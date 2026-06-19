# Home Page Redesign Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Replace the site homepage with new content built on the existing Solutions design system, and wire it to serve at the site root (`/`).

**Architecture:** Create a self-contained `page-home.php` template by adapting `page-solutions.php` (same inline-`<style>` pattern the codebase uses for every page template). Reorder sections to Hero → Our Services → Who We Serve → Why Trust → CTA, refresh all copy, expand card counts, and add a bullet-list card variant. Wire the existing "Home" page (already `page_on_front`) to use `page-home.php` via an idempotent migration in `content-fixes.php` (auto-runs on every container start), and 301-redirect the retired `/stretch-creative-solutions/` URL to `/`.

**Tech Stack:** WordPress classic PHP theme, hand-written HTML/CSS/JS in page templates, WP-CLI idempotent setup scripts, Docker/Render deploy.

**Spec:** `docs/superpowers/specs/2026-06-19-home-page-redesign-design.md`

## Verification model (no unit-test framework)

This is presentation PHP. There is no PHPUnit suite. "Tests" in this plan mean:
1. **Lint** — `php -l <file>` must report "No syntax errors".
2. **Content presence** — `grep` for required strings in the rendered template.
3. **Visual/HTTP** — bring up Docker, run the migration, `curl` the homepage and the old Solutions URL to confirm the new H1 renders at `/` and the old URL 301s to `/`. Then a human visual review.

Commit after each task.

---

## File Structure

- **Create:** `stretch-theme/page-home.php` — new Home template (`Template Name: Home`). Self-contained: inline `<style>`, five `<section>`s, inline reveal/tilt `<script>` (copied from Solutions). One responsibility: render the homepage.
- **Modify:** `stretch-theme/functions.php` — add a `template_redirect` hook redirecting the retired Solutions slug to `/`.
- **Modify:** `stretch-theme/setup-wizard.php:30` — assign `page-home.php` (not `front-page-v2.php`) to the Home page for fresh installs.
- **Modify:** `content-fixes.php` — append an idempotent "FIX 3" that repoints the live Home page's template to `page-home.php` and confirms front-page options.
- **Leave as-is (superseded):** `stretch-theme/page-solutions.php` — kept on disk; its URL is redirected so the template no longer renders. `front-page-v2.php` is no longer the homepage but stays on disk.

---

## Task 1: Scaffold `page-home.php` from the Solutions template

**Files:**
- Create: `stretch-theme/page-home.php`

- [ ] **Step 1: Copy the Solutions template as the starting point**

```bash
cp stretch-theme/page-solutions.php stretch-theme/page-home.php
```

- [ ] **Step 2: Change the template name header**

Edit `stretch-theme/page-home.php`, replace:

```php
/**
 * Template Name: Solutions
 */
```

with:

```php
/**
 * Template Name: Home
 */
```

- [ ] **Step 3: Add CSS for the new card-list and addon variants**

In `page-home.php`, find the `.sol-card-stats {` rule block (the stats row used by industry cards) and insert these rules immediately AFTER the closing `}` of the `.sol-stat-label` rule (i.e. right before the `/* ... ALL SERVICES ... */` CSS section comment). Add:

```css
/* Industry card bullet list (replaces stat row on Home) */
.sol-card-list { list-style: none; margin: 0 0 20px; padding: 0; }
.sol-card-list li {
  position: relative; padding-left: 22px; margin-bottom: 8px;
  font-family: 'Assistant', sans-serif; font-size: 15px;
  color: #555; line-height: 1.5;
}
.sol-card-list li::before {
  content: ''; position: absolute; left: 0; top: 8px;
  width: 8px; height: 8px; border-radius: 50%;
  background: linear-gradient(135deg, #8560A8, #00BFF3);
}

/* Add-On Services: a non-clickable service card */
.sol-svc-card--addon { cursor: default; }
.sol-svc-card--addon:hover { transform: none; }
.sol-addon-list { list-style: none; margin: 4px 0 0; padding: 0; }
.sol-addon-list li {
  font-family: 'Assistant', sans-serif; font-size: 15px;
  color: #555; line-height: 1.7;
}

/* Trust section: capstone card spans full width; section CTA button */
.sol-prop-card--wide { grid-column: 1 / -1; }
.sol-trust-cta { text-align: center; margin-top: 40px; }
```

