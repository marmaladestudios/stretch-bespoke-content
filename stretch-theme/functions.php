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

// Contact form + lead capture handler (AUD-001/002)
if (file_exists(get_template_directory() . '/inc/contact-form.php')) {
    require_once get_template_directory() . '/inc/contact-form.php';
}

// Same-origin scanner fetch proxy (AUD-008)
if (file_exists(get_template_directory() . '/inc/scanner-proxy.php')) {
    require_once get_template_directory() . '/inc/scanner-proxy.php';
}

// Performance tweaks: emoji dequeue, autoload fixes (AUD-042)
if (file_exists(get_template_directory() . '/inc/perf.php')) {
    require_once get_template_directory() . '/inc/perf.php';
}

/**
 * Fix blog/category/post permalink resolution.
 * The permalink /blog/%category%/%postname%/ causes category rules to
 * match post URLs. This adds higher-priority post rewrite rules.
 */
function stretch_fix_blog_rewrites() {
    // Category feeds must be registered BEFORE the two-segment post rule below,
    // or /blog/{cat}/feed/ matches as a post named "feed" and 404s (AUD-021).
    // add_rewrite_rule('top') APPENDS to extra_rules_top, so registration order
    // here == matching order (verified via `wp rewrite list`).
    add_rewrite_rule(
        'blog/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$',
        'index.php?category_name=$matches[1]&feed=$matches[2]',
        'top'
    );
    add_rewrite_rule(
        'blog/([^/]+)/(feed|rdf|rss|rss2|atom)/?$',
        'index.php?category_name=$matches[1]&feed=$matches[2]',
        'top'
    );
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
    $version = '2.1';
    if (get_option('stretch_rewrite_version') !== $version) {
        flush_rewrite_rules();
        update_option('stretch_rewrite_version', $version);
    }
}
add_action('init', 'stretch_maybe_flush_rewrites');

/**
 * Legacy blog URL redirects (AUD-021).
 * /blog/category/{slug}/... → /blog/{slug}/  (old category base)
 * /blog/page/N/             → /blog/          (old blog pagination)
 * Runs at template_redirect priority 1 — before redirect_canonical (priority 10)
 * fires redirect_guess_404_permalink() and 301s these to a random post.
 */
add_action('template_redirect', 'stretch_legacy_blog_redirects', 1);
function stretch_legacy_blog_redirects() {
    $path = (string) parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);

    if (preg_match('#^/blog/category/([^/]+)#', $path, $m)) {
        wp_safe_redirect(home_url('/blog/' . sanitize_title($m[1]) . '/'), 301);
        exit;
    }

    if (preg_match('#^/blog/page/[0-9]+/?$#', $path)) {
        wp_safe_redirect(home_url('/blog/'), 301);
        exit;
    }
}

/**
 * Graphic Design + Video pages merged into /visual-content-and-design/ (redesign
 * Phase 3). Path-matched (not is_page) so the 301 survives unpublishing.
 */
add_action('template_redirect', 'stretch_redirect_merged_visual_pages', 1);
function stretch_redirect_merged_visual_pages() {
    $path = (string) parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
    if (preg_match('#^/graphic_design_services(/|$)#', $path)) {
        wp_safe_redirect(home_url('/visual-content-and-design/#graphic-design'), 301);
        exit;
    }
    if (preg_match('#^/video-content-services(/|$)#', $path)) {
        wp_safe_redirect(home_url('/visual-content-and-design/#photography-video'), 301);
        exit;
    }
}

/**
 * Our Team + Our Work merged into the single About page (/about-stretch-creative/,
 * punch-list #12). Path-matched (not is_page) so the 301 survives unpublishing the
 * retired /the-team/ and /our-work/ pages.
 */
