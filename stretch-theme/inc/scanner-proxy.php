<?php
/**
 * AEO Scanner same-origin fetch proxy (AUD-008).
 *
 * Registers GET /wp-json/stretch/v1/fetch-page?url=... so the client-side
 * scanner can analyze third-party pages without shipping visitor URLs to
 * free CORS proxy operators. The fetch happens server-side via
 * wp_remote_get with SSRF protection (public hosts only — hostname AND
 * resolved IPs are checked) and a per-IP rate limit.
 *
 * Response JSON: { ok: bool, status: int, html: string|null }
 * `html` is populated only when the upstream content-type is HTML.
 * Errors add an `error` code. Always sent with Cache-Control: no-store.
 */

if (!defined('ABSPATH')) {
    exit;
}

/** Max upstream response size (bytes) — ~2.5 MB. */
define('STRETCH_SCANNER_PROXY_MAX_BYTES', 2621440);

/** Requests allowed per IP per minute. */
define('STRETCH_SCANNER_PROXY_RATE_LIMIT', 10);

/**
 * Register the REST route.
 */
function stretch_scanner_proxy_register_routes() {
    register_rest_route('stretch/v1', '/fetch-page', [
        'methods'             => WP_REST_Server::READABLE,
        'callback'            => 'stretch_scanner_proxy_fetch_page',
        'permission_callback' => '__return_true', // Public tool; abuse is limited by validation + rate limit below.
        'args'                => [
            'url' => [
                'required'          => true,
                'type'              => 'string',
                'description'       => 'Public http(s) URL of the page to fetch for AEO analysis.',
                'sanitize_callback' => null, // Validated strictly in the callback; do not mangle first.
            ],
        ],
    ]);
}
add_action('rest_api_init', 'stretch_scanner_proxy_register_routes');

/**
 * True when an IP address is NOT publicly routable (loopback, RFC1918,
 * link-local, CGNAT, IPv6 unique-local/link-local, etc.).
 *
 * @param string $ip IPv4 or IPv6 address.
 * @return bool
 */
function stretch_scanner_proxy_ip_is_private($ip) {
    // filter_var flags reject: 10/8, 172.16/12, 192.168/16 (private) and
    // 0/8, 127/8, 169.254/16, 240/4, ::1, ::, ::ffff:0:0/96, fe80::/10 (reserved),
    // plus fc00::/7 for IPv6 private.
    if (false === filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
        return true;
    }
    // Extra IPv4 ranges the filter flags miss.
    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
        $long = ip2long($ip);
        $extra_blocks = [
            ['100.64.0.0', 10],  // CGNAT (RFC 6598)
            ['192.0.0.0', 24],   // IETF protocol assignments
            ['198.18.0.0', 15],  // Benchmarking
            ['224.0.0.0', 4],    // Multicast
        ];
        foreach ($extra_blocks as $block) {
            $net  = ip2long($block[0]);
            $mask = -1 << (32 - $block[1]);
            if (($long & $mask) === ($net & $mask)) {
                return true;
            }
        }
    }
    return false;
}

/**
 * Validate a user-supplied URL for server-side fetching (SSRF guard).
 *
 * @param string $url Raw URL.
 * @return true|array True when safe, or [error_code, human_message] when rejected.
 */
function stretch_scanner_proxy_validate_url($url) {
    if (!is_string($url) || '' === trim($url)) {
        return ['missing_url', 'A url parameter is required.'];
    }
    if (strlen($url) >= 2048) {
        return ['url_too_long', 'URL must be shorter than 2048 characters.'];
    }

    $parts = wp_parse_url($url);
    if (false === $parts || empty($parts['host'])) {
        return ['invalid_url', 'Could not parse that URL.'];
    }
    $scheme = isset($parts['scheme']) ? strtolower($parts['scheme']) : '';
    if (!in_array($scheme, ['http', 'https'], true)) {
        return ['invalid_scheme', 'Only http:// and https:// URLs can be scanned.'];
    }
    if (isset($parts['user']) || isset($parts['pass'])) {
        return ['credentials_in_url', 'URLs with embedded credentials are not allowed.'];
    }

    $host = strtolower(rtrim($parts['host'], '.'));

    // Reject obvious non-public hostnames before touching DNS.
    if ('localhost' === $host || str_ends_with($host, '.localhost')
        || str_ends_with($host, '.local') || str_ends_with($host, '.internal')
        || str_ends_with($host, '.home.arpa')) {
        return ['private_host', 'Local and internal hostnames cannot be scanned.'];
    }

    // Build the list of IPs this host points at.
    $ips = [];
    $literal = trim($host, '[]'); // IPv6 literals arrive bracketed.
    if (filter_var($literal, FILTER_VALIDATE_IP)) {
        $ips[] = $literal;
    } else {
        $v4 = gethostbynamel($host);
        if (is_array($v4)) {
            $ips = array_merge($ips, $v4);
        }
        $aaaa = @dns_get_record($host, DNS_AAAA);
        if (is_array($aaaa)) {
            foreach ($aaaa as $record) {
                if (!empty($record['ipv6'])) {
                    $ips[] = $record['ipv6'];
                }
            }
        }
        if (empty($ips)) {
            return ['unresolvable_host', 'That hostname could not be resolved.'];
        }
    }

    // Every resolved address must be publicly routable.
    foreach ($ips as $ip) {
        if (stretch_scanner_proxy_ip_is_private($ip)) {
            return ['private_address', 'That host resolves to a private or internal address and cannot be scanned.'];
        }
    }

    return true;
}

