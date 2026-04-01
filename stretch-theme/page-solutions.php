<?php
/**
 * Template Name: Solutions
 */
get_header();
?>

<style>
/* ========================================
   SOLUTIONS — PREMIUM TEMPLATE
   ======================================== */

html, body { overflow-x: hidden; }
.admin-bar .site-nav { top: 32px; }
@media (max-width: 782px) { .admin-bar .site-nav { top: 46px; } }

.v2-section { box-sizing: border-box; }
.v2-section *, .v2-section *::before, .v2-section *::after { box-sizing: inherit; }
.v2-section img { max-width: 100%; height: auto; display: block; }

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

.v2-reveal {
  opacity: 0; transform: translateY(40px);
  transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}
.v2-reveal.visible { opacity: 1; transform: translateY(0); }
.v2-reveal-left {
  opacity: 0; transform: translateX(-60px);
  transition: opacity 0.9s cubic-bezier(0.16, 1, 0.3, 1), transform 0.9s cubic-bezier(0.16, 1, 0.3, 1);
}
.v2-reveal-left.visible { opacity: 1; transform: translateX(0); }
.v2-reveal-right {
  opacity: 0; transform: translateX(60px);
  transition: opacity 0.9s cubic-bezier(0.16, 1, 0.3, 1), transform 0.9s cubic-bezier(0.16, 1, 0.3, 1);
}
.v2-reveal-right.visible { opacity: 1; transform: translateX(0); }
.v2-delay-1 { transition-delay: 0.1s; }
.v2-delay-2 { transition-delay: 0.2s; }
.v2-delay-3 { transition-delay: 0.3s; }
.v2-delay-4 { transition-delay: 0.4s; }
.v2-delay-5 { transition-delay: 0.5s; }
.v2-delay-6 { transition-delay: 0.6s; }

.v2-angle-divider {
  position: absolute; bottom: -1px; left: 0; right: 0;
  z-index: 2; pointer-events: none; line-height: 0;
}
.v2-angle-divider svg { display: block; width: 100%; height: 60px; }

/* ========================================
   1. HERO
   ======================================== */
