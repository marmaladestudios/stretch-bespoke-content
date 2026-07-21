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
 * Option values: numeric => attachment ID (renders <img>); string => text logo label.
 */
function stretch_pfx_logo_marquee($compact = false) {
    $logos = get_option('stretch_client_logos', []);
    if (empty($logos) || !is_array($logos)) { return; }
    $items = '';
    foreach ($logos as $name => $val) {
        if (is_numeric($val)) {
            $url = wp_get_attachment_url((int) $val);
            if (!$url) { continue; }
            $items .= '<div class="pfx-logo-item"><img src="' . esc_url($url) . '" alt="' . esc_attr((string) $name) . '" loading="lazy"></div>';
        } else {
            $label = is_string($val) ? trim($val) : '';
            if ($label === '') { continue; }
            $items .= '<span class="pfx-logo-text">' . esc_html($label) . '</span>';
        }
    }
    if ($items === '') { return; }
    $class = $compact ? 'pfx-logos pfx-logos--compact' : 'pfx-logos';
    echo '<section class="' . esc_attr($class) . '" aria-label="Trusted Brands">';
    echo '<h2 class="pfx-reveal">Trusted by Leading Brands</h2>';
    echo '<div class="pfx-marquee pfx-reveal pfx-delay-1"><div class="pfx-marquee-track">';
    echo '<div class="pfx-marquee-group">' . $items . '</div>';
    echo '<div class="pfx-marquee-group" aria-hidden="true">' . $items . '</div>';
    echo '</div></div>';
    echo '</section>';
}
?>
<style id="stretch-pfx">
/* ============ PREMIUM FX KIT (pfx-) ============ */
:root {
  --ink: #1a1f2e; --ink-2: #252C3A; --ink-3: #1e2333;
  --purple: #8560A8; --indigo: #5674B9; --blue: #448CCB; --cyan: #00BFF3;
  --body: #4a5364; --body-strong: #3c4354; --muted: #7a8194;
  --ghost: #c3c8d4; --border: #e9e9f1;
  --light-1: #f9f9fb; --light-2: #f7f6fc; --light-3: #edf4fb;
}
.pfx-container { max-width: 1200px; margin: 0 auto; padding: 0 clamp(24px, 4vw, 40px); width: 100%; }
.gradient-text {
  background: linear-gradient(135deg, #8560A8 0%, #5674B9 30%, #448CCB 60%, #00BFF3 100%);
  -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; color: transparent;
}
.pfx-overline {
  font-family: 'Montserrat', sans-serif; font-size: 12px; font-weight: 600;
  letter-spacing: 3px; text-transform: uppercase; color: #00BFF3;
  display: block; margin-bottom: 18px;
}

/* Scroll progress */
.pfx-progress { position: fixed; top: 0; left: 0; width: 100%; height: 3px; z-index: 1100; pointer-events: none; }
.pfx-progress-fill { height: 100%; width: 0; background: linear-gradient(90deg, #8560A8, #5674B9, #448CCB, #00BFF3); transition: width 0.1s ease-out; }

/* Custom cursor — single cyan ring (design), lerps after the pointer; grows over interactive targets */
.pfx-cursor {
  position: fixed; top: 0; left: 0; width: 34px; height: 34px;
  border: 1.5px solid rgba(0,191,243,0.55); border-radius: 50%;
  pointer-events: none; z-index: 1101; transform: translate(-50%, -50%); opacity: 0;
  transition: width 0.25s ease, height 0.25s ease, border-color 0.25s ease, opacity 0.3s ease;
}
.pfx-cursor.active { width: 58px; height: 58px; border-color: rgba(0,191,243,0.9); }
@media (hover: none), (pointer: coarse), (max-width: 768px) { .pfx-cursor { display: none !important; } }

/* Reveals — fade up 40px, 0.7s ease; catch-up sweep + interval fallback in JS */
.pfx-reveal { opacity: 0; transform: translateY(40px); transition: opacity 0.7s ease, transform 0.7s ease; }
.pfx-reveal.visible { opacity: 1; transform: translateY(0); }
.pfx-reveal-left { opacity: 0; transform: translateX(-60px); transition: opacity 0.7s ease, transform 0.7s ease; }
.pfx-reveal-left.visible { opacity: 1; transform: translateX(0); }
.pfx-reveal-right { opacity: 0; transform: translateX(60px); transition: opacity 0.7s ease, transform 0.7s ease; }
.pfx-reveal-right.visible { opacity: 1; transform: translateX(0); }
.pfx-delay-1 { transition-delay: 0.1s; } .pfx-delay-2 { transition-delay: 0.2s; }
.pfx-delay-3 { transition-delay: 0.3s; } .pfx-delay-4 { transition-delay: 0.4s; }
.pfx-delay-5 { transition-delay: 0.5s; } .pfx-delay-6 { transition-delay: 0.6s; }

/* Angled divider (SVG variant — inner pages) */
.pfx-angle-divider { position: absolute; bottom: -1px; left: 0; right: 0; z-index: 2; pointer-events: none; line-height: 0; }
.pfx-angle-divider svg { display: block; width: 100%; height: 60px; }

/* Grain — STATIC (no animation: compositor cost > visual value) */
.pfx-grain-overlay { position: absolute; inset: 0; overflow: hidden; pointer-events: none; z-index: 0; }
.pfx-grain-overlay::before {
  content: ''; position: absolute; inset: -50%; width: 200%; height: 200%; opacity: 0.05;
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
  background-size: 128px 128px;
}

/* Cinematic grid hero */
.pfx-hero { position: relative; display: flex; align-items: center; background: linear-gradient(170deg, #1a1f2e 0%, #252C3A 40%, #1e2333 100%); overflow: hidden; }
.pfx-hero::before { content: ''; position: absolute; top: -50%; right: -20%; width: 80%; height: 150%; background: radial-gradient(ellipse at center, rgba(86,116,185,0.08) 0%, transparent 70%); pointer-events: none; }
.pfx-hero::after { content: ''; position: absolute; bottom: -30%; left: -10%; width: 60%; height: 80%; background: radial-gradient(ellipse at center, rgba(133,96,168,0.06) 0%, transparent 70%); pointer-events: none; }
.pfx-hero-mesh { position: absolute; inset: 0; pointer-events: none; z-index: 0; background: radial-gradient(ellipse at 20% 50%, rgba(133,96,168,0.06) 0%, transparent 50%), radial-gradient(ellipse at 80% 20%, rgba(0,191,243,0.04) 0%, transparent 50%), radial-gradient(ellipse at 50% 80%, rgba(86,116,185,0.05) 0%, transparent 50%); }
.pfx-hero-grid { position: absolute; inset: 0; pointer-events: none; z-index: 1; overflow: hidden; }
.pfx-grid-container { position: absolute; inset: -60px; display: grid; grid-template-columns: repeat(auto-fill, 60px); grid-auto-rows: 60px; transition: transform 0.3s ease-out; }
.pfx-grid-cell { border: 1px solid rgba(255,255,255,0.05); }
.pfx-grid-cell.colored { background: var(--cell-color); animation: pfx-cellPulse var(--cell-dur, 8s) ease-in-out var(--cell-delay, 0s) infinite; }
@keyframes pfx-cellPulse { 0%, 100% { opacity: 0.15; } 50% { opacity: 1; } }
.pfx-hero-grid::after { content: ''; position: absolute; inset: 0; z-index: 1; pointer-events: none; background: radial-gradient(ellipse 62% 58% at 50% 46%, rgba(26,31,46,0.95) 0%, rgba(26,31,46,0.55) 52%, rgba(26,31,46,0) 78%); }
.pfx-hero--left .pfx-hero-grid::after { background: radial-gradient(ellipse 62% 58% at 28% 46%, rgba(26,31,46,0.95) 0%, rgba(26,31,46,0.55) 52%, rgba(26,31,46,0) 78%); }

/* Buttons */
.pfx-btn-primary {
  display: inline-block; font-family: 'Poppins', sans-serif; font-size: 16px; font-weight: 500;
  color: #fff; background: linear-gradient(135deg, #8560A8, #5674B9);
  padding: 18px 44px; border-radius: 6px; text-decoration: none; letter-spacing: 0.2px;
  transition: box-shadow 0.35s ease; box-shadow: 0 10px 28px rgba(133,96,168,0.35);
  position: relative; overflow: hidden; cursor: pointer; border: none; white-space: nowrap;
}
.pfx-btn-primary::before { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, #5674B9, #00BFF3); opacity: 0; transition: opacity 0.35s ease; border-radius: 6px; }
.pfx-btn-primary:hover { box-shadow: 0 14px 36px rgba(0,191,243,0.35); }
.pfx-btn-primary:hover::before { opacity: 1; }
.pfx-btn-primary span { position: relative; z-index: 1; }
.pfx-btn-primary:focus-visible, .pfx-btn-outline:focus-visible { outline: 2px solid #00BFF3; outline-offset: 2px; }
.pfx-btn-outline { display: inline-block; font-family: 'Poppins', sans-serif; font-size: 16px; font-weight: 500; color: #fff; border: 1px solid rgba(255,255,255,0.35); padding: 16px 40px; border-radius: 6px; text-decoration: none; transition: background 0.3s ease, border-color 0.3s ease; white-space: nowrap; }
.pfx-btn-outline:hover { background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.6); }

/* Animated accent bar — mirrored stops sliding 0%->200%, linear */
.pfx-accent-bar { height: 4px; background: linear-gradient(90deg, #8560A8, #5674B9, #448CCB, #00BFF3, #448CCB, #5674B9, #8560A8); background-size: 200% 100%; animation: pfx-gradientSlide 6.5s linear infinite; }
@keyframes pfx-gradientSlide { from { background-position: 0% 0; } to { background-position: 200% 0; } }

/* Hover sweep bars — pure CSS */
.pfx-sweep { position: relative; overflow: hidden; }
.pfx-sweep-bar { position: absolute; background: linear-gradient(90deg, #8560A8, #448CCB, #00BFF3); transition: 0.45s ease; }
.pfx-sweep-bar--top { top: 0; left: 0; height: 4px; width: 0; }
.pfx-sweep:hover .pfx-sweep-bar--top { width: 100%; }
.pfx-sweep-bar--left { left: 0; top: 0; width: 4px; height: 0; background: linear-gradient(180deg, #8560A8, #00BFF3); }
.pfx-sweep:hover .pfx-sweep-bar--left { height: 100%; }

/* Rotating gradient-border CTA card */
@property --pfx-border-angle { syntax: '<angle>'; initial-value: 0deg; inherits: false; }
@keyframes pfx-borderSpin { to { --pfx-border-angle: 360deg; } }
.pfx-gradient-card {
  position: relative; border-radius: 20px; padding: 2px;
  background: conic-gradient(from var(--pfx-border-angle), #8560A8, #5674B9, #448CCB, #00BFF3, #448CCB, #5674B9, #8560A8);
  animation: pfx-borderSpin 19s linear infinite;
  box-shadow: 0 20px 60px rgba(26,31,46,0.12), 0 0 32px rgba(133,96,168,0.12), 0 0 64px rgba(0,191,243,0.06);
}
.pfx-gradient-card-inner { border-radius: 18px; background: #fff; padding: 64px 56px; text-align: center; }
.pfx-gradient-card-inner.dark { background: #1e2333; }

/* Stats bar */
.pfx-stats-bar { background: #1a1f2e; padding: 72px 0; position: relative; overflow: hidden; }
.pfx-stats-bar--ink2 { background: #252C3A; }
.pfx-stats-inner { display: grid; grid-template-columns: repeat(auto-fit, minmax(190px, 1fr)); gap: 40px; text-align: center; position: relative; z-index: 1; }
.pfx-stat-number { font-family: 'Poppins', sans-serif; font-size: clamp(38px, 4vw, 54px); font-weight: 600; color: #fff; line-height: 1; letter-spacing: -1px; }
.pfx-stat-number .pfx-suffix { color: #00BFF3; }
.pfx-stat-label { font-family: 'Assistant', sans-serif; font-size: 15px; font-weight: 300; color: rgba(255,255,255,0.6); margin-top: 10px; }

/* Logo marquee */
.pfx-logos { background: #fff; padding: 70px 0 64px; overflow: hidden; position: relative; }
.pfx-logos h2 { font-family: 'Montserrat', sans-serif; font-size: 12px; font-weight: 600; letter-spacing: 3px; text-transform: uppercase; color: #8a90a0; text-align: center; margin: 0 0 36px; }
.pfx-logos--compact { padding: 56px 0 50px; }
.pfx-logos--compact h2 { margin-bottom: 32px; }
.pfx-marquee { position: relative; -webkit-mask-image: linear-gradient(90deg, transparent, #000 12%, #000 88%, transparent); mask-image: linear-gradient(90deg, transparent, #000 12%, #000 88%, transparent); }
.pfx-marquee-track { display: flex; width: max-content; animation: pfx-marqueeScroll 38s linear infinite; }
.pfx-marquee:hover .pfx-marquee-track { animation-play-state: paused; }
@keyframes pfx-marqueeScroll { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
.pfx-marquee-group { display: flex; align-items: center; gap: 72px; padding-right: 72px; }
.pfx-logo-item { flex: 0 0 auto; }
.pfx-logo-item img { height: 34px; width: auto; filter: grayscale(100%); opacity: 0.55; transition: filter 0.4s ease, opacity 0.4s ease, transform 0.4s ease; }
.pfx-logos--compact .pfx-logo-item img { height: 28px; }
.pfx-logo-item img:hover { filter: grayscale(0%); opacity: 1; transform: translateY(-2px); }
.pfx-logo-text { font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 19px; color: #b6bcc8; letter-spacing: 0.4px; white-space: nowrap; transition: color 0.3s ease; cursor: default; }
.pfx-logo-text:hover { color: #448CCB; }

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
  .pfx-grid-cell.colored, .pfx-gradient-card, .pfx-accent-bar, .pfx-marquee-track { animation: none !important; }
  .pfx-reveal, .pfx-reveal-left, .pfx-reveal-right { opacity: 1 !important; transform: none !important; transition: none !important; }
  .pfx-sweep-bar { transition: none !important; }
  .pfx-cursor { display: none !important; }
  html { scroll-behavior: auto !important; }
}

/* Responsive */
@media (max-width: 768px) { .pfx-gradient-card-inner { padding: 44px 28px; } }
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

  /* Custom cursor — single cyan ring, lerp 0.2 */
  if (!isTouchDevice && !reducedMotion && window.innerWidth > 768) {
    var cursor = document.createElement('div'); cursor.className = 'pfx-cursor';
    document.body.appendChild(cursor);
    var cx = -100, cy = -100, ringX = -100, ringY = -100;
    document.addEventListener('mousemove', function (e) {
      cx = e.clientX; cy = e.clientY; cursor.style.opacity = '1';
    }, { passive: true });
    (function animateRing() {
      ringX += (cx - ringX) * 0.2; ringY += (cy - ringY) * 0.2;
      cursor.style.transform = 'translate(' + ringX + 'px,' + ringY + 'px) translate(-50%,-50%)';
      requestAnimationFrame(animateRing);
    })();
    document.addEventListener('mouseover', function (e) {
      if (e.target.closest && e.target.closest('a, button, summary, .pfx-tilt')) cursor.classList.add('active');
    });
    document.addEventListener('mouseout', function (e) {
      if (e.target.closest && e.target.closest('a, button, summary, .pfx-tilt')) cursor.classList.remove('active');
    });
  }

  /* Reveal: IO (threshold 0.12) + in-view-on-load + scroll catch-up sweep + hidden-tab interval fallback */
  var revealSel = '.pfx-reveal, .pfx-reveal-left, .pfx-reveal-right';
  var revealPendingSel = '.pfx-reveal:not(.visible), .pfx-reveal-left:not(.visible), .pfx-reveal-right:not(.visible)';
  var revealObserver = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) { entry.target.classList.add('visible'); revealObserver.unobserve(entry.target); }
    });
  }, { threshold: 0.12 });
  document.querySelectorAll(revealSel).forEach(function (el) {
    var r = el.getBoundingClientRect();
    if (r.top < window.innerHeight * 0.9) { el.classList.add('visible'); return; } // in view on load — no flash
    revealObserver.observe(el);
  });
  var revealRaf = 0;
  function revealSweep() {
    revealRaf = 0;
    var vh = window.innerHeight;
    document.querySelectorAll(revealPendingSel).forEach(function (el) {
      if (el.getBoundingClientRect().top < vh) { el.classList.add('visible'); revealObserver.unobserve(el); }
    });
  }
  window.addEventListener('scroll', function () { if (!revealRaf) revealRaf = requestAnimationFrame(revealSweep); }, { passive: true });
  var revealFallback = setInterval(function () {
    var pending = document.querySelectorAll(revealPendingSel);
    if (!pending.length) { clearInterval(revealFallback); return; }
    var vh = window.innerHeight;
    if (vh === 0 || document.hidden) { pending.forEach(function (el) { el.classList.add('visible'); }); return; }
    pending.forEach(function (el) {
      var r = el.getBoundingClientRect();
      if (r.top < vh - 40 && r.bottom > 0) el.classList.add('visible');
    });
  }, 400);

  /* Grid hero generation + parallax (±14px) */
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
    var colors = ['rgba(133,96,168,0.13)', 'rgba(86,116,185,0.13)', 'rgba(68,140,203,0.13)', 'rgba(0,191,243,0.13)'];
    var coloredIndices = new Set();
    while (coloredIndices.size < coloredCount) coloredIndices.add(Math.floor(Math.random() * totalCells));
    var fragment = document.createDocumentFragment();
    for (var i = 0; i < totalCells; i++) {
      var cell = document.createElement('div');
      cell.className = 'pfx-grid-cell';
      if (coloredIndices.has(i)) {
        cell.classList.add('colored');
        cell.style.setProperty('--cell-color', colors[Math.floor(Math.random() * colors.length)]);
        cell.style.setProperty('--cell-dur', (5 + Math.random() * 7).toFixed(1) + 's');
        cell.style.setProperty('--cell-delay', (Math.random() * 6).toFixed(1) + 's');
      }
      fragment.appendChild(cell);
    }
    gridContainer.appendChild(fragment);
    if (!isTouchDevice && !reducedMotion && window.innerWidth > 768) {
      heroSection.addEventListener('mousemove', function (e) {
        var rect = heroSection.getBoundingClientRect();
        var mx = ((e.clientX - rect.left) / rect.width - 0.5) * 2;
        var my = ((e.clientY - rect.top) / rect.height - 0.5) * 2;
        gridContainer.style.transform = 'translate(' + (mx * 14).toFixed(1) + 'px, ' + (my * 14).toFixed(1) + 'px)';
      }, { passive: true });
      heroSection.addEventListener('mouseleave', function () { gridContainer.style.transform = 'translate(0, 0)'; });
    }
  });

  /* Counters — HTML ships the FINAL value (AUD-026); JS animates from 0, 1600ms, 1-(1-p)^3 */
  function animateCount(el) {
    var target = parseFloat(el.dataset.target);
    if (isNaN(target)) return;
    var duration = 1600, start = performance.now();
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
  }, { threshold: 0.5 });
  document.querySelectorAll('.pfx-stats-bar').forEach(function (bar) { countObserver.observe(bar); });

  /* Grain injection */
  document.querySelectorAll('[data-grain]').forEach(function (section) {
    if (window.getComputedStyle(section).position === 'static') section.style.position = 'relative';
    var grain = document.createElement('div');
    grain.className = 'pfx-grain-overlay';
    section.insertBefore(grain, section.firstChild);
  });

  /* 3D tilt — perspective(900px), rotateX/Y up to ±4°, no translateY, reset 0.4s */
  if (!isTouchDevice && !reducedMotion && window.innerWidth > 768) {
    document.querySelectorAll('.pfx-tilt').forEach(function (card) {
      card.addEventListener('mousemove', function (e) {
        var rect = card.getBoundingClientRect();
        var px = (e.clientX - rect.left) / rect.width - 0.5;
        var py = (e.clientY - rect.top) / rect.height - 0.5;
        card.style.transform = 'perspective(900px) rotateX(' + (-py * 4).toFixed(2) + 'deg) rotateY(' + (px * 4).toFixed(2) + 'deg)';
        card.style.transition = 'none';
      }, { passive: true });
      card.addEventListener('mouseleave', function () {
        card.style.transform = '';
        card.style.transition = 'transform 0.4s ease';
      });
    });
  }

  /* Magnetic buttons — primary only; translate(dx*0.1, dy*0.16), spring back 0.35s */
  if (!isTouchDevice && !reducedMotion) {
    document.querySelectorAll('.pfx-btn-primary').forEach(function (btn) {
      btn.addEventListener('mousemove', function (e) {
        var rect = btn.getBoundingClientRect();
        var dx = e.clientX - (rect.left + rect.width / 2);
        var dy = e.clientY - (rect.top + rect.height / 2);
        btn.style.transform = 'translate(' + (dx * 0.1) + 'px, ' + (dy * 0.16) + 'px)';
      }, { passive: true });
      btn.addEventListener('mouseleave', function () {
        btn.style.transition = 'transform 0.35s';
        btn.style.transform = '';
        setTimeout(function () { btn.style.transition = ''; }, 360);
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
