# Site-Wide Premium Redesign & Copy Rollout — Design Spec

**Date:** 2026-07-10
**Status:** Approved via interactive mockups (`scratchpad/mockups/home.html`, `industry.html`, served locally on :8899)
**Scope:** Home + industry template redesign, 2 new industry pages, service-page copy rollout,
new combined Visual Content & Design page, About/Team copy updates, new main nav + footer menus.
**Source of truth for copy:** Google Doc "New Pages & Page Copy" (doc ID `1SomIjqlFOORYXBCKXYWSYtbSlBKeiRzmGEZ3fEeJLLw`), extracted 2026-07-10.

## Goal

The June copy update flattened the home and industry pages' design. Restore the site's premium
design language (established in `page-service.php` / blog templates) on those pages, roll out the
remaining copy-doc pages, and restructure the main navigation to fit them — one coherent visual
system across the site.

## Decisions (made with Cole)

1. **Home restores social proof:** client logo marquee + animated stats bar (200+ Creatives,
   27+ Enterprise Brands, 500K+ Content Pieces, 98% Client Retention). No testimonials/blog strip.
2. **Shared effects partial** (not per-template copies): premium kit lives once in the theme;
   home + industry consume it now, future pages get it free. Existing service pages untouched.
3. **Visual Content & Design:** ONE combined page (per doc copy). Nav keeps TWO menu items —
   "Graphic Design" and "Photography & Videography" — anchor-linking to the page's two capability
   sections. Old GD/video URLs 301 to the new page.
4. **Hero CTA button on home** ("Schedule a Discovery Call") — approved via mockup (doc's hero
   had no button).
5. **Home mid-CTA copy** (doc marks a mid-page CTA with no copy): "Let's find the right fit." /
   "Every engagement starts with a conversation about your goals, your audience, and your budget."
   — approved via mockup; Cole may reword anytime.
6. Copy drift fixes vs doc: "collect insights" (not "surface"), "doesn't **always** pay the bills".

## 1. Shared premium kit — `template-parts/premium-fx.php`

One include emitting shared CSS + JS (prefixed `pfx-`), source-ported from `page-service.php`
and `front-page-v2.php` (proven code, not rewrites):

- Scroll progress bar (gradient, fixed top)
- Custom cursor (ring + dot, grows on interactive hover, no labels; hidden on touch/mobile/reduced-motion)
- Cinematic grid hero: JS-generated 60px cells, ~18% colored (brand palette), pulse animation,
  radial mask for text clarity (mask position configurable — centered for home, shifted left for
  left-aligned industry heroes), mouse parallax
- Grain texture (static SVG noise, injected into `[data-grain]` sections — animation dropped:
  compositor cost > visual value)
- Scroll-reveal system (`.pfx-reveal`, `-left`, `-right`, delays) with a **throttled-tab fallback**:
  timer-driven position check reveals content when IntersectionObserver/rAF are paused (hidden or
  embedded tabs); zero-height viewports reveal everything
- Animated stats counters (+ instant fallback in throttled tabs)
- Magnetic buttons, 3D tilt (`.pfx-tilt`), gradient accent bar
- Rotating conic gradient-border card (19s, `@property` angle) for CTA cards
- Logo marquee (reads `stretch_client_logos`, duplicated track, 45s loop, grayscale→color hover,
  edge fade masks; `--compact` variant for inner pages)
- FAQ accordion (single-open, max-height animation)
- Nav dropdown styles (dark glass panel, gradient hairline, hover bridge)
- `prefers-reduced-motion`: all animation off, reveals pre-visible
- **No** `backdrop-filter` on cards and **no** `mix-blend-mode` cursor (perf); nav bar blur only

## 2. Home page (`page-home.php`) — section order

1. **Hero** — grid hero (centered mask), overline / H1 with gradient span / subtitle (doc copy),
   + "Schedule a Discovery Call →" button. Angled divider.
