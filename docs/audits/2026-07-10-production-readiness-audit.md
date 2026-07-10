# Production Readiness Audit — Stretch Creative

**Date:** 2026-07-10
**Scope:** Full dev code review (3 parallel reviewers: PHP security · WP architecture/perf · front-end/a11y — 63 files) + browser UI/UX walkthrough of every page (desktop & true-viewport mobile) + automated sweeps (94 URLs, launch config, hygiene greps).
**Local environment:** localhost:8888 (Docker), matched to Render deployment behavior.
**Companion doc:** approved redesign spec `docs/superpowers/specs/2026-07-10-sitewide-premium-redesign-design.md`. Tickets marked **[REDESIGN]** are already covered there — sequence them in that project, don't double-build.

Each ticket is self-contained for sub-agent execution: files, evidence, fix, effort (S <1h · M 1-4h · L >4h).

---

## Executive summary

The site is functionally healthy on the surface — all 94 URLs resolve, zero console errors, interactive features work, mobile nav works — but it is **not launch-ready**. Four launch blockers: the contact form doesn't submit anywhere; every blog post carries fake email-capture UIs (exit-intent popup + newsletter form) that silently discard addresses; the site has zero SEO metadata (no meta descriptions/OG/canonical/plugin — for an SEO agency); and 23 published posts hotlink images from the old stretchcreative.co domain that break at DNS cutover.

