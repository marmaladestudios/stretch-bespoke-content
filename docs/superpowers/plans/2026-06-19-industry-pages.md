# Industry Pages Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Build a reusable industry-page template and ship two industry pages (Ecommerce, Agencies & Strategic Partners) at `/industries/ecommerce/` and `/industries/agencies/`.

**Architecture:** One shared `page-industry.php` template renders per-page content read from a slug-keyed option `stretch_industry_{slug}` — the same pattern as `page-service.php`. An idempotent `setup-industries.php` creates the `/industries/` parent + child pages, assigns the template, and seeds both content arrays; it runs on every deploy via the entrypoint. Homepage and footer links are pointed at the new URLs, and bare `/industries/` 301-redirects to home until a landing page exists.

**Tech Stack:** WordPress classic PHP theme, inline HTML/CSS/JS per template, WP-CLI idempotent setup scripts, Docker/Render deploy.

**Spec:** `docs/superpowers/specs/2026-06-19-industry-pages-design.md` (canonical source for all page copy)

## Verification model (no unit-test framework)

Same as the home-page work: `php -l` lint + `grep` content checks + (where possible) HTTP checks. Docker may be unavailable locally; live render verification happens on Render after deploy. Commit after each task.

---

## Data contract (used by BOTH the template and the setup script — field names MUST match exactly)

```
stretch_industry_{slug} = [
  'overline'          => string,
  'h1'                => string,
  'hero_text'         => string,
  'cta_label'         => string,                 // default 'Schedule a Discovery Call'
  'audiences'         => [ string, ... ],
  'challenges_intro'  => [ string, ... ],        // paragraphs
  'challenges'        => [ string, ... ],        // bullet list
  'solutions_heading' => string,
  'solutions'         => [ ['title'=>string, 'body'=>string], ... ],
  'mid_cta_text'      => string,
  'popular_heading'   => string,
  'popular'           => [ ['title'=>string, 'body'=>string], ... ],
  'why'               => [ ['title'=>string, 'body'=>string], ... ],
  'faqs'              => [ ['q'=>string, 'a'=>string], ... ],
  'final_heading'     => string,
  'final_text'        => string,
]
```

All CTA buttons link to `/contact-stretch-creative/`.

---

## File Structure

- **Create:** `stretch-theme/page-industry.php` — shared template (`Template Name: Industry Page`); self-contained inline `<style>`/`<script>`; renders the data contract; emits FAQPage JSON-LD.
- **Create:** `setup-industries.php` (repo root) — idempotent: creates `/industries/` parent + `ecommerce`/`agencies` children, assigns template, writes both options.
- **Modify:** `docker-entrypoint-custom.sh` — add `setup-industries.php` to the idempotent eval-file run list (and copy it into the container like the other setup scripts).
- **Modify:** `stretch-theme/setup-wizard.php` — fresh-install: create the `/industries/` parent + two children with `page-industry.php`; repoint the two footer items to the new URLs.
- **Modify:** `stretch-theme/functions.php` — `template_redirect`: bare `/industries/` page → `home_url('/')`.
- **Modify:** `stretch-theme/page-home.php` — point the Ecommerce and Agencies industry cards (currently `href="#"`) to the new URLs.

---

## Task 1: Create the `page-industry.php` template

**Files:** Create `stretch-theme/page-industry.php`

- [ ] **Step 1: Write the template file**

Create `stretch-theme/page-industry.php` with EXACTLY this content:

```php
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
```

- [ ] **Step 2: Lint** — Run `php -l stretch-theme/page-industry.php` → Expected: `No syntax errors detected`

- [ ] **Step 3: Verify structure** —
  Run `grep -c "Template Name: Industry Page" stretch-theme/page-industry.php` → `1`
  Run `grep -c "get_option('stretch_industry_'" stretch-theme/page-industry.php` → `1`
  Run `grep -c "application/ld+json" stretch-theme/page-industry.php` → `1`

- [ ] **Step 4: Commit**
```bash
git add stretch-theme/page-industry.php
git commit -m "feat(industry): reusable industry page template (data-driven, FAQ schema)"
```

---

## Task 2: Create `setup-industries.php` (pages + content)

**Files:** Create `setup-industries.php` (repo root)

- [ ] **Step 1: Create the script skeleton + page wiring + option writes**

