<?php
/**
 * Strip Rank Math inline TOC blocks from imported blog posts.
 * Run via: docker exec stretch-wordpress-1 wp --allow-root eval-file /var/www/html/strip-rank-math-toc.php
 */

global $wpdb;

$rows = $wpdb->get_results(
    "SELECT ID, post_title FROM {$wpdb->posts}
     WHERE post_type = 'post'
       AND post_status IN ('publish', 'draft')
       AND post_content LIKE '%wp:rank-math/toc-block%'
     ORDER BY ID"
);

if ( ! $rows ) {
    echo "No posts matched.\n";
    return;
}

echo "Found " . count( $rows ) . " posts with rank-math TOC blocks.\n\n";

$pattern = '/<!-- wp:rank-math\/toc-block.*?<!-- \/wp:rank-math\/toc-block -->\n?/s';
$updated = 0;
$skipped = 0;

foreach ( $rows as $row ) {
    $post = get_post( $row->ID );
    if ( ! $post ) {
        continue;
    }

    $new_content = preg_replace( $pattern, '', $post->post_content );

    if ( $new_content === $post->post_content ) {
        printf( "SKIP  #%d  %s  (pattern did not match)\n", $post->ID, $post->post_title );
        $skipped++;
        continue;
    }

    $result = wp_update_post(
        array(
            'ID'           => $post->ID,
            'post_content' => $new_content,
        ),
        true
    );

    if ( is_wp_error( $result ) ) {
        printf( "ERROR #%d  %s  (%s)\n", $post->ID, $post->post_title, $result->get_error_message() );
        continue;
    }

    printf( "OK    #%d  %s\n", $post->ID, $post->post_title );
    $updated++;
}

echo "\nUpdated: $updated   Skipped: $skipped\n";