Below the blockers: no caching layer on a single container running web+MySQL, a setup wizard that fatals on production and can break permalinks, hardcoded AEO text injected into every post regardless of topic, the flagship AEO scanner presenting fabricated fallback scores as real analysis, accessibility gaps (keyboard-dead dropdowns, mobile menu that can't be closed by touch), ~15,500 lines of duplicated inline CSS/JS, and a stale footer linking to legacy pages. The icon set needs ~10 replacements (Appendix A — full inventory with verdicts).

**Counts:** 4 P0 · 15 P1 · 17 P2 · 6 P3 (+ verified-clean list).

---

## P0 — Launch blockers

### AUD-001 · Contact form is decorative — submissions go nowhere
- **Area:** Conversion
- **Files:** `stretch-theme/page-contact.php:497` (form), `:519` (submit), `:559-575` (JS has no submit handler)
- **Evidence:** `<form class="contact-form" onsubmit="return false;">` — no action, no handler, no validation, no feedback, no mail plugin installed. Page promises "we'll get back to you within one business day."
- **Fix:** Real submission path: admin-post/REST handler with nonce + honeypot + `wp_mail()`, or a form plugin. **Must include working mail delivery on Render** (no local sendmail — WP Mail SMTP + transactional provider), success/error UI states, and an end-to-end delivery test to hello@stretchcreative.com.
- **Effort:** M

### AUD-002 · Fake email-capture UIs on every blog post
- **Area:** Conversion / trust / compliance
- **Files:** `single.php:2668-2671` (exit-intent popup — button `onclick="this.textContent='Sent! ✓'"`, email never read or sent, promises a "free AEO checklist"), `single.php:2020-2022` (newsletter form, `onsubmit="return false;"`)
- **Evidence:** Users believe they subscribed / requested a resource; input is silently discarded. Trust + implied-consent problem, not just a bug.
- **Fix:** Integrate a real ESP endpoint (or the AUD-001 mail path) for both, or remove both blocks until backed by a real service.
- **Effort:** M

### AUD-003 · Zero SEO metadata site-wide
- **Area:** SEO
- **Evidence:** No meta descriptions, no OG/Twitter tags, no canonicals, no schema beyond industry FAQ JSON-LD; titles are bare ("Ecommerce – Stretch Creative", "AEO – Stretch Creative"); no SEO plugin (`wp plugin list`). Core `wp-sitemap.xml` only.
- **Fix:** Install/configure an SEO plugin (Rank Math was on the old site) or hand-roll: unique titles + descriptions everywhere, OG/Twitter cards, canonicals, Organization/WebSite schema. Per-page titles should match copy-doc H1s.
- **Effort:** L

### AUD-004 · 23 published posts hotlink images from the OLD production domain
- **Area:** Content integrity / launch
- **Evidence:** `post_content LIKE '%stretchcreative.co/wp-content%'` → 23 published posts (e.g. `/blog/seo/seo-kpis-2025/` hero = `https://stretchcreative.co/wp-content/uploads/2025/01/Seo-metrics-.png`; 404 on the new stack). They render today only because the old host still serves them — all break at DNS cutover.
- **Fix:** Sideload every referenced file (patterns in `sideload-blog-images.php`/`sideload-wayback.php`), `wp search-replace` the URLs, verify zero remaining references.
- **Effort:** M

---

## P1 — High priority (fix before launch)

### AUD-005 · Mobile nav menu cannot be closed by touch
- **Files:** `assets/css/theme.css:242-255` (open panel overlays the hamburger; toggle has no z-index), `assets/js/theme.js:50-59` (closes only on Escape — unavailable on touch)
- **Evidence:** Open the menu on a phone → the 280px overlay covers the toggle; `body` scroll locked; no close button, no outside-tap close. Users are stuck.
- **Fix:** `.nav-toggle { position:relative; z-index:300 }` (or visible close button in panel) + close-on-outside-tap + focus trap.
- **Effort:** S

### AUD-006 · Nav dropdowns unusable by keyboard and on touch
- **Files:** `theme.css:220-224` (`li:hover` only), `header.php:38-45`
- **Evidence:** No `:focus-within` mirror → keyboard users tab through invisible child links; sub-menus unreachable inside the open mobile panel (no override). **[REDESIGN §7 rebuilds the nav — its implementation must include `:focus-within`, `aria-haspopup/expanded`, and inline sub-menus in the mobile drawer.]**
- **Effort:** S (inside redesign)

### AUD-007 · Hardcoded AEO content injected into every blog post
- **Files:** `single.php:2384-2387` (two "Key Takeaway" boxes with AEO-specific text auto-inserted into ANY post with ≥1/≥4 H2s), `single.php:2301-2312` ("Free Consultation" box before 3rd H2 of every post)
- **Evidence:** A videography post gets factually wrong AEO takeaways. Content integrity bug visible to every reader.
- **Fix:** Drive takeaways from post meta (render nothing when absent); move injection server-side.
- **Effort:** M

### AUD-008 · AEO scanner fabricates fallback scores + exfiltrates URLs to third-party proxies
- **Files:** `aeo-scanner.php:1576-1616` (fetch failure → `vary()` = base ± `Math.random()*8` scores presented in the same UI/PDF as real analysis; estimate note at :2190 appears only in the passage panel), `aeo-scanner.php:2091-2099` (visitor URLs sent to api.allorigins.win / corsproxy.io / api.codetabs.com), `category.php:939` (jsPDF from cdnjs, no SRI, no defer, every hub visitor)
- **Evidence:** The flagship tool can present random numbers as analysis — brand-integrity risk for an agency selling AEO expertise; scanned URLs disclosed to three free proxy operators with no SLA.
- **Fix:** Same-origin REST proxy endpoint (`wp_remote_get` server-side); label all fallback results as estimates on scores AND the PDF; lazy-load jsPDF on first use + SRI hash (or self-host).
- **Effort:** M

### AUD-009 · Nav is invisible on light pages (404 etc.)
- **Files:** `theme.css:166-178`, `404.php`
- **Evidence:** Fixed transparent nav + white text over the 404 page's white body → only the purple Contact button is visible (screenshot-verified; markup identical to other pages).
- **Fix:** Solid-nav variant via body class (`error404` + template opt-in class); audit other light-topped contexts.
- **Effort:** S

### AUD-010 · Footer menus link to legacy Solutions child pages and omit current IA
- **Evidence:** Footer "Solutions": For Ecommerce / For Agencies / For Publishers / Marketing & Demand Gen → `/stretch-creative-solutions/*` legacy ACF pages (old design, competing copy). No links to live industry pages or current services. **[REDESIGN §7 rebuilds footer — Phase 3.]**
- **Effort:** S (inside redesign)

### AUD-011 · Legacy content pages still published and competing with new pages
- **Evidence:** `/stretch-creative-solutions/{ecommerce,agency,publisher,demand-generation}-content/` + `/content-strategy/` (also still in the nav's Solutions submenu) render the old ACF design with outdated copy; `sample-page` published.
- **Fix:** **Decision needed from Cole:** redirect map (ecommerce-content→`/industries/ecommerce/`, agency-content→`/industries/agencies/`, publisher/demand-gen/content-strategy→nearest equivalents), then 301 on request path + unpublish. Delete sample-page.
- **Effort:** S–M after decision

### AUD-012 · No caching layer; single container runs web + MySQL
- **Evidence:** No page/object cache (`wp cache type` → Default), no CDN, `render.yaml` single service with in-container MySQL (deploys restart the DB). Every anonymous request = full WP bootstrap sharing CPU with MySQL.
- **Fix:** Launch minimum: full-page cache plugin + Cloudflare cache-everything for anonymous HTML + AUD-020 headers. Longer term: managed MySQL.
- **Effort:** M

### AUD-013 · Setup Wizard Step 6 fatals on production
- **Files:** `setup-wizard.php:436-439`, `setup-services.php:663-675`
- **Evidence:** Wizard includes `setup-services.php` (present in the prod webroot via entrypoint), whose unconditional `WP_CLI::` calls fatal in web context — white-screens Step 6 mid-mutation. Works locally only because the file is absent there.
- **Fix:** Guard every `WP_CLI::` call (pattern in `setup-aeo-hub.php:98-105`).
- **Effort:** S

### AUD-014 · Homepage + About hotlink Unsplash images
- **Files:** `page-home.php:727,745,763,781`, `page-about.php:705` (live); dormant copies in solutions/v2/v3/wizard
- **Evidence:** Live pages depend on images.unsplash.com (guideline violation, third-party SPOF, no srcset, no width/height → CLS).
- **Fix:** Sideload as attachments, serve via `wp_get_attachment_image()`. **[Do before/with REDESIGN Phase 1 — it touches these templates.]**
- **Effort:** S

### AUD-015 · /blog/ embeds the whole post corpus inline and queries all posts every request
- **Files:** `page-blog-home.php:102-150, 171-192`
- **Evidence:** `posts_per_page => -1` + full content + word counts per request; 41.8 KB inline `var POSTS`; +8 per-category preview queries. Grows linearly with content.
- **Fix:** Slim JSON (title/url/cat/date) in a transient regenerated on `save_post`; one grouped preview query.
- **Effort:** M

### AUD-016 · Image-permissions vetting for portfolio & selected-work samples
- **Evidence:** `/our-work/` (18 items) + service-page strips show client-brand screenshots (Etsy, Walgreens, Grove, NHL...). Copy doc explicitly requires permission vetting before launch.
- **Fix:** **Decision needed from Cole/team:** confirm rights per item; remove/anonymize failures. Agents can prep the inventory sheet.
- **Effort:** — (business)

### AUD-017 · Launch configuration placeholders
- **Evidence:** `admin_email=admin@stretch.local`; DB credentials hardcoded/committed (`render.yaml:14-16`; passwordless MySQL root in entrypoint); `wordpress-importer` active; ACF Pro update pending (6.8.0.1→6.8.5); Akismet inactive with comments enabled.
- **Fix:** Real admin email; secrets → Render env vars (generate at init); deactivate importer; update ACF (verify license); disable comments or activate Akismet; verify `blog_public=1` on the production DB at launch (it lives on the persistent disk).
- **Effort:** S

### AUD-018 · Process-timeline steps not keyboard-accessible (live About page)
- **Files:** `page-about.php:857-871` (divs), `:994-996` (click handlers)
- **Evidence:** No tabindex/role/key handling — keyboard and SR users cannot operate the timeline. (Same pattern in retired front-page-v2 — dies with AUD-030.)
- **Fix:** `<button>` steps in `role="tablist"` + arrow keys; panels as `role="tabpanel"`.
- **Effort:** S

### AUD-019 · Blog sidebar/FAQ accordions: inline-onclick spans, no aria state
- **Files:** `single.php:1716,1742` (`<span onclick>` toggles), `:1829` (button without `aria-expanded`)
- **Fix:** `<button aria-expanded>` + shared accordion pattern (theme.js:63-76).
- **Effort:** S

---

## P2 — Fix soon (bundle with launch if time allows)

### AUD-020 · No Cache-Control on static assets
- `curl -I theme.css` → ETag only; expires_module loaded but unconfigured. **Fix:** `.htaccess`: `max-age=31536000, immutable` for versioned assets; `s-maxage` on HTML once CDN fronts it. **S**

### AUD-021 · Rewrite regressions: category feeds 404; /blog/category/* and /blog/page/N redirect to wrong posts
- `/blog/aeo/feed/`→404; `/blog/category/aeo/`→301 to a random post; `/blog/page/2/`→301 to a post (`functions.php:20-69` + `redirect_guess_404_permalink`). **Fix:** feed/pagination rule variants + explicit 301 maps; bump `stretch_rewrite_version`. **S**

### AUD-022 · Mutation scripts in production webroot with accidental-only guards
- `docker-entrypoint-custom.sh:92-99` copies 8 scripts; 4 have no guard at all, others guard via `WP_CLI::error()` (which itself fatals over the web). All currently 500 pre-side-effect — protection is accidental. **Fix:** run `wp eval-file` from `/opt/` (stop copying to webroot) + `if (!defined('WP_CLI') || !WP_CLI) exit;` line 1 everywhere. **S**

### AUD-023 · Setup wizard: CSRF-able GET mutations; can break production permalinks; ships forever
- `setup-wizard.php:15,268,326-328,396-399,417-431,471` — mutations on GET, capability check only, no nonce; Step 1 sets `permalink_structure=/%postname%/` (breaks every blog URL if re-run); "DELETE after setup" comment but Docker redeploys it. **Fix:** nonce every step; gate behind `STRETCH_ALLOW_WIZARD`; remove/fix the permalink mutation. **S–M**

### AUD-024 · Lightbox `innerHTML` built from unescaped dataset strings
- `page-portfolio.php:585-596`, `page-service.php:2216-2223` — `dataset` decodes entities, so admin-entered media meta containing `"`/`<` re-enters DOM unescaped (stored-XSS vector); vimeo id concatenated into iframe URL. **Fix:** build with `createElement`/`textContent`; validate vimeo as `/^\d+$/`. **S**

### AUD-025 · Dialogs without focus management
- Lightboxes (`page-portfolio.php:574-623`, `page-service.php:2204-2247`) have `role="dialog"` but never move/trap/restore focus; exit-intent overlay (`single.php:2662-2674`) lacks even the role. **Fix:** focus close button on open, trap Tab, restore on close. **S**

### AUD-026 · No-JS/crawler regressions: all content invisible; stats render "0"
- Every template ships `opacity:0` reveal classes with no `<noscript>` fallback; counters render literal "0+"/"0%" server-side. **Fix:** shared `<noscript>` reset + render final numbers in HTML (animate from 0 in JS only). **[Fold into REDESIGN shared kit]** **S**

### AUD-027 · Reduced-motion coverage inconsistent across live templates
- Zero handling: page-about, page-contact (mapPulse), page-industry, category.php (carousel), aeo-scanner (radar/confetti/scramble/typewriter). Partial: page-home/solutions/team (JS gated, CSS reveals not); blog-home omits `.blog-reveal`. Gold standard: `page-service.php:1498-1506`. Also `html{scroll-behavior:smooth}` not RM-gated. **Fix:** one shared `@media (prefers-reduced-motion: reduce)` neutralizing all effect classes. **[REDESIGN shared kit]** **S**

### AUD-028 · Contrast + focus-visible failures (small text)
- #999/#bbb at 12-14px on white (`theme.css:859,966`; `single.php:563-1622` multiple; `category.php:342,639,806`; `page-contact.php:342`) — down to 1.86:1. `outline:none` without replacement: `category.php:684`, `aeo-scanner.php:390,801`, `page-blog-home.php:727,1019`, `single.php:813`. **Fix:** floor grays (#767676 on white, rgba(255,255,255,.62) on dark); `:focus-visible` outlines (pattern at theme.css:135-139). **S**

### AUD-029 · N+1 and per-view query pileups
- 18 leading-wildcard LIKE lookups per `/our-work/` (`functions.php:254-270`); ~10 extra WP_Query per post view incl. near-duplicate more-hub/related sections (`single.php:1699-1962`); category hub `posts_per_page=-1` + full-content read-time per card (`category.php:107,190-197`). **Fix:** persist filename→ID map (invalidate on `add_attachment`); grouped sidebar query + transient; read time in post meta; drop one duplicate section. **M**

### AUD-030 · Dead/hazardous templates + 4.3 MB seed data in the theme
- `front-page-v2.php` (98 KB, unassigned — carries its own defect cluster: crash-loop testimonial carousel, unconditional rAF cursor loop, clipped quote SVGs, dead letter-reveal code), `front-page-v3.php` (107 KB near-clone), `front-page-demo.php`, `page-solutions.php` (page 301s away), `setup-aeo-hub.php`, `stretch-theme/data/` (4.3 MB wizard-only). All selectable as templates in admin. **Fix:** delete after REDESIGN Phase 1 lands (v2 is the design reference until then); keep data/ out of the theme. **S [sequenced]**

### AUD-031 · Portfolio grid: no srcset; oversized images
- `page-portfolio.php:477-491` manual `<img>` from 1024px `large` into ~400px cells, 0 srcset on 19 imgs. **Fix:** `wp_get_attachment_image()`; drop unused `hero-bg` size. **S**

### AUD-032 · Raw-echo escaping gaps (2)
- `category.php:1013` (`echo $sec['table']` — siblings use `wp_kses_post`), `template-parts/sections/card-grid.php:44,53` (`echo $card['svg_code']`). **Fix:** `wp_kses_post` / `wp_kses` with SVG allowlist. **S**

### AUD-033 · Entrypoint: theme copy nests on restart; seeds run every boot
- `docker-entrypoint-custom.sh:84` `cp -rf dir/ dir/` → `stretch-theme/stretch-theme/` on persisted-FS restart; `:123-133` runs 5 seed scripts every container start. **Fix:** `cp -rT`; version-gate seeds. **S**

### AUD-034 · JS defect grab-bag (live templates)
- `category.php:1218-1226` `querySelector('#')` throws on plain-# anchors; copy button copies the word "Copy" (`single.php:2515-2534` — button inside blockquote, regex strips leading only); scanner typewriter interval can respawn after clear (`aeo-scanner.php:2079-2088,2168-2181`); theme.js null-deref guards missing (`theme.js:65,80-87,109`); duplicate reveal-observer + scroll handler on bespoke page (`page-bespoke:2043-2065`, one lacks `{passive:true}`); clickable table rows w/o keyboard path (`single.php:2497-2512`). **Fix:** guards/flags per item; delete bespoke duplicates. **S each**

### AUD-035 · Icon-only controls & ARIA half-patterns
- Share buttons rely on `title` (`single.php:1844-1913`); copy-link swaps innerHTML via inline onclick with embedded escaped SVG (×2); portfolio filter "tabs" have `role="tab"` without `aria-controls`/arrow-keys (`page-portfolio.php:460-465`). **Fix:** `aria-label`s; class-toggle instead of innerHTML; complete tabs pattern or downgrade to `aria-pressed` buttons. **S**

### AUD-036 · Dead "Learn More" links on the live homepage
- `page-home.php:775,793` — Local Service Providers + SaaS cards `href="#"` (jump to top). **Fix:** point at `/contact-stretch-creative/` until the industry pages ship. **[REDESIGN §4 creates the real pages — this is the interim fix if launch precedes it.]** **S**

---

## P3 — Cleanup / polish

### AUD-037 · Icon set replacement (client-flagged)
- **Evidence:** Full inventory in **Appendix A** (66 icons audited). ~10 JANKY verdicts — worst: the homepage **palette blob** (`page-home.php:677` + `page-solutions.php:726` — the icon Cole circled), zoom-in magnifier misused for SEO (`page-home.php:650`), bare-plus Add-On icon (`:695`), SEO "constellation magnifier" + creative-dojo "squiggle" hub icons (`page-blog-home.php:57,69`), clipped testimonial quote marks (`front-page-v2.php:2243-2282`, viewBox defect), pennant-flags Content Strategy icon, mixed-metaphor bespoke icons, clock used for "Google AI Overview" (`aeo-scanner.php:1756`).
- **Fix:** Adopt **Lucide** (MIT; matches existing 24px/1.5-stroke feather style ~85%), replace flagged icons 1:1 per Appendix A's suggested-replacement column, keep brand glyphs (X/LinkedIn/Facebook) official. **[Coordinate with REDESIGN so new pages ship the new set.]**
- **Effort:** M

### AUD-038 · Blog home giant outlined "01" watermark
- Contradicts Cole's established rejection of giant watermark text. **Decision needed**, then remove/shrink. **S**

### AUD-039 · SEO-page stat bar copy confusing ("72% Strategy", unitless "3-6")
- **[REDESIGN Phase 4 replaces with copy-doc props — no separate fix if that ships.]**

### AUD-040 · Search results template polish
- Cards with large empty bodies/mixed heights; legacy pages in results (fixed by AUD-011). **S**

### AUD-041 · Content depth: AEO spokes thin (~700 words, "2 min read")
- Content-team backlog; informational.

### AUD-042 · Misc small items
- Dequeue emoji script (~3.2 KB/page); `stretch_hub_aeo` option autoload=off; self-host Google Fonts (theme.css currently chained behind the fonts request); drop wizard `header()` calls after output (`setup-wizard.php:630-631`); set a site icon (site_icon=0); add helpful links to 404 after AUD-009; fix invalid gradient `fill` on About divider (`page-about.php:940`); replace `⚲` tofu glyph (`page-blog-home.php:1481`) with the search SVG; consolidate 55 duplicated angle-divider SVGs into one template part with `aria-hidden="true"`; replace `100vw` offsets causing ~15px scrollbar misalignment (`single.php:544,1407`, `category.php:303`); standardize breakpoints (960/768/480 — currently 9 distinct values incl. aeo-scanner's five 700px queries); document a z-index scale (current range: nav 100 → cursor 100001).

---

## Cross-template duplication (input for the shared-kit refactor — AUD-026/027 + REDESIGN)

**12,221 lines inline CSS + 3,326 lines inline JS** across 15 templates, none browser-cached (vs 125-line theme.js / 1,163-line theme.css). 14 reveal-observer copies (thresholds drift .1/.12/.15; only theme.js respects reduced-motion), 7 tilt implementations (3°/4°/6°, throttled vs not), 2 identical lightboxes, 2 identical magnetic-button + grain implementations, 2 hero-grid generators (~450-550 DOM nodes each — replace with CSS gradient + <20 glow nodes), 3 accordions with different open policies, byte-duplicated keyframes across v2/v3/service/single. Measured page impact: 30-52% of every page's HTML is inline style/script (post pages: 80.7 KB CSS in 13 blocks). Estimated ~2,500-3,000 removable lines via the shared partial. Page-weight table and full duplication matrix: see reviewer transcript; representative sizes — `/blog/aeo/` 192 KB raw / 41 KB gzip, post pages 134-176 KB, homepage 61 KB.

---

## Verified clean (no action)

- **SQL:** all variable queries use `prepare()` + `esc_like` correctly.
- **Escaping:** consistent esc_* / `wp_kses_post` across live templates (2 exceptions → AUD-032); PHP-in-JS via `wp_json_encode`; scanner escapes page text before `innerHTML` (no DOM-XSS).
- **Redirects:** hardcoded `home_url('/')` only; no open-redirect surface. No eval/exec/unserialize of untrusted data.
- **Roles:** `stretch_client` = `read` only; portal gated by `is_user_logged_in()`.
- **Hygiene:** no console.log/debugger/TODO leftovers; no hardcoded hosts in theme; all imgs have alt; all `target="_blank"` have `rel="noopener"` (20/20).
- **URL health:** 94/94 content URLs 200; designed redirects work; real 404s return 404.
- **Mobile (true viewport):** no horizontal overflow at 390px; hamburger visible/functional; menu opens with correct aria. (Initial headless "mobile broken" captures were a device-scale artifact — retracted. The touch-close defect is AUD-005.)
- **Console:** zero JS errors across 9 page types.
- **Interactive:** portfolio filters/lightbox, scanner + jsPDF, accordions, counters, blog filters all functional.

---

## Appendix A — SVG icon inventory (66 audited; replace JANKY per AUD-037)

**JANKY — replace:**

| Location | Depicts | Replacement (Lucide) |
|---|---|---|
| `page-home.php:677` + `page-solutions.php:726` | "Palette": floating circles + malformed blob (client-flagged) | `palette` or `pen-tool` |
| `page-home.php:650` + `page-solutions.php:744` | Zoom-IN magnifier used for "SEO/AEO Strategy" (wrong semantics) | `search` / `search-check` |
| `page-home.php:695` | Bare plus sign for "Add-On Services" (reads as a button) | `puzzle` or `plus-circle` |
| `page-solutions.php:753` | Two pennant flags — "Content Strategy" | `map` or `route` |
| `page-blog-home.php:57` (seo hub) | Magnifier stuffed with dot-constellation (unreadable at 48px) | `search` + ≤2 nodes |
| `page-blog-home.php:69` (creative-dojo hub) | Circle with random S-squiggle + dots (unrecognizable) | `brush` / `circle-dot` |
| `front-page-v2.php:2243-2282` (×4) | Quote marks clipped by viewBox (path x=64 in 0 0 60 48) | fix viewBox / typographic `"` — moot if AUD-030 deletes v2 |
| `front-page-v2.php:2488` | Three plain circles — "Curate Team" | `users` — moot with AUD-030 |
| `page-bespoke:1411` | Mountain+pennant mixed metaphor | `flag` or `mountain` |
| `page-bespoke:1614` | Diamond with star — ambiguous | `gem` or `sparkles` |
| `page-bespoke:1726` | Funnel + misplaced zoom-plus collage | `filter` alone |
| `aeo-scanner.php:1756` | Clock labeling "Google AI Overview" (wrong semantics) | `sparkles` / `search-check` |
| `single.php:1852,1895` | Copy-link icon duplicated as escaped strings inside onclick | `link` + class toggle (AUD-035) |

**Borderline (optional):** `page-about.php:912` calibrate dial → `crosshair`; `page-blog-home.php:51` busy AEO bubble-star → simplify; `page-bespoke:1418` stray tick marks → clean `trending-up`; `page-bespoke:1716` cursor-blob → `mouse-pointer-2`; `page-contact.php:488` LinkedIn rendered stroke-only → official filled glyph.

**OK — keep (51):** layers, edit-pencil, target, arrows, video, users, activity, eye, check-circle, globe, heart, chat, file-text, info, search, trending-up, map-pin, phone, mail, package, clock, play, storefront, sparkles, monitor+play, book-open, chevrons, gauge ring, download, checkboxes, brand glyphs (X/LinkedIn/Facebook), decorative mockup art in BCE, PHP-generated hub-and-spoke diagram, angle dividers (consolidate per AUD-042).

---

## Suggested execution order for sub-agents

1. **Wave 1 — launch blockers (parallel):** AUD-001, AUD-002, AUD-003, AUD-004, AUD-013, AUD-017
2. **Wave 2 — pre-launch UX/security hardening (parallel):** AUD-005, AUD-007, AUD-008, AUD-009, AUD-014, AUD-018, AUD-019, AUD-021, AUD-022, AUD-023, AUD-024, AUD-025, AUD-028, AUD-032, AUD-033, AUD-036
3. **Wave 3 — perf (parallel):** AUD-012, AUD-015, AUD-020, AUD-029, AUD-031, AUD-034
4. **Redesign-sequenced:** AUD-006, AUD-010, AUD-026, AUD-027, AUD-030, AUD-035 remainder, AUD-037 (icons), AUD-039, shared-kit consolidation
5. **Decisions needed from Cole first:** AUD-011 (legacy redirect map), AUD-016 (image permissions), AUD-038 (watermark)
