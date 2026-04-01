<?php
/**
 * Image population script — run via WP-CLI:
 * wp eval-file setup-images.php
 *
 * Downloads placeholder images and attaches them to pages/posts.
 */

// ── Helper: Download image and add to media library ──
function stretch_import_image($url, $title, $post_id = 0) {
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';

    // Check if we already imported this
    $existing = get_posts([
        'post_type'  => 'attachment',
        'title'      => $title,
        'numberposts' => 1,
    ]);
    if ($existing) {
        WP_CLI::log("    Image '{$title}' already exists (ID: {$existing[0]->ID})");
        return $existing[0]->ID;
    }

    $tmp = download_url($url);
    if (is_wp_error($tmp)) {
        WP_CLI::warning("Failed to download {$url}: " . $tmp->get_error_message());
        return 0;
    }

    $ext = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
    $file_array = [
        'name'     => sanitize_title($title) . '.' . $ext,
        'tmp_name' => $tmp,
    ];

    $attachment_id = media_handle_sideload($file_array, $post_id, $title);
    if (is_wp_error($attachment_id)) {
        @unlink($tmp);
        WP_CLI::warning("Failed to sideload {$title}: " . $attachment_id->get_error_message());
        return 0;
    }

    WP_CLI::log("    Imported '{$title}' (ID: {$attachment_id})");
    return $attachment_id;
}

WP_CLI::log("=== Importing images ===\n");

// ────────────────────────────────────────
// BLOG POST FEATURED IMAGES
// ────────────────────────────────────────
WP_CLI::log("Blog post featured images...");

$blog_images = [
    'content-marketing-2024'       => 'https://images.unsplash.com/photo-1432888498266-38ffec3eaf0a?w=800&h=450&fit=crop',
    'ecommerce-seo-content'        => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=800&h=450&fit=crop',
    'building-content-team-scale'  => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&h=450&fit=crop',
];

foreach ($blog_images as $slug => $url) {
    $post = get_page_by_path($slug, OBJECT, 'post');
    if ($post && !has_post_thumbnail($post->ID)) {
        $img_id = stretch_import_image($url, 'blog-' . $slug, $post->ID);
        if ($img_id) {
            set_post_thumbnail($post->ID, $img_id);
            WP_CLI::log("  Set featured image for '{$post->post_title}'");
        }
    }
}

// ────────────────────────────────────────
// TEAM MEMBER PHOTOS (placeholder avatars)
// ────────────────────────────────────────
WP_CLI::log("\nTeam member photos...");

$team_page = get_page_by_path('the-team');
if ($team_page) {
    $sections = get_field('page_sections', $team_page->ID);
    if ($sections) {
        foreach ($sections as $i => &$section) {
            if ($section['acf_fc_layout'] === 'team-grid' && !empty($section['team_members'])) {
                foreach ($section['team_members'] as $j => &$member) {
                    if (empty($member['photo'])) {
                        // Use UI Avatars for consistent placeholder photos
                        $initials = implode('+', array_map(function($w) { return substr($w, 0, 1); }, explode(' ', $member['name'])));
                        $colors = ['8560A8', '5674B9', '448CCB', '00BFF3'];
                        $color = $colors[$j % count($colors)];
                        $url = "https://ui-avatars.com/api/?name=" . urlencode($member['name']) . "&size=400&background={$color}&color=fff&bold=true&format=png";

                        $img_id = stretch_import_image($url, 'team-' . sanitize_title($member['name']), $team_page->ID);
                        if ($img_id) {
                            $section['team_members'][$j]['photo'] = $img_id;
                        }
                    }
                }
            }
        }
        update_field('page_sections', $sections, $team_page->ID);
        WP_CLI::log("  Updated team grid with photos");
    }
}

// ────────────────────────────────────────
// ABOUT PAGE — Add image+text section
// ────────────────────────────────────────
WP_CLI::log("\nAbout page image...");

$about_page = get_page_by_path('about-stretch-creative');
if ($about_page) {
    $about_img_id = stretch_import_image(
        'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&h=600&fit=crop',
        'about-team-collaboration',
        $about_page->ID
    );

    if ($about_img_id) {
        $sections = get_field('page_sections', $about_page->ID);
        // Insert an image+text section after the story content block (index 1)
        $image_text_section = [
            'acf_fc_layout'    => 'image-text',
            'image'            => $about_img_id,
            'image_position'   => 'right',
            'overline'         => 'Who We Are',
            'heading'          => 'A Growing Community of Creatives',
            'body_content'     => '<p>From two people with a vision to a community of more than 200 creatives — Stretch Creative has grown by staying true to our core values: fair compensation, publishable quality, and long-term partnerships built on trust.</p><p>Every writer, editor, designer, and strategist on our team shares a passion for great content and a commitment to helping brands tell their stories.</p>',
            'cta_button'       => ['title' => 'Meet the Team →', 'url' => '/the-team/', 'target' => ''],
            'background_style' => 'light',
            'custom_background_color' => '',
            'section_id'       => '',
            'padding_style'    => 'default',
        ];
        array_splice($sections, 2, 0, [$image_text_section]);
        update_field('page_sections', $sections, $about_page->ID);
        WP_CLI::log("  Added image+text section to About page");
    }
}