- [ ] **Step 4: Lint**

Run: `php -l stretch-theme/page-home.php`
Expected: `No syntax errors detected in stretch-theme/page-home.php`

- [ ] **Step 5: Commit**

```bash
git add stretch-theme/page-home.php
git commit -m "feat(home): scaffold page-home.php from Solutions template + new CSS"
```

---

## Task 2: Hero section content + divider fill

**Files:**
- Modify: `stretch-theme/page-home.php` (the `<section class="v2-section sol-hero">` block)

- [ ] **Step 1: Replace the hero content + divider**

In `page-home.php`, replace the entire hero `<section>` (from `<section class="v2-section sol-hero" aria-label="Hero">` through its closing `</section>`) with:

```html
<section class="v2-section sol-hero" aria-label="Hero">
  <div class="sol-hero-shapes">
    <div class="sol-shape sol-shape-1"></div>
    <div class="sol-shape sol-shape-2"></div>
    <div class="sol-shape sol-shape-3"></div>
    <div class="sol-shape sol-shape-4"></div>
  </div>

  <div class="v2-container">
    <div class="sol-hero-content">
      <span class="v2-overline v2-reveal v2-delay-1">Stretch Creative</span>
      <h1 class="v2-reveal v2-delay-2">Content Solutions for <span class="gradient-text">Modern Search &amp; Discoverability</span></h1>
      <p class="v2-subtitle v2-reveal v2-delay-3">Rank smarter, not harder. Stretch Creative maximizes your marketing budget with SEO, AEO, and content services that fit your needs&mdash;nothing more, nothing less.</p>
    </div>
  </div>

  <div class="v2-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none">
      <polygon points="0,60 1440,0 1440,60" fill="#f9f9fb"/>
    </svg>
  </div>
</section>
```

(Divider fill changed `#ffffff` → `#f9f9fb` because the next section is now Services, which has a `#f9f9fb` background.)

- [ ] **Step 2: Lint**

Run: `php -l stretch-theme/page-home.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Verify content present**

Run: `grep -c "Content Solutions for" stretch-theme/page-home.php`
Expected: `1`

- [ ] **Step 4: Commit**

```bash
git add stretch-theme/page-home.php
git commit -m "feat(home): hero copy + divider for new homepage"
```

---

## Task 3: Replace the two middle sections with Our Services (first) then Who We Serve

This task reorders and rewrites two sections at once. In the copied template the order is `sol-cards-section` (industries) then `sol-services`. We replace BOTH with Services-first, then Who-We-Serve.

**Files:**
- Modify: `stretch-theme/page-home.php`

- [ ] **Step 1: Replace both section blocks**

In `page-home.php`, select the span starting at the comment `<!-- ========================================` that introduces `2. SOLUTIONS CARDS` and ending at the closing `</section>` of the `3. ALL SERVICES` section (i.e. everything between the hero's closing `</section>` and the `<!-- 3.5 WHY TRUST STRETCH -->` comment). Replace that entire span with:

```html
<!-- ========================================
     2. OUR SERVICES
     ======================================== -->
