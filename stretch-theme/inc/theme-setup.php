<?php
/**
 * Theme setup: menus, supports, image sizes.
 */

function stretch_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('editor-styles');
    add_editor_style('assets/css/editor-style.css');
    add_theme_support('responsive-embeds');
    add_theme_support('custom-logo', [
        'height'      => 80,
        'width'       => 260,
        'flex-height' => true,
        'flex-width'  => true,
    ]);

    register_nav_menus([
        'primary'  => __('Primary Navigation', 'stretch'),
        'footer-1' => __('Footer Column 1', 'stretch'),
        'footer-2' => __('Footer Column 2', 'stretch'),
        'footer-3' => __('Footer Column 3', 'stretch'),
    ]);

    add_image_size('blog-card', 600, 340, true);
    add_image_size('team-photo', 400, 400, true);
    add_image_size('hero-bg', 1920, 1080, true);
}
add_action('after_setup_theme', 'stretch_setup');

/**
 * Register client user role for future portal.
 */
function stretch_register_roles() {
    if (!get_role('stretch_client')) {
        add_role('stretch_client', __('Client', 'stretch'), ['read' => true]);
    }
}
add_action('init', 'stretch_register_roles');

/**
 * ACF JSON save/load paths.
 */
function stretch_acf_json_save_point($path) {
    return get_stylesheet_directory() . '/acf-json';
}
add_filter('acf/settings/save_json', 'stretch_acf_json_save_point');

function stretch_acf_json_load_point($paths) {
    unset($paths[0]);
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return $paths;
}
add_filter('acf/settings/load_json', 'stretch_acf_json_load_point');
