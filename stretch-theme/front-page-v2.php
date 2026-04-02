<?php
/**
 * Template Name: Homepage 2.0
 */
get_header();
?>

<div class="v2-cursor" id="v2Cursor"></div><div class="v2-cursor-dot" id="v2CursorDot"></div>

<!-- Scroll Progress Bar -->
<div id="scrollProgress" style="position:fixed;top:0;left:0;width:0%;height:3px;background:linear-gradient(90deg,#8560A8,#5674B9,#448CCB,#00BFF3);z-index:99999;transition:width .1s linear;"></div>

<style>
/* ========================================
   HOMEPAGE 2.0 — PREMIUM TEMPLATE
   ======================================== */

/* ---------- OVERFLOW FIX ---------- */
html, body { overflow-x: hidden; }

/* ---------- ANGLED SECTION DIVIDERS ---------- */
.v2-angle-divider {
  position: absolute;
  bottom: -1px;
  left: 0;
  right: 0;
  z-index: 2;
  pointer-events: none;
  line-height: 0;
}
.v2-angle-divider svg {
  display: block;
  width: 100%;
  height: 60px;
}
.v2-angle-divider-top {
  position: absolute;
  top: -1px;
  left: 0;
  right: 0;
  z-index: 2;
  pointer-events: none;
  line-height: 0;
}
.v2-angle-divider-top svg {
  display: block;
  width: 100%;
  height: 60px;
}

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
.v2-reveal.visible {
  opacity: 1;
  transform: translateY(0);
}
.v2-reveal-left {
  opacity: 0;
  transform: translateX(-60px);
  transition: opacity 0.9s cubic-bezier(0.16, 1, 0.3, 1), transform 0.9s cubic-bezier(0.16, 1, 0.3, 1);
}
.v2-reveal-left.visible {
  opacity: 1;
  transform: translateX(0);
}
.v2-reveal-right {
  opacity: 0;
  transform: translateX(60px);
  transition: opacity 0.9s cubic-bezier(0.16, 1, 0.3, 1), transform 0.9s cubic-bezier(0.16, 1, 0.3, 1);
}
.v2-reveal-right.visible {
  opacity: 1;
  transform: translateX(0);
}
.v2-delay-1 { transition-delay: 0.1s; }
.v2-delay-2 { transition-delay: 0.2s; }
.v2-delay-3 { transition-delay: 0.3s; }
.v2-delay-4 { transition-delay: 0.4s; }
.v2-delay-5 { transition-delay: 0.5s; }
.v2-delay-6 { transition-delay: 0.6s; }

/* ========================================
   1. CINEMATIC HERO
   ======================================== */
