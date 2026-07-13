<?php
/**
 * Template Name: Industry Page
 * Premium redesign (Phase 2). Data: stretch_industry_{slug} option (setup-industries.php).
 */
get_header();
get_template_part('template-parts/premium-fx');

$slug = get_post_field('post_name', get_the_ID());
$d    = get_option('stretch_industry_' . $slug, []);

$contact_url = '/contact-stretch-creative/';
$overline    = !empty($d['overline'])          ? $d['overline']          : get_the_title();
$h1          = !empty($d['h1'])                ? $d['h1']                : get_the_title();
$hero_text   = !empty($d['hero_text'])         ? $d['hero_text']         : '';
$cta_label   = !empty($d['cta_label'])         ? $d['cta_label']         : 'Schedule a Discovery Call';
$audiences   = !empty($d['audiences'])         ? $d['audiences']         : [];
$ch_intro    = !empty($d['challenges_intro'])  ? $d['challenges_intro']  : [];
$challenges  = !empty($d['challenges'])        ? $d['challenges']        : [];
$sol_head    = !empty($d['solutions_heading']) ? $d['solutions_heading'] : 'Solutions Built for You';
$solutions   = !empty($d['solutions'])         ? $d['solutions']         : [];
$mid_cta     = !empty($d['mid_cta_text'])      ? $d['mid_cta_text']      : '';
$pop_head    = !empty($d['popular_heading'])   ? $d['popular_heading']   : 'Most Popular Services';
$popular     = !empty($d['popular'])           ? $d['popular']           : [];
$why         = !empty($d['why'])               ? $d['why']               : [];
$faqs        = !empty($d['faqs'])              ? $d['faqs']              : [];
$final_head  = !empty($d['final_heading'])     ? $d['final_heading']     : 'Ready to Get Started?';
$final_text  = !empty($d['final_text'])        ? $d['final_text']        : '';