add_action('template_redirect', 'stretch_redirect_merged_about_pages', 1);
function stretch_redirect_merged_about_pages() {
    $path = (string) parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
    if (preg_match('#^/the-team(/|$)#', $path)) {
        wp_safe_redirect(home_url('/about-stretch-creative/#our-team'), 301);
        exit;
    }
    if (preg_match('#^/our-work(/|$)#', $path)) {
        wp_safe_redirect(home_url('/about-stretch-creative/#our-work'), 301);
        exit;
    }
}

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

    // Theme CSS/JS — version by file mtime so the ?ver= busts browser + CDN caches
    // whenever the file changes. A static theme version (previously 1.0.0, never
    // bumped) left stale theme.css cached and broke the nav dropdowns on returning
    // visitors after the redesign. filemtime changes each deploy (theme copied → new
    // mtime), so caches bust once per deploy and stay warm within one.
    $css_path = get_template_directory() . '/assets/css/theme.css';
    $js_path  = get_template_directory() . '/assets/js/theme.js';
    $css_ver  = file_exists($css_path) ? filemtime($css_path) : wp_get_theme()->get('Version');
    $js_ver   = file_exists($js_path)  ? filemtime($js_path)  : wp_get_theme()->get('Version');

    // Theme CSS
    wp_enqueue_style('stretch-theme', get_template_directory_uri() . '/assets/css/theme.css', ['stretch-google-fonts'], $css_ver);

    // Theme JS — loaded in footer, no jQuery
    wp_enqueue_script('stretch-theme', get_template_directory_uri() . '/assets/js/theme.js', [], $js_ver, true);
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
 * ────────────────────────────────────────────────────────────────
 * Read time as post meta (AUD-029).
 * Templates previously ran str_word_count(strip_tags(get_the_content()))
 * per card per request. The minutes now live in `_stretch_read_min`,
 * recomputed on save and lazily backfilled.
 * ────────────────────────────────────────────────────────────────
 */
function stretch_calc_read_min($content) {
    return max(1, (int) ceil(str_word_count(strip_tags((string) $content)) / 250));
}

/**
 * Read `_stretch_read_min` for a post (defaults to the loop post),
 * computing + persisting it on the fly if missing.
 */
function stretch_get_read_min($post_id = 0) {
    $post_id = $post_id ? (int) $post_id : get_the_ID();
    if (!$post_id) {
        return 1;
    }
    $min = get_post_meta($post_id, '_stretch_read_min', true);
    if ($min === '' || (int) $min < 1) {
        $min = stretch_calc_read_min(get_post_field('post_content', $post_id));
        update_post_meta($post_id, '_stretch_read_min', $min);
    }
    return (int) $min;
}

add_action('save_post_post', 'stretch_update_read_min_meta', 10, 2);
function stretch_update_read_min_meta($post_id, $post) {
    if (wp_is_post_revision($post_id) || wp_is_post_autosave($post_id)) {
        return;
    }
    update_post_meta($post_id, '_stretch_read_min', stretch_calc_read_min($post->post_content));
}

// One-time backfill for existing posts, guarded by an option flag.
add_action('init', 'stretch_backfill_read_min', 20);
function stretch_backfill_read_min() {
    if (get_option('stretch_read_min_backfilled')) {
        return;
    }
    $posts = get_posts([
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
    ]);
    foreach ($posts as $p) {
        if (get_post_meta($p->ID, '_stretch_read_min', true) === '') {
            update_post_meta($p->ID, '_stretch_read_min', stretch_calc_read_min($p->post_content));
        }
    }
    update_option('stretch_read_min_backfilled', '1', false);
}

/**
 * ────────────────────────────────────────────────────────────────
 * Blog index for /blog/ (AUD-015).
 * page-blog-home.php previously ran a posts_per_page=-1 WP_Query with
 * full-content word counts plus one preview WP_Query per category on
 * EVERY request. The whole dataset now lives in one transient:
 *   'posts'    → client-side archive/search index (no colors — the
 *                template maps hub colors on top)
 *   'previews' → newest 3 posts per category slug (hub hover cards)
 * Rebuilt lazily; invalidated on save/trash/delete of a post.
 * ────────────────────────────────────────────────────────────────
 */
