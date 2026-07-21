<?php
/**
 * Template Name: Industry Page
 * Premium redesign (Phase 3). Recreates design_handoff_stretch_pages/"Industry - Ecommerce.dc.html".
 * Data-driven: reads the stretch_industry_{slug} option (setup-industries.php).
 */
get_header();
get_template_part('template-parts/premium-fx');

$slug = get_post_field('post_name', get_the_ID());
$d    = get_option('stretch_industry_' . $slug, []);

$contact_url = '/contact-stretch-creative/';
$work_url    = '/our-work/';

$overline    = !empty($d['overline'])          ? $d['overline']          : get_the_title();
$h1          = !empty($d['h1'])                ? $d['h1']                : get_the_title();
$h1_accent   = !empty($d['h1_accent'])         ? $d['h1_accent']         : '';
$hero_text   = !empty($d['hero_text'])         ? $d['hero_text']         : '';
$cta_label   = !empty($d['cta_label'])         ? $d['cta_label']         : 'Schedule a Discovery Call';
$audiences   = !empty($d['audiences'])         ? $d['audiences']         : [];
$ch_intro    = !empty($d['challenges_intro'])  ? $d['challenges_intro']  : [];
$ch_photo    = array_key_exists('challenges_photo', $d) ? $d['challenges_photo'] : null; // isset => render slot (gradient fallback)
$ch_title    = !empty($d['challenges_list_title']) ? $d['challenges_list_title'] : ('Many ' . strtolower($overline) . ' businesses struggle with:');
$challenges  = !empty($d['challenges'])        ? $d['challenges']        : [];
$sol_head    = !empty($d['solutions_heading']) ? $d['solutions_heading'] : 'Solutions Built for You';
$sol_accent  = !empty($d['solutions_heading_accent']) ? $d['solutions_heading_accent'] : '';
$solutions   = !empty($d['solutions'])         ? $d['solutions']         : [];
$mid_cta     = !empty($d['mid_cta_text'])      ? $d['mid_cta_text']      : '';
$gallery     = !empty($d['gallery'])           ? $d['gallery']           : [];
$pop_head    = !empty($d['popular_heading'])   ? $d['popular_heading']   : 'Most Popular Services';
$popular     = !empty($d['popular'])           ? $d['popular']           : [];
$why         = !empty($d['why'])               ? $d['why']               : [];
$faqs        = !empty($d['faqs'])              ? $d['faqs']              : [];
$final_head  = !empty($d['final_heading'])     ? $d['final_heading']     : 'Ready to Get Started?';
$final_text  = !empty($d['final_text'])        ? $d['final_text']        : '';

/** Inline Lucide-style icon library for industry data (24px viewBox, stroke 1.5). */
function stretch_industry_icon($key) {
    $icons = [
        'shirt'      => '<path d="M20.38 3.46 16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"/>',
        'cup'        => '<path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/>',
        'sparkle'    => '<path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z"/>',
        'box'        => '<path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/>',
        'cart'       => '<circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>',
        'storefront' => '<path d="M3 9l1-5h16l1 5"/><path d="M4 9v11a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V9"/><path d="M9 21v-6a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v6"/><path d="M3 9a3 3 0 0 0 6 0 3 3 0 0 0 6 0 3 3 0 0 0 6 0"/>',
        'search'     => '<circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>',
        'file-text'  => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/>',
        'book-open'  => '<path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>',
        'camera'     => '<path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/>',
        'target'     => '<circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>',
        'map-pin'    => '<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>',
        'layout'     => '<rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/>',
        'pen'        => '<path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"/><polygon points="18 2 22 6 12 16 8 16 8 12 18 2"/>',
        'chart'      => '<line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>',
        'shield'     => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>',
        'users'      => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
        'message'    => '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>',
        'globe'      => '<circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>',
        'wrench'     => '<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>',
        'briefcase'  => '<rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>',
        'monitor'    => '<rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/>',
        'heart'      => '<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>',
        'graduation' => '<path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/>',
    ];
    return isset($icons[$key]) ? $icons[$key] : '';
}
$stretch_default_icon_rotation = ['storefront', 'box', 'sparkle', 'cart', 'globe', 'users', 'chart', 'target'];
$stretch_sol_icon_rotation     = ['search', 'file-text', 'book-open', 'camera', 'target', 'chart'];

