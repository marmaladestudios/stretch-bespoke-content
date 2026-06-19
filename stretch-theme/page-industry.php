<?php
/**
 * Template Name: Industry Page
 *
 * Reusable industry page. Reads content from a WordPress option keyed by the
 * page slug: stretch_industry_{slug} (seeded by setup-industries.php).
 */
get_header();

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
?>

<style>
html, body { overflow-x: hidden; }
.admin-bar .site-nav { top: 32px; }
@media (max-width: 782px) { .admin-bar .site-nav { top: 46px; } }

.ind-page { box-sizing: border-box; }
.ind-page *, .ind-page *::before, .ind-page *::after { box-sizing: inherit; }
.v2-container { max-width: 1200px; margin: 0 auto; padding: 0 40px; width: 100%; }
.gradient-text {
  background: linear-gradient(135deg, #8560A8 0%, #5674B9 30%, #448CCB 60%, #00BFF3 100%);
  -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
}
.v2-overline {
  font-family: 'Montserrat', sans-serif; font-size: 13px; font-weight: 400;
  letter-spacing: 3px; text-transform: uppercase; color: #00BFF3;
  margin-bottom: 16px; display: block;
}
.v2-reveal { opacity: 0; transform: translateY(40px); transition: opacity .8s cubic-bezier(.16,1,.3,1), transform .8s cubic-bezier(.16,1,.3,1); }
.v2-reveal.visible { opacity: 1; transform: translateY(0); }
.v2-delay-1 { transition-delay: .1s; } .v2-delay-2 { transition-delay: .2s; }
.v2-delay-3 { transition-delay: .3s; } .v2-delay-4 { transition-delay: .4s; }
.v2-angle-divider { position: absolute; bottom: -1px; left: 0; right: 0; z-index: 2; pointer-events: none; line-height: 0; }
.v2-angle-divider svg { display: block; width: 100%; height: 60px; }
.v2-btn-primary {
  display: inline-block; font-family: 'Poppins', sans-serif; font-size: 15px; font-weight: 500;
  color: #8560A8; background: #fff; padding: 16px 40px; border-radius: 6px; text-decoration: none;
  transition: transform .3s ease, box-shadow .3s ease; box-shadow: 0 4px 20px rgba(0,0,0,.15);
}
.v2-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(0,0,0,.25); }

.ind-section { position: relative; box-sizing: border-box; }
.ind-section h2 { font-family: 'Poppins', sans-serif; font-size: clamp(28px,3.4vw,42px); font-weight: 600; line-height: 1.15; margin: 0 0 28px; letter-spacing: -.5px; }

