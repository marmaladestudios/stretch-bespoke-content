<?php
/**
 * Idempotent nav + footer menu builder (redesign Phase 4, per copy-doc site map).
 * Run: wp eval-file setup-menus.php
 *
 * Footer locations: theme registers exactly three (footer-1, footer-2, footer-3;
 * see inc/theme-setup.php register_nav_menus + footer.php columns), which maps
 * 1:1 onto the site map's three footer groupings — no new location needed.
 */
if (!defined('WP_CLI') || !WP_CLI) { exit; }

function stretch_menu_rebuild($menu_name, $location, array $items) {
    $existing = wp_get_nav_menu_object($menu_name);
    if ($existing) {
        // Rebuild from scratch each run — the definition below is the source of truth.
        $old = wp_get_nav_menu_items($existing->term_id) ?: [];
        foreach ($old as $item) { wp_delete_post($item->ID, true); }
        $menu_id = $existing->term_id;
    } else {
        $menu_id = wp_create_nav_menu($menu_name);
    }
    if (is_wp_error($menu_id)) { WP_CLI::error("Menu {$menu_name}: " . $menu_id->get_error_message()); }

    $add = function ($menu_id, $title, $url, $parent = 0, $classes = '') {
        $result = wp_update_nav_menu_item($menu_id, 0, [
            'menu-item-title'     => $title,
            'menu-item-url'       => home_url($url),
            'menu-item-status'    => 'publish',
            'menu-item-parent-id' => $parent,
            'menu-item-classes'   => $classes, // space-separated CSS classes (e.g. nav-cta button)
        ]);
        if (is_wp_error($result)) {
            WP_CLI::error("Menu {$menu_id}: failed to add {$title}: " . $result->get_error_message());
        }
        if (!(int) $result) {
            WP_CLI::error("Menu {$menu_id}: failed to add {$title} (no item ID returned).");
        }
        return (int) $result;
    };
    $expected_count = 0;
    foreach ($items as $item) {
        $parent_id = $add($menu_id, $item['title'], $item['url'], 0, $item['classes'] ?? '');
        $expected_count++;
        foreach ($item['children'] ?? [] as $child) {
            $add($menu_id, $child['title'], $child['url'], $parent_id, $child['classes'] ?? '');
            $expected_count++;
        }
    }
    $locations = get_theme_mod('nav_menu_locations', []);
    $locations[$location] = $menu_id;
    set_theme_mod('nav_menu_locations', $locations);

    $saved_items     = wp_get_nav_menu_items($menu_id) ?: [];
    $saved_locations = get_theme_mod('nav_menu_locations', []);
    if (count($saved_items) !== $expected_count || (int) ($saved_locations[$location] ?? 0) !== (int) $menu_id) {
        WP_CLI::error("Menu {$menu_name}: verification failed after write; refusing to record the seed version.");
    }
    WP_CLI::log("  \xe2\x9c\x93 {$menu_name} \xe2\x86\x92 {$location} (" . count($items) . " top-level items)");
}

