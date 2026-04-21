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

    // Services parent page (landing hub for /services/{slug}/ children)
    $services = get_page_by_path('services');
    $services_id = $services ? $services->ID : wp_insert_post([
        'post_title'  => 'Services',
        'post_name'   => 'services',
        'post_type'   => 'page',
        'post_status' => 'publish',
    ]);
    echo "✓ Services parent page<br>";

    // Bespoke Content Experience — nested under /services/
    $bce = get_page_by_path('services/bespoke-content-experience') ?: get_page_by_path('bespoke-content-experience');
    if ($bce) {
        $bce_id = $bce->ID;
        wp_update_post(['ID' => $bce_id, 'post_parent' => $services_id]);
    } else {
        $bce_id = wp_insert_post([
            'post_title'  => 'Bespoke Content Experience',
            'post_name'   => 'bespoke-content-experience',
            'post_type'   => 'page',
            'post_status' => 'publish',
            'post_parent' => $services_id,
        ]);
    }
    update_post_meta($bce_id, '_wp_page_template', 'page-bespoke-content-experience.php');
    echo "✓ Bespoke Content Experience (under /services/)<br>";

    // Our Work (portfolio) page
    $our_work = get_page_by_path('our-work');
    $our_work_id = $our_work ? $our_work->ID : wp_insert_post([
        'post_title'  => 'Our Work',
        'post_name'   => 'our-work',
        'post_type'   => 'page',
        'post_status' => 'publish',
    ]);
    update_post_meta($our_work_id, '_wp_page_template', 'page-portfolio.php');
    echo "✓ Our Work page<br>";

    // Pricing page
    $pricing = get_page_by_path('pricing');
    $pricing_id = $pricing ? $pricing->ID : wp_insert_post([
        'post_title'  => 'Pricing',
        'post_name'   => 'pricing',
        'post_type'   => 'page',
        'post_status' => 'publish',
    ]);
    update_post_meta($pricing_id, '_wp_page_template', 'page-pricing.php');
    echo "✓ Pricing page<br>";

    echo '<br><strong style="color:#28c840;">Step 1 complete!</strong>';
    echo '<br><br><a href="?step=2" style="display:inline-block;background:#8560A8;color:#fff;padding:12px 28px;text-decoration:none;">Run Step 2: Blog Posts →</a>';

} elseif ($step === 2) {
    // ── STEP 2: Categories & Posts ──
    echo '<strong>Step 2: Creating categories & posts...</strong><br>';

    require_once ABSPATH . 'wp-admin/includes/taxonomy.php';

    $cats = [];
    $category_defs = [
        'AEO'               => 'Answer Engine Optimization — strategies and insights for getting your content cited by AI-powered search engines like ChatGPT, Gemini, and Perplexity.',
        'Content Marketing' => 'Strategy, storytelling, and the craft of content that compounds over time.',
        'SEO'               => 'Technical audits, ranking strategies, and SEO that stands up to Google updates.',
        'Ecommerce'         => 'Content and optimization strategies built for online retail.',
        'Generative AI'     => 'How AI is reshaping content creation, research, and brand discovery.',
        'Video Content'     => 'Video marketing, YouTube SEO, and visual storytelling that converts.',
        'Creative Dojo'     => 'Behind-the-scenes dispatches from the Stretch Creative studio.',
    ];
    foreach ($category_defs as $name => $description) {
        $term = term_exists($name, 'category');
        if ($term) {
            $cats[$name] = is_array($term) ? $term['term_id'] : $term;
            // Update description if empty
            $existing = get_term($cats[$name], 'category');
            if ($existing && empty($existing->description)) {
                wp_update_term($cats[$name], 'category', ['description' => $description]);
            }
        } else {
            $result = wp_insert_term($name, 'category', ['description' => $description]);
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

    // Top-level: Solutions
    $solutions_item_id = wp_update_nav_menu_item($primary_id, 0, ['menu-item-title' => 'Solutions', 'menu-item-url' => home_url('/stretch-creative-solutions/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom']);

    // Solutions children (in display order)
    $sol_children = [
        ['Bespoke Content Experience', 'services/bespoke-content-experience', 'bespoke-content-experience'],
        ['Content Writing',             'content-writing-at-any-scale',        null],
        ['Content Strategy',            'content-strategy',                    null],
        ['SEO Strategy & Services',     'seo_content_strategy_services',       null],
        ['Paid Advertising',            'paid-advertising',                    null],
        ['Graphic Design',              'graphic_design_services',             null],
        ['Video & Photography',         'video-content-services',              null],
    ];
    foreach ($sol_children as $child) {
        [$title, $primary_slug, $fallback_slug] = $child;
        $child_page = get_page_by_path($primary_slug) ?: ($fallback_slug ? get_page_by_path($fallback_slug) : null);
        if ($child_page) {
            wp_update_nav_menu_item($primary_id, 0, [
                'menu-item-title'     => $title,
                'menu-item-object'    => 'page',
                'menu-item-object-id' => $child_page->ID,
                'menu-item-type'      => 'post_type',
                'menu-item-parent-id' => $solutions_item_id,
                'menu-item-status'    => 'publish',
            ]);
        } else {
            echo "- Skipped nav child (page missing): {$title}<br>";
        }
    }

    // Top-level items
    wp_update_nav_menu_item($primary_id, 0, ['menu-item-title' => 'Our Story', 'menu-item-url' => home_url('/about-stretch-creative/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom']);
    wp_update_nav_menu_item($primary_id, 0, ['menu-item-title' => 'Our Team', 'menu-item-url' => home_url('/the-team/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom']);

    // Our Work — link to page if it exists
    $our_work_page = get_page_by_path('our-work');
    if ($our_work_page) {
        wp_update_nav_menu_item($primary_id, 0, [
            'menu-item-title'     => 'Our Work',
            'menu-item-object'    => 'page',
            'menu-item-object-id' => $our_work_page->ID,
            'menu-item-type'      => 'post_type',
            'menu-item-status'    => 'publish',
        ]);
    } else {
        wp_update_nav_menu_item($primary_id, 0, ['menu-item-title' => 'Our Work', 'menu-item-url' => home_url('/our-work/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom']);
    }

    wp_update_nav_menu_item($primary_id, 0, ['menu-item-title' => 'Blog', 'menu-item-url' => home_url('/blog/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom']);
    wp_update_nav_menu_item($primary_id, 0, ['menu-item-title' => 'Contact Us', 'menu-item-url' => home_url('/contact-stretch-creative/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom', 'menu-item-classes' => 'btn-primary nav-cta']);
    echo "✓ Primary menu (Solutions dropdown + Our Work + Blog + Contact)<br>";

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

    echo '<br><strong style="color:#28c840;">Step 6 complete!</strong>';
    echo '<br><br><a href="?step=7" style="display:inline-block;background:#8560A8;color:#fff;padding:12px 28px;text-decoration:none;">Run Step 7: Demo AEO Post →</a>';

} elseif ($step === 7) {
    // ── STEP 7: Rich Demo AEO Post ──
    echo '<strong>Step 7: Creating demo AEO post...</strong><br>';

    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';
    require_once ABSPATH . 'wp-admin/includes/taxonomy.php';

    // Get or create AEO category
    $aeo_cat = get_category_by_slug('aeo');
    if (!$aeo_cat) {
        $result = wp_insert_term('AEO', 'category', ['description' => 'Answer Engine Optimization — strategies for getting your content cited by AI-powered search engines.']);
        $aeo_cat_id = is_array($result) ? $result['term_id'] : 0;
    } else {
        $aeo_cat_id = $aeo_cat->term_id;
    }
    echo "✓ AEO category ready<br>";

    // Check if post exists
    $existing = get_posts(['name' => 'the-complete-guide-to-answer-engine-optimization-aeo-in-2026', 'post_type' => 'post', 'numberposts' => 1]);
    if ($existing) {
        echo "- Demo post already exists<br>";
    } else {
        $post_content = '<p>The search landscape is undergoing its most significant transformation in over two decades. As AI-powered answer engines like ChatGPT, Google\'s AI Overviews, Perplexity, and Claude reshape how people find information, a new discipline has emerged: Answer Engine Optimization (AEO). For brands that depend on organic visibility, understanding and implementing AEO isn\'t optional — it\'s existential. This guide breaks down everything you need to know to position your brand for the AI-driven search era.</p>

<h2>What Is Answer Engine Optimization?</h2>

<p>Answer Engine Optimization is the practice of structuring your content, brand signals, and digital presence so that AI-powered answer engines cite, reference, and recommend your brand when responding to user queries. Unlike traditional SEO, which focuses on ranking in a list of blue links, AEO focuses on becoming the source that AI systems trust and surface in their generated responses.</p>

<p>Think of it this way: when someone asks ChatGPT "What\'s the best approach to content strategy for SaaS companies?" — the brands that appear in that answer didn\'t get there by accident. They got there because their content was structured, authoritative, and optimized in ways that AI models recognize and prefer.</p>

<figure><img src="https://images.unsplash.com/photo-1677442136019-21780ecad995?w=800&h=450&fit=crop" alt="AI search"><figcaption>AI-powered search engines are reshaping how content is discovered.</figcaption></figure>

<h2>AEO vs Traditional SEO</h2>

<table>
<thead><tr><th></th><th>Traditional SEO</th><th>AEO</th></tr></thead>
<tbody>
<tr><td>Goal</td><td>Rank on page 1</td><td>Get cited in AI answers</td></tr>
<tr><td>Format</td><td>Keywords in content</td><td>Structured, definitive answers</td></tr>
<tr><td>Signals</td><td>Backlinks, authority</td><td>Expertise, clarity, structure</td></tr>
<tr><td>Result</td><td>Click to website</td><td>Brand mention in AI response</td></tr>
<tr><td>Measurement</td><td>Rankings, traffic</td><td>Citations, brand visibility</td></tr>
</tbody>
</table>

<blockquote class="pullquote"><p>The brands that will dominate the next decade of search are the ones optimizing for AI answer engines today — not tomorrow.</p></blockquote>

<h2>How AI Answer Engines Work</h2>

<p>To optimize for answer engines, you first need to understand how they select and synthesize sources. Models like GPT-4, Gemini, and Claude are trained on vast corpora of web content, but they also use retrieval-augmented generation (RAG) to pull in real-time information. When a user asks a question, the AI doesn\'t just recall memorized data — it actively searches, evaluates, and synthesizes information from multiple sources to generate a comprehensive response.</p>

<p>The selection process favors content that demonstrates clear expertise, provides definitive answers, and is structured in ways that AI systems can easily parse. This means your content needs to be more than just "good" — it needs to be optimally structured for machine comprehension while remaining genuinely valuable for human readers.</p>

<h2>7 Key AEO Strategies</h2>

<h3>1. Structure Content with Clear Headings and Definitive Statements</h3>
<p>AI models parse content hierarchically. Clear H2/H3 heading structures, concise topic sentences, and definitive statements make your content easier for AI to understand and cite. Avoid burying key information in long paragraphs — lead with the answer.</p>

<h3>2. Lead with the Answer, Then Explain</h3>
<p>The inverted pyramid isn\'t just for journalism anymore. When addressing a question, state your answer clearly in the first sentence, then provide supporting context, evidence, and nuance. This mirrors how AI systems extract and present information.</p>

<h3>3. Use Schema Markup and Structured Data</h3>
<p>Schema markup helps AI understand the context and relationships within your content. FAQ schema, HowTo schema, and Article schema all provide machine-readable signals that can increase your content\'s visibility in AI-generated responses.</p>

<h3>4. Build Topical Authority Through Content Clusters</h3>
<p>AI systems evaluate not just individual pages but your brand\'s overall authority on a topic. Build comprehensive content clusters that comprehensively cover your core topics. A pillar page supported by dozens of detailed subtopic pages signals to AI that your brand is a genuine authority on the subject.</p>

<figure><img src="https://images.unsplash.com/photo-1504868584819-f8e8b4b6d7e3?w=800&h=400&fit=crop" alt="Data analytics"><figcaption>Data-driven content strategies are essential for AEO success.</figcaption></figure>

<h3>5. Optimize for Featured Snippets — The Bridge to AEO</h3>
<p>Featured snippets remain a critical bridge between traditional SEO and AEO. Content that earns featured snippets demonstrates exactly the qualities that AI answer engines look for: clear structure, definitive answers, and authoritative sourcing.</p>

<h3>6. Create Original Research and Data</h3>
<p>AI models heavily favor original data, unique research findings, and proprietary insights. When your content includes statistics, survey results, or analysis that can\'t be found elsewhere, AI systems are more likely to cite your brand as the authoritative source.</p>

<h3>7. Maintain E-E-A-T Signals</h3>
<p>Experience, Expertise, Authoritativeness, and Trustworthiness (E-E-A-T) are not just Google\'s quality guidelines — they\'re the fundamental attributes that AI systems evaluate when choosing which sources to cite. Ensure your content clearly demonstrates first-hand experience, features expert authors with verifiable credentials, is published on an authoritative domain, and maintains consistent accuracy and trustworthiness.</p>

<hr>

<h2>Measuring AEO Success</h2>

<p>Traditional SEO metrics like rankings and organic traffic remain important, but AEO introduces new dimensions of measurement. Brand radar tools can track how often your brand is mentioned in AI-generated responses. Citation tracking monitors which of your content pieces are being referenced by AI systems.</p>

<p>The most forward-thinking brands are already building dashboards that combine traditional SEO metrics with AEO-specific measurements: AI citation frequency, brand mention sentiment in AI responses, and share of voice in AI-generated answers for their target topics.</p>

<h2>Getting Started with AEO</h2>

<p>The good news is that AEO and SEO are complementary, not competing strategies. Many of the fundamentals overlap: create authoritative content, structure it clearly, build topical depth, and maintain strong E-E-A-T signals. The key additions for AEO are the emphasis on definitive statements, machine-readable structure, and original insights that AI systems can\'t find elsewhere.</p>

<blockquote class="pullquote"><p>AEO isn\'t replacing SEO — it\'s the next layer. The brands that master both will own the future of organic visibility.</p></blockquote>';

        $admin = get_user_by('login', 'admin');
        $post_id = wp_insert_post([
            'post_title' => 'The Complete Guide to Answer Engine Optimization (AEO) in 2026',
            'post_name' => 'the-complete-guide-to-answer-engine-optimization-aeo-in-2026',
            'post_content' => $post_content,
            'post_status' => 'publish',
            'post_type' => 'post',
            'post_category' => [$aeo_cat_id],
            'post_author' => $admin ? $admin->ID : 1,
        ]);
        echo "✓ Created demo post (ID: {$post_id})<br>";

        // Featured image
        try {
            $tmp = download_url('https://images.unsplash.com/photo-1620712943543-bcc4688e7485?w=1200&h=630&fit=crop', 30);
            if (!is_wp_error($tmp)) {
                $img_id = media_handle_sideload(['name' => 'aeo-guide-featured.jpg', 'tmp_name' => $tmp], $post_id, 'AEO Guide Featured Image');
                if (!is_wp_error($img_id)) {
                    set_post_thumbnail($post_id, $img_id);
                    echo "✓ Featured image set<br>";
                }
            }
        } catch (Exception $e) { echo "✗ Featured image failed<br>"; }
    }

    echo '<br><strong style="color:#28c840;">Step 7 complete!</strong>';
    echo '<br><br><a href="?step=8" style="display:inline-block;background:#8560A8;color:#fff;padding:12px 28px;text-decoration:none;">Run Step 8: AEO Hub Pillar →</a>';

} elseif ($step === 8) {
    // ── STEP 8: AEO Hub Pillar Content ──
    echo '<strong>Step 8: Populating AEO hub pillar content...</strong><br>';

    $aeo_hub_file = get_template_directory() . '/setup-aeo-hub.php';
    if (!file_exists($aeo_hub_file)) {
        echo "✗ setup-aeo-hub.php not found in theme<br>";
    } else {
        // setup-aeo-hub.php declares $aeo_hub and calls update_option at the end.
        // Loading it here runs that same code.
        $existing = get_option('stretch_hub_aeo');
        include $aeo_hub_file;
        $after = get_option('stretch_hub_aeo');
        if ($after && !empty($after['headline'])) {
            echo "✓ AEO hub content saved (" . count($after['sections'] ?? []) . " sections)<br>";
        } else {
            echo "✗ AEO hub option is empty — check setup-aeo-hub.php<br>";
        }
    }

    echo '<br><strong style="color:#28c840;">Step 8 complete!</strong>';
    echo '<br><br><a href="?step=9" style="display:inline-block;background:#8560A8;color:#fff;padding:12px 28px;text-decoration:none;">Run Step 9: Seed Blog Posts →</a>';

} elseif ($step === 9) {
    // ── STEP 9: Seed Blog Posts from data/blog-posts.json (batched to avoid timeout) ──

    // Disable output buffering / gzip so the user sees progress in real time
    @ini_set('zlib.output_compression', 'Off');
    @ini_set('output_buffering', 'Off');
    @ini_set('implicit_flush', 1);
    while (ob_get_level()) { ob_end_flush(); }
    header('X-Accel-Buffering: no');
    header('Content-Encoding: identity');

    @ini_set('max_execution_time', 120);
    @set_time_limit(120);

    $batch_size   = 8; // posts per request; Render kills long-running HTTP requests
    $skip_thumbs  = isset($_GET['skip_thumbs']) && $_GET['skip_thumbs'] === '1';
    $batch        = isset($_GET['batch']) ? max(0, intval($_GET['batch'])) : 0;

    echo '<strong>Step 9: Seeding blog posts (batch ' . ($batch + 1) . ')</strong><br>';
    flush();

    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';

    $json_path = get_template_directory() . '/data/blog-posts.json';
    if (!file_exists($json_path)) {
        echo "✗ data/blog-posts.json not found<br>";
    } else {
        $posts_data = json_decode(file_get_contents($json_path), true);
        if (!is_array($posts_data)) {
            echo "✗ Failed to parse blog-posts.json<br>";
        } else {
            $total      = count($posts_data);
            $start      = $batch * $batch_size;
            $end        = min($start + $batch_size, $total);
            $slice      = array_slice($posts_data, $start, $batch_size);

            echo "Processing posts {$start}–" . ($end - 1) . " of {$total}" . ($skip_thumbs ? ' (skip thumbs)' : '') . "<br><br>";
            flush();

            // Preload category term IDs
            $cat_ids = [];
            foreach (get_categories(['hide_empty' => false]) as $c) { $cat_ids[$c->slug] = $c->term_id; }

            // Default author: first admin user
            $admins = get_users(['role' => 'administrator', 'number' => 1]);
            $default_author = $admins ? $admins[0]->ID : 1;

            $uploads_base_url = rtrim(home_url('/'), '/');

            $created = 0; $skipped = 0; $thumbs_ok = 0; $thumbs_fail = 0;

            $thumbs_dir = get_template_directory() . '/data/thumbs';

            foreach ($slice as $pd) {
                if (empty($pd['slug']) || empty($pd['title'])) continue;

                $existing = get_page_by_path($pd['slug'], OBJECT, 'post');
                $post_id  = 0;
                $is_new   = false;

                if ($existing) {
                    $post_id = $existing->ID;
                    if (get_post_thumbnail_id($post_id) || $skip_thumbs) {
                        $skipped++;
                        echo "- Exists: {$pd['slug']}<br>"; flush();
                        continue;
                    }
                    echo "→ Backfilling thumb: {$pd['slug']}<br>"; flush();
                } else {
                    $cat_term_ids = [];
                    foreach (($pd['categories'] ?? []) as $cat_slug) {
                        if (isset($cat_ids[$cat_slug])) $cat_term_ids[] = $cat_ids[$cat_slug];
                    }

                    $post_id = wp_insert_post([
                        'post_title'    => $pd['title'],
                        'post_name'     => $pd['slug'],
                        'post_content'  => $pd['content'] ?? '',
                        'post_excerpt'  => $pd['excerpt'] ?? '',
                        'post_status'   => $pd['status'] ?? 'publish',
                        'post_type'     => 'post',
                        'post_date_gmt' => $pd['date'] ?? current_time('mysql', 1),
                        'post_author'   => $default_author,
                        'post_category' => $cat_term_ids,
                    ]);

                    if (is_wp_error($post_id) || !$post_id) {
                        echo "✗ Failed: {$pd['slug']}<br>"; flush();
                        continue;
                    }

                    if (!empty($pd['tags'])) wp_set_post_tags($post_id, $pd['tags']);
                    $is_new = true;
                    $created++;
                }

                // Thumbnail handling — local WebP first, then source URL fallback
                if (!$skip_thumbs) {
                    $got_thumb = false;

                    // 1. Try bundled local WebP (fastest, always works)
                    $local_thumb = $thumbs_dir . '/' . $pd['slug'] . '.webp';
                    if (file_exists($local_thumb)) {
                        $tmp = wp_tempnam($pd['slug'] . '.webp');
                        if ($tmp && copy($local_thumb, $tmp)) {
                            $name = sanitize_title($pd['slug']) . '.webp';
                            $att_id = media_handle_sideload(['name' => $name, 'tmp_name' => $tmp], $post_id);
                            if (!is_wp_error($att_id)) {
                                set_post_thumbnail($post_id, $att_id);
                                $got_thumb = true;
                                $thumbs_ok++;
                            } else {
                                @unlink($tmp);
                            }
                        }
                    }

                    // 2. Fallback to thumb_source URL if we have one and local missed
                    if (!$got_thumb && !empty($pd['thumb_source'])) {
                        $url = $pd['thumb_source'];
                        $tmp = download_url($url, 6);
                        if (!is_wp_error($tmp)) {
                            $ext = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
                            $name = sanitize_title($pd['slug']) . '.' . $ext;
                            $att_id = media_handle_sideload(['name' => $name, 'tmp_name' => $tmp], $post_id);
                            if (!is_wp_error($att_id)) {
                                set_post_thumbnail($post_id, $att_id);
                                $got_thumb = true;
                                $thumbs_ok++;
                            } else {
                                @unlink($tmp);
                            }
                        }
                    }

                    if (!$got_thumb) $thumbs_fail++;
                }

                echo ($is_new ? '✓' : '★') . ' ' . $pd['slug'] . '<br>';
                flush();
            }

            echo "<br><strong>Batch summary:</strong> {$created} created · {$skipped} skipped · {$thumbs_ok} thumbs · {$thumbs_fail} thumb fails<br>";
            flush();

            $next_batch = $batch + 1;
            $more = ($next_batch * $batch_size) < $total;

            if ($more) {
                $next_url = '?step=9&batch=' . $next_batch . ($skip_thumbs ? '&skip_thumbs=1' : '');
                echo '<br><a href="' . esc_url($next_url) . '" id="nextBatch" style="display:inline-block;background:#8560A8;color:#fff;padding:12px 28px;text-decoration:none;">Continue: Batch ' . ($next_batch + 1) . ' →</a>';
                echo '<br><br><em style="color:#999;">Auto-advancing in 2 seconds…</em>';
                echo '<script>setTimeout(function(){ window.location.href = ' . json_encode($next_url) . '; }, 2000);</script>';
            } else {
                echo '<br><strong style="color:#28c840;font-size:18px;">✓ All posts seeded!</strong>';
                echo '<br><br><a href="' . home_url('/blog/') . '" style="display:inline-block;background:#8560A8;color:#fff;padding:12px 28px;text-decoration:none;font-weight:600;">View Blog →</a>';
                echo '<br><br><em style="color:#999;">Remember to delete the Setup page and remove setup-wizard.php from the theme.</em>';
            }
        }
    }

} else {
    echo '<p style="font-size:16px;color:#323A51;line-height:1.6;">This wizard sets up all content for the Stretch Creative site in 9 steps.</p>';
    echo '<p style="font-size:14px;color:#999;">Pages already created will be skipped.</p>';
    echo '<br><a href="?step=1" style="display:inline-block;background:#8560A8;color:#fff;padding:16px 36px;font-size:17px;text-decoration:none;">Start Setup: Step 1 →</a>';
}

echo '</div></section>';
get_footer();
