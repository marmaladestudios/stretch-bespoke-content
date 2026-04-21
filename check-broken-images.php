<?php
if (!defined('ABSPATH')) { WP_CLI::error('Run via wp eval-file'); }

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

WP_CLI::log("Posts with remaining unsideloaded images: " . count($affected));
WP_CLI::log("Total broken image URLs across those posts: {$total_broken}\n");

foreach ($affected as $a) {
    WP_CLI::log(sprintf("  [%d] (%s) %d imgs — %s", $a['id'], $a['status'], $a['count'], $a['title']));
}
