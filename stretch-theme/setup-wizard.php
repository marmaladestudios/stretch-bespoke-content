<?php
/**
 * Template Name: Setup Wizard
 * One-click content setup in steps. DELETE THIS FILE after setup is complete.
 */
if (!current_user_can('manage_options')) { wp_die('Access denied.'); }

@ini_set('max_execution_time', 300);
@set_time_limit(300);

get_header();
echo '<section style="padding:160px 40px 80px;max-width:800px;margin:0 auto;font-family:Poppins,sans-serif;">';
echo '<h1 style="font-size:32px;margin-bottom:24px;">Stretch Creative Setup Wizard</h1>';

$step = isset($_GET['step']) ? intval($_GET['step']) : 0;

echo '<div style="background:#f9f9fb;padding:24px;margin-bottom:24px;font-size:14px;line-height:2;">';

if ($step === 1) {
    // ── STEP 1: Pages & Settings ──
    echo '<strong>Step 1: Creating pages...</strong><br>';

    update_option('permalink_structure', '/%postname%/');
    flush_rewrite_rules();
    echo '✓ Permalinks set<br>';

    $home = get_page_by_path('home');
    if (!$home) { $home_id = wp_insert_post(['post_title' => 'Home', 'post_name' => 'home', 'post_type' => 'page', 'post_status' => 'publish']); }
    else { $home_id = $home->ID; }
    update_post_meta($home_id, '_wp_page_template', 'front-page-v2.php');
    update_option('show_on_front', 'page');
    update_option('page_on_front', $home_id);
    echo "✓ Homepage created<br>";

    $blog = get_page_by_path('blog');
    if (!$blog) { $blog_id = wp_insert_post(['post_title' => 'Blog', 'post_name' => 'blog', 'post_type' => 'page', 'post_status' => 'publish']); }
    else { $blog_id = $blog->ID; }
    update_post_meta($blog_id, '_wp_page_template', 'page-blog-home.php');
    update_option('page_for_posts', $blog_id);
    echo "✓ Blog page created<br>";

    $pages = [
        ['Our Story', 'about-stretch-creative', 'page-about.php'],
        ['Our Team', 'the-team', 'page-team.php'],
        ['Solutions', 'stretch-creative-solutions', 'page-solutions.php'],
        ['Contact Stretch Creative', 'contact-stretch-creative', 'page-contact.php'],
    ];
    foreach ($pages as $p) {
        $ex = get_page_by_path($p[1]);
        $pid = $ex ? $ex->ID : wp_insert_post(['post_title' => $p[0], 'post_name' => $p[1], 'post_type' => 'page', 'post_status' => 'publish']);
        update_post_meta($pid, '_wp_page_template', $p[2]);
        echo "✓ {$p[0]}<br>";
    }

    echo '<br><strong style="color:#28c840;">Step 1 complete!</strong>';
    echo '<br><br><a href="?step=2" style="display:inline-block;background:#8560A8;color:#fff;padding:12px 28px;text-decoration:none;">Run Step 2: Blog Posts →</a>';

} elseif ($step === 2) {
    // ── STEP 2: Categories & Posts ──
    echo '<strong>Step 2: Creating categories & posts...</strong><br>';

    $cats = [];
    foreach (['Content Marketing', 'Ecommerce', 'SEO', 'AEO'] as $name) {
        $term = term_exists($name, 'category');
        if ($term) { $cats[$name] = $term['term_id']; }
        else { $cats[$name] = wp_create_category($name); }
        echo "✓ Category: {$name}<br>";
    }

    // Set AEO description
    if (isset($cats['AEO'])) {
        wp_update_term($cats['AEO'], 'category', ['description' => 'Answer Engine Optimization — strategies for getting your content cited by AI-powered search engines.']);
    }

    $posts = [
        ['7 Things You Need to Know for Successful Content Marketing', 'content-marketing-tips', $cats['Content Marketing']],
        ['How Ecommerce Brands Can Win with SEO Content', 'ecommerce-seo-content', $cats['Ecommerce']],
        ['The Complete Guide to Building a Content Team at Scale', 'building-content-team', $cats['Content Marketing']],
        ['What Is Answer Engine Optimization (AEO) and Why It Matters', 'what-is-aeo', $cats['AEO']],
        ['AEO vs SEO: Understanding the Key Differences', 'aeo-vs-seo', $cats['AEO']],
        ['How to Structure Content for AI Answer Engines', 'structure-content-ai', $cats['AEO']],
    ];

    $content = '<p>The content landscape is undergoing its biggest transformation in years. Brands that adapt now will capture visibility in channels growing exponentially.</p><h2>Why This Matters</h2><p>Search engines, AI answer engines, and social platforms all reward content that is authoritative, well-structured, and genuinely helpful. The era of thin, keyword-stuffed content is over.</p><blockquote>The brands that will dominate are the ones investing in quality content today — not tomorrow.</blockquote><h2>What You Can Do</h2><p>Start by auditing your existing content. Is it structured for both humans and machines? Does it provide definitive answers? The fundamentals remain: be authoritative, be helpful, be clear.</p>';

    foreach ($posts as $p) {
        $ex = get_page_by_path($p[1], OBJECT, 'post');
        if (!$ex) {
            wp_insert_post([
                'post_title' => $p[0], 'post_name' => $p[1],
                'post_content' => '<p>' . $p[0] . ' — an in-depth look at what matters most.</p>' . $content,
                'post_status' => 'publish', 'post_type' => 'post', 'post_category' => [$p[2]],
            ]);
            echo "✓ Post: {$p[0]}<br>";
        } else {
            echo "- Exists: {$p[0]}<br>";
        }
    }

    echo '<br><strong style="color:#28c840;">Step 2 complete!</strong>';
    echo '<br><br><a href="?step=3" style="display:inline-block;background:#8560A8;color:#fff;padding:12px 28px;text-decoration:none;">Run Step 3: Logos →</a>';

} elseif ($step === 3) {
    // ── STEP 3: Client Logos ──
    echo '<strong>Step 3: Importing client logos...</strong><br>';

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

    $imported = [];
    foreach ($logos as $name => $url) {
        try {
            $existing = get_posts(['post_type' => 'attachment', 'title' => 'logo-' . sanitize_title($name), 'numberposts' => 1]);
            if ($existing) { $imported[$name] = $existing[0]->ID; echo "- Exists: {$name}<br>"; continue; }

            $tmp = download_url($url, 30);
            if (is_wp_error($tmp)) { echo "✗ Failed: {$name}<br>"; continue; }
            $ext = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'png';
            $id = media_handle_sideload(['name' => 'logo-' . sanitize_title($name) . '.' . $ext, 'tmp_name' => $tmp], 0, 'logo-' . sanitize_title($name));
            if (is_wp_error($id)) { @unlink($tmp); echo "✗ Failed: {$name}<br>"; continue; }
            $imported[$name] = $id;
            echo "✓ {$name}<br>";
        } catch (Exception $e) {
            echo "✗ Error: {$name}<br>";
        }
    }
    update_option('stretch_client_logos', $imported);
    echo "✓ Saved " . count($imported) . " logos<br>";

    echo '<br><strong style="color:#28c840;">Step 3 complete!</strong>';
    echo '<br><br><a href="?step=4" style="display:inline-block;background:#8560A8;color:#fff;padding:12px 28px;text-decoration:none;">Run Step 4: Menus →</a>';

} elseif ($step === 4) {
    // ── STEP 4: Navigation Menus ──
    echo '<strong>Step 4: Setting up menus...</strong><br>';

    $menu_locations = [];

    $primary = wp_get_nav_menu_object('Primary');
    $primary_id = $primary ? $primary->term_id : wp_create_nav_menu('Primary');
    $menu_locations['primary'] = $primary_id;

    $items = wp_get_nav_menu_items($primary_id);
    if ($items) foreach ($items as $item) wp_delete_post($item->ID, true);

    wp_update_nav_menu_item($primary_id, 0, ['menu-item-title' => 'Solutions', 'menu-item-url' => home_url('/stretch-creative-solutions/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom']);
    wp_update_nav_menu_item($primary_id, 0, ['menu-item-title' => 'Our Story', 'menu-item-url' => home_url('/about-stretch-creative/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom']);
    wp_update_nav_menu_item($primary_id, 0, ['menu-item-title' => 'Our Team', 'menu-item-url' => home_url('/the-team/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom']);
    wp_update_nav_menu_item($primary_id, 0, ['menu-item-title' => 'Blog', 'menu-item-url' => home_url('/blog/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom']);
    wp_update_nav_menu_item($primary_id, 0, ['menu-item-title' => 'Contact Us', 'menu-item-url' => home_url('/contact-stretch-creative/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom', 'menu-item-classes' => 'btn-primary nav-cta']);
    echo "✓ Primary menu<br>";

    foreach (['Solutions' => 'footer-1', 'Company' => 'footer-2', 'Stay Connected' => 'footer-3'] as $name => $loc) {
        $menu = wp_get_nav_menu_object($name);
        $mid = $menu ? $menu->term_id : wp_create_nav_menu($name);
        $menu_locations[$loc] = $mid;
    }

    wp_update_nav_menu_item($menu_locations['footer-1'], 0, ['menu-item-title' => 'Ecommerce', 'menu-item-url' => home_url('/stretch-creative-solutions/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom']);
    wp_update_nav_menu_item($menu_locations['footer-1'], 0, ['menu-item-title' => 'Agencies', 'menu-item-url' => home_url('/stretch-creative-solutions/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom']);
    wp_update_nav_menu_item($menu_locations['footer-1'], 0, ['menu-item-title' => 'Publishers', 'menu-item-url' => home_url('/stretch-creative-solutions/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom']);

    wp_update_nav_menu_item($menu_locations['footer-2'], 0, ['menu-item-title' => 'Our Story', 'menu-item-url' => home_url('/about-stretch-creative/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom']);
    wp_update_nav_menu_item($menu_locations['footer-2'], 0, ['menu-item-title' => 'Our Team', 'menu-item-url' => home_url('/the-team/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom']);

    wp_update_nav_menu_item($menu_locations['footer-3'], 0, ['menu-item-title' => 'Contact Us', 'menu-item-url' => home_url('/contact-stretch-creative/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom']);
    wp_update_nav_menu_item($menu_locations['footer-3'], 0, ['menu-item-title' => 'Blog', 'menu-item-url' => home_url('/blog/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom']);

    set_theme_mod('nav_menu_locations', $menu_locations);
    echo "✓ Footer menus<br>";

    echo '<br><strong style="color:#28c840;font-size:18px;">✓ All setup complete!</strong>';
    echo '<br><br><a href="' . home_url('/') . '" style="display:inline-block;background:#8560A8;color:#fff;padding:12px 28px;text-decoration:none;font-weight:600;">View Your Site →</a>';
    echo '<br><br><em style="color:#999;">Remember to delete this Setup page and remove setup-wizard.php from the theme.</em>';

} else {
    echo '<p style="font-size:16px;color:#323A51;line-height:1.6;">This wizard sets up all content for the Stretch Creative site in 4 steps.</p>';
    echo '<p style="font-size:14px;color:#999;">Pages already created in Step 1 will be skipped.</p>';
    echo '<br><a href="?step=1" style="display:inline-block;background:#8560A8;color:#fff;padding:16px 36px;font-size:17px;text-decoration:none;">Start Setup: Step 1 →</a>';
}

echo '</div></section>';
get_footer();
