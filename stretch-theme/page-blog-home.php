<?php
/**
 * Template Name: Blog Home
 *
 * Hub-centric magazine layout with instant client-side search + filter.
 */
get_header();

// ────────────────────────────────────────────────
// HUB METADATA (color + tagline per category slug)
// ────────────────────────────────────────────────
$hub_meta = [
    'aeo' => [
        'color'   => '#00BFF3',
        'tagline' => 'The complete playbook for getting your content cited by ChatGPT, Gemini, and Perplexity.',
    ],
    'content-marketing' => [
        'color'   => '#8560A8',
        'tagline' => 'Strategy, storytelling, and the craft of content that compounds over time.',
    ],
    'seo' => [
        'color'   => '#5674B9',
        'tagline' => 'Technical audits, ranking strategies, and SEO that stands up to Google updates.',
    ],
    'ecommerce' => [
        'color'   => '#448CCB',
        'tagline' => 'Content and optimization strategies built for online retail.',
    ],
    'generative-ai' => [
        'color'   => '#6B8F3C',
        'tagline' => 'How AI is reshaping content creation, research, and brand discovery.',
    ],
    'video-content' => [
        'color'   => '#D4783F',
        'tagline' => 'Video marketing, YouTube SEO, and visual storytelling that converts.',
    ],
    'creative-dojo' => [
        'color'   => '#C74B6F',
        'tagline' => 'Behind-the-scenes dispatches from the Stretch Creative studio.',
    ],
];
$default_color = '#8560A8';

// ────────────────────────────────────────────────
// HUB ICON LIBRARY (custom SVG per topic)
// ────────────────────────────────────────────────
if (!function_exists('stretch_blog_hub_icon')) {
    function stretch_blog_hub_icon($slug) {
        $icons = [
            // AEO: speech bubble with a citation spark inside
            'aeo' => '<svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M7 11a3 3 0 0 1 3-3h28a3 3 0 0 1 3 3v18a3 3 0 0 1-3 3H24l-8 8v-8H10a3 3 0 0 1-3-3z"/><path d="M24 14l2 5 5 1-4 3.5 1 5-4-2.5-4 2.5 1-5-4-3.5 5-1z" stroke-width="1.4"/></svg>',

            // Content Marketing: folded document with lines + pen nib accent
            'content-marketing' => '<svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M12 6h18l8 8v22a2 2 0 0 1-2 2H14a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2Z"/><path d="M30 6v8h8"/><path d="M18 22h12"/><path d="M18 28h12"/><path d="M18 34h8"/></svg>',

            // SEO: magnifier with connection nodes inside
            'seo' => '<svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><circle cx="20" cy="20" r="12"/><path d="m29 29 11 11"/><circle cx="20" cy="20" r="1.6" fill="currentColor" stroke="none"/><circle cx="15" cy="16" r="1.3" fill="currentColor" stroke="none"/><circle cx="25" cy="17" r="1.3" fill="currentColor" stroke="none"/><circle cx="22" cy="25" r="1.3" fill="currentColor" stroke="none"/><path d="M15 16 20 20 25 17 22 25 15 16" stroke-width="1"/></svg>',

            // Ecommerce: storefront with awning
            'ecommerce' => '<svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M8 18h32l-2 22H10Z"/><path d="M8 18v-4l4-6h24l4 6v4"/><path d="M12 8h24"/><path d="M18 28a6 6 0 0 0 12 0"/></svg>',

            // Generative AI: cluster of sparkles
            'generative-ai' => '<svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M22 8l2 8 8 2-8 2-2 8-2-8-8-2 8-2z"/><path d="M36 26l1 4 4 1-4 1-1 4-1-4-4-1 4-1z" stroke-width="1.4"/><path d="M10 6l0.5 2.5L13 9l-2.5 0.5L10 12l-0.5-2.5L7 9l2.5-0.5z" stroke-width="1.2"/></svg>',

            // Video Content: monitor with play + sound arcs
            'video-content' => '<svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><rect x="6" y="12" width="24" height="24" rx="2"/><path d="m16 19 8 5-8 5z" fill="currentColor" stroke="none"/><path d="M34 19c2 2 2 10 0 12"/><path d="M38 15c4 3 4 15 0 18"/></svg>',

            // Creative Dojo: concentric rings with brush curve (aikido-inspired)
            'creative-dojo' => '<svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><circle cx="24" cy="24" r="15"/><path d="M12 22c5-5 15 9 23 3" stroke-width="1.8"/><circle cx="24" cy="24" r="2" fill="currentColor" stroke="none"/><circle cx="12" cy="22" r="1.3" fill="currentColor" stroke="none"/><circle cx="35" cy="25" r="1.3" fill="currentColor" stroke="none"/></svg>',
        ];
        return $icons[$slug] ?? $icons['content-marketing'];
    }
}

// ────────────────────────────────────────────────
// FETCH CATEGORIES (split featured = has pillar option)
// ────────────────────────────────────────────────
$uncat_id = get_cat_ID('Uncategorized');
$all_cats = get_categories([
    'hide_empty' => true,
    'exclude'    => $uncat_id,
]);

$featured_hubs = [];
$regular_hubs  = [];
foreach ($all_cats as $cat) {
    $hub_option = get_option("stretch_hub_{$cat->slug}");
    if (!empty($hub_option) && !empty($hub_option['headline'])) {
        $featured_hubs[] = ['cat' => $cat, 'hub' => $hub_option];
    } else {
        $regular_hubs[] = $cat;
    }
}
// Sort regular hubs by post count desc
usort($regular_hubs, function ($a, $b) {
    return $b->count - $a->count;
});

// ────────────────────────────────────────────────
// FETCH ALL POSTS FOR CLIENT-SIDE FILTER
// ────────────────────────────────────────────────
$all_posts_query = new WP_Query([
    'post_type'        => 'post',
    'posts_per_page'   => -1,
    'post_status'      => 'publish',
    'orderby'          => 'date',
    'order'            => 'DESC',
    'category__not_in' => [$uncat_id],
    'no_found_rows'    => true,
]);

$posts_data = [];
if ($all_posts_query->have_posts()) {
    while ($all_posts_query->have_posts()) {
        $all_posts_query->the_post();
        $pid  = get_the_ID();
        $cats = get_the_category();

        // Primary category = first non-Uncategorized
        $primary_cat = null;
        foreach ($cats as $c) {
            if ($c->slug !== 'uncategorized') {
                $primary_cat = $c;
                break;
            }
        }
        if (!$primary_cat) continue;

        $content = strip_tags(get_the_content());
        $wc      = str_word_count($content);
        $rt      = max(1, (int) ceil($wc / 250));
        $thumb   = has_post_thumbnail() ? get_the_post_thumbnail_url($pid, 'medium_large') : '';
        $color   = $hub_meta[$primary_cat->slug]['color'] ?? $default_color;

        $posts_data[] = [
            'id'        => $pid,
            'title'     => html_entity_decode(get_the_title(), ENT_QUOTES, 'UTF-8'),
            'url'       => get_permalink(),
            'excerpt'   => html_entity_decode(wp_trim_words(get_the_excerpt(), 22), ENT_QUOTES, 'UTF-8'),
            'thumb'     => $thumb,
            'cat_slug'  => $primary_cat->slug,
            'cat_name'  => $primary_cat->name,
            'cat_color' => $color,
            'author'    => get_the_author(),
            'date'      => get_the_date('M j, Y'),
            'read_time' => $rt,
        ];
    }
    wp_reset_postdata();
}

// Hubs list for chips (All + each hub, sorted by count desc)
$chip_hubs = $regular_hubs;
foreach ($featured_hubs as $fh) {
    $chip_hubs[] = $fh['cat'];
}
usort($chip_hubs, function ($a, $b) {
    return $b->count - $a->count;
});
$chip_data = array_map(function ($c) use ($hub_meta, $default_color) {
    return [
        'slug'  => $c->slug,
        'name'  => $c->name,
        'color' => $hub_meta[$c->slug]['color'] ?? $default_color,
        'count' => (int) $c->count,
    ];
}, $chip_hubs);