2. **Trusted by Leading Brands** — logo marquee (restored).
3. **Stats bar** — dark, grain, 4 animated counters with pulse glow. Angled divider.
4. **Our Services** — 6 cards (doc copy, incl. copy-drift fixes): numbered 01–06, gradient icon
   tiles, gradient top-border sweep + tilt + icon micro-rotation on hover; Add-On card dashed.
5. **Mid-page CTA** — rotating gradient-border card (light bg), copy per Decision 5.
6. **Who We Serve** — 4 industry cards: image with slow zoom on hover, glass tag chip over image
   (no gradient overlays on photos), checkmark lists, arrow-slide links. Ecommerce + Agencies link
   live; Service Providers + SaaS link to the NEW pages (this project builds them).
7. **Why Trust Stretch Creative** — dark section, grain, 5 glass cards (2+2+wide) with gradient
   left-edge sweep + tilt; "Learn how we work →" magnetic button → About.
8. **Let's Talk** — full-bleed purple→dark gradient, floating shapes, grain; "Contact Us →"
   primary + "See Our Work" outline button (outline button is a design addition).

Existing H2 flourishes stay: "Multiple services × one agency", "Built for your industry"
(doc's literal H2s render as overlines).

## 3. Industry template (`page-industry.php`) — applies to all 4 industry pages

1. **Hero** — grid hero, left-shifted mask, overline = page title, H1/hero text from
   `stretch_industry_{slug}`, magnetic CTA button. Angled divider + animated gradient accent bar.
2. **Who We Work With** — icon chips: white pills w/ gradient outline (mask-composite technique),
   per-audience icon, hover lift.
3. **Challenges** — 2-col: intro paragraphs left (`reveal-left`), pain panel right (`reveal-right`):
   white card, gradient left edge, "Many {industry} businesses struggle with:" heading, X-circle list.
4. **Solutions** — cards restyled to home-services pattern: gradient icon tile + small number
   top-right, gradient sweep + tilt on hover.
5. **Mid CTA** — gradient-border card with the doc's per-industry CTA line.
6. **Most Popular Services** — 3-col cards, gradient top border grows on hover, lift.
7. **Trusted brands strip** — compact logo marquee, divider into dark.
8. **Why Stretch** — dark, grain, glass cards with gradient edge sweep.
9. **FAQs** — accordion (replaces `<details>`), FAQPage JSON-LD kept.
10. **Final CTA** — full-bleed gradient + shapes + grain (same component as home).

**Data model:** `stretch_industry_{slug}` gains optional `icon` keys on `audiences` and
`solutions` entries (slug of an inline SVG in a small icon library in the template). Missing
icons fall back to a rotating default set — template never breaks on old data.

## 4. New industry pages (data only — template does the work)

Extend `setup-industries.php` (idempotent) with doc copy:
- **Local Service Providers** → `/industries/service-providers/`
- **SaaS & Digital Platforms** → `/industries/saas/`
Home "Who We Serve" cards + nav + footer link to them (replaces `#` placeholders).

## 5. Service pages — copy rollout (existing premium template, content swaps)

Via `setup-services.php` options (idempotent updates):
- **Content Writing** (`/content-writing-at-any-scale/`): new doc copy. Remove "Whether you need
  one piece or a thousand, quality never compromises." Replace "Selected Work" module with
  **Add-On Services** (SEO + Editorial / Budget Management / Content Loading) until image
  permissions are vetted (doc note — phase 2 restores work examples). Testimonials, FAQs, final
  CTA unchanged. Cross-service CTA links to the other 4 services.
- **SEO/AEO** (`/seo_content_strategy_services/`): new doc copy incl. stat-box props (Technical
  SEO Expertise / AEO-Ready Strategies / Transparent Reporting / No Long-Term Contracts) and
  "From enterprise audits to SEO-Lite…" line. Testimonials/FAQs/CTA unchanged.
- **Paid Advertising** (`/paid-advertising/`): new doc copy. Testimonials/FAQs/CTA unchanged.
- **Visual Content & Design** (NEW, `/visual-content-and-design/`): combined page on the service
  template with two anchored capability groups — `#graphic-design` (6 items) and
  `#photography-video` (13 items) — merged FAQs from the two old pages, work examples kept but
  flagged for vetting before launch. **301s:** `/graphic_design_services/` and
  `/video-content-services/` → the new page, matched on the request path (not `is_page()`,
  which stops firing once a page is unpublished). Old pages unpublished after redirects are live.
- **BCE** (`/services/bespoke-content-experience/`): design/copy unchanged; retitle H1/title/meta
  around "Interactive Content Marketing" (BCE stays as branding inside copy, out of headings).

## 6. About & Team — copy updates (existing templates)

- **Our Story:** doc copy — "Because Stories Matter" hero line, Founded on a Belief, "community
  of 200+" quote, 3 numbered differentiators (note: doc's Flexible Engagements copy has a
  placeholder "from … to …" — keep current sentence until Cole supplies the range), Values (4),
  Process (6 steps), Join Our Team CTA → Team page.
