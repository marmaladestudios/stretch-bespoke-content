<?php
/**
 * Idempotent content fixes for issues #11-#16 from the project tracker.
 * Safe to run multiple times — each fix checks current state before acting.
 *
 * Run: docker compose exec wordpress wp eval-file /var/www/html/content-fixes.php --allow-root
 */
// AUD-022: web-exposure guard — this script mutates content and must only run
// via WP-CLI (wp eval-file). A direct web request exits before doing anything.
if (!defined('WP_CLI') || !WP_CLI) {
    exit;
}

if (!defined('ABSPATH')) {
    if (defined('WP_CLI') && WP_CLI) { WP_CLI::error('This script must be run via wp eval-file.'); } else { echo 'Error: ' . 'This script must be run via wp eval-file.' . "\n"; exit; }
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

if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("=== Unpublishing dated/incomplete posts ==="); } else { echo "=== Unpublishing dated/incomplete posts ===" . "\n"; }
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
        if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("  ○ skip (not published): {$slug}"); } else { echo "  ○ skip (not published): {$slug}" . "\n"; }
        continue;
    }
    $post = $candidates[0];
    wp_update_post(['ID' => $post->ID, 'post_status' => 'draft']);
    if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("  ✓ drafted: {$post->post_title} (ID {$post->ID})"); } else { echo "  ✓ drafted: {$post->post_title} (ID {$post->ID})" . "\n"; }
}

// --------------------------------------------------------------------
// FIX 2 — Repair broken healthcare-content-marketing post image (#13)
// --------------------------------------------------------------------
if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("\n=== Fixing healthcare post image ==="); } else { echo "\n=== Fixing healthcare post image ===" . "\n"; }
$healthcare = get_page_by_path('the-guide-for-healthcare-content-marketing', OBJECT, 'post');
if (!$healthcare) {
    if (defined('WP_CLI') && WP_CLI) { WP_CLI::warning('  Healthcare post not found by slug. Skipping image fix.'); } else { echo 'Warning: ' . '  Healthcare post not found by slug. Skipping image fix.' . "\n"; }
} else {
    // Sideload a replacement image
    $replacement_url = 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=1600&q=80&auto=format&fit=crop';
    $att_id = cf_sideload_image($replacement_url, 'healthcare-content-marketing-hero');
    if (!$att_id) {
        if (defined('WP_CLI') && WP_CLI) { WP_CLI::warning('  Failed to sideload replacement image.'); } else { echo 'Warning: ' . '  Failed to sideload replacement image.' . "\n"; }
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
                if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("  ✓ replaced broken DALLC2B7E… image with attachment {$att_id}"); } else { echo "  ✓ replaced broken DALLC2B7E… image with attachment {$att_id}" . "\n"; }
            } else {
                if (defined('WP_CLI') && WP_CLI) { WP_CLI::warning('  Regex did not match. Image block unchanged.'); } else { echo 'Warning: ' . '  Regex did not match. Image block unchanged.' . "\n"; }
            }
        } else {
            // Already patched — just make sure featured image is set
            if (!has_post_thumbnail($healthcare->ID)) {
                set_post_thumbnail($healthcare->ID, $att_id);
                if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("  ✓ set featured image on already-patched post"); } else { echo "  ✓ set featured image on already-patched post" . "\n"; }
            } else {
                if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("  ○ already patched — no change needed"); } else { echo "  ○ already patched — no change needed" . "\n"; }
            }
        }
    }
}

// --------------------------------------------------------------------
// FIX 3 — Repoint homepage to the new Home template (page-home.php)
// The Solutions design is now the homepage; front-page-v2 is retired.
// --------------------------------------------------------------------
if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("\n=== Repointing homepage to page-home.php ==="); } else { echo "\n=== Repointing homepage to page-home.php ===" . "\n"; }
$home_page = get_page_by_path('home');
if (!$home_page) {
    if (defined('WP_CLI') && WP_CLI) { WP_CLI::warning('  Home page (slug "home") not found. Skipping front-page repoint.'); } else { echo 'Warning: ' . '  Home page (slug "home") not found. Skipping front-page repoint.' . "\n"; }
} else {
    update_post_meta($home_page->ID, '_wp_page_template', 'page-home.php');
    update_option('show_on_front', 'page');
    update_option('page_on_front', $home_page->ID);
    if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("  ✓ Home page (ID {$home_page->ID}) → page-home.php; front page set"); } else { echo "  ✓ Home page (ID {$home_page->ID}) → page-home.php; front page set" . "\n"; }
}