// 3 latest posts per hub for hover previews
$hub_previews = [];
foreach ($chip_hubs as $cat) {
    $q = new WP_Query([
        'post_type'      => 'post',
        'posts_per_page' => 3,
        'post_status'    => 'publish',
        'cat'            => $cat->term_id,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'no_found_rows'  => true,
    ]);
    $items = [];
    while ($q->have_posts()) {
        $q->the_post();
        $items[] = [
            'title' => get_the_title(),
            'url'   => get_permalink(),
            'date'  => get_the_date('M j'),
        ];
    }
    wp_reset_postdata();
    $hub_previews[$cat->slug] = $items;
}

$total_posts_count = count($posts_data);
?>

<style>
/* =====================================================
   BLOG HOME — HUB-CENTRIC MAGAZINE (v2)
   ===================================================== */
html, body { overflow-x: hidden; }
.admin-bar .site-nav { top: 32px; }
@media (max-width: 782px) { .admin-bar .site-nav { top: 46px; } }

/* ---------- UTILITIES ---------- */
.blog-container { max-width: 1200px; margin: 0 auto; padding: 0 40px; width: 100%; }
.blog-gradient-text {
  background: linear-gradient(135deg, #8560A8 0%, #5674B9 30%, #448CCB 60%, #00BFF3 100%);
  -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
}
.blog-section { box-sizing: border-box; position: relative; }
.blog-section *, .blog-section *::before, .blog-section *::after { box-sizing: inherit; }
.blog-section img { max-width: 100%; height: auto; display: block; }

/* ---------- REVEAL ANIMATIONS ---------- */
.blog-reveal {
  opacity: 0; transform: translateY(40px);
  transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}
.blog-reveal.visible { opacity: 1; transform: translateY(0); }
.blog-stagger > * { transition-delay: calc(var(--i, 0) * 80ms); }

/* ---------- ANGLED DIVIDERS ---------- */
.blog-angle-divider {
  position: absolute; bottom: -1px; left: 0; right: 0; z-index: 1; pointer-events: none; line-height: 0;
}
.blog-angle-divider svg { display: block; width: 100%; height: 60px; }

/* =====================================================
   1. HERO (no featured post — brand moment only)
   ===================================================== */
.blog-hero {
  background: linear-gradient(170deg, #252C3A 0%, #1a1f2e 100%);
  padding: 180px 0 140px;
  color: #fff;
  position: relative;
  overflow: hidden;
}
/* Grid texture background */
.blog-hero-grid {
  position: absolute; inset: 0;
  background-image:
    linear-gradient(rgba(255,255,255,0.035) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255,255,255,0.035) 1px, transparent 1px);
  background-size: 60px 60px;
  background-position: center center;
  mask-image: radial-gradient(ellipse at center, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.85) 50%, rgba(0,0,0,1) 100%);
  -webkit-mask-image: radial-gradient(ellipse at center, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.85) 50%, rgba(0,0,0,1) 100%);
  transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  pointer-events: none;
}
/* Colored accent cells at edges (per design feedback) */
.blog-hero-cells { position: absolute; inset: 0; pointer-events: none; }
.blog-hero-cell {
  position: absolute; width: 60px; height: 60px;
  border-radius: 2px;
  opacity: 0.14;
  filter: blur(0.5px);
}
.blog-hero-cell.c1 { top: 12%;  left: 8%;  background: #8560A8; animation: blog-pulse 7s ease-in-out infinite; }
.blog-hero-cell.c2 { top: 72%;  left: 14%; background: #00BFF3; animation: blog-pulse 9s ease-in-out infinite 1s; }
.blog-hero-cell.c3 { top: 22%;  right: 10%; background: #448CCB; animation: blog-pulse 8s ease-in-out infinite 0.5s; }
.blog-hero-cell.c4 { top: 60%;  right: 6%; background: #5674B9; animation: blog-pulse 10s ease-in-out infinite 2s; }
.blog-hero-cell.c5 { top: 40%;  left: 40%; background: #00BFF3; width: 48px; height: 48px; opacity: 0.08; animation: blog-pulse 12s ease-in-out infinite; }
@keyframes blog-pulse {
  0%, 100% { opacity: 0.08; transform: scale(1); }
  50%      { opacity: 0.2;  transform: scale(1.15); }
}

.blog-hero-inner { position: relative; z-index: 2; text-align: center; max-width: 760px; margin: 0 auto; }
.blog-hero-overline {
  font-family: 'Montserrat', sans-serif;
  font-size: 13px; text-transform: uppercase; letter-spacing: 3px;
  color: #00BFF3; margin-bottom: 20px;
}
.blog-hero h1 {
  font-family: 'Poppins', sans-serif;
  font-size: 68px; font-weight: 600; line-height: 1.1;
  margin: 0 0 20px; letter-spacing: -1.5px;
}
.blog-hero-subtitle {
  font-family: 'Assistant', sans-serif;
  font-size: 20px; color: rgba(255,255,255,0.65);
  line-height: 1.6; margin: 0 auto 42px; max-width: 620px;
}
.blog-hero-stats {
  display: inline-flex; gap: 48px;
  font-family: 'Poppins', sans-serif;
  color: rgba(255,255,255,0.5);
  font-size: 14px;
  justify-content: center;
}
.blog-hero-stats strong {
  display: block;
  font-size: 28px; font-weight: 600; color: #fff; letter-spacing: -0.5px;
  margin-bottom: 2px;
}
.blog-hero-stats .stat-dot {
  display: inline-block; width: 5px; height: 5px; border-radius: 50%;
  background: #00BFF3; margin-right: 7px; vertical-align: middle;
  animation: blog-pulse-dot 2s ease-in-out infinite;
}
@keyframes blog-pulse-dot {
  0%, 100% { opacity: 1; transform: scale(1); }
  50%      { opacity: 0.4; transform: scale(1.3); }
}

/* Scroll cue */
.blog-hero-scrollcue {
  position: absolute; bottom: 40px; left: 50%; transform: translateX(-50%);
  color: rgba(255,255,255,0.4);
  font-family: 'Montserrat', sans-serif;
  font-size: 11px; text-transform: uppercase; letter-spacing: 3px;
  display: flex; flex-direction: column; align-items: center; gap: 10px;
  z-index: 2;
}
.blog-hero-scrollcue .chev {
  display: block; width: 14px; height: 14px;
  border-right: 2px solid rgba(255,255,255,0.4);
  border-bottom: 2px solid rgba(255,255,255,0.4);
  transform: rotate(45deg);
  animation: blog-chev 2s ease-in-out infinite;
}
@keyframes blog-chev {
  0%, 20%, 100% { transform: rotate(45deg) translate(0,0); opacity: 0.4; }
  50%           { transform: rotate(45deg) translate(4px,4px); opacity: 0.8; }
}

/* =====================================================
   2. HUB SHOWCASE (the centerpiece)
   ===================================================== */
.blog-hubs {
  background: #f9f9fb;
  padding: 110px 0 100px;
  position: relative;
  z-index: 3;
}
.blog-hubs-intro {
  text-align: center;
  max-width: 640px;
  margin: 0 auto 64px;
}
.blog-section-overline {
  font-family: 'Montserrat', sans-serif;
  font-size: 12px; text-transform: uppercase; letter-spacing: 3px;
  color: #8560A8; margin-bottom: 14px;
}
.blog-section-heading {
  font-family: 'Poppins', sans-serif;
  font-size: 40px; font-weight: 600; color: #252C3A;
  margin: 0 0 14px; letter-spacing: -0.5px;
}
.blog-section-lede {
  font-family: 'Assistant', sans-serif;
  font-size: 17px; color: #5a6276; line-height: 1.6;
  margin: 0;
}

/* Featured hub — frame with rotating conic gradient border */
.blog-featured-hub-frame {
  position: relative;
  border-radius: 22px;
  padding: 2px;
  margin-bottom: 32px;
  isolation: isolate;
  overflow: hidden;
}
.blog-featured-hub-frame::before {
  content: '';
  position: absolute;
  inset: -50%;
  z-index: 0;
  background: conic-gradient(from 0deg, transparent 0deg, var(--hub-color, #00BFF3) 60deg, transparent 180deg, #8560A8 300deg, transparent 360deg);
  animation: blog-frame-rotate 19s linear infinite;
  opacity: 0.85;
}
@keyframes blog-frame-rotate { to { transform: rotate(360deg); } }

.blog-featured-hub {
  background: #fff;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 4px 30px rgba(0,0,0,0.06);
  display: grid;
  grid-template-columns: 1fr 1fr;
  position: relative;
  z-index: 1;
  transition: box-shadow 0.5s ease, transform 0.2s cubic-bezier(0.16,1,0.3,1);
  text-decoration: none;
  color: inherit;
  transform-style: preserve-3d;
  will-change: transform;
}
.blog-featured-hub:hover {
  box-shadow: 0 24px 70px rgba(0,0,0,0.18);
}
.blog-featured-hub-visual {
  position: relative;
  background: linear-gradient(145deg, #1a1f2e 0%, #252C3A 50%, color-mix(in srgb, var(--hub-color, #00BFF3) 40%, #1a1f2e) 120%);
  min-height: 400px;
  overflow: hidden;
}
.blog-featured-hub-visual::after {
  content: '';
  position: absolute; inset: 0;
  background-image:
    linear-gradient(rgba(255,255,255,0.06) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255,255,255,0.06) 1px, transparent 1px);
  background-size: 40px 40px;
  mask-image: radial-gradient(ellipse at 50% 50%, rgba(0,0,0,0.5) 0%, rgba(0,0,0,0.15) 100%);
  -webkit-mask-image: radial-gradient(ellipse at 50% 50%, rgba(0,0,0,0.5) 0%, rgba(0,0,0,0.15) 100%);
  pointer-events: none;
}
.blog-featured-hub-badge {
  position: absolute; top: 28px; left: 28px; z-index: 3;
  font-family: 'Montserrat', sans-serif; font-size: 10px;
  text-transform: uppercase; letter-spacing: 2.5px; color: #fff;
  background: rgba(0,0,0,0.4); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);
  padding: 8px 14px; border-radius: 4px;
  border: 1px solid rgba(255,255,255,0.18);
}
.blog-featured-hub-title {
  position: absolute; bottom: 32px; left: 32px; right: 32px; z-index: 3;
  font-family: 'Poppins', sans-serif;
  font-size: 64px; font-weight: 600; color: #fff;
  letter-spacing: -2px; line-height: 1;
  margin: 0;
  background: linear-gradient(135deg, #fff 0%, rgba(255,255,255,0.5) 100%);
  -webkit-background-clip: text; background-clip: text;
  -webkit-text-fill-color: transparent;
}

/* Orbital graph (pillar + spokes viz) */
.blog-orbital {
  position: absolute;
  top: 50%; left: 50%;
  width: 86%; height: 86%;
  transform: translate(-50%, -50%);
  z-index: 2;
  overflow: visible;
}
.blog-orbital-rot {
  transform-origin: 50% 50%;
  animation: blog-orbital-rotate 80s linear infinite;
}
@keyframes blog-orbital-rotate { to { transform: rotate(360deg); } }
.blog-orbital-spoke {
  transform-origin: center;
  animation: blog-orbital-pulse 3.5s ease-in-out infinite;
  filter: drop-shadow(0 0 4px var(--hub-color, #00BFF3));
}
@keyframes blog-orbital-pulse {
  0%, 100% { opacity: 0.55; r: 2.2; }
  50%      { opacity: 1;    r: 2.8; }
}
.blog-orbital-halo {
  transform-origin: center;
  animation: blog-orbital-halo 3s ease-in-out infinite;
}
@keyframes blog-orbital-halo {
  0%, 100% { transform: scale(1);    opacity: 0.18; }
  50%      { transform: scale(1.25); opacity: 0.32; }
}

.blog-featured-hub-body {
  padding: 52px 48px;
  display: flex; flex-direction: column; justify-content: center;
  background: #fff;
  position: relative;
}
.blog-featured-hub-icon {
  display: inline-flex;
  width: 56px; height: 56px;
  color: var(--hub-color, #00BFF3);
  margin-bottom: 20px;
  padding: 10px;
  border-radius: 12px;
  background: color-mix(in srgb, var(--hub-color, #00BFF3) 10%, transparent);
  border: 1px solid color-mix(in srgb, var(--hub-color, #00BFF3) 18%, transparent);
}
.blog-featured-hub-icon svg { width: 100%; height: 100%; }
.blog-featured-hub-body h3 {
  font-family: 'Poppins', sans-serif;
  font-size: 28px; font-weight: 600; color: #252C3A;
  margin: 0 0 18px; line-height: 1.25; letter-spacing: -0.3px;
}
.blog-featured-hub-body .tagline {
  font-family: 'Assistant', sans-serif;
  font-size: 17px; color: #5a6276; line-height: 1.6;
  margin: 0 0 32px;
}
.blog-featured-hub-meta {
  display: flex; align-items: center; gap: 20px;
  font-family: 'Poppins', sans-serif; font-size: 14px; color: #8590a6;
  margin-bottom: 32px;
}
.blog-featured-hub-meta .dot {
  display: inline-block; width: 6px; height: 6px; border-radius: 50%;
  background: var(--hub-color, #00BFF3); margin-right: 8px; vertical-align: middle;
}
.blog-featured-hub-meta .sep { opacity: 0.3; }
.blog-featured-hub-cta {
  display: inline-flex; align-items: center; gap: 10px;
  font-family: 'Poppins', sans-serif; font-size: 15px; font-weight: 500;
  color: var(--hub-color, #00BFF3);
  transition: gap 0.3s ease;
}
.blog-featured-hub:hover .blog-featured-hub-cta { gap: 16px; }

/* Regular hub grid */
.blog-hub-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 24px;
}
.blog-hub-card-wrap {
  position: relative;
  perspective: 1200px;
  z-index: 3;
}
.blog-hub-card-wrap:hover,
.blog-hub-card-wrap:focus-within {
  z-index: 50;
}
.blog-hub-card {
  background: #fff;
  border-radius: 16px;
  padding: 32px 28px;
  border-top: 4px solid var(--hub-color, #8560A8);
  box-shadow: 0 2px 16px rgba(0,0,0,0.05);
  transition: box-shadow 0.4s ease, transform 0.2s cubic-bezier(0.16,1,0.3,1);
  text-decoration: none;
  display: flex;
  flex-direction: column;
  position: relative;
  overflow: hidden;
  min-height: 240px;
  transform-style: preserve-3d;
  will-change: transform;
}
.blog-hub-card::after {
  content: '';
  position: absolute; inset: 0;
  background: radial-gradient(circle 220px at var(--glow-x, 50%) var(--glow-y, 50%), var(--hub-color, #8560A8) 0%, transparent 60%);
  opacity: 0; transition: opacity 0.4s ease;
  pointer-events: none;
  mix-blend-mode: multiply;
}
.blog-hub-card-wrap:hover .blog-hub-card {
  box-shadow: 0 20px 50px rgba(0,0,0,0.12);
}
.blog-hub-card-wrap:hover .blog-hub-card::after { opacity: 0.1; }

.blog-hub-card-icon {
  display: inline-flex;
  width: 48px; height: 48px;
  color: var(--hub-color, #8560A8);
  margin-bottom: 16px;
  padding: 9px;
  border-radius: 11px;
  background: color-mix(in srgb, var(--hub-color, #8560A8) 10%, transparent);
  border: 1px solid color-mix(in srgb, var(--hub-color, #8560A8) 18%, transparent);
  transition: transform 0.4s cubic-bezier(0.16,1,0.3,1), background 0.3s ease;
}
.blog-hub-card-icon svg { width: 100%; height: 100%; }
.blog-hub-card-wrap:hover .blog-hub-card-icon {
  transform: rotate(-6deg) scale(1.08);
  background: color-mix(in srgb, var(--hub-color, #8560A8) 16%, transparent);
}

.blog-hub-card-count {
  font-family: 'Montserrat', sans-serif; font-size: 11px;
  text-transform: uppercase; letter-spacing: 2px;
  color: var(--hub-color, #8560A8);
  margin-bottom: 10px;
  display: flex; align-items: center; gap: 8px;
}
.blog-hub-card-count::before {
  content: ''; display: inline-block; width: 5px; height: 5px; border-radius: 50%;
  background: var(--hub-color, #8560A8);
}
.blog-hub-card h3 {
  font-family: 'Poppins', sans-serif;
  font-size: 22px; font-weight: 600; color: #252C3A;
  margin: 0 0 10px; line-height: 1.25; letter-spacing: -0.3px;
}
.blog-hub-card p {
  font-family: 'Assistant', sans-serif; font-size: 15px;
  color: #5a6276; line-height: 1.55; margin: 0 0 20px; flex: 1;
}
.blog-hub-card-link {
  font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 500;
  color: var(--hub-color, #8560A8);
  display: inline-flex; align-items: center; gap: 6px;
  transition: gap 0.3s ease;
}
.blog-hub-card-wrap:hover .blog-hub-card-link { gap: 12px; }

/* Hover preview — slides down below card */
.blog-hub-card-preview {
  position: absolute;
  top: calc(100% - 6px);
  left: 0; right: 0;
  background: #fff;
  border-radius: 0 0 16px 16px;
  padding: 18px 28px 22px;
  box-shadow: 0 20px 40px rgba(0,0,0,0.12), 0 0 0 1px rgba(0,0,0,0.03);
  border-top: 1px solid rgba(0,0,0,0.04);
  opacity: 0;
  transform: translateY(-8px);
  pointer-events: none;
  transition: opacity 0.35s ease, transform 0.35s cubic-bezier(0.16,1,0.3,1);
  z-index: 15;
}
.blog-hub-card-wrap:hover .blog-hub-card-preview,
.blog-hub-card-wrap:focus-within .blog-hub-card-preview {
  opacity: 1;
  transform: translateY(0);
  pointer-events: auto;
}
.blog-hub-card-preview-label {
  font-family: 'Montserrat', sans-serif; font-size: 10px;
  text-transform: uppercase; letter-spacing: 2px;
  color: var(--hub-color, #8560A8);
  margin-bottom: 12px;
  display: flex; align-items: center; gap: 6px;
}
.blog-hub-card-preview-label::before {
  content: ''; width: 12px; height: 1px; background: var(--hub-color, #8560A8);
}
.blog-hub-card-preview ul {
  list-style: none; padding: 0; margin: 0;
  display: flex; flex-direction: column; gap: 2px;
}
.blog-hub-card-preview li a {
  display: flex; justify-content: space-between; align-items: baseline; gap: 12px;
  padding: 7px 0;
  text-decoration: none;
  font-family: 'Assistant', sans-serif;
  border-bottom: 1px solid rgba(0,0,0,0.05);
  transition: color 0.2s ease;
}
.blog-hub-card-preview li:last-child a { border-bottom: none; }
.blog-hub-card-preview .prev-title {
  font-size: 14px; color: #252C3A; font-weight: 500;
  line-height: 1.4;
  flex: 1;
  display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden;
}
.blog-hub-card-preview .prev-date {
  font-size: 12px; color: #8590a6; white-space: nowrap;
}
.blog-hub-card-preview li a:hover .prev-title { color: var(--hub-color, #8560A8); }

/* Chapter markers — giant faded section numbers */
.blog-chapter-mark {
  position: absolute;
  top: 32px; right: 40px;
  font-family: 'Poppins', sans-serif;
  font-size: 200px; font-weight: 700;
  line-height: 0.85;
  letter-spacing: -8px;
  color: transparent;
  -webkit-text-stroke: 1.5px rgba(37,44,58,0.06);
  pointer-events: none;
  z-index: 1;
  user-select: none;
}
.blog-browse .blog-chapter-mark { -webkit-text-stroke-color: rgba(37,44,58,0.05); }
.blog-hubs .blog-container,
.blog-browse .blog-container { position: relative; z-index: 2; }

/* =====================================================
   3. BROWSE ALL (search + filter + posts)
   ===================================================== */
.blog-browse {
  background: #fff;
  padding: 100px 0 120px;
  position: relative;
}
.blog-browse-header {
  text-align: center;
  margin-bottom: 48px;
}

/* Sticky filter bar */
.blog-filter-bar {
  position: sticky;
  top: 78px;
  z-index: 40;
  background: rgba(255,255,255,0.92);
  backdrop-filter: blur(14px);
  -webkit-backdrop-filter: blur(14px);
  border-radius: 14px;
  padding: 16px 20px;
  margin-bottom: 40px;
  box-shadow: 0 4px 24px rgba(0,0,0,0.06), 0 0 0 1px rgba(0,0,0,0.04);
  transition: box-shadow 0.3s ease, transform 0.3s ease;
}
.admin-bar .blog-filter-bar { top: 110px; }
@media (max-width: 782px) { .admin-bar .blog-filter-bar { top: 124px; } }

.blog-filter-bar.stuck {
  box-shadow: 0 8px 30px rgba(0,0,0,0.1), 0 0 0 1px rgba(0,0,0,0.06);
}
.blog-filter-row {
  display: flex; align-items: center; gap: 16px;
}
.blog-search {
  position: relative;
  flex: 0 0 340px;
}
.blog-search-icon {
  position: absolute;
  left: 14px; top: 50%; transform: translateY(-50%);
  width: 18px; height: 18px;
  color: #8590a6; pointer-events: none;
}
.blog-search input {
  width: 100%;
  padding: 12px 40px 12px 42px;
  border-radius: 10px;
  border: 1px solid rgba(0,0,0,0.08);
  background: #f9f9fb;
  font-family: 'Assistant', sans-serif; font-size: 15px;
  color: #252C3A;
  outline: none;
  transition: border-color 0.2s ease, background 0.2s ease, box-shadow 0.2s ease;
}
.blog-search input::placeholder { color: #a0a8b8; }
.blog-search input:focus {
  border-color: #8560A8;
  background: #fff;
  box-shadow: 0 0 0 3px rgba(133,96,168,0.12);
}
.blog-search-clear {
  position: absolute;
  right: 10px; top: 50%; transform: translateY(-50%);
  width: 24px; height: 24px;
  display: none; align-items: center; justify-content: center;
  border: none; background: rgba(0,0,0,0.08); border-radius: 50%;
  cursor: pointer; color: #5a6276;
  font-size: 14px; line-height: 1;
  transition: background 0.2s ease;
}
.blog-search-clear:hover { background: rgba(0,0,0,0.14); }
.blog-search-clear.visible { display: flex; }

/* Chips — scrollable on mobile */
.blog-chips {
  flex: 1;
  display: flex; gap: 8px; align-items: center;
  overflow-x: auto;
  scrollbar-width: none;
  -ms-overflow-style: none;
  padding: 2px 2px;
}
.blog-chips::-webkit-scrollbar { display: none; }
.blog-chip {
  flex-shrink: 0;
  display: inline-flex; align-items: center; gap: 8px;
  padding: 8px 14px;
  border-radius: 999px;
  border: 1px solid rgba(0,0,0,0.1);
  background: #fff;
  font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 500;
  color: #5a6276;
  cursor: pointer;
  transition: all 0.2s ease;
  white-space: nowrap;
}
.blog-chip:hover { border-color: rgba(0,0,0,0.18); color: #252C3A; }
.blog-chip .chip-count {
  font-size: 11px; color: #a0a8b8;
  background: rgba(0,0,0,0.04);
  padding: 2px 7px; border-radius: 999px;
  transition: color 0.2s ease, background 0.2s ease;
}
.blog-chip.active {
  background: var(--chip-color, #252C3A);
  border-color: var(--chip-color, #252C3A);
  color: #fff;
}
.blog-chip.active .chip-count {
  background: rgba(255,255,255,0.2); color: rgba(255,255,255,0.85);
}

/* Result meta row */
.blog-result-meta {
  display: flex; justify-content: space-between; align-items: center;
  margin-bottom: 20px;
  font-family: 'Assistant', sans-serif; font-size: 14px;
  color: #8590a6;
}
.blog-result-meta strong { color: #252C3A; font-weight: 600; }
.blog-result-reset {
  background: none; border: none; cursor: pointer;
  font-family: 'Poppins', sans-serif; font-size: 13px; color: #8560A8;
  font-weight: 500;
  display: none;
}
.blog-result-reset.visible { display: inline-block; }
.blog-result-reset:hover { text-decoration: underline; }

/* Posts grid */
.blog-posts-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 28px;
  min-height: 200px;
}
.blog-card {
  background: #fff;
  border-radius: 14px;
  overflow: hidden;
  box-shadow: 0 2px 16px rgba(0,0,0,0.05);
  transition: transform 0.4s ease, box-shadow 0.4s ease;
  border: 1px solid rgba(0,0,0,0.04);
  display: flex; flex-direction: column;
  opacity: 0;
  transform: translateY(16px);
  animation: blog-card-in 0.5s cubic-bezier(0.16,1,0.3,1) forwards;
}
@keyframes blog-card-in {
  to { opacity: 1; transform: translateY(0); }
}
.blog-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 16px 48px rgba(0,0,0,0.1);
}
.blog-card-image {
  aspect-ratio: 16/10;
  overflow: hidden;
  display: block;
  position: relative;
}
.blog-card-image img {
  width: 100%; height: 100%; object-fit: cover;
  transition: transform 0.6s ease;
}
.blog-card:hover .blog-card-image img { transform: scale(1.06); }
.blog-card-image-fallback {
  width: 100%; height: 100%;
  background: linear-gradient(135deg, var(--card-color, #8560A8) 0%, #1a1f2e 120%);
  display: flex; align-items: center; justify-content: center;
  position: relative;
  overflow: hidden;
}
.blog-card-image-fallback::after {
  content: '';
  position: absolute; inset: 0;
  background-image:
    linear-gradient(rgba(255,255,255,0.06) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255,255,255,0.06) 1px, transparent 1px);
  background-size: 24px 24px;
}
.blog-card-image-fallback span {
  position: relative; z-index: 1;
  font-family: 'Poppins', sans-serif; font-size: 20px; font-weight: 500;
  color: rgba(255,255,255,0.85);
  letter-spacing: -0.3px;
  padding: 0 20px; text-align: center;
}
.blog-card-body {
  padding: 24px;
  flex: 1; display: flex; flex-direction: column;
}
.blog-card-body .cat-badge {
  display: inline-flex; align-items: center; gap: 6px;
  font-family: 'Montserrat', sans-serif; font-size: 10px;
  text-transform: uppercase; letter-spacing: 2px;
  color: var(--card-color, #8560A8);
  margin-bottom: 12px;
  width: fit-content;
  text-decoration: none;
}
.blog-card-body .cat-badge::before {
  content: ''; width: 5px; height: 5px; border-radius: 50%;
  background: var(--card-color, #8560A8);
}
.blog-card-body h3 {
  font-family: 'Poppins', sans-serif;
  font-size: 19px; font-weight: 600; color: #252C3A;
  margin: 0 0 10px; line-height: 1.35;
  letter-spacing: -0.2px;
}
.blog-card-body h3 a { color: inherit; text-decoration: none; transition: color 0.2s ease; }
.blog-card-body h3 a:hover { color: var(--card-color, #8560A8); }
.blog-card-body p {
  font-family: 'Assistant', sans-serif;
  font-size: 15px; color: #5a6276;
  line-height: 1.55; margin: 0 0 18px;
  display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
  flex: 1;
}
.blog-card-footer {
  font-family: 'Assistant', sans-serif; font-size: 13px; color: #8590a6;
  display: flex; justify-content: space-between; align-items: center;
  padding-top: 14px; border-top: 1px solid rgba(0,0,0,0.05);
}
.blog-card-footer .read-time {
  display: inline-flex; align-items: center; gap: 5px;
}

/* Highlight for search matches */
.blog-highlight {
  background: linear-gradient(120deg, rgba(0,191,243,0.18) 0%, rgba(133,96,168,0.18) 100%);
  padding: 1px 3px; border-radius: 3px;
  color: inherit;
}

/* Load more */
.blog-loadmore-wrap {
  text-align: center;
  margin-top: 56px;
}
.blog-loadmore {
  display: inline-flex; align-items: center; gap: 10px;
  padding: 14px 32px;
  background: #fff;
  border: 1px solid rgba(0,0,0,0.1);
  border-radius: 999px;
  font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 500;
  color: #252C3A;
  cursor: pointer;
  transition: all 0.3s ease;
}
.blog-loadmore:hover {
  border-color: #8560A8;
  color: #8560A8;
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(133,96,168,0.15);
}
.blog-loadmore[hidden] { display: none; }
.blog-loadmore-count {
  font-size: 12px; color: #8590a6; font-weight: 400;
}

/* Empty state */
.blog-empty {
  text-align: center;
  padding: 80px 40px;
  grid-column: 1 / -1;
}
.blog-empty-icon {
  font-size: 48px; margin-bottom: 16px; color: rgba(0,0,0,0.15);
}
.blog-empty h4 {
  font-family: 'Poppins', sans-serif; font-size: 22px; color: #252C3A;
  margin: 0 0 8px; font-weight: 600;
}
.blog-empty p {
  font-family: 'Assistant', sans-serif; font-size: 15px; color: #5a6276;
  margin: 0 0 24px;
}
.blog-empty button {
  padding: 12px 26px;
  background: linear-gradient(135deg, #8560A8, #5674B9);
  color: #fff;
  border: none; border-radius: 8px;
  font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 500;
  cursor: pointer;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.blog-empty button:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(133,96,168,0.3);
}

/* =====================================================
   4. NEWSLETTER CTA
   ===================================================== */
.blog-newsletter {
  background: linear-gradient(170deg, #252C3A, #1a1f2e);
  padding: 100px 0;
  color: #fff;
  position: relative;
  overflow: hidden;
}
.blog-newsletter::before {
  content: '';
  position: absolute; inset: 0;
  background-image:
    linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
  background-size: 60px 60px;
  mask-image: radial-gradient(ellipse at center, rgba(0,0,0,0.6) 0%, rgba(0,0,0,1) 100%);
  -webkit-mask-image: radial-gradient(ellipse at center, rgba(0,0,0,0.6) 0%, rgba(0,0,0,1) 100%);
  pointer-events: none;
}
.blog-newsletter-inner {
  position: relative; z-index: 2;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 60px;
  align-items: center;
}
.blog-newsletter h2 {
  font-family: 'Poppins', sans-serif;
  font-size: 38px; font-weight: 600;
  margin: 0 0 12px; letter-spacing: -0.5px;
  color: #fff;
}
.blog-newsletter .nl-subtitle {
  font-family: 'Assistant', sans-serif;
  font-size: 17px; color: rgba(255,255,255,0.6); line-height: 1.6;
}
.blog-newsletter-form {
  display: flex; gap: 12px;
}
.blog-newsletter-form input[type="email"] {
  flex: 1;
  padding: 16px 20px;
  border-radius: 10px;
  border: 1px solid rgba(255,255,255,0.15);
  background: rgba(255,255,255,0.06);
  color: #fff;
  font-family: 'Assistant', sans-serif; font-size: 16px;
  outline: none;
  transition: border-color 0.3s ease;
}
.blog-newsletter-form input[type="email"]::placeholder { color: rgba(255,255,255,0.35); }
.blog-newsletter-form input[type="email"]:focus { border-color: #00BFF3; }
.blog-newsletter-form button {
  padding: 16px 32px;
  border: none; border-radius: 10px;
  background: linear-gradient(135deg, #8560A8, #5674B9);
  color: #fff;
  font-family: 'Poppins', sans-serif; font-size: 15px; font-weight: 500;
  cursor: pointer;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  white-space: nowrap;
}
.blog-newsletter-form button:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 30px rgba(133,96,168,0.4);
}

/* =====================================================
   5. FINAL CTA
   ===================================================== */
.blog-cta-final {
  background: linear-gradient(135deg, #8560A8, #5674B9);
  padding: 90px 0;
  text-align: center;
  color: #fff;
  position: relative;
  overflow: hidden;
}
.blog-cta-final::before {
  content: '';
  position: absolute; inset: 0;
  background-image: linear-gradient(rgba(255,255,255,0.06) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.06) 1px, transparent 1px);
  background-size: 50px 50px;
  pointer-events: none;
}
.blog-cta-final-inner { position: relative; z-index: 2; }
.blog-cta-final h2 {
  font-family: 'Poppins', sans-serif;
  font-size: 40px; font-weight: 600;
  margin: 0 0 14px; letter-spacing: -0.5px;
  color: #fff;
}
.blog-cta-final p {
  font-family: 'Assistant', sans-serif;
  font-size: 17px; color: rgba(255,255,255,0.85);
  margin: 0 auto 30px; max-width: 560px;
}
.blog-cta-final .cta-btn {
  display: inline-block;
  padding: 16px 40px;
  background: #fff;
  color: #8560A8;
  font-family: 'Poppins', sans-serif; font-size: 15px; font-weight: 600;
  border-radius: 10px;
  text-decoration: none;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.blog-cta-final .cta-btn:hover {
  transform: translateY(-3px);
  box-shadow: 0 12px 36px rgba(0,0,0,0.25);
}

/* =====================================================
   RESPONSIVE
   ===================================================== */
@media (max-width: 1100px) {
  .blog-featured-hub-title { font-size: 48px; }
  .blog-featured-hub-body { padding: 40px 36px; }
  .blog-featured-hub-body h3 { font-size: 24px; }
  .blog-chapter-mark { font-size: 160px; }
}
@media (max-width: 960px) {
  .blog-posts-grid { grid-template-columns: repeat(2, 1fr); }
  .blog-hub-grid { grid-template-columns: repeat(2, 1fr); }
  .blog-featured-hub { grid-template-columns: 1fr; }
  .blog-featured-hub-visual { min-height: 300px; }
  .blog-featured-hub-title { font-size: 42px; }
  .blog-featured-hub-body { padding: 36px 32px; }
  .blog-newsletter-inner { grid-template-columns: 1fr; gap: 32px; }
  .blog-hero h1 { font-size: 52px; }
  .blog-filter-row { flex-wrap: wrap; }
  .blog-search { flex: 1 1 100%; }
  .blog-chapter-mark { font-size: 120px; right: 24px; top: 24px; }
  /* Disable hover preview on tablet (touch) */
  .blog-hub-card-preview { display: none; }
  .blog-hub-card { min-height: 220px; }
}
@media (max-width: 768px) {
  .blog-container { padding: 0 24px; }
  .blog-hero { padding: 140px 0 110px; }
  .blog-hero h1 { font-size: 42px; }
  .blog-hero-subtitle { font-size: 16px; }
  .blog-hero-stats { gap: 32px; font-size: 12px; }
  .blog-hero-stats strong { font-size: 22px; }
  .blog-section-heading { font-size: 30px; }
  .blog-hubs, .blog-browse, .blog-newsletter { padding: 70px 0; }
  .blog-featured-hub-title { font-size: 34px; letter-spacing: -1px; }
  .blog-featured-hub-visual { min-height: 240px; }
  .blog-featured-hub-body { padding: 28px 24px; }
  .blog-featured-hub-body h3 { font-size: 22px; }
  .blog-featured-hub-icon { width: 44px; height: 44px; margin-bottom: 14px; }
  .blog-newsletter-form { flex-direction: column; }
  .blog-cta-final h2 { font-size: 30px; }
  .blog-hero-scrollcue { bottom: 24px; }
  .blog-chapter-mark { font-size: 90px; right: 16px; top: 16px; letter-spacing: -4px; }
}
@media (max-width: 560px) {
  .blog-posts-grid { grid-template-columns: 1fr; }
  .blog-hub-grid { grid-template-columns: 1fr; }
  .blog-hero h1 { font-size: 34px; }
  .blog-search { flex-basis: auto; }
  .blog-filter-bar { padding: 14px; }
}

/* Respect reduced motion */
@media (prefers-reduced-motion: reduce) {
  .blog-featured-hub-frame::before,
  .blog-orbital-rot,
  .blog-orbital-spoke,
  .blog-orbital-halo,
  .blog-hero-cell,
  .blog-hero-scrollcue .chev { animation: none; }
}
</style>

<!-- =====================================================
     1. HERO
     ===================================================== -->
<section class="blog-section blog-hero">
  <div class="blog-hero-grid" id="blogHeroGrid"></div>
  <div class="blog-hero-cells">
    <span class="blog-hero-cell c1"></span>
    <span class="blog-hero-cell c2"></span>
    <span class="blog-hero-cell c3"></span>
    <span class="blog-hero-cell c4"></span>
    <span class="blog-hero-cell c5"></span>
  </div>
  <div class="blog-container">
    <div class="blog-hero-inner blog-reveal">
      <div class="blog-hero-overline">Insights &amp; Ideas</div>
      <h1>The Stretch Creative <span class="blog-gradient-text">Blog</span></h1>
      <p class="blog-hero-subtitle">Expert perspectives on content strategy, SEO, AEO, and the future of digital storytelling — organized by the topics that matter to your growth.</p>
      <div class="blog-hero-stats">
        <div><strong><?php echo $total_posts_count; ?></strong><span class="stat-dot"></span>Articles</div>
        <div><strong><?php echo count($chip_hubs); ?></strong><span class="stat-dot"></span>Topic Hubs</div>
        <div><strong>Weekly</strong><span class="stat-dot"></span>New Drops</div>
      </div>
    </div>
  </div>
  <a href="#hubs" class="blog-hero-scrollcue" aria-label="Scroll to explore">
    <span>Explore</span>
    <span class="chev" aria-hidden="true"></span>
  </a>
  <div class="blog-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none"><polygon points="0,60 1440,0 1440,60" fill="#f9f9fb"/></svg>
  </div>
</section>

<!-- =====================================================
     2. HUB SHOWCASE
     ===================================================== -->
<section class="blog-section blog-hubs" id="hubs">
  <span class="blog-chapter-mark" aria-hidden="true">01</span>
  <div class="blog-container">
    <div class="blog-hubs-intro blog-reveal">
      <div class="blog-section-overline">Explore by Topic</div>
      <h2 class="blog-section-heading">Deep dives, organized by hub</h2>
      <p class="blog-section-lede">Each hub is a curated body of work — a pillar guide plus the supporting articles that go deeper on the specifics.</p>
    </div>

    <?php if (!empty($featured_hubs)) : foreach ($featured_hubs as $fh) :
      $fcat = $fh['cat'];
      $fhub = $fh['hub'];
      $fcolor = $hub_meta[$fcat->slug]['color'] ?? $default_color;
      $ftagline = $hub_meta[$fcat->slug]['tagline'] ?? ($fhub['subtitle'] ?? '');
      $spoke_count = min(12, max(3, ((int) $fcat->count) - 1));
    ?>
    <div class="blog-featured-hub-frame blog-reveal" style="--hub-color: <?php echo esc_attr($fcolor); ?>;">
      <a href="<?php echo esc_url(get_category_link($fcat->term_id)); ?>" class="blog-featured-hub" data-tilt>
        <div class="blog-featured-hub-visual">
          <span class="blog-featured-hub-badge">Featured Hub · Pillar Guide</span>
          <svg class="blog-orbital" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <!-- faint orbit ring -->
            <circle cx="50" cy="50" r="36" fill="none" stroke="rgba(255,255,255,0.12)" stroke-width="0.4" stroke-dasharray="1 2"/>
            <circle cx="50" cy="50" r="24" fill="none" stroke="rgba(255,255,255,0.06)" stroke-width="0.3" stroke-dasharray="0.6 2"/>
            <!-- rotating spokes group -->
            <g class="blog-orbital-rot">
              <?php
              for ($i = 0; $i < $spoke_count; $i++) :
                $angle = (360 / $spoke_count) * $i - 90;
                $rad   = deg2rad($angle);
                $sx    = 50 + 36 * cos($rad);
                $sy    = 50 + 36 * sin($rad);
                $delay = ($i % 5) * 0.4;
              ?>
              <line x1="50" y1="50" x2="<?php echo number_format($sx, 2); ?>" y2="<?php echo number_format($sy, 2); ?>" stroke="<?php echo esc_attr($fcolor); ?>" stroke-width="0.4" stroke-opacity="0.35"/>
              <circle class="blog-orbital-spoke" cx="<?php echo number_format($sx, 2); ?>" cy="<?php echo number_format($sy, 2); ?>" r="2.2" fill="<?php echo esc_attr($fcolor); ?>" style="animation-delay: <?php echo $delay; ?>s;"/>
              <?php endfor; ?>
            </g>
            <!-- pillar node (center) -->
            <circle cx="50" cy="50" r="11" fill="<?php echo esc_attr($fcolor); ?>" opacity="0.18" class="blog-orbital-halo"/>
            <circle cx="50" cy="50" r="7"  fill="<?php echo esc_attr($fcolor); ?>"/>
            <circle cx="50" cy="50" r="2.2" fill="#fff"/>
          </svg>
          <h3 class="blog-featured-hub-title"><?php echo esc_html($fcat->name); ?></h3>
        </div>
        <div class="blog-featured-hub-body">
          <span class="blog-featured-hub-icon" aria-hidden="true"><?php echo stretch_blog_hub_icon($fcat->slug); ?></span>
          <h3><?php echo esc_html($fhub['headline'] ?? $fcat->name); ?></h3>
          <p class="tagline"><?php echo esc_html($ftagline); ?></p>
          <div class="blog-featured-hub-meta">
            <span><span class="dot"></span><?php echo (int) $fcat->count; ?> Articles</span>
            <span class="sep">·</span>
            <span>Pillar + <?php echo max(0, ((int)$fcat->count) - 1); ?> supporting guides</span>
          </div>
          <span class="blog-featured-hub-cta">Enter the <?php echo esc_html($fcat->name); ?> hub &rarr;</span>
        </div>
      </a>
    </div>
    <?php endforeach; endif; ?>

    <div class="blog-hub-grid blog-stagger">
      <?php foreach ($regular_hubs as $i => $cat) :
        $color   = $hub_meta[$cat->slug]['color'] ?? $default_color;
        $tagline = $hub_meta[$cat->slug]['tagline'] ?? ($cat->description ?: 'Articles and insights from the Stretch Creative team.');
        $preview = $hub_previews[$cat->slug] ?? [];
      ?>
      <div class="blog-hub-card-wrap blog-reveal" style="--hub-color: <?php echo esc_attr($color); ?>; --i: <?php echo (int) $i; ?>;">
        <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" class="blog-hub-card" data-tilt>
          <span class="blog-hub-card-icon" aria-hidden="true"><?php echo stretch_blog_hub_icon($cat->slug); ?></span>
          <div class="blog-hub-card-count"><?php echo (int) $cat->count; ?> <?php echo $cat->count === 1 ? 'Article' : 'Articles'; ?></div>
          <h3><?php echo esc_html($cat->name); ?></h3>
          <p><?php echo esc_html($tagline); ?></p>
          <span class="blog-hub-card-link">Browse hub &rarr;</span>
        </a>
        <?php if (!empty($preview)) : ?>
        <div class="blog-hub-card-preview" aria-hidden="true">
          <div class="blog-hub-card-preview-label">Recently published</div>
          <ul>
            <?php foreach ($preview as $p) : ?>
            <li>
              <a href="<?php echo esc_url($p['url']); ?>">
                <span class="prev-title"><?php echo esc_html($p['title']); ?></span>
                <span class="prev-date"><?php echo esc_html($p['date']); ?></span>
              </a>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php endif; ?>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="blog-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none"><polygon points="0,0 1440,60 1440,60 0,60" fill="#fff"/></svg>
  </div>
</section>

<!-- =====================================================
     3. BROWSE ALL
     ===================================================== -->
<section class="blog-section blog-browse" id="browse">
  <span class="blog-chapter-mark" aria-hidden="true">02</span>
  <div class="blog-container">
    <div class="blog-browse-header blog-reveal">
      <div class="blog-section-overline" style="color: #00BFF3;">The Archive</div>
      <h2 class="blog-section-heading">Browse every article</h2>
      <p class="blog-section-lede">Search by keyword, filter by hub, or just scroll. Everything we've ever published — in one place.</p>
    </div>

    <div class="blog-filter-bar blog-reveal" id="blogFilterBar">
      <div class="blog-filter-row">
        <div class="blog-search">
          <svg class="blog-search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"></circle>
            <path d="m21 21-4.35-4.35"></path>
          </svg>
          <input type="search" id="blogSearchInput" placeholder="Search articles…" autocomplete="off" aria-label="Search articles">
          <button type="button" class="blog-search-clear" id="blogSearchClear" aria-label="Clear search">&times;</button>
        </div>
        <div class="blog-chips" id="blogChips">
          <button type="button" class="blog-chip active" data-hub="all" style="--chip-color: #252C3A;">
            All <span class="chip-count"><?php echo $total_posts_count; ?></span>
          </button>
          <?php foreach ($chip_data as $cd) : ?>
          <button type="button" class="blog-chip" data-hub="<?php echo esc_attr($cd['slug']); ?>" style="--chip-color: <?php echo esc_attr($cd['color']); ?>;">
            <?php echo esc_html($cd['name']); ?> <span class="chip-count"><?php echo (int) $cd['count']; ?></span>
          </button>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <div class="blog-result-meta">
      <div id="blogResultCount">Showing <strong><?php echo min(9, $total_posts_count); ?></strong> of <strong><?php echo $total_posts_count; ?></strong> articles</div>
      <button type="button" class="blog-result-reset" id="blogResultReset">Clear filters</button>
    </div>

    <div class="blog-posts-grid" id="blogPostsGrid" aria-live="polite"></div>

    <div class="blog-loadmore-wrap">
      <button type="button" class="blog-loadmore" id="blogLoadMore" hidden>
        Load more
        <span class="blog-loadmore-count" id="blogLoadMoreCount"></span>
      </button>
    </div>
  </div>

  <div class="blog-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none"><polygon points="0,60 1440,0 1440,60" fill="#252C3A"/></svg>
  </div>
</section>

<!-- =====================================================
     4. NEWSLETTER CTA
     ===================================================== -->
<section class="blog-section blog-newsletter">
  <div class="blog-container">
    <div class="blog-newsletter-inner blog-reveal">
      <div>
        <h2>Stay in the loop</h2>
        <p class="nl-subtitle">Get the latest on content strategy, SEO, and AEO delivered to your inbox. No spam, just the work we think matters.</p>
      </div>
      <div>
        <form class="blog-newsletter-form" onsubmit="return false;">
          <input type="email" placeholder="your@email.com" aria-label="Email address">
          <button type="submit">Subscribe</button>
        </form>
      </div>
    </div>
  </div>
  <div class="blog-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none"><polygon points="0,0 1440,60 1440,60 0,60" fill="#8560A8"/></svg>
  </div>
</section>

<!-- =====================================================
     5. FINAL CTA
     ===================================================== -->
<section class="blog-section blog-cta-final">
  <div class="blog-container blog-cta-final-inner blog-reveal">
    <h2>Ready to scale your content?</h2>
    <p>If you've read this far, you're serious about content. Let's talk about what Stretch Creative can build with you.</p>
    <a href="<?php echo esc_url(home_url('/contact-stretch-creative/')); ?>" class="cta-btn">Get Started</a>
  </div>
</section>

<script>
(function () {
  // ───── DATA ─────
  var POSTS = <?php echo wp_json_encode($posts_data); ?> || [];
  var PAGE_SIZE = 9;

  // ───── ELEMENTS ─────
  var grid         = document.getElementById('blogPostsGrid');
  var searchInput  = document.getElementById('blogSearchInput');
  var searchClear  = document.getElementById('blogSearchClear');
  var chipsWrap    = document.getElementById('blogChips');
  var resultCount  = document.getElementById('blogResultCount');
  var resultReset  = document.getElementById('blogResultReset');
  var loadMoreBtn  = document.getElementById('blogLoadMore');
  var loadMoreCnt  = document.getElementById('blogLoadMoreCount');
  var filterBar    = document.getElementById('blogFilterBar');
  var heroGrid     = document.getElementById('blogHeroGrid');

  // ───── STATE ─────
  var state = { query: '', hub: 'all', visible: PAGE_SIZE };

  // ───── UTIL ─────
  function escapeHTML(str) {
    return String(str).replace(/[&<>"']/g, function (c) {
      return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
    });
  }
  function escapeRegExp(str) {
    return str.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
  }
  function highlight(text, q) {
    if (!q) return escapeHTML(text);
    var safe = escapeHTML(text);
    var re = new RegExp('(' + escapeRegExp(q) + ')', 'ig');
    return safe.replace(re, '<mark class="blog-highlight">$1</mark>');
  }
  function debounce(fn, ms) {
    var t;
    return function () {
      var args = arguments, ctx = this;
      clearTimeout(t);
      t = setTimeout(function () { fn.apply(ctx, args); }, ms);
    };
  }

  // ───── URL SYNC ─────
  function readUrlState() {
    try {
      var params = new URLSearchParams(window.location.search);
      var q = params.get('q'); var h = params.get('hub');
      if (q) state.query = q;
      if (h) state.hub = h;
    } catch (e) { /* noop */ }
  }
  function writeUrlState(replace) {
    try {
      var params = new URLSearchParams();
      if (state.query) params.set('q', state.query);
      if (state.hub && state.hub !== 'all') params.set('hub', state.hub);
      var qs = params.toString();
      var url = window.location.pathname + (qs ? '?' + qs : '') + window.location.hash;
      if (replace) history.replaceState(null, '', url);
      else history.pushState(null, '', url);
    } catch (e) { /* noop */ }
  }

  // ───── FILTER ─────
  function getFiltered() {
    var q = state.query.trim().toLowerCase();
    return POSTS.filter(function (p) {
      if (state.hub !== 'all' && p.cat_slug !== state.hub) return false;
      if (!q) return true;
      return (p.title.toLowerCase().indexOf(q) !== -1) ||
             (p.excerpt && p.excerpt.toLowerCase().indexOf(q) !== -1) ||
             (p.cat_name.toLowerCase().indexOf(q) !== -1);
    });
  }

  // ───── RENDER ─────
  function cardHTML(post, i, q) {
    var title  = q ? highlight(post.title, q) : escapeHTML(post.title);
    var excerpt = post.excerpt ? (q ? highlight(post.excerpt, q) : escapeHTML(post.excerpt)) : '';
    var delay  = Math.min(i, 8) * 40; // staggered in-animation
    var img    = post.thumb
      ? '<img src="' + escapeHTML(post.thumb) + '" alt="' + escapeHTML(post.title) + '" loading="lazy">'
      : '<div class="blog-card-image-fallback"><span>' + escapeHTML(post.cat_name) + '</span></div>';
    return '' +
      '<article class="blog-card" style="--card-color: ' + escapeHTML(post.cat_color) + '; animation-delay: ' + delay + 'ms;">' +
        '<a href="' + escapeHTML(post.url) + '" class="blog-card-image">' + img + '</a>' +
        '<div class="blog-card-body">' +
          '<span class="cat-badge">' + escapeHTML(post.cat_name) + '</span>' +
          '<h3><a href="' + escapeHTML(post.url) + '">' + title + '</a></h3>' +
          (excerpt ? '<p>' + excerpt + '</p>' : '') +
          '<div class="blog-card-footer">' +
            '<span>' + escapeHTML(post.author) + ' · ' + escapeHTML(post.date) + '</span>' +
            '<span class="read-time">' + post.read_time + ' min</span>' +
          '</div>' +
        '</div>' +
      '</article>';
  }

  function render() {
    var q = state.query.trim().toLowerCase();
    var filtered = getFiltered();
    var slice = filtered.slice(0, state.visible);

    // Grid
    if (filtered.length === 0) {
      grid.innerHTML =
        '<div class="blog-empty">' +
          '<div class="blog-empty-icon">⚲</div>' +
          '<h4>No articles match that search</h4>' +
          '<p>Try a different keyword or clear the filter.</p>' +
          '<button type="button" data-action="reset">Reset filters</button>' +
        '</div>';
    } else {
      grid.innerHTML = slice.map(function (p, i) { return cardHTML(p, i, q); }).join('');
    }

    // Count meta
    var hasFilter = (state.query || state.hub !== 'all');
    resultCount.innerHTML = 'Showing <strong>' + slice.length + '</strong> of <strong>' + filtered.length + '</strong> ' +
      (filtered.length === 1 ? 'article' : 'articles') +
      (state.hub !== 'all' ? ' in <strong>' + chipName(state.hub) + '</strong>' : '') +
      (state.query ? ' for "<strong>' + escapeHTML(state.query) + '</strong>"' : '');

    resultReset.classList.toggle('visible', !!hasFilter);
    searchClear.classList.toggle('visible', !!state.query);

    // Load more
    var remaining = filtered.length - slice.length;
    if (remaining > 0) {
      loadMoreBtn.hidden = false;
      loadMoreCnt.textContent = '(' + remaining + ' more)';
    } else {
      loadMoreBtn.hidden = true;
    }
  }

  function chipName(slug) {
    var chip = chipsWrap.querySelector('.blog-chip[data-hub="' + slug + '"]');
    if (!chip) return slug;
    var countEl = chip.querySelector('.chip-count');
    var text = chip.textContent.replace(countEl ? countEl.textContent : '', '').trim();
    return text;
  }

  function updateChipsUI() {
    Array.prototype.forEach.call(chipsWrap.querySelectorAll('.blog-chip'), function (el) {
      el.classList.toggle('active', el.dataset.hub === state.hub);
    });
  }
  function updateSearchUI() {
    if (searchInput.value !== state.query) searchInput.value = state.query;
  }

  // ───── EVENTS ─────
  var debouncedSearch = debounce(function () {
    state.query   = searchInput.value;
    state.visible = PAGE_SIZE;
    render();
    writeUrlState(true);
  }, 120);
  searchInput.addEventListener('input', debouncedSearch);

  searchClear.addEventListener('click', function () {
    searchInput.value = '';
    state.query = '';
    state.visible = PAGE_SIZE;
    render();
    writeUrlState(true);
    searchInput.focus();
  });

  chipsWrap.addEventListener('click', function (e) {
    var chip = e.target.closest('.blog-chip');
    if (!chip) return;
    state.hub = chip.dataset.hub;
    state.visible = PAGE_SIZE;
    updateChipsUI();
    render();
    writeUrlState(false);
    // Scroll to just below the filter bar if user is above it
    var barRect = filterBar.getBoundingClientRect();
    if (barRect.top < 0) filterBar.scrollIntoView({ behavior: 'smooth', block: 'start' });
  });

  resultReset.addEventListener('click', function () {
    state.query = '';
    state.hub   = 'all';
    state.visible = PAGE_SIZE;
    searchInput.value = '';
    updateChipsUI();
    render();
    writeUrlState(false);
  });

  grid.addEventListener('click', function (e) {
    var btn = e.target.closest('[data-action="reset"]');
    if (btn) {
      state.query = ''; state.hub = 'all'; state.visible = PAGE_SIZE;
      searchInput.value = '';
      updateChipsUI();
      render();
      writeUrlState(false);
    }
  });

  loadMoreBtn.addEventListener('click', function () {
    state.visible += PAGE_SIZE;
    render();
  });

  window.addEventListener('popstate', function () {
    readUrlState();
    updateChipsUI();
    updateSearchUI();
    state.visible = PAGE_SIZE;
    render();
  });

  // Sticky shadow on filter bar
  window.addEventListener('scroll', function () {
    var rect = filterBar.getBoundingClientRect();
    filterBar.classList.toggle('stuck', rect.top <= 85);
  }, { passive: true });

  // Hero grid parallax (subtle mouse-follow — matches homepage feel)
  if (heroGrid) {
    var hero = heroGrid.parentElement;
    hero.addEventListener('mousemove', function (e) {
      var rect = hero.getBoundingClientRect();
      var x = ((e.clientX - rect.left) / rect.width - 0.5) * 20;
      var y = ((e.clientY - rect.top) / rect.height - 0.5) * 20;
      heroGrid.style.transform = 'translate(' + (-x) + 'px, ' + (-y) + 'px)';
    });
    hero.addEventListener('mouseleave', function () {
      heroGrid.style.transform = 'translate(0, 0)';
    });
  }

  // 3D tilt + cursor-tracked glow on hub cards and featured hub
  var prefersReducedMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (!prefersReducedMotion && !('ontouchstart' in window)) {
    document.querySelectorAll('[data-tilt]').forEach(function (card) {
      var rafId = null;
      var maxTilt = card.classList.contains('blog-featured-hub') ? 4 : 6;
      function onMove(e) {
        if (rafId) return;
        rafId = requestAnimationFrame(function () {
          rafId = null;
          var rect = card.getBoundingClientRect();
          var x = (e.clientX - rect.left) / rect.width;
          var y = (e.clientY - rect.top) / rect.height;
          var rx = (0.5 - y) * maxTilt;
          var ry = (x - 0.5) * maxTilt;
          card.style.transform = 'perspective(1200px) rotateX(' + rx.toFixed(2) + 'deg) rotateY(' + ry.toFixed(2) + 'deg) translate3d(0,-4px,0)';
          card.style.setProperty('--glow-x', (x * 100).toFixed(1) + '%');
          card.style.setProperty('--glow-y', (y * 100).toFixed(1) + '%');
        });
      }
      function onLeave() {
        card.style.transform = '';
      }
      card.addEventListener('mousemove', onMove);
      card.addEventListener('mouseleave', onLeave);
    });
  }

  // Reveal animations
  var revealEls = document.querySelectorAll('.blog-reveal');
  var observer = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
  revealEls.forEach(function (el) { observer.observe(el); });

  // ───── INIT ─────
  readUrlState();
  updateChipsUI();
  updateSearchUI();
  render();
})();
</script>

<?php get_footer(); ?>
