# Home Page Redesign — Design Spec

**Date:** 2026-06-19
**Status:** Approved (design), pending spec review
**Scope:** Single page — the site homepage. First of a multi-page content-update batch (other pages handled in later sessions, one at a time).

## Goal

Replace the current homepage (`front-page-v2.php`) with new content built on the
existing **Solutions** design system. The Solutions page is being converted into
the Home page ("Home Page, formerly Solutions"). The new content is a content
refresh + section reorder of the structure already present in `page-solutions.php`.

## Decisions

- **Design:** Adapt the existing Solutions design system — dark gradient hero
  (`.sol-hero`), `gradient-text` brand spans, card grids, `v2-reveal` scroll
  animations, brand palette (`#8560A8`, `#5674B9`, `#448CCB`, `#00BFF3`). Swap text,
  reorder sections (Services now before Who We Serve), expand card counts.
- **Wiring:** This content lives at the site root (`/`). Build it into the homepage
  template and point `page_on_front` at it, replacing `front-page-v2.php`. The old
  `/stretch-creative-solutions/` URL is retired/redirected (it is now Home).
- **Industry "Learn More" links:** The four Who-We-Serve industry pages
  (Ecommerce, Agencies, Service Providers, SaaS) **do not exist yet**. Their
  Learn More buttons point to `#` placeholders until those pages are built in a
  later session.
- **Service "Learn More" links:** Wire to existing pages (slugs confirmed in
  `setup-wizard.php`).

## Implementation approach (to be detailed in the plan)

The Solutions design lives in `page-solutions.php`. Build the new Home using that
design. Preferred wiring: make the homepage template render this content and set
`show_on_front`/`page_on_front` accordingly (mirror the pattern in
`setup-wizard.php` lines 27–33 and `setup-content.php` lines 241–242). Retire the
separate Solutions page (redirect its URL to `/`). Exact mechanism (new
`page-home.php` vs. repurposing the existing Home page's template assignment) is a
plan-level decision.

## Section map

### 1. Hero — reuse `.sol-hero`
- **Overline:** STRETCH CREATIVE
- **H1:** Content Solutions for Modern Search & Discoverability *(gradient span on a portion)*
- **Subtitle:** Rank smarter, not harder. Stretch Creative maximizes your marketing budget with SEO, AEO, and content services that fit your needs—nothing more, nothing less.

### 2. Our Services — reuse `.sol-services` (placed BEFORE industries)
- **H2:** Our Services
- **Overline / subhead:** Multiple services × one agency
- **6 cards:**

| Card | Body | Learn More → |
|------|------|--------------|
| SEO/AEO Strategy & Services | Search has changed, but people still need answers. We help businesses earn visibility across traditional search, AI-generated results, and emerging discovery platforms with content and site experiences that are useful, accurate, and easy to understand. | SEO service page (`seo_content_strategy_services`) |
| Interactive Content Marketing | Calculators, assessments, maps, quizzes, and other interactive tools give visitors a reason to engage instead of bounce. We build bespoke content experiences that answer questions, surface insights, recommend products, and provide your visitors with value—and fun. | Bespoke Content Experience (`services/bespoke-content-experience`) |
| Content Writing | Our hand-picked roster of experienced content writers can take on whatever written assets you need to inform, persuade, and support your customers through the buying journey. Every piece we produce is written by humans for real people, fully optimized and written with a clear purpose. | Content Writing page (`content-writing-at-any-scale`) |
| Visual Content & Design | Strong visuals make complex information easier to understand. Our in-house, human creatives produce high-quality graphics, infographics, digital assets, photography, and video productions that clarify key points, strengthen messaging and branding, and help your content perform across multiple channels. | Graphic Design page (`graphic_design_services`) |
| Paid Advertising | Traffic alone doesn't pay the bills. Our paid advertising team creates paid campaigns that connect with the right audiences, align with your business goals, and support measurable outcomes, from lead generation to product sales. | Paid Advertising page (`paid-advertising`) |
| Add-On Services *(small card, no button)* | Budget management • CMS loading | — |

### 3. Who We Serve — reuse `.sol-cards-section`
- **H2:** Who We Serve
- **4 cards**, each: heading, one-line hook, paragraph, 3–4 bullet list, **Learn More → `#` (placeholder)**

**Ecommerce** — "SEO and content services for every stage of the buying journey."
We help DTC brands and retailers attract qualified shoppers and improve product discovery with expert SEO services, informative product detail and category pages, interactive content experiences, and engaging blogs that build your brand and help your customers find the products they need.
- Product Detail Pages & Category Page Content
- SEO & Product Discovery
- Creative Assets & Visual Storytelling
- Buying Guides and Gift Guides

**Agencies & Strategic Partners** — "High-volume, white-labeled content for agencies and other partners."
When demand exceeds capacity, Stretch Creative is ready to help with the expertise, talent, and production support to help your agency scale. We work as an extension of your team to produce high-quality, human-written content at any scale.
- White-Labeled SEO Content Production
- SEO & Content Strategy
- Design & Interactive Assets
- High-Volume Production

**Local Service Providers** — "Get found locally, build trust, and turn searches into service calls."
Your local service business or franchise needs to be visible where customers are searching—and persuasive when they click onto your site. Stretch Creative combines local SEO, service-focused content, and digital marketing strategies that will help your business earn trust and generate work orders.
- SEO for Local Search Visibility
- Service & Geographic Landing Pages and Blogs
- Social Media & Design
- Paid Advertising

**SaaS & Digital Platforms** — "Clear, accurate content for high-stakes buying decisions."
Whether you're selling software or connecting users to services, your success depends on helping people make informed decisions, often involving serious topics like money, law, and health. Stretch Creative produces content that distills down complex ideas and offerings and answers all the right questions.
- Expert-Written or -Reviewed Content
- White Papers and Case Studies
- Graphic Design
- SEO Content Strategy

### 4. Why Trust Stretch Creative? — reuse `.sol-trust`
- **H2:** Why Trust Stretch Creative?
- **5 cards:**
  1. **All of the services you need under one roof** — Content works better when the people creating it work together. With writers, designers, SEO specialists, videographers, and paid media experts under one roof, your campaigns stay aligned, your message remains consistent, and your projects move faster.
  2. **We're an extension of your team** — The best partnerships don't happen through support tickets and quarterly check-ins. Regularly scheduled touch-base calls and easy access to your Client Services Team and Managing Editor keep our partnership fresh and current. That makes it easy for us to pivot with you when big changes come down the pipeline, for better or worse.
  3. **Stay agile in the face of change** — Search is evolving fast, and it's more important than ever to stay current on trends in content, SEO, and AI. We're on top of it at the agency level, and everything we produce is optimized using current SEO and AEO best practices.
  4. **Scale with ease** — Need more content? Launching a new product? Expanding into a new market? Our processes make it easy to increase production, add new content types and services, and grow your marketing efforts without rebuilding your entire operation.
  5. **Human-created, editorially driven** — We're not an AI-assisted content mill. Our writers, editors, and visual creatives are vetted, experienced freelancers who we hand-pick for every project. While we use AI to streamline operational workflows, we never send our clients AI-written content.
- **Section-level button:** Learn how we work → About page (`about-stretch-creative`)

### 5. CTA — reuse `.sol-cta`
- **H2:** Let's Talk
- **Body:** Tell us about your project and we'll show you how Stretch Creative can help.
- **Button:** → Contact page (`contact-stretch-creative`)

## Out of scope (later sessions)
- The four industry pages (Ecommerce, Agencies, Local Service Providers, SaaS) — new layouts.
- Other pages in the content-update document.
