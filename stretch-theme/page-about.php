<?php
/**
 * Template Name: About Us
 */
get_header();
?>

<style>
/* ========================================
   ABOUT US — PREMIUM TEMPLATE
   ======================================== */

/* ---------- OVERFLOW FIX ---------- */
html, body { overflow-x: hidden; }

/* ---------- ADMIN BAR FIX ---------- */
.admin-bar .site-nav { top: 32px; }
@media (max-width: 782px) { .admin-bar .site-nav { top: 46px; } }

/* ---------- RESET / BASE ---------- */
.v2-section { box-sizing: border-box; }
.v2-section *, .v2-section *::before, .v2-section *::after { box-sizing: inherit; }
.v2-section img { max-width: 100%; height: auto; display: block; }

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
  opacity: 0;
  transform: translateY(40px);
  transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}
.v2-reveal.visible { opacity: 1; transform: translateY(0); }
.v2-reveal-left {
  opacity: 0;
  transform: translateX(-60px);
  transition: opacity 0.9s cubic-bezier(0.16, 1, 0.3, 1), transform 0.9s cubic-bezier(0.16, 1, 0.3, 1);
}
.v2-reveal-left.visible { opacity: 1; transform: translateX(0); }
.v2-reveal-right {
  opacity: 0;
  transform: translateX(60px);
  transition: opacity 0.9s cubic-bezier(0.16, 1, 0.3, 1), transform 0.9s cubic-bezier(0.16, 1, 0.3, 1);
}
.v2-reveal-right.visible { opacity: 1; transform: translateX(0); }
.v2-delay-1 { transition-delay: 0.1s; }
.v2-delay-2 { transition-delay: 0.2s; }
.v2-delay-3 { transition-delay: 0.3s; }
.v2-delay-4 { transition-delay: 0.4s; }
.v2-delay-5 { transition-delay: 0.5s; }
.v2-delay-6 { transition-delay: 0.6s; }

/* ---------- ANGLED SECTION DIVIDERS ---------- */
.v2-angle-divider {
  position: absolute;
  bottom: -1px;
  left: 0; right: 0;
  z-index: 2;
  pointer-events: none;
  line-height: 0;
}
.v2-angle-divider svg { display: block; width: 100%; height: 60px; }
.v2-angle-divider-top {
  position: absolute;
  top: -1px;
  left: 0; right: 0;
  z-index: 2;
  pointer-events: none;
  line-height: 0;
}
.v2-angle-divider-top svg { display: block; width: 100%; height: 60px; }

/* ========================================
   1. HERO
   ======================================== */