- **Team:** hero "Clever. Skilled. Inspired." + intro; roster unchanged; "What We Look For"
  (Empathy / Intuition / Curious / Growth-Minded); "Start Your Career" CTA → contact.

## 7. Navigation & footer

**Header** (`header.php` + `theme.css`): Solutions ▾ (SEO/AEO, Interactive Content Marketing,
Content Writing, Graphic Design→`/visual-content-and-design/#graphic-design`, Photography &
Videography→`…#photography-video`, Paid Advertising) · Industries ▾ (4) · About Us ▾ (Our Story,
Our Team) · Our Work · Blog · Contact Us button. Desktop: dark near-opaque dropdown panels
(no backdrop-filter) w/ gradient hairline, chevron rotate, hover bridge. Mobile: accordion submenus in the existing drawer.
Implemented as WP menus (nested) so the client can edit; setup script builds them idempotently.

**Footer:** menu columns rebuilt to mirror the new structure (Solutions incl. the two visual
anchors, Industries incl. the 2 new pages).

## 8. Migrations, deploy, and rollout

- All content changes land in idempotent scripts (`setup-industries.php`, `setup-services.php`,
  `setup-content.php`/`content-fixes.php` for menus, About/Team, redirects) — safe locally and on
  Render; wired into `docker-entrypoint-custom.sh` + setup wizard like existing scripts.
- Redirects registered in `functions.php` (same pattern as existing 301s); rewrite version bumped.
- Phased implementation: ① shared kit + home ② industry template + 2 new pages ③ nav/footer +
  redirects ④ service copy + Visual page + BCE headings ⑤ About/Team. Each phase verified in the
  browser before the next; push to Render after Cole approves locally.

## Non-goals

Case studies section (doc has planning notes only), blog changes, industry "Featured Work"
modules (deferred until image permissions vetted), Selected Work strips on service pages
(temporarily replaced per doc), pricing/portfolio pages.

## Error handling & resilience

- Missing option data → sections render nothing (existing pattern), never fatal.
- Missing logo attachments → marquee skips them (existing behavior).
- JS features are progressive enhancements; content is server-rendered and readable without JS
  (reveals pre-visible via `no-js` class fallback in production build).
- `prefers-reduced-motion` honored everywhere.

## Testing

- Local: full page sweep (all URLs incl. 2 new industries + visual page + redirects return
  expected codes), visual pass on home/industry/service/about at 1440/960/768/375 widths,
  keyboard nav through dropdowns, FAQ accordion a11y (aria-expanded/controls).
- `wp eval-file` scripts run twice → second run is a no-op (idempotency check).
- Render: deploy, wizard fresh-install path exercised on a scratch container.