<section class="v2-section sol-services" aria-label="Our Services">
  <div class="v2-container">
    <div class="sol-services-heading">
      <span class="v2-overline v2-reveal">Our Services</span>
      <h2 class="v2-reveal v2-delay-1">Multiple services <span class="gradient-text">&times; one agency</span></h2>
    </div>

    <div class="sol-services-grid">
      <a href="/seo_content_strategy_services/" class="sol-svc-card v2-reveal v2-delay-1" style="--svc-start:#8560A8;--svc-end:#5674B9;--svc-icon-bg:rgba(133,96,168,0.1);--svc-icon-bg-end:rgba(86,116,185,0.1);">
        <div class="sol-svc-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="#8560A8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
        </div>
        <h3>SEO/AEO Strategy &amp; Services</h3>
        <p>Search has changed, but people still need answers. We help businesses earn visibility across traditional search, AI-generated results, and emerging discovery platforms with content and site experiences that are useful, accurate, and easy to understand.</p>
        <span class="sol-svc-link">Learn more &rarr;</span>
      </a>

      <a href="/services/bespoke-content-experience/" class="sol-svc-card v2-reveal v2-delay-2" style="--svc-start:#5674B9;--svc-end:#448CCB;--svc-icon-bg:rgba(86,116,185,0.1);--svc-icon-bg-end:rgba(68,140,203,0.1);">
        <div class="sol-svc-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="#5674B9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
        </div>
        <h3>Interactive Content Marketing</h3>
        <p>Calculators, assessments, maps, quizzes, and other interactive tools give visitors a reason to engage instead of bounce. We build bespoke content experiences that answer questions, surface insights, recommend products, and provide your visitors with value&mdash;and fun.</p>
        <span class="sol-svc-link">Learn more &rarr;</span>
      </a>

      <a href="/content-writing-at-any-scale/" class="sol-svc-card v2-reveal v2-delay-3" style="--svc-start:#448CCB;--svc-end:#00BFF3;--svc-icon-bg:rgba(68,140,203,0.1);--svc-icon-bg-end:rgba(0,191,243,0.1);">
        <div class="sol-svc-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="#448CCB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"/><polygon points="18 2 22 6 12 16 8 16 8 12 18 2"/></svg>
        </div>
        <h3>Content Writing</h3>
        <p>Our hand-picked roster of experienced content writers can take on whatever written assets you need to inform, persuade, and support your customers through the buying journey. Every piece we produce is written by humans for real people, fully optimized and written with a clear purpose.</p>
        <span class="sol-svc-link">Learn more &rarr;</span>
      </a>

      <a href="/graphic_design_services/" class="sol-svc-card v2-reveal v2-delay-1" style="--svc-start:#00BFF3;--svc-end:#5674B9;--svc-icon-bg:rgba(0,191,243,0.1);--svc-icon-bg-end:rgba(86,116,185,0.1);">
        <div class="sol-svc-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="#00BFF3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="13.5" cy="6.5" r="2.5"/><circle cx="17.5" cy="10.5" r="2.5"/><circle cx="8.5" cy="7.5" r="2.5"/><circle cx="6.5" cy="12.5" r="2.5"/><path d="M12 2a10 10 0 1 0 10 10c0-4.22-4.5-3-5-6s-1-4-5-4z"/></svg>
        </div>
        <h3>Visual Content &amp; Design</h3>
        <p>Strong visuals make complex information easier to understand. Our in-house, human creatives produce high-quality graphics, infographics, digital assets, photography, and video productions that clarify key points, strengthen messaging and branding, and help your content perform across multiple channels.</p>
        <span class="sol-svc-link">Learn more &rarr;</span>
      </a>

      <a href="/paid-advertising/" class="sol-svc-card v2-reveal v2-delay-2" style="--svc-start:#8560A8;--svc-end:#448CCB;--svc-icon-bg:rgba(133,96,168,0.1);--svc-icon-bg-end:rgba(68,140,203,0.1);">
        <div class="sol-svc-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="#8560A8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
        </div>
        <h3>Paid Advertising</h3>
        <p>Traffic alone doesn&rsquo;t pay the bills. Our paid advertising team creates paid campaigns that connect with the right audiences, align with your business goals, and support measurable outcomes, from lead generation to product sales.</p>
        <span class="sol-svc-link">Learn more &rarr;</span>
      </a>

      <div class="sol-svc-card sol-svc-card--addon v2-reveal v2-delay-3" style="--svc-start:#5674B9;--svc-end:#00BFF3;--svc-icon-bg:rgba(86,116,185,0.1);--svc-icon-bg-end:rgba(0,191,243,0.1);">
        <div class="sol-svc-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="#5674B9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        </div>
        <h3>Add-On Services</h3>
        <ul class="sol-addon-list">
          <li>Budget management</li>
          <li>CMS loading</li>
        </ul>
      </div>
    </div>
  </div>

  <div class="v2-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none">
      <polygon points="0,60 1440,0 1440,60" fill="#ffffff"/>
    </svg>
  </div>
</section>


<!-- ========================================
     3. WHO WE SERVE
     ======================================== -->
