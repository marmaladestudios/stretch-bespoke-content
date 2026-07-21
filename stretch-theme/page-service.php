<?php
/**
 * Template Name: Service Page
 *
 * Reusable "Solutions" page template. Premium redesign (Phase 2) — recreates
 * design_handoff_stretch_pages/"Solutions - Content Writing.dc.html".
 *
 * DATA-DRIVEN: all copy comes from the option stretch_service_{slug}. Every
 * section is !empty()-gated so the 4 other solution pages reuse this layout
 * with different (and possibly missing) data — a missing field skips its
 * section cleanly and never fatals.
 */
get_header();
get_template_part('template-parts/premium-fx');

$slug    = get_post_field('post_name', get_the_ID());
$service = (array) get_option('stretch_service_' . $slug, []);

/* ---------- Hero ---------- */
$headline        = !empty($service['headline'])        ? $service['headline']        : get_the_title();
$headline_accent = !empty($service['headline_accent']) ? $service['headline_accent'] : '';
$hero_overline   = !empty($service['hero_overline'])   ? $service['hero_overline']   : 'Our Services';
$hero_lede       = !empty($service['subheadline'])     ? $service['subheadline']     : '';
$hero_cta_label  = !empty($service['hero_cta_label'])  ? $service['hero_cta_label']  : 'Get Started';
$hero_cta_url    = !empty($service['hero_cta_url'])    ? $service['hero_cta_url']    : '/contact-stretch-creative/';

/* ---------- Props pill bar ---------- */
$props           = !empty($service['props'])           ? (array) $service['props']   : [];

/* ---------- Intro (2-col: paragraphs + editorial photo) ---------- */
$intro_paras     = !empty($service['hero_text'])       ? (array) $service['hero_text'] : [];
$intro_image     = !empty($service['intro_image'])     ? (int) $service['intro_image'] : 0;

/* ---------- Reality (tinted, centered) ---------- */
$problem         = !empty($service['problem'])         ? (array) $service['problem'] : [];
$reality_sub     = $problem['sub'] ?? '';
$reality_paras   = !empty($problem['paragraphs']) ? (array) $problem['paragraphs'] : [];
if (!$reality_paras && !empty($problem['text'])) {
    $tmp = (array) $problem['text'];
    if ($reality_sub === '') { $reality_sub = (string) array_shift($tmp); }
    $reality_paras = $tmp;
}

/* ---------- Solution (5 accent-bar cards + CTA) ---------- */
$solution        = !empty($service['solution'])        ? (array) $service['solution'] : [];
$solution_points = !empty($solution['points'])         ? (array) $solution['points']  : [];

/* ---------- Pull quote ---------- */
$pull_quote      = !empty($service['pull_quote'])      ? (array) $service['pull_quote'] : [];

/* ---------- What We Write (ghost-number grid) ---------- */
$offerings_overline = !empty($service['offerings_overline']) ? $service['offerings_overline'] : 'Capabilities';
$offerings_heading  = !empty($service['offerings_heading'])  ? $service['offerings_heading']  : 'What We Deliver';
$offerings_accent   = !empty($service['offerings_heading_accent']) ? $service['offerings_heading_accent'] : '';
$offerings_intro    = !empty($service['offerings_intro'])   ? $service['offerings_intro']    : '';
$offerings          = !empty($service['offerings'])         ? (array) $service['offerings']  : [];

/* ---------- Add-On Services + cross-sell ---------- */
$addons_overline = !empty($service['addons_overline']) ? $service['addons_overline'] : 'Additional Support';
$addons_heading  = !empty($service['addons_heading'])  ? $service['addons_heading']  : 'Add-On Services';
$addons          = !empty($service['addons'])          ? (array) $service['addons']  : [];
$cross_cta       = !empty($service['cross_cta'])       ? (array) $service['cross_cta'] : [];

/* ---------- Process (timeline + sticky photo) ---------- */
$process         = !empty($service['process'])         ? (array) $service['process'] : [];
$process_steps   = !empty($process['steps'])           ? (array) $process['steps']   : [];
$process_intro   = !empty($process['intro'])           ? (array) $process['intro']   : [];
$process_sub     = $process['sub'] ?? '';
if ($process_sub === '' && $process_intro) { $process_sub = (string) array_shift($process_intro); }
$process_image   = !empty($service['process_image'])   ? (int) $service['process_image'] : 0;

/* ---------- Why Stretch (dark, 4 icon cards) ---------- */
$why_overline    = !empty($service['why_overline'])    ? $service['why_overline']    : 'The Difference';
$why_heading     = !empty($service['why_heading'])     ? $service['why_heading']     : 'Why Stretch Creative?';
$benefits        = !empty($service['benefits'])        ? (array) $service['benefits'] : [];

/* ---------- Testimonials (tilt cards) ---------- */
$testimonials_overline   = !empty($service['testimonials_overline'])   ? $service['testimonials_overline']   : 'Social Proof';
$testimonials_heading    = !empty($service['testimonials_heading'])    ? $service['testimonials_heading']    : 'What Our Clients Say';
$testimonials_subheading = !empty($service['testimonials_subheading']) ? $service['testimonials_subheading'] : '';
$testimonials    = !empty($service['testimonials'])    ? (array) $service['testimonials'] : [];

/* ---------- FAQ ---------- */
$faq_overline    = !empty($service['faq_overline'])    ? $service['faq_overline']    : 'FAQ';
$faq_heading     = !empty($service['faq_heading'])     ? $service['faq_heading']     : 'Frequently Asked Questions';
$faqs            = !empty($service['faqs'])            ? (array) $service['faqs']    : [];

/* ---------- Final CTA ---------- */
$cta             = !empty($service['cta'])             ? (array) $service['cta']     : [];
$cta_heading     = !empty($cta['heading'])             ? $cta['heading']             : 'Ready to Get Started?';
$cta_sub         = !empty($cta['subheading'])          ? $cta['subheading']          : '';
$cta_text        = !empty($cta['text'])                ? $cta['text']                : '';
$cta_btn_label   = !empty($cta['button_label'])        ? $cta['button_label']        : 'Get in Touch';
$cta_btn_url     = !empty($cta['button_url'])          ? $cta['button_url']          : '/contact-stretch-creative/';
$cta_sec_label   = !empty($cta['secondary_label'])     ? $cta['secondary_label']     : '';
$cta_sec_url     = !empty($cta['secondary_url'])       ? $cta['secondary_url']       : '/our-work/';

/* ============================================================
 * Section flow — ordered background colors of the sections that will
 * actually render. Wedge dividers pull their fill from the NEXT
 * rendered section so optional sections can't strand a wedge on the
 * wrong background (mirrors the page-home.php wedge treatment).
 * ============================================================ */
