<?php
/**
 * Template Name: Home
 * Premium redesign (Phase 1) — spec docs/superpowers/specs/2026-07-10-sitewide-premium-redesign-design.md
 */
get_header();
get_template_part('template-parts/premium-fx');
$stretch_page_images = (array) get_option('stretch_page_images', []);
?>
<style>
html, body { overflow-x: hidden; }
.admin-bar .site-nav { top: 32px; }
@media (max-width: 782px) { .admin-bar .site-nav { top: 46px; } }

/* HERO */
.home-hero { min-height: 92vh; padding: 180px 0 140px; }
.home-hero-content { position: relative; z-index: 2; text-align: center; max-width: 860px; margin: 0 auto; }
.home-hero-content h1 { font-family: 'Poppins', sans-serif; font-size: clamp(38px, 5vw, 64px); font-weight: 600; line-height: 1.08; color: #fff; margin: 0 0 26px; letter-spacing: -1.5px; }
.home-hero-content .home-subtitle { font-family: 'Assistant', sans-serif; font-size: 20px; font-weight: 300; line-height: 1.7; color: rgba(255,255,255,0.72); max-width: 640px; margin: 0 auto 42px; }

/* SERVICES */
.home-services { background: linear-gradient(180deg, #fff 0%, #f9f9fb 100%); padding: 110px 0 120px; position: relative; }
.home-services-heading { text-align: center; max-width: 640px; margin: 0 auto 64px; }
.home-services-heading h2, .home-industries-heading h2, .home-trust-heading h2 { font-family: 'Poppins', sans-serif; font-size: clamp(30px, 3.6vw, 44px); font-weight: 600; color: #1a1f2e; margin: 0; letter-spacing: -0.5px; line-height: 1.15; }
.home-services-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 26px; }
.home-svc-card { position: relative; background: #fff; border: 1px solid #eceef3; border-radius: 16px; padding: 40px 34px 34px; text-decoration: none; display: flex; flex-direction: column; overflow: hidden; box-shadow: 0 6px 24px rgba(26,31,46,0.05); transition: transform 0.5s cubic-bezier(0.16,1,0.3,1), box-shadow 0.5s ease, border-color 0.4s ease; }
.home-svc-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, var(--svc-start), var(--svc-end)); transform: scaleX(0); transform-origin: left; transition: transform 0.5s cubic-bezier(0.16,1,0.3,1); }
.home-svc-card:hover { transform: translateY(-8px); box-shadow: 0 20px 50px rgba(26,31,46,0.12); border-color: transparent; }
.home-svc-card:hover::before { transform: scaleX(1); }
.home-svc-num { font-family: 'Montserrat', sans-serif; font-size: 12px; font-weight: 600; letter-spacing: 2px; color: #767676; margin-bottom: 22px; transition: color 0.4s ease; }
.home-svc-card:hover .home-svc-num { color: var(--svc-end); }
.home-svc-icon { width: 58px; height: 58px; border-radius: 14px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, var(--svc-icon-bg), var(--svc-icon-bg-end)); margin-bottom: 24px; transition: transform 0.5s cubic-bezier(0.16,1,0.3,1); }
.home-svc-icon svg { width: 26px; height: 26px; }
.home-svc-card:hover .home-svc-icon { transform: scale(1.08) rotate(-4deg); }
.home-svc-card h3 { font-family: 'Poppins', sans-serif; font-size: 20px; font-weight: 600; color: #1a1f2e; margin: 0 0 14px; line-height: 1.25; }
.home-svc-card p { font-family: 'Assistant', sans-serif; font-size: 15.5px; line-height: 1.65; color: #5a6275; margin: 0 0 24px; flex: 1; }
.home-svc-link { font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 500; color: #8560A8; display: inline-flex; align-items: center; gap: 8px; transition: gap 0.3s ease, color 0.3s ease; }
.home-svc-card:hover .home-svc-link { gap: 14px; color: #5674B9; }
.home-svc-card--addon { border: 1.5px dashed #d5d9e4; background: transparent; box-shadow: none; }
.home-svc-card--addon:hover { box-shadow: 0 12px 32px rgba(26,31,46,0.07); }
.home-addon-list { list-style: none; margin: 0; padding: 0; }
.home-addon-list li { font-family: 'Assistant', sans-serif; font-size: 16px; color: #5a6275; padding: 10px 0 10px 30px; position: relative; border-bottom: 1px solid #eceef3; }
.home-addon-list li:last-child { border-bottom: none; }
.home-addon-list li::before { content: '+'; position: absolute; left: 4px; top: 8px; color: #00BFF3; font-weight: 600; font-size: 18px; }

/* MID CTA */
.home-midcta { background: #f9f9fb; padding: 30px 0 110px; }
.home-midcta .pfx-gradient-card { max-width: 880px; margin: 0 auto; }
.home-midcta h2 { font-family: 'Poppins', sans-serif; font-size: clamp(26px, 3vw, 36px); font-weight: 600; color: #1a1f2e; margin: 0 0 14px; letter-spacing: -0.5px; }
.home-midcta p { font-family: 'Assistant', sans-serif; font-size: 18px; color: #5a6275; margin: 0 0 32px; line-height: 1.6; }

/* WHO WE SERVE */
.home-industries { background: #f9f9fb; padding: 0 0 120px; position: relative; }
.home-industries-heading { text-align: center; max-width: 640px; margin: 0 auto 64px; }
.home-ind-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; }
.home-ind-card { background: #fff; border-radius: 18px; overflow: hidden; box-shadow: 0 8px 30px rgba(26,31,46,0.07); transition: transform 0.5s cubic-bezier(0.16,1,0.3,1), box-shadow 0.5s ease; display: flex; flex-direction: column; }
.home-ind-card:hover { box-shadow: 0 24px 60px rgba(26,31,46,0.14); }
.home-ind-image { position: relative; height: 220px; overflow: hidden; }
.home-ind-image img { width: 100%; height: 100%; object-fit: cover; transform: scale(1.06); transition: transform 6s ease; }
.home-ind-card:hover .home-ind-image img { transform: scale(1.14); }
.home-ind-tag { position: absolute; bottom: 16px; left: 20px; font-family: 'Montserrat', sans-serif; font-size: 12px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; color: #fff; background: rgba(26,31,46,0.82); padding: 8px 16px; border-radius: 30px; border: 1px solid rgba(255,255,255,0.15); }
.home-ind-content { padding: 34px 34px 38px; display: flex; flex-direction: column; flex: 1; }
.home-ind-title { font-family: 'Poppins', sans-serif; font-size: 20px; font-weight: 600; color: #1a1f2e; line-height: 1.35; margin: 0 0 14px; }
.home-ind-desc { font-family: 'Assistant', sans-serif; font-size: 15.5px; line-height: 1.65; color: #5a6275; margin: 0 0 20px; }
.home-ind-list { list-style: none; margin: 0 0 26px; padding: 0; }
.home-ind-list li { font-family: 'Assistant', sans-serif; font-size: 15px; color: #3a4256; padding: 7px 0 7px 28px; position: relative; }
.home-ind-list li::before { content: ''; position: absolute; left: 0; top: 9px; width: 16px; height: 16px; border-radius: 50%; background: linear-gradient(135deg, rgba(133,96,168,0.15), rgba(0,191,243,0.15)); background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='%238560A8' stroke-width='3.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='20 6 9 17 4 12'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: center; }
.home-ind-link { font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 500; color: #8560A8; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; margin-top: auto; transition: gap 0.3s ease, color 0.3s ease; }
.home-ind-link:hover { gap: 14px; color: #5674B9; }
.home-ind-link svg { transition: transform 0.3s ease; }
.home-ind-link:hover svg { transform: translateX(3px); }

/* WHY TRUST (dark) */
.home-trust { background: linear-gradient(170deg, #1a1f2e 0%, #252C3A 55%, #1e2333 100%); padding: 120px 0 130px; position: relative; overflow: hidden; }
.home-trust::before { content: ''; position: absolute; top: -20%; right: -10%; width: 60%; height: 80%; background: radial-gradient(ellipse at center, rgba(133,96,168,0.08) 0%, transparent 70%); pointer-events: none; }
.home-trust-heading { text-align: center; max-width: 680px; margin: 0 auto 64px; position: relative; z-index: 1; }
.home-trust-heading h2 { color: #fff; }
.home-trust-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; position: relative; z-index: 1; }
.home-trust-card { position: relative; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.09); border-radius: 16px; padding: 38px 34px; overflow: hidden; transition: background 0.4s ease, border-color 0.4s ease, transform 0.5s cubic-bezier(0.16,1,0.3,1); }
.home-trust-card::before { content: ''; position: absolute; top: 0; left: 0; bottom: 0; width: 3px; background: linear-gradient(180deg, var(--prop-start), var(--prop-end)); transform: scaleY(0); transform-origin: top; transition: transform 0.5s cubic-bezier(0.16,1,0.3,1); }
.home-trust-card:hover { background: rgba(255,255,255,0.07); border-color: rgba(255,255,255,0.16); }
.home-trust-card:hover::before { transform: scaleY(1); }
.home-trust-card--wide { grid-column: 1 / -1; }
.home-trust-card h3 { font-family: 'Poppins', sans-serif; font-size: 20px; font-weight: 600; color: #fff; margin: 0 0 12px; }
.home-trust-card p { font-family: 'Assistant', sans-serif; font-size: 16px; line-height: 1.7; color: #b9c2d4; margin: 0; }
.home-trust-cta { text-align: center; margin-top: 52px; position: relative; z-index: 1; }

/* FINAL CTA */
.home-cta-full { position: relative; overflow: hidden; background: linear-gradient(170deg, #8560A8, #3d2d66 30%, #252C3A 70%, #1a1f2e); padding: 140px 0; text-align: center; }
.home-cta-full::before { content: ''; position: absolute; top: 30%; left: 50%; transform: translate(-50%, -50%); width: 800px; height: 800px; background: radial-gradient(circle, rgba(0,191,243,0.08), transparent 70%); pointer-events: none; }
.home-cta-shape { position: absolute; border-radius: 50%; opacity: 0.08; animation: home-ctaFloat 12s ease-in-out infinite alternate; pointer-events: none; }
.home-cta-shape-1 { width: 200px; height: 200px; top: 15%; left: 10%; background: radial-gradient(circle, #00BFF3, transparent); }
.home-cta-shape-2 { width: 300px; height: 300px; bottom: 10%; right: 15%; background: radial-gradient(circle, #8560A8, transparent); animation-delay: -4s; }
.home-cta-shape-3 { width: 120px; height: 120px; top: 60%; left: 70%; background: radial-gradient(circle, #5674B9, transparent); animation-delay: -2s; border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; }
@keyframes home-ctaFloat { 0% { transform: translate(0,0) rotate(0deg); } 100% { transform: translate(30px,-30px) rotate(15deg); } }
.home-cta-content { position: relative; z-index: 1; max-width: 720px; margin: 0 auto; padding: 0 40px; }
.home-cta-content h2 { font-family: 'Poppins', sans-serif; font-size: clamp(36px, 5vw, 56px); font-weight: 600; color: #fff; margin: 0 0 22px; line-height: 1.15; }
.home-cta-content p { font-family: 'Assistant', sans-serif; font-size: 19px; font-weight: 300; color: rgba(255,255,255,0.65); margin: 0 0 44px; line-height: 1.7; }
.home-cta-buttons { display: flex; gap: 20px; justify-content: center; flex-wrap: wrap; }
@media (prefers-reduced-motion: reduce) { .home-cta-shape { animation: none !important; } .home-ind-image img { transition: none; } }
@media (max-width: 960px) { .home-services-grid { grid-template-columns: repeat(2, 1fr); } .home-ind-grid { grid-template-columns: 1fr; } .home-trust-grid { grid-template-columns: 1fr; } }
@media (max-width: 640px) { .home-services-grid { grid-template-columns: 1fr; } .home-hero { padding: 150px 0 110px; min-height: auto; } }
</style>

<!-- 1. HERO -->
<section class="pfx-hero home-hero" data-grain aria-label="Hero">
  <div class="pfx-hero-mesh"></div>
  <div class="pfx-hero-grid"></div>
  <div class="pfx-container">
    <div class="home-hero-content">
      <span class="pfx-overline pfx-reveal pfx-delay-1">Stretch Creative</span>
      <h1 class="pfx-reveal pfx-delay-2">Content Solutions for <span class="gradient-text">Modern Search &amp; Discoverability</span></h1>
      <p class="home-subtitle pfx-reveal pfx-delay-3">Rank smarter, not harder. Stretch Creative maximizes your marketing budget with SEO, AEO, and content services that fit your needs&mdash;nothing more, nothing less.</p>
      <a href="/contact-stretch-creative/" class="pfx-btn-primary pfx-reveal pfx-delay-4"><span>Schedule a Discovery Call &rarr;</span></a>
    </div>
  </div>
  <div class="pfx-angle-divider"><svg viewBox="0 0 1440 60" preserveAspectRatio="none" aria-hidden="true" focusable="false"><polygon points="0,60 1440,0 1440,60" fill="#ffffff"/></svg></div>
</section>

<!-- 2. TRUSTED BRANDS -->
<?php stretch_pfx_logo_marquee(); ?>

<!-- 3. STATS BAR (values render server-side; JS animates from 0 — AUD-026) -->
<section class="pfx-stats-bar" data-grain aria-label="Statistics" style="position:relative;">
  <div class="pfx-container">
    <div class="pfx-stats-inner">
      <div class="pfx-reveal"><div class="pfx-stat-number"><span class="pfx-count" data-target="200">200</span><span class="pfx-suffix">+</span></div><div class="pfx-stat-label">Creatives</div></div>
      <div class="pfx-reveal pfx-delay-1"><div class="pfx-stat-number"><span class="pfx-count" data-target="27">27</span><span class="pfx-suffix">+</span></div><div class="pfx-stat-label">Enterprise Brands</div></div>
      <div class="pfx-reveal pfx-delay-2"><div class="pfx-stat-number"><span class="pfx-count" data-target="500">500</span><span class="pfx-suffix">K+</span></div><div class="pfx-stat-label">Content Pieces Delivered</div></div>
      <div class="pfx-reveal pfx-delay-3"><div class="pfx-stat-number"><span class="pfx-count" data-target="98">98</span><span class="pfx-suffix">%</span></div><div class="pfx-stat-label">Client Retention</div></div>
    </div>
  </div>
  <div class="pfx-angle-divider"><svg viewBox="0 0 1440 60" preserveAspectRatio="none" aria-hidden="true" focusable="false"><polygon points="0,60 1440,0 1440,60" fill="#ffffff"/></svg></div>
</section>

<!-- 4. OUR SERVICES -->
<section class="home-services" data-grain aria-label="Our Services">
  <div class="pfx-container">
    <div class="home-services-heading">
      <span class="pfx-overline pfx-reveal">Our Services</span>
      <h2 class="pfx-reveal pfx-delay-1">Multiple services <span class="gradient-text">&times; one agency</span></h2>
    </div>

    <div class="home-services-grid">
      <a href="/seo_content_strategy_services/" class="home-svc-card pfx-tilt pfx-reveal pfx-delay-1" style="--svc-start:#8560A8;--svc-end:#5674B9;--svc-icon-bg:rgba(133,96,168,0.1);--svc-icon-bg-end:rgba(86,116,185,0.1);">
        <div class="home-svc-num">01</div>
        <div class="home-svc-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="#8560A8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
        </div>
        <h3>SEO/AEO Strategy &amp; Services</h3>
        <p>Search has changed, but people still need answers. We help businesses earn visibility across traditional search, AI-generated results, and emerging discovery platforms with content and site experiences that are useful, accurate, and easy to understand.</p>
        <span class="home-svc-link">Learn more &rarr;</span>
      </a>

      <a href="/services/bespoke-content-experience/" class="home-svc-card pfx-tilt pfx-reveal pfx-delay-2" style="--svc-start:#5674B9;--svc-end:#448CCB;--svc-icon-bg:rgba(86,116,185,0.1);--svc-icon-bg-end:rgba(68,140,203,0.1);">
        <div class="home-svc-num">02</div>
        <div class="home-svc-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="#5674B9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
        </div>
        <h3>Interactive Content Marketing</h3>
        <p>Calculators, assessments, maps, quizzes, and other interactive tools give visitors a reason to engage instead of bounce. We build bespoke content experiences that answer questions, surface insights, recommend products, and provide your visitors with value&mdash;and fun.</p>
        <span class="home-svc-link">Learn more &rarr;</span>
      </a>

      <a href="/content-writing-at-any-scale/" class="home-svc-card pfx-tilt pfx-reveal pfx-delay-3" style="--svc-start:#448CCB;--svc-end:#00BFF3;--svc-icon-bg:rgba(68,140,203,0.1);--svc-icon-bg-end:rgba(0,191,243,0.1);">
        <div class="home-svc-num">03</div>
        <div class="home-svc-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="#448CCB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"/><polygon points="18 2 22 6 12 16 8 16 8 12 18 2"/></svg>
        </div>
        <h3>Content Writing</h3>
        <p>Our hand-picked roster of experienced content writers can take on whatever written assets you need to inform, persuade, and support your customers through the buying journey. Every piece we produce is written by humans for real people, fully optimized and written with a clear purpose.</p>
        <span class="home-svc-link">Learn more &rarr;</span>
      </a>

      <a href="/graphic_design_services/" class="home-svc-card pfx-tilt pfx-reveal pfx-delay-4" style="--svc-start:#00BFF3;--svc-end:#5674B9;--svc-icon-bg:rgba(0,191,243,0.1);--svc-icon-bg-end:rgba(86,116,185,0.1);">
        <div class="home-svc-num">04</div>
        <div class="home-svc-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="#00BFF3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="13.5" cy="6.5" r=".5" fill="#00BFF3"/><circle cx="17.5" cy="10.5" r=".5" fill="#00BFF3"/><circle cx="8.5" cy="7.5" r=".5" fill="#00BFF3"/><circle cx="6.5" cy="12.5" r=".5" fill="#00BFF3"/><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/></svg>
        </div>
        <h3>Visual Content &amp; Design</h3>
        <p>Strong visuals make complex information easier to understand. Our in-house, human creatives produce high-quality graphics, infographics, digital assets, photography, and video productions that clarify key points, strengthen messaging and branding, and help your content perform across multiple channels.</p>
        <span class="home-svc-link">Learn more &rarr;</span>
      </a>

      <a href="/paid-advertising/" class="home-svc-card pfx-tilt pfx-reveal pfx-delay-5" style="--svc-start:#8560A8;--svc-end:#448CCB;--svc-icon-bg:rgba(133,96,168,0.1);--svc-icon-bg-end:rgba(68,140,203,0.1);">
        <div class="home-svc-num">05</div>
        <div class="home-svc-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="#8560A8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
        </div>
        <h3>Paid Advertising</h3>
        <p>Traffic alone doesn&rsquo;t pay the bills. Our paid advertising team creates paid campaigns that connect with the right audiences, align with your business goals, and support measurable outcomes, from lead generation to product sales.</p>
        <span class="home-svc-link">Learn more &rarr;</span>
      </a>

      <div class="home-svc-card home-svc-card--addon pfx-tilt pfx-reveal pfx-delay-6" style="--svc-start:#5674B9;--svc-end:#00BFF3;--svc-icon-bg:rgba(86,116,185,0.1);--svc-icon-bg-end:rgba(0,191,243,0.1);">
        <div class="home-svc-num">06</div>
        <div class="home-svc-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="#5674B9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19.439 7.85c-.049.322.059.648.289.878l1.568 1.568c.47.47.706 1.087.706 1.704s-.235 1.233-.706 1.704l-1.611 1.611a.98.98 0 0 1-.837.276c-.47-.07-.802-.48-.968-.925a2.501 2.501 0 1 0-3.214 3.214c.446.166.855.497.925.968a.979.979 0 0 1-.276.837l-1.61 1.61a2.404 2.404 0 0 1-1.705.707 2.402 2.402 0 0 1-1.704-.706l-1.568-1.568a1.026 1.026 0 0 0-.877-.29c-.493.074-.84.504-1.02.968a2.5 2.5 0 1 1-3.237-3.237c.464-.18.894-.527.967-1.02a1.026 1.026 0 0 0-.289-.877l-1.568-1.568A2.402 2.402 0 0 1 1.998 12c0-.617.236-1.234.706-1.704L4.23 8.77c.24-.24.581-.353.917-.303.515.077.877.528 1.073 1.01a2.5 2.5 0 1 0 3.259-3.259c-.482-.196-.933-.558-1.01-1.073-.05-.336.062-.676.303-.917l1.525-1.525A2.402 2.402 0 0 1 12 1.998c.617 0 1.234.236 1.704.706l1.568 1.568c.23.23.556.338.877.29.493-.074.84-.504 1.02-.968a2.5 2.5 0 1 1 3.237 3.237c-.464.18-.894.527-.967 1.02Z"/></svg>
        </div>
        <h3>Add-On Services</h3>
        <ul class="home-addon-list">
          <li>Budget management</li>
          <li>CMS loading</li>
        </ul>
      </div>
    </div>
  </div>

  <div class="pfx-angle-divider"><svg viewBox="0 0 1440 60" preserveAspectRatio="none" aria-hidden="true" focusable="false"><polygon points="0,60 1440,0 1440,60" fill="#f9f9fb"/></svg></div>
</section>

<!-- 5. MID-PAGE CTA (approved copy) -->
<section class="home-midcta" aria-label="Get Started">
  <div class="pfx-container">
    <div class="pfx-gradient-card pfx-reveal">
      <div class="pfx-gradient-card-inner">
        <h2>Let&rsquo;s find the right fit.</h2>
        <p>Every engagement starts with a conversation about your goals, your audience, and your budget.</p>
        <a href="/contact-stretch-creative/" class="pfx-btn-primary"><span>Schedule a Discovery Call &rarr;</span></a>
      </div>
    </div>
  </div>
</section>

<!-- 6. WHO WE SERVE -->
<section class="home-industries" aria-label="Who We Serve">
  <div class="pfx-container">
    <div class="home-industries-heading">
      <span class="pfx-overline pfx-reveal">Who We Serve</span>
      <h2 class="pfx-reveal pfx-delay-1">Built for <span class="gradient-text">your industry</span></h2>
    </div>

    <div class="home-ind-grid">
      <div class="home-ind-card pfx-tilt pfx-reveal pfx-delay-1">
        <div class="home-ind-image">
          <?php
          // AUD-014: serve the local attachment (with srcset) when seeded.
          $sol_img = wp_get_attachment_image((int) ($stretch_page_images['home_ecommerce'] ?? 0), 'large', false, ['loading' => 'lazy', 'alt' => 'Ecommerce']);
          if ($sol_img) : echo $sol_img; else : ?>
          <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=600&h=400&fit=crop" alt="Ecommerce" loading="lazy">
          <?php endif; ?>
          <div class="home-ind-tag">Ecommerce</div>
        </div>
        <div class="home-ind-content">
          <h3 class="home-ind-title">SEO and content services for every stage of the buying journey.</h3>
          <p class="home-ind-desc">We help DTC brands and retailers attract qualified shoppers and improve product discovery with expert SEO services, informative product detail and category pages, interactive content experiences, and engaging blogs that build your brand and help your customers find the products they need.</p>
          <ul class="home-ind-list">
            <li>Product Detail Pages &amp; Category Page Content</li>
            <li>SEO &amp; Product Discovery</li>
            <li>Creative Assets &amp; Visual Storytelling</li>
            <li>Buying Guides and Gift Guides</li>
          </ul>
          <a href="/industries/ecommerce/" class="home-ind-link">Learn More <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
        </div>
      </div>

      <div class="home-ind-card pfx-tilt pfx-reveal pfx-delay-2">
        <div class="home-ind-image">
          <?php
          $sol_img = wp_get_attachment_image((int) ($stretch_page_images['home_agencies'] ?? 0), 'large', false, ['loading' => 'lazy', 'alt' => 'Agencies and strategic partners']);
          if ($sol_img) : echo $sol_img; else : ?>
          <img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?w=600&h=400&fit=crop" alt="Agencies and strategic partners" loading="lazy">
          <?php endif; ?>
          <div class="home-ind-tag">Agencies &amp; Strategic Partners</div>
        </div>
        <div class="home-ind-content">
          <h3 class="home-ind-title">High-volume, white-labeled content for agencies and other partners.</h3>
          <p class="home-ind-desc">When demand exceeds capacity, Stretch Creative is ready to help with the expertise, talent, and production support to help your agency scale. We work as an extension of your team to produce high-quality, human-written content at any scale.</p>
          <ul class="home-ind-list">
            <li>White-Labeled SEO Content Production</li>
            <li>SEO &amp; Content Strategy</li>
            <li>Design &amp; Interactive Assets</li>
            <li>High-Volume Production</li>
          </ul>
          <a href="/industries/agencies/" class="home-ind-link">Learn More <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
        </div>
      </div>

      <div class="home-ind-card pfx-tilt pfx-reveal pfx-delay-3">
        <div class="home-ind-image">
          <?php
          $sol_img = wp_get_attachment_image((int) ($stretch_page_images['home_service_providers'] ?? 0), 'large', false, ['loading' => 'lazy', 'alt' => 'Local service providers']);
          if ($sol_img) : echo $sol_img; else : ?>
          <img src="https://images.unsplash.com/photo-1521791136064-7986c2920216?w=600&h=400&fit=crop" alt="Local service providers" loading="lazy">
          <?php endif; ?>
          <div class="home-ind-tag">Local Service Providers</div>
        </div>
        <div class="home-ind-content">
          <h3 class="home-ind-title">Get found locally, build trust, and turn searches into service calls.</h3>
          <p class="home-ind-desc">Your local service business or franchise needs to be visible where customers are searching&mdash;and persuasive when they click onto your site. Stretch Creative combines local SEO, service-focused content, and digital marketing strategies that will help your business earn trust and generate work orders.</p>
          <ul class="home-ind-list">
            <li>SEO for Local Search Visibility</li>
            <li>Service &amp; Geographic Landing Pages and Blogs</li>
            <li>Social Media &amp; Design</li>
            <li>Paid Advertising</li>
          </ul>
          <?php // AUD-036: interim target until the Local Service Providers industry page ships. ?>
          <a href="/contact-stretch-creative/" class="home-ind-link">Learn More <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
        </div>
      </div>

      <div class="home-ind-card pfx-tilt pfx-reveal pfx-delay-4">
        <div class="home-ind-image">
          <?php
          $sol_img = wp_get_attachment_image((int) ($stretch_page_images['home_saas'] ?? 0), 'large', false, ['loading' => 'lazy', 'alt' => 'SaaS and digital platforms']);
          if ($sol_img) : echo $sol_img; else : ?>
          <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=600&h=400&fit=crop" alt="SaaS and digital platforms" loading="lazy">
          <?php endif; ?>
          <div class="home-ind-tag">SaaS &amp; Digital Platforms</div>
        </div>
        <div class="home-ind-content">
          <h3 class="home-ind-title">Clear, accurate content for high-stakes buying decisions.</h3>
          <p class="home-ind-desc">Whether you&rsquo;re selling software or connecting users to services, your success depends on helping people make informed decisions, often involving serious topics like money, law, and health. Stretch Creative produces content that distills down complex ideas and offerings and answers all the right questions.</p>
          <ul class="home-ind-list">
            <li>Expert-Written or -Reviewed Content</li>
            <li>White Papers and Case Studies</li>
            <li>Graphic Design</li>
            <li>SEO Content Strategy</li>
          </ul>
          <?php // AUD-036: interim target until the SaaS industry page ships. ?>
          <a href="/contact-stretch-creative/" class="home-ind-link">Learn More <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- 7. WHY TRUST (dark) -->
<section class="home-trust" data-grain aria-label="Why Trust Stretch Creative">
  <div class="pfx-container">
    <div class="home-trust-heading">
      <span class="pfx-overline pfx-reveal">Why Stretch</span>
      <h2 class="pfx-reveal pfx-delay-1">Why Trust <span class="gradient-text">Stretch Creative?</span></h2>
    </div>

    <div class="home-trust-grid">
      <div class="home-trust-card pfx-tilt pfx-reveal pfx-delay-1" style="--prop-start:#8560A8;--prop-end:#5674B9;">
        <h3>All of the services you need under one roof</h3>
        <p>Content works better when the people creating it work together. With writers, designers, SEO specialists, videographers, and paid media experts under one roof, your campaigns stay aligned, your message remains consistent, and your projects move faster.</p>
      </div>

      <div class="home-trust-card pfx-tilt pfx-reveal pfx-delay-2" style="--prop-start:#5674B9;--prop-end:#448CCB;">
        <h3>We&rsquo;re an extension of your team</h3>
        <p>The best partnerships don&rsquo;t happen through support tickets and quarterly check-ins. Regularly scheduled touch-base calls and easy access to your Client Services Team and Managing Editor keep our partnership fresh and current. That makes it easy for us to pivot with you when big changes come down the pipeline, for better or worse.</p>
      </div>

      <div class="home-trust-card pfx-tilt pfx-reveal pfx-delay-3" style="--prop-start:#448CCB;--prop-end:#00BFF3;">
        <h3>Stay agile in the face of change</h3>
        <p>Search is evolving fast, and it&rsquo;s more important than ever to stay current on trends in content, SEO, and AI. We&rsquo;re on top of it at the agency level, and everything we produce is optimized using current SEO and AEO best practices.</p>
      </div>

      <div class="home-trust-card pfx-tilt pfx-reveal pfx-delay-4" style="--prop-start:#8560A8;--prop-end:#00BFF3;">
        <h3>Scale with ease</h3>
        <p>Need more content? Launching a new product? Expanding into a new market? Our processes make it easy to increase production, add new content types and services, and grow your marketing efforts without rebuilding your entire operation.</p>
      </div>

      <div class="home-trust-card home-trust-card--wide pfx-tilt pfx-reveal pfx-delay-5" style="--prop-start:#8560A8;--prop-end:#448CCB;">
        <h3>Human-created, editorially driven</h3>
        <p>We&rsquo;re not an AI-assisted content mill. Our writers, editors, and visual creatives are vetted, experienced freelancers who we hand-pick for every project. While we use AI to streamline operational workflows, we never send our clients AI-written content.</p>
      </div>
    </div>

    <div class="home-trust-cta pfx-reveal pfx-delay-2">
      <a href="/about-stretch-creative/" class="pfx-btn-primary"><span>Learn how we work &rarr;</span></a>
    </div>
  </div>
</section>

<!-- 8. FINAL CTA -->
<section class="home-cta-full" data-grain aria-label="Call to Action">
  <div class="home-cta-shape home-cta-shape-1"></div>
  <div class="home-cta-shape home-cta-shape-2"></div>
  <div class="home-cta-shape home-cta-shape-3"></div>
  <div class="home-cta-content">
    <h2 class="pfx-reveal">Let&rsquo;s Talk</h2>
    <p class="pfx-reveal pfx-delay-1">Tell us about your project and we&rsquo;ll show you how Stretch Creative can help.</p>
    <div class="home-cta-buttons pfx-reveal pfx-delay-2">
      <a href="/contact-stretch-creative/" class="pfx-btn-primary"><span>Contact Us &rarr;</span></a>
      <a href="/our-work/" class="pfx-btn-outline">See Our Work</a>
    </div>
  </div>
</section>

<?php get_footer(); ?>
