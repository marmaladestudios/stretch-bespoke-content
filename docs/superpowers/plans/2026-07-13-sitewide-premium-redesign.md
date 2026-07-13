# Site-Wide Premium Redesign Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Apply the approved premium design system to the home and industry pages, build the two missing industry pages and the combined Visual Content & Design page, roll out the copy-doc content to service/About/Team pages, and replace the main nav + footer with the new site-map structure.

**Architecture:** A shared effects partial (`template-parts/premium-fx.php`) carries the premium kit once (grid hero, reveals with throttled-tab fallback, counters, marquee, tilt, magnetic buttons, gradient-border cards, accordion, reduced-motion + noscript resets). Templates include it and use its `pfx-` vocabulary. All content lands through idempotent `setup-*.php` seed scripts wired into the deploy seed gate. Nav/footer are WP menus rebuilt by a seed script so the client can edit them.

**Tech Stack:** WordPress custom theme (PHP templates, no build step), vanilla JS/CSS, WP-CLI seeds, Docker local at localhost:8888, Render production.

**Spec:** `docs/superpowers/specs/2026-07-10-sitewide-premium-redesign-design.md`
**Copy source (in-repo):** `design-reference/copy-doc.md` (line refs below are to this file)
**Audit tickets absorbed:** AUD-005/010 (footer), AUD-013 (shared-kit direction), AUD-026 (noscript), AUD-027 (reduced-motion), AUD-030 (dead templates), AUD-036 (dead links), AUD-037 (icons→Lucide), AUD-039 (SEO stat copy)

## Phase-order deviation from spec (intentional)

The spec listed nav/footer as Phase ③ before the service-page work. This plan builds **all link-target pages first** (industry pages, Visual Content & Design) and rebuilds nav/footer **after** (Phase 4 here), so no menu item ever points at a 404. Confirmed against spec §7's requirement that Graphic Design / Photography & Videography menu items deep-link into the combined Visual page.

## Global Constraints

- Brand palette exactly: `#8560A8` purple, `#5674B9` blue, `#448CCB` mid, `#00BFF3` cyan, darks `#1a1f2e`/`#252C3A`/`#1e2333`, light `#f9f9fb`. Fonts: Poppins (headings), Assistant (body), Montserrat (overlines/nav).
- Copy is VERBATIM from `design-reference/copy-doc.md` — never paraphrase; apply the two known drift fixes ("collect insights", "doesn't always pay the bills").
- Established taste rules (never violate): angled dividers not waves; no gradient overlays on photos; no letter-by-letter text animation; no giant watermark text; no horizontal-scroll sections; gradient-border animation reserved for CTA cards (19s rotation); grid hero mask keeps text area clear.
- Performance rules from the audit: NO `backdrop-filter` on cards or dropdown panels (nav bar only); NO `mix-blend-mode` cursor; grain overlays are STATIC (no animation); `prefers-reduced-motion` neutralizes every animation; `<noscript>` reveals all content; counters render final numbers server-side and animate from 0 in JS.
- Every seed script: first line guard `if (!defined('WP_CLI') || !WP_CLI) { exit; }` (or the `STRETCH_WIZARD` variant only where the wizard includes it), idempotent (second run = no-op), `WP_CLI::error` (non-zero exit) when incomplete so the deploy gate retries.
- Icons: Lucide (MIT), 24px viewBox, stroke 1.5, `fill="none" stroke-linecap="round" stroke-linejoin="round"`. Brand glyphs (X/LinkedIn/Facebook) stay official filled paths.
- All template output escaped: `esc_html`/`esc_attr`/`esc_url`/`wp_kses_post`. PHP-into-JS via `wp_json_encode` only.
- Verification pattern per task: `docker compose exec -T wordpress php -l <file>` clean; curl assertions with expected values; headless Chrome screenshot > 30KB for visual tasks (`"/Applications/Google Chrome.app/Contents/MacOS/Google Chrome" --headless --disable-gpu --hide-scrollbars --window-size=1440,900 --screenshot=<out> <url>`); zero regressions on the standing battery (Task 16 lists it).
- Commit after every task with the message given in the task.
- Local WP-CLI: `docker compose exec -T wordpress wp <cmd> --allow-root` from `/Users/colevineyard/stretch`. Copy scripts in with `docker compose cp <file> wordpress:/var/www/html/<file>` before `wp eval-file`.

---

### Task 1: Shared premium kit — `template-parts/premium-fx.php`

**Files:**
- Create: `stretch-theme/template-parts/premium-fx.php`
- Test: curl + php -l assertions (steps below)

**Interfaces:**
- Produces (used by every later template task):
  - Include with `get_template_part('template-parts/premium-fx')` once per template, immediately after `get_header()`.
  - CSS classes: `.pfx-container`, `.gradient-text`, `.pfx-overline`, `.pfx-reveal|-left|-right` + `.pfx-delay-1..6`, `.pfx-angle-divider`, `.pfx-hero` + `.pfx-hero-mesh` + `.pfx-hero-grid` (+ modifier `.pfx-hero--left` shifts the radial mask to 32% for left-aligned heroes), `.pfx-btn-primary` (span-wrapped label), `.pfx-btn-outline`, `.pfx-accent-bar`, `.pfx-gradient-card > .pfx-gradient-card-inner(.dark)`, `.pfx-stats-bar` + `.pfx-stat-number > .pfx-count[data-target]` + `.pfx-suffix` + `.pfx-stat-label`, `.pfx-logos(.pfx-logos--compact)` + `.pfx-marquee > .pfx-marquee-track`, `.pfx-icon-chip`, `.pfx-tilt`, `.pfx-accordion-item > .pfx-accordion-trigger[aria-controls] + .pfx-accordion-panel`, section attribute `data-grain` (static grain overlay injected by JS).
  - PHP helper defined here: `stretch_pfx_logo_marquee( $compact = false )` — echoes the full "Trusted by Leading Brands" section from the `stretch_client_logos` option (returns silently if the option is empty).
  - JS behaviors bound automatically on DOMContentLoaded: scroll progress bar, custom cursor (desktop pointer only), reveal observer **with the timer fallback for hidden/zero-height viewports**, grid-hero generation + mouse parallax, counters (server-rendered final values; animates from 0 when visible; instant-set fallback), tilt, magnetic buttons, single-open accordion, sticky-nav `scrolled` class already handled by theme.js (do not duplicate).
- Consumes: `stretch_client_logos` WP option (name ⇒ attachment ID map, already seeded).

- [ ] **Step 1: Create the file with this exact content**

The file is one PHP partial that emits a `<style>` block, then the logo-marquee helper, then a `<script>` block. Port the CSS verbatim from the approved mockup kit with these two WordPress adaptations already applied below: the marquee is server-rendered (no JS logo array) and a `<noscript>` reset ships for AUD-026.

