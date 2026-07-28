<?php
/**
 * Template Name: Home
 * Premium redesign (Phase 1) — recreates design_handoff_stretch_pages/Home.dc.html
 * spec docs/superpowers/specs/2026-07-10-sitewide-premium-redesign-design.md
 */
get_header();
get_template_part('template-parts/premium-fx');
$stretch_page_images = (array) get_option('stretch_page_images', []);

/* Neutral, request-free placeholder for un-seeded Who-We-Serve imagery. */
function stretch_home_serve_media($stretch_page_images, $key, $alt) {
    $img = wp_get_attachment_image((int) ($stretch_page_images[$key] ?? 0), 'large', false, [
        'loading' => 'lazy', 'alt' => $alt, 'class' => 'home-serve-img',
    ]);
    if ($img) { return $img; }
    return '<div class="home-serve-img home-serve-img--empty" role="img" aria-label="' . esc_attr($alt) . '"></div>';
}
?>
<style>
html, body { overflow-x: hidden; }

/* ===== HERO ===== */
.home-hero { min-height: 92vh; }
.home-hero-inner { position: relative; z-index: 2; max-width: 1200px; width: 100%; margin: 0 auto; padding: 150px clamp(24px, 4vw, 40px) 120px; display: flex; flex-direction: column; align-items: center; text-align: center; }
.home-hero-title { font-family: 'Poppins', sans-serif; font-weight: 600; font-size: clamp(38px, 5vw, 64px); letter-spacing: -1.5px; line-height: 1.1; color: #fff; margin: 0 0 24px; max-width: 920px; }
.home-hero-lede { font-family: 'Assistant', sans-serif; font-weight: 300; font-size: clamp(17px, 1.5vw, 20px); line-height: 1.7; color: rgba(255,255,255,0.85); max-width: 660px; margin: 0 0 40px; }
.home-hero-wedge { position: absolute; left: 0; right: 0; bottom: -1px; height: 60px; background: #fff; clip-path: polygon(0 100%, 100% 0, 100% 100%); z-index: 1; pointer-events: none; }

/* ===== WEDGE DIVIDERS (standalone) =====
   Systemic seam fix (#14): container bg = PREVIOUS section color (set inline),
   clipped triangle = NEXT section color (inline) and extends 1px past BOTH
   edges so no anti-aliased hairline shows; container overlaps the next
   section by 1px (margin-bottom) and the previous section by 1px (margin-top). */
.home-wedge { height: 60px; position: relative; line-height: 0; margin-top: -1px; margin-bottom: -1px; }
.home-wedge > div { position: absolute; left: 0; right: 0; top: -1px; bottom: -1px; }

/* ===== SECTION HEADERS ===== */
.home-head { text-align: center; max-width: 720px; margin: 0 auto 60px; }
.home-h2 { font-family: 'Poppins', sans-serif; font-weight: 600; font-size: clamp(30px, 3.4vw, 44px); letter-spacing: -1px; line-height: 1.15; margin: 0; }

/* ===== OUR SERVICES ===== */
.home-services { background: #fff; padding: 100px 0 60px; }
.home-services .home-h2 { color: #1a1f2e; }
.home-services-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 26px; }
.home-svc-card { position: relative; display: block; background: #fff; border: 1px solid #e9e9f1; border-radius: 14px; padding: 34px 30px 30px; overflow: hidden; text-decoration: none; transition: transform 0.35s ease, box-shadow 0.35s ease; }
a.home-svc-card:hover { transform: translateY(-6px); box-shadow: 0 22px 44px rgba(26,31,46,0.10); }
.home-svc-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 22px; }
.home-svc-icon { width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, rgba(133,96,168,0.12), rgba(0,191,243,0.12)); display: flex; align-items: center; justify-content: center; }
.home-svc-num { font-family: 'Montserrat', sans-serif; font-size: 13px; font-weight: 600; letter-spacing: 2px; color: #c3c8d4; }
.home-svc-card h3 { font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 20px; margin: 0 0 12px; color: #1a1f2e; }
.home-svc-card p { margin: 0 0 18px; font-family: 'Assistant', sans-serif; font-size: 15px; line-height: 1.65; color: #4a5364; }
.home-svc-link { font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 14px; color: #448CCB; }
.home-svc-card--addon { background: #fdfdff; border: 1.5px dashed #cfd3e0; }
.home-addon-list { list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; gap: 10px; }
.home-addon-list li { display: flex; gap: 10px; font-family: 'Assistant', sans-serif; font-size: 15px; color: #4a5364; }
.home-addon-list li span { color: #00BFF3; font-weight: 700; }
.home-svc-card--addon h3 { margin-bottom: 14px; }

/* ===== MID CTA ===== */
.home-midcta { background: #fff; padding: 50px clamp(24px, 4vw, 40px) 110px; }
.home-midcta .pfx-gradient-card { max-width: 1120px; margin: 0 auto; }
.home-midcta .pfx-gradient-card-inner { padding: 64px clamp(28px, 5vw, 72px); }
.home-midcta h2 { font-family: 'Poppins', sans-serif; font-weight: 600; font-size: clamp(28px, 3vw, 40px); letter-spacing: -1px; margin: 0 0 14px; color: #fff; }
.home-midcta p { margin: 0 auto 32px; max-width: 560px; font-family: 'Assistant', sans-serif; font-weight: 300; font-size: 17px; line-height: 1.7; color: rgba(255,255,255,0.75); }

/* ===== WHO WE SERVE ===== */
.home-serve { background: #f9f9fb; padding: 100px 0 110px; }
.home-serve .home-h2 { color: #1a1f2e; }
.home-serve-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(380px, 1fr)); gap: 28px; }
.home-serve-card { background: #fff; border: 1px solid #e9e9f1; border-radius: 16px; overflow: hidden; transition: box-shadow 0.35s ease; }
.home-serve-card:hover { box-shadow: 0 24px 48px rgba(26,31,46,0.12); }
.home-serve-media { position: relative; overflow: hidden; height: 230px; }
.home-serve-img { display: block; width: 100%; height: 100%; object-fit: cover; transition: transform 1.2s ease; }
.home-serve-img--empty { background: linear-gradient(135deg, #e8eaf1, #f3f4f8); }
.home-serve-card:hover .home-serve-img { transform: scale(1.06); }
.home-serve-pill { position: absolute; top: 16px; left: 16px; background: rgba(26,31,46,0.85); color: #fff; padding: 6px 14px; border-radius: 999px; font-family: 'Montserrat', sans-serif; font-size: 11px; font-weight: 600; letter-spacing: 1.5px; text-transform: uppercase; pointer-events: none; }
.home-serve-body { padding: 28px 28px 30px; }
.home-serve-body h3 { font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 19px; line-height: 1.35; margin: 0 0 12px; color: #1a1f2e; }
.home-serve-desc { margin: 0 0 18px; font-family: 'Assistant', sans-serif; font-size: 15px; line-height: 1.65; color: #4a5364; }
.home-serve-list { list-style: none; margin: 0 0 20px; padding: 0; display: flex; flex-direction: column; gap: 8px; }
.home-serve-list li { display: flex; gap: 10px; font-family: 'Assistant', sans-serif; font-size: 15px; color: #3c4354; }
.home-serve-list li span { color: #00BFF3; font-weight: 700; }
.home-serve-link { font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 14px; color: #448CCB; }

/* ===== WHY TRUST (dark) ===== */
.home-trust { position: relative; background: #1a1f2e; padding: 100px clamp(24px, 4vw, 40px) 110px; overflow: hidden; }
.home-trust-inner { position: relative; z-index: 1; max-width: 1200px; margin: 0 auto; }
.home-trust .home-h2 { color: #fff; }
.home-trust-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 24px; }
@media (max-width: 860px) { .home-trust-grid { grid-template-columns: 1fr; } }
.home-trust-card { position: relative; overflow: hidden; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.09); border-radius: 14px; padding: 34px; }
.home-trust-card--wide { grid-column: 1 / -1; }
.home-trust-card h3 { font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 19px; margin: 0 0 12px; color: #fff; }
.home-trust-card p { margin: 0; font-family: 'Assistant', sans-serif; font-size: 15px; line-height: 1.7; color: rgba(255,255,255,0.7); }
.home-trust-cta { text-align: center; margin-top: 48px; position: relative; z-index: 1; }

/* ===== FINAL CTA ===== */
.home-cta { position: relative; overflow: hidden; background: linear-gradient(170deg, #8560A8 0%, #3d2d66 30%, #252C3A 70%, #1a1f2e 100%); padding: 130px clamp(24px, 4vw, 40px); text-align: center; }
.home-cta-orb-a { position: absolute; width: 420px; height: 420px; left: -120px; top: -80px; border-radius: 50%; background: radial-gradient(circle, rgba(0,191,243,0.16), transparent 70%); animation: home-floatA 14s ease-in-out infinite; pointer-events: none; }
.home-cta-orb-b { position: absolute; width: 540px; height: 540px; right: -170px; bottom: -150px; border-radius: 50%; background: radial-gradient(circle, rgba(133,96,168,0.3), transparent 70%); animation: home-floatB 17s ease-in-out infinite; pointer-events: none; }
@keyframes home-floatA { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(28px, -26px); } }
@keyframes home-floatB { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(-24px, 22px); } }
.home-cta-inner { position: relative; z-index: 1; max-width: 760px; margin: 0 auto; }
.home-cta-inner h2 { font-family: 'Poppins', sans-serif; font-weight: 600; font-size: clamp(34px, 4vw, 52px); letter-spacing: -1.2px; margin: 0 0 18px; color: #fff; }
.home-cta-inner p { margin: 0 auto; max-width: 560px; font-family: 'Assistant', sans-serif; font-weight: 300; font-size: 18px; line-height: 1.7; color: rgba(255,255,255,0.8); }
.home-cta-buttons { display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; margin-top: 38px; }

@media (prefers-reduced-motion: reduce) {
  .home-cta-orb-a, .home-cta-orb-b { animation: none !important; }
  .home-serve-img { transition: none !important; }
}
</style>

<!-- 1. HERO -->
<section class="pfx-hero home-hero" data-grain aria-label="Hero">
  <div class="pfx-hero-grid"></div>
  <div class="home-hero-inner">
    <span class="pfx-overline pfx-reveal">Stretch Creative</span>
    <h1 class="home-hero-title pfx-reveal pfx-delay-1">Digital Marketing Solutions for <span class="gradient-text">Modern Search</span></h1>
    <p class="home-hero-lede pfx-reveal pfx-delay-2">Stretch Creative provides SEO, AEO, and content services to increase brand visibility, earn attention, and inspire people toward action.</p>
    <a href="<?php echo esc_url('/contact-stretch-creative/'); ?>" class="pfx-btn-primary pfx-reveal pfx-delay-2"><span>Schedule a Discovery Call →</span></a>
  </div>
  <div class="home-hero-wedge" aria-hidden="true"></div>
</section>

<!-- 2. TRUSTED BRANDS -->
<?php stretch_pfx_logo_marquee(); ?>

<!-- wedge: white → Ink-2 (down-left) -->
<div class="home-wedge" aria-hidden="true" style="background:#ffffff"><div style="background:#252C3A;clip-path:polygon(0 0,100% 100%,0 100%)"></div></div>

<!-- 3. STATS (Ink-2) — values render server-side; JS animates from 0 -->
<section class="pfx-stats-bar pfx-stats-bar--ink2" aria-label="Statistics">
  <div class="pfx-container">
    <div class="pfx-stats-inner">
      <div class="pfx-reveal"><div class="pfx-stat-number"><span class="pfx-count" data-target="200">200</span><span>+</span></div><div class="pfx-stat-label">Human Creatives</div></div>
      <div class="pfx-reveal pfx-delay-1"><div class="pfx-stat-number"><span class="pfx-count" data-target="170">170</span><span>+</span></div><div class="pfx-stat-label">Enterprise Brands</div></div>
      <div class="pfx-reveal pfx-delay-2"><div class="pfx-stat-number"><span class="pfx-count" data-target="15000">15,000</span><span>+</span></div><div class="pfx-stat-label">Content Pieces Delivered</div></div>
      <div class="pfx-reveal pfx-delay-3"><div class="pfx-stat-number"><span class="pfx-count" data-target="96">96</span><span>%</span></div><div class="pfx-stat-label">On-Time Delivery</div></div>
    </div>
  </div>
</section>

<!-- wedge: Ink-2 → white (down-right) -->
<div class="home-wedge" aria-hidden="true" style="background:#252C3A"><div style="background:#ffffff;clip-path:polygon(0 100%,100% 0,100% 100%)"></div></div>

<!-- 4. OUR SERVICES -->
<section class="home-services" aria-label="Our Services">
  <div class="pfx-container">
    <div class="home-head pfx-reveal">
      <span class="pfx-overline">Our Services</span>
      <h2 class="home-h2">Multiple services × <span class="gradient-text">one agency</span></h2>
    </div>
    <div class="home-services-grid">
      <a href="<?php echo esc_url('/seo_content_strategy_services/'); ?>" class="home-svc-card pfx-sweep pfx-reveal">
        <div class="pfx-sweep-bar pfx-sweep-bar--top"></div>
        <div class="home-svc-top">
          <div class="home-svc-icon"><svg width="24" height="24" style="fill:none;stroke:#448CCB;stroke-width:1.7;stroke-linecap:round;stroke-linejoin:round"><circle cx="10" cy="10" r="6"></circle><path d="M14.5 14.5L20 20"></path></svg></div>
          <span class="home-svc-num">01</span>
        </div>
        <h3>SEO/AEO Strategy &amp; Services</h3>
        <p>Search has changed, but people still need answers. We help businesses earn visibility across traditional search, AI-generated results, and emerging discovery platforms with content and site experiences that are useful, accurate, and easy to understand.</p>
        <span class="home-svc-link">Learn more →</span>
      </a>

      <a href="<?php echo esc_url('/services/bespoke-content-experience/'); ?>" class="home-svc-card pfx-sweep pfx-reveal pfx-delay-1">
        <div class="pfx-sweep-bar pfx-sweep-bar--top"></div>
        <div class="home-svc-top">
          <div class="home-svc-icon"><svg width="24" height="24" style="fill:none;stroke:#448CCB;stroke-width:1.7;stroke-linecap:round;stroke-linejoin:round"><path d="M5 4l7 16 2.5-6.5L21 11z"></path></svg></div>
          <span class="home-svc-num">02</span>
        </div>
        <h3>Interactive Content Marketing</h3>
        <p>Calculators, assessments, maps, quizzes, and other interactive tools give visitors a reason to engage instead of bounce. We build bespoke content experiences that answer questions, surface insights, recommend products, and provide your visitors with value—and fun.</p>
        <span class="home-svc-link">Learn more →</span>
      </a>

      <a href="<?php echo esc_url('/content-writing-at-any-scale/'); ?>" class="home-svc-card pfx-sweep pfx-reveal pfx-delay-2">
        <div class="pfx-sweep-bar pfx-sweep-bar--top"></div>
        <div class="home-svc-top">
          <div class="home-svc-icon"><svg width="24" height="24" style="fill:none;stroke:#448CCB;stroke-width:1.7;stroke-linecap:round;stroke-linejoin:round"><path d="M4 20l1-4L16.5 4.5a2.1 2.1 0 013 3L8 19z"></path><path d="M13.5 7.5l3 3"></path></svg></div>
          <span class="home-svc-num">03</span>
        </div>
        <h3>Content Writing</h3>
        <p>Our hand-picked roster of experienced content writers can take on whatever written assets you need to inform, persuade, and support your customers through the buying journey. Every piece we produce is written by humans for real people, fully optimized and written with a clear purpose.</p>
        <span class="home-svc-link">Learn more →</span>
      </a>

      <a href="<?php echo esc_url('/visual-content-and-design/'); ?>" class="home-svc-card pfx-sweep pfx-reveal">
        <div class="pfx-sweep-bar pfx-sweep-bar--top"></div>
        <div class="home-svc-top">
          <div class="home-svc-icon"><svg width="24" height="24" style="fill:none;stroke:#448CCB;stroke-width:1.7;stroke-linecap:round;stroke-linejoin:round"><rect x="3" y="5" width="18" height="14" rx="2"></rect><circle cx="8.5" cy="9.5" r="1.5"></circle><path d="M3 16l5-4 4 3 3-2.5 6 4.5"></path></svg></div>
          <span class="home-svc-num">04</span>
        </div>
        <h3>Visual Content &amp; Design</h3>
        <p>Strong visuals make complex information easier to understand. Our in-house, human creatives produce high-quality graphics, infographics, digital assets, photography, and video productions that clarify key points, strengthen messaging and branding, and help your content perform across multiple channels.</p>
        <span class="home-svc-link">Learn more →</span>
      </a>

      <a href="<?php echo esc_url('/paid-advertising/'); ?>" class="home-svc-card pfx-sweep pfx-reveal pfx-delay-1">
        <div class="pfx-sweep-bar pfx-sweep-bar--top"></div>
        <div class="home-svc-top">
          <div class="home-svc-icon"><svg width="24" height="24" style="fill:none;stroke:#448CCB;stroke-width:1.7;stroke-linecap:round;stroke-linejoin:round"><path d="M3 10v4h3l10 6V4L6 10z"></path><path d="M20 9a5 5 0 010 6"></path></svg></div>
          <span class="home-svc-num">05</span>
        </div>
        <h3>Paid Advertising</h3>
        <p>Traffic alone doesn’t pay the bills. Our paid advertising team creates paid campaigns that connect with the right audiences, align with your business goals, and support measurable outcomes, from lead generation to product sales.</p>
        <span class="home-svc-link">Learn more →</span>
      </a>

      <div class="home-svc-card home-svc-card--addon pfx-reveal pfx-delay-2">
        <div class="home-svc-top">
          <div class="home-svc-icon"><svg width="24" height="24" style="fill:none;stroke:#448CCB;stroke-width:1.7;stroke-linecap:round;stroke-linejoin:round"><path d="M12 5v14"></path><path d="M5 12h14"></path></svg></div>
          <span class="home-svc-num">06</span>
        </div>
        <h3>Add-On Services</h3>
        <ul class="home-addon-list">
          <li><span>+</span>Budget Management</li>
          <li><span>+</span>CMS Loading</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- 5. MID CTA -->
<section class="home-midcta" aria-label="Get Started">
  <div class="pfx-gradient-card pfx-reveal">
    <div class="pfx-gradient-card-inner dark">
      <h2>Let’s find the right fit.</h2>
      <p>Every engagement starts with a conversation about your goals, your audience, and your budget.</p>
      <a href="<?php echo esc_url('/contact-stretch-creative/'); ?>" class="pfx-btn-primary"><span>Schedule a Discovery Call →</span></a>
    </div>
  </div>
</section>

<!-- 6. WHO WE SERVE -->
<section class="home-serve" aria-label="Who We Serve">
  <div class="pfx-container">
    <div class="home-head pfx-reveal">
      <span class="pfx-overline">Who We Serve</span>
      <h2 class="home-h2">Built for <span class="gradient-text">your industry</span></h2>
    </div>
    <div class="home-serve-grid">
      <div class="home-serve-card pfx-tilt pfx-reveal">
        <div class="home-serve-media">
          <?php echo stretch_home_serve_media($stretch_page_images, 'home_ecommerce', 'Ecommerce'); ?>
          <span class="home-serve-pill">Ecommerce</span>
        </div>
        <div class="home-serve-body">
          <h3>SEO and content services for every stage of the buying journey.</h3>
          <p class="home-serve-desc">We help DTC brands and retailers attract qualified shoppers and improve product discovery with expert SEO services, informative product detail and category pages, interactive content experiences, and engaging blogs that build your brand and help your customers find the products they need.</p>
          <ul class="home-serve-list">
            <li><span>✓</span>Product Detail Pages &amp; Category Page Content</li>
            <li><span>✓</span>SEO &amp; Product Discovery</li>
            <li><span>✓</span>Creative Assets &amp; Visual Storytelling</li>
            <li><span>✓</span>Buying Guides and Gift Guides</li>
          </ul>
          <a href="<?php echo esc_url('/industries/ecommerce/'); ?>" class="home-serve-link">Learn More →</a>
        </div>
      </div>

      <div class="home-serve-card pfx-tilt pfx-reveal pfx-delay-1">
        <div class="home-serve-media">
          <?php echo stretch_home_serve_media($stretch_page_images, 'home_agencies', 'Agencies & Partners'); ?>
          <span class="home-serve-pill">Agencies &amp; Partners</span>
        </div>
        <div class="home-serve-body">
          <h3>High-volume, white-labeled content for agencies and other partners.</h3>
          <p class="home-serve-desc">When demand exceeds capacity, Stretch Creative is ready to help with the expertise, talent, and production support to help your agency scale. We work as an extension of your team to produce high-quality, human-written content at any scale.</p>
          <ul class="home-serve-list">
            <li><span>✓</span>White-Labeled SEO Content Production</li>
            <li><span>✓</span>SEO &amp; Content Strategy</li>
            <li><span>✓</span>Design &amp; Interactive Assets</li>
            <li><span>✓</span>High-Volume Production</li>
          </ul>
          <a href="<?php echo esc_url('/industries/agencies/'); ?>" class="home-serve-link">Learn More →</a>
        </div>
      </div>

      <div class="home-serve-card pfx-tilt pfx-reveal">
        <div class="home-serve-media">
          <?php echo stretch_home_serve_media($stretch_page_images, 'home_service_providers', 'Local Service Providers'); ?>
          <span class="home-serve-pill">Local Service Providers</span>
        </div>
        <div class="home-serve-body">
          <h3>Get found locally, build trust, and turn searches into service calls.</h3>
          <p class="home-serve-desc">Your local service business or franchise needs to be visible where customers are searching—and persuasive when they click onto your site. Stretch Creative combines local SEO, service-focused content, and digital marketing strategies that will help your business earn trust and generate work orders.</p>
          <ul class="home-serve-list">
            <li><span>✓</span>SEO for Local Search Visibility</li>
            <li><span>✓</span>Service &amp; Geographic Landing Pages and Blogs</li>
            <li><span>✓</span>Social Media &amp; Design</li>
            <li><span>✓</span>Paid Advertising</li>
          </ul>
          <a href="<?php echo esc_url('/industries/service-providers/'); ?>" class="home-serve-link">Learn More →</a>
        </div>
      </div>

      <div class="home-serve-card pfx-tilt pfx-reveal pfx-delay-1">
        <div class="home-serve-media">
          <?php echo stretch_home_serve_media($stretch_page_images, 'home_saas', 'SaaS & Digital Platforms'); ?>
          <span class="home-serve-pill">SaaS &amp; Digital Platforms</span>
        </div>
        <div class="home-serve-body">
          <h3>Clear, accurate content for high-stakes buying decisions.</h3>
          <p class="home-serve-desc">Whether you’re selling software or connecting users to services, your success depends on helping people make informed decisions, often involving serious topics like money, law, and health. Stretch Creative produces content that distills down complex ideas and offerings and answers all the right questions.</p>
          <ul class="home-serve-list">
            <li><span>✓</span>Expert-Written or -Reviewed Content</li>
            <li><span>✓</span>White Papers and Case Studies</li>
            <li><span>✓</span>Graphic Design</li>
            <li><span>✓</span>SEO Content Strategy</li>
          </ul>
          <a href="<?php echo esc_url('/industries/saas/'); ?>" class="home-serve-link">Learn More →</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- wedge: #f9f9fb → Ink (down-left) -->
<div class="home-wedge" aria-hidden="true" style="background:#f9f9fb"><div style="background:#1a1f2e;clip-path:polygon(0 0,100% 100%,0 100%)"></div></div>

<!-- 7. WHY TRUST (dark) -->
<section class="home-trust" data-grain aria-label="Why Trust Stretch Creative">
  <div class="home-trust-inner">
    <div class="home-head pfx-reveal">
      <span class="pfx-overline">Why Stretch</span>
      <h2 class="home-h2">Why Trust Stretch Creative?</h2>
    </div>
    <div class="home-trust-grid">
      <div class="home-trust-card pfx-sweep pfx-reveal">
        <div class="pfx-sweep-bar pfx-sweep-bar--left"></div>
        <h3>All of the services you need under one roof</h3>
        <p>Content works better when the people creating it work together. With writers, designers, SEO specialists, videographers, and paid media experts under one roof, your campaigns stay aligned, your message remains consistent, and your projects move faster.</p>
      </div>
      <div class="home-trust-card pfx-sweep pfx-reveal pfx-delay-1">
        <div class="pfx-sweep-bar pfx-sweep-bar--left"></div>
        <h3>We’re an extension of your team</h3>
        <p>The best partnerships don’t happen through support tickets and quarterly check-ins. Regularly scheduled touch-base calls and easy access to your Client Services Team and Managing Editor keep our partnership fresh and current. That makes it easy for us to pivot with you when big changes come down the pipeline, for better or worse.</p>
      </div>
      <div class="home-trust-card pfx-sweep pfx-reveal pfx-delay-2">
        <div class="pfx-sweep-bar pfx-sweep-bar--left"></div>
        <h3>Stay agile in the face of change</h3>
        <p>Search is evolving fast, and it’s more important than ever to stay current on trends in content, SEO, and AI. We’re on top of it at the agency level, and everything we produce is optimized using current SEO and AEO best practices.</p>
      </div>
      <div class="home-trust-card pfx-sweep pfx-reveal pfx-delay-3">
        <div class="pfx-sweep-bar pfx-sweep-bar--left"></div>
        <h3>Scale with ease</h3>
        <p>Need more content? Launching a new product? Expanding into a new market? Our processes make it easy to increase production, add new content types and services, and grow your marketing efforts without rebuilding your entire operation.</p>
      </div>
      <div class="home-trust-card home-trust-card--wide pfx-sweep pfx-reveal">
        <div class="pfx-sweep-bar pfx-sweep-bar--left"></div>
        <h3>Human-created, editorially driven</h3>
        <p>We’re not an AI-assisted content mill. Our writers, editors, and visual creatives are vetted, experienced freelancers who we hand-pick for every project. While we use AI to streamline operational workflows, we never send our clients AI-written content.</p>
      </div>
    </div>
    <div class="home-trust-cta pfx-reveal">
      <a href="<?php echo esc_url('/about-stretch-creative/'); ?>" class="pfx-btn-outline">Learn how we work →</a>
    </div>
  </div>
</section>

<!-- wedge: Ink → Purple (down-right) -->
<div class="home-wedge" aria-hidden="true" style="background:#1a1f2e"><div style="background:#8560A8;clip-path:polygon(0 100%,100% 0,100% 100%)"></div></div>

<!-- 8. FINAL CTA -->
<section class="home-cta" data-grain aria-label="Call to Action">
  <div class="home-cta-orb-a"></div>
  <div class="home-cta-orb-b"></div>
  <div class="home-cta-inner">
    <h2 class="pfx-reveal">Let’s Talk</h2>
    <p class="pfx-reveal pfx-delay-1">Tell us about your project and we’ll show you how Stretch Creative can help.</p>
    <div class="home-cta-buttons pfx-reveal pfx-delay-2">
      <a href="<?php echo esc_url('/contact-stretch-creative/'); ?>" class="pfx-btn-primary"><span>Contact Us →</span></a>
      <a href="<?php echo esc_url('/our-work/'); ?>" class="pfx-btn-outline">See Our Work</a>
    </div>
  </div>
</section>

<?php get_footer(); ?>
