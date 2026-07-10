<?php
/**
 * Import real team photos from old site and update team page template.
 * Run: wp eval-file setup-team-photos.php
 */
// AUD-022: web-exposure guard — this script mutates content and must only run
// via WP-CLI (wp eval-file). A direct web request exits before doing anything.
if (!defined('WP_CLI') || !WP_CLI) {
    exit;
}
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

function import_photo($url, $name) {
    $slug = 'team-photo-' . sanitize_title($name);
    $existing = get_posts(['post_type' => 'attachment', 'title' => $slug, 'numberposts' => 1]);
    if ($existing) { if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("  - Exists: {$name}"); } else { echo "  - Exists: {$name}" . "\n"; } return $existing[0]->ID; }

    $tmp = download_url($url, 30);
    if (is_wp_error($tmp)) { if (defined('WP_CLI') && WP_CLI) { WP_CLI::warning("Failed: {$name}"); } else { echo 'Warning: ' . "Failed: {$name}" . "\n"; } return 0; }
    $ext = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
    $id = media_handle_sideload(['name' => $slug . '.' . $ext, 'tmp_name' => $tmp], 0, $slug);
    if (is_wp_error($id)) { @unlink($tmp); if (defined('WP_CLI') && WP_CLI) { WP_CLI::warning("Sideload failed: {$name}"); } else { echo 'Warning: ' . "Sideload failed: {$name}" . "\n"; } return 0; }
    if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("  ✓ {$name} (ID: {$id})"); } else { echo "  ✓ {$name} (ID: {$id})" . "\n"; }
    return $id;
}

// Roster: [name, title, photo URL or '' for placeholder]
// Order matters — this is the display order on /the-team/
$team = [
    ['Jesse Galvon Reid', 'CEO', 'https://stretchcreative.co/wp-content/uploads/2020/09/Untitled-design-18-e1641438108530.png'],
    ['Chris Reid', 'CGO', 'https://stretchcreative.co/wp-content/uploads/2023/09/Chris.jpeg'],
    ['Kelsi Carrell', 'Head of Operations', 'https://stretchcreative.co/wp-content/uploads/2020/11/Kelsi-e1641439041685.jpeg'],
    ['Kristen Bailey', 'Editor-In-Chief', 'https://stretchcreative.co/wp-content/uploads/2020/09/kristen0.png'],
    ['Kristyn Pacione', 'Client Services Manager', 'https://stretchcreative.co/wp-content/uploads/2023/09/KP.jpeg'],
    ['Cole Vineyard', 'SEO & Marketing Manager', ''],
    ['Diane', 'Business Development Manager', ''],
    ['MacKenzie Sanford', 'Editor + Resource Coordinator', 'https://stretchcreative.co/wp-content/uploads/2023/01/Mack.jpeg'],
    ['Nicole', 'Production Coordinator', ''],
    ['Jessica DeWolf', 'Lead Editor', 'https://stretchcreative.co/wp-content/uploads/2021/02/Untitled-design-22-e1641438472628.png'],
];

if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("=== Importing team photos ===\n"); } else { echo "=== Importing team photos ===\n" . "\n"; }

$photo_map = [];
foreach ($team as $member) {
    if (!empty($member[2])) {
        $id = import_photo($member[2], $member[0]);
        if ($id) {
            $photo_map[] = ['name' => $member[0], 'title' => $member[1], 'photo_id' => $id, 'url' => wp_get_attachment_url($id)];
            continue;
        }
        if (defined('WP_CLI') && WP_CLI) { WP_CLI::warning("Photo failed for {$member[0]} — adding without photo."); } else { echo 'Warning: ' . "Photo failed for {$member[0]} — adding without photo." . "\n"; }
    }
    // No photo URL or sideload failed — record member with empty photo so the
    // template renders the initials-on-color fallback avatar.
    $photo_map[] = ['name' => $member[0], 'title' => $member[1], 'photo_id' => 0, 'url' => ''];
    if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("  ○ {$member[0]} (no photo)"); } else { echo "  ○ {$member[0]} (no photo)" . "\n"; }
}

// Save as option for the team page template to use
update_option('stretch_team_members', $photo_map);
if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("\nSaved " . count($photo_map) . " team members to options."); } else { echo "\nSaved " . count($photo_map) . " team members to options." . "\n"; }

// Now update the page-team.php template to use real photos
// The template hardcodes team members — we'll update it to pull from the option
if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("\n=== Done! Team photos imported. ==="); } else { echo "\n=== Done! Team photos imported. ===" . "\n"; }