```php
<?php
/**
 * Premium effects kit — shared design-system CSS/JS (redesign Phase 1).
 * Include once per template, right after get_header():
 *   get_template_part('template-parts/premium-fx');
 * Vocabulary: pfx- prefixed classes. See docs/superpowers/plans/2026-07-13-sitewide-premium-redesign.md Task 1.
 */

if (!defined('ABSPATH')) { exit; }

/**
 * Trusted-brands marquee from the stretch_client_logos option.
 * $compact renders the smaller inner-page variant.
 */
function stretch_pfx_logo_marquee($compact = false) {
    $logos = get_option('stretch_client_logos', []);
    if (empty($logos) || !is_array($logos)) { return; }
    $items = '';
    foreach ($logos as $name => $id) {
        $url = wp_get_attachment_url($id);
        if (!$url) { continue; }
        $items .= '<div class="pfx-logo-item"><img src="' . esc_url($url) . '" alt="' . esc_attr($name) . '" loading="lazy"></div>';
    }
    if ($items === '') { return; }
    $class = $compact ? 'pfx-logos pfx-logos--compact' : 'pfx-logos';
    echo '<section class="' . esc_attr($class) . '" aria-label="Trusted Brands">';
    echo '<h2 class="pfx-reveal">Trusted by Leading Brands</h2>';
    echo '<div class="pfx-marquee pfx-reveal pfx-delay-1"><div class="pfx-marquee-track">' . $items . $items . '</div></div>';
    echo '</section>';
}
?>
<style id="stretch-pfx">
/* ============ PREMIUM FX KIT (pfx-) ============ */
.pfx-container { max-width: 1200px; margin: 0 auto; padding: 0 40px; width: 100%; }
.gradient-text {
  background: linear-gradient(135deg, #8560A8 0%, #5674B9 30%, #448CCB 60%, #00BFF3 100%);
  -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
}
.pfx-overline {
  font-family: 'Montserrat', sans-serif; font-size: 13px; font-weight: 400;
  letter-spacing: 3px; text-transform: uppercase; color: #00BFF3;
  display: block; margin-bottom: 18px;
}

/* Scroll progress */
.pfx-progress { position: fixed; top: 0; left: 0; width: 100%; height: 3px; z-index: 1100; pointer-events: none; }
.pfx-progress-fill { height: 100%; width: 0; background: linear-gradient(90deg, #8560A8, #5674B9, #448CCB, #00BFF3); transition: width 0.1s ease-out; }

/* Custom cursor — plain ring + dot; NO blend mode, NO backdrop-filter (perf) */
.pfx-cursor {
  position: fixed; top: 0; left: 0; width: 20px; height: 20px;
  border: 1.5px solid rgba(133,96,168,0.5); border-radius: 50%;
  pointer-events: none; z-index: 1101; transform: translate(-50%, -50%);
  transition: width 0.3s cubic-bezier(0.16,1,0.3,1), height 0.3s cubic-bezier(0.16,1,0.3,1), border-color 0.3s ease, background 0.3s ease;
}
.pfx-cursor.active { width: 56px; height: 56px; border-color: rgba(133,96,168,0.3); background: rgba(133,96,168,0.08); }
.pfx-cursor-dot { position: fixed; top: 0; left: 0; width: 6px; height: 6px; background: #8560A8; border-radius: 50%; pointer-events: none; z-index: 1102; transform: translate(-50%, -50%); }
@media (hover: none), (pointer: coarse), (max-width: 768px) { .pfx-cursor, .pfx-cursor-dot { display: none !important; } }

/* Reveals */
.pfx-reveal { opacity: 0; transform: translateY(40px); transition: opacity 0.8s cubic-bezier(0.16,1,0.3,1), transform 0.8s cubic-bezier(0.16,1,0.3,1); }
.pfx-reveal.visible { opacity: 1; transform: translateY(0); }
.pfx-reveal-left { opacity: 0; transform: translateX(-60px); transition: opacity 0.9s cubic-bezier(0.16,1,0.3,1), transform 0.9s cubic-bezier(0.16,1,0.3,1); }
.pfx-reveal-left.visible { opacity: 1; transform: translateX(0); }
.pfx-reveal-right { opacity: 0; transform: translateX(60px); transition: opacity 0.9s cubic-bezier(0.16,1,0.3,1), transform 0.9s cubic-bezier(0.16,1,0.3,1); }
.pfx-reveal-right.visible { opacity: 1; transform: translateX(0); }
.pfx-delay-1 { transition-delay: 0.1s; } .pfx-delay-2 { transition-delay: 0.2s; }
.pfx-delay-3 { transition-delay: 0.3s; } .pfx-delay-4 { transition-delay: 0.4s; }
.pfx-delay-5 { transition-delay: 0.5s; } .pfx-delay-6 { transition-delay: 0.6s; }

/* Angled divider */
.pfx-angle-divider { position: absolute; bottom: -1px; left: 0; right: 0; z-index: 2; pointer-events: none; line-height: 0; }
.pfx-angle-divider svg { display: block; width: 100%; height: 60px; }

/* Grain — STATIC (no animation: compositor cost > visual value) */
.pfx-grain-overlay { position: absolute; inset: 0; overflow: hidden; pointer-events: none; z-index: 0; }
.pfx-grain-overlay::before {
  content: ''; position: absolute; inset: -50%; width: 200%; height: 200%; opacity: 0.035;
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
  background-size: 128px 128px;
}

/* Cinematic grid hero */
.pfx-hero { position: relative; display: flex; align-items: center; background: linear-gradient(170deg, #1a1f2e 0%, #252C3A 40%, #1e2333 100%); overflow: hidden; }
.pfx-hero::before { content: ''; position: absolute; top: -50%; right: -20%; width: 80%; height: 150%; background: radial-gradient(ellipse at center, rgba(86,116,185,0.08) 0%, transparent 70%); pointer-events: none; }
.pfx-hero::after { content: ''; position: absolute; bottom: -30%; left: -10%; width: 60%; height: 80%; background: radial-gradient(ellipse at center, rgba(133,96,168,0.06) 0%, transparent 70%); pointer-events: none; }
.pfx-hero-mesh { position: absolute; inset: 0; pointer-events: none; z-index: 0; background: radial-gradient(ellipse at 20% 50%, rgba(133,96,168,0.06) 0%, transparent 50%), radial-gradient(ellipse at 80% 20%, rgba(0,191,243,0.04) 0%, transparent 50%), radial-gradient(ellipse at 50% 80%, rgba(86,116,185,0.05) 0%, transparent 50%); }
.pfx-hero-grid { position: absolute; inset: 0; pointer-events: none; z-index: 1; overflow: hidden; }
.pfx-grid-container { position: absolute; inset: -60px; display: grid; grid-template-columns: repeat(auto-fill, 60px); grid-auto-rows: 60px; transition: transform 0.4s ease-out; }
.pfx-grid-cell { border: 1px solid rgba(255,255,255,0.03); }
.pfx-grid-cell.colored { background: var(--cell-color); border-color: rgba(255,255,255,0.06); animation: pfx-cellPulse 4s ease-in-out infinite; animation-delay: var(--cell-delay, 0s); }
@keyframes pfx-cellPulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.4; } }
.pfx-hero-grid::after { content: ''; position: absolute; inset: 0; background: radial-gradient(ellipse 55% 50% at 50% 50%, rgba(37,44,58,0.95) 0%, rgba(37,44,58,0.7) 30%, transparent 60%); pointer-events: none; z-index: 1; }
.pfx-hero--left .pfx-hero-grid::after { background: radial-gradient(ellipse 52% 55% at 32% 50%, rgba(37,44,58,0.95) 0%, rgba(37,44,58,0.7) 30%, transparent 62%); }

/* Buttons */
.pfx-btn-primary {
  display: inline-block; font-family: 'Poppins', sans-serif; font-size: 15px; font-weight: 500;
  color: #fff; background: linear-gradient(135deg, #8560A8, #5674B9);
  padding: 18px 44px; border-radius: 6px; text-decoration: none;
  transition: transform 0.3s ease, box-shadow 0.3s ease; box-shadow: 0 4px 20px rgba(133,96,168,0.3);
  position: relative; overflow: hidden; cursor: pointer; border: none;
}
.pfx-btn-primary::before { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, #5674B9, #00BFF3); opacity: 0; transition: opacity 0.3s ease; border-radius: 6px; }
.pfx-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(133,96,168,0.45); }
.pfx-btn-primary:hover::before { opacity: 1; }
.pfx-btn-primary span { position: relative; z-index: 1; }
.pfx-btn-primary:focus-visible, .pfx-btn-outline:focus-visible { outline: 2px solid #00BFF3; outline-offset: 2px; }
.pfx-btn-outline { display: inline-block; font-family: 'Poppins', sans-serif; font-size: 15px; font-weight: 500; color: #fff; border: 1px solid rgba(255,255,255,0.3); padding: 17px 43px; border-radius: 6px; text-decoration: none; transition: all 0.3s ease; }
.pfx-btn-outline:hover { background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.6); }

/* Animated accent bar */
.pfx-accent-bar { height: 4px; background: linear-gradient(90deg, #8560A8, #5674B9, #448CCB, #00BFF3, #448CCB, #5674B9, #8560A8); background-size: 200% 100%; animation: pfx-gradientSlide 4s ease infinite; }
@keyframes pfx-gradientSlide { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }

/* Rotating gradient-border CTA card (reserved for CTA cards; 19s per taste rules) */
@property --pfx-border-angle { syntax: '<angle>'; initial-value: 0deg; inherits: false; }
@keyframes pfx-borderSpin { to { --pfx-border-angle: 360deg; } }
.pfx-gradient-card {
  position: relative; border-radius: 20px; padding: 2px;
  background: conic-gradient(from var(--pfx-border-angle), #8560A8, #5674B9, #448CCB, #00BFF3, #448CCB, #5674B9, #8560A8);
  animation: pfx-borderSpin 19s linear infinite;
  box-shadow: 0 20px 60px rgba(26,31,46,0.12), 0 0 32px rgba(133,96,168,0.12), 0 0 64px rgba(0,191,243,0.06);
}
.pfx-gradient-card-inner { border-radius: 18px; background: #fff; padding: 64px 56px; text-align: center; }
.pfx-gradient-card-inner.dark { background: linear-gradient(170deg, #1e2333, #252C3A); }

/* Stats bar */
.pfx-stats-bar { background: #1a1f2e; padding: 72px 0; position: relative; overflow: hidden; }
.pfx-stats-bar::before { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, rgba(133,96,168,0.06), rgba(0,191,243,0.04)); pointer-events: none; }
.pfx-stats-inner { display: grid; grid-template-columns: repeat(4, 1fr); gap: 30px; text-align: center; position: relative; z-index: 1; }
.pfx-stat-number { font-family: 'Poppins', sans-serif; font-size: clamp(36px, 5vw, 56px); font-weight: 600; color: #fff; line-height: 1; margin-bottom: 10px; animation: pfx-numGlow 3.5s ease-in-out infinite; }
@keyframes pfx-numGlow { 0%, 100% { text-shadow: 0 0 18px rgba(0,191,243,0.18); } 50% { text-shadow: 0 0 34px rgba(0,191,243,0.45); } }
.pfx-stat-number .pfx-suffix { color: #00BFF3; }
.pfx-stat-label { font-family: 'Assistant', sans-serif; font-size: 14px; font-weight: 300; color: rgba(255,255,255,0.62); text-transform: uppercase; letter-spacing: 2px; }

/* Logo marquee */
.pfx-logos { background: #fff; padding: 70px 0 64px; overflow: hidden; position: relative; }
.pfx-logos h2 { font-family: 'Montserrat', sans-serif; font-size: 13px; font-weight: 400; letter-spacing: 3px; text-transform: uppercase; color: #767676; text-align: center; margin: 0 0 40px; }
.pfx-logos--compact { padding: 56px 0 50px; }
.pfx-logos--compact h2 { margin-bottom: 32px; }
.pfx-marquee { position: relative; }
.pfx-marquee::before, .pfx-marquee::after { content: ''; position: absolute; top: 0; bottom: 0; width: 140px; z-index: 2; pointer-events: none; }
.pfx-marquee::before { left: 0; background: linear-gradient(90deg, #fff, transparent); }
.pfx-marquee::after { right: 0; background: linear-gradient(270deg, #fff, transparent); }
.pfx-marquee-track { display: flex; align-items: center; gap: 70px; width: max-content; animation: pfx-marqueeScroll 45s linear infinite; }
.pfx-marquee-track:hover { animation-play-state: paused; }
@keyframes pfx-marqueeScroll { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
.pfx-logo-item { flex: 0 0 auto; }
.pfx-logo-item img { height: 34px; width: auto; filter: grayscale(100%); opacity: 0.55; transition: filter 0.4s ease, opacity 0.4s ease, transform 0.4s ease; }
.pfx-logos--compact .pfx-logo-item img { height: 28px; }
.pfx-logo-item img:hover { filter: grayscale(0%); opacity: 1; transform: translateY(-2px); }

/* Icon chips */
.pfx-icon-chip { display: inline-flex; align-items: center; gap: 10px; }
.pfx-icon-chip svg { width: 17px; height: 17px; stroke: #8560A8; flex: 0 0 auto; }

/* Accordion */
.pfx-accordion-item { border: 1px solid #eceef3; border-radius: 12px; margin-bottom: 14px; overflow: hidden; transition: box-shadow 0.4s ease, border-color 0.4s ease; background: #fff; }
.pfx-accordion-item.pfx-acc-open { box-shadow: 0 10px 32px rgba(26,31,46,0.08); border-color: rgba(133,96,168,0.25); }
.pfx-accordion-trigger { width: 100%; display: flex; align-items: center; justify-content: space-between; gap: 20px; background: none; border: none; text-align: left; font-family: 'Poppins', sans-serif; font-size: 17px; font-weight: 600; color: #1a1f2e; padding: 24px 28px; cursor: pointer; }
.pfx-accordion-trigger:focus-visible { outline: 2px solid #00BFF3; outline-offset: -2px; }
.pfx-accordion-icon { flex: 0 0 auto; width: 28px; height: 28px; border-radius: 50%; background: linear-gradient(135deg, rgba(133,96,168,0.1), rgba(0,191,243,0.1)); display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 300; color: #5674B9; transition: transform 0.35s ease; }
.pfx-acc-open .pfx-accordion-icon { transform: rotate(45deg); }
.pfx-accordion-panel { max-height: 0; overflow: hidden; transition: max-height 0.45s cubic-bezier(0.16,1,0.3,1); }
.pfx-accordion-panel p { font-family: 'Assistant', sans-serif; font-size: 16px; line-height: 1.7; color: #555; margin: 0; padding: 0 28px 26px; max-width: 880px; }

/* Reduced motion — neutralize EVERYTHING (AUD-027) */
@media (prefers-reduced-motion: reduce) {
  .pfx-grid-cell.colored, .pfx-stat-number, .pfx-gradient-card, .pfx-accent-bar,
  .pfx-marquee-track { animation: none !important; }
  .pfx-reveal, .pfx-reveal-left, .pfx-reveal-right { opacity: 1 !important; transform: none !important; transition: none !important; }
  .pfx-cursor, .pfx-cursor-dot { display: none !important; }
  html { scroll-behavior: auto !important; }
}

/* Responsive */
@media (max-width: 960px) { .pfx-stats-inner { grid-template-columns: repeat(2, 1fr); gap: 40px 20px; } }
@media (max-width: 768px) { .pfx-container { padding: 0 24px; } .pfx-gradient-card-inner { padding: 44px 28px; } }
</style>
<noscript><style>/* AUD-026: content must be visible without JS */
.pfx-reveal, .pfx-reveal-left, .pfx-reveal-right { opacity: 1 !important; transform: none !important; }
</style></noscript>
<script id="stretch-pfx-js">
document.addEventListener('DOMContentLoaded', function () {
  var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var isTouchDevice = 'ontouchstart' in window || navigator.maxTouchPoints > 0;

  /* Scroll progress bar */
  var progress = document.createElement('div');
  progress.className = 'pfx-progress';
  progress.innerHTML = '<div class="pfx-progress-fill"></div>';
  document.body.appendChild(progress);
  var progressFill = progress.querySelector('.pfx-progress-fill');
  window.addEventListener('scroll', function () {
    var h = document.documentElement.scrollHeight - window.innerHeight;
    progressFill.style.width = (h > 0 ? (window.scrollY / h) * 100 : 0) + '%';
  }, { passive: true });

  /* Custom cursor */
  if (!isTouchDevice && !reducedMotion && window.innerWidth > 768) {
    var cursor = document.createElement('div'); cursor.className = 'pfx-cursor';
    var dot = document.createElement('div'); dot.className = 'pfx-cursor-dot';
    document.body.appendChild(cursor); document.body.appendChild(dot);
    var cx = -100, cy = -100, ringX = -100, ringY = -100, cursorDirty = false;
    document.addEventListener('mousemove', function (e) {
      cx = e.clientX; cy = e.clientY; cursorDirty = true;
      dot.style.left = cx + 'px'; dot.style.top = cy + 'px';
    }, { passive: true });
    (function animateRing() {
      if (cursorDirty || Math.abs(cx - ringX) > 0.5 || Math.abs(cy - ringY) > 0.5) {
        ringX += (cx - ringX) * 0.18; ringY += (cy - ringY) * 0.18;
        cursor.style.left = ringX + 'px'; cursor.style.top = ringY + 'px';
        cursorDirty = false;
      }
      requestAnimationFrame(animateRing);
    })();
    document.addEventListener('mouseover', function (e) {
      if (e.target.closest('a, button, summary, [data-cursor]')) cursor.classList.add('active');
    });
    document.addEventListener('mouseout', function (e) {
      if (e.target.closest('a, button, summary, [data-cursor]')) cursor.classList.remove('active');
    });
  }

  /* Reveal observer + throttled-tab fallback (hidden/zero-height viewports) */
  var revealSel = '.pfx-reveal, .pfx-reveal-left, .pfx-reveal-right';
  var revealObserver = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) { entry.target.classList.add('visible'); revealObserver.unobserve(entry.target); }
    });
  }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });
  document.querySelectorAll(revealSel).forEach(function (el) { revealObserver.observe(el); });
  var revealFallback = setInterval(function () {
    var pending = document.querySelectorAll('.pfx-reveal:not(.visible), .pfx-reveal-left:not(.visible), .pfx-reveal-right:not(.visible)');
    if (!pending.length) { clearInterval(revealFallback); return; }
    var vh = window.innerHeight;
    if (vh === 0 || document.hidden) { pending.forEach(function (el) { el.classList.add('visible'); }); return; }
    pending.forEach(function (el) {
      var r = el.getBoundingClientRect();
      if (r.top < vh - 40 && r.bottom > 0) el.classList.add('visible');
    });
  }, 400);

  /* Grid hero generation + parallax */
  document.querySelectorAll('.pfx-hero').forEach(function (heroSection) {
    var gridWrap = heroSection.querySelector('.pfx-hero-grid');
    if (!gridWrap) return;
    var gridContainer = document.createElement('div');
    gridContainer.className = 'pfx-grid-container';
    gridWrap.appendChild(gridContainer);
    var cellSize = 60;
    var cols = Math.ceil((window.innerWidth + 120) / cellSize);
    var rows = Math.ceil((Math.max(heroSection.offsetHeight, 400) + 120) / cellSize);
    var totalCells = cols * rows;
    var coloredCount = Math.floor(totalCells * 0.18);
    var colors = ['rgba(133,96,168,0.18)','rgba(133,96,168,0.14)','rgba(86,116,185,0.16)','rgba(86,116,185,0.12)','rgba(0,191,243,0.14)','rgba(0,191,243,0.10)','rgba(68,140,203,0.14)','rgba(133,96,168,0.22)','rgba(0,191,243,0.18)'];
    var coloredIndices = new Set();
    while (coloredIndices.size < coloredCount) coloredIndices.add(Math.floor(Math.random() * totalCells));
    var fragment = document.createDocumentFragment();
    for (var i = 0; i < totalCells; i++) {
      var cell = document.createElement('div');
      cell.className = 'pfx-grid-cell';
      if (coloredIndices.has(i)) {
        cell.classList.add('colored');
        cell.style.setProperty('--cell-color', colors[Math.floor(Math.random() * colors.length)]);
        cell.style.setProperty('--cell-delay', (Math.random() * 4).toFixed(1) + 's');
      }
      fragment.appendChild(cell);
    }
    gridContainer.appendChild(fragment);
    if (!isTouchDevice && !reducedMotion && window.innerWidth > 768) {
      heroSection.addEventListener('mousemove', function (e) {
        var rect = heroSection.getBoundingClientRect();
        var mx = ((e.clientX - rect.left) / rect.width - 0.5) * 2;
        var my = ((e.clientY - rect.top) / rect.height - 0.5) * 2;
        gridContainer.style.transform = 'translate(' + (mx * 15) + 'px, ' + (my * 15) + 'px)';
      }, { passive: true });
      heroSection.addEventListener('mouseleave', function () { gridContainer.style.transform = 'translate(0, 0)'; });
    }
  });

  /* Counters — HTML ships the FINAL value (AUD-026); JS animates from 0 */
  function animateCount(el) {
    var target = parseFloat(el.dataset.target);
    if (isNaN(target)) return;
    var duration = 2000, start = performance.now();
    function tick(now) {
      var p = Math.min((now - start) / duration, 1);
      el.textContent = Math.floor(target * (1 - Math.pow(1 - p, 3)));
      if (p < 1) requestAnimationFrame(tick); else el.textContent = target;
    }
    requestAnimationFrame(tick);
  }
  var countObserver = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        entry.target.setAttribute('data-counted', '1');
        if (!reducedMotion) {
          entry.target.querySelectorAll('.pfx-count').forEach(function (el) { el.textContent = '0'; animateCount(el); });
        }
        countObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.3 });
  document.querySelectorAll('.pfx-stats-bar').forEach(function (bar) { countObserver.observe(bar); });

  /* Grain injection */
  document.querySelectorAll('[data-grain]').forEach(function (section) {
    if (window.getComputedStyle(section).position === 'static') section.style.position = 'relative';
    var grain = document.createElement('div');
    grain.className = 'pfx-grain-overlay';
    section.insertBefore(grain, section.firstChild);
  });

  /* 3D tilt */
  if (!isTouchDevice && !reducedMotion && window.innerWidth > 768) {
    document.querySelectorAll('.pfx-tilt').forEach(function (card) {
      card.addEventListener('mousemove', function (e) {
        var rect = card.getBoundingClientRect();
        var dx = (e.clientX - (rect.left + rect.width / 2)) / (rect.width / 2);
        var dy = (e.clientY - (rect.top + rect.height / 2)) / (rect.height / 2);
        card.style.transform = 'perspective(800px) rotateY(' + (dx * 3) + 'deg) rotateX(' + (-dy * 3) + 'deg) translateY(-6px)';
        card.style.transition = 'none';
      }, { passive: true });
      card.addEventListener('mouseleave', function () {
        card.style.transform = '';
        card.style.transition = 'transform 0.5s cubic-bezier(0.16,1,0.3,1), box-shadow 0.5s ease';
      });
    });
  }

  /* Magnetic buttons */
  if (!isTouchDevice && !reducedMotion) {
    document.querySelectorAll('.pfx-btn-primary, .pfx-btn-outline').forEach(function (btn) {
      btn.addEventListener('mousemove', function (e) {
        var rect = btn.getBoundingClientRect();
        var dx = e.clientX - (rect.left + rect.width / 2);
        var dy = e.clientY - (rect.top + rect.height / 2);
        var dist = Math.sqrt(dx * dx + dy * dy);
        var maxDist = 40;
        if (dist < maxDist + rect.width / 2) {
          var pull = Math.max(0, 1 - dist / (maxDist + rect.width / 2));
          btn.style.transform = 'translate(' + (dx * pull * 0.3) + 'px, ' + (dy * pull * 0.3) + 'px)';
        }
      }, { passive: true });
      btn.addEventListener('mouseleave', function () {
        btn.style.transform = '';
        btn.style.transition = 'transform 0.4s cubic-bezier(0.16,1,0.3,1)';
        setTimeout(function () { btn.style.transition = ''; }, 400);
      });
    });
  }

  /* Single-open accordion */
  document.querySelectorAll('.pfx-accordion-trigger').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var expanded = btn.getAttribute('aria-expanded') === 'true';
      var panel = document.getElementById(btn.getAttribute('aria-controls'));
      if (!panel) return;
      var item = btn.closest('.pfx-accordion-item');
      document.querySelectorAll('.pfx-accordion-trigger').forEach(function (other) {
        if (other === btn) return;
        other.setAttribute('aria-expanded', 'false');
        var op = document.getElementById(other.getAttribute('aria-controls'));
        if (op) op.style.maxHeight = '0';
        var oi = other.closest('.pfx-accordion-item');
        if (oi) oi.classList.remove('pfx-acc-open');
      });
      btn.setAttribute('aria-expanded', String(!expanded));
      panel.style.maxHeight = expanded ? '0' : panel.scrollHeight + 'px';
      if (item) item.classList.toggle('pfx-acc-open', !expanded);
    });
  });
});
</script>
```