Create `setup-industries.php` with this structure. The `$industries['ecommerce']` and `$industries['agencies']` arrays must be populated by transcribing — VERBATIM — the "Content — Ecommerce" and "Content — Agencies & Strategic Partners" sections of `docs/superpowers/specs/2026-06-19-industry-pages-design.md`, mapped onto the data contract at the top of this plan. Use the exact field names from the data contract. For `solutions`/`popular`/`why`, each item is `['title' => '...', 'body' => '...']` (the spec writes them as "Title — Body"; split on the em-dash). For `faqs`, each item is `['q' => '...', 'a' => '...']`. Preserve apostrophes/dashes; in PHP single-quoted strings escape `'` as `\'`.

```php
<?php
/**
 * Idempotent setup for Industry pages. Creates the /industries/ parent and child
 * pages, assigns the page-industry.php template, and seeds slug-keyed content.
 *
 * Run: docker compose exec wordpress wp eval-file /var/www/html/setup-industries.php --allow-root
 */
if (!defined('ABSPATH')) {
    WP_CLI::error('This script must be run via wp eval-file.');
}

// ── Parent: /industries/ ──────────────────────────────────────────────
$parent = get_page_by_path('industries');
if (!$parent) {
    $parent_id = wp_insert_post([
        'post_title'  => 'Industries',
        'post_name'   => 'industries',
        'post_type'   => 'page',
        'post_status' => 'publish',
    ]);
    WP_CLI::log("Created /industries/ parent (ID {$parent_id})");
} else {
    $parent_id = $parent->ID;
    WP_CLI::log("/industries/ parent exists (ID {$parent_id})");
}

// ── Content ───────────────────────────────────────────────────────────
$industries = [];

$industries['ecommerce'] = [
    'title'    => 'Ecommerce',  // WP page title
    'overline' => 'Ecommerce',
    'h1'       => 'Ecommerce SEO, Content, and Creative Services',
    // ... transcribe the rest of the Ecommerce content from the spec ...
];

$industries['agencies'] = [
    'title'    => 'Agencies & Strategic Partners',
    'overline' => 'Agencies & Strategic Partners',
    'h1'       => 'White-Labeled Content & Creative Services for Agencies and Strategic Partners',
    // ... transcribe the rest of the Agencies content from the spec ...
];

// ── Create/ensure child pages + assign template + seed options ─────────
foreach ($industries as $slug => $data) {
    $title = !empty($data['title']) ? $data['title'] : ucfirst($slug);

    $page = get_page_by_path('industries/' . $slug);
    if (!$page) {
        $page_id = wp_insert_post([
            'post_title'  => $title,
            'post_name'   => $slug,
            'post_type'   => 'page',
            'post_status' => 'publish',
            'post_parent' => $parent_id,
        ]);
        WP_CLI::log("Created page: industries/{$slug} (ID {$page_id})");
    } else {
        $page_id = $page->ID;
        // Ensure correct parent
        if ((int) $page->post_parent !== (int) $parent_id) {
            wp_update_post(['ID' => $page_id, 'post_parent' => $parent_id]);
        }
    }
    update_post_meta($page_id, '_wp_page_template', 'page-industry.php');

    // Strip the WP-title-only field before saving as the render option
    $option_data = $data;
    unset($option_data['title']);
    update_option('stretch_industry_' . $slug, $option_data, false);
    WP_CLI::log("Saved option: stretch_industry_{$slug}");
}

WP_CLI::success('Industry pages created and content seeded.');
```

- [ ] **Step 2: Transcribe content from the spec** — Fill the two `// ... transcribe ...` placeholders with the complete content from the spec (all fields in the data contract: `hero_text`, `cta_label` (use `'Schedule a Discovery Call'`), `audiences`, `challenges_intro`, `challenges`, `solutions_heading`, `solutions`, `mid_cta_text`, `popular_heading`, `popular`, `why`, `faqs`, `final_heading`, `final_text`). Verbatim from `docs/superpowers/specs/2026-06-19-industry-pages-design.md`.

- [ ] **Step 3: Lint** — Run `php -l setup-industries.php` → `No syntax errors detected`

- [ ] **Step 4: Verify content completeness** —
  Run `grep -c "stretch_industry_" setup-industries.php` → `1` (the single update_option line)
  Run `php -r '$s=file_get_contents("setup-industries.php"); echo (substr_count($s, "=>") > 80) ? "OK\n" : "TOO FEW KEYS\n";'` → `OK` (both fully-populated arrays have many keys; this guards against an un-transcribed skeleton)
  Run `grep -c "Schedule a Discovery Call" setup-industries.php` → `2`

