<?php
/**
 * Import real client logos and update Homepage 2.0 marquee.
 * Run: wp eval-file setup-logos.php
 */
// AUD-022: web-exposure guard — this script mutates content and must only run
// via WP-CLI (wp eval-file). A direct web request exits before doing anything.
if (!defined('WP_CLI') || !WP_CLI) {
    exit;
}

require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

function stretch_import_logo($url, $name) {
    $existing = get_posts(['post_type' => 'attachment', 'title' => $name, 'numberposts' => 1]);
    if ($existing) return $existing[0]->ID;

    $tmp = download_url($url);
    if (is_wp_error($tmp)) {
        if (defined('WP_CLI') && WP_CLI) { WP_CLI::warning("Failed: {$name} — " . $tmp->get_error_message()); } else { echo 'Warning: ' . "Failed: {$name} — " . $tmp->get_error_message() . "\n"; }
        return 0;
    }
    $ext = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'png';
    $id = media_handle_sideload(['name' => sanitize_title($name) . '.' . $ext, 'tmp_name' => $tmp], 0, $name);
    if (is_wp_error($id)) { @unlink($tmp); return 0; }
    if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("  Imported: {$name} (ID: {$id})"); } else { echo "  Imported: {$name} (ID: {$id})" . "\n"; }
    return $id;
}

$logos = [
    'Blue Nile'        => 'https://stretchcreative.co/wp-content/uploads/2021/12/client-bluenile.jpg',
    'Vuori'            => 'https://stretchcreative.co/wp-content/uploads/2021/12/client-vuori.jpg',
    'RVCA'             => 'https://stretchcreative.co/wp-content/uploads/2023/10/client-rvca.png',
    'Zulily'           => 'https://stretchcreative.co/wp-content/uploads/2023/10/client-zulily.png',
    'Walmart'          => 'https://stretchcreative.co/wp-content/uploads/2023/10/client-walmart.png',
    'Grainger'         => 'https://stretchcreative.co/wp-content/uploads/2021/12/client-grainger.jpg',
    'Etsy'             => 'https://stretchcreative.co/wp-content/uploads/2023/10/client-etsy.png',
    'Home Depot'       => 'https://stretchcreative.co/wp-content/uploads/2021/12/client-homedepot.jpg',
    'Grove'            => 'https://stretchcreative.co/wp-content/uploads/2022/08/grove_logo-removebg-preview-e1661728963251.png',
    '1stDibs'          => 'https://stretchcreative.co/wp-content/uploads/2022/08/1stdibs-logo-black-on-white-500px-padding-removebg-preview-2-e1661728971271.png',
    'Stance'           => 'https://stretchcreative.co/wp-content/uploads/2023/10/client-stance.jpg',
    'Udemy'            => 'https://stretchcreative.co/wp-content/uploads/2023/10/client-udemy.png',
    'Spy'              => 'https://stretchcreative.co/wp-content/uploads/2023/10/client-spy.png',
    'ServiceChannel'   => 'https://stretchcreative.co/wp-content/uploads/2023/10/client-service-channel.png',
    'Paperless Post'   => 'https://stretchcreative.co/wp-content/uploads/2023/10/client-paperless.png',
    'Hipcamp'          => 'https://stretchcreative.co/wp-content/uploads/2023/10/client-hipcamp.png',
    'FreshBooks'       => 'https://stretchcreative.co/wp-content/uploads/2023/10/client-freshbooks.png',
    'Element'          => 'https://stretchcreative.co/wp-content/uploads/2023/10/client-element.png',
    'DraftKings'       => 'https://stretchcreative.co/wp-content/uploads/2023/10/client-draft-kings.png',
    'DC Shoes'         => 'https://stretchcreative.co/wp-content/uploads/2023/10/client-dc.png',
    'Brixton'          => 'https://stretchcreative.co/wp-content/uploads/2023/10/client-brixton.png',
    'Billabong'        => 'https://stretchcreative.co/wp-content/uploads/2023/10/client-billabong.png',
    'Boot Barn'        => 'https://stretchcreative.co/wp-content/uploads/2021/12/client-bootbarn.jpg',
    'Tribal'           => 'https://stretchcreative.co/wp-content/uploads/2021/12/client-tribal.jpg',
    'Junk Food'        => 'https://stretchcreative.co/wp-content/uploads/2021/12/client-junkfood.jpg',
    'Walgreens'        => 'https://stretchcreative.co/wp-content/uploads/2023/10/client-walgreens.png',
    'UGG'              => 'https://stretchcreative.co/wp-content/uploads/2024/03/ugg-client.png',
];

if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("=== Importing client logos ===\n"); } else { echo "=== Importing client logos ===\n" . "\n"; }

$imported = [];
foreach ($logos as $name => $url) {
    $id = stretch_import_logo($url, 'client-logo-' . sanitize_title($name));
    if ($id) {
        $imported[$name] = $id;
    }
}

if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("\nImported " . count($imported) . " logos."); } else { echo "\nImported " . count($imported) . " logos." . "\n"; }

// Now update the Homepage 2.0 template marquee
// The marquee is hardcoded in front-page-v2.php with text-based SVGs.
// We need to replace them with real <img> tags.

// Build the HTML for the marquee
$marquee_html = '';
foreach ($imported as $name => $id) {
    $url = wp_get_attachment_url($id);
    $marquee_html .= '<img src="' . $url . '" alt="' . esc_attr($name) . '" loading="lazy">' . "\n            ";
}

// Save the logo data as an option so we can use it in the template
update_option('stretch_client_logos', $imported);
if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("\nSaved logo IDs to stretch_client_logos option."); } else { echo "\nSaved logo IDs to stretch_client_logos option." . "\n"; }
if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("Logo URLs available for template use."); } else { echo "Logo URLs available for template use." . "\n"; }

// Output the HTML snippet for manual insertion
if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("\n=== Logo marquee HTML (for reference) ==="); } else { echo "\n=== Logo marquee HTML (for reference) ===" . "\n"; }
foreach ($imported as $name => $id) {
    $url = wp_get_attachment_url($id);
    if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("  {$name}: {$url}"); } else { echo "  {$name}: {$url}" . "\n"; }
}

if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("\n=== Done! ==="); } else { echo "\n=== Done! ===" . "\n"; }