- [ ] **Step 2: Lint**

Run: `docker compose exec -T wordpress php -l /var/www/html/wp-content/themes/stretch-theme/template-parts/premium-fx.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Smoke-include check**

Create a throwaway include on a live template is NOT needed — instead run:
`docker compose exec -T wordpress wp eval 'get_template_part("template-parts/premium-fx"); echo "\nINCLUDED_OK\n";' --allow-root | tail -1`
Expected: `INCLUDED_OK` (the partial emits its style/script blocks above it — errors would fatal).

- [ ] **Step 4: Commit**

```bash
git add stretch-theme/template-parts/premium-fx.php
git commit -m "feat(redesign): shared premium-fx kit — grid hero, reveals+fallback, counters, marquee, tilt, a11y/perf rules (AUD-013/026/027)"
```

---

### Task 2: Rebuild `page-home.php` on the premium design

**Files:**
- Modify: `stretch-theme/page-home.php` (full rewrite of the file)
- Test: curl + screenshot assertions (steps below)

**Interfaces:**
- Consumes: `get_template_part('template-parts/premium-fx')` and every `pfx-` class from Task 1; `stretch_pfx_logo_marquee()`; `stretch_page_images` option (existing, keys `home_ecommerce|home_agencies|home_service_providers|home_saas`).
- Produces: the live homepage. Section ids used later by nav/footer anchors: none (no home anchors in the site map).
- Copy: hero/services/industries/trust/CTA copy is IDENTICAL to the current file (already doc-verbatim with the two drift fixes) — reuse the existing strings exactly as they appear in the current `page-home.php`. Structural additions from the approved design: hero CTA button, restored marquee + stats bar, mid-page CTA card, dark trust section, final CTA with outline button.

- [ ] **Step 1: Rewrite the file**

Replace the ENTIRE contents of `stretch-theme/page-home.php` with the structure below. Where a block says `[COPY: keep existing]`, carry over the exact copy strings and the icon SVGs from the current file version at HEAD — with the three Lucide icon replacements listed in Step 2 applied.

```php
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
      <p class="home-subtitle pfx-reveal pfx-delay-3">[COPY: keep existing hero subtitle string]</p>
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

<!-- 4. OUR SERVICES — six cards, numbered 01-06. [COPY: keep existing] card copy,
     links, and per-card --svc-* custom properties from the current file. Card
     wrapper becomes: class="home-svc-card pfx-tilt pfx-reveal pfx-delay-N" with
     <div class="home-svc-num">0N</div> first, then the icon tile, h3, p, link.
     The add-on card keeps its list and gets home-svc-card--addon. -->

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

<!-- 6. WHO WE SERVE — four cards. [COPY: keep existing] tag/title/desc/list copy and
     the stretch_page_images attachment logic (wp_get_attachment_image + Unsplash
     fallback) EXACTLY as in the current file. Card wrapper becomes
     class="home-ind-card pfx-tilt pfx-reveal pfx-delay-N"; the image block becomes
     <div class="home-ind-image"> with <div class="home-ind-tag">NAME</div> INSIDE it
     (glass tag over the photo). Links: Ecommerce -> /industries/ecommerce/,
     Agencies -> /industries/agencies/, Service Providers and SaaS keep
     /contact-stretch-creative/ for now (Task 5 flips them to the new pages). -->

