<?php
/**
 * Template Name: Portfolio (Our Work)
 *
 * Displays a filterable grid of selected portfolio work.
 * Items are stored as a curated list of WP media attachment IDs
 * with category and client metadata. To add/remove items, edit
 * the $portfolio array below.
 */
get_header();

$portfolio = stretch_get_portfolio();
?>

<style>
/* ========================================
   PORTFOLIO — PREMIUM TEMPLATE
   ======================================== */

html, body { overflow-x: hidden; }
.admin-bar .site-nav { top: 32px; }
@media (max-width: 782px) { .admin-bar .site-nav { top: 46px; } }

.v2-section { box-sizing: border-box; }
.v2-section *, .v2-section *::before, .v2-section *::after { box-sizing: inherit; }

.v2-container {
  max-width: 1280px;
  margin: 0 auto;
  padding: 0 40px;
  width: 100%;
}
.gradient-text {
  background: linear-gradient(135deg, #8560A8 0%, #5674B9 30%, #448CCB 60%, #00BFF3 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

/* ---------- REVEAL ANIMATIONS ---------- */
.v2-reveal {
  opacity: 0; transform: translateY(40px);
  transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}
.v2-reveal.visible { opacity: 1; transform: translateY(0); }
.v2-delay-1 { transition-delay: 0.1s; }
.v2-delay-2 { transition-delay: 0.2s; }
.v2-delay-3 { transition-delay: 0.3s; }
.v2-delay-4 { transition-delay: 0.4s; }

/* ---------- ANGLE DIVIDERS ---------- */
.v2-angle-divider {
  position: absolute; bottom: -1px; left: 0; right: 0;
  z-index: 2; pointer-events: none; line-height: 0;
}
.v2-angle-divider svg { display: block; width: 100%; height: 60px; }

/* ========================================
   1. HERO
   ======================================== */
.pf-hero {
  position: relative;
  min-height: 50vh;
  display: flex;
  align-items: center;
  background: linear-gradient(170deg, #1a1f2e 0%, #252C3A 40%, #1e2333 100%);
  overflow: hidden;
  padding: 140px 0 100px;
}
.pf-hero::before {
  content: '';
  position: absolute;
  top: -40%; right: -15%;
  width: 75%; height: 140%;
  background: radial-gradient(ellipse at center, rgba(86,116,185,0.08), transparent 70%);
  pointer-events: none;
}
.pf-hero::after {
  content: '';
  position: absolute;
  bottom: -30%; left: -10%;
  width: 60%; height: 80%;
  background: radial-gradient(ellipse at center, rgba(133,96,168,0.06), transparent 70%);
  pointer-events: none;
}
.pf-hero-shapes { position: absolute; inset: 0; pointer-events: none; z-index: 1; }
.pf-shape { position: absolute; border-radius: 50%; opacity: 0.12; }
.pf-shape-1 { width: 280px; height: 280px; top: 12%; left: 6%; background: radial-gradient(circle, #8560A8, transparent); }
.pf-shape-2 { width: 200px; height: 200px; top: 60%; left: 70%; background: radial-gradient(circle, #5674B9, transparent); }
.pf-shape-3 { width: 140px; height: 140px; top: 22%; right: 8%; background: radial-gradient(circle, #00BFF3, transparent); }

.pf-hero-content {
  position: relative; z-index: 2;
  text-align: center;
  max-width: 760px; margin: 0 auto;
}
.pf-hero-content .v2-overline {
  font-family: 'Montserrat', sans-serif;
  font-size: 13px; letter-spacing: 3px;
  text-transform: uppercase; color: #00BFF3;
  margin-bottom: 20px; display: block;
}
.pf-hero-content h1 {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(36px, 5vw, 60px);
  font-weight: 600; line-height: 1.1;
  color: #fff; margin: 0 0 24px; letter-spacing: -1px;
}
.pf-hero-content .v2-subtitle {
  font-family: 'Assistant', sans-serif;
  font-size: 19px; font-weight: 300; line-height: 1.7;
  color: rgba(255,255,255,0.72);
  max-width: 620px; margin: 0 auto;
}

/* ========================================
   2. FILTERS
   ======================================== */
.pf-filters-wrap {
  background: #fff;
  padding: 56px 0 24px;
  position: sticky;
  top: 0;
  z-index: 10;
  border-bottom: 1px solid rgba(0,0,0,0.05);
}
.admin-bar .pf-filters-wrap { top: 32px; }
@media (max-width: 782px) { .admin-bar .pf-filters-wrap { top: 46px; } }
.pf-filters {
  display: flex;
  gap: 12px;
  justify-content: center;
  flex-wrap: wrap;
}
.pf-filter-btn {
  font-family: 'Poppins', sans-serif;
  font-size: 14px; font-weight: 500;
  color: #555;
  background: #fff;
  border: 1px solid rgba(0,0,0,0.1);
  padding: 10px 22px;
  border-radius: 100px;
  cursor: pointer;
  transition: all 0.3s ease;
  letter-spacing: 0.3px;
}
.pf-filter-btn:hover {
  color: #8560A8;
  border-color: rgba(133,96,168,0.4);
  background: rgba(133,96,168,0.04);
}
.pf-filter-btn.active {
  color: #fff;
  background: linear-gradient(135deg, #8560A8, #5674B9);
  border-color: transparent;
  box-shadow: 0 4px 16px rgba(133,96,168,0.25);
}
.pf-filter-count {
  display: inline-block;
  margin-left: 6px;
  opacity: 0.6;
  font-size: 12px;
  font-weight: 400;
}

/* ========================================
   3. GRID
   ======================================== */
.pf-grid-section {
  padding: 48px 0 120px;
  background: #fff;
  position: relative;
}
.pf-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 24px;
}
.pf-card {
  position: relative;
  border-radius: 12px;
  overflow: hidden;
  background: #f9f9fb;
  cursor: pointer;
  aspect-ratio: 4 / 3;
  display: block;
  text-decoration: none;
  color: inherit;
  transition: transform 0.5s cubic-bezier(0.16,1,0.3,1), box-shadow 0.5s ease;
}
.pf-card.hidden { display: none; }
.pf-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 24px 64px rgba(37,44,58,0.14);
}
.pf-card-img-wrap {
  position: absolute; inset: 0;
  overflow: hidden;
}
.pf-card img {
  width: 100%; height: 100%;
  object-fit: cover;
  transition: transform 0.7s cubic-bezier(0.16,1,0.3,1);
  display: block;
}
.pf-card:hover img { transform: scale(1.06); }
.pf-card-overlay {
  position: absolute; inset: 0;
  background: linear-gradient(0deg, rgba(37,44,58,0.92) 0%, rgba(37,44,58,0.4) 50%, transparent 100%);
  z-index: 1;
  opacity: 0;
  transition: opacity 0.4s ease;
}
.pf-card:hover .pf-card-overlay { opacity: 1; }
.pf-card-content {
  position: absolute; bottom: 0; left: 0; right: 0;
  padding: 24px;
  z-index: 2;
  transform: translateY(24px);
  transition: transform 0.4s cubic-bezier(0.16,1,0.3,1);
  opacity: 0;
}
.pf-card:hover .pf-card-content {
  transform: translateY(0);
  opacity: 1;
}
.pf-card-tag {
  display: inline-block;
  font-family: 'Poppins', sans-serif;
  font-size: 10px; font-weight: 600;
  letter-spacing: 2px; text-transform: uppercase;
  color: #00BFF3;
  border: 1px solid rgba(0,191,243,0.4);
  padding: 4px 10px;
  margin-bottom: 12px;
  border-radius: 100px;
}
.pf-card-client {
  font-family: 'Poppins', sans-serif;
  font-size: 20px; font-weight: 500;
  color: #fff; line-height: 1.2;
  margin: 0;
}
.pf-card-vimeo {
  position: absolute;
  top: 16px; right: 16px;
  z-index: 3;
  background: rgba(0,0,0,0.5);
  backdrop-filter: blur(8px);
  border-radius: 50%;
  width: 44px; height: 44px;
  display: flex;
  align-items: center;
  justify-content: center;
  pointer-events: none;
  opacity: 0;
  transition: opacity 0.4s ease, transform 0.4s ease;
  transform: scale(0.8);
}
.pf-card:hover .pf-card-vimeo {
  opacity: 1;
  transform: scale(1);
}
.pf-card-vimeo svg { width: 16px; height: 16px; fill: #fff; margin-left: 2px; }

/* Always-visible label below the card on mobile */
.pf-card-label {
  display: none;
}

/* ========================================
   4. CTA
   ======================================== */
.pf-cta {
  padding: 100px 0;
  background: linear-gradient(135deg, #8560A8, #5674B9);
  text-align: center;
  position: relative;
  overflow: hidden;
}
.pf-cta::before {
  content: '';
  position: absolute;
  top: 30%; left: 50%;
  transform: translate(-50%, -50%);
  width: 600px; height: 600px;
  background: radial-gradient(circle, rgba(0,191,243,0.12), transparent 70%);
  pointer-events: none;
}
.pf-cta h2 {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(32px, 4vw, 48px);
  font-weight: 600; color: #fff;
  margin: 0 0 16px; position: relative;
}
.pf-cta p {
  font-family: 'Assistant', sans-serif;
  font-size: 19px; font-weight: 300;
  color: rgba(255,255,255,0.75);
  margin-bottom: 36px; position: relative;
  max-width: 560px; margin-left: auto; margin-right: auto;
}
.pf-cta .v2-btn-primary {
  display: inline-block;
  font-family: 'Poppins', sans-serif;
  font-size: 15px; font-weight: 500;
  color: #8560A8; background: #fff;
  padding: 16px 40px; border-radius: 6px;
  text-decoration: none;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  box-shadow: 0 4px 20px rgba(0,0,0,0.15);
  position: relative;
}
.pf-cta .v2-btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 30px rgba(0,0,0,0.25);
}

/* ========================================
   5. LIGHTBOX (for clicking cards)
   ======================================== */
.pf-lightbox {
  position: fixed;
  inset: 0;
  background: rgba(15,18,28,0.94);
  backdrop-filter: blur(8px);
  z-index: 9999;
  display: none;
  align-items: center;
  justify-content: center;
  padding: 40px;
  opacity: 0;
  transition: opacity 0.3s ease;
}
.pf-lightbox.open {
  display: flex;
  opacity: 1;
}
.pf-lightbox-inner {
  position: relative;
  max-width: 1100px;
  width: 100%;
  max-height: 90vh;
  display: flex;
  flex-direction: column;
  align-items: center;
}
.pf-lightbox img,
.pf-lightbox iframe {
  max-width: 100%;
  max-height: 75vh;
  border-radius: 8px;
  box-shadow: 0 24px 80px rgba(0,0,0,0.5);
  display: block;
}
.pf-lightbox iframe {
  width: 100%;
  aspect-ratio: 16 / 9;
  border: none;
}
.pf-lightbox-meta {
  margin-top: 20px;
  text-align: center;
  color: #fff;
  font-family: 'Poppins', sans-serif;
}
.pf-lightbox-client {
  font-size: 22px; font-weight: 500;
  margin: 0 0 6px;
}
.pf-lightbox-tag {
  font-size: 12px; font-weight: 500;
  letter-spacing: 2px; text-transform: uppercase;
  color: #00BFF3;
  opacity: 0.85;
}
.pf-lightbox-close {
  position: absolute;
  top: 24px; right: 24px;
  width: 44px; height: 44px;
  border-radius: 50%;
  background: rgba(255,255,255,0.1);
  border: 1px solid rgba(255,255,255,0.2);
  color: #fff;
  cursor: pointer;
  font-size: 22px; line-height: 1;
  display: flex; align-items: center; justify-content: center;
  transition: all 0.3s ease;
  z-index: 10000;
}
.pf-lightbox-close:hover {
  background: rgba(255,255,255,0.2);
  transform: rotate(90deg);
}

/* ========================================
   RESPONSIVE
   ======================================== */
@media (max-width: 960px) {
  .pf-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
  .v2-container { padding: 0 24px; }
  .pf-hero { padding: 100px 0 70px; min-height: auto; }
  .pf-filters-wrap { position: static; padding: 32px 0 16px; }
  .pf-grid { grid-template-columns: 1fr; gap: 16px; }
  .pf-grid-section { padding: 32px 0 80px; }
  .pf-cta { padding: 70px 0; }
  /* Show always-visible label on mobile since hover doesn't apply */
  .pf-card { aspect-ratio: 16 / 10; }
  .pf-card-overlay { opacity: 1; background: linear-gradient(0deg, rgba(37,44,58,0.85) 0%, rgba(37,44,58,0.2) 60%, transparent 100%); }
  .pf-card-content { opacity: 1; transform: translateY(0); padding: 18px; }
  .pf-lightbox { padding: 20px; }
}
@media (max-width: 480px) {
  .v2-container { padding: 0 16px; }
  .pf-filter-btn { font-size: 13px; padding: 9px 16px; }
}

@media (prefers-reduced-motion: reduce) {
  .v2-reveal { opacity: 1 !important; transform: none !important; transition: none !important; }
  .pf-card, .pf-card img, .pf-card-content, .pf-card-overlay { transition: none !important; }
}
</style>


<!-- ========================================
     1. HERO
     ======================================== -->
<section class="v2-section pf-hero" aria-label="Portfolio Hero">
  <div class="pf-hero-shapes">
    <div class="pf-shape pf-shape-1"></div>
    <div class="pf-shape pf-shape-2"></div>
    <div class="pf-shape pf-shape-3"></div>
  </div>

  <div class="v2-container">
    <div class="pf-hero-content">
      <span class="v2-overline v2-reveal v2-delay-1">Selected Work</span>
      <h1 class="v2-reveal v2-delay-2">Our <span class="gradient-text">Work</span></h1>
      <p class="v2-subtitle v2-reveal v2-delay-3">A snapshot of recent projects across writing, design, photography, and video — for brands we&rsquo;re proud to work with.</p>
    </div>
  </div>
</section>


<!-- ========================================
     2. FILTERS
     ======================================== -->
<?php
$counts = [
    'all'     => count($portfolio),
    'writing' => count(array_filter($portfolio, fn($p) => $p['category'] === 'writing')),
    'design'  => count(array_filter($portfolio, fn($p) => $p['category'] === 'design')),
    'video'   => count(array_filter($portfolio, fn($p) => $p['category'] === 'video')),
];
?>
<div class="pf-filters-wrap">
  <div class="v2-container">
    <div class="pf-filters" role="tablist" aria-label="Portfolio filters">
      <button class="pf-filter-btn active" data-filter="all" role="tab" aria-selected="true">All <span class="pf-filter-count"><?php echo $counts['all']; ?></span></button>
      <button class="pf-filter-btn" data-filter="writing" role="tab">Writing <span class="pf-filter-count"><?php echo $counts['writing']; ?></span></button>
      <button class="pf-filter-btn" data-filter="design" role="tab">Graphic Design <span class="pf-filter-count"><?php echo $counts['design']; ?></span></button>
      <button class="pf-filter-btn" data-filter="video" role="tab">Video &amp; Photography <span class="pf-filter-count"><?php echo $counts['video']; ?></span></button>
    </div>
  </div>
</div>


<!-- ========================================
     3. GRID
     ======================================== -->
<section class="v2-section pf-grid-section" aria-label="Portfolio Grid">
  <div class="v2-container">
    <div class="pf-grid" id="pfGrid">
      <?php foreach ($portfolio as $i => $item) :
        $img_url = wp_get_attachment_image_url($item['id'], 'large');
        $img_full = wp_get_attachment_image_url($item['id'], 'full');
        $alt     = get_post_meta($item['id'], '_wp_attachment_image_alt', true);
        if (!$img_url) continue;
      ?>
        <a href="#"
           class="pf-card v2-reveal v2-delay-<?php echo (($i % 4) + 1); ?>"
           data-category="<?php echo esc_attr($item['category']); ?>"
           data-img="<?php echo esc_url($img_full); ?>"
           data-client="<?php echo esc_attr($item['client']); ?>"
           data-tag="<?php echo esc_attr($item['subcat']); ?>"
           <?php if (!empty($item['vimeo'])) : ?>data-vimeo="<?php echo esc_attr($item['vimeo']); ?>"<?php endif; ?>
           aria-label="<?php echo esc_attr($item['client'] . ' — ' . $item['subcat']); ?>">
          <div class="pf-card-img-wrap">
            <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($alt ?: $item['client'] . ' ' . $item['subcat']); ?>" loading="lazy">
          </div>
          <?php if (!empty($item['vimeo'])) : ?>
          <div class="pf-card-vimeo" aria-hidden="true">
            <svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
          </div>
          <?php endif; ?>
          <div class="pf-card-overlay"></div>
          <div class="pf-card-content">
            <span class="pf-card-tag"><?php echo esc_html($item['subcat']); ?></span>
            <h3 class="pf-card-client"><?php echo esc_html($item['client']); ?></h3>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>


<!-- ========================================
     4. CTA
     ======================================== -->
<section class="v2-section pf-cta" aria-label="Call to Action">
  <div class="v2-container">
    <h2 class="v2-reveal">Like what you see?</h2>
    <p class="v2-reveal v2-delay-1">Tell us about your project and we&rsquo;ll show you how Stretch can help bring it to life.</p>
    <a href="/contact-stretch-creative/" class="v2-btn-primary v2-reveal v2-delay-2">Start a Project &rarr;</a>
  </div>
</section>


<!-- ========================================
     5. LIGHTBOX
     ======================================== -->
<div class="pf-lightbox" id="pfLightbox" role="dialog" aria-modal="true" aria-hidden="true">
  <button class="pf-lightbox-close" id="pfLightboxClose" aria-label="Close">&times;</button>
  <div class="pf-lightbox-inner" id="pfLightboxInner"></div>
</div>


<script>
(function() {
  /* ---------- SCROLL REVEAL ---------- */
  var revealObserver = new IntersectionObserver(function(entries) {
    entries.forEach(function(entry) {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        revealObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });

  document.querySelectorAll('.v2-reveal').forEach(function(el) {
    revealObserver.observe(el);
  });

  /* ---------- FILTERS ---------- */
  var filterBtns = document.querySelectorAll('.pf-filter-btn');
  var cards = document.querySelectorAll('.pf-card');

  filterBtns.forEach(function(btn) {
    btn.addEventListener('click', function() {
      var filter = btn.dataset.filter;

      filterBtns.forEach(function(b) {
        b.classList.remove('active');
        b.setAttribute('aria-selected', 'false');
      });
      btn.classList.add('active');
      btn.setAttribute('aria-selected', 'true');

      cards.forEach(function(card) {
        if (filter === 'all' || card.dataset.category === filter) {
          card.classList.remove('hidden');
        } else {
          card.classList.add('hidden');
        }
      });
    });
  });

  /* ---------- LIGHTBOX ---------- */
  var lightbox = document.getElementById('pfLightbox');
  var lightboxInner = document.getElementById('pfLightboxInner');
  var lightboxClose = document.getElementById('pfLightboxClose');

  function openLightbox(card) {
    var imgUrl = card.dataset.img;
    var client = card.dataset.client;
    var tag    = card.dataset.tag;
    var vimeo  = card.dataset.vimeo;

    var media;
    if (vimeo) {
      media = '<iframe src="https://player.vimeo.com/video/' + vimeo + '?h=0&title=0&byline=0&portrait=0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>';
    } else {
      media = '<img src="' + imgUrl + '" alt="' + client + '">';
    }

    lightboxInner.innerHTML = media +
      '<div class="pf-lightbox-meta">' +
        '<p class="pf-lightbox-client">' + client + '</p>' +
        '<span class="pf-lightbox-tag">' + tag + '</span>' +
      '</div>';

    lightbox.classList.add('open');
    lightbox.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
  }

  function closeLightbox() {
    lightbox.classList.remove('open');
    lightbox.setAttribute('aria-hidden', 'true');
    lightboxInner.innerHTML = '';
    document.body.style.overflow = '';
  }

  cards.forEach(function(card) {
    card.addEventListener('click', function(e) {
      e.preventDefault();
      openLightbox(card);
    });
  });

  lightboxClose.addEventListener('click', closeLightbox);
  lightbox.addEventListener('click', function(e) {
    if (e.target === lightbox) closeLightbox();
  });
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && lightbox.classList.contains('open')) closeLightbox();
  });
})();
</script>

<?php get_footer(); ?>
