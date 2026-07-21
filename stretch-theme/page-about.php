<?php
/**
 * Template Name: About Us
 */
get_header();

// AUD-014: local attachment IDs seeded by setup-page-images.php.
// Falls back to the original hotlink when the option/attachment is missing.
$stretch_page_images = (array) get_option('stretch_page_images', []);
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
  /* AUD-018: steps are real <button>s now — reset UA button styles so visuals are unchanged */
  appearance: none;
  -webkit-appearance: none;
  background: none;
  border: 0;
  margin: 0;
  font: inherit;
  color: inherit;
  display: block;
  width: 100%;
  text-align: center;
  padding: 0 8px;
  cursor: pointer;
  user-select: none;
}
.v2-timeline-step:focus-visible {
  outline: 2px solid #00BFF3;
  outline-offset: 4px;
  border-radius: 6px;
}
.v2-timeline-dot {
  display: block;
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
  display: block;
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
  display: block;
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

/* ========================================
   ANCHOR SCROLL OFFSET (fixed nav)
   ======================================== */
#our-story, #our-team, #our-work { scroll-margin-top: 90px; }

/* ========================================
   4.5 TEAM GRID  (merged from /the-team/)
   ======================================== */
.team-grid-section {
  padding: 120px 0;
  background: #fff;
  position: relative;
}
.team-grid-heading {
  text-align: center;
  margin-bottom: 64px;
}
.team-grid-heading .v2-overline {
  font-family: 'Montserrat', sans-serif;
  font-size: 12px; letter-spacing: 3px;
  text-transform: uppercase; color: #00BFF3;
  display: block; margin-bottom: 16px;
}
.team-grid-heading h2 {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(32px, 4vw, 44px);
  font-weight: 600; color: #252C3A; margin: 0;
}
.team-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 32px;
}
.team-card {
  position: relative;
  background: #f9f9fb;
  border-radius: 12px;
  padding: 40px 24px 32px;
  text-align: center;
  transition: transform 0.4s cubic-bezier(0.16,1,0.3,1), box-shadow 0.4s ease;
  overflow: hidden;
  transform-style: preserve-3d;
}
.team-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 20px 60px rgba(37,44,58,0.12);
}
.team-avatar {
  width: 140px; height: 140px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: 'Poppins', sans-serif;
  font-size: 28px; font-weight: 600;
  color: #fff;
  margin: 0 auto 20px;
  position: relative;
  z-index: 1;
  border: 4px solid #fff;
  box-shadow: 0 4px 20px rgba(133,96,168,0.15);
  transition: transform 0.4s ease, box-shadow 0.4s ease;
}
.team-card:hover .team-avatar {
  transform: scale(1.05);
  box-shadow: 0 8px 30px rgba(133,96,168,0.25);
}
.team-card h3 {
  font-family: 'Poppins', sans-serif;
  font-size: 16px; font-weight: 600;
  color: #252C3A; margin: 0 0 6px;
  position: relative; z-index: 1;
}
.team-card .team-role {
  font-family: 'Assistant', sans-serif;
  font-size: 14px; color: #888;
  position: relative; z-index: 1;
}

/* ========================================
   4.6 HIRING QUALITIES  (merged from /the-team/)
   ======================================== */
.team-qualities {
  padding: 120px 0;
  background: #f9f9fb;
  position: relative;
}
.team-qualities-heading {
  text-align: center;
  margin-bottom: 64px;
}
.team-qualities-heading .v2-overline {
  font-family: 'Montserrat', sans-serif;
  font-size: 12px; letter-spacing: 3px;
  text-transform: uppercase; color: #00BFF3;
  display: block; margin-bottom: 16px;
}
.team-qualities-heading h2 {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(32px, 4vw, 44px);
  font-weight: 600; color: #252C3A; margin: 0;
}
.team-qualities-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 32px;
  max-width: 900px;
  margin: 0 auto;
}
.team-quality-card {
  background: #fff;
  border-radius: 12px;
  padding: 40px 36px;
  display: flex;
  gap: 24px;
  align-items: flex-start;
  transition: transform 0.4s cubic-bezier(0.16,1,0.3,1), box-shadow 0.4s ease;
  border: 1px solid rgba(0,0,0,0.04);
}
.team-quality-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 16px 48px rgba(37,44,58,0.1);
}
.team-quality-icon {
  width: 56px; height: 56px; min-width: 56px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, rgba(133,96,168,0.08), rgba(0,191,243,0.08));
}
.team-quality-icon svg { width: 28px; height: 28px; }
.team-quality-card h3 {
  font-family: 'Poppins', sans-serif;
  font-size: 20px; font-weight: 600;
  color: #252C3A; margin: 0 0 8px;
}
.team-quality-card p {
  font-family: 'Assistant', sans-serif;
  font-size: 16px; font-weight: 300;
  line-height: 1.7; color: #666; margin: 0;
}

