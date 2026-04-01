<?php
/**
 * Template Name: Setup Wizard
 *
 * One-click content setup. Create a page with this template and visit it.
 * DELETE THIS FILE after setup is complete.
 */

// Only allow admins
if (!current_user_can('manage_options')) {
    wp_die('Access denied.');
}

get_header();

echo '<section style="padding:160px 40px 80px;max-width:800px;margin:0 auto;font-family:Poppins,sans-serif;">';
echo '<h1 style="font-size:32px;margin-bottom:24px;">Stretch Creative Setup Wizard</h1>';

if (isset($_GET['run']) && $_GET['run'] === 'setup') {
    echo '<div style="background:#f9f9fb;padding:24px;margin-bottom:24px;font-size:14px;line-height:2;">';

    // ── Set permalink structure ──
    update_option('permalink_structure', '/%postname%/');
    flush_rewrite_rules();
    echo '✓ Permalinks set to post name<br>';

    // ── Create Homepage ──
    $home = get_page_by_path('home');
    if (!$home) {
        $home_id = wp_insert_post(['post_title' => 'Home', 'post_name' => 'home', 'post_type' => 'page', 'post_status' => 'publish']);
    } else {
        $home_id = $home->ID;
    }
    update_post_meta($home_id, '_wp_page_template', 'front-page-v2.php');
    update_option('show_on_front', 'page');
    update_option('page_on_front', $home_id);
    echo "✓ Homepage created (ID: {$home_id}) with Homepage 2.0 template<br>";

    // ── Create Blog page ──
    $blog = get_page_by_path('blog');
    if (!$blog) {
        $blog_id = wp_insert_post(['post_title' => 'Blog', 'post_name' => 'blog', 'post_type' => 'page', 'post_status' => 'publish']);
    } else {
        $blog_id = $blog->ID;
    }
    update_post_meta($blog_id, '_wp_page_template', 'page-blog-home.php');
    update_option('page_for_posts', $blog_id);
    echo "✓ Blog page created (ID: {$blog_id})<br>";

    // ── Create other pages ──
    $pages = [
        ['Our Story', 'about-stretch-creative', 'page-about.php'],
        ['Our Team', 'the-team', 'page-team.php'],
        ['Solutions', 'stretch-creative-solutions', 'page-solutions.php'],
        ['Contact Stretch Creative', 'contact-stretch-creative', 'page-contact.php'],
    ];
    foreach ($pages as $p) {
        $existing = get_page_by_path($p[1]);
        if (!$existing) {
            $pid = wp_insert_post(['post_title' => $p[0], 'post_name' => $p[1], 'post_type' => 'page', 'post_status' => 'publish']);
        } else {
            $pid = $existing->ID;
        }
        update_post_meta($pid, '_wp_page_template', $p[2]);
        echo "✓ Page '{$p[0]}' created with template {$p[2]}<br>";
    }

    // ── Create categories ──
    $cat_cm = wp_create_category('Content Marketing');
    $cat_ec = wp_create_category('Ecommerce');
    $cat_seo = wp_create_category('SEO');
    $cat_aeo = wp_create_category('AEO');
    wp_update_term($cat_aeo, 'category', [
        'description' => 'Answer Engine Optimization — strategies and insights for getting your content cited by AI-powered search engines like ChatGPT, Gemini, and Perplexity.'
    ]);
    echo "✓ Categories created (Content Marketing, Ecommerce, SEO, AEO)<br>";

    // ── Create sample blog posts ──
    $posts = [
        ['7 Things You Need to Know for Successful Content Marketing', 'content-marketing-tips', $cat_cm, 'Content marketing continues to evolve at a rapid pace. From AI-assisted writing to interactive content experiences, the landscape is shifting. Here are the most important trends and strategies you need to know to stay ahead.'],
        ['How Ecommerce Brands Can Win with SEO Content', 'ecommerce-seo-content', $cat_ec, 'For ecommerce brands, SEO content is more than blog posts — it\'s product descriptions that convert, buying guides that rank, and category pages that drive organic traffic.'],
        ['The Complete Guide to Building a Content Team at Scale', 'building-content-team', $cat_cm, 'Scaling a content operation is one of the hardest challenges in marketing. How do you maintain quality as you increase volume? We break down the proven approach.'],
        ['What Is Answer Engine Optimization (AEO) and Why It Matters', 'what-is-aeo', $cat_aeo, 'Answer Engine Optimization is the practice of structuring content so AI-powered search engines cite your brand. As ChatGPT, Gemini, and Perplexity reshape how people find information, AEO is becoming critical.'],
        ['AEO vs SEO: Understanding the Key Differences', 'aeo-vs-seo', $cat_aeo, 'While SEO focuses on ranking in traditional search results, AEO targets citation in AI-generated answers. The strategies overlap but diverge in important ways.'],
        ['How to Structure Content for AI Answer Engines', 'structure-content-ai', $cat_aeo, 'AI answer engines prefer content that is clearly structured, definitively stated, and backed by expertise. Learn the formatting patterns that increase your chances of being cited.'],
    ];

    foreach ($posts as $p) {
        $existing = get_page_by_path($p[1], OBJECT, 'post');
        if (!$existing) {
            wp_insert_post([
                'post_title' => $p[0],
                'post_name' => $p[1],
                'post_content' => '<p>' . $p[3] . '</p><h2>Why This Matters</h2><p>The content landscape is undergoing its biggest transformation in years. Brands that adapt now will capture visibility in channels growing exponentially.</p><blockquote>The brands that will dominate are the ones optimizing today — not tomorrow.</blockquote><h2>What You Can Do</h2><p>Start by auditing your existing content. Is it structured for both humans and machines? Does it provide definitive answers to real questions? The fundamentals remain: be authoritative, be helpful, be clear.</p>',
                'post_status' => 'publish',
                'post_type' => 'post',
                'post_category' => [$p[2]],
            ]);
            echo "✓ Post created: {$p[0]}<br>";
        } else {
            echo "- Post exists: {$p[0]}<br>";
        }
    }

    // ── Import client logos ──
    echo '<br><strong>Importing client logos...</strong><br>';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';

    $logos = [
        'Blue Nile' => 'https://stretchcreative.co/wp-content/uploads/2021/12/client-bluenile.jpg',
        'Vuori' => 'https://stretchcreative.co/wp-content/uploads/2021/12/client-vuori.jpg',
        'RVCA' => 'https://stretchcreative.co/wp-content/uploads/2023/10/client-rvca.png',
        'Walmart' => 'https://stretchcreative.co/wp-content/uploads/2023/10/client-walmart.png',
        'Etsy' => 'https://stretchcreative.co/wp-content/uploads/2023/10/client-etsy.png',
        'Home Depot' => 'https://stretchcreative.co/wp-content/uploads/2021/12/client-homedepot.jpg',
        'Grove' => 'https://stretchcreative.co/wp-content/uploads/2022/08/grove_logo-removebg-preview-e1661728963251.png',
        'Stance' => 'https://stretchcreative.co/wp-content/uploads/2023/10/client-stance.jpg',
        'Udemy' => 'https://stretchcreative.co/wp-content/uploads/2023/10/client-udemy.png',
        'DraftKings' => 'https://stretchcreative.co/wp-content/uploads/2023/10/client-draft-kings.png',
        'Brixton' => 'https://stretchcreative.co/wp-content/uploads/2023/10/client-brixton.png',
        'Billabong' => 'https://stretchcreative.co/wp-content/uploads/2023/10/client-billabong.png',
        'Walgreens' => 'https://stretchcreative.co/wp-content/uploads/2023/10/client-walgreens.png',
        'UGG' => 'https://stretchcreative.co/wp-content/uploads/2024/03/ugg-client.png',
        'FreshBooks' => 'https://stretchcreative.co/wp-content/uploads/2023/10/client-freshbooks.png',
        'Hipcamp' => 'https://stretchcreative.co/wp-content/uploads/2023/10/client-hipcamp.png',
    ];

    $imported_logos = [];
    foreach ($logos as $name => $url) {
        $existing = get_posts(['post_type' => 'attachment', 'title' => 'logo-' . sanitize_title($name), 'numberposts' => 1]);
        if ($existing) {
            $imported_logos[$name] = $existing[0]->ID;
            echo "- Logo exists: {$name}<br>";
            continue;
        }
        $tmp = download_url($url);
        if (is_wp_error($tmp)) { echo "✗ Failed: {$name}<br>"; continue; }
        $ext = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'png';
        $id = media_handle_sideload(['name' => 'logo-' . sanitize_title($name) . '.' . $ext, 'tmp_name' => $tmp], 0, 'logo-' . sanitize_title($name));
        if (is_wp_error($id)) { @unlink($tmp); echo "✗ Failed: {$name}<br>"; continue; }
        $imported_logos[$name] = $id;
        echo "✓ Logo imported: {$name}<br>";
    }
    update_option('stretch_client_logos', $imported_logos);
    echo "✓ Saved " . count($imported_logos) . " logos to options<br>";

    // ── Navigation Menus ──
    echo '<br><strong>Setting up menus...</strong><br>';
    $menu_locations = [];

    // Primary menu
    $primary = wp_get_nav_menu_object('Primary');
    $primary_id = $primary ? $primary->term_id : wp_create_nav_menu('Primary');
    $menu_locations['primary'] = $primary_id;

    // Clear and repopulate
    $items = wp_get_nav_menu_items($primary_id);
    if ($items) foreach ($items as $item) wp_delete_post($item->ID, true);

    wp_update_nav_menu_item($primary_id, 0, ['menu-item-title' => 'Solutions', 'menu-item-url' => home_url('/stretch-creative-solutions/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom', 'menu-item-position' => 1]);
    wp_update_nav_menu_item($primary_id, 0, ['menu-item-title' => 'Our Story', 'menu-item-url' => home_url('/about-stretch-creative/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom', 'menu-item-position' => 2]);
    wp_update_nav_menu_item($primary_id, 0, ['menu-item-title' => 'Our Team', 'menu-item-url' => home_url('/the-team/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom', 'menu-item-position' => 3]);
    wp_update_nav_menu_item($primary_id, 0, ['menu-item-title' => 'Blog', 'menu-item-url' => home_url('/blog/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom', 'menu-item-position' => 4]);
    wp_update_nav_menu_item($primary_id, 0, ['menu-item-title' => 'Contact Us', 'menu-item-url' => home_url('/contact-stretch-creative/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom', 'menu-item-classes' => 'btn-primary nav-cta', 'menu-item-position' => 5]);
    echo "✓ Primary menu created<br>";

    // Footer menus
    foreach (['Solutions' => 'footer-1', 'Company' => 'footer-2', 'Stay Connected' => 'footer-3'] as $name => $loc) {
        $menu = wp_get_nav_menu_object($name);
        $mid = $menu ? $menu->term_id : wp_create_nav_menu($name);
        $menu_locations[$loc] = $mid;
    }

    $f1 = $menu_locations['footer-1'];
    wp_update_nav_menu_item($f1, 0, ['menu-item-title' => 'For Ecommerce', 'menu-item-url' => home_url('/stretch-creative-solutions/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom']);
    wp_update_nav_menu_item($f1, 0, ['menu-item-title' => 'For Agencies', 'menu-item-url' => home_url('/stretch-creative-solutions/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom']);
    wp_update_nav_menu_item($f1, 0, ['menu-item-title' => 'For Publishers', 'menu-item-url' => home_url('/stretch-creative-solutions/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom']);

    $f2 = $menu_locations['footer-2'];
    wp_update_nav_menu_item($f2, 0, ['menu-item-title' => 'Our Story', 'menu-item-url' => home_url('/about-stretch-creative/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom']);
    wp_update_nav_menu_item($f2, 0, ['menu-item-title' => 'Our Team', 'menu-item-url' => home_url('/the-team/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom']);

    $f3 = $menu_locations['footer-3'];
    wp_update_nav_menu_item($f3, 0, ['menu-item-title' => 'Contact Us', 'menu-item-url' => home_url('/contact-stretch-creative/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom']);
    wp_update_nav_menu_item($f3, 0, ['menu-item-title' => 'Blog', 'menu-item-url' => home_url('/blog/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom']);

    set_theme_mod('nav_menu_locations', $menu_locations);
    echo "✓ Footer menus created<br>";

    echo '<br><strong style="color:#28c840;font-size:18px;">✓ Setup complete!</strong><br>';
    echo 'You can now <a href="' . home_url('/') . '" style="color:#8560A8;font-weight:600;">view your site</a>.<br>';
    echo '<br><strong style="color:#ff5f57;">Important:</strong> Delete the Setup Wizard page and remove <code>setup-wizard.php</code> from the theme when done.';
    echo '</div>';
} else {
    echo '<p style="font-size:16px;color:#323A51;line-height:1.6;">This will create all pages, blog posts, navigation menus, and import client logos for the Stretch Creative site.</p>';
    echo '<p style="font-size:14px;color:#999;">Make sure the Stretch Creative theme is active before running.</p>';
    echo '<a href="?run=setup" style="display:inline-block;background:#8560A8;color:#fff;padding:16px 36px;font-size:17px;font-family:Assistant,sans-serif;margin-top:20px;text-decoration:none;">Run Setup →</a>';
}

echo '</section>';
get_footer();