.about-hero {
  position: relative;
  min-height: 60vh;
  display: flex;
  align-items: center;
  background: linear-gradient(170deg, #1a1f2e 0%, #252C3A 40%, #1e2333 100%);
  overflow: hidden;
  padding: 140px 0 100px;
}
.about-hero::before {
  content: '';
  position: absolute;
  top: -50%; right: -20%;
  width: 80%; height: 150%;
  background: radial-gradient(ellipse at center, rgba(86,116,185,0.08) 0%, transparent 70%);
  pointer-events: none;
}
.about-hero::after {
  content: '';
  position: absolute;
  bottom: -30%; left: -10%;
  width: 60%; height: 80%;
  background: radial-gradient(ellipse at center, rgba(133,96,168,0.06) 0%, transparent 70%);
  pointer-events: none;
}
.about-hero-shapes {
  position: absolute;
  inset: 0;
  pointer-events: none;
  z-index: 1;
}
.about-shape {
  position: absolute;
  border-radius: 50%;
  opacity: 0.12;
  will-change: transform;
}
.about-shape-1 { width: 300px; height: 300px; top: 10%; left: 5%; background: radial-gradient(circle, #8560A8, transparent); }
.about-shape-2 { width: 200px; height: 200px; top: 60%; left: 60%; background: radial-gradient(circle, #5674B9, transparent); }
.about-shape-3 { width: 150px; height: 150px; top: 20%; right: 10%; background: radial-gradient(circle, #00BFF3, transparent); }
.about-shape-4 { width: 100px; height: 100px; bottom: 20%; right: 25%; background: radial-gradient(circle, #448CCB, transparent); border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; }

.about-hero-content {
  position: relative;
  z-index: 2;
  text-align: center;
  max-width: 700px;
  margin: 0 auto;
}
.about-hero-content .v2-overline {
  font-family: 'Montserrat', sans-serif;
  font-size: 13px;
  font-weight: 400;
  letter-spacing: 3px;
  text-transform: uppercase;
  color: #00BFF3;
  margin-bottom: 20px;
  display: block;
}
.about-hero-content h1 {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(36px, 4.5vw, 58px);
  font-weight: 600;
  line-height: 1.1;
  color: #fff;
  margin: 0 0 24px;
  letter-spacing: -1px;
}
.about-hero-content .v2-subtitle {
  font-family: 'Assistant', sans-serif;
  font-size: 19px;
  font-weight: 300;
  line-height: 1.7;
  color: rgba(255,255,255,0.7);
  max-width: 520px;
  margin: 0 auto;
}

/* ========================================
   2. STORY CONTENT
   ======================================== */
.about-story {
  padding: 120px 0;
  background: #fff;
  position: relative;
}
.about-story-inner {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 80px;
  align-items: center;
}
.about-story-text h2 {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(28px, 3vw, 38px);
  font-weight: 600;
  color: #252C3A;
  margin: 0 0 24px;
  line-height: 1.2;
}
.about-story-text p {
  font-family: 'Assistant', sans-serif;
  font-size: 17px;
  font-weight: 300;
  line-height: 1.8;
  color: #555;
  margin-bottom: 20px;
}
.about-story-quote {
  font-family: 'Poppins', sans-serif;
  font-size: 20px;
  font-weight: 500;
  color: #8560A8;
  border-left: 4px solid;
  border-image: linear-gradient(180deg, #8560A8, #00BFF3) 1;
  padding: 16px 0 16px 24px;
  margin: 32px 0;
  line-height: 1.5;
}
.about-story-image {
  position: relative;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 24px 64px rgba(37,44,58,0.12);
}
.about-story-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 6s ease;
}
.about-story-image:hover img { transform: scale(1.05); }
.about-story-image::after {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, rgba(133,96,168,0.1), rgba(0,191,243,0.05));
  mix-blend-mode: multiply;
}

/* ========================================
   2.5 STRATEGIC PARTNER
   ======================================== */
.about-partner {
  padding: 120px 0;
  background: #fafbfd;
  position: relative;
}
.about-partner-heading {
  text-align: center;
  max-width: 760px;
  margin: 0 auto 64px;
}
.about-partner-heading h2 {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(30px, 3.5vw, 42px);
  font-weight: 600;
  color: #252C3A;
  margin: 0 0 20px;
  line-height: 1.2;
  letter-spacing: -0.5px;
}
.about-partner-subtitle {
  font-family: 'Assistant', sans-serif;
  font-size: 18px;
  font-weight: 300;
  line-height: 1.7;
  color: #555;
  margin: 0;
}
.about-partner-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 32px;
}
.about-partner-card {
  background: #fff;
  border-radius: 12px;
  padding: 40px 32px;
  position: relative;
  border: 1px solid rgba(0,0,0,0.04);
  box-shadow: 0 4px 24px rgba(37,44,58,0.04);
  transition: transform 0.4s cubic-bezier(0.16,1,0.3,1), box-shadow 0.4s ease;
}
.about-partner-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 20px 48px rgba(37,44,58,0.1);
}
.about-partner-number {
  font-family: 'Poppins', sans-serif;
  font-size: 48px;
  font-weight: 700;
  line-height: 1;
  margin-bottom: 24px;
  background: linear-gradient(135deg, var(--num-start, #8560A8), var(--num-end, #00BFF3));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  display: inline-block;
}
.about-partner-card h3 {
  font-family: 'Poppins', sans-serif;
  font-size: 20px;
  font-weight: 600;
  color: #252C3A;
  margin: 0 0 12px;
}
.about-partner-card p {
  font-family: 'Assistant', sans-serif;
  font-size: 16px;
  font-weight: 300;
  line-height: 1.7;
  color: #555;
  margin: 0;
}

/* ========================================
   3. VALUES GRID
   ======================================== */
.about-values {
  padding: 120px 0;
  background: #f9f9fb;
  position: relative;
}
.about-values-heading {
  text-align: center;
  margin-bottom: 64px;
}
.about-values-heading .v2-overline {
  font-family: 'Montserrat', sans-serif;
  font-size: 12px;
  letter-spacing: 3px;
  text-transform: uppercase;
  color: #00BFF3;
  display: block;
  margin-bottom: 16px;
}
.about-values-heading h2 {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(32px, 4vw, 44px);
  font-weight: 600;
  color: #252C3A;
  margin: 0;
}
.about-values-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 32px;
}
.about-value-card {
  background: #fff;
  border-radius: 12px;
  padding: 40px 32px;
  transition: transform 0.4s cubic-bezier(0.16,1,0.3,1), box-shadow 0.4s ease;
  border: 1px solid rgba(0,0,0,0.04);
  position: relative;
  overflow: hidden;
}
.about-value-card::before {
  content: '';
  position: absolute;
  top: 0; left: 0;
  width: 100%; height: 4px;
  background: linear-gradient(90deg, var(--accent, #8560A8), var(--accent-end, #5674B9));
  opacity: 0;
  transition: opacity 0.3s ease;
}
.about-value-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 20px 60px rgba(37,44,58,0.1);
}
.about-value-card:hover::before { opacity: 1; }
.about-value-icon {
  width: 56px; height: 56px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 24px;
  background: linear-gradient(135deg, var(--icon-bg, rgba(133,96,168,0.08)), var(--icon-bg-end, rgba(0,191,243,0.08)));
}
.about-value-icon svg { width: 28px; height: 28px; }
.about-value-card h3 {
  font-family: 'Poppins', sans-serif;
  font-size: 20px;
  font-weight: 600;
  color: #252C3A;
  margin: 0 0 12px;
}
.about-value-card p {
  font-family: 'Assistant', sans-serif;
  font-size: 16px;
  font-weight: 300;
  line-height: 1.7;
  color: #666;
  margin: 0;
}

/* ========================================
   4. PROCESS TIMELINE
   ======================================== */
.about-process {
  padding: 120px 0;
  background: #fff;
  overflow: hidden;
  position: relative;
}
.about-process-heading {
  text-align: center;
  margin-bottom: 80px;
}
.about-process-heading .v2-overline {
  font-family: 'Montserrat', sans-serif;
  font-size: 12px;
  letter-spacing: 3px;
  text-transform: uppercase;
  color: #00BFF3;
  display: block;
  margin-bottom: 16px;
}
.about-process-heading h2 {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(32px, 4vw, 44px);
  font-weight: 600;
  color: #252C3A;
  margin: 0;
}
.v2-timeline {
  position: relative;
  max-width: 1000px;
  margin: 0 auto;
}
.v2-timeline-line {
  position: absolute;
  top: 28px; left: 0; right: 0;
  height: 3px;
  background: #e0e0e8;
  z-index: 0;
}
.v2-timeline-progress {
  height: 100%;
  width: 0%;
  background: linear-gradient(90deg, #8560A8, #5674B9, #00BFF3);
  border-radius: 2px;
  transition: width 0.5s ease;
}
.v2-timeline-steps {
  display: grid;
  grid-template-columns: repeat(6, 1fr);
  position: relative;
  z-index: 1;
}
.v2-timeline-step {
  text-align: center;
  padding: 0 8px;
  cursor: pointer;
  user-select: none;
}
.v2-timeline-dot {
  width: 18px; height: 18px;
  border-radius: 50%;
  background: #e0e0e8;
  margin: 20px auto 20px;
  position: relative;
  transition: all 0.5s ease;
}
.v2-timeline-dot::after {
  content: '';
  position: absolute;
  inset: -6px;
  border-radius: 50%;
  border: 2px solid transparent;
  transition: border-color 0.5s ease;
}
.v2-timeline-step.active .v2-timeline-dot {
  background: #00BFF3;
  box-shadow: 0 0 20px rgba(0,191,243,0.4);
  transform: scale(1.3);
}
.v2-timeline-step:hover .v2-timeline-dot {
  background: #8560A8;
  box-shadow: 0 0 16px rgba(133,96,168,0.3);
  transform: scale(1.2);
}
.v2-timeline-step.active:hover .v2-timeline-dot {
  background: #00BFF3;
  box-shadow: 0 0 20px rgba(0,191,243,0.4);
  transform: scale(1.3);
}
.v2-timeline-step.active .v2-timeline-dot::after { border-color: rgba(0,191,243,0.2); }
.v2-timeline-step-number {
  font-family: 'Poppins', sans-serif;
  font-size: 12px;
  font-weight: 500;
  color: #bbb;
  margin-bottom: 4px;
  transition: color 0.5s ease;
}
.v2-timeline-step.active .v2-timeline-step-number { color: #00BFF3; }
.v2-timeline-step:hover .v2-timeline-step-number { color: #8560A8; }
.v2-timeline-step.active:hover .v2-timeline-step-number { color: #00BFF3; }
.v2-timeline-step-title {
  font-family: 'Poppins', sans-serif;
  font-size: 14px;
  font-weight: 500;
  color: #888;
  transition: color 0.5s ease;
}
.v2-timeline-step.active .v2-timeline-step-title { color: #252C3A; font-weight: 600; }
.v2-timeline-step:hover .v2-timeline-step-title { color: #252C3A; }

.v2-timeline-detail {
  margin-top: 48px;
  position: relative;
  min-height: 180px;
}
.v2-timeline-detail-card {
  position: absolute;
  top: 0; left: 0; right: 0;
  background: #fff;
  border-left: 4px solid;
  border-image: linear-gradient(180deg, #8560A8, #00BFF3) 1;
  padding: 40px 44px;
  box-shadow: 0 12px 48px rgba(37,44,58,0.08);
  opacity: 0;
  transform: translateY(16px);
  transition: opacity 0.4s ease, transform 0.4s ease;
  pointer-events: none;
  display: grid;
  grid-template-columns: 1fr auto;
  gap: 40px;
  align-items: center;
}
.v2-timeline-detail-card.active {
  opacity: 1;
  transform: translateY(0);
  pointer-events: auto;
}
.v2-timeline-detail-step {
  font-family: 'Poppins', sans-serif;
  font-size: 11px;
  font-weight: 600;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: #00BFF3;
  margin-bottom: 8px;
}
.v2-timeline-detail-title {
  font-family: 'Poppins', sans-serif;
  font-size: 24px;
  font-weight: 600;
  color: #252C3A;
  margin-bottom: 12px;
}
.v2-timeline-detail-desc {
  font-family: 'Assistant', sans-serif;
  font-size: 17px;
  font-weight: 300;
  color: #323A51;
  line-height: 1.65;
  max-width: 600px;
}
.v2-timeline-detail-icon {
  width: 80px; height: 80px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, rgba(133,96,168,0.08), rgba(0,191,243,0.08));
  border-radius: 50%;
}
.v2-timeline-detail-icon svg { width: 36px; height: 36px; }

/* ========================================
   5. CTA
   ======================================== */
.about-cta {
  padding: 100px 0;
  background: linear-gradient(135deg, #8560A8, #5674B9);
  text-align: center;
  position: relative;
  overflow: hidden;
}
.about-cta::before {
  content: '';
  position: absolute;
  top: 30%; left: 50%;
  transform: translate(-50%, -50%);
  width: 600px; height: 600px;
  background: radial-gradient(circle, rgba(0,191,243,0.12), transparent 70%);
  pointer-events: none;
}
.about-cta h2 {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(32px, 4vw, 48px);
  font-weight: 600;
  color: #fff;
  margin: 0 0 16px;
  position: relative;
}
.about-cta p {
  font-family: 'Assistant', sans-serif;
  font-size: 19px;
  font-weight: 300;
  color: rgba(255,255,255,0.7);
  margin-bottom: 36px;
  position: relative;
}
.about-cta .v2-btn-primary {
  display: inline-block;
  font-family: 'Poppins', sans-serif;
  font-size: 15px;
  font-weight: 500;
  color: #8560A8;
  background: #fff;
  padding: 16px 40px;
  border-radius: 6px;
  text-decoration: none;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  box-shadow: 0 4px 20px rgba(0,0,0,0.15);
  position: relative;
}
.about-cta .v2-btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 30px rgba(0,0,0,0.25);
}

/* ========================================
   RESPONSIVE
   ======================================== */
@media (max-width: 960px) {
  .about-story-inner {
    grid-template-columns: 1fr;
    gap: 50px;
  }
  .about-partner-grid {
    grid-template-columns: 1fr;
    gap: 24px;
  }
  .about-values-grid {
    grid-template-columns: repeat(2, 1fr);
  }
  .v2-timeline-steps {
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
  }
  .v2-timeline-line { display: none; }
}
@media (max-width: 768px) {
  .v2-container { padding: 0 24px; }
  .about-hero { padding: 100px 0 70px; }
  .about-hero-content h1 { font-size: 34px; }
  .about-story { padding: 80px 0; }
  .about-partner { padding: 80px 0; }
  .about-values { padding: 80px 0; }
  .about-process { padding: 80px 0; }
  .about-cta { padding: 70px 0; }
  .v2-timeline-detail-card {
    grid-template-columns: 1fr;
    padding: 28px 24px;
  }
  .v2-timeline-detail-icon { display: none; }
  .v2-timeline-detail-title { font-size: 20px; }
}
@media (max-width: 480px) {
  .v2-container { padding: 0 16px; }
  .about-values-grid { grid-template-columns: 1fr; }
  .v2-timeline-steps {
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
  }
}
</style>


<!-- ========================================
     1. HERO
     ======================================== -->
<section class="v2-section about-hero" aria-label="Hero">
  <div class="about-hero-shapes">
    <div class="about-shape about-shape-1"></div>
    <div class="about-shape about-shape-2"></div>
    <div class="about-shape about-shape-3"></div>
    <div class="about-shape about-shape-4"></div>
  </div>

  <div class="v2-container">
    <div class="about-hero-content">
      <span class="v2-overline v2-reveal v2-delay-1">Our Story</span>
      <h1 class="v2-reveal v2-delay-2">Because <span class="gradient-text">Stories Matter</span></h1>
      <p class="v2-subtitle v2-reveal v2-delay-3">From two creatives with a vision to a community of more than 200, we&rsquo;ve been on a mission to change the way content gets made.</p>
    </div>
  </div>

  <div class="v2-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none">
      <polygon points="0,60 1440,0 1440,60" fill="#ffffff"/>
    </svg>
  </div>
</section>


<!-- ========================================
     2. STORY CONTENT
     ======================================== -->
<section class="v2-section about-story" aria-label="Our Story">
  <div class="v2-container">
    <div class="about-story-inner">
      <div class="about-story-text v2-reveal-left">
        <h2>Founded on a Belief</h2>
        <p>Stretch Creative was built on a set of core beliefs: that creators deserve fair compensation, that content should be publishable from the start, that freelancers need genuine support, and that long-term partnerships always outperform one-off transactions.</p>
        <p>Chris Reid founded Stretch Creative at the dawn of the pandemic, seeing an opportunity to build something different &mdash; a creative agency that puts its people first while delivering exceptional content at scale.</p>
        <div class="about-story-quote">
          &ldquo;Our community of creatives has grown from two to more than 200.&rdquo;
        </div>
        <p>Today, we serve clients across industries &mdash; from ecommerce brands and publishers to agencies and enterprise marketing teams &mdash; with content that moves the needle.</p>
      </div>
      <div class="about-story-image v2-reveal-right">
        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&h=600&fit=crop" alt="Team collaboration at Stretch Creative" loading="lazy">
      </div>
    </div>
  </div>

  <div class="v2-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none">
      <polygon points="0,0 1440,60 1440,60 0,60" fill="#fafbfd"/>
    </svg>
  </div>
</section>


<!-- ========================================
     2.5 STRATEGIC PARTNER
     ======================================== -->
<section class="v2-section about-partner" aria-label="Why Partner With Us">
  <div class="v2-container">
    <div class="about-partner-heading">
      <h2 class="v2-reveal">We&rsquo;re less a vendor, more a <span class="gradient-text">strategic content partner</span></h2>
      <p class="about-partner-subtitle v2-reveal v2-delay-1">Our personalized approach and full menu of content services make us your one-stop partner for any or all of your SEO and content needs.</p>
    </div>

    <div class="about-partner-grid">
      <div class="about-partner-card v2-reveal v2-delay-1" style="--num-start:#8560A8;--num-end:#5674B9;">
        <div class="about-partner-number">01</div>
        <h3>Dedicated Creative Teams</h3>
        <p>We hand-pick a dedicated team of talented writers and editors for your content who are trained and supported by a Managing Editor.</p>
      </div>

      <div class="about-partner-card v2-reveal v2-delay-2" style="--num-start:#5674B9;--num-end:#448CCB;">
        <div class="about-partner-number">02</div>
        <h3>Flexible Engagements</h3>
        <p>We offer a few engagement options, from &hellip; to &hellip;. Our goal is to maximize your budget and keep you agile.</p>
      </div>

      <div class="about-partner-card v2-reveal v2-delay-3" style="--num-start:#448CCB;--num-end:#00BFF3;">
        <div class="about-partner-number">03</div>
        <h3>Integrated Services</h3>
        <p>Our content services include writing, graphic design, video production, photography, SEO, and paid &mdash; all working together to ensure consistency across all of your channels.</p>
      </div>
    </div>
  </div>

  <div class="v2-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none">
      <polygon points="0,0 1440,60 1440,60 0,60" fill="#f9f9fb"/>
    </svg>
  </div>
</section>


<!-- ========================================
     3. VALUES GRID
     ======================================== -->
<section class="v2-section about-values" aria-label="Our Values">
  <div class="v2-container">
    <div class="about-values-heading">
      <span class="v2-overline v2-reveal">What Drives Us</span>
      <h2 class="v2-reveal v2-delay-1">Our Values</h2>
    </div>

    <div class="about-values-grid">
      <div class="about-value-card v2-reveal v2-delay-1" style="--accent:#8560A8;--accent-end:#5674B9;--icon-bg:rgba(133,96,168,0.1);--icon-bg-end:rgba(86,116,185,0.1);">
        <div class="about-value-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="#8560A8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <h3>Collaboration</h3>
        <p>We believe great content is born from great partnerships. Every project is a shared journey between our team and our clients.</p>
      </div>

      <div class="about-value-card v2-reveal v2-delay-2" style="--accent:#5674B9;--accent-end:#448CCB;--icon-bg:rgba(86,116,185,0.1);--icon-bg-end:rgba(68,140,203,0.1);">
        <div class="about-value-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="#5674B9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
        </div>
        <h3>Flexibility</h3>
        <p>No two projects are the same. We adapt our approach, team composition, and processes to match exactly what each client needs.</p>
      </div>

      <div class="about-value-card v2-reveal v2-delay-3" style="--accent:#448CCB;--accent-end:#00BFF3;--icon-bg:rgba(68,140,203,0.1);--icon-bg-end:rgba(0,191,243,0.1);">
        <div class="about-value-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="#448CCB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
        </div>
        <h3>Truth &amp; Transparency</h3>
        <p>Honesty is at the heart of everything we do. We set clear expectations, communicate openly, and deliver on our promises.</p>
      </div>

      <div class="about-value-card v2-reveal v2-delay-4" style="--accent:#00BFF3;--accent-end:#448CCB;--icon-bg:rgba(0,191,243,0.1);--icon-bg-end:rgba(68,140,203,0.1);">
        <div class="about-value-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="#00BFF3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        </div>
        <h3>Accountability</h3>
        <p>We own our work from start to finish. Every piece of content is reviewed, refined, and delivered to the highest standard.</p>
      </div>

      <div class="about-value-card v2-reveal v2-delay-5" style="--accent:#8560A8;--accent-end:#00BFF3;--icon-bg:rgba(133,96,168,0.1);--icon-bg-end:rgba(0,191,243,0.1);">
        <div class="about-value-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="#8560A8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="M2 12h20"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
        </div>
        <h3>Social Responsibility</h3>
        <p>We care about the world beyond content. From fair wages to sustainable practices, we strive to make a positive impact.</p>
      </div>

      <div class="about-value-card v2-reveal v2-delay-6" style="--accent:#5674B9;--accent-end:#8560A8;--icon-bg:rgba(86,116,185,0.1);--icon-bg-end:rgba(133,96,168,0.1);">
        <div class="about-value-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="#5674B9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
        </div>
        <h3>Empathy</h3>
        <p>Understanding the human behind every brief. We listen deeply to tell stories that resonate with real audiences.</p>
      </div>
    </div>
  </div>

  <div class="v2-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none">
      <polygon points="0,60 1440,0 1440,60" fill="#ffffff"/>
    </svg>
  </div>
</section>


<!-- ========================================
     4. PROCESS TIMELINE
     ======================================== -->
<section class="v2-section about-process" id="processTimeline" aria-label="Our Process">
  <div class="v2-container">
    <div class="about-process-heading">
      <span class="v2-overline v2-reveal">How We Work</span>
      <h2 class="v2-reveal v2-delay-1">Our <span class="gradient-text">Process</span></h2>
    </div>

    <div class="v2-timeline v2-reveal v2-delay-2">
      <div class="v2-timeline-line">
        <div class="v2-timeline-progress" id="timelineProgress"></div>
      </div>

      <div class="v2-timeline-steps">
        <div class="v2-timeline-step active" data-step="1">
          <div class="v2-timeline-step-number">01</div>
          <div class="v2-timeline-dot"></div>
          <div class="v2-timeline-step-title">Consultation</div>
        </div>
        <div class="v2-timeline-step" data-step="2">
          <div class="v2-timeline-step-number">02</div>
          <div class="v2-timeline-dot"></div>
          <div class="v2-timeline-step-title">Brief &amp; Style Guide</div>
        </div>
        <div class="v2-timeline-step" data-step="3">
          <div class="v2-timeline-step-number">03</div>
          <div class="v2-timeline-dot"></div>
          <div class="v2-timeline-step-title">Curate Team</div>
        </div>
        <div class="v2-timeline-step" data-step="4">
          <div class="v2-timeline-step-number">04</div>
          <div class="v2-timeline-dot"></div>
          <div class="v2-timeline-step-title">Calibrate</div>
        </div>
        <div class="v2-timeline-step" data-step="5">
          <div class="v2-timeline-step-number">05</div>
          <div class="v2-timeline-dot"></div>
          <div class="v2-timeline-step-title">Create</div>
        </div>
        <div class="v2-timeline-step" data-step="6">
          <div class="v2-timeline-step-number">06</div>
          <div class="v2-timeline-dot"></div>
          <div class="v2-timeline-step-title">Deliver &amp; Report</div>
        </div>
      </div>

      <div class="v2-timeline-detail">
        <div class="v2-timeline-detail-card active" data-detail="1">
          <div>
            <div class="v2-timeline-detail-step">Step 01</div>
            <div class="v2-timeline-detail-title">Consultation</div>
            <div class="v2-timeline-detail-desc">We start by listening. Every engagement begins with a deep-dive conversation to understand your brand, audience, goals, and content challenges. No templates &mdash; just genuine curiosity.</div>
          </div>
          <div class="v2-timeline-detail-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="#8560A8" stroke-width="1.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
          </div>
        </div>
        <div class="v2-timeline-detail-card" data-detail="2">
          <div>
            <div class="v2-timeline-detail-step">Step 02</div>
            <div class="v2-timeline-detail-title">Brief &amp; Style Guide</div>
            <div class="v2-timeline-detail-desc">We distill everything into a clear creative brief and style guide that ensures every word written sounds like you. Voice, tone, formatting &mdash; all documented and shared.</div>
          </div>
          <div class="v2-timeline-detail-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="#5674B9" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
          </div>
        </div>
        <div class="v2-timeline-detail-card" data-detail="3">
          <div>
            <div class="v2-timeline-detail-step">Step 03</div>
            <div class="v2-timeline-detail-title">Curate Team</div>
            <div class="v2-timeline-detail-desc">We hand-pick writers, editors, and designers from our community of 200+ creatives, matching subject-matter expertise and writing style to your unique needs.</div>
          </div>
          <div class="v2-timeline-detail-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="#448CCB" stroke-width="1.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          </div>
        </div>
        <div class="v2-timeline-detail-card" data-detail="4">
          <div>
            <div class="v2-timeline-detail-step">Step 04</div>
            <div class="v2-timeline-detail-title">Calibrate</div>
            <div class="v2-timeline-detail-desc">A calibration round ensures quality from the start. We review early deliverables with you, fine-tune the approach, and lock in the standard before scaling up.</div>
          </div>
          <div class="v2-timeline-detail-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="#00BFF3" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><line x1="22" y1="12" x2="18" y2="12"/><line x1="6" y1="12" x2="2" y2="12"/><line x1="12" y1="6" x2="12" y2="2"/><line x1="12" y1="22" x2="12" y2="18"/></svg>
          </div>
        </div>
        <div class="v2-timeline-detail-card" data-detail="5">
          <div>
            <div class="v2-timeline-detail-step">Step 05</div>
            <div class="v2-timeline-detail-title">Create</div>
            <div class="v2-timeline-detail-desc">This is where the magic happens. Your curated team produces high-quality, publish-ready content at the volume and cadence you need &mdash; blogs, copy, ebooks, video, and more.</div>
          </div>
          <div class="v2-timeline-detail-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="#8560A8" stroke-width="1.5"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
          </div>
        </div>
        <div class="v2-timeline-detail-card" data-detail="6">
          <div>
            <div class="v2-timeline-detail-step">Step 06</div>
            <div class="v2-timeline-detail-title">Deliver &amp; Report</div>
            <div class="v2-timeline-detail-desc">Content is delivered on time, every time. We also provide performance reporting so you can see the impact of every piece and continuously optimize.</div>
          </div>
          <div class="v2-timeline-detail-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="#5674B9" stroke-width="1.5"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="v2-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none">
      <polygon points="0,0 1440,60 1440,60 0,60" fill="linear-gradient(135deg, #8560A8, #5674B9)"/>
      <polygon points="0,0 1440,60 1440,60 0,60" fill="#8560A8"/>
    </svg>
  </div>
</section>


<!-- ========================================
     5. CTA
     ======================================== -->
<section class="v2-section about-cta" aria-label="Call to Action">
  <div class="v2-container">
    <h2 class="v2-reveal">Join Our Team</h2>
    <p class="v2-reveal v2-delay-1">We&rsquo;re always looking for talented creatives who care about craft. If that sounds like you, we&rsquo;d love to hear from you.</p>
    <a href="/the-team/" class="v2-btn-primary v2-reveal v2-delay-2">Meet the Team &rarr;</a>
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

  document.querySelectorAll('.v2-reveal, .v2-reveal-left, .v2-reveal-right').forEach(function(el) {
    revealObserver.observe(el);
  });

  /* ---------- PROCESS TIMELINE ---------- */
  var timelineProgress = document.getElementById('timelineProgress');
  var timelineSteps = document.querySelectorAll('.v2-timeline-step');
  var timelineDetails = document.querySelectorAll('.v2-timeline-detail-card');

  function setActiveStep(index) {
    timelineSteps.forEach(function(step, i) {
      step.classList.toggle('active', i <= index);
    });
    if (timelineProgress) {
      var pct = ((index + 1) / timelineSteps.length) * 100;
      timelineProgress.style.width = pct + '%';
    }
    timelineDetails.forEach(function(card) { card.classList.remove('active'); });
    var targetCard = document.querySelector('.v2-timeline-detail-card[data-detail="' + (index + 1) + '"]');
    if (targetCard) targetCard.classList.add('active');
  }

  timelineSteps.forEach(function(step, i) {
    step.addEventListener('click', function() { setActiveStep(i); });
  });

  setActiveStep(0);
})();
</script>

<?php get_footer(); ?>