/* ========================================
   4.7 SELECTED WORK  (merged from /our-work/)
   ======================================== */
.pf-grid-section {
  padding: 120px 0;
  background: #fff;
  position: relative;
}
.pf-work-heading {
  text-align: center;
  margin-bottom: 40px;
}
.pf-work-heading .v2-overline {
  font-family: 'Montserrat', sans-serif;
  font-size: 12px; letter-spacing: 3px;
  text-transform: uppercase; color: #00BFF3;
  display: block; margin-bottom: 16px;
}
.pf-work-heading h2 {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(32px, 4vw, 44px);
  font-weight: 600; color: #252C3A; margin: 0 0 16px;
}
.pf-work-intro {
  font-family: 'Assistant', sans-serif;
  font-size: 18px; font-weight: 300; line-height: 1.7;
  color: #555; max-width: 620px; margin: 0 auto;
}
.pf-filters {
  display: flex;
  gap: 12px;
  justify-content: center;
  flex-wrap: wrap;
  margin-bottom: 48px;
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

/* Work lightbox */
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

/* ---------- MERGED-SECTION RESPONSIVE ---------- */
@media (max-width: 960px) {
  .team-grid { grid-template-columns: repeat(3, 1fr); }
  .team-qualities-grid { grid-template-columns: 1fr; }
  .pf-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
  .team-grid-section { padding: 80px 0; }
  .team-grid { grid-template-columns: repeat(2, 1fr); }
  .team-qualities { padding: 80px 0; }
  .pf-grid-section { padding: 80px 0; }
  .pf-grid { grid-template-columns: 1fr; gap: 16px; }
  .pf-card { aspect-ratio: 16 / 10; }
  .pf-card-overlay { opacity: 1; background: linear-gradient(0deg, rgba(37,44,58,0.85) 0%, rgba(37,44,58,0.2) 60%, transparent 100%); }
  .pf-card-content { opacity: 1; transform: translateY(0); padding: 18px; }
  .pf-lightbox { padding: 20px; }
}
@media (max-width: 480px) {
  .team-grid { grid-template-columns: 1fr; }
  .pf-filter-btn { font-size: 13px; padding: 9px 16px; }
}
@media (prefers-reduced-motion: reduce) {
  .pf-card, .pf-card img, .pf-card-content, .pf-card-overlay { transition: none !important; }
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
      <p class="v2-subtitle v2-reveal v2-delay-3">From two creatives with a vision to a community of more than 200, we’ve been on a mission to change the way content gets made.</p>
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
<section class="v2-section about-story" id="our-story" aria-label="Our Story">
  <div class="v2-container">
    <div class="about-story-inner">
      <div class="about-story-text v2-reveal-left">
        <h2>Founded on a Belief</h2>
        <p>Stretch Creative was built on a set of core beliefs: that creators deserve fair compensation, that content should be publishable from the start, that freelancers need genuine support, and that long-term partnerships always outperform one-off transactions.</p>
        <p>Chris Reid founded Stretch Creative at the dawn of the pandemic, seeing an opportunity to build something different — a creative agency that puts its people first while delivering exceptional content at scale.</p>
        <div class="about-story-quote">
          “Our community of creatives has grown from two to more than 200.”
        </div>
        <p>Today, we serve clients across industries — from ecommerce brands and publishers to agencies and enterprise marketing teams — with content that moves the needle.</p>
      </div>
      <div class="about-story-image v2-reveal-right">
        <?php
        // AUD-014: serve the local attachment (with srcset) when seeded.
        $about_img = wp_get_attachment_image((int) ($stretch_page_images['about_team'] ?? 0), 'large', false, ['loading' => 'lazy', 'alt' => 'Team collaboration at Stretch Creative']);
        if ($about_img) : echo $about_img; else : ?>
        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&h=600&fit=crop" alt="Team collaboration at Stretch Creative" loading="lazy">
        <?php endif; ?>
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
      <h2 class="v2-reveal">We’re less a vendor, more a <span class="gradient-text">strategic content partner</span></h2>
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
        <p>Our content services include writing, graphic design, video production, photography, SEO, and paid — all working together to ensure consistency across all of your channels.</p>
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

      <?php // AUD-018: keyboard-accessible tabs — real buttons, roving tabindex, arrow keys (JS below). ?>
      <div class="v2-timeline-steps" role="tablist" aria-label="Process steps">
        <button type="button" class="v2-timeline-step active" data-step="1" id="processTab1" role="tab" aria-selected="true" aria-controls="processPanel1" tabindex="0">
          <span class="v2-timeline-step-number">01</span>
          <span class="v2-timeline-dot"></span>
          <span class="v2-timeline-step-title">Consultation</span>
        </button>
        <button type="button" class="v2-timeline-step" data-step="2" id="processTab2" role="tab" aria-selected="false" aria-controls="processPanel2" tabindex="-1">
          <span class="v2-timeline-step-number">02</span>
          <span class="v2-timeline-dot"></span>
          <span class="v2-timeline-step-title">Brief &amp; Style Guide</span>
        </button>
        <button type="button" class="v2-timeline-step" data-step="3" id="processTab3" role="tab" aria-selected="false" aria-controls="processPanel3" tabindex="-1">
          <span class="v2-timeline-step-number">03</span>
          <span class="v2-timeline-dot"></span>
          <span class="v2-timeline-step-title">Curate Team</span>
        </button>
        <button type="button" class="v2-timeline-step" data-step="4" id="processTab4" role="tab" aria-selected="false" aria-controls="processPanel4" tabindex="-1">
          <span class="v2-timeline-step-number">04</span>
          <span class="v2-timeline-dot"></span>
          <span class="v2-timeline-step-title">Calibrate</span>
        </button>
        <button type="button" class="v2-timeline-step" data-step="5" id="processTab5" role="tab" aria-selected="false" aria-controls="processPanel5" tabindex="-1">
          <span class="v2-timeline-step-number">05</span>
          <span class="v2-timeline-dot"></span>
          <span class="v2-timeline-step-title">Create</span>
        </button>
        <button type="button" class="v2-timeline-step" data-step="6" id="processTab6" role="tab" aria-selected="false" aria-controls="processPanel6" tabindex="-1">
          <span class="v2-timeline-step-number">06</span>
          <span class="v2-timeline-dot"></span>
          <span class="v2-timeline-step-title">Deliver &amp; Report</span>
        </button>
      </div>

      <div class="v2-timeline-detail">
        <div class="v2-timeline-detail-card active" data-detail="1" id="processPanel1" role="tabpanel" aria-labelledby="processTab1" tabindex="0">
          <div>
            <div class="v2-timeline-detail-step">Step 01</div>
            <div class="v2-timeline-detail-title">Consultation</div>
            <div class="v2-timeline-detail-desc">We start by listening. Every engagement begins with a deep-dive conversation to understand your brand, audience, goals, and content challenges. No templates — just genuine curiosity.</div>
          </div>
          <div class="v2-timeline-detail-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="#8560A8" stroke-width="1.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
          </div>
        </div>
        <div class="v2-timeline-detail-card" data-detail="2" id="processPanel2" role="tabpanel" aria-labelledby="processTab2" tabindex="-1" aria-hidden="true">
          <div>
            <div class="v2-timeline-detail-step">Step 02</div>
            <div class="v2-timeline-detail-title">Brief &amp; Style Guide</div>
            <div class="v2-timeline-detail-desc">We distill everything into a clear creative brief and style guide that ensures every word written sounds like you. Voice, tone, formatting — all documented and shared.</div>
          </div>
          <div class="v2-timeline-detail-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="#5674B9" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
          </div>
        </div>
        <div class="v2-timeline-detail-card" data-detail="3" id="processPanel3" role="tabpanel" aria-labelledby="processTab3" tabindex="-1" aria-hidden="true">
          <div>
            <div class="v2-timeline-detail-step">Step 03</div>
            <div class="v2-timeline-detail-title">Curate Team</div>
            <div class="v2-timeline-detail-desc">We hand-pick writers, editors, and designers from our community of 200+ creatives, matching subject-matter expertise and writing style to your unique needs.</div>
          </div>
          <div class="v2-timeline-detail-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="#448CCB" stroke-width="1.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          </div>
        </div>
        <div class="v2-timeline-detail-card" data-detail="4" id="processPanel4" role="tabpanel" aria-labelledby="processTab4" tabindex="-1" aria-hidden="true">
          <div>
            <div class="v2-timeline-detail-step">Step 04</div>
            <div class="v2-timeline-detail-title">Calibrate</div>
            <div class="v2-timeline-detail-desc">A calibration round ensures quality from the start. We review early deliverables with you, fine-tune the approach, and lock in the standard before scaling up.</div>
          </div>
          <div class="v2-timeline-detail-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="#00BFF3" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><line x1="22" y1="12" x2="18" y2="12"/><line x1="6" y1="12" x2="2" y2="12"/><line x1="12" y1="6" x2="12" y2="2"/><line x1="12" y1="22" x2="12" y2="18"/></svg>
          </div>
        </div>
        <div class="v2-timeline-detail-card" data-detail="5" id="processPanel5" role="tabpanel" aria-labelledby="processTab5" tabindex="-1" aria-hidden="true">
          <div>
            <div class="v2-timeline-detail-step">Step 05</div>
            <div class="v2-timeline-detail-title">Create</div>
            <div class="v2-timeline-detail-desc">This is where the magic happens. Your curated team produces high-quality, publish-ready content at the volume and cadence you need — blogs, copy, ebooks, video, and more.</div>
          </div>
          <div class="v2-timeline-detail-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="#8560A8" stroke-width="1.5"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
          </div>
        </div>
        <div class="v2-timeline-detail-card" data-detail="6" id="processPanel6" role="tabpanel" aria-labelledby="processTab6" tabindex="-1" aria-hidden="true">
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
      <polygon points="0,0 1440,60 1440,60 0,60" fill="#ffffff"/>
    </svg>
  </div>
</section>


<!-- ========================================
     4.5 TEAM GRID  (merged from /the-team/)
     ======================================== -->
<section class="v2-section team-grid-section" id="our-team" aria-label="Team Members">
  <div class="v2-container">
    <div class="team-grid-heading">
      <span class="v2-overline v2-reveal">The People Behind the Work</span>
      <h2 class="v2-reveal v2-delay-1">Meet the <span class="gradient-text">Team</span></h2>
    </div>

    <div class="team-grid">
      <?php
      $team_members = get_option('stretch_team_members', []);
      if (empty($team_members)) {
          // Fallback if option not set
          $team_members = [
              ['name' => 'Chris Reid', 'title' => 'CEO', 'photo_id' => 0, 'url' => ''],
              ['name' => 'Kelsi Carrell', 'title' => 'Head of Operations', 'photo_id' => 0, 'url' => ''],
          ];
      }

      $colors = ['#8560A8', '#5674B9', '#448CCB', '#00BFF3'];
      $delay = 1;
      foreach ($team_members as $i => $member) :
        $d = ($delay % 6) + 1;
        $color = $colors[$i % count($colors)];
        $initials = implode('', array_map(function($w) { return strtoupper(substr($w, 0, 1)); }, explode(' ', $member['name'])));
        $has_photo = !empty($member['url']);
      ?>
      <div class="team-card v2-reveal v2-delay-<?php echo $d; ?>">
        <?php if ($has_photo) : ?>
          <div class="team-avatar" style="background: url('<?php echo esc_url($member['url']); ?>') center/cover; font-size: 0;"></div>
        <?php else : ?>
          <div class="team-avatar" style="background: <?php echo $color; ?>;">
            <?php echo $initials; ?>
          </div>
        <?php endif; ?>
        <h3><?php echo esc_html($member['name']); ?></h3>
        <span class="team-role"><?php echo esc_html($member['title']); ?></span>
      </div>
      <?php
        $delay++;
      endforeach;
      ?>
    </div>
  </div>

  <div class="v2-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none">
      <polygon points="0,0 1440,60 1440,60 0,60" fill="#f9f9fb"/>
    </svg>
  </div>
</section>


<!-- ========================================
     4.6 HIRING QUALITIES  (merged from /the-team/)
     ======================================== -->
<section class="v2-section team-qualities" aria-label="What We Look For">
  <div class="v2-container">
    <div class="team-qualities-heading">
      <span class="v2-overline v2-reveal">Join Us</span>
      <h2 class="v2-reveal v2-delay-1">What We <span class="gradient-text">Look For</span></h2>
    </div>

    <div class="team-qualities-grid">
      <div class="team-quality-card v2-reveal v2-delay-1">
        <div class="team-quality-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="#8560A8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
        </div>
        <div>
          <h3>Empathy</h3>
          <p>You love to tell a good story. You understand that behind every brief is a human audience that deserves authentic, meaningful content.</p>
        </div>
      </div>

      <div class="team-quality-card v2-reveal v2-delay-2">
        <div class="team-quality-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="#5674B9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
        </div>
        <div>
          <h3>Intuition</h3>
          <p>You really know how to read a room. You pick up on tone, context, and audience signals instinctively and adapt your voice accordingly.</p>
        </div>
      </div>

      <div class="team-quality-card v2-reveal v2-delay-3">
        <div class="team-quality-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="#448CCB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </div>
        <div>
          <h3>Curious</h3>
          <p>You go down the rabbit hole. You research thoroughly, ask great questions, and bring genuine interest to every topic you tackle.</p>
        </div>
      </div>

      <div class="team-quality-card v2-reveal v2-delay-4">
        <div class="team-quality-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="#00BFF3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
        </div>
        <div>
          <h3>Growth-Minded</h3>
          <p>You want to be a better writer. You welcome feedback, seek out learning opportunities, and constantly push to refine your craft.</p>
        </div>
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
     4.7 SELECTED WORK  (merged from /our-work/)
     ======================================== -->
<?php
$portfolio = stretch_get_portfolio();
$counts = [
    'all'     => count($portfolio),
    'writing' => count(array_filter($portfolio, fn($p) => $p['category'] === 'writing')),
    'design'  => count(array_filter($portfolio, fn($p) => $p['category'] === 'design')),
    'video'   => count(array_filter($portfolio, fn($p) => $p['category'] === 'video')),
];
?>
<section class="v2-section pf-grid-section" id="our-work" aria-label="Selected Work">
  <div class="v2-container">
    <div class="pf-work-heading">
      <span class="v2-overline v2-reveal">Selected Work</span>
      <h2 class="v2-reveal v2-delay-1">Our <span class="gradient-text">Work</span></h2>
      <p class="pf-work-intro v2-reveal v2-delay-2">A snapshot of recent projects across writing, design, photography, and video &mdash; for brands we&rsquo;re proud to work with.</p>
    </div>

    <?php // AUD-035: plain toggle buttons (aria-pressed) — not a tabs widget. ?>
    <div class="pf-filters v2-reveal v2-delay-2" role="group" aria-label="Portfolio filters">
      <button type="button" class="pf-filter-btn active" data-filter="all" aria-pressed="true">All <span class="pf-filter-count"><?php echo $counts['all']; ?></span></button>
      <button type="button" class="pf-filter-btn" data-filter="writing" aria-pressed="false">Writing <span class="pf-filter-count"><?php echo $counts['writing']; ?></span></button>
      <button type="button" class="pf-filter-btn" data-filter="design" aria-pressed="false">Graphic Design <span class="pf-filter-count"><?php echo $counts['design']; ?></span></button>
      <button type="button" class="pf-filter-btn" data-filter="video" aria-pressed="false">Video &amp; Photography <span class="pf-filter-count"><?php echo $counts['video']; ?></span></button>
    </div>

    <div class="pf-grid" id="pfGrid">
      <?php foreach ($portfolio as $i => $item) :
        $img_full = wp_get_attachment_image_url($item['id'], 'full');
        $alt      = get_post_meta($item['id'], '_wp_attachment_image_alt', true);
        // AUD-031: full <img> markup with srcset/sizes instead of a bare src.
        $img_html = wp_get_attachment_image($item['id'], 'large', false, [
            'loading' => 'lazy',
            'alt'     => $alt ?: $item['client'] . ' ' . $item['subcat'],
        ]);
        if (!$img_html) continue;
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
            <?php echo $img_html; ?>
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

  <div class="v2-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none">
      <polygon points="0,0 1440,60 1440,60 0,60" fill="#8560A8"/>
    </svg>
  </div>
</section>

<!-- Lightbox (for clicking work cards) -->
<div class="pf-lightbox" id="pfLightbox" role="dialog" aria-modal="true" aria-hidden="true">
  <button class="pf-lightbox-close" id="pfLightboxClose" aria-label="Close">&times;</button>
  <div class="pf-lightbox-inner" id="pfLightboxInner"></div>
</div>


<!-- ========================================
     5. CTA
     ======================================== -->
<section class="v2-section about-cta" aria-label="Call to Action">
  <div class="v2-container">
    <h2 class="v2-reveal">Join Our Team</h2>
    <p class="v2-reveal v2-delay-1">We’re always looking for talented creatives who care about craft. If that sounds like you, we’d love to hear from you.</p>
    <a href="#our-team" class="v2-btn-primary v2-reveal v2-delay-2">Meet the Team &rarr;</a>
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

  /* AUD-018: tablist pattern — roving tabindex, aria-selected, arrow-key navigation */
  function setActiveStep(index) {
    timelineSteps.forEach(function(step, i) {
      step.classList.toggle('active', i <= index);
      step.setAttribute('aria-selected', i === index ? 'true' : 'false');
      step.setAttribute('tabindex', i === index ? '0' : '-1');
    });
    if (timelineProgress) {
      var pct = ((index + 1) / timelineSteps.length) * 100;
      timelineProgress.style.width = pct + '%';
    }
    timelineDetails.forEach(function(card) {
      card.classList.remove('active');
      card.setAttribute('aria-hidden', 'true');
      card.setAttribute('tabindex', '-1');
    });
    var targetCard = document.querySelector('.v2-timeline-detail-card[data-detail="' + (index + 1) + '"]');
    if (targetCard) {
      targetCard.classList.add('active');
      targetCard.setAttribute('aria-hidden', 'false');
      targetCard.setAttribute('tabindex', '0');
    }
  }

  timelineSteps.forEach(function(step, i) {
    step.addEventListener('click', function() { setActiveStep(i); });
    step.addEventListener('keydown', function(e) {
      var total = timelineSteps.length;
      var next = null;
      if (e.key === 'ArrowRight') next = (i + 1) % total;
      else if (e.key === 'ArrowLeft') next = (i - 1 + total) % total;
      else if (e.key === 'Home') next = 0;
      else if (e.key === 'End') next = total - 1;
      if (next !== null) {
        e.preventDefault();
        setActiveStep(next);
        timelineSteps[next].focus();
      }
    });
  });

  setActiveStep(0);
})();
</script>

