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
$headline        = !empty($service['headline'])        ? $service['headline']        : get_the_title();
$subheadline     = !empty($service['subheadline'])     ? $service['subheadline']     : '';
$hero_text       = !empty($service['hero_text'])       ? $service['hero_text']       : '';
$hero_cta_label  = !empty($service['hero_cta_label'])  ? $service['hero_cta_label']  : 'Get Started';
$hero_cta_url    = !empty($service['hero_cta_url'])    ? $service['hero_cta_url']    : '/contact-stretch-creative/';
$problem         = !empty($service['problem'])         ? $service['problem']         : [];
$solution        = !empty($service['solution'])        ? $service['solution']        : [];
$offerings_intro      = !empty($service['offerings_intro'])      ? $service['offerings_intro']      : '';
$offerings            = !empty($service['offerings'])            ? $service['offerings']            : [];
$offerings_overline   = !empty($service['offerings_overline'])   ? $service['offerings_overline']   : 'Services';
$offerings_heading    = !empty($service['offerings_heading'])    ? $service['offerings_heading']    : 'What We Deliver';
$offerings_subheading = !empty($service['offerings_subheading']) ? $service['offerings_subheading'] : '';
$process         = !empty($service['process'])         ? $service['process']         : [];
$why_heading     = !empty($service['why_heading'])     ? $service['why_heading']     : 'Why Stretch?';
$why_intro       = !empty($service['why_intro'])       ? $service['why_intro']       : '';
$benefits        = !empty($service['benefits'])        ? $service['benefits']        : [];
$testimonials_list = !empty($service['testimonials']) ? $service['testimonials']    : [];
$faqs            = !empty($service['faqs'])            ? $service['faqs']            : [];
$stats           = !empty($service['stats'])           ? $service['stats']           : [];
$cta             = !empty($service['cta'])             ? $service['cta']             : [];

// Default stats by slug
if (empty($stats)) {
    $default_stats = [
        'content-writing-at-any-scale' => [
            ['label' => 'Writers', 'value' => '200', 'suffix' => '+'],
            ['label' => 'Minimums', 'value' => 'No Minimums', 'suffix' => ''],
            ['label' => 'Industries', 'value' => '10', 'suffix' => '+'],
            ['label' => 'On-Time Delivery', 'value' => '98', 'suffix' => '%'],
        ],
        'seo_content_strategy_services' => [
            ['label' => 'Keywords Analyzed', 'value' => '500', 'suffix' => 'K+'],
            ['label' => 'Results Timeline', 'value' => '3-6', 'suffix' => 'mo'],
            ['label' => 'Strategy', 'value' => '100', 'suffix' => '%', 'prefix' => '', 'display' => 'Custom'],
            ['label' => 'Approach', 'value' => 'Data-Driven', 'suffix' => ''],
        ],
        'graphic_design_services' => [
            ['label' => 'Designers', 'value' => '50', 'suffix' => '+'],
            ['label' => 'Turnaround', 'value' => '24', 'suffix' => 'hr'],
            ['label' => 'Formats', 'value' => 'Multiple', 'suffix' => ''],
            ['label' => 'Brand Match', 'value' => 'On-Brand Always', 'suffix' => ''],
        ],
        'video-content-services' => [
            ['label' => 'Experience', 'value' => '30', 'suffix' => 'yr'],
            ['label' => 'Production', 'value' => 'End-to-End', 'suffix' => ''],
            ['label' => 'Quality', 'value' => '4K', 'suffix' => ''],
            ['label' => 'Distribution', 'value' => 'Multi-Platform', 'suffix' => ''],
        ],
    ];
    $stats = isset($default_stats[$slug]) ? $default_stats[$slug] : [
        ['label' => 'Projects', 'value' => '500', 'suffix' => '+'],
        ['label' => 'Clients', 'value' => '100', 'suffix' => '+'],
        ['label' => 'Satisfaction', 'value' => '98', 'suffix' => '%'],
        ['label' => 'On-Time', 'value' => '99', 'suffix' => '%'],
    ];
}

// Pull quote by slug
$pull_quotes = [
    'content-writing-at-any-scale' => 'Whether you need one piece or a thousand, <span class="svc-quote-accent">quality never compromises.</span>',
    'seo_content_strategy_services' => 'From enterprise audits to SEO-Lite — <span class="svc-quote-accent">you only pay for what you need.</span>',
    'graphic_design_services' => 'Design is not decoration. It is <span class="svc-quote-accent">communication, trust, and brand equity</span> made visible.',
    'video-content-services' => 'Every frame tells a story. We make sure <span class="svc-quote-accent">yours is unforgettable.</span>',
    'content-strategy' => 'Strategy without execution is a document. We build the kind <span class="svc-quote-accent">your team can actually ship.</span>',
    'paid-advertising' => 'Creative and media, under one roof — <span class="svc-quote-accent">which is exactly why our campaigns compound.</span>',
];
$pull_quote = isset($pull_quotes[$slug]) ? $pull_quotes[$slug] : 'Whatever the challenge, we bring <span class="svc-quote-accent">craft, scale, and consistency</span> to every project.';

// Testimonials by slug
$testimonials = [
    'content-writing-at-any-scale' => [
        'quote' => 'Stretch transformed our content operation. We went from struggling to publish two posts a month to having a full editorial calendar of expert-written content. The quality is indistinguishable from our in-house team.',
        'name'  => 'VP of Marketing',
        'title' => 'Fortune 500 Retailer',
    ],
    'seo_content_strategy_services' => [
        'quote' => 'Their SEO strategy helped us rank for keywords we never thought possible. Within six months, our organic traffic had tripled and we were outranking competitors who had been in the space for years.',
        'name'  => 'Director of Digital',
        'title' => 'B2B SaaS Company',
    ],
    'graphic_design_services' => [
        'quote' => 'We needed hundreds of product images and infographics on a tight deadline. Stretch delivered every single asset on-brand and on-time. They feel like an extension of our creative team.',
        'name'  => 'Creative Director',
        'title' => 'DTC Ecommerce Brand',
    ],
    'video-content-services' => [
        'quote' => 'The production quality blew us away. We expected a typical corporate video and got something cinematic. Our CEO said it was the best brand investment we made all year.',
        'name'  => 'Head of Brand',
        'title' => 'Healthcare Technology Company',
    ],
    'content-strategy' => [
        'quote' => 'Stretch came in, audited every piece of content we had, and handed us a roadmap our team could actually execute on. Six months later our organic traffic is up and every brief our writers pick up sets them up to win.',
        'name'  => 'Director of Content Marketing',
        'title' => 'B2B SaaS Company',
    ],
    'paid-advertising' => [
        'quote' => 'We had been splitting creative and media across two agencies and paying for the friction. Stretch brought it under one roof and our CAC dropped within the first quarter. The testing velocity is the real unlock.',
        'name'  => 'VP of Growth',
        'title' => 'DTC Consumer Brand',
    ],
];
$testimonial = isset($testimonials[$slug]) ? $testimonials[$slug] : $testimonials['content-writing-at-any-scale'];

// Benefit icons (SVG circles with initials or abstract shapes)
$benefit_colors = ['#8560A8', '#5674B9', '#448CCB', '#00BFF3'];
?>

<style>
/* ========================================
   SERVICE PAGE — PREMIUM TEMPLATE
   ======================================== */

html, body { overflow-x: hidden; }

/* ---------- ADMIN BAR FIX ---------- */
.admin-bar .site-nav { top: 32px; }
@media (max-width: 782px) { .admin-bar .site-nav { top: 46px; } }

/* ---------- RESET / BASE ---------- */
.svc-section { box-sizing: border-box; }
.svc-section *, .svc-section *::before, .svc-section *::after { box-sizing: inherit; }
.svc-section img { max-width: 100%; height: auto; display: block; }

/* ---------- UTILITIES ---------- */
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
.svc-reveal-right {
  opacity: 0; transform: translateX(60px);
  transition: opacity 0.9s cubic-bezier(0.16, 1, 0.3, 1), transform 0.9s cubic-bezier(0.16, 1, 0.3, 1);
}
.svc-reveal-right.visible { opacity: 1; transform: translateX(0); }
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
.svc-angle-divider-top {
  position: absolute; top: -1px; left: 0; right: 0;
  z-index: 2; pointer-events: none; line-height: 0;
}
.svc-angle-divider-top svg { display: block; width: 100%; height: 60px; }

/* ---------- GRAIN TEXTURE ---------- */
@keyframes svc-grainShift {
  0% { transform: translate(0, 0); }
  25% { transform: translate(-2%, -3%); }
  50% { transform: translate(3%, 1%); }
  75% { transform: translate(-1%, 3%); }
  100% { transform: translate(0, 0); }
}
.svc-grain-overlay {
  position: absolute; inset: 0;
  overflow: hidden; pointer-events: none; z-index: 0;
}
.svc-grain-overlay::before {
  content: '';
  position: absolute; inset: -50%;
  width: 200%; height: 200%;
  opacity: 0.035;
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
  background-size: 128px 128px;
  animation: svc-grainShift 0.8s steps(4) infinite;
}

/* ========================================
   1. CINEMATIC HERO
   ======================================== */