- [ ] **Step 5: Commit**
```bash
git add setup-industries.php
git commit -m "feat(industry): seed Ecommerce + Agencies pages and content (idempotent)"
```

---

## Task 3: Wire deploy entrypoint + fresh-install wizard

**Files:** Modify `docker-entrypoint-custom.sh`, `stretch-theme/setup-wizard.php`

- [ ] **Step 1: Copy + run setup-industries.php in the entrypoint**

In `docker-entrypoint-custom.sh`, find the block of `cp -f /opt/setup-*.php ...` lines (around lines 92-98) and add, after the `cp -f /opt/content-fixes.php ...` line:
```bash
cp -f /opt/setup-industries.php /var/www/html/setup-industries.php 2>/dev/null || true
```
Then find the idempotent run block (the `wp ... eval-file ...` lines around 115-118) and add, after the `content-fixes.php` eval-file line:
```bash
    wp --allow-root --path=/var/www/html eval-file /var/www/html/setup-industries.php 2>&1 || echo "  ! setup-industries failed (continuing)"
```

(Note: `setup-industries.php` lives at the repo root and is copied into the image the same way the other `setup-*.php` are. Confirm the Dockerfile copies repo-root `setup-*.php` into `/opt/`; if it copies them individually, add `setup-industries.php` to that COPY list too — check `Dockerfile` and match the existing pattern.)

- [ ] **Step 2: Add the Dockerfile COPY line**

The Dockerfile copies setup scripts with individual `COPY` lines (verified). In `Dockerfile`, immediately after the line:
```dockerfile
COPY content-fixes.php /opt/content-fixes.php
```
add:
```dockerfile
COPY setup-industries.php /opt/setup-industries.php
```

- [ ] **Step 3: Fresh-install pages in setup-wizard.php**

In `stretch-theme/setup-wizard.php`, after the "Services parent page" / "Bespoke Content Experience" block (after line ~87, before the "Our Work (portfolio) page" block at ~89), add an Industries parent + children block:
```php
    // Industries parent + child pages (use shared page-industry.php template)
    $industries_parent = get_page_by_path('industries');
    $industries_parent_id = $industries_parent ? $industries_parent->ID : wp_insert_post([
        'post_title'  => 'Industries',
        'post_name'   => 'industries',
        'post_type'   => 'page',
        'post_status' => 'publish',
    ]);
    echo "✓ Industries parent page<br>";

    foreach ([['Ecommerce','ecommerce'], ['Agencies & Strategic Partners','agencies']] as $ind) {
        $child = get_page_by_path('industries/' . $ind[1]);
        $child_id = $child ? $child->ID : wp_insert_post([
            'post_title'  => $ind[0],
            'post_name'   => $ind[1],
            'post_type'   => 'page',
            'post_status' => 'publish',
            'post_parent' => $industries_parent_id,
        ]);
        update_post_meta($child_id, '_wp_page_template', 'page-industry.php');
        echo "✓ Industry: {$ind[0]}<br>";
    }
```

- [ ] **Step 4: Repoint footer menu items**

In `stretch-theme/setup-wizard.php`, replace line 308:
```php
    wp_update_nav_menu_item($menu_locations['footer-1'], 0, ['menu-item-title' => 'Ecommerce', 'menu-item-url' => home_url('/stretch-creative-solutions/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom']);
```
with:
```php
    wp_update_nav_menu_item($menu_locations['footer-1'], 0, ['menu-item-title' => 'Ecommerce', 'menu-item-url' => home_url('/industries/ecommerce/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom']);
```
and replace line 309:
```php
    wp_update_nav_menu_item($menu_locations['footer-1'], 0, ['menu-item-title' => 'Agencies', 'menu-item-url' => home_url('/stretch-creative-solutions/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom']);
```
with:
```php
    wp_update_nav_menu_item($menu_locations['footer-1'], 0, ['menu-item-title' => 'Agencies', 'menu-item-url' => home_url('/industries/agencies/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom']);
```
(Leave the "Publishers" item at line 310 unchanged.)

