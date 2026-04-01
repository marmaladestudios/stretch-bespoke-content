# Stretch Creative WordPress Theme — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Build a custom ACF-powered WordPress theme for Stretch Creative based on the approved landing page prototype, with 13 flexible content section types and full responsive design.

**Architecture:** Classic WordPress theme on Underscores scaffold. ACF Flexible Content for page sections, WordPress Customizer for global brand settings, vanilla JS for interactions. No page builders, no jQuery.

**Tech Stack:** WordPress, PHP 8+, ACF Pro, CSS custom properties, vanilla JavaScript, Google Fonts (Poppins, Assistant, Montserrat)

**Reference:** Design spec at `docs/superpowers/specs/2026-04-01-wordpress-theme-design.md`. Prototype at `bespoke-content-experience.html`.

---

## File Map

```
stretch-theme/
├── style.css                          # Task 1 — Theme declaration header
├── screenshot.png                     # Task 1 — Theme preview (placeholder)
├── functions.php                      # Task 3 — Master setup, requires inc/ files
├── header.php                         # Task 5 — Fixed nav, skip-to-content, mobile menu
├── footer.php                         # Task 6 — Multi-column footer
├── index.php                          # Task 13 — Fallback template
├── front-page.php                     # Task 13 — Homepage (ACF flexible content loop)
├── page.php                           # Task 13 — Standard page (ACF flexible content loop)
├── single.php                         # Task 14 — Blog post
├── archive.php                        # Task 14 — Blog archive with filters
├── search.php                         # Task 15 — Search results
├── 404.php                            # Task 15 — Not found
├── page-portal.php                    # Task 15 — Future portal placeholder
├── assets/
│   ├── css/
│   │   ├── theme.css                  # Task 2 — Full design system
│   │   └── editor-style.css           # Task 16 — Gutenberg editor styles
│   ├── js/
│   │   └── theme.js                   # Task 7 — All interactions
│   └── images/                        # Static assets
├── template-parts/
│   └── sections/
│       ├── hero.php                   # Task 9
│       ├── content-block.php          # Task 9
│       ├── pull-quote-banner.php      # Task 9
│       ├── cta-section.php            # Task 9
│       ├── card-grid.php              # Task 10
│       ├── process-steps.php          # Task 10
│       ├── accordion-faq.php          # Task 10
│       ├── logo-carousel.php          # Task 11
│       ├── testimonials.php           # Task 11
│       ├── image-text.php             # Task 11
│       ├── team-grid.php              # Task 12
│       ├── contact-block.php          # Task 12
│       └── blog-preview.php           # Task 12
├── acf-json/                          # ACF auto-save directory
│   └── .gitkeep                       # Task 1
└── inc/
    ├── theme-setup.php                # Task 3 — Menus, supports, image sizes
    ├── customizer.php                 # Task 4 — Customizer panels + CSS output
    └── acf-fields.php                 # Task 8 — ACF field group registration
```

---

### Task 1: Theme Scaffold

**Files:**
- Create: `stretch-theme/style.css`
- Create: `stretch-theme/acf-json/.gitkeep`
- Create directory structure

- [ ] **Step 1: Create theme directory structure**

```bash
mkdir -p stretch-theme/{assets/{css,js,images},template-parts/sections,acf-json,inc}
```

- [ ] **Step 2: Create style.css (theme declaration)**

Create `stretch-theme/style.css`:

```css
/*
Theme Name: Stretch Creative
Theme URI: https://stretchcreative.co
Author: Stretch Creative
Author URI: https://stretchcreative.co
Description: Custom ACF-powered theme for Stretch Creative. Built from the Bespoke Content Experience prototype.
Version: 1.0.0
Requires at least: 6.0
Requires PHP: 8.0
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: stretch
*/
```

- [ ] **Step 3: Create .gitkeep for acf-json**

```bash
touch stretch-theme/acf-json/.gitkeep
```

- [ ] **Step 4: Commit**

```bash
git add stretch-theme/
git commit -m "feat: scaffold stretch-theme directory structure"
```

---

### Task 2: Design System CSS

**Files:**
- Create: `stretch-theme/assets/css/theme.css`

Extract all styles from the prototype (`bespoke-content-experience.html` lines 11-934) into the theme stylesheet, converting hardcoded colors to CSS custom properties.

- [ ] **Step 1: Create theme.css with CSS custom properties and reset**

Create `stretch-theme/assets/css/theme.css`:

```css
/* ==========================================================================
   STRETCH CREATIVE THEME — Design System
   Extracted from bespoke-content-experience.html prototype
   ========================================================================== */

/* ===== CSS CUSTOM PROPERTIES ===== */
:root {
  --color-purple: #8560A8;
  --color-purple-hover: #74509a;
  --color-blue: #5674B9;
  --color-mid-blue: #448CCB;
  --color-cyan: #00BFF3;
  --color-dark: #252C3A;
  --color-dark-alt: #282829;
  --color-body: #323A51;
  --color-light-bg: #f9f9fb;
  --color-white: #ffffff;

  --font-heading: 'Poppins', sans-serif;
  --font-body: 'Assistant', sans-serif;
  --font-nav: 'Montserrat', sans-serif;
  --font-size-base: 18px;
  --line-height-base: 1.6;

  --container-width: 1100px;
  --container-padding: 28px;
  --section-padding: 100px;
  --section-padding-mobile: 72px;

  --bp-tablet: 960px;
  --bp-mobile: 768px;
  --bp-small: 480px;
}

/* ===== RESET & BASE ===== */
*, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
html { scroll-behavior: smooth; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }
body {
  font-family: var(--font-body);
  font-weight: 300;
  font-size: var(--font-size-base);
  line-height: var(--line-height-base);
  color: var(--color-body);
  background: var(--color-white);
  overflow-x: hidden;
}
img { max-width: 100%; display: block; }
a { text-decoration: none; color: inherit; }

/* ===== LAYOUT ===== */
.container { max-width: var(--container-width); margin: 0 auto; padding: 0 var(--container-padding); }
section { width: 100%; position: relative; }

/* ===== SKIP TO CONTENT (A11Y) ===== */
.skip-to-content {
  position: absolute;
  left: -9999px;
  top: 0;
  z-index: 9999;
  padding: 12px 24px;
  background: var(--color-purple);
  color: #fff;
  font-family: var(--font-body);
  font-size: 16px;
}
.skip-to-content:focus {
  left: 0;
}

/* ===== TYPOGRAPHY ===== */
.overline {
  font-family: var(--font-heading);
  font-size: 14px;
  font-weight: 500;
  letter-spacing: 0.5px;
  margin-bottom: 16px;
  display: block;
}
h1, h2, h3 { font-family: var(--font-heading); }
h2 { font-size: 38px; font-weight: 500; color: var(--color-body); line-height: 1.15; margin-bottom: 32px; }
h3 { font-size: 22px; font-weight: 600; color: var(--color-purple); line-height: 1.4; margin-bottom: 10px; }
p { margin-bottom: 24px; }
p:last-child { margin-bottom: 0; }

/* ===== BUTTONS ===== */
.btn-primary {
  display: inline-block;
  background: var(--color-purple);
  color: #fff;
  font-family: var(--font-body);
  font-size: 17px;
  font-weight: 400;
  padding: 16px 36px;
  border: none;
  border-radius: 0;
  cursor: pointer;
  transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
  position: relative;
  overflow: hidden;
}
.btn-primary::after {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, rgba(255,255,255,0.15), transparent);
  transform: translateX(-100%);
  transition: transform 0.5s ease;
}
.btn-primary:hover {
  background: var(--color-purple-hover);
  transform: translateY(-2px);
  box-shadow: 0 8px 30px rgba(133, 96, 168, 0.35);
}
.btn-primary:hover::after { transform: translateX(100%); }

.btn-white {
  display: inline-block;
  background: #fff;
  color: var(--color-purple);
  font-family: var(--font-body);
  font-size: 17px;
  font-weight: 400;
  padding: 16px 36px;
  border: none;
  border-radius: 0;
  cursor: pointer;
  transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
}
.btn-white:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 30px rgba(255,255,255,0.3);
}

/* Focus styles for accessibility */
.btn-primary:focus-visible,
.btn-white:focus-visible {
  outline: 3px solid var(--color-cyan);
  outline-offset: 2px;
}

/* ===== SCROLL REVEAL ===== */
.reveal {
  opacity: 0;
  transform: translateY(32px);
  transition: opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1), transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}
.reveal.visible { opacity: 1; transform: translateY(0); }
.reveal-delay-1 { transition-delay: 0.1s; }
.reveal-delay-2 { transition-delay: 0.2s; }
.reveal-delay-3 { transition-delay: 0.3s; }
.reveal-delay-4 { transition-delay: 0.4s; }
.reveal-delay-5 { transition-delay: 0.5s; }
.reveal-delay-6 { transition-delay: 0.6s; }

@media (prefers-reduced-motion: reduce) {
  .reveal { opacity: 1; transform: none; transition: none; }
  .reveal-delay-1, .reveal-delay-2, .reveal-delay-3,
  .reveal-delay-4, .reveal-delay-5, .reveal-delay-6 { transition-delay: 0s; }
  @keyframes meshFloat { 0%, 100% { transform: none; } }
  @keyframes shapeFloat { 0%, 100% { transform: none; } }
  @keyframes gradientSlide { 0%, 100% { background-position: 0% 50%; } }
  @keyframes fadeUp { from, to { opacity: 1; transform: none; } }
}

/* ===== NAV ===== */
.site-nav {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 100;
  padding: 20px 0;
  transition: all 0.4s ease;
}
.site-nav.scrolled {
  background: rgba(37, 44, 58, 0.95);
  backdrop-filter: blur(12px);
  -webkit-backdrop-filter: blur(12px);
  padding: 14px 0;
  box-shadow: 0 4px 30px rgba(0,0,0,0.15);
}
.site-nav .container { display: flex; justify-content: space-between; align-items: center; }
.site-nav .logo { display: block; line-height: 0; }
.site-nav .logo img { height: 40px; width: auto; }
.nav-toggle { display: none; background: none; border: none; cursor: pointer; padding: 8px; }
.nav-toggle span { display: block; width: 24px; height: 2px; background: #fff; margin: 5px 0; transition: 0.3s; }
.nav-links { display: flex; list-style: none; gap: 32px; align-items: center; }
.nav-links a {
  font-family: var(--font-nav);
  font-size: 15px;
  font-weight: 400;
  color: #fff;
  transition: opacity 0.2s;
}
.nav-links a:hover { opacity: 0.8; }
.nav-links a:focus-visible { outline: 2px solid var(--color-cyan); outline-offset: 2px; }
.nav-cta { padding: 10px 24px !important; font-size: 15px !important; }

/* Mobile menu */
.nav-links.open {
  display: flex;
  flex-direction: column;
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  width: 280px;
  background: var(--color-dark);
  padding: 80px 28px 28px;
  gap: 20px;
  z-index: 200;
  box-shadow: -4px 0 30px rgba(0,0,0,0.3);
}
.nav-toggle.active span:nth-child(1) { transform: rotate(45deg) translate(5px, 5px); }
.nav-toggle.active span:nth-child(2) { opacity: 0; }
.nav-toggle.active span:nth-child(3) { transform: rotate(-45deg) translate(5px, -5px); }

/* ===== SECTION BACKGROUNDS ===== */
.section-white { background: var(--color-white); padding: var(--section-padding) 0; }
.section-white .overline { color: var(--color-purple); }
.section-light { background: var(--color-light-bg); padding: var(--section-padding) 0; }
.section-light .overline { color: var(--color-purple); }
.section-dark {
  background: var(--color-dark-alt);
  padding: var(--section-padding) 0;
  position: relative;
  overflow: hidden;
}
.section-dark::before {
  content: '';
  position: absolute;
  top: -200px;
  right: -200px;
  width: 600px;
  height: 600px;
  background: radial-gradient(circle, rgba(133, 96, 168, 0.08), transparent 70%);
  pointer-events: none;
}
.section-dark::after {
  content: '';
  position: absolute;
  bottom: -150px;
  left: -150px;
  width: 500px;
  height: 500px;
  background: radial-gradient(circle, rgba(0, 191, 243, 0.06), transparent 70%);
  pointer-events: none;
}
.section-dark .container { position: relative; z-index: 1; }
.section-dark .overline {
  color: rgba(255,255,255,0.45);
  text-transform: uppercase;
  letter-spacing: 2px;
  font-size: 13px;
}
.section-dark h2 { color: #fff; }
.section-purple {
  background: var(--color-purple);
  padding: var(--section-padding) 0;
  position: relative;
  overflow: hidden;
}
.section-compact { padding: 60px 0; }
.section-no-padding { padding: 0; }

.section-divider {
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(133, 96, 168, 0.15) 20%, rgba(0, 191, 243, 0.15) 80%, transparent);
}

/* ===== HERO ===== */
.hero {
  position: relative;
  background: var(--color-dark);
  overflow: hidden;
  padding: 200px 0 140px;
  min-height: 85vh;
  display: flex;
  align-items: center;
}
.hero::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(160deg, rgba(86, 116, 185, 0.4), var(--color-cyan) 80%);
  z-index: 1;
}
.hero-mesh {
  position: absolute;
  inset: 0;
  z-index: 0;
  opacity: 0.12;
  background:
    radial-gradient(ellipse 600px 600px at 20% 50%, var(--color-purple), transparent),
    radial-gradient(ellipse 500px 500px at 70% 30%, var(--color-cyan), transparent),
    radial-gradient(ellipse 400px 400px at 80% 80%, var(--color-blue), transparent);
  animation: meshFloat 12s ease-in-out infinite;
}
@keyframes meshFloat {
  0%, 100% { transform: scale(1) translate(0, 0); }
  33% { transform: scale(1.05) translate(20px, -15px); }
  66% { transform: scale(0.97) translate(-15px, 10px); }
}

.hero-shapes { position: absolute; inset: 0; z-index: 1; overflow: hidden; pointer-events: none; }
.shape { position: absolute; opacity: 0.12; animation: shapeFloat 20s ease-in-out infinite; }
.shape-1 { width: 300px; height: 300px; border: 2px solid #fff; top: 10%; right: 5%; transform: rotate(15deg); animation-duration: 18s; }
.shape-2 { width: 150px; height: 150px; background: rgba(0, 191, 243, 0.2); top: 60%; right: 15%; transform: rotate(45deg); animation-duration: 22s; animation-delay: -4s; }
.shape-3 { width: 200px; height: 200px; border: 2px solid rgba(255,255,255,0.3); border-radius: 50%; top: 20%; right: 20%; animation-duration: 25s; animation-delay: -8s; }
.shape-4 { width: 80px; height: 80px; background: rgba(133, 96, 168, 0.25); border-radius: 50%; top: 70%; right: 35%; animation-duration: 15s; animation-delay: -2s; }
.shape-5 { width: 120px; height: 120px; border: 1.5px solid rgba(255,255,255,0.15); top: 40%; right: 8%; transform: rotate(30deg); animation-duration: 20s; animation-delay: -6s; }
.shape-6 { width: 60px; height: 60px; background: rgba(0, 191, 243, 0.15); border-radius: 50%; top: 15%; right: 40%; animation-duration: 16s; animation-delay: -10s; }
@keyframes shapeFloat {
  0%, 100% { transform: rotate(var(--r, 15deg)) translate(0, 0); }
  25% { transform: rotate(var(--r, 15deg)) translate(15px, -20px); }
  50% { transform: rotate(var(--r, 15deg)) translate(-10px, 15px); }
  75% { transform: rotate(var(--r, 15deg)) translate(20px, 10px); }
}

.hero .container { position: relative; z-index: 2; }
.hero .overline {
  color: rgba(255,255,255,0.7);
  letter-spacing: 2px;
  text-transform: uppercase;
  font-size: 13px;
}
.hero h1 {
  font-size: 80px;
  font-weight: 400;
  color: #fff;
  line-height: 1.05;
  margin-bottom: 28px;
}
.hero h1 .accent {
  background: linear-gradient(90deg, #fff 40%, var(--color-cyan) 90%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}
.hero .subtitle {
  font-family: var(--font-heading);
  font-size: 22px;
  font-weight: 400;
  color: rgba(255,255,255,0.92);
  line-height: 1.5;
  margin-bottom: 16px;
}
.hero .supporting {
  font-family: var(--font-body);
  font-size: 20px;
  font-weight: 300;
  color: rgba(255,255,255,0.7);
  margin-bottom: 44px;
}

.hero-accent-bar {
  height: 4px;
  background: linear-gradient(90deg, var(--color-purple) 0%, var(--color-blue) 25%, var(--color-mid-blue) 50%, var(--color-cyan) 75%, var(--color-purple) 100%);
  background-size: 200% 100%;
  animation: gradientSlide 4s ease infinite;
}
@keyframes gradientSlide {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

@keyframes fadeUp {
  from { opacity: 0; transform: translateY(30px); }
  to { opacity: 1; transform: translateY(0); }
}
.hero .overline { animation: fadeUp 0.7s ease 0.2s both; }
.hero h1 { animation: fadeUp 0.8s ease 0.35s both; }
.hero .subtitle { animation: fadeUp 0.8s ease 0.5s both; }
.hero .supporting { animation: fadeUp 0.7s ease 0.65s both; }
.hero .btn-primary { animation: fadeUp 0.7s ease 0.8s both; }

/* ===== PULL QUOTE BANNER ===== */
.pull-quote-banner {
  background: var(--color-dark);
  padding: 56px 0;
  position: relative;
  overflow: hidden;
}
.pull-quote-banner::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, rgba(133, 96, 168, 0.1), rgba(0, 191, 243, 0.08));
  pointer-events: none;
}
.pull-quote-banner .container { position: relative; z-index: 1; text-align: center; }
.pull-quote-banner blockquote {
  font-family: var(--font-heading);
  font-size: 24px;
  font-weight: 400;
  color: #fff;
  line-height: 1.55;
  max-width: 820px;
  margin: 0 auto;
  position: relative;
  padding: 0 40px;
}
.pull-quote-banner blockquote::before {
  content: '';
  display: block;
  width: 48px;
  height: 3px;
  background: linear-gradient(90deg, var(--color-purple), var(--color-cyan));
  margin: 0 auto 28px;
}
.pull-quote-banner .quote-accent { color: var(--color-cyan); }

/* ===== CONTENT BLOCK ===== */
.body-content { max-width: 780px; }
.body-content.wide { max-width: var(--container-width); }
.pull-highlight {
  font-size: 22px;
  font-weight: 400;
  color: var(--color-dark);
  line-height: 1.55;
  padding: 32px 0 32px 28px;
  border-left: 3px solid var(--color-cyan);
  margin: 36px 0;
  font-family: var(--font-heading);
}

/* ===== CARD GRID / FEATURES ===== */
.features-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 24px;
  margin-top: 48px;
}
.feature-card {
  padding: 36px 28px;
  border-left: 3px solid var(--color-purple);
  background: #fff;
  position: relative;
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}
.section-light .feature-card { background: #fff; }
.feature-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: -3px;
  bottom: 0;
  width: 3px;
  background: linear-gradient(180deg, var(--color-purple), var(--color-cyan));
  opacity: 0;
  transition: opacity 0.4s ease;
}
.feature-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 16px 48px rgba(133, 96, 168, 0.12);
}
.feature-card:hover::before { opacity: 1; }
.feature-icon {
  width: 44px;
  height: 44px;
  margin-bottom: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.feature-icon svg { width: 100%; height: 100%; }
.feature-icon img { width: 100%; height: 100%; object-fit: contain; }
.feature-card h3 { font-size: 19px; margin-bottom: 12px; }
.feature-card p { font-size: 16px; line-height: 1.6; margin-bottom: 0; color: var(--color-body); }

/* Featured card (full-width dark variant) */
.feature-card-featured {
  grid-column: 1 / -1;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 40px;
  padding: 48px 44px;
  background: linear-gradient(160deg, var(--color-dark), var(--color-body));
  border-left: 4px solid;
  border-image: linear-gradient(180deg, var(--color-purple), var(--color-cyan)) 1;
  position: relative;
  overflow: hidden;
  transition: all 0.4s ease;
}
.feature-card-featured::after {
  content: '';
  position: absolute;
  top: -100px;
  right: -100px;
  width: 350px;
  height: 350px;
  background: radial-gradient(circle, rgba(0, 191, 243, 0.06), transparent 70%);
  pointer-events: none;
}
.feature-card-featured:hover {
  box-shadow: 0 20px 56px rgba(37, 44, 58, 0.3);
  transform: translateY(-4px);
}
.feature-card-featured h3 { color: var(--color-cyan); font-size: 24px; margin-bottom: 16px; }
.feature-card-featured p { color: rgba(255,255,255,0.8); font-size: 17px; line-height: 1.65; margin-bottom: 0; }
.featured-tag {
  display: inline-block;
  font-family: var(--font-heading);
  font-size: 10px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 2px;
  color: var(--color-cyan);
  border: 1px solid rgba(0, 191, 243, 0.3);
  padding: 4px 12px;
  margin-bottom: 20px;
}

/* 2 and 4 column variants */
.features-grid.cols-2 { grid-template-columns: repeat(2, 1fr); }
.features-grid.cols-4 { grid-template-columns: repeat(4, 1fr); }

/* ===== BENEFITS GRID (DARK) ===== */
.benefits-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 2px;
  margin-top: 48px;
  background: rgba(255,255,255,0.04);
}
.benefit-item {
  padding: 36px 32px;
  background: var(--color-dark-alt);
  position: relative;
  transition: all 0.4s ease;
}
.benefit-item:hover { background: rgba(255,255,255,0.03); }
.benefit-icon {
  width: 40px;
  height: 40px;
  margin-bottom: 18px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.benefit-icon svg { width: 100%; height: 100%; }
.benefit-icon img { width: 100%; height: 100%; object-fit: contain; }
.benefit-item strong {
  font-family: var(--font-heading);
  font-size: 18px;
  font-weight: 500;
  color: #fff;
  display: block;
  margin-bottom: 8px;
}
.benefit-item span {
  font-size: 16px;
  color: rgba(255,255,255,0.65);
  font-weight: 300;
  line-height: 1.6;
}

/* ===== PROCESS STEPS ===== */
.process-steps { margin-top: 56px; position: relative; }
.process-steps::before {
  content: '';
  position: absolute;
  left: 31px;
  top: 40px;
  bottom: 40px;
  width: 2px;
  background: linear-gradient(180deg, var(--color-purple), var(--color-blue), var(--color-mid-blue), var(--color-cyan));
  opacity: 0.25;
}
.process-step {
  display: grid;
  grid-template-columns: 64px 1fr;
  gap: 28px;
  padding: 28px 0;
  align-items: start;
  position: relative;
}
.step-marker {
  width: 64px;
  height: 64px;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  z-index: 1;
}
.step-number {
  font-family: var(--font-heading);
  font-size: 22px;
  font-weight: 600;
  width: 52px;
  height: 52px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--color-purple);
  background: #fff;
  border: 2px solid rgba(133, 96, 168, 0.2);
  transition: all 0.4s ease;
}
.process-step:hover .step-number {
  background: var(--color-purple);
  color: #fff;
  border-color: var(--color-purple);
  box-shadow: 0 8px 24px rgba(133, 96, 168, 0.25);
}
.section-light .step-number { background: var(--color-light-bg); }
.step-content { padding-top: 12px; }
.process-step h3 { font-size: 20px; margin-bottom: 6px; }
.process-step .step-desc {
  color: var(--color-body);
  font-weight: 300;
  font-size: 17px;
  line-height: 1.6;
}

/* ===== CTA SECTION ===== */
.cta-close {
  background: var(--color-purple);
  padding: 110px 0;
  text-align: center;
  position: relative;
  overflow: hidden;
}
.cta-close::before {
  content: '';
  position: absolute;
  inset: 0;
  background:
    radial-gradient(ellipse 400px 400px at 20% 50%, rgba(86, 116, 185, 0.3), transparent),
    radial-gradient(ellipse 350px 350px at 80% 30%, rgba(0, 191, 243, 0.2), transparent);
  pointer-events: none;
}
.cta-close .container { position: relative; z-index: 1; }
.cta-close h2 {
  color: #fff;
  margin-bottom: 20px;
  max-width: 600px;
  margin-left: auto;
  margin-right: auto;
  font-size: 40px;
}
.cta-close p {
  color: rgba(255,255,255,0.85);
  font-size: 18px;
  max-width: 580px;
  margin: 0 auto 40px;
}

/* ===== AUDIENCE / ICON CARDS ===== */
.audience-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 20px;
  margin-top: 44px;
}
.audience-card {
  display: flex;
  gap: 18px;
  align-items: flex-start;
  padding: 28px 24px;
  background: #fff;
  transition: all 0.4s ease;
  border: 1px solid transparent;
}
.audience-card:hover {
  border-color: rgba(133, 96, 168, 0.12);
  box-shadow: 0 8px 32px rgba(133, 96, 168, 0.06);
  transform: translateY(-3px);
}
.audience-icon { flex-shrink: 0; width: 36px; height: 36px; margin-top: 2px; }
.audience-card p { font-size: 17px; line-height: 1.55; margin-bottom: 0; }

/* ===== IMAGE + TEXT ===== */
.image-text-layout {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 56px;
  align-items: center;
}
.image-text-layout.image-right { direction: ltr; }
.image-text-layout.image-left .image-text-media { order: -1; }
.image-text-media img { width: 100%; height: auto; }
.image-text-content .overline { color: var(--color-purple); }

/* ===== ACCORDION / FAQ ===== */
.accordion-item {
  border-bottom: 1px solid rgba(133, 96, 168, 0.12);
}
.accordion-trigger {
  width: 100%;
  background: none;
  border: none;
  padding: 20px 0;
  display: flex;
  justify-content: space-between;
  align-items: center;
  cursor: pointer;
  font-family: var(--font-heading);
  font-size: 18px;
  font-weight: 500;
  color: var(--color-body);
  text-align: left;
  transition: color 0.3s ease;
}
.accordion-trigger:hover,
.accordion-trigger[aria-expanded="true"] { color: var(--color-purple); }
.accordion-trigger:focus-visible { outline: 2px solid var(--color-cyan); outline-offset: 2px; }
.accordion-icon {
  width: 24px;
  height: 24px;
  position: relative;
  flex-shrink: 0;
}
.accordion-icon::before,
.accordion-icon::after {
  content: '';
  position: absolute;
  background: currentColor;
  transition: transform 0.3s ease;
}
.accordion-icon::before { width: 14px; height: 2px; top: 11px; left: 5px; }
.accordion-icon::after { width: 2px; height: 14px; top: 5px; left: 11px; }
.accordion-trigger[aria-expanded="true"] .accordion-icon::after { transform: rotate(90deg); }
.accordion-panel {
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.4s ease;
}
.accordion-panel-inner { padding: 0 0 24px; }
.accordion-panel-inner p { font-size: 16px; line-height: 1.65; }

/* ===== TEAM GRID ===== */
.team-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 24px;
  margin-top: 44px;
}
.team-card {
  position: relative;
  overflow: hidden;
  background: #fff;
  transition: transform 0.4s ease;
}
.team-card:hover { transform: translateY(-4px); }
.team-card-photo {
  aspect-ratio: 1;
  overflow: hidden;
  background: var(--color-light-bg);
}
.team-card-photo img { width: 100%; height: 100%; object-fit: cover; }
.team-card-info { padding: 16px; text-align: center; }
.team-card-name {
  font-family: var(--font-heading);
  font-size: 16px;
  font-weight: 600;
  color: var(--color-body);
  margin-bottom: 2px;
}
.team-card-title { font-size: 14px; color: var(--color-purple); }
.team-card-bio-overlay {
  position: absolute;
  inset: 0;
  background: rgba(37, 44, 58, 0.92);
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 24px;
  opacity: 0;
  transition: opacity 0.4s ease;
}
.team-card:hover .team-card-bio-overlay { opacity: 1; }
.team-card-bio-overlay p { color: #fff; font-size: 14px; line-height: 1.6; text-align: center; margin: 0; }

/* ===== LOGO CAROUSEL ===== */
.logo-carousel {
  display: flex;
  gap: 48px;
  align-items: center;
  justify-content: center;
  flex-wrap: wrap;
  margin-top: 40px;
}
.logo-carousel img {
  height: 40px;
  width: auto;
  filter: grayscale(100%);
  opacity: 0.6;
  transition: all 0.3s ease;
}
.logo-carousel img:hover {
  filter: grayscale(0%);
  opacity: 1;
}

/* ===== TESTIMONIALS ===== */
.testimonials-carousel { position: relative; overflow: hidden; margin-top: 48px; }
.testimonials-track { display: flex; transition: transform 0.5s ease; }
.testimonial-slide {
  min-width: 100%;
  padding: 40px;
  text-align: center;
}
.testimonial-quote {
  font-family: var(--font-heading);
  font-size: 22px;
  font-weight: 400;
  color: var(--color-body);
  line-height: 1.6;
  max-width: 700px;
  margin: 0 auto 24px;
  font-style: italic;
}
.testimonial-author { font-family: var(--font-heading); font-size: 16px; font-weight: 600; color: var(--color-purple); }
.testimonial-role { font-size: 14px; color: #999; margin-top: 4px; }
.testimonial-photo {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  overflow: hidden;
  margin: 0 auto 16px;
}
.testimonial-photo img { width: 100%; height: 100%; object-fit: cover; }
.testimonials-dots {
  display: flex;
  justify-content: center;
  gap: 8px;
  margin-top: 24px;
}
.testimonials-dot {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  background: rgba(133, 96, 168, 0.2);
  border: none;
  cursor: pointer;
  transition: background 0.3s ease;
  padding: 0;
}
.testimonials-dot.active { background: var(--color-purple); }
.testimonials-dot:focus-visible { outline: 2px solid var(--color-cyan); outline-offset: 2px; }

/* ===== CONTACT BLOCK ===== */
.contact-layout {
  display: grid;
  grid-template-columns: 1fr 1.2fr;
  gap: 56px;
  align-items: start;
}
.contact-layout.form-left { direction: rtl; }
.contact-layout.form-left > * { direction: ltr; }
.contact-info address {
  font-style: normal;
  font-size: 16px;
  line-height: 1.8;
  margin-bottom: 24px;
}
.contact-info a { color: var(--color-purple); transition: color 0.2s; }
.contact-info a:hover { color: var(--color-cyan); }
.contact-social { display: flex; gap: 16px; margin-top: 16px; }
.contact-social a {
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 1px solid rgba(133, 96, 168, 0.2);
  transition: all 0.3s ease;
}
.contact-social a:hover {
  background: var(--color-purple);
  border-color: var(--color-purple);
  color: #fff;
}

/* ===== BLOG CARDS ===== */
.blog-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 24px;
  margin-top: 40px;
}
.blog-card {
  background: #fff;
  border: 1px solid rgba(0,0,0,0.06);
  transition: all 0.4s ease;
  overflow: hidden;
}
.blog-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 36px rgba(133, 96, 168, 0.1);
}
.blog-card-image {
  aspect-ratio: 16/9;
  overflow: hidden;
  background: var(--color-light-bg);
}
.blog-card-image img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease; }
.blog-card:hover .blog-card-image img { transform: scale(1.05); }
.blog-card-body { padding: 24px; }
.blog-card-category {
  font-family: var(--font-heading);
  font-size: 11px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 1px;
  color: var(--color-purple);
  margin-bottom: 8px;
  display: inline-block;
}
.blog-card-title {
  font-family: var(--font-heading);
  font-size: 18px;
  font-weight: 500;
  color: var(--color-body);
  line-height: 1.4;
  margin-bottom: 12px;
}
.blog-card-title a { transition: color 0.2s; }
.blog-card-title a:hover { color: var(--color-purple); }
.blog-card-excerpt { font-size: 15px; color: #666; line-height: 1.55; margin-bottom: 16px; }
.blog-card-meta { font-size: 13px; color: #999; }
.blog-card-readmore {
  font-family: var(--font-heading);
  font-size: 14px;
  font-weight: 500;
  color: var(--color-purple);
  transition: color 0.2s;
}
.blog-card-readmore:hover { color: var(--color-cyan); }

/* Blog category filter buttons */
.blog-filters {
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
  margin-bottom: 32px;
}
.blog-filter-btn {
  font-family: var(--font-heading);
  font-size: 13px;
  font-weight: 500;
  padding: 8px 20px;
  border: 1px solid rgba(133, 96, 168, 0.2);
  background: transparent;
  color: var(--color-body);
  cursor: pointer;
  transition: all 0.3s ease;
}
.blog-filter-btn:hover,
.blog-filter-btn.active {
  background: var(--color-purple);
  border-color: var(--color-purple);
  color: #fff;
}

/* Blog single post */
.single-post-header {
  background: var(--color-dark);
  padding: 160px 0 80px;
  position: relative;
}
.single-post-header::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(160deg, rgba(86, 116, 185, 0.3), rgba(0, 191, 243, 0.2));
}
.single-post-header .container { position: relative; z-index: 1; }
.single-post-header h1 {
  font-size: 42px;
  font-weight: 500;
  color: #fff;
  line-height: 1.2;
  max-width: 780px;
}
.single-post-meta {
  margin-top: 20px;
  font-size: 15px;
  color: rgba(255,255,255,0.7);
}
.single-post-meta a { color: var(--color-cyan); }
.single-post-content {
  max-width: 780px;
  margin: 0 auto;
  padding: 60px var(--container-padding);
}
.single-post-content h2 { font-size: 30px; margin-top: 48px; margin-bottom: 20px; }
.single-post-content h3 { font-size: 24px; margin-top: 36px; margin-bottom: 16px; }
.single-post-content ul, .single-post-content ol { margin-bottom: 24px; padding-left: 24px; }
.single-post-content li { margin-bottom: 8px; }
.single-post-content blockquote {
  border-left: 3px solid var(--color-cyan);
  padding: 16px 0 16px 24px;
  margin: 32px 0;
  font-family: var(--font-heading);
  font-size: 20px;
  font-weight: 400;
  color: var(--color-dark);
}
.single-post-content img { margin: 32px 0; }

/* Pagination */
.pagination {
  display: flex;
  justify-content: center;
  gap: 4px;
  margin-top: 48px;
}
.pagination a, .pagination span {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 40px;
  height: 40px;
  font-family: var(--font-heading);
  font-size: 14px;
  font-weight: 500;
  border: 1px solid rgba(133, 96, 168, 0.15);
  transition: all 0.3s ease;
}
.pagination a:hover {
  background: var(--color-purple);
  border-color: var(--color-purple);
  color: #fff;
}
.pagination .current {
  background: var(--color-purple);
  border-color: var(--color-purple);
  color: #fff;
}

/* ===== FOOTER ===== */
.site-footer {
  background: var(--color-dark-alt);
  padding: 64px 0 32px;
  color: rgba(255,255,255,0.6);
  font-size: 15px;
}
.footer-grid {
  display: grid;
  grid-template-columns: 1.5fr 1fr 1fr 1fr;
  gap: 40px;
  margin-bottom: 40px;
}
.footer-brand .logo { display: block; line-height: 0; margin-bottom: 12px; }
.footer-brand .logo img { height: 38px; width: auto; }
.footer-brand p { font-size: 14px; line-height: 1.6; color: rgba(255,255,255,0.5); margin-bottom: 0; max-width: 280px; }
.footer-col h4 { font-family: var(--font-heading); font-size: 15px; font-weight: 500; color: #fff; margin-bottom: 16px; }
.footer-col ul { list-style: none; }
.footer-col li { margin-bottom: 8px; }
.footer-col a { color: rgba(255,255,255,0.55); font-size: 14px; transition: color 0.2s; }
.footer-col a:hover { color: var(--color-cyan); }
.footer-bottom {
  border-top: 1px solid rgba(255,255,255,0.08);
  padding-top: 24px;
  font-size: 13px;
  color: rgba(255,255,255,0.35);
}

/* ===== 404 ===== */
.page-404 { text-align: center; padding: 160px 0 100px; }
.page-404 h1 { font-size: 120px; font-weight: 600; color: var(--color-purple); opacity: 0.2; margin-bottom: 0; }
.page-404 h2 { margin-top: -20px; }

/* ===== SEARCH RESULTS ===== */
.search-header { padding: 160px 0 60px; background: var(--color-dark); }
.search-header h1 { color: #fff; font-size: 36px; font-weight: 400; }
.search-header .search-query { color: var(--color-cyan); }

/* ===== RESPONSIVE ===== */
@media (max-width: 960px) {
  .features-grid { grid-template-columns: repeat(2, 1fr); }
  .features-grid.cols-4 { grid-template-columns: repeat(2, 1fr); }
  .feature-card-featured { grid-template-columns: 1fr; }
  .benefits-grid { grid-template-columns: 1fr; }
  .image-text-layout { grid-template-columns: 1fr; gap: 36px; }
  .image-text-layout.image-left .image-text-media { order: 0; }
  .contact-layout { grid-template-columns: 1fr; gap: 36px; }
  .audience-grid { grid-template-columns: 1fr; }
  .footer-grid { grid-template-columns: 1fr 1fr; gap: 32px; }
  .team-grid { grid-template-columns: repeat(3, 1fr); }
}

@media (max-width: 768px) {
  .hero { padding: 140px 0 70px; min-height: auto; }
  .hero h1 { font-size: 52px; }
  .hero .subtitle { font-size: 20px; }
  .hero .supporting { font-size: 17px; }
  h2 { font-size: 30px; }
  .section-white, .section-light, .section-dark { padding: var(--section-padding-mobile) 0; }
  .section-purple { padding: var(--section-padding-mobile) 0; }
  .cta-close { padding: 80px 0; }
  .cta-close h2 { font-size: 30px; }
  .features-grid, .features-grid.cols-2, .features-grid.cols-4 { grid-template-columns: 1fr; gap: 16px; }
  .process-steps::before { left: 27px; }
  .process-step { grid-template-columns: 56px 1fr; gap: 16px; padding: 20px 0; }
  .step-number { width: 44px; height: 44px; font-size: 18px; }
  .nav-links { display: none; }
  .nav-toggle { display: block; }
  .footer-grid { grid-template-columns: 1fr; gap: 28px; }
  .pull-quote-banner blockquote { font-size: 20px; padding: 0 20px; }
  .pull-quote-banner { padding: 44px 0; }
  .blog-grid { grid-template-columns: 1fr; }
  .team-grid { grid-template-columns: repeat(2, 1fr); }
  .shape-1, .shape-3, .shape-5 { display: none; }
  .single-post-header h1 { font-size: 32px; }
}

@media (max-width: 480px) {
  .hero h1 { font-size: 40px; }
  .hero .subtitle { font-size: 18px; }
  h2 { font-size: 26px; }
  .btn-primary, .btn-white { width: 100%; text-align: center; }
  .feature-card { padding: 28px 20px; }
  .benefit-item { padding: 28px 20px; }
  .pull-quote-banner blockquote { font-size: 18px; padding: 0 8px; }
  .team-grid { grid-template-columns: 1fr; }
}
```

