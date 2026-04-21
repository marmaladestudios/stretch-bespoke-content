<?php
/**
 * Recover broken stretchcreative.co image URLs via the Wayback Machine.
 * For each remaining broken URL in post content, query archive.org's
 * availability API; if a snapshot exists, download the raw file and
 * sideload into the media library; replace URL in post content.
 */

if (!defined('ABSPATH')) { WP_CLI::error('Run via wp eval-file'); }

require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

wp_set_current_user(1);

$posts = get_posts([
    'post_type'      => 'post',
    'post_status'    => ['publish', 'draft', 'private'],
    'posts_per_page' => -1,
]);

$url_map = [];
$stats   = ['recovered' => 0, 'no_snapshot' => 0, 'download_fail' => 0, 'posts_updated' => 0];

foreach ($posts as $post) {
    if (!preg_match_all('#https?://(?:www\.)?stretchcreative\.co/wp-content/uploads/[^\s"\'\)<>]+\.(?:jpg|jpeg|png|gif|webp|svg)#i', $post->post_content, $m)) {
        continue;
    }

    $content = $post->post_content;
    $changed = false;
    $unique  = array_unique($m[0]);

    WP_CLI::log("\n[{$post->ID}] {$post->post_title} — " . count($unique) . " broken");

    foreach ($unique as $broken_url) {
        if (isset($url_map[$broken_url])) {
            $new_url = wp_get_attachment_url($url_map[$broken_url]);
            if ($new_url) {
                $content = str_replace($broken_url, $new_url, $content);
                $changed = true;
            }
            continue;
        }

        // Query Wayback availability
        $api = 'https://archive.org/wayback/available?url=' . urlencode($broken_url);
        $resp = wp_remote_get($api, ['timeout' => 30]);
        if (is_wp_error($resp)) {
            WP_CLI::warning("  API FAIL {$broken_url}: " . $resp->get_error_message());
            $stats['download_fail']++;
            continue;
        }
        $body = json_decode(wp_remote_retrieve_body($resp), true);
        $snap = $body['archived_snapshots']['closest'] ?? null;

        if (empty($snap) || empty($snap['available']) || empty($snap['url'])) {
            WP_CLI::log("  no snapshot for " . basename($broken_url));
            $stats['no_snapshot']++;
            continue;
        }

        // Convert /web/TIMESTAMP/URL -> /web/TIMESTAMPid_/URL for raw content
        $wayback_url = preg_replace('#/web/(\d+)/#', '/web/$1id_/', $snap['url']);

        // Sideload
        $attach_id = media_sideload_image($wayback_url, $post->ID, null, 'id');
        if (is_wp_error($attach_id)) {
            WP_CLI::warning("  sideload FAIL {$broken_url}: " . $attach_id->get_error_message());
            $stats['download_fail']++;
            continue;
        }

        // media_sideload_image stores filename from the Wayback URL —
        // rename the attachment's title/slug to something sensible.
        $clean_title = sanitize_title(pathinfo(parse_url($broken_url, PHP_URL_PATH), PATHINFO_FILENAME));
        wp_update_post([
            'ID'         => $attach_id,
            'post_title' => $clean_title,
            'post_name'  => $clean_title,
        ]);

        $url_map[$broken_url] = $attach_id;
        $new_url = wp_get_attachment_url($attach_id);
        $content = str_replace($broken_url, $new_url, $content);
        $changed = true;
        $stats['recovered']++;
        WP_CLI::log("  recovered -> #{$attach_id}");
        usleep(500000); // 0.5s between Wayback calls to be polite
    }

    if ($changed) {
        wp_update_post(['ID' => $post->ID, 'post_content' => $content]);
        $stats['posts_updated']++;
    }
}

WP_CLI::log("\n=== WAYBACK SUMMARY ===");
WP_CLI::log("Recovered:        {$stats['recovered']}");
WP_CLI::log("No snapshot:      {$stats['no_snapshot']}");
WP_CLI::log("Download failed:  {$stats['download_fail']}");
WP_CLI::log("Posts updated:    {$stats['posts_updated']}");
WP_CLI::success("Done");
