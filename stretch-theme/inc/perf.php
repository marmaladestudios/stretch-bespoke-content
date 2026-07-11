<?php
/**
 * Performance tweaks (AUD-042).
 *
 * Loaded conditionally from functions.php. Currently:
 *   - Removes the WordPress emoji detection script + inline styles
 *     (~3.2 KB and one script eval on every page; the site uses no
 *     emoji-dependent content).
 *
 * Related one-time DB tweak (done via WP-CLI, not code):
 *   wp option set-autoload stretch_hub_aeo off
 * The stretch_hub_aeo blob is only read by the AEO hub tooling, so it
 * should not ride along on every request's alloptions load.
 *
 * Deferred (noted in AUD-042, needs its own pass): self-hosting Google
 * Fonts — theme.css is currently chained behind the fonts request.
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Remove emoji detection script, styles, and related filters.
 */
function stretch_disable_emojis() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

    add_filter('tiny_mce_plugins', 'stretch_disable_emojis_tinymce');
    add_filter('wp_resource_hints', 'stretch_disable_emojis_dns_prefetch', 10, 2);
}
add_action('init', 'stretch_disable_emojis');

/**
 * Drop the wpemoji TinyMCE plugin.
 *
 * @param array $plugins TinyMCE plugin slugs.
 * @return array
 */
function stretch_disable_emojis_tinymce($plugins) {
    if (is_array($plugins)) {
        return array_diff($plugins, ['wpemoji']);
    }
    return [];
}

/**
 * Remove the s.w.org emoji CDN dns-prefetch hint.
 *
 * @param array  $urls          Resource hint URLs.
 * @param string $relation_type Hint type (dns-prefetch, preconnect, ...).
 * @return array
 */
function stretch_disable_emojis_dns_prefetch($urls, $relation_type) {
    if ('dns-prefetch' === $relation_type) {
        $emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/');
        foreach ($urls as $key => $url) {
            if (is_string($url) && strpos($url, $emoji_svg_url) === 0) {
                unset($urls[$key]);
            }
        }
    }
    return array_values($urls);
}