/* Hero */
.ind-hero { position: relative; min-height: 56vh; display: flex; align-items: center;
  background: linear-gradient(170deg,#1a1f2e 0%,#252C3A 40%,#1e2333 100%); overflow: hidden; padding: 150px 0 110px; }
.ind-hero::before { content:''; position:absolute; top:-50%; right:-20%; width:80%; height:150%;
  background: radial-gradient(ellipse at center, rgba(86,116,185,.10) 0%, transparent 70%); pointer-events:none; }
.ind-hero-content { position: relative; z-index: 2; max-width: 820px; }
.ind-hero h1 { font-family:'Poppins',sans-serif; font-size: clamp(34px,4.4vw,56px); font-weight:600;
  line-height:1.1; color:#fff; margin:0 0 22px; letter-spacing:-1px; }
.ind-hero p { font-family:'Assistant',sans-serif; font-size:20px; font-weight:300; line-height:1.6; color:#cfd6e4; margin:0 0 34px; max-width:680px; }

/* Audiences */
.ind-audiences { background:#fff; padding: 84px 0; }
.ind-chips { display:flex; flex-wrap:wrap; gap:14px; margin-top:8px; }
.ind-chip { font-family:'Assistant',sans-serif; font-size:16px; font-weight:600; color:#2a3247;
  background: linear-gradient(135deg, rgba(133,96,168,.10), rgba(0,191,243,.10));
  border:1px solid rgba(86,116,185,.25); padding:12px 22px; border-radius:40px; }

/* Challenges */
.ind-challenges { background:#f9f9fb; padding: 90px 0; }
.ind-challenges .ind-intro p { font-family:'Assistant',sans-serif; font-size:18px; line-height:1.7; color:#444; margin:0 0 18px; max-width:860px; }
.ind-pain-list { list-style:none; margin:28px 0 0; padding:0; display:grid; grid-template-columns:1fr 1fr; gap:14px 36px; }
.ind-pain-list li { position:relative; padding-left:34px; font-family:'Assistant',sans-serif; font-size:16px; color:#3a4256; line-height:1.5; }
.ind-pain-list li::before { content:''; position:absolute; left:0; top:2px; width:20px; height:20px; border-radius:50%;
  background:rgba(133,96,168,.12);
  background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238560A8' stroke-width='3' stroke-linecap='round'%3E%3Cline x1='18' y1='6' x2='6' y2='18'/%3E%3Cline x1='6' y1='6' x2='18' y2='18'/%3E%3C/svg%3E");
  background-repeat:no-repeat; background-position:center; }

/* Solutions */
.ind-solutions { background:#fff; padding: 90px 0; }
.ind-solutions-grid { display:grid; grid-template-columns:1fr 1fr; gap:24px; }
.ind-solution-card { background:#fff; border:1px solid #eceef3; border-radius:14px; padding:32px 30px;
  box-shadow:0 6px 24px rgba(26,31,46,.05); transition:transform .4s ease, box-shadow .4s ease; }
.ind-solution-card:hover { transform:translateY(-6px); box-shadow:0 14px 40px rgba(26,31,46,.10); }
.ind-solution-card h3 { font-family:'Poppins',sans-serif; font-size:21px; font-weight:600; color:#1a1f2e; margin:0 0 12px; }
.ind-solution-card p { font-family:'Assistant',sans-serif; font-size:16px; line-height:1.65; color:#555; margin:0; }

/* Mid CTA */
.ind-midcta { background:linear-gradient(135deg,#8560A8,#5674B9); padding:64px 0; text-align:center; }
.ind-midcta p { font-family:'Poppins',sans-serif; font-size:clamp(22px,2.6vw,30px); font-weight:600; color:#fff; margin:0 0 26px; }

/* Popular services */
.ind-popular { background:#f9f9fb; padding: 90px 0; }
.ind-popular-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:22px; margin-top:8px; }
.ind-pop-card { background:#fff; border-radius:12px; padding:26px 24px; border-top:3px solid #448CCB; box-shadow:0 4px 18px rgba(26,31,46,.05); }
.ind-pop-card h3 { font-family:'Poppins',sans-serif; font-size:17px; font-weight:600; color:#1a1f2e; margin:0 0 10px; }
.ind-pop-card p { font-family:'Assistant',sans-serif; font-size:15px; line-height:1.55; color:#5a6275; margin:0; }

/* Why */
.ind-why { background:linear-gradient(170deg,#1a1f2e,#252C3A); padding: 90px 0; }
.ind-why h2 { color:#fff; }
.ind-why-grid { display:grid; grid-template-columns:1fr 1fr; gap:24px; }
.ind-why-card { background:rgba(255,255,255,.04); border:1px solid rgba(255,255,255,.08); border-radius:14px; padding:30px 28px; }
.ind-why-card h3 { font-family:'Poppins',sans-serif; font-size:19px; font-weight:600; color:#fff; margin:0 0 10px; }
.ind-why-card p { font-family:'Assistant',sans-serif; font-size:16px; line-height:1.6; color:#b9c2d4; margin:0; }

/* FAQs */
.ind-faqs { background:#fff; padding: 90px 0; }
.ind-faq { border-bottom:1px solid #eceef3; }
.ind-faq summary { list-style:none; cursor:pointer; font-family:'Poppins',sans-serif; font-size:18px; font-weight:600; color:#1a1f2e; padding:22px 40px 22px 0; position:relative; }
.ind-faq summary::-webkit-details-marker { display:none; }
.ind-faq summary::after { content:'+'; position:absolute; right:6px; top:18px; font-size:26px; font-weight:300; color:#5674B9; transition:transform .3s ease; }
.ind-faq[open] summary::after { transform:rotate(45deg); }
.ind-faq p { font-family:'Assistant',sans-serif; font-size:16px; line-height:1.7; color:#555; margin:0 0 22px; max-width:880px; }

/* Final CTA */
.ind-finalcta { background:linear-gradient(135deg,#5674B9,#00BFF3); padding: 96px 0; text-align:center; }
.ind-finalcta h2 { color:#fff; margin-bottom:18px; }
.ind-finalcta p { font-family:'Assistant',sans-serif; font-size:19px; line-height:1.6; color:#eaf6fe; max-width:720px; margin:0 auto 32px; }

@media (max-width: 960px) {
  .ind-solutions-grid { grid-template-columns:1fr; }
  .ind-popular-grid { grid-template-columns:repeat(2,1fr); }
  .ind-why-grid { grid-template-columns:1fr; }
  .ind-pain-list { grid-template-columns:1fr; }
}
@media (max-width: 600px) {
  .v2-container { padding:0 24px; }
  .ind-popular-grid { grid-template-columns:1fr; }
}
</style>

<div class="ind-page">

<!-- HERO -->
<section class="ind-section ind-hero" aria-label="Intro">
  <div class="v2-container">
    <div class="ind-hero-content">
      <span class="v2-overline v2-reveal v2-delay-1"><?php echo esc_html($overline); ?></span>
      <h1 class="v2-reveal v2-delay-2"><?php echo esc_html($h1); ?></h1>
      <?php if ($hero_text): ?><p class="v2-reveal v2-delay-3"><?php echo esc_html($hero_text); ?></p><?php endif; ?>
      <a href="<?php echo esc_url($contact_url); ?>" class="v2-btn-primary v2-reveal v2-delay-4"><?php echo esc_html($cta_label); ?> &rarr;</a>
    </div>
  </div>
  <div class="v2-angle-divider"><svg viewBox="0 0 1440 60" preserveAspectRatio="none"><polygon points="0,60 1440,0 1440,60" fill="#ffffff"/></svg></div>
</section>

<?php if ($audiences): ?>
<!-- WHO WE WORK WITH -->
<section class="ind-section ind-audiences" aria-label="Who We Work With">
  <div class="v2-container">
    <span class="v2-overline v2-reveal">Who We Work With</span>
    <h2 class="v2-reveal v2-delay-1">Brands and teams <span class="gradient-text">we partner with</span></h2>
    <div class="ind-chips">
      <?php foreach ($audiences as $i => $aud): ?>
        <span class="ind-chip v2-reveal v2-delay-<?php echo (($i % 4) + 1); ?>"><?php echo esc_html($aud); ?></span>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if ($ch_intro || $challenges): ?>
<!-- CHALLENGES -->
<section class="ind-section ind-challenges" aria-label="Challenges">
  <div class="v2-container">
    <h2 class="v2-reveal"><?php echo esc_html($overline); ?> <span class="gradient-text">Challenges</span></h2>
    <div class="ind-intro v2-reveal v2-delay-1">
      <?php foreach ($ch_intro as $p): ?><p><?php echo esc_html($p); ?></p><?php endforeach; ?>
    </div>
    <?php if ($challenges): ?>
    <ul class="ind-pain-list v2-reveal v2-delay-2">
      <?php foreach ($challenges as $c): ?><li><?php echo esc_html($c); ?></li><?php endforeach; ?>
    </ul>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>

<?php if ($solutions): ?>
<!-- SOLUTIONS -->
<section class="ind-section ind-solutions" aria-label="Solutions">
  <div class="v2-container">
    <span class="v2-overline v2-reveal">What We Do</span>
    <h2 class="v2-reveal v2-delay-1"><?php echo esc_html($sol_head); ?></h2>
    <div class="ind-solutions-grid">
      <?php foreach ($solutions as $i => $s): ?>
        <div class="ind-solution-card v2-reveal v2-delay-<?php echo (($i % 3) + 1); ?>">
          <h3><?php echo esc_html($s['title']); ?></h3>
          <p><?php echo esc_html($s['body']); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if ($mid_cta): ?>
<!-- MID CTA -->
<section class="ind-section ind-midcta" aria-label="Get Started">
  <div class="v2-container">
    <p class="v2-reveal"><?php echo esc_html($mid_cta); ?></p>
    <a href="<?php echo esc_url($contact_url); ?>" class="v2-btn-primary v2-reveal v2-delay-1"><?php echo esc_html($cta_label); ?> &rarr;</a>
  </div>
</section>
<?php endif; ?>

<?php if ($popular): ?>
<!-- MOST POPULAR SERVICES -->
<section class="ind-section ind-popular" aria-label="Popular Services">
  <div class="v2-container">
    <span class="v2-overline v2-reveal">Services</span>
    <h2 class="v2-reveal v2-delay-1"><?php echo esc_html($pop_head); ?></h2>
    <div class="ind-popular-grid">
      <?php foreach ($popular as $i => $p): ?>
        <div class="ind-pop-card v2-reveal v2-delay-<?php echo (($i % 3) + 1); ?>">
          <h3><?php echo esc_html($p['title']); ?></h3>
          <p><?php echo esc_html($p['body']); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if ($why): ?>
<!-- WHY STRETCH -->
<section class="ind-section ind-why" aria-label="Why Stretch Creative">
  <div class="v2-container">
    <span class="v2-overline v2-reveal">Why Stretch</span>
    <h2 class="v2-reveal v2-delay-1">Why Stretch <span class="gradient-text">Creative?</span></h2>
    <div class="ind-why-grid">
      <?php foreach ($why as $i => $w): ?>
        <div class="ind-why-card v2-reveal v2-delay-<?php echo (($i % 2) + 1); ?>">
          <h3><?php echo esc_html($w['title']); ?></h3>
          <p><?php echo esc_html($w['body']); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if ($faqs): ?>
<!-- FAQS -->
<section class="ind-section ind-faqs" aria-label="FAQs">
  <div class="v2-container">
    <span class="v2-overline v2-reveal">FAQs</span>
    <h2 class="v2-reveal v2-delay-1">Frequently asked <span class="gradient-text">questions</span></h2>
    <?php foreach ($faqs as $f): ?>
      <details class="ind-faq v2-reveal">
        <summary><?php echo esc_html($f['q']); ?></summary>
        <p><?php echo esc_html($f['a']); ?></p>
      </details>
    <?php endforeach; ?>
  </div>
</section>
<?php
  // FAQPage structured data
  $faq_ld = ['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => []];
  foreach ($faqs as $f) {
    $faq_ld['mainEntity'][] = [
      '@type' => 'Question',
      'name'  => $f['q'],
      'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
    ];
  }
  echo '<script type="application/ld+json">' . wp_json_encode($faq_ld) . '</script>';
?>
<?php endif; ?>

<!-- FINAL CTA -->
<section class="ind-section ind-finalcta" aria-label="Contact">
  <div class="v2-container">
    <h2 class="v2-reveal"><?php echo esc_html($final_head); ?></h2>
    <?php if ($final_text): ?><p class="v2-reveal v2-delay-1"><?php echo esc_html($final_text); ?></p><?php endif; ?>
    <a href="<?php echo esc_url($contact_url); ?>" class="v2-btn-primary v2-reveal v2-delay-2"><?php echo esc_html($cta_label); ?> &rarr;</a>
  </div>
</section>

</div><!-- .ind-page -->

<script>
(function(){
  var obs = new IntersectionObserver(function(entries){
    entries.forEach(function(e){ if(e.isIntersecting){ e.target.classList.add('visible'); obs.unobserve(e.target); } });
  }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
  document.querySelectorAll('.v2-reveal').forEach(function(el){ obs.observe(el); });
})();
</script>

<?php get_footer(); ?>