$flow = [];
if ($props)                                             { $flow['props']       = '#252C3A'; }
if ($intro_paras || $intro_image)                       { $flow['intro']       = '#ffffff'; }
if ($reality_sub || $reality_paras)                     { $flow['reality']     = '#f7f6fc'; }
// Pull quote renders INSIDE the Reality 2-col grid when both exist; it is only
// its own section (own flow entry) when there is no Reality copy.
if (!empty($pull_quote['text']) && !($reality_sub || $reality_paras)) { $flow['pullquote'] = '#f7f6fc'; }
if ($solution_points || !empty($solution['heading']))   { $flow['solution']    = '#ffffff'; }
if ($offerings)                                         { $flow['write']       = '#ffffff'; }
if ($addons || $cross_cta)                              { $flow['addons']      = '#f9f9fb'; }
if ($process_steps)                                     { $flow['process']     = '#f9f9fb'; }
if ($benefits)                                          { $flow['why']         = '#1a1f2e'; }
if ($testimonials)                                      { $flow['testimonial'] = '#ffffff'; }
if ($faqs)                                              { $flow['faq']         = '#f9f9fb'; }
$flow['cta'] = '#8560A8';

if (!function_exists('stretch_svc_next_fill')) {
    /** Background color of the section rendered after $key (null when last). */
    function stretch_svc_next_fill($flow, $key) {
        $keys = array_keys($flow);
        $i = array_search($key, $keys, true);
        return ($i !== false && isset($keys[$i + 1])) ? $flow[$keys[$i + 1]] : '#ffffff';
    }
    /** Background color of the section rendered before $key (fallback given). */
    function stretch_svc_prev_fill($flow, $key, $fallback) {
        $keys = array_keys($flow);
        $i = array_search($key, $keys, true);
        return ($i !== false && $i > 0) ? $flow[$keys[$i - 1]] : $fallback;
    }
    /** Background color of the first rendered section (for the in-hero wedge). */
    function stretch_svc_first_fill($flow) {
        foreach ($flow as $bg) { return $bg; }
        return '#ffffff';
    }
}

/* Neutral, request-free placeholder image (matches page-home.php). */
if (!function_exists('stretch_svc_image')) {
    function stretch_svc_image($id, $alt, $size = 'large', $class = 'svc-photo-img') {
        $img = wp_get_attachment_image((int) $id, $size, false, [
            'loading' => 'lazy', 'alt' => $alt, 'class' => $class,
        ]);
        if ($img) { return $img; }
        return '<div class="' . esc_attr($class) . ' svc-photo-img--empty" role="img" aria-label="' . esc_attr($alt) . '"></div>';
    }
}

/* Initials monogram from a person's name ("Kristen Haney" => "KH"). */
if (!function_exists('stretch_svc_initials')) {
    function stretch_svc_initials($name) {
        $parts = preg_split('/\s+/', trim((string) $name), -1, PREG_SPLIT_NO_EMPTY);
        $ini = '';
        foreach ($parts as $p) {
            $ini .= mb_strtoupper(mb_substr($p, 0, 1));
            if (mb_strlen($ini) >= 2) { break; }
        }
        return $ini;
    }
}

/* Ghost section-number emitter (#17). A static counter increments only when a
   section actually renders, so numbering is sequential with no gaps regardless
   of which optional sections are skipped. Dark sections use the outline style. */
if (!function_exists('stretch_svc_chapter')) {
    function stretch_svc_chapter($dark = false) {
        static $n = 0;
        $n++;
        return '<span class="svc-chapter' . ($dark ? ' svc-chapter--dark' : '') . '" aria-hidden="true">'
             . sprintf('%02d', $n) . '</span>';
    }
}

/* ---------- Why-card icons (#23 semantic sweep) ----------
 * 24-grid (viewBox 0 0 22 22), 1.7 stroke, round caps — matches the site set.
 * Picked by keyword from each benefit heading so the icon always fits, even
 * when benefit order differs page to page (index cycling used to mismatch the
 * SEO page). Falls back to a rotation, never to a blank tile. */
$why_icon_lib = [
    'roof'   => '<path d="M4 10.5L11 4l7 6.5"></path><path d="M6 9.5V18h10V9.5"></path>',                                   // under one roof
    'person' => '<circle cx="11" cy="7.5" r="3.5"></circle><path d="M4.5 18.5a6.5 6.5 0 0113 0"></path>',                    // human / expert-led
    'growth' => '<path d="M4 18h14"></path><path d="M5.5 14.5l4-4 3 2.5L17 8"></path><path d="M13.5 8H17v3.5"></path>',       // scale / grow / boost
    'chat'   => '<path d="M4 5h13v8.5H9L5.5 17v-3.5H4z"></path>',                                                            // point of contact / comms
    'target' => '<circle cx="11" cy="11" r="7"></circle><circle cx="11" cy="11" r="3"></circle>',                            // results / execute / strategy
    'layers' => '<path d="M11 3l7 4-7 4-7-4 7-4z"></path><path d="M4 11l7 4 7-4"></path><path d="M4 14.8l7 4 7-4"></path>',   // holistic / integrated / formats
    'search' => '<circle cx="9.5" cy="9.5" r="5.5"></circle><path d="M13.7 13.7l4 4"></path>',                               // SEO / research / AEO
];
/** Choose a why-card icon by keyword; fall back to a rotation (never blank). */
if (!function_exists('stretch_svc_why_icon')) {
    function stretch_svc_why_icon($lib, $title, $i) {
        $t = mb_strtolower((string) $title);
        // Order matters: more-specific themes resolve before the generic
        // "seo/search" catch so headings like "SEO built to scale" or
        // "Holistic SEO and AEO" pick the distinctive icon, not the magnifier.
        $rules = [
            'roof'   => ['one roof', 'under one'],
            'person' => ['human', 'expert-led', 'expert led', 'hand-pick', 'people'],
            'growth' => ['scale', 'grow', 'boost', 'long-term'],
            'layers' => ['holistic', 'integrat', 'end-to-end', 'format', 'multiple', 'plug in', 'full-service', 'end to end'],
            'target' => ['result', 'measurable', 'execute', 'strateg', 'effective', 'brand', 'roi', 'data', 'performance'],
            'search' => ['seo', 'aeo', 'research', 'root'],
            'chat'   => ['contact', 'point of', 'extension', 'collab', 'communication', 'storytelling', 'story'],
        ];
        foreach ($rules as $icon => $needles) {
            foreach ($needles as $needle) {
                if (strpos($t, $needle) !== false) { return $lib[$icon]; }
            }
        }
        $rotation = ['roof', 'person', 'growth', 'chat'];
        return $lib[$rotation[$i % count($rotation)]];
    }
}
?>

<style>
html, body { overflow-x: hidden; }

/* ===== GHOST SECTION NUMBERS (#17 — BCE chapter treatment) =====
   Oversized outline/ghost numeral, top-right of each major section, behind
   content, aria-hidden. Auto-numbered from the rendered section flow via
   stretch_svc_chapter() so optional sections never leave a gap. Anchored by
   `right` (never overflows the viewport; html/body clip overflow-x anyway). */
