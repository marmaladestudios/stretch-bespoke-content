<?php
/**
 * Idempotent setup for /our-work/ portfolio assets.
 *
 * Sideloads each image from /opt/portfolio-assets/ (bundled in the Docker image)
 * into the WP media library if it doesn't already exist. Skips images whose
 * filename is already attached to a media post — safe to re-run on every container
 * startup.
 *
 * Run: docker compose exec wordpress wp eval-file /var/www/html/setup-portfolio.php --allow-root
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

// Look in both /opt (production) and the repo root (local dev)
$candidate_dirs = [
    '/opt/portfolio-assets',
    dirname(__FILE__) . '/portfolio-assets',
    '/var/www/html/portfolio-assets',
];
$assets_dir = null;
foreach ($candidate_dirs as $d) {
    if (is_dir($d)) { $assets_dir = $d; break; }
}
if (!$assets_dir) {
    if (defined('WP_CLI') && WP_CLI) { WP_CLI::warning('No portfolio-assets/ directory found. Skipping.'); } else { echo 'Warning: ' . 'No portfolio-assets/ directory found. Skipping.' . "\n"; }
    return;
}
if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("Sideloading portfolio assets from: {$assets_dir}"); } else { echo "Sideloading portfolio assets from: {$assets_dir}" . "\n"; }

// Definitions mirror stretch_portfolio_definitions() in functions.php.
// File names here MUST match what the theme's lookup expects.
$items = [
    ['img-011-008.png', "Paperless Post — Home Sweet Home Invitation",      "Paperless Post home sweet home invitation design"],
    ['img-012-010.png', "Etsy — Wedding Invitations Listing Page",          "Etsy wedding invitations product listing page"],
    ['img-012-011.png', "Walgreens — Chemical Peel Expert Article",         "Walgreens Thread article about chemical peels for acne scars"],
    ['img-013-014.jpg', "Grove Co — Meyer's Clean Day Products",            "Grove Collaborative Meyer's Clean Day product flatlay"],
    ['img-013-015.jpg', "Remitly — Immigrants Pay Taxes Too Infographic",   "Remitly infographic on immigrants and tax contributions"],
    ['img-014-017.jpg', "Reef — Aerial Surfers Social Post",                "Reef Instagram post with aerial surfers in turquoise water"],
    ['img-014-018.jpg', "Grove Collaborative — Mosquito Repellents Article","Grove Collaborative article on natural mosquito repellents"],
    ['img-014-019.png', "Brixton x Coors — Cheers to the Originals Email",  "Brixton Coors Banquet email campaign"],
    ['img-015-023.jpg', "Reef — Surf Barrel Social Content",                "Reef social content with surfer inside a wave barrel"],
    ['img-019-026.jpg', "Meyer's Clean Day — Dish Soap Product Photography","Meyer's Clean Day dish soap with peonies on a pink tray"],
    ['img-020-027.jpg', "Meyer's Clean Day — Lilac Lifestyle Photography",  "Meyer's Clean Day lilac-scented products with fresh lilacs"],
    ['img-021-028.jpg', "QuickBooks — Inflation in Canada Infographic",     "QuickBooks infographic on inflation impacts in Canada"],
    ['img-021-030.png', "WeWork — Los Angeles Mural Photography",           "WeWork Los Angeles office featuring a colorful mural"],
    ['img-023-031.jpg', "Vicis — Protect the Ice Brand Story",              "Still from Vicis Protect the Ice hockey brand film"],
    ['img-024-032.jpg', "Open Road — Corporate Video Still",                "Still from corporate video featuring an RV on an open road"],
    ['img-024-033.jpg', "Family Flowers — Documentary Still",               "Still from documentary featuring family arranging flowers"],
    ['img-025-034.jpg', "NHL — TV Advertisement Still",                     "Still from TV commercial featuring an NHL player"],
    ['img-025-035.jpg', "Monster Energy — X Games Aspen Social Ad Still",   "Still from Monster Energy X Games Aspen social video ad"],
];

global $wpdb;
$imported = 0; $skipped = 0; $failed = 0;

foreach ($items as [$file, $title, $alt]) {
    $src = $assets_dir . '/' . $file;
    if (!file_exists($src)) {
        if (defined('WP_CLI') && WP_CLI) { WP_CLI::warning("  missing source: {$file}"); } else { echo 'Warning: ' . "  missing source: {$file}" . "\n"; }
        $failed++;
        continue;
    }

    // Already attached?
    $base = pathinfo($file, PATHINFO_FILENAME);
    $existing = $wpdb->get_var($wpdb->prepare(
        "SELECT post_id FROM {$wpdb->postmeta}
         WHERE meta_key = '_wp_attached_file'
           AND (meta_value LIKE %s OR meta_value LIKE %s)
         LIMIT 1",
        '%/' . $wpdb->esc_like($file),
        '%/' . $wpdb->esc_like($base) . '%'
    ));
    if ($existing) {
        $skipped++;
        continue;
    }

    // Copy to a tmp file and sideload (so the original in /opt stays intact)
    $tmp = wp_tempnam($file);
    if (!copy($src, $tmp)) {
        if (defined('WP_CLI') && WP_CLI) { WP_CLI::warning("  copy failed: {$file}"); } else { echo 'Warning: ' . "  copy failed: {$file}" . "\n"; }
        $failed++;
        continue;
    }
    $id = media_handle_sideload(
        ['name' => $file, 'tmp_name' => $tmp],
        0,
        $title
    );
    if (is_wp_error($id)) {
        if (defined('WP_CLI') && WP_CLI) { WP_CLI::warning("  sideload failed for {$file}: " . $id->get_error_message()); } else { echo 'Warning: ' . "  sideload failed for {$file}: " . $id->get_error_message() . "\n"; }
        @unlink($tmp);
        $failed++;
        continue;
    }
    if ($alt) update_post_meta($id, '_wp_attachment_image_alt', $alt);
    if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("  ✓ imported {$file} (ID {$id})"); } else { echo "  ✓ imported {$file} (ID {$id})" . "\n"; }
    $imported++;
}

if (defined('WP_CLI') && WP_CLI) { WP_CLI::success("Portfolio: {$imported} imported, {$skipped} already existed, {$failed} failed."); } else { echo 'Success: ' . "Portfolio: {$imported} imported, {$skipped} already existed, {$failed} failed." . "\n"; }