/** Inline Lucide-style icon library for industry data (24px, stroke 1.5). */
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
?>
<style>
html, body { overflow-x: hidden; }
.admin-bar .site-nav { top: 32px; }
@media (max-width: 782px) { .admin-bar .site-nav { top: 46px; } }
.ind-section h2 { font-family: 'Poppins', sans-serif; font-size: clamp(28px, 3.4vw, 42px); font-weight: 600; line-height: 1.15; margin: 0 0 28px; letter-spacing: -0.5px; color: #1a1f2e; }

.ind-hero { min-height: 64vh; padding: 170px 0 120px; }
.ind-hero-content { position: relative; z-index: 2; max-width: 840px; }
.ind-hero-content h1 { font-family: 'Poppins', sans-serif; font-size: clamp(34px, 4.4vw, 56px); font-weight: 600; line-height: 1.1; color: #fff; margin: 0 0 22px; letter-spacing: -1px; }
.ind-hero-content p { font-family: 'Assistant', sans-serif; font-size: 20px; font-weight: 300; line-height: 1.6; color: #cfd6e4; margin: 0 0 36px; max-width: 680px; }

.ind-audiences { background: #fff; padding: 90px 0; position: relative; }
.ind-chips { display: flex; flex-wrap: wrap; gap: 14px; margin-top: 8px; }
.ind-chip { position: relative; font-family: 'Assistant', sans-serif; font-size: 16px; font-weight: 600; color: #2a3247; background: #fff; padding: 13px 24px; border-radius: 40px; border: 1px solid transparent; background-clip: padding-box; box-shadow: 0 2px 12px rgba(26,31,46,0.06); transition: transform 0.4s cubic-bezier(0.16,1,0.3,1), box-shadow 0.4s ease; cursor: default; }
.ind-chip::before { content: ''; position: absolute; inset: -1px; border-radius: 41px; padding: 1.5px; background: linear-gradient(135deg, rgba(133,96,168,0.5), rgba(86,116,185,0.4), rgba(0,191,243,0.5)); -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0); -webkit-mask-composite: xor; mask-composite: exclude; pointer-events: none; }
.ind-chip:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(133,96,168,0.15); }

.ind-challenges { background: #f9f9fb; padding: 100px 0; position: relative; }
.ind-challenges-grid { display: grid; grid-template-columns: 1fr 1.1fr; gap: 60px; align-items: start; }
.ind-challenges .ind-intro p { font-family: 'Assistant', sans-serif; font-size: 18px; line-height: 1.75; color: #444; margin: 0 0 20px; }
.ind-pain-panel { background: #fff; border-radius: 18px; padding: 40px 38px; box-shadow: 0 10px 40px rgba(26,31,46,0.08); position: relative; overflow: hidden; }
.ind-pain-panel::before { content: ''; position: absolute; top: 0; left: 0; bottom: 0; width: 4px; background: linear-gradient(180deg, #8560A8, #5674B9, #00BFF3); }
.ind-pain-panel h3 { font-family: 'Poppins', sans-serif; font-size: 17px; font-weight: 600; color: #1a1f2e; margin: 0 0 22px; }
.ind-pain-list { list-style: none; margin: 0; padding: 0; display: grid; gap: 14px; }
.ind-pain-list li { position: relative; padding-left: 34px; font-family: 'Assistant', sans-serif; font-size: 16px; color: #3a4256; line-height: 1.5; }
.ind-pain-list li::before { content: ''; position: absolute; left: 0; top: 2px; width: 20px; height: 20px; border-radius: 50%; background: rgba(133,96,168,0.12); background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238560A8' stroke-width='3' stroke-linecap='round'%3E%3Cline x1='18' y1='6' x2='6' y2='18'/%3E%3Cline x1='6' y1='6' x2='18' y2='18'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: center; }

.ind-solutions { background: #fff; padding: 100px 0; position: relative; }
.ind-solutions-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 26px; }
.ind-solution-card { position: relative; background: #fff; border: 1px solid #eceef3; border-radius: 16px; padding: 38px 34px 34px; box-shadow: 0 6px 24px rgba(26,31,46,0.05); overflow: hidden; transition: transform 0.5s cubic-bezier(0.16,1,0.3,1), box-shadow 0.5s ease, border-color 0.4s ease; }
.ind-solution-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, var(--sol-start, #8560A8), var(--sol-end, #00BFF3)); transform: scaleX(0); transform-origin: left; transition: transform 0.5s cubic-bezier(0.16,1,0.3,1); }
.ind-solution-card:hover { transform: translateY(-8px); box-shadow: 0 18px 48px rgba(26,31,46,0.11); border-color: transparent; }
.ind-solution-card:hover::before { transform: scaleX(1); }
.ind-sol-head { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 22px; }
.ind-sol-icon { width: 56px; height: 56px; border-radius: 14px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, var(--sol-bg-a, rgba(133,96,168,0.1)), var(--sol-bg-b, rgba(0,191,243,0.1))); transition: transform 0.5s cubic-bezier(0.16,1,0.3,1); }
.ind-sol-icon svg { width: 25px; height: 25px; stroke: var(--sol-start, #8560A8); fill: none; stroke-width: 1.5; stroke-linecap: round; stroke-linejoin: round; }
.ind-solution-card:hover .ind-sol-icon { transform: scale(1.08) rotate(-4deg); }
.ind-sol-num { font-family: 'Montserrat', sans-serif; font-size: 12px; font-weight: 600; letter-spacing: 2px; color: #767676; transition: color 0.4s ease; }
.ind-solution-card:hover .ind-sol-num { color: var(--sol-end, #00BFF3); }
.ind-solution-card h3 { font-family: 'Poppins', sans-serif; font-size: 21px; font-weight: 600; color: #1a1f2e; margin: 0 0 12px; }
.ind-solution-card p { font-family: 'Assistant', sans-serif; font-size: 16px; line-height: 1.68; color: #555; margin: 0; }

.ind-midcta { background: #fff; padding: 10px 0 100px; }
.ind-midcta .pfx-gradient-card { max-width: 880px; margin: 0 auto; }
.ind-midcta h2 { font-size: clamp(24px, 2.8vw, 32px); margin: 0 0 28px; line-height: 1.3; }

.ind-popular { background: #f9f9fb; padding: 100px 0; position: relative; }
.ind-popular-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-top: 8px; }
.ind-pop-card { position: relative; background: #fff; border-radius: 14px; padding: 30px 28px; box-shadow: 0 4px 18px rgba(26,31,46,0.05); overflow: hidden; transition: transform 0.45s cubic-bezier(0.16,1,0.3,1), box-shadow 0.45s ease; }
.ind-pop-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, var(--pop-start, #448CCB), var(--pop-end, #00BFF3)); transform: scaleX(0.22); transform-origin: left; transition: transform 0.5s cubic-bezier(0.16,1,0.3,1); }
.ind-pop-card:hover { transform: translateY(-6px); box-shadow: 0 16px 40px rgba(26,31,46,0.11); }
.ind-pop-card:hover::before { transform: scaleX(1); }
.ind-pop-card h3 { font-family: 'Poppins', sans-serif; font-size: 17px; font-weight: 600; color: #1a1f2e; margin: 0 0 10px; }
.ind-pop-card p { font-family: 'Assistant', sans-serif; font-size: 15px; line-height: 1.6; color: #5a6275; margin: 0; }

.ind-why { background: linear-gradient(170deg, #1a1f2e, #252C3A); padding: 100px 0; position: relative; overflow: hidden; }
.ind-why h2 { color: #fff; }
.ind-why-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; position: relative; z-index: 1; }
.ind-why-card { position: relative; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.09); border-radius: 16px; padding: 34px 30px; overflow: hidden; transition: background 0.4s ease, border-color 0.4s ease; }
.ind-why-card::before { content: ''; position: absolute; top: 0; left: 0; bottom: 0; width: 3px; background: linear-gradient(180deg, var(--why-start, #8560A8), var(--why-end, #00BFF3)); transform: scaleY(0); transform-origin: top; transition: transform 0.5s cubic-bezier(0.16,1,0.3,1); }
.ind-why-card:hover { background: rgba(255,255,255,0.07); border-color: rgba(255,255,255,0.16); }
.ind-why-card:hover::before { transform: scaleY(1); }
.ind-why-card h3 { font-family: 'Poppins', sans-serif; font-size: 19px; font-weight: 600; color: #fff; margin: 0 0 10px; }
.ind-why-card p { font-family: 'Assistant', sans-serif; font-size: 16px; line-height: 1.65; color: #b9c2d4; margin: 0; }

.ind-faqs { background: #fff; padding: 100px 0; }

.ind-finalcta { position: relative; overflow: hidden; background: linear-gradient(170deg, #8560A8, #3d2d66 30%, #252C3A 70%, #1a1f2e); padding: 120px 0; text-align: center; }
.ind-finalcta h2 { color: #fff; margin-bottom: 18px; }
.ind-finalcta p { font-family: 'Assistant', sans-serif; font-size: 19px; line-height: 1.6; color: rgba(255,255,255,0.65); max-width: 720px; margin: 0 auto 32px; }

@media (max-width: 960px) { .ind-challenges-grid { grid-template-columns: 1fr; gap: 36px; } .ind-solutions-grid { grid-template-columns: 1fr; } .ind-popular-grid { grid-template-columns: repeat(2, 1fr); } .ind-why-grid { grid-template-columns: 1fr; } }
@media (max-width: 600px) { .ind-popular-grid { grid-template-columns: 1fr; } .ind-hero { padding: 150px 0 100px; min-height: auto; } }
</style>

<!-- HERO -->
<section class="pfx-hero pfx-hero--left ind-hero ind-section" data-grain aria-label="Intro">
  <div class="pfx-hero-mesh"></div>
  <div class="pfx-hero-grid"></div>
  <div class="pfx-container">
    <div class="ind-hero-content">
      <span class="pfx-overline pfx-reveal pfx-delay-1"><?php echo esc_html($overline); ?></span>
      <h1 class="pfx-reveal pfx-delay-2"><?php echo esc_html($h1); ?></h1>
      <?php if ($hero_text) : ?><p class="pfx-reveal pfx-delay-3"><?php echo esc_html($hero_text); ?></p><?php endif; ?>
      <a href="<?php echo esc_url($contact_url); ?>" class="pfx-btn-primary pfx-reveal pfx-delay-4"><span><?php echo esc_html($cta_label); ?> &rarr;</span></a>
    </div>
  </div>
  <div class="pfx-angle-divider"><svg viewBox="0 0 1440 60" preserveAspectRatio="none" aria-hidden="true" focusable="false"><polygon points="0,60 1440,0 1440,60" fill="#ffffff"/></svg></div>
</section>
<div class="pfx-accent-bar"></div>

<?php if ($audiences) : ?>
<section class="ind-section ind-audiences" aria-label="Who We Work With">
  <div class="pfx-container">
    <span class="pfx-overline pfx-reveal">Who We Work With</span>
    <h2 class="pfx-reveal pfx-delay-1">Brands and teams <span class="gradient-text">we partner with</span></h2>
    <div class="ind-chips">
      <?php foreach ($audiences as $i => $aud) :
          $label = is_array($aud) ? ($aud['label'] ?? '') : $aud;
          if ($label === '') { continue; }
          $icon_key = is_array($aud) && !empty($aud['icon']) ? $aud['icon'] : $stretch_default_icon_rotation[$i % count($stretch_default_icon_rotation)];
          $icon = stretch_industry_icon($icon_key);
      ?>
        <span class="ind-chip pfx-icon-chip pfx-reveal pfx-delay-<?php echo (($i % 4) + 1); ?>">
          <?php if ($icon) : ?><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><?php echo $icon; // phpcs:ignore -- static SVG library above ?></svg><?php endif; ?>
          <?php echo esc_html($label); ?>
        </span>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if ($ch_intro || $challenges) : ?>
<section class="ind-section ind-challenges" aria-label="Challenges">
  <div class="pfx-container">
    <div class="ind-challenges-grid">
      <div class="pfx-reveal-left">
        <span class="pfx-overline">The Reality</span>
        <h2><?php echo esc_html($overline); ?> <span class="gradient-text">Challenges</span></h2>
        <div class="ind-intro">
          <?php foreach ($ch_intro as $p) : ?><p><?php echo esc_html($p); ?></p><?php endforeach; ?>
        </div>
      </div>
      <?php if ($challenges) : ?>
      <div class="ind-pain-panel pfx-reveal-right">
        <h3>Many <?php echo esc_html(strtolower($overline)); ?> businesses struggle with:</h3>
        <ul class="ind-pain-list">
          <?php foreach ($challenges as $c) : ?><li><?php echo esc_html($c); ?></li><?php endforeach; ?>
        </ul>
      </div>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if ($solutions) :
    $sol_palettes = [
        ['#8560A8', '#5674B9', 'rgba(133,96,168,0.1)', 'rgba(86,116,185,0.1)'],
        ['#5674B9', '#448CCB', 'rgba(86,116,185,0.1)', 'rgba(68,140,203,0.1)'],
        ['#448CCB', '#00BFF3', 'rgba(68,140,203,0.1)', 'rgba(0,191,243,0.1)'],
        ['#00BFF3', '#5674B9', 'rgba(0,191,243,0.1)', 'rgba(86,116,185,0.1)'],
        ['#8560A8', '#00BFF3', 'rgba(133,96,168,0.1)', 'rgba(0,191,243,0.1)'],
    ];
    $sol_icon_rotation = ['search', 'file-text', 'book-open', 'camera', 'target', 'chart'];
?>
<section class="ind-section ind-solutions" aria-label="Solutions">
  <div class="pfx-container">
    <span class="pfx-overline pfx-reveal">What We Do</span>
    <h2 class="pfx-reveal pfx-delay-1"><?php echo esc_html($sol_head); ?></h2>
    <div class="ind-solutions-grid">
      <?php foreach ($solutions as $i => $s) :
          $pal = $sol_palettes[$i % count($sol_palettes)];
          $icon_key = !empty($s['icon']) ? $s['icon'] : $sol_icon_rotation[$i % count($sol_icon_rotation)];
          $icon = stretch_industry_icon($icon_key);
      ?>
        <div class="ind-solution-card pfx-tilt pfx-reveal pfx-delay-<?php echo (($i % 2) + 1); ?>" style="--sol-start:<?php echo esc_attr($pal[0]); ?>;--sol-end:<?php echo esc_attr($pal[1]); ?>;--sol-bg-a:<?php echo esc_attr($pal[2]); ?>;--sol-bg-b:<?php echo esc_attr($pal[3]); ?>;">
          <div class="ind-sol-head">
            <?php if ($icon) : ?><div class="ind-sol-icon"><svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><?php echo $icon; // phpcs:ignore -- static SVG library ?></svg></div><?php endif; ?>
            <div class="ind-sol-num"><?php echo esc_html(str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT)); ?></div>
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
<section class="ind-section ind-midcta" aria-label="Get Started">
  <div class="pfx-container">
    <div class="pfx-gradient-card pfx-reveal">
      <div class="pfx-gradient-card-inner">
        <h2><?php echo esc_html($mid_cta); ?></h2>
        <a href="<?php echo esc_url($contact_url); ?>" class="pfx-btn-primary"><span><?php echo esc_html($cta_label); ?> &rarr;</span></a>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if ($popular) :
    $pop_palettes = [['#8560A8','#5674B9'],['#5674B9','#448CCB'],['#448CCB','#00BFF3'],['#00BFF3','#448CCB'],['#8560A8','#448CCB'],['#5674B9','#00BFF3'],['#448CCB','#8560A8'],['#00BFF3','#8560A8'],['#8560A8','#00BFF3']];
?>
<section class="ind-section ind-popular" aria-label="Popular Services">
  <div class="pfx-container">
    <span class="pfx-overline pfx-reveal">Services</span>
    <h2 class="pfx-reveal pfx-delay-1"><?php echo esc_html($pop_head); ?></h2>
    <div class="ind-popular-grid">
      <?php foreach ($popular as $i => $p) : $pal = $pop_palettes[$i % count($pop_palettes)]; ?>
        <div class="ind-pop-card pfx-reveal pfx-delay-<?php echo (($i % 3) + 1); ?>" style="--pop-start:<?php echo esc_attr($pal[0]); ?>;--pop-end:<?php echo esc_attr($pal[1]); ?>;">
          <h3><?php echo esc_html($p['title']); ?></h3>
          <p><?php echo esc_html($p['body']); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- TRUSTED BRANDS STRIP -->
<div style="position:relative;">
  <?php stretch_pfx_logo_marquee(true); ?>
  <div class="pfx-angle-divider"><svg viewBox="0 0 1440 60" preserveAspectRatio="none" aria-hidden="true" focusable="false"><polygon points="0,60 1440,0 1440,60" fill="#1a1f2e"/></svg></div>
</div>

<?php if ($why) :
    $why_palettes = [['#8560A8','#5674B9'],['#5674B9','#448CCB'],['#448CCB','#00BFF3'],['#8560A8','#00BFF3']];
?>
<section class="ind-section ind-why" data-grain aria-label="Why Stretch Creative">
  <div class="pfx-container">
    <span class="pfx-overline pfx-reveal">Why Stretch</span>
    <h2 class="pfx-reveal pfx-delay-1">Why Stretch <span class="gradient-text">Creative?</span></h2>
    <div class="ind-why-grid">
      <?php foreach ($why as $i => $w) : $pal = $why_palettes[$i % count($why_palettes)]; ?>
        <div class="ind-why-card pfx-tilt pfx-reveal pfx-delay-<?php echo (($i % 2) + 1); ?>" style="--why-start:<?php echo esc_attr($pal[0]); ?>;--why-end:<?php echo esc_attr($pal[1]); ?>;">
          <h3><?php echo esc_html($w['title']); ?></h3>
          <p><?php echo esc_html($w['body']); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if ($faqs) : ?>
<section class="ind-section ind-faqs" id="ind-faqs" aria-label="FAQs">
  <div class="pfx-container">
    <span class="pfx-overline pfx-reveal">FAQs</span>
    <h2 class="pfx-reveal pfx-delay-1">Frequently asked <span class="gradient-text">questions</span></h2>
    <?php foreach ($faqs as $i => $f) : $panel_id = 'ind-faq-' . ($i + 1); ?>
      <div class="pfx-accordion-item pfx-reveal">
        <button class="pfx-accordion-trigger" type="button" aria-expanded="false" aria-controls="<?php echo esc_attr($panel_id); ?>">
          <?php echo esc_html($f['q']); ?>
          <span class="pfx-accordion-icon" aria-hidden="true">+</span>
        </button>
        <div class="pfx-accordion-panel" id="<?php echo esc_attr($panel_id); ?>">
          <p><?php echo esc_html($f['a']); ?></p>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>
<?php
    $faq_ld = ['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => []];
    foreach ($faqs as $f) {
        $faq_ld['mainEntity'][] = ['@type' => 'Question', 'name' => $f['q'], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']]];
    }
    echo '<script type="application/ld+json">' . wp_json_encode($faq_ld) . '</script>';
?>
<?php endif; ?>

<!-- FINAL CTA -->
<section class="ind-section ind-finalcta" data-grain aria-label="Contact">
  <div class="pfx-container">
    <h2 class="pfx-reveal"><?php echo esc_html($final_head); ?></h2>
    <?php if ($final_text) : ?><p class="pfx-reveal pfx-delay-1"><?php echo esc_html($final_text); ?></p><?php endif; ?>
    <a href="<?php echo esc_url($contact_url); ?>" class="pfx-btn-primary pfx-reveal pfx-delay-2"><span><?php echo esc_html($cta_label); ?> &rarr;</span></a>
  </div>
</section>

<?php get_footer(); ?>