- [ ] **Step 2: Commit**

```bash
git add stretch-theme/assets/css/theme.css
git commit -m "feat: add complete design system CSS extracted from prototype"
```

---

### Task 3: Theme Setup — functions.php and inc/theme-setup.php

**Files:**
- Create: `stretch-theme/functions.php`
- Create: `stretch-theme/inc/theme-setup.php`

- [ ] **Step 1: Create inc/theme-setup.php**

Create `stretch-theme/inc/theme-setup.php`:

```php
<?php
/**
 * Theme setup: menus, supports, image sizes.
 */

function stretch_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('editor-styles');
    add_editor_style('assets/css/editor-style.css');
    add_theme_support('responsive-embeds');
    add_theme_support('custom-logo', [
        'height'      => 80,
        'width'       => 260,
        'flex-height' => true,
        'flex-width'  => true,
    ]);

    register_nav_menus([
        'primary'  => __('Primary Navigation', 'stretch'),
        'footer-1' => __('Footer Column 1', 'stretch'),
        'footer-2' => __('Footer Column 2', 'stretch'),
        'footer-3' => __('Footer Column 3', 'stretch'),
    ]);

    add_image_size('blog-card', 600, 340, true);
    add_image_size('team-photo', 400, 400, true);
    add_image_size('hero-bg', 1920, 1080, true);
}
add_action('after_setup_theme', 'stretch_setup');

/**
 * Register client user role for future portal.
 */
function stretch_register_roles() {
    if (!get_role('stretch_client')) {
        add_role('stretch_client', __('Client', 'stretch'), ['read' => true]);
    }
}
add_action('init', 'stretch_register_roles');

/**
 * ACF JSON save/load paths.
 */
function stretch_acf_json_save_point($path) {
    return get_stylesheet_directory() . '/acf-json';
}
add_filter('acf/settings/save_json', 'stretch_acf_json_save_point');

function stretch_acf_json_load_point($paths) {
    unset($paths[0]);
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return $paths;
}
add_filter('acf/settings/load_json', 'stretch_acf_json_load_point');
```

- [ ] **Step 2: Create functions.php**

Create `stretch-theme/functions.php`:

```php
<?php
/**
 * Stretch Creative Theme — functions.php
 */

// Theme setup: menus, supports, image sizes, roles
require_once get_template_directory() . '/inc/theme-setup.php';

// Customizer: brand colors, typography, header/footer settings
require_once get_template_directory() . '/inc/customizer.php';

// ACF field registration (PHP fallback for flexible content)
require_once get_template_directory() . '/inc/acf-fields.php';

/**
 * Enqueue styles and scripts.
 */
function stretch_enqueue_assets() {
    // Google Fonts
    wp_enqueue_style(
        'stretch-google-fonts',
        'https://fonts.googleapis.com/css2?family=Assistant:wght@300;400;600&family=Montserrat:wght@400&family=Poppins:wght@400;500;600&display=swap',
        [],
        null
    );

    // Theme CSS
    wp_enqueue_style('stretch-theme', get_template_directory_uri() . '/assets/css/theme.css', ['stretch-google-fonts'], wp_get_theme()->get('Version'));

    // Theme JS — loaded in footer, no jQuery
    wp_enqueue_script('stretch-theme', get_template_directory_uri() . '/assets/js/theme.js', [], wp_get_theme()->get('Version'), true);
}
add_action('wp_enqueue_scripts', 'stretch_enqueue_assets');

/**
 * Add preconnect hints for Google Fonts.
 */
function stretch_resource_hints($urls, $relation_type) {
    if ($relation_type === 'preconnect') {
        $urls[] = ['href' => 'https://fonts.googleapis.com'];
        $urls[] = ['href' => 'https://fonts.gstatic.com', 'crossorigin' => 'anonymous'];
    }
    return $urls;
}
add_filter('wp_resource_hints', 'stretch_resource_hints', 10, 2);

/**
 * Output Customizer CSS variables in <head>.
 */
function stretch_customizer_css() {
    $purple   = get_theme_mod('stretch_color_primary', '#8560A8');
    $blue     = get_theme_mod('stretch_color_secondary', '#5674B9');
    $cyan     = get_theme_mod('stretch_color_accent', '#00BFF3');
    $dark     = get_theme_mod('stretch_color_dark', '#252C3A');
    $body     = get_theme_mod('stretch_color_body', '#323A51');
    $font_h   = get_theme_mod('stretch_font_heading', 'Poppins');
    $font_b   = get_theme_mod('stretch_font_body', 'Assistant');
    $font_n   = get_theme_mod('stretch_font_nav', 'Montserrat');
    $font_sz  = get_theme_mod('stretch_font_size_base', '18');

    echo '<style id="stretch-customizer-css">:root{';
    echo "--color-purple:{$purple};";
    echo "--color-blue:{$blue};";
    echo "--color-cyan:{$cyan};";
    echo "--color-dark:{$dark};";
    echo "--color-body:{$body};";
    echo "--font-heading:'{$font_h}',sans-serif;";
    echo "--font-body:'{$font_b}',sans-serif;";
    echo "--font-nav:'{$font_n}',sans-serif;";
    echo "--font-size-base:{$font_sz}px;";
    echo '}</style>';
}
add_action('wp_head', 'stretch_customizer_css', 20);

/**
 * Render ACF flexible content sections.
 * Called from front-page.php and page.php.
 */
function stretch_render_sections() {
    if (!function_exists('have_rows') || !have_rows('page_sections')) {
        return;
    }

    while (have_rows('page_sections')) {
        the_row();
        $layout = get_row_layout();
        $template = get_template_directory() . "/template-parts/sections/{$layout}.php";

        if (file_exists($template)) {
            include $template;
        }
    }
}

/**
 * Helper: get section background classes from ACF sub-fields.
 */
function stretch_section_classes() {
    $bg = get_sub_field('background_style') ?: 'white';
    $padding = get_sub_field('padding_style') ?: 'default';
    $id = get_sub_field('section_id');

    $classes = [];
    switch ($bg) {
        case 'light':  $classes[] = 'section-light'; break;
        case 'dark':   $classes[] = 'section-dark'; break;
        case 'purple': $classes[] = 'section-purple'; break;
        default:       $classes[] = 'section-white'; break;
    }

    if ($padding === 'compact') $classes[] = 'section-compact';
    if ($padding === 'none') $classes[] = 'section-no-padding';

    return [
        'class' => implode(' ', $classes),
        'id'    => $id ? esc_attr($id) : '',
        'style' => get_sub_field('custom_background_color') ? 'background-color:' . esc_attr(get_sub_field('custom_background_color')) . ';' : '',
    ];
}
```

