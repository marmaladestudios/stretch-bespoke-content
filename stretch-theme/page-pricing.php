<?php
/**
 * Template Name: Pricing
 */
get_header();
?>

<style>
/* ========================================
   PRICING — PREMIUM TEMPLATE
   ======================================== */

html, body { overflow-x: hidden; }

/* ---------- ADMIN BAR FIX ---------- */
.admin-bar .site-nav { top: 32px; }
@media (max-width: 782px) { .admin-bar .site-nav { top: 46px; } }

/* ---------- RESET / BASE ---------- */
.v2-section { box-sizing: border-box; }
.v2-section *, .v2-section *::before, .v2-section *::after { box-sizing: inherit; }

/* ---------- UTILITIES ---------- */
.v2-container {
  max-width: 1200px;
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
.pric-hero {
  position: relative;
  min-height: 55vh;
  display: flex;
  align-items: center;
  background: linear-gradient(170deg, #1a1f2e 0%, #252C3A 40%, #1e2333 100%);
  overflow: hidden;
  padding: 140px 0 100px;
}
.pric-hero::before {
  content: '';
  position: absolute;
  top: -40%; right: -15%;
  width: 75%; height: 140%;
  background: radial-gradient(ellipse at center, rgba(86,116,185,0.08) 0%, transparent 70%);
  pointer-events: none;
}
.pric-hero::after {
  content: '';
  position: absolute;
  bottom: -30%; left: -10%;
  width: 60%; height: 80%;
  background: radial-gradient(ellipse at center, rgba(133,96,168,0.06) 0%, transparent 70%);
  pointer-events: none;
}
.pric-hero-shapes {
  position: absolute; inset: 0; pointer-events: none; z-index: 1;
}
.pric-shape {
  position: absolute; border-radius: 50%; opacity: 0.12;
}
.pric-shape-1 { width: 280px; height: 280px; top: 12%; left: 6%; background: radial-gradient(circle, #8560A8, transparent); }
.pric-shape-2 { width: 200px; height: 200px; top: 60%; left: 70%; background: radial-gradient(circle, #5674B9, transparent); }
.pric-shape-3 { width: 140px; height: 140px; top: 22%; right: 8%; background: radial-gradient(circle, #00BFF3, transparent); }

.pric-hero-content {
  position: relative; z-index: 2;
  text-align: center;
  max-width: 760px; margin: 0 auto;
}
.pric-hero-content .v2-overline {
  font-family: 'Montserrat', sans-serif;
  font-size: 13px; font-weight: 400;
  letter-spacing: 3px; text-transform: uppercase;
  color: #00BFF3; margin-bottom: 20px; display: block;
}
.pric-hero-content h1 {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(34px, 4.5vw, 56px);
  font-weight: 600; line-height: 1.15;
  color: #fff; margin: 0 0 24px; letter-spacing: -1px;
}
.pric-hero-content .v2-subtitle {
  font-family: 'Assistant', sans-serif;
  font-size: 18px; font-weight: 300; line-height: 1.7;
  color: rgba(255,255,255,0.72);
  max-width: 640px; margin: 0 auto;
}

/* ========================================
   2. PRICING MODELS
   ======================================== */
.pric-models {
  padding: 120px 0;
  background: #fff;
  position: relative;
}
.pric-models-heading {
  text-align: center;
  margin-bottom: 64px;
}
.pric-models-heading .v2-overline {
  font-family: 'Montserrat', sans-serif;
  font-size: 12px; letter-spacing: 3px;
  text-transform: uppercase; color: #00BFF3;
  display: block; margin-bottom: 16px;
}
.pric-models-heading h2 {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(30px, 3.5vw, 42px);
  font-weight: 600; color: #252C3A; margin: 0;
  letter-spacing: -0.3px;
}
.pric-models-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 28px;
}
.pric-model-card {
  background: #fff;
  border-radius: 12px;
  padding: 44px 36px;
  position: relative;
  border: 1px solid rgba(0,0,0,0.06);
  box-shadow: 0 4px 24px rgba(37,44,58,0.04);
  transition: transform 0.4s cubic-bezier(0.16,1,0.3,1), box-shadow 0.4s ease, border-color 0.4s ease;
  overflow: hidden;
}
.pric-model-card::before {
  content: '';
  position: absolute;
  top: 0; left: 0;
  width: 100%; height: 4px;
  background: linear-gradient(90deg, var(--pm-start, #8560A8), var(--pm-end, #00BFF3));
  opacity: 0;
  transition: opacity 0.3s ease;
}
.pric-model-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 20px 56px rgba(37,44,58,0.12);
  border-color: rgba(0,0,0,0.02);
}
.pric-model-card:hover::before { opacity: 1; }
.pric-model-icon {
  width: 56px; height: 56px;
  border-radius: 14px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 24px;
  background: linear-gradient(135deg, var(--pm-icon-a, rgba(133,96,168,0.1)), var(--pm-icon-b, rgba(0,191,243,0.1)));
}
.pric-model-icon svg { width: 28px; height: 28px; }
.pric-model-card h3 {
  font-family: 'Poppins', sans-serif;
  font-size: 22px; font-weight: 600;
  color: #252C3A; margin: 0 0 14px;
  letter-spacing: -0.3px;
}
.pric-model-card p {
  font-family: 'Assistant', sans-serif;
  font-size: 16px; font-weight: 300;
  line-height: 1.7; color: #555;
  margin: 0;
}

/* ========================================
   3. TAGLINE BANNER
   ======================================== */
.pric-tagline {
  padding: 110px 0;
  background: linear-gradient(135deg, #f9f9fb 0%, #f0f0f6 100%);
  position: relative;
  overflow: hidden;
}
.pric-tagline::before {
  content: '';
  position: absolute; top: 0; left: 0;
  width: 100%; height: 100%;
  background: linear-gradient(90deg, rgba(133,96,168,0.04), rgba(0,191,243,0.04), rgba(133,96,168,0.04));
  background-size: 200% 100%;
  animation: pricTaglineSlide 8s ease infinite;
  pointer-events: none;
}
@keyframes pricTaglineSlide {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}
.pric-tagline-inner {
  position: relative;
  text-align: center;
  max-width: 900px;
  margin: 0 auto;
}
.pric-tagline h2 {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(26px, 3.5vw, 40px);
  font-weight: 500;
  color: #323A51; line-height: 1.35;
  margin: 0;
  letter-spacing: -0.3px;
}
.pric-tagline h2 .gradient-text { font-weight: 600; }

/* ========================================
   4. CTA
   ======================================== */
.pric-cta {
  padding: 100px 0;
  background: linear-gradient(135deg, #8560A8, #5674B9);
  text-align: center;
  position: relative;
  overflow: hidden;
}
.pric-cta::before {
  content: '';
  position: absolute;
  top: 30%; left: 50%;
  transform: translate(-50%, -50%);
  width: 600px; height: 600px;
  background: radial-gradient(circle, rgba(0,191,243,0.12), transparent 70%);
  pointer-events: none;
}
.pric-cta-content {
  position: relative;
  max-width: 720px;
  margin: 0 auto;
}
.pric-cta p {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(22px, 2.5vw, 30px);
  font-weight: 400;
  color: #fff; line-height: 1.4;
  margin: 0 0 36px;
}
.pric-cta .v2-btn-primary {
  display: inline-block;
  font-family: 'Poppins', sans-serif;
  font-size: 15px; font-weight: 500;
  color: #8560A8; background: #fff;
  padding: 18px 44px; border-radius: 6px;
  text-decoration: none;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  box-shadow: 0 4px 20px rgba(0,0,0,0.15);
}
.pric-cta .v2-btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 30px rgba(0,0,0,0.25);
}

/* ========================================
   5. FAQ
   ======================================== */
.pric-faq {
  padding: 120px 0;
  background: #fff;
  position: relative;
}
.pric-faq-heading {
  text-align: center;
  margin-bottom: 56px;
}
.pric-faq-heading .v2-overline {
  font-family: 'Montserrat', sans-serif;
  font-size: 12px; letter-spacing: 3px;
  text-transform: uppercase; color: #00BFF3;
  display: block; margin-bottom: 16px;
}
.pric-faq-heading h2 {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(30px, 3.5vw, 42px);
  font-weight: 600; color: #252C3A; margin: 0;
  letter-spacing: -0.3px;
}
.pric-accordion {
  max-width: 820px;
  margin: 0 auto;
  list-style: none; padding: 0;
}
.pric-acc-item {
  margin-bottom: 12px;
  background: #fff;
  border-radius: 10px;
  border: 1px solid rgba(0,0,0,0.06);
  position: relative;
  overflow: hidden;
  transition: box-shadow 0.4s ease;
}
.pric-acc-item::before {
  content: '';
  position: absolute;
  left: 0; top: 0; bottom: 0;
  width: 4px;
  background: linear-gradient(180deg, #8560A8, #5674B9, #00BFF3);
  opacity: 0;
  transition: opacity 0.4s ease;
}
.pric-acc-item.pric-acc-open {
  box-shadow: 0 8px 32px rgba(37,44,58,0.06);
}
.pric-acc-item.pric-acc-open::before { opacity: 1; }
.pric-acc-trigger {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
  padding: 22px 28px;
  background: none; border: none;
  cursor: pointer;
  font-family: 'Poppins', sans-serif;
  font-size: 17px; font-weight: 500;
  color: #252C3A;
  text-align: left;
  transition: color 0.3s ease;
}
.pric-acc-trigger:hover { color: #8560A8; }
.pric-acc-trigger[aria-expanded="true"] { color: #8560A8; font-weight: 600; }
.pric-acc-icon {
  flex-shrink: 0;
  width: 28px; height: 28px;
  position: relative;
  transition: transform 0.4s cubic-bezier(0.16,1,0.3,1);
}
.pric-acc-icon::before,
.pric-acc-icon::after {
  content: '';
  position: absolute;
  background: currentColor;
  border-radius: 2px;
  transition: transform 0.4s cubic-bezier(0.16,1,0.3,1);
}
.pric-acc-icon::before {
  width: 16px; height: 2px;
  top: 50%; left: 50%;
  transform: translate(-50%, -50%);
}
.pric-acc-icon::after {
  width: 2px; height: 16px;
  top: 50%; left: 50%;
  transform: translate(-50%, -50%);
}
.pric-acc-trigger[aria-expanded="true"] .pric-acc-icon { transform: rotate(45deg); }
.pric-acc-panel {
  overflow: hidden;
  max-height: 0;
  transition: max-height 0.5s cubic-bezier(0.16, 1, 0.3, 1);
}
.pric-acc-panel-inner {
  padding: 0 28px 26px;
  font-family: 'Assistant', sans-serif;
  font-size: 16px; font-weight: 300;
  line-height: 1.75; color: #555;
}

/* ========================================
   RESPONSIVE
   ======================================== */
@media (max-width: 960px) {
  .pric-models-grid { grid-template-columns: 1fr; gap: 20px; }
}
@media (max-width: 768px) {
  .v2-container { padding: 0 24px; }
  .pric-hero { padding: 100px 0 70px; min-height: auto; }
  .pric-hero-content h1 { font-size: 32px; }
  .pric-models { padding: 80px 0; }
  .pric-model-card { padding: 36px 28px; }
  .pric-tagline { padding: 70px 0; }
  .pric-cta { padding: 70px 0; }
  .pric-faq { padding: 80px 0; }
  .pric-acc-trigger { padding: 20px 22px; font-size: 15px; }
  .pric-acc-panel-inner { padding: 0 22px 22px; font-size: 15px; }
}
@media (max-width: 480px) {
  .v2-container { padding: 0 16px; }
  .pric-hero-content h1 { font-size: 26px; }
  .pric-hero-content .v2-subtitle { font-size: 16px; }
  .pric-model-card { padding: 32px 24px; }
  .pric-model-card h3 { font-size: 20px; }
}

/* ---------- REDUCED MOTION ---------- */
@media (prefers-reduced-motion: reduce) {
  .v2-reveal { opacity: 1 !important; transform: none !important; transition: none !important; }
  .pric-tagline::before { animation: none !important; }
}
</style>


<!-- ========================================
     1. HERO
     ======================================== -->
<section class="v2-section pric-hero" aria-label="Pricing Hero">
  <div class="pric-hero-shapes">
    <div class="pric-shape pric-shape-1"></div>
    <div class="pric-shape pric-shape-2"></div>
    <div class="pric-shape pric-shape-3"></div>
  </div>

  <div class="v2-container">
    <div class="pric-hero-content">
      <span class="v2-overline v2-reveal v2-delay-1">Pricing</span>
      <h1 class="v2-reveal v2-delay-2">Transparent, flexible pricing <span class="gradient-text">means no surprises</span></h1>
      <p class="v2-subtitle v2-reveal v2-delay-3">Whether you&rsquo;re looking for a single project or an ongoing partnership, we&rsquo;ll create a custom plan to fit your goals and budget. And if your content needs change direction, we can too.</p>
    </div>
  </div>

  <div class="v2-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none">
      <polygon points="0,60 1440,0 1440,60" fill="#ffffff"/>
    </svg>
  </div>
</section>


<!-- ========================================
     2. PRICING MODELS
     ======================================== -->
<section class="v2-section pric-models" aria-label="Pricing Models">
  <div class="v2-container">
    <div class="pric-models-heading">
      <span class="v2-overline v2-reveal">How We Price</span>
      <h2 class="v2-reveal v2-delay-1">A model to fit <span class="gradient-text">every engagement</span></h2>
    </div>

    <div class="pric-models-grid">
      <div class="pric-model-card v2-reveal v2-delay-1" style="--pm-start:#8560A8;--pm-end:#5674B9;--pm-icon-a:rgba(133,96,168,0.1);--pm-icon-b:rgba(86,116,185,0.1);">
        <div class="pric-model-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="#8560A8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
        </div>
        <h3>Pay Per Asset</h3>
        <p>We price per deliverable &mdash; not by the hour or the word &mdash; so you always know what you&rsquo;re spending your budget on.</p>
      </div>

      <div class="pric-model-card v2-reveal v2-delay-2" style="--pm-start:#5674B9;--pm-end:#448CCB;--pm-icon-a:rgba(86,116,185,0.1);--pm-icon-b:rgba(68,140,203,0.1);">
        <div class="pric-model-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="#5674B9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
        </div>
        <h3>Flexible Retainer</h3>
        <p>Our flexible retainer models ensure we have the teams and processes in place to maintain consistent content production at scale.</p>
      </div>

      <div class="pric-model-card v2-reveal v2-delay-3" style="--pm-start:#448CCB;--pm-end:#00BFF3;--pm-icon-a:rgba(68,140,203,0.1);--pm-icon-b:rgba(0,191,243,0.1);">
        <div class="pric-model-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="#448CCB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </div>
        <h3>Ad-Hoc Content</h3>
        <p>If your content needs are seasonal or otherwise sporadic, we&rsquo;ll put you on an ad-hoc plan with no volume requirements or monthly minimums.</p>
      </div>
    </div>
  </div>
</section>


<!-- ========================================
     3. TAGLINE BANNER
     ======================================== -->
<section class="v2-section pric-tagline" aria-label="Tagline">
  <div class="v2-container">
    <div class="pric-tagline-inner">
      <h2 class="v2-reveal">No cookie-cutter packages, no hidden fees &mdash; <span class="gradient-text">just results.</span></h2>
    </div>
  </div>
</section>


<!-- ========================================
     4. CTA
     ======================================== -->
<section class="v2-section pric-cta" aria-label="Call to Action">
  <div class="v2-container">
    <div class="pric-cta-content">
      <p class="v2-reveal">Ready to learn more? Contact us for a free consultation and custom quote.</p>
      <a href="/contact-stretch-creative/" class="v2-btn-primary v2-reveal v2-delay-1">Get a Quote &rarr;</a>
    </div>
  </div>
</section>


<!-- ========================================
     5. FAQ
     ======================================== -->
<section class="v2-section pric-faq" aria-label="Frequently Asked Questions">
  <div class="v2-container">
    <div class="pric-faq-heading">
      <span class="v2-overline v2-reveal">FAQ</span>
      <h2 class="v2-reveal v2-delay-1">Frequently Asked <span class="gradient-text">Questions</span></h2>
    </div>

    <div class="pric-accordion" role="list">
      <div class="pric-acc-item v2-reveal v2-delay-1" role="listitem">
        <button class="pric-acc-trigger" aria-expanded="false" aria-controls="pric-faq-1">
          <span>Can you help with SEO-focused content writing?</span>
          <span class="pric-acc-icon" aria-hidden="true"></span>
        </button>
        <div class="pric-acc-panel" id="pric-faq-1" role="region">
          <div class="pric-acc-panel-inner">
            Absolutely. Our writers are skilled in crafting SEO-friendly content of all types to enhance your online visibility and drive more traffic to your website.
          </div>
        </div>
      </div>

      <div class="pric-acc-item v2-reveal v2-delay-2" role="listitem">
        <button class="pric-acc-trigger" aria-expanded="false" aria-controls="pric-faq-2">
          <span>What kind of businesses do you work with?</span>
          <span class="pric-acc-icon" aria-hidden="true"></span>
        </button>
        <div class="pric-acc-panel" id="pric-faq-2" role="region">
          <div class="pric-acc-panel-inner">
            We collaborate with businesses of all sizes across various industries. We tailor our content services to meet your unique goals and help you connect with your audience effectively.
          </div>
        </div>
      </div>

      <div class="pric-acc-item v2-reveal v2-delay-3" role="listitem">
        <button class="pric-acc-trigger" aria-expanded="false" aria-controls="pric-faq-3">
          <span>How does your content writing process work?</span>
          <span class="pric-acc-icon" aria-hidden="true"></span>
        </button>
        <div class="pric-acc-panel" id="pric-faq-3" role="region">
          <div class="pric-acc-panel-inner">
            Our process includes thorough research, expert writing, and a multi-layered editing review. Each piece is crafted to engage your target audience and is polished by a dedicated managing editor for maximum impact.
          </div>
        </div>
      </div>

      <div class="pric-acc-item v2-reveal v2-delay-4" role="listitem">
        <button class="pric-acc-trigger" aria-expanded="false" aria-controls="pric-faq-4">
          <span>What is the turnaround time for content delivery?</span>
          <span class="pric-acc-icon" aria-hidden="true"></span>
        </button>
        <div class="pric-acc-panel" id="pric-faq-4" role="region">
          <div class="pric-acc-panel-inner">
            Turnaround time depends on project scope, but we typically deliver high-quality content within 5 to 7 business days. For urgent needs, we offer expedited services without compromising quality.
          </div>
        </div>
      </div>

      <div class="pric-acc-item v2-reveal v2-delay-1" role="listitem">
        <button class="pric-acc-trigger" aria-expanded="false" aria-controls="pric-faq-5">
          <span>Can we start small and scale up?</span>
          <span class="pric-acc-icon" aria-hidden="true"></span>
        </button>
        <div class="pric-acc-panel" id="pric-faq-5" role="region">
          <div class="pric-acc-panel-inner">
            You bet. We can produce as little or as much content as you need. Our streamlined internal processes and flexible services are designed to help you scale quickly without sacrificing quality or consistency.
          </div>
        </div>
      </div>

      <div class="pric-acc-item v2-reveal v2-delay-2" role="listitem">
        <button class="pric-acc-trigger" aria-expanded="false" aria-controls="pric-faq-6">
          <span>Can you manage the entire content creation process?</span>
          <span class="pric-acc-icon" aria-hidden="true"></span>
        </button>
        <div class="pric-acc-panel" id="pric-faq-6" role="region">
          <div class="pric-acc-panel-inner">
            Yes. We can ideate, strategize, create, publish, and track all of your content &mdash; or we can just step in where you have gaps or when you need extra hands on deck. All the Stretch-ing we do makes us incredibly flexible &mdash; and that keeps you agile.
          </div>
        </div>
      </div>

      <div class="pric-acc-item v2-reveal v2-delay-3" role="listitem">
        <button class="pric-acc-trigger" aria-expanded="false" aria-controls="pric-faq-7">
          <span>Can you handle high-volume content needs?</span>
          <span class="pric-acc-icon" aria-hidden="true"></span>
        </button>
        <div class="pric-acc-panel" id="pric-faq-7" role="region">
          <div class="pric-acc-panel-inner">
            Yes. We hand-pick dedicated cohorts of experienced writers and editors who are happy to commit to high volumes. They&rsquo;re fully supported by a Stretch Managing Editor and our production team, who work closely together to ensure high quality and timely delivery.
          </div>
        </div>
      </div>

      <div class="pric-acc-item v2-reveal v2-delay-4" role="listitem">
        <button class="pric-acc-trigger" aria-expanded="false" aria-controls="pric-faq-8">
          <span>What makes Stretch Creative different from other content agencies?</span>
          <span class="pric-acc-icon" aria-hidden="true"></span>
        </button>
        <div class="pric-acc-panel" id="pric-faq-8" role="region">
          <div class="pric-acc-panel-inner">
            What sets us apart from the rest is our firm belief that good content requires tight collaborations among everyone involved. We offer integrated content services, so you don&rsquo;t need multiple agencies for SEO, writing, design, video, and ads. We collaborate internally and with your ing regularly scheduled touch-base meetings. our Client Services team chats about your content or billing needs and our Managing Editor discusses editorial feedback and content strategy.
          </div>
        </div>
      </div>

      <div class="pric-acc-item v2-reveal v2-delay-1" role="listitem">
        <button class="pric-acc-trigger" aria-expanded="false" aria-controls="pric-faq-9">
          <span>Do you work with in-house teams?</span>
          <span class="pric-acc-icon" aria-hidden="true"></span>
        </button>
        <div class="pric-acc-panel" id="pric-faq-9" role="region">
          <div class="pric-acc-panel-inner">
            Heck yeah. We&rsquo;re happy to collaborate with your in-house marketing or creative team to amplify your efforts. [what this might look like].
          </div>
        </div>
      </div>
    </div>
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

  document.querySelectorAll('.v2-reveal').forEach(function(el) {
    revealObserver.observe(el);
  });

  /* ---------- ACCORDION ---------- */
  document.querySelectorAll('.pric-acc-trigger').forEach(function(btn) {
    btn.addEventListener('click', function() {
      var expanded = btn.getAttribute('aria-expanded') === 'true';
      var panel = document.getElementById(btn.getAttribute('aria-controls'));
      var item = btn.closest('.pric-acc-item');

      document.querySelectorAll('.pric-acc-trigger').forEach(function(other) {
        if (other !== btn) {
          other.setAttribute('aria-expanded', 'false');
          var otherPanel = document.getElementById(other.getAttribute('aria-controls'));
          if (otherPanel) otherPanel.style.maxHeight = '0';
          var otherItem = other.closest('.pric-acc-item');
          if (otherItem) otherItem.classList.remove('pric-acc-open');
        }
      });

      if (expanded) {
        btn.setAttribute('aria-expanded', 'false');
        panel.style.maxHeight = '0';
        item.classList.remove('pric-acc-open');
      } else {
        btn.setAttribute('aria-expanded', 'true');
        panel.style.maxHeight = panel.scrollHeight + 'px';
        item.classList.add('pric-acc-open');
      }
    });
  });
})();
</script>

<?php get_footer(); ?>
