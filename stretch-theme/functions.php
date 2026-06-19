<?php
/**
 * Stretch Creative Theme — functions.php
 */

// Theme setup: menus, supports, image sizes, roles
require_once get_template_directory() . '/inc/theme-setup.php';

// Customizer: brand colors, typography, header/footer settings
require_once get_template_directory() . '/inc/customizer.php';

// ACF field registration (PHP fallback for flexible content)
require_once get_template_directory() . '/inc/acf-fields.php';

/**
 * Fix blog/category/post permalink resolution.
 * The permalink /blog/%category%/%postname%/ causes category rules to
 * match post URLs. This adds higher-priority post rewrite rules.
 */
function stretch_fix_blog_rewrites() {
    add_rewrite_rule(
        'blog/([^/]+)/([^/]+)/?$',
        'index.php?category_name=$matches[1]&name=$matches[2]',
        'top'
    );
    add_rewrite_rule(
        'blog/([^/]+)/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$',
        'index.php?category_name=$matches[1]&name=$matches[2]&feed=$matches[3]',
        'top'
    );
    add_rewrite_rule(
        'blog/([^/]+)/([^/]+)/trackback/?$',
        'index.php?category_name=$matches[1]&name=$matches[2]&tb=1',
        'top'
    );
    add_rewrite_rule(
        'blog/([^/]+)/([^/]+)/comment-page-([0-9]{1,})/?$',
        'index.php?category_name=$matches[1]&name=$matches[2]&cpage=$matches[3]',
        'top'
    );
}
add_action('init', 'stretch_fix_blog_rewrites');

/**
 * Rewrite category URLs from /blog/category/slug/ to /blog/slug/
 * (category_structure is /blog/category/%category%, so we strip the
 * redundant /category/ segment rather than introducing a second /blog/).
 */
function stretch_category_link($link, $term_id) {
    return str_replace('/blog/category/', '/blog/', $link);
}
add_filter('category_link', 'stretch_category_link', 10, 2);

/**
 * Add rewrite rule for /blog/slug/ to serve category archives
 */
function stretch_blog_category_rewrites() {
    add_rewrite_rule(
        'blog/([^/]+)/?$',
        'index.php?category_name=$matches[1]',
        'top'
    );
    add_rewrite_rule(
        'blog/([^/]+)/page/([0-9]+)/?$',
        'index.php?category_name=$matches[1]&paged=$matches[2]',
        'top'
    );
}
add_action('init', 'stretch_blog_category_rewrites');

/**
 * Flush rewrite rules when they change (version-gated).
 */
function stretch_maybe_flush_rewrites() {
    $version = '2.0';
    if (get_option('stretch_rewrite_version') !== $version) {
        flush_rewrite_rules();
        update_option('stretch_rewrite_version', $version);
    }
}
add_action('init', 'stretch_maybe_flush_rewrites');

/**
 * The Solutions page content is now the homepage. 301-redirect the retired
 * /stretch-creative-solutions/ URL to the site root.
 */
add_action('template_redirect', 'stretch_redirect_retired_solutions');
function stretch_redirect_retired_solutions() {
    if (is_page('stretch-creative-solutions')) {
        wp_redirect(home_url('/'), 301);
        exit;
    }
}

/**
 * The /industries/ landing page is not built yet. Redirect the bare parent URL
 * to the homepage; the child industry pages (e.g. /industries/ecommerce/) render
 * normally.
 */
add_action('template_redirect', 'stretch_redirect_industries_parent');
function stretch_redirect_industries_parent() {
    if (is_page('industries')) {
        wp_redirect(home_url('/'), 302);
        exit;
    }
}

/**
 * Enqueue styles and scripts.
 */
function stretch_enqueue_assets() {
    // Google Fonts
    wp_enqueue_style(
        'stretch-google-fonts',
        'https://fonts.googleapis.com/css2?family=Assistant:wght@300;400;600&family=Montserrat:wght@400&family=Poppins:wght@400;500;600&display=swap',
        [],
        null
    );

    // Theme CSS
    wp_enqueue_style('stretch-theme', get_template_directory_uri() . '/assets/css/theme.css', ['stretch-google-fonts'], wp_get_theme()->get('Version'));

    // Theme JS — loaded in footer, no jQuery
    wp_enqueue_script('stretch-theme', get_template_directory_uri() . '/assets/js/theme.js', [], wp_get_theme()->get('Version'), true);
}
add_action('wp_enqueue_scripts', 'stretch_enqueue_assets');

/**
 * Add preconnect hints for Google Fonts.
 */
