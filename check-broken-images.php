<?php
// AUD-022: web-exposure guard — this script mutates content and must only run
// via WP-CLI (wp eval-file). A direct web request exits before doing anything.
if (!defined('WP_CLI') || !WP_CLI) {
    exit;
}
if (!defined('ABSPATH')) { if (defined('WP_CLI') && WP_CLI) { WP_CLI::error('Run via wp eval-file'); } else { echo 'Error: ' . 'Run via wp eval-file' . "\n"; exit; } }

$posts = get_posts([
    'post_type' => 'post',
    'post_status' => ['publish', 'draft', 'private'],
    'posts_per_page' => -1,
]);

$affected = [];
$total_broken = 0;

foreach ($posts as $post) {
    if (preg_match_all('#https?://(?:www\.)?stretchcreative\.co/wp-content/uploads/[^\s"\'\)<>]+\.(?:jpg|jpeg|png|gif|webp|svg)#i', $post->post_content, $m)) {
        $urls = array_unique($m[0]);
        $affected[] = [
            'id'     => $post->ID,
            'slug'   => $post->post_name,
            'title'  => $post->post_title,
            'status' => $post->post_status,
            'count'  => count($urls),
        ];
        $total_broken += count($urls);
    }
}

if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("Posts with remaining unsideloaded images: " . count($affected)); } else { echo "Posts with remaining unsideloaded images: " . count($affected) . "\n"; }
if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("Total broken image URLs across those posts: {$total_broken}\n"); } else { echo "Total broken image URLs across those posts: {$total_broken}\n" . "\n"; }

foreach ($affected as $a) {
    if (defined('WP_CLI') && WP_CLI) { WP_CLI::log(sprintf("  [%d] (%s) %d imgs — %s", $a['id'], $a['status'], $a['count'], $a['title'])); } else { echo sprintf("  [%d] (%s) %d imgs — %s", $a['id'], $a['status'], $a['count'], $a['title']) . "\n"; }
}
