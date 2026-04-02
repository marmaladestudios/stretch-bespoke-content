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
 * Rewrite category URLs from /category/slug/ to /blog/slug/
 */
function stretch_category_link($link, $term_id) {
    return str_replace('/category/', '/blog/', $link);
}
add_filter('category_link', 'stretch_category_link', 10, 2);

/**
 * Add rewrite rule for /blog/slug/ to serve category archives
 */
function stretch_blog_category_rewrites() {
    add_rewrite_rule(
        'blog/([^/]+)/?$',
        'index.php?category_name=$matches[1]',
        'bottom'
    );
    add_rewrite_rule(
        'blog/([^/]+)/page/([0-9]+)/?$',
        'index.php?category_name=$matches[1]&paged=$matches[2]',
        'bottom'
    );
}
add_action('init', 'stretch_blog_category_rewrites');

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