<script>
(function() {
  /* ---------- 3D TILT ON TEAM CARDS (merged from /the-team/) ---------- */
  var isTouchDevice = 'ontouchstart' in window || navigator.maxTouchPoints > 0;
  var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  if (!isTouchDevice && !reducedMotion) {
    var tiltCards = document.querySelectorAll('.team-card');
    tiltCards.forEach(function(card) {
      card.addEventListener('mousemove', function(e) {
        var rect = card.getBoundingClientRect();
        var cx = rect.left + rect.width / 2;
        var cy = rect.top + rect.height / 2;
        var dx = (e.clientX - cx) / (rect.width / 2);
        var dy = (e.clientY - cy) / (rect.height / 2);
        card.style.transform = 'perspective(800px) rotateY(' + (dx * 6) + 'deg) rotateX(' + (-dy * 6) + 'deg) translateY(-8px)';
        card.style.transition = 'box-shadow 0.4s ease';
      });
      card.addEventListener('mouseleave', function() {
        card.style.transform = '';
        card.style.transition = 'transform 0.5s cubic-bezier(0.16,1,0.3,1), box-shadow 0.4s ease';
      });
    });
  }

  /* ---------- WORK FILTERS (merged from /our-work/) ---------- */
  var filterBtns = document.querySelectorAll('.pf-filter-btn');
  var cards = document.querySelectorAll('.pf-card');

  filterBtns.forEach(function(btn) {
    btn.addEventListener('click', function() {
      var filter = btn.dataset.filter;

      filterBtns.forEach(function(b) {
        b.classList.remove('active');
        b.setAttribute('aria-pressed', 'false');
      });
      btn.classList.add('active');
      btn.setAttribute('aria-pressed', 'true');

      cards.forEach(function(card) {
        if (filter === 'all' || card.dataset.category === filter) {
          card.classList.remove('hidden');
          card.classList.add('visible');
        } else {
          card.classList.add('hidden');
        }
      });
    });
  });

  /* ---------- WORK LIGHTBOX (merged from /our-work/) ----------
     AUD-024: content built with createElement/textContent; vimeo id validated
     as digits-only. AUD-025: focus moves to close button, Tab trapped, focus
     returns to the invoking card on close. */
  var lightbox = document.getElementById('pfLightbox');
  var lightboxInner = document.getElementById('pfLightboxInner');
  var lightboxClose = document.getElementById('pfLightboxClose');
  if (lightbox && lightboxInner && lightboxClose) {
    var lightboxInvoker = null;

    var openLightbox = function(card) {
      var imgUrl = card.dataset.img || '';
      var client = card.dataset.client || '';
      var tag    = card.dataset.tag || '';
      var vimeo  = card.dataset.vimeo || '';

      var media;
      if (/^\d+$/.test(vimeo)) {
        media = document.createElement('iframe');
        media.src = 'https://player.vimeo.com/video/' + vimeo + '?h=0&title=0&byline=0&portrait=0';
        media.setAttribute('allow', 'autoplay; fullscreen; picture-in-picture');
        media.setAttribute('allowfullscreen', '');
      } else {
        media = document.createElement('img');
        media.src = imgUrl;
        media.alt = client;
      }

      var meta = document.createElement('div');
      meta.className = 'pf-lightbox-meta';
      var clientEl = document.createElement('p');
      clientEl.className = 'pf-lightbox-client';
      clientEl.textContent = client;
      var tagEl = document.createElement('span');
      tagEl.className = 'pf-lightbox-tag';
      tagEl.textContent = tag;
      meta.appendChild(clientEl);
      meta.appendChild(tagEl);

      lightboxInner.textContent = '';
      lightboxInner.appendChild(media);
      lightboxInner.appendChild(meta);

      lightboxInvoker = card;
      lightbox.classList.add('open');
      lightbox.setAttribute('aria-hidden', 'false');
      document.body.style.overflow = 'hidden';
      lightboxClose.focus();
    };

    var closeLightbox = function() {
      lightbox.classList.remove('open');
      lightbox.setAttribute('aria-hidden', 'true');
      lightboxInner.textContent = '';
      document.body.style.overflow = '';
      if (lightboxInvoker && typeof lightboxInvoker.focus === 'function') {
        lightboxInvoker.focus();
      }
      lightboxInvoker = null;
    };

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
      if (!lightbox.classList.contains('open')) return;
      if (e.key === 'Escape') {
        closeLightbox();
        return;
      }
      if (e.key !== 'Tab') return;
      var focusables = lightbox.querySelectorAll('button, a[href], iframe, [tabindex]:not([tabindex="-1"])');
      if (!focusables.length) return;
      var first = focusables[0];
      var last = focusables[focusables.length - 1];
      if (!lightbox.contains(document.activeElement)) {
        e.preventDefault();
        first.focus();
      } else if (e.shiftKey && document.activeElement === first) {
        e.preventDefault();
        last.focus();
      } else if (!e.shiftKey && document.activeElement === last) {
        e.preventDefault();
        first.focus();
      }
    });
  }
})();
</script>

<?php get_footer(); ?>
