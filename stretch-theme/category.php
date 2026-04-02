<?php
/**
 * Template: Category Archive — Pillar Content Hub
 *
 * Reads pillar content from WP option: stretch_hub_{category_slug}
 * Falls back to a simple article grid if no hub content exists.
 */
get_header();

$current_cat = get_queried_object();
$cat_id      = $current_cat->term_id;
$cat_name    = $current_cat->name;
$cat_slug    = $current_cat->slug;
$cat_desc    = $current_cat->description;
$cat_count   = $current_cat->count;

// Hub content from WP option
$hub = get_option("stretch_hub_{$cat_slug}");

// Accent colors per category
$hub_colors = ['#8560A8', '#5674B9', '#448CCB', '#00BFF3', '#6B8F3C', '#D4783F', '#C74B6F'];
$accent     = $hub_colors[$cat_id % count($hub_colors)];

// If no hub content, use simple fallback
if (empty($hub) || empty($hub['sections'])) :
    // ──────────────────────────────
    // FALLBACK: Simple Article Grid
    // ──────────────────────────────
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
?>
<style>
html, body { overflow-x: hidden; }
.admin-bar .site-nav { top: 32px; }
@media (max-width: 782px) { .admin-bar .site-nav { top: 46px; } }
.hub-container { max-width: 1200px; margin: 0 auto; padding: 0 40px; width: 100%; }
.hub-section { box-sizing: border-box; position: relative; }
.hub-section *, .hub-section *::before, .hub-section *::after { box-sizing: inherit; }
.hub-section img { max-width: 100%; height: auto; display: block; }
.hub-reveal { opacity: 0; transform: translateY(40px); transition: opacity 0.8s cubic-bezier(0.16,1,0.3,1), transform 0.8s cubic-bezier(0.16,1,0.3,1); }
.hub-reveal.visible { opacity: 1; transform: translateY(0); }
.hub-angle-divider { position: absolute; bottom: -1px; left: 0; right: 0; z-index: 2; pointer-events: none; line-height: 0; }
.hub-angle-divider svg { display: block; width: 100%; height: 60px; }
.hub-hero { background: linear-gradient(170deg, #252C3A 0%, #1a1f2e 100%); padding: 160px 0 100px; color: #fff; position: relative; overflow: hidden; }
.hub-hero::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.02'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"); pointer-events: none; }
.hub-hero h1 { font-family: 'Poppins', sans-serif; font-size: 56px; font-weight: 600; line-height: 1.15; margin: 0 0 20px; letter-spacing: -1px; }
.hub-hero-overline { font-family: 'Montserrat', sans-serif; font-size: 13px; text-transform: uppercase; letter-spacing: 3px; color: <?php echo $accent; ?>; margin-bottom: 16px; }
.hub-hero-desc { font-family: 'Assistant', sans-serif; font-size: 19px; color: rgba(255,255,255,0.6); max-width: 620px; line-height: 1.6; margin-bottom: 24px; }
.hub-hero-count { font-family: 'Poppins', sans-serif; font-size: 14px; color: rgba(255,255,255,0.4); display: inline-flex; align-items: center; gap: 8px; }
.hub-hero-count span { display: inline-block; width: 6px; height: 6px; border-radius: 50%; background: <?php echo $accent; ?>; }
.hub-grid-section { background: #f9f9fb; padding: 100px 0; position: relative; }
.hub-section-heading { font-family: 'Poppins', sans-serif; font-size: 36px; font-weight: 600; color: #252C3A; text-align: center; margin: 0 0 48px; }
.hub-posts-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 32px; }
.hub-card { background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 16px rgba(0,0,0,0.06); transition: transform 0.4s ease, box-shadow 0.4s ease; border: 1px solid rgba(0,0,0,0.04); }
.hub-card:hover { transform: translateY(-6px); box-shadow: 0 12px 40px rgba(0,0,0,0.12); }
.hub-card-image { aspect-ratio: 16/10; overflow: hidden; position: relative; display: block; }
.hub-card-image img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease; }
.hub-card:hover .hub-card-image img { transform: scale(1.06); }
.hub-card-image .fallback-gradient { width: 100%; height: 100%; background: linear-gradient(135deg, #8560A8, #5674B9); display: flex; align-items: center; justify-content: center; font-family: 'Poppins', sans-serif; font-size: 18px; color: rgba(255,255,255,0.25); }
.hub-card-body { padding: 24px; }
.hub-card-body .cat-badge { display: inline-block; font-family: 'Montserrat', sans-serif; font-size: 10px; text-transform: uppercase; letter-spacing: 2px; color: #8560A8; background: rgba(133,96,168,0.08); padding: 3px 10px; border-radius: 4px; margin-bottom: 10px; }
.hub-card-body h3 { font-family: 'Poppins', sans-serif; font-size: 18px; font-weight: 600; line-height: 1.35; margin: 0 0 8px; color: #252C3A; }
.hub-card-body h3 a { color: inherit; text-decoration: none; }
.hub-card-body h3 a:hover { color: #8560A8; }
.hub-card-body .card-excerpt { font-family: 'Assistant', sans-serif; font-size: 15px; color: #555; line-height: 1.5; margin-bottom: 16px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.hub-card-footer { font-family: 'Assistant', sans-serif; font-size: 13px; color: rgba(37,44,58,0.45); display: flex; justify-content: space-between; }
.hub-pagination { text-align: center; margin-top: 56px; }
.hub-pagination .page-numbers { display: inline-flex; align-items: center; justify-content: center; width: 44px; height: 44px; font-family: 'Poppins', sans-serif; font-size: 15px; font-weight: 500; color: #323A51; text-decoration: none; border-radius: 8px; transition: all 0.3s ease; margin: 0 3px; }
.hub-pagination .page-numbers:hover { background: rgba(133,96,168,0.08); color: #8560A8; }
.hub-pagination .page-numbers.current { background: linear-gradient(135deg, #8560A8, #5674B9); color: #fff; }
@media (max-width: 960px) { .hub-posts-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 768px) { .hub-container { padding: 0 24px; } .hub-hero { padding: 130px 0 60px; } .hub-hero h1 { font-size: 36px; } .hub-section-heading { font-size: 28px; } .hub-grid-section { padding: 60px 0; } }
@media (max-width: 480px) { .hub-posts-grid { grid-template-columns: 1fr; } .hub-hero h1 { font-size: 28px; } }
</style>

<section class="hub-section hub-hero">
  <div class="hub-container">
    <div class="hub-reveal">
      <div class="hub-hero-overline">Content Hub</div>
      <h1><?php echo esc_html($cat_name); ?></h1>
      <?php if ($cat_desc) : ?>
        <p class="hub-hero-desc"><?php echo esc_html($cat_desc); ?></p>
      <?php else : ?>
        <p class="hub-hero-desc">Explore our collection of expert articles, guides, and insights on <?php echo esc_html(strtolower($cat_name)); ?>.</p>
      <?php endif; ?>
      <div class="hub-hero-count"><span></span> <?php echo $cat_count; ?> <?php echo $cat_count === 1 ? 'Article' : 'Articles'; ?></div>
    </div>
  </div>
  <div class="hub-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none"><polygon points="0,60 1440,0 1440,60" fill="#f9f9fb"/></svg>
  </div>
</section>

<section class="hub-section hub-grid-section">
  <div class="hub-container">
    <h2 class="hub-section-heading hub-reveal">All Articles</h2>
    <div class="hub-posts-grid">
      <?php
      $grid_query = new WP_Query([
          'post_type'      => 'post',
          'posts_per_page' => 12,
          'paged'          => $paged,
          'cat'            => $cat_id,
          'post_status'    => 'publish',
      ]);
      if ($grid_query->have_posts()) :
        while ($grid_query->have_posts()) : $grid_query->the_post();
          $c_read = ceil(str_word_count(strip_tags(get_the_content())) / 250);
          if ($c_read < 1) $c_read = 1;
      ?>
        <article class="hub-card hub-reveal">
          <a href="<?php the_permalink(); ?>" class="hub-card-image">
            <?php if (has_post_thumbnail()) : ?>
              <?php the_post_thumbnail('blog-card'); ?>
            <?php else : ?>
              <div class="fallback-gradient">Stretch</div>
            <?php endif; ?>
          </a>
          <div class="hub-card-body">
            <span class="cat-badge"><?php echo esc_html($cat_name); ?></span>
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <p class="card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 18); ?></p>
            <div class="hub-card-footer">
              <span><?php the_author(); ?> &middot; <?php echo get_the_date(); ?></span>
              <span><?php echo $c_read; ?> min read</span>
            </div>
          </div>
        </article>
      <?php endwhile; endif; ?>
    </div>
    <div class="hub-pagination">
      <?php
      echo paginate_links([
          'total'     => $grid_query->max_num_pages,
          'current'   => $paged,
          'prev_text' => '&larr;',
          'next_text' => '&rarr;',
      ]);
      wp_reset_postdata();
      ?>
    </div>
  </div>
</section>

<script>
(function() {
  var els = document.querySelectorAll('.hub-reveal');
  var obs = new IntersectionObserver(function(entries) {
    entries.forEach(function(e) { if (e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); } });
  }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
  els.forEach(function(el) { obs.observe(el); });
})();
</script>

<?php get_footer(); ?>

<?php else :
// ──────────────────────────────
// PILLAR CONTENT HUB
// ──────────────────────────────

$hub_headline = !empty($hub['headline']) ? $hub['headline'] : $cat_name;
$hub_subtitle = !empty($hub['subtitle']) ? $hub['subtitle'] : $cat_desc;
$hub_intro    = !empty($hub['intro'])    ? $hub['intro']    : '';
$sections     = $hub['sections'];

// Pre-fetch spoke posts by slug for performance
$spoke_slugs = array_filter(array_column($sections, 'article_slug'));
$spoke_posts = [];
if (!empty($spoke_slugs)) {
    $spoke_query = new WP_Query([
        'post_type'      => 'post',
        'post_name__in'  => $spoke_slugs,
        'posts_per_page' => count($spoke_slugs),
        'post_status'    => 'publish',
    ]);
    while ($spoke_query->have_posts()) {
        $spoke_query->the_post();
        $spoke_posts[get_post_field('post_name')] = [
            'id'        => get_the_ID(),
            'title'     => get_the_title(),
            'permalink' => get_the_permalink(),
            'thumbnail' => get_the_post_thumbnail_url(get_the_ID(), 'medium'),
            'excerpt'   => wp_trim_words(get_the_excerpt(), 20),
        ];
    }
    wp_reset_postdata();
}

// All articles in category for the library
$all_articles = new WP_Query([
    'post_type'      => 'post',
    'posts_per_page' => -1,
    'cat'            => $cat_id,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
]);
$sticky_posts = get_option('sticky_posts');
?>

<style>
/* ========================================
   PILLAR CONTENT HUB — PREMIUM TEMPLATE
   ======================================== */
html, body { overflow-x: hidden; }
.admin-bar .site-nav { top: 32px; }
@media (max-width: 782px) { .admin-bar .site-nav { top: 46px; } }

.hub-container { max-width: 1200px; margin: 0 auto; padding: 0 40px; width: 100%; }
.hub-section { box-sizing: border-box; position: relative; }
.hub-section *, .hub-section *::before, .hub-section *::after { box-sizing: inherit; }
.hub-section img { max-width: 100%; height: auto; display: block; }

.hub-gradient-text {
  background: linear-gradient(135deg, #8560A8 0%, #5674B9 30%, #448CCB 60%, #00BFF3 100%);
  -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
}

.hub-reveal {
  opacity: 0; transform: translateY(40px);
  transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}
.hub-reveal.visible { opacity: 1; transform: translateY(0); }

.hub-angle-divider {
  position: absolute; bottom: -1px; left: 0; right: 0; z-index: 2; pointer-events: none; line-height: 0;
}
.hub-angle-divider svg { display: block; width: 100%; height: 60px; }

/* ========================================
   1. HUB HERO
   ======================================== */
.hub-hero {
  background: linear-gradient(170deg, #252C3A 0%, #1a1f2e 100%);
  padding: 160px 0 120px;
  color: #fff;
  position: relative;
  overflow: hidden;
}
.hub-hero::before {
  content: '';
  position: absolute; top: 0; left: 0; right: 0; bottom: 0;
  background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.02'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
  pointer-events: none;
}
.hub-hero-accent {
  position: absolute; top: 0; left: 0; right: 0; height: 4px;
  background: linear-gradient(90deg, #8560A8, #5674B9, #448CCB, #00BFF3);
}
.hub-hero-inner {
  position: relative; z-index: 1;
  max-width: 720px;
}
.hub-hero-overline {
  font-family: 'Montserrat', sans-serif;
  font-size: 13px; text-transform: uppercase; letter-spacing: 3px;
  color: <?php echo $accent; ?>;
  margin-bottom: 16px;
}
.hub-hero h1 {
  font-family: 'Poppins', sans-serif;
  font-size: 52px; font-weight: 600; line-height: 1.15;
  margin: 0 0 20px; letter-spacing: -1px;
}
.hub-hero-subtitle {
  font-family: 'Assistant', sans-serif;
  font-size: 20px; color: rgba(255,255,255,0.6);
  line-height: 1.6; margin-bottom: 28px;
}
.hub-hero-meta {
  display: flex; align-items: center; gap: 20px;
  font-family: 'Poppins', sans-serif; font-size: 14px;
}
.hub-hero-count {
  color: rgba(255,255,255,0.4);
  display: inline-flex; align-items: center; gap: 8px;
}
.hub-hero-count span {
  display: inline-block; width: 6px; height: 6px;
  border-radius: 50%; background: <?php echo $accent; ?>;
}
.hub-hero-start {
  display: inline-flex; align-items: center; gap: 8px;
  padding: 12px 28px;
  background: linear-gradient(135deg, #8560A8, #5674B9);
  color: #fff; font-family: 'Poppins', sans-serif;
  font-size: 14px; font-weight: 500;
  border-radius: 8px; border: none; cursor: pointer;
  text-decoration: none;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.hub-hero-start:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 30px rgba(133,96,168,0.4);
  color: #fff;
}

/* ========================================
   2. TABLE OF CONTENTS — Left Sidebar
   ======================================== */
.hub-toc {
  position: fixed;
  left: max(20px, calc((100vw - 780px) / 2 - 260px));
  top: 160px;
  width: 200px;
  max-height: calc(100vh - 200px);
  overflow-y: auto;
  scrollbar-width: none;
  z-index: 50;
  opacity: 0;
  transition: opacity 0.3s;
}
.hub-toc::-webkit-scrollbar { display: none; }
.hub-toc.visible { opacity: 1; }
.admin-bar .hub-toc { top: 192px; }
.hub-toc-label {
  font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 600;
  text-transform: uppercase; letter-spacing: 2px; color: #bbb;
  margin-bottom: 16px;
}
.hub-toc-list {
  list-style: none; padding: 0; margin: 0;
}
.hub-toc-chapter { margin-bottom: 8px; }
.hub-toc-chapter > a {
  font-size: 13px; font-weight: 600; color: #252C3A;
  text-decoration: none; display: block; padding: 6px 0 6px 16px;
  border-left: 2px solid transparent; margin-left: -2px;
  transition: color 0.2s;
}
.hub-toc-chapter.active > a { color: #8560A8; border-left-color: #8560A8; }
.hub-toc-sub { list-style: none; padding: 0; margin: 0 0 0 16px; }
.hub-toc-sub .hub-toc-item { padding: 4px 0 4px 12px; border-left: 1px solid #e8e8ec; margin-left: 0; }
.hub-toc-sub .hub-toc-item a {
  font-size: 12px; color: #bbb; text-decoration: none;
  font-family: 'Poppins', sans-serif; display: block; line-height: 1.4;
  transition: color 0.2s;
}
.hub-toc-sub .hub-toc-item.active a { color: #8560A8; font-weight: 500; }
.hub-toc-sub .hub-toc-item.active { border-left-color: #8560A8; }
.hub-toc-sub .hub-toc-item a:hover { color: #8560A8; }
@media (max-width: 1280px) { .hub-toc { display: none; } }

/* ========================================
   ARTICLE CAROUSEL
   ======================================== */
.hub-carousel-section {
  background: #fff;
  padding: 0 0 40px;
  overflow: hidden;
}
.hub-carousel-wrapper {
  overflow: hidden;
  position: relative;
  margin: 0 -40px;
  padding: 0 40px;
}
.hub-carousel-track {
  display: flex;
  gap: 20px;
  overflow-x: auto;
  scroll-behavior: smooth;
  scrollbar-width: none;
  padding: 10px 0 20px;
  -webkit-overflow-scrolling: touch;
}
.hub-carousel-track::-webkit-scrollbar { display: none; }
.hub-carousel-card {
  min-width: 220px;
  max-width: 220px;
  flex-shrink: 0;
  text-decoration: none;
  color: inherit;
  transition: transform 0.3s ease;
}
.hub-carousel-card:hover { transform: translateY(-4px); }
.hub-carousel-img {
  width: 220px;
  height: 140px;
  border-radius: 10px;
  overflow: hidden;
  margin-bottom: 10px;
  background: #f0f0f4;
}
.hub-carousel-img img {
  width: 100%; height: 100%; object-fit: cover;
  transition: transform 0.3s ease;
}
.hub-carousel-card:hover .hub-carousel-img img { transform: scale(1.05); }
.hub-carousel-fallback {
  width: 100%; height: 100%;
  background: linear-gradient(135deg, #8560A8, #5674B9);
}
.hub-carousel-title {
  font-family: 'Poppins', sans-serif;
  font-size: 13px;
  font-weight: 500;
  color: #252C3A;
  line-height: 1.35;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
.hub-carousel-card:hover .hub-carousel-title { color: #8560A8; }

/* ========================================
   3. PILLAR CONTENT
   ======================================== */
.hub-pillar-content {
  background: #fff;
  padding: 80px 0 60px;
  position: relative;
}
.hub-pillar-article {
  max-width: 780px;
  margin: 0 auto;
  padding: 0 40px;
}
.hub-intro {
  font-family: 'Assistant', sans-serif;
  font-size: 19px; line-height: 1.8; color: #323A51;
  margin-bottom: 60px;
}
.hub-intro p { margin: 0 0 20px; }
.hub-intro p:last-child { margin-bottom: 0; }

.hub-content-section {
  margin-bottom: 64px;
  scroll-margin-top: 100px;
}
.hub-content-section h3 {
  font-family: 'Poppins', sans-serif;
  font-size: 32px; font-weight: 600; line-height: 1.25;
  color: #252C3A; margin: 0 0 24px;
  letter-spacing: -0.5px;
}
.hub-content-section .hub-section-body {
  font-family: 'Assistant', sans-serif;
  font-size: 18px; line-height: 1.8; color: #323A51;
}
.hub-content-section .hub-section-body p {
  margin: 0 0 20px;
}
.hub-content-section .hub-section-body p:last-child { margin-bottom: 0; }

/* Chapter headers */
.hub-chapter { padding: 20px 0; }
.hub-chapter-header {
  margin: 80px 0 48px;
  padding: 0;
  text-align: center;
}
.hub-chapter-header:first-child { margin-top: 0; }
.hub-chapter-label {
  font-family: 'Poppins', sans-serif;
  font-size: 11px; font-weight: 600;
  text-transform: uppercase; letter-spacing: 3px;
  color: #8560A8; display: block; margin-bottom: 8px;
}
.hub-chapter-title {
  font-family: 'Poppins', sans-serif;
  font-size: 28px; font-weight: 600;
  color: #252C3A;
}

/* Pull quote */
.hub-pullquote {
  text-align: center;
  margin: 40px -40px;
  padding: 40px;
  border-top: 2px solid rgba(133,96,168,0.12);
  border-bottom: 2px solid rgba(133,96,168,0.12);
}
.hub-pullquote p {
  font-family: 'Poppins', sans-serif;
  font-size: 22px; font-weight: 500;
  color: #252C3A; line-height: 1.5;
  font-style: italic; margin: 0;
}
.hub-pullquote p::before { content: '\201C'; color: #8560A8; }
.hub-pullquote p::after { content: '\201D'; color: #8560A8; }

/* Key points box */
.hub-keypoints {
  margin: 32px 0;
  padding: 28px 32px;
  background: linear-gradient(135deg, rgba(133,96,168,0.06), rgba(0,191,243,0.04));
  border-radius: 12px;
  border: 1px solid rgba(133,96,168,0.08);
}
.hub-keypoints-label {
  font-family: 'Poppins', sans-serif;
  font-size: 11px; font-weight: 600;
  text-transform: uppercase; letter-spacing: 1.5px;
  color: #8560A8; margin-bottom: 16px;
}
.hub-keypoints ol {
  margin: 0; padding: 0 0 0 20px;
}
.hub-keypoints li {
  font-family: 'Assistant', sans-serif;
  font-size: 16px; line-height: 1.6;
  color: #323A51; margin-bottom: 8px;
}
.hub-keypoints li::marker { color: #8560A8; font-weight: 600; }

/* Inline spoke link */
.hub-inline-link {
  margin-top: 16px;
}
.hub-inline-link a {
  font-family: 'Poppins', sans-serif;
  font-size: 14px; font-weight: 500;
  color: #8560A8;
  text-decoration: none;
  transition: color 0.2s;
}
.hub-inline-link a:hover { color: #00BFF3; }

/* Pillar article tables */
.hub-pillar-article table {
  width: 100%; border-collapse: collapse;
  margin: 24px 0; border-radius: 12px;
  overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.06);
}
.hub-pillar-article table thead {
  background: linear-gradient(135deg, #252C3A, #323A51);
}
.hub-pillar-article table thead th {
  padding: 14px 20px; text-align: left;
  font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 500;
  color: #fff; letter-spacing: 0.5px;
}
.hub-pillar-article table tbody td {
  padding: 12px 20px; font-size: 15px;
  border-bottom: 1px solid #f0f0f4;
}
.hub-pillar-article table tbody tr:hover { background: #f9f9fb; }

/* ========================================
   SPOKE CARD — Inline Article Recommendation
   ======================================== */
.hub-spoke-card {
  display: flex; gap: 20px;
  padding: 24px; margin: 32px 0;
  background: linear-gradient(135deg, rgba(133,96,168,0.04), rgba(0,191,243,0.03));
  border-left: 3px solid #8560A8;
  border-radius: 0 12px 12px 0;
  transition: all 0.3s ease;
  text-decoration: none;
}
.hub-spoke-card:hover {
  background: linear-gradient(135deg, rgba(133,96,168,0.08), rgba(0,191,243,0.06));
  transform: translateX(4px);
}
.hub-spoke-card-img {
  width: 120px; height: 80px;
  border-radius: 8px; overflow: hidden;
  flex-shrink: 0;
}
.hub-spoke-card-img img { width: 100%; height: 100%; object-fit: cover; }
.hub-spoke-card-img .fallback-spoke {
  width: 100%; height: 100%;
  background: linear-gradient(135deg, #8560A8, #5674B9);
  display: flex; align-items: center; justify-content: center;
  font-family: 'Poppins', sans-serif; font-size: 10px; color: rgba(255,255,255,0.3);
}
.hub-spoke-card-content { flex: 1; }
.hub-spoke-card-label {
  font-family: 'Poppins', sans-serif; font-size: 10px; font-weight: 600;
  text-transform: uppercase; letter-spacing: 1.5px; color: #8560A8;
  margin-bottom: 4px;
}
.hub-spoke-card-title {
  font-family: 'Poppins', sans-serif; font-size: 16px; font-weight: 500;
  color: #252C3A; line-height: 1.3; margin-bottom: 6px;
}
.hub-spoke-card-link {
  font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 500;
  color: #8560A8; text-decoration: none;
}
.hub-spoke-card:hover .hub-spoke-card-link { color: #00BFF3; }

@media (max-width: 480px) {
  .hub-spoke-card { flex-direction: column; gap: 12px; }
  .hub-spoke-card-img { width: 100%; height: 120px; }
}

/* ========================================
   4. ARTICLE LIBRARY
   ======================================== */
.hub-library {
  padding: 100px 0; background: #f9f9fb; position: relative;
}
.hub-library-top {
  display: flex; justify-content: space-between; align-items: center;
  flex-wrap: wrap; gap: 20px; margin-bottom: 40px;
}
.hub-library h2 {
  font-family: 'Poppins', sans-serif;
  font-size: 36px; font-weight: 600; color: #252C3A;
  margin: 0;
}
.hub-library-controls {
  display: flex; align-items: center; gap: 16px; flex-wrap: wrap;
}
.hub-library-search {
  padding: 10px 20px;
  border: 2px solid #e8e8ec; border-radius: 8px;
  font-family: 'Assistant', sans-serif; font-size: 15px;
  width: 260px; outline: none;
  transition: border-color 0.2s;
  background: #fff;
}
.hub-library-search:focus { border-color: #8560A8; }
.hub-library-filters { display: flex; gap: 8px; }
.hub-library-filter {
  padding: 8px 16px;
  border: 1px solid #e8e8ec; background: #fff;
  border-radius: 6px;
  font-family: 'Poppins', sans-serif; font-size: 12px; font-weight: 500;
  cursor: pointer; transition: all 0.2s;
  color: #323A51;
}
.hub-library-filter.active,
.hub-library-filter:hover { background: #8560A8; color: #fff; border-color: #8560A8; }

.hub-library-grid {
  display: grid; grid-template-columns: repeat(3, 1fr);
  gap: 32px;
}
.hub-lib-card {
  background: #fff; border-radius: 12px; overflow: hidden;
  box-shadow: 0 2px 16px rgba(0,0,0,0.06);
  transition: transform 0.4s ease, box-shadow 0.4s ease;
  border: 1px solid rgba(0,0,0,0.04);
}
.hub-lib-card.hidden { display: none; }
.hub-lib-card:hover { transform: translateY(-6px); box-shadow: 0 12px 40px rgba(0,0,0,0.12); }
.hub-lib-card-image {
  aspect-ratio: 16/10; overflow: hidden; position: relative; display: block;
}
.hub-lib-card-image img {
  width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease;
}
.hub-lib-card:hover .hub-lib-card-image img { transform: scale(1.06); }
.hub-lib-card-image .fallback-gradient {
  width: 100%; height: 100%;
  background: linear-gradient(135deg, #8560A8, #5674B9);
  display: flex; align-items: center; justify-content: center;
  font-family: 'Poppins', sans-serif; font-size: 18px; color: rgba(255,255,255,0.25);
}
.hub-lib-card-body { padding: 24px; }
.hub-lib-card-body .cat-badge {
  display: inline-block;
  font-family: 'Montserrat', sans-serif; font-size: 10px;
  text-transform: uppercase; letter-spacing: 2px; color: #8560A8;
  background: rgba(133,96,168,0.08); padding: 3px 10px;
  border-radius: 4px; margin-bottom: 10px;
}
.hub-lib-card-body h3 {
  font-family: 'Poppins', sans-serif; font-size: 18px; font-weight: 600;
  line-height: 1.35; margin: 0 0 8px; color: #252C3A;
}
.hub-lib-card-body h3 a { color: inherit; text-decoration: none; }
.hub-lib-card-body h3 a:hover { color: #8560A8; }
.hub-lib-card-body .card-excerpt {
  font-family: 'Assistant', sans-serif; font-size: 15px; color: #555;
  line-height: 1.5; margin-bottom: 16px;
  display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
}
.hub-lib-card-footer {
  font-family: 'Assistant', sans-serif; font-size: 13px;
  color: rgba(37,44,58,0.45); display: flex; justify-content: space-between;
}

.hub-library-empty {
  grid-column: 1 / -1; text-align: center; padding: 60px 20px;
  font-family: 'Assistant', sans-serif; font-size: 17px; color: #999;
  display: none;
}

@media (max-width: 960px) { .hub-library-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 480px) { .hub-library-grid { grid-template-columns: 1fr; } }

/* ========================================
   5. RELATED HUBS
   ======================================== */
.hub-related {
  background: #fff; padding: 80px 0; position: relative;
}
.hub-related-heading {
  font-family: 'Poppins', sans-serif; font-size: 36px; font-weight: 600;
  color: #252C3A; text-align: center; margin: 0 0 48px;
}
.hub-related-grid {
  display: flex; gap: 24px; flex-wrap: wrap; justify-content: center;
}
.hub-related-card {
  flex: 0 0 200px; background: #f9f9fb; border-radius: 12px;
  padding: 24px 20px; text-align: center; text-decoration: none;
  border-top: 3px solid;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.hub-related-card:hover {
  transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,0.08);
}
.hub-related-card h3 {
  font-family: 'Poppins', sans-serif; font-size: 16px; font-weight: 600;
  color: #252C3A; margin: 0 0 4px;
}
.hub-related-card .rel-count {
  font-family: 'Assistant', sans-serif; font-size: 13px; color: rgba(37,44,58,0.5);
}

/* ========================================
   6. CTA
   ======================================== */
.hub-cta-final {
  background: linear-gradient(135deg, #8560A8, #5674B9);
  padding: 80px 0; text-align: center; color: #fff;
  position: relative;
}
.hub-cta-final h2 {
  font-family: 'Poppins', sans-serif; font-size: 36px; font-weight: 600; margin: 0 0 12px;
}
.hub-cta-final p {
  font-family: 'Assistant', sans-serif; font-size: 18px;
  color: rgba(255,255,255,0.7); margin: 0 0 28px;
}
.hub-cta-btn {
  display: inline-block; padding: 16px 40px;
  background: #fff; color: #8560A8;
  font-family: 'Poppins', sans-serif; font-size: 15px; font-weight: 600;
  border-radius: 8px; text-decoration: none;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.hub-cta-btn:hover {
  transform: translateY(-2px); box-shadow: 0 8px 30px rgba(0,0,0,0.2);
}

/* ========================================
   RESPONSIVE
   ======================================== */
@media (max-width: 960px) {
  .hub-library-top { flex-direction: column; align-items: flex-start; }
}
@media (max-width: 768px) {
  .hub-container { padding: 0 24px; }
  .hub-hero { padding: 130px 0 80px; }
  .hub-hero h1 { font-size: 36px; }
  .hub-pillar-content { padding: 60px 0 40px; }
  .hub-pillar-article { padding: 0 24px; }
  .hub-content-section h3 { font-size: 26px; }
  .hub-pullquote { margin: 32px -24px; padding: 32px 24px; }
  .hub-pullquote p { font-size: 18px; }
  .hub-chapter-title { font-size: 24px; }
  .hub-library { padding: 60px 0; }
  .hub-library h2 { font-size: 28px; }
  .hub-related { padding: 60px 0; }
  .hub-related-heading { font-size: 28px; }
  .hub-cta-final h2 { font-size: 28px; }
  .hub-related-card { flex: 0 0 160px; }
  .hub-library-search { width: 100%; }
}
@media (max-width: 480px) {
  .hub-hero h1 { font-size: 28px; }
  .hub-hero-subtitle { font-size: 17px; }
  .hub-hero-meta { flex-direction: column; align-items: flex-start; gap: 12px; }
  .hub-content-section h3 { font-size: 22px; }
}
</style>

<!-- ============================
     1. HUB HERO
     ============================ -->
<section class="hub-section hub-hero">
  <div class="hub-hero-accent"></div>
  <div class="hub-container">
    <div class="hub-hero-inner hub-reveal">
      <div class="hub-hero-overline">Content Hub</div>
      <h1><?php echo esc_html($hub_headline); ?></h1>
      <p class="hub-hero-subtitle"><?php echo esc_html($hub_subtitle); ?></p>
      <div class="hub-hero-meta">
        <div class="hub-hero-count"><span></span> <?php echo $cat_count; ?> <?php echo $cat_count === 1 ? 'Article' : 'Articles'; ?></div>
        <a href="#hub-content" class="hub-hero-start">Start Reading &darr;</a>
      </div>
    </div>
  </div>
  <div class="hub-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none"><polygon points="0,60 1440,0 1440,60" fill="#fff"/></svg>
  </div>
</section>

<!-- Article Carousel -->
<section class="hub-carousel-section">
  <div class="hub-container">
    <div class="hub-carousel-wrapper">
      <div class="hub-carousel-track" id="hubCarouselTrack">
        <?php
        $carousel_posts = new WP_Query([
            'post_type' => 'post',
            'posts_per_page' => 10,
            'cat' => $cat_id,
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
        ]);
        while ($carousel_posts->have_posts()) : $carousel_posts->the_post();
        ?>
        <a href="<?php the_permalink(); ?>" class="hub-carousel-card">
          <div class="hub-carousel-img">
            <?php if (has_post_thumbnail()) : the_post_thumbnail('blog-card'); else : ?>
              <div class="hub-carousel-fallback"></div>
            <?php endif; ?>
          </div>
          <div class="hub-carousel-title"><?php the_title(); ?></div>
        </a>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>
    </div>
  </div>
</section>

<!-- AEO Scanner Tool -->
<?php if ($current_cat && $current_cat->slug === 'aeo') : ?>
  <?php get_template_part('aeo-scanner'); ?>
<?php endif; ?>

<!-- ============================
     2. TABLE OF CONTENTS (fixed sidebar)
     ============================ -->
<nav class="hub-toc" id="hubToc" aria-label="Table of contents">
  <div class="hub-toc-label">Contents</div>
  <ul class="hub-toc-list">
    <?php foreach ($hub['chapters'] as $ci => $chapter) : ?>
      <li class="hub-toc-chapter" data-section="hub-chapter-<?php echo $ci; ?>">
        <a href="#hub-chapter-<?php echo $ci; ?>"><?php echo esc_html($chapter['title']); ?></a>
        <ul class="hub-toc-sub">
          <?php foreach ($chapter['sections'] as $si) :
            if (isset($sections[$si])) : ?>
            <li class="hub-toc-item" data-section="hub-section-<?php echo $si; ?>">
              <a href="#hub-section-<?php echo $si; ?>"><?php echo esc_html($sections[$si]['heading']); ?></a>
            </li>
          <?php endif; endforeach; ?>
        </ul>
      </li>
    <?php endforeach; ?>
  </ul>
</nav>

<!-- ============================
     3. PILLAR CONTENT
     ============================ -->
<section class="hub-section hub-pillar-content" id="hub-content">

    <?php if ($hub_intro) : ?>
      <div class="hub-pillar-article">
        <div class="hub-intro hub-reveal">
          <?php echo wp_kses_post($hub_intro); ?>
        </div>
      </div>
    <?php endif; ?>

    <?php
    $current_chapter = -1;
    $chapter_bgs = ['#fff', '#f9f9fb', '#fff'];
    $chapters = !empty($hub['chapters']) ? $hub['chapters'] : [];

    foreach ($sections as $si => $sec) :
      $slug = !empty($sec['article_slug']) ? $sec['article_slug'] : '';
      $spoke = isset($spoke_posts[$slug]) ? $spoke_posts[$slug] : null;
      $card_style = !empty($sec['card_style']) ? $sec['card_style'] : 'card';

      // Check if we need a new chapter header
      foreach ($chapters as $ci => $chapter) {
        if (in_array($si, $chapter['sections']) && $ci !== $current_chapter) {
          if ($current_chapter >= 0) echo '</div></div>'; // close previous chapter
          $current_chapter = $ci;
          $bg = isset($chapter_bgs[$ci]) ? $chapter_bgs[$ci] : '#fff';
          echo '<div class="hub-chapter" style="background:' . esc_attr($bg) . ';">';
          echo '<div class="hub-pillar-article">';
          echo '<div class="hub-chapter-header hub-reveal">';
          echo '<span class="hub-chapter-label">Part ' . ($ci + 1) . '</span>';
          echo '<h2 class="hub-chapter-title" id="hub-chapter-' . $ci . '">' . esc_html($chapter['title']) . '</h2>';
          echo '</div>';
          break;
        }
      }
    ?>
      <div class="hub-content-section hub-reveal" id="hub-section-<?php echo $si; ?>">
        <h3><?php echo esc_html($sec['heading']); ?></h3>
        <div class="hub-section-body">
          <?php echo wp_kses_post($sec['content']); ?>
        </div>

        <?php // Special element: table
        if (!empty($sec['table'])) : ?>
          <div class="hub-reveal">
            <?php echo $sec['table']; ?>
          </div>
          <?php if (!empty($sec['content_after_table'])) : ?>
            <div class="hub-section-body hub-reveal">
              <?php echo wp_kses_post($sec['content_after_table']); ?>
            </div>
          <?php endif; ?>
        <?php endif; ?>

        <?php // Special element: pullquote
        if (!empty($sec['pullquote'])) : ?>
          <div class="hub-pullquote hub-reveal">
            <p><?php echo wp_kses_post($sec['pullquote']); ?></p>
          </div>
        <?php endif; ?>

        <?php // Additional content after special elements
        if (!empty($sec['content_after'])) : ?>
          <div class="hub-section-body hub-reveal">
            <?php echo wp_kses_post($sec['content_after']); ?>
          </div>
        <?php endif; ?>

        <?php // Special element: keypoints
        if (!empty($sec['keypoints'])) : ?>
          <div class="hub-keypoints hub-reveal">
            <div class="hub-keypoints-label">Key Points</div>
            <ol>
              <?php foreach ($sec['keypoints'] as $kp) : ?>
                <li><?php echo esc_html($kp); ?></li>
              <?php endforeach; ?>
            </ol>
          </div>
        <?php endif; ?>

        <?php // Spoke card (always full card style)
        if ($spoke) : ?>
          <?php if (true) : ?>
            <a href="<?php echo esc_url($spoke['permalink']); ?>" class="hub-spoke-card hub-reveal">
              <div class="hub-spoke-card-img">
                <?php if (!empty($spoke['thumbnail'])) : ?>
                  <img src="<?php echo esc_url($spoke['thumbnail']); ?>" alt="<?php echo esc_attr($spoke['title']); ?>">
                <?php else : ?>
                  <div class="fallback-spoke">S</div>
                <?php endif; ?>
              </div>
              <div class="hub-spoke-card-content">
                <div class="hub-spoke-card-label">Deep Dive</div>
                <div class="hub-spoke-card-title"><?php echo esc_html($spoke['title']); ?></div>
                <span class="hub-spoke-card-link">Read the full guide &rarr;</span>
              </div>
            </a>
          <?php endif; ?>
        <?php endif; ?>
      </div>

    <?php endforeach; ?>

    <?php // Close last chapter
    if ($current_chapter >= 0) echo '</div></div>'; ?>

  <div class="hub-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none"><polygon points="0,0 1440,60 1440,60 0,60" fill="#f9f9fb"/></svg>
  </div>
</section>

<!-- ============================
     4. ARTICLE LIBRARY
     ============================ -->
<section class="hub-section hub-library" id="hub-library">
  <div class="hub-container">
    <div class="hub-library-top hub-reveal">
      <h2>All Articles in This Hub</h2>
      <div class="hub-library-controls">
        <div class="hub-library-filters">
          <button class="hub-library-filter active" data-filter="all">All</button>
          <button class="hub-library-filter" data-filter="newest">Newest</button>
          <button class="hub-library-filter" data-filter="featured">Featured</button>
        </div>
        <input type="text" class="hub-library-search" placeholder="Search articles..." aria-label="Search articles">
      </div>
    </div>

    <div class="hub-library-grid" id="hubLibraryGrid">
      <?php
      if ($all_articles->have_posts()) :
        while ($all_articles->have_posts()) : $all_articles->the_post();
          $c_read = ceil(str_word_count(strip_tags(get_the_content())) / 250);
          if ($c_read < 1) $c_read = 1;
          $is_sticky = in_array(get_the_ID(), (array)$sticky_posts) ? 'true' : 'false';
      ?>
        <article class="hub-lib-card hub-reveal"
                 data-title="<?php echo esc_attr(strtolower(get_the_title())); ?>"
                 data-date="<?php echo esc_attr(get_the_date('Y-m-d H:i:s')); ?>"
                 data-sticky="<?php echo $is_sticky; ?>">
          <a href="<?php the_permalink(); ?>" class="hub-lib-card-image">
            <?php if (has_post_thumbnail()) : ?>
              <?php the_post_thumbnail('blog-card'); ?>
            <?php else : ?>
              <div class="fallback-gradient">Stretch</div>
            <?php endif; ?>
          </a>
          <div class="hub-lib-card-body">
            <span class="cat-badge"><?php echo esc_html($cat_name); ?></span>
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <p class="card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 18); ?></p>
            <div class="hub-lib-card-footer">
              <span><?php the_author(); ?> &middot; <?php echo get_the_date(); ?></span>
              <span><?php echo $c_read; ?> min read</span>
            </div>
          </div>
        </article>
      <?php endwhile; endif; wp_reset_postdata(); ?>

      <div class="hub-library-empty">No articles match your search.</div>
    </div>
  </div>

  <div class="hub-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none"><polygon points="0,60 1440,0 1440,60" fill="#fff"/></svg>
  </div>
</section>

<!-- ============================
     5. RELATED HUBS
     ============================ -->
<?php
$other_cats = get_categories(['hide_empty' => true, 'exclude' => [$cat_id, get_cat_ID('Uncategorized')]]);
if (!empty($other_cats)) :
?>
<section class="hub-section hub-related">
  <div class="hub-container">
    <h2 class="hub-related-heading hub-reveal">Explore More Topics</h2>
    <div class="hub-related-grid hub-reveal">
      <?php
      $ri = 0;
      foreach ($other_cats as $oc) :
        $rc = $hub_colors[$ri % count($hub_colors)];
        $ri++;
      ?>
        <a href="<?php echo esc_url(get_category_link($oc->term_id)); ?>" class="hub-related-card" style="border-top-color: <?php echo $rc; ?>;">
          <h3><?php echo esc_html($oc->name); ?></h3>
          <div class="rel-count"><?php echo $oc->count; ?> Articles</div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="hub-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none"><polygon points="0,60 1440,0 1440,60" fill="#8560A8"/></svg>
  </div>
</section>
<?php endif; ?>

<!-- ============================
     6. CTA
     ============================ -->
<section class="hub-section hub-cta-final">
  <div class="hub-container hub-reveal">
    <h2>Want help with <?php echo esc_html($cat_name); ?>?</h2>
    <p>Let us build a strategy that gets your brand cited by AI answer engines.</p>
    <a href="<?php echo esc_url(home_url('/contact-stretch-creative/')); ?>" class="hub-cta-btn">Let&rsquo;s Talk</a>
  </div>
</section>

<!-- ============================
     JAVASCRIPT
     ============================ -->
<script>
(function() {
  /* ── Scroll Reveal ── */
  var revealEls = document.querySelectorAll('.hub-reveal');
  var revealObs = new IntersectionObserver(function(entries) {
    entries.forEach(function(e) {
      if (e.isIntersecting) {
        e.target.classList.add('visible');
        revealObs.unobserve(e.target);
      }
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
  revealEls.forEach(function(el) { revealObs.observe(el); });

  /* ── Smooth Scroll for "Start Reading" ── */
  document.querySelectorAll('a[href^="#"]').forEach(function(a) {
    a.addEventListener('click', function(ev) {
      var target = document.querySelector(this.getAttribute('href'));
      if (target) {
        ev.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });

  /* ── TOC Visibility & Active State ── */
  var toc = document.getElementById('hubToc');
  var contentSection = document.getElementById('hub-content');
  var tocItems = toc ? toc.querySelectorAll('.hub-toc-item') : [];
  var tocChapters = toc ? toc.querySelectorAll('.hub-toc-chapter') : [];
  var sectionEls = document.querySelectorAll('.hub-content-section');

  if (toc && contentSection) {
    function updateTocVis() {
      var rect = contentSection.getBoundingClientRect();
      if (rect.top < window.innerHeight * 0.3 && rect.bottom > 300) {
        toc.classList.add('visible');
      } else {
        toc.classList.remove('visible');
      }
    }
    window.addEventListener('scroll', function() { requestAnimationFrame(updateTocVis); }, { passive: true });
    updateTocVis();

    /* Active section tracking — highlights section and parent chapter */
    var sectionObs = new IntersectionObserver(function(entries) {
      entries.forEach(function(e) {
        if (e.isIntersecting) {
          var id = e.target.id;
          tocItems.forEach(function(item) {
            item.classList.toggle('active', item.getAttribute('data-section') === id);
          });
          /* Highlight parent chapter */
          tocChapters.forEach(function(ch) {
            var childItems = ch.querySelectorAll('.hub-toc-item');
            var anyActive = false;
            childItems.forEach(function(ci) {
              if (ci.getAttribute('data-section') === id) anyActive = true;
            });
            ch.classList.toggle('active', anyActive);
          });
        }
      });
    }, { threshold: 0.2, rootMargin: '-80px 0px -60% 0px' });
    sectionEls.forEach(function(s) { sectionObs.observe(s); });
  }

  /* ── Article Library Filters ── */
  var grid = document.getElementById('hubLibraryGrid');
  if (!grid) return;

  var cards = grid.querySelectorAll('.hub-lib-card');
  var emptyMsg = grid.querySelector('.hub-library-empty');
  var searchInput = document.querySelector('.hub-library-search');
  var filterBtns = document.querySelectorAll('.hub-library-filter');
  var currentFilter = 'all';

  function applyFilters() {
    var query = searchInput ? searchInput.value.toLowerCase().trim() : '';
    var visibleCount = 0;

    /* Convert to array for sorting */
    var cardArr = Array.prototype.slice.call(cards);

    /* Sort based on filter */
    if (currentFilter === 'newest') {
      cardArr.sort(function(a, b) {
        return new Date(b.getAttribute('data-date')) - new Date(a.getAttribute('data-date'));
      });
    } else if (currentFilter === 'featured') {
      cardArr.sort(function(a, b) {
        var aS = a.getAttribute('data-sticky') === 'true' ? 0 : 1;
        var bS = b.getAttribute('data-sticky') === 'true' ? 0 : 1;
        if (aS !== bS) return aS - bS;
        return new Date(b.getAttribute('data-date')) - new Date(a.getAttribute('data-date'));
      });
    }

    /* Re-append sorted cards */
    cardArr.forEach(function(card) {
      grid.insertBefore(card, emptyMsg);
    });

    /* Filter by search */
    cardArr.forEach(function(card) {
      var title = card.getAttribute('data-title') || '';
      var matches = !query || title.indexOf(query) !== -1;
      card.classList.toggle('hidden', !matches);
      if (matches) visibleCount++;
    });

    if (emptyMsg) {
      emptyMsg.style.display = visibleCount === 0 ? 'block' : 'none';
    }
  }

  filterBtns.forEach(function(btn) {
    btn.addEventListener('click', function() {
      filterBtns.forEach(function(b) { b.classList.remove('active'); });
      this.classList.add('active');
      currentFilter = this.getAttribute('data-filter');
      applyFilters();
    });
  });

  if (searchInput) {
    searchInput.addEventListener('input', applyFilters);
  }
})();
</script>

<?php get_footer(); endif; ?>