.svc-chapter { position: absolute; top: 18px; right: clamp(12px, 3vw, 46px); z-index: 1; font-family: 'Poppins', sans-serif; font-weight: 700; font-size: clamp(150px, 19vw, 240px); line-height: 0.8; letter-spacing: -8px; color: rgba(26,31,46,0.05); pointer-events: none; user-select: none; }
.svc-chapter--dark { color: transparent; -webkit-text-stroke: 1px rgba(255,255,255,0.10); }
/* Numbered sections get a positioning context; their inner wrappers ride above
   the ghost numeral. */
.svc-intro, .svc-reality, .svc-solution, .svc-addons, .svc-process, .svc-testimonials, .svc-faq { position: relative; }
.svc-intro-grid, .svc-reality-inner, .svc-reality-grid, .svc-solution-inner, .svc-addons-inner, .svc-process-inner, .svc-testimonials-inner, .svc-faq-inner, .svc-pullquote p, .svc-why-inner, .svc-cta-inner { position: relative; z-index: 2; }

/* ===== SHARED ===== */
.svc-h2 { font-family: 'Poppins', sans-serif; font-weight: 600; font-size: clamp(30px, 3.4vw, 44px); letter-spacing: -1px; line-height: 1.15; margin: 0; color: #1a1f2e; }
.svc-head { text-align: center; max-width: 720px; margin: 0 auto 54px; }
.svc-lede { margin: 16px 0 0; font-family: 'Assistant', sans-serif; font-weight: 300; font-size: 17px; line-height: 1.75; color: #4a5364; }

/* ===== HERO (left-aligned) ===== */
.svc-hero { min-height: 78vh; }
.svc-hero-inner { position: relative; z-index: 2; max-width: 1200px; width: 100%; margin: 0 auto; padding: 150px clamp(24px, 4vw, 40px) 110px; display: flex; flex-direction: column; align-items: flex-start; text-align: left; }
.svc-hero-title { font-family: 'Poppins', sans-serif; font-weight: 600; font-size: clamp(38px, 5vw, 64px); letter-spacing: -1.5px; line-height: 1.1; color: #fff; margin: 0 0 22px; max-width: 840px; }
.svc-hero-lede { font-family: 'Poppins', sans-serif; font-weight: 500; font-size: clamp(18px, 1.6vw, 22px); line-height: 1.4; color: rgba(255,255,255,0.95); margin: 0 0 36px; }
.svc-hero-wedge { position: absolute; left: 0; right: 0; bottom: -1px; height: 60px; clip-path: polygon(0 100%, 100% 0, 100% 100%); z-index: 1; pointer-events: none; }
/* #15 — make the in-hero diagonal legible. The wedge fill equals the next
   section (a near-identical dark), so the diagonal reads via a 1px light edge
   cast along the clip-path top boundary (drop-shadow follows the clipped shape)
   plus a faint top-lit gradient sheen inside the wedge itself. */
.svc-hero-wedge { filter: drop-shadow(0 -1px 0 rgba(255,255,255,0.16)); }
.svc-hero-wedge::before { content: ''; position: absolute; inset: 0; clip-path: polygon(0 100%, 100% 0, 100% 100%); background: linear-gradient(200deg, rgba(255,255,255,0.10) 0%, rgba(255,255,255,0.03) 34%, rgba(255,255,255,0) 60%); pointer-events: none; }

/* ===== WEDGE DIVIDERS (standalone) — systemic seam fix (#14) =====
   Pattern (identical on every wedge, both templates):
   • container bg  = the PREVIOUS section's color, so any sub-pixel gap at the
     TOP edge (previous section → wedge) shows the correct color and vanishes.
   • clipped child = the NEXT section's color, extended 1px BEYOND both the top
     and bottom edges (top:-1px / bottom:-1px), so the diagonal's anti-aliased
     hairline always blends into a matching fill instead of a grey sliver.
   • container overlaps the following section by 1px (margin-bottom:-1px) so the
     BOTTOM edge (wedge → next) has no rounding gap at any zoom level. */
.svc-wedge { height: 60px; position: relative; line-height: 0; margin-bottom: -1px; }
.svc-wedge > div { position: absolute; top: -1px; left: 0; right: 0; bottom: -1px; }

/* ===== PROPS BAR ===== */
.svc-props { background: #252C3A; padding: 44px clamp(24px, 4vw, 40px); }
.svc-props-row { max-width: 1200px; margin: 0 auto; display: flex; flex-wrap: wrap; gap: 14px; justify-content: center; }
.svc-prop-pill { padding: 11px 24px; border-radius: 999px; border: 1px solid rgba(255,255,255,0.22); background: rgba(255,255,255,0.05); color: #fff; font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 14.5px; white-space: nowrap; }

/* ===== INTRO ===== */
.svc-intro { background: #fff; padding: 88px clamp(24px, 4vw, 40px) 92px; }
.svc-intro-grid { max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: clamp(28px, 4vw, 60px); align-items: center; }
.svc-intro-grid p { margin: 0 0 18px; font-family: 'Assistant', sans-serif; font-size: 17px; font-weight: 300; line-height: 1.8; color: #4a5364; }
.svc-intro-grid p:last-child { margin-bottom: 0; }
.svc-intro-photo { border-radius: 16px; overflow: hidden; height: 320px; border: 1px solid #e9e9f1; box-shadow: 0 24px 48px rgba(26,31,46,0.10); }

/* ===== PHOTO PLACEHOLDER ===== */
.svc-photo-img { display: block; width: 100%; height: 100%; object-fit: cover; }
.svc-photo-img--empty { background: linear-gradient(135deg, #e8eaf1, #f3f4f8); }

/* ===== REALITY ===== */
.svc-reality { background: #f7f6fc; padding: 96px clamp(24px, 4vw, 40px) 100px; }
.svc-reality-inner { max-width: 780px; margin: 0 auto; text-align: center; }
.svc-reality-inner .svc-h2 { margin-bottom: 16px; }
.svc-reality-sub { font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 19px; color: #5674B9; margin: 0 0 26px; }
.svc-reality-inner p.svc-body { margin: 0 0 18px; font-family: 'Assistant', sans-serif; font-size: 17px; font-weight: 300; line-height: 1.8; color: #4a5364; }
.svc-reality-inner p.svc-body:last-child { margin-bottom: 0; }
/* Two-column Reality: copy left, pull-quote card right (mirrors ind-challenges) */
.svc-reality-grid { max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: 1fr 1.05fr; gap: clamp(36px, 5vw, 72px); align-items: center; text-align: left; }
.svc-reality-grid .svc-h2 { margin: 0 0 18px; }
.svc-reality-grid .svc-reality-sub { margin: 0 0 22px; }
.svc-reality-grid p.svc-body { margin: 0 0 18px; font-family: 'Assistant', sans-serif; font-size: 16.5px; font-weight: 300; line-height: 1.8; color: #4a5364; }
.svc-reality-grid p.svc-body:last-child { margin-bottom: 0; }
.svc-pq-card { position: relative; background: #fff; border: 1px solid #e9e9f1; border-radius: 16px; padding: 54px 46px 50px 52px; box-shadow: 0 18px 40px rgba(26,31,46,0.08); overflow: hidden; }
.svc-pq-card::before { content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 4px; background: linear-gradient(180deg, #8560A8, #00BFF3); }
.svc-pq-card-mark { position: absolute; top: -26px; left: 22px; font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 150px; line-height: 1; color: rgba(133,96,168,0.10); pointer-events: none; }
.svc-pq-card p { position: relative; margin: 0; font-family: 'Poppins', sans-serif; font-weight: 500; font-size: clamp(22px, 2.2vw, 30px); letter-spacing: -0.5px; line-height: 1.4; color: #1a1f2e; }
@media (max-width: 900px) { .svc-reality-grid { grid-template-columns: 1fr; gap: 36px; } }

/* ===== SOLUTION ===== */
.svc-solution { background: #fff; padding: 96px clamp(24px, 4vw, 40px) 100px; }
.svc-solution-inner { max-width: 840px; margin: 0 auto; text-align: center; }
.svc-solution-inner .svc-h2 { margin-bottom: 20px; }
.svc-solution-intro { margin: 0 0 20px; font-family: 'Assistant', sans-serif; font-size: 17px; font-weight: 300; line-height: 1.8; color: #4a5364; }
.svc-solution-intro:last-child { margin-bottom: 44px; }
.svc-solution-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px; text-align: left; }
.svc-solution-card { position: relative; overflow: hidden; background: #fff; border: 1px solid #e9e9f1; border-radius: 14px; padding: 28px 28px 26px 34px; transition: transform 0.3s ease, box-shadow 0.3s ease; }
.svc-solution-card:hover { transform: translateY(-4px); box-shadow: 0 16px 34px rgba(26,31,46,0.08); }
.svc-solution-card-bar { position: absolute; left: 0; top: 0; bottom: 0; width: 4px; background: linear-gradient(180deg, #8560A8, #00BFF3); }
.svc-solution-card h3 { font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 18px; margin: 0 0 10px; color: #1a1f2e; }
.svc-solution-card p { margin: 0; font-family: 'Assistant', sans-serif; font-size: 15px; font-weight: 300; line-height: 1.7; color: #4a5364; }
.svc-solution-cta { margin-top: 52px; }

/* ===== PULL QUOTE ===== */
.svc-pullquote { background: linear-gradient(135deg, #f7f6fc, #edf4fb); padding: 100px clamp(24px, 4vw, 40px); text-align: center; position: relative; overflow: hidden; }
.svc-pullquote-mark { position: absolute; top: -30px; left: 50%; transform: translateX(-560px); font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 280px; line-height: 1; color: rgba(133,96,168,0.10); pointer-events: none; }
.svc-pullquote p { position: relative; max-width: 900px; margin: 0 auto; font-family: 'Poppins', sans-serif; font-weight: 500; font-size: clamp(24px, 3vw, 36px); letter-spacing: -0.5px; line-height: 1.35; color: #1a1f2e; }
.svc-pq-accent { color: #00BFF3; }

/* ===== WHAT WE WRITE ===== */
.svc-write { background: #fff; padding: 100px clamp(24px, 4vw, 40px); }
.svc-write-inner { max-width: 1200px; margin: 0 auto; }
.svc-write-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; }
@media (min-width: 1000px) { .svc-write-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); } }
.svc-write-card { position: relative; background: #fff; border: 1px solid #e9e9f1; border-radius: 12px; padding: 26px 24px; transition: transform 0.3s ease, box-shadow 0.3s ease; }
.svc-write-card:hover { transform: translateY(-4px); box-shadow: 0 16px 34px rgba(26,31,46,0.08); }
.svc-write-num { position: absolute; top: 16px; right: 20px; font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 38px; line-height: 1; color: rgba(133,96,168,0.14); }
.svc-write-card h3 { font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 17px; margin: 0 0 8px; color: #1a1f2e; padding-right: 52px; }
.svc-write-card p { margin: 0; font-family: 'Assistant', sans-serif; font-size: 14.5px; font-weight: 300; line-height: 1.65; color: #4a5364; }

/* ===== ADD-ONS ===== */
.svc-addons { background: #f9f9fb; padding: 96px clamp(24px, 4vw, 40px); }
.svc-addons-inner { max-width: 1200px; margin: 0 auto; }
.svc-addons-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; }
.svc-addon-card { background: #fff; border: 1px solid #e9e9f1; border-radius: 14px; padding: 32px; transition: transform 0.35s ease, box-shadow 0.35s ease; }
.svc-addon-card:hover { transform: translateY(-5px); box-shadow: 0 18px 38px rgba(26,31,46,0.09); }
.svc-addon-card h3 { font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 18px; margin: 0 0 10px; color: #1a1f2e; }
.svc-addon-card p { margin: 0; font-family: 'Assistant', sans-serif; font-size: 15px; font-weight: 300; line-height: 1.7; color: #4a5364; }
.svc-cross { margin-top: 24px; background: #fff; border: 1.5px dashed #cfd3e0; border-radius: 16px; padding: 44px clamp(24px, 4vw, 48px); text-align: center; }
.svc-cross h3 { font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 22px; margin: 0 0 10px; color: #1a1f2e; }
.svc-cross p { margin: 0 auto 28px; max-width: 560px; font-family: 'Assistant', sans-serif; font-size: 16px; font-weight: 300; line-height: 1.7; color: #4a5364; }
.svc-cross-links { display: flex; flex-wrap: wrap; gap: 12px; justify-content: center; }
.svc-cross-link { display: inline-flex; align-items: center; padding: 10px 22px; border-radius: 999px; border: 1px solid transparent; background: linear-gradient(#fff, #fff) padding-box, linear-gradient(135deg, #8560A8, #448CCB, #00BFF3) border-box; font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 14px; color: #3c4354; transition: box-shadow 0.3s ease, transform 0.3s ease; }
.svc-cross-link:hover { box-shadow: 0 8px 20px rgba(86,116,185,0.2); transform: translateY(-2px); color: #3c4354; }

/* ===== PROCESS ===== */
.svc-process { background: #f9f9fb; padding: 40px clamp(24px, 4vw, 40px) 110px; }
.svc-process-inner { max-width: 1140px; margin: 0 auto; }
.svc-process-head { text-align: center; margin-bottom: 60px; }
.svc-process-sub { margin: 0 auto 12px; max-width: 640px; font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 18px; color: #5674B9; }
.svc-process-intro { margin: 0 auto; max-width: 680px; font-family: 'Assistant', sans-serif; font-size: 16.5px; font-weight: 300; line-height: 1.75; color: #4a5364; }
.svc-process-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: clamp(32px, 4vw, 56px); align-items: start; }
.svc-timeline { position: relative; }
.svc-timeline-line { position: absolute; left: 27px; top: 30px; bottom: 30px; width: 2px; background: linear-gradient(180deg, #8560A8, #448CCB, #00BFF3); }
.svc-step { position: relative; padding-left: 92px; margin-bottom: 46px; }
.svc-step:last-child { margin-bottom: 0; }
.svc-step-num { position: absolute; left: 0; top: 0; width: 56px; height: 56px; border-radius: 50%; border: 2px solid transparent; background: linear-gradient(#f9f9fb, #f9f9fb) padding-box, linear-gradient(135deg, #8560A8, #00BFF3) border-box; display: flex; align-items: center; justify-content: center; font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 16px; color: #5674B9; }
.svc-step h3 { font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 20px; margin: 6px 0 10px; color: #1a1f2e; }
.svc-step p { margin: 0; font-family: 'Assistant', sans-serif; font-size: 15.5px; font-weight: 300; line-height: 1.75; color: #4a5364; }
.svc-process-photo { position: sticky; top: 90px; border-radius: 16px; overflow: hidden; height: 480px; border: 1px solid #e9e9f1; box-shadow: 0 24px 48px rgba(26,31,46,0.10); }

/* ===== WHY (dark) ===== */
.svc-why { position: relative; background: #1a1f2e; padding: 100px clamp(24px, 4vw, 40px) 110px; overflow: hidden; }
.svc-why-inner { position: relative; z-index: 1; max-width: 1200px; margin: 0 auto; }
.svc-why .svc-h2 { color: #fff; }
.svc-why-head { margin-bottom: 60px; }
.svc-why-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 24px; }
.svc-why-card { position: relative; overflow: hidden; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.09); border-radius: 14px; padding: 34px 30px; }
.svc-why-bar { position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, #8560A8, #5674B9, #448CCB, #00BFF3, #448CCB, #5674B9, #8560A8); background-size: 200% 100%; animation: svc-slideBar 6s linear infinite; }
@keyframes svc-slideBar { from { background-position: 0% 0; } to { background-position: 200% 0; } }
.svc-why-icon { width: 44px; height: 44px; border-radius: 11px; background: linear-gradient(135deg, rgba(133,96,168,0.28), rgba(0,191,243,0.18)); display: flex; align-items: center; justify-content: center; margin-bottom: 18px; }
.svc-why-card h3 { font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 18px; margin: 0 0 12px; color: #fff; }
.svc-why-card p { margin: 0; font-family: 'Assistant', sans-serif; font-size: 14.5px; line-height: 1.7; color: rgba(255,255,255,0.7); }

/* ===== TESTIMONIALS ===== */
.svc-testimonials { background: #fff; padding: 96px clamp(24px, 4vw, 40px) 100px; }
.svc-testimonials-inner { max-width: 1200px; margin: 0 auto; }
.svc-testimonials-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px; align-items: stretch; }
.svc-tcard { display: flex; flex-direction: column; height: 100%; background: #fff; border: 1px solid #e9e9f1; border-radius: 16px; padding: 34px; transition: box-shadow 0.35s ease; }
.svc-tcard:hover { box-shadow: 0 20px 42px rgba(26,31,46,0.1); }
.svc-tcard-mark { font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 56px; line-height: 0.6; color: rgba(133,96,168,0.3); margin-bottom: 20px; }
.svc-tcard-quote { flex: 1 1 auto; margin: 0 0 22px; font-style: italic; font-family: 'Assistant', sans-serif; font-size: 15.5px; line-height: 1.75; color: #3c4354; }
.svc-tcard-person { display: flex; align-items: center; gap: 14px; margin-top: auto; }
.svc-tcard-avatar { display: flex; align-items: center; justify-content: center; width: 48px; height: 48px; border-radius: 50%; overflow: hidden; flex-shrink: 0; border: 2px solid #e9e9f1; background: linear-gradient(135deg, #f0eef7, #e7f3fb); }
.svc-tcard-avatar .svc-photo-img--empty { background: linear-gradient(135deg, #f0eef7, #e7f3fb); }
.svc-tcard-mono { display: flex; align-items: center; justify-content: center; width: 100%; height: 100%; background: linear-gradient(135deg, #8560A8 0%, #5674B9 30%, #448CCB 60%, #00BFF3 100%); color: #fff; font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 15px; letter-spacing: 0.5px; }
.svc-tcard-name { font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 15px; color: #1a1f2e; }
.svc-tcard-role { font-family: 'Assistant', sans-serif; font-size: 13px; color: #7a8194; margin-top: 2px; }

/* ===== FAQ ===== */
.svc-faq { background: #f9f9fb; padding: 96px clamp(24px, 4vw, 40px) 100px; }
.svc-faq-inner { max-width: 820px; margin: 0 auto; }
.svc-faq-head { text-align: center; margin-bottom: 44px; }
.svc-faq details { border-bottom: 1px solid #e4e6ee; }
.svc-faq details:last-child { border-bottom: none; }
.svc-faq summary { display: flex; align-items: center; justify-content: space-between; gap: 20px; padding: 24px 0; font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 17px; color: #1a1f2e; list-style: none; cursor: pointer; }
.svc-faq summary::-webkit-details-marker { display: none; }
.svc-faq-marker { color: #00BFF3; font-weight: 600; font-size: 22px; flex-shrink: 0; transition: transform 0.3s ease; }
.svc-faq details[open] .svc-faq-marker { transform: rotate(45deg); }
.svc-faq-answer { margin: 0; padding: 0 44px 24px 0; font-family: 'Assistant', sans-serif; font-size: 15.5px; font-weight: 300; line-height: 1.75; color: #4a5364; }

/* ===== FINAL CTA ===== */
.svc-cta { position: relative; overflow: hidden; background: linear-gradient(170deg, #8560A8 0%, #3d2d66 30%, #252C3A 70%, #1a1f2e 100%); padding: 130px clamp(24px, 4vw, 40px); text-align: center; }
.svc-cta-orb-a { position: absolute; width: 420px; height: 420px; left: -120px; top: -80px; border-radius: 50%; background: radial-gradient(circle, rgba(0,191,243,0.16), transparent 70%); animation: svc-floatA 14s ease-in-out infinite; pointer-events: none; }
.svc-cta-orb-b { position: absolute; width: 540px; height: 540px; right: -170px; bottom: -150px; border-radius: 50%; background: radial-gradient(circle, rgba(133,96,168,0.3), transparent 70%); animation: svc-floatB 17s ease-in-out infinite; pointer-events: none; }
@keyframes svc-floatA { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(28px, -26px); } }
@keyframes svc-floatB { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(-24px, 22px); } }
.svc-cta-inner { position: relative; z-index: 1; max-width: 760px; margin: 0 auto; }
.svc-cta-inner h2 { font-family: 'Poppins', sans-serif; font-weight: 600; font-size: clamp(34px, 4vw, 52px); letter-spacing: -1.2px; margin: 0 0 16px; color: #fff; }
.svc-cta-sub { font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 19px; margin: 0 0 18px; color: rgba(255,255,255,0.95); }
.svc-cta-text { margin: 0 auto; max-width: 620px; font-family: 'Assistant', sans-serif; font-size: 17px; font-weight: 300; line-height: 1.75; color: rgba(255,255,255,0.8); }
.svc-cta-buttons { display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; margin-top: 38px; }

@media (prefers-reduced-motion: reduce) {
  .svc-cta-orb-a, .svc-cta-orb-b, .svc-why-bar { animation: none !important; }
}
@media (max-width: 860px) {
  .svc-process-photo { position: static; height: 320px; }
}
</style>

<!-- ============ HERO (left-aligned) ============ -->
<section class="pfx-hero pfx-hero--left svc-hero" data-grain aria-label="Hero">
  <div class="pfx-hero-grid"></div>
  <div class="svc-hero-inner">
    <span class="pfx-overline pfx-reveal"><?php echo esc_html($hero_overline); ?></span>
    <h1 class="svc-hero-title pfx-reveal pfx-delay-1"><?php
      // Accent is a substring of the headline (seed convention) — highlight in place.
      echo stretch_accent_title($headline, $headline_accent);
    ?></h1>
    <?php if ($hero_lede !== '') : ?>
    <p class="svc-hero-lede pfx-reveal pfx-delay-2"><?php echo esc_html($hero_lede); ?></p>
    <?php endif; ?>
    <a href="<?php echo esc_url($hero_cta_url); ?>" class="pfx-btn-primary pfx-reveal pfx-delay-2"><span><?php echo esc_html($hero_cta_label); ?> →</span></a>
  </div>
  <div class="svc-hero-wedge" aria-hidden="true" style="background:<?php echo esc_attr(stretch_svc_first_fill($flow)); ?>"></div>
</section>

<!-- animated accent bar -->
<div class="pfx-accent-bar" aria-hidden="true"></div>

<?php if ($props) : ?>
<!-- ============ PROPS BAR (Ink-2) ============ -->
<section class="svc-props" aria-label="Highlights">
  <div class="svc-props-row">
    <?php foreach ($props as $prop) : ?>
      <span class="svc-prop-pill"><?php echo esc_html($prop); ?></span>
    <?php endforeach; ?>
  </div>
</section>
<!-- wedge: Ink-2 → next (down-left) -->
<div class="svc-wedge" aria-hidden="true" style="background:#252C3A"><div style="background:<?php echo esc_attr(stretch_svc_next_fill($flow, 'props')); ?>;clip-path:polygon(0 0,100% 100%,0 100%)"></div></div>
<?php endif; ?>

<?php if ($intro_paras || $intro_image) : ?>
<!-- ============ INTRO (white, 2-col) ============ -->
<section class="svc-intro" aria-label="Introduction">
  <?php echo stretch_svc_chapter(); ?>
  <div class="svc-intro-grid">
    <div class="pfx-reveal">
      <?php foreach ($intro_paras as $p) : if ($p === '') continue; ?>
        <p><?php echo wp_kses_post($p); ?></p>
      <?php endforeach; ?>
    </div>
    <div class="svc-intro-photo pfx-reveal pfx-delay-1">
      <?php echo stretch_svc_image($intro_image, $headline . ' — editorial'); ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php
/* Pull-quote inner HTML (cyan highlight span) — shared by both layouts. */
$pq_html = '';
if (!empty($pull_quote['text'])) {
    $pq_text = (string) $pull_quote['text'];
    $pq_hl   = (string) ($pull_quote['highlight'] ?? '');
    if ($pq_hl !== '' && strpos($pq_text, $pq_hl) !== false) {
        $parts   = explode($pq_hl, $pq_text, 2);
        $pq_html = esc_html($parts[0]) . '<span class="svc-pq-accent">' . esc_html($pq_hl) . '</span>' . esc_html($parts[1]);
    } else {
        $pq_html = esc_html($pq_text);
    }
}
?>
<?php if ($reality_sub || $reality_paras) : ?>
<!-- ============ THE REALITY — 2-col when a pull quote exists: copy left, quote card right ============ -->
<section class="svc-reality" aria-label="The Reality">
  <?php echo stretch_svc_chapter(); ?>
  <?php if ($pq_html !== '') : ?>
  <div class="svc-reality-grid">
    <div class="pfx-reveal">
      <?php if (!empty($problem['overline'])) : ?><span class="pfx-overline"><?php echo esc_html($problem['overline']); ?></span><?php endif; ?>
      <?php if (!empty($problem['heading'])) : ?><h2 class="svc-h2"><?php echo esc_html($problem['heading']); ?></h2><?php endif; ?>
      <?php if ($reality_sub !== '') : ?><p class="svc-reality-sub"><?php echo esc_html($reality_sub); ?></p><?php endif; ?>
      <?php foreach ($reality_paras as $p) : if ($p === '') continue; ?>
        <p class="svc-body"><?php echo wp_kses_post($p); ?></p>
      <?php endforeach; ?>
    </div>
    <div class="svc-pq-card pfx-reveal pfx-delay-1">
      <div class="svc-pq-card-mark" aria-hidden="true">&ldquo;</div>
      <p><?php echo $pq_html; ?></p>
    </div>
  </div>
  <?php else : ?>
  <div class="svc-reality-inner pfx-reveal">
    <?php if (!empty($problem['overline'])) : ?><span class="pfx-overline"><?php echo esc_html($problem['overline']); ?></span><?php endif; ?>
    <?php if (!empty($problem['heading'])) : ?><h2 class="svc-h2"><?php echo esc_html($problem['heading']); ?></h2><?php endif; ?>
    <?php if ($reality_sub !== '') : ?><p class="svc-reality-sub"><?php echo esc_html($reality_sub); ?></p><?php endif; ?>
    <?php foreach ($reality_paras as $p) : if ($p === '') continue; ?>
      <p class="svc-body"><?php echo wp_kses_post($p); ?></p>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</section>
<?php endif; ?>

<?php if ($pq_html !== '' && !($reality_sub || $reality_paras)) : ?>
<!-- ============ PULL QUOTE (standalone band fallback when no Reality section) ============ -->
<section class="svc-pullquote" aria-label="Quote">
  <?php echo stretch_svc_chapter(); ?>
  <div class="svc-pullquote-mark" aria-hidden="true">&ldquo;</div>
  <p class="pfx-reveal"><?php echo $pq_html; ?></p>
</section>
<?php endif; ?>

<?php if ($solution_points || !empty($solution['heading'])) : ?>
<!-- ============ THE SOLUTION (white, 5 accent-bar cards) ============ -->
<section class="svc-solution" aria-label="The Solution">
  <?php echo stretch_svc_chapter(); ?>
  <div class="svc-solution-inner">
    <div class="pfx-reveal">
      <?php if (!empty($solution['overline'])) : ?><span class="pfx-overline"><?php echo esc_html($solution['overline']); ?></span><?php endif; ?>
      <?php if (!empty($solution['heading'])) : ?><h2 class="svc-h2"><?php
        echo esc_html($solution['heading']);
        if (!empty($solution['heading_accent'])) { echo ' <span class="gradient-text">' . esc_html($solution['heading_accent']) . '</span>'; }
      ?></h2><?php endif; ?>
      <?php if (!empty($solution['text'])) : foreach ((array) $solution['text'] as $sp) : if ($sp === '') continue; ?>
        <p class="svc-solution-intro"><?php echo wp_kses_post($sp); ?></p>
      <?php endforeach; endif; ?>
    </div>
    <?php if ($solution_points) : ?>
    <div class="svc-solution-grid">
      <?php foreach ($solution_points as $i => $point) : ?>
      <div class="svc-solution-card pfx-reveal<?php echo $i ? ' pfx-delay-' . min($i, 6) : ''; ?>">
        <div class="svc-solution-card-bar" aria-hidden="true"></div>
        <h3><?php echo esc_html($point['title'] ?? ''); ?></h3>
        <p><?php echo wp_kses_post($point['body'] ?? ''); ?></p>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <?php if (!empty($solution['cta_label'])) : ?>
    <div class="svc-solution-cta pfx-reveal">
      <a href="<?php echo esc_url($solution['cta_url'] ?? '/contact-stretch-creative/'); ?>" class="pfx-btn-primary"><span><?php echo esc_html($solution['cta_label']); ?> →</span></a>
    </div>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>

<?php if ($offerings) : ?>
<!-- ============ WHAT WE WRITE (white, ghost-number grid) ============ -->
<section class="svc-write" aria-label="<?php echo esc_attr($offerings_heading); ?>">
  <div class="svc-write-inner">
    <div class="svc-head pfx-reveal">
      <span class="pfx-overline"><?php echo esc_html($offerings_overline); ?></span>
      <h2 class="svc-h2"><?php
        echo esc_html($offerings_heading);
        if ($offerings_accent !== '') { echo ' <span class="gradient-text">' . esc_html($offerings_accent) . '</span>'; }
      ?></h2>
      <?php if ($offerings_intro !== '') : ?><p class="svc-lede"><?php echo wp_kses_post($offerings_intro); ?></p><?php endif; ?>
    </div>
    <div class="svc-write-grid">
      <?php foreach ($offerings as $i => $item) : ?>
      <div class="svc-write-card pfx-reveal<?php echo $i ? ' pfx-delay-' . (($i % 3) + 1) : ''; ?>">
        <span class="svc-write-num" aria-hidden="true"><?php echo esc_html(sprintf('%02d', $i + 1)); ?></span>
        <h3><?php echo esc_html($item['title'] ?? ''); ?></h3>
        <p><?php echo wp_kses_post($item['description'] ?? ''); ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if ($addons || $cross_cta) : ?>
<!-- ============ ADD-ON SERVICES (Light bg 1) ============ -->
<section class="svc-addons" aria-label="<?php echo esc_attr($addons_heading); ?>">
  <?php echo stretch_svc_chapter(); ?>
  <div class="svc-addons-inner">
    <div class="svc-head pfx-reveal">
      <span class="pfx-overline"><?php echo esc_html($addons_overline); ?></span>
      <h2 class="svc-h2"><?php echo esc_html($addons_heading); ?></h2>
    </div>
    <?php if ($addons) : ?>
    <div class="svc-addons-grid">
      <?php foreach ($addons as $i => $addon) : ?>
      <div class="svc-addon-card pfx-reveal<?php echo $i ? ' pfx-delay-' . min($i * 2, 6) : ''; ?>">
        <h3><?php echo esc_html($addon['title'] ?? ''); ?></h3>
        <p><?php echo wp_kses_post($addon['description'] ?? ''); ?></p>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <?php if ($cross_cta) : ?>
    <div class="svc-cross pfx-reveal">
      <?php if (!empty($cross_cta['heading'])) : ?><h3><?php echo esc_html($cross_cta['heading']); ?></h3><?php endif; ?>
      <?php if (!empty($cross_cta['body'])) : ?><p><?php echo wp_kses_post($cross_cta['body']); ?></p><?php endif; ?>
      <?php if (!empty($cross_cta['links'])) : ?>
      <div class="svc-cross-links">
        <?php foreach ((array) $cross_cta['links'] as $link) : ?>
          <a href="<?php echo esc_url($link['url'] ?? '#'); ?>" class="svc-cross-link"><?php echo esc_html($link['label'] ?? ''); ?></a>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
    </div>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>

<?php if ($process_steps) : ?>
<!-- ============ HOW WE WORK (timeline + sticky photo) ============ -->
<section class="svc-process" aria-label="How We Work">
  <?php echo stretch_svc_chapter(); ?>
  <div class="svc-process-inner">
    <div class="svc-process-head pfx-reveal">
      <?php if (!empty($process['overline'])) : ?><span class="pfx-overline"><?php echo esc_html($process['overline']); ?></span><?php endif; ?>
      <?php if (!empty($process['heading'])) : ?><h2 class="svc-h2"><?php echo esc_html($process['heading']); ?></h2><?php endif; ?>
      <?php if ($process_sub !== '') : ?><p class="svc-process-sub"><?php echo esc_html($process_sub); ?></p><?php endif; ?>
      <?php foreach ($process_intro as $p) : if ($p === '') continue; ?>
        <p class="svc-process-intro"><?php echo wp_kses_post($p); ?></p>
      <?php endforeach; ?>
    </div>
    <div class="svc-process-grid">
      <div class="svc-timeline">
        <div class="svc-timeline-line" aria-hidden="true"></div>
        <?php foreach ($process_steps as $i => $step) : ?>
        <div class="svc-step pfx-reveal<?php echo $i ? ' pfx-delay-' . min($i, 6) : ''; ?>">
          <div class="svc-step-num"><?php echo esc_html(sprintf('%02d', $i + 1)); ?></div>
          <h3><?php echo esc_html($step['title'] ?? ''); ?></h3>
          <p><?php echo wp_kses_post($step['description'] ?? ''); ?></p>
        </div>
        <?php endforeach; ?>
      </div>
      <div class="svc-process-photo pfx-reveal pfx-delay-1">
        <?php echo stretch_svc_image($process_image, ($process['heading'] ?? $headline) . ' — collaboration'); ?>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if ($benefits) : ?>
<!-- wedge: prev → Ink (down-left) -->
<div class="svc-wedge" aria-hidden="true" style="background:<?php echo esc_attr(stretch_svc_prev_fill($flow, 'why', '#f9f9fb')); ?>"><div style="background:#1a1f2e;clip-path:polygon(0 0,100% 100%,0 100%)"></div></div>
<!-- ============ WHY STRETCH (Ink + grain) ============ -->
<section class="svc-why" data-grain aria-label="<?php echo esc_attr($why_heading); ?>">
  <?php echo stretch_svc_chapter(true); ?>
  <div class="svc-why-inner">
    <div class="svc-head svc-why-head pfx-reveal">
      <span class="pfx-overline"><?php echo esc_html($why_overline); ?></span>
      <h2 class="svc-h2"><?php echo esc_html($why_heading); ?></h2>
    </div>
    <div class="svc-why-grid">
      <?php foreach ($benefits as $i => $benefit) : ?>
      <div class="svc-why-card pfx-reveal<?php echo $i ? ' pfx-delay-' . min($i * 2, 6) : ''; ?>">
        <div class="svc-why-bar" aria-hidden="true"></div>
        <div class="svc-why-icon" aria-hidden="true"><svg width="22" height="22" viewBox="0 0 22 22" style="fill:none;stroke:#00BFF3;stroke-width:1.7;stroke-linecap:round;stroke-linejoin:round"><?php echo stretch_svc_why_icon($why_icon_lib, $benefit['title'] ?? '', $i); ?></svg></div>
        <h3><?php echo esc_html($benefit['title'] ?? ''); ?></h3>
        <p><?php echo wp_kses_post($benefit['description'] ?? ''); ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<!-- wedge: Ink → next (down-right) -->
<div class="svc-wedge" aria-hidden="true" style="background:#1a1f2e"><div style="background:<?php echo esc_attr(stretch_svc_next_fill($flow, 'why')); ?>;clip-path:polygon(0 100%,100% 0,100% 100%)"></div></div>
<?php endif; ?>

<?php if ($testimonials) : ?>
<!-- ============ TESTIMONIALS (white, tilt cards) ============ -->
<section class="svc-testimonials" aria-label="<?php echo esc_attr($testimonials_heading); ?>">
  <?php echo stretch_svc_chapter(); ?>
  <div class="svc-testimonials-inner">
    <div class="svc-head pfx-reveal">
      <span class="pfx-overline"><?php echo esc_html($testimonials_overline); ?></span>
      <h2 class="svc-h2"><?php echo esc_html($testimonials_heading); ?></h2>
      <?php if ($testimonials_subheading !== '') : ?><p class="svc-lede"><?php echo esc_html($testimonials_subheading); ?></p><?php endif; ?>
    </div>
    <div class="svc-testimonials-grid">
      <?php foreach ($testimonials as $i => $t) : ?>
      <div class="svc-tcard pfx-tilt pfx-reveal<?php echo $i ? ' pfx-delay-' . min($i * 2, 6) : ''; ?>">
        <div class="svc-tcard-mark" aria-hidden="true">&ldquo;</div>
        <p class="svc-tcard-quote"><?php echo wp_kses_post($t['quote'] ?? ''); ?></p>
        <div class="svc-tcard-person">
          <div class="svc-tcard-avatar"><?php
            $t_img   = !empty($t['image']) ? (int) $t['image'] : 0;
            $t_photo = $t_img ? wp_get_attachment_image($t_img, 'thumbnail', false, [
                'loading' => 'lazy', 'alt' => ($t['name'] ?? 'Client') . ' photo', 'class' => 'svc-photo-img',
            ]) : '';
            if ($t_photo) {
                echo $t_photo;
            } else {
                $t_ini = stretch_svc_initials($t['name'] ?? '');
                if ($t_ini !== '') {
                    echo '<span class="svc-tcard-mono" aria-hidden="true">' . esc_html($t_ini) . '</span>';
                }
            }
          ?></div>
          <div>
            <div class="svc-tcard-name"><?php echo esc_html($t['name'] ?? ''); ?></div>
            <?php if (!empty($t['title'])) : ?><div class="svc-tcard-role"><?php echo esc_html($t['title']); ?></div><?php endif; ?>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if ($faqs) : ?>
<!-- ============ FAQ (Light bg 1, native details) ============ -->
<section class="svc-faq" aria-label="<?php echo esc_attr($faq_heading); ?>">
  <?php echo stretch_svc_chapter(); ?>
  <div class="svc-faq-inner">
    <div class="svc-faq-head pfx-reveal">
      <span class="pfx-overline"><?php echo esc_html($faq_overline); ?></span>
      <h2 class="svc-h2"><?php echo esc_html($faq_heading); ?></h2>
    </div>
    <div class="pfx-reveal">
      <?php foreach ($faqs as $faq) : ?>
      <details>
        <summary><?php echo esc_html($faq['question'] ?? ''); ?><span class="svc-faq-marker" aria-hidden="true">+</span></summary>
        <p class="svc-faq-answer"><?php echo wp_kses_post($faq['answer'] ?? ''); ?></p>
      </details>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- wedge: prev → Purple (down-left) -->
<div class="svc-wedge" aria-hidden="true" style="background:<?php echo esc_attr(stretch_svc_prev_fill($flow, 'cta', '#f9f9fb')); ?>"><div style="background:#8560A8;clip-path:polygon(0 0,100% 100%,0 100%)"></div></div>

<!-- ============ FINAL CTA (gradient + orbs) ============ -->
<section class="svc-cta" data-grain aria-label="Call to Action">
  <?php echo stretch_svc_chapter(true); ?>
  <div class="svc-cta-orb-a" aria-hidden="true"></div>
  <div class="svc-cta-orb-b" aria-hidden="true"></div>
  <div class="svc-cta-inner">
    <h2 class="pfx-reveal"><?php echo esc_html($cta_heading); ?></h2>
    <?php if ($cta_sub !== '') : ?><p class="svc-cta-sub pfx-reveal pfx-delay-1"><?php echo esc_html($cta_sub); ?></p><?php endif; ?>
    <?php if ($cta_text !== '') : ?><p class="svc-cta-text pfx-reveal pfx-delay-1"><?php echo wp_kses_post($cta_text); ?></p><?php endif; ?>
    <div class="svc-cta-buttons pfx-reveal pfx-delay-2">
      <a href="<?php echo esc_url($cta_btn_url); ?>" class="pfx-btn-primary"><span><?php echo esc_html($cta_btn_label); ?> →</span></a>
      <?php if ($cta_sec_label !== '') : ?><a href="<?php echo esc_url($cta_sec_url); ?>" class="pfx-btn-outline"><?php echo esc_html($cta_sec_label); ?></a><?php endif; ?>
    </div>
  </div>
</section>

<?php get_footer(); ?>