.v2-hero {
  position: relative;
  min-height: 100vh;
  display: flex;
  align-items: center;
  background: linear-gradient(170deg, #1a1f2e 0%, #252C3A 40%, #1e2333 100%);
  overflow: hidden;
  padding: 120px 0 80px;
}
.v2-hero::before {
  content: '';
  position: absolute;
  top: -50%;
  right: -20%;
  width: 80%;
  height: 150%;
  background: radial-gradient(ellipse at center, rgba(86,116,185,0.08) 0%, transparent 70%);
  pointer-events: none;
}
.v2-hero::after {
  content: '';
  position: absolute;
  bottom: -30%;
  left: -10%;
  width: 60%;
  height: 80%;
  background: radial-gradient(ellipse at center, rgba(133,96,168,0.06) 0%, transparent 70%);
  pointer-events: none;
}

/* Floating shapes */
.v2-hero-shapes {
  position: absolute;
  inset: 0;
  pointer-events: none;
  z-index: 1;
}
.v2-shape {
  position: absolute;
  border-radius: 50%;
  opacity: 0.12;
  will-change: transform;
  transition: transform 0.3s ease-out;
}
.v2-shape-1 {
  width: 300px; height: 300px;
  top: 10%; left: 5%;
  background: radial-gradient(circle, #8560A8, transparent);
  transform: translate(calc(var(--mx, 0) * 20px), calc(var(--my, 0) * 20px));
}
.v2-shape-2 {
  width: 200px; height: 200px;
  top: 60%; left: 15%;
  background: radial-gradient(circle, #5674B9, transparent);
  transform: translate(calc(var(--mx, 0) * -15px), calc(var(--my, 0) * -15px));
}
.v2-shape-3 {
  width: 150px; height: 150px;
  top: 20%; right: 10%;
  background: radial-gradient(circle, #00BFF3, transparent);
  transform: translate(calc(var(--mx, 0) * 25px), calc(var(--my, 0) * 12px));
}
.v2-shape-4 {
  width: 100px; height: 100px;
  bottom: 20%; right: 25%;
  background: radial-gradient(circle, #448CCB, transparent);
  border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
  transform: translate(calc(var(--mx, 0) * -10px), calc(var(--my, 0) * 18px));
}
.v2-shape-5 {
  width: 80px; height: 80px;
  top: 40%; left: 45%;
  background: radial-gradient(circle, #8560A8, transparent);
  opacity: 0.08;
  transform: translate(calc(var(--mx, 0) * 30px), calc(var(--my, 0) * -20px));
}
.v2-shape-6 {
  width: 250px; height: 250px;
  bottom: 5%; right: 5%;
  background: radial-gradient(circle, #5674B9, transparent);
  opacity: 0.06;
  transform: translate(calc(var(--mx, 0) * -12px), calc(var(--my, 0) * 8px));
}

.v2-hero-inner {
  position: relative;
  z-index: 2;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 60px;
  align-items: center;
}

/* Hero text */
.v2-hero-text .v2-overline {
  font-family: 'Montserrat', sans-serif;
  font-size: 13px;
  font-weight: 400;
  letter-spacing: 3px;
  text-transform: uppercase;
  color: #00BFF3;
  margin-bottom: 20px;
  display: block;
}
.v2-hero-text h1 {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(36px, 4.5vw, 58px);
  font-weight: 600;
  line-height: 1.1;
  color: #fff;
  margin: 0 0 24px;
  letter-spacing: -1px;
}
.v2-hero-text .v2-subtitle {
  font-family: 'Assistant', sans-serif;
  font-size: 19px;
  font-weight: 300;
  line-height: 1.7;
  color: rgba(255,255,255,0.7);
  margin-bottom: 16px;
  max-width: 480px;
}
.v2-hero-text .v2-supporting {
  font-family: 'Assistant', sans-serif;
  font-size: 15px;
  color: rgba(255,255,255,0.45);
  margin-bottom: 36px;
}
.v2-hero-text .v2-btn-primary {
  display: inline-block;
  font-family: 'Poppins', sans-serif;
  font-size: 15px;
  font-weight: 500;
  color: #fff;
  background: linear-gradient(135deg, #8560A8, #5674B9);
  padding: 16px 40px;
  border-radius: 6px;
  text-decoration: none;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  box-shadow: 0 4px 20px rgba(133,96,168,0.3);
  position: relative;
  overflow: hidden;
}
.v2-hero-text .v2-btn-primary::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, #5674B9, #00BFF3);
  opacity: 0;
  transition: opacity 0.3s ease;
  border-radius: 6px;
}
.v2-hero-text .v2-btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 30px rgba(133,96,168,0.45);
}
.v2-hero-text .v2-btn-primary:hover::before { opacity: 1; }
.v2-hero-text .v2-btn-primary span { position: relative; z-index: 1; }

/* Hero visual — illustrated composition */
.v2-hero-visual {
  position: relative;
}
.v2-hero-visual svg {
  width: 100%;
  height: auto;
  display: block;
}

/* Hero illustration float animations */
@keyframes v2-illoFloat {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-10px); }
}
@keyframes v2-illoFloatAlt {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(8px); }
}
@keyframes v2-illoBlobDrift {
  0%, 100% { transform: translate(0, 0) scale(1); }
  33% { transform: translate(6px, -4px) scale(1.02); }
  66% { transform: translate(-4px, 5px) scale(0.98); }
}
.v2-illo-phone {
  animation: v2-illoFloat 3s ease-in-out infinite;
}
.v2-illo-browser {
  animation: v2-illoFloatAlt 4s ease-in-out infinite;
}
.v2-illo-blob {
  animation: v2-illoBlobDrift 8s ease-in-out infinite;
}
.v2-illo-blob:nth-of-type(2) { animation-delay: -2.5s; }
.v2-illo-blob:nth-of-type(3) { animation-delay: -5s; }

/* ========================================
   2. GRADIENT ACCENT BAR
   ======================================== */
.v2-accent-bar {
  height: 4px;
  background: linear-gradient(90deg, #8560A8, #5674B9, #448CCB, #00BFF3, #448CCB, #5674B9, #8560A8);
  background-size: 200% 100%;
  animation: v2-gradientSlide 4s ease infinite;
}
@keyframes v2-gradientSlide {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

/* ========================================
   3. ANIMATED STATS COUNTER BAR
   ======================================== */
.v2-stats-bar {
  background: #1a1f2e;
  padding: 60px 0;
  position: relative;
}
.v2-stats-bar::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, rgba(133,96,168,0.05), rgba(0,191,243,0.03));
  pointer-events: none;
}
.v2-stats-bar-inner {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 30px;
  text-align: center;
  position: relative;
}
.v2-stat-item {
  padding: 10px;
}
.v2-stat-number {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(36px, 5vw, 56px);
  font-weight: 600;
  color: #fff;
  line-height: 1;
  margin-bottom: 8px;
}
.v2-stat-number .v2-count { display: inline; }
.v2-stat-number .v2-suffix { color: #00BFF3; }
.v2-stat-label {
  font-family: 'Assistant', sans-serif;
  font-size: 14px;
  font-weight: 300;
  color: rgba(255,255,255,0.5);
  text-transform: uppercase;
  letter-spacing: 2px;
}

/* ========================================
   4. PULL QUOTE BANNER
   ======================================== */
.v2-pull-quote {
  padding: 100px 0;
  background: linear-gradient(135deg, #f9f9fb 0%, #f0f0f6 100%);
  position: relative;
  overflow: hidden;
}
.v2-pull-quote::before {
  content: '';
  position: absolute;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: linear-gradient(90deg, rgba(133,96,168,0.03), rgba(0,191,243,0.03), rgba(133,96,168,0.03));
  background-size: 200% 100%;
  animation: v2-gradientSlide 8s ease infinite;
}
.v2-pull-quote blockquote {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(22px, 3vw, 34px);
  font-weight: 400;
  color: #323A51;
  line-height: 1.5;
  text-align: center;
  max-width: 900px;
  margin: 0 auto;
  position: relative;
}
.v2-pull-quote .quote-accent {
  color: #00BFF3;
  font-weight: 500;
}
.v2-pull-quote blockquote::before,
.v2-pull-quote blockquote::after {
  font-family: Georgia, serif;
  font-size: 120px;
  line-height: 1;
  position: absolute;
  opacity: 0.07;
  color: #8560A8;
}
.v2-pull-quote blockquote::before {
  content: '\201C';
  top: -40px;
  left: -30px;
}
.v2-pull-quote blockquote::after {
  content: '\201D';
  bottom: -70px;
  right: -20px;
}

/* ========================================
   5. SERVICES SHOWCASE
   ======================================== */
.v2-services {
  padding: 0;
  padding-bottom: 40px;
  background: #fff;
  position: relative;
}
.v2-service-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  min-height: 500px;
}
.v2-service-row:nth-child(even) .v2-service-image { order: 2; }
.v2-service-row:nth-child(even) .v2-service-content { order: 1; }
.v2-service-image {
  position: relative;
  overflow: hidden;
}
.v2-service-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transform: scale(1.1);
  transition: transform 8s ease;
  will-change: transform;
}
.v2-service-image::after {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, rgba(133,96,168,0.15), rgba(0,191,243,0.1));
  mix-blend-mode: multiply;
}
.v2-service-content {
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding: 80px 70px;
}
.v2-service-content .v2-overline {
  font-family: 'Montserrat', sans-serif;
  font-size: 12px;
  letter-spacing: 3px;
  text-transform: uppercase;
  color: #00BFF3;
  margin-bottom: 16px;
}
.v2-service-content h3 {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(28px, 3vw, 38px);
  font-weight: 600;
  color: #252C3A;
  margin: 0 0 20px;
  line-height: 1.2;
}
.v2-service-content p {
  font-family: 'Assistant', sans-serif;
  font-size: 17px;
  font-weight: 300;
  line-height: 1.8;
  color: #555;
  margin-bottom: 30px;
  max-width: 440px;
}
.v2-service-cta {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-family: 'Poppins', sans-serif;
  font-size: 14px;
  font-weight: 500;
  color: #8560A8;
  text-decoration: none;
  transition: gap 0.3s ease, color 0.3s ease;
}
.v2-service-cta:hover {
  gap: 14px;
  color: #5674B9;
}
.v2-service-cta svg { transition: transform 0.3s ease; }
.v2-service-cta:hover svg { transform: translateX(4px); }

/* ========================================
   6. BESPOKE CONTENT EXPERIENCE
   ======================================== */
.v2-bespoke {
  background: #252C3A;
  padding: 120px 0;
  position: relative;
  overflow: hidden;
}
.v2-bespoke::before {
  content: '';
  position: absolute;
  top: -100px; right: -100px;
  width: 500px; height: 500px;
  background: radial-gradient(circle, rgba(0,191,243,0.06), transparent);
  pointer-events: none;
}
.v2-bespoke-inner {
  display: grid;
  grid-template-columns: 1fr 1.1fr;
  gap: 80px;
  align-items: center;
}
.v2-bespoke-text .v2-tag {
  display: inline-block;
  font-family: 'Montserrat', sans-serif;
  font-size: 11px;
  letter-spacing: 3px;
  text-transform: uppercase;
  color: #00BFF3;
  background: rgba(0,191,243,0.1);
  padding: 6px 16px;
  border-radius: 20px;
  margin-bottom: 24px;
}
.v2-bespoke-text h2 {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(32px, 4vw, 48px);
  font-weight: 600;
  color: #00BFF3;
  margin: 0 0 24px;
  line-height: 1.15;
}
.v2-bespoke-text p {
  font-family: 'Assistant', sans-serif;
  font-size: 17px;
  font-weight: 300;
  line-height: 1.8;
  color: rgba(255,255,255,0.6);
  margin-bottom: 16px;
  max-width: 460px;
}
.v2-bespoke-text .v2-btn-outline {
  display: inline-block;
  margin-top: 16px;
  font-family: 'Poppins', sans-serif;
  font-size: 14px;
  font-weight: 500;
  color: #00BFF3;
  border: 1px solid rgba(0,191,243,0.4);
  padding: 14px 32px;
  border-radius: 6px;
  text-decoration: none;
  transition: all 0.3s ease;
}
.v2-bespoke-text .v2-btn-outline:hover {
  background: rgba(0,191,243,0.1);
  border-color: #00BFF3;
}

/* Bespoke app mockup */
.v2-bespoke-app {
  background: #1a1f2e;
  border-radius: 12px;
  border: 1px solid rgba(255,255,255,0.08);
  overflow: hidden;
  box-shadow: 0 30px 80px rgba(0,0,0,0.5);
}
.v2-bespoke-app-bar {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 14px 18px;
  background: rgba(255,255,255,0.03);
  border-bottom: 1px solid rgba(255,255,255,0.06);
}
.v2-bespoke-app-bar .v2-browser-dot { width: 10px; height: 10px; border-radius: 50%; }
.v2-bespoke-app-title {
  font-family: 'Poppins', sans-serif;
  font-size: 12px;
  font-weight: 500;
  color: rgba(255,255,255,0.6);
  margin-left: 16px;
}
.v2-bespoke-tabs {
  display: flex;
  gap: 0;
  border-bottom: 1px solid rgba(255,255,255,0.06);
}
.v2-bespoke-tab {
  font-family: 'Assistant', sans-serif;
  font-size: 12px;
  color: rgba(255,255,255,0.35);
  padding: 12px 20px;
  border-bottom: 2px solid transparent;
  cursor: default;
}
.v2-bespoke-tab.active {
  color: #00BFF3;
  border-bottom-color: #00BFF3;
}
.v2-bespoke-body {
  padding: 24px;
}

/* Slider controls */
.v2-bespoke-sliders {
  display: flex;
  flex-direction: column;
  gap: 16px;
  margin-bottom: 24px;
}
.v2-bespoke-slider {
  display: flex;
  align-items: center;
  gap: 12px;
}
.v2-bespoke-slider-label {
  font-family: 'Assistant', sans-serif;
  font-size: 11px;
  color: rgba(255,255,255,0.4);
  width: 100px;
  flex-shrink: 0;
}
.v2-bespoke-slider-track {
  flex: 1;
  height: 4px;
  background: rgba(255,255,255,0.08);
  border-radius: 2px;
  position: relative;
}
.v2-bespoke-slider-fill {
  height: 100%;
  border-radius: 2px;
  background: linear-gradient(90deg, #5674B9, #00BFF3);
}
.v2-bespoke-slider-fill::after {
  content: '';
  position: absolute;
  right: -5px;
  top: 50%;
  transform: translateY(-50%);
  width: 12px;
  height: 12px;
  background: #00BFF3;
  border-radius: 50%;
  box-shadow: 0 0 8px rgba(0,191,243,0.5);
}

/* Metric readouts */
.v2-bespoke-metrics {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 16px;
  margin-bottom: 24px;
}
.v2-bespoke-metric {
  background: rgba(255,255,255,0.03);
  border: 1px solid rgba(255,255,255,0.06);
  border-radius: 8px;
  padding: 16px;
  text-align: center;
}
.v2-bespoke-metric-value {
  font-family: 'Poppins', sans-serif;
  font-size: 22px;
  font-weight: 600;
  color: #00BFF3;
  line-height: 1;
}
.v2-bespoke-metric-label {
  font-family: 'Assistant', sans-serif;
  font-size: 10px;
  color: rgba(255,255,255,0.35);
  margin-top: 6px;
  text-transform: uppercase;
  letter-spacing: 1px;
}

/* Bar chart */
.v2-bespoke-chart {
  display: flex;
  align-items: flex-end;
  gap: 8px;
  height: 80px;
  margin-bottom: 20px;
  padding: 0 10px;
}
.v2-bespoke-chart-bar {
  flex: 1;
  border-radius: 3px 3px 0 0;
  background: linear-gradient(180deg, #00BFF3, #5674B9);
  transition: height 1s ease;
}
.v2-bespoke-chart-bar:nth-child(1) { height: 35%; }
.v2-bespoke-chart-bar:nth-child(2) { height: 50%; }
.v2-bespoke-chart-bar:nth-child(3) { height: 42%; }
.v2-bespoke-chart-bar:nth-child(4) { height: 68%; }
.v2-bespoke-chart-bar:nth-child(5) { height: 55%; }
.v2-bespoke-chart-bar:nth-child(6) { height: 78%; }
.v2-bespoke-chart-bar:nth-child(7) { height: 65%; }
.v2-bespoke-chart-bar:nth-child(8) { height: 92%; }

.v2-bespoke-download {
  display: block;
  text-align: center;
  font-family: 'Poppins', sans-serif;
  font-size: 12px;
  font-weight: 500;
  color: #fff;
  background: linear-gradient(135deg, #5674B9, #00BFF3);
  padding: 12px;
  border-radius: 6px;
  text-decoration: none;
  transition: opacity 0.3s ease;
  cursor: default;
}
.v2-bespoke-download:hover { opacity: 0.9; }

/* ========================================
   7. CLIENT LOGO MARQUEE
   ======================================== */
.v2-logos {
  padding: 80px 0;
  background: #f9f9fb;
  overflow: hidden;
}
.v2-logos h2 {
  font-family: 'Poppins', sans-serif;
  font-size: 14px;
  font-weight: 400;
  letter-spacing: 3px;
  text-transform: uppercase;
  color: #999;
  text-align: center;
  margin-bottom: 50px;
}
.v2-marquee-track {
  display: flex;
  width: max-content;
  animation: v2-marqueeScroll 40s linear infinite;
}
.v2-marquee-track:hover {
  animation-play-state: paused;
}
@keyframes v2-marqueeScroll {
  0% { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}
.v2-logo-item {
  display: flex;
  align-items: center;
  justify-content: center;
  min-width: 160px;
  height: 60px;
  padding: 0 28px;
  filter: grayscale(100%);
  opacity: 0.45;
  transition: all 0.4s ease;
  white-space: nowrap;
  user-select: none;
}
.v2-logo-item img {
  max-height: 40px;
  max-width: 120px;
  width: auto;
  height: auto;
  object-fit: contain;
}
.v2-logo-item:hover {
  filter: grayscale(0%);
  opacity: 1;
}

/* ========================================
   7b. CASE STUDIES
   ======================================== */
.v2-case-studies {
  padding: 120px 0;
  background: #252C3A;
}
.v2-cs-header {
  text-align: center;
  margin-bottom: 64px;
}
.v2-cs-overline {
  font-family: 'Poppins', sans-serif;
  font-size: 13px;
  font-weight: 500;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: #8560A8;
  margin-bottom: 16px;
}
.v2-cs-heading {
  font-family: 'Poppins', sans-serif;
  font-size: 42px;
  font-weight: 500;
  color: #252C3A;
  line-height: 1.15;
}
.v2-cs-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 32px;
}
.v2-cs-card {
  position: relative;
  overflow: hidden;
  background: #252C3A;
  min-height: 420px;
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.5s ease;
}
.v2-cs-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 24px 64px rgba(37, 44, 58, 0.25);
}
.v2-cs-card-image {
  position: absolute;
  inset: 0;
  z-index: 0;
}
.v2-cs-card-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.6s ease;
}
.v2-cs-card:hover .v2-cs-card-image img {
  transform: scale(1.05);
}
.v2-cs-card::after {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(0deg, rgba(37,44,58,0.95) 0%, rgba(37,44,58,0.6) 40%, rgba(37,44,58,0.1) 100%);
  z-index: 1;
}
.v2-cs-card-content {
  position: relative;
  z-index: 2;
  padding: 40px;
}
.v2-cs-card-tag {
  display: inline-block;
  font-family: 'Poppins', sans-serif;
  font-size: 10px;
  font-weight: 600;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: #00BFF3;
  border: 1px solid rgba(0,191,243,0.3);
  padding: 4px 12px;
  margin-bottom: 16px;
}
.v2-cs-card-title {
  font-family: 'Poppins', sans-serif;
  font-size: 24px;
  font-weight: 500;
  color: #fff;
  line-height: 1.3;
  margin-bottom: 12px;
}
.v2-cs-card-desc {
  font-family: 'Assistant', sans-serif;
  font-size: 16px;
  color: rgba(255,255,255,0.7);
  line-height: 1.6;
  margin-bottom: 20px;
}
.v2-cs-card-stats {
  display: flex;
  gap: 24px;
}
.v2-cs-stat {
  text-align: left;
}
.v2-cs-stat-num {
  font-family: 'Poppins', sans-serif;
  font-size: 28px;
  font-weight: 600;
  color: #00BFF3;
  line-height: 1;
}
.v2-cs-stat-label {
  font-family: 'Poppins', sans-serif;
  font-size: 10px;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 1px;
  color: rgba(255,255,255,0.5);
  margin-top: 4px;
}
.v2-cs-card-large {
  grid-column: 1 / -1;
  min-height: 480px;
  display: grid;
  grid-template-columns: 1fr 1fr;
}
.v2-cs-card-large .v2-cs-card-image {
  position: relative;
}
.v2-cs-card-large::after {
  display: none;
}
.v2-cs-card-large .v2-cs-card-content {
  background: linear-gradient(160deg, #252C3A, #323A51);
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding: 56px 48px;
}
.v2-cs-card-link {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-family: 'Poppins', sans-serif;
  font-size: 14px;
  font-weight: 500;
  color: #00BFF3;
  text-decoration: none;
  transition: gap 0.3s ease;
}
.v2-cs-card-link:hover {
  gap: 14px;
}

@media (max-width: 768px) {
  .v2-cs-grid { grid-template-columns: 1fr; }
  .v2-cs-card-large { grid-template-columns: 1fr; }
  .v2-cs-card-large .v2-cs-card-image { min-height: 240px; }
  .v2-cs-heading { font-size: 30px; }
  .v2-cs-card { min-height: 340px; }
}

/* ========================================
   8. TESTIMONIALS 2.0
   ======================================== */
.v2-testimonials {
  padding: 120px 0;
  background: #fff;
  position: relative;
}
.v2-testimonials-inner {
  max-width: 800px;
  margin: 0 auto;
  text-align: center;
  position: relative;
  min-height: 320px;
}
.v2-testimonial-slide {
  position: absolute;
  top: 0; left: 0;
  width: 100%;
  opacity: 0;
  transform: translateY(10px);
  transition: opacity 0.6s ease, transform 0.6s ease;
  pointer-events: none;
}
.v2-testimonial-slide.active {
  opacity: 1;
  transform: translateY(0);
  pointer-events: auto;
  position: relative;
}
.v2-testimonial-quote-mark {
  display: block;
  margin: 0 auto 30px;
  opacity: 0.1;
}
.v2-testimonial-text {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(20px, 2.5vw, 26px);
  font-weight: 400;
  color: #323A51;
  line-height: 1.6;
  margin-bottom: 40px;
  font-style: italic;
}
.v2-testimonial-author {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 16px;
}
.v2-testimonial-avatar {
  width: 52px; height: 52px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: 'Poppins', sans-serif;
  font-size: 16px;
  font-weight: 600;
  color: #fff;
  flex-shrink: 0;
}
.v2-testimonial-info {
  text-align: left;
}
.v2-testimonial-name {
  font-family: 'Poppins', sans-serif;
  font-size: 15px;
  font-weight: 600;
  color: #252C3A;
}
.v2-testimonial-title {
  font-family: 'Assistant', sans-serif;
  font-size: 13px;
  color: #888;
}
.v2-testimonial-dots {
  display: flex;
  justify-content: center;
  gap: 10px;
  margin-top: 50px;
}
.v2-testimonial-dot {
  width: 10px; height: 10px;
  border-radius: 50%;
  background: #ddd;
  border: none;
  cursor: pointer;
  transition: all 0.3s ease;
  padding: 0;
}
.v2-testimonial-dot.active {
  background: #8560A8;
  transform: scale(1.3);
}

/* ========================================
   9. PROCESS TIMELINE
   ======================================== */
.v2-process {
  padding: 120px 0;
  background: #f9f9fb;
  overflow: hidden;
}
.v2-process-heading {
  text-align: center;
  margin-bottom: 80px;
}
.v2-process-heading .v2-overline {
  font-family: 'Montserrat', sans-serif;
  font-size: 12px;
  letter-spacing: 3px;
  text-transform: uppercase;
  color: #00BFF3;
  display: block;
  margin-bottom: 16px;
}
.v2-process-heading h2 {
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
  top: 28px;
  left: 0;
  right: 0;
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
.v2-timeline-step.active .v2-timeline-dot::after {
  border-color: rgba(0,191,243,0.2);
}
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

/* Detail panel */
.v2-timeline-detail {
  margin-top: 48px;
  position: relative;
  min-height: 180px;
}
.v2-timeline-detail-card {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  background: #fff;
  border-left: 4px solid;
  border-image: linear-gradient(180deg, #8560A8, #00BFF3) 1;
  padding: 40px 44px;
  box-shadow: 0 12px 48px rgba(37, 44, 58, 0.08);
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
  width: 80px;
  height: 80px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, rgba(133,96,168,0.08), rgba(0,191,243,0.08));
  border-radius: 50%;
}
.v2-timeline-detail-icon svg {
  width: 36px;
  height: 36px;
}

@media (max-width: 768px) {
  .v2-timeline-detail-card {
    grid-template-columns: 1fr;
    padding: 28px 24px;
  }
  .v2-timeline-detail-icon { display: none; }
  .v2-timeline-detail-title { font-size: 20px; }
}

/* ========================================
   10. IMPACT NUMBERS
   ======================================== */
.v2-impact {
  padding: 120px 0;
  background: linear-gradient(170deg, #1a1f2e, #252C3A);
  position: relative;
  overflow: hidden;
}
.v2-impact::before {
  content: '';
  position: absolute;
  top: 50%; left: 50%;
  transform: translate(-50%, -50%);
  width: 600px; height: 600px;
  background: radial-gradient(circle, rgba(0,191,243,0.04), transparent);
  pointer-events: none;
}
.v2-impact-heading {
  text-align: center;
  margin-bottom: 60px;
}
.v2-impact-heading .v2-overline {
  font-family: 'Montserrat', sans-serif;
  font-size: 12px;
  letter-spacing: 3px;
  text-transform: uppercase;
  color: #00BFF3;
  display: block;
  margin-bottom: 16px;
}
.v2-impact-heading h2 {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(32px, 4vw, 44px);
  font-weight: 600;
  color: #fff;
  margin: 0;
}
.v2-impact-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 40px;
  text-align: center;
}
.v2-impact-item {
  padding: 30px 20px;
  border-radius: 12px;
  background: rgba(255,255,255,0.02);
  border: 1px solid rgba(255,255,255,0.05);
  transition: all 0.4s ease;
}
.v2-impact-item:hover {
  background: rgba(255,255,255,0.04);
  border-color: rgba(0,191,243,0.2);
  transform: translateY(-4px);
}
.v2-impact-number {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(40px, 5vw, 64px);
  font-weight: 600;
  line-height: 1;
  margin-bottom: 12px;
}
.v2-impact-number .v2-count { color: #fff; }
.v2-impact-number .v2-suffix { color: #00BFF3; }
.v2-impact-desc {
  font-family: 'Assistant', sans-serif;
  font-size: 14px;
  font-weight: 300;
  color: rgba(255,255,255,0.5);
  line-height: 1.5;
}

/* ========================================
   11. MAGAZINE BLOG LAYOUT
   ======================================== */
.v2-blog {
  padding: 120px 0;
  background: #fff;
}
.v2-blog-heading {
  text-align: center;
  margin-bottom: 60px;
}
.v2-blog-heading .v2-overline {
  font-family: 'Montserrat', sans-serif;
  font-size: 12px;
  letter-spacing: 3px;
  text-transform: uppercase;
  color: #00BFF3;
  display: block;
  margin-bottom: 16px;
}
.v2-blog-heading h2 {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(32px, 4vw, 44px);
  font-weight: 600;
  color: #252C3A;
  margin: 0;
}
.v2-blog-grid {
  display: grid;
  grid-template-columns: 1.4fr 1fr;
  gap: 30px;
  max-width: 1100px;
  margin: 0 auto;
}
.v2-blog-featured {
  border-radius: 12px;
  overflow: hidden;
  position: relative;
  min-height: 500px;
  background: #252C3A;
  text-decoration: none;
  display: block;
  transition: transform 0.4s ease;
}
.v2-blog-featured:hover { transform: translateY(-4px); }
.v2-blog-featured img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  position: absolute;
  inset: 0;
  transition: transform 6s ease;
}
.v2-blog-featured:hover img { transform: scale(1.05); }
.v2-blog-featured-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(0deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.1) 50%);
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  padding: 40px;
}
.v2-blog-tag {
  display: inline-block;
  font-family: 'Montserrat', sans-serif;
  font-size: 10px;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: #00BFF3;
  background: rgba(0,191,243,0.15);
  padding: 4px 12px;
  border-radius: 20px;
  margin-bottom: 12px;
  width: fit-content;
}
.v2-blog-featured-overlay h3 {
  font-family: 'Poppins', sans-serif;
  font-size: 24px;
  font-weight: 600;
  color: #fff;
  margin: 0 0 8px;
  line-height: 1.3;
}
.v2-blog-featured-overlay p {
  font-family: 'Assistant', sans-serif;
  font-size: 15px;
  color: rgba(255,255,255,0.6);
  margin: 0;
}
.v2-blog-stack {
  display: flex;
  flex-direction: column;
  gap: 30px;
}
.v2-blog-small {
  flex: 1;
  border-radius: 12px;
  overflow: hidden;
  background: #f9f9fb;
  text-decoration: none;
  display: flex;
  flex-direction: column;
  transition: transform 0.4s ease, box-shadow 0.4s ease;
}
.v2-blog-small:hover {
  transform: translateY(-4px);
  box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}
.v2-blog-small-img {
  height: 160px;
  overflow: hidden;
}
.v2-blog-small-img img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 6s ease;
}
.v2-blog-small:hover .v2-blog-small-img img { transform: scale(1.05); }
.v2-blog-small-content {
  padding: 24px;
  flex: 1;
  display: flex;
  flex-direction: column;
}
.v2-blog-small-content h3 {
  font-family: 'Poppins', sans-serif;
  font-size: 16px;
  font-weight: 600;
  color: #252C3A;
  margin: 0 0 8px;
  line-height: 1.4;
}
.v2-blog-small-content p {
  font-family: 'Assistant', sans-serif;
  font-size: 14px;
  color: #777;
  margin: 0;
  line-height: 1.6;
}

/* ========================================
   12. FULL-VIEWPORT CTA
   ======================================== */
.v2-cta-full {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  position: relative;
  overflow: hidden;
  background: linear-gradient(170deg, #8560A8, #3d2d66 30%, #252C3A 70%, #1a1f2e);
}
.v2-cta-full::before {
  content: '';
  position: absolute;
  top: 30%; left: 50%;
  transform: translate(-50%, -50%);
  width: 800px; height: 800px;
  background: radial-gradient(circle, rgba(0,191,243,0.08), transparent 70%);
  pointer-events: none;
}
.v2-cta-shapes {
  position: absolute;
  inset: 0;
  pointer-events: none;
}
.v2-cta-shape {
  position: absolute;
  border-radius: 50%;
  opacity: 0.08;
  animation: v2-ctaFloat 12s ease-in-out infinite alternate;
}
.v2-cta-shape-1 {
  width: 200px; height: 200px;
  top: 15%; left: 10%;
  background: radial-gradient(circle, #00BFF3, transparent);
  animation-delay: 0s;
}
.v2-cta-shape-2 {
  width: 300px; height: 300px;
  bottom: 10%; right: 15%;
  background: radial-gradient(circle, #8560A8, transparent);
  animation-delay: -4s;
}
.v2-cta-shape-3 {
  width: 120px; height: 120px;
  top: 60%; left: 70%;
  background: radial-gradient(circle, #5674B9, transparent);
  animation-delay: -2s;
  border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
}
.v2-cta-shape-4 {
  width: 160px; height: 160px;
  top: 30%; right: 20%;
  background: radial-gradient(circle, #448CCB, transparent);
  animation-delay: -6s;
}
@keyframes v2-ctaFloat {
  0% { transform: translate(0, 0) rotate(0deg); }
  100% { transform: translate(30px, -30px) rotate(15deg); }
}
.v2-cta-content {
  position: relative;
  z-index: 1;
  max-width: 700px;
  padding: 0 40px;
}
.v2-cta-content h2 {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(36px, 5vw, 56px);
  font-weight: 600;
  color: #fff;
  margin: 0 0 24px;
  line-height: 1.15;
}
.v2-cta-content p {
  font-family: 'Assistant', sans-serif;
  font-size: 19px;
  font-weight: 300;
  color: rgba(255,255,255,0.6);
  margin-bottom: 44px;
  line-height: 1.7;
}
.v2-cta-buttons {
  display: flex;
  gap: 20px;
  justify-content: center;
  flex-wrap: wrap;
}
.v2-cta-btn-primary {
  display: inline-block;
  font-family: 'Poppins', sans-serif;
  font-size: 15px;
  font-weight: 500;
  color: #fff;
  background: linear-gradient(135deg, #00BFF3, #5674B9);
  padding: 18px 44px;
  border-radius: 6px;
  text-decoration: none;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  box-shadow: 0 4px 20px rgba(0,191,243,0.3);
}
.v2-cta-btn-primary:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 30px rgba(0,191,243,0.45);
}
.v2-cta-btn-outline {
  display: inline-block;
  font-family: 'Poppins', sans-serif;
  font-size: 15px;
  font-weight: 500;
  color: #fff;
  border: 1px solid rgba(255,255,255,0.3);
  padding: 18px 44px;
  border-radius: 6px;
  text-decoration: none;
  transition: all 0.3s ease;
}
.v2-cta-btn-outline:hover {
  background: rgba(255,255,255,0.08);
  border-color: rgba(255,255,255,0.6);
}

/* ========================================
   RESPONSIVE
   ======================================== */
@media (max-width: 960px) {
  .v2-hero-inner {
    grid-template-columns: 1fr;
    gap: 50px;
  }
  .v2-hero-visual {
    max-width: 500px;
    margin: 0 auto;
  }
  .v2-stats-bar-inner {
    grid-template-columns: repeat(2, 1fr);
    gap: 40px 20px;
  }
  .v2-service-row {
    grid-template-columns: 1fr;
    min-height: auto;
  }
  .v2-service-row:nth-child(even) .v2-service-image { order: 0; }
  .v2-service-row:nth-child(even) .v2-service-content { order: 0; }
  .v2-service-image { height: 350px; }
  .v2-service-content { padding: 50px 40px; }
  .v2-bespoke-inner {
    grid-template-columns: 1fr;
    gap: 50px;
  }
  .v2-impact-grid {
    grid-template-columns: repeat(2, 1fr);
  }
  .v2-blog-grid {
    grid-template-columns: 1fr;
  }
  .v2-blog-featured { min-height: 380px; }
  .v2-timeline-steps {
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
  }
  .v2-timeline-line { display: none; }
}

@media (max-width: 768px) {
  .v2-container { padding: 0 24px; }
  .v2-hero { padding: 100px 0 60px; }
  .v2-hero-text h1 { font-size: 34px; }
  .v2-pull-quote blockquote { font-size: 20px; }
  .v2-pull-quote { padding: 70px 0; }
  .v2-service-content { padding: 40px 24px; }
  .v2-bespoke { padding: 80px 0; }
  .v2-bespoke-metrics { grid-template-columns: repeat(3, 1fr); gap: 8px; }
  .v2-testimonial-text { font-size: 18px; }
  .v2-process { padding: 80px 0; }
  .v2-impact { padding: 80px 0; }
  .v2-blog { padding: 80px 0; }
  .v2-cta-content h2 { font-size: 32px; }
}

@media (max-width: 480px) {
  .v2-container { padding: 0 16px; }
  .v2-stats-bar-inner {
    grid-template-columns: 1fr 1fr;
    gap: 30px 10px;
  }
  .v2-impact-grid {
    grid-template-columns: 1fr;
    gap: 20px;
  }
  .v2-timeline-steps {
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
  }
  .v2-cta-buttons { flex-direction: column; align-items: center; }
  .v2-cta-btn-primary, .v2-cta-btn-outline { width: 100%; text-align: center; }
  .v2-bespoke-metrics { grid-template-columns: 1fr; }
  .v2-testimonial-author { flex-direction: column; gap: 10px; }
  .v2-testimonial-info { text-align: center; }
}

/* ========================================
   RESPONSIVE — ADDITIONAL FIXES
   ======================================== */

/* ---- 960px additions ---- */
@media (max-width: 960px) {
  /* Hero: reduce padding on tablets so content breathes */
  .v2-hero { padding: 100px 0 60px; }

  /* Case study heading on tablets */
  .v2-cs-heading { font-size: 34px; }

  /* Bespoke app: give it reasonable max-width when stacked */
  .v2-bespoke-app { max-width: 600px; margin: 0 auto; }

  /* Blog featured: reduce min-height to prevent excess whitespace */
  .v2-blog-featured { min-height: 320px; }

  /* Stats bar: reduce vertical padding */
  .v2-stats-bar { padding: 50px 0; }

  /* Process section: tighten heading margin */
  .v2-process-heading { margin-bottom: 60px; }

  /* CTA full: cap min-height so it doesn't force full-vh on tablets */
  .v2-cta-full { min-height: 80vh; }
}

/* ---- 768px additions ---- */
@media (max-width: 768px) {
  /* Hero subtitle legibility */
  .v2-hero-text .v2-subtitle { font-size: 17px; }
  .v2-hero-text .v2-supporting { font-size: 14px; }

  /* Tighten case study large card content padding */
  .v2-cs-card-large .v2-cs-card-content { padding: 36px 28px; }

  /* Case study regular card: less content padding */
  .v2-cs-card-content { padding: 28px 24px; }

  /* Stats bar: 1 col for very tight layouts near 768 */
  .v2-stats-bar { padding: 40px 0; }

  /* Impact section padding */
  .v2-impact-heading { margin-bottom: 40px; }

  /* Bespoke slider label: allow wrapping on narrow */
  .v2-bespoke-slider-label { font-size: 10px; width: 80px; }

  /* Blog featured overlay: less padding */
  .v2-blog-featured-overlay { padding: 28px 24px; }
  .v2-blog-featured-overlay h3 { font-size: 20px; }

  /* Testimonials: tighten vertical padding */
  .v2-testimonials { padding: 80px 0; }
  .v2-testimonials-inner { min-height: auto; }

  /* CTA full: reduce min-height */
  .v2-cta-full { min-height: 70vh; padding: 80px 0; }

  /* Pull quote: tighten decorative quotes so they don't overflow */
  .v2-pull-quote blockquote::before { font-size: 80px; top: -20px; left: -10px; }
  .v2-pull-quote blockquote::after  { font-size: 80px; bottom: -40px; right: -10px; }

  /* Process: tighten */
  .v2-process-heading { margin-bottom: 48px; }

  /* General section padding reduction */
  .v2-case-studies { padding: 80px 0; }
  .v2-bespoke { padding: 80px 0; }
  .v2-logos { padding: 60px 0; }
}

/* ---- 480px additions ---- */
@media (max-width: 480px) {
  /* --- Hero --- */
  .v2-hero { padding: 80px 0 48px; min-height: auto; }
  .v2-hero-text h1 { font-size: 28px; letter-spacing: -0.5px; }
  .v2-hero-text .v2-subtitle { font-size: 15px; }
  .v2-hero-text .v2-supporting { font-size: 13px; }
  .v2-hero-text .v2-btn-primary { padding: 14px 28px; font-size: 14px; width: 100%; text-align: center; box-sizing: border-box; }
  .v2-hero-inner { gap: 32px; }

  /* Hide browser mockup on small mobile — too complex to render well */
  .v2-hero-visual { display: none; }

  /* --- Pull quote --- */
  .v2-pull-quote { padding: 48px 0; }
  .v2-pull-quote blockquote { font-size: 17px; }
  .v2-pull-quote blockquote::before,
  .v2-pull-quote blockquote::after { display: none; }

  /* --- Stats bar --- */
  .v2-stats-bar { padding: 40px 0; }
  .v2-stat-number { font-size: 36px; }
  .v2-stat-label { font-size: 12px; letter-spacing: 1px; }

  /* --- Services --- */
  .v2-service-image { height: 240px; }
  .v2-service-content { padding: 32px 16px; }
  .v2-service-content h3 { font-size: 24px; }
  .v2-service-content p { font-size: 15px; }

  /* --- Bespoke --- */
  .v2-bespoke { padding: 56px 0; }
  .v2-bespoke-text h2 { font-size: 28px; }
  .v2-bespoke-text p { font-size: 15px; }
  .v2-bespoke-app { max-width: 100%; }
  .v2-bespoke-slider-label { width: 72px; font-size: 10px; }
  .v2-bespoke-metric-value { font-size: 18px; }
  .v2-bespoke-body { padding: 16px; }

  /* --- Logo marquee --- */
  .v2-logos { padding: 40px 0; }
  .v2-logos h2 { font-size: 12px; margin-bottom: 32px; }
  .v2-logo-item { min-width: 120px; padding: 0 16px; }
  .v2-logo-item img { max-height: 28px; max-width: 90px; }

  /* --- Case studies --- */
  .v2-case-studies { padding: 56px 0; }
  .v2-cs-header { margin-bottom: 40px; }
  .v2-cs-heading { font-size: 26px; }
  .v2-cs-card { min-height: 280px; }
  .v2-cs-card-content { padding: 20px 16px; }
  .v2-cs-card-title { font-size: 18px; }
  .v2-cs-card-desc { font-size: 14px; }
  .v2-cs-card-stats { gap: 16px; flex-wrap: wrap; }
  .v2-cs-stat-num { font-size: 22px; }

  /* Large card: force single-column image + content stack */
  .v2-cs-card-large { grid-template-columns: 1fr; min-height: auto; }
  .v2-cs-card-large .v2-cs-card-image { min-height: 200px; position: relative; }
  .v2-cs-card-large .v2-cs-card-content { padding: 24px 16px; }

  /* --- Impact numbers --- */
  .v2-impact { padding: 56px 0; }
  .v2-impact-heading h2 { font-size: 28px; }
  .v2-impact-number { font-size: 40px; }
  .v2-impact-desc { font-size: 13px; }
  .v2-impact-item { padding: 20px 16px; }

  /* --- Testimonials --- */
  .v2-testimonials { padding: 56px 0; }
  .v2-testimonial-text { font-size: 16px; }
  .v2-testimonials-inner { min-height: auto; }

  /* --- Process timeline --- */
  .v2-process { padding: 56px 0; }
  .v2-process-heading h2 { font-size: 26px; }
  .v2-process-heading { margin-bottom: 36px; }
  /* 2 columns already set above; collapse to 1 on very small screens */
  .v2-timeline-steps { grid-template-columns: 1fr; gap: 12px; }
  .v2-timeline-step { padding: 0 4px; }
  .v2-timeline-step-title { font-size: 13px; }
  .v2-timeline-detail-card { padding: 20px 16px; gap: 20px; }
  .v2-timeline-detail-title { font-size: 18px; }
  .v2-timeline-detail-desc { font-size: 15px; }
  .v2-timeline-detail { margin-top: 24px; }

  /* --- Blog --- */
  .v2-blog { padding: 56px 0; }
  .v2-blog-heading h2 { font-size: 26px; }
  .v2-blog-featured { min-height: 260px; }
  .v2-blog-featured-overlay { padding: 20px 16px; }
  .v2-blog-featured-overlay h3 { font-size: 17px; }
  .v2-blog-small-content h3 { font-size: 14px; }
  .v2-blog-stack { gap: 20px; }

  /* --- Full CTA --- */
  .v2-cta-full { min-height: 100svh; padding: 60px 0; }
  .v2-cta-content { padding: 0 20px; }
  .v2-cta-content h2 { font-size: 26px; margin-bottom: 16px; }
  .v2-cta-content p { font-size: 15px; margin-bottom: 32px; }
  .v2-cta-btn-primary,
  .v2-cta-btn-outline { padding: 15px 24px; font-size: 14px; }

  /* --- General section headings --- */
  .v2-impact-heading .v2-overline,
  .v2-process-heading .v2-overline,
  .v2-blog-heading .v2-overline { font-size: 11px; letter-spacing: 2px; }
}

/* ========================================
   PREMIUM MICRO-INTERACTIONS
   ======================================== */

/* ---------- 1. CUSTOM CURSOR ---------- */
.v2-cursor {
  position: fixed;
  top: 0;
  left: 0;
  width: 20px;
  height: 20px;
  border: 1.5px solid rgba(133,96,168,0.5);
  border-radius: 50%;
  pointer-events: none;
  z-index: 100000;
  transform: translate(-50%, -50%);
  transition: width 0.3s cubic-bezier(0.16,1,0.3,1), height 0.3s cubic-bezier(0.16,1,0.3,1), border-color 0.3s ease, background 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: 'Montserrat', sans-serif;
  font-size: 10px;
  font-weight: 600;
  letter-spacing: 1px;
  text-transform: uppercase;
  color: transparent;
  backdrop-filter: blur(2px);
  mix-blend-mode: difference;
}
.v2-cursor.active {
  width: 60px;
  height: 60px;
  border-color: rgba(133,96,168,0.3);
  background: rgba(133,96,168,0.08);
  color: rgba(255,255,255,0.9);
  mix-blend-mode: normal;
}
.v2-cursor-dot {
  position: fixed;
  top: 0;
  left: 0;
  width: 6px;
  height: 6px;
  background: #8560A8;
  border-radius: 50%;
  pointer-events: none;
  z-index: 100001;
  transform: translate(-50%, -50%);
}
@media (hover: none), (pointer: coarse) {
  .v2-cursor, .v2-cursor-dot { display: none !important; }
}
@media (max-width: 768px) {
  .v2-cursor, .v2-cursor-dot { display: none !important; }
}

/* ---------- 4. LETTER-BY-LETTER HERO REVEAL ---------- */
@keyframes v2-letterReveal {
  from {
    opacity: 0;
    transform: translateY(40px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
.v2-hero-title .v2-letter {
  display: inline-block;
  opacity: 0;
  animation: v2-letterReveal 0.5s cubic-bezier(0.16,1,0.3,1) forwards;
}
.v2-hero-title .v2-letter-space {
  display: inline-block;
  width: 0.3em;
}

/* ---------- 5. GRAIN TEXTURE OVERLAY ---------- */
@keyframes v2-grainShift {
  0% { transform: translate(0, 0); }
  25% { transform: translate(-2%, -3%); }
  50% { transform: translate(3%, 1%); }
  75% { transform: translate(-1%, 3%); }
  100% { transform: translate(0, 0); }
}

.v2-grain-overlay {
  position: absolute;
  inset: 0;
  overflow: hidden;
  pointer-events: none;
  z-index: 0;
}
.v2-grain-overlay::before {
  content: '';
  position: absolute;
  inset: -50%;
  width: 200%;
  height: 200%;
  opacity: 0.035;
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
  background-size: 128px 128px;
  animation: v2-grainShift 0.8s steps(4) infinite;
}

/* ---------- 6. SCROLL TEXT WIPE (disabled — kept visible) ---------- */
.v2-pull-quote .v2-wipe-word {
  display: inline;
  opacity: 1;
  color: #252C3A;
}
.v2-pull-quote .v2-wipe-word .quote-accent,
.v2-pull-quote .v2-wipe-word.revealed .quote-accent {
  color: #00BFF3;
}

/* ---------- 7. IMPACT NUMBER PULSE GLOW ---------- */
@keyframes v2-pulseGlow {
  0%, 100% {
    text-shadow: 0 0 0 transparent;
    filter: brightness(1);
  }
  50% {
    text-shadow: 0 0 20px rgba(0,191,243,0.25), 0 0 40px rgba(86,116,185,0.15);
    filter: brightness(1.08);
  }
}
.v2-impact-number.v2-pulse-active {
  animation: v2-pulseGlow 3s ease-in-out infinite;
  animation-delay: 2.5s;
}

/* ---------- REDUCED MOTION ---------- */
@media (prefers-reduced-motion: reduce) {
  .v2-cursor, .v2-cursor-dot { display: none !important; }
  .v2-hero-title .v2-letter { animation: none !important; opacity: 1; transform: none; }
  .v2-grain-overlay::before { animation: none !important; }
  .v2-impact-number.v2-pulse-active { animation: none !important; }
  .v2-pull-quote .v2-wipe-word { opacity: 1 !important; color: #252C3A !important; }
}
</style>


<!-- ========================================
     1. CINEMATIC HERO
     ======================================== -->
<section class="v2-section v2-hero" aria-label="Hero">
  <div class="v2-hero-shapes" id="heroShapes">
    <div class="v2-shape v2-shape-1"></div>
    <div class="v2-shape v2-shape-2"></div>
    <div class="v2-shape v2-shape-3"></div>
    <div class="v2-shape v2-shape-4"></div>
    <div class="v2-shape v2-shape-5"></div>
    <div class="v2-shape v2-shape-6"></div>
  </div>

  <div class="v2-container">
    <div class="v2-hero-inner">
      <div class="v2-hero-text">
        <span class="v2-overline v2-reveal v2-delay-1">Stretch Creative</span>
        <h1 class="v2-hero-title v2-reveal v2-delay-2">Creative Solutions<br><span class="gradient-text">Fit For You</span></h1>
        <p class="v2-subtitle v2-reveal v2-delay-3">The trusted partner for producing publish-ready content at scale&nbsp;&mdash; your story, your voice, on time.</p>
        <p class="v2-supporting v2-reveal v2-delay-4">Content writing &middot; SEO strategy &middot; Design &middot; Videography</p>
        <a href="/contact-stretch-creative/" class="v2-btn-primary v2-reveal v2-delay-5"><span>Let&rsquo;s Chat &rarr;</span></a>
      </div>

      <div class="v2-hero-visual v2-reveal v2-delay-3">
        <svg viewBox="0 0 600 500" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Illustration of creative digital services including mobile, web, video, and design">
          <defs>
            <linearGradient id="illoPhoneScreen" x1="0" y1="0" x2="0" y2="1">
              <stop offset="0%" stop-color="#1a1a2e"/>
              <stop offset="100%" stop-color="#12121f"/>
            </linearGradient>
            <linearGradient id="illoBarGrad1" x1="0" y1="1" x2="0" y2="0">
              <stop offset="0%" stop-color="#5674B9"/>
              <stop offset="100%" stop-color="#8560A8"/>
            </linearGradient>
            <linearGradient id="illoBarGrad2" x1="0" y1="1" x2="0" y2="0">
              <stop offset="0%" stop-color="#448CCB"/>
              <stop offset="100%" stop-color="#5674B9"/>
            </linearGradient>
            <linearGradient id="illoBarGrad3" x1="0" y1="1" x2="0" y2="0">
              <stop offset="0%" stop-color="#00BFF3"/>
              <stop offset="100%" stop-color="#448CCB"/>
            </linearGradient>
            <filter id="illoShadow" x="-10%" y="-10%" width="130%" height="140%">
              <feDropShadow dx="0" dy="6" stdDeviation="12" flood-color="#000" flood-opacity="0.25"/>
            </filter>
            <filter id="illoShadowSm" x="-10%" y="-10%" width="130%" height="140%">
              <feDropShadow dx="0" dy="3" stdDeviation="6" flood-color="#000" flood-opacity="0.2"/>
            </filter>
          </defs>

          <!-- === Background Blobs === -->
          <g class="v2-illo-blob">
            <path d="M80 180 C40 120, 130 60, 200 90 C270 120, 250 200, 190 240 C130 280, 120 240, 80 180Z" fill="#8560A8" opacity="0.18"/>
          </g>
          <g class="v2-illo-blob">
            <path d="M400 60 C450 20, 540 50, 530 120 C520 190, 460 200, 420 170 C380 140, 350 100, 400 60Z" fill="#F5A623" opacity="0.2"/>
          </g>
          <g class="v2-illo-blob">
            <path d="M350 340 C400 300, 520 310, 540 370 C560 430, 500 480, 430 470 C360 460, 300 380, 350 340Z" fill="#00BFF3" opacity="0.13"/>
          </g>

          <!-- === Decorative Floating Elements === -->
          <!-- Small dots -->
          <circle cx="95" cy="90" r="3" fill="#fff" opacity="0.18"/>
          <circle cx="520" cy="100" r="4" fill="#00BFF3" opacity="0.25"/>
          <circle cx="560" cy="260" r="3" fill="#8560A8" opacity="0.3"/>
          <circle cx="50" cy="320" r="5" fill="#fff" opacity="0.1"/>
          <circle cx="140" cy="60" r="3.5" fill="#00BFF3" opacity="0.2"/>
          <circle cx="480" cy="440" r="4" fill="#fff" opacity="0.15"/>
          <circle cx="30" cy="230" r="2.5" fill="#5674B9" opacity="0.25"/>

          <!-- Sparkle / 4-pointed stars -->
          <g opacity="0.2" fill="#fff">
            <path d="M540 180 L543 186 L540 192 L537 186Z"/>
            <path d="M540 180 L546 186 L540 192 L534 186Z"/>
          </g>
          <g opacity="0.15" fill="#00BFF3">
            <path d="M70 400 L72.5 405 L70 410 L67.5 405Z"/>
            <path d="M70 400 L75 405 L70 410 L65 405Z"/>
          </g>
          <g opacity="0.18" fill="#8560A8">
            <path d="M460 50 L462 54 L460 58 L458 54Z"/>
            <path d="M460 50 L464 54 L460 58 L456 54Z"/>
          </g>

          <!-- Mini network graph -->
          <g opacity="0.15" stroke="#fff" stroke-width="1">
            <circle cx="555" cy="340" r="3" fill="#5674B9" stroke="none" opacity="0.4"/>
            <circle cx="580" cy="360" r="2.5" fill="#8560A8" stroke="none" opacity="0.4"/>
            <circle cx="565" cy="380" r="2" fill="#00BFF3" stroke="none" opacity="0.4"/>
            <line x1="555" y1="340" x2="580" y2="360"/>
            <line x1="580" y1="360" x2="565" y2="380"/>
            <line x1="555" y1="340" x2="565" y2="380"/>
          </g>

          <!-- Small geometric shapes -->
          <rect x="42" cy="140" y="140" width="8" height="8" rx="1.5" stroke="#fff" stroke-width="1" fill="none" opacity="0.12" transform="rotate(15 46 144)"/>
          <circle cx="510" cy="460" r="5" stroke="#5674B9" stroke-width="1" fill="none" opacity="0.15"/>

          <!-- === Browser Window (center-right, behind phone) === -->
          <g class="v2-illo-browser" filter="url(#illoShadow)" transform="rotate(2.5 420 230)">
            <!-- Window frame -->
            <rect x="280" y="80" width="260" height="320" rx="10" fill="#fff"/>
            <!-- Browser chrome -->
            <rect x="280" y="80" width="260" height="32" rx="10" fill="#f0f0f4"/>
            <!-- Bottom corners of chrome are square -->
            <rect x="280" y="102" width="260" height="10" fill="#f0f0f4"/>
            <!-- Three dots -->
            <circle cx="298" cy="96" r="4" fill="#ff5f57"/>
            <circle cx="312" cy="96" r="4" fill="#febc2e"/>
            <circle cx="326" cy="96" r="4" fill="#28c840"/>
            <!-- URL bar -->
            <rect x="344" y="89" width="180" height="14" rx="4" fill="#e4e4ea"/>
            <!-- Content area -->
            <!-- Heading lines -->
            <rect x="300" y="128" width="140" height="8" rx="3" fill="#252C3A" opacity="0.7"/>
            <rect x="300" y="144" width="100" height="8" rx="3" fill="#252C3A" opacity="0.4"/>
            <!-- Paragraph text lines -->
            <rect x="300" y="168" width="220" height="5" rx="2" fill="#c0c0c8"/>
            <rect x="300" y="180" width="200" height="5" rx="2" fill="#c0c0c8"/>
            <rect x="300" y="192" width="210" height="5" rx="2" fill="#c0c0c8"/>
            <rect x="300" y="204" width="150" height="5" rx="2" fill="#c0c0c8"/>
            <!-- Image placeholder -->
            <rect x="300" y="224" width="220" height="90" rx="6" fill="#e8e8f0"/>
            <g opacity="0.3">
              <circle cx="410" cy="258" r="12" stroke="#aaa" stroke-width="1.5" fill="none"/>
              <path d="M385 298 L400 278 L415 290 L430 270 L445 298Z" fill="#ccc" opacity="0.5"/>
            </g>
            <!-- CTA button -->
            <rect x="300" y="330" width="100" height="28" rx="6" fill="#8560A8"/>
            <rect x="316" y="340" width="68" height="8" rx="3" fill="#fff" opacity="0.9"/>
            <!-- Small text after button -->
            <rect x="300" y="372" width="180" height="5" rx="2" fill="#c0c0c8" opacity="0.6"/>
            <rect x="300" y="384" width="140" height="5" rx="2" fill="#c0c0c8" opacity="0.6"/>
          </g>

          <!-- === Smartphone / Mobile Device (center-left, prominent) === -->
          <g class="v2-illo-phone" filter="url(#illoShadow)">
            <!-- Phone frame -->
            <rect x="100" y="100" width="170" height="310" rx="18" fill="#1a1a2e"/>
            <!-- Screen bezel inset -->
            <rect x="110" y="115" width="150" height="280" rx="8" fill="url(#illoPhoneScreen)"/>
            <!-- Notch -->
            <rect x="155" y="100" width="60" height="12" rx="6" fill="#1a1a2e"/>
            <!-- Search bar -->
            <rect x="120" y="130" width="130" height="22" rx="6" fill="rgba(255,255,255,0.07)"/>
            <circle cx="133" cy="141" r="5" stroke="rgba(255,255,255,0.3)" stroke-width="1" fill="none"/>
            <rect x="144" y="138" width="60" height="5" rx="2" fill="rgba(255,255,255,0.15)"/>
            <!-- Content text lines -->
            <rect x="120" y="165" width="130" height="5" rx="2" fill="rgba(255,255,255,0.12)"/>
            <rect x="120" y="176" width="110" height="5" rx="2" fill="rgba(255,255,255,0.08)"/>
            <rect x="120" y="187" width="120" height="5" rx="2" fill="rgba(255,255,255,0.08)"/>
            <!-- Bar chart -->
            <g transform="translate(120, 280)">
              <!-- Chart baseline -->
              <line x1="0" y1="90" x2="130" y2="90" stroke="rgba(255,255,255,0.08)" stroke-width="1"/>
              <!-- Grid lines -->
              <line x1="0" y1="30" x2="130" y2="30" stroke="rgba(255,255,255,0.04)" stroke-width="0.5"/>
              <line x1="0" y1="60" x2="130" y2="60" stroke="rgba(255,255,255,0.04)" stroke-width="0.5"/>
              <!-- Bars -->
              <rect x="8" y="55" width="16" height="35" rx="3" fill="url(#illoBarGrad1)"/>
              <rect x="32" y="30" width="16" height="60" rx="3" fill="url(#illoBarGrad2)"/>
              <rect x="56" y="42" width="16" height="48" rx="3" fill="url(#illoBarGrad1)"/>
              <rect x="80" y="15" width="16" height="75" rx="3" fill="url(#illoBarGrad3)"/>
              <rect x="104" y="5" width="16" height="85" rx="3" fill="url(#illoBarGrad3)"/>
              <!-- Chart labels -->
              <text x="16" y="102" fill="rgba(255,255,255,0.3)" font-size="6" text-anchor="middle" font-family="sans-serif">Q1</text>
              <text x="40" y="102" fill="rgba(255,255,255,0.3)" font-size="6" text-anchor="middle" font-family="sans-serif">Q2</text>
              <text x="64" y="102" fill="rgba(255,255,255,0.3)" font-size="6" text-anchor="middle" font-family="sans-serif">Q3</text>
              <text x="88" y="102" fill="rgba(255,255,255,0.3)" font-size="6" text-anchor="middle" font-family="sans-serif">Q4</text>
              <text x="112" y="102" fill="rgba(255,255,255,0.3)" font-size="6" text-anchor="middle" font-family="sans-serif">Q5</text>
            </g>
            <!-- Small heading above chart -->
            <rect x="120" y="210" width="90" height="6" rx="2" fill="rgba(255,255,255,0.18)"/>
            <rect x="120" y="222" width="70" height="4" rx="2" fill="rgba(255,255,255,0.08)"/>
            <!-- Growth arrow -->
            <g transform="translate(215, 215)">
              <path d="M0 18 L15 0" stroke="#00BFF3" stroke-width="1.5" stroke-linecap="round"/>
              <path d="M10 0 L15 0 L15 5" stroke="#00BFF3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </g>
          </g>

          <!-- === Video Player (bottom-right, overlapping) === -->
          <g filter="url(#illoShadowSm)">
            <rect x="370" y="360" width="180" height="110" rx="10" fill="#252C3A"/>
            <!-- Play button -->
            <circle cx="460" cy="400" r="20" stroke="#fff" stroke-width="2" fill="none" opacity="0.8"/>
            <path d="M453 390 L453 410 L470 400Z" fill="#fff" opacity="0.8"/>
            <!-- Progress bar background -->
            <rect x="385" y="448" width="150" height="4" rx="2" fill="rgba(255,255,255,0.1)"/>
            <!-- Progress bar fill -->
            <rect x="385" y="448" width="55" height="4" rx="2" fill="#00BFF3"/>
            <!-- Progress dot -->
            <circle cx="440" cy="450" r="5" fill="#00BFF3"/>
            <!-- HD badge -->
            <rect x="520" y="366" width="22" height="12" rx="3" fill="rgba(255,255,255,0.12)"/>
            <text x="531" y="375" fill="rgba(255,255,255,0.6)" font-size="7" text-anchor="middle" font-family="sans-serif" font-weight="600">HD</text>
            <!-- Timestamp -->
            <text x="395" y="442" fill="rgba(255,255,255,0.4)" font-size="7" font-family="sans-serif">1:24 / 3:05</text>
          </g>

          <!-- === Pencil + Color Palette (bottom-left area) === -->
          <g transform="translate(80, 420) rotate(-30)">
            <!-- Pencil body -->
            <rect x="0" y="0" width="100" height="14" rx="2" fill="#F5A623"/>
            <rect x="0" y="0" width="100" height="7" rx="2" fill="#F7BC5E"/>
            <!-- Pencil tip -->
            <polygon points="100,0 100,14 118,7" fill="#252C3A"/>
            <polygon points="112,4 112,10 118,7" fill="#e8c9a0"/>
            <!-- Eraser end -->
            <rect x="-12" y="1" width="14" height="12" rx="3" fill="#E88B9C"/>
            <rect x="-2" y="0" width="4" height="14" rx="0" fill="#c0c0c0"/>
          </g>
          <!-- Color swatches -->
          <circle cx="100" cy="468" r="9" fill="#8560A8"/>
          <circle cx="123" cy="468" r="9" fill="#5674B9"/>
          <circle cx="146" cy="468" r="9" fill="#00BFF3"/>
          <circle cx="100" cy="468" r="9" stroke="#fff" stroke-width="1.5" fill="none" opacity="0.3"/>
          <circle cx="123" cy="468" r="9" stroke="#fff" stroke-width="1.5" fill="none" opacity="0.3"/>
          <circle cx="146" cy="468" r="9" stroke="#fff" stroke-width="1.5" fill="none" opacity="0.3"/>

          <!-- === More scattered decorative elements === -->
          <circle cx="310" cy="50" r="2" fill="#fff" opacity="0.12"/>
          <circle cx="240" cy="470" r="3" fill="#5674B9" opacity="0.2"/>
          <rect x="570" cy="430" y="430" width="6" height="6" rx="1" stroke="#00BFF3" stroke-width="0.8" fill="none" opacity="0.2" transform="rotate(20 573 433)"/>
        </svg>
      </div>
    </div>
  </div>
</section>


<!-- ========================================
     2. GRADIENT ACCENT BAR
     ======================================== -->
<div class="v2-section v2-accent-bar"></div>


<!-- ========================================
     CLIENT LOGO MARQUEE
     ======================================== -->
<section class="v2-section v2-logos" aria-label="Trusted Brands">
  <h2>Trusted by Leading Brands</h2>
  <div class="v2-marquee-track">
    <?php
    $logo_ids = get_option('stretch_client_logos', []);
    if ($logo_ids) {
        foreach ($logo_ids as $name => $id) {
            $url = wp_get_attachment_url($id);
            if ($url) echo '<div class="v2-logo-item"><img src="' . esc_url($url) . '" alt="' . esc_attr($name) . '" loading="lazy"></div>' . "\n    ";
        }
        foreach ($logo_ids as $name => $id) {
            $url = wp_get_attachment_url($id);
            if ($url) echo '<div class="v2-logo-item"><img src="' . esc_url($url) . '" alt="' . esc_attr($name) . '" loading="lazy"></div>' . "\n    ";
        }
    }
    ?>
  </div>
</section>


<!-- ========================================
     3. ANIMATED STATS COUNTER BAR
     ======================================== -->
<section class="v2-section v2-stats-bar" style="position:relative;" aria-label="Statistics">
  <div class="v2-container">
    <div class="v2-stats-bar-inner">
      <div class="v2-stat-item v2-reveal">
        <div class="v2-stat-number"><span class="v2-count" data-target="200">0</span><span class="v2-suffix">+</span></div>
        <div class="v2-stat-label">Creatives</div>
      </div>
      <div class="v2-stat-item v2-reveal v2-delay-1">
        <div class="v2-stat-number"><span class="v2-count" data-target="27">0</span><span class="v2-suffix">+</span></div>
        <div class="v2-stat-label">Enterprise Brands</div>
      </div>
      <div class="v2-stat-item v2-reveal v2-delay-2">
        <div class="v2-stat-number"><span class="v2-count" data-target="500" data-suffix="K">0</span><span class="v2-suffix">K+</span></div>
        <div class="v2-stat-label">Content Pieces Delivered</div>
      </div>
      <div class="v2-stat-item v2-reveal v2-delay-3">
        <div class="v2-stat-number"><span class="v2-count" data-target="98">0</span><span class="v2-suffix">%</span></div>
        <div class="v2-stat-label">Client Retention</div>
      </div>
    </div>
  </div>
  <div class="v2-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none"><polygon points="0,60 1440,0 1440,60" fill="#f9f9fb"/></svg>
  </div>
</section>


<!-- ========================================
     4. PULL QUOTE BANNER
     ======================================== -->
<section class="v2-section v2-pull-quote" aria-label="Quote">
  <div class="v2-container">
    <blockquote class="v2-reveal">
      More than a vendor &mdash; a creative partner that produces <span class="quote-accent">publish-ready content at scale</span>, on brand and on time.
    </blockquote>
  </div>
  <div class="v2-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none"><polygon points="0,0 1440,60 1440,60 0,60" fill="#fff"/></svg>
  </div>
</section>


<!-- ========================================
     5. SERVICES SHOWCASE
     ======================================== -->
<section class="v2-section v2-services" aria-label="Services">
  <div class="v2-service-row">
    <div class="v2-service-image v2-reveal-left">
      <img src="https://images.unsplash.com/photo-1455390582262-044cdead277a?w=800&h=600&fit=crop" alt="Content writing" loading="lazy">
    </div>
    <div class="v2-service-content v2-reveal-right">
      <span class="v2-overline">01</span>
      <h3>Content Writing</h3>
      <p>From long-form editorial to product descriptions, our subject-matter experts craft compelling copy that sounds like your brand and ranks where it matters.</p>
      <a href="/services/" class="v2-service-cta">Explore Content <svg width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M4 9h10M10 5l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
    </div>
  </div>

  <div class="v2-service-row">
    <div class="v2-service-image v2-reveal-right">
      <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&h=600&fit=crop" alt="SEO strategy" loading="lazy">
    </div>
    <div class="v2-service-content v2-reveal-left">
      <span class="v2-overline">02</span>
      <h3>SEO &amp; Content Strategy</h3>
      <p>Data-driven content strategies that identify high-intent topics, capture organic share, and turn search visibility into measurable business outcomes.</p>
      <a href="/services/" class="v2-service-cta">Explore Strategy <svg width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M4 9h10M10 5l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
    </div>
  </div>

  <div class="v2-service-row">
    <div class="v2-service-image v2-reveal-left">
      <img src="https://images.unsplash.com/photo-1561070791-2526d30994b5?w=800&h=600&fit=crop" alt="Graphic design" loading="lazy">
    </div>
    <div class="v2-service-content v2-reveal-right">
      <span class="v2-overline">03</span>
      <h3>Graphic Design</h3>
      <p>Visual storytelling that elevates every touchpoint &mdash; from infographics and social assets to full brand systems that make an impression.</p>
      <a href="/services/" class="v2-service-cta">Explore Design <svg width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M4 9h10M10 5l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
    </div>
  </div>

  <div class="v2-service-row">
    <div class="v2-service-image v2-reveal-right">
      <img src="https://images.unsplash.com/photo-1574717024653-61fd2cf4d44d?w=800&h=600&fit=crop" alt="Videography" loading="lazy">
    </div>
    <div class="v2-service-content v2-reveal-left">
      <span class="v2-overline">04</span>
      <h3>Videography</h3>
      <p>End-to-end video production &mdash; concept through post. Brand films, product videos, and social-first content that stops the scroll.</p>
      <a href="/services/" class="v2-service-cta">Explore Video <svg width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M4 9h10M10 5l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
    </div>
  </div>
  <div class="v2-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none"><polygon points="0,0 0,60 1440,60" fill="#252C3A"/></svg>
  </div>
</section>


<!-- ========================================
     6. BESPOKE CONTENT EXPERIENCE
     ======================================== -->
<section class="v2-section v2-bespoke" aria-label="Bespoke Content Experience">
  <div class="v2-container">
    <div class="v2-bespoke-inner">
      <div class="v2-bespoke-text v2-reveal-left">
        <span class="v2-tag">The Centerpiece</span>
        <h2>Bespoke Content<br>Experience</h2>
        <p>Custom-built interactive content experiences that transform passive readers into engaged participants. Think calculators, assessments, and data-driven tools &mdash; all wrapped in your brand and designed to generate qualified leads.</p>
        <p>Each experience is hand-coded, fully responsive, and engineered for performance. No templates. No iframes. Pure, on-brand engagement.</p>
        <a href="/bespoke-content-experience/" class="v2-btn-outline">See It In Action &rarr;</a>
      </div>

      <div class="v2-bespoke-app v2-reveal-right">
        <div class="v2-bespoke-app-bar">
          <div class="v2-browser-dot" style="background:#ff5f57;"></div>
          <div class="v2-browser-dot" style="background:#febc2e;"></div>
          <div class="v2-browser-dot" style="background:#28c840;"></div>
          <span class="v2-bespoke-app-title">Migration Readiness Assessment</span>
        </div>
        <div class="v2-bespoke-tabs">
          <span class="v2-bespoke-tab active">Assessment</span>
          <span class="v2-bespoke-tab">Results</span>
          <span class="v2-bespoke-tab">Benchmarks</span>
        </div>
        <div class="v2-bespoke-body">
          <div class="v2-bespoke-sliders">
            <div class="v2-bespoke-slider">
              <span class="v2-bespoke-slider-label">Data Volume</span>
              <div class="v2-bespoke-slider-track"><div class="v2-bespoke-slider-fill" style="width:72%;"></div></div>
            </div>
            <div class="v2-bespoke-slider">
              <span class="v2-bespoke-slider-label">Complexity</span>
              <div class="v2-bespoke-slider-track"><div class="v2-bespoke-slider-fill" style="width:58%;"></div></div>
            </div>
            <div class="v2-bespoke-slider">
              <span class="v2-bespoke-slider-label">Team Size</span>
              <div class="v2-bespoke-slider-track"><div class="v2-bespoke-slider-fill" style="width:85%;"></div></div>
            </div>
          </div>

          <div class="v2-bespoke-metrics">
            <div class="v2-bespoke-metric">
              <div class="v2-bespoke-metric-value">7.2</div>
              <div class="v2-bespoke-metric-label">Readiness</div>
            </div>
            <div class="v2-bespoke-metric">
              <div class="v2-bespoke-metric-value">4.8mo</div>
              <div class="v2-bespoke-metric-label">Timeline</div>
            </div>
            <div class="v2-bespoke-metric">
              <div class="v2-bespoke-metric-value">Med</div>
              <div class="v2-bespoke-metric-label">Risk</div>
            </div>
          </div>

          <div class="v2-bespoke-chart">
            <div class="v2-bespoke-chart-bar"></div>
            <div class="v2-bespoke-chart-bar"></div>
            <div class="v2-bespoke-chart-bar"></div>
            <div class="v2-bespoke-chart-bar"></div>
            <div class="v2-bespoke-chart-bar"></div>
            <div class="v2-bespoke-chart-bar"></div>
            <div class="v2-bespoke-chart-bar"></div>
            <div class="v2-bespoke-chart-bar"></div>
          </div>

          <div class="v2-bespoke-download">Download Full Report</div>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- ========================================
     8. TESTIMONIALS 2.0
     ======================================== -->
<section class="v2-section v2-testimonials" aria-label="Testimonials">
  <div class="v2-container">
    <div class="v2-testimonials-inner" id="testimonialCarousel">
      <!-- Slide 1 -->
      <div class="v2-testimonial-slide active">
        <svg class="v2-testimonial-quote-mark" width="60" height="48" viewBox="0 0 60 48" fill="#8560A8"><path d="M0 48V28.8C0 12.48 9.36 3.36 28.08 0l2.16 5.76C19.44 8.64 13.68 15.84 13.2 24H24v24H0zm33.84 0V28.8c0-16.32 9.36-25.44 28.08-28.8L64.08 5.76C53.28 8.64 47.52 15.84 47.04 24H57.84v24H33.84z"/></svg>
        <p class="v2-testimonial-text">&ldquo;Working with Stretch Creative has been the biggest difference-maker in scaling our SEO content operations.&rdquo;</p>
        <div class="v2-testimonial-author">
          <div class="v2-testimonial-avatar" style="background:linear-gradient(135deg,#8560A8,#5674B9);">KH</div>
          <div class="v2-testimonial-info">
            <div class="v2-testimonial-name">Kristen Haney</div>
            <div class="v2-testimonial-title">Sr. Growth Manager SEO, Grove Collaborative</div>
          </div>
        </div>
      </div>

      <!-- Slide 2 -->
      <div class="v2-testimonial-slide">
        <svg class="v2-testimonial-quote-mark" width="60" height="48" viewBox="0 0 60 48" fill="#8560A8"><path d="M0 48V28.8C0 12.48 9.36 3.36 28.08 0l2.16 5.76C19.44 8.64 13.68 15.84 13.2 24H24v24H0zm33.84 0V28.8c0-16.32 9.36-25.44 28.08-28.8L64.08 5.76C53.28 8.64 47.52 15.84 47.04 24H57.84v24H33.84z"/></svg>
        <p class="v2-testimonial-text">&ldquo;Stretch feels like an extension of our own marketing department. Responsive, reliable, and genuinely great writers.&rdquo;</p>
        <div class="v2-testimonial-author">
          <div class="v2-testimonial-avatar" style="background:linear-gradient(135deg,#5674B9,#448CCB);">KH</div>
          <div class="v2-testimonial-info">
            <div class="v2-testimonial-name">Karen Hewitt</div>
            <div class="v2-testimonial-title">Sr. Marketing Manager, WeWork</div>
          </div>
        </div>
      </div>

      <!-- Slide 3 -->
      <div class="v2-testimonial-slide">
        <svg class="v2-testimonial-quote-mark" width="60" height="48" viewBox="0 0 60 48" fill="#8560A8"><path d="M0 48V28.8C0 12.48 9.36 3.36 28.08 0l2.16 5.76C19.44 8.64 13.68 15.84 13.2 24H24v24H0zm33.84 0V28.8c0-16.32 9.36-25.44 28.08-28.8L64.08 5.76C53.28 8.64 47.52 15.84 47.04 24H57.84v24H33.84z"/></svg>
        <p class="v2-testimonial-text">&ldquo;No matter the task or turnaround time, they do a great job of bringing our brand identity to life.&rdquo;</p>
        <div class="v2-testimonial-author">
          <div class="v2-testimonial-avatar" style="background:linear-gradient(135deg,#448CCB,#00BFF3);">KW</div>
          <div class="v2-testimonial-info">
            <div class="v2-testimonial-name">Keenan Wilson</div>
            <div class="v2-testimonial-title">Marketing Manager, Stance</div>
          </div>
        </div>
      </div>

      <!-- Slide 4 -->
      <div class="v2-testimonial-slide">
        <svg class="v2-testimonial-quote-mark" width="60" height="48" viewBox="0 0 60 48" fill="#8560A8"><path d="M0 48V28.8C0 12.48 9.36 3.36 28.08 0l2.16 5.76C19.44 8.64 13.68 15.84 13.2 24H24v24H0zm33.84 0V28.8c0-16.32 9.36-25.44 28.08-28.8L64.08 5.76C53.28 8.64 47.52 15.84 47.04 24H57.84v24H33.84z"/></svg>
        <p class="v2-testimonial-text">&ldquo;Communicating at the right time, in the right dialect, and in a consistent voice across multiple platforms is imperative. Stretch delivers.&rdquo;</p>
        <div class="v2-testimonial-author">
          <div class="v2-testimonial-avatar" style="background:linear-gradient(135deg,#8560A8,#00BFF3);">BR</div>
          <div class="v2-testimonial-info">
            <div class="v2-testimonial-name">Brian Reichel</div>
            <div class="v2-testimonial-title">Sr. VP Marketing, Brixton</div>
          </div>
        </div>
      </div>

      <div class="v2-testimonial-dots" id="testimonialDots">
        <button class="v2-testimonial-dot active" data-index="0" aria-label="Testimonial 1"></button>
        <button class="v2-testimonial-dot" data-index="1" aria-label="Testimonial 2"></button>
        <button class="v2-testimonial-dot" data-index="2" aria-label="Testimonial 3"></button>
        <button class="v2-testimonial-dot" data-index="3" aria-label="Testimonial 4"></button>
      </div>
    </div>
  </div>
  <div class="v2-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none"><polygon points="0,60 1440,0 1440,60" fill="rgb(26,31,46)"/></svg>
  </div>
</section>


<!-- ========================================
     IMPACT / CASE STUDIES (moved above process)
     ======================================== -->
<section class="v2-section v2-impact" aria-label="Impact">
  <div class="v2-container">
    <div class="v2-impact-heading v2-reveal">
      <span class="v2-overline">Measurable Results</span>
      <h2>Case Studies</h2>
    </div>
    <div class="v2-impact-grid">
      <div class="v2-impact-item v2-reveal v2-delay-1">
        <div class="v2-impact-number"><span class="v2-count" data-target="4.2" data-decimals="1">0</span><span class="v2-suffix">x</span></div>
        <div class="v2-impact-desc">Average Dwell Time Increase</div>
      </div>
      <div class="v2-impact-item v2-reveal v2-delay-2">
        <div class="v2-impact-number"><span class="v2-count" data-target="312">0</span><span class="v2-suffix">%</span></div>
        <div class="v2-impact-desc">Organic Traffic Lift</div>
      </div>
      <div class="v2-impact-item v2-reveal v2-delay-3">
        <div class="v2-impact-number"><span class="v2-count" data-target="89">0</span><span class="v2-suffix"></span></div>
        <div class="v2-impact-desc">Average Backlinks Earned</div>
      </div>
      <div class="v2-impact-item v2-reveal v2-delay-4">
        <div class="v2-impact-number"><span class="v2-count" data-target="2.8" data-decimals="1">0</span><span class="v2-suffix">x</span></div>
        <div class="v2-impact-desc">Conversion Rate Improvement</div>
      </div>
    </div>

    <div class="v2-cs-grid" style="margin-top:80px;">
      <!-- Large featured case study -->
      <div class="v2-cs-card v2-cs-card-large v2-reveal">
        <div class="v2-cs-card-image">
          <img src="https://images.unsplash.com/photo-1551434678-e076c223a692?w=800&h=600&fit=crop" alt="Grove Collaborative case study">
        </div>
        <div class="v2-cs-card-content">
          <div class="v2-cs-card-tag">Featured Case Study</div>
          <h3 class="v2-cs-card-title">How Grove Collaborative Scaled SEO Content to 500+ Articles</h3>
          <p class="v2-cs-card-desc">We built a dedicated content team of 12 writers calibrated to Grove's brand voice, producing expert-level SEO content across sustainability, home care, and wellness categories.</p>
          <div class="v2-cs-card-stats">
            <div class="v2-cs-stat">
              <div class="v2-cs-stat-num">312%</div>
              <div class="v2-cs-stat-label">Organic Lift</div>
            </div>
            <div class="v2-cs-stat">
              <div class="v2-cs-stat-num">500+</div>
              <div class="v2-cs-stat-label">Articles</div>
            </div>
            <div class="v2-cs-stat">
              <div class="v2-cs-stat-num">4.2x</div>
              <div class="v2-cs-stat-label">Dwell Time</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Case study 2 -->
      <div class="v2-cs-card v2-reveal">
        <div class="v2-cs-card-image">
          <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=600&h=500&fit=crop" alt="Ecommerce content at scale">
        </div>
        <div class="v2-cs-card-content">
          <div class="v2-cs-card-tag">Ecommerce</div>
          <h3 class="v2-cs-card-title">10,000 Product Descriptions in 90 Days for a Major Retailer</h3>
          <p class="v2-cs-card-desc">Scaled product content across 15 categories while maintaining consistent brand voice and SEO optimization.</p>
          <div class="v2-cs-card-stats">
            <div class="v2-cs-stat">
              <div class="v2-cs-stat-num">10K</div>
              <div class="v2-cs-stat-label">Products</div>
            </div>
            <div class="v2-cs-stat">
              <div class="v2-cs-stat-num">+47%</div>
              <div class="v2-cs-stat-label">Conversions</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Case study 3 -->
      <div class="v2-cs-card v2-reveal">
        <div class="v2-cs-card-image">
          <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=600&h=500&fit=crop" alt="Content marketing strategy">
        </div>
        <div class="v2-cs-card-content">
          <div class="v2-cs-card-tag">Content Strategy</div>
          <h3 class="v2-cs-card-title">From Zero to Page One: Building a B2B Content Engine</h3>
          <p class="v2-cs-card-desc">A comprehensive content strategy that took a B2B SaaS company from no organic presence to ranking for 200+ keywords.</p>
          <div class="v2-cs-card-stats">
            <div class="v2-cs-stat">
              <div class="v2-cs-stat-num">200+</div>
              <div class="v2-cs-stat-label">Keywords</div>
            </div>
            <div class="v2-cs-stat">
              <div class="v2-cs-stat-num">8x</div>
              <div class="v2-cs-stat-label">Traffic</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="v2-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none"><polygon points="0,0 0,60 1440,60" fill="#f9f9fb"/></svg>
  </div>
</section>


<!-- ========================================
     PROCESS TIMELINE
     ======================================== -->
<section class="v2-section v2-process" aria-label="How We Work" id="processTimeline">
  <div class="v2-container">
    <div class="v2-process-heading v2-reveal">
      <span class="v2-overline">Our Process</span>
      <h2>How We Work</h2>
    </div>
    <div class="v2-timeline">
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

      <!-- Detail cards -->
      <div class="v2-timeline-detail">
        <div class="v2-timeline-detail-card active" data-detail="1">
          <div>
            <div class="v2-timeline-detail-step">Step 01</div>
            <div class="v2-timeline-detail-title">Consultation</div>
            <div class="v2-timeline-detail-desc">We meet to define your content needs, budget, and timeline. This is where we learn about your brand, audience, goals, and what success looks like — so we can build the right team and strategy from day one.</div>
          </div>
          <div class="v2-timeline-detail-icon">
            <svg viewBox="0 0 36 36" fill="none"><circle cx="18" cy="14" r="6" stroke="#8560A8" stroke-width="1.5"/><path d="M6 32c0-6.627 5.373-12 12-12s12 5.373 12 12" stroke="#8560A8" stroke-width="1.5" fill="none"/></svg>
          </div>
        </div>
        <div class="v2-timeline-detail-card" data-detail="2">
          <div>
            <div class="v2-timeline-detail-step">Step 02</div>
            <div class="v2-timeline-detail-title">Brief &amp; Style Guide</div>
            <div class="v2-timeline-detail-desc">We develop detailed project briefs and training materials that capture your brand voice, editorial standards, and content requirements. This becomes the playbook your dedicated team follows.</div>
          </div>
          <div class="v2-timeline-detail-icon">
            <svg viewBox="0 0 36 36" fill="none"><rect x="6" y="4" width="24" height="28" rx="2" stroke="#5674B9" stroke-width="1.5" fill="none"/><line x1="12" y1="12" x2="24" y2="12" stroke="#5674B9" stroke-width="1.5"/><line x1="12" y1="18" x2="24" y2="18" stroke="#5674B9" stroke-width="1.5"/><line x1="12" y1="24" x2="18" y2="24" stroke="#5674B9" stroke-width="1.5"/></svg>
          </div>
        </div>
        <div class="v2-timeline-detail-card" data-detail="3">
          <div>
            <div class="v2-timeline-detail-step">Step 03</div>
            <div class="v2-timeline-detail-title">Curate Your Team</div>
            <div class="v2-timeline-detail-desc">We hand-pick writers and creatives based on their expertise, industry experience, and fit with your brand. Your dedicated cohort becomes a true extension of your marketing team.</div>
          </div>
          <div class="v2-timeline-detail-icon">
            <svg viewBox="0 0 36 36" fill="none"><circle cx="12" cy="14" r="5" stroke="#448CCB" stroke-width="1.5" fill="none"/><circle cx="24" cy="14" r="5" stroke="#448CCB" stroke-width="1.5" fill="none"/><circle cx="18" cy="26" r="5" stroke="#448CCB" stroke-width="1.5" fill="none"/></svg>
          </div>
        </div>
        <div class="v2-timeline-detail-card" data-detail="4">
          <div>
            <div class="v2-timeline-detail-step">Step 04</div>
            <div class="v2-timeline-detail-title">Calibrate</div>
            <div class="v2-timeline-detail-desc">We produce sample pieces and refine through your feedback until the voice, quality, and style match your standards perfectly. No content goes live until you're confident in the output.</div>
          </div>
          <div class="v2-timeline-detail-icon">
            <svg viewBox="0 0 36 36" fill="none"><circle cx="18" cy="18" r="12" stroke="#00BFF3" stroke-width="1.5" fill="none"/><circle cx="18" cy="18" r="6" stroke="#00BFF3" stroke-width="1.5" fill="none"/><circle cx="18" cy="18" r="1.5" fill="#00BFF3"/></svg>
          </div>
        </div>
        <div class="v2-timeline-detail-card" data-detail="5">
          <div>
            <div class="v2-timeline-detail-step">Step 05</div>
            <div class="v2-timeline-detail-title">Create</div>
            <div class="v2-timeline-detail-desc">Your dedicated team produces content on schedule, at your scale, with built-in editorial quality checks at every stage. Direct collaboration and real-time feedback keep everything on track.</div>
          </div>
          <div class="v2-timeline-detail-icon">
            <svg viewBox="0 0 36 36" fill="none"><path d="M6 28l8-10 6 6 8-12 4 5" stroke="#8560A8" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/><line x1="6" y1="32" x2="32" y2="32" stroke="#8560A8" stroke-width="1" opacity="0.3"/></svg>
          </div>
        </div>
        <div class="v2-timeline-detail-card" data-detail="6">
          <div>
            <div class="v2-timeline-detail-step">Step 06</div>
            <div class="v2-timeline-detail-title">Deliver &amp; Report</div>
            <div class="v2-timeline-detail-desc">Publish-ready content delivered on time with performance tracking and ongoing optimization. We continuously monitor, maintain, and refine content quality through regular feedback loops.</div>
          </div>
          <div class="v2-timeline-detail-icon">
            <svg viewBox="0 0 36 36" fill="none"><rect x="6" y="8" width="24" height="20" rx="2" stroke="#00BFF3" stroke-width="1.5" fill="none"/><polyline points="12,18 16,22 24,14" stroke="#00BFF3" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="v2-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none"><polygon points="0,60 1440,0 1440,60" fill="#fff"/></svg>
  </div>
</section>


<!-- ========================================
     11. MAGAZINE BLOG LAYOUT
     ======================================== -->
<section class="v2-section v2-blog" aria-label="From the Blog">
  <div class="v2-container">
    <div class="v2-blog-heading v2-reveal">
      <span class="v2-overline">Insights</span>
      <h2>From the Blog</h2>
    </div>
    <div class="v2-blog-grid">
      <a href="#" class="v2-blog-featured v2-reveal-left">
        <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&h=600&fit=crop" alt="Content strategy" loading="lazy">
        <div class="v2-blog-featured-overlay">
          <span class="v2-blog-tag">Strategy</span>
          <h3>The Future of Content: Why Interactive Experiences Outperform Static Pages 3-to-1</h3>
          <p>How leading brands are using bespoke content to drive engagement, generate leads, and own their category.</p>
        </div>
      </a>
      <div class="v2-blog-stack">
        <a href="#" class="v2-blog-small v2-reveal-right v2-delay-1">
          <div class="v2-blog-small-img">
            <img src="https://images.unsplash.com/photo-1432821596592-e2c18b78144f?w=600&h=300&fit=crop" alt="SEO trends" loading="lazy">
          </div>
          <div class="v2-blog-small-content">
            <span class="v2-blog-tag">SEO</span>
            <h3>5 Content Frameworks That Consistently Win Featured Snippets</h3>
            <p>Proven structures for dominating position zero across competitive verticals.</p>
          </div>
        </a>
        <a href="#" class="v2-blog-small v2-reveal-right v2-delay-2">
          <div class="v2-blog-small-img">
            <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?w=600&h=300&fit=crop" alt="Brand content" loading="lazy">
          </div>
          <div class="v2-blog-small-content">
            <span class="v2-blog-tag">Branding</span>
            <h3>Scaling Content Without Losing Your Brand Voice</h3>
            <p>How enterprise teams maintain quality and consistency at 500+ pieces per month.</p>
          </div>
        </a>
      </div>
    </div>
  </div>
</section>


<!-- ========================================
     12. FULL-VIEWPORT CTA
     ======================================== -->
<section class="v2-section v2-cta-full" aria-label="Call to Action">
  <div class="v2-cta-shapes">
    <div class="v2-cta-shape v2-cta-shape-1"></div>
    <div class="v2-cta-shape v2-cta-shape-2"></div>
    <div class="v2-cta-shape v2-cta-shape-3"></div>
    <div class="v2-cta-shape v2-cta-shape-4"></div>
  </div>
  <div class="v2-cta-content v2-reveal">
    <h2>Ready to create something extraordinary?</h2>
    <p>Let&rsquo;s build content that doesn&rsquo;t just fill a page &mdash; it moves the needle. Your audience is waiting.</p>
    <div class="v2-cta-buttons">
      <a href="/contact-stretch-creative/" class="v2-cta-btn-primary">Start a Project &rarr;</a>
      <a href="/work/" class="v2-cta-btn-outline">View Our Work &rarr;</a>
    </div>
  </div>
</section>


<script>
(function() {
  'use strict';

  /* ---------- SCROLL PROGRESS BAR ---------- */
  var progressBar = document.getElementById('scrollProgress');
  function updateProgress() {
    var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    var docHeight = document.documentElement.scrollHeight - window.innerHeight;
    var pct = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
    progressBar.style.width = pct + '%';
  }

  /* ---------- MOUSE PARALLAX ON HERO ---------- */
  var heroSection = document.querySelector('.v2-hero');
  var heroShapes = document.getElementById('heroShapes');
  if (heroSection && heroShapes) {
    heroSection.addEventListener('mousemove', function(e) {
      var rect = heroSection.getBoundingClientRect();
      var mx = ((e.clientX - rect.left) / rect.width - 0.5) * 2;
      var my = ((e.clientY - rect.top) / rect.height - 0.5) * 2;
      heroShapes.style.setProperty('--mx', mx);
      heroShapes.style.setProperty('--my', my);
    });
  }

  /* ---------- INTERSECTION OBSERVER — REVEALS ---------- */
  var revealEls = document.querySelectorAll('.v2-reveal, .v2-reveal-left, .v2-reveal-right');
  var revealObserver = new IntersectionObserver(function(entries) {
    entries.forEach(function(entry) {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        revealObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });
  revealEls.forEach(function(el) { revealObserver.observe(el); });

  /* ---------- COUNTING ANIMATION ---------- */
  var countEls = document.querySelectorAll('.v2-count');
  var counted = new Set();
  function animateCount(el) {
    if (counted.has(el)) return;
    counted.add(el);
    var target = parseFloat(el.dataset.target);
    var decimals = parseInt(el.dataset.decimals || '0', 10);
    var duration = 2000;
    var start = performance.now();
    function tick(now) {
      var elapsed = now - start;
      var progress = Math.min(elapsed / duration, 1);
      // ease out cubic
      var ease = 1 - Math.pow(1 - progress, 3);
      var current = target * ease;
      el.textContent = decimals > 0 ? current.toFixed(decimals) : Math.floor(current);
      if (progress < 1) requestAnimationFrame(tick);
      else el.textContent = decimals > 0 ? target.toFixed(decimals) : target;
    }
    requestAnimationFrame(tick);
  }
  var countObserver = new IntersectionObserver(function(entries) {
    entries.forEach(function(entry) {
      if (entry.isIntersecting) {
        var counts = entry.target.querySelectorAll('.v2-count');
        counts.forEach(animateCount);
      }
    });
  }, { threshold: 0.3 });
  document.querySelectorAll('.v2-stats-bar, .v2-impact').forEach(function(el) {
    countObserver.observe(el);
  });

  /* ---------- TESTIMONIAL CAROUSEL ---------- */
  var slides = document.querySelectorAll('.v2-testimonial-slide');
  var dots = document.querySelectorAll('.v2-testimonial-dot');
  var currentSlide = 0;
  var autoInterval;

  function showSlide(index) {
    slides.forEach(function(s) { s.classList.remove('active'); });
    dots.forEach(function(d) { d.classList.remove('active'); });
    slides[index].classList.add('active');
    dots[index].classList.add('active');
    currentSlide = index;
  }

  function nextSlide() {
    showSlide((currentSlide + 1) % slides.length);
  }

  function startAuto() {
    autoInterval = setInterval(nextSlide, 5000);
  }

  dots.forEach(function(dot) {
    dot.addEventListener('click', function() {
      clearInterval(autoInterval);
      showSlide(parseInt(this.dataset.index, 10));
      startAuto();
    });
  });

  startAuto();

  /* ---------- PROCESS TIMELINE (interactive) ---------- */
  var timelineSection = document.getElementById('processTimeline');
  var timelineProgress = document.getElementById('timelineProgress');
  var timelineSteps = document.querySelectorAll('.v2-timeline-step');
  var timelineDetails = document.querySelectorAll('.v2-timeline-detail-card');
  var activeTimelineStep = 0;

  function setActiveStep(index) {
    activeTimelineStep = index;
    // Update steps
    timelineSteps.forEach(function(step, i) {
      step.classList.toggle('active', i <= index);
    });
    // Update progress bar
    if (timelineProgress) {
      var pct = ((index + 1) / timelineSteps.length) * 100;
      timelineProgress.style.width = pct + '%';
    }
    // Update detail cards
    timelineDetails.forEach(function(card) {
      card.classList.remove('active');
    });
    var targetCard = document.querySelector('.v2-timeline-detail-card[data-detail="' + (index + 1) + '"]');
    if (targetCard) targetCard.classList.add('active');
  }

  // Click on steps
  timelineSteps.forEach(function(step, i) {
    step.addEventListener('click', function() {
      setActiveStep(i);
    });
  });

  // Initialize first step
  setActiveStep(0);

  function updateTimeline() {
    // Scroll-based activation only if user hasn't clicked recently
    // (kept for initial reveal animation)
    if (!timelineSection) return;
    var rect = timelineSection.getBoundingClientRect();
    var viewH = window.innerHeight;
    if (rect.top > viewH || rect.bottom < 0) return;
  }

  /* ---------- SERVICE IMAGE PARALLAX ---------- */
  var serviceImages = document.querySelectorAll('.v2-service-image img');
  function updateParallax() {
    serviceImages.forEach(function(img) {
      var rect = img.parentElement.getBoundingClientRect();
      var viewH = window.innerHeight;
      if (rect.top < viewH && rect.bottom > 0) {
        var progress = (viewH - rect.top) / (viewH + rect.height);
        var offset = (progress - 0.5) * 40;
        img.style.transform = 'scale(1.1) translateY(' + offset + 'px)';
      }
    });
  }

  /* ---------- SCROLL HANDLER (throttled via rAF) ---------- */
  var ticking = false;
  function onScroll() {
    if (!ticking) {
      requestAnimationFrame(function() {
        updateProgress();
        updateTimeline();
        updateParallax();
        ticking = false;
      });
      ticking = true;
    }
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  // initial run
  updateProgress();
  updateTimeline();
  updateParallax();

  /* ========================================
     PREMIUM MICRO-INTERACTIONS
     ======================================== */

  var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var isTouchDevice = 'ontouchstart' in window || navigator.maxTouchPoints > 0;

  /* ---------- 1. CUSTOM CURSOR ---------- */
  if (!isTouchDevice && !reducedMotion && window.innerWidth > 768) {
    var cursor = document.getElementById('v2Cursor');
    var cursorDot = document.getElementById('v2CursorDot');
    var cursorX = 0, cursorY = 0, dotX = 0, dotY = 0;
    var cursorVisible = false;

    document.addEventListener('mousemove', function(e) {
      cursorX = e.clientX;
      cursorY = e.clientY;
      if (!cursorVisible) {
        cursor.style.opacity = '1';
        cursorDot.style.opacity = '1';
        cursorVisible = true;
      }
    });

    // Smooth follow for outer ring
    (function animateCursor() {
      dotX += (cursorX - dotX) * 0.9;
      dotY += (cursorY - dotY) * 0.9;
      cursorDot.style.left = dotX + 'px';
      cursorDot.style.top = dotY + 'px';

      var cX = parseFloat(cursor.style.left) || 0;
      var cY = parseFloat(cursor.style.top) || 0;
      cursor.style.left = cX + (cursorX - cX) * 0.15 + 'px';
      cursor.style.top = cY + (cursorY - cY) * 0.15 + 'px';
      requestAnimationFrame(animateCursor);
    })();

    cursor.style.opacity = '0';
    cursorDot.style.opacity = '0';

    // Interactive element hover
    var interactiveSelectors = 'a, button, .v2-btn-primary, .btn-primary, .btn-white, .v2-cta-btn-primary, .v2-cta-btn-outline, .v2-cs-card, .v2-service-row, .v2-testimonial-dot';
    document.querySelectorAll(interactiveSelectors).forEach(function(el) {
      el.addEventListener('mouseenter', function() {
        cursor.classList.add('active');
        var tag = el.tagName.toLowerCase();
        cursor.textContent = '';
      });
      el.addEventListener('mouseleave', function() {
        cursor.classList.remove('active');
        cursor.textContent = '';
      });
    });
  }

  /* ---------- 2. MAGNETIC BUTTONS ---------- */
  if (!isTouchDevice && !reducedMotion) {
    var magneticBtns = document.querySelectorAll('.v2-btn-primary, .btn-primary, .btn-white, .v2-cta-btn-primary');
    magneticBtns.forEach(function(btn) {
      btn.addEventListener('mousemove', function(e) {
        var rect = btn.getBoundingClientRect();
        var bx = rect.left + rect.width / 2;
        var by = rect.top + rect.height / 2;
        var dx = e.clientX - bx;
        var dy = e.clientY - by;
        var dist = Math.sqrt(dx * dx + dy * dy);
        var maxDist = 40;
        if (dist < maxDist + rect.width / 2) {
          var pull = Math.max(0, 1 - dist / (maxDist + rect.width / 2));
          btn.style.transform = 'translate(' + (dx * pull * 0.3) + 'px, ' + (dy * pull * 0.3) + 'px)';
        }
      });
      btn.addEventListener('mouseleave', function() {
        btn.style.transform = '';
        btn.style.transition = 'transform 0.4s cubic-bezier(0.16,1,0.3,1)';
        setTimeout(function() { btn.style.transition = ''; }, 400);
      });
    });
  }

  /* ---------- 3. 3D TILT ON CARDS ---------- */
  if (!isTouchDevice && !reducedMotion) {
    var tiltCards = document.querySelectorAll('.v2-cs-card, .v2-service-row');
    tiltCards.forEach(function(card) {
      card.style.transition = card.style.transition ? card.style.transition + ', transform 0.3s ease-out' : 'transform 0.3s ease-out';
      card.style.transformStyle = 'preserve-3d';
      card.addEventListener('mousemove', function(e) {
        var rect = card.getBoundingClientRect();
        var cx = rect.left + rect.width / 2;
        var cy = rect.top + rect.height / 2;
        var dx = (e.clientX - cx) / (rect.width / 2);
        var dy = (e.clientY - cy) / (rect.height / 2);
        card.style.transform = 'perspective(800px) rotateY(' + (dx * 4) + 'deg) rotateX(' + (-dy * 4) + 'deg)';
        card.style.transition = 'none';
      });
      card.addEventListener('mouseleave', function() {
        card.style.transform = '';
        card.style.transition = 'transform 0.5s cubic-bezier(0.16,1,0.3,1)';
      });
    });
  }

  /* ---------- 4. LETTER-BY-LETTER HERO REVEAL (disabled — breaks gradient text) ---------- */
  if (false && !reducedMotion) {
    var heroTitle = document.querySelector('.v2-hero-title');
    if (heroTitle) {
      var html = heroTitle.innerHTML;
      // Preserve the gradient-text span
      var parts = html.split(/(<span class="gradient-text">.*?<\/span>|<br\s*\/?>)/i);
      var newHTML = '';
      var charIndex = 0;

      parts.forEach(function(part) {
        if (part.match(/^<br/i)) {
          newHTML += part;
        } else if (part.match(/^<span class="gradient-text">/i)) {
          // Extract inner text of gradient span and wrap letters
          var inner = part.replace(/<span class="gradient-text">/, '').replace(/<\/span>/, '');
          var wrappedInner = '';
          for (var i = 0; i < inner.length; i++) {
            if (inner[i] === ' ') {
              wrappedInner += '<span class="v2-letter-space"> </span>';
            } else {
              wrappedInner += '<span class="v2-letter" style="animation-delay:' + (charIndex * 0.03) + 's">' + inner[i] + '</span>';
            }
            charIndex++;
          }
          newHTML += '<span class="gradient-text">' + wrappedInner + '</span>';
        } else {
          // Regular text
          for (var j = 0; j < part.length; j++) {
            if (part[j] === ' ') {
              newHTML += '<span class="v2-letter-space"> </span>';
            } else if (part[j] === '&' || part.substr(j).match(/^&[a-z]+;/i)) {
              // Handle HTML entities
              var entityMatch = part.substr(j).match(/^&[a-z]+;/i);
              if (entityMatch) {
                newHTML += '<span class="v2-letter" style="animation-delay:' + (charIndex * 0.03) + 's">' + entityMatch[0] + '</span>';
                j += entityMatch[0].length - 1;
              } else {
                newHTML += '<span class="v2-letter" style="animation-delay:' + (charIndex * 0.03) + 's">' + part[j] + '</span>';
              }
            } else {
              newHTML += '<span class="v2-letter" style="animation-delay:' + (charIndex * 0.03) + 's">' + part[j] + '</span>';
            }
            charIndex++;
          }
        }
      });

      heroTitle.innerHTML = newHTML;
    }
  }

  /* ---------- 5. GRAIN TEXTURE OVERLAY ---------- */
  if (!reducedMotion) {
    var grainSections = document.querySelectorAll('.v2-hero, .v2-impact, .v2-bespoke, .v2-stats-bar');
    grainSections.forEach(function(section) {
      // Ensure position relative for absolute child
      var pos = window.getComputedStyle(section).position;
      if (pos === 'static') section.style.position = 'relative';
      var grain = document.createElement('div');
      grain.className = 'v2-grain-overlay';
      section.insertBefore(grain, section.firstChild);
    });
  }

  /* ---------- 6. SCROLL-TRIGGERED TEXT WIPE ON PULL QUOTE ---------- */
  var pullQuote = document.querySelector('.v2-pull-quote blockquote');
  if (pullQuote && !reducedMotion) {
    // Wrap each word in a span (preserving HTML like <span class="quote-accent">)
    var quoteHTML = pullQuote.innerHTML;
    // Split by tags and text
    var tokens = quoteHTML.split(/(<[^>]+>)/);
    var wordHTML = '';
    tokens.forEach(function(token) {
      if (token.match(/^</)) {
        wordHTML += token; // keep tags as-is
      } else {
        // Split text into words
        var words = token.split(/(\s+)/);
        words.forEach(function(w) {
          if (w.match(/^\s+$/)) {
            wordHTML += w;
          } else if (w.length > 0) {
            wordHTML += '<span class="v2-wipe-word">' + w + '</span>';
          }
        });
      }
    });
    pullQuote.innerHTML = wordHTML;

    var wipeWords = pullQuote.querySelectorAll('.v2-wipe-word');
    var pullQuoteSection = document.querySelector('.v2-pull-quote');

    function updateTextWipe() {
      if (!pullQuoteSection) return;
      var rect = pullQuoteSection.getBoundingClientRect();
      var viewH = window.innerHeight;
      // Progress: 0 when top enters viewport, 1 when bottom leaves
      var progress = 1 - (rect.bottom / (viewH + rect.height));
      progress = Math.max(0, Math.min(1, progress));

      wipeWords.forEach(function(word, i) {
        var wordProgress = (progress * (wipeWords.length + 5) - i) / 5;
        wordProgress = Math.max(0, Math.min(1, wordProgress));
        if (wordProgress > 0.5) {
          word.classList.add('revealed');
        } else {
          word.classList.remove('revealed');
        }
      });
    }

    // Piggyback on the scroll via a separate passive listener
    var wipeTicking = false;
    window.addEventListener('scroll', function() {
      if (!wipeTicking) {
        requestAnimationFrame(function() {
          updateTextWipe();
          wipeTicking = false;
        });
        wipeTicking = true;
      }
    }, { passive: true });
    updateTextWipe();
  }

  /* ---------- 7. LIVE PULSE ON IMPACT NUMBERS ---------- */
  if (!reducedMotion) {
    var impactNumbers = document.querySelectorAll('.v2-impact-number');
    var pulseObserver = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting) {
          // Delay the pulse to start after counting finishes (~2.5s)
          setTimeout(function() {
            entry.target.classList.add('v2-pulse-active');
          }, 2500);
          pulseObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.3 });
    impactNumbers.forEach(function(el) {
      pulseObserver.observe(el);
    });
  }

})();
</script>

<?php get_footer(); ?>