// ────────────────────────────────────────
// HOMEPAGE — Add image to featured card area
// ────────────────────────────────────────
WP_CLI::log("\nHomepage images...");

$home_page = get_page_by_path('home');
if ($home_page) {
    // Add a logo carousel section with placeholder logos
    $sections = get_field('page_sections', $home_page->ID);

    // Check if logo carousel already exists
    $has_logos = false;
    foreach ($sections as $s) {
        if ($s['acf_fc_layout'] === 'logo-carousel') $has_logos = true;
    }

    if (!$has_logos) {
        // Import some placeholder brand logos (colored squares as stand-ins)
        $logo_names = ['Blue Nile', 'Vuori', 'RVCA', 'Zulily', 'Grainger', 'Etsy', 'Home Depot', 'Grove'];
        $logos = [];
        foreach ($logo_names as $name) {
            $colors = ['8560A8', '5674B9', '448CCB', '00BFF3', '323A51', '74509a'];
            $color = $colors[array_rand($colors)];
            $url = "https://ui-avatars.com/api/?name=" . urlencode($name) . "&size=120&background={$color}&color=fff&bold=true&format=png&rounded=false&length=3";
            $img_id = stretch_import_image($url, 'logo-' . sanitize_title($name), $home_page->ID);
            if ($img_id) {
                $logos[] = [
                    'logo_image'   => $img_id,
                    'company_name' => $name,
                ];
            }
        }

        if ($logos) {
            $logo_section = [
                'acf_fc_layout'    => 'logo-carousel',
                'heading'          => 'More Than a Vendor',
                'subheading'       => 'These are just a few of the brands that trust us with their content.',
                'logos'            => $logos,
                'background_style' => 'white',
                'custom_background_color' => '',
                'section_id'       => 'clients',
                'padding_style'    => 'default',
            ];

            // Insert after testimonials (before blog preview)
            $insert_pos = count($sections) - 2; // Before blog preview and CTA
            array_splice($sections, $insert_pos, 0, [$logo_section]);
            update_field('page_sections', $sections, $home_page->ID);
            WP_CLI::log("  Added logo carousel to homepage");
        }
    }
}

// ────────────────────────────────────────
// SOLUTIONS PAGE — Hero-style images for sub-pages
// ────────────────────────────────────────
WP_CLI::log("\nSolution/Service page images...");

$page_images = [
    'ecommerce-content'            => ['https://images.unsplash.com/photo-1556742393-d75f468bfcb0?w=800&h=600&fit=crop', 'Ecommerce workspace'],
    'agency-content'               => ['https://images.unsplash.com/photo-1600880292203-757bb62b4baf?w=800&h=600&fit=crop', 'Agency team meeting'],
    'publisher-content'            => ['https://images.unsplash.com/photo-1504711434969-e33886168d6c?w=800&h=600&fit=crop', 'Publishing and media'],
    'demand-generation-content'    => ['https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&h=600&fit=crop', 'Marketing analytics'],
    'content-writing-at-any-scale' => ['https://images.unsplash.com/photo-1455390582262-044cdead277a?w=800&h=600&fit=crop', 'Writing and content creation'],
    'seo_content_strategy_services' => ['https://images.unsplash.com/photo-1562577309-4932fdd64cd1?w=800&h=600&fit=crop', 'SEO and data analysis'],
    'graphic_design_services'      => ['https://images.unsplash.com/photo-1561070791-2526d30994b5?w=800&h=600&fit=crop', 'Graphic design workspace'],
    'video-content-services'       => ['https://images.unsplash.com/photo-1574717024653-61fd2cf4d44d?w=800&h=600&fit=crop', 'Video production'],
];

foreach ($page_images as $slug => $info) {
    $page = get_page_by_path($slug) ?: get_page_by_path("stretch-creative-solutions/{$slug}");
    if ($page) {
        $sections = get_field('page_sections', $page->ID);
        if ($sections) {
            // Check if we already have an image-text section
            $has_it = false;
            foreach ($sections as $s) {
                if ($s['acf_fc_layout'] === 'image-text') $has_it = true;
            }

            if (!$has_it) {
                $img_id = stretch_import_image($info[0], 'page-' . sanitize_title($slug), $page->ID);
                if ($img_id) {
                    // Add image+text section after the content block
                    $image_section = [
                        'acf_fc_layout'    => 'image-text',
                        'image'            => $img_id,
                        'image_position'   => 'right',
                        'overline'         => '',
                        'heading'          => '',
                        'body_content'     => '',
                        'cta_button'       => ['title' => "Let's Talk →", 'url' => '/contact-stretch-creative/', 'target' => ''],
                        'background_style' => 'light',
                        'custom_background_color' => '',
                        'section_id'       => '',
                        'padding_style'    => 'default',
                    ];
                    // Insert before the CTA (last section)
                    array_splice($sections, count($sections) - 1, 0, [$image_section]);
                    update_field('page_sections', $sections, $page->ID);
                    WP_CLI::log("  Added image to {$page->post_title}");
                }
            }
        }
    }
}

WP_CLI::log("\n=== Image import complete! ===");
