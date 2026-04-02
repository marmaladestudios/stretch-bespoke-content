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

    require_once ABSPATH . 'wp-admin/includes/taxonomy.php';

    $cats = [];
    foreach (['Content Marketing', 'Ecommerce', 'SEO', 'AEO'] as $name) {
        $term = term_exists($name, 'category');
        if ($term) {
            $cats[$name] = is_array($term) ? $term['term_id'] : $term;
        } else {
            $result = wp_insert_term($name, 'category');
            if (is_wp_error($result)) {
                echo "✗ Category failed: {$name} — " . $result->get_error_message() . "<br>";
                $cats[$name] = 1; // fallback to Uncategorized
            } else {
                $cats[$name] = $result['term_id'];
            }
        }
        echo "✓ Category: {$name}<br>";
    }

    // Set AEO description
    if (isset($cats['AEO']) && $cats['AEO'] > 1) {
        wp_update_term(intval($cats['AEO']), 'category', ['description' => 'Answer Engine Optimization — strategies for getting your content cited by AI-powered search engines.']);
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

    echo '<br><strong style="color:#28c840;">Step 4 complete!</strong>';
    echo '<br><br><a href="?step=5" style="display:inline-block;background:#8560A8;color:#fff;padding:12px 28px;text-decoration:none;">Run Step 5: Team Photos →</a>';

} elseif ($step === 5) {
    // ── STEP 5: Team Photos ──
    echo '<strong>Step 5: Importing team photos...</strong><br>';

    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';

    $team = [
        ['Chris Reid', 'CEO', 'https://stretchcreative.co/wp-content/uploads/2023/09/Chris.jpeg'],
        ['Kelsi Carrell', 'Head of Operations', 'https://stretchcreative.co/wp-content/uploads/2020/11/Kelsi-e1641439041685.jpeg'],
        ['Jesse Galvon Reid', 'CPO', 'https://stretchcreative.co/wp-content/uploads/2020/09/Untitled-design-18-e1641438108530.png'],
        ['Kristen Bailey', 'Editor-In-Chief', 'https://stretchcreative.co/wp-content/uploads/2020/09/kristen0.png'],
        ['Josh Wong', 'Director of Video Content', 'https://stretchcreative.co/wp-content/uploads/2023/10/Josh-Wong-scaled.jpg'],
        ['Jeanine Gordon', 'Managing Editor', 'https://stretchcreative.co/wp-content/uploads/2023/09/Jeanine.jpeg'],
        ['Fiona Ferguson', 'Community & Recruitment', 'https://stretchcreative.co/wp-content/uploads/2023/01/Fiona.jpeg'],
        ['Kristyn Pacione', 'Client Services', 'https://stretchcreative.co/wp-content/uploads/2023/09/KP.jpeg'],
        ['MacKenzie Sanford', 'Editor + Resource Coordinator', 'https://stretchcreative.co/wp-content/uploads/2023/01/Mack.jpeg'],
        ['Jessica DeWolf', 'Lead Editor', 'https://stretchcreative.co/wp-content/uploads/2021/02/Untitled-design-22-e1641438472628.png'],
        ['Leslie Jeffries', 'Senior Copywriter', 'https://stretchcreative.co/wp-content/uploads/2020/09/Leslie-Jeffries.jpeg'],
        ['Jodi Noblett', 'Copywriter', 'https://stretchcreative.co/wp-content/uploads/2021/02/Untitled-design-33-e1641438356563.png'],
    ];

    $photo_map = [];
    foreach ($team as $member) {
        try {
            $slug = 'team-photo-' . sanitize_title($member[0]);
            $existing = get_posts(['post_type' => 'attachment', 'title' => $slug, 'numberposts' => 1]);
            if ($existing) { $photo_map[] = ['name' => $member[0], 'title' => $member[1], 'photo_id' => $existing[0]->ID, 'url' => wp_get_attachment_url($existing[0]->ID)]; echo "- Exists: {$member[0]}<br>"; continue; }
            $tmp = download_url($member[2], 30);
            if (is_wp_error($tmp)) { echo "✗ Failed: {$member[0]}<br>"; continue; }
            $ext = pathinfo(parse_url($member[2], PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
            $id = media_handle_sideload(['name' => $slug . '.' . $ext, 'tmp_name' => $tmp], 0, $slug);
            if (is_wp_error($id)) { @unlink($tmp); echo "✗ Error: {$member[0]}<br>"; continue; }
            $photo_map[] = ['name' => $member[0], 'title' => $member[1], 'photo_id' => $id, 'url' => wp_get_attachment_url($id)];
            echo "✓ {$member[0]}<br>";
        } catch (Exception $e) { echo "✗ Error: {$member[0]}<br>"; }
    }
    update_option('stretch_team_members', $photo_map);
    echo "✓ Saved " . count($photo_map) . " team members<br>";

    echo '<br><strong style="color:#28c840;">Step 5 complete!</strong>';
    echo '<br><br><a href="?step=6" style="display:inline-block;background:#8560A8;color:#fff;padding:12px 28px;text-decoration:none;">Run Step 6: Services & Author →</a>';

} elseif ($step === 6) {
    // ── STEP 6: Services, Author, Permalinks, Featured Images ──
    echo '<strong>Step 6: Setting up services, author, and permalinks...</strong><br>';

    // Permalinks
    update_option('permalink_structure', '/blog/%category%/%postname%/');
    delete_option('category_base');
    flush_rewrite_rules(true);
    echo "✓ Permalinks set to /blog/category/post<br>";

    // Merge AEO categories if duplicated
    $aeo = get_category_by_slug('aeo');
    $aeo_full = get_category_by_slug('answer-engine-optimization');
    if ($aeo && $aeo_full && $aeo->term_id !== $aeo_full->term_id) {
        $posts_in_old = get_posts(['cat' => $aeo_full->term_id, 'posts_per_page' => -1, 'fields' => 'ids']);
        foreach ($posts_in_old as $pid) {
            wp_remove_object_terms($pid, $aeo_full->term_id, 'category');
            wp_set_post_categories($pid, [$aeo->term_id], true);
        }
        wp_delete_term($aeo_full->term_id, 'category');
        echo "✓ Merged AEO categories<br>";
    }

    // Author setup
    $admin = get_user_by('login', 'admin');
    if ($admin) {
        wp_update_user([
            'ID' => $admin->ID,
            'first_name' => 'Cole',
            'last_name' => 'Vineyard',
            'display_name' => 'Cole Vineyard',
            'nickname' => 'Cole Vineyard',
            'description' => 'Cole Vineyard is the founder of Marmalade Studios and a digital strategist specializing in content-driven growth, SEO, and Answer Engine Optimization. With a background spanning creative direction, web development, and performance marketing, Cole helps brands build content ecosystems that rank, convert, and establish lasting authority.',
            'user_url' => 'https://www.linkedin.com/in/colevineyard/',
        ]);
        update_user_meta($admin->ID, 'linkedin', 'https://www.linkedin.com/in/colevineyard/');
        echo "✓ Author: Cole Vineyard<br>";

        // Assign author to all posts
        $posts = get_posts(['numberposts' => -1, 'post_type' => 'post', 'post_status' => 'publish']);
        foreach ($posts as $p) { wp_update_post(['ID' => $p->ID, 'post_author' => $admin->ID]); }
        echo "✓ All posts assigned to Cole Vineyard<br>";
    }

    // Service page content
    $service_file = ABSPATH . 'setup-services.php';
    if (file_exists($service_file)) {
        include $service_file;
        echo "✓ Service content populated<br>";
    } else {
        echo "- Service setup script not found (run manually)<br>";
    }

    // Blog post featured images
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';

    $blog_images = [
        'aeo-vs-seo' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&h=450&fit=crop',
        'structure-content-for-ai' => 'https://images.unsplash.com/photo-1504868584819-f8e8b4b6d7e3?w=800&h=450&fit=crop',
        'brand-visibility-crisis-aeo' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&h=450&fit=crop',
        '5-quick-wins-aeo' => 'https://images.unsplash.com/photo-1553877522-43269d4ea984?w=800&h=450&fit=crop',
    ];
    foreach ($blog_images as $slug => $url) {
        $post = null;
        $found = get_posts(['name' => $slug, 'post_type' => 'post', 'numberposts' => 1]);
        if ($found) $post = $found[0];
        if ($post && !has_post_thumbnail($post->ID)) {
            try {
                $tmp = download_url($url, 30);
                if (!is_wp_error($tmp)) {
                    $id = media_handle_sideload(['name' => 'blog-' . $slug . '.jpg', 'tmp_name' => $tmp], $post->ID, $slug);
                    if (!is_wp_error($id)) { set_post_thumbnail($post->ID, $id); echo "✓ Image: {$post->post_title}<br>"; }
                }
            } catch (Exception $e) { echo "✗ Image failed: {$slug}<br>"; }
        }
    }

    // Site title
    update_option('blogname', 'Stretch Creative');
    echo "✓ Site title set<br>";

    echo '<br><strong style="color:#28c840;font-size:18px;">✓ All setup complete!</strong>';
    echo '<br><br><a href="' . home_url('/') . '" style="display:inline-block;background:#8560A8;color:#fff;padding:12px 28px;text-decoration:none;font-weight:600;">View Your Site →</a>';
    echo '<br><br><em style="color:#999;">Remember to delete this Setup page and remove setup-wizard.php from the theme.</em>';

} else {
    echo '<p style="font-size:16px;color:#323A51;line-height:1.6;">This wizard sets up all content for the Stretch Creative site in 6 steps.</p>';
    echo '<p style="font-size:14px;color:#999;">Pages already created will be skipped.</p>';
    echo '<br><a href="?step=1" style="display:inline-block;background:#8560A8;color:#fff;padding:16px 36px;font-size:17px;text-decoration:none;">Start Setup: Step 1 →</a>';
}

echo '</div></section>';
get_footer();
