<?php
/**
 * Template Name: Service Page
 *
 * Reusable service page template. Reads content from a WordPress option
 * keyed by the page slug: stretch_service_{slug}
 */
get_header();

$slug    = get_post_field('post_name', get_the_ID());
$service = get_option('stretch_service_' . $slug, []);

// Defaults
$headline    = !empty($service['headline'])    ? $service['headline']    : get_the_title();
$subheadline = !empty($service['subheadline']) ? $service['subheadline'] : '';
$offerings   = !empty($service['offerings'])   ? $service['offerings']   : [];
$why_heading = !empty($service['why_heading']) ? $service['why_heading'] : 'Why Stretch?';
$why_intro   = !empty($service['why_intro'])   ? $service['why_intro']   : '';
$benefits    = !empty($service['benefits'])    ? $service['benefits']    : [];
$faqs        = !empty($service['faqs'])        ? $service['faqs']        : [];
?>

<style>
/* ========================================
   SERVICE PAGE — REUSABLE TEMPLATE
   ======================================== */

html, body { overflow-x: hidden; }
.admin-bar .site-nav { top: 32px; }
@media (max-width: 782px) { .admin-bar .site-nav { top: 46px; } }

.svc-section { box-sizing: border-box; }
.svc-section *, .svc-section *::before, .svc-section *::after { box-sizing: inherit; }
.svc-section img { max-width: 100%; height: auto; display: block; }

