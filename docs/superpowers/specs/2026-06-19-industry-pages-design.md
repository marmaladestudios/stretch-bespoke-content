# Industry Pages Design Spec — Ecommerce & Agencies

**Date:** 2026-06-19
**Status:** Pending spec review
**Scope:** A shared, reusable industry-page template plus content for two industries (Ecommerce, Agencies & Strategic Partners). Two more industries (Local Service Providers, SaaS) will reuse the same template later.

## Goal

Build the first two of the four "Who We Serve" industry pages linked from the homepage (currently `#` placeholders). Follow the codebase's established shared-template pattern (`page-service.php`), where one template renders per-page content read from a slug-keyed WordPress option seeded by an idempotent setup script.

## Decisions

- **URLs (nested):** `/industries/ecommerce/` and `/industries/agencies/`. Requires an `/industries/` parent page so nested permalinks resolve.
- **`/industries/` parent (now):** Create the parent page so children resolve, and 301-redirect the bare `/industries/` URL to the homepage (`/`) until a real industries landing page is built in a later session.
- **Build both now:** one template + both content sets seeded together.
- **Design:** Reuse the brand design system established on Home/Solutions — dark gradient hero, `gradient-text`, card grids, `v2-reveal` scroll animations, brand palette (`#8560A8`, `#5674B9`, `#448CCB`, `#00BFF3`). Reuse `.v2-*` utility classes (`v2-container`, `v2-overline`, `v2-reveal`, `v2-btn-primary`). New sections namespaced `.ind-*`.
- **CTAs:** Hero CTA, mid CTA, and final CTA all link to the Contact page (`/contact-stretch-creative/`).
- **FAQ schema:** Emit FAQPage JSON-LD from the FAQ data for SEO.
- **Homepage links:** Update the Ecommerce and Agencies "Learn More" cards (currently `href="#"`) to the new URLs. Local Service Providers and SaaS remain `#`.
- **Footer menu:** Update the footer "Ecommerce" and "Agencies" items (currently → `/stretch-creative-solutions/`) to the new URLs.

## Architecture (mirrors page-service.php)

- **`stretch-theme/page-industry.php`** — `Template Name: Industry Page`. Reads `get_option('stretch_industry_' . $slug, [])` where `$slug` is the page's `post_name`. Renders all sections from that data array. Self-contained inline `<style>` and `<script>` (scroll-reveal), same as other page templates. Emits FAQ JSON-LD when `faqs` is non-empty.
- **`setup-industries.php`** (repo root) — idempotent WP-CLI script that:
  - creates/ensures the `/industries/` parent page,
  - creates/ensures the two child pages (`ecommerce`, `agencies`) nested under it with the `page-industry.php` template,
  - writes the content arrays via `update_option('stretch_industry_{slug}', [...])`.
  Added to the deploy entrypoint's idempotent run list.
- **`stretch-theme/functions.php`** — add a `template_redirect` redirect: bare `/industries/` page → `home_url('/')`.
- **`stretch-theme/setup-wizard.php`** — for fresh installs: create the `/industries/` parent + the two children with the template; update the two footer menu items to the new URLs.
- **`stretch-theme/page-home.php`** — point the Ecommerce and Agencies industry-card links to the new URLs.
- **Deploy entrypoint (`docker-entrypoint-custom.sh`)** — add `setup-industries.php` to the idempotent eval-file list.

## Content data shape (per industry option)

```
[
  'overline'      => string,   // industry name, hero overline
  'h1'            => string,   // hero H1
  'hero_text'     => string,   // hero intro line
  'cta_label'     => string,   // hero button label
  'audiences'     => [string], // "Who We Work With" chips
  'challenges_intro' => [string], // 1-2 intro paragraphs
  'challenges'    => [string], // pain-point bullet list
  'solutions_heading' => string,  // "Solutions Built for Ecommerce Brands"
  'solutions'     => [ ['title'=>string, 'body'=>string] ],
  'mid_cta_text'  => string,   // "Looking for solutions? Schedule a discovery call today."
  'popular_heading' => string, // "Services Most Popular with Ecommerce Brands"
  'popular'       => [ ['title'=>string, 'body'=>string] ],
  'why'           => [ ['title'=>string, 'body'=>string] ], // 4 value props
  'faqs'          => [ ['q'=>string, 'a'=>string] ],
  'final_heading' => string,   // "Ready to Grow Your Ecommerce Business?"
  'final_text'    => string,
]
```