function stretch_resource_hints($urls, $relation_type) {
    if ($relation_type === 'preconnect') {
        $urls[] = ['href' => 'https://fonts.googleapis.com'];
        $urls[] = ['href' => 'https://fonts.gstatic.com', 'crossorigin' => 'anonymous'];
    }
    return $urls;
}
add_filter('wp_resource_hints', 'stretch_resource_hints', 10, 2);

/**
 * Output Customizer CSS variables in <head>.
 */
function stretch_customizer_css() {
    $purple   = get_theme_mod('stretch_color_primary', '#8560A8');
    $blue     = get_theme_mod('stretch_color_secondary', '#5674B9');
    $cyan     = get_theme_mod('stretch_color_accent', '#00BFF3');
    $dark     = get_theme_mod('stretch_color_dark', '#252C3A');
    $body     = get_theme_mod('stretch_color_body', '#323A51');
    $font_h   = get_theme_mod('stretch_font_heading', 'Poppins');
    $font_b   = get_theme_mod('stretch_font_body', 'Assistant');
    $font_n   = get_theme_mod('stretch_font_nav', 'Montserrat');
    $font_sz  = get_theme_mod('stretch_font_size_base', '18');

    echo '<style id="stretch-customizer-css">:root{';
    echo "--color-purple:{$purple};";
    echo "--color-blue:{$blue};";
    echo "--color-cyan:{$cyan};";
    echo "--color-dark:{$dark};";
    echo "--color-body:{$body};";
    echo "--font-heading:'{$font_h}',sans-serif;";
    echo "--font-body:'{$font_b}',sans-serif;";
    echo "--font-nav:'{$font_n}',sans-serif;";
    echo "--font-size-base:{$font_sz}px;";
    echo '}</style>';
}
add_action('wp_head', 'stretch_customizer_css', 20);

/**
 * Render ACF flexible content sections.
 * Called from front-page.php and page.php.
 */
function stretch_render_sections() {
    if (!function_exists('have_rows') || !have_rows('page_sections')) {
        return;
    }

    while (have_rows('page_sections')) {
        the_row();
        $layout = get_row_layout();
        $template = get_template_directory() . "/template-parts/sections/{$layout}.php";

        if (file_exists($template)) {
            include $template;
        }
    }
}

/**
 * Helper: get section background classes from ACF sub-fields.
 */
function stretch_section_classes() {
    $bg = get_sub_field('background_style') ?: 'white';
    $padding = get_sub_field('padding_style') ?: 'default';
    $id = get_sub_field('section_id');

    $classes = [];
    switch ($bg) {
        case 'light':  $classes[] = 'section-light'; break;
        case 'dark':   $classes[] = 'section-dark'; break;
        case 'purple': $classes[] = 'section-purple'; break;
        default:       $classes[] = 'section-white'; break;
    }

    if ($padding === 'compact') $classes[] = 'section-compact';
    if ($padding === 'none') $classes[] = 'section-no-padding';

    return [
        'class' => implode(' ', $classes),
        'id'    => $id ? esc_attr($id) : '',
        'style' => get_sub_field('custom_background_color') ? 'background-color:' . esc_attr(get_sub_field('custom_background_color')) . ';' : '',
    ];
}


/**
 * Curated portfolio items keyed for filtering.
 *
 * Items are declared with their source `file` name. At render time we resolve
 * each file to a real WP attachment ID (looked up by source filename in the
 * uploads dir) so the same array works across local + Render environments
 * regardless of what attachment ID was assigned when the image was sideloaded.
 *
 * Used by /our-work/ and the inline "Selected Work" strip on service pages.
 */
