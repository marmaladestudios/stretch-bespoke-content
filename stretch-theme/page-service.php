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
$stats       = !empty($service['stats'])       ? $service['stats']       : [];

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
  max-width: 620px; margin: 0 auto 40px;
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
      <a href="/contact-stretch-creative/" class="svc-btn-primary svc-reveal svc-delay-4"><span>Get Started &rarr;</span></a>
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
      <span class="svc-overline svc-reveal">Services</span>
      <h2 class="svc-reveal svc-delay-1">What We <span class="svc-gradient-text">Deliver</span></h2>
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
     5.5 SELECTED WORK — INLINE PORTFOLIO STRIP
     ======================================== -->
<?php
$service_portfolio = function_exists('stretch_get_portfolio_for_service')
    ? stretch_get_portfolio_for_service($slug)
    : [];
if (!empty($service_portfolio)) :
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

    <div class="svc-benefits-grid">
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
     7. TESTIMONIAL
     ======================================== -->
<section class="svc-section svc-testimonial" aria-label="Testimonial">
  <div class="svc-container">
    <div class="svc-testimonial-inner svc-reveal">
      <div class="svc-testimonial-quote-mark" aria-hidden="true">&ldquo;</div>
      <p class="svc-testimonial-text">&ldquo;<?php echo esc_html($testimonial['quote']); ?>&rdquo;</p>
      <div class="svc-testimonial-attr">
        <?php echo esc_html($testimonial['name']); ?>
        <span>&mdash; <?php echo esc_html($testimonial['title']); ?></span>
      </div>
    </div>
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
    <h2 class="svc-reveal">Ready to <span class="svc-gradient-text">Get Started</span>?</h2>
    <p class="svc-reveal svc-delay-1">Tell us about your project and we&rsquo;ll show you how Stretch can help.</p>
    <div class="svc-cta-buttons svc-reveal svc-delay-2">
      <a href="/contact-stretch-creative/" class="svc-cta-btn-primary">Start a Project &rarr;</a>
      <a href="/about-stretch-creative/" class="svc-cta-btn-outline">Learn About Us</a>
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
  var svcLb       = document.getElementById('svcLightbox');
  var svcLbInner  = document.getElementById('svcLightboxInner');
  var svcLbClose  = document.getElementById('svcLightboxClose');
  var svcWorkCards = document.querySelectorAll('.svc-work-card');

  if (svcLb && svcLbInner && svcWorkCards.length) {
    function svcOpenLb(card) {
      var imgUrl = card.dataset.img;
      var client = card.dataset.client;
      var tag    = card.dataset.tag;
      var vimeo  = card.dataset.vimeo;
      var media  = vimeo
        ? '<iframe src="https://player.vimeo.com/video/' + vimeo + '?h=0&title=0&byline=0&portrait=0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>'
        : '<img src="' + imgUrl + '" alt="' + client + '">';
      svcLbInner.innerHTML = media +
        '<div class="svc-lightbox-meta">' +
          '<p class="svc-lightbox-client">' + client + '</p>' +
          '<span class="svc-lightbox-tag">' + tag + '</span>' +
        '</div>';
      svcLb.classList.add('open');
      svcLb.setAttribute('aria-hidden', 'false');
      document.body.style.overflow = 'hidden';
    }
    function svcCloseLb() {
      svcLb.classList.remove('open');
      svcLb.setAttribute('aria-hidden', 'true');
      svcLbInner.innerHTML = '';
      document.body.style.overflow = '';
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
      if (e.key === 'Escape' && svcLb.classList.contains('open')) svcCloseLb();
    });
  }

})();
</script>

<?php get_footer(); ?>
