<?php
/**
 * Setup script for Service Page content.
 * Run via: docker compose exec wordpress wp eval-file /var/www/html/setup-services.php --allow-root
 */

if (!defined('ABSPATH')) {
    WP_CLI::error('This script must be run via wp eval-file.');
}

$services = [];

// ============================================================
// 1. Content Writing at Any Scale
// ============================================================
$services['content-writing-at-any-scale'] = [
    'headline'    => 'Content Writing at Any Scale',
    'subheadline' => "We partner with marketing, sales, and SEO teams to produce large or small volumes of content, fine-tuned to perform exactly how you want it to.",
    'offerings'   => [
        [
            'title'       => 'Blog Articles',
            'description' => 'Informative, engaging blog posts written by subject-matter experts and optimized for search. Whether you need a steady stream of weekly posts or a one-time batch, our writers deliver publish-ready content that drives organic traffic and positions your brand as a thought leader.',
        ],
        [
            'title'       => 'Buying Guides',
            'description' => 'Comprehensive, research-driven buying guides that help your customers make informed purchase decisions. We combine product expertise with SEO best practices to create guides that rank well and convert browsers into buyers.',
        ],
        [
            'title'       => 'User-Generated Content',
            'description' => 'Authentic, relatable content that mirrors the voice of real customers. From product reviews to community-style posts, we create UGC-style content that builds trust and social proof for your brand.',
        ],
        [
            'title'       => 'Ebooks & White Papers',
            'description' => 'Long-form, authoritative content that establishes your expertise and generates leads. Our writers produce in-depth ebooks and white papers backed by research, data, and original insights that your audience will want to download and share.',
        ],
        [
            'title'       => 'Expert-Written or Reviewed',
            'description' => 'Content written or reviewed by credentialed experts in fields like health, finance, law, and technology. We match your content with qualified professionals to ensure accuracy, trustworthiness, and compliance with E-E-A-T standards.',
        ],
        [
            'title'       => 'Product Descriptions',
            'description' => 'Persuasive, SEO-friendly product descriptions that highlight key features and benefits. Whether you have 50 SKUs or 50,000, we scale our writing teams to deliver consistent, on-brand copy that drives conversions.',
        ],
        [
            'title'       => 'Product Listing Pages',
            'description' => 'Optimized product listing and category pages that improve discoverability and guide shoppers through your catalog. We write compelling copy that balances SEO requirements with a seamless user experience.',
        ],
        [
            'title'       => 'Email & Social Content',
            'description' => 'Engaging email campaigns, newsletters, and social media copy that nurture leads and keep your audience connected. We write content tailored to each platform and stage of the customer journey.',
        ],
        [
            'title'       => 'Google Ads, Banners & Landing Pages',
            'description' => 'High-converting ad copy, banner text, and landing page content designed to maximize click-through and conversion rates. We write concise, action-oriented messaging that aligns with your campaign goals and brand voice.',
        ],
        [
            'title'       => 'Website Copy',
            'description' => 'Clear, compelling website copy that communicates your value proposition and guides visitors toward action. From homepages to service pages, we craft messaging that reflects your brand and resonates with your target audience.',
        ],
    ],
    'why_heading' => 'Why Stretch?',
    'why_intro'   => "Whether you're a small business or a formidable Fortune 100, your content needs to be trustworthy, authoritative, and — above all — helpful to the reader.",
    'benefits'    => [
        [
            'title'       => 'Dedicated Cohorts',
            'description' => 'We build a dedicated team of writers specifically for your brand. Your cohort learns your voice, style guide, and audience inside and out — so every piece of content sounds like it came from your in-house team.',
        ],
        [
            'title'       => 'Authoritative Content',
            'description' => "Our writers are experienced professionals, not anonymous freelancers. We match subject-matter experts to your projects so your content is accurate, credible, and aligned with Google's E-E-A-T guidelines.",
        ],
        [
            'title'       => 'Collaborative Process',
            'description' => 'We work alongside your team, not in a silo. From intake calls to editorial reviews, our process is transparent and collaborative. You stay in the loop at every stage, and feedback is always welcome.',
        ],
        [
            'title'       => 'Consistent Quality',
            'description' => 'Every piece of content goes through our multi-stage editorial process — including writing, editing, fact-checking, and QA — to ensure it meets your standards before delivery. No surprises, no rework.',
        ],
    ],
    'faqs' => [
        [
            'question' => 'How does Stretch match writers to my brand?',
            'answer'   => 'We start with a detailed onboarding process where we learn your brand voice, tone, style guidelines, and subject-matter requirements. Based on that, we assemble a dedicated cohort of writers with relevant expertise. Your cohort works exclusively on your content, ensuring consistency across every deliverable.',
        ],
        [
            'question' => 'What if I only need a small volume of content?',
            'answer'   => "We work with brands of all sizes, from startups needing a handful of blog posts to enterprises requiring thousands of product descriptions per month. There are no minimums — we'll build a plan that fits your needs and budget.",
        ],
        [
            'question' => 'How do you ensure content quality at scale?',
            'answer'   => 'Every piece of content passes through our multi-stage quality assurance process. This includes editorial review, fact-checking, plagiarism scanning, and style-guide compliance checks. As volume increases, we add editors and QA specialists to maintain the same high standards.',
        ],
        [
            'question' => 'Can your writers handle specialized or technical topics?',
            'answer'   => 'Absolutely. We have writers with professional backgrounds in healthcare, finance, technology, legal, SaaS, ecommerce, and many other industries. For topics requiring extra credibility, we can also arrange expert reviews by credentialed professionals.',
        ],
    ],
];