<section class="v2-section sol-cards-section" aria-label="Who We Serve">
  <div class="v2-container">
    <div class="sol-cards-heading">
      <span class="v2-overline v2-reveal">Who We Serve</span>
      <h2 class="v2-reveal v2-delay-1">Built for <span class="gradient-text">your industry</span></h2>
    </div>

    <div class="sol-cards-grid">
      <div class="sol-card v2-reveal v2-delay-1">
        <div class="sol-card-image">
          <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=600&h=400&fit=crop" alt="Ecommerce" loading="lazy">
        </div>
        <div class="sol-card-content">
          <div class="sol-card-tag">Ecommerce</div>
          <div class="sol-card-title">SEO and content services for every stage of the buying journey.</div>
          <div class="sol-card-desc">We help DTC brands and retailers attract qualified shoppers and improve product discovery with expert SEO services, informative product detail and category pages, interactive content experiences, and engaging blogs that build your brand and help your customers find the products they need.</div>
          <ul class="sol-card-list">
            <li>Product Detail Pages &amp; Category Page Content</li>
            <li>SEO &amp; Product Discovery</li>
            <li>Creative Assets &amp; Visual Storytelling</li>
            <li>Buying Guides and Gift Guides</li>
          </ul>
          <a href="#" class="sol-card-link">Learn More <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
        </div>
      </div>

      <div class="sol-card v2-reveal v2-delay-2">
        <div class="sol-card-image">
          <img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?w=600&h=400&fit=crop" alt="Agencies and strategic partners" loading="lazy">
        </div>
        <div class="sol-card-content">
          <div class="sol-card-tag">Agencies &amp; Strategic Partners</div>
          <div class="sol-card-title">High-volume, white-labeled content for agencies and other partners.</div>
          <div class="sol-card-desc">When demand exceeds capacity, Stretch Creative is ready to help with the expertise, talent, and production support to help your agency scale. We work as an extension of your team to produce high-quality, human-written content at any scale.</div>
          <ul class="sol-card-list">
            <li>White-Labeled SEO Content Production</li>
            <li>SEO &amp; Content Strategy</li>
            <li>Design &amp; Interactive Assets</li>
            <li>High-Volume Production</li>
          </ul>
          <a href="#" class="sol-card-link">Learn More <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
        </div>
      </div>

      <div class="sol-card v2-reveal v2-delay-3">
        <div class="sol-card-image">
          <img src="https://images.unsplash.com/photo-1521791136064-7986c2920216?w=600&h=400&fit=crop" alt="Local service providers" loading="lazy">
        </div>
        <div class="sol-card-content">
          <div class="sol-card-tag">Local Service Providers</div>
          <div class="sol-card-title">Get found locally, build trust, and turn searches into service calls.</div>
          <div class="sol-card-desc">Your local service business or franchise needs to be visible where customers are searching&mdash;and persuasive when they click onto your site. Stretch Creative combines local SEO, service-focused content, and digital marketing strategies that will help your business earn trust and generate work orders.</div>
          <ul class="sol-card-list">
            <li>SEO for Local Search Visibility</li>
            <li>Service &amp; Geographic Landing Pages and Blogs</li>
            <li>Social Media &amp; Design</li>
            <li>Paid Advertising</li>
          </ul>
          <a href="#" class="sol-card-link">Learn More <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
        </div>
      </div>

      <div class="sol-card v2-reveal v2-delay-4">
        <div class="sol-card-image">
          <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=600&h=400&fit=crop" alt="SaaS and digital platforms" loading="lazy">
        </div>
        <div class="sol-card-content">
          <div class="sol-card-tag">SaaS &amp; Digital Platforms</div>
          <div class="sol-card-title">Clear, accurate content for high-stakes buying decisions.</div>
          <div class="sol-card-desc">Whether you&rsquo;re selling software or connecting users to services, your success depends on helping people make informed decisions, often involving serious topics like money, law, and health. Stretch Creative produces content that distills down complex ideas and offerings and answers all the right questions.</div>
          <ul class="sol-card-list">
            <li>Expert-Written or -Reviewed Content</li>
            <li>White Papers and Case Studies</li>
            <li>Graphic Design</li>
            <li>SEO Content Strategy</li>
          </ul>
          <a href="#" class="sol-card-link">Learn More <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
        </div>
      </div>
    </div>
  </div>

  <div class="v2-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none">
      <polygon points="0,60 1440,0 1440,60" fill="#1a1f2e"/>
    </svg>
  </div>