/** Attachment image or neutral gradient placeholder (no external requests). */
function stretch_industry_media($id, $alt) {
    $img = wp_get_attachment_image((int) $id, 'large', false, [
        'loading' => 'lazy', 'alt' => $alt, 'class' => 'ind-media-img',
    ]);
    if ($img) { return $img; }
    return '<div class="ind-media-img ind-media-img--empty" role="img" aria-label="' . esc_attr($alt) . '"></div>';
}
?>
<style>
html, body { overflow-x: hidden; }
.admin-bar .site-nav { top: 32px; }
@media (max-width: 782px) { .admin-bar .site-nav { top: 46px; } }

/* ===== HERO ===== */
.ind-hero { min-height: 74vh; }
.ind-hero-inner { position: relative; z-index: 2; max-width: 1200px; width: 100%; margin: 0 auto; padding: 150px clamp(24px, 4vw, 40px) 110px; display: flex; flex-direction: column; align-items: flex-start; text-align: left; }
.ind-hero-title { font-family: 'Poppins', sans-serif; font-weight: 600; font-size: clamp(38px, 5vw, 64px); letter-spacing: -1.5px; line-height: 1.1; color: #fff; margin: 0 0 22px; max-width: 860px; }
.ind-hero-lede { font-family: 'Assistant', sans-serif; font-weight: 300; font-size: clamp(17px, 1.5vw, 20px); line-height: 1.7; color: rgba(255,255,255,0.85); max-width: 620px; margin: 0 0 38px; }
.ind-hero-wedge { position: absolute; left: 0; right: 0; bottom: -1px; height: 60px; background: #fff; clip-path: polygon(0 100%, 100% 0, 100% 100%); z-index: 1; pointer-events: none; }

/* ===== WEDGE DIVIDERS (standalone) ===== */
.ind-wedge { height: 60px; position: relative; line-height: 0; }
.ind-wedge > div { position: absolute; inset: 0; }

/* ===== SHARED HEADS ===== */
.ind-head { text-align: center; margin: 0 auto 56px; }
.ind-h2 { font-family: 'Poppins', sans-serif; font-weight: 600; font-size: clamp(30px, 3.4vw, 44px); letter-spacing: -1px; line-height: 1.15; margin: 0; color: #1a1f2e; }

/* ===== WHO WE WORK WITH ===== */
.ind-audiences { background: #fff; padding: 92px 0 96px; }
.ind-audiences-inner { max-width: 1100px; margin: 0 auto; padding: 0 clamp(24px, 4vw, 40px); text-align: center; }
.ind-audiences .ind-h2 { margin-bottom: 44px; }
.ind-chips { display: flex; flex-wrap: wrap; gap: 14px; justify-content: center; }
.ind-chip { display: inline-flex; align-items: center; gap: 10px; padding: 12px 24px; border-radius: 999px; border: 1px solid transparent; background: linear-gradient(#fff, #fff) padding-box, linear-gradient(135deg, #8560A8, #448CCB, #00BFF3) border-box; font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 15px; color: #3c4354; white-space: nowrap; transition: transform 0.4s cubic-bezier(0.16,1,0.3,1); }
.ind-chip:hover { transform: translateY(-3px); }
.ind-chip svg { width: 16px; height: 16px; fill: none; stroke: #5674B9; stroke-width: 1.5; stroke-linecap: round; stroke-linejoin: round; flex: 0 0 auto; }

/* ===== CHALLENGES ===== */
.ind-challenges { background: #f9f9fb; padding: 96px 0 104px; }
.ind-challenges-inner { max-width: 1200px; margin: 0 auto; padding: 0 clamp(24px, 4vw, 40px); display: grid; grid-template-columns: 1fr 1.1fr; gap: clamp(32px, 4vw, 64px); align-items: start; }
.ind-challenges .ind-eyebrow-h2 { font-family: 'Poppins', sans-serif; font-weight: 600; font-size: clamp(30px, 3.4vw, 44px); letter-spacing: -1px; line-height: 1.15; margin: 0 0 22px; color: #1a1f2e; }
.ind-challenges p { margin: 0 0 18px; font-family: 'Assistant', sans-serif; font-size: 16.5px; font-weight: 300; line-height: 1.8; color: #4a5364; }
.ind-challenges p:last-of-type { margin-bottom: 0; }
.ind-challenges-photo { margin-top: 30px; border-radius: 16px; overflow: hidden; height: 240px; border: 1px solid #e9e9f1; box-shadow: 0 18px 40px rgba(26,31,46,0.08); }
.ind-media-img { display: block; width: 100%; height: 100%; object-fit: cover; }
.ind-media-img--empty { background: linear-gradient(135deg, #e8eaf1, #f3f4f8); }
.ind-pain-panel { position: relative; overflow: hidden; background: #fff; border: 1px solid #e9e9f1; border-radius: 16px; padding: 36px 36px 36px 42px; box-shadow: 0 16px 40px rgba(26,31,46,0.06); }
.ind-pain-panel::before { content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 4px; background: linear-gradient(180deg, #8560A8, #00BFF3); }
.ind-pain-panel h3 { font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 19px; margin: 0 0 20px; color: #1a1f2e; }
.ind-pain-list { list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; gap: 13px; }
.ind-pain-list li { display: flex; gap: 12px; font-family: 'Assistant', sans-serif; font-size: 15.5px; line-height: 1.55; color: #4a5364; }
.ind-pain-list li span { color: #8560A8; font-weight: 700; flex-shrink: 0; }

/* ===== WHAT WE DO ===== */
.ind-solutions { background: #fff; padding: 100px 0 60px; }
.ind-solutions-inner { max-width: 1200px; margin: 0 auto; padding: 0 clamp(24px, 4vw, 40px); }
.ind-solutions .ind-head { max-width: 760px; }
.ind-solutions-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 26px; }
.ind-sol-card { position: relative; background: #fff; border: 1px solid #e9e9f1; border-radius: 14px; padding: 34px 30px; overflow: hidden; transition: transform 0.35s ease, box-shadow 0.35s ease; }
.ind-sol-card:hover { transform: translateY(-6px); box-shadow: 0 22px 44px rgba(26,31,46,0.10); }
.ind-sol-card--wide { grid-column: 1 / -1; }
.ind-sol-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 22px; }
.ind-sol-icon { width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, rgba(133,96,168,0.12), rgba(0,191,243,0.12)); display: flex; align-items: center; justify-content: center; }
.ind-sol-icon svg { width: 24px; height: 24px; fill: none; stroke: #448CCB; stroke-width: 1.7; stroke-linecap: round; stroke-linejoin: round; }
.ind-sol-num { font-family: 'Montserrat', sans-serif; font-size: 13px; font-weight: 600; letter-spacing: 2px; color: #c3c8d4; }
.ind-sol-card h3 { font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 20px; margin: 0 0 12px; color: #1a1f2e; }
.ind-sol-card p { margin: 0; font-family: 'Assistant', sans-serif; font-size: 15px; font-weight: 300; line-height: 1.7; color: #4a5364; }

/* ===== MID CTA ===== */
.ind-midcta { background: #fff; padding: 50px clamp(24px, 4vw, 40px) 110px; }
.ind-midcta .pfx-gradient-card { max-width: 1120px; margin: 0 auto; }
.ind-midcta .pfx-gradient-card-inner { padding: 60px clamp(28px, 5vw, 72px); }
.ind-midcta h2 { font-family: 'Poppins', sans-serif; font-weight: 600; font-size: clamp(26px, 2.8vw, 36px); letter-spacing: -0.8px; margin: 0 0 30px; color: #fff; line-height: 1.25; }

/* ===== WORK GALLERY ===== */
.ind-gallery { background: #fff; padding: 0 0 104px; }
.ind-gallery-inner { max-width: 1200px; margin: 0 auto; padding: 0 clamp(24px, 4vw, 40px); display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 20px; }
.ind-gallery-tile { position: relative; border-radius: 16px; overflow: hidden; height: 280px; border: 1px solid #e9e9f1; }
.ind-gallery-pill { position: absolute; bottom: 14px; left: 14px; background: rgba(26,31,46,0.85); color: #fff; padding: 6px 14px; border-radius: 999px; font-family: 'Montserrat', sans-serif; font-size: 11px; font-weight: 600; letter-spacing: 1.5px; text-transform: uppercase; pointer-events: none; }

/* ===== POPULAR SERVICES ===== */
.ind-popular { background: #f9f9fb; padding: 96px 0 104px; }
.ind-popular-inner { max-width: 1200px; margin: 0 auto; padding: 0 clamp(24px, 4vw, 40px); }
.ind-popular .ind-head { max-width: 760px; margin-bottom: 54px; }
.ind-popular-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 22px; }
.ind-pop-card { position: relative; overflow: hidden; background: #fff; border: 1px solid #e9e9f1; border-radius: 12px; padding: 28px 26px; transition: transform 0.3s ease, box-shadow 0.3s ease; }
.ind-pop-card:hover { transform: translateY(-4px); box-shadow: 0 16px 34px rgba(26,31,46,0.08); }
.ind-pop-bar { position: absolute; top: 0; left: 0; height: 3px; width: 44px; background: linear-gradient(90deg, #8560A8, #448CCB, #00BFF3); transition: width 0.45s ease; }
.ind-pop-card:hover .ind-pop-bar { width: 100%; }
.ind-pop-card h3 { font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 17px; margin: 0 0 10px; color: #1a1f2e; }
.ind-pop-card p { margin: 0; font-family: 'Assistant', sans-serif; font-size: 14.5px; font-weight: 300; line-height: 1.65; color: #4a5364; }

/* ===== WHY (dark) ===== */
.ind-why { position: relative; background: #1a1f2e; padding: 100px clamp(24px, 4vw, 40px) 110px; overflow: hidden; }
.ind-why-inner { position: relative; z-index: 1; max-width: 1200px; margin: 0 auto; }
.ind-why .ind-head { max-width: 720px; }
.ind-why .ind-h2 { color: #fff; }
.ind-why-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 24px; }
.ind-why-card { position: relative; overflow: hidden; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.09); border-radius: 14px; padding: 34px; }
.ind-why-card h3 { font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 19px; margin: 0 0 12px; color: #fff; }
.ind-why-card p { margin: 0; font-family: 'Assistant', sans-serif; font-size: 15px; line-height: 1.7; color: rgba(255,255,255,0.7); }

/* ===== FAQ ===== */
.ind-faqs { background: #fff; padding: 90px 0 100px; }
.ind-faqs-inner { max-width: 820px; margin: 0 auto; padding: 0 clamp(24px, 4vw, 40px); }
.ind-faqs .ind-head { margin-bottom: 44px; }
.ind-faq { border-bottom: 1px solid #e4e6ee; }
.ind-faq:last-child { border-bottom: none; }
.ind-faq summary { display: flex; align-items: center; justify-content: space-between; gap: 20px; padding: 24px 0; font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 17px; color: #1a1f2e; list-style: none; cursor: pointer; }
.ind-faq summary::-webkit-details-marker { display: none; }
.ind-faq summary span { color: #00BFF3; font-weight: 600; font-size: 22px; flex-shrink: 0; transition: transform 0.3s ease; }
.ind-faq[open] summary span { transform: rotate(45deg); }
.ind-faq p { margin: 0; padding: 0 44px 24px 0; font-family: 'Assistant', sans-serif; font-size: 15.5px; font-weight: 300; line-height: 1.75; color: #4a5364; }

/* ===== FINAL CTA ===== */
.ind-finalcta { position: relative; overflow: hidden; background: linear-gradient(170deg, #8560A8 0%, #3d2d66 30%, #252C3A 70%, #1a1f2e 100%); padding: 130px clamp(24px, 4vw, 40px); text-align: center; }
.ind-cta-orb-a { position: absolute; width: 420px; height: 420px; left: -120px; top: -80px; border-radius: 50%; background: radial-gradient(circle, rgba(0,191,243,0.16), transparent 70%); animation: ind-floatA 14s ease-in-out infinite; pointer-events: none; }
.ind-cta-orb-b { position: absolute; width: 540px; height: 540px; right: -170px; bottom: -150px; border-radius: 50%; background: radial-gradient(circle, rgba(133,96,168,0.3), transparent 70%); animation: ind-floatB 17s ease-in-out infinite; pointer-events: none; }
@keyframes ind-floatA { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(28px, -26px); } }
@keyframes ind-floatB { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(-24px, 22px); } }
.ind-cta-inner { position: relative; z-index: 1; max-width: 760px; margin: 0 auto; }
.ind-finalcta h2 { font-family: 'Poppins', sans-serif; font-weight: 600; font-size: clamp(34px, 4vw, 52px); letter-spacing: -1.2px; margin: 0 0 18px; color: #fff; }
.ind-finalcta p { margin: 0 auto; max-width: 640px; font-family: 'Assistant', sans-serif; font-weight: 300; font-size: 17px; line-height: 1.75; color: rgba(255,255,255,0.8); }
.ind-cta-buttons { display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; margin-top: 38px; }

@media (max-width: 960px) {
  .ind-challenges-inner { grid-template-columns: 1fr; gap: 36px; }
  .ind-solutions-grid { grid-template-columns: 1fr; }
  .ind-sol-card--wide { grid-column: auto; }
  .ind-popular-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
  .ind-gallery-inner { grid-template-columns: repeat(2, minmax(0, 1fr)); }
  .ind-why-grid { grid-template-columns: 1fr; }
}
@media (max-width: 600px) {
  .ind-popular-grid, .ind-gallery-inner { grid-template-columns: 1fr; }
  .ind-hero-inner { padding: 130px clamp(24px, 4vw, 40px) 90px; }
  .ind-hero { min-height: auto; }
}
@media (prefers-reduced-motion: reduce) {
  .ind-chip, .ind-sol-card, .ind-pop-card, .ind-pop-bar, .ind-faq summary span { transition: none !important; }
  .ind-cta-orb-a, .ind-cta-orb-b { animation: none !important; }
}
</style>

<!-- HERO -->
<section class="pfx-hero pfx-hero--left ind-hero" data-grain aria-label="Intro">
  <div class="pfx-hero-grid"></div>
  <div class="ind-hero-inner">
    <span class="pfx-overline pfx-reveal"><?php echo esc_html($overline); ?></span>
    <h1 class="ind-hero-title pfx-reveal pfx-delay-1"><?php echo stretch_accent_title($h1, $h1_accent); ?></h1>
    <?php if ($hero_text) : ?><p class="ind-hero-lede pfx-reveal pfx-delay-2"><?php echo esc_html($hero_text); ?></p><?php endif; ?>
    <a href="<?php echo esc_url($contact_url); ?>" class="pfx-btn-primary pfx-reveal pfx-delay-3"><span><?php echo esc_html($cta_label); ?> &rarr;</span></a>
  </div>
  <div class="ind-hero-wedge" aria-hidden="true"></div>
</section>
<div class="pfx-accent-bar"></div>

<?php if ($audiences) : ?>
<!-- WHO WE WORK WITH -->
<section class="ind-audiences" aria-label="Who We Work With">
  <div class="ind-audiences-inner">
    <div class="pfx-reveal">
      <span class="pfx-overline">Who We Work With</span>
      <h2 class="ind-h2">Brands and teams we partner with</h2>
    </div>
    <div class="ind-chips pfx-reveal pfx-delay-1">
      <?php foreach ($audiences as $i => $aud) :
          $label = is_array($aud) ? ($aud['label'] ?? '') : $aud;
          if ($label === '') { continue; }
          $icon_key = is_array($aud) && !empty($aud['icon']) ? $aud['icon'] : $stretch_default_icon_rotation[$i % count($stretch_default_icon_rotation)];
          $icon = stretch_industry_icon($icon_key);
      ?>
        <span class="ind-chip">
          <?php if ($icon) : ?><svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><?php echo $icon; // phpcs:ignore -- static SVG library above ?></svg><?php endif; ?>
          <?php echo esc_html($label); ?>
        </span>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if ($ch_intro || $challenges) : ?>
<!-- CHALLENGES -->
<section class="ind-challenges" aria-label="Challenges">
  <div class="ind-challenges-inner">
    <div class="pfx-reveal-left">
      <span class="pfx-overline">The Reality</span>
      <h2 class="ind-eyebrow-h2"><?php echo esc_html($overline); ?> Challenges</h2>
      <?php foreach ($ch_intro as $p) : ?><p><?php echo esc_html($p); ?></p><?php endforeach; ?>
      <?php if ($ch_photo !== null) : ?>
        <div class="ind-challenges-photo pfx-reveal"><?php echo stretch_industry_media($ch_photo, esc_html($overline) . ' storefront'); ?></div>
      <?php endif; ?>
    </div>
    <?php if ($challenges) : ?>
    <div class="ind-pain-panel pfx-reveal-right">
      <h3><?php echo esc_html($ch_title); ?></h3>
      <ul class="ind-pain-list">
        <?php foreach ($challenges as $c) : ?><li><span aria-hidden="true">&#10005;</span><?php echo esc_html($c); ?></li><?php endforeach; ?>
      </ul>
    </div>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>

<?php if ($solutions) : ?>
<!-- WHAT WE DO -->
<section class="ind-solutions" aria-label="Solutions">
  <div class="ind-solutions-inner">
    <div class="ind-head pfx-reveal">
      <span class="pfx-overline">What We Do</span>
      <h2 class="ind-h2"><?php echo stretch_accent_title($sol_head, $sol_accent); ?></h2>
    </div>
    <div class="ind-solutions-grid">
      <?php
      $sol_count = count($solutions);
      foreach ($solutions as $i => $s) :
          $icon_key = !empty($s['icon']) ? $s['icon'] : $stretch_sol_icon_rotation[$i % count($stretch_sol_icon_rotation)];
          $icon = stretch_industry_icon($icon_key);
          // Last card spans full width when it would otherwise sit alone on its row (odd count).
          $wide = ($i === $sol_count - 1 && $sol_count % 2 === 1);
      ?>
        <div class="ind-sol-card pfx-sweep<?php echo $wide ? ' ind-sol-card--wide' : ''; ?> pfx-reveal pfx-delay-<?php echo (($i % 2) + 1); ?>">
          <div class="pfx-sweep-bar pfx-sweep-bar--top"></div>
          <div class="ind-sol-top">
            <?php if ($icon) : ?><div class="ind-sol-icon"><svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><?php echo $icon; // phpcs:ignore -- static SVG library ?></svg></div><?php endif; ?>
            <span class="ind-sol-num"><?php echo esc_html(str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT)); ?></span>
          </div>
          <h3><?php echo esc_html($s['title']); ?></h3>
          <p><?php echo esc_html($s['body']); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if ($mid_cta) : ?>
<!-- MID CTA -->
<section class="ind-midcta" aria-label="Get Started">
  <div class="pfx-gradient-card pfx-reveal">
    <div class="pfx-gradient-card-inner dark">
      <h2><?php echo esc_html($mid_cta); ?></h2>
      <a href="<?php echo esc_url($contact_url); ?>" class="pfx-btn-primary"><span><?php echo esc_html($cta_label); ?> &rarr;</span></a>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if ($gallery) : ?>
<!-- WORK GALLERY -->
<section class="ind-gallery" aria-label="Work Gallery">
  <div class="ind-gallery-inner">
    <?php foreach ($gallery as $i => $g) :
        $label = is_array($g) ? ($g['label'] ?? '') : (string) $g;
        $image = is_array($g) ? ($g['image'] ?? 0) : 0;
    ?>
      <div class="ind-gallery-tile pfx-reveal pfx-delay-<?php echo (($i % 3) + 1); ?>">
        <?php echo stretch_industry_media($image, $label); ?>
        <?php if ($label !== '') : ?><span class="ind-gallery-pill"><?php echo esc_html($label); ?></span><?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>

<?php if ($popular) : ?>
<!-- POPULAR SERVICES -->
<section class="ind-popular" aria-label="Popular Services">
  <div class="ind-popular-inner">
    <div class="ind-head pfx-reveal">
      <span class="pfx-overline">Services</span>
      <h2 class="ind-h2"><?php echo esc_html($pop_head); ?></h2>
    </div>
    <div class="ind-popular-grid">
      <?php foreach ($popular as $i => $p) : ?>
        <div class="ind-pop-card pfx-reveal pfx-delay-<?php echo (($i % 3) + 1); ?>">
          <div class="ind-pop-bar"></div>
          <h3><?php echo esc_html($p['title']); ?></h3>
          <p><?php echo esc_html($p['body']); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- TRUSTED BRANDS MARQUEE -->
<?php stretch_pfx_logo_marquee(true); ?>

<?php if ($why) : ?>
<!-- wedge: white -> Ink (down-left) -->
<div class="ind-wedge" aria-hidden="true" style="background:#ffffff"><div style="background:#1a1f2e;clip-path:polygon(0 0,100% 100%,0 100%)"></div></div>

<!-- WHY STRETCH (dark) -->
<section class="ind-why" data-grain aria-label="Why Stretch Creative">
  <div class="ind-why-inner">
    <div class="ind-head pfx-reveal">
      <span class="pfx-overline">Why Stretch</span>
      <h2 class="ind-h2">Why Stretch Creative?</h2>
    </div>
    <div class="ind-why-grid">
      <?php foreach ($why as $i => $w) : ?>
        <div class="ind-why-card pfx-sweep pfx-reveal pfx-delay-<?php echo (($i % 2) + 1); ?>">
          <div class="pfx-sweep-bar pfx-sweep-bar--left"></div>
          <h3><?php echo esc_html($w['title']); ?></h3>
          <p><?php echo esc_html($w['body']); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<!-- wedge: Ink -> white/purple (down-right) -->
<div class="ind-wedge" aria-hidden="true" style="background:#1a1f2e"><div style="background:<?php echo $faqs ? '#ffffff' : '#8560A8'; ?>;clip-path:polygon(0 100%,100% 0,100% 100%)"></div></div>
<?php endif; ?>

<?php if ($faqs) : ?>
<?php if (!$why) : ?>
<!-- wedge: white -> white spacer omitted; marquee(white) flows straight into FAQ(white) -->
<?php endif; ?>
<!-- FAQ -->
<section class="ind-faqs" aria-label="FAQs">
  <div class="ind-faqs-inner">
    <div class="ind-head pfx-reveal">
      <span class="pfx-overline">FAQs</span>
      <h2 class="ind-h2">Frequently asked questions</h2>
    </div>
    <div class="pfx-reveal">
      <?php foreach ($faqs as $f) : ?>
        <details class="ind-faq">
          <summary><?php echo esc_html($f['q']); ?><span aria-hidden="true">+</span></summary>
          <p><?php echo esc_html($f['a']); ?></p>
        </details>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<!-- wedge: white -> purple (down-left) -->
<div class="ind-wedge" aria-hidden="true" style="background:#ffffff"><div style="background:#8560A8;clip-path:polygon(0 0,100% 100%,0 100%)"></div></div>
<?php
    $faq_ld = ['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => []];
    foreach ($faqs as $f) {
        $faq_ld['mainEntity'][] = ['@type' => 'Question', 'name' => $f['q'], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']]];
    }
    echo '<script type="application/ld+json">' . wp_json_encode($faq_ld) . '</script>';
?>
<?php elseif (!$why) : ?>
<!-- No why/faq: bridge marquee(white) -> final(purple) -->
<div class="ind-wedge" aria-hidden="true" style="background:#ffffff"><div style="background:#8560A8;clip-path:polygon(0 0,100% 100%,0 100%)"></div></div>
<?php endif; ?>

<!-- FINAL CTA -->
<section class="ind-finalcta" data-grain aria-label="Contact">
  <div class="ind-cta-orb-a"></div>
  <div class="ind-cta-orb-b"></div>
  <div class="ind-cta-inner">
    <h2 class="pfx-reveal"><?php echo esc_html($final_head); ?></h2>
    <?php if ($final_text) : ?><p class="pfx-reveal pfx-delay-1"><?php echo esc_html($final_text); ?></p><?php endif; ?>
    <div class="ind-cta-buttons pfx-reveal pfx-delay-2">
      <a href="<?php echo esc_url($contact_url); ?>" class="pfx-btn-primary"><span><?php echo esc_html($cta_label); ?> &rarr;</span></a>
      <a href="<?php echo esc_url($work_url); ?>" class="pfx-btn-outline">See Our Work</a>
    </div>
  </div>
</section>

<?php get_footer(); ?>