.svc-hero {
  position: relative;
  min-height: 80vh;
  display: flex;
  align-items: center;
  background: linear-gradient(170deg, #1a1f2e 0%, #252C3A 40%, #1e2333 100%);
  overflow: hidden;
  padding: 160px 0 120px;
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

/* Animated mesh background */
.svc-hero-mesh {
  position: absolute; inset: 0;
  pointer-events: none; z-index: 0;
  background:
    radial-gradient(ellipse at 20% 50%, rgba(133,96,168,0.06) 0%, transparent 50%),
    radial-gradient(ellipse at 80% 20%, rgba(0,191,243,0.04) 0%, transparent 50%),
    radial-gradient(ellipse at 50% 80%, rgba(86,116,185,0.05) 0%, transparent 50%);
}

/* Grid pattern overlay — built dynamically with JS for colored squares */
.svc-hero-grid {
  position: absolute; inset: 0;
  pointer-events: none; z-index: 1;
  overflow: hidden;
}
.svc-grid-container {
  position: absolute; inset: -60px;
  display: grid;
  grid-template-columns: repeat(auto-fill, 60px);
  grid-auto-rows: 60px;
  transition: transform 0.4s ease-out;
}
.svc-grid-cell {
  border: 1px solid rgba(255,255,255,0.03);
  transition: background 0.6s ease, border-color 0.6s ease;
}
.svc-grid-cell.colored {
  background: var(--cell-color);
  border-color: rgba(255,255,255,0.06);
  animation: svc-cellPulse 4s ease-in-out infinite;
  animation-delay: var(--cell-delay, 0s);
}
@keyframes svc-cellPulse {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.4; }
}
.svc-hero:hover .svc-grid-container {
  transform: translate(calc(var(--gmx, 0) * 15px), calc(var(--gmy, 0) * 15px));
}
/* Radial mask — clear center for text, colored cells visible at edges */
.svc-hero-grid::after {
  content: '';
  position: absolute; inset: 0;
  background: radial-gradient(ellipse 55% 50% at 50% 50%, rgba(37,44,58,0.95) 0%, rgba(37,44,58,0.7) 30%, transparent 60%);
  pointer-events: none;
  z-index: 1;
}
@media (prefers-reduced-motion: reduce) {
  .svc-grid-cell.colored { animation: none; }
  .svc-hero:hover .svc-grid-container { transform: none; }
}

.svc-hero-content {
  position: relative; z-index: 2;
  text-align: center;
  max-width: 780px; margin: 0 auto;
}
.svc-hero-overline {
  font-family: 'Montserrat', sans-serif;
  font-size: 13px; font-weight: 400;
  letter-spacing: 3px; text-transform: uppercase;
  color: #00BFF3; display: block; margin-bottom: 20px;
}
.svc-hero-content h1 {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(38px, 5vw, 62px);
  font-weight: 600; line-height: 1.08;
  color: #fff; margin: 0 0 24px; letter-spacing: -1.5px;
}
.svc-hero-content .svc-subtitle {
  font-family: 'Assistant', sans-serif;
  font-size: 19px; font-weight: 300; line-height: 1.7;
  color: rgba(255,255,255,0.7);
  max-width: 620px; margin: 0 auto 20px;
}
.svc-hero-content .svc-hero-body {
  font-family: 'Assistant', sans-serif;
  font-size: 16px; font-weight: 300; line-height: 1.75;
  color: rgba(255,255,255,0.55);
  max-width: 680px; margin: 0 auto 40px;
}
.svc-cta-content .svc-cta-sub {
  font-family: 'Poppins', sans-serif;
  font-size: 18px; font-weight: 400;
  color: rgba(255,255,255,0.85);
  margin: 0 0 16px;
  letter-spacing: 0.2px;
}
.svc-btn-primary {
  display: inline-block;
  font-family: 'Poppins', sans-serif;
  font-size: 15px; font-weight: 500;
  color: #fff;
  background: linear-gradient(135deg, #8560A8, #5674B9);
  padding: 18px 44px; border-radius: 6px;
  text-decoration: none;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  box-shadow: 0 4px 20px rgba(133,96,168,0.3);
  position: relative; overflow: hidden;
}
.svc-btn-primary::before {
  content: '';
  position: absolute; inset: 0;
  background: linear-gradient(135deg, #5674B9, #00BFF3);
  opacity: 0; transition: opacity 0.3s ease;
  border-radius: 6px;
}
.svc-btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 30px rgba(133,96,168,0.45);
}
.svc-btn-primary:hover::before { opacity: 1; }
.svc-btn-primary span { position: relative; z-index: 1; }

/* ========================================
   2. GRADIENT ACCENT BAR
   ======================================== */
.svc-accent-bar {
  height: 4px;
  background: linear-gradient(90deg, #8560A8, #5674B9, #448CCB, #00BFF3, #448CCB, #5674B9, #8560A8);
  background-size: 200% 100%;
  animation: svc-gradientSlide 4s ease infinite;
}
@keyframes svc-gradientSlide {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

/* ========================================
   3. STATS BAR
   ======================================== */
.svc-stats-bar {
  background: #1a1f2e;
  padding: 60px 0;
  position: relative;
}
.svc-stats-bar::before {
  content: '';
  position: absolute; inset: 0;
  background: linear-gradient(135deg, rgba(133,96,168,0.05), rgba(0,191,243,0.03));
  pointer-events: none;
}
.svc-stats-inner {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 30px;
  text-align: center;
  position: relative;
}
.svc-stat-item { padding: 10px; }
.svc-stat-number {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(32px, 4vw, 50px);
  font-weight: 600;
  color: #fff; line-height: 1;
  margin-bottom: 8px;
}
.svc-stat-number .svc-count { display: inline; }
.svc-stat-number .svc-suffix { color: #00BFF3; }
.svc-stat-label {
  font-family: 'Assistant', sans-serif;
  font-size: 14px; font-weight: 300;
  color: rgba(255,255,255,0.5);
  text-transform: uppercase; letter-spacing: 2px;
}

/* ========================================
   3.5 PROBLEM / SOLUTION (optional)
   ======================================== */
.svc-problem {
  padding: 120px 0 100px;
  background: linear-gradient(180deg, #f7f6fc 0%, #fafafd 100%);
  position: relative;
  overflow: hidden;
}
.svc-problem::before {
  content: '';
  position: absolute;
  top: 50%; left: 50%;
  transform: translate(-50%, -50%);
  width: 800px; height: 800px;
  background: radial-gradient(circle, rgba(133,96,168,0.04), transparent 60%);
  pointer-events: none;
}
.svc-problem-inner {
  max-width: 820px;
  margin: 0 auto;
  text-align: center;
  position: relative;
  z-index: 1;
}
.svc-problem-overline {
  font-family: 'Montserrat', sans-serif;
  font-size: 12px; letter-spacing: 3px;
  text-transform: uppercase;
  color: #8560A8;
  display: block; margin-bottom: 18px;
}
.svc-problem h2 {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(34px, 4.2vw, 50px);
  font-weight: 600; color: #252C3A;
  margin: 0 0 22px; line-height: 1.1;
  letter-spacing: -0.8px;
}
.svc-problem-sub {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(18px, 2vw, 22px);
  font-weight: 500;
  color: #8560A8;
  margin: 0 0 32px; line-height: 1.45;
  max-width: 720px;
  margin-left: auto; margin-right: auto;
}
.svc-problem-text {
  font-family: 'Assistant', sans-serif;
  font-size: 18px; font-weight: 300; line-height: 1.8;
  color: #4a5066;
  max-width: 740px; margin: 0 auto;
}
.svc-problem-text strong {
  color: #252C3A; font-weight: 500;
}

.svc-solution {
  padding: 110px 0 110px;
  background: #fff;
  position: relative;
  overflow: hidden;
}
.svc-solution::before {
  content: '';
  position: absolute;
  top: -200px; right: -200px;
  width: 600px; height: 600px;
  background: radial-gradient(circle, rgba(0,191,243,0.05), transparent 60%);
  pointer-events: none;
}
.svc-solution::after {
  content: '';
  position: absolute;
  bottom: -150px; left: -150px;
  width: 500px; height: 500px;
  background: radial-gradient(circle, rgba(86,116,185,0.04), transparent 60%);
  pointer-events: none;
}
.svc-solution-inner {
  max-width: 820px;
  margin: 0 auto;
  text-align: center;
  position: relative;
  z-index: 1;
}
.svc-solution-overline {
  font-family: 'Montserrat', sans-serif;
  font-size: 12px; letter-spacing: 3px;
  text-transform: uppercase;
  color: #00BFF3;
  display: block; margin-bottom: 18px;
}
.svc-solution h2 {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(34px, 4.2vw, 50px);
  font-weight: 600; color: #252C3A;
  margin: 0 0 22px; line-height: 1.1;
  letter-spacing: -0.8px;
}
.svc-solution-sub {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(18px, 2vw, 22px);
  font-weight: 500;
  color: #5674B9;
  margin: 0 0 28px; line-height: 1.45;
  max-width: 720px;
  margin-left: auto; margin-right: auto;
}
.svc-solution-text {
  font-family: 'Assistant', sans-serif;
  font-size: 18px; font-weight: 300; line-height: 1.8;
  color: #4a5066;
  max-width: 740px; margin: 0 auto 40px;
}

/* ========================================
   4. PULL QUOTE BANNER
   ======================================== */
.svc-pull-quote {
  padding: 100px 0;
  background: linear-gradient(135deg, #f9f9fb 0%, #f0f0f6 100%);
  position: relative;
  overflow: hidden;
}
.svc-pull-quote::before {
  content: '';
  position: absolute; top: 0; left: 0;
  width: 100%; height: 100%;
  background: linear-gradient(90deg, rgba(133,96,168,0.03), rgba(0,191,243,0.03), rgba(133,96,168,0.03));
  background-size: 200% 100%;
  animation: svc-gradientSlide 8s ease infinite;
}
.svc-pull-quote blockquote {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(22px, 3vw, 34px);
  font-weight: 400;
  color: #323A51; line-height: 1.5;
  text-align: center;
  max-width: 900px; margin: 0 auto;
  position: relative;
}
.svc-quote-accent {
  color: #00BFF3; font-weight: 500;
}
.svc-pull-quote blockquote::before,
.svc-pull-quote blockquote::after {
  font-family: Georgia, serif;
  font-size: 120px; line-height: 1;
  position: absolute;
  opacity: 0.07; color: #8560A8;
}
.svc-pull-quote blockquote::before {
  content: '\201C'; top: -40px; left: -30px;
}
.svc-pull-quote blockquote::after {
  content: '\201D'; bottom: -70px; right: -20px;
}

/* ========================================
   5. OFFERINGS — ALTERNATING SHOWCASE
   ======================================== */
.svc-offerings {
  padding: 120px 0;
  background: #fff;
  position: relative;
}
.svc-section-heading {
  text-align: center;
  margin-bottom: 72px;
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
.svc-offerings-sub {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(17px, 1.9vw, 21px);
  font-weight: 500;
  color: #5674B9;
  margin: 18px auto 0;
  max-width: 720px;
  line-height: 1.45;
}
.svc-offerings-intro {
  font-family: 'Assistant', sans-serif;
  font-size: 17px; font-weight: 300; line-height: 1.7;
  color: #4a5066;
  margin: 16px auto 0;
  max-width: 700px;
}

.svc-offering-list {
  display: flex;
  flex-direction: column;
  gap: 0;
}
.svc-offering-row {
  display: grid;
  grid-template-columns: 120px 1fr;
  gap: 48px;
  align-items: center;
  padding: 48px 40px;
  border-radius: 12px;
  position: relative;
  transition: background 0.5s ease, box-shadow 0.4s ease;
  border-left: 3px solid transparent;
}
.svc-offering-row::before {
  content: '';
  position: absolute;
  left: 0; top: 0; bottom: 0;
  width: 3px;
  background: linear-gradient(180deg, #8560A8, #00BFF3);
  opacity: 0.4;
  border-radius: 2px;
  transition: opacity 0.4s ease;
}
.svc-offering-row:hover::before {
  opacity: 1;
}
.svc-offering-row:hover {
  background: rgba(133,96,168,0.03);
  box-shadow: 0 8px 40px rgba(37,44,58,0.06);
}

/* Even rows: flip layout */
.svc-offering-row.svc-offering-even {
  grid-template-columns: 1fr 120px;
  text-align: right;
}
.svc-offering-row.svc-offering-even .svc-offering-number {
  order: 2;
}
.svc-offering-row.svc-offering-even .svc-offering-body {
  order: 1;
}

.svc-offering-number {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(60px, 7vw, 90px);
  font-weight: 700;
  color: rgba(37,44,58,0.06);
  line-height: 1;
  user-select: none;
}
.svc-offering-body h3 {
  font-family: 'Poppins', sans-serif;
  font-size: 22px; font-weight: 600;
  color: #252C3A; margin: 0 0 12px;
  line-height: 1.3;
}
.svc-offering-body p {
  font-family: 'Assistant', sans-serif;
  font-size: 16px; font-weight: 300;
  line-height: 1.7; color: #555; margin: 0;
  max-width: 600px;
}
.svc-offering-row.svc-offering-even .svc-offering-body p {
  margin-left: auto;
}

/* ========================================
   5.25 PROCESS / HOW IT WORKS (optional)
   ======================================== */
.svc-process {
  padding: 120px 0;
  background: #f9f9fb;
  position: relative;
  overflow: hidden;
}
.svc-process::before {
  content: '';
  position: absolute;
  bottom: -200px; right: -200px;
  width: 600px; height: 600px;
  background: radial-gradient(circle, rgba(86,116,185,0.04), transparent 60%);
  pointer-events: none;
}
.svc-process-sub {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(18px, 2vw, 22px);
  font-weight: 500;
  color: #5674B9;
  text-align: center;
  margin: -40px auto 24px;
  max-width: 720px;
  line-height: 1.4;
  position: relative;
}
.svc-process-intro {
  font-family: 'Assistant', sans-serif;
  font-size: 17px; font-weight: 300; line-height: 1.75;
  color: #4a5066;
  text-align: center;
  max-width: 720px; margin: 0 auto 56px;
  position: relative;
}
.svc-process-steps {
  list-style: none; padding: 0;
  max-width: 860px; margin: 0 auto;
  position: relative;
}
.svc-process-steps::before {
  content: '';
  position: absolute;
  left: 39px; top: 40px; bottom: 40px;
  width: 2px;
  background: linear-gradient(180deg, rgba(133,96,168,0.4) 0%, rgba(86,116,185,0.4) 40%, rgba(68,140,203,0.4) 70%, rgba(0,191,243,0.4) 100%);
  z-index: 0;
}
.svc-process-step {
  display: grid;
  grid-template-columns: 80px 1fr;
  gap: 32px;
  align-items: flex-start;
  padding: 16px 0;
  position: relative;
}
.svc-process-num {
  width: 80px; height: 80px;
  border-radius: 50%;
  background: #fff;
  display: flex; align-items: center; justify-content: center;
  font-family: 'Poppins', sans-serif;
  font-size: 22px; font-weight: 600;
  color: #8560A8;
  position: relative;
  z-index: 1;
  flex-shrink: 0;
  box-shadow: 0 2px 8px rgba(37,44,58,0.06);
  border: 2px solid rgba(133,96,168,0.2);
  transition: transform 0.4s cubic-bezier(0.16,1,0.3,1), box-shadow 0.4s ease;
}
.svc-process-step:hover .svc-process-num {
  transform: scale(1.05);
  box-shadow: 0 6px 20px rgba(133,96,168,0.18);
}
.svc-process-step:nth-child(6n+1) .svc-process-num { color: #8560A8; border-color: rgba(133,96,168,0.45); }
.svc-process-step:nth-child(6n+2) .svc-process-num { color: #6e6eb5; border-color: rgba(110,110,181,0.45); }
.svc-process-step:nth-child(6n+3) .svc-process-num { color: #5674B9; border-color: rgba(86,116,185,0.45); }
.svc-process-step:nth-child(6n+4) .svc-process-num { color: #448CCB; border-color: rgba(68,140,203,0.45); }
.svc-process-step:nth-child(6n+5) .svc-process-num { color: #2cb0e0; border-color: rgba(44,176,224,0.45); }
.svc-process-step:nth-child(6n+6) .svc-process-num { color: #00BFF3; border-color: rgba(0,191,243,0.45); }
.svc-process-body {
  padding-top: 14px;
}
.svc-process-body h3 {
  font-family: 'Poppins', sans-serif;
  font-size: 22px; font-weight: 600;
  color: #252C3A; margin: 0 0 10px;
  letter-spacing: -0.3px;
}
.svc-process-body p {
  font-family: 'Assistant', sans-serif;
  font-size: 16px; font-weight: 300;
  line-height: 1.75; color: #4a5066; margin: 0;
  max-width: 640px;
}

/* ========================================
   5.5 SELECTED WORK — INLINE PORTFOLIO STRIP
   ======================================== */
.svc-selected-work {
  padding: 100px 0;
  background: #f9f9fb;
  position: relative;
}
.svc-work-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 24px;
  margin-top: 16px;
}
.svc-work-grid.svc-work-grid-2 {
  grid-template-columns: repeat(2, 1fr);
  max-width: 800px;
  margin-left: auto;
  margin-right: auto;
}
.svc-work-card {
  position: relative;
  border-radius: 12px;
  overflow: hidden;
  background: #fff;
  cursor: pointer;
  aspect-ratio: 4 / 3;
  display: block;
  text-decoration: none;
  color: inherit;
  box-shadow: 0 4px 16px rgba(37,44,58,0.06);
  transition: transform 0.5s cubic-bezier(0.16,1,0.3,1), box-shadow 0.5s ease;
}
.svc-work-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 24px 56px rgba(37,44,58,0.14);
}
.svc-work-card img {
  width: 100%; height: 100%;
  object-fit: cover;
  transition: transform 0.7s cubic-bezier(0.16,1,0.3,1);
  display: block;
}
.svc-work-card:hover img { transform: scale(1.05); }
.svc-work-overlay {
  position: absolute; inset: 0;
  background: linear-gradient(0deg, rgba(37,44,58,0.92) 0%, rgba(37,44,58,0.4) 50%, transparent 100%);
  opacity: 0;
  transition: opacity 0.4s ease;
  z-index: 1;
}
.svc-work-card:hover .svc-work-overlay { opacity: 1; }
.svc-work-meta {
  position: absolute; bottom: 0; left: 0; right: 0;
  padding: 22px;
  z-index: 2;
  transform: translateY(20px);
  opacity: 0;
  transition: transform 0.4s cubic-bezier(0.16,1,0.3,1), opacity 0.4s ease;
}
.svc-work-card:hover .svc-work-meta {
  transform: translateY(0);
  opacity: 1;
}
.svc-work-tag {
  display: inline-block;
  font-family: 'Poppins', sans-serif;
  font-size: 10px; font-weight: 600;
  letter-spacing: 2px; text-transform: uppercase;
  color: #00BFF3;
  border: 1px solid rgba(0,191,243,0.4);
  padding: 4px 10px;
  border-radius: 100px;
  margin-bottom: 10px;
}
.svc-work-client {
  font-family: 'Poppins', sans-serif;
  font-size: 18px; font-weight: 500;
  color: #fff; line-height: 1.2;
  margin: 0;
}
.svc-work-vimeo {
  position: absolute;
  top: 14px; right: 14px;
  z-index: 3;
  background: rgba(0,0,0,0.55);
  backdrop-filter: blur(8px);
  border-radius: 50%;
  width: 40px; height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  pointer-events: none;
}
.svc-work-vimeo svg { width: 14px; height: 14px; margin-left: 2px; }
.svc-work-link-wrap {
  text-align: center;
  margin-top: 48px;
}
.svc-work-link {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-family: 'Poppins', sans-serif;
  font-size: 15px; font-weight: 500;
  color: #8560A8;
  text-decoration: none;
  padding: 12px 28px;
  border: 1px solid rgba(133,96,168,0.3);
  border-radius: 100px;
  transition: all 0.3s ease;
}
.svc-work-link:hover {
  gap: 14px;
  background: rgba(133,96,168,0.06);
  border-color: rgba(133,96,168,0.6);
  color: #5674B9;
}

/* Lightbox */
.svc-lightbox {
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
.svc-lightbox.open { display: flex; opacity: 1; }
.svc-lightbox-inner {
  position: relative;
  max-width: 1100px;
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
}
.svc-lightbox img,
.svc-lightbox iframe {
  max-width: 100%;
  max-height: 75vh;
  border-radius: 8px;
  box-shadow: 0 24px 80px rgba(0,0,0,0.5);
  display: block;
}
.svc-lightbox iframe {
  width: 100%;
  aspect-ratio: 16 / 9;
  border: none;
}
.svc-lightbox-meta {
  margin-top: 18px;
  text-align: center;
  color: #fff;
  font-family: 'Poppins', sans-serif;
}
.svc-lightbox-client { font-size: 22px; font-weight: 500; margin: 0 0 6px; }
.svc-lightbox-tag {
  font-size: 12px; font-weight: 500;
  letter-spacing: 2px; text-transform: uppercase;
  color: #00BFF3; opacity: 0.85;
}
.svc-lightbox-close {
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
.svc-lightbox-close:hover {
  background: rgba(255,255,255,0.2);
  transform: rotate(90deg);
}

/* ========================================
   6. WHY STRETCH — DARK SECTION
   ======================================== */
.svc-why {
  padding: 120px 0;
  background: linear-gradient(170deg, #1a1f2e, #252C3A);
  position: relative;
  overflow: hidden;
}
.svc-why::before {
  content: '';
  position: absolute;
  top: 50%; left: 50%;
  transform: translate(-50%, -50%);
  width: 700px; height: 700px;
  background: radial-gradient(circle, rgba(0,191,243,0.04), transparent);
  pointer-events: none;
}
.svc-why::after {
  content: '';
  position: absolute;
  top: 20%; right: -10%;
  width: 500px; height: 500px;
  background: radial-gradient(circle, rgba(133,96,168,0.04), transparent);
  pointer-events: none;
}
.svc-why .svc-section-heading .svc-overline { color: #00BFF3; }
.svc-why .svc-section-heading h2 { color: #fff; }
.svc-why-intro {
  font-family: 'Assistant', sans-serif;
  font-size: 19px; font-weight: 300; line-height: 1.7;
  color: rgba(255,255,255,0.6);
  text-align: center;
  max-width: 700px; margin: -32px auto 56px;
  position: relative;
}
.svc-benefits-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 32px;
  position: relative;
}
.svc-benefits-grid.svc-benefits-odd .svc-benefit-card:last-child {
  grid-column: 1 / -1;
  max-width: calc(50% - 16px);
  margin: 0 auto;
}
@media (max-width: 960px) {
  .svc-benefits-grid.svc-benefits-odd .svc-benefit-card:last-child {
    max-width: none;
  }
}
.svc-benefit-card {
  background: rgba(255,255,255,0.03);
  border: 1px solid rgba(255,255,255,0.06);
  border-radius: 12px;
  padding: 40px 32px;
  transition: transform 0.5s cubic-bezier(0.16,1,0.3,1), box-shadow 0.5s ease, background 0.4s ease;
  position: relative;
  overflow: hidden;
  transform-style: preserve-3d;
}
/* Animated gradient top border */
.svc-benefit-card::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 3px;
  background: linear-gradient(90deg, #8560A8, #5674B9, #448CCB, #00BFF3, #448CCB, #5674B9, #8560A8);
  background-size: 200% 100%;
  animation: svc-gradientSlide 4s ease infinite;
}
.svc-benefit-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 20px 60px rgba(0,191,243,0.1), 0 0 0 1px rgba(0,191,243,0.15);
  background: rgba(255,255,255,0.05);
}
.svc-benefit-icon {
  width: 52px; height: 52px;
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  margin-bottom: 24px;
  font-family: 'Poppins', sans-serif;
  font-size: 20px; font-weight: 600;
  color: #fff;
  position: relative;
}
.svc-benefit-icon::before {
  content: '';
  position: absolute; inset: 0;
  border-radius: 50%;
  opacity: 0.15;
}
.svc-benefit-icon-1 { background: rgba(133,96,168,0.2); }
.svc-benefit-icon-1::before { background: #8560A8; }
.svc-benefit-icon-2 { background: rgba(86,116,185,0.2); }
.svc-benefit-icon-2::before { background: #5674B9; }
.svc-benefit-icon-3 { background: rgba(68,140,203,0.2); }
.svc-benefit-icon-3::before { background: #448CCB; }
.svc-benefit-icon-4 { background: rgba(0,191,243,0.2); }
.svc-benefit-icon-4::before { background: #00BFF3; }
.svc-benefit-card h3 {
  font-family: 'Poppins', sans-serif;
  font-size: 20px; font-weight: 600;
  color: #fff; margin: 0 0 12px;
}
.svc-benefit-card p {
  font-family: 'Assistant', sans-serif;
  font-size: 16px; font-weight: 300;
  line-height: 1.7; color: rgba(255,255,255,0.55); margin: 0;
}

/* ========================================
   7. TESTIMONIAL
   ======================================== */
.svc-testimonial {
  padding: 100px 0;
  background: #fff;
  position: relative;
}
.svc-testimonial-inner {
  max-width: 800px;
  margin: 0 auto;
  text-align: center;
  position: relative;
}
.svc-testimonial-quote-mark {
  font-family: Georgia, serif;
  font-size: 140px; line-height: 1;
  color: rgba(133,96,168,0.08);
  position: absolute;
  top: -60px; left: 50%;
  transform: translateX(-50%);
  user-select: none;
}
.svc-testimonial-text {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(18px, 2.5vw, 24px);
  font-weight: 400;
  color: #323A51; line-height: 1.6;
  margin: 0 0 32px;
  font-style: italic;
  position: relative;
}
.svc-testimonial-attr {
  font-family: 'Poppins', sans-serif;
  font-size: 15px; font-weight: 600;
  color: #8560A8;
}
.svc-testimonial-attr span {
  font-weight: 300; color: #888;
  margin-left: 8px;
}
/* Multi-testimonial grid */
.svc-testimonials-heading {
  text-align: center;
  margin-bottom: 56px;
}
.svc-testimonials-heading .svc-overline {
  font-family: 'Montserrat', sans-serif;
  font-size: 12px; letter-spacing: 3px;
  text-transform: uppercase; color: #00BFF3;
  display: block; margin-bottom: 16px;
}
.svc-testimonials-heading h2 {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(30px, 3.6vw, 42px);
  font-weight: 600; color: #252C3A; margin: 0 0 10px;
  letter-spacing: -0.5px;
}
.svc-testimonials-sub {
  font-family: 'Assistant', sans-serif;
  font-size: 17px; font-weight: 300;
  color: #5b6275; margin: 0 auto;
  max-width: 620px; line-height: 1.6;
}
.svc-testimonials-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 28px;
  max-width: 1180px;
  margin: 0 auto;
}
.svc-testimonials-grid.svc-testimonials-2 {
  grid-template-columns: repeat(2, 1fr);
  max-width: 880px;
}
.svc-testimonial-card {
  background: #fff;
  border-radius: 14px;
  padding: 44px 30px 30px;
  position: relative;
  border: 1px solid rgba(37,44,58,0.06);
  box-shadow: 0 4px 24px rgba(37,44,58,0.05);
  transition: transform 0.55s cubic-bezier(0.16,1,0.3,1), box-shadow 0.5s ease;
  display: flex;
  flex-direction: column;
  overflow: hidden;
}
.svc-testimonial-card::after {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 3px;
  background: linear-gradient(90deg, #8560A8, #5674B9, #00BFF3);
  opacity: 0.85;
}
.svc-testimonial-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 18px 44px rgba(37,44,58,0.12);
}
.svc-testimonial-card-mark {
  font-family: Georgia, serif;
  font-size: 72px; line-height: 0.6;
  color: rgba(133,96,168,0.16);
  margin: 0 0 6px;
  user-select: none;
}
.svc-testimonial-card-quote {
  font-family: 'Poppins', sans-serif;
  font-size: 15.5px; font-weight: 400;
  font-style: italic;
  color: #323A51; line-height: 1.7;
  margin: 0 0 24px;
  flex: 1;
}
.svc-testimonial-card-attr {
  margin-top: auto;
  padding-top: 18px;
  border-top: 1px solid rgba(37,44,58,0.08);
}
.svc-testimonial-card-name {
  font-family: 'Poppins', sans-serif;
  font-size: 14.5px; font-weight: 600;
  color: #8560A8;
  margin: 0 0 4px;
  letter-spacing: 0.1px;
}
.svc-testimonial-card-title {
  font-family: 'Assistant', sans-serif;
  font-size: 13px; font-weight: 300;
  color: #6e7488;
  line-height: 1.45;
}

/* ========================================
   8. FAQ ACCORDION
   ======================================== */
.svc-faq {
  padding: 120px 0;
  background: #f9f9fb;
  position: relative;
}
.svc-accordion {
  max-width: 800px;
  margin: 0 auto;
  list-style: none; padding: 0;
}
.svc-accordion-item {
  margin-bottom: 12px;
  background: #fff;
  border-radius: 10px;
  border: 1px solid rgba(0,0,0,0.06);
  border-left: 4px solid rgba(133,96,168,0.2);
  overflow: hidden;
  transition: border-color 0.4s ease, box-shadow 0.4s ease;
}
.svc-accordion-item.svc-acc-open {
  border-left-color: transparent;
  box-shadow: 0 8px 32px rgba(37,44,58,0.06);
}
.svc-accordion-item.svc-acc-open::before {
  opacity: 1;
}
/* Gradient left border on open */
.svc-accordion-item {
  position: relative;
}
.svc-accordion-item::after {
  content: '';
  position: absolute;
  left: -4px; top: 0; bottom: 0;
  width: 4px;
  background: linear-gradient(180deg, #8560A8, #5674B9, #00BFF3);
  opacity: 0;
  transition: opacity 0.4s ease;
  border-radius: 2px 0 0 2px;
}
.svc-accordion-item.svc-acc-open::after {
  opacity: 1;
}
.svc-accordion-trigger {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
  padding: 24px 28px;
  background: none; border: none;
  cursor: pointer;
  font-family: 'Poppins', sans-serif;
  font-size: 17px; font-weight: 500;
  color: #252C3A;
  text-align: left;
  transition: color 0.3s ease, font-weight 0.3s ease;
}
.svc-accordion-trigger:hover { color: #8560A8; }
.svc-accordion-trigger[aria-expanded="true"] {
  color: #8560A8;
  font-weight: 600;
}
.svc-accordion-icon {
  flex-shrink: 0;
  width: 28px; height: 28px;
  position: relative;
  transition: transform 0.4s cubic-bezier(0.16,1,0.3,1);
}
.svc-accordion-icon::before,
.svc-accordion-icon::after {
  content: '';
  position: absolute;
  background: currentColor;
  border-radius: 2px;
  transition: transform 0.4s cubic-bezier(0.16,1,0.3,1);
}
.svc-accordion-icon::before {
  width: 16px; height: 2px;
  top: 50%; left: 50%;
  transform: translate(-50%, -50%);
}
.svc-accordion-icon::after {
  width: 2px; height: 16px;
  top: 50%; left: 50%;
  transform: translate(-50%, -50%);
}
.svc-accordion-trigger[aria-expanded="true"] .svc-accordion-icon {
  transform: rotate(45deg);
}
.svc-accordion-panel {
  overflow: hidden;
  max-height: 0;
  transition: max-height 0.5s cubic-bezier(0.16, 1, 0.3, 1);
}
.svc-accordion-panel-inner {
  padding: 0 28px 28px;
  font-family: 'Assistant', sans-serif;
  font-size: 16px; font-weight: 300;
  line-height: 1.7; color: #555;
}

/* ========================================
   9. FULL-VIEWPORT CTA
   ======================================== */
.svc-cta-full {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  position: relative;
  overflow: hidden;
  background: linear-gradient(170deg, #8560A8, #3d2d66 30%, #252C3A 70%, #1a1f2e);
}
.svc-cta-full::before {
  content: '';
  position: absolute;
  top: 30%; left: 50%;
  transform: translate(-50%, -50%);
  width: 800px; height: 800px;
  background: radial-gradient(circle, rgba(0,191,243,0.08), transparent 70%);
  pointer-events: none;
}
.svc-cta-shapes {
  position: absolute; inset: 0;
  pointer-events: none;
}
.svc-cta-shape {
  position: absolute;
  border-radius: 50%; opacity: 0.08;
  animation: svc-ctaFloat 12s ease-in-out infinite alternate;
}
.svc-cta-shape-1 {
  width: 200px; height: 200px;
  top: 15%; left: 10%;
  background: radial-gradient(circle, #00BFF3, transparent);
  animation-delay: 0s;
}
.svc-cta-shape-2 {
  width: 300px; height: 300px;
  bottom: 10%; right: 15%;
  background: radial-gradient(circle, #8560A8, transparent);
  animation-delay: -4s;
}
.svc-cta-shape-3 {
  width: 120px; height: 120px;
  top: 60%; left: 70%;
  background: radial-gradient(circle, #5674B9, transparent);
  animation-delay: -2s;
  border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
}
.svc-cta-shape-4 {
  width: 160px; height: 160px;
  top: 30%; right: 20%;
  background: radial-gradient(circle, #448CCB, transparent);
  animation-delay: -6s;
}
@keyframes svc-ctaFloat {
  0% { transform: translate(0, 0) rotate(0deg); }
  100% { transform: translate(30px, -30px) rotate(15deg); }
}
.svc-cta-content {
  position: relative; z-index: 1;
  max-width: 700px; padding: 0 40px;
}
.svc-cta-content h2 {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(36px, 5vw, 56px);
  font-weight: 600; color: #fff;
  margin: 0 0 24px; line-height: 1.15;
}
.svc-cta-content p {
  font-family: 'Assistant', sans-serif;
  font-size: 19px; font-weight: 300;
  color: rgba(255,255,255,0.6);
  margin-bottom: 44px; line-height: 1.7;
}
.svc-cta-buttons {
  display: flex; gap: 20px;
  justify-content: center; flex-wrap: wrap;
}
.svc-cta-btn-primary {
  display: inline-block;
  font-family: 'Poppins', sans-serif;
  font-size: 15px; font-weight: 500;
  color: #fff;
  background: linear-gradient(135deg, #00BFF3, #5674B9);
  padding: 18px 44px; border-radius: 6px;
  text-decoration: none;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  box-shadow: 0 4px 20px rgba(0,191,243,0.3);
}
.svc-cta-btn-primary:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 30px rgba(0,191,243,0.45);
}
.svc-cta-btn-outline {
  display: inline-block;
  font-family: 'Poppins', sans-serif;
  font-size: 15px; font-weight: 500;
  color: #fff;
  border: 1px solid rgba(255,255,255,0.3);
  padding: 18px 44px; border-radius: 6px;
  text-decoration: none;
  transition: all 0.3s ease;
}
.svc-cta-btn-outline:hover {
  background: rgba(255,255,255,0.08);
  border-color: rgba(255,255,255,0.6);
}

/* ========================================
   RESPONSIVE
   ======================================== */
@media (max-width: 960px) {
  .svc-stats-inner { grid-template-columns: repeat(2, 1fr); }
  .svc-benefits-grid { grid-template-columns: 1fr; }
  .svc-testimonials-grid { grid-template-columns: 1fr; max-width: 560px; }
  .svc-testimonials-grid.svc-testimonials-2 { grid-template-columns: 1fr; max-width: 560px; }
  .svc-offering-row {
    grid-template-columns: 80px 1fr;
    gap: 28px;
    padding: 36px 28px;
  }
  .svc-offering-row.svc-offering-even {
    grid-template-columns: 1fr 80px;
  }
}
@media (max-width: 768px) {
  .svc-container { padding: 0 24px; }
  .svc-hero { padding: 120px 0 80px; min-height: 70vh; }
  .svc-hero-content h1 { font-size: 34px; letter-spacing: -0.5px; }
  .svc-offerings { padding: 80px 0; }
  .svc-offering-row,
  .svc-offering-row.svc-offering-even {
    grid-template-columns: 1fr;
    gap: 12px;
    text-align: left;
    padding: 28px 24px;
  }
  .svc-offering-row.svc-offering-even .svc-offering-number { order: 0; }
  .svc-offering-row.svc-offering-even .svc-offering-body { order: 0; }
  .svc-offering-row.svc-offering-even .svc-offering-body p { margin-left: 0; }
  .svc-offering-number { font-size: 48px; }
  .svc-problem { padding: 80px 0 70px; }
  .svc-solution { padding: 70px 0 80px; }
  .svc-process { padding: 80px 0; }
  .svc-process-steps::before { left: 29px; }
  .svc-process-step { grid-template-columns: 60px 1fr; gap: 20px; }
  .svc-process-num { width: 60px; height: 60px; font-size: 17px; }
  .svc-process-body { padding-top: 8px; }
  .svc-process-body h3 { font-size: 19px; }
  .svc-why { padding: 80px 0; }
  .svc-testimonial { padding: 70px 0; }
  .svc-faq { padding: 80px 0; }
  .svc-pull-quote { padding: 70px 0; }
  .svc-pull-quote blockquote { font-size: 20px; }
  .svc-pull-quote blockquote::before,
  .svc-pull-quote blockquote::after { font-size: 80px; }
  .svc-cta-full { min-height: 80vh; }
  .svc-cta-content h2 { font-size: 32px; }
  .svc-stats-inner { grid-template-columns: repeat(2, 1fr); gap: 20px; }
  .svc-cta-buttons { flex-direction: column; align-items: center; }
  .svc-cta-btn-primary, .svc-cta-btn-outline { width: 100%; text-align: center; }
}
@media (max-width: 480px) {
  .svc-container { padding: 0 16px; }
  .svc-hero { padding: 100px 0 60px; min-height: auto; }
  .svc-hero-content h1 { font-size: 28px; }
  .svc-hero-content .svc-subtitle { font-size: 16px; }
  .svc-stats-inner { grid-template-columns: 1fr 1fr; gap: 16px; }
  .svc-stat-number { font-size: 28px; }
  .svc-stat-label { font-size: 11px; letter-spacing: 1px; }
  .svc-offering-body h3 { font-size: 18px; }
  .svc-offering-body p { font-size: 15px; }
  .svc-accordion-trigger { font-size: 15px; padding: 20px 20px; }
  .svc-accordion-panel-inner { padding: 0 20px 20px; }
  .svc-benefit-card { padding: 28px 24px; }
  .svc-benefit-card h3 { font-size: 18px; }
  .svc-testimonial-text { font-size: 17px; }
  .svc-cta-full { min-height: 100svh; padding: 60px 0; }
  .svc-cta-content { padding: 0 20px; }
  .svc-cta-content h2 { font-size: 26px; margin-bottom: 16px; }
  .svc-section-heading h2 { font-size: 28px; }
  .svc-pull-quote blockquote { font-size: 18px; padding: 0 10px; }
  .svc-pull-quote blockquote::before { left: -10px; top: -30px; font-size: 60px; }
  .svc-pull-quote blockquote::after { right: -10px; bottom: -50px; font-size: 60px; }
}

/* ---------- REDUCED MOTION ---------- */
@media (prefers-reduced-motion: reduce) {
  .svc-grain-overlay::before { animation: none !important; }
  .svc-reveal, .svc-reveal-left, .svc-reveal-right {
    opacity: 1 !important; transform: none !important;
    transition: none !important;
  }
  .svc-accent-bar { animation: none !important; }
  .svc-benefit-card::before { animation: none !important; }
  .svc-cta-shape { animation: none !important; }
}
</style>


<!-- ========================================
     1. CINEMATIC HERO
     ======================================== -->
<section class="svc-section svc-hero" aria-label="Hero" id="svcHero">
  <div class="svc-hero-mesh"></div>
  <div class="svc-hero-grid" id="svcHeroGrid"><div class="svc-grid-container" id="svcGridContainer"></div></div>

  <div class="svc-container">
    <div class="svc-hero-content">
      <span class="svc-hero-overline svc-reveal svc-delay-1">Our Services</span>
      <h1 class="svc-reveal svc-delay-2"><?php echo wp_kses_post($headline); ?></h1>
      <?php if ($subheadline) : ?>
        <p class="svc-subtitle svc-reveal svc-delay-3"><?php echo esc_html($subheadline); ?></p>
      <?php endif; ?>
      <?php if ($hero_text) : ?>
        <p class="svc-hero-body svc-reveal svc-delay-3"><?php echo esc_html($hero_text); ?></p>
      <?php endif; ?>
      <a href="<?php echo esc_url($hero_cta_url); ?>" class="svc-btn-primary svc-reveal svc-delay-4"><span><?php echo esc_html($hero_cta_label); ?> &rarr;</span></a>
    </div>
  </div>

  <div class="svc-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none">
      <polygon points="0,60 1440,0 1440,60" fill="#1a1f2e"/>
    </svg>
  </div>
</section>


<!-- ========================================
     2. GRADIENT ACCENT BAR
     ======================================== -->
<div class="svc-accent-bar"></div>


<!-- ========================================
     3. STATS BAR
     ======================================== -->
<section class="svc-section svc-stats-bar" aria-label="Key Statistics" id="svcStatsBar">
  <div class="svc-container">
    <div class="svc-stats-inner">
      <?php foreach ($stats as $stat) :
        $is_numeric = is_numeric($stat['value']);
      ?>
        <div class="svc-stat-item svc-reveal svc-delay-<?php echo min(($stat === $stats[0] ? 1 : ($stat === $stats[1] ? 2 : ($stat === $stats[2] ? 3 : 4))), 4); ?>">
          <div class="svc-stat-number">
            <?php if ($is_numeric) : ?>
              <span class="svc-count" data-target="<?php echo esc_attr($stat['value']); ?>">0</span><span class="svc-suffix"><?php echo esc_html($stat['suffix']); ?></span>
            <?php else : ?>
              <span style="font-size:0.6em;"><?php echo esc_html($stat['value']); ?></span>
            <?php endif; ?>
          </div>
          <div class="svc-stat-label"><?php echo esc_html($stat['label']); ?></div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>


<!-- ========================================
     3.5 PROBLEM / SOLUTION (optional)
     ======================================== -->
<?php if (!empty($problem)) :
  $p_heading = !empty($problem['heading']) ? $problem['heading'] : '';
  $p_sub     = !empty($problem['subheading']) ? $problem['subheading'] : '';
  $p_text    = !empty($problem['text']) ? $problem['text'] : '';
  $p_overline = !empty($problem['overline']) ? $problem['overline'] : 'The Reality';
?>
<section class="svc-section svc-problem" aria-label="The Problem">
  <div class="svc-container">
    <div class="svc-problem-inner">
      <span class="svc-problem-overline svc-reveal"><?php echo esc_html($p_overline); ?></span>
      <?php if ($p_heading) : ?>
        <h2 class="svc-reveal svc-delay-1"><?php echo esc_html($p_heading); ?></h2>
      <?php endif; ?>
      <?php if ($p_sub) : ?>
        <p class="svc-problem-sub svc-reveal svc-delay-2"><?php echo esc_html($p_sub); ?></p>
      <?php endif; ?>
      <?php if ($p_text) : ?>
        <p class="svc-problem-text svc-reveal svc-delay-3"><?php echo wp_kses_post($p_text); ?></p>
      <?php endif; ?>
    </div>
  </div>

  <div class="svc-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none">
      <polygon points="0,60 1440,0 1440,60" fill="#ffffff"/>
    </svg>
  </div>
</section>
<?php endif; ?>


<?php if (!empty($solution)) :
  $s_heading = !empty($solution['heading']) ? $solution['heading'] : '';
  $s_sub     = !empty($solution['subheading']) ? $solution['subheading'] : '';
  $s_text    = !empty($solution['text']) ? $solution['text'] : '';
  $s_overline = !empty($solution['overline']) ? $solution['overline'] : 'The Solution';
  $s_cta_label = !empty($solution['cta_label']) ? $solution['cta_label'] : '';
  $s_cta_url   = !empty($solution['cta_url']) ? $solution['cta_url'] : '/contact-stretch-creative/';
?>
<section class="svc-section svc-solution" aria-label="The Solution">
  <div class="svc-container">
    <div class="svc-solution-inner">
      <span class="svc-solution-overline svc-reveal"><?php echo esc_html($s_overline); ?></span>
      <?php if ($s_heading) : ?>
        <h2 class="svc-reveal svc-delay-1"><?php echo esc_html($s_heading); ?></h2>
      <?php endif; ?>
      <?php if ($s_sub) : ?>
        <p class="svc-solution-sub svc-reveal svc-delay-2"><?php echo esc_html($s_sub); ?></p>
      <?php endif; ?>
      <?php if ($s_text) : ?>
        <p class="svc-solution-text svc-reveal svc-delay-3"><?php echo wp_kses_post($s_text); ?></p>
      <?php endif; ?>
      <?php if ($s_cta_label) : ?>
        <a href="<?php echo esc_url($s_cta_url); ?>" class="svc-btn-primary svc-reveal svc-delay-4"><span><?php echo esc_html($s_cta_label); ?> &rarr;</span></a>
      <?php endif; ?>
    </div>
  </div>

  <div class="svc-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none">
      <polygon points="0,60 1440,0 1440,60" fill="#f9f9fb"/>
    </svg>
  </div>
</section>
<?php endif; ?>


<!-- ========================================
     4. PULL QUOTE BANNER
     ======================================== -->
<section class="svc-section svc-pull-quote" aria-label="Pull Quote">
  <div class="svc-container">
    <blockquote class="svc-reveal"><?php echo $pull_quote; ?></blockquote>
  </div>

  <div class="svc-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none">
      <polygon points="0,0 1440,60 1440,60 0,60" fill="#ffffff"/>
    </svg>
  </div>
</section>


<!-- ========================================
     5. OFFERINGS — ALTERNATING SHOWCASE
     ======================================== -->
<?php if (!empty($offerings)) : ?>
<section class="svc-section svc-offerings" aria-label="What We Deliver">
  <div class="svc-container">
    <div class="svc-section-heading">
      <span class="svc-overline svc-reveal"><?php echo esc_html($offerings_overline); ?></span>
      <h2 class="svc-reveal svc-delay-1"><?php
        $owords = explode(' ', $offerings_heading);
        if (count($owords) >= 2) {
          $olast = array_pop($owords);
          echo esc_html(implode(' ', $owords)) . ' <span class="svc-gradient-text">' . esc_html($olast) . '</span>';
        } else {
          echo esc_html($offerings_heading);
        }
      ?></h2>
      <?php if (!empty($offerings_subheading)) : ?>
        <p class="svc-offerings-sub svc-reveal svc-delay-2"><?php echo esc_html($offerings_subheading); ?></p>
      <?php endif; ?>
      <?php if (!empty($offerings_intro)) : ?>
        <p class="svc-offerings-intro svc-reveal svc-delay-3"><?php echo wp_kses_post($offerings_intro); ?></p>
      <?php endif; ?>
    </div>

    <div class="svc-offering-list">
      <?php foreach ($offerings as $i => $item) :
        $num    = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
        $is_even = ($i % 2 === 1);
        $anim    = $is_even ? 'svc-reveal-right' : 'svc-reveal-left';
      ?>
        <div class="svc-offering-row <?php echo $is_even ? 'svc-offering-even' : ''; ?> <?php echo $anim; ?>">
          <div class="svc-offering-number"><?php echo $num; ?></div>
          <div class="svc-offering-body">
            <h3><?php echo esc_html($item['title']); ?></h3>
            <p><?php echo esc_html($item['description']); ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="svc-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none">
      <polygon points="0,60 1440,0 1440,60" fill="#f9f9fb"/>
    </svg>
  </div>
</section>
<?php endif; ?>


<!-- ========================================
     5.25 PROCESS / HOW IT WORKS (optional)
     ======================================== -->
<?php
// Pre-compute portfolio existence for divider logic below
$service_portfolio = function_exists('stretch_get_portfolio_for_service')
    ? stretch_get_portfolio_for_service($slug)
    : [];
$has_portfolio = !empty($service_portfolio);
?>
<?php if (!empty($process) && !empty($process['steps'])) :
  $pr_heading  = !empty($process['heading'])  ? $process['heading']  : 'How It Works';
  $pr_sub      = !empty($process['subheading']) ? $process['subheading'] : '';
  $pr_intro    = !empty($process['intro'])    ? $process['intro']    : '';
  $pr_overline = !empty($process['overline']) ? $process['overline'] : 'Process';
  $pr_steps    = $process['steps'];
?>
<section class="svc-section svc-process" aria-label="How It Works">
  <div class="svc-container">
    <div class="svc-section-heading">
      <span class="svc-overline svc-reveal"><?php echo esc_html($pr_overline); ?></span>
      <h2 class="svc-reveal svc-delay-1"><?php
        // Highlight the last word with gradient if heading has 2+ words
        $words = explode(' ', $pr_heading);
        if (count($words) >= 2) {
          $last = array_pop($words);
          echo esc_html(implode(' ', $words)) . ' <span class="svc-gradient-text">' . esc_html($last) . '</span>';
        } else {
          echo esc_html($pr_heading);
        }
      ?></h2>
    </div>

    <?php if ($pr_sub) : ?>
      <p class="svc-process-sub svc-reveal svc-delay-2"><?php echo esc_html($pr_sub); ?></p>
    <?php endif; ?>
    <?php if ($pr_intro) : ?>
      <p class="svc-process-intro svc-reveal svc-delay-3"><?php echo wp_kses_post($pr_intro); ?></p>
    <?php endif; ?>

    <ol class="svc-process-steps">
      <?php foreach ($pr_steps as $i => $step) :
        $num = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
        $delay = min(($i % 4) + 1, 4);
      ?>
        <li class="svc-process-step svc-reveal-left svc-delay-<?php echo $delay; ?>">
          <div class="svc-process-num" aria-hidden="true"><?php echo $num; ?></div>
          <div class="svc-process-body">
            <h3><?php echo esc_html($step['title']); ?></h3>
            <p><?php echo esc_html($step['description']); ?></p>
          </div>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>

  <?php if (!$has_portfolio) : ?>
  <div class="svc-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none">
      <polygon points="0,60 1440,0 1440,60" fill="#1a1f2e"/>
    </svg>
  </div>
  <?php endif; ?>
</section>
<?php endif; ?>


<!-- ========================================
     5.5 SELECTED WORK — INLINE PORTFOLIO STRIP
     ======================================== -->
<?php
if ($has_portfolio) :
    $grid_class = count($service_portfolio) <= 2 ? 'svc-work-grid svc-work-grid-2' : 'svc-work-grid';
?>
<section class="svc-section svc-selected-work" aria-label="Selected Work">
  <div class="svc-container">
    <div class="svc-section-heading">
      <span class="svc-overline svc-reveal">Recent Work</span>
      <h2 class="svc-reveal svc-delay-1">Selected <span class="svc-gradient-text">Work</span></h2>
    </div>

    <div class="<?php echo $grid_class; ?>">
      <?php foreach ($service_portfolio as $i => $item) :
        $img = wp_get_attachment_image_url($item['id'], 'large');
        $img_full = wp_get_attachment_image_url($item['id'], 'full');
        $alt = get_post_meta($item['id'], '_wp_attachment_image_alt', true);
        if (!$img) continue;
      ?>
        <a href="#" class="svc-work-card svc-reveal svc-delay-<?php echo (($i % 4) + 1); ?>"
           data-img="<?php echo esc_url($img_full); ?>"
           data-client="<?php echo esc_attr($item['client']); ?>"
           data-tag="<?php echo esc_attr($item['subcat']); ?>"
           <?php if (!empty($item['vimeo'])) : ?>data-vimeo="<?php echo esc_attr($item['vimeo']); ?>"<?php endif; ?>
           aria-label="<?php echo esc_attr($item['client'] . ' — ' . $item['subcat']); ?>">
          <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($alt ?: $item['client'] . ' ' . $item['subcat']); ?>" loading="lazy">
          <?php if (!empty($item['vimeo'])) : ?>
          <div class="svc-work-vimeo" aria-hidden="true">
            <svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z" fill="#fff"/></svg>
          </div>
          <?php endif; ?>
          <div class="svc-work-overlay"></div>
          <div class="svc-work-meta">
            <span class="svc-work-tag"><?php echo esc_html($item['subcat']); ?></span>
            <h3 class="svc-work-client"><?php echo esc_html($item['client']); ?></h3>
          </div>
        </a>
      <?php endforeach; ?>
    </div>

    <div class="svc-work-link-wrap svc-reveal">
      <a href="/our-work/" class="svc-work-link">View all work &rarr;</a>
    </div>
  </div>

  <div class="svc-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none">
      <polygon points="0,60 1440,0 1440,60" fill="#1a1f2e"/>
    </svg>
  </div>
</section>

<!-- Lightbox for selected work -->
<div class="svc-lightbox" id="svcLightbox" role="dialog" aria-modal="true" aria-hidden="true">
  <button class="svc-lightbox-close" id="svcLightboxClose" aria-label="Close">&times;</button>
  <div class="svc-lightbox-inner" id="svcLightboxInner"></div>
</div>
<?php endif; ?>


<!-- ========================================
     6. WHY STRETCH — DARK SECTION
     ======================================== -->
<?php if (!empty($benefits)) : ?>
<section class="svc-section svc-why" aria-label="Why Stretch" id="svcWhy">
  <div class="svc-container">
    <div class="svc-section-heading">
      <span class="svc-overline svc-reveal">The Difference</span>
      <h2 class="svc-reveal svc-delay-1"><?php echo esc_html($why_heading); ?></h2>
    </div>

    <?php if ($why_intro) : ?>
      <p class="svc-why-intro svc-reveal svc-delay-2"><?php echo esc_html($why_intro); ?></p>
    <?php endif; ?>

    <div class="svc-benefits-grid<?php echo (count($benefits) % 2 === 1 && count($benefits) > 2) ? ' svc-benefits-odd' : ''; ?>">
      <?php foreach ($benefits as $i => $item) :
        $accent = ($i % 4) + 1;
        $delay  = ($i % 4) + 1;
        $icons  = ['&#9733;', '&#9670;', '&#9679;', '&#9650;'];
      ?>
        <div class="svc-benefit-card svc-reveal svc-delay-<?php echo $delay; ?>">
          <div class="svc-benefit-icon svc-benefit-icon-<?php echo $accent; ?>"><?php echo $icons[$i % 4]; ?></div>
          <h3><?php echo esc_html($item['title']); ?></h3>
          <p><?php echo esc_html($item['description']); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="svc-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none">
      <polygon points="0,0 1440,60 1440,60 0,60" fill="#ffffff"/>
    </svg>
  </div>
</section>
<?php endif; ?>


<!-- ========================================
     7. TESTIMONIAL(S)
     ======================================== -->
<?php
$has_multi_testimonials = is_array($testimonials_list) && count($testimonials_list) >= 2;
?>
<section class="svc-section svc-testimonial" aria-label="<?php echo $has_multi_testimonials ? 'Client Testimonials' : 'Testimonial'; ?>">
  <div class="svc-container">
    <?php if ($has_multi_testimonials) :
      $tm_count = count($testimonials_list);
      $grid_class = $tm_count === 2 ? 'svc-testimonials-grid svc-testimonials-2' : 'svc-testimonials-grid';
      $tm_heading    = !empty($service['testimonials_heading']) ? $service['testimonials_heading'] : 'What Our Clients Say';
      $tm_subheading = !empty($service['testimonials_subheading']) ? $service['testimonials_subheading'] : '';
    ?>
      <div class="svc-testimonials-heading">
        <span class="svc-overline svc-reveal">Social Proof</span>
        <h2 class="svc-reveal svc-delay-1"><?php echo esc_html($tm_heading); ?></h2>
        <?php if ($tm_subheading) : ?>
          <p class="svc-testimonials-sub svc-reveal svc-delay-2"><?php echo esc_html($tm_subheading); ?></p>
        <?php endif; ?>
      </div>

      <div class="<?php echo esc_attr($grid_class); ?>">
        <?php foreach ($testimonials_list as $i => $tm) :
          $delay = min(($i % 3) + 1, 4);
        ?>
          <article class="svc-testimonial-card svc-reveal svc-delay-<?php echo $delay; ?>">
            <div class="svc-testimonial-card-mark" aria-hidden="true">&ldquo;</div>
            <p class="svc-testimonial-card-quote">&ldquo;<?php echo esc_html($tm['quote']); ?>&rdquo;</p>
            <div class="svc-testimonial-card-attr">
              <div class="svc-testimonial-card-name"><?php echo esc_html($tm['name']); ?></div>
              <div class="svc-testimonial-card-title"><?php echo esc_html($tm['title']); ?></div>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    <?php else : ?>
      <div class="svc-testimonial-inner svc-reveal">
        <div class="svc-testimonial-quote-mark" aria-hidden="true">&ldquo;</div>
        <p class="svc-testimonial-text">&ldquo;<?php echo esc_html($testimonial['quote']); ?>&rdquo;</p>
        <div class="svc-testimonial-attr">
          <?php echo esc_html($testimonial['name']); ?>
          <span>&mdash; <?php echo esc_html($testimonial['title']); ?></span>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <div class="svc-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none">
      <polygon points="0,60 1440,0 1440,60" fill="#f9f9fb"/>
    </svg>
  </div>
</section>


<!-- ========================================
     8. FAQ ACCORDION
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
     9. FULL-VIEWPORT CTA
     ======================================== -->
<section class="svc-section svc-cta-full" aria-label="Call to Action" id="svcCta">
  <div class="svc-cta-shapes">
    <div class="svc-cta-shape svc-cta-shape-1"></div>
    <div class="svc-cta-shape svc-cta-shape-2"></div>
    <div class="svc-cta-shape svc-cta-shape-3"></div>
    <div class="svc-cta-shape svc-cta-shape-4"></div>
  </div>

  <div class="svc-cta-content">
    <?php
      $cta_heading      = !empty($cta['heading'])      ? $cta['heading']      : 'Ready to Get Started?';
      $cta_subheading   = !empty($cta['subheading'])   ? $cta['subheading']   : '';
      $cta_text         = !empty($cta['text'])         ? $cta['text']         : 'Tell us about your project and we&rsquo;ll show you how Stretch can help.';
      $cta_button_label = !empty($cta['button_label']) ? $cta['button_label'] : 'Start a Project';
      $cta_button_url   = !empty($cta['button_url'])   ? $cta['button_url']   : '/contact-stretch-creative/';
      $cta_secondary    = array_key_exists('secondary', $cta) ? $cta['secondary'] : ['label' => 'Learn About Us', 'url' => '/about-stretch-creative/'];
      // Allow the heading to highlight the last 2 words; if user-supplied, render as-is.
      $cta_heading_html = !empty($cta['heading']) ? esc_html($cta_heading) : 'Ready to <span class="svc-gradient-text">Get Started</span>?';
    ?>
    <h2 class="svc-reveal"><?php echo $cta_heading_html; ?></h2>
    <?php if ($cta_subheading) : ?>
      <p class="svc-cta-sub svc-reveal svc-delay-1"><?php echo esc_html($cta_subheading); ?></p>
    <?php endif; ?>
    <p class="svc-reveal svc-delay-1"><?php echo wp_kses_post($cta_text); ?></p>
    <div class="svc-cta-buttons svc-reveal svc-delay-2">
      <a href="<?php echo esc_url($cta_button_url); ?>" class="svc-cta-btn-primary"><?php echo esc_html($cta_button_label); ?> &rarr;</a>
      <?php if (!empty($cta_secondary) && !empty($cta_secondary['label'])) : ?>
        <a href="<?php echo esc_url($cta_secondary['url']); ?>" class="svc-cta-btn-outline"><?php echo esc_html($cta_secondary['label']); ?></a>
      <?php endif; ?>
    </div>
  </div>
</section>


<script>
(function() {
  var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var isTouchDevice = 'ontouchstart' in window || navigator.maxTouchPoints > 0;

  /* ---------- SCROLL REVEAL ---------- */
  var revealObserver = new IntersectionObserver(function(entries) {
    entries.forEach(function(entry) {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        revealObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });

  document.querySelectorAll('.svc-reveal, .svc-reveal-left, .svc-reveal-right').forEach(function(el) {
    revealObserver.observe(el);
  });

  /* ---------- COUNTER ANIMATION ---------- */
  function animateCount(el) {
    var target = parseFloat(el.dataset.target);
    var decimals = parseInt(el.dataset.decimals || '0', 10);
    if (isNaN(target)) return;
    var duration = 2000;
    var start = performance.now();
    function tick(now) {
      var elapsed = now - start;
      var progress = Math.min(elapsed / duration, 1);
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
        var counts = entry.target.querySelectorAll('.svc-count');
        counts.forEach(animateCount);
        countObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.3 });
  var statsBar = document.getElementById('svcStatsBar');
  if (statsBar) countObserver.observe(statsBar);

  /* ---------- ACCORDION ---------- */
  document.querySelectorAll('.svc-accordion-trigger').forEach(function(btn) {
    btn.addEventListener('click', function() {
      var expanded = btn.getAttribute('aria-expanded') === 'true';
      var panel = document.getElementById(btn.getAttribute('aria-controls'));
      var item = btn.closest('.svc-accordion-item');

      // Close all others
      document.querySelectorAll('.svc-accordion-trigger').forEach(function(other) {
        if (other !== btn) {
          other.setAttribute('aria-expanded', 'false');
          var otherPanel = document.getElementById(other.getAttribute('aria-controls'));
          if (otherPanel) otherPanel.style.maxHeight = '0';
          var otherItem = other.closest('.svc-accordion-item');
          if (otherItem) otherItem.classList.remove('svc-acc-open');
        }
      });

      // Toggle current
      if (expanded) {
        btn.setAttribute('aria-expanded', 'false');
        panel.style.maxHeight = '0';
        item.classList.remove('svc-acc-open');
      } else {
        btn.setAttribute('aria-expanded', 'true');
        panel.style.maxHeight = panel.scrollHeight + 'px';
        item.classList.add('svc-acc-open');
      }
    });
  });

  /* ---------- HERO GRID GENERATION ---------- */
  var gridContainer = document.getElementById('svcGridContainer');
  var heroSection = document.getElementById('svcHero');
  if (gridContainer && heroSection) {
    var cellSize = 60;
    var cols = Math.ceil((window.innerWidth + 120) / cellSize);
    var rows = Math.ceil((window.innerHeight + 120) / cellSize);
    var totalCells = cols * rows;
    var coloredCount = Math.floor(totalCells * 0.18);

    var gradients = [
      'rgba(133,96,168,0.18)',
      'rgba(133,96,168,0.14)',
      'rgba(86,116,185,0.16)',
      'rgba(86,116,185,0.12)',
      'rgba(0,191,243,0.14)',
      'rgba(0,191,243,0.10)',
      'rgba(68,140,203,0.14)',
      'rgba(133,96,168,0.22)',
      'rgba(0,191,243,0.18)',
    ];

    // Pick random indices for colored cells
    var coloredIndices = new Set();
    while (coloredIndices.size < coloredCount) {
      coloredIndices.add(Math.floor(Math.random() * totalCells));
    }

    var fragment = document.createDocumentFragment();
    for (var i = 0; i < totalCells; i++) {
      var cell = document.createElement('div');
      cell.className = 'svc-grid-cell';
      if (coloredIndices.has(i)) {
        cell.classList.add('colored');
        cell.style.setProperty('--cell-color', gradients[Math.floor(Math.random() * gradients.length)]);
        cell.style.setProperty('--cell-delay', (Math.random() * 4).toFixed(1) + 's');
      }
      fragment.appendChild(cell);
    }
    gridContainer.appendChild(fragment);

    // Mouse tracking for grid parallax
    if (!isTouchDevice && !reducedMotion && window.innerWidth > 768) {
      heroSection.addEventListener('mousemove', function(e) {
        var rect = heroSection.getBoundingClientRect();
        var mx = ((e.clientX - rect.left) / rect.width - 0.5) * 2;
        var my = ((e.clientY - rect.top) / rect.height - 0.5) * 2;
        gridContainer.style.setProperty('--gmx', mx.toFixed(3));
        gridContainer.style.setProperty('--gmy', my.toFixed(3));
        gridContainer.style.transform = 'translate(' + (mx * 15) + 'px, ' + (my * 15) + 'px)';
      });
      heroSection.addEventListener('mouseleave', function() {
        gridContainer.style.transform = 'translate(0, 0)';
      });
    }
  }

  /* ---------- 3D TILT ON BENEFIT CARDS ---------- */
  if (!isTouchDevice && !reducedMotion && window.innerWidth > 768) {
    var tiltCards = document.querySelectorAll('.svc-benefit-card');
    tiltCards.forEach(function(card) {
      card.addEventListener('mousemove', function(e) {
        var rect = card.getBoundingClientRect();
        var cx = rect.left + rect.width / 2;
        var cy = rect.top + rect.height / 2;
        var dx = (e.clientX - cx) / (rect.width / 2);
        var dy = (e.clientY - cy) / (rect.height / 2);
        card.style.transform = 'perspective(800px) rotateY(' + (dx * 3) + 'deg) rotateX(' + (-dy * 3) + 'deg) translateY(-6px)';
        card.style.transition = 'none';
      });
      card.addEventListener('mouseleave', function() {
        card.style.transform = '';
        card.style.transition = 'transform 0.5s cubic-bezier(0.16,1,0.3,1), box-shadow 0.5s ease, background 0.4s ease';
      });
    });
  }

  /* ---------- GRAIN TEXTURE OVERLAY ---------- */
  if (!reducedMotion) {
    var grainSections = document.querySelectorAll('.svc-hero, .svc-why, .svc-stats-bar, .svc-cta-full');
    grainSections.forEach(function(section) {
      var pos = window.getComputedStyle(section).position;
      if (pos === 'static') section.style.position = 'relative';
      var grain = document.createElement('div');
      grain.className = 'svc-grain-overlay';
      section.insertBefore(grain, section.firstChild);
    });
  }

  /* ---------- MAGNETIC BUTTONS ---------- */
  if (!isTouchDevice && !reducedMotion) {
    var magneticBtns = document.querySelectorAll('.svc-btn-primary, .svc-cta-btn-primary');
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

  /* ---------- SELECTED WORK LIGHTBOX ---------- */
  /* AUD-024: content built with createElement/textContent (no HTML string
     interpolation of dataset values); vimeo id validated as digits-only.
     AUD-025: focus moves to the close button on open, Tab is trapped inside
     the dialog, and focus returns to the invoking card on close. */
  var svcLb       = document.getElementById('svcLightbox');
  var svcLbInner  = document.getElementById('svcLightboxInner');
  var svcLbClose  = document.getElementById('svcLightboxClose');
  var svcWorkCards = document.querySelectorAll('.svc-work-card');
  var svcLbInvoker = null;

  if (svcLb && svcLbInner && svcLbClose && svcWorkCards.length) {
    function svcOpenLb(card) {
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
      meta.className = 'svc-lightbox-meta';
      var clientEl = document.createElement('p');
      clientEl.className = 'svc-lightbox-client';
      clientEl.textContent = client;
      var tagEl = document.createElement('span');
      tagEl.className = 'svc-lightbox-tag';
      tagEl.textContent = tag;
      meta.appendChild(clientEl);
      meta.appendChild(tagEl);

      svcLbInner.textContent = '';
      svcLbInner.appendChild(media);
      svcLbInner.appendChild(meta);

      svcLbInvoker = card;
      svcLb.classList.add('open');
      svcLb.setAttribute('aria-hidden', 'false');
      document.body.style.overflow = 'hidden';
      svcLbClose.focus();
    }
    function svcCloseLb() {
      svcLb.classList.remove('open');
      svcLb.setAttribute('aria-hidden', 'true');
      svcLbInner.textContent = '';
      document.body.style.overflow = '';
      if (svcLbInvoker && typeof svcLbInvoker.focus === 'function') {
        svcLbInvoker.focus();
      }
      svcLbInvoker = null;
    }
    svcWorkCards.forEach(function(card) {
      card.addEventListener('click', function(e) {
        e.preventDefault();
        svcOpenLb(card);
      });
    });
    svcLbClose.addEventListener('click', svcCloseLb);
    svcLb.addEventListener('click', function(e) {
      if (e.target === svcLb) svcCloseLb();
    });
    document.addEventListener('keydown', function(e) {
      if (!svcLb.classList.contains('open')) return;
      if (e.key === 'Escape') {
        svcCloseLb();
        return;
      }
      if (e.key !== 'Tab') return;
      var focusables = svcLb.querySelectorAll('button, a[href], iframe, [tabindex]:not([tabindex="-1"])');
      if (!focusables.length) return;
      var first = focusables[0];
      var last = focusables[focusables.length - 1];
      if (!svcLb.contains(document.activeElement)) {
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