<!-- 7. WHY TRUST (dark) — five cards. [COPY: keep existing] h3/p copy and --prop-*
     custom properties. Wrapper: class="home-trust-card pfx-tilt pfx-reveal
     pfx-delay-N" (5th card adds home-trust-card--wide). Close with:
     <div class="home-trust-cta pfx-reveal pfx-delay-2">
       <a href="/about-stretch-creative/" class="pfx-btn-primary"><span>Learn how we work &rarr;</span></a>
     </div> -->

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
```

Notes for the implementer:
- The `[COPY: keep existing]` blocks are NOT placeholders for invented content — they are instructions to carry the exact strings/SVGs/logic from the current `page-home.php` at HEAD into the new wrappers. Diff your result against HEAD to prove copy is byte-identical (whitespace aside).
- Delete the old inline `<script>` (reveal observer + tilt) at the bottom of the current file — the kit owns those behaviors now.

- [ ] **Step 2: Apply the three Lucide icon replacements while porting the services cards (AUD-037)**

Card 01 (SEO/AEO) icon — replace the zoom-in magnifier with Lucide `search`:
```html
<svg viewBox="0 0 24 24" fill="none" stroke="#8560A8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
```
Card 04 (Visual Content & Design) icon — replace the malformed palette blob (the client-flagged icon) with Lucide `palette`:
```html
<svg viewBox="0 0 24 24" fill="none" stroke="#00BFF3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="13.5" cy="6.5" r=".5" fill="#00BFF3"/><circle cx="17.5" cy="10.5" r=".5" fill="#00BFF3"/><circle cx="8.5" cy="7.5" r=".5" fill="#00BFF3"/><circle cx="6.5" cy="12.5" r=".5" fill="#00BFF3"/><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/></svg>
```
Card 06 (Add-On Services) icon — replace the bare plus with Lucide `puzzle`:
```html
<svg viewBox="0 0 24 24" fill="none" stroke="#5674B9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19.439 7.85c-.049.322.059.648.289.878l1.568 1.568c.47.47.706 1.087.706 1.704s-.235 1.233-.706 1.704l-1.611 1.611a.98.98 0 0 1-.837.276c-.47-.07-.802-.48-.968-.925a2.501 2.501 0 1 0-3.214 3.214c.446.166.855.497.925.968a.979.979 0 0 1-.276.837l-1.61 1.61a2.404 2.404 0 0 1-1.705.707 2.402 2.402 0 0 1-1.704-.706l-1.568-1.568a1.026 1.026 0 0 0-.877-.29c-.493.074-.84.504-1.02.968a2.5 2.5 0 1 1-3.237-3.237c.464-.18.894-.527.967-1.02a1.026 1.026 0 0 0-.289-.877l-1.568-1.568A2.402 2.402 0 0 1 1.998 12c0-.617.236-1.234.706-1.704L4.23 8.77c.24-.24.581-.353.917-.303.515.077.877.528 1.073 1.01a2.5 2.5 0 1 0 3.259-3.259c-.482-.196-.933-.558-1.01-1.073-.05-.336.062-.676.303-.917l1.525-1.525A2.402 2.402 0 0 1 12 1.998c.617 0 1.234.236 1.704.706l1.568 1.568c.23.23.556.338.877.29.493-.074.84-.504 1.02-.968a2.5 2.5 0 1 1 3.237 3.237c-.464.18-.894.527-.967 1.02Z"/></svg>
```
Cards 02/03/05 keep their existing icons (layers / edit-pencil / target — already clean).

- [ ] **Step 3: Lint + render checks**

```bash
docker compose exec -T wordpress php -l /var/www/html/wp-content/themes/stretch-theme/page-home.php
export LC_ALL=C
curl -s "http://localhost:8888/?t=$(date +%s)" -o /tmp/home-check.html
grep -c "pfx-hero" /tmp/home-check.html          # expect >= 1
grep -c "pfx-marquee-track" /tmp/home-check.html # expect 1 (server-rendered logos)
grep -c "pfx-logo-item" /tmp/home-check.html     # expect >= 30 (duplicated track)
grep -c "home-midcta" /tmp/home-check.html       # expect >= 1 (new mid CTA)
grep -c "home-trust-card" /tmp/home-check.html   # expect 5
grep -c ">200<" /tmp/home-check.html             # expect >= 1 (server-rendered counter)
grep -c "images.unsplash.com" /tmp/home-check.html # expect 0 locally (option seeded)
grep -c 'href="#"' /tmp/home-check.html          # expect 0
```
Screenshot: `"/Applications/Google Chrome.app/Contents/MacOS/Google Chrome" --headless --disable-gpu --hide-scrollbars --window-size=1440,900 --screenshot=/tmp/home-new.png "http://localhost:8888/"` — file > 100KB, visually: grid hero + gradient headline + Discovery Call button.

- [ ] **Step 4: Copy-fidelity diff**

```bash
git diff HEAD -- stretch-theme/page-home.php | grep -E "^-.*(We help DTC|When demand exceeds|Your local service|Whether you|Search has changed|Calculators,|Our hand-picked|Strong visuals|Traffic alone|Content works|The best partnerships|Search is evolving|Need more content|We\x27re not an AI)" | wc -l
```
Expected: `0` removed copy lines that aren't re-added identically (manually eyeball the diff hunks: every `-` copy line must have a matching `+` line).

- [ ] **Step 5: Commit**

```bash
git add stretch-theme/page-home.php
git commit -m "feat(redesign): premium homepage — grid hero, marquee+stats restored, mid-CTA, dark trust, Lucide icon fixes (AUD-036 interim, AUD-037 partial)"
```

---

### Task 3: Delete dead templates; move wizard data out of the theme (AUD-030)

**Files:**
- Delete: `stretch-theme/front-page-v2.php`, `stretch-theme/front-page-v3.php`, `stretch-theme/front-page-demo.php`, `stretch-theme/page-solutions.php`, `stretch-theme/setup-aeo-hub.php`
- Move: `stretch-theme/data/` → `wizard-data/` (repo root)
- Modify: `stretch-theme/setup-wizard.php` (data path), `Dockerfile` (COPY wizard-data), `docker-entrypoint-custom.sh` (no change needed — verify only)

**Interfaces:**
- Consumes: Task 2 must be merged first (front-page-v2 was the design reference; the homepage no longer references it).
- Produces: none (pure removal). The wizard reads seed JSON from `/opt/wizard-data/` in production and `ABSPATH . '../wizard-data/'`-style path locally — see Step 2 for the exact resolution function.

- [ ] **Step 1: Verify nothing references the doomed files**

```bash
grep -rn "front-page-v2\|front-page-v3\|front-page-demo\|page-solutions\|setup-aeo-hub" stretch-theme/ --include="*.php" | grep -v "Binary"
docker compose exec -T wordpress wp post list --post_type=page --fields=ID,post_name --allow-root | while read id slug; do docker compose exec -T wordpress wp post meta get "$id" _wp_page_template --allow-root 2>/dev/null; done | sort | uniq -c
```
Expected: no live template references; no page assigned to any of the five templates (page 14 `stretch-creative-solutions` may still reference `page-solutions.php` — reassign it to `default` with `wp post meta update 14 _wp_page_template default --allow-root`; its URL 301s to `/` so rendering never happens).

- [ ] **Step 2: Move wizard data and point the wizard at it**

```bash
git mv stretch-theme/data wizard-data
```
In `stretch-theme/setup-wizard.php`, find every reference to `get_template_directory() . '/data/` (Step 9 seeder + thumbnail backfill) and replace the directory resolution with:
```php
// Wizard seed data lives outside the theme (AUD-030): /opt/wizard-data in the
// production image, ../wizard-data relative to ABSPATH for local dev bind mounts.
function stretch_wizard_data_dir() {
    if (is_dir('/opt/wizard-data')) { return '/opt/wizard-data'; }
    $local = dirname(ABSPATH) . '/wizard-data';
    return is_dir($local) ? $local : '';
}
```
and use `stretch_wizard_data_dir() . '/blog-posts.json'` / `. '/thumbs/...'` at each site. If the dir resolves empty, the wizard step must print "wizard-data not found — skipping seed" instead of fataling.

In `Dockerfile`, after the setup-script COPY block add:
```dockerfile
COPY wizard-data/ /opt/wizard-data/
```

- [ ] **Step 3: Delete the dead templates**

```bash
git rm stretch-theme/front-page-v2.php stretch-theme/front-page-v3.php stretch-theme/front-page-demo.php stretch-theme/page-solutions.php stretch-theme/setup-aeo-hub.php
```

- [ ] **Step 4: Verify**

```bash
docker compose exec -T wordpress php -l /var/www/html/wp-content/themes/stretch-theme/setup-wizard.php
export LC_ALL=C
for u in "/" "/blog/" "/blog/aeo/" "/our-work/" "/the-team/" "/about-stretch-creative/" "/contact-stretch-creative/" "/industries/ecommerce/"; do curl -s -o /dev/null -w "%{http_code} $u\n" "http://localhost:8888$u"; done
curl -s -o /dev/null -w "%{http_code}\n" "http://localhost:8888/stretch-creative-solutions/"   # expect 301
```
Expected: all 200 (+ the 301). Admin template dropdown no longer lists Homepage 2.0/3.0/Demo/Solutions (verify via `docker compose exec -T wordpress wp eval 'print_r(array_keys(wp_get_theme()->get_page_templates()));' --allow-root` — expect no front-page-v2/v3/demo/solutions entries).

- [ ] **Step 5: Commit**

```bash
git add -A
git commit -m "chore(redesign): delete dead templates, move wizard data out of the theme (AUD-030)"
```

---

### Task 4: Rebuild `page-industry.php` on the premium design (data-driven)

**Files:**
- Modify: `stretch-theme/page-industry.php` (full rewrite)
- Test: curl + screenshot assertions on `/industries/ecommerce/` and `/industries/agencies/`

**Interfaces:**
- Consumes: premium-fx kit (Task 1); option `stretch_industry_{slug}` with existing keys (`overline,h1,hero_text,cta_label,audiences,challenges_intro,challenges,solutions_heading,solutions[{title,body}],mid_cta_text,popular_heading,popular[{title,body}],why[{title,body}],faqs[{q,a}],final_heading,final_text`) PLUS new optional keys this task starts honoring: `audiences` entries may be `"Label"` or `{label, icon}`; `solutions` entries may add `icon`.
- Produces: icon slug vocabulary consumed by Task 5's seed data: `shirt,cup,sparkle,box,cart,storefront,search,file-text,book-open,camera,target,map-pin,layout,pen,chart,shield,users,message,globe,wrench,briefcase,monitor,heart,graduation` (function `stretch_industry_icon($slug)` returns the inline SVG; unknown/missing slugs fall back to a rotating default set in DOM order).

- [ ] **Step 1: Rewrite the template**

Full file content — this is complete; no porting required:

```php
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
$faqs        = !empty($d['faqs'])              ? $d['faqs']               : [];
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
```

- [ ] **Step 2: Lint + render checks**

```bash
docker compose exec -T wordpress php -l /var/www/html/wp-content/themes/stretch-theme/page-industry.php
export LC_ALL=C
for slug in ecommerce agencies; do
  curl -s "http://localhost:8888/industries/$slug/?t=$(date +%s)" -o /tmp/ind-$slug.html
  echo "$slug: hero=$(grep -c pfx-hero--left /tmp/ind-$slug.html) chips=$(grep -c ind-chip /tmp/ind-$slug.html) panel=$(grep -c ind-pain-panel /tmp/ind-$slug.html) solcards=$(grep -c ind-solution-card /tmp/ind-$slug.html) marquee=$(grep -c pfx-marquee-track /tmp/ind-$slug.html) accordion=$(grep -c pfx-accordion-trigger /tmp/ind-$slug.html) faqld=$(grep -c 'FAQPage' /tmp/ind-$slug.html) gradcard=$(grep -c pfx-gradient-card /tmp/ind-$slug.html)"
done
```
Expected per page: hero=1, chips>=6, panel=1, solcards>=5, marquee=1, accordion>=4, faqld=1, gradcard>=1. Screenshot both pages at 1440x900 (>100KB, hero text left-aligned over clear mask).

- [ ] **Step 3: Commit**

```bash
git add stretch-theme/page-industry.php
git commit -m "feat(redesign): premium industry template — icon chips, challenges panel, icon solution cards, marquee strip, accordion FAQs"
```

---

### Task 5: Seed Service Providers + SaaS industry pages; flip homepage links

**Files:**
- Modify: `setup-industries.php` (append two entries to its `$industries` data array — match the existing array shape used for ecommerce/agencies)
- Modify: `stretch-theme/page-home.php` (two `home-ind-link` hrefs)
- Copy source: `design-reference/copy-doc.md` lines 708-885 (Local Service Providers) and 886-1085 (SaaS)

**Interfaces:**
- Consumes: Task 4's option schema + icon slugs; existing `setup-industries.php` structure (creates parent `/industries/` + child pages with template `page-industry.php`, saves `stretch_industry_{slug}` options; idempotent by slug).
- Produces: pages at `/industries/service-providers/` and `/industries/saas/`; options `stretch_industry_service-providers`, `stretch_industry_saas`.

- [ ] **Step 1: Append the two data entries**

Add to the industries array in `setup-industries.php`, after the agencies entry. Copy is verbatim from the doc (curly quotes/em-dashes preserved exactly as they appear in `design-reference/copy-doc.md`):

