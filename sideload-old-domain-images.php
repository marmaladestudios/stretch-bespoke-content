<?php
/**
 * AUD-004: Migrate media hotlinked from the old production domain
 * (stretchcreative.co/wp-content/uploads/...) into the local media library
 * and rewrite published post content to point at the local copies.
 *
 * Idempotent:
 *   - Attachments are reused when one with the same source filename already
 *     exists (`_wp_attached_file` LIKE basename) or when tagged with the
 *     `_aud004_source_url` meta written by this script.
 *   - Once a post's content is rewritten it no longer matches the scan,
 *     so a second run performs no downloads and no DB writes.
 *
 * Handles:
 *   - img src / srcset entries / href links, in plain HTML and inside
 *     JSON-escaped blobs (http:\/\/... — e.g. SiteOrigin panels caches);
 *     http/https and www/non-www variants are canonicalized.
 *   - -WxH size-variant URLs: the base (original) file is downloaded once;
 *     each variant is mapped to the matching generated intermediate size,
 *     falling back to the full-size URL.
 *   - 404s on the old host: falls back to the Wayback Machine raw-content
 *     pattern (https://web.archive.org/web/2im_/<url>). If that also fails
 *     the URL is left untouched in post content and reported.
 *   - Featured images: posts whose _thumbnail_id is missing or points at a
 *     nonexistent attachment get the post's first migrated inline image.
 *
 * Run:
 *   docker compose cp sideload-old-domain-images.php wordpress:/var/www/html/
 *   docker compose exec -T wordpress wp eval-file /var/www/html/sideload-old-domain-images.php --allow-root
 */

if (!defined('WP_CLI') || !WP_CLI) exit;

require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

wp_set_current_user(1);

global $wpdb;

const AUD004_SOURCE_META = '_aud004_source_url';
const AUD004_THROTTLE_US = 500000; // 0.5s between remote downloads

$media_ext = 'jpe?g|png|gif|webp|svg|mp4|mov|m4v|webm';
// Plain URLs: https://stretchcreative.co/wp-content/uploads/....ext
$plain_re = '#https?://(?:www\.)?stretchcreative\.co/wp-content/uploads/[^\s"\'<>\\\\]+\.(?:' . $media_ext . ')#i';
// JSON-escaped URLs: http:\/\/stretchcreative.co\/wp-content\/uploads\/....ext
$escaped_re = '#https?:\\\\/\\\\/(?:www\.)?stretchcreative\.co\\\\/wp-content\\\\/uploads\\\\/(?:[^\s"\'<>&\\\\]|\\\\/)+\.(?:' . $media_ext . ')#i';

/** Canonical form used for grouping + downloading: https, no www, real slashes. */
function aud004_canonicalize($raw) {
    $u = str_replace('\/', '/', $raw);
    $u = preg_replace('#^http://#i', 'https://', $u);
    $u = preg_replace('#^https://www\.#i', 'https://', $u);
    return $u;
}

/** Strip a trailing -WxH size suffix to get the original ("base") file URL. */
function aud004_base_url($url) {
    return preg_replace('#-\d+x\d+(\.[a-z0-9]+)$#i', '$1', $url);
}

/** Find an existing attachment whose _wp_attached_file ends with $basename. */
function aud004_find_by_basename($basename) {
    global $wpdb;
    $names = array_unique([$basename, sanitize_file_name($basename)]);
    foreach ($names as $name) {
        $id = $wpdb->get_var($wpdb->prepare(
            "SELECT pm.post_id FROM {$wpdb->postmeta} pm
             INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id AND p.post_type = 'attachment'
             WHERE pm.meta_key = '_wp_attached_file' AND pm.meta_value LIKE %s
             ORDER BY pm.post_id ASC LIMIT 1",
            '%' . $wpdb->esc_like($name)
        ));
        if ($id) return (int) $id;
    }
    return 0;
}