- [ ] **Step 3: Commit**

```bash
git add stretch-theme/functions.php stretch-theme/inc/theme-setup.php
git commit -m "feat: add functions.php and theme-setup with menus, supports, enqueues"
```

---

### Task 4: WordPress Customizer

**Files:**
- Create: `stretch-theme/inc/customizer.php`

- [ ] **Step 1: Create inc/customizer.php**

Create `stretch-theme/inc/customizer.php`:

```php
<?php
/**
 * Theme Customizer: brand colors, typography, header, footer.
 */

function stretch_customize_register($wp_customize) {

    // ── Brand Colors Panel ──
    $wp_customize->add_panel('stretch_brand', [
        'title'    => __('Brand Settings', 'stretch'),
        'priority' => 30,
    ]);

    // Colors section
    $wp_customize->add_section('stretch_colors', [
        'title' => __('Brand Colors', 'stretch'),
        'panel' => 'stretch_brand',
    ]);

    $colors = [
        'stretch_color_primary'   => ['label' => 'Primary (Purple)',   'default' => '#8560A8'],
        'stretch_color_secondary' => ['label' => 'Secondary (Blue)',   'default' => '#5674B9'],
        'stretch_color_accent'    => ['label' => 'Accent (Cyan)',      'default' => '#00BFF3'],
        'stretch_color_dark'      => ['label' => 'Dark Background',    'default' => '#252C3A'],
        'stretch_color_body'      => ['label' => 'Body Text',          'default' => '#323A51'],
    ];

    foreach ($colors as $id => $config) {
        $wp_customize->add_setting($id, [
            'default'           => $config['default'],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        ]);
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $id, [
            'label'   => __($config['label'], 'stretch'),
            'section' => 'stretch_colors',
        ]));
    }

    // Typography section
    $wp_customize->add_section('stretch_typography', [
        'title' => __('Typography', 'stretch'),
        'panel' => 'stretch_brand',
    ]);

    $fonts = [
        'stretch_font_heading' => ['label' => 'Heading Font',  'default' => 'Poppins'],
        'stretch_font_body'    => ['label' => 'Body Font',     'default' => 'Assistant'],
        'stretch_font_nav'     => ['label' => 'Nav Font',      'default' => 'Montserrat'],
    ];

    foreach ($fonts as $id => $config) {
        $wp_customize->add_setting($id, [
            'default'           => $config['default'],
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control($id, [
            'label'   => __($config['label'], 'stretch'),
            'section' => 'stretch_typography',
            'type'    => 'text',
        ]);
    }

    $wp_customize->add_setting('stretch_font_size_base', [
        'default'           => '18',
        'sanitize_callback' => 'absint',
    ]);
    $wp_customize->add_control('stretch_font_size_base', [
        'label'   => __('Base Font Size (px)', 'stretch'),
        'section' => 'stretch_typography',
        'type'    => 'number',
        'input_attrs' => ['min' => 14, 'max' => 24, 'step' => 1],
    ]);

    // Header section
    $wp_customize->add_section('stretch_header', [
        'title' => __('Header', 'stretch'),
        'panel' => 'stretch_brand',
    ]);

    $wp_customize->add_setting('stretch_sticky_nav', [
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ]);
    $wp_customize->add_control('stretch_sticky_nav', [
        'label'   => __('Enable Sticky Navigation', 'stretch'),
        'section' => 'stretch_header',
        'type'    => 'checkbox',
    ]);

    // Footer section
    $wp_customize->add_section('stretch_footer', [
        'title' => __('Footer', 'stretch'),
        'panel' => 'stretch_brand',
    ]);

    $wp_customize->add_setting('stretch_footer_tagline', [
        'default'           => 'The trusted partner for producing publish-ready content at scale — your story, your voice, on time.',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('stretch_footer_tagline', [
        'label'   => __('Footer Tagline', 'stretch'),
        'section' => 'stretch_footer',
        'type'    => 'textarea',
    ]);

    $wp_customize->add_setting('stretch_footer_copyright', [
        'default'           => '© Copyright ' . date('Y') . ' Stretch Creative',
        'sanitize_callback' => 'wp_kses_post',
    ]);
    $wp_customize->add_control('stretch_footer_copyright', [
        'label'   => __('Copyright Text', 'stretch'),
        'section' => 'stretch_footer',
        'type'    => 'text',
    ]);
}
add_action('customize_register', 'stretch_customize_register');
```

- [ ] **Step 2: Commit**

```bash
git add stretch-theme/inc/customizer.php
git commit -m "feat: add WordPress Customizer panels for brand colors, typography, header, footer"
```

---

### Task 5: Header Template

**Files:**
- Create: `stretch-theme/header.php`

- [ ] **Step 1: Create header.php**

Create `stretch-theme/header.php`:

```php
<?php
/**
 * Header template — fixed nav with scroll behavior, mobile toggle.
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-to-content" href="#main-content"><?php esc_html_e('Skip to content', 'stretch'); ?></a>

<nav class="site-nav" id="siteNav" role="navigation" aria-label="<?php esc_attr_e('Main navigation', 'stretch'); ?>">
  <div class="container">
    <?php if (has_custom_logo()) : ?>
      <a href="<?php echo esc_url(home_url('/')); ?>" class="logo" aria-label="<?php esc_attr_e('Home', 'stretch'); ?>">
        <?php
        $logo_id = get_theme_mod('custom_logo');
        echo wp_get_attachment_image($logo_id, 'full');
        ?>
      </a>
    <?php else : ?>
      <a href="<?php echo esc_url(home_url('/')); ?>" class="logo" aria-label="<?php esc_attr_e('Home', 'stretch'); ?>">
        <span style="font-family:'Montserrat',sans-serif;font-size:28px;font-weight:700;color:#fff;letter-spacing:-1px;"><?php bloginfo('name'); ?></span>
      </a>
    <?php endif; ?>

    <button class="nav-toggle" aria-label="<?php esc_attr_e('Toggle navigation', 'stretch'); ?>" aria-expanded="false" aria-controls="primaryMenu">
      <span></span><span></span><span></span>
    </button>

    <?php if (has_nav_menu('primary')) : ?>
      <?php
      wp_nav_menu([
          'theme_location' => 'primary',
          'container'       => false,
          'menu_class'      => 'nav-links',
          'menu_id'         => 'primaryMenu',
          'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
          'depth'           => 1,
      ]);
      ?>
    <?php endif; ?>

    <?php if (is_user_logged_in() && current_user_can('stretch_client')) : ?>
      <a href="<?php echo esc_url(home_url('/portal/')); ?>" class="btn-primary nav-cta"><?php esc_html_e('Dashboard', 'stretch'); ?></a>
    <?php endif; ?>
  </div>
</nav>

<main id="main-content">
```

- [ ] **Step 2: Commit**

```bash
git add stretch-theme/header.php
git commit -m "feat: add header template with fixed nav, mobile toggle, skip-to-content"
```

---

### Task 6: Footer Template

**Files:**
- Create: `stretch-theme/footer.php`

- [ ] **Step 1: Create footer.php**

Create `stretch-theme/footer.php`:

```php
<?php
/**
 * Footer template — multi-column with menus.
 */
?>
</main>

<footer class="site-footer" role="contentinfo">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <?php if (has_custom_logo()) : ?>
          <div class="logo">
            <?php
            $logo_id = get_theme_mod('custom_logo');
            echo wp_get_attachment_image($logo_id, 'full');
            ?>
          </div>
        <?php else : ?>
          <div class="logo">
            <span style="font-family:'Montserrat',sans-serif;font-size:26px;font-weight:700;color:#fff;"><?php bloginfo('name'); ?></span>
          </div>
        <?php endif; ?>
        <p><?php echo esc_html(get_theme_mod('stretch_footer_tagline', 'The trusted partner for producing publish-ready content at scale — your story, your voice, on time.')); ?></p>
      </div>

      <?php if (has_nav_menu('footer-1')) : ?>
        <div class="footer-col">
          <h4><?php echo esc_html(wp_get_nav_menu_name('footer-1')); ?></h4>
          <?php wp_nav_menu(['theme_location' => 'footer-1', 'container' => false, 'menu_class' => '', 'depth' => 1]); ?>
        </div>
      <?php endif; ?>

      <?php if (has_nav_menu('footer-2')) : ?>
        <div class="footer-col">
          <h4><?php echo esc_html(wp_get_nav_menu_name('footer-2')); ?></h4>
          <?php wp_nav_menu(['theme_location' => 'footer-2', 'container' => false, 'menu_class' => '', 'depth' => 1]); ?>
        </div>
      <?php endif; ?>

      <?php if (has_nav_menu('footer-3')) : ?>
        <div class="footer-col">
          <h4><?php echo esc_html(wp_get_nav_menu_name('footer-3')); ?></h4>
          <?php wp_nav_menu(['theme_location' => 'footer-3', 'container' => false, 'menu_class' => '', 'depth' => 1]); ?>
        </div>
      <?php endif; ?>
    </div>

    <div class="footer-bottom">
      <?php echo wp_kses_post(get_theme_mod('stretch_footer_copyright', '&copy; Copyright ' . date('Y') . ' Stretch Creative')); ?>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
```

- [ ] **Step 2: Commit**

```bash
git add stretch-theme/footer.php
git commit -m "feat: add footer template with multi-column layout and Customizer integration"
```

---

### Task 7: Theme JavaScript

**Files:**
- Create: `stretch-theme/assets/js/theme.js`

- [ ] **Step 1: Create theme.js**

Create `stretch-theme/assets/js/theme.js`:

```js
/**
 * Stretch Creative Theme — Interactions
 * No jQuery. Vanilla JS only.
 */

(function () {
  'use strict';

  // ── Scroll Reveal ──
  if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    const revealObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add('visible');
          }
        });
      },
      { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
    );
    document.querySelectorAll('.reveal').forEach((el) => revealObserver.observe(el));
  }

  // ── Sticky Nav ──
  const nav = document.getElementById('siteNav');
  if (nav) {
    let ticking = false;
    window.addEventListener('scroll', () => {
      if (!ticking) {
        window.requestAnimationFrame(() => {
          nav.classList.toggle('scrolled', window.scrollY > 60);
          ticking = false;
        });
        ticking = true;
      }
    });
  }

  // ── Mobile Menu Toggle ──
  const toggle = document.querySelector('.nav-toggle');
  const menu = document.getElementById('primaryMenu');
  if (toggle && menu) {
    toggle.addEventListener('click', () => {
      const isOpen = menu.classList.toggle('open');
      toggle.classList.toggle('active', isOpen);
      toggle.setAttribute('aria-expanded', isOpen);
      document.body.style.overflow = isOpen ? 'hidden' : '';
    });

    // Close on escape
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && menu.classList.contains('open')) {
        menu.classList.remove('open');
        toggle.classList.remove('active');
        toggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
        toggle.focus();
      }
    });
  }

  // ── Accordion ──
  document.querySelectorAll('.accordion-trigger').forEach((trigger) => {
    trigger.addEventListener('click', () => {
      const panel = document.getElementById(trigger.getAttribute('aria-controls'));
      const isExpanded = trigger.getAttribute('aria-expanded') === 'true';

      trigger.setAttribute('aria-expanded', !isExpanded);

      if (!isExpanded) {
        panel.style.maxHeight = panel.scrollHeight + 'px';
      } else {
        panel.style.maxHeight = '0';
      }
    });
  });

  // ── Testimonials Carousel ──
  document.querySelectorAll('.testimonials-carousel').forEach((carousel) => {
    const track = carousel.querySelector('.testimonials-track');
    const dots = carousel.querySelectorAll('.testimonials-dot');
    let current = 0;
    const total = dots.length;

    function goTo(index) {
      current = ((index % total) + total) % total;
      track.style.transform = 'translateX(-' + current * 100 + '%)';
      dots.forEach((d, i) => d.classList.toggle('active', i === current));
    }

    dots.forEach((dot, i) => {
      dot.addEventListener('click', () => goTo(i));
    });

    // Auto-advance every 6 seconds
    let interval = setInterval(() => goTo(current + 1), 6000);
    carousel.addEventListener('mouseenter', () => clearInterval(interval));
    carousel.addEventListener('mouseleave', () => {
      interval = setInterval(() => goTo(current + 1), 6000);
    });

    goTo(0);
  });

  // ── Blog Category Filters ──
  document.querySelectorAll('.blog-filter-btn').forEach((btn) => {
    btn.addEventListener('click', () => {
      const filter = btn.dataset.filter;
      const grid = btn.closest('section').querySelector('.blog-grid');

      // Update active button
      btn.closest('.blog-filters').querySelectorAll('.blog-filter-btn').forEach((b) => b.classList.remove('active'));
      btn.classList.add('active');

      // Filter cards
      grid.querySelectorAll('.blog-card').forEach((card) => {
        if (filter === 'all' || card.dataset.category === filter) {
          card.style.display = '';
        } else {
          card.style.display = 'none';
        }
      });
    });
  });
})();
```

- [ ] **Step 2: Commit**

```bash
git add stretch-theme/assets/js/theme.js
git commit -m "feat: add theme JS — scroll reveal, sticky nav, mobile menu, accordion, carousel, blog filters"
```

---

### Task 8: ACF Field Registration

**Files:**
- Create: `stretch-theme/inc/acf-fields.php`

This registers the Flexible Content field group with all 13 section layouts and their sub-fields. This is the PHP fallback — ACF JSON exports will also be saved in `acf-json/`.

- [ ] **Step 1: Create inc/acf-fields.php**

Create `stretch-theme/inc/acf-fields.php`:

```php
<?php
/**
 * ACF Flexible Content field group registration.
 * Registers all section layouts for the page builder.
 */

if (!function_exists('acf_add_local_field_group')) {
    return;
}

/**
 * Shared section settings fields (reused in every layout).
 */
function stretch_section_settings_fields($prefix) {
    return [
        [
            'key'     => "field_{$prefix}_bg_style",
            'label'   => 'Background Style',
            'name'    => 'background_style',
            'type'    => 'select',
            'choices' => ['white' => 'White', 'light' => 'Light', 'dark' => 'Dark', 'purple' => 'Purple'],
            'default_value' => 'white',
        ],
        [
            'key'   => "field_{$prefix}_bg_custom",
            'label' => 'Custom Background Color',
            'name'  => 'custom_background_color',
            'type'  => 'color_picker',
            'instructions' => 'Leave blank to use the selected style.',
        ],
        [
            'key'   => "field_{$prefix}_section_id",
            'label' => 'Section ID',
            'name'  => 'section_id',
            'type'  => 'text',
            'instructions' => 'For anchor links (e.g., "about" creates #about).',
        ],
        [
            'key'     => "field_{$prefix}_padding",
            'label'   => 'Padding',
            'name'    => 'padding_style',
            'type'    => 'select',
            'choices' => ['default' => 'Default', 'compact' => 'Compact', 'none' => 'None'],
            'default_value' => 'default',
        ],
    ];
}

add_action('acf/init', function () {

    acf_add_local_field_group([
        'key'      => 'group_page_sections',
        'title'    => 'Page Sections',
        'fields'   => [
            [
                'key'        => 'field_page_sections',
                'label'      => 'Sections',
                'name'       => 'page_sections',
                'type'       => 'flexible_content',
                'button_label' => 'Add Section',
                'layouts'    => [

                    // ── 1. Hero ──
                    'hero' => [
                        'key'        => 'layout_hero',
                        'name'       => 'hero',
                        'label'      => 'Hero',
                        'sub_fields' => array_merge(
                            [
                                ['key' => 'field_hero_overline',   'label' => 'Overline',        'name' => 'overline',        'type' => 'text'],
                                ['key' => 'field_hero_headline',   'label' => 'Headline',        'name' => 'headline',        'type' => 'text',     'required' => 1],
                                ['key' => 'field_hero_accent',     'label' => 'Accent Word(s)',   'name' => 'accent_text',     'type' => 'text',     'instructions' => 'Word(s) in headline that get the gradient accent. Leave blank for no accent.'],
                                ['key' => 'field_hero_subtitle',   'label' => 'Subtitle',        'name' => 'subtitle',        'type' => 'textarea', 'rows' => 2],
                                ['key' => 'field_hero_supporting', 'label' => 'Supporting Text',  'name' => 'supporting_text', 'type' => 'textarea', 'rows' => 2],
                                ['key' => 'field_hero_cta',        'label' => 'CTA Button',      'name' => 'cta_button',      'type' => 'link'],
                                ['key' => 'field_hero_cta2',       'label' => 'Secondary CTA',   'name' => 'secondary_cta',   'type' => 'link'],
                                ['key' => 'field_hero_bg_image',   'label' => 'Background Image', 'name' => 'bg_image',       'type' => 'image',    'return_format' => 'url'],
                                ['key' => 'field_hero_bg_video',   'label' => 'Background Video URL', 'name' => 'bg_video',   'type' => 'url'],
                                ['key' => 'field_hero_shapes',     'label' => 'Show Animated Shapes', 'name' => 'show_shapes', 'type' => 'true_false', 'default_value' => 1],
                            ],
                            stretch_section_settings_fields('hero')
                        ),
                    ],

                    // ── 2. Content Block ──
                    'content-block' => [
                        'key'        => 'layout_content_block',
                        'name'       => 'content-block',
                        'label'      => 'Content Block',
                        'sub_fields' => array_merge(
                            [
                                ['key' => 'field_cb_overline',  'label' => 'Overline',        'name' => 'overline',        'type' => 'text'],
                                ['key' => 'field_cb_heading',   'label' => 'Heading',         'name' => 'heading',         'type' => 'text'],
                                ['key' => 'field_cb_body',      'label' => 'Body Content',    'name' => 'body_content',    'type' => 'wysiwyg',  'toolbar' => 'full', 'media_upload' => 1],
                                ['key' => 'field_cb_highlight', 'label' => 'Pull Highlight',  'name' => 'pull_highlight',  'type' => 'textarea', 'rows' => 3, 'instructions' => 'Displays as a left-bordered pullquote. Leave blank to skip.'],
                                ['key' => 'field_cb_width',     'label' => 'Max Width',       'name' => 'max_width',       'type' => 'select',   'choices' => ['normal' => 'Normal (780px)', 'wide' => 'Wide (1100px)'], 'default_value' => 'normal'],
                            ],
                            stretch_section_settings_fields('cb')
                        ),
                    ],

                    // ── 3. Card Grid ──
                    'card-grid' => [
                        'key'        => 'layout_card_grid',
                        'name'       => 'card-grid',
                        'label'      => 'Card Grid',
                        'sub_fields' => array_merge(
                            [
                                ['key' => 'field_cg_overline', 'label' => 'Overline',  'name' => 'overline', 'type' => 'text'],
                                ['key' => 'field_cg_heading',  'label' => 'Heading',   'name' => 'heading',  'type' => 'text'],
                                ['key' => 'field_cg_columns',  'label' => 'Columns',   'name' => 'columns',  'type' => 'select', 'choices' => ['2' => '2 Columns', '3' => '3 Columns', '4' => '4 Columns'], 'default_value' => '3'],
                                ['key' => 'field_cg_featured', 'label' => 'Featured First Card', 'name' => 'featured_first', 'type' => 'true_false', 'instructions' => 'First card spans full width with dark background.'],
                                [
                                    'key'        => 'field_cg_cards',
                                    'label'      => 'Cards',
                                    'name'       => 'cards',
                                    'type'       => 'repeater',
                                    'layout'     => 'block',
                                    'button_label' => 'Add Card',
                                    'sub_fields' => [
                                        ['key' => 'field_cg_card_icon',  'label' => 'Icon',        'name' => 'icon',        'type' => 'image', 'return_format' => 'array', 'instructions' => 'Upload SVG or image for card icon.'],
                                        ['key' => 'field_cg_card_svg',   'label' => 'SVG Code',    'name' => 'svg_code',    'type' => 'textarea', 'rows' => 3, 'instructions' => 'Paste raw SVG markup. Used if no icon image is uploaded.'],
                                        ['key' => 'field_cg_card_tag',   'label' => 'Tag Label',   'name' => 'tag_label',   'type' => 'text', 'instructions' => 'Small tag above title (e.g., "The Centerpiece"). Only shows on featured cards.'],
                                        ['key' => 'field_cg_card_title', 'label' => 'Title',       'name' => 'title',       'type' => 'text', 'required' => 1],
                                        ['key' => 'field_cg_card_desc',  'label' => 'Description', 'name' => 'description', 'type' => 'textarea'],
                                        ['key' => 'field_cg_card_link',  'label' => 'Link',        'name' => 'link',        'type' => 'link'],
                                    ],
                                ],
                            ],
                            stretch_section_settings_fields('cg')
                        ),
                    ],

                    // ── 4. Pull Quote Banner ──
                    'pull-quote-banner' => [
                        'key'        => 'layout_pull_quote',
                        'name'       => 'pull-quote-banner',
                        'label'      => 'Pull Quote Banner',
                        'sub_fields' => [
                            ['key' => 'field_pq_quote',  'label' => 'Quote Text',    'name' => 'quote_text',   'type' => 'textarea', 'required' => 1],
                            ['key' => 'field_pq_accent', 'label' => 'Accent Phrase', 'name' => 'accent_phrase', 'type' => 'text', 'instructions' => 'Word(s) to highlight in cyan.'],
                        ],
                    ],

                    // ── 5. Logo Carousel ──
                    'logo-carousel' => [
                        'key'        => 'layout_logo_carousel',
                        'name'       => 'logo-carousel',
                        'label'      => 'Logo Carousel',
                        'sub_fields' => array_merge(
                            [
                                ['key' => 'field_lc_heading',    'label' => 'Heading',    'name' => 'heading',    'type' => 'text'],
                                ['key' => 'field_lc_subheading', 'label' => 'Subheading', 'name' => 'subheading', 'type' => 'text'],
                                [
                                    'key'          => 'field_lc_logos',
                                    'label'        => 'Logos',
                                    'name'         => 'logos',
                                    'type'         => 'repeater',
                                    'layout'       => 'table',
                                    'button_label' => 'Add Logo',
                                    'sub_fields'   => [
                                        ['key' => 'field_lc_logo_image', 'label' => 'Logo Image',   'name' => 'logo_image',   'type' => 'image', 'return_format' => 'array'],
                                        ['key' => 'field_lc_logo_name',  'label' => 'Company Name', 'name' => 'company_name', 'type' => 'text'],
                                    ],
                                ],
                            ],
                            stretch_section_settings_fields('lc')
                        ),
                    ],

                    // ── 6. Testimonials ──
                    'testimonials' => [
                        'key'        => 'layout_testimonials',
                        'name'       => 'testimonials',
                        'label'      => 'Testimonials',
                        'sub_fields' => array_merge(
                            [
                                [
                                    'key'          => 'field_tm_items',
                                    'label'        => 'Testimonials',
                                    'name'         => 'testimonials',
                                    'type'         => 'repeater',
                                    'layout'       => 'block',
                                    'button_label' => 'Add Testimonial',
                                    'sub_fields'   => [
                                        ['key' => 'field_tm_quote',   'label' => 'Quote',   'name' => 'quote',   'type' => 'textarea', 'required' => 1],
                                        ['key' => 'field_tm_name',    'label' => 'Name',    'name' => 'name',    'type' => 'text',     'required' => 1],
                                        ['key' => 'field_tm_title',   'label' => 'Title',   'name' => 'title',   'type' => 'text'],
                                        ['key' => 'field_tm_company', 'label' => 'Company', 'name' => 'company', 'type' => 'text'],
                                        ['key' => 'field_tm_photo',   'label' => 'Photo',   'name' => 'photo',   'type' => 'image', 'return_format' => 'array'],
                                    ],
                                ],
                            ],
                            stretch_section_settings_fields('tm')
                        ),
                    ],

                    // ── 7. Process Steps ──
                    'process-steps' => [
                        'key'        => 'layout_process_steps',
                        'name'       => 'process-steps',
                        'label'      => 'Process Steps',
                        'sub_fields' => array_merge(
                            [
                                ['key' => 'field_ps_overline', 'label' => 'Overline', 'name' => 'overline', 'type' => 'text'],
                                ['key' => 'field_ps_heading',  'label' => 'Heading',  'name' => 'heading',  'type' => 'text'],
                                [
                                    'key'          => 'field_ps_steps',
                                    'label'        => 'Steps',
                                    'name'         => 'steps',
                                    'type'         => 'repeater',
                                    'layout'       => 'block',
                                    'button_label' => 'Add Step',
                                    'sub_fields'   => [
                                        ['key' => 'field_ps_step_title', 'label' => 'Title',       'name' => 'title',       'type' => 'text', 'required' => 1],
                                        ['key' => 'field_ps_step_desc',  'label' => 'Description', 'name' => 'description', 'type' => 'textarea'],
                                        ['key' => 'field_ps_step_icon',  'label' => 'Icon',        'name' => 'icon',        'type' => 'image', 'return_format' => 'array'],
                                    ],
                                ],
                            ],
                            stretch_section_settings_fields('ps')
                        ),
                    ],

                    // ── 8. CTA Section ──
                    'cta-section' => [
                        'key'        => 'layout_cta_section',
                        'name'       => 'cta-section',
                        'label'      => 'CTA Section',
                        'sub_fields' => [
                            ['key' => 'field_cta_heading',   'label' => 'Heading',          'name' => 'heading',        'type' => 'text',     'required' => 1],
                            ['key' => 'field_cta_body',      'label' => 'Body Text',        'name' => 'body_text',      'type' => 'textarea'],
                            ['key' => 'field_cta_button',    'label' => 'CTA Button',       'name' => 'cta_button',     'type' => 'link',     'required' => 1],
                            ['key' => 'field_cta_button2',   'label' => 'Secondary Button', 'name' => 'secondary_button', 'type' => 'link'],
                            ['key' => 'field_cta_bg',        'label' => 'Background',       'name' => 'bg_style',       'type' => 'select',   'choices' => ['purple' => 'Purple', 'dark' => 'Dark', 'custom' => 'Custom Color'], 'default_value' => 'purple'],
                            ['key' => 'field_cta_bg_custom', 'label' => 'Custom Background Color', 'name' => 'custom_bg_color', 'type' => 'color_picker', 'conditional_logic' => [[ ['field' => 'field_cta_bg', 'operator' => '==', 'value' => 'custom'] ]]],
                        ],
                    ],

                    // ── 9. Image + Text ──
                    'image-text' => [
                        'key'        => 'layout_image_text',
                        'name'       => 'image-text',
                        'label'      => 'Image + Text',
                        'sub_fields' => array_merge(
                            [
                                ['key' => 'field_it_image',     'label' => 'Image',          'name' => 'image',          'type' => 'image', 'return_format' => 'array', 'required' => 1],
                                ['key' => 'field_it_position',  'label' => 'Image Position', 'name' => 'image_position', 'type' => 'select', 'choices' => ['left' => 'Left', 'right' => 'Right'], 'default_value' => 'right'],
                                ['key' => 'field_it_overline',  'label' => 'Overline',       'name' => 'overline',       'type' => 'text'],
                                ['key' => 'field_it_heading',   'label' => 'Heading',        'name' => 'heading',        'type' => 'text'],
                                ['key' => 'field_it_body',      'label' => 'Body',           'name' => 'body_content',   'type' => 'wysiwyg', 'toolbar' => 'full'],
                                ['key' => 'field_it_cta',       'label' => 'CTA Button',     'name' => 'cta_button',     'type' => 'link'],
                            ],
                            stretch_section_settings_fields('it')
                        ),
                    ],

                    // ── 10. Accordion / FAQ ──
                    'accordion-faq' => [
                        'key'        => 'layout_accordion_faq',
                        'name'       => 'accordion-faq',
                        'label'      => 'Accordion / FAQ',
                        'sub_fields' => array_merge(
                            [
                                ['key' => 'field_faq_heading', 'label' => 'Heading', 'name' => 'heading', 'type' => 'text'],
                                [
                                    'key'          => 'field_faq_items',
                                    'label'        => 'Items',
                                    'name'         => 'items',
                                    'type'         => 'repeater',
                                    'layout'       => 'block',
                                    'button_label' => 'Add Item',
                                    'sub_fields'   => [
                                        ['key' => 'field_faq_q', 'label' => 'Question / Title', 'name' => 'question', 'type' => 'text',    'required' => 1],
                                        ['key' => 'field_faq_a', 'label' => 'Answer / Content', 'name' => 'answer',   'type' => 'wysiwyg', 'toolbar' => 'basic', 'media_upload' => 0],
                                    ],
                                ],
                            ],
                            stretch_section_settings_fields('faq')
                        ),
                    ],

                    // ── 11. Team Grid ──
                    'team-grid' => [
                        'key'        => 'layout_team_grid',
                        'name'       => 'team-grid',
                        'label'      => 'Team Grid',
                        'sub_fields' => array_merge(
                            [
                                ['key' => 'field_tg_heading', 'label' => 'Heading',    'name' => 'heading',    'type' => 'text'],
                                ['key' => 'field_tg_intro',   'label' => 'Intro Text', 'name' => 'intro_text', 'type' => 'textarea'],
                                [
                                    'key'          => 'field_tg_members',
                                    'label'        => 'Team Members',
                                    'name'         => 'team_members',
                                    'type'         => 'repeater',
                                    'layout'       => 'block',
                                    'button_label' => 'Add Member',
                                    'sub_fields'   => [
                                        ['key' => 'field_tg_photo', 'label' => 'Photo', 'name' => 'photo', 'type' => 'image', 'return_format' => 'array'],
                                        ['key' => 'field_tg_name',  'label' => 'Name',  'name' => 'name',  'type' => 'text', 'required' => 1],
                                        ['key' => 'field_tg_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'],
                                        ['key' => 'field_tg_bio',   'label' => 'Bio',   'name' => 'bio',   'type' => 'textarea'],
                                    ],
                                ],
                            ],
                            stretch_section_settings_fields('tg')
                        ),
                    ],

                    // ── 12. Contact Block ──
                    'contact-block' => [
                        'key'        => 'layout_contact_block',
                        'name'       => 'contact-block',
                        'label'      => 'Contact Block',
                        'sub_fields' => array_merge(
                            [
                                ['key' => 'field_ct_heading',   'label' => 'Heading',        'name' => 'heading',        'type' => 'text'],
                                ['key' => 'field_ct_address',   'label' => 'Address',        'name' => 'address',        'type' => 'textarea'],
                                ['key' => 'field_ct_phone',     'label' => 'Phone',          'name' => 'phone',          'type' => 'text'],
                                ['key' => 'field_ct_email',     'label' => 'Email',          'name' => 'email',          'type' => 'email'],
                                [
                                    'key'          => 'field_ct_social',
                                    'label'        => 'Social Links',
                                    'name'         => 'social_links',
                                    'type'         => 'repeater',
                                    'layout'       => 'table',
                                    'button_label' => 'Add Link',
                                    'sub_fields'   => [
                                        ['key' => 'field_ct_social_platform', 'label' => 'Platform', 'name' => 'platform', 'type' => 'select', 'choices' => ['linkedin' => 'LinkedIn', 'twitter' => 'Twitter/X', 'instagram' => 'Instagram', 'facebook' => 'Facebook']],
                                        ['key' => 'field_ct_social_url',      'label' => 'URL',      'name' => 'url',      'type' => 'url'],
                                    ],
                                ],
                                ['key' => 'field_ct_form',   'label' => 'Form Shortcode', 'name' => 'form_shortcode', 'type' => 'text', 'instructions' => 'Paste the form plugin shortcode (e.g., [wpforms id="123"]).'],
                                ['key' => 'field_ct_layout', 'label' => 'Layout',         'name' => 'layout',         'type' => 'select', 'choices' => ['form-right' => 'Form Right', 'form-left' => 'Form Left'], 'default_value' => 'form-right'],
                            ],
                            stretch_section_settings_fields('ct')
                        ),
                    ],

                    // ── 13. Blog Preview ──
                    'blog-preview' => [
                        'key'        => 'layout_blog_preview',
                        'name'       => 'blog-preview',
                        'label'      => 'Blog Preview',
                        'sub_fields' => array_merge(
                            [
                                ['key' => 'field_bp_heading',    'label' => 'Heading',             'name' => 'heading',      'type' => 'text'],
                                ['key' => 'field_bp_subheading', 'label' => 'Subheading',          'name' => 'subheading',   'type' => 'text'],
                                ['key' => 'field_bp_count',      'label' => 'Number of Posts',     'name' => 'post_count',   'type' => 'number', 'default_value' => 3, 'min' => 1, 'max' => 12],
                                ['key' => 'field_bp_category',   'label' => 'Category Filter',     'name' => 'category',     'type' => 'taxonomy', 'taxonomy' => 'category', 'field_type' => 'select', 'allow_null' => 1, 'return_format' => 'id'],
                                ['key' => 'field_bp_filters',    'label' => 'Show Filter Buttons', 'name' => 'show_filters', 'type' => 'true_false'],
                            ],
                            stretch_section_settings_fields('bp')
                        ),
                    ],

                ], // end layouts
            ],
        ],
        'location' => [
            [['param' => 'post_type', 'operator' => '==', 'value' => 'page']],
        ],
        'style'           => 'seamless',
        'label_placement' => 'top',
    ]);
});
```