/**
 * Per-IP sliding rate limit via a transient counter.
 *
 * @return bool True when the caller is over the limit.
 */
function stretch_scanner_proxy_is_rate_limited() {
    $ip = isset($_SERVER['REMOTE_ADDR']) ? (string) $_SERVER['REMOTE_ADDR'] : 'unknown';
    $key = 'stretch_scanfetch_' . md5($ip);
    $count = (int) get_transient($key);
    if ($count >= STRETCH_SCANNER_PROXY_RATE_LIMIT) {
        return true;
    }
    set_transient($key, $count + 1, MINUTE_IN_SECONDS);
    return false;
}

/**
 * Build a JSON response with no-store caching.
 *
 * @param array $data        Response body.
 * @param int   $http_status HTTP status for OUR endpoint (not upstream).
 * @return WP_REST_Response
 */
function stretch_scanner_proxy_respond($data, $http_status = 200) {
    $response = new WP_REST_Response($data, $http_status);
    $response->header('Cache-Control', 'no-store');
    $response->header('X-Content-Type-Options', 'nosniff');
    return $response;
}

/**
 * Route callback: fetch a public page server-side and hand its HTML to the scanner.
 *
 * @param WP_REST_Request $request Request with `url` param.
 * @return WP_REST_Response
 */
function stretch_scanner_proxy_fetch_page(WP_REST_Request $request) {
    if (stretch_scanner_proxy_is_rate_limited()) {
        return stretch_scanner_proxy_respond([
            'ok'      => false,
            'status'  => 0,
            'html'    => null,
            'error'   => 'rate_limited',
            'message' => 'Too many scans from this address. Please wait a minute and try again.',
        ], 429);
    }

    $url = (string) $request->get_param('url');
    $valid = stretch_scanner_proxy_validate_url($url);
    if (true !== $valid) {
        return stretch_scanner_proxy_respond([
            'ok'      => false,
            'status'  => 0,
            'html'    => null,
            'error'   => $valid[0],
            'message' => $valid[1],
        ], 400);
    }

    $result = wp_remote_get($url, [
        'timeout'             => 12,
        'redirection'         => 3,
        'user-agent'          => 'StretchCreative-AEO-Scanner/1.0 (+' . home_url('/blog/aeo/') . '; on-demand scan requested by a site visitor)',
        'limit_response_size' => STRETCH_SCANNER_PROXY_MAX_BYTES,
        // Core re-validates every redirect hop against wp_http_validate_url()
        // (blocks localhost/private IPv4 targets) — defense in depth on top of
        // the resolver checks above.
        'reject_unsafe_urls'  => true,
    ]);

    if (is_wp_error($result)) {
        return stretch_scanner_proxy_respond([
            'ok'      => false,
            'status'  => 0,
            'html'    => null,
            'error'   => 'fetch_failed',
            'message' => 'The page could not be fetched (it may be down, blocking automated requests, or too slow to respond).',
        ]);
    }

    $status = (int) wp_remote_retrieve_response_code($result);
    if ($status >= 400 || 0 === $status) {
        return stretch_scanner_proxy_respond([
            'ok'     => false,
            'status' => $status,
            'html'   => null,
            'error'  => 'upstream_http_error',
        ]);
    }

    $content_type = wp_remote_retrieve_header($result, 'content-type');
    if (is_array($content_type)) {
        $content_type = (string) end($content_type);
    }
    $content_type = strtolower((string) $content_type);
    $is_html = (false !== strpos($content_type, 'text/html')) || (false !== strpos($content_type, 'application/xhtml+xml'));

    $html = null;
    if ($is_html) {
        // Client parses this with DOMParser (inert — scripts never execute),
        // so the markup is passed through untouched for accurate analysis.
        $html = wp_remote_retrieve_body($result);
    }

    return stretch_scanner_proxy_respond([
        'ok'     => true,
        'status' => $status,
        'html'   => $html,
    ]);
}