function stretch_get_blog_index() {
    $index = get_transient('stretch_blog_index');
    if (is_array($index) && isset($index['posts'], $index['previews'])) {
        return $index;
    }

    $q = new WP_Query([
        'post_type'      => 'post',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
        'no_found_rows'  => true,
    ]);

    $posts    = [];
    $previews = [];
    while ($q->have_posts()) {
        $q->the_post();
        $pid  = get_the_ID();
        $cats = get_the_category();

        $primary_cat = null;
        $has_uncat   = false;
        foreach ($cats as $c) {
            if ($c->slug === 'uncategorized') {
                $has_uncat = true;
            } elseif (!$primary_cat) {
                $primary_cat = $c;
            }
        }

        // Newest 3 per non-Uncategorized category (by membership; the list is
        // already date DESC) — matches the old per-hub `cat => id` queries,
        // which included posts that are also in Uncategorized.
        foreach ($cats as $c) {
            if ($c->slug === 'uncategorized') {
                continue;
            }
            if (count($previews[$c->slug] ?? []) >= 3) {
                continue;
            }
            $previews[$c->slug][] = [
                'title' => get_the_title(),
                'url'   => get_permalink(),
                'date'  => get_the_date('M j'),
            ];
        }

        // Archive index — matches the old `category__not_in => [uncat]` query,
        // which skipped any post that is in Uncategorized at all.
        if ($has_uncat || !$primary_cat) {
            continue;
        }

        $posts[] = [
            'title'     => html_entity_decode(get_the_title(), ENT_QUOTES, 'UTF-8'),
            'url'       => get_permalink(),
            'excerpt'   => html_entity_decode(wp_trim_words(get_the_excerpt(), 22), ENT_QUOTES, 'UTF-8'),
            'thumb'     => has_post_thumbnail() ? get_the_post_thumbnail_url($pid, 'medium_large') : '',
            'cat_slug'  => $primary_cat->slug,
            'cat_name'  => $primary_cat->name,
            'author'    => get_the_author(),
            'date'      => get_the_date('M j, Y'),
            'read_time' => stretch_get_read_min($pid),
        ];
    }
    wp_reset_postdata();

    $index = ['posts' => $posts, 'previews' => $previews];
    set_transient('stretch_blog_index', $index, 12 * HOUR_IN_SECONDS);
    return $index;
}

function stretch_flush_blog_index($post_id = 0, $post = null) {
    if ($post_id) {
        $type = ($post instanceof WP_Post) ? $post->post_type : get_post_type($post_id);
        if ($type && $type !== 'post') {
            return;
        }
    }
    delete_transient('stretch_blog_index');
}
add_action('save_post_post', 'stretch_flush_blog_index', 10, 2);
add_action('deleted_post', 'stretch_flush_blog_index', 10, 2);
add_action('trashed_post', 'stretch_flush_blog_index');

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
 * Persisted filename → attachment ID map (AUD-029).
 * Replaces the 18 leading-wildcard LIKE queries per /our-work/ view with a
 * single non-autoloaded option. Rebuilt lazily when a lookup misses (at most
 * once per request), appended to on `add_attachment`, pruned on
 * `delete_attachment`.
 */
function stretch_attachment_file_map($force_rebuild = false) {
    if (!$force_rebuild) {
        $map = get_option('stretch_attachment_file_map', null);
        if (is_array($map)) {
            return $map;
        }
    }

    global $wpdb;
    $rows = $wpdb->get_results(
        "SELECT post_id, meta_value FROM {$wpdb->postmeta}
         WHERE meta_key = '_wp_attached_file'
         ORDER BY post_id ASC"
    );
    $map = [];
    foreach ($rows as $row) {
        if (!$row->meta_value) {
            continue;
        }
        $map[basename($row->meta_value)] = (int) $row->post_id; // highest ID wins
    }
    update_option('stretch_attachment_file_map', $map, false);
    return $map;
}