/** Find an attachment previously created by this script for $source_url. */
function aud004_find_by_source($source_url) {
    global $wpdb;
    $id = $wpdb->get_var($wpdb->prepare(
        "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = %s AND meta_value = %s LIMIT 1",
        AUD004_SOURCE_META, $source_url
    ));
    return $id ? (int) $id : 0;
}

/** Sanity-check a downloaded temp file so we never sideload an HTML error page. */
function aud004_valid_download($tmp, $filename) {
    if (!is_string($tmp) || !file_exists($tmp) || filesize($tmp) < 50) return false;
    $ext  = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $head = strtolower((string) file_get_contents($tmp, false, null, 0, 512));
    if (strpos($head, '<html') !== false || strpos($head, '<!doctype html') !== false) return false;
    if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true)) {
        return @getimagesize($tmp) !== false;
    }
    if ($ext === 'svg') {
        return strpos($head, '<svg') !== false || strpos($head, '<?xml') !== false;
    }
    return true; // video: size + not-HTML checks above
}

/** Download one candidate URL (throttled) and sideload it as $filename. */
function aud004_download_and_sideload($candidate_url, $filename, $parent_post_id, $label) {
    $tmp = download_url($candidate_url, 30);
    usleep(AUD004_THROTTLE_US); // be polite to the remote host
    if (is_wp_error($tmp)) {
        WP_CLI::log("    {$label} download failed: " . $tmp->get_error_message());
        return 0;
    }
    if (!aud004_valid_download($tmp, $filename)) {
        WP_CLI::log("    {$label} returned invalid/HTML payload, discarding");
        @unlink($tmp);
        return 0;
    }
    $attach_id = media_handle_sideload(['name' => $filename, 'tmp_name' => $tmp], $parent_post_id);
    if (is_wp_error($attach_id)) {
        WP_CLI::log("    {$label} sideload failed: " . $attach_id->get_error_message());
        return 0; // media_handle_sideload unlinks the temp file on failure
    }
    return (int) $attach_id;
}

/* -------------------------------------------------------------------------
 * 1. Scan published posts for old-domain media URLs
 * ---------------------------------------------------------------------- */

$post_ids = $wpdb->get_col(
    "SELECT ID FROM {$wpdb->posts}
     WHERE post_status = 'publish' AND post_content LIKE '%stretchcreative.co%'
     ORDER BY ID ASC"
);

$occurrences = []; // post_id => [ ['raw' =>, 'canon' =>, 'escaped' =>, 'pos' =>], ... ]
$groups      = []; // base_url => ['urls' => [canon => true], 'first_post' => id]

foreach ($post_ids as $pid) {
    $content = get_post_field('post_content', $pid, 'raw');
    $found   = [];
    foreach ([$plain_re => false, $escaped_re => true] as $re => $is_escaped) {
        if (!preg_match_all($re, $content, $m, PREG_OFFSET_CAPTURE)) continue;
        $seen = [];
        foreach ($m[0] as $hit) {
            [$raw, $pos] = $hit;
            if (isset($seen[$raw])) continue; // one entry per distinct raw string per post
            $seen[$raw] = true;
            $found[] = ['raw' => $raw, 'canon' => aud004_canonicalize($raw), 'escaped' => $is_escaped, 'pos' => $pos];
        }
    }
    if (!$found) continue;
    $occurrences[$pid] = $found;
    foreach ($found as $occ) {
        $base = aud004_base_url($occ['canon']);
        if (!isset($groups[$base])) $groups[$base] = ['urls' => [], 'first_post' => (int) $pid];
        $groups[$base]['urls'][$occ['canon']] = true;
    }
}

$distinct_urls = [];
foreach ($groups as $g) $distinct_urls = array_merge($distinct_urls, array_keys($g['urls']));
$distinct_urls = array_unique($distinct_urls);

WP_CLI::log('Posts referencing old-domain media: ' . count($occurrences)
    . ' | distinct URLs: ' . count($distinct_urls)
    . ' | distinct source files: ' . count($groups));