// ============================================================
// 2. SEO & Content Strategy Services
// ============================================================
$services['seo_content_strategy_services'] = [
    'headline'    => 'SEO & Content Strategy Services',
    'subheadline' => "Google's message on SEO is crystal clear: No matter how 'optimized' your content is, it won't perform to its potential if it isn't fundamentally helpful to begin with.",
    'offerings'   => [
        [
            'title'       => 'Keyword Research',
            'description' => 'We identify the highest-value keywords for your business using advanced tools and competitive analysis. Our research goes beyond search volume — we evaluate intent, difficulty, and opportunity to build a keyword strategy that drives qualified traffic to your site.',
        ],
        [
            'title'       => 'Content Strategy',
            'description' => 'A comprehensive content roadmap aligned with your business goals, audience needs, and SEO opportunities. We plan topic clusters, content types, publishing cadences, and distribution strategies that work together to grow your organic footprint.',
        ],
        [
            'title'       => 'SEO Content Briefs',
            'description' => 'Detailed, data-driven briefs that set your writers up for success. Each brief includes target keywords, search intent analysis, competitive benchmarks, recommended structure, and specific guidance to ensure every piece of content is optimized from the start.',
        ],
        [
            'title'       => 'Audits & Analyses',
            'description' => 'Thorough audits of your existing content and SEO performance. We analyze your site architecture, content gaps, technical issues, and competitive landscape to identify quick wins and long-term strategic opportunities.',
        ],
        [
            'title'       => 'Article Optimizations & Rewrites',
            'description' => 'Breathe new life into underperforming content. We optimize existing articles with updated keywords, improved structure, fresh information, and enhanced readability — often yielding significant ranking improvements without starting from scratch.',
        ],
        [
            'title'       => 'A/B Testing',
            'description' => 'Data-driven experimentation to find what resonates with your audience. We test headlines, meta descriptions, content formats, CTAs, and page layouts to continuously improve your click-through rates and conversions.',
        ],
        [
            'title'       => 'CMS Loading & Optimizing',
            'description' => 'We handle the entire content loading process — from formatting and tagging to image optimization and metadata setup. Your content goes live publish-ready, with proper schema markup, internal linking, and technical SEO best practices baked in.',
        ],
    ],
    'why_heading' => 'Why Stretch?',
    'why_intro'   => "Our SEO experts know the ins and outs of keyword research and data analysis. Our editorial team is tuned into the human ethos and user experience. Together, they're a perfect balance of science and art.",
    'benefits'    => [
        [
            'title'       => 'SEO at Any Scale',
            'description' => 'Whether you need a strategy for 10 pages or 10,000, our process is designed to scale. We use proven frameworks and efficient workflows that deliver consistent, high-quality SEO work — no matter the scope of your project.',
        ],
        [
            'title'       => 'Precision Insights',
            'description' => 'We go beyond surface-level keyword data. Our analysts uncover nuanced search intent patterns, competitive gaps, and content opportunities that most agencies miss — giving you a strategic edge in the SERPs.',
        ],
        [
            'title'       => 'Holistic SEO Strategy',
            'description' => "SEO isn't just about keywords. We take a holistic approach that encompasses content quality, user experience, technical optimization, and link-building strategy. Every recommendation is grounded in how search engines actually evaluate and rank content.",
        ],
        [
            'title'       => 'Measurable Results',
            'description' => 'We set clear KPIs from the start and track performance rigorously. You get regular reports showing exactly how your content is performing — traffic, rankings, conversions — along with actionable recommendations for continuous improvement.',
        ],
    ],
    'faqs' => [
        [
            'question' => 'How is your SEO approach different from other agencies?',
            'answer'   => "Most SEO agencies focus almost exclusively on technical optimization and keyword density. We take a fundamentally different approach: we start with content quality and user experience, then layer in SEO best practices. This aligns with Google's emphasis on helpful, people-first content — and it produces better long-term results.",
        ],
        [
            'question' => 'Do you guarantee rankings?',
            'answer'   => "No reputable SEO provider can guarantee specific rankings — and we'd be wary of anyone who does. What we do guarantee is a rigorous, data-driven process, transparent reporting, and a strategy built on proven best practices. Our clients consistently see significant improvements in organic visibility and traffic.",
        ],
        [
            'question' => 'How long does it take to see results from SEO?',
            'answer'   => 'SEO is a long-term investment. Most clients begin seeing measurable improvements in rankings and traffic within 3 to 6 months, with results compounding over time. The timeline depends on factors like your domain authority, competitive landscape, and the scope of work.',
        ],
        [
            'question' => 'Can you work with our existing content team?',
            'answer'   => 'Absolutely. We frequently collaborate with in-house marketing and editorial teams. We can provide the strategic layer — keyword research, content briefs, audits — while your team handles the writing, or we can manage the entire process end to end. We adapt to whatever structure works best for you.',
        ],
        [
            'question' => 'What tools do you use for keyword research and analysis?',
            'answer'   => 'We use a comprehensive suite of industry-leading tools including Ahrefs, Semrush, Google Search Console, Clearscope, and proprietary analysis frameworks. Our strategists combine automated data with manual analysis to deliver insights that tools alone cannot provide.',
        ],
        [
            'question' => 'Do you handle technical SEO as well?',
            'answer'   => 'Yes. Our audits cover technical SEO fundamentals including site speed, crawlability, indexation, schema markup, mobile usability, and Core Web Vitals. We provide detailed recommendations and can work with your development team to implement fixes.',
        ],
        [
            'question' => 'How do you measure and report on SEO performance?',
            'answer'   => 'We provide regular performance reports that track keyword rankings, organic traffic, click-through rates, conversions, and other KPIs aligned with your business goals. Every report includes analysis and strategic recommendations — not just raw data dumps.',
        ],
    ],
];

