<?php
/**
 * Template Name: Blog Home
 */
get_header();

// Featured post (latest)
$featured_query = new WP_Query([
    'post_type'      => 'post',
    'posts_per_page' => 1,
    'post_status'    => 'publish',
]);
$featured_id = 0;
if ($featured_query->have_posts()) {
    $featured_query->the_post();
    $featured_id = get_the_ID();
    $feat_cats = get_the_category();
    $feat_cat = $feat_cats ? $feat_cats[0] : null;
    $feat_read_time = ceil(str_word_count(strip_tags(get_the_content())) / 250);
    $feat_title = get_the_title();
    $feat_excerpt = wp_trim_words(get_the_excerpt(), 30);
    $feat_permalink = get_the_permalink();
    $feat_date = get_the_date();
    $feat_author = get_the_author();
    $feat_has_thumb = has_post_thumbnail();
    $feat_thumb = $feat_has_thumb ? get_the_post_thumbnail_url(null, 'large') : '';
    wp_reset_postdata();
}

// Pagination
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
?>

<style>
/* ========================================
   BLOG HOME — PREMIUM TEMPLATE
   ======================================== */
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

/* ---------- ANGLED DIVIDERS ---------- */
.blog-angle-divider {
  position: absolute; bottom: -1px; left: 0; right: 0; z-index: 2; pointer-events: none; line-height: 0;
}
.blog-angle-divider svg { display: block; width: 100%; height: 60px; }

/* ========================================
   1. MAGAZINE HERO
   ======================================== */