- [ ] **Step 2: Commit**

```bash
git add stretch-theme/inc/acf-fields.php
git commit -m "feat: register ACF Flexible Content with all 13 section layouts"
```

---

### Task 9: Section Templates — Hero, Content Block, Pull Quote, CTA

**Files:**
- Create: `stretch-theme/template-parts/sections/hero.php`
- Create: `stretch-theme/template-parts/sections/content-block.php`
- Create: `stretch-theme/template-parts/sections/pull-quote-banner.php`
- Create: `stretch-theme/template-parts/sections/cta-section.php`

- [ ] **Step 1: Create hero.php**

Create `stretch-theme/template-parts/sections/hero.php`:

```php
<?php
/**
 * Section: Hero
 */
$overline   = get_sub_field('overline');
$headline   = get_sub_field('headline');
$accent     = get_sub_field('accent_text');
$subtitle   = get_sub_field('subtitle');
$supporting = get_sub_field('supporting_text');
$cta        = get_sub_field('cta_button');
$cta2       = get_sub_field('secondary_cta');
$bg_image   = get_sub_field('bg_image');
$bg_video   = get_sub_field('bg_video');
$shapes     = get_sub_field('show_shapes');

$style = $bg_image ? "background-image:url(" . esc_url($bg_image) . ");background-size:cover;background-position:center;" : '';
?>

<section class="hero" aria-label="<?php echo esc_attr($headline); ?>"<?php echo $style ? ' style="' . $style . '"' : ''; ?>>
  <?php if ($bg_video) : ?>
    <video class="hero-mesh" autoplay muted loop playsinline style="opacity:0.3;object-fit:cover;width:100%;height:100%;">
      <source src="<?php echo esc_url($bg_video); ?>" type="video/mp4">
    </video>
  <?php elseif (!$bg_image) : ?>
    <div class="hero-mesh"></div>
  <?php endif; ?>

  <?php if ($shapes) : ?>
    <div class="hero-shapes">
      <div class="shape shape-1"></div>
      <div class="shape shape-2"></div>
      <div class="shape shape-3"></div>
      <div class="shape shape-4"></div>
      <div class="shape shape-5"></div>
      <div class="shape shape-6"></div>
    </div>
  <?php endif; ?>

  <div class="container">
    <?php if ($overline) : ?>
      <span class="overline"><?php echo esc_html($overline); ?></span>
    <?php endif; ?>

    <h1>
      <?php
      if ($accent && str_contains($headline, $accent)) {
          echo wp_kses_post(str_replace($accent, '<span class="accent">' . esc_html($accent) . '</span>', esc_html($headline)));
      } else {
          echo esc_html($headline);
      }
      ?>
    </h1>

    <?php if ($subtitle) : ?>
      <p class="subtitle"><?php echo esc_html($subtitle); ?></p>
    <?php endif; ?>

    <?php if ($supporting) : ?>
      <p class="supporting"><?php echo esc_html($supporting); ?></p>
    <?php endif; ?>

    <?php if ($cta) : ?>
      <a href="<?php echo esc_url($cta['url']); ?>" class="btn-primary"<?php echo $cta['target'] ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo esc_html($cta['title']); ?></a>
    <?php endif; ?>

    <?php if ($cta2) : ?>
      <a href="<?php echo esc_url($cta2['url']); ?>" class="btn-white" style="margin-left:16px;"<?php echo $cta2['target'] ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo esc_html($cta2['title']); ?></a>
    <?php endif; ?>
  </div>
</section>
<div class="hero-accent-bar"></div>
```

- [ ] **Step 2: Create content-block.php**

Create `stretch-theme/template-parts/sections/content-block.php`:

```php
<?php
/**
 * Section: Content Block
 */
$sec       = stretch_section_classes();
$overline  = get_sub_field('overline');
$heading   = get_sub_field('heading');
$body      = get_sub_field('body_content');
$highlight = get_sub_field('pull_highlight');
$width     = get_sub_field('max_width') ?: 'normal';
?>

<section class="<?php echo esc_attr($sec['class']); ?>"<?php echo $sec['id'] ? ' id="' . $sec['id'] . '"' : ''; ?><?php echo $sec['style'] ? ' style="' . $sec['style'] . '"' : ''; ?>>
  <div class="container">
    <?php if ($overline) : ?>
      <span class="overline reveal"><?php echo esc_html($overline); ?></span>
    <?php endif; ?>

    <?php if ($heading) : ?>
      <h2 class="reveal"><?php echo esc_html($heading); ?></h2>
    <?php endif; ?>

    <div class="body-content<?php echo $width === 'wide' ? ' wide' : ''; ?>">
      <?php if ($body) : ?>
        <div class="reveal"><?php echo wp_kses_post($body); ?></div>
      <?php endif; ?>

      <?php if ($highlight) : ?>
        <div class="pull-highlight reveal"><?php echo esc_html($highlight); ?></div>
      <?php endif; ?>
    </div>
  </div>
</section>
```

- [ ] **Step 3: Create pull-quote-banner.php**

Create `stretch-theme/template-parts/sections/pull-quote-banner.php`:

```php
<?php
/**
 * Section: Pull Quote Banner
 */
$quote  = get_sub_field('quote_text');
$accent = get_sub_field('accent_phrase');
?>

<div class="pull-quote-banner">
  <div class="container">
    <blockquote class="reveal">
      <?php
      if ($accent && str_contains($quote, $accent)) {
          echo wp_kses_post(str_replace(
              $accent,
              '<span class="quote-accent">' . esc_html($accent) . '</span>',
              esc_html($quote)
          ));
      } else {
          echo esc_html($quote);
      }
      ?>
    </blockquote>
  </div>
</div>
```

- [ ] **Step 4: Create cta-section.php**

Create `stretch-theme/template-parts/sections/cta-section.php`:

```php
<?php
/**
 * Section: CTA Section
 */
$heading   = get_sub_field('heading');
$body      = get_sub_field('body_text');
$cta       = get_sub_field('cta_button');
$cta2      = get_sub_field('secondary_button');
$bg_style  = get_sub_field('bg_style') ?: 'purple';
$custom_bg = get_sub_field('custom_bg_color');

$class = 'cta-close';
$style = '';
if ($bg_style === 'dark') {
    $style = 'background:var(--color-dark);';
} elseif ($bg_style === 'custom' && $custom_bg) {
    $style = 'background:' . esc_attr($custom_bg) . ';';
}
?>

<section class="<?php echo esc_attr($class); ?>"<?php echo $style ? ' style="' . $style . '"' : ''; ?>>
  <div class="container">
    <h2 class="reveal"><?php echo wp_kses_post($heading); ?></h2>

    <?php if ($body) : ?>
      <p class="reveal"><?php echo esc_html($body); ?></p>
    <?php endif; ?>

    <?php if ($cta) : ?>
      <a href="<?php echo esc_url($cta['url']); ?>" class="btn-white reveal"<?php echo $cta['target'] ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo esc_html($cta['title']); ?></a>
    <?php endif; ?>

    <?php if ($cta2) : ?>
      <a href="<?php echo esc_url($cta2['url']); ?>" class="btn-primary reveal" style="margin-left:16px;"<?php echo $cta2['target'] ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo esc_html($cta2['title']); ?></a>
    <?php endif; ?>
  </div>
</section>
```

- [ ] **Step 5: Commit**

```bash
git add stretch-theme/template-parts/sections/hero.php stretch-theme/template-parts/sections/content-block.php stretch-theme/template-parts/sections/pull-quote-banner.php stretch-theme/template-parts/sections/cta-section.php
git commit -m "feat: add section templates — hero, content block, pull quote banner, CTA"
```

---

### Task 10: Section Templates — Card Grid, Process Steps, Accordion

**Files:**
- Create: `stretch-theme/template-parts/sections/card-grid.php`
- Create: `stretch-theme/template-parts/sections/process-steps.php`
- Create: `stretch-theme/template-parts/sections/accordion-faq.php`

- [ ] **Step 1: Create card-grid.php**

Create `stretch-theme/template-parts/sections/card-grid.php`:

```php
<?php
/**
 * Section: Card Grid
 */
$sec      = stretch_section_classes();
$overline = get_sub_field('overline');
$heading  = get_sub_field('heading');
$columns  = get_sub_field('columns') ?: '3';
$featured = get_sub_field('featured_first');
$cards    = get_sub_field('cards');
?>

<section class="<?php echo esc_attr($sec['class']); ?>"<?php echo $sec['id'] ? ' id="' . $sec['id'] . '"' : ''; ?><?php echo $sec['style'] ? ' style="' . $sec['style'] . '"' : ''; ?>>
  <div class="container">
    <?php if ($overline) : ?>
      <span class="overline reveal"><?php echo esc_html($overline); ?></span>
    <?php endif; ?>

    <?php if ($heading) : ?>
      <h2 class="reveal"><?php echo esc_html($heading); ?></h2>
    <?php endif; ?>

    <?php if ($cards) : ?>
      <div class="features-grid cols-<?php echo esc_attr($columns); ?>">
        <?php foreach ($cards as $i => $card) :
          $is_featured = ($featured && $i === 0);
          $delay = min($i + 1, 6);
        ?>
          <?php if ($is_featured) : ?>
            <div class="feature-card-featured reveal">
              <div>
                <?php if ($card['tag_label']) : ?>
                  <div class="featured-tag"><?php echo esc_html($card['tag_label']); ?></div>
                <?php endif; ?>
                <h3><?php echo esc_html($card['title']); ?></h3>
                <?php if ($card['description']) : ?>
                  <p><?php echo wp_kses_post(nl2br(esc_html($card['description']))); ?></p>
                <?php endif; ?>
              </div>
              <div>
                <?php if ($card['icon']) : ?>
                  <div class="feature-icon"><?php echo wp_get_attachment_image($card['icon']['ID'], 'medium'); ?></div>
                <?php elseif ($card['svg_code']) : ?>
                  <div class="feature-icon"><?php echo $card['svg_code']; ?></div>
                <?php endif; ?>
              </div>
            </div>
          <?php else : ?>
            <div class="feature-card reveal reveal-delay-<?php echo esc_attr($delay); ?>">
              <?php if ($card['icon']) : ?>
                <div class="feature-icon"><?php echo wp_get_attachment_image($card['icon']['ID'], 'thumbnail'); ?></div>
              <?php elseif ($card['svg_code']) : ?>
                <div class="feature-icon"><?php echo $card['svg_code']; ?></div>
              <?php endif; ?>
              <h3><?php echo esc_html($card['title']); ?></h3>
              <?php if ($card['description']) : ?>
                <p><?php echo esc_html($card['description']); ?></p>
              <?php endif; ?>
              <?php if ($card['link']) : ?>
                <a href="<?php echo esc_url($card['link']['url']); ?>" class="blog-card-readmore"<?php echo $card['link']['target'] ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo esc_html($card['link']['title']); ?> &rarr;</a>
              <?php endif; ?>
            </div>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
```

