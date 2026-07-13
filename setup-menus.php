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

    $add = function ($menu_id, $title, $url, $parent = 0) {
        return wp_update_nav_menu_item($menu_id, 0, [
            'menu-item-title'     => $title,
            'menu-item-url'       => home_url($url),
            'menu-item-status'    => 'publish',
            'menu-item-parent-id' => $parent,
        ]);
    };
    foreach ($items as $item) {
        $parent_id = $add($menu_id, $item['title'], $item['url']);
        foreach ($item['children'] ?? [] as $child) {
            $add($menu_id, $child['title'], $child['url'], $parent_id);
        }
    }
    $locations = get_theme_mod('nav_menu_locations', []);
    $locations[$location] = $menu_id;
    set_theme_mod('nav_menu_locations', $locations);
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
    ['title' => 'About Us', 'url' => '/about-stretch-creative/', 'children' => [
        ['title' => 'Our Story', 'url' => '/about-stretch-creative/'],
        ['title' => 'Our Team',  'url' => '/the-team/'],
    ]],
    ['title' => 'Our Work', 'url' => '/our-work/'],
    ['title' => 'Blog',     'url' => '/blog/'],
];
stretch_menu_rebuild('Primary Navigation', 'primary', $primary);

// Footer columns — theme registers exactly footer-1 / footer-2 / footer-3
// (inc/theme-setup.php register_nav_menus; footer.php renders each as a column
// with wp_get_nav_menu_name() as the heading), so the site map's three footer
// groupings map straight onto them without merging.
stretch_menu_rebuild('Footer — Solutions', 'footer-1', [
    ['title' => 'SEO/AEO Services',              'url' => '/seo_content_strategy_services/'],
    ['title' => 'Interactive Content Marketing', 'url' => '/services/bespoke-content-experience/'],
    ['title' => 'Content Writing',               'url' => '/content-writing-at-any-scale/'],
    ['title' => 'Visual Content & Design',       'url' => '/visual-content-and-design/'],
    ['title' => 'Paid Advertising',              'url' => '/paid-advertising/'],
]);
stretch_menu_rebuild('Footer — Industries', 'footer-2', [
    ['title' => 'Ecommerce',                'url' => '/industries/ecommerce/'],
    ['title' => 'Agencies & Partners',      'url' => '/industries/agencies/'],
    ['title' => 'Service Providers',        'url' => '/industries/service-providers/'],
    ['title' => 'SaaS & Digital Platforms', 'url' => '/industries/saas/'],
]);
stretch_menu_rebuild('Footer — Company', 'footer-3', [
    ['title' => 'Our Story',  'url' => '/about-stretch-creative/'],
    ['title' => 'Our Team',   'url' => '/the-team/'],
    ['title' => 'Our Work',   'url' => '/our-work/'],
    ['title' => 'Pricing',    'url' => '/pricing/'],
    ['title' => 'Blog',       'url' => '/blog/'],
    ['title' => 'Contact Us', 'url' => '/contact-stretch-creative/'],
]);

WP_CLI::success('Menus rebuilt per site map.');
