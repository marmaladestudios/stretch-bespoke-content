<?php
/**
 * Template Name: Contact Us
 */
get_header();
?>

<style>
/* ========================================
   CONTACT US — PREMIUM TEMPLATE
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

.v2-angle-divider {
  position: absolute; bottom: -1px; left: 0; right: 0;
  z-index: 2; pointer-events: none; line-height: 0;
}
.v2-angle-divider svg { display: block; width: 100%; height: 60px; }

/* ========================================
   1. HERO
   ======================================== */
.contact-hero {
  position: relative;
  min-height: 50vh;
  display: flex;
  align-items: center;
  background: linear-gradient(170deg, #1a1f2e 0%, #252C3A 40%, #1e2333 100%);
  overflow: hidden;
  padding: 140px 0 90px;
}
.contact-hero::before {
  content: '';
  position: absolute;
  top: -50%; right: -20%;
  width: 80%; height: 150%;
  background: radial-gradient(ellipse at center, rgba(86,116,185,0.08) 0%, transparent 70%);
  pointer-events: none;
}
.contact-hero::after {
  content: '';
  position: absolute;
  bottom: -30%; left: -10%;
  width: 60%; height: 80%;
  background: radial-gradient(ellipse at center, rgba(133,96,168,0.06) 0%, transparent 70%);
  pointer-events: none;
}
.contact-hero-shapes {
  position: absolute; inset: 0; pointer-events: none; z-index: 1;
}
.contact-shape {
  position: absolute; border-radius: 50%; opacity: 0.12;
}
.contact-shape-1 { width: 250px; height: 250px; top: 15%; left: 8%; background: radial-gradient(circle, #8560A8, transparent); }
.contact-shape-2 { width: 180px; height: 180px; top: 50%; right: 15%; background: radial-gradient(circle, #00BFF3, transparent); }
.contact-shape-3 { width: 120px; height: 120px; bottom: 10%; left: 40%; background: radial-gradient(circle, #5674B9, transparent); border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; }

.contact-hero-content {
  position: relative; z-index: 2;
  text-align: center;
  max-width: 700px; margin: 0 auto;
}
.contact-hero-content .v2-overline {
  font-family: 'Montserrat', sans-serif;
  font-size: 13px; font-weight: 400;
  letter-spacing: 3px; text-transform: uppercase;
  color: #00BFF3; margin-bottom: 20px; display: block;
}
.contact-hero-content h1 {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(36px, 4.5vw, 58px);
  font-weight: 600; line-height: 1.1;
  color: #fff; margin: 0 0 24px; letter-spacing: -1px;
}
.contact-hero-content .v2-subtitle {
  font-family: 'Assistant', sans-serif;
  font-size: 19px; font-weight: 300; line-height: 1.7;
  color: rgba(255,255,255,0.7);
  max-width: 480px; margin: 0 auto;
}

/* ========================================
   2. CONTACT CONTENT
   ======================================== */
.contact-content {
  padding: 120px 0;
  background: #fff;
  position: relative;
}
.contact-inner {
  display: grid;
  grid-template-columns: 1fr 1.2fr;
  gap: 80px;
  align-items: flex-start;
}

/* Left: Info */
.contact-info h2 {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(28px, 3vw, 38px);
  font-weight: 600; color: #252C3A;
  margin: 0 0 32px; line-height: 1.2;
}
.contact-info-item {
  display: flex;
  gap: 16px;
  align-items: flex-start;
  margin-bottom: 28px;
}
.contact-info-icon {
  width: 44px; height: 44px; min-width: 44px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, rgba(133,96,168,0.08), rgba(0,191,243,0.08));
}
.contact-info-icon svg { width: 20px; height: 20px; }
.contact-info-item h3 {
  font-family: 'Poppins', sans-serif;
  font-size: 14px; font-weight: 600;
  color: #252C3A; margin: 0 0 4px;
}
.contact-info-item p,
.contact-info-item a {
  font-family: 'Assistant', sans-serif;
  font-size: 15px; font-weight: 300;
  color: #666; margin: 0;
  line-height: 1.6;
  text-decoration: none;
  transition: color 0.3s ease;
}
.contact-info-item a:hover { color: #8560A8; }

.contact-social {
  display: flex;
  gap: 12px;
  margin-top: 36px;
}
.contact-social a {
  width: 44px; height: 44px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f9f9fb;
  border: 1px solid rgba(0,0,0,0.04);
  transition: all 0.3s ease;
  text-decoration: none;
}
.contact-social a:hover {
  background: linear-gradient(135deg, #8560A8, #5674B9);
  border-color: transparent;
}
.contact-social a:hover svg { stroke: #fff; }
.contact-social a svg {
  width: 20px; height: 20px;
  stroke: #888;
  transition: stroke 0.3s ease;
}

/* Right: Form */
.contact-form-wrapper {
  background: #f9f9fb;
  border-radius: 16px;
  padding: 48px;
  border: 1px solid rgba(0,0,0,0.04);
}
.contact-form-wrapper h3 {
  font-family: 'Poppins', sans-serif;
  font-size: 22px; font-weight: 600;
  color: #252C3A; margin: 0 0 8px;
}
.contact-form-wrapper .form-subtitle {
  font-family: 'Assistant', sans-serif;
  font-size: 15px; color: #888;
  margin: 0 0 32px;
}
.contact-form { display: flex; flex-direction: column; gap: 20px; }
.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
}
.form-group { display: flex; flex-direction: column; }
.form-group label {
  font-family: 'Poppins', sans-serif;
  font-size: 12px; font-weight: 500;
  color: #555; margin-bottom: 8px;
  text-transform: uppercase;
  letter-spacing: 1px;
}
.form-group input,
.form-group textarea,
.form-group select {
  font-family: 'Assistant', sans-serif;
  font-size: 16px;
  color: #252C3A;
  background: #fff;
  border: 1px solid #e0e0e8;
  border-radius: 8px;
  padding: 14px 16px;
  transition: border-color 0.3s ease, box-shadow 0.3s ease;
  outline: none;
  -webkit-appearance: none;
}
.form-group input:focus,
.form-group textarea:focus,
.form-group select:focus {
  border-color: #8560A8;
  box-shadow: 0 0 0 3px rgba(133,96,168,0.1);
}
.form-group textarea { resize: vertical; min-height: 140px; }
.form-group input::placeholder,
.form-group textarea::placeholder {
  color: #bbb;
}
.form-submit {
  display: inline-block;
  font-family: 'Poppins', sans-serif;
  font-size: 15px; font-weight: 500;
  color: #fff;
  background: linear-gradient(135deg, #8560A8, #5674B9);
  padding: 16px 40px;
  border-radius: 6px;
  border: none;
  cursor: pointer;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  box-shadow: 0 4px 20px rgba(133,96,168,0.3);
  text-align: center;
  width: fit-content;
}
.form-submit:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 30px rgba(133,96,168,0.45);
}

/* ========================================
   3. MAP / LOCATION
   ======================================== */
.contact-map {
  padding: 100px 0;
  background: #f9f9fb;
  position: relative;
}
.contact-map-placeholder {
  max-width: 1200px;
  margin: 0 auto;
  height: 400px;
  background: linear-gradient(135deg, #1a1f2e, #252C3A);
  border-radius: 16px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  position: relative;
  overflow: hidden;
}
.contact-map-placeholder::before {
  content: '';
  position: absolute;
  inset: 0;
  background: radial-gradient(circle at 40% 50%, rgba(0,191,243,0.06), transparent 60%),
              radial-gradient(circle at 70% 30%, rgba(133,96,168,0.06), transparent 60%);
}
/* Dot grid pattern */
.contact-map-placeholder::after {
  content: '';
  position: absolute;
  inset: 0;
  background-image: radial-gradient(rgba(255,255,255,0.04) 1px, transparent 1px);
  background-size: 24px 24px;
}
.map-pin {
  width: 48px; height: 48px;
  background: linear-gradient(135deg, #8560A8, #00BFF3);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 20px;
  position: relative;
  z-index: 1;
  box-shadow: 0 0 40px rgba(0,191,243,0.3);
  animation: mapPulse 3s ease-in-out infinite;
}
@keyframes mapPulse {
  0%, 100% { box-shadow: 0 0 20px rgba(0,191,243,0.3); }
  50% { box-shadow: 0 0 40px rgba(0,191,243,0.5), 0 0 80px rgba(133,96,168,0.2); }
}
.map-pin svg { width: 24px; height: 24px; }
.map-city {
  font-family: 'Poppins', sans-serif;
  font-size: 28px; font-weight: 600;
  color: #fff; margin-bottom: 8px;
  position: relative; z-index: 1;
}
.map-coords {
  font-family: 'Montserrat', sans-serif;
  font-size: 12px; font-weight: 400;
  letter-spacing: 3px; color: rgba(255,255,255,0.35);
  position: relative; z-index: 1;
}

/* ========================================
   4. CTA
   ======================================== */
.contact-cta {
  padding: 100px 0;
  background: #252C3A;
  text-align: center;
  position: relative;
  overflow: hidden;
}
.contact-cta::before {
  content: '';
  position: absolute;
  top: 50%; left: 50%;
  transform: translate(-50%, -50%);
  width: 600px; height: 600px;
  background: radial-gradient(circle, rgba(0,191,243,0.04), transparent 70%);
  pointer-events: none;
}
.contact-cta h2 {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(28px, 3.5vw, 42px);
  font-weight: 600; color: #fff;
  margin: 0 0 16px; position: relative;
}
.contact-cta p {
  font-family: 'Assistant', sans-serif;
  font-size: 18px; font-weight: 300;
  color: rgba(255,255,255,0.5);
  margin-bottom: 36px; position: relative;
}
.contact-cta .v2-btn-primary {
  display: inline-block;
  font-family: 'Poppins', sans-serif;
  font-size: 15px; font-weight: 500;
  color: #fff;
  background: linear-gradient(135deg, #8560A8, #5674B9);
  padding: 16px 40px; border-radius: 6px;
  text-decoration: none;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  box-shadow: 0 4px 20px rgba(133,96,168,0.3);
  position: relative;
}
.contact-cta .v2-btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 30px rgba(133,96,168,0.45);
}

/* ========================================
   RESPONSIVE
   ======================================== */
@media (max-width: 960px) {
  .contact-inner {
    grid-template-columns: 1fr;
    gap: 50px;
  }
}
@media (max-width: 768px) {
  .v2-container { padding: 0 24px; }
  .contact-hero { padding: 100px 0 70px; }
  .contact-hero-content h1 { font-size: 34px; }
  .contact-content { padding: 80px 0; }
  .contact-form-wrapper { padding: 32px 24px; }
  .form-row { grid-template-columns: 1fr; }
  .contact-map { padding: 60px 0; }
  .contact-map-placeholder { height: 300px; margin: 0 24px; }
  .contact-cta { padding: 70px 0; }
}
@media (max-width: 480px) {
  .v2-container { padding: 0 16px; }
  .contact-map-placeholder { margin: 0 16px; }
}
</style>


<!-- ========================================
     1. HERO
     ======================================== -->
<section class="v2-section contact-hero" aria-label="Hero">
  <div class="contact-hero-shapes">
    <div class="contact-shape contact-shape-1"></div>
    <div class="contact-shape contact-shape-2"></div>
    <div class="contact-shape contact-shape-3"></div>
  </div>

  <div class="v2-container">
    <div class="contact-hero-content">
      <span class="v2-overline v2-reveal v2-delay-1">Contact</span>
      <h1 class="v2-reveal v2-delay-2">We&rsquo;re <span class="gradient-text">Here to Help</span></h1>
      <p class="v2-subtitle v2-reveal v2-delay-3">Let&rsquo;s talk about your content needs. We&rsquo;d love to hear from you.</p>
    </div>
  </div>

  <div class="v2-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none">
      <polygon points="0,60 1440,0 1440,60" fill="#ffffff"/>
    </svg>
  </div>
</section>


<!-- ========================================
     2. CONTACT CONTENT
     ======================================== -->
<section class="v2-section contact-content" aria-label="Contact Information">
  <div class="v2-container">
    <div class="contact-inner">
      <div class="contact-info v2-reveal-left">
        <h2>Get In Touch</h2>

        <div class="contact-info-item">
          <div class="contact-info-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="#8560A8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
          </div>
          <div>
            <h3>Address</h3>
            <p>132 - 328 Wale Rd<br>Victoria, BC, Canada<br>V9B 0J8</p>
          </div>
        </div>

        <div class="contact-info-item">
          <div class="contact-info-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="#5674B9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
          </div>
          <div>
            <h3>Phone</h3>
            <a href="tel:+12508589644">+1 250 858 9644</a>
          </div>
        </div>

        <div class="contact-info-item">
          <div class="contact-info-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="#448CCB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
          </div>
          <div>
            <h3>Email</h3>
            <a href="mailto:hello@stretchcreative.com">hello@stretchcreative.com</a>
          </div>
        </div>

        <div class="contact-social">
          <a href="https://www.linkedin.com/company/stretch-creative/" target="_blank" rel="noopener" aria-label="LinkedIn">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
          </a>
        </div>
      </div>

      <div class="contact-form-wrapper v2-reveal-right">
        <h3>Send Us a Message</h3>
        <p class="form-subtitle">Fill out the form below and we&rsquo;ll get back to you within one business day.</p>

        <form class="contact-form" onsubmit="return false;">
          <div class="form-row">
            <div class="form-group">
              <label for="contact-name">Your Name</label>
              <input type="text" id="contact-name" name="name" placeholder="Jane Smith" autocomplete="name">
            </div>
            <div class="form-group">
              <label for="contact-email">Email Address</label>
              <input type="email" id="contact-email" name="email" placeholder="jane@company.com" autocomplete="email">
            </div>
          </div>

          <div class="form-group">
            <label for="contact-company">Company</label>
            <input type="text" id="contact-company" name="company" placeholder="Company name" autocomplete="organization">
          </div>

          <div class="form-group">
            <label for="contact-message">Message</label>
            <textarea id="contact-message" name="message" placeholder="Tell us about your project and content needs..."></textarea>
          </div>

          <button type="submit" class="form-submit">Send Message &rarr;</button>
        </form>
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
     3. MAP / LOCATION
     ======================================== -->
<section class="v2-section contact-map" aria-label="Location">
  <div class="contact-map-placeholder v2-reveal">
    <div class="map-pin">
      <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
    </div>
    <div class="map-city">Victoria, BC</div>
    <div class="map-coords">48.4284&deg; N &middot; 123.3656&deg; W</div>
  </div>
</section>


<!-- ========================================
     4. CTA
     ======================================== -->
<section class="v2-section contact-cta" aria-label="Call to Action">
  <div class="v2-container">
    <h2 class="v2-reveal">Ready to scale your content?</h2>
    <p class="v2-reveal v2-delay-1">Let&rsquo;s build something great together.</p>
    <a href="/stretch-creative-solutions/" class="v2-btn-primary v2-reveal v2-delay-2">Explore Solutions &rarr;</a>
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
})();
</script>

<?php get_footer(); ?>