- [ ] **Step 2: Create process-steps.php**

Create `stretch-theme/template-parts/sections/process-steps.php`:

```php
<?php
/**
 * Section: Process Steps
 */
$sec      = stretch_section_classes();
$overline = get_sub_field('overline');
$heading  = get_sub_field('heading');
$steps    = get_sub_field('steps');
?>

<section class="<?php echo esc_attr($sec['class']); ?>"<?php echo $sec['id'] ? ' id="' . $sec['id'] . '"' : ''; ?><?php echo $sec['style'] ? ' style="' . $sec['style'] . '"' : ''; ?>>
  <div class="container">
    <?php if ($overline) : ?>
      <span class="overline reveal"><?php echo esc_html($overline); ?></span>
    <?php endif; ?>

    <?php if ($heading) : ?>
      <h2 class="reveal"><?php echo esc_html($heading); ?></h2>
    <?php endif; ?>

    <?php if ($steps) : ?>
      <div class="process-steps">
        <?php foreach ($steps as $i => $step) : ?>
          <div class="process-step reveal">
            <div class="step-marker">
              <div class="step-number"><?php echo str_pad($i + 1, 2, '0', STR_PAD_LEFT); ?></div>
            </div>
            <div class="step-content">
              <h3><?php echo esc_html($step['title']); ?></h3>
              <?php if ($step['description']) : ?>
                <span class="step-desc"><?php echo esc_html($step['description']); ?></span>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
```

- [ ] **Step 3: Create accordion-faq.php**

Create `stretch-theme/template-parts/sections/accordion-faq.php`:

```php
<?php
/**
 * Section: Accordion / FAQ
 */
$sec     = stretch_section_classes();
$heading = get_sub_field('heading');
$items   = get_sub_field('items');
$uid     = 'faq-' . uniqid();
?>

<section class="<?php echo esc_attr($sec['class']); ?>"<?php echo $sec['id'] ? ' id="' . $sec['id'] . '"' : ''; ?><?php echo $sec['style'] ? ' style="' . $sec['style'] . '"' : ''; ?>>
  <div class="container">
    <?php if ($heading) : ?>
      <h2 class="reveal"><?php echo esc_html($heading); ?></h2>
    <?php endif; ?>

    <?php if ($items) : ?>
      <div class="body-content">
        <?php foreach ($items as $i => $item) :
          $panel_id = $uid . '-panel-' . $i;
          $trigger_id = $uid . '-trigger-' . $i;
        ?>
          <div class="accordion-item reveal">
            <button
              class="accordion-trigger"
              id="<?php echo esc_attr($trigger_id); ?>"
              aria-expanded="false"
              aria-controls="<?php echo esc_attr($panel_id); ?>"
            >
              <?php echo esc_html($item['question']); ?>
              <span class="accordion-icon" aria-hidden="true"></span>
            </button>
            <div
              class="accordion-panel"
              id="<?php echo esc_attr($panel_id); ?>"
              role="region"
              aria-labelledby="<?php echo esc_attr($trigger_id); ?>"
            >
              <div class="accordion-panel-inner">
                <?php echo wp_kses_post($item['answer']); ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
```

- [ ] **Step 4: Commit**

```bash
git add stretch-theme/template-parts/sections/card-grid.php stretch-theme/template-parts/sections/process-steps.php stretch-theme/template-parts/sections/accordion-faq.php
git commit -m "feat: add section templates — card grid, process steps, accordion/FAQ"
```

---

### Task 11: Section Templates — Logo Carousel, Testimonials, Image+Text

**Files:**
- Create: `stretch-theme/template-parts/sections/logo-carousel.php`
- Create: `stretch-theme/template-parts/sections/testimonials.php`
- Create: `stretch-theme/template-parts/sections/image-text.php`

- [ ] **Step 1: Create logo-carousel.php**

Create `stretch-theme/template-parts/sections/logo-carousel.php`:

```php
<?php
/**
 * Section: Logo Carousel
 */
$sec        = stretch_section_classes();
$heading    = get_sub_field('heading');
$subheading = get_sub_field('subheading');
$logos      = get_sub_field('logos');
?>

<section class="<?php echo esc_attr($sec['class']); ?>"<?php echo $sec['id'] ? ' id="' . $sec['id'] . '"' : ''; ?><?php echo $sec['style'] ? ' style="' . $sec['style'] . '"' : ''; ?>>
  <div class="container" style="text-align:center;">
    <?php if ($heading) : ?>
      <h2 class="reveal"><?php echo esc_html($heading); ?></h2>
    <?php endif; ?>
    <?php if ($subheading) : ?>
      <p class="reveal"><?php echo esc_html($subheading); ?></p>
    <?php endif; ?>

    <?php if ($logos) : ?>
      <div class="logo-carousel reveal">
        <?php foreach ($logos as $logo) : ?>
          <?php if ($logo['logo_image']) : ?>
            <img
              src="<?php echo esc_url($logo['logo_image']['url']); ?>"
              alt="<?php echo esc_attr($logo['company_name'] ?: $logo['logo_image']['alt']); ?>"
              loading="lazy"
            >
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
```

- [ ] **Step 2: Create testimonials.php**

Create `stretch-theme/template-parts/sections/testimonials.php`:

```php
<?php
/**
 * Section: Testimonials Carousel
 */
$sec          = stretch_section_classes();
$testimonials = get_sub_field('testimonials');
?>

<section class="<?php echo esc_attr($sec['class']); ?>"<?php echo $sec['id'] ? ' id="' . $sec['id'] . '"' : ''; ?><?php echo $sec['style'] ? ' style="' . $sec['style'] . '"' : ''; ?>>
  <div class="container">
    <?php if ($testimonials) : ?>
      <div class="testimonials-carousel reveal" aria-label="<?php esc_attr_e('Testimonials', 'stretch'); ?>">
        <div class="testimonials-track">
          <?php foreach ($testimonials as $t) : ?>
            <div class="testimonial-slide">
              <?php if ($t['photo']) : ?>
                <div class="testimonial-photo">
                  <img src="<?php echo esc_url($t['photo']['sizes']['thumbnail']); ?>" alt="<?php echo esc_attr($t['name']); ?>" loading="lazy">
                </div>
              <?php endif; ?>
              <blockquote class="testimonial-quote">&ldquo;<?php echo esc_html($t['quote']); ?>&rdquo;</blockquote>
              <div class="testimonial-author"><?php echo esc_html($t['name']); ?></div>
              <?php if ($t['title'] || $t['company']) : ?>
                <div class="testimonial-role">
                  <?php echo esc_html(implode(', ', array_filter([$t['title'], $t['company']]))); ?>
                </div>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
        <div class="testimonials-dots" role="tablist" aria-label="<?php esc_attr_e('Testimonial navigation', 'stretch'); ?>">
          <?php foreach ($testimonials as $i => $t) : ?>
            <button class="testimonials-dot<?php echo $i === 0 ? ' active' : ''; ?>" role="tab" aria-label="<?php printf(esc_attr__('Testimonial %d', 'stretch'), $i + 1); ?>"></button>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>
```

- [ ] **Step 3: Create image-text.php**

Create `stretch-theme/template-parts/sections/image-text.php`:

```php
<?php
/**
 * Section: Image + Text
 */
$sec      = stretch_section_classes();
$image    = get_sub_field('image');
$position = get_sub_field('image_position') ?: 'right';
$overline = get_sub_field('overline');
$heading  = get_sub_field('heading');
$body     = get_sub_field('body_content');
$cta      = get_sub_field('cta_button');
?>

<section class="<?php echo esc_attr($sec['class']); ?>"<?php echo $sec['id'] ? ' id="' . $sec['id'] . '"' : ''; ?><?php echo $sec['style'] ? ' style="' . $sec['style'] . '"' : ''; ?>>
  <div class="container">
    <div class="image-text-layout image-<?php echo esc_attr($position); ?> reveal">
      <div class="image-text-content">
        <?php if ($overline) : ?>
          <span class="overline"><?php echo esc_html($overline); ?></span>
        <?php endif; ?>

        <?php if ($heading) : ?>
          <h2><?php echo esc_html($heading); ?></h2>
        <?php endif; ?>

        <?php if ($body) : ?>
          <?php echo wp_kses_post($body); ?>
        <?php endif; ?>

        <?php if ($cta) : ?>
          <a href="<?php echo esc_url($cta['url']); ?>" class="btn-primary"<?php echo $cta['target'] ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo esc_html($cta['title']); ?></a>
        <?php endif; ?>
      </div>
      <div class="image-text-media">
        <?php if ($image) : ?>
          <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" loading="lazy">
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
```

- [ ] **Step 4: Commit**

```bash
git add stretch-theme/template-parts/sections/logo-carousel.php stretch-theme/template-parts/sections/testimonials.php stretch-theme/template-parts/sections/image-text.php
git commit -m "feat: add section templates — logo carousel, testimonials, image+text"
```

---

### Task 12: Section Templates — Team Grid, Contact Block, Blog Preview

**Files:**
- Create: `stretch-theme/template-parts/sections/team-grid.php`
- Create: `stretch-theme/template-parts/sections/contact-block.php`
- Create: `stretch-theme/template-parts/sections/blog-preview.php`

- [ ] **Step 1: Create team-grid.php**

Create `stretch-theme/template-parts/sections/team-grid.php`:

```php
<?php
/**
 * Section: Team Grid
 */
$sec     = stretch_section_classes();
$heading = get_sub_field('heading');
$intro   = get_sub_field('intro_text');
$members = get_sub_field('team_members');
?>

<section class="<?php echo esc_attr($sec['class']); ?>"<?php echo $sec['id'] ? ' id="' . $sec['id'] . '"' : ''; ?><?php echo $sec['style'] ? ' style="' . $sec['style'] . '"' : ''; ?>>
  <div class="container">
    <?php if ($heading) : ?>
      <h2 class="reveal"><?php echo esc_html($heading); ?></h2>
    <?php endif; ?>

    <?php if ($intro) : ?>
      <p class="reveal" style="max-width:700px;"><?php echo esc_html($intro); ?></p>
    <?php endif; ?>

    <?php if ($members) : ?>
      <div class="team-grid">
        <?php foreach ($members as $i => $m) :
          $delay = min($i + 1, 6);
        ?>
          <div class="team-card reveal reveal-delay-<?php echo esc_attr($delay); ?>">
            <div class="team-card-photo">
              <?php if ($m['photo']) : ?>
                <img src="<?php echo esc_url($m['photo']['sizes']['team-photo']); ?>" alt="<?php echo esc_attr($m['name']); ?>" loading="lazy">
              <?php endif; ?>
            </div>
            <div class="team-card-info">
              <div class="team-card-name"><?php echo esc_html($m['name']); ?></div>
              <?php if ($m['title']) : ?>
                <div class="team-card-title"><?php echo esc_html($m['title']); ?></div>
              <?php endif; ?>
            </div>
            <?php if ($m['bio']) : ?>
              <div class="team-card-bio-overlay">
                <p><?php echo esc_html($m['bio']); ?></p>
              </div>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
```

- [ ] **Step 2: Create contact-block.php**

Create `stretch-theme/template-parts/sections/contact-block.php`:

```php
<?php
/**
 * Section: Contact Block
 */
$sec     = stretch_section_classes();
$heading = get_sub_field('heading');
$address = get_sub_field('address');
$phone   = get_sub_field('phone');
$email   = get_sub_field('email');
$social  = get_sub_field('social_links');
$form    = get_sub_field('form_shortcode');
$layout  = get_sub_field('layout') ?: 'form-right';
?>

<section class="<?php echo esc_attr($sec['class']); ?>"<?php echo $sec['id'] ? ' id="' . $sec['id'] . '"' : ''; ?><?php echo $sec['style'] ? ' style="' . $sec['style'] . '"' : ''; ?>>
  <div class="container">
    <?php if ($heading) : ?>
      <h2 class="reveal"><?php echo esc_html($heading); ?></h2>
    <?php endif; ?>

    <div class="contact-layout <?php echo esc_attr($layout); ?> reveal">
      <div class="contact-info">
        <?php if ($address) : ?>
          <address><?php echo wp_kses_post(nl2br(esc_html($address))); ?></address>
        <?php endif; ?>

        <?php if ($phone) : ?>
          <p><a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a></p>
        <?php endif; ?>

        <?php if ($email) : ?>
          <p><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></p>
        <?php endif; ?>

        <?php if ($social) : ?>
          <div class="contact-social">
            <?php foreach ($social as $s) : ?>
              <a href="<?php echo esc_url($s['url']); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr($s['platform']); ?>">
                <?php echo esc_html($s['platform']); ?>
              </a>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

      <div class="contact-form">
        <?php if ($form) : ?>
          <?php echo do_shortcode($form); ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
```

- [ ] **Step 3: Create blog-preview.php**

Create `stretch-theme/template-parts/sections/blog-preview.php`:

```php
<?php
/**
 * Section: Blog Preview
 */
$sec        = stretch_section_classes();
$heading    = get_sub_field('heading');
$subheading = get_sub_field('subheading');
$count      = get_sub_field('post_count') ?: 3;
$category   = get_sub_field('category');
$show_filters = get_sub_field('show_filters');

$args = [
    'post_type'      => 'post',
    'posts_per_page' => $count,
    'post_status'    => 'publish',
];
if ($category) {
    $args['cat'] = $category;
}
$posts = new WP_Query($args);

// Get categories for filter buttons
$cats = get_categories(['hide_empty' => true]);
?>

<section class="<?php echo esc_attr($sec['class']); ?>"<?php echo $sec['id'] ? ' id="' . $sec['id'] . '"' : ''; ?><?php echo $sec['style'] ? ' style="' . $sec['style'] . '"' : ''; ?>>
  <div class="container">
    <?php if ($heading) : ?>
      <h2 class="reveal"><?php echo esc_html($heading); ?></h2>
    <?php endif; ?>

    <?php if ($subheading) : ?>
      <p class="reveal"><?php echo esc_html($subheading); ?></p>
    <?php endif; ?>

    <?php if ($show_filters && $cats) : ?>
      <div class="blog-filters reveal">
        <button class="blog-filter-btn active" data-filter="all"><?php esc_html_e('All', 'stretch'); ?></button>
        <?php foreach ($cats as $cat) : ?>
          <button class="blog-filter-btn" data-filter="<?php echo esc_attr($cat->slug); ?>"><?php echo esc_html($cat->name); ?></button>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php if ($posts->have_posts()) : ?>
      <div class="blog-grid">
        <?php while ($posts->have_posts()) : $posts->the_post();
          $post_cats = get_the_category();
          $first_cat = $post_cats ? $post_cats[0] : null;
        ?>
          <article class="blog-card reveal" data-category="<?php echo $first_cat ? esc_attr($first_cat->slug) : ''; ?>">
            <?php if (has_post_thumbnail()) : ?>
              <a href="<?php the_permalink(); ?>" class="blog-card-image">
                <?php the_post_thumbnail('blog-card'); ?>
              </a>
            <?php endif; ?>
            <div class="blog-card-body">
              <?php if ($first_cat) : ?>
                <span class="blog-card-category"><?php echo esc_html($first_cat->name); ?></span>
              <?php endif; ?>
              <h3 class="blog-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
              <p class="blog-card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
              <a href="<?php the_permalink(); ?>" class="blog-card-readmore"><?php esc_html_e('Read More', 'stretch'); ?> &rarr;</a>
            </div>
          </article>
        <?php endwhile; ?>
      </div>
      <?php wp_reset_postdata(); ?>
    <?php endif; ?>
  </div>
</section>
```