function stretch_portfolio_definitions() {
    return [
        // key => [file, client, category, subcat, vimeo?]
        'paperless-post' => ['file' => 'img-011-008.png', 'client' => 'Paperless Post',     'category' => 'writing', 'subcat' => 'Blog Article'],
        'etsy'           => ['file' => 'img-012-010.png', 'client' => 'Etsy',                'category' => 'writing', 'subcat' => 'Product Listing Pages'],
        'walgreens'      => ['file' => 'img-012-011.png', 'client' => 'Walgreens',           'category' => 'writing', 'subcat' => 'Expert-Written Content'],
        'grove-co'       => ['file' => 'img-013-014.jpg', 'client' => 'Grove Co',            'category' => 'writing', 'subcat' => 'User-Generated Content'],
        'grove-collab'   => ['file' => 'img-014-018.jpg', 'client' => 'Grove Collaborative', 'category' => 'writing', 'subcat' => 'User-Generated Content'],
        'brixton-coors'  => ['file' => 'img-014-019.png', 'client' => 'Brixton × Coors',     'category' => 'writing', 'subcat' => 'Email Marketing'],
        'reef-aerial'    => ['file' => 'img-014-017.jpg', 'client' => 'Reef',                'category' => 'writing', 'subcat' => 'Social Media'],
        'reef-barrel'    => ['file' => 'img-015-023.jpg', 'client' => 'Reef',                'category' => 'writing', 'subcat' => 'Social Media'],

        'meyers-product' => ['file' => 'img-019-026.jpg', 'client' => "Meyer's Clean Day",   'category' => 'video',   'subcat' => 'Product Photography'],
        'meyers-life'    => ['file' => 'img-020-027.jpg', 'client' => "Meyer's Clean Day",   'category' => 'video',   'subcat' => 'Lifestyle Photography'],
        'quickbooks'     => ['file' => 'img-021-028.jpg', 'client' => 'Intuit QuickBooks',   'category' => 'design',  'subcat' => 'Infographic'],
        'remitly'        => ['file' => 'img-013-015.jpg', 'client' => 'Remitly',             'category' => 'design',  'subcat' => 'Infographic'],
        'wework'         => ['file' => 'img-021-030.png', 'client' => 'WeWork',              'category' => 'video',   'subcat' => 'Lifestyle Photography'],
        'vicis'          => ['file' => 'img-023-031.jpg', 'client' => 'Vicis',               'category' => 'video',   'subcat' => 'Brand Story',      'vimeo' => '900872814'],
        'open-road'      => ['file' => 'img-024-032.jpg', 'client' => 'Open Road',           'category' => 'video',   'subcat' => 'Corporate Video',  'vimeo' => '875315890'],
        'family-flowers' => ['file' => 'img-024-033.jpg', 'client' => 'Family Flowers',      'category' => 'video',   'subcat' => 'Documentary',      'vimeo' => '875333898'],
        'nhl'            => ['file' => 'img-025-034.jpg', 'client' => 'NHL',                 'category' => 'video',   'subcat' => 'TV Advertisement', 'vimeo' => '875337016'],
        'monster'        => ['file' => 'img-025-035.jpg', 'client' => 'Monster Energy',      'category' => 'video',   'subcat' => 'Social Media Ad',  'vimeo' => '875314882'],
    ];
}

/**
 * Look up an attachment ID by its source filename (matches the wp-content/uploads
 * file the attachment points at). Returns 0 if not found.
 */
function stretch_attachment_id_by_filename($filename) {
    static $cache = [];
    if (isset($cache[$filename])) return $cache[$filename];

    global $wpdb;
    $base = pathinfo($filename, PATHINFO_FILENAME);
    $row  = $wpdb->get_var($wpdb->prepare(
        "SELECT post_id FROM {$wpdb->postmeta}
         WHERE meta_key = '_wp_attached_file'
           AND (meta_value LIKE %s OR meta_value LIKE %s)
         ORDER BY post_id DESC LIMIT 1",
        '%/' . $wpdb->esc_like($filename),
        '%/' . $wpdb->esc_like($base) . '%'
    ));
    $cache[$filename] = $row ? (int) $row : 0;
    return $cache[$filename];
}

/**
 * Returns the portfolio as an ordered list of items, each with a resolved `id`.
 * Items whose images haven't been sideloaded yet are dropped silently — the
 * filter-button counts will reflect what's actually renderable.
 */
function stretch_get_portfolio() {
    static $cache = null;
    if ($cache !== null) return $cache;

    $cache = [];
    foreach (stretch_portfolio_definitions() as $key => $item) {
        $id = stretch_attachment_id_by_filename($item['file']);
        if (!$id) continue;
        $item['id']  = $id;
        $item['key'] = $key;
        $cache[]     = $item;
    }
    return $cache;
}

/**
 * Map a service-page slug to a list of portfolio definition keys to feature
 * in the inline "Selected Work" strip. Empty array hides the strip.
 */
function stretch_get_portfolio_for_service($slug) {
    $map = [
        'content-writing-at-any-scale' => ['paperless-post', 'etsy', 'walgreens', 'grove-co', 'brixton-coors', 'reef-aerial'],
        'graphic_design_services'      => ['quickbooks', 'remitly'],
        'video-content-services'       => ['vicis', 'meyers-product', 'meyers-life', 'open-road', 'monster', 'nhl'],
        'paid-advertising'             => ['monster', 'nhl'],
        // SEO + Content Strategy left empty — strip hides automatically
    ];
    if (empty($map[$slug])) return [];
    $by_key = [];
    foreach (stretch_get_portfolio() as $item) {
        if (!empty($item['key'])) $by_key[$item['key']] = $item;
    }
    $out = [];
    foreach ($map[$slug] as $key) {
        if (isset($by_key[$key])) $out[] = $by_key[$key];
    }
    return $out;
}