</section>
```

Notes baked in: Services divider fill is `#ffffff` (next section is white Who-We-Serve); Who-We-Serve divider fill is `#1a1f2e` (next section is the dark Trust section). The Bespoke link uses `/services/bespoke-content-experience/` (nested under `/services/` per `setup-wizard.php:73`). Industry "Learn More" links are `#` placeholders per spec.

- [ ] **Step 2: Lint**

Run: `php -l stretch-theme/page-home.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Verify card counts**

Run: `grep -c "sol-svc-card" stretch-theme/page-home.php`
Expected: `6` (5 link cards + 1 addon card)

Run: `grep -c 'class="sol-card ' stretch-theme/page-home.php`
Expected: `4` (four industry cards)

Run: `grep -c 'sol-card-link' stretch-theme/page-home.php`
Expected: `4` (each industry card's Learn More)

- [ ] **Step 4: Commit**

```bash
git add stretch-theme/page-home.php
git commit -m "feat(home): Our Services (6 cards) + Who We Serve (4 industries)"
```

---

## Task 4: Why Trust Stretch Creative section (5 cards + section CTA)

**Files:**
- Modify: `stretch-theme/page-home.php` (the `sol-trust` section)

- [ ] **Step 1: Replace the trust section**

In `page-home.php`, replace the entire `<section class="v2-section sol-trust" aria-label="Why Trust Stretch">` block (through its closing `</section>`, including its angle divider) with:

```html
<section class="v2-section sol-trust" aria-label="Why Trust Stretch Creative">
  <div class="v2-container">
    <div class="sol-trust-heading">
      <span class="v2-overline v2-reveal">Why Stretch</span>
      <h2 class="v2-reveal v2-delay-1">Why Trust <span class="gradient-text">Stretch Creative?</span></h2>
    </div>

    <div class="sol-trust-grid">
      <div class="sol-prop-card v2-reveal v2-delay-1" style="--prop-start:#8560A8;--prop-end:#5674B9;">
        <h3>All of the services you need under one roof</h3>
        <p>Content works better when the people creating it work together. With writers, designers, SEO specialists, videographers, and paid media experts under one roof, your campaigns stay aligned, your message remains consistent, and your projects move faster.</p>
      </div>

      <div class="sol-prop-card v2-reveal v2-delay-2" style="--prop-start:#5674B9;--prop-end:#448CCB;">
        <h3>We&rsquo;re an extension of your team</h3>
        <p>The best partnerships don&rsquo;t happen through support tickets and quarterly check-ins. Regularly scheduled touch-base calls and easy access to your Client Services Team and Managing Editor keep our partnership fresh and current. That makes it easy for us to pivot with you when big changes come down the pipeline, for better or worse.</p>
      </div>

      <div class="sol-prop-card v2-reveal v2-delay-3" style="--prop-start:#448CCB;--prop-end:#00BFF3;">
        <h3>Stay agile in the face of change</h3>
        <p>Search is evolving fast, and it&rsquo;s more important than ever to stay current on trends in content, SEO, and AI. We&rsquo;re on top of it at the agency level, and everything we produce is optimized using current SEO and AEO best practices.</p>
      </div>

      <div class="sol-prop-card v2-reveal v2-delay-4" style="--prop-start:#8560A8;--prop-end:#00BFF3;">
        <h3>Scale with ease</h3>
        <p>Need more content? Launching a new product? Expanding into a new market? Our processes make it easy to increase production, add new content types and services, and grow your marketing efforts without rebuilding your entire operation.</p>
      </div>

      <div class="sol-prop-card sol-prop-card--wide v2-reveal v2-delay-5" style="--prop-start:#8560A8;--prop-end:#448CCB;">
        <h3>Human-created, editorially driven</h3>
        <p>We&rsquo;re not an AI-assisted content mill. Our writers, editors, and visual creatives are vetted, experienced freelancers who we hand-pick for every project. While we use AI to streamline operational workflows, we never send our clients AI-written content.</p>
      </div>
    </div>

    <div class="sol-trust-cta v2-reveal v2-delay-2">
      <a href="/about-stretch-creative/" class="v2-btn-primary">Learn how we work &rarr;</a>
    </div>
  </div>

  <div class="v2-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none">
      <polygon points="0,60 1440,0 1440,60" fill="#8560A8"/>
    </svg>
  </div>
