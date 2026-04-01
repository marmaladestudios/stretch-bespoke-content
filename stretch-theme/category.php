<?php
/**
 * Template: Category Archive (Content Hub)
 */
get_header();

$current_cat = get_queried_object();
$cat_id = $current_cat->term_id;
$cat_name = $current_cat->name;
$cat_desc = $current_cat->description;
$cat_count = $current_cat->count;

// Assign accent colors per category for variety
$hub_colors = ['#8560A8', '#5674B9', '#448CCB', '#00BFF3', '#6B8F3C', '#D4783F', '#C74B6F'];
$accent = $hub_colors[$cat_id % count($hub_colors)];

// Pillar post: first check for sticky, then fall back to most recent
$sticky_posts = get_option('sticky_posts');
$pillar_id = 0;
$pillar_query_args = [
    'post_type'      => 'post',
    'posts_per_page' => 1,
    'post_status'    => 'publish',
    'cat'            => $cat_id,
];
if (!empty($sticky_posts)) {
    $sticky_in_cat = new WP_Query(array_merge($pillar_query_args, [
        'post__in' => $sticky_posts,
    ]));
    if ($sticky_in_cat->have_posts()) {
        $sticky_in_cat->the_post();
        $pillar_id = get_the_ID();
        wp_reset_postdata();
    }
}
if (!$pillar_id) {
    $first_post = new WP_Query($pillar_query_args);
    if ($first_post->have_posts()) {
        $first_post->the_post();
        $pillar_id = get_the_ID();
        wp_reset_postdata();
    }
}

$paged = get_query_var('paged') ? get_query_var('paged') : 1;
?>

<style>
/* ========================================
   CATEGORY HUB — PREMIUM TEMPLATE
   ======================================== */
html, body { overflow-x: hidden; }
.admin-bar .site-nav { top: 32px; }
@media (max-width: 782px) { .admin-bar .site-nav { top: 46px; } }

.hub-container { max-width: 1200px; margin: 0 auto; padding: 0 40px; width: 100%; }
.hub-gradient-text {
  background: linear-gradient(135deg, #8560A8 0%, #5674B9 30%, #448CCB 60%, #00BFF3 100%);
  -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
}
.hub-section { box-sizing: border-box; position: relative; }
.hub-section *, .hub-section *::before, .hub-section *::after { box-sizing: inherit; }
.hub-section img { max-width: 100%; height: auto; display: block; }

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
  padding: 160px 0 100px;
  color: #fff;
  position: relative;
  overflow: hidden;
}
.hub-hero::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0; bottom: 0;
  background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.02'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
  pointer-events: none;
}
.hub-hero-accent {
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 4px;
  background: <?php echo $accent; ?>;
}
.hub-hero-overline {
  font-family: 'Montserrat', sans-serif;
  font-size: 13px;
  text-transform: uppercase;
  letter-spacing: 3px;
  color: <?php echo $accent; ?>;
  margin-bottom: 16px;
}
.hub-hero h1 {
  font-family: 'Poppins', sans-serif;
  font-size: 56px;
  font-weight: 600;
  line-height: 1.15;
  margin: 0 0 20px;
  letter-spacing: -1px;
}
.hub-hero-desc {
  font-family: 'Assistant', sans-serif;
  font-size: 19px;
  color: rgba(255,255,255,0.6);
  max-width: 620px;
  line-height: 1.6;
  margin-bottom: 24px;
}
.hub-hero-count {
  font-family: 'Poppins', sans-serif;
  font-size: 14px;
  color: rgba(255,255,255,0.4);
  display: inline-flex;
  align-items: center;
  gap: 8px;
}
.hub-hero-count span {
  display: inline-block;
  width: 6px; height: 6px;
  border-radius: 50%;
  background: <?php echo $accent; ?>;
}

/* ========================================
   2. PILLAR POST
   ======================================== */
