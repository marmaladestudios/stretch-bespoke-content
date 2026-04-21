<?php
/**
 * Sideload images from stretchcreative.co into local media library.
 * Run via: docker compose exec wordpress wp eval-file /tmp/sideload-blog-images.php --allow-root
 */

if (!defined('ABSPATH')) {
    WP_CLI::error('Run via wp eval-file');
}

require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

wp_set_current_user(1);

$imported_posts = get_posts([
    'post_type'      => 'post',
    'post_status'    => ['publish', 'draft', 'private'],
    'posts_per_page' => -1,
    'meta_query'     => [
        [
            'key'     => '_oxygen_lock_post_edit_mode',
            'compare' => 'EXISTS',
        ],
    ],
]);

WP_CLI::log("Found " . count($imported_posts) . " imported posts to process");

$url_map = [];
$stats = ['posts_updated' => 0, 'inline_imgs' => 0, 'featured_imgs' => 0, 'failures' => 0];

foreach ($imported_posts as $post) {
    WP_CLI::log("\n[{$post->ID}] {$post->post_title}");
    $content = $post->post_content;
    $changed = false;

    // 1. Inline images
    if (preg_match_all('#https?://(?:www\.)?stretchcreative\.co/wp-content/uploads/[^\s"\'\)<>]+\.(?:jpg|jpeg|png|gif|webp|svg)#i', $content, $matches)) {
        $unique_urls = array_unique($matches[0]);
        foreach ($unique_urls as $url) {
            if (isset($url_map[$url])) {
                $new_url = wp_get_attachment_url($url_map[$url]);
                if ($new_url) {
                    $content = str_replace($url, $new_url, $content);
                    $changed = true;
                }
                continue;
            }

            $attach_id = media_sideload_image($url, $post->ID, null, 'id');
            if (is_wp_error($attach_id)) {
                WP_CLI::warning("  inline FAIL {$url}: " . $attach_id->get_error_message());
                $stats['failures']++;
                continue;
            }

            $url_map[$url] = $attach_id;
            $new_url = wp_get_attachment_url($attach_id);
            $content = str_replace($url, $new_url, $content);
            $changed = true;
            $stats['inline_imgs']++;
            WP_CLI::log("  inline OK   #{$attach_id}");
        }
    }

    if ($changed) {
        wp_update_post(['ID' => $post->ID, 'post_content' => $content]);
        $stats['posts_updated']++;
    }

    // 2. Featured image — fetch from old site REST API
    $thumb_id = get_post_meta($post->ID, '_thumbnail_id', true);
    if ($thumb_id && !get_post($thumb_id)) {
        $api_url = "https://stretchcreative.co/wp-json/wp/v2/posts?slug=" . urlencode($post->post_name) . "&_embed=true";
        $resp = wp_remote_get($api_url, ['timeout' => 30]);
        if (is_wp_error($resp)) {
            WP_CLI::warning("  REST FAIL: " . $resp->get_error_message());
            continue;
        }
        $body = json_decode(wp_remote_retrieve_body($resp), true);
        if (!empty($body[0]['_embedded']['wp:featuredmedia'][0]['source_url'])) {
            $featured_url = $body[0]['_embedded']['wp:featuredmedia'][0]['source_url'];
            if (isset($url_map[$featured_url])) {
                $new_thumb_id = $url_map[$featured_url];
            } else {
                $new_thumb_id = media_sideload_image($featured_url, $post->ID, null, 'id');
                if (is_wp_error($new_thumb_id)) {
                    WP_CLI::warning("  featured FAIL: " . $new_thumb_id->get_error_message());
                    $stats['failures']++;
                    continue;
                }
                $url_map[$featured_url] = $new_thumb_id;
            }
            update_post_meta($post->ID, '_thumbnail_id', $new_thumb_id);
            $stats['featured_imgs']++;
            WP_CLI::log("  featured OK #{$new_thumb_id}");
        } else {
            WP_CLI::warning("  no featured image at REST for slug={$post->post_name}");
        }
    }
}

WP_CLI::log("\n=== SUMMARY ===");
WP_CLI::log("Posts updated:    {$stats['posts_updated']}");
WP_CLI::log("Inline images:    {$stats['inline_imgs']}");
WP_CLI::log("Featured images:  {$stats['featured_imgs']}");
WP_CLI::log("Failures:         {$stats['failures']}");
WP_CLI::success("Image sideload complete");