```php
'service-providers' => [
    'title'             => 'Service Providers',
    'overline'          => 'Local Service Providers',
    'h1'                => 'Local SEO, Content & Creative Services for Service Providers',
    'hero_text'         => 'Help customers find your business, understand your services, and feel confident reaching out.',
    'cta_label'         => 'Schedule a Discovery Call',
    'audiences'         => [
        ['label' => 'Home Service Businesses', 'icon' => 'wrench'],
        ['label' => 'Healthcare Systems', 'icon' => 'heart'],
        ['label' => 'Beauty & Wellness Practices', 'icon' => 'sparkle'],
        ['label' => 'Dental Groups', 'icon' => 'shield'],
        ['label' => 'Multi-Office Law Firms', 'icon' => 'briefcase'],
        ['label' => 'Restoration Companies', 'icon' => 'wrench'],
        ['label' => 'Franchises', 'icon' => 'storefront'],
        ['label' => 'Multi-Location Businesses', 'icon' => 'map-pin'],
    ],
    'challenges_intro'  => [
        'When people need a service, they usually start with an online search.',
        'Whether they’re looking for a plumber, contractor, CPA, attorney, or wellness provider, customers expect to find accurate information quickly and easily. If your business isn’t visible where they’re searching, or if your website doesn’t build trust once they click in, you may never get the opportunity to earn their business.',
    ],
    'challenges'        => [
        'Limited visibility in local search results',
        'Competing against larger businesses and national brands',
        'Managing SEO across multiple service areas or locations',
        'Outdated service pages and website content',
        'Explaining complex services clearly',
        'Building trust with prospective customers',
        'Generating consistent leads',
        'Keeping up with changes in search and AI-powered discovery',
    ],
    'solutions_heading' => 'Solutions Built for Service Providers',
    'solutions'         => [
        ['icon' => 'map-pin',   'title' => 'Local SEO', 'body' => 'Local SEO helps customers find your business when they’re actively looking for services. We support service providers with local keyword research, on-page optimization, Google Business Profile support, location page optimization, technical SEO, and content strategy.'],
        ['icon' => 'file-text', 'title' => 'Service & Location Page Content', 'body' => 'Customers need clear information before they contact a business. We create service pages, location pages, FAQs, and supporting content that help potential customers understand what you do, where you work, and why they should choose your business.'],
        ['icon' => 'book-open', 'title' => 'Local Content Marketing', 'body' => 'Educational articles, resource centers, and service-focused blog content help answer customer questions, support local search visibility, and establish credibility within your market.'],
        ['icon' => 'camera',    'title' => 'Visual Content & Design', 'body' => 'Strong visual content helps customers understand who you are before they ever pick up the phone. We create graphics, photography, video content, and branded assets that support your website, social media presence, and advertising campaigns.'],
        ['icon' => 'target',    'title' => 'Paid Advertising', 'body' => 'SEO builds long-term visibility, but paid advertising can help generate leads right away. We develop search, display, remarketing, and social advertising campaigns that connect service providers with customers who are ready to take action.'],
    ],
    'mid_cta_text'      => 'Need more qualified leads? Schedule a discovery call today.',
    'popular_heading'   => 'Services Most Popular with Local Service Providers',
    'popular'           => [
        ['title' => 'Local SEO Services', 'body' => 'Local keyword research, SEO audits and technical SEO, Google Business Profile support, and search optimization for service-based businesses.'],
        ['title' => 'Service Pages', 'body' => 'Clear, informative service pages designed to answer customer questions, build trust and authority, and support local search visibility.'],
        ['title' => 'Location Pages', 'body' => 'Unique location pages that help multi-location or multi-region businesses and franchises expand their presence in local search results.'],
        ['title' => 'Content Marketing', 'body' => 'Educational articles, FAQs, service-focused blogs, and resource content that provide value to your audience and support organic visibility.'],
        ['title' => 'Visual Content & Design', 'body' => 'Infographics, social media graphics, branded assets, and other creative content that support multi-channel marketing efforts.'],
        ['title' => 'Photography & Video', 'body' => 'Professional photography, team profiles, service demonstrations, facility photography, and video production.'],
        ['title' => 'Interactive Content Experiences', 'body' => 'Assessments, calculators, cost estimators, and other tools that help customers understand their options before reaching out.'],
        ['title' => 'Paid Advertising', 'body' => 'Search, display, social media, and remarketing campaigns designed to generate qualified leads when they need you most.'],
    ],
    'why'               => [
        ['title' => 'All of the Services You Need Under One Roof', 'body' => 'SEO, content, design, photography, video, and paid advertising working together to help service providers attract and convert new customers.'],
        ['title' => 'Human-Created. Expert-Led.', 'body' => 'Every project is developed by experienced professionals who understand how customers search for and evaluate service providers.'],
        ['title' => 'Built for Growth', 'body' => 'Whether you’re expanding into new markets, opening new locations, or growing your service area, our team can scale alongside your business.'],
        ['title' => 'A True Extension of Your Team', 'body' => 'Work with strategists, writers, editors, creatives, and SEO specialists who understand your services, your customers, and your goals.'],
    ],
    'faqs'              => [
        ['q' => 'What is local SEO?', 'a' => 'Local SEO is the process of improving a business’s visibility in local search results through website optimization, Google Business Profile management, local content creation, and location-based SEO strategies.'],
        ['q' => 'Do service pages help SEO?', 'a' => 'Yes. Service pages help search engines understand the services you offer while providing customers with the information they need to evaluate your business.'],
        ['q' => 'Do I need separate location pages?', 'a' => 'If your business serves multiple cities, neighborhoods, or markets, dedicated location pages can help improve visibility for local searches in those areas.'],
        ['q' => 'Can Stretch Creative support franchises and multi-location businesses?', 'a' => 'Absolutely. We regularly support franchises and large organizations with multiple locations, various service offerings, and complex local SEO needs.'],
    ],
    'final_heading'     => 'Ready to Grow Your Service Business?',
    'final_text'        => 'Stretch Creative provides local SEO, strategy, and content services that can help get—and keep—your phones ringing. Let’s talk about how we can help you grow.',
],
'saas' => [
    'title'             => 'SaaS & Digital Platforms',
    'overline'          => 'SaaS & Digital Platforms',
    'h1'                => 'SaaS and Digital Platform SEO, Content & Creative Services',
    'hero_text'         => 'Help your audience understand what you offer, why it matters, and whether it’s the right fit.',
    'cta_label'         => 'Schedule a Discovery Call',
    'audiences'         => [
        ['label' => 'SaaS Companies', 'icon' => 'monitor'],
        ['label' => 'Telehealth Platforms', 'icon' => 'heart'],
        ['label' => 'Fintech Companies', 'icon' => 'chart'],
        ['label' => 'EdTech Platforms', 'icon' => 'graduation'],
        ['label' => 'Marketplaces', 'icon' => 'storefront'],
        ['label' => 'Technology-Enabled Service Providers', 'icon' => 'wrench'],
        ['label' => 'B2B Software Companies', 'icon' => 'briefcase'],
        ['label' => 'B2C Digital Platforms', 'icon' => 'globe'],
    ],
    'challenges_intro'  => [
        'The more innovative or technical your product is, the harder it can be to explain to your audience.',
        'Many software companies and digital platforms ask customers to learn new concepts, evaluate unfamiliar solutions, or trust technology with important decisions involving their businesses, finances, healthcare, education, or personal information.',
        'At the same time, buyers are conducting more independent research than ever before, often with the help of AI. They compare alternatives, read reviews, and explore educational content. They often arrive at sales conversations with a shortlist already in mind.',
    ],
    'challenges'        => [
        'Explaining complex products clearly',
        'Long buying and decision-making cycles',
        'Standing out in crowded markets',
        'Creating content that builds trust and credibility',
        'Supporting product adoption and customer education',
        'Producing content for highly regulated or YMYL industries',
        'Maintaining consistent messaging across channels',
        'Keeping up with changes in search and AI-powered discovery',
    ],
    'solutions_heading' => 'Solutions Built for SaaS Companies and Digital Platforms',
    'solutions'         => [
        ['icon' => 'search',    'title' => 'SaaS SEO & Content Strategy', 'body' => 'Strong SaaS content starts with understanding how potential customers search for solutions. We develop AEO and SEO strategies, content plans, and search-optimized resources that help software companies and platforms attract qualified audiences throughout the buying process.'],
        ['icon' => 'layout',    'title' => 'Product & Solution Pages', 'body' => 'Your website should help visitors understand what your product does, who it’s for, and why it matters. We create product pages, solution pages, feature descriptions, landing pages, and supporting content that simplify complex offerings without oversimplifying them.'],
        ['icon' => 'book-open', 'title' => 'Thought Leadership & Educational Content', 'body' => 'Many buyers need education before they’re ready to commit. Blogs, guides, white papers, case studies, research reports, and other long-form content help establish authority, answer questions, and support informed decision-making.'],
        ['icon' => 'shield',    'title' => 'Expert-Written & Expert-Reviewed Content', 'body' => 'Healthcare, finance, legal, and other YMYL industries require a higher standard of accuracy and credibility. We have a roster of subject matter experts across many industries who can write or review content that informs, educates, and builds trust—byline included.'],
        ['icon' => 'camera',    'title' => 'Visual Content & Design', 'body' => 'Complex ideas are easier to understand when they’re presented visually. We create infographics, diagrams, presentations, branded graphics, and other visual assets that help explain products, workflows, and value propositions.'],
        ['icon' => 'sparkle',   'title' => 'Interactive Content Experiences', 'body' => 'Calculators, assessments, quizzes, benchmarks, and other interactive tools help users evaluate solutions, understand potential outcomes, and engage more deeply with your brand.'],
    ],
    'mid_cta_text'      => 'Need help explaining a complex product? Schedule a discovery call today.',
    'popular_heading'   => 'Services Most Popular with SaaS and Digital Platforms',
    'popular'           => [
        ['title' => 'SaaS SEO Services', 'body' => 'Technical SEO, keyword research, content strategy, SEO audits, content optimization, and AEO support.'],
        ['title' => 'Product & Solution Pages', 'body' => 'Feature pages, solution pages, landing pages, comparison pages, and conversion-focused website copy.'],
        ['title' => 'Thought Leadership Content', 'body' => 'Blogs, articles, white papers, research reports, executive bylines, and long-form educational resources.'],
        ['title' => 'Case Studies & Customer Stories', 'body' => 'Success stories, implementation examples, customer interviews, and proof-of-concept content.'],
        ['title' => 'Expert-Written & Expert-Reviewed Content', 'body' => 'SME-bylined content for healthcare, finance, technology, and other YMYL industries, backed by subject matter expertise and editorial review.'],
        ['title' => 'Visual Content & Design', 'body' => 'Infographics, presentations, social media graphics, digital advertising creative, and branded visual assets.'],
        ['title' => 'Interactive Content Experiences', 'body' => 'ROI calculators, assessments, benchmarking tools, interactive maps, product selectors, and other engaging resources.'],
        ['title' => 'Photography & Video', 'body' => 'Product demonstrations, customer stories, executive interviews, event coverage, and branded video production.'],
    ],
    'why'               => [
        ['title' => 'All of the Services You Need Under One Roof', 'body' => 'SEO, content, design, photography, video, and paid advertising working together to support your growth strategy.'],
        ['title' => 'Human-Created. Expert-Led.', 'body' => 'Every project is developed by experienced professionals who understand how to communicate important, complex ideas clearly and accurately.'],
        ['title' => 'Built for Growth', 'body' => 'Whether you’re launching a new product, entering a new market, or expanding your content program, our team can scale alongside your business.'],
        ['title' => 'A True Extension of Your Team', 'body' => 'Work with dedicated SEO specialists, editorial teams, and creatives to reach your audience through multiple channels.'],
    ],
    'faqs'              => [
        ['q' => 'What is SaaS content marketing?', 'a' => 'SaaS content marketing uses blogs, guides, case studies, white papers, videos, and other online resources to educate potential customers and support the buying process.'],
        ['q' => 'Why is SEO important for SaaS companies?', 'a' => 'SEO helps software companies attract qualified prospects who are actively researching solutions, comparing alternatives, and evaluating products.'],
        ['q' => 'Can Stretch Creative create content for healthcare and fintech companies?', 'a' => 'Yes. We regularly create expert-written and expert-reviewed content for healthcare, fintech, technology, and other industries where accuracy and trust are critical.'],
        ['q' => 'Do you create case studies and white papers?', 'a' => 'Absolutely. We develop customer stories, research reports, white papers, executive thought leadership content, and other long-form assets.'],
        ['q' => 'Can you support product launches?', 'a' => 'Yes. We help SaaS companies create launch content, landing pages, product messaging, educational resources, and supporting creative assets.'],
    ],
    'final_heading'     => 'Ready to Get Started?',
    'final_text'        => 'Whether you need SaaS SEO services, thought leadership content, expert-reviewed articles, or a complete content strategy, Stretch Creative can help. Let’s talk about your SEO and content needs and what we can do to help you achieve your goals.',
],
```

IMPORTANT adaptation note: the existing ecommerce/agencies entries store `audiences` as plain strings. Task 4's template accepts both shapes — leave the existing two entries untouched.

- [ ] **Step 2: Run the seed + flush**

```bash
docker compose cp setup-industries.php wordpress:/var/www/html/setup-industries.php
docker compose exec -T wordpress wp eval-file /var/www/html/setup-industries.php --allow-root
docker compose exec -T wordpress wp rewrite flush --allow-root
```
Expected output includes `Created page: industries/service-providers` and `Created page: industries/saas` (+ two `Saved option:` lines). Run the eval-file a second time — expected: no-op messages, nothing created.

- [ ] **Step 3: Flip the two homepage links**

In `stretch-theme/page-home.php` Who-We-Serve cards: Local Service Providers link `/contact-stretch-creative/` → `/industries/service-providers/`; SaaS link `/contact-stretch-creative/` → `/industries/saas/` (closes AUD-036 fully).

