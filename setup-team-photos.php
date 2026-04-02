<?php
/**
 * Import real team photos from old site and update team page template.
 * Run: wp eval-file setup-team-photos.php
 */
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

function import_photo($url, $name) {
    $slug = 'team-photo-' . sanitize_title($name);
    $existing = get_posts(['post_type' => 'attachment', 'title' => $slug, 'numberposts' => 1]);
    if ($existing) { WP_CLI::log("  - Exists: {$name}"); return $existing[0]->ID; }

    $tmp = download_url($url, 30);
    if (is_wp_error($tmp)) { WP_CLI::warning("Failed: {$name}"); return 0; }
    $ext = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
    $id = media_handle_sideload(['name' => $slug . '.' . $ext, 'tmp_name' => $tmp], 0, $slug);
    if (is_wp_error($id)) { @unlink($tmp); WP_CLI::warning("Sideload failed: {$name}"); return 0; }
    WP_CLI::log("  ✓ {$name} (ID: {$id})");
    return $id;
}

$team = [
    ['Chris Reid', 'CEO', 'https://stretchcreative.co/wp-content/uploads/2023/09/Chris.jpeg'],
    ['Kelsi Carrell', 'Head of Operations', 'https://stretchcreative.co/wp-content/uploads/2020/11/Kelsi-e1641439041685.jpeg'],
    ['Jesse Galvon Reid', 'CPO – Chief People Officer', 'https://stretchcreative.co/wp-content/uploads/2020/09/Untitled-design-18-e1641438108530.png'],
    ['Kristen Bailey', 'Editor-In-Chief', 'https://stretchcreative.co/wp-content/uploads/2020/09/kristen0.png'],
    ['Josh Wong', 'Director of Video Content', 'https://stretchcreative.co/wp-content/uploads/2023/10/Josh-Wong-scaled.jpg'],
    ['Jeanine Gordon', 'Managing Editor', 'https://stretchcreative.co/wp-content/uploads/2023/09/Jeanine.jpeg'],
    ['Fiona Ferguson', 'Community & Recruitment Coordinator', 'https://stretchcreative.co/wp-content/uploads/2023/01/Fiona.jpeg'],
    ['Kristyn Pacione', 'Client Services', 'https://stretchcreative.co/wp-content/uploads/2023/09/KP.jpeg'],
    ['MacKenzie Sanford', 'Editor + Resource Coordinator', 'https://stretchcreative.co/wp-content/uploads/2023/01/Mack.jpeg'],
    ['Jessica DeWolf', 'Lead Editor', 'https://stretchcreative.co/wp-content/uploads/2021/02/Untitled-design-22-e1641438472628.png'],
    ['Leslie Jeffries', 'Senior Copywriter', 'https://stretchcreative.co/wp-content/uploads/2020/09/Leslie-Jeffries.jpeg'],
    ['Jodi Noblett', 'Copywriter', 'https://stretchcreative.co/wp-content/uploads/2021/02/Untitled-design-33-e1641438356563.png'],
    ['Chelsey Moore', 'Copywriter', 'https://stretchcreative.co/wp-content/uploads/2021/02/Untitled-design-31-e1641438382819.png'],
    ['Lauren Gargiulo', 'Copywriter', 'https://stretchcreative.co/wp-content/uploads/2021/02/Untitled-design-28-e1641438395903.png'],
    ['Gillian Beckett', 'Copywriter', 'https://stretchcreative.co/wp-content/uploads/2021/02/Untitled-design-27-e1641438408682.png'],
    ['Kristin Kizer', 'Copywriter', 'https://stretchcreative.co/wp-content/uploads/2021/02/Untitled-design-26-e1641438420612.png'],
    ['Hannah Parks', 'Editor', 'https://stretchcreative.co/wp-content/uploads/2021/02/Untitled-design-23-e1641438462980.png'],
    ['Michele Fair', 'Copywriter', 'https://stretchcreative.co/wp-content/uploads/2021/02/Untitled-design-20-e1641438490942.png'],
    ['Nikki Smith', 'Copywriter', 'https://stretchcreative.co/wp-content/uploads/2021/02/Untitled-design-15-e1641438530889.png'],
    ['Phoenix Griffin', 'Copywriter', 'https://stretchcreative.co/wp-content/uploads/2021/02/Untitled-design-14-e1641438537372.png'],
    ['Nova Sawatzky', 'Copywriter', 'https://stretchcreative.co/wp-content/uploads/2021/02/Untitled-design-13-e1641438545590.png'],
    ['Monica Valhauer', 'Editor', 'https://stretchcreative.co/wp-content/uploads/2021/02/Untitled-design-10-e1641438576939.png'],
    ['Laura Anne', 'Copywriter', 'https://stretchcreative.co/wp-content/uploads/2021/02/Untitled-design-9-e1641438584102.png'],
    ['Rebecca Phillips', 'Copywriter', 'https://stretchcreative.co/wp-content/uploads/2021/02/Untitled-design-8-e1641438600887.png'],
    ['Vicki Duong', 'Copywriter', 'https://stretchcreative.co/wp-content/uploads/2021/02/Untitled-design-7-e1641184972637.png'],
    ['Julie Bruns', 'Copywriter', 'https://stretchcreative.co/wp-content/uploads/2020/11/Untitled-design-5-e1641439069441.png'],
    ['Eva Kurilova', 'Copywriter', 'https://stretchcreative.co/wp-content/uploads/2020/11/Untitled-design-3-e1641439083916.png'],
];

WP_CLI::log("=== Importing team photos ===\n");

$photo_map = [];
foreach ($team as $member) {
    $id = import_photo($member[2], $member[0]);
    if ($id) {
        $photo_map[] = ['name' => $member[0], 'title' => $member[1], 'photo_id' => $id, 'url' => wp_get_attachment_url($id)];
    }
}

// Save as option for the team page template to use
update_option('stretch_team_members', $photo_map);
WP_CLI::log("\nSaved " . count($photo_map) . " team members to options.");

// Now update the page-team.php template to use real photos
// The template hardcodes team members — we'll update it to pull from the option
WP_CLI::log("\n=== Done! Team photos imported. ===");