</section>
```

(Trust divider fill stays `#8560A8` — the next section is the purple-gradient CTA. The 5th card uses `sol-prop-card--wide` to span both columns; the section-level "Learn how we work" button links to the About page slug `about-stretch-creative`.)

- [ ] **Step 2: Lint**

Run: `php -l stretch-theme/page-home.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Verify**

Run: `grep -c "sol-prop-card" stretch-theme/page-home.php`
Expected: `5`

Run: `grep -c "Learn how we work" stretch-theme/page-home.php`
Expected: `1`

- [ ] **Step 4: Commit**

```bash
git add stretch-theme/page-home.php
git commit -m "feat(home): Why Trust section (5 cards + About CTA)"
```

---

## Task 5: CTA section

**Files:**
- Modify: `stretch-theme/page-home.php` (the `sol-cta` section)

- [ ] **Step 1: Replace the CTA section**

In `page-home.php`, replace the `<section class="v2-section sol-cta" aria-label="Call to Action">` block (through its closing `</section>`) with:

```html
<section class="v2-section sol-cta" aria-label="Call to Action">
  <div class="v2-container">
    <h2 class="v2-reveal">Let&rsquo;s Talk</h2>
    <p class="v2-reveal v2-delay-1">Tell us about your project and we&rsquo;ll show you how Stretch Creative can help.</p>
    <a href="/contact-stretch-creative/" class="v2-btn-primary v2-reveal v2-delay-2">Contact Us &rarr;</a>
  </div>
</section>
```

- [ ] **Step 2: Lint**

Run: `php -l stretch-theme/page-home.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Verify**

Run: `grep -c "Tell us about your project and we" stretch-theme/page-home.php`
Expected: `1`

- [ ] **Step 4: Commit**

```bash
git add stretch-theme/page-home.php
git commit -m "feat(home): final CTA section"
```

---

## Task 6: Redirect retired Solutions URL to the homepage

**Files:**
- Modify: `stretch-theme/functions.php`

- [ ] **Step 1: Add the redirect hook**

In `stretch-theme/functions.php`, after the existing `add_action('init', 'stretch_maybe_flush_rewrites');` line (line ~81), add:

```php
/**
 * The Solutions page content is now the homepage. 301-redirect the retired
 * /stretch-creative-solutions/ URL to the site root.
 */
add_action('template_redirect', 'stretch_redirect_retired_solutions');
function stretch_redirect_retired_solutions() {
    if (is_page('stretch-creative-solutions')) {
        wp_redirect(home_url('/'), 301);
        exit;
    }
}
```

- [ ] **Step 2: Lint**

Run: `php -l stretch-theme/functions.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
git add stretch-theme/functions.php
git commit -m "feat(home): 301-redirect retired /stretch-creative-solutions/ to /"
```

---

## Task 7: Wire the homepage template (fresh installs + live migration)

**Files:**
- Modify: `stretch-theme/setup-wizard.php:30`
- Modify: `content-fixes.php`

- [ ] **Step 1: Point fresh installs at page-home.php**

In `stretch-theme/setup-wizard.php`, replace:

```php
    update_post_meta($home_id, '_wp_page_template', 'front-page-v2.php');
```

with:

```php
    update_post_meta($home_id, '_wp_page_template', 'page-home.php');
```

- [ ] **Step 2: Add idempotent live migration to content-fixes.php**

In `content-fixes.php`, immediately BEFORE the final line `WP_CLI::success('Content fixes complete.');`, insert:

```php
// --------------------------------------------------------------------
// FIX 3 — Repoint homepage to the new Home template (page-home.php)
// The Solutions design is now the homepage; front-page-v2 is retired.
// --------------------------------------------------------------------
WP_CLI::log("\n=== Repointing homepage to page-home.php ===");
$home_page = get_page_by_path('home');
if (!$home_page) {
    WP_CLI::warning('  Home page (slug "home") not found. Skipping front-page repoint.');
} else {
    update_post_meta($home_page->ID, '_wp_page_template', 'page-home.php');
    update_option('show_on_front', 'page');
    update_option('page_on_front', $home_page->ID);
    WP_CLI::log("  ✓ Home page (ID {$home_page->ID}) → page-home.php; front page set");
}
```