$stats = [
    'sideloaded' => 0, 'reused' => 0, 'unrecoverable' => [],
    'posts_rewritten' => 0, 'replacements' => 0, 'thumbnails_set' => 0,
];

if (!$occurrences) {
    WP_CLI::success('No old-domain media URLs in published post content — nothing to do (no-op).');
    return;
}

/* -------------------------------------------------------------------------
 * 2. Resolve each source file to a local attachment (reuse > old host > Wayback)
 * ---------------------------------------------------------------------- */

$n = 0;
foreach ($groups as $base => &$group) {
    $n++;
    $base_name = basename(parse_url($base, PHP_URL_PATH));
    WP_CLI::log("[{$n}/" . count($groups) . "] {$base_name}");

    $group['attachment_id'] = 0;
    $group['file_is_base']  = true;

    // (a) previously migrated by this script
    if ($id = aud004_find_by_source($base)) {
        WP_CLI::log("    reusing attachment #{$id} (source-url meta)");
        $group['attachment_id'] = $id;
        $stats['reused']++;
        continue;
    }
    // (b) same source filename already in the library
    if ($id = aud004_find_by_basename($base_name)) {
        WP_CLI::log("    reusing attachment #{$id} (_wp_attached_file matches basename)");
        update_post_meta($id, AUD004_SOURCE_META, $base);
        $group['attachment_id'] = $id;
        $stats['reused']++;
        continue;
    }

    // (c) download: original file first, then referenced -WxH variants, then Wayback
    $variants   = array_values(array_diff(array_keys($group['urls']), [$base]));
    $candidates = [['url' => $base, 'name' => $base_name, 'is_base' => true, 'label' => 'old host (original)']];
    foreach ($variants as $v) {
        $candidates[] = ['url' => $v, 'name' => basename(parse_url($v, PHP_URL_PATH)), 'is_base' => false, 'label' => 'old host (size variant)'];
    }
    $candidates[] = ['url' => 'https://web.archive.org/web/2im_/' . $base, 'name' => $base_name, 'is_base' => true, 'label' => 'Wayback (original)'];
    foreach ($variants as $v) {
        $candidates[] = ['url' => 'https://web.archive.org/web/2im_/' . $v, 'name' => basename(parse_url($v, PHP_URL_PATH)), 'is_base' => false, 'label' => 'Wayback (size variant)'];
    }

    foreach ($candidates as $c) {
        $id = aud004_download_and_sideload($c['url'], $c['name'], $group['first_post'], $c['label']);
        if ($id) {
            update_post_meta($id, AUD004_SOURCE_META, $base);
            $group['attachment_id'] = $id;
            $group['file_is_base']  = $c['is_base'];
            $stats['sideloaded']++;
            WP_CLI::log("    OK -> attachment #{$id} via {$c['label']}");
            break;
        }
    }

    if (!$group['attachment_id']) {
        WP_CLI::warning("    UNRECOVERABLE — leaving post content unchanged for: {$base}");
        $stats['unrecoverable'] = array_merge($stats['unrecoverable'], array_keys($group['urls']));
    }
}
unset($group);

/* -------------------------------------------------------------------------
 * 3. Build old-URL -> new-URL map
 * ---------------------------------------------------------------------- */

$url_map = []; // canonical old url => new local url
foreach ($groups as $base => $group) {
    if (!$group['attachment_id']) continue;
    $full = wp_get_attachment_url($group['attachment_id']);
    if (!$full) continue;

    foreach (array_keys($group['urls']) as $old) {
        $new = $full;
        if ($old !== $base && $group['file_is_base']
            && preg_match('#-(\d+)x(\d+)\.[a-z0-9]+$#i', $old, $m)) {
            // map -WxH variant to the matching generated intermediate size
            $meta = wp_get_attachment_metadata($group['attachment_id']);
            if (!empty($meta['sizes'])) {
                foreach ($meta['sizes'] as $size) {
                    if ((int) $size['width'] === (int) $m[1] && (int) $size['height'] === (int) $m[2]) {
                        $new = dirname($full) . '/' . $size['file'];
                        break;
                    }
                }
            }
        }
        $url_map[$old] = $new;
    }
}

