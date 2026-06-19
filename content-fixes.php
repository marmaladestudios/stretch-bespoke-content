<?php
/**
 * Idempotent content fixes for issues #11-#16 from the project tracker.
 * Safe to run multiple times — each fix checks current state before acting.
 *
 * Run: docker compose exec wordpress wp eval-file /var/www/html/content-fixes.php --allow-root
 */

if (!defined('ABSPATH')) {
    WP_CLI::error('This script must be run via wp eval-file.');
}

require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

// --------------------------------------------------------------------
// Helper: sideload an image and return attachment ID. Caches by slug.
// --------------------------------------------------------------------
function cf_sideload_image($url, $slug) {
    $existing = get_posts(['post_type' => 'attachment', 'name' => $slug, 'numberposts' => 1, 'post_status' => 'inherit']);
    if ($existing) return $existing[0]->ID;

    $tmp = download_url($url, 30);
    if (is_wp_error($tmp)) return 0;
    $ext = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
    $id = media_handle_sideload(['name' => $slug . '.' . $ext, 'tmp_name' => $tmp], 0, $slug);
    if (is_wp_error($id)) { @unlink($tmp); return 0; }
    return $id;
}

// --------------------------------------------------------------------
// FIX 1 — Unpublish dated/incomplete posts (issues #11, #12, #14, #15)
// --------------------------------------------------------------------
$posts_to_unpublish = [
    'content-marketing-in-2024',                          // 2024 dated post
    'the-ultimate-guide-to-content-marketing-in-2022',    // 2022 dated post
    'content-marketing-tips',                             // incomplete listicle (slug variant)
    'building-content-team',                              // incomplete content (slug variant)
    'building-content-team-scale',                        // local slug variant
];

WP_CLI::log("=== Unpublishing dated/incomplete posts ===");
foreach ($posts_to_unpublish as $slug) {
    // Try matching slug or trashed-variant slug
    $candidates = get_posts([
        'post_type'      => 'post',
        'post_status'    => ['publish', 'pending', 'future'],
        'name'           => $slug,
        'numberposts'    => 1,
        'suppress_filters' => true,
    ]);
    if (empty($candidates)) {
        // Try variants
        $candidates = get_posts([
            'post_type'      => 'post',
            'post_status'    => ['publish', 'pending', 'future'],
            'name'           => $slug . '__trashed',
            'numberposts'    => 1,
            'suppress_filters' => true,
        ]);
    }
    if (empty($candidates)) {
        WP_CLI::log("  ○ skip (not published): {$slug}");
        continue;
    }
    $post = $candidates[0];
    wp_update_post(['ID' => $post->ID, 'post_status' => 'draft']);
    WP_CLI::log("  ✓ drafted: {$post->post_title} (ID {$post->ID})");
}

// --------------------------------------------------------------------
// FIX 2 — Repair broken healthcare-content-marketing post image (#13)
// --------------------------------------------------------------------
WP_CLI::log("\n=== Fixing healthcare post image ===");
$healthcare = get_page_by_path('the-guide-for-healthcare-content-marketing', OBJECT, 'post');
if (!$healthcare) {
    WP_CLI::warning('  Healthcare post not found by slug. Skipping image fix.');
} else {
    // Sideload a replacement image
    $replacement_url = 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=1600&q=80&auto=format&fit=crop';
    $att_id = cf_sideload_image($replacement_url, 'healthcare-content-marketing-hero');
    if (!$att_id) {
        WP_CLI::warning('  Failed to sideload replacement image.');
    } else {
        $img_url = wp_get_attachment_image_url($att_id, 'full');

        // Replace the first wp:image block (broken DALLC2B7E… url) with the new attachment.
        $content = $healthcare->post_content;
        $new_block = "<!-- wp:image {\"id\":{$att_id},\"sizeSlug\":\"full\",\"linkDestination\":\"none\"} -->\n"
            . "<figure class=\"wp-block-image size-full\"><img src=\"" . esc_url($img_url) . "\" alt=\"A tablet representing healthcare content marketing\" class=\"wp-image-{$att_id}\"/></figure>\n"
            . "<!-- /wp:image -->";

        // Only patch if the broken DALL image is still referenced
        if (strpos($content, 'DALLC2B7E') !== false) {
            $new_content = preg_replace(
                '/<!-- wp:image[^>]*-->\s*<figure[^>]*><img src="[^"]*DALLC2B7E[^"]*"[^>]*\/?>.*?<!-- \/wp:image -->/s',
                $new_block,
                $content,
                1
            );
            if ($new_content && $new_content !== $content) {
                wp_update_post(['ID' => $healthcare->ID, 'post_content' => $new_content]);
                // Set as featured image too
                set_post_thumbnail($healthcare->ID, $att_id);
                WP_CLI::log("  ✓ replaced broken DALLC2B7E… image with attachment {$att_id}");
            } else {
                WP_CLI::warning('  Regex did not match. Image block unchanged.');
            }
        } else {
            // Already patched — just make sure featured image is set
            if (!has_post_thumbnail($healthcare->ID)) {
                set_post_thumbnail($healthcare->ID, $att_id);
                WP_CLI::log("  ✓ set featured image on already-patched post");
            } else {
                WP_CLI::log("  ○ already patched — no change needed");
            }
        }
    }
}

// --------------------------------------------------------------------
// FIX 3 — Repoint homepage to the new Home template (page-home.php)
// The Solutions design is now the homepage; front-page-v2 is retired.
// --------------------------------------------------------------------
WP_CLI::log("\n=== Repointing homepage to page-home.php ===");
$home_page = get_page_by_path('home');
if (!$home_page) {
    WP_CLI::warning('  Home page (slug "home") not found. Skipping front-page repoint.');
} else {
    update_post_meta($home_page->ID, '_wp_page_template', 'page-home.php');
    update_option('show_on_front', 'page');
    update_option('page_on_front', $home_page->ID);
    WP_CLI::log("  ✓ Home page (ID {$home_page->ID}) → page-home.php; front page set");
}

WP_CLI::success('Content fixes complete.');