.svc-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 40px;
  width: 100%;
}
.svc-gradient-text {
  background: linear-gradient(135deg, #8560A8 0%, #5674B9 30%, #448CCB 60%, #00BFF3 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

/* ---------- REVEAL ANIMATIONS ---------- */
.svc-reveal {
  opacity: 0; transform: translateY(40px);
  transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}
.svc-reveal.visible { opacity: 1; transform: translateY(0); }
.svc-reveal-left {
  opacity: 0; transform: translateX(-60px);
  transition: opacity 0.9s cubic-bezier(0.16, 1, 0.3, 1), transform 0.9s cubic-bezier(0.16, 1, 0.3, 1);
}
.svc-reveal-left.visible { opacity: 1; transform: translateX(0); }
.svc-delay-1 { transition-delay: 0.1s; }
.svc-delay-2 { transition-delay: 0.2s; }
.svc-delay-3 { transition-delay: 0.3s; }
.svc-delay-4 { transition-delay: 0.4s; }
.svc-delay-5 { transition-delay: 0.5s; }
.svc-delay-6 { transition-delay: 0.6s; }

/* ---------- ANGLED DIVIDERS ---------- */
.svc-angle-divider {
  position: absolute; bottom: -1px; left: 0; right: 0;
  z-index: 2; pointer-events: none; line-height: 0;
}
.svc-angle-divider svg { display: block; width: 100%; height: 60px; }

/* ========================================
   1. HERO
   ======================================== */
.svc-hero {
  position: relative;
  min-height: 60vh;
  display: flex;
  align-items: center;
  background: linear-gradient(170deg, #1a1f2e 0%, #252C3A 40%, #1e2333 100%);
  overflow: hidden;
  padding: 140px 0 100px;
}
.svc-hero::before {
  content: '';
  position: absolute;
  top: -50%; right: -20%;
  width: 80%; height: 150%;
  background: radial-gradient(ellipse at center, rgba(86,116,185,0.08) 0%, transparent 70%);
  pointer-events: none;
}
.svc-hero::after {
  content: '';
  position: absolute;
  bottom: -30%; left: -10%;
  width: 60%; height: 80%;
  background: radial-gradient(ellipse at center, rgba(133,96,168,0.06) 0%, transparent 70%);
  pointer-events: none;
}
.svc-hero-shapes {
  position: absolute; inset: 0; pointer-events: none; z-index: 1;
}
.svc-shape {
  position: absolute; border-radius: 50%; opacity: 0.12;
}
.svc-shape-1 { width: 300px; height: 300px; top: 10%; left: 5%; background: radial-gradient(circle, #8560A8, transparent); }
.svc-shape-2 { width: 200px; height: 200px; top: 55%; left: 65%; background: radial-gradient(circle, #5674B9, transparent); }
.svc-shape-3 { width: 150px; height: 150px; top: 20%; right: 10%; background: radial-gradient(circle, #00BFF3, transparent); }
.svc-shape-4 { width: 100px; height: 100px; bottom: 15%; left: 30%; background: radial-gradient(circle, #448CCB, transparent); border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; }

.svc-hero-content {
  position: relative; z-index: 2;
  text-align: center;
  max-width: 740px; margin: 0 auto;
}
.svc-hero-content h1 {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(36px, 4.5vw, 58px);
  font-weight: 600; line-height: 1.1;
  color: #fff; margin: 0 0 24px; letter-spacing: -1px;
}
.svc-hero-content .svc-subtitle {
  font-family: 'Assistant', sans-serif;
  font-size: 19px; font-weight: 300; line-height: 1.7;
  color: rgba(255,255,255,0.7);
  max-width: 600px; margin: 0 auto 36px;
}
.svc-btn-primary {
  display: inline-block;
  font-family: 'Poppins', sans-serif;
  font-size: 15px; font-weight: 500;
  color: #fff;
  background: linear-gradient(135deg, #8560A8, #5674B9);
  padding: 16px 40px; border-radius: 6px;
  text-decoration: none;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  box-shadow: 0 4px 20px rgba(133,96,168,0.3);
}
.svc-btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 30px rgba(133,96,168,0.45);
}

/* ========================================
   2. OFFERINGS GRID
   ======================================== */
.svc-offerings {
  padding: 120px 0;
  background: #fff;
  position: relative;
}
.svc-section-heading {
  text-align: center;
  margin-bottom: 64px;
}
.svc-section-heading .svc-overline {
  font-family: 'Montserrat', sans-serif;
  font-size: 12px; letter-spacing: 3px;
  text-transform: uppercase; color: #00BFF3;
  display: block; margin-bottom: 16px;
}
.svc-section-heading h2 {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(32px, 4vw, 44px);
  font-weight: 600; color: #252C3A; margin: 0;
}
.svc-offerings-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 28px;
}
.svc-offering-card {
  background: #fff;
  border-radius: 10px;
  padding: 32px 28px;
  border: 1px solid rgba(0,0,0,0.06);
  border-left: 4px solid #8560A8;
  transition: transform 0.4s cubic-bezier(0.16,1,0.3,1), box-shadow 0.4s ease;
}
.svc-offering-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 16px 48px rgba(37,44,58,0.1);
}
.svc-offering-card h3 {
  font-family: 'Poppins', sans-serif;
  font-size: 18px; font-weight: 600;
  color: #252C3A; margin: 0 0 10px;
}
.svc-offering-card p {
  font-family: 'Assistant', sans-serif;
  font-size: 16px; font-weight: 300;
  line-height: 1.65; color: #555; margin: 0;
}

/* ========================================
   3. WHY STRETCH
   ======================================== */
.svc-why {
  padding: 120px 0;
  background: #f9f9fb;
  position: relative;
}
.svc-why-intro {
  font-family: 'Assistant', sans-serif;
  font-size: 19px; font-weight: 300; line-height: 1.7;
  color: #555; text-align: center;
  max-width: 700px; margin: -32px auto 56px;
}
.svc-benefits-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 32px;
}
.svc-benefit-card {
  background: #fff;
  border-radius: 10px;
  padding: 36px 30px;
  border: 1px solid rgba(0,0,0,0.04);
  transition: transform 0.4s cubic-bezier(0.16,1,0.3,1), box-shadow 0.4s ease;
}
.svc-benefit-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 40px rgba(37,44,58,0.08);
}
.svc-benefit-accent {
  width: 40px; height: 3px;
  border-radius: 2px;
  margin-bottom: 20px;
}
.svc-benefit-accent-1 { background: #8560A8; }
.svc-benefit-accent-2 { background: #5674B9; }
.svc-benefit-accent-3 { background: #448CCB; }
.svc-benefit-accent-4 { background: #00BFF3; }
.svc-benefit-card h3 {
  font-family: 'Poppins', sans-serif;
  font-size: 18px; font-weight: 600;
  color: #252C3A; margin: 0 0 10px;
}
.svc-benefit-card p {
  font-family: 'Assistant', sans-serif;
  font-size: 16px; font-weight: 300;
  line-height: 1.65; color: #555; margin: 0;
}

/* ========================================
   4. FAQ ACCORDION
   ======================================== */
.svc-faq {
  padding: 120px 0;
  background: #fff;
  position: relative;
}
.svc-accordion {
  max-width: 800px;
  margin: 0 auto;
  list-style: none;
  padding: 0;
}
.svc-accordion-item {
  border-bottom: 1px solid rgba(0,0,0,0.08);
}
.svc-accordion-item:first-child {
  border-top: 1px solid rgba(0,0,0,0.08);
}
.svc-accordion-trigger {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
  padding: 24px 0;
  background: none;
  border: none;
  cursor: pointer;
  font-family: 'Poppins', sans-serif;
  font-size: 17px; font-weight: 500;
  color: #252C3A;
  text-align: left;
  transition: color 0.3s ease;
}
.svc-accordion-trigger:hover { color: #8560A8; }
.svc-accordion-trigger[aria-expanded="true"] { color: #8560A8; }
.svc-accordion-icon {
  flex-shrink: 0;
  width: 24px; height: 24px;
  position: relative;
  transition: transform 0.3s ease;
}
.svc-accordion-icon::before,
.svc-accordion-icon::after {
  content: '';
  position: absolute;
  background: currentColor;
  border-radius: 1px;
  transition: transform 0.3s ease;
}
.svc-accordion-icon::before {
  width: 14px; height: 2px;
  top: 50%; left: 50%;
  transform: translate(-50%, -50%);
}
.svc-accordion-icon::after {
  width: 2px; height: 14px;
  top: 50%; left: 50%;
  transform: translate(-50%, -50%);
}
.svc-accordion-trigger[aria-expanded="true"] .svc-accordion-icon::after {
  transform: translate(-50%, -50%) rotate(90deg);
}
.svc-accordion-panel {
  overflow: hidden;
  max-height: 0;
  transition: max-height 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}
.svc-accordion-panel-inner {
  padding: 0 0 24px;
  font-family: 'Assistant', sans-serif;
  font-size: 16px; font-weight: 300;
  line-height: 1.7; color: #555;
}

/* ========================================
   5. CTA
   ======================================== */
.svc-cta {
  padding: 100px 0;
  background: linear-gradient(135deg, #8560A8, #5674B9);
  text-align: center;
  position: relative;
  overflow: hidden;
}
.svc-cta::before {
  content: '';
  position: absolute;
  top: 30%; left: 50%;
  transform: translate(-50%, -50%);
  width: 600px; height: 600px;
  background: radial-gradient(circle, rgba(0,191,243,0.12), transparent 70%);
  pointer-events: none;
}
.svc-cta h2 {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(32px, 4vw, 48px);
  font-weight: 600; color: #fff;
  margin: 0 0 16px; position: relative;
}
.svc-cta p {
  font-family: 'Assistant', sans-serif;
  font-size: 19px; font-weight: 300;
  color: rgba(255,255,255,0.7);
  margin-bottom: 36px; position: relative;
}
.svc-cta .svc-btn-white {
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
.svc-cta .svc-btn-white:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 30px rgba(0,0,0,0.25);
}

/* ========================================
   RESPONSIVE
   ======================================== */
@media (max-width: 960px) {
  .svc-offerings-grid { grid-template-columns: 1fr; }
  .svc-benefits-grid { grid-template-columns: 1fr; }
}
@media (max-width: 768px) {
  .svc-container { padding: 0 24px; }
  .svc-hero { padding: 100px 0 70px; }
  .svc-hero-content h1 { font-size: 34px; }
  .svc-offerings { padding: 80px 0; }
  .svc-why { padding: 80px 0; }
  .svc-faq { padding: 80px 0; }
  .svc-cta { padding: 70px 0; }
}
@media (max-width: 480px) {
  .svc-container { padding: 0 16px; }
  .svc-accordion-trigger { font-size: 15px; }
}
</style>


<!-- ========================================
     1. HERO
     ======================================== -->
<section class="svc-section svc-hero" aria-label="Hero">
  <div class="svc-hero-shapes">
    <div class="svc-shape svc-shape-1"></div>
    <div class="svc-shape svc-shape-2"></div>
    <div class="svc-shape svc-shape-3"></div>
    <div class="svc-shape svc-shape-4"></div>
  </div>

  <div class="svc-container">
    <div class="svc-hero-content">
      <h1 class="svc-reveal svc-delay-1"><?php echo esc_html($headline); ?></h1>
      <?php if ($subheadline) : ?>
        <p class="svc-subtitle svc-reveal svc-delay-2"><?php echo esc_html($subheadline); ?></p>
      <?php endif; ?>
      <a href="/contact-stretch-creative/" class="svc-btn-primary svc-reveal svc-delay-3">Get Started &rarr;</a>
    </div>
  </div>

  <div class="svc-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none">
      <polygon points="0,60 1440,0 1440,60" fill="#ffffff"/>
    </svg>
  </div>
</section>


<!-- ========================================
     2. OFFERINGS
     ======================================== -->
<?php if (!empty($offerings)) : ?>
<section class="svc-section svc-offerings" aria-label="What We Offer">
  <div class="svc-container">
    <div class="svc-section-heading">
      <span class="svc-overline svc-reveal">Services</span>
      <h2 class="svc-reveal svc-delay-1">What We <span class="svc-gradient-text">Offer</span></h2>
    </div>

    <div class="svc-offerings-grid">
      <?php foreach ($offerings as $i => $item) :
        $delay = ($i % 4) + 1;
      ?>
        <div class="svc-offering-card svc-reveal svc-delay-<?php echo $delay; ?>">
          <h3><?php echo esc_html($item['title']); ?></h3>
          <p><?php echo esc_html($item['description']); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="svc-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none">
      <polygon points="0,0 1440,60 1440,60 0,60" fill="#f9f9fb"/>
    </svg>
  </div>
</section>
<?php endif; ?>


<!-- ========================================
     3. WHY STRETCH
     ======================================== -->
<?php if (!empty($benefits)) : ?>
<section class="svc-section svc-why" aria-label="Why Stretch">
  <div class="svc-container">
    <div class="svc-section-heading">
      <span class="svc-overline svc-reveal">The Difference</span>
      <h2 class="svc-reveal svc-delay-1"><?php echo esc_html($why_heading); ?></h2>
    </div>

    <?php if ($why_intro) : ?>
      <p class="svc-why-intro svc-reveal svc-delay-2"><?php echo esc_html($why_intro); ?></p>
    <?php endif; ?>

    <div class="svc-benefits-grid">
      <?php foreach ($benefits as $i => $item) :
        $accent = ($i % 4) + 1;
        $delay  = ($i % 4) + 1;
      ?>
        <div class="svc-benefit-card svc-reveal svc-delay-<?php echo $delay; ?>">
          <div class="svc-benefit-accent svc-benefit-accent-<?php echo $accent; ?>"></div>
          <h3><?php echo esc_html($item['title']); ?></h3>
          <p><?php echo esc_html($item['description']); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="svc-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none">
      <polygon points="0,60 1440,0 1440,60" fill="#ffffff"/>
    </svg>
  </div>
</section>
<?php endif; ?>


<!-- ========================================
     4. FAQ ACCORDION
     ======================================== -->
<?php if (!empty($faqs)) : ?>
<section class="svc-section svc-faq" aria-label="Frequently Asked Questions">
  <div class="svc-container">
    <div class="svc-section-heading">
      <span class="svc-overline svc-reveal">FAQ</span>
      <h2 class="svc-reveal svc-delay-1">Frequently Asked <span class="svc-gradient-text">Questions</span></h2>
    </div>

    <div class="svc-accordion" role="list">
      <?php foreach ($faqs as $i => $faq) :
        $id = 'svc-faq-' . $i;
      ?>
        <div class="svc-accordion-item svc-reveal svc-delay-<?php echo min(($i % 4) + 1, 4); ?>" role="listitem">
          <button class="svc-accordion-trigger"
                  aria-expanded="false"
                  aria-controls="<?php echo $id; ?>">
            <span><?php echo esc_html($faq['question']); ?></span>
            <span class="svc-accordion-icon" aria-hidden="true"></span>
          </button>
          <div class="svc-accordion-panel" id="<?php echo $id; ?>" role="region">
            <div class="svc-accordion-panel-inner">
              <?php echo wp_kses_post($faq['answer']); ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="svc-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none">
      <polygon points="0,0 1440,60 1440,60 0,60" fill="#8560A8"/>
    </svg>
  </div>
</section>
<?php endif; ?>


<!-- ========================================
     5. CTA
     ======================================== -->
<section class="svc-section svc-cta" aria-label="Call to Action">
  <div class="svc-container">
    <h2 class="svc-reveal">Ready to Get Started?</h2>
    <p class="svc-reveal svc-delay-1">Tell us about your project and we&rsquo;ll show you how Stretch can help.</p>
    <a href="/contact-stretch-creative/" class="svc-btn-white svc-reveal svc-delay-2">Contact Us &rarr;</a>
  </div>
</section>


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

  document.querySelectorAll('.svc-reveal, .svc-reveal-left').forEach(function(el) {
    revealObserver.observe(el);
  });

  /* ---------- ACCORDION ---------- */
  document.querySelectorAll('.svc-accordion-trigger').forEach(function(btn) {
    btn.addEventListener('click', function() {
      var expanded = btn.getAttribute('aria-expanded') === 'true';
      var panel = document.getElementById(btn.getAttribute('aria-controls'));

      // Close all others
      document.querySelectorAll('.svc-accordion-trigger').forEach(function(other) {
        if (other !== btn) {
          other.setAttribute('aria-expanded', 'false');
          var otherPanel = document.getElementById(other.getAttribute('aria-controls'));
          if (otherPanel) otherPanel.style.maxHeight = '0';
        }
      });

      // Toggle current
      if (expanded) {
        btn.setAttribute('aria-expanded', 'false');
        panel.style.maxHeight = '0';
      } else {
        btn.setAttribute('aria-expanded', 'true');
        panel.style.maxHeight = panel.scrollHeight + 'px';
      }
    });
  });
})();
</script>

<?php get_footer(); ?>