/* -------------------------------------------------------------------------
 * 4. Rewrite post content
 * ---------------------------------------------------------------------- */

foreach ($occurrences as $pid => $occs) {
    $post    = get_post($pid);
    $content = $post->post_content;

    // Longest raw strings first so a base URL never clobbers part of a variant URL.
    usort($occs, fn($a, $b) => strlen($b['raw']) - strlen($a['raw']));

    $count = 0;
    foreach ($occs as $occ) {
        if (!isset($url_map[$occ['canon']])) continue; // unrecoverable: leave as-is
        $replacement = $occ['escaped'] ? str_replace('/', '\/', $url_map[$occ['canon']]) : $url_map[$occ['canon']];
        $content     = str_replace($occ['raw'], $replacement, $content, $hits);
        $count      += $hits;
    }

    if ($content !== $post->post_content) {
        // wp_update_post() unslashes: wp_slash() protects literal backslashes (JSON-escaped blobs).
        $res = wp_update_post(['ID' => $pid, 'post_content' => wp_slash($content)], true);
        if (is_wp_error($res)) {
            WP_CLI::warning("[{$pid}] update failed: " . $res->get_error_message());
            continue;
        }
        $stats['posts_rewritten']++;
        $stats['replacements'] += $count;
        WP_CLI::log("[{$pid}] rewrote {$count} URL occurrence(s): {$post->post_title}");
    }

    /* Featured image: set one if missing/dangling and the post has a migrated inline image */
    $thumb_id = (int) get_post_meta($pid, '_thumbnail_id', true);
    $valid    = $thumb_id && ($t = get_post($thumb_id)) && $t->post_type === 'attachment';
    if (!$valid) {
        $video_ext = ['mp4', 'mov', 'm4v', 'webm'];
        usort($occs, fn($a, $b) => $a['pos'] - $b['pos']); // document order: first image = hero
        foreach ($occs as $occ) {
            $ext = strtolower(pathinfo(parse_url($occ['canon'], PHP_URL_PATH), PATHINFO_EXTENSION));
            if (in_array($ext, $video_ext, true)) continue;
            $base = aud004_base_url($occ['canon']);
            if (!empty($groups[$base]['attachment_id'])) {
                set_post_thumbnail($pid, $groups[$base]['attachment_id']);
                $stats['thumbnails_set']++;
                WP_CLI::log("[{$pid}] set missing featured image -> attachment #{$groups[$base]['attachment_id']}");
                break;
            }
        }
    }
}

/* -------------------------------------------------------------------------
 * 5. Summary + audit re-check
 * ---------------------------------------------------------------------- */

$remaining = (int) $wpdb->get_var(
    "SELECT COUNT(*) FROM {$wpdb->posts}
     WHERE post_status = 'publish' AND post_content LIKE '%stretchcreative.co/wp-content%'"
);

WP_CLI::log("\n=== AUD-004 SUMMARY ===");
WP_CLI::log('Distinct old URLs found:      ' . count($distinct_urls));
WP_CLI::log('Distinct source files:        ' . count($groups));
WP_CLI::log("Attachments sideloaded:       {$stats['sideloaded']}");
WP_CLI::log("Attachments reused:           {$stats['reused']}");
WP_CLI::log("Posts rewritten:              {$stats['posts_rewritten']} ({$stats['replacements']} URL occurrences)");
WP_CLI::log("Featured images set:          {$stats['thumbnails_set']}");
WP_CLI::log('Unrecoverable URLs:           ' . count($stats['unrecoverable']));
foreach ($stats['unrecoverable'] as $u) WP_CLI::log("  - {$u}");
WP_CLI::log("Audit LIKE query rows left:   {$remaining}");
WP_CLI::success('AUD-004 old-domain media migration pass complete.');