- [ ] **Step 5: Lint + verify**
  Run `php -l stretch-theme/setup-wizard.php` → `No syntax errors detected`
  Run `bash -n docker-entrypoint-custom.sh` → no output (valid)
  Run `grep -c "setup-industries.php" docker-entrypoint-custom.sh` → `2` (copy line + eval-file line)
  Run `grep -c "industries/ecommerce/\|industries/agencies/" stretch-theme/setup-wizard.php` → `2`

- [ ] **Step 6: Commit**
```bash
git add docker-entrypoint-custom.sh stretch-theme/setup-wizard.php Dockerfile
git commit -m "feat(industry): wire setup-industries into deploy + fresh-install wizard + footer"
```

---

## Task 4: Redirect bare `/industries/` to home

**Files:** Modify `stretch-theme/functions.php`

- [ ] **Step 1: Extend the redirect hook**

In `stretch-theme/functions.php`, find the existing function `stretch_redirect_retired_solutions` (added for the home-page work, around line 88). Immediately AFTER its closing `}`, add a second redirect function + hook:
```php
/**
 * The /industries/ landing page is not built yet. Redirect the bare parent URL
 * to the homepage; the child industry pages (e.g. /industries/ecommerce/) render
 * normally.
 */
add_action('template_redirect', 'stretch_redirect_industries_parent');
function stretch_redirect_industries_parent() {
    if (is_page('industries')) {
        wp_redirect(home_url('/'), 302);
        exit;
    }
}
```
(Use 302, not 301 — this is a temporary redirect until the landing page exists. `is_page('industries')` matches only the parent by slug, not the nested children.)

- [ ] **Step 2: Lint + verify**
  Run `php -l stretch-theme/functions.php` → `No syntax errors detected`
  Run `grep -c "stretch_redirect_industries_parent" stretch-theme/functions.php` → `2`

- [ ] **Step 3: Commit**
```bash
git add stretch-theme/functions.php
git commit -m "feat(industry): redirect bare /industries/ to home (302, landing page deferred)"
```

---

## Task 5: Point homepage industry cards at the new URLs

**Files:** Modify `stretch-theme/page-home.php`

- [ ] **Step 1: Update the Ecommerce card link**

In `stretch-theme/page-home.php`, the four "Who We Serve" industry cards each currently have `<a href="#" class="sol-card-link">`. Update only the Ecommerce and Agencies cards.