- [ ] **Step 3: Lint both files**

Run: `php -l stretch-theme/setup-wizard.php && php -l content-fixes.php`
Expected: `No syntax errors detected` for both

- [ ] **Step 4: Commit**

```bash
git add stretch-theme/setup-wizard.php content-fixes.php
git commit -m "feat(home): wire page-home.php as homepage (setup + idempotent migration)"
```

---

## Task 8: End-to-end verification in Docker

**Files:** none (verification only)

- [ ] **Step 1: Bring up the stack**

Run: `docker compose up -d --build`
Wait for the container to finish its entrypoint (the idempotent setup scripts, incl. `content-fixes.php`, run automatically). Confirm with: `docker compose logs --tail=40 wordpress | grep -i "page-home"`
Expected: a line `✓ Home page (ID N) → page-home.php; front page set`

If `content-fixes.php` did not run automatically (fresh DB still installing), run it manually:
`docker compose exec wordpress wp eval-file /var/www/html/content-fixes.php --allow-root`

- [ ] **Step 2: Confirm the homepage renders the new content**

Determine the mapped host port from `docker-compose.yml` (the `ports:` mapping for the wordpress service), then:
Run: `curl -s http://localhost:<port>/ | grep -o "Content Solutions for Modern Search &amp; Discoverability"`
Expected: the H1 string prints (homepage now serves page-home.php)

- [ ] **Step 3: Confirm the old Solutions URL 301-redirects to /**

Run: `curl -s -o /dev/null -w "%{http_code} %{redirect_url}\n" http://localhost:<port>/stretch-creative-solutions/`
Expected: `301 http://localhost:<port>/` (or the site's home_url)

- [ ] **Step 4: Confirm industry card images load (broken-image guard)**

Run:
```bash
for u in \
  "https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=600&h=400&fit=crop" \
  "https://images.unsplash.com/photo-1600880292203-757bb62b4baf?w=600&h=400&fit=crop" \
  "https://images.unsplash.com/photo-1521791136064-7986c2920216?w=600&h=400&fit=crop" \
  "https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=600&h=400&fit=crop"; do
  echo "$(curl -s -o /dev/null -w '%{http_code}' "$u")  $u"
done
```
Expected: all four return `200`. If any returns 404, swap that `src` in `page-home.php` for a working Unsplash image of the same theme, re-lint, and commit.

- [ ] **Step 5: Human visual review**

Open `http://localhost:<port>/` in a browser. Confirm:
- Hero copy + gradient on "Modern Search & Discoverability"
- Services grid is a clean 3×2 (Add-On card has no Learn-more link and isn't clickable)
- Who We Serve is a clean 2×2 with bullet lists and Learn More buttons
- Why Trust shows 5 cards with the 5th spanning full width + the "Learn how we work" button
- Section transitions (angle dividers) blend with adjacent backgrounds (no color seams)
- CTA links to Contact

- [ ] **Step 6: Final commit (only if images were swapped in Step 4)**

```bash
git add stretch-theme/page-home.php
git commit -m "fix(home): swap industry card image(s) that 404'd"
```

---

## Self-Review (completed by plan author)

- **Spec coverage:** Hero (Task 2), 6 services incl. Add-On (Task 3), 4 industry cards w/ bullet lists + `#` links (Task 3), 5 trust cards + section About CTA (Task 4), CTA (Task 5), front-page wiring + Solutions redirect (Tasks 6–7), industry pages noted out-of-scope. All spec sections mapped. ✓
- **Placeholder scan:** No TBD/TODO; every code step has complete markup. The industry `#` links are intentional placeholders per spec, not plan gaps. ✓
- **Type/string consistency:** CSS classes referenced in markup (`sol-card-list`, `sol-svc-card--addon`, `sol-addon-list`, `sol-prop-card--wide`, `sol-trust-cta`) are all defined in Task 1 Step 3. Slugs match `setup-wizard.php` (`seo_content_strategy_services`, `services/bespoke-content-experience`, `content-writing-at-any-scale`, `graphic_design_services`, `paid-advertising`, `about-stretch-creative`, `contact-stretch-creative`). ✓
- **Known soft spot:** Unsplash image URLs for Local Service Providers and SaaS are unverified guesses — Task 8 Step 4 explicitly validates and provides a swap path.