.blog-hero {
  background: linear-gradient(170deg, #252C3A 0%, #1a1f2e 100%);
  padding: 160px 0 100px;
  color: #fff;
  position: relative;
}
.blog-hero-overline {
  font-family: 'Montserrat', sans-serif;
  font-size: 13px;
  text-transform: uppercase;
  letter-spacing: 3px;
  color: #00BFF3;
  margin-bottom: 16px;
}
.blog-hero h1 {
  font-family: 'Poppins', sans-serif;
  font-size: 56px;
  font-weight: 600;
  line-height: 1.15;
  margin: 0 0 16px;
  letter-spacing: -1px;
}
.blog-hero-subtitle {
  font-family: 'Assistant', sans-serif;
  font-size: 19px;
  color: rgba(255,255,255,0.65);
  max-width: 620px;
  line-height: 1.6;
  margin-bottom: 48px;
}

/* Featured card */
.blog-featured-card {
  background: #1e2435;
  border-radius: 16px;
  overflow: hidden;
  display: grid;
  grid-template-columns: 1.2fr 1fr;
  gap: 0;
  border: 1px solid rgba(255,255,255,0.06);
  transition: transform 0.4s ease, box-shadow 0.4s ease;
}
.blog-featured-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 20px 60px rgba(0,0,0,0.4);
}
.blog-featured-card-image {
  aspect-ratio: 16/9;
  overflow: hidden;
  position: relative;
}
.blog-featured-card-image img {
  width: 100%; height: 100%; object-fit: cover;
  transition: transform 0.6s ease;
}
.blog-featured-card:hover .blog-featured-card-image img { transform: scale(1.05); }
.blog-featured-card-image .fallback-gradient {
  width: 100%; height: 100%;
  background: linear-gradient(135deg, #8560A8, #448CCB);
  display: flex; align-items: center; justify-content: center;
  font-family: 'Poppins', sans-serif; font-size: 24px; color: rgba(255,255,255,0.3);
}
.blog-featured-card-body {
  padding: 40px;
  display: flex;
  flex-direction: column;
  justify-content: center;
}
.blog-featured-card-body .cat-badge {
  display: inline-block;
  font-family: 'Montserrat', sans-serif;
  font-size: 11px;
  text-transform: uppercase;
  letter-spacing: 2px;
  color: #00BFF3;
  background: rgba(0,191,243,0.1);
  padding: 4px 12px;
  border-radius: 4px;
  margin-bottom: 16px;
  width: fit-content;
}
.blog-featured-card-body h3 {
  font-family: 'Poppins', sans-serif;
  font-size: 26px;
  font-weight: 600;
  line-height: 1.3;
  margin: 0 0 12px;
  color: #fff;
}
.blog-featured-card-body h3 a { color: inherit; text-decoration: none; }
.blog-featured-card-body h3 a:hover { color: #00BFF3; }
.blog-featured-card-body .excerpt {
  font-family: 'Assistant', sans-serif;
  font-size: 16px;
  color: rgba(255,255,255,0.55);
  line-height: 1.6;
  margin-bottom: 20px;
}
.blog-featured-card-meta {
  font-family: 'Assistant', sans-serif;
  font-size: 14px;
  color: rgba(255,255,255,0.4);
  margin-bottom: 20px;
}
.blog-featured-card-link {
  font-family: 'Poppins', sans-serif;
  font-size: 15px;
  font-weight: 500;
  color: #00BFF3;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  transition: gap 0.3s ease;
}
.blog-featured-card-link:hover { gap: 14px; }

/* ========================================
   2. HUB NAVIGATION
   ======================================== */
.blog-hubs {
  background: #f9f9fb;
  padding: 100px 0;
  position: relative;
}
.blog-section-heading {
  font-family: 'Poppins', sans-serif;
  font-size: 36px;
  font-weight: 600;
  color: #252C3A;
  text-align: center;
  margin: 0 0 48px;
}
.blog-hubs-grid {
  display: flex;
  gap: 24px;
  overflow-x: auto;
  scroll-snap-type: x mandatory;
  -webkit-overflow-scrolling: touch;
  padding-bottom: 8px;
}
.blog-hubs-grid::-webkit-scrollbar { height: 4px; }
.blog-hubs-grid::-webkit-scrollbar-thumb { background: #8560A8; border-radius: 4px; }
.blog-hub-card {
  flex: 0 0 260px;
  scroll-snap-align: start;
  background: #fff;
  border-radius: 12px;
  padding: 28px 24px;
  border-top: 4px solid;
  box-shadow: 0 2px 16px rgba(0,0,0,0.06);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  text-decoration: none;
  display: block;
}
.blog-hub-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 30px rgba(0,0,0,0.1);
}
.blog-hub-card h3 {
  font-family: 'Poppins', sans-serif;
  font-size: 18px;
  font-weight: 600;
  color: #252C3A;
  margin: 0 0 6px;
}
.blog-hub-card .hub-count {
  font-family: 'Assistant', sans-serif;
  font-size: 13px;
  color: rgba(37,44,58,0.5);
  margin-bottom: 8px;
}
.blog-hub-card .hub-desc {
  font-family: 'Assistant', sans-serif;
  font-size: 14px;
  color: #323A51;
  line-height: 1.5;
}

/* ========================================
   3. LATEST POSTS GRID
   ======================================== */
.blog-latest {
  background: #fff;
  padding: 100px 0;
  position: relative;
}
.blog-posts-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 32px;
}
.blog-card {
  background: #fff;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 2px 16px rgba(0,0,0,0.06);
  transition: transform 0.4s ease, box-shadow 0.4s ease;
  border: 1px solid rgba(0,0,0,0.04);
}
.blog-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 12px 40px rgba(0,0,0,0.12);
}
.blog-card-image {
  aspect-ratio: 16/10;
  overflow: hidden;
  position: relative;
  display: block;
}
.blog-card-image img {
  width: 100%; height: 100%; object-fit: cover;
  transition: transform 0.6s ease;
}
.blog-card:hover .blog-card-image img { transform: scale(1.06); }
.blog-card-image .fallback-gradient {
  width: 100%; height: 100%;
  background: linear-gradient(135deg, #8560A8, #5674B9);
  display: flex; align-items: center; justify-content: center;
  font-family: 'Poppins', sans-serif; font-size: 18px; color: rgba(255,255,255,0.25);
}
.blog-card-body {
  padding: 24px;
}
.blog-card-body .cat-badge {
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
.blog-card-body h3 {
  font-family: 'Poppins', sans-serif;
  font-size: 18px;
  font-weight: 600;
  line-height: 1.35;
  margin: 0 0 8px;
  color: #252C3A;
}
.blog-card-body h3 a { color: inherit; text-decoration: none; }
.blog-card-body h3 a:hover { color: #8560A8; }
.blog-card-body .card-excerpt {
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
.blog-card-footer {
  font-family: 'Assistant', sans-serif;
  font-size: 13px;
  color: rgba(37,44,58,0.45);
  display: flex;
  justify-content: space-between;
  align-items: center;
}

/* Pagination */
.blog-pagination {
  text-align: center;
  margin-top: 56px;
}
.blog-pagination .page-numbers {
  display: inline-flex; align-items: center; justify-content: center;
  width: 44px; height: 44px;
  font-family: 'Poppins', sans-serif; font-size: 15px; font-weight: 500;
  color: #323A51; text-decoration: none;
  border-radius: 8px;
  transition: all 0.3s ease;
  margin: 0 3px;
}
.blog-pagination .page-numbers:hover { background: rgba(133,96,168,0.08); color: #8560A8; }
.blog-pagination .page-numbers.current {
  background: linear-gradient(135deg, #8560A8, #5674B9);
  color: #fff;
}

/* ========================================
   4. NEWSLETTER CTA
   ======================================== */
.blog-newsletter {
  background: linear-gradient(170deg, #252C3A, #1a1f2e);
  padding: 100px 0;
  color: #fff;
  position: relative;
}
.blog-newsletter-inner {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 60px;
  align-items: center;
}
.blog-newsletter h2 {
  font-family: 'Poppins', sans-serif;
  font-size: 36px;
  font-weight: 600;
  margin: 0 0 12px;
}
.blog-newsletter .nl-subtitle {
  font-family: 'Assistant', sans-serif;
  font-size: 17px;
  color: rgba(255,255,255,0.6);
  line-height: 1.6;
}
.blog-newsletter-form {
  display: flex;
  gap: 12px;
}
.blog-newsletter-form input[type="email"] {
  flex: 1;
  padding: 16px 20px;
  border-radius: 8px;
  border: 1px solid rgba(255,255,255,0.15);
  background: rgba(255,255,255,0.06);
  color: #fff;
  font-family: 'Assistant', sans-serif;
  font-size: 16px;
  outline: none;
  transition: border-color 0.3s ease;
}
.blog-newsletter-form input[type="email"]::placeholder { color: rgba(255,255,255,0.35); }
.blog-newsletter-form input[type="email"]:focus { border-color: #00BFF3; }
.blog-newsletter-form button {
  padding: 16px 32px;
  border: none;
  border-radius: 8px;
  background: linear-gradient(135deg, #8560A8, #5674B9);
  color: #fff;
  font-family: 'Poppins', sans-serif;
  font-size: 15px;
  font-weight: 500;
  cursor: pointer;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  white-space: nowrap;
}
.blog-newsletter-form button:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 30px rgba(133,96,168,0.4);
}

/* ========================================
   5. FINAL CTA
   ======================================== */
.blog-cta-final {
  background: linear-gradient(135deg, #8560A8, #5674B9);
  padding: 80px 0;
  text-align: center;
  color: #fff;
}
.blog-cta-final h2 {
  font-family: 'Poppins', sans-serif;
  font-size: 36px;
  font-weight: 600;
  margin: 0 0 24px;
}
.blog-cta-final .cta-btn {
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
.blog-cta-final .cta-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 30px rgba(0,0,0,0.2);
}

/* ========================================
   RESPONSIVE
   ======================================== */
@media (max-width: 960px) {
  .blog-posts-grid { grid-template-columns: repeat(2, 1fr); }
  .blog-featured-card { grid-template-columns: 1fr; }
  .blog-featured-card-body { padding: 28px; }
  .blog-newsletter-inner { grid-template-columns: 1fr; gap: 32px; }
}
@media (max-width: 768px) {
  .blog-container { padding: 0 24px; }
  .blog-hero { padding: 130px 0 60px; }
  .blog-hero h1 { font-size: 36px; }
  .blog-hero-subtitle { font-size: 16px; }
  .blog-featured-card-body h3 { font-size: 20px; }
  .blog-section-heading { font-size: 28px; }
  .blog-hubs, .blog-latest, .blog-newsletter { padding: 60px 0; }
  .blog-newsletter-form { flex-direction: column; }
  .blog-cta-final h2 { font-size: 28px; }
}
@media (max-width: 480px) {
  .blog-posts-grid { grid-template-columns: 1fr; }
  .blog-hero h1 { font-size: 28px; }
  .blog-featured-card-body { padding: 20px; }
  .blog-hub-card { flex: 0 0 220px; }
}
</style>

<!-- ============================
     1. MAGAZINE HERO
     ============================ -->
<section class="blog-section blog-hero">
  <div class="blog-container">
    <div class="blog-reveal">
      <div class="blog-hero-overline">Insights &amp; Ideas</div>
      <h1>The Stretch Creative <span class="blog-gradient-text">Blog</span></h1>
      <p class="blog-hero-subtitle">Expert perspectives on content strategy, SEO, design, and the future of digital storytelling.</p>
    </div>

    <?php if ($featured_id) : ?>
    <div class="blog-featured-card blog-reveal">
      <div class="blog-featured-card-image">
        <?php if ($feat_has_thumb) : ?>
          <a href="<?php echo esc_url($feat_permalink); ?>">
            <img src="<?php echo esc_url($feat_thumb); ?>" alt="<?php echo esc_attr($feat_title); ?>">
          </a>
        <?php else : ?>
          <a href="<?php echo esc_url($feat_permalink); ?>"><div class="fallback-gradient">Stretch Creative</div></a>
        <?php endif; ?>
      </div>
      <div class="blog-featured-card-body">
        <?php if ($feat_cat) : ?>
          <span class="cat-badge"><?php echo esc_html($feat_cat->name); ?></span>
        <?php endif; ?>
        <h3><a href="<?php echo esc_url($feat_permalink); ?>"><?php echo esc_html($feat_title); ?></a></h3>
        <p class="excerpt"><?php echo esc_html($feat_excerpt); ?></p>
        <div class="blog-featured-card-meta"><?php echo esc_html($feat_author); ?> &middot; <?php echo esc_html($feat_date); ?> &middot; <?php echo $feat_read_time; ?> min read</div>
        <a href="<?php echo esc_url($feat_permalink); ?>" class="blog-featured-card-link">Read Article &rarr;</a>
      </div>
    </div>
    <?php endif; ?>
  </div>

  <div class="blog-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none"><polygon points="0,60 1440,0 1440,60" fill="#f9f9fb"/></svg>
  </div>
</section>

<!-- ============================
     2. HUB NAVIGATION
     ============================ -->
<section class="blog-section blog-hubs">
  <div class="blog-container">
    <h2 class="blog-section-heading blog-reveal">Explore by Topic</h2>
    <div class="blog-hubs-grid blog-reveal">
      <?php
      $hub_colors = ['#8560A8', '#5674B9', '#448CCB', '#00BFF3', '#6B8F3C', '#D4783F', '#C74B6F'];
      $categories = get_categories(['hide_empty' => false, 'exclude' => get_cat_ID('Uncategorized')]);
      $ci = 0;
      foreach ($categories as $cat) :
        $color = $hub_colors[$ci % count($hub_colors)];
        $ci++;
      ?>
        <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" class="blog-hub-card" style="border-top-color: <?php echo $color; ?>;">
          <h3><?php echo esc_html($cat->name); ?></h3>
          <div class="hub-count"><?php echo $cat->count; ?> <?php echo $cat->count === 1 ? 'Article' : 'Articles'; ?></div>
          <?php if ($cat->description) : ?>
            <div class="hub-desc"><?php echo esc_html(wp_trim_words($cat->description, 15)); ?></div>
          <?php endif; ?>
        </a>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="blog-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none"><polygon points="0,0 1440,60 1440,60 0,60" fill="#fff"/></svg>
  </div>
</section>

<!-- ============================
     3. LATEST POSTS GRID
     ============================ -->
<section class="blog-section blog-latest">
  <div class="blog-container">
    <h2 class="blog-section-heading blog-reveal">Latest Articles</h2>
    <div class="blog-posts-grid">
      <?php
      $latest = new WP_Query([
          'post_type'      => 'post',
          'posts_per_page' => 9,
          'paged'          => $paged,
          'post__not_in'   => $featured_id ? [$featured_id] : [],
          'post_status'    => 'publish',
      ]);
      if ($latest->have_posts()) :
        while ($latest->have_posts()) : $latest->the_post();
          $card_cats = get_the_category();
          $card_cat = $card_cats ? $card_cats[0] : null;
          $read_time = ceil(str_word_count(strip_tags(get_the_content())) / 250);
          if ($read_time < 1) $read_time = 1;
      ?>
        <article class="blog-card blog-reveal">
          <a href="<?php the_permalink(); ?>" class="blog-card-image">
            <?php if (has_post_thumbnail()) : ?>
              <?php the_post_thumbnail('blog-card'); ?>
            <?php else : ?>
              <div class="fallback-gradient">Stretch</div>
            <?php endif; ?>
          </a>
          <div class="blog-card-body">
            <?php if ($card_cat) : ?>
              <span class="cat-badge"><?php echo esc_html($card_cat->name); ?></span>
            <?php endif; ?>
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <p class="card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 18); ?></p>
            <div class="blog-card-footer">
              <span><?php the_author(); ?> &middot; <?php echo get_the_date(); ?></span>
              <span><?php echo $read_time; ?> min read</span>
            </div>
          </div>
        </article>
      <?php
        endwhile;
      endif;
      ?>
    </div>

    <div class="blog-pagination">
      <?php
      echo paginate_links([
          'total'   => $latest->max_num_pages,
          'current' => $paged,
          'prev_text' => '&larr;',
          'next_text' => '&rarr;',
      ]);
      wp_reset_postdata();
      ?>
    </div>
  </div>

  <div class="blog-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none"><polygon points="0,60 1440,0 1440,60" fill="#252C3A"/></svg>
  </div>
</section>

<!-- ============================
     4. NEWSLETTER CTA
     ============================ -->
<section class="blog-section blog-newsletter">
  <div class="blog-container">
    <div class="blog-newsletter-inner blog-reveal">
      <div>
        <h2>Stay in the loop</h2>
        <p class="nl-subtitle">Get the latest insights on content strategy, SEO, and digital storytelling delivered to your inbox. No spam, just valuable content.</p>
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

<!-- ============================
     5. FINAL CTA
     ============================ -->
<section class="blog-section blog-cta-final">
  <div class="blog-container blog-reveal">
    <h2>Ready to scale your content?</h2>
    <a href="<?php echo esc_url(home_url('/contact-stretch-creative/')); ?>" class="cta-btn">Get Started</a>
  </div>
</section>

<script>
(function() {
  var revealEls = document.querySelectorAll('.blog-reveal');
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