add_action('add_attachment', 'stretch_attachment_map_add');
function stretch_attachment_map_add($post_id) {
    $file = get_post_meta($post_id, '_wp_attached_file', true);
    if (!$file) {
        return;
    }
    $map = get_option('stretch_attachment_file_map', null);
    if (!is_array($map)) {
        return; // map builds itself on the next lookup
    }
    $map[basename($file)] = (int) $post_id;
    update_option('stretch_attachment_file_map', $map, false);
}

add_action('delete_attachment', 'stretch_attachment_map_forget');
function stretch_attachment_map_forget($post_id) {
    $map = get_option('stretch_attachment_file_map', null);
    if (!is_array($map)) {
        return;
    }
    $changed = false;
    foreach ($map as $file => $id) {
        if ((int) $id === (int) $post_id) {
            unset($map[$file]);
            $changed = true;
        }
    }
    if ($changed) {
        update_option('stretch_attachment_file_map', $map, false);
    }
}

/**
 * Look up an attachment ID by its source filename (matches the wp-content/uploads
 * file the attachment points at). Returns 0 if not found.
 */
function stretch_attachment_id_by_filename($filename) {
    static $cache   = [];
    static $rebuilt = false;
    if (isset($cache[$filename])) return $cache[$filename];

    $lookup = static function ($map) use ($filename) {
        if (isset($map[$filename])) {
            return (int) $map[$filename];
        }
        // Filename-prefix fallback (scaled/renamed variants), highest ID wins —
        // mirrors the old `meta_value LIKE '%/base%' ORDER BY post_id DESC`.
        $base = pathinfo($filename, PATHINFO_FILENAME);
        $best = 0;
        foreach ($map as $file => $id) {
            if (strpos($file, $base) === 0 && (int) $id > $best) {
                $best = (int) $id;
            }
        }
        return $best;
    };

    $id = $lookup(stretch_attachment_file_map());
    if (!$id && !$rebuilt) {
        $rebuilt = true; // rebuild at most once per request
        $id = $lookup(stretch_attachment_file_map(true));
    }
    $cache[$filename] = $id;
    return $id;
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
        'graphic_design_services'      => ['quickbooks', 'remitly'],
        'video-content-services'       => ['vicis', 'meyers-product', 'meyers-life', 'open-road', 'monster', 'nhl'],
        'paid-advertising'             => ['monster', 'nhl'],
        // Union of the former Graphic Design + Video Content pages' keys (Task 7)
        'visual-content-and-design'    => ['quickbooks', 'remitly', 'vicis', 'meyers-product', 'meyers-life', 'open-road', 'monster', 'nhl'],
        // Content Writing (replaced by Add-On Services, AUD-039) and SEO +
        // Content Strategy left empty — strip hides automatically
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

/**
 * Render a heading with its accent phrase wrapped in a gradient span, matching
 * the home-page hero treatment. $accent is the seeded phrase to highlight; when
 * absent (or not found in $text) the last word is highlighted instead, the same
 * rule the service-template section headings already use. Text that ships its
 * own markup is passed through untouched.
 */
function stretch_accent_title($text, $accent = '', $class = 'gradient-text') {
    if (strpos($text, '<') !== false) {
        return wp_kses_post($text);
    }
    if ($accent !== '' && ($pos = stripos($text, $accent)) !== false) {
        $match = substr($text, $pos, strlen($accent));
        return esc_html(substr($text, 0, $pos))
            . '<span class="' . esc_attr($class) . '">' . esc_html($match) . '</span>'
            . esc_html(substr($text, $pos + strlen($accent)));
    }
    $words = explode(' ', trim($text));
    if (count($words) >= 2) {
        $last = array_pop($words);
        return esc_html(implode(' ', $words))
            . ' <span class="' . esc_attr($class) . '">' . esc_html($last) . '</span>';
    }
    return esc_html($text);
}