- [ ] **Step 4: Verify**

```bash
export LC_ALL=C
for u in "/industries/service-providers/" "/industries/saas/"; do curl -s -o /tmp/ind-new.html -w "%{http_code} $u " "http://localhost:8888$u"; grep -c "ind-solution-card" /tmp/ind-new.html; done
curl -s "http://localhost:8888/?t=$(date +%s)" | grep -c "industries/service-providers\|industries/saas"
```
Expected: both 200 with >=5 solution cards; homepage contains both new URLs (count 2). Screenshot `/industries/saas/` — hero shows the SaaS H1.

- [ ] **Step 5: Commit**

```bash
git add setup-industries.php stretch-theme/page-home.php
git commit -m "feat(redesign): seed Service Providers + SaaS industry pages, link them from home (AUD-036 closed)"
```

---

### Task 6: Service-page copy rollout — Content Writing, SEO/AEO, Paid Advertising

**Files:**
- Modify: `setup-services.php` (the three entries in its `$services` array)
- Copy source: `design-reference/copy-doc.md` — Content Writing 1087-1397, SEO/AEO 1399-1670, Paid Advertising 2013-2276
- Test: curl assertions per page

**Interfaces:**
- Consumes: existing `stretch_service_{slug}` option schema exactly as `page-service.php` reads it (keys: `overline,h1,tagline,intro,stats[[num,suffix,label]|prop strings],problem_overline,problem_h2,problem_body[],solution_overline,solution_h2,solution_intro,solution_points[{title,body}],offerings_h2,offerings_intro,offerings[{title,body}],addons[{title,body}],cross_cta{heading,body,links[]},process_h2,process_intro,process[{title,body}],why[{title,body}],testimonials,faqs,cta{...}`). Open `setup-services.php` and `page-service.php` FIRST and mirror the existing ecommerce-content entry's exact key names — the authoritative schema is the code, not this list.
- Produces: updated options for slugs `content-writing-at-any-scale`, `seo_content_strategy_services`, `paid-advertising`.

- [ ] **Step 1: Map the doc onto the schema — Content Writing (`content-writing-at-any-scale`)**

Verbatim from doc lines 1094-1397, with these copy-doc directives applied:
- H1 `Content Writing at Any Scale`; tagline `High-quality content solves problems.`; intro = the two paragraphs at doc 1100-1106.
- Props/stat pills (doc 1114-1117): `No Minimums · No Long-Term Contracts · Dedicated Writing Team · Editorial Visibility` (render as prop strings, not counters).
- THE REALITY → problem section: h2 `We’re in strange times.` + the three paragraphs (doc 1125-1133).
- THE SOLUTION → h2 `We’re your strategic content-writing partner` + intro paragraph (doc 1141) + five solution_points (doc 1149-1175: quality-at-volume / consistent voice / AEO+SEO optimized / accuracy+integrity / hand-picked writers).
- **REMOVE the sentence** "Whether you need one piece or a thousand, quality never compromises." (doc directive at 1179) — grep the option data after seeding to prove it is gone.
- CAPABILITIES → offerings h2 `What we write` + intro (doc 1187) + all 13 offering items (doc 1191-1265, titles: Blog articles / Buying guides / Product & category page content / Service, industry, and location pages / Ebooks & white papers / Email & social content / Google Ads, banners, and landing pages / Website copy / User-generated content / Expert-written & expert-reviewed content / Thought leadership / Case studies / Optimizations and rewrites — bodies verbatim from those lines).
- **Selected Work strip: replace with Add-On Services** (doc directive at 1273): set this page's portfolio strip OFF by removing its entry from `stretch_get_portfolio_for_service()`'s map in `functions.php` (delete the `content-writing-at-any-scale` line) and add `addons`: SEO + Editorial / Budget Management / Content Loading with bodies from doc 1279-1293.
- cross_cta (doc 1297-1308): heading `Need more than written content?`, body doc 1299, links: SEO/AEO Services → `/seo_content_strategy_services/`, Interactive Content Marketing → `/services/bespoke-content-experience/`, Visual Content & Design → `/visual-content-and-design/` (Task 7 creates it — this task may temporarily point to `/graphic_design_services/` and Task 7 flips it; note which you chose in the commit message), Paid Advertising → `/paid-advertising/`.
- PROCESS (doc 1312-1350): h2 `How We Work` + intro + 5 steps (Consultation / Editorial selection / Calibration / Full-scale production / Ongoing collaboration).
- THE DIFFERENCE why cards (doc 1354-1378): 4 cards ending `A single point of contact`.
- Testimonials, FAQs, final CTA: **unchanged** (doc says "stays the same" at 1386-1394) — do not touch those keys.

- [ ] **Step 2: Map SEO/AEO (`seo_content_strategy_services`) — doc 1407-1670**