// --------------------------------------------------------------------
// FIX 4 — Draft retired graphic-design/video-content pages (final-review I-1)
// setup-services.php no longer creates these on fresh installs, but existing
// production DBs still have them published from before the merge into
// visual-content-and-design (301s live in functions.php ~line 141). Draft them
// here so any install — fresh or existing — ends up in the same state.
// --------------------------------------------------------------------
if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("\n=== Drafting retired GD/Video pages ==="); } else { echo "\n=== Drafting retired GD/Video pages ===" . "\n"; }
$retired_page_slugs = ['graphic_design_services', 'video-content-services'];
foreach ($retired_page_slugs as $slug) {
    $retired_page = get_page_by_path($slug);
    if (!$retired_page) {
        if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("  ○ skip (not found): {$slug}"); } else { echo "  ○ skip (not found): {$slug}" . "\n"; }
        continue;
    }
    if ($retired_page->post_status === 'publish') {
        wp_update_post(['ID' => $retired_page->ID, 'post_status' => 'draft']);
        if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("  ✓ drafted: {$retired_page->post_title} (ID {$retired_page->ID})"); } else { echo "  ✓ drafted: {$retired_page->post_title} (ID {$retired_page->ID})" . "\n"; }
    } else {
        if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("  ○ already {$retired_page->post_status} — no change needed: {$slug} (ID {$retired_page->ID})"); } else { echo "  ○ already {$retired_page->post_status} — no change needed: {$slug} (ID {$retired_page->ID})" . "\n"; }
    }
}

// --------------------------------------------------------------------
// FIX 5 — Draft retired Our Team / Our Work pages (punch-list #12)
// Our Story + Our Team + Our Work merged into the single About page at
// /about-stretch-creative/ (301s live in functions.php,
// stretch_redirect_merged_about_pages). Draft the standalone /the-team/ and
// /our-work/ pages here so any install — fresh or existing — ends up in the
// same state and the old URLs no longer resolve to a published page.
// --------------------------------------------------------------------
if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("\n=== Drafting retired Team/Work pages ==="); } else { echo "\n=== Drafting retired Team/Work pages ===" . "\n"; }
$retired_about_slugs = ['the-team', 'our-work'];
foreach ($retired_about_slugs as $slug) {
    $retired_page = get_page_by_path($slug);
    if (!$retired_page) {
        if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("  ○ skip (not found): {$slug}"); } else { echo "  ○ skip (not found): {$slug}" . "\n"; }
        continue;
    }
    if ($retired_page->post_status === 'publish') {
        wp_update_post(['ID' => $retired_page->ID, 'post_status' => 'draft']);
        if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("  ✓ drafted: {$retired_page->post_title} (ID {$retired_page->ID})"); } else { echo "  ✓ drafted: {$retired_page->post_title} (ID {$retired_page->ID})" . "\n"; }
    } else {
        if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("  ○ already {$retired_page->post_status} — no change needed: {$slug} (ID {$retired_page->ID})"); } else { echo "  ○ already {$retired_page->post_status} — no change needed: {$slug} (ID {$retired_page->ID})" . "\n"; }
    }
}

// --------------------------------------------------------------------
// FIX 6 — Retire the AEO content cluster from the blog (punch-list #24)
// The "AEO hub" is the /blog/aeo/ category landing rendered by category.php
// from the stretch_hub_aeo option (not a post), plus its 13 spoke/cornerstone
// posts in the "aeo" category. Draft every AEO post here (reversible) so the
// category empties out — the blog-home topic card auto-drops (hide_empty) and
// the related-posts rails stop surfacing them. The hub landing URL itself and
// the now-dead post URLs (all under /blog/aeo/) are 301'd to /blog/ by
// stretch_redirect_retired_aeo() in functions.php (path-matched, survives
// unpublishing). No published content or nav item links to these slugs, so no
// per-post link removal is needed. To restore the cluster: republish the posts
// and drop the redirect.
// --------------------------------------------------------------------
if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("\n=== Drafting retired AEO cluster posts ==="); } else { echo "\n=== Drafting retired AEO cluster posts ===" . "\n"; }
$aeo_post_slugs = [
    'the-complete-guide-to-answer-engine-optimization-aeo-in-2026', // cornerstone/pillar post
    'what-is-answer-engine-optimization-beginners-guide',
    'aeo-vs-seo',
    'how-ai-answer-engines-choose-brands-to-cite',
    'structure-content-for-ai',
    'schema-markup-for-aeo-technical-guide',
    'building-topical-authority-content-cluster-strategy-aeo',
    'featured-snippets-bridge-to-aeo',
    'eeat-signals-ai-answer-engines-evaluate',
    'original-research-data-aeo-competitive-advantage',
    'measuring-aeo-success-metrics-tools-reporting',
    'brand-visibility-crisis-aeo',
    '5-quick-wins-aeo',
];
foreach ($aeo_post_slugs as $slug) {
    $candidates = get_posts([
        'post_type'        => 'post',
        'post_status'      => ['publish', 'pending', 'future'],
        'name'             => $slug,
        'numberposts'      => 1,
        'suppress_filters' => true,
    ]);
    if (empty($candidates)) {
        if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("  ○ skip (not published): {$slug}"); } else { echo "  ○ skip (not published): {$slug}" . "\n"; }
        continue;
    }
    $post = $candidates[0];
    wp_update_post(['ID' => $post->ID, 'post_status' => 'draft']);
    if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("  ✓ drafted: {$post->post_title} (ID {$post->ID})"); } else { echo "  ✓ drafted: {$post->post_title} (ID {$post->ID})" . "\n"; }
}

if (defined('WP_CLI') && WP_CLI) { WP_CLI::success('Content fixes complete.'); } else { echo 'Success: ' . 'Content fixes complete.' . "\n"; }