$primary = [
    ['title' => 'Solutions', 'url' => '/seo_content_strategy_services/', 'children' => [
        ['title' => 'SEO/AEO Services',              'url' => '/seo_content_strategy_services/'],
        ['title' => 'Interactive Content Marketing', 'url' => '/services/bespoke-content-experience/'],
        ['title' => 'Content Writing',               'url' => '/content-writing-at-any-scale/'],
        ['title' => 'Graphic Design',                'url' => '/visual-content-and-design/#graphic-design'],
        ['title' => 'Photography & Videography',     'url' => '/visual-content-and-design/#photography-video'],
        ['title' => 'Paid Advertising',               'url' => '/paid-advertising/'],
    ]],
    ['title' => 'Industries', 'url' => '/industries/ecommerce/', 'children' => [
        ['title' => 'Ecommerce',                 'url' => '/industries/ecommerce/'],
        ['title' => 'Agencies & Partners',       'url' => '/industries/agencies/'],
        ['title' => 'Service Providers',         'url' => '/industries/service-providers/'],
        ['title' => 'SaaS & Digital Platforms',  'url' => '/industries/saas/'],
    ]],
    // About is now a single merged page (/about-stretch-creative/ with #our-story
    // / #our-team / #our-work anchors) — no dropdown children (punch-list #12).
    // About is a single merged page; dropdown children deep-link to its sections
    // so Our Work is reachable from the top nav (Cole request 2026-07-22).
    ['title' => 'About', 'url' => '/about-stretch-creative/', 'children' => [
        ['title' => 'Our Story', 'url' => '/about-stretch-creative/#our-story'],
        ['title' => 'Our Team',  'url' => '/about-stretch-creative/#our-team'],
        ['title' => 'Our Work',  'url' => '/about-stretch-creative/#our-work'],
    ]],
    ['title' => 'Blog',    'url' => '/blog/'],
    // Contact renders as the right-aligned CTA button (theme.css .nav-links .nav-cta).
    ['title' => 'Contact', 'url' => '/contact-stretch-creative/', 'classes' => 'nav-cta'],
];
stretch_menu_rebuild('Primary Navigation', 'primary', $primary);

// Footer columns — theme registers exactly footer-1 / footer-2 / footer-3
// (inc/theme-setup.php register_nav_menus; footer.php renders each as a column
// with wp_get_nav_menu_name() as the heading), so the site map's three footer
// groupings map straight onto them without merging.
// The menu name doubles as the footer column heading (footer.php renders
// wp_get_nav_menu_name), so these are the clean visible headings. Remove the
// earlier "Footer — *" named menus so they don't linger orphaned in wp-admin.
foreach (['Footer — Solutions', 'Footer — Industries', 'Footer — Company'] as $legacy) {
    $obj = wp_get_nav_menu_object($legacy);
    if ($obj) { wp_delete_nav_menu($obj->term_id); }
}
stretch_menu_rebuild('Solutions', 'footer-1', [
    ['title' => 'SEO/AEO Services',              'url' => '/seo_content_strategy_services/'],
    ['title' => 'Interactive Content Marketing', 'url' => '/services/bespoke-content-experience/'],
    ['title' => 'Content Writing',               'url' => '/content-writing-at-any-scale/'],
    ['title' => 'Visual Content & Design',       'url' => '/visual-content-and-design/'],
    ['title' => 'Paid Advertising',              'url' => '/paid-advertising/'],
]);
stretch_menu_rebuild('Industries', 'footer-2', [
    ['title' => 'Ecommerce',                'url' => '/industries/ecommerce/'],
    ['title' => 'Agencies & Partners',      'url' => '/industries/agencies/'],
    ['title' => 'Service Providers',        'url' => '/industries/service-providers/'],
    ['title' => 'SaaS & Digital Platforms', 'url' => '/industries/saas/'],
]);
// Footer col 3 leads with the About group (Our Story / Our Team / Our Work) to
// mirror the primary nav, then keeps Blog, Contact, and Pricing reachable in the
// footer (a 3-column footer can't 1:1 mirror a 5-item nav; Pricing lives only here).
stretch_menu_rebuild('About', 'footer-3', [
    ['title' => 'Our Story',  'url' => '/about-stretch-creative/#our-story'],
    ['title' => 'Our Team',   'url' => '/about-stretch-creative/#our-team'],
    ['title' => 'Our Work',   'url' => '/about-stretch-creative/#our-work'],
    ['title' => 'Blog',       'url' => '/blog/'],
    ['title' => 'Contact',    'url' => '/contact-stretch-creative/'],
    ['title' => 'Pricing',    'url' => '/pricing/'],
]);

wp_cache_flush();
if (function_exists('wp_cache_clear_cache')) {
    wp_cache_clear_cache();
}

WP_CLI::success('Menus rebuilt per site map.');
