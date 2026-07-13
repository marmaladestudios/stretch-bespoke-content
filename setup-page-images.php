<?php
if (!defined('WP_CLI') || !WP_CLI) exit;
/**
 * AUD-014 — Sideload the hotlinked Unsplash images used by the live
 * Home (Who We Serve) and About (story) templates into the media library,
 * then record the attachment IDs in the `stretch_page_images` option.
 *
 * Run via WP-CLI only:
 *   wp eval-file setup-page-images.php
 *
 * Idempotent: attachments are deduped by a `_stretch_source_url` meta key,
 * so re-running never creates duplicates — it just refreshes the option.
 *
 * Templates (page-home.php / page-about.php) read the option and render via
 * wp_get_attachment_image(); they fall back to the original Unsplash URL when
 * a key is missing, so running this script is safe at any point.
 */

require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

/**
 * The 5 live hotlinked images (page-home.php Who We Serve ×4, page-about.php story ×1).
 * Keys are the option keys the templates read.
 */
$stretch_page_image_sources = [
    'home_ecommerce' => [
        'url'   => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=600&h=400&fit=crop',
        'title' => 'home-who-we-serve-ecommerce',
        'alt'   => 'Ecommerce',
    ],
    'home_agencies' => [
        'url'   => 'https://images.unsplash.com/photo-1600880292203-757bb62b4baf?w=600&h=400&fit=crop',
        'title' => 'home-who-we-serve-agencies',
        'alt'   => 'Agencies and strategic partners',
    ],
    'home_service_providers' => [
        'url'   => 'https://images.unsplash.com/photo-1521791136064-7986c2920216?w=600&h=400&fit=crop',
        'title' => 'home-who-we-serve-local-service-providers',
        'alt'   => 'Local service providers',
    ],
    'home_saas' => [
        'url'   => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=600&h=400&fit=crop',
        'title' => 'home-who-we-serve-saas',
        'alt'   => 'SaaS and digital platforms',
    ],
    'about_team' => [
        'url'   => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&h=600&fit=crop',
        'title' => 'about-story-team-collaboration',
        'alt'   => 'Team collaboration at Stretch Creative',
    ],
];

/**
 * Find an attachment previously sideloaded from $url (deduped via meta),
 * or sideload it now. Returns attachment ID or 0 on failure.
 */
function stretch_page_image_sideload($url, $title, $alt, $bundle_key = '') {
    // Dedupe: was this exact source URL already imported by this script?
    $existing = get_posts([
        'post_type'   => 'attachment',
        'post_status' => 'any',
        'numberposts' => 1,
        'fields'      => 'ids',
        'meta_key'    => '_stretch_source_url',
        'meta_value'  => $url,
    ]);
    if (!empty($existing)) {
        $id = (int) $existing[0];
        WP_CLI::log("  ✓ Already imported '{$title}' (attachment {$id}) — skipping download");
        return $id;
    }

    $tmp = null;

    // Prefer the repo-bundled file (Unsplash is unreachable from Render egress).
    if (!empty($bundle_key)) {
        $bundle_dirs = ['/opt/page-images', dirname(ABSPATH) . '/page-images'];
        foreach ($bundle_dirs as $dir) {
            foreach (['jpg', 'jpeg', 'png', 'webp'] as $try_ext) {
                $local = $dir . '/' . $bundle_key . '.' . $try_ext;
                if (file_exists($local)) {
                    $tmp_copy = wp_tempnam($bundle_key . '.' . $try_ext);
                    if ($tmp_copy && copy($local, $tmp_copy)) {
                        WP_CLI::log("  ✓ Using bundled file for '{$bundle_key}' ({$local})");
                        $tmp = $tmp_copy;
                        break 2;
                    }
                }
            }
        }
    }

    if (empty($tmp)) {
        $tmp = download_url($url, 60);
        if (is_wp_error($tmp)) {
            // One retry — the first production run failed on transient network
            // contention during a crash-loop window and never got another chance.
            WP_CLI::log("  … download failed ({$tmp->get_error_message()}), retrying once");
            sleep(2);
            $tmp = download_url($url, 60);
        }
        if (is_wp_error($tmp)) {
            WP_CLI::warning("Failed to download {$url}: " . $tmp->get_error_message());
            return 0;
        }
    }

    // Unsplash URLs carry no file extension — derive one from the real mime type.
    $mime_map = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
        'image/gif'  => 'gif',
        'image/avif' => 'avif',
    ];
    $mime = function_exists('wp_get_image_mime') ? wp_get_image_mime($tmp) : false;
    $ext  = ($mime && isset($mime_map[$mime])) ? $mime_map[$mime] : 'jpg';

    $file_array = [
        'name'     => sanitize_title($title) . '.' . $ext,
        'tmp_name' => $tmp,
    ];

    $attachment_id = media_handle_sideload($file_array, 0, $title);
    if (is_wp_error($attachment_id)) {
        @unlink($tmp);
        WP_CLI::warning("Failed to sideload '{$title}': " . $attachment_id->get_error_message());
        return 0;
    }

    update_post_meta($attachment_id, '_stretch_source_url', $url);
    update_post_meta($attachment_id, '_wp_attachment_image_alt', $alt);

    WP_CLI::log("  + Imported '{$title}' (attachment {$attachment_id})");
    return (int) $attachment_id;
}

WP_CLI::log('=== AUD-014: Sideloading page images (Home Who-We-Serve ×4, About story ×1) ===');

$option  = get_option('stretch_page_images', []);
$option  = is_array($option) ? $option : [];
$before  = $option;
$failed  = 0;

foreach ($stretch_page_image_sources as $key => $src) {
    // If the option already points at a real image attachment, keep it.
    $current = isset($option[$key]) ? (int) $option[$key] : 0;
    if ($current && wp_attachment_is_image($current)) {
        WP_CLI::log("  ✓ '{$key}' already set (attachment {$current}) — no-op");
        continue;
    }

    $id = stretch_page_image_sideload($src['url'], $src['title'], $src['alt'], $key);
    if ($id) {
        $option[$key] = $id;
    } else {
        $failed++;
    }
}

if ($option !== $before) {
    update_option('stretch_page_images', $option, true);
    WP_CLI::log('Updated option stretch_page_images: ' . wp_json_encode($option));
} else {
    WP_CLI::log('Option stretch_page_images unchanged: ' . wp_json_encode($option));
}

if ($failed) {
    // Exit non-zero so the deploy seed gate does NOT record this run as complete
    // and retries on the next boot (all seeds are idempotent no-ops once done).
    // A plain warning here previously let a transient failure seal the gate with
    // Unsplash fallbacks still live on the homepage.
    WP_CLI::error("{$failed} image(s) could not be imported — templates keep their Unsplash fallback; seed will retry next boot.");
} else {
    WP_CLI::success('All page images are local attachments.');
}