// ============================================================
// 3. Graphic Design Services
// ============================================================
$services['graphic_design_services'] = [
    'headline'    => 'Graphic Design Services',
    'subheadline' => "Increase trust, engagement, and brand recognition with design that's always on-brand.",
    'offerings'   => [
        [
            'title'       => 'Infographics & Illustration',
            'description' => 'Custom infographics and illustrations that transform complex data and concepts into visually compelling, shareable assets. Our designers work with your content team to distill key messages into graphics that enhance understanding and drive engagement.',
        ],
        [
            'title'       => 'Social Media Carousels',
            'description' => 'Scroll-stopping carousel designs optimized for Instagram, LinkedIn, and other social platforms. Each carousel is crafted to tell a story, educate your audience, or showcase products in a format that maximizes engagement and shares.',
        ],
        [
            'title'       => 'Product Photography',
            'description' => 'Professional product photography that showcases your items in the best light. From clean e-commerce shots on white backgrounds to styled lifestyle contexts, we capture images that build trust and drive purchase decisions.',
        ],
        [
            'title'       => 'Lifestyle Photography',
            'description' => 'Authentic lifestyle photography that tells your brand story and connects with your audience emotionally. We plan and execute photo shoots that show your products or services in real-world settings, creating aspirational imagery for your marketing.',
        ],
        [
            'title'       => 'Cartoons',
            'description' => 'Original cartoon illustrations that add personality and approachability to your brand communications. Whether for blog posts, social media, or internal communications, custom cartoons make your content memorable and distinctly yours.',
        ],
        [
            'title'       => 'Publication Design',
            'description' => 'Professional layout and design for ebooks, white papers, reports, magazines, and other long-form publications. We create polished, on-brand documents that elevate your content and make a strong impression on your audience.',
        ],
        [
            'title'       => 'Logos & Icons',
            'description' => 'Distinctive logo designs and custom icon sets that strengthen your visual brand identity. From brand-new logos to icon libraries for your website and app, we create cohesive visual assets that work across every touchpoint.',
        ],
        [
            'title'       => 'Photo Sourcing',
            'description' => 'Expert photo sourcing and curation when custom photography isn\'t needed. We search premium stock libraries and select images that feel authentic and on-brand — no generic stock art. Every image is licensed, optimized, and ready to use.',
        ],
    ],
    'why_heading' => 'Why Stretch?',
    'why_intro'   => "As your flexible design partner, we can take on all of your brand's needs for visual assets — or happily remain on-call for times when your internal design team is backlogged.",
    'benefits'    => [
        [
            'title'       => 'Strengthen SEO',
            'description' => 'Custom visuals do more than look good — they improve your SEO. Original images, infographics, and illustrations increase time on page, reduce bounce rates, and earn backlinks. We optimize every asset with proper alt text, file names, and compression for search performance.',
        ],
        [
            'title'       => 'Boost Your Brand',
            'description' => 'Consistent, high-quality design builds brand recognition and trust. Our designers follow your brand guidelines meticulously — or help you create them — ensuring every visual asset reinforces your identity and sets you apart from competitors.',
        ],
        [
            'title'       => 'One-Off or at Scale',
            'description' => 'Need a single infographic or a library of 500 product images? We scale our design team to match your needs. Our flexible model means you only pay for what you need, when you need it — no retainers or long-term commitments required.',
        ],
        [
            'title'       => 'Multiple Formats',
            'description' => 'Every asset is delivered in all the formats you need — web, print, social, and more. We provide source files, optimized exports, and platform-specific variations so your visuals look perfect everywhere they appear.',
        ],
    ],
    'faqs' => [
        [
            'question' => 'Can your designers match our existing brand guidelines?',
            'answer'   => 'Absolutely. We start every engagement by thoroughly reviewing your brand guidelines, style guides, and existing assets. Our designers internalize your visual identity — colors, typography, imagery style, tone — so that every deliverable is seamlessly on-brand.',
        ],
        [
            'question' => 'What is the typical turnaround time for design projects?',
            'answer'   => 'Turnaround varies by project scope. Simple assets like social graphics typically take 2-3 business days. More complex projects like infographics or publication design may take 1-2 weeks. We always provide a timeline upfront and communicate proactively about deadlines.',
        ],
        [
            'question' => 'Do you provide source files?',
            'answer'   => 'Yes. We deliver all design work with source files included — typically in Adobe Creative Suite formats (PSD, AI, INDD) or Figma, along with exported files in whatever formats you need (PNG, JPG, SVG, PDF, etc.).',
        ],
        [
            'question' => 'Can you handle large volumes of design work?',
            'answer'   => 'Yes — scale is one of our core strengths. We have a bench of experienced designers who can ramp up quickly to handle high-volume projects, from hundreds of product images to large-scale infographic libraries. Our project managers ensure quality stays consistent as volume increases.',
        ],
        [
            'question' => 'Do you offer revisions?',
            'answer'   => 'Yes. Every project includes revision rounds to ensure you are completely satisfied with the final deliverable. We work collaboratively through feedback, and our goal is always to get it right — not just get it done.',
        ],
        [
            'question' => 'Can you work with our content and marketing teams directly?',
            'answer'   => 'Of course. We regularly embed with client teams via Slack, Asana, Monday.com, or whatever project management and communication tools you prefer. Our designers participate in creative briefs, content planning sessions, and review cycles as if they were part of your team.',
        ],
    ],
];