All CTAs render a button to `/contact-stretch-creative/`. `cta_label` defaults to "Schedule a Discovery Call".

## Section rendering

1. **Hero** (`.ind-hero`, dark gradient, reuse `.sol-hero` treatment): overline → H1 (gradient span on a key phrase) → `hero_text` → CTA button.
2. **Who We Work With** (`.ind-audiences`, white): overline "Who We Work With" + heading; `audiences` rendered as pill chips (`.ind-chip`).
3. **Challenges** (`.ind-challenges`, light `#f9f9fb`): heading (`{Industry} Challenges`) + `challenges_intro` paragraphs + a 2-column `.ind-pain-list` with alert-style bullet markers.
4. **Solutions** (`.ind-solutions`, white): `solutions_heading` + a responsive card grid (`.ind-solution-card`), one card per `solutions` item (title + body).
5. **Mid CTA** (`.ind-midcta`, gradient banner): `mid_cta_text` + Contact button.
6. **Most Popular Services** (`.ind-popular`, light): `popular_heading` + a 3-col compact card grid (`.ind-pop-card`), one per `popular` item (title + body). Informational, no links.
7. **Why Stretch Creative?** (`.ind-why`, dark gradient): heading "Why Stretch Creative?" + 4 value-prop cards (`.ind-why-card`) from `why`.
8. **FAQs** (`.ind-faqs`, white): heading "FAQs" + native `<details>` accordion list from `faqs`. Emit `<script type="application/ld+json">` FAQPage schema.
9. **Final CTA** (`.ind-finalcta`, gradient): `final_heading` + `final_text` + Contact button.

Angle dividers (reusing `.v2-angle-divider`) bridge sections, with fills matching the next section's background.

## Content — Ecommerce (`ecommerce`)

- **overline:** Ecommerce
- **h1:** Ecommerce SEO, Content, and Creative Services
- **hero_text:** Help shoppers discover the right products, and give them the inspiration and confidence they need to buy.
- **audiences:** Fashion & Apparel Brands · Food & Beverage Companies · Beauty & Personal Care Brands · DTC Brands · DTC Retailers · Online Marketplaces
- **challenges_intro:**
  - Today's ecommerce brands face more competition than ever before. Website traffic alone is no longer enough to drive success when customers research products across search engines, AI-powered search tools, marketplaces, social platforms, and retailer websites before making a purchase.
  - At the same time, rising costs make it increasingly important to maximize the value of—and for—every visitor who lands on your website. Many ecommerce businesses struggle with:
- **challenges:** Product pages that don't answer customer questions · Category pages that fail to rank in search results · Poor product discovery experiences · Thin or duplicate content across large catalogs · Inconsistent branding across channels · Limited internal resources for content production · Outdated content that's poorly optimized for today's search landscape · Difficulty scaling ecommerce marketing efforts
- **solutions_heading:** Solutions Built for Ecommerce Brands
- **solutions:**
  - Ecommerce SEO — Effective ecommerce SEO starts with understanding how customers search for products. Our ecommerce SEO services include keyword research, technical SEO for ecommerce websites, on-page optimization, product page SEO, category page optimization, and content strategy development.
  - Product & Category Page Content — Product detail pages and category pages often play a central role in both product discovery and purchasing decisions. We create product descriptions, category page content, and supporting copy that help customers make informed purchasing decisions while supporting ecommerce search engine optimization goals.
  - Ecommerce Content Marketing — Most customers want solid product information before they buy. Buying guides, gift guides, comparison articles, educational resources, and ecommerce blog content help shoppers research products, understand their options, and discover your brand through search.
  - Visual Content & Product Photography — Strong visuals help customers understand products, compare options, and buy with confidence. Our creative team produces ecommerce product photography, video content, infographics, comparison graphics, and branded visual assets that support product pages, social media campaigns, email marketing, and paid advertising.
  - Ecommerce Paid Advertising — Organic search takes time. Paid advertising helps ecommerce brands put products in front of the right shoppers at the right moment. We develop search, shopping, display, remarketing, and social media advertising campaigns that support product launches and help customers discover products they may not have found otherwise.