- H1 `SEO + AEO Strategy & Services` (retitle from "SEO Strategy & Services"); tagline `Get found today, stay visible tomorrow.`; intro doc 1413-1419.
- Props (doc 1427-1434, **fixes AUD-039's confusing stats**): `Technical SEO Expertise · AEO-Ready Strategies · Transparent Reporting · No Long-Term Contracts` + the line `From enterprise audits to SEO-Lite, you only pay for the services you need.` (doc 1438) as the stat-bar footnote.
- THE REALITY h2 `Search is evolving at light speed.` + paragraphs doc 1446-1458.
- THE SOLUTION h2 `SEO isn’t about chasing algorithms.` + intro doc 1466-1470 + 5 points (doc 1474-1500: strategies around your business / technical+content / today’s search experiences / long-term growth / data into action).
- CAPABILITIES `What we deliver` + intro doc 1508 + 8 offerings (doc 1512-1556: Technical SEO / Keyword research / SEO content strategy / Content briefs / On-page SEO / SEO audits / SEO and AEO content optimization / Performance tracking & reporting) + addon Budget management (doc 1560-1562).
- cross_cta `Need More Than SEO?` (doc 1568-1579): Content Writing / Interactive Content Marketing / Visual Content & Design / Paid Advertising.
- PROCESS 5 steps doc 1593-1619 (Discovery / Audit & Research / Strategy Development / Implementation / Ongoing Optimization).
- Why cards doc 1630-1650 (SEO built to scale / under one roof / Holistic SEO and AEO / Measurable Results).
- Testimonials/FAQs/final CTA unchanged (doc 1656-1666).

- [ ] **Step 3: Map Paid Advertising (`paid-advertising`) — doc 2021-2276**

- H1 `Paid Advertising Services`; tagline `Reach the right audience with campaigns built to perform.`; intro doc 2029.
- Props (doc 2037-2040): `Search, Shopping & Social Ads · Performance Tracking & Optimization · Ad Copywriting & Design · No Long-Term Contracts`.
- THE REALITY h2 `Competition isn’t getting any cheaper.` + doc 2050-2054. THE SOLUTION h2 `Effective campaigns don’t happen by accident.` + intro doc 2062-2066 + 5 points doc 2070-2096.
- CAPABILITIES `Advertising services we offer` + 8 offerings doc 2108-2152 + addons doc 2164-2178 (SEO & Content Strategy / Budget Management / CMS Loading).
- cross_cta doc 2182-2193. PROCESS 5 steps doc 2199-2231. Why cards doc 2237-2259. Testimonials/FAQs/final CTA unchanged (doc 2265-2275).

- [ ] **Step 4: Seed + verify**

```bash
docker compose cp setup-services.php wordpress:/var/www/html/setup-services.php
docker compose exec -T wordpress wp eval-file /var/www/html/setup-services.php --allow-root | tail -5
export LC_ALL=C
curl -s "http://localhost:8888/content-writing-at-any-scale/?t=$(date +%s)" -o /tmp/svc-cw.html
grep -c "High-quality content solves problems" /tmp/svc-cw.html          # expect 1
grep -c "quality never compromises" /tmp/svc-cw.html                     # expect 0 (removed line)
grep -c "svc-selected-work" /tmp/svc-cw.html                             # expect 0 (strip replaced)
grep -c "Content Loading" /tmp/svc-cw.html                               # expect >= 1 (addons)
curl -s "http://localhost:8888/seo_content_strategy_services/?t=$(date +%s)" -o /tmp/svc-seo.html
grep -c "SEO + AEO Strategy" /tmp/svc-seo.html                           # expect >= 1
grep -c "72%" /tmp/svc-seo.html                                          # expect 0 (AUD-039 stat gone)
grep -c "AEO-Ready Strategies" /tmp/svc-seo.html                         # expect 1
curl -s "http://localhost:8888/paid-advertising/?t=$(date +%s)" | grep -c "Competition isn’t getting any cheaper\|Competition isn&#8217;t getting any cheaper"   # expect 1
```
Second `wp eval-file` run = no-op. Also confirm testimonials/FAQs survived: `grep -c "svc-testimonial" /tmp/svc-cw.html` >= 1 and `grep -c "svc-accordion-trigger" /tmp/svc-cw.html` >= 3.

- [ ] **Step 5: Commit**

```bash
git add setup-services.php stretch-theme/functions.php
git commit -m "feat(redesign): new copy for Content Writing, SEO/AEO, Paid Advertising service pages (AUD-039)"
```

---

### Task 7: Combined Visual Content & Design page

**Files:**
- Modify: `setup-services.php` (new entry + page creation for slug `visual-content-and-design`, template `page-service.php`, top-level page)
- Modify: `stretch-theme/page-service.php` (two section anchors)
- Modify: `stretch-theme/functions.php` (`stretch_get_portfolio_for_service` map)
- Copy source: `design-reference/copy-doc.md` lines 1682-2010

**Interfaces:**
- Consumes: Task 6's schema knowledge; existing GD/video options for FAQ merge (`stretch_service_graphic_design_services`-style keys — read both current options with `wp option get` to extract their `faqs` arrays).
- Produces: page at `/visual-content-and-design/` with in-page anchors `#graphic-design` and `#photography-video` (Task 9's menu items and Task 10's redirects depend on BOTH the URL and these anchor ids).

- [ ] **Step 1: Add the seed entry**

New `$services` entry keyed `visual-content-and-design` (page title `Visual Content & Design`, created at root — mirror how existing top-level service pages are created in this script):
- H1 `Visual Content and Design`; tagline `Show your audience what words alone can’t.`; intro doc 1702-1706.
- Props (doc 1714-1717): `In-House Creative Team · Photography & Video Production · Graphic Design & Branding · From Concept Through Delivery`.
- THE REALITY h2 `First impressions happen fast.` + doc 1725-1737. THE SOLUTION h2 `Creative content changes the equation.` + intro doc 1747-1751 + 5 points doc 1755-1791 (design with purpose / brand consistent / in-house / assets that work everywhere / concept to completion).
- CAPABILITIES h2 `Creative Services` + intro doc 1799. Offerings in TWO groups (this drives the anchors): group A heading `Graphic Design` with 6 items (doc 1807-1839: Graphic Design / Infographics / Social Media Creative / Email & Digital Marketing Assets / Presentation & Sales Materials / Brand Support); group B heading `Videography & Photography` with 13 items (doc 1848-1916: Brand Stories / Corporate Video Services / Commercial Production / Social Media Content / Documentaries / Motion Graphics & Animation / Interviews / Pre-Production / Production / Post-Production / Video Interviewing / Product & Lifestyle Photography — count is 12 titled blocks + Social Media Content = 13 per doc). If the current schema has no group concept, add optional `offerings_groups[{anchor,heading,items[]}]` support to `page-service.php` rendering, falling back to flat `offerings` when absent.
- Add-On Services doc 1931-1949 (Creative Ideation / Budget Management / Copywriting). cross_cta doc 1953-1964 (SEO/AEO Services / Content Writing / Interactive Content Marketing / Paid Advertising).
- Why cards doc 1970-1992. Selected Work: map `visual-content-and-design` in `stretch_get_portfolio_for_service()` to the union of the old GD + video keys (`quickbooks,remitly,vicis,meyers-product,meyers-life,open-road,monster,nhl`) — work examples stay pending Cole's AUD-016 vetting (they are already live on the old pages; this is no new exposure).
- FAQs: MERGE the two old pages' `faqs` arrays (GD first, then video, dedupe identical questions). Testimonials: reuse the GD page's testimonials key.
- Final CTA h2 `Ready to Tell Your Story Visually?` (doc 2006) with the standard contact button.

- [ ] **Step 2: Anchors in the template**

In `page-service.php`, where offering groups render, emit `id="graphic-design"` on group A's section wrapper and `id="photography-video"` on group B's (only when `offerings_groups` is present, so other service pages are unaffected).

- [ ] **Step 3: Seed + verify**

```bash
docker compose cp setup-services.php wordpress:/var/www/html/setup-services.php
docker compose exec -T wordpress wp eval-file /var/www/html/setup-services.php --allow-root | tail -3
export LC_ALL=C
curl -s -o /tmp/vcd.html -w "%{http_code}\n" "http://localhost:8888/visual-content-and-design/"    # expect 200
grep -c 'id="graphic-design"' /tmp/vcd.html      # expect 1
grep -c 'id="photography-video"' /tmp/vcd.html   # expect 1
grep -c "Show your audience what words alone" /tmp/vcd.html   # expect 1
grep -c "svc-accordion-trigger" /tmp/vcd.html    # expect >= 5 (merged FAQs)
```
Also update Task 6's temporary cross_cta link if it pointed at `/graphic_design_services/` — flip to `/visual-content-and-design/` and re-seed.

- [ ] **Step 4: Commit**

```bash
git add setup-services.php stretch-theme/page-service.php stretch-theme/functions.php
git commit -m "feat(redesign): combined Visual Content & Design page with GD/photo-video anchors"
```

---

### Task 8: BCE heading optimization (Interactive Content Marketing)

**Files:**
- Modify: `stretch-theme/page-bespoke-content-experience.php` (H1/headings only), plus the page's Rank Math title/description via WP-CLI (no code)

**Interfaces:** none downstream. Doc directive at lines 1672-1680: optimize for "interactive content marketing"; keep BCE branding out of headings but alive in body copy.

- [ ] **Step 1: Retitle**

In the template: H1 becomes `Interactive Content Marketing` with the existing gradient-span treatment (put the span on `Marketing`); keep "Bespoke Content Experience" in the intro/body copy as the product name. Update the hero subtitle only if it duplicates the old H1 verbatim; otherwise leave body copy untouched.

```bash
docker compose exec -T wordpress wp post meta update 2992 rank_math_title "Interactive Content Marketing | Stretch Creative" --allow-root
docker compose exec -T wordpress wp post meta update 2992 rank_math_description "Calculators, quizzes, assessments, and interactive tools that turn visitors into engaged buyers. Stretch Creative builds bespoke content experiences that perform." --allow-root
```

- [ ] **Step 2: Verify + commit**

```bash
export LC_ALL=C
curl -s "http://localhost:8888/services/bespoke-content-experience/?t=$(date +%s)" -o /tmp/bce.html
grep -o "<title>[^<]*" /tmp/bce.html                       # expect Interactive Content Marketing | Stretch Creative
grep -c "<h1[^>]*>.*Interactive Content" /tmp/bce.html      # expect 1
grep -c "Bespoke Content Experience" /tmp/bce.html          # expect >= 1 (branding retained in body)
docker compose exec -T wordpress php -l /var/www/html/wp-content/themes/stretch-theme/page-bespoke-content-experience.php
git add stretch-theme/page-bespoke-content-experience.php
git commit -m "feat(redesign): retitle BCE page around Interactive Content Marketing (doc directive)"
```

---

### Task 9: Rebuild primary nav + footer menus (site-map structure)

**Files:**
- Create: `setup-menus.php` (repo root)
- Modify: `stretch-theme/assets/css/theme.css` (dropdown panel restyle + chevrons)
- Test: curl + browser assertions

**Interfaces:**
- Consumes: pages from Tasks 5 & 7 (all menu targets must 200 before this task runs); existing `header.php` (`wp_nav_menu` theme_location `primary`, depth 2 — unchanged) and footer menu locations (read `inc/theme-setup.php` `register_nav_menus` for the exact footer location slugs; the wizard's Step 4 shows the pattern for building them).
- Produces: WP menus `Primary Navigation` (location `primary`) and the footer menus, client-editable. Structure per copy-doc site map (lines 2495-2559).

- [ ] **Step 1: Write `setup-menus.php`**

```php
<?php
/**
 * Idempotent nav + footer menu builder (redesign Phase 4, per copy-doc site map).
 * Run: wp eval-file setup-menus.php
 */
if (!defined('WP_CLI') || !WP_CLI) { exit; }

function stretch_menu_rebuild($menu_name, $location, array $items) {
    $existing = wp_get_nav_menu_object($menu_name);
    if ($existing) {
        // Rebuild from scratch each run — the definition below is the source of truth.
        $old = wp_get_nav_menu_items($existing->term_id) ?: [];
        foreach ($old as $item) { wp_delete_post($item->ID, true); }
        $menu_id = $existing->term_id;
    } else {
        $menu_id = wp_create_nav_menu($menu_name);
    }
    if (is_wp_error($menu_id)) { WP_CLI::error("Menu {$menu_name}: " . $menu_id->get_error_message()); }

    $add = function ($menu_id, $title, $url, $parent = 0) {
        return wp_update_nav_menu_item($menu_id, 0, [
            'menu-item-title'     => $title,
            'menu-item-url'       => home_url($url),
            'menu-item-status'    => 'publish',
            'menu-item-parent-id' => $parent,
        ]);
    };
    foreach ($items as $item) {
        $parent_id = $add($menu_id, $item['title'], $item['url']);
        foreach ($item['children'] ?? [] as $child) {
            $add($menu_id, $child['title'], $child['url'], $parent_id);
        }
    }
    $locations = get_theme_mod('nav_menu_locations', []);
    $locations[$location] = $menu_id;
    set_theme_mod('nav_menu_locations', $locations);
    WP_CLI::log("  ✓ {$menu_name} → {$location} (" . count($items) . " top-level items)");
}

$primary = [
    ['title' => 'Solutions', 'url' => '/seo_content_strategy_services/', 'children' => [
        ['title' => 'SEO/AEO Services',              'url' => '/seo_content_strategy_services/'],
        ['title' => 'Interactive Content Marketing', 'url' => '/services/bespoke-content-experience/'],
        ['title' => 'Content Writing',               'url' => '/content-writing-at-any-scale/'],
        ['title' => 'Graphic Design',                'url' => '/visual-content-and-design/#graphic-design'],
        ['title' => 'Photography & Videography',     'url' => '/visual-content-and-design/#photography-video'],
        ['title' => 'Paid Advertising',              'url' => '/paid-advertising/'],
    ]],
    ['title' => 'Industries', 'url' => '/industries/ecommerce/', 'children' => [
        ['title' => 'Ecommerce',                 'url' => '/industries/ecommerce/'],
        ['title' => 'Agencies & Partners',       'url' => '/industries/agencies/'],
        ['title' => 'Service Providers',         'url' => '/industries/service-providers/'],
        ['title' => 'SaaS & Digital Platforms',  'url' => '/industries/saas/'],
    ]],
    ['title' => 'About Us', 'url' => '/about-stretch-creative/', 'children' => [
        ['title' => 'Our Story', 'url' => '/about-stretch-creative/'],
        ['title' => 'Our Team',  'url' => '/the-team/'],
    ]],
    ['title' => 'Our Work', 'url' => '/our-work/'],
    ['title' => 'Blog',     'url' => '/blog/'],
];
stretch_menu_rebuild('Primary Navigation', 'primary', $primary);

// Footer columns — match the registered footer locations in inc/theme-setup.php.
// Read that file first; the names below assume footer_solutions / footer_company /
// footer_connect (adjust to the actual registered slugs, and update page templates
// only if the location slugs differ — the wizard Step 4 shows the current wiring).
stretch_menu_rebuild('Footer — Solutions', 'footer_solutions', [
    ['title' => 'SEO/AEO Services',              'url' => '/seo_content_strategy_services/'],
    ['title' => 'Interactive Content Marketing', 'url' => '/services/bespoke-content-experience/'],
    ['title' => 'Content Writing',               'url' => '/content-writing-at-any-scale/'],
    ['title' => 'Visual Content & Design',       'url' => '/visual-content-and-design/'],
    ['title' => 'Paid Advertising',              'url' => '/paid-advertising/'],
]);
stretch_menu_rebuild('Footer — Industries', 'footer_industries', [
    ['title' => 'Ecommerce',                'url' => '/industries/ecommerce/'],
    ['title' => 'Agencies & Partners',      'url' => '/industries/agencies/'],
    ['title' => 'Service Providers',        'url' => '/industries/service-providers/'],
    ['title' => 'SaaS & Digital Platforms', 'url' => '/industries/saas/'],
]);
stretch_menu_rebuild('Footer — Company', 'footer_company', [
    ['title' => 'Our Story',  'url' => '/about-stretch-creative/'],
    ['title' => 'Our Team',   'url' => '/the-team/'],
    ['title' => 'Our Work',   'url' => '/our-work/'],
    ['title' => 'Pricing',    'url' => '/pricing/'],
    ['title' => 'Blog',       'url' => '/blog/'],
    ['title' => 'Contact Us', 'url' => '/contact-stretch-creative/'],
]);

WP_CLI::success('Menus rebuilt per site map.');
```
IMPORTANT: before running, open `inc/theme-setup.php` and `footer.php`. If only ONE or TWO footer locations exist, consolidate the three definitions above into the registered locations (Industries column merges into Solutions) and, if a location for industries is missing, register it in `inc/theme-setup.php` + add the column to `footer.php` mirroring the existing column markup.

- [ ] **Step 2: Restyle the dropdown panels (approved design)**

In `theme.css`, replace the existing `.sub-menu` visual styles (keep the Wave-A `:focus-within` + mobile-panel rules intact — they are behavior, not skin) with:
```css
.nav-links li.menu-item-has-children > a::after {
  content: ''; display: inline-block; width: 8px; height: 8px; margin-left: 7px;
  border-right: 1.5px solid currentColor; border-bottom: 1.5px solid currentColor;
  transform: rotate(45deg) translateY(-2px); transition: transform 0.3s ease;
}
.nav-links li.menu-item-has-children:hover > a::after,
.nav-links li.menu-item-has-children:focus-within > a::after { transform: rotate(225deg) translateY(-1px); }
.nav-links .sub-menu {
  min-width: 260px; background: rgba(26, 31, 46, 0.98);
  border: 1px solid rgba(255,255,255,0.09); border-radius: 14px;
  padding: 10px; box-shadow: 0 24px 60px rgba(0,0,0,0.4);
}
.nav-links .sub-menu::before {
  content: ''; position: absolute; top: 0; left: 14px; right: 14px; height: 2px;
  border-radius: 2px; background: linear-gradient(90deg, #8560A8, #5674B9, #448CCB, #00BFF3);
}
.nav-links .sub-menu a { display: block; padding: 12px 16px; border-radius: 9px; font-size: 13.5px; white-space: nowrap; transition: background 0.25s ease, color 0.25s ease, padding-left 0.25s ease; }
.nav-links .sub-menu a:hover, .nav-links .sub-menu a:focus-visible { background: rgba(133,96,168,0.18); color: #fff; padding-left: 22px; }
```
NO `backdrop-filter` on the panel (perf constraint). Verify the existing hover-bridge/gap rules still apply (a `::after` bridge or padding on the parent li — if absent, add `.nav-links li.menu-item-has-children { padding-bottom: 14px; margin-bottom: -14px; }`).

- [ ] **Step 3: Run + verify**

```bash
docker compose cp setup-menus.php wordpress:/var/www/html/setup-menus.php
docker compose exec -T wordpress wp eval-file /var/www/html/setup-menus.php --allow-root
export LC_ALL=C
curl -s "http://localhost:8888/?t=$(date +%s)" -o /tmp/nav.html
grep -o 'primaryMenu.*Contact' /tmp/nav.html | head -c 400
grep -c ">Industries<" /tmp/nav.html          # expect 1
grep -c ">About Us<" /tmp/nav.html            # expect 1
grep -c "visual-content-and-design/#graphic-design" /tmp/nav.html   # expect 1
grep -c ">Content Strategy<" /tmp/nav.html    # expect 0 (legacy item gone)
for u in $(grep -o 'href="http://localhost:8888[^"]*"' /tmp/nav.html | sed 's/href="http:\/\/localhost:8888//; s/"//' | sed 's/#.*//' | sort -u); do curl -s -o /dev/null -w "%{http_code} $u\n" "http://localhost:8888$u"; done
```
Expected: every nav URL 200 (or designed 301/302). Run eval-file twice — second run rebuilds to identical state (idempotent by definition; verify item counts equal). Browser check: dropdowns open on hover AND `:focus-within`; mobile panel shows sub-items inline (Wave-A behavior preserved).

- [ ] **Step 4: Commit**

```bash
git add setup-menus.php stretch-theme/assets/css/theme.css stretch-theme/inc/theme-setup.php stretch-theme/footer.php
git commit -m "feat(redesign): rebuild primary nav + footer menus per site map; premium dropdown panels (AUD-005/010)"
```

---

### Task 10: Redirects for retired GD/Video pages

**Files:**
- Modify: `stretch-theme/functions.php` (redirect block)
- WP-CLI: unpublish the two old pages

**Interfaces:** Consumes Task 7's live `/visual-content-and-design/`. Produces 301s that Task 14's battery asserts. NOTE: `is_page()` fires only for published pages — match on request path (audit lesson).

- [ ] **Step 1: Add to functions.php next to the existing legacy redirects**

```php
/**
 * Graphic Design + Video pages merged into /visual-content-and-design/ (redesign
 * Phase 3). Path-matched (not is_page) so the 301 survives unpublishing.
 */
add_action('template_redirect', 'stretch_redirect_merged_visual_pages', 1);
function stretch_redirect_merged_visual_pages() {
    $path = (string) parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
    if (preg_match('#^/graphic_design_services(/|$)#', $path)) {
        wp_safe_redirect(home_url('/visual-content-and-design/#graphic-design'), 301);
        exit;
    }
    if (preg_match('#^/video-content-services(/|$)#', $path)) {
        wp_safe_redirect(home_url('/visual-content-and-design/#photography-video'), 301);
        exit;
    }
}
```

- [ ] **Step 2: Unpublish + verify**

```bash
docker compose exec -T wordpress wp post update 21 --post_status=draft --allow-root   # graphic_design_services
docker compose exec -T wordpress wp post update 22 --post_status=draft --allow-root   # video-content-services
curl -s -o /dev/null -w "%{http_code} -> %{redirect_url}\n" "http://localhost:8888/graphic_design_services/"
curl -s -o /dev/null -w "%{http_code} -> %{redirect_url}\n" "http://localhost:8888/video-content-services/"
```
Expected: both `301 -> http://localhost:8888/visual-content-and-design/#...`. Note: `/content-strategy/` and the four `/stretch-creative-solutions/*` legacy pages are OUT OF SCOPE here — they wait on Cole's AUD-011 redirect-map decision.

- [ ] **Step 3: Commit**

```bash
git add stretch-theme/functions.php
git commit -m "feat(redesign): 301 retired GD/Video pages into the combined Visual page"
```

---

### Task 11: About + Team copy updates

**Files:**
- Modify: `stretch-theme/page-about.php`, `stretch-theme/page-team.php`
- Copy source: `design-reference/copy-doc.md` 2281-2437

**Interfaces:** none downstream. Structure of both templates is KEPT (they already carry the premium look); this is copy surgery only.

- [ ] **Step 1: page-about.php**

Verbatim swaps per doc 2289-2393: hero stays `Because Stories Matter` + subtitle (2293); `Founded on a Belief` paragraphs (2297-2303) — includes the "community of more than 200" quote line (2301); section `We’re less a vendor, more a strategic content partner` intro (2307) + 3 numbered differentiators (2311-2325) — **Flexible Engagements keeps the CURRENT sentence** (doc has a literal `from … to …` placeholder at 2319; spec decision: retain existing copy until Cole supplies the range); Values 4 cards (2331-2345); Process 6 steps verbatim (2353-2387); `Join Our Team` block + `Meet the Team →` link (2389-2393).

- [ ] **Step 2: page-team.php**

Doc 2397-2435: hero `Clever. Skilled. Inspired.` + subtitle (2401); roster UNTOUCHED (doc 2407: "stays the same"); `What We Look For` 4 traits verbatim (2413-2429 — note trait 1 body: "You love to tell a good story. …"); `Start Your Career with Stretch` + `Apply Now →` → `/contact-stretch-creative/` (2431-2435). Also fix the stroke-only LinkedIn glyph on `page-contact.php:488` if not already done by Task 12 — leave to Task 12.

- [ ] **Step 3: Verify + commit**

```bash
docker compose exec -T wordpress php -l /var/www/html/wp-content/themes/stretch-theme/page-about.php
docker compose exec -T wordpress php -l /var/www/html/wp-content/themes/stretch-theme/page-team.php
export LC_ALL=C
curl -s "http://localhost:8888/about-stretch-creative/?t=$(date +%s)" | grep -c "Because Stories Matter\|Founded on a Belief\|Truth & Transparency\|Truth &amp; Transparency"   # expect >= 3
curl -s "http://localhost:8888/the-team/?t=$(date +%s)" | grep -c "What We Look For\|Growth-Minded\|Start Your Career"                    # expect >= 3
git add stretch-theme/page-about.php stretch-theme/page-team.php
git commit -m "feat(redesign): About + Team copy per copy doc (placeholder range retained)"
```

---

### Task 12: Icon sweep — remaining flagged icons (AUD-037)

**Files:**
- Modify: `stretch-theme/page-blog-home.php` (2 hub icons), `stretch-theme/aeo-scanner.php` (1), `stretch-theme/page-contact.php` (LinkedIn fill), `stretch-theme/page-bespoke-content-experience.php` (3)

**Interfaces:** none. Audit Appendix A is the authority; home/solutions items were fixed in Task 2 (and page-solutions.php was deleted in Task 3); front-page-v2 items died with Task 3.

- [ ] **Step 1: Apply replacements (Lucide bodies, keep each site's existing svg attributes/classes)**

1. `page-blog-home.php:57` (seo hub icon — "constellation magnifier") → Lucide `search`: `<circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>`
2. `page-blog-home.php:69` (creative-dojo squiggle) → Lucide `brush`: `<path d="m9.06 11.9 8.07-8.06a2.85 2.85 0 1 1 4.03 4.03l-8.06 8.08"/><path d="M7.07 14.94c-1.66 0-3 1.35-3 3.02 0 1.33-2.5 1.52-2 2.02 1.08 1.1 2.49 2.02 4 2.02 2.2 0 4-1.8 4-4.04a3.01 3.01 0 0 0-3-3.02z"/>`
3. `aeo-scanner.php:1756` (clock labeling "Google AI Overview") → Lucide `sparkles`: `<path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z"/><path d="M20 3v4"/><path d="M22 5h-4"/>`
4. `page-contact.php:488` LinkedIn: change the svg to `fill="currentColor" stroke="none"` keeping the official path (brand glyphs are filled).
5. `page-bespoke-content-experience.php:1411` (mountain+pennant muddle) → Lucide `flag`: `<path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/><line x1="4" y1="22" x2="4" y2="15"/>`
6. `page-bespoke:1614` (diamond-star) → Lucide `gem`: `<path d="M6 3h12l4 6-10 13L2 9z"/><path d="M11 3 8 9l4 13 4-13-3-6"/><path d="M2 9h20"/>`
7. `page-bespoke:1726` (funnel+zoom collage) → Lucide `filter` alone: `<polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>`

- [ ] **Step 2: Verify + commit**

```bash
for f in page-blog-home.php aeo-scanner.php page-contact.php page-bespoke-content-experience.php; do docker compose exec -T wordpress php -l /var/www/html/wp-content/themes/stretch-theme/$f; done
export LC_ALL=C
curl -s "http://localhost:8888/blog/?t=$(date +%s)" -o /dev/null -w "blog %{http_code}\n"
curl -s "http://localhost:8888/blog/aeo/?t=$(date +%s)" -o /dev/null -w "hub %{http_code}\n"
git add stretch-theme/
git commit -m "fix(design): replace flagged AI-looking icons with Lucide equivalents (AUD-037)"
```
Screenshot `/blog/` hub cards region and eyeball the two new hub icons.

---

### Task 13: Deploy wiring for new seeds

**Files:**
- Modify: `Dockerfile` (COPY setup-menus.php; wizard-data COPY landed in Task 3)
- Modify: `docker-entrypoint-custom.sh` (append `/opt/setup-menus.php` to `SEED_SCRIPTS`)

**Interfaces:** mirrors the existing seed pattern exactly (guarded scripts run from /opt, hash-gated).

- [ ] **Step 1: Wire**

Dockerfile, after the existing setup COPYs: `COPY setup-menus.php /opt/setup-menus.php`. Entrypoint `SEED_SCRIPTS` array: add `/opt/setup-menus.php` as the LAST entry (menus rebuild after content exists). `setup-industries.php` and `setup-services.php` are already in the array — their Task 5/6/7 changes ride the same hash gate.

- [ ] **Step 2: Verify + commit**

```bash
bash -n docker-entrypoint-custom.sh && echo entrypoint OK
grep -c "setup-menus" Dockerfile docker-entrypoint-custom.sh    # expect 1 and 1
git add Dockerfile docker-entrypoint-custom.sh
git commit -m "chore(redesign): wire setup-menus into deploy seeds"
```

---

### Task 14: Full regression, push, production verification

**Files:** none (verification + release)

- [ ] **Step 1: Local full battery**

```bash
export LC_ALL=C
docker compose exec -T wordpress bash -c 'wp post list --post_type=page --post_status=publish --field=url --allow-root; wp term list category --field=url --allow-root' | while read url; do curl -s -o /dev/null -w "%{http_code} $url\n" "$url"; done | sort | uniq -c | sort -rn | head
# Expected: overwhelmingly 200; known 301/302 only (solutions→/, industries→/, gd/video→visual)
for u in "/blog/aeo/feed/" "/visual-content-and-design/" "/industries/service-providers/" "/industries/saas/"; do curl -s -o /dev/null -w "%{http_code} $u\n" "http://localhost:8888$u"; done
curl -s "http://localhost:8888/" | grep -c "pfx-hero"                      # expect >= 1
curl -s "http://localhost:8888/contact-stretch-creative/" | grep -c admin-post.php   # expect 1 (Wave A intact)
curl -s "http://localhost:8888/blog/aeo/" | grep -c "allorigins\|corsproxy\|codetabs" # expect 0
docker compose exec -T wordpress wp eval-file /var/www/html/setup-industries.php --allow-root | tail -2   # no-op
docker compose exec -T wordpress wp eval-file /var/www/html/setup-menus.php --allow-root | tail -2        # rebuild-to-identical
```
Screenshot sweep at 1440x900 AND 390x844 for `/`, `/industries/saas/`, `/visual-content-and-design/` — all render, no horizontal overflow at 390 (`document.documentElement.scrollWidth == 390` via the browser pane).

- [ ] **Step 2: Push + production watch**

```bash
git log origin/main..HEAD --oneline    # review the task commits
git push origin main
```
Then poll production (pattern from the incident runbook — background loop, 45s interval, REQUIRE `status=200` AND `pfx-hero>=1` for 6 consecutive reads; also assert `>Industries<` in the nav and `/visual-content-and-design/` returns 200). If production flaps: the entrypoint is crash-loop-proof (d985668) — read Render logs before any further push; do NOT stack speculative fixes.

- [ ] **Step 3: Update memory/project docs**

Mark the redesign shipped in the project docs (`docs/audits/...` execution-order section: redesign-sequenced tickets now DONE) and report to Cole with before/after screenshots and the standing decision list (AUD-011 legacy map, AUD-016 image permissions, AUD-038 watermark, ACF license, SMTP).

---

## Self-review (completed by plan author)

1. **Spec coverage:** shared kit ✓(T1) home ✓(T2) industry template ✓(T4) 2 new pages ✓(T5) service copy ✓(T6) Visual page + anchors ✓(T7) BCE ✓(T8) nav+footer ✓(T9) GD/video redirects ✓(T10) About/Team ✓(T11) icons ✓(T2+T12) dead templates ✓(T3) noscript/reduced-motion ✓(T1) deploy ✓(T13) rollout ✓(T14). Spec's "Featured Work on industry pages" = explicitly out of scope (deferred with AUD-016). Spec's redirect list beyond GD/video (content-strategy etc.) = blocked on Cole (noted in T10).
2. **Placeholder scan:** the `[COPY: keep existing]` blocks in T2 are carry-over instructions pointing at exact HEAD content, with a diff-verification step — not invented-content placeholders. Doc-line citations point at the in-repo `design-reference/copy-doc.md`. No TBDs remain.
3. **Type consistency:** `stretch_pfx_logo_marquee($compact)` (T1) used in T2/T4 ✓; icon slugs defined in T4 = slugs used in T5 data ✓ (`wrench,heart,sparkle,shield,briefcase,storefront,map-pin,monitor,chart,graduation,globe,search,layout,book-open,camera,file-text,target` all exist in T4's library); `pfx-` class names consistent across T1/T2/T4/T9; option keys in T5 match T4's reads; anchor ids in T7 = hrefs in T9/T10 ✓.