// ============================================================
// 4. Video Content Services
// ============================================================
$services['video-content-services'] = [
    'headline'    => 'Video Content Services',
    'subheadline' => "Cut out the middlemen, and pay less for more. Our in-house Creative Director is an executive producer and storytelling mastermind with a cinematic eye and 30 years of experience.",
    'offerings'   => [
        [
            'title'       => 'Brand Stories',
            'description' => 'Cinematic brand films that capture your company\'s mission, values, and unique story. We produce polished, emotionally resonant videos that connect with your audience on a human level and differentiate your brand in a crowded market.',
        ],
        [
            'title'       => 'Corporate Video Services',
            'description' => 'Professional corporate videos for training, internal communications, investor relations, and recruitment. We bring the same production quality and storytelling craft to corporate work that we apply to consumer-facing content.',
        ],
        [
            'title'       => 'Documentaries',
            'description' => 'Long-form documentary content that dives deep into your brand story, industry, or cause. Our documentary team handles everything from research and pre-production through filming, editing, and distribution — creating compelling narratives that build authority and trust.',
        ],
        [
            'title'       => 'TV Advertisements',
            'description' => 'Broadcast-quality TV commercials that capture attention and drive action. From concept and scripting through production and post, we create ads that deliver your message with impact and meet all broadcast specifications.',
        ],
        [
            'title'       => 'Interviews',
            'description' => 'Professionally produced interview content featuring executives, customers, thought leaders, or subject-matter experts. We handle everything from question development and lighting setup to multi-camera filming and polished editing.',
        ],
        [
            'title'       => 'Social Media Advertisements',
            'description' => 'Thumb-stopping social video ads optimized for every platform — Instagram Reels, TikTok, YouTube Shorts, Facebook, and LinkedIn. We create platform-native content with the right aspect ratios, pacing, and hooks to maximize engagement and ROAS.',
        ],
        [
            'title'       => 'Motion Graphics & Animation',
            'description' => 'Eye-catching motion graphics and animation that bring abstract concepts to life. From animated explainers and logo reveals to data visualizations and kinetic typography, we create dynamic visual content that elevates your brand.',
        ],
    ],
    'why_heading' => 'Why Stretch?',
    'why_intro'   => 'Pay less for more.',
    'benefits'    => [
        [
            'title'       => 'Effective Strategy',
            'description' => 'Every video starts with a clear strategic purpose. We work with you to define goals, audience, distribution channels, and success metrics before a single frame is shot — so every dollar of your production budget drives measurable business results.',
        ],
        [
            'title'       => 'Masterful Storytelling',
            'description' => 'Our Creative Director brings 30 years of executive production experience and a cinematic eye for storytelling. We don\'t just capture footage — we craft narratives that move people emotionally and inspire action.',
        ],
        [
            'title'       => 'End-to-End Production',
            'description' => 'From concept development and scriptwriting through filming, editing, color grading, sound design, and final delivery — we handle every stage of production in-house. No subcontractors, no middlemen, no surprises.',
        ],
        [
            'title'       => 'Multiple Formats',
            'description' => 'One shoot, many assets. We plan every production to maximize your investment by capturing content that can be repurposed across formats — full-length videos, social cuts, GIFs, thumbnails, and still frames — all from a single session.',
        ],
    ],
    'faqs' => [
        [
            'question' => 'How much does video production cost?',
            'answer'   => 'Video production costs vary widely based on scope, complexity, and deliverables. We offer flexible packages that range from lean social-first productions to full cinematic shoots. We always start with your budget and goals, then design a production plan that maximizes value. Contact us for a custom quote.',
        ],
        [
            'question' => 'How long does a typical video project take?',
            'answer'   => 'Most projects take 4 to 8 weeks from concept to final delivery, depending on complexity. Simple social video content can be turned around in as little as 1-2 weeks. We provide a detailed production timeline at the start of every project so you know exactly what to expect.',
        ],
        [
            'question' => 'Do you handle everything in-house?',
            'answer'   => 'Yes. Strategy, scripting, production, editing, motion graphics, sound design, and color grading are all handled by our in-house team. This keeps costs down, quality consistent, and communication streamlined. For specialized needs like aerial cinematography or large-scale productions, we bring in trusted partners from our vetted network.',
        ],
        [
            'question' => 'Can you create video content for social media specifically?',
            'answer'   => 'Absolutely. Social-first video is one of our specialties. We produce platform-native content optimized for Instagram Reels, TikTok, YouTube Shorts, LinkedIn, and Facebook — with the right aspect ratios, pacing, captions, and hooks that each platform demands. We can also repurpose longer-form content into social-ready cuts.',
        ],
    ],
];


// ============================================================
// Save options and update page templates
// ============================================================
foreach ($services as $slug => $data) {
    // Save option
    update_option('stretch_service_' . $slug, $data, false);
    WP_CLI::log("Saved option: stretch_service_{$slug}");

    // Find the page by slug and set its template
    $page = get_page_by_path($slug);
    if ($page) {
        update_post_meta($page->ID, '_wp_page_template', 'page-service.php');
        WP_CLI::log("Set template for page: {$page->post_title} (ID: {$page->ID})");
    } else {
        WP_CLI::warning("Page not found for slug: {$slug}");
    }
}

WP_CLI::success('All service page content saved and templates assigned.');