- **mid_cta_text:** Looking for solutions? Schedule a discovery call today.
- **popular_heading:** Services Most Popular with Ecommerce Brands
- **popular:**
  - Ecommerce SEO Services — Technical SEO, ecommerce SEO audits, on-page optimization, category and product page SEO, ecommerce content strategy, and AEO optimization.
  - Product Detail Page Content — Helpful, engaging product descriptions, feature copy, specifications, FAQs, and other PDP resources that help shoppers make informed purchasing decisions.
  - Category Page Content — Search-friendly, inspirational category page copy designed to improve navigation, product discovery, and search visibility.
  - Ecommerce Content Marketing — Buying guides, gift guides, user-generated content, comparison guides, educational articles, and aspirational ecommerce blog content.
  - Expert-Written or Expert-Reviewed Content — SME-bylined content for healthcare, finance, technology, and other YMYL products, backed by subject matter expertise and rigorous editorial review.
  - Visual Content & Design — Infographics, comparison charts, social media assets, digital advertising creative, and branded design support.
  - Product Photography & Video — Product photography, lifestyle imagery, demonstrations, and branded video production.
  - Interactive Content Experiences — Product finders, quizzes, calculators, and other tools that support product discovery and customer engagement.
  - Paid Advertising — Search, shopping, display, and email and social media campaigns.
- **why:**
  - All of the Services You Need Under One Roof — SEO, content, design, photography, video, and paid advertising working together to support your ecommerce marketing strategy.
  - Human-Created, Expert-Led — Every project is developed by experienced professionals who understand how to create content that serves both customers and search engines.
  - Built for Growth — Our team can support ecommerce brands at virtually any stage of growth, from new product launches to enterprise-scale catalogs.
  - A True Extension of Your Team — Work directly with strategists, writers, editors, creatives, and SEO specialists who understand your products, your audience, and your goals.
- **faqs:**
  - What is ecommerce SEO? — Ecommerce SEO is the process of improving an online store's visibility in search engines through technical SEO, keyword research, product page optimization, category page optimization, and content development.
  - Do product pages help SEO? — Yes. Product page SEO helps search engines understand your products while providing customers with the information they need to make the right purchasing decisions.
  - What is category page SEO? — Category page SEO focuses on optimizing product category pages to improve search visibility, product discovery, and site navigation.
  - What is ecommerce content marketing? — Ecommerce content marketing uses buying guides, comparison content, educational articles, videos, and other resources to help customers research products, make informed decisions, and discover brands through search.
  - Can Stretch Creative help large ecommerce websites? — Absolutely. We regularly support ecommerce businesses with large product catalogs and complex content requirements.
  - Do you provide ecommerce product photography? — Yes. Our in-house creative team provides ecommerce product photography, lifestyle photography, video production, and supporting visual content services.
- **final_heading:** Ready to Grow Your Ecommerce Business?
- **final_text:** Whether you need ecommerce SEO services, content marketing support, product photography, or a complete ecommerce marketing strategy, Stretch Creative can help. Let's talk about your products, customers, and goals.

## Content — Agencies & Strategic Partners (`agencies`)

- **overline:** Agencies & Strategic Partners
- **h1:** White-Labeled Content & Creative Services for Agencies and Strategic Partners
- **hero_text:** Scale production, expand your capabilities, and deliver exceptional work without expanding your payroll.
- **audiences:** SEO Agencies · Content Marketing Agencies · Digital Marketing Agencies · Creative Agencies · Publishers & Media Companies · In-House Marketing Teams
- **challenges_intro:**
  - Agency growth is exciting—until production becomes the bottleneck.
  - As client demands increase, many agencies find themselves balancing tight deadlines, fluctuating workloads, limited internal resources, and increasing pressure to maintain quality at scale. Hiring talent is expensive and time-consuming. Freelancers can help, but managing multiple contractors often creates administrative headaches and inconsistent results. Many agencies and strategic partners struggle with:
- **challenges:** Limited bandwidth during periods of rapid growth · Difficulty scaling content production without adding headcount · Maintaining consistent quality across writers and projects · Meeting aggressive publishing schedules · Managing multiple client industries and subject matters · Finding reliable partners for specialized content needs · Balancing strategy work with content execution · Expanding service offerings without expanding internal teams
- **solutions_heading:** Solutions Built for Agencies & Partners
- **solutions:**
  - White-Labeled Content Production — Need additional production capacity without additional payroll? Stretch Creative works behind the scenes as an extension of your team, producing high-quality content that aligns with your clients' goals, brand standards, and editorial requirements.
  - Flexible Production Support — Your clients' needs can change quickly. Our team is built to scale production up or down as workloads fluctuate, helping agencies respond to new opportunities without disrupting their existing operations.
  - SEO Content at Scale — Whether you need ten articles or a thousand, our team supports both low- and high-volume content initiatives across a wide range of industries. We create SEO-focused content designed to help agencies meet publishing goals without sacrificing quality.
  - Creative & Visual Content — Content often performs best when it's supported by strong visuals. We provide graphic design, infographics, photography, video production, and other creative assets that help agencies expand their service offerings and deliver more value to clients.
  - Subject Matter Expertise — Our roster of credentialed subject matter experts supports agencies that work across complex industries and specialized subjects, from ecommerce and healthcare to SaaS and local service providers.
- **mid_cta_text:** Need additional production capacity? Schedule a discovery call today.
- **popular_heading:** Services Most Popular with Agencies & Partners
- **popular:**
  - White-Labeled SEO Content — SEO articles, pillar pages, landing pages, service pages, and other search-focused content delivered under your brand.
  - Content Strategy Support — Keyword research, content planning, editorial calendars, content audits, and content optimization recommendations.
  - Graphic Design & Visual Content — Infographics, social media assets, digital advertising creative, branded graphics, and supporting visual content.
  - Expert-Written or Expert-Reviewed Content — SME-bylined content for healthcare, finance, technology, and other YMYL industries, backed by subject matter expertise and rigorous editorial review.
  - Interactive Content Experiences — Calculators, assessments, quizzes, and interactive tools that help agencies differentiate their offerings.
  - Photography & Video Production — Photography, videography, editing, and post-production services for agency and client projects.
  - Content Optimization — Content refreshes, SEO updates, content audits, and optimization initiatives designed to improve performance.
  - White Papers & Long-Form Content — Thought leadership content, ebooks, guides, research reports, and other premium content assets.
  - Overflow & Production Support — Dedicated production resources available when your internal teams need additional capacity.
- **why:**
  - All of the Services You Need Under One Roof — Content, SEO, design, photography, video, and paid advertising working together to support your clients' goals and campaigns.
  - Human-Created. Expert-Led. — Every project is developed by experienced professionals who understand the importance of quality, consistency, and brand alignment.
  - Built for Growth — Our team can scale alongside your agency, whether you need occasional overflow support or a long-term production partner.
  - A True Extension of Your Team — We work collaboratively, communicate clearly, and integrate seamlessly into existing agency workflows.
- **faqs:**
  - Do you offer white-labeled services? — Yes. Stretch Creative regularly partners with agencies and strategic partners on fully white-labeled content, SEO, design, and creative projects.
  - Can you match our client's brand voice? — Absolutely. Our onboarding and editorial processes, including dedicated writing and editing cohorts, are designed to ensure consistency across brands, industries, and content types.
  - How quickly can you scale production? — Our team is built to support both ongoing content programs and high-volume initiatives. Production timelines depend on project scope, but scaling quickly is one of our core strengths.
  - Do you work under NDAs? — Yes. We regularly work under non-disclosure agreements and maintain strict confidentiality for agency partnerships.
  - Can you support multiple industries? — Yes. We work across ecommerce, healthcare, SaaS, local service providers, professional services, and many other industries.
  - Do you provide strategy in addition to content production? — Yes. We can support keyword research, content planning, SEO strategy, content audits, performance tracking, and other strategic initiatives in addition to content creation.
- **final_heading:** Ready to Scale Your Agency?
- **final_text:** Whether you need additional production capacity, specialized expertise, or a long-term white-labeled content partner, Stretch Creative can help.

## Out of scope (later sessions)
- Industries landing page at `/industries/` (currently redirects to home).
- Local Service Providers and SaaS industry pages (template will already support them; just need content + pages). Their homepage links stay `#`.