For the Ecommerce card: locate the `.sol-card` whose `<div class="sol-card-tag">Ecommerce</div>` is present, and within THAT card change its `<a href="#" class="sol-card-link">` to `<a href="/industries/ecommerce/" class="sol-card-link">`. (The Learn More anchor is the last element in that card's `.sol-card-content`.)

- [ ] **Step 2: Update the Agencies card link**

For the card whose tag is `<div class="sol-card-tag">Agencies &amp; Strategic Partners</div>`, change its `<a href="#" class="sol-card-link">` to `<a href="/industries/agencies/" class="sol-card-link">`.

Leave the Local Service Providers and SaaS cards with `href="#"`.

- [ ] **Step 3: Lint + verify**
  Run `php -l stretch-theme/page-home.php` → `No syntax errors detected`
  Run `grep -c 'href="/industries/ecommerce/" class="sol-card-link"' stretch-theme/page-home.php` → `1`
  Run `grep -c 'href="/industries/agencies/" class="sol-card-link"' stretch-theme/page-home.php` → `1`
  Run `grep -c 'href="#" class="sol-card-link"' stretch-theme/page-home.php` → `2` (Local Service Providers + SaaS remain)

- [ ] **Step 4: Commit**
```bash
git add stretch-theme/page-home.php
git commit -m "feat(industry): link homepage Ecommerce & Agencies cards to industry pages"
```

---

## Task 6: End-to-end verification

**Files:** none (verification only)

- [ ] **Step 1: Lint everything**
```bash
php -l stretch-theme/page-industry.php && php -l setup-industries.php && \
php -l stretch-theme/setup-wizard.php && php -l stretch-theme/functions.php && \
php -l stretch-theme/page-home.php && bash -n docker-entrypoint-custom.sh && echo "ALL LINT OK"
```
Expected: `ALL LINT OK`

- [ ] **Step 2: Validate the seeded content is well-formed PHP data**

Run a standalone PHP harness that defines `ABSPATH` and stubs the WP functions, includes the array section of `setup-industries.php`, and asserts both industries have the required keys. Concretely:
```bash
php -r '
define("ABSPATH", "/tmp/");
function get_page_by_path($p){ return null; }
function wp_insert_post($a){ return 1; }
function wp_update_post($a){ return 1; }
function update_post_meta($a,$b,$c){ return true; }
function update_option($a,$b,$c=true){ $GLOBALS["opts"][$a]=$b; return true; }
class WP_CLI { static function log($m){} static function success($m){} static function error($m){ throw new Exception($m); } }
include "setup-industries.php";
$req = ["overline","h1","hero_text","cta_label","audiences","challenges_intro","challenges","solutions_heading","solutions","mid_cta_text","popular_heading","popular","why","faqs","final_heading","final_text"];
foreach (["ecommerce","agencies"] as $slug) {
  $o = $GLOBALS["opts"]["stretch_industry_$slug"] ?? null;
  if (!$o) { echo "MISSING OPTION: $slug\n"; exit(1); }
  foreach ($req as $k) { if (!array_key_exists($k,$o) || empty($o[$k])) { echo "MISSING KEY $slug.$k\n"; exit(1); } }
  if (count($o["faqs"]) < 6) { echo "FEW FAQS $slug\n"; exit(1); }
  if (count($o["solutions"]) < 5) { echo "FEW SOLUTIONS $slug\n"; exit(1); }
}
echo "CONTENT OK: ecommerce(".count($GLOBALS["opts"]["stretch_industry_ecommerce"]["popular"])." popular), agencies(".count($GLOBALS["opts"]["stretch_industry_agencies"]["popular"])." popular)\n";
'
```
Expected: `CONTENT OK: ecommerce(9 popular), agencies(9 popular)` (Ecommerce has 9 popular-services cards, Agencies has 9). If any `MISSING`/`FEW` line prints, fix the transcription in Task 2 and re-run.

- [ ] **Step 3: Live verification (Render, post-deploy — or local Docker if available)**

After merge/deploy, confirm on the running site:
- `/industries/ecommerce/` returns 200 and renders the hero H1 "Ecommerce SEO, Content, and Creative Services".
- `/industries/agencies/` returns 200 and renders its hero H1.
- Bare `/industries/` 302-redirects to `/`.
- Homepage Ecommerce/Agencies "Learn More" buttons navigate to the new pages.
- Deploy log shows `Saved option: stretch_industry_ecommerce` and `... _agencies` and `Industry pages created and content seeded.`
- FAQ accordions expand/collapse; view-source shows one `application/ld+json` FAQPage block per page.

Document the result. If Docker is available locally, bring up the stack and run `wp eval-file /var/www/html/setup-industries.php --allow-root`, then curl the URLs; otherwise note that this step is pending the Render deploy.

---

## Self-Review (completed by plan author)

- **Spec coverage:** template w/ all 9 sections + FAQ schema (Task 1); both content sets + page creation (Task 2); `/industries/` parent, nesting, deploy + fresh-install wiring, footer links (Tasks 2–3); bare-`/industries/` redirect (Task 4); homepage card links (Task 5); verification incl. content-completeness harness (Task 6). All spec sections mapped. ✓
- **Placeholder scan:** Task 2's `// ... transcribe ...` is a deliberate, bounded transcription instruction pointing at the committed spec (the canonical content source), guarded by an automated completeness check in Task 2 Step 4 and Task 6 Step 2 — not an open-ended "implement later". Template/wiring code is complete and literal. ✓
- **Type/field consistency:** the data-contract field names (`overline`, `h1`, `hero_text`, `cta_label`, `audiences`, `challenges_intro`, `challenges`, `solutions_heading`, `solutions[title,body]`, `mid_cta_text`, `popular_heading`, `popular[title,body]`, `why[title,body]`, `faqs[q,a]`, `final_heading`, `final_text`) are identical between the template reads (Task 1), the seed arrays (Task 2), and the verification harness (Task 6). Slugs (`ecommerce`, `agencies`), URLs (`/industries/ecommerce/`, `/industries/agencies/`), template name (`page-industry.php`), and option prefix (`stretch_industry_`) are consistent across all tasks. ✓
- **Known soft spots:** (1) Dockerfile copy mechanism for setup scripts is verified in Task 3 Step 2 rather than assumed. (2) Live render is deferred to Render unless local Docker is up.