.hub-pillar {
  background: #fff;
  padding: 100px 0;
  position: relative;
}
.hub-pillar-card {
  display: grid;
  grid-template-columns: 1.4fr 1fr;
  gap: 0;
  background: #fff;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 4px 30px rgba(0,0,0,0.08);
  border: 1px solid rgba(0,0,0,0.04);
}
.hub-pillar-image {
  overflow: hidden;
  position: relative;
  min-height: 360px;
}
.hub-pillar-image img {
  width: 100%; height: 100%; object-fit: cover;
}
.hub-pillar-image .fallback-gradient {
  width: 100%; height: 100%;
  background: linear-gradient(135deg, <?php echo $accent; ?>, #252C3A);
  display: flex; align-items: center; justify-content: center;
  font-family: 'Poppins', sans-serif; font-size: 24px; color: rgba(255,255,255,0.2);
}
.hub-pillar-body {
  padding: 48px 40px;
  display: flex;
  flex-direction: column;
  justify-content: center;
}
.hub-pillar-tag {
  display: inline-block;
  font-family: 'Montserrat', sans-serif;
  font-size: 11px;
  text-transform: uppercase;
  letter-spacing: 2px;
  color: <?php echo $accent; ?>;
  background: rgba(133,96,168,0.08);
  padding: 4px 12px;
  border-radius: 4px;
  margin-bottom: 16px;
  width: fit-content;
}
.hub-pillar-body h2 {
  font-family: 'Poppins', sans-serif;
  font-size: 28px;
  font-weight: 600;
  line-height: 1.3;
  margin: 0 0 16px;
  color: #252C3A;
}
.hub-pillar-body h2 a { color: inherit; text-decoration: none; }
.hub-pillar-body h2 a:hover { color: #8560A8; }
.hub-pillar-body .pillar-excerpt {
  font-family: 'Assistant', sans-serif;
  font-size: 16px;
  color: #555;
  line-height: 1.7;
  margin-bottom: 16px;
}
.hub-pillar-meta {
  font-family: 'Assistant', sans-serif;
  font-size: 14px;
  color: rgba(37,44,58,0.45);
  margin-bottom: 24px;
}
.hub-pillar-btn {
  display: inline-block;
  padding: 14px 32px;
  background: linear-gradient(135deg, #8560A8, #5674B9);
  color: #fff;
  font-family: 'Poppins', sans-serif;
  font-size: 15px;
  font-weight: 500;
  border-radius: 8px;
  text-decoration: none;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  width: fit-content;
}
.hub-pillar-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 30px rgba(133,96,168,0.4);
}

/* ========================================
   3. POST GRID
   ======================================== */
.hub-grid-section {
  background: #f9f9fb;
  padding: 100px 0;
  position: relative;
}
.hub-section-heading {
  font-family: 'Poppins', sans-serif;
  font-size: 36px;
  font-weight: 600;
  color: #252C3A;
  text-align: center;
  margin: 0 0 48px;
}
.hub-posts-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 32px;
}
.hub-card {
  background: #fff;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 2px 16px rgba(0,0,0,0.06);
  transition: transform 0.4s ease, box-shadow 0.4s ease;
  border: 1px solid rgba(0,0,0,0.04);
}
.hub-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 12px 40px rgba(0,0,0,0.12);
}
.hub-card-image {
  aspect-ratio: 16/10;
  overflow: hidden;
  position: relative;
  display: block;
}
.hub-card-image img {
  width: 100%; height: 100%; object-fit: cover;
  transition: transform 0.6s ease;
}
.hub-card:hover .hub-card-image img { transform: scale(1.06); }
.hub-card-image .fallback-gradient {
  width: 100%; height: 100%;
  background: linear-gradient(135deg, #8560A8, #5674B9);
  display: flex; align-items: center; justify-content: center;
  font-family: 'Poppins', sans-serif; font-size: 18px; color: rgba(255,255,255,0.25);
}
.hub-card-body { padding: 24px; }
.hub-card-body .cat-badge {
  display: inline-block;
  font-family: 'Montserrat', sans-serif;
  font-size: 10px;
  text-transform: uppercase;
  letter-spacing: 2px;
  color: #8560A8;
  background: rgba(133,96,168,0.08);
  padding: 3px 10px;
  border-radius: 4px;
  margin-bottom: 10px;
}
.hub-card-body h3 {
  font-family: 'Poppins', sans-serif;
  font-size: 18px;
  font-weight: 600;
  line-height: 1.35;
  margin: 0 0 8px;
  color: #252C3A;
}
.hub-card-body h3 a { color: inherit; text-decoration: none; }
.hub-card-body h3 a:hover { color: #8560A8; }
.hub-card-body .card-excerpt {
  font-family: 'Assistant', sans-serif;
  font-size: 15px;
  color: #555;
  line-height: 1.5;
  margin-bottom: 16px;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
.hub-card-footer {
  font-family: 'Assistant', sans-serif;
  font-size: 13px;
  color: rgba(37,44,58,0.45);
  display: flex;
  justify-content: space-between;
}

/* Pagination */
.hub-pagination {
  text-align: center;
  margin-top: 56px;
}
.hub-pagination .page-numbers {
  display: inline-flex; align-items: center; justify-content: center;
  width: 44px; height: 44px;
  font-family: 'Poppins', sans-serif; font-size: 15px; font-weight: 500;
  color: #323A51; text-decoration: none;
  border-radius: 8px;
  transition: all 0.3s ease;
  margin: 0 3px;
}
.hub-pagination .page-numbers:hover { background: rgba(133,96,168,0.08); color: #8560A8; }
.hub-pagination .page-numbers.current {
  background: linear-gradient(135deg, #8560A8, #5674B9);
  color: #fff;
}

/* ========================================
   4. RELATED HUBS
   ======================================== */
.hub-related {
  background: #fff;
  padding: 80px 0;
  position: relative;
}
.hub-related-grid {
  display: flex;
  gap: 24px;
  flex-wrap: wrap;
  justify-content: center;
}
.hub-related-card {
  flex: 0 0 200px;
  background: #f9f9fb;
  border-radius: 12px;
  padding: 24px 20px;
  text-align: center;
  text-decoration: none;
  border-top: 3px solid;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.hub-related-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 24px rgba(0,0,0,0.08);
}
.hub-related-card h3 {
  font-family: 'Poppins', sans-serif;
  font-size: 16px;
  font-weight: 600;
  color: #252C3A;
  margin: 0 0 4px;
}
.hub-related-card .rel-count {
  font-family: 'Assistant', sans-serif;
  font-size: 13px;
  color: rgba(37,44,58,0.5);
}

/* ========================================
   5. CTA
   ======================================== */
.hub-cta-final {
  background: linear-gradient(135deg, #8560A8, #5674B9);
  padding: 80px 0;
  text-align: center;
  color: #fff;
}
.hub-cta-final h2 {
  font-family: 'Poppins', sans-serif;
  font-size: 36px;
  font-weight: 600;
  margin: 0 0 24px;
}
.hub-cta-final .cta-btn {
  display: inline-block;
  padding: 16px 40px;
  background: #fff;
  color: #8560A8;
  font-family: 'Poppins', sans-serif;
  font-size: 15px;
  font-weight: 600;
  border-radius: 8px;
  text-decoration: none;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.hub-cta-final .cta-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 30px rgba(0,0,0,0.2);
}

/* ========================================
   RESPONSIVE
   ======================================== */
@media (max-width: 960px) {
  .hub-posts-grid { grid-template-columns: repeat(2, 1fr); }
  .hub-pillar-card { grid-template-columns: 1fr; }
}
@media (max-width: 768px) {
  .hub-container { padding: 0 24px; }
  .hub-hero { padding: 130px 0 60px; }
  .hub-hero h1 { font-size: 36px; }
  .hub-section-heading { font-size: 28px; }
  .hub-pillar, .hub-grid-section, .hub-related { padding: 60px 0; }
  .hub-pillar-body { padding: 28px; }
  .hub-pillar-body h2 { font-size: 22px; }
  .hub-cta-final h2 { font-size: 28px; }
  .hub-related-card { flex: 0 0 160px; }
}
@media (max-width: 480px) {
  .hub-posts-grid { grid-template-columns: 1fr; }
  .hub-hero h1 { font-size: 28px; }
  .hub-pillar-body { padding: 20px; }
}
</style>

<!-- ============================
     1. HUB HERO
     ============================ -->
<section class="hub-section hub-hero">
  <div class="hub-hero-accent"></div>
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
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none"><polygon points="0,60 1440,0 1440,60" fill="#fff"/></svg>
  </div>
</section>

<!-- ============================
     2. PILLAR POST
     ============================ -->
<?php if ($pillar_id) :
  $pillar_post = get_post($pillar_id);
  setup_postdata($pillar_post);
  $p_read_time = ceil(str_word_count(strip_tags($pillar_post->post_content)) / 250);
  if ($p_read_time < 1) $p_read_time = 1;
?>
<section class="hub-section hub-pillar">
  <div class="hub-container">
    <div class="hub-pillar-card hub-reveal">
      <div class="hub-pillar-image">
        <?php if (has_post_thumbnail($pillar_id)) : ?>
          <img src="<?php echo esc_url(get_the_post_thumbnail_url($pillar_id, 'large')); ?>" alt="<?php echo esc_attr(get_the_title($pillar_id)); ?>">
        <?php else : ?>
          <div class="fallback-gradient"><?php echo esc_html($cat_name); ?></div>
        <?php endif; ?>
      </div>
      <div class="hub-pillar-body">
        <div class="hub-pillar-tag">Pillar Article</div>
        <h2><a href="<?php echo esc_url(get_permalink($pillar_id)); ?>"><?php echo esc_html(get_the_title($pillar_id)); ?></a></h2>
        <p class="pillar-excerpt"><?php echo wp_trim_words(get_the_excerpt($pillar_id), 40); ?></p>
        <div class="hub-pillar-meta"><?php echo esc_html(get_the_author_meta('display_name', $pillar_post->post_author)); ?> &middot; <?php echo esc_html(get_the_date('', $pillar_id)); ?> &middot; <?php echo $p_read_time; ?> min read</div>
        <a href="<?php echo esc_url(get_permalink($pillar_id)); ?>" class="hub-pillar-btn">Read the Guide &rarr;</a>
      </div>
    </div>
  </div>
  <?php wp_reset_postdata(); ?>

  <div class="hub-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none"><polygon points="0,0 1440,60 1440,60 0,60" fill="#f9f9fb"/></svg>
  </div>
</section>
<?php endif; ?>

<!-- ============================
     3. POST GRID
     ============================ -->
<section class="hub-section hub-grid-section">
  <div class="hub-container">
    <h2 class="hub-section-heading hub-reveal">All Articles</h2>
    <div class="hub-posts-grid">
      <?php
      $grid_query = new WP_Query([
          'post_type'      => 'post',
          'posts_per_page' => 9,
          'paged'          => $paged,
          'cat'            => $cat_id,
          'post__not_in'   => $pillar_id ? [$pillar_id] : [],
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
      <?php
        endwhile;
      endif;
      ?>
    </div>

    <div class="hub-pagination">
      <?php
      echo paginate_links([
          'total'   => $grid_query->max_num_pages,
          'current' => $paged,
          'prev_text' => '&larr;',
          'next_text' => '&rarr;',
      ]);
      wp_reset_postdata();
      ?>
    </div>
  </div>
</section>

<!-- ============================
     4. RELATED HUBS
     ============================ -->
<?php
$other_cats = get_categories(['hide_empty' => false, 'exclude' => [$cat_id, get_cat_ID('Uncategorized')]]);
if (!empty($other_cats)) :
?>
<section class="hub-section hub-related">
  <div class="hub-container">
    <h2 class="hub-section-heading hub-reveal">Explore More Topics</h2>
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
     5. CTA
     ============================ -->
<section class="hub-section hub-cta-final">
  <div class="hub-container hub-reveal">
    <h2>Want content like this for your brand?</h2>
    <a href="<?php echo esc_url(home_url('/contact-stretch-creative/')); ?>" class="cta-btn">Let&rsquo;s Talk</a>
  </div>
</section>

<script>
(function() {
  var revealEls = document.querySelectorAll('.hub-reveal');
  var observer = new IntersectionObserver(function(entries) {
    entries.forEach(function(entry) {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
  revealEls.forEach(function(el) { observer.observe(el); });
})();
</script>

<?php get_footer(); ?>