- [ ] **Step 4: Commit**

```bash
git add stretch-theme/template-parts/sections/team-grid.php stretch-theme/template-parts/sections/contact-block.php stretch-theme/template-parts/sections/blog-preview.php
git commit -m "feat: add section templates — team grid, contact block, blog preview"
```

---

### Task 13: Page Templates — front-page, page, index

**Files:**
- Create: `stretch-theme/front-page.php`
- Create: `stretch-theme/page.php`
- Create: `stretch-theme/index.php`

- [ ] **Step 1: Create front-page.php**

Create `stretch-theme/front-page.php`:

```php
<?php
/**
 * Template: Homepage
 * Uses ACF Flexible Content to render page sections.
 */
get_header();
stretch_render_sections();
get_footer();
```

- [ ] **Step 2: Create page.php**

Create `stretch-theme/page.php`:

```php
<?php
/**
 * Template: Standard Page
 * Uses ACF Flexible Content to render page sections.
 * Falls back to standard content if no ACF sections exist.
 */
get_header();

if (function_exists('have_rows') && have_rows('page_sections')) {
    stretch_render_sections();
} else {
    ?>
    <section class="section-white" style="padding-top:160px;">
      <div class="container">
        <div class="body-content">
          <?php
          while (have_posts()) {
              the_post();
              the_content();
          }
          ?>
        </div>
      </div>
    </section>
    <?php
}

get_footer();
```

- [ ] **Step 3: Create index.php**

Create `stretch-theme/index.php`:

```php
<?php
/**
 * Template: Fallback / Blog index
 */
get_header();
?>

<section class="search-header">
  <div class="container">
    <h1><?php esc_html_e('Latest Posts', 'stretch'); ?></h1>
  </div>
</section>

<section class="section-white">
  <div class="container">
    <?php if (have_posts()) : ?>
      <div class="blog-grid">
        <?php while (have_posts()) : the_post();
          $cats = get_the_category();
          $first_cat = $cats ? $cats[0] : null;
        ?>
          <article class="blog-card">
            <?php if (has_post_thumbnail()) : ?>
              <a href="<?php the_permalink(); ?>" class="blog-card-image">
                <?php the_post_thumbnail('blog-card'); ?>
              </a>
            <?php endif; ?>
            <div class="blog-card-body">
              <?php if ($first_cat) : ?>
                <span class="blog-card-category"><?php echo esc_html($first_cat->name); ?></span>
              <?php endif; ?>
              <h3 class="blog-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
              <p class="blog-card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
              <a href="<?php the_permalink(); ?>" class="blog-card-readmore"><?php esc_html_e('Read More', 'stretch'); ?> &rarr;</a>
            </div>
          </article>
        <?php endwhile; ?>
      </div>

      <div class="pagination">
        <?php
        the_posts_pagination([
            'prev_text' => '&laquo;',
            'next_text' => '&raquo;',
        ]);
        ?>
      </div>
    <?php else : ?>
      <p><?php esc_html_e('No posts found.', 'stretch'); ?></p>
    <?php endif; ?>
  </div>
</section>

<?php get_footer(); ?>
```

- [ ] **Step 4: Commit**

```bash
git add stretch-theme/front-page.php stretch-theme/page.php stretch-theme/index.php
git commit -m "feat: add page templates — front-page, page, index (blog fallback)"
```

---

### Task 14: Blog Templates — single.php, archive.php

**Files:**
- Create: `stretch-theme/single.php`
- Create: `stretch-theme/archive.php`

- [ ] **Step 1: Create single.php**

Create `stretch-theme/single.php`:

```php
<?php
/**
 * Template: Single Blog Post
 */
get_header();

while (have_posts()) : the_post();
?>

<header class="single-post-header">
  <div class="container">
    <?php
    $cats = get_the_category();
    if ($cats) : ?>
      <span class="blog-card-category" style="color:var(--color-cyan);">
        <?php echo esc_html($cats[0]->name); ?>
      </span>
    <?php endif; ?>
    <h1><?php the_title(); ?></h1>
    <div class="single-post-meta">
      <?php echo esc_html(get_the_date()); ?> &middot;
      <?php esc_html_e('By', 'stretch'); ?> <?php the_author(); ?>
    </div>
  </div>
</header>
<div class="hero-accent-bar"></div>

<article class="single-post-content">
  <?php if (has_post_thumbnail()) : ?>
    <figure style="margin:0 0 40px;">
      <?php the_post_thumbnail('large'); ?>
    </figure>
  <?php endif; ?>

  <?php the_content(); ?>
</article>

<?php
// Related posts
$related = new WP_Query([
    'post_type'      => 'post',
    'posts_per_page' => 3,
    'post__not_in'   => [get_the_ID()],
    'category__in'   => wp_get_post_categories(get_the_ID()),
    'post_status'    => 'publish',
]);

if ($related->have_posts()) : ?>
  <section class="section-light">
    <div class="container">
      <h2><?php esc_html_e('Related Posts', 'stretch'); ?></h2>
      <div class="blog-grid">
        <?php while ($related->have_posts()) : $related->the_post();
          $r_cats = get_the_category();
          $r_cat = $r_cats ? $r_cats[0] : null;
        ?>
          <article class="blog-card">
            <?php if (has_post_thumbnail()) : ?>
              <a href="<?php the_permalink(); ?>" class="blog-card-image">
                <?php the_post_thumbnail('blog-card'); ?>
              </a>
            <?php endif; ?>
            <div class="blog-card-body">
              <?php if ($r_cat) : ?>
                <span class="blog-card-category"><?php echo esc_html($r_cat->name); ?></span>
              <?php endif; ?>
              <h3 class="blog-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
              <p class="blog-card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
            </div>
          </article>
        <?php endwhile; ?>
      </div>
    </div>
  </section>
  <?php wp_reset_postdata(); ?>
<?php endif; ?>

<?php
endwhile;
get_footer();
```

- [ ] **Step 2: Create archive.php**

Create `stretch-theme/archive.php`:

```php
<?php
/**
 * Template: Blog Archive (category, tag, date archives)
 */
get_header();
?>

<header class="search-header">
  <div class="container">
    <h1>
      <?php
      if (is_category()) {
          single_cat_title();
      } elseif (is_tag()) {
          single_tag_title();
      } elseif (is_author()) {
          the_author();
      } elseif (is_date()) {
          echo get_the_date('F Y');
      } else {
          esc_html_e('Blog', 'stretch');
      }
      ?>
    </h1>
  </div>
</header>
<div class="hero-accent-bar"></div>

<section class="section-white">
  <div class="container">
    <?php
    // Category filter buttons (on main blog page)
    $cats = get_categories(['hide_empty' => true]);
    if ($cats) : ?>
      <div class="blog-filters">
        <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="blog-filter-btn<?php echo !is_category() ? ' active' : ''; ?>"><?php esc_html_e('All', 'stretch'); ?></a>
        <?php foreach ($cats as $cat) : ?>
          <a href="<?php echo esc_url(get_category_link($cat)); ?>" class="blog-filter-btn<?php echo is_category($cat->term_id) ? ' active' : ''; ?>"><?php echo esc_html($cat->name); ?></a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php if (have_posts()) : ?>
      <div class="blog-grid">
        <?php while (have_posts()) : the_post();
          $post_cats = get_the_category();
          $first_cat = $post_cats ? $post_cats[0] : null;
        ?>
          <article class="blog-card">
            <?php if (has_post_thumbnail()) : ?>
              <a href="<?php the_permalink(); ?>" class="blog-card-image">
                <?php the_post_thumbnail('blog-card'); ?>
              </a>
            <?php endif; ?>
            <div class="blog-card-body">
              <?php if ($first_cat) : ?>
                <span class="blog-card-category"><?php echo esc_html($first_cat->name); ?></span>
              <?php endif; ?>
              <h3 class="blog-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
              <p class="blog-card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
              <span class="blog-card-meta"><?php echo esc_html(get_the_date()); ?></span>
            </div>
          </article>
        <?php endwhile; ?>
      </div>

      <div class="pagination">
        <?php
        the_posts_pagination([
            'prev_text' => '&laquo;',
            'next_text' => '&raquo;',
        ]);
        ?>
      </div>
    <?php else : ?>
      <p><?php esc_html_e('No posts found.', 'stretch'); ?></p>
    <?php endif; ?>
  </div>
</section>

<?php get_footer(); ?>
```

- [ ] **Step 3: Commit**

```bash
git add stretch-theme/single.php stretch-theme/archive.php
git commit -m "feat: add blog templates — single post with related posts, archive with filters"
```

---

### Task 15: Utility Templates — search, 404, portal

**Files:**
- Create: `stretch-theme/search.php`
- Create: `stretch-theme/404.php`
- Create: `stretch-theme/page-portal.php`

- [ ] **Step 1: Create search.php**

Create `stretch-theme/search.php`:

```php
<?php
/**
 * Template: Search Results
 */
get_header();
?>

<header class="search-header">
  <div class="container">
    <h1><?php esc_html_e('Search results for:', 'stretch'); ?> <span class="search-query"><?php echo esc_html(get_search_query()); ?></span></h1>
  </div>
</header>
<div class="hero-accent-bar"></div>

<section class="section-white">
  <div class="container">
    <?php if (have_posts()) : ?>
      <div class="blog-grid">
        <?php while (have_posts()) : the_post(); ?>
          <article class="blog-card">
            <?php if (has_post_thumbnail()) : ?>
              <a href="<?php the_permalink(); ?>" class="blog-card-image">
                <?php the_post_thumbnail('blog-card'); ?>
              </a>
            <?php endif; ?>
            <div class="blog-card-body">
              <h3 class="blog-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
              <p class="blog-card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
            </div>
          </article>
        <?php endwhile; ?>
      </div>

      <div class="pagination">
        <?php the_posts_pagination(['prev_text' => '&laquo;', 'next_text' => '&raquo;']); ?>
      </div>
    <?php else : ?>
      <div class="body-content" style="text-align:center;padding:60px 0;">
        <p><?php esc_html_e('No results found. Try a different search.', 'stretch'); ?></p>
        <?php get_search_form(); ?>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php get_footer(); ?>
```

- [ ] **Step 2: Create 404.php**

Create `stretch-theme/404.php`:

```php
<?php
/**
 * Template: 404 Not Found
 */
get_header();
?>

<section class="section-white page-404">
  <div class="container">
    <h1>404</h1>
    <h2><?php esc_html_e('Page Not Found', 'stretch'); ?></h2>
    <p style="max-width:480px;margin:20px auto 40px;"><?php esc_html_e("The page you're looking for doesn't exist or has been moved.", 'stretch'); ?></p>
    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-primary"><?php esc_html_e('Back to Home', 'stretch'); ?> &rarr;</a>
  </div>
</section>

<?php get_footer(); ?>
```

- [ ] **Step 3: Create page-portal.php**

Create `stretch-theme/page-portal.php`:

```php
<?php
/**
 * Template Name: Client Portal
 * Template Post Type: page
 *
 * Minimal full-width template for future client portal features.
 * No sidebar, simplified header.
 */
get_header();
?>

<section class="section-white" style="padding-top:120px;min-height:60vh;">
  <div class="container">
    <?php
    if (is_user_logged_in()) {
        while (have_posts()) {
            the_post();
            the_content();
        }
    } else {
        ?>
        <div style="text-align:center;padding:60px 0;">
          <h2><?php esc_html_e('Client Portal', 'stretch'); ?></h2>
          <p><?php esc_html_e('Please log in to access your dashboard.', 'stretch'); ?></p>
          <?php wp_login_form(); ?>
        </div>
        <?php
    }
    ?>
  </div>
</section>

<?php get_footer(); ?>
```

- [ ] **Step 4: Commit**

```bash
git add stretch-theme/search.php stretch-theme/404.php stretch-theme/page-portal.php
git commit -m "feat: add utility templates — search results, 404, client portal placeholder"
```

---

### Task 16: Gutenberg Editor Styles

**Files:**
- Create: `stretch-theme/assets/css/editor-style.css`

- [ ] **Step 1: Create editor-style.css**

Create `stretch-theme/assets/css/editor-style.css`:

```css
/**
 * Gutenberg editor styles — matches front-end typography.
 */
.editor-styles-wrapper {
  font-family: 'Assistant', sans-serif;
  font-weight: 300;
  font-size: 18px;
  line-height: 1.6;
  color: #323A51;
  max-width: 780px;
  margin: 0 auto;
}

.editor-styles-wrapper h1,
.editor-styles-wrapper h2,
.editor-styles-wrapper h3,
.editor-styles-wrapper h4 {
  font-family: 'Poppins', sans-serif;
}

.editor-styles-wrapper h2 {
  font-size: 30px;
  font-weight: 500;
  color: #323A51;
  line-height: 1.2;
  margin-top: 48px;
  margin-bottom: 20px;
}

.editor-styles-wrapper h3 {
  font-size: 24px;
  font-weight: 600;
  color: #8560A8;
  line-height: 1.4;
  margin-top: 36px;
  margin-bottom: 16px;
}

.editor-styles-wrapper p {
  margin-bottom: 24px;
}

.editor-styles-wrapper a {
  color: #8560A8;
  text-decoration: underline;
}

.editor-styles-wrapper blockquote {
  border-left: 3px solid #00BFF3;
  padding: 16px 0 16px 24px;
  margin: 32px 0;
  font-family: 'Poppins', sans-serif;
  font-size: 20px;
  font-weight: 400;
  color: #252C3A;
}

.editor-styles-wrapper ul,
.editor-styles-wrapper ol {
  margin-bottom: 24px;
  padding-left: 24px;
}

.editor-styles-wrapper li {
  margin-bottom: 8px;
}

.editor-styles-wrapper img {
  max-width: 100%;
  height: auto;
}
```

- [ ] **Step 2: Commit**

```bash
git add stretch-theme/assets/css/editor-style.css
git commit -m "feat: add Gutenberg editor styles matching theme typography"
```

---

## Final Verification

After all tasks are complete, verify the theme is installable:

- [ ] Confirm all files exist in `stretch-theme/`
- [ ] Zip the theme: `cd stretch-theme && zip -r ../stretch-theme.zip . && cd ..`
- [ ] Verify `style.css` has the required theme header
- [ ] Verify `functions.php` requires all `inc/` files
- [ ] Verify all 13 section templates exist in `template-parts/sections/`
- [ ] Verify all page templates exist (front-page, page, single, archive, search, 404, page-portal)