.sol-hero {
  position: relative;
  min-height: 60vh;
  display: flex;
  align-items: center;
  background: linear-gradient(170deg, #1a1f2e 0%, #252C3A 40%, #1e2333 100%);
  overflow: hidden;
  padding: 140px 0 100px;
}
.sol-hero::before {
  content: '';
  position: absolute;
  top: -50%; right: -20%;
  width: 80%; height: 150%;
  background: radial-gradient(ellipse at center, rgba(86,116,185,0.08) 0%, transparent 70%);
  pointer-events: none;
}
.sol-hero::after {
  content: '';
  position: absolute;
  bottom: -30%; left: -10%;
  width: 60%; height: 80%;
  background: radial-gradient(ellipse at center, rgba(133,96,168,0.06) 0%, transparent 70%);
  pointer-events: none;
}
.sol-hero-shapes {
  position: absolute; inset: 0; pointer-events: none; z-index: 1;
}
.sol-shape {
  position: absolute; border-radius: 50%; opacity: 0.12;
}
.sol-shape-1 { width: 300px; height: 300px; top: 10%; left: 5%; background: radial-gradient(circle, #8560A8, transparent); }
.sol-shape-2 { width: 200px; height: 200px; top: 55%; left: 65%; background: radial-gradient(circle, #5674B9, transparent); }
.sol-shape-3 { width: 150px; height: 150px; top: 20%; right: 10%; background: radial-gradient(circle, #00BFF3, transparent); }
.sol-shape-4 { width: 100px; height: 100px; bottom: 15%; left: 30%; background: radial-gradient(circle, #448CCB, transparent); border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; }

.sol-hero-content {
  position: relative; z-index: 2;
  text-align: center;
  max-width: 700px; margin: 0 auto;
}
.sol-hero-content .v2-overline {
  font-family: 'Montserrat', sans-serif;
  font-size: 13px; font-weight: 400;
  letter-spacing: 3px; text-transform: uppercase;
  color: #00BFF3; margin-bottom: 20px; display: block;
}
.sol-hero-content h1 {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(36px, 4.5vw, 58px);
  font-weight: 600; line-height: 1.1;
  color: #fff; margin: 0 0 24px; letter-spacing: -1px;
}
.sol-hero-content .v2-subtitle {
  font-family: 'Assistant', sans-serif;
  font-size: 19px; font-weight: 300; line-height: 1.7;
  color: rgba(255,255,255,0.7);
  max-width: 520px; margin: 0 auto;
}

/* ========================================
   2. SOLUTIONS CARDS
   ======================================== */
.sol-cards-section {
  padding: 120px 0;
  background: #fff;
  position: relative;
}
.sol-cards-heading {
  text-align: center;
  margin-bottom: 64px;
}
.sol-cards-heading .v2-overline {
  font-family: 'Montserrat', sans-serif;
  font-size: 12px; letter-spacing: 3px;
  text-transform: uppercase; color: #00BFF3;
  display: block; margin-bottom: 16px;
}
.sol-cards-heading h2 {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(32px, 4vw, 44px);
  font-weight: 600; color: #252C3A; margin: 0;
}
.sol-cards-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 32px;
}
.sol-card {
  position: relative;
  overflow: hidden;
  min-height: 420px;
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  border-radius: 12px;
  transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.5s ease;
}
.sol-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 24px 64px rgba(37,44,58,0.2);
}
.sol-card-image {
  position: absolute; inset: 0; z-index: 0;
}
.sol-card-image img {
  width: 100%; height: 100%;
  object-fit: cover;
  transition: transform 0.6s ease;
}
.sol-card:hover .sol-card-image img {
  transform: scale(1.05);
}
.sol-card::after {
  content: '';
  position: absolute; inset: 0;
  background: linear-gradient(0deg, rgba(37,44,58,0.95) 0%, rgba(37,44,58,0.6) 40%, rgba(37,44,58,0.15) 100%);
  z-index: 1;
}
.sol-card-content {
  position: relative; z-index: 2;
  padding: 40px;
}
.sol-card-tag {
  display: inline-block;
  font-family: 'Poppins', sans-serif;
  font-size: 10px; font-weight: 600;
  letter-spacing: 2px; text-transform: uppercase;
  color: #00BFF3;
  border: 1px solid rgba(0,191,243,0.3);
  padding: 4px 12px;
  margin-bottom: 16px;
}
.sol-card-title {
  font-family: 'Poppins', sans-serif;
  font-size: 24px; font-weight: 500;
  color: #fff; line-height: 1.3; margin-bottom: 12px;
}
.sol-card-desc {
  font-family: 'Assistant', sans-serif;
  font-size: 16px; color: rgba(255,255,255,0.7);
  line-height: 1.6; margin-bottom: 20px;
}
.sol-card-stats {
  display: flex; gap: 24px; margin-bottom: 20px;
}
.sol-stat-num {
  font-family: 'Poppins', sans-serif;
  font-size: 28px; font-weight: 600;
  color: #00BFF3; line-height: 1;
}
.sol-stat-label {
  font-family: 'Poppins', sans-serif;
  font-size: 10px; font-weight: 500;
  text-transform: uppercase; letter-spacing: 1px;
  color: rgba(255,255,255,0.5); margin-top: 4px;
}
.sol-card-link {
  display: inline-flex;
  align-items: center; gap: 8px;
  font-family: 'Poppins', sans-serif;
  font-size: 14px; font-weight: 500;
  color: #00BFF3; text-decoration: none;
  transition: gap 0.3s ease;
}
.sol-card-link:hover { gap: 14px; }

/* ========================================
   3. ALL SERVICES
   ======================================== */
.sol-services {
  padding: 120px 0;
  background: #f9f9fb;
  position: relative;
}
.sol-services-heading {
  text-align: center;
  margin-bottom: 64px;
}
.sol-services-heading .v2-overline {
  font-family: 'Montserrat', sans-serif;
  font-size: 12px; letter-spacing: 3px;
  text-transform: uppercase; color: #00BFF3;
  display: block; margin-bottom: 16px;
}
.sol-services-heading h2 {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(32px, 4vw, 44px);
  font-weight: 600; color: #252C3A; margin: 0;
}
.sol-services-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 24px;
}
.sol-service-card {
  background: #fff;
  border-radius: 12px;
  padding: 36px 28px;
  text-align: center;
  transition: transform 0.4s cubic-bezier(0.16,1,0.3,1), box-shadow 0.4s ease;
  border: 1px solid rgba(0,0,0,0.04);
}
.sol-service-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 16px 48px rgba(37,44,58,0.08);
}
.sol-service-icon {
  width: 56px; height: 56px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 20px;
  background: linear-gradient(135deg, rgba(133,96,168,0.08), rgba(0,191,243,0.08));
}
.sol-service-icon svg { width: 28px; height: 28px; }
.sol-service-card h3 {
  font-family: 'Poppins', sans-serif;
  font-size: 17px; font-weight: 600;
  color: #252C3A; margin: 0 0 8px;
}
.sol-service-card p {
  font-family: 'Assistant', sans-serif;
  font-size: 15px; font-weight: 300;
  line-height: 1.6; color: #777; margin: 0;
}

/* ========================================
   4. CTA
   ======================================== */
.sol-cta {
  padding: 100px 0;
  background: linear-gradient(135deg, #8560A8, #5674B9);
  text-align: center;
  position: relative;
  overflow: hidden;
}
.sol-cta::before {
  content: '';
  position: absolute;
  top: 30%; left: 50%;
  transform: translate(-50%, -50%);
  width: 600px; height: 600px;
  background: radial-gradient(circle, rgba(0,191,243,0.12), transparent 70%);
  pointer-events: none;
}
.sol-cta h2 {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(32px, 4vw, 48px);
  font-weight: 600; color: #fff;
  margin: 0 0 16px; position: relative;
}
.sol-cta p {
  font-family: 'Assistant', sans-serif;
  font-size: 19px; font-weight: 300;
  color: rgba(255,255,255,0.7);
  margin-bottom: 36px; position: relative;
}
.sol-cta .v2-btn-primary {
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
.sol-cta .v2-btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 30px rgba(0,0,0,0.25);
}

/* ========================================
   RESPONSIVE
   ======================================== */
@media (max-width: 960px) {
  .sol-cards-grid { grid-template-columns: 1fr; }
  .sol-services-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
  .v2-container { padding: 0 24px; }
  .sol-hero { padding: 100px 0 70px; }
  .sol-hero-content h1 { font-size: 34px; }
  .sol-cards-section { padding: 80px 0; }
  .sol-card { min-height: 360px; }
  .sol-services { padding: 80px 0; }
  .sol-cta { padding: 70px 0; }
}
@media (max-width: 480px) {
  .v2-container { padding: 0 16px; }
  .sol-services-grid { grid-template-columns: 1fr; }
}
</style>


<!-- ========================================
     1. HERO
     ======================================== -->
<section class="v2-section sol-hero" aria-label="Hero">
  <div class="sol-hero-shapes">
    <div class="sol-shape sol-shape-1"></div>
    <div class="sol-shape sol-shape-2"></div>
    <div class="sol-shape sol-shape-3"></div>
    <div class="sol-shape sol-shape-4"></div>
  </div>

  <div class="v2-container">
    <div class="sol-hero-content">
      <span class="v2-overline v2-reveal v2-delay-1">Solutions</span>
      <h1 class="v2-reveal v2-delay-2">Creative Solutions <span class="gradient-text">Fit For You</span></h1>
      <p class="v2-subtitle v2-reveal v2-delay-3">From ecommerce product copy to enterprise content strategy, we tailor our services to meet you where you are.</p>
    </div>
  </div>

  <div class="v2-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none">
      <polygon points="0,60 1440,0 1440,60" fill="#ffffff"/>
    </svg>
  </div>
</section>


<!-- ========================================
     2. SOLUTIONS CARDS
     ======================================== -->
<section class="v2-section sol-cards-section" aria-label="Solutions">
  <div class="v2-container">
    <div class="sol-cards-heading">
      <span class="v2-overline v2-reveal">Who We Serve</span>
      <h2 class="v2-reveal v2-delay-1">Industries &amp; <span class="gradient-text">Solutions</span></h2>
    </div>

    <div class="sol-cards-grid">
      <div class="sol-card v2-reveal v2-delay-1">
        <div class="sol-card-image">
          <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=600&h=400&fit=crop" alt="Ecommerce solutions" loading="lazy">
        </div>
        <div class="sol-card-content">
          <div class="sol-card-tag">Ecommerce</div>
          <div class="sol-card-title">Scale Your Product Content</div>
          <div class="sol-card-desc">High-converting product descriptions, category pages, and brand storytelling for online retailers of every size.</div>
          <div class="sol-card-stats">
            <div>
              <div class="sol-stat-num">500+</div>
              <div class="sol-stat-label">Products Written</div>
            </div>
            <div>
              <div class="sol-stat-num">3x</div>
              <div class="sol-stat-label">Conversion Lift</div>
            </div>
          </div>
          <a href="/contact-stretch-creative/" class="sol-card-link">Learn More <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
        </div>
      </div>

      <div class="sol-card v2-reveal v2-delay-2">
        <div class="sol-card-image">
          <img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?w=600&h=400&fit=crop" alt="Agency solutions" loading="lazy">
        </div>
        <div class="sol-card-content">
          <div class="sol-card-tag">Agencies</div>
          <div class="sol-card-title">Your White-Label Content Partner</div>
          <div class="sol-card-desc">Reliable, scalable content production that integrates seamlessly with your agency&rsquo;s workflow and client expectations.</div>
          <div class="sol-card-stats">
            <div>
              <div class="sol-stat-num">50+</div>
              <div class="sol-stat-label">Agency Partners</div>
            </div>
            <div>
              <div class="sol-stat-num">98%</div>
              <div class="sol-stat-label">On-Time Delivery</div>
            </div>
          </div>
          <a href="/contact-stretch-creative/" class="sol-card-link">Learn More <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
        </div>
      </div>

      <div class="sol-card v2-reveal v2-delay-3">
        <div class="sol-card-image">
          <img src="https://images.unsplash.com/photo-1457369804613-52c61a468e7d?w=600&h=400&fit=crop" alt="Publisher solutions" loading="lazy">
        </div>
        <div class="sol-card-content">
          <div class="sol-card-tag">Publishers</div>
          <div class="sol-card-title">Editorial Content at Scale</div>
          <div class="sol-card-desc">From blogs and articles to longform features, we deliver publish-ready editorial content that meets your standards.</div>
          <div class="sol-card-stats">
            <div>
              <div class="sol-stat-num">1,000+</div>
              <div class="sol-stat-label">Articles Delivered</div>
            </div>
            <div>
              <div class="sol-stat-num">200+</div>
              <div class="sol-stat-label">Writers Available</div>
            </div>
          </div>
          <a href="/contact-stretch-creative/" class="sol-card-link">Learn More <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
        </div>
      </div>

      <div class="sol-card v2-reveal v2-delay-4">
        <div class="sol-card-image">
          <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=600&h=400&fit=crop" alt="Content marketing solutions" loading="lazy">
        </div>
        <div class="sol-card-content">
          <div class="sol-card-tag">Content Marketing</div>
          <div class="sol-card-title">Full-Funnel Content Strategy</div>
          <div class="sol-card-desc">SEO-driven blogs, gated content, email campaigns, and social copy that attract, engage, and convert your audience.</div>
          <div class="sol-card-stats">
            <div>
              <div class="sol-stat-num">40%</div>
              <div class="sol-stat-label">Traffic Growth</div>
            </div>
            <div>
              <div class="sol-stat-num">2x</div>
              <div class="sol-stat-label">Lead Generation</div>
            </div>
          </div>
          <a href="/contact-stretch-creative/" class="sol-card-link">Learn More <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
        </div>
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
     3. ALL SERVICES
     ======================================== -->
<section class="v2-section sol-services" aria-label="All Services">
  <div class="v2-container">
    <div class="sol-services-heading">
      <span class="v2-overline v2-reveal">Everything We Do</span>
      <h2 class="v2-reveal v2-delay-1">Our <span class="gradient-text">Services</span></h2>
    </div>

    <div class="sol-services-grid">
      <div class="sol-service-card v2-reveal v2-delay-1">
        <div class="sol-service-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="#8560A8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"/><polygon points="18 2 22 6 12 16 8 16 8 12 18 2"/></svg>
        </div>
        <h3>Product Copy</h3>
        <p>Compelling descriptions that sell</p>
      </div>

      <div class="sol-service-card v2-reveal v2-delay-2">
        <div class="sol-service-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="#5674B9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        </div>
        <h3>Banner Sales Copy</h3>
        <p>High-impact messaging for ads</p>
      </div>

      <div class="sol-service-card v2-reveal v2-delay-3">
        <div class="sol-service-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="#448CCB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
        </div>
        <h3>Email &amp; Social</h3>
        <p>Engaging campaigns that convert</p>
      </div>

      <div class="sol-service-card v2-reveal v2-delay-1">
        <div class="sol-service-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="#00BFF3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
        </div>
        <h3>Ebooks &amp; Gated Content</h3>
        <p>Lead magnets that drive downloads</p>
      </div>

      <div class="sol-service-card v2-reveal v2-delay-2">
        <div class="sol-service-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="#8560A8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
        </div>
        <h3>Blogs &amp; Articles</h3>
        <p>Publish-ready content at scale</p>
      </div>

      <div class="sol-service-card v2-reveal v2-delay-3">
        <div class="sol-service-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="#5674B9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
        </div>
        <h3>SEO Services</h3>
        <p>Strategy that drives organic growth</p>
      </div>

      <div class="sol-service-card v2-reveal v2-delay-1">
        <div class="sol-service-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="#448CCB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
        </div>
        <h3>Content Optimization</h3>
        <p>Refresh and improve existing content</p>
      </div>

      <div class="sol-service-card v2-reveal v2-delay-2">
        <div class="sol-service-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="#00BFF3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
        </div>
        <h3>Design Services</h3>
        <p>Visual content that stands out</p>
      </div>

      <div class="sol-service-card v2-reveal v2-delay-3">
        <div class="sol-service-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="#8560A8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
        </div>
        <h3>Content at Scale</h3>
        <p>Volume production, zero compromise</p>
      </div>
    </div>
  </div>

  <div class="v2-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none">
      <polygon points="0,60 1440,0 1440,60" fill="#8560A8"/>
    </svg>
  </div>
</section>


<!-- ========================================
     4. CTA
     ======================================== -->
<section class="v2-section sol-cta" aria-label="Call to Action">
  <div class="v2-container">
    <h2 class="v2-reveal">Let&rsquo;s Talk</h2>
    <p class="v2-reveal v2-delay-1">Ready to scale your content? Tell us about your project and we&rsquo;ll show you how Stretch can help.</p>
    <a href="/contact-stretch-creative/" class="v2-btn-primary v2-reveal v2-delay-2">Contact Us &rarr;</a>
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

  /* ---------- 3D TILT ON SOLUTION CARDS ---------- */
  var isTouchDevice = 'ontouchstart' in window || navigator.maxTouchPoints > 0;
  var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  if (!isTouchDevice && !reducedMotion) {
    var tiltCards = document.querySelectorAll('.sol-card');
    tiltCards.forEach(function(card) {
      card.style.transformStyle = 'preserve-3d';
      card.addEventListener('mousemove', function(e) {
        var rect = card.getBoundingClientRect();
        var cx = rect.left + rect.width / 2;
        var cy = rect.top + rect.height / 2;
        var dx = (e.clientX - cx) / (rect.width / 2);
        var dy = (e.clientY - cy) / (rect.height / 2);
        card.style.transform = 'perspective(800px) rotateY(' + (dx * 4) + 'deg) rotateX(' + (-dy * 4) + 'deg) translateY(-8px)';
        card.style.transition = 'box-shadow 0.5s ease';
      });
      card.addEventListener('mouseleave', function() {
        card.style.transform = '';
        card.style.transition = 'transform 0.5s cubic-bezier(0.16,1,0.3,1), box-shadow 0.5s ease';
      });
    });
  }
})();
</script>

<?php get_footer(); ?>
