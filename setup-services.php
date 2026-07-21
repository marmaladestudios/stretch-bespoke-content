<?php
/**
 * Setup script for Service Page content.
 * Run via: docker compose exec wordpress wp eval-file /var/www/html/setup-services.php --allow-root
 */
// AUD-022: web-exposure guard — WP-CLI only, except when included by the setup
// wizard, which defines STRETCH_WIZARD immediately before including this file.
// A direct web request exits before doing anything.
if ((!defined('WP_CLI') || !WP_CLI) && !defined('STRETCH_WIZARD')) {
    exit;
}

if (!defined('ABSPATH')) {
    if (defined('WP_CLI') && WP_CLI) { WP_CLI::error('This script must be run via wp eval-file.'); } else { echo 'Error: ' . 'This script must be run via wp eval-file.' . "\n"; exit; }
}

$services = [];

// ============================================================
// 1. Content Writing at Any Scale
// ============================================================
$services['content-writing-at-any-scale'] = [
    // -------- Hero --------
    'headline'       => 'Content Writing at Any Scale',
    'headline_accent' => 'at Any Scale',
    'hero_overline'  => 'Our Services',
    'subheadline'    => 'High-quality content solves problems.',
    'hero_text'      =>     [
        'Your audience is looking for helpful, trustworthy information to support their next steps. Google and AI-based search are prioritizing great content that explains offerings and answers questions in a clear, organized, and engaging way.',
        'Stretch Creative creates content with purpose. We know how to build brand loyalty and credibility while guiding your readers ever closer to the bottom of the funnel.',
    ],
    'hero_cta_label' => 'Let’s Talk Content',
    'hero_cta_url'   => '/contact-stretch-creative/',

    // -------- Intro editorial photo (attachment ID; 0 => neutral placeholder) --------
    'intro_image'    => 0,

    // -------- Props (stat pills, not counters) --------
    'props' =>     [
        'No Minimums',
        'No Long-Term Contracts',
        'Dedicated Writing Team',
        'Editorial Visibility',
    ],

    // -------- Problem --------
    'problem' => [
        'overline' => 'The Reality',
        'heading'  => 'We’re in strange times.',
        'text'     =>             [
                'Search is changing faster than businesses can keep up.',
                'Traditional SEO is still central to getting discovered, but it’s no longer the only way people will find you online. AI-powered search experiences are changing how users ask questions, evaluate answers, and interact with websites, leaving many businesses wondering how to maintain visibility as AI becomes more prevalent in search.',
                'The good news? The fundamentals haven’t changed—along with strong technical SEO and a well-structured website, your best bet for capturing organic traffic online is to publish helpful, optimized content.',
            ],
    ],

    // -------- Solution --------
    'solution' => [
        'overline'  => 'The Solution',
        'heading'   => 'We’re your strategic',
        'heading_accent' => 'content-writing partner',
        'text'      => 'If your business works with freelance writers, faceless agencies, or content mills, we’re betting the results are hit-and-miss—mostly miss. If the writers producing your content don’t understand your brand, audience, or goals, the results are bound to be inconsistent and disconnected from your bigger picture. And if you don’t know who your writers are, how can you be sure they’re human?',
        'cta_label' => 'Get in Touch',
        'cta_url'   => '/contact-stretch-creative/',
        'points' =>             [
                ['title' => 'We produce quality content at high volumes.', 'body' => 'Most content bottlenecks are a quality problem, not a volume issue. With a tight-knit, properly trained writing team, strong editorial oversight, and a world-class production workflow, large volumes of content can be cohesive, consistent, and well-written.'],
                ['title' => 'We maintain consistent style and brand voice across assets.', 'body' => 'When you work with Stretch Creative, you work with a dedicated team of content professionals who get to know your audience, brand voice, and business goals. Content that flows from those foundations outperforms the rest every time.'],
                ['title' => 'Everything we produce is AEO- and SEO-optimized.', 'body' => 'Agency-wide, Stretch Creative is plugged into the latest Google Updates and SEO/AEO best practices for content that ranks. Search may be changing, but accurate, helpful, and engaging written assets will always perform.'],
                ['title' => 'We value accuracy and integrity.', 'body' => 'There’s a lot of terrible content on the Internet, and we’re committed to adding only words that bring value to the mix. Our editorial team is diligent about fact-checking and writing genuinely useful content that helps our fellow humans solve problems. No slop, no fluff.'],
                ['title' => 'We hand-pick writers based on their expertise.', 'body' => 'Not every writer excels at every content type or writes knowledgably on all topics. We know every one of our writers, their areas of expertise, and what types of content they crush every time. Whatever content you need, we’ll handpick the perfect team.'],
            ],
    ],

    // -------- Pull quote (giant ghost mark, Cyan highlight span) --------
    'pull_quote' => [
        'text'      => 'Most content bottlenecks are a quality problem, not a volume issue.',
        'highlight' => 'quality problem',
    ],

    // -------- Capabilities (Offerings) --------
    'offerings_overline'      => 'Capabilities',
    'offerings_heading'       => 'What We',
    'offerings_heading_accent' => 'Write',
    'offerings_intro'         => 'Stretch Creative delivers whatever types of content you need, on brand, on time, and publish-ready.',
    'offerings' =>     [
        ['title' => 'Blog articles', 'description' => 'Educational, informative, inspirational, and search-optimized articles designed to answer questions and attract qualified audiences.'],
        ['title' => 'Buying guides', 'description' => 'The perfect balance of editorial romance and practical information, built to inspire confidence and drive buying decisions.'],
        ['title' => 'Product & category page content', 'description' => 'Product descriptions and helpful category page copy that help shoppers at every stage of the funnel evaluate and compare products.'],
        ['title' => 'Service, industry, and location pages', 'description' => 'Informative location-, industry-, or service-specific content designed to support local visibility and help potential customers understand your services.'],
        ['title' => 'Ebooks & white papers', 'description' => 'Authoritative long-form resources that establish expertise, educate audiences, and capture leads.'],
        ['title' => 'Email & social content', 'description' => 'Audience-focused social media content and email campaigns that strengthen relationships, support broader marketing initiatives, and keep your brand top of mind.'],
        ['title' => 'Google Ads, banners, and landing pages', 'description' => 'Snappy, optimized ads, banners, and the pages they lead to, written together and dialed in to perform.'],
        ['title' => 'Website copy', 'description' => 'Clear, compelling, and SEO- and AEO-optimized copy for your homepage, landing pages, and supporting website content.'],
        ['title' => 'User-generated content', 'description' => 'Authentic first-person UGC, created by clever, experienced writers who know how to make it land.'],
        ['title' => 'Expert-written & expert-reviewed content', 'description' => 'Content for YMYL topics like healthcare, finance, technology, and other industries where trust, accuracy, subject-matter expertise, and an expert byline are critical.'],
        ['title' => 'Thought leadership', 'description' => 'Expert articles, executive bylines, and other content that help your organization share expertise, build trust, and establish authority within your industry.'],
        ['title' => 'Case studies', 'description' => 'Engaging customer stories and success narratives that demonstrate results and build trust and credibility.'],
        ['title' => 'Optimizations and rewrites', 'description' => 'Blog articles, category pages, landing pages, and other website content can go stale after a while. We can optimize or rewrite existing content to improve visibility.'],
    ],

    // -------- Add-On Services (replaces Selected Work strip) --------
    'addons_overline' => 'Additional Support',
    'addons_heading'  => 'Add-On Services',
    'addons' =>     [
        ['title' => 'SEO + Editorial', 'description' => 'SEO keyword research, topic ideation, content strategy, content briefs'],
        ['title' => 'Budget Management', 'description' => 'Coordinated production oversight and budget tracking'],
        ['title' => 'Content Loading', 'description' => 'Formatting, uploading, publishing, and QA support within your content management system.'],
    ],

    // -------- Cross-sell CTA --------
    'cross_cta' =>     [
        'heading' => 'Need more than written content?',
        'body'    => 'We’re a full-scale agency offering all of the services you need to work smarter and rank higher.',
        'links'   => [
            ['label' => 'SEO/AEO Services', 'url' => '/seo_content_strategy_services/'],
            ['label' => 'Interactive Content Marketing', 'url' => '/services/bespoke-content-experience/'],
            ['label' => 'Visual Content & Design', 'url' => '/visual-content-and-design/'],
            ['label' => 'Paid Advertising', 'url' => '/paid-advertising/'],
        ],
    ],

    // -------- Process (How It Works) --------
    'process' => [
        'overline' => 'Process',
        'heading'  => 'How We Work',
        'intro'    =>             [
                'You can’t send a content brief into the void and expect great content to come back.',
                'Our collaborative process sets us apart from other content agencies, and it’s what enables us to produce stellar work that lightens your editing load and removes uncertainties around quality and consistency.',
            ],
        'steps' =>             [
                ['title' => 'Consultation', 'description' => 'We start with a conversation between your team and our client services and editorial teams. Producing effective content starts with understanding your goals, your audience, your pain points, and what "great" work looks like for you.'],
                ['title' => 'Editorial selection', 'description' => 'We hand-select writers with the right experience for your content (you’re welcome to meet them). The team lead creates an internal style guide for your brand, including audience information, purpose, and formatting preferences, and trains the writers.'],
                ['title' => 'Calibration', 'description' => 'Before we move into full production, we write a handful of pieces and pressure-test the process. We gather your feedback, make adjustments, and get everything dialed in.'],
                ['title' => 'Full-scale production', 'description' => 'With your writing cohort trained and practiced, and your feedback documented and communicated, we move into full production. Two rounds of revisions are always included, but once we’re up and running, they’re not usually necessary.'],
                ['title' => 'Ongoing collaboration', 'description' => 'Scheduled bi-weekly or monthly touch-base meetings provide an opportunity for us to get feedback, discuss emerging needs, and stay in the loop on projects coming down the pipeline. The relationship we build with your team is critical to our success.'],
            ],
    ],

    // -------- Process team/collaboration photo (attachment ID; 0 => placeholder) --------
    'process_image' => 0,

    // -------- Why Stretch / Benefits --------
    'why_overline' => 'The Difference',
    'why_heading'  => 'Why Stretch Creative?',
    'benefits' =>     [
        ['title' => 'All of the services you need under one roof', 'description' => 'SEO, content, design, photography, video, and paid advertising working together to support your growth strategy.'],
        ['title' => 'Human-created, expert-led', 'description' => 'Every project is developed by experienced content writers who understand how to communicate important, complex ideas clearly and accurately.'],
        ['title' => 'Built to scale', 'description' => 'Whether you’re launching a new product, entering a new market, or expanding your content program, our team can scale alongside your business.'],
        ['title' => 'A single point of contact', 'description' => 'Your dedicated project manager supports your team with attention to the details and diligent communication so nothing falls through the cracks.'],
    ],

    // -------- Testimonials (3 real; image => avatar attachment ID, 0 => placeholder) --------
    'testimonials_overline'   => 'Social Proof',
    'testimonials_heading'    => 'What Our Clients Say',
    'testimonials_subheading' => 'A few of the brands that trust us with their content.',
    'testimonials' => [
        [
            'quote' => 'Working with Stretch Creative has been the biggest difference-maker in scaling Grove Collaborative’s SEO content operations. Not only that, the Stretch Creative team has been a pure joy to work with — they’ve been one of the best agencies I’ve worked with during my SEO career, and I cannot recommend them enough.',
            'name'  => 'Kristen Haney',
            'title' => 'Sr. Growth Manager SEO Content, Grove Collaborative',
            'image' => 0,
        ],
        [
            'quote' => 'We have worked with Stretch on numerous projects across multiple channels and global markets. They were heavily involved in each project to get it across the line in a timely manner and strive to deliver the highest quality of work.',
            'name'  => 'Karen Hewitt',
            'title' => 'Sr. Marketing Manager Demand Generation, WeWork',
            'image' => 0,
        ],
        [
            'quote' => 'Stretch is professional, punctual, and overall an amazing asset for us. No matter the task or turnaround time, they do a great job of bringing our brand identity to life and delivering assets on time.',
            'name'  => 'Keenan Wilson',
            'title' => 'Marketing Manager, Stance',
            'image' => 0,
        ],
    ],

    // -------- FAQ --------
    'faq_overline' => 'FAQ',
    'faq_heading'  => 'Frequently Asked Questions',
    'faqs' => [
        [
            'question' => 'What does “content at any scale” actually mean?',
            'answer'   => 'Whether you need five articles a month or five hundred product descriptions a week, we have the team and the process to handle it. Volume never comes at the expense of quality — our editorial workflow makes sure of that.',
        ],
        [
            'question' => 'Can you write for my industry?',
            'answer'   => 'Almost certainly. Our roster covers ecommerce, SaaS, health and wellness, finance, home and lifestyle, publishing, and more. We’ll match you with writers who have real experience in your space — and if you need a credentialed expert byline for YMYL content, we have those, too.',
        ],
        [
            'question' => 'How do you handle large-scale projects?',
            'answer'   => 'With a dedicated project manager, detailed onboarding, collaborative tools, and a calibration phase before we ramp up production. By the time we’re operating at full volume, your cohort knows your brand inside and out.',
        ],
        [
            'question' => 'How does pricing work?',
            'answer'   => 'Our pricing is competitive, flexible, and built around your actual needs — the volume, complexity, and type of content you require. We’ll put together a model that works for your budget and fairly compensates our writers, which means lower turnover and a team that stays invested in your brand long-term.',
        ],
        [
            'question' => 'Do you have monthly minimums?',
            'answer'   => 'No. We’ll work with you at whatever pace makes sense for your business.',
        ],
    ],

    // -------- Closing CTA --------
    'cta' => [
        'heading'         => 'Ready to Scale Your Content?',
        'subheading'      => 'Let’s build something great together.',
        'text'            => 'Whether you need a handful of pieces or a full content operation, we’ll put together a team that knows your brand and delivers work you’re proud to publish. No fluff. No chasing. Just great content — at any scale.',
        'button_label'    => 'Get in Touch',
        'button_url'      => '/contact-stretch-creative/',
        'secondary_label' => 'See Our Work',
        'secondary_url'   => '/our-work/',
    ],
];

// ============================================================
// Shared testimonials (reused across all service pages until we have
// service-specific ones)
// ============================================================
$shared_testimonials_heading    = 'What Our Clients Say';
$shared_testimonials_subheading = 'A few of the brands that trust us with their content.';
$shared_testimonials = [
    [
        'quote' => "Working with Stretch Creative has been the biggest difference-maker in scaling Grove Collaborative's SEO content operations. Not only that, the Stretch Creative team has been a pure joy to work with — they've been one of the best agencies I've worked with during my SEO career, and I cannot recommend them enough.",
        'name'  => 'Kristen Haney',
        'title' => 'Sr. Growth Manager SEO Content, Grove Collaborative',
    ],
    [
        'quote' => 'We have worked with Stretch on numerous projects across multiple channels and global markets. They were heavily involved in each project to get it across the line in a timely manner and strive to deliver the highest quality of work.',
        'name'  => 'Karen Hewitt',
        'title' => 'Sr. Marketing Manager Demand Generation, WeWork',
    ],
    [
        'quote' => 'Stretch is professional, punctual, and overall an amazing asset for us. No matter the task or turnaround time, they do a great job of bringing our brand identity to life and delivering assets on time.',
        'name'  => 'Keenan Wilson',
        'title' => 'Marketing Manager, Stance',
    ],
];

// ============================================================
// 2. SEO & Content Strategy Services
// ============================================================
$services['seo_content_strategy_services'] = [
    // -------- Hero --------
    'headline'       => 'SEO + AEO Strategy & Services',
    'headline_accent' => 'Strategy & Services',
    'subheadline'    => 'Get found today, stay visible tomorrow.',
    'hero_text'      =>     [
        'Search has changed. Ranking well on Google is still important, but it’s no longer the only way people discover businesses online.',
        'Stretch Creative combines proven SEO strategies with Answer Engine Optimization (AEO) to help your website perform across traditional search engines, AI-powered search experiences, and whatever comes next.',
    ],
    'hero_cta_label' => 'Let’s Talk Search',
    'hero_cta_url'   => '/contact-stretch-creative/',

    // -------- Props (stat pills, not counters) --------
    'props' =>     [
        'Technical SEO Expertise',
        'AEO-Ready Strategies',
        'Transparent Reporting',
        'No Long-Term Contracts',
    ],
    'props_footnote' => 'From enterprise audits to SEO-Lite, you only pay for the services you need.',

    // -------- Problem --------
    'problem' => [
        'overline' => 'The Reality',
        'heading'  => 'Search is evolving at light speed.',
        'text'     =>             [
                'Businesses have spent years learning how to succeed in traditional search, only to have AI reshape the landscape almost overnight.',
                'People are still searching, but they’re increasingly asking questions directly in ChatGPT, Google AI Overviews, Perplexity, Claude, and other AI-powered tools.',
                'The good news? SEO isn’t dead, and search engines and answer engines continue to reward websites that demonstrate expertise, publish genuinely helpful content, and provide an excellent user experience.',
                'Search may be evolving, but the strongest websites still combine a solid technical foundation with helpful, authoritative content that’s organized and optimized for both search engines and AI platforms to understand.',
            ],
    ],

    // -------- Solution --------
    'solution' => [
        'overline'  => 'The Solution',
        'heading'   => 'SEO isn’t about chasing algorithms.',
        'text'      =>             [
                'Every Google update and AI leap forward seems to bring a new set of “must-follow” tactics. We focus on integrating new best practices thoughtfully into the fundamentals that have always mattered: understanding your audience, creating useful content, building technically sound websites, and adapting as search evolves.',
                'Here’s how Stretch Creative helps businesses stay visible to search engines and AI-based search—without reinventing the wheel.',
            ],
        'cta_label' => 'Get in Touch',
        'cta_url'   => '/contact-stretch-creative/',
        'points' =>             [
                ['title' => 'We build strategies around your business.', 'body' => 'We develop SEO and AEO strategies that reflect your goals instead of applying one-size-fits-all recommendations. We handle the detailed work that separates pages that rank from those that stay on page two.'],
                ['title' => 'We combine technical SEO with great content.', 'body' => 'Technical SEO helps search engines find your content. Great content gives them something worth ranking. Our writers, editors, and SEO specialists work together to ensure every page serves both audiences.'],
                ['title' => 'We optimize for today’s search experiences.', 'body' => 'Modern search extends beyond Google. We structure content to perform across traditional search, AI-generated answers, featured snippets, voice search, and emerging answer engines.'],
                ['title' => 'We prioritize long-term growth.', 'body' => 'Quick wins are great, but sustainable visibility comes from consistent optimization, a thoughtful content strategy, and ongoing improvements—not shortcuts.'],
                ['title' => 'We translate data into action.', 'body' => 'SEO reports shouldn’t require a translator. We explain what the data means, identify opportunities, and provide practical recommendations your team can actually use.'],
            ],
    ],

    // -------- Capabilities (Offerings) --------
    'offerings_overline'   => 'Capabilities',
    'offerings_heading'    => 'What We Deliver',
    'offerings_intro'      => 'Our strategic SEO support services improve visibility across modern-day search engines.',
    'offerings' =>     [
        ['title' => 'Technical SEO', 'description' => 'Website audits, crawl analyses, indexing recommendations, site architecture reviews, Core Web Vitals guidance, and technical improvements to help search engines understand your website.'],
        ['title' => 'Keyword research', 'description' => 'Audience-focused keyword research that identifies ranking and conversion opportunities based on search demand, intent, competition, and your business goals.'],
        ['title' => 'SEO content strategy', 'description' => 'Topic planning, editorial mapping, and content recommendations designed to support long-term, organic growth.'],
        ['title' => 'Content briefs', 'description' => 'Your keywords and content strategy, embodied in SEO editorial briefs that help writers produce well-organized, helpful, and search-optimized articles.'],
        ['title' => 'On-page SEO', 'description' => 'Title tags, meta descriptions, header hierarchy, internal linking, schema markup, and content structure—optimized across every page that matters.'],
        ['title' => 'SEO audits', 'description' => 'Comprehensive evaluations of your website’s technical health, content quality, user experience, and search visibility, along with prioritized recommendations.'],
        ['title' => 'SEO and AEO content optimization', 'description' => 'Optimize existing content for SEO and AEO, from blogs and category pages to location and service pages, to make them more visible to today’s search engines.'],
        ['title' => 'Performance tracking & reporting', 'description' => 'Transparent, business-focused reporting focused on meaningful metrics like rankings, organic traffic, and click-through rates translated into actionable recommendations.'],
    ],

    // -------- Add-On Services --------
    'addons_heading' => 'Add-On Services',
    'addons' =>     [
        ['title' => 'Budget management', 'description' => 'Coordinated production oversight and budget tracking for larger SEO and content initiatives.'],
    ],

    // -------- Cross-sell CTA --------
    'cross_cta' =>     [
        'heading' => 'Need More Than SEO?',
        'body'    => 'We’re a full-scale agency offering all of the services you need to rank higher and maximize your budget.',
        'links'   => [
            ['label' => 'Content Writing', 'url' => '/content-writing-at-any-scale/'],
            ['label' => 'Interactive Content Marketing', 'url' => '/services/bespoke-content-experience/'],
            ['label' => 'Visual Content & Design', 'url' => '/visual-content-and-design/'],
            ['label' => 'Paid Advertising', 'url' => '/paid-advertising/'],
        ],
    ],

    // -------- Process (How It Works) --------
    'process' => [
        'overline' => 'Process',
        'heading'  => 'How We Work',
        'intro'    => 'SEO works best when it’s an ongoing process of improving your website, understanding your audience, and adapting to changes in search. Here’s how we work.',
        'steps' =>             [
                ['title' => 'Discovery', 'description' => 'We begin by learning about your business, audience, competitors, and goals before reviewing your existing website and search performance.'],
                ['title' => 'Audit & Research', 'description' => 'Our team evaluates your site’s technical health, keyword opportunities, existing content, and competition to identify the best opportunities for improvement, usually starting with the low-hanging fruit.'],
                ['title' => 'Strategy Development', 'description' => 'We develop a practical, detailed roadmap that prioritizes recommendations based on impact, effort, and your business objectives.'],
                ['title' => 'Implementation', 'description' => 'Whether we’re optimizing existing pages, creating new content, or improving technical performance, we execute every recommendation with long-term success in mind.'],
                ['title' => 'Ongoing Optimization', 'description' => 'Search is constantly changing. Through regular reporting, performance reviews, and strategic recommendations, we help your website continue to grow.'],
            ],
    ],

    // -------- Why Stretch / Benefits --------
    'why_heading' => 'Why Stretch Creative?',
    'benefits' =>     [
        ['title' => 'SEO built to scale', 'description' => 'We use proven frameworks and efficient workflows that deliver consistent, high-quality SEO work, no matter the scope of your project.'],
        ['title' => 'All of the services you need under one roof', 'description' => 'SEO, content, design, photography, video, and paid advertising work together to support your digital growth strategy. Add services as you need them, long-term or project-by-project.'],
        ['title' => 'Holistic SEO and AEO', 'description' => 'We take a holistic approach to SEO and AEO that encompasses content quality, user experience, technical optimization, and link building. Every recommendation is grounded in how today’s search engines actually evaluate and rank content.'],
        ['title' => 'Measurable Results', 'description' => 'We set clear KPIs from the start and track performance rigorously. You’ll get regular reports showing exactly how your content is performing—traffic, rankings, conversions—along with actionable recommendations for continuous improvement.'],
    ],

    // -------- FAQ (unchanged) --------
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
            'title'       => 'Infographics & Illustrations',
            'description' => 'Our talented designers turn complicated data or ideas into relatable, visually appealing graphics to inform, inspire, and educate your audience.',
        ],
        [
            'title'       => 'Logos & Icons',
            'description' => 'Increase brand recognition and enhance your content and credibility with graphics like logos and icons for your website, blog articles, or other assets.',
        ],
        [
            'title'       => 'Social Media Carousels',
            'description' => 'Scroll-stopping carousel designs optimized for Instagram, LinkedIn, and other social platforms — crafted to tell a story, educate your audience, or showcase products in a format that maximizes engagement.',
        ],
        [
            'title'       => 'Publication Design',
            'description' => 'Professional layout and design for ebooks, white papers, reports, and long-form publications. Polished, on-brand documents that elevate your content and make a strong impression.',
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
    'stats' => [
        ['label' => 'Designers', 'value' => '50', 'suffix' => '+'],
        ['label' => 'Turnaround', 'value' => '24', 'suffix' => 'hr'],
        ['label' => 'Formats', 'value' => 'Multiple', 'suffix' => ''],
        ['label' => 'Brand Match', 'value' => 'On-Brand Always', 'suffix' => ''],
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
    'headline'    => 'Video & Photography Production',
    'subheadline' => "Cut out the middlemen, and pay less for more. Our in-house Creative Director brings 30 years of experience to every shoot — video or photography — for a cinematic eye and a streamlined crew you can actually afford.",
    'offerings'   => [
        [
            'title'       => 'Brand Stories',
            'description' => 'Let us tell your brand story — ideated, written, and produced with keen attention to your vibe, values, and vision. We\'ll help turn your ideas into a solid concept and shoot a sleek, cinematic production you\'ll be proud to share far and wide.',
        ],
        [
            'title'       => 'Corporate Video Services',
            'description' => 'Get your message across with expert visual storytelling, complete with hooks that draw in and engage any audience. We\'ll produce interesting videos to highlight your company\'s achievements for investors, create training videos for new hires, or explainer videos for sales and marketing.',
        ],
        [
            'title'       => 'TV Advertisements',
            'description' => 'Television commercials have a lot of moving parts that traditionally involve a slew of decision-makers and creators — and that\'s why they\'re generally so expensive. We streamline the TV ad process by cutting out the various middle people and creating your commercials entirely in-house, from ideation and scriptwriting to pre- and post-production.',
        ],
        [
            'title'       => 'Social Media Ads',
            'description' => 'Our smart, clever copywriters and talented video production team create fun, shareable social media posts and ads designed to convert — and to be remembered. We\'ll run with your concept or put our heads together to come up with ideas you can take back to your team. However we roll, we\'ll do it in close collaboration with your marketing department.',
        ],
        [
            'title'       => 'Documentaries',
            'description' => 'Telling real stories of real people, our documentaries are a blend of emotion, information, and inspiration.',
        ],
        [
            'title'       => 'Motion Graphics & Animation',
            'description' => 'Make your corporate video or brand story more informative or entertaining with customized motion graphics or animations. Repurpose these moving bits for social media or email campaigns to maximize your marketing dollars.',
        ],
        [
            'title'       => 'Interviews',
            'description' => 'Give your employees, stakeholders, or customers a voice with interview videos that get to the heart of the matter. We\'ll dispatch a local videographer to capture the footage and then bring it in-house to turn it into a production worthy of any distribution channel. We can even repurpose it into blog posts or sound bites — or incorporate the footage into other visual assets.',
        ],
        [
            'title'       => 'Pre-Production',
            'description' => 'May include ideating, scriptwriting, talent and location scouting, storyboarding, and more — everything that needs to happen before the cameras roll.',
        ],
        [
            'title'       => 'Production',
            'description' => 'Includes all aspects of shooting the video — from direction and lighting to sound and sets to talent management.',
        ],
        [
            'title'       => 'Post-Production',
            'description' => 'May include trimming clips, adding transitions and special effects, enhancing audio levels, and adding titles, sub-titles, animations, or moving graphics to create a cohesive and engaging final product.',
        ],
        [
            'title'       => 'Video Interviewing',
            'description' => 'We\'ll film an interview with your subject, either remotely or in person, no matter where they\'re located. We\'ll edit it as you like or break it into snippets for use on a website or social media. The transcript can be used to create blog posts.',
        ],
        [
            'title'       => 'Product Photography',
            'description' => 'Exceptional product photography is the backbone of a successful e-comm. We\'ll capture the essence of your products and highlight their features with stunning visuals that leave a lasting impression.',
        ],
        [
            'title'       => 'Lifestyle Photography',
            'description' => 'Leave it to our photographers to capture real moments that highlight the authenticity of your brand and connect with your audience in a memorable way.',
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
    'stats' => [
        ['label' => 'Experience', 'value' => '30', 'suffix' => 'yr'],
        ['label' => 'Production', 'value' => 'End-to-End', 'suffix' => ''],
        ['label' => 'Quality', 'value' => '4K', 'suffix' => ''],
        ['label' => 'Distribution', 'value' => 'Multi-Platform', 'suffix' => ''],
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
// 5. Content Strategy
// ============================================================
$services['content-strategy'] = [
    'headline'    => 'Content Strategy That Drives Results',
    'headline_accent' => 'Drives Results',
    'subheadline' => "Whether you're starting from zero or scaling what's already working, we plug in wherever you need strategic support — from SEO-backed roadmaps to winning editorial briefs.",
    'offerings'   => [
        [
            'title'       => 'Content Roadmaps',
            'description' => 'A full content roadmap built from audience research, competitive analysis, and SEO opportunity — with clear topic clusters, formats, and cadences mapped against your business goals.',
        ],
        [
            'title'       => 'Editorial Content Briefs',
            'description' => 'Thorough briefs that set writers up to win. We define angle, audience, key points, sources, and structure so every piece lands in your voice and performs in search.',
        ],
        [
            'title'       => 'Audience & Persona Research',
            'description' => 'Deep qualitative and quantitative research to understand who you are writing for, what they care about, and how to earn their attention at each stage of the journey.',
        ],
        [
            'title'       => 'Content Audits',
            'description' => 'A clear-eyed look at what you have live today — what is performing, what should be optimized, what should be consolidated, and what should be retired.',
        ],
        [
            'title'       => 'Channel Strategy',
            'description' => 'Decide where your content should live and how it should travel — blog, social, email, owned properties — with a plan for amplification, not just publication.',
        ],
        [
            'title'       => 'Editorial Calendar Management',
            'description' => 'We run the calendar: topic intake, prioritization, assignment, deadline tracking, and publishing cadence — so nothing slips and every month moves the strategy forward.',
        ],
        [
            'title'       => 'Topic Cluster Architecture',
            'description' => 'Pillar-and-cluster frameworks that build topical authority and internal linking equity, designed to compound organic performance over time.',
        ],
        [
            'title'       => 'User Journey Mapping',
            'description' => 'Let us map your entire customer journey across all digital touchpoints, from initial brand interaction through to purchasing decisions — so your content meets readers where they actually are.',
        ],
        [
            'title'       => 'Marketing Position',
            'description' => 'We\'ll conduct a competitor and market review to help inform your go-to-market strategy, tone of voice, and launch campaign approach.',
        ],
        [
            'title'       => 'Product Naming',
            'description' => 'Our creatives will give your products the best names ever — names that stick, tell a story, and survive a trademark search.',
        ],
    ],
    'why_heading' => 'Why Stretch?',
    'why_intro'   => "Strategy without execution is a document. We sit at the intersection of research, editorial, and SEO — so the strategy we build is the one your team can actually ship.",
    'benefits'    => [
        [
            'title'       => 'Rooted in Research',
            'description' => 'Every recommendation is backed by data — keyword research, SERP analysis, audience insights, and content performance — not gut instinct or template frameworks.',
        ],
        [
            'title'       => 'Plug In Where You Need',
            'description' => "Start from scratch, audit what exists, or jump into the middle of an active program — we scope the engagement to match the gap you're trying to fill.",
        ],
        [
            'title'       => 'SEO-Integrated',
            'description' => 'Our strategists and SEO team sit together. The strategy you get is already optimized for discovery, not bolted onto an SEO plan after the fact.',
        ],
        [
            'title'       => 'Built to Execute',
            'description' => 'Everything we deliver is actionable — briefs writers can pick up, calendars editors can run, frameworks designers can build against. No shelf-ware.',
        ],
    ],
    'stats' => [
        ['label' => 'Approach', 'value' => 'Custom', 'suffix' => ''],
        ['label' => 'Integration', 'value' => 'SEO + Editorial', 'suffix' => ''],
        ['label' => 'Strategists', 'value' => 'Senior', 'suffix' => ''],
        ['label' => 'Delivery', 'value' => 'Actionable', 'suffix' => ''],
    ],
    'faqs' => [
        [
            'question' => 'Can you build a content strategy from scratch?',
            'answer'   => 'Yes. We start with a discovery deep-dive, run competitive and keyword research, and build a content strategy from the ground up — including audience definition, topic clusters, channel mix, and editorial cadence.',
        ],
        [
            'question' => 'Can you work with a strategy we already have?',
            'answer'   => 'Absolutely. We regularly plug into existing programs — auditing the current strategy, identifying gaps, and either filling them ourselves or arming your team with the frameworks and briefs to execute better.',
        ],
        [
            'question' => "What's included in your editorial briefs?",
            'answer'   => 'Target keyword and search intent, recommended angle, working title, reader takeaways, required sources, structural recommendations, internal linking opportunities, and voice/tone notes — everything a writer needs to deliver a publish-ready draft.',
        ],
        [
            'question' => 'How long until we see results from a new strategy?',
            'answer'   => 'Content strategy is a long game. Expect early signals — better briefs, more aligned output, reduced rework — within the first 30-60 days. Organic traffic improvements typically compound over 3 to 9 months depending on domain authority and publishing velocity.',
        ],
        [
            'question' => 'Do you support execution or just strategy?',
            'answer'   => 'Both. Some clients hire us for the strategy layer only; others want us to execute it through writing, design, and video. We scale up or down based on what your team needs — and what your team already has covered.',
        ],
    ],
];

// ============================================================
// 6. Paid Advertising
// ============================================================
$services['paid-advertising'] = [
    // -------- Hero --------
    'headline'       => 'Paid Advertising Services',
    'headline_accent' => 'Advertising Services',
    'subheadline'    => 'Reach the right audience with campaigns built to perform.',
    'hero_text'      => 'The best advertising reaches people with the right message at the right moment. Stretch Creative develops paid advertising campaigns backed by thoughtful strategy, compelling messaging and visuals, and continuous refining and optimization to help you connect with qualified audiences and make the most of your marketing budget.',
    'hero_cta_label' => 'Let’s Build Your Next Campaign',
    'hero_cta_url'   => '/contact-stretch-creative/',

    // -------- Props (stat pills, not counters) --------
    'props' =>     [
        'Search, Shopping & Social Ads',
        'Performance Tracking & Optimization',
        'Ad Copywriting & Design',
        'No Long-Term Contracts',
    ],

    // -------- Problem --------
    'problem' => [
        'overline' => 'The Reality',
        'heading'  => 'Competition isn’t getting any cheaper.',
        'text'     =>             [
                'Paid advertising has become more competitive, more expensive, and more complex in recent years. Rising costs, changing privacy regulations, evolving algorithms, and increasing competition mean businesses can’t afford to rely on guesswork or “set it and forget it” campaigns.',
                'The good news? Strong visuals, compelling messaging, thoughtful targeting, and ongoing optimization still make paid advertising one of the fastest ways to reach qualified customers. Success comes from combining smart strategy with messaging and visuals that give people a reason to click.',
            ],
    ],

    // -------- Solution --------
    'solution' => [
        'overline'  => 'The Solution',
        'heading'   => 'Effective campaigns don’t happen by accident.',
        'text'      =>             [
                'Clicks don’t happen because an ad exists—they happen because the message resonates with the right audience.',
                'Here’s how Stretch Creative helps businesses get more from their advertising investment.',
            ],
        'cta_label' => 'Get in Touch',
        'cta_url'   => '/contact-stretch-creative/',
        'points' =>             [
                ['title' => 'We build campaigns around your goals.', 'body' => 'Every campaign begins with your objectives, audience, and budget—never a templated media plan. Whether you’re driving sales, generating leads, or building awareness, we create strategies that support measurable business outcomes.'],
                ['title' => 'We connect strategy with flawless execution.', 'body' => 'Successful advertising depends on more than targeting. Our writers, designers, photographers, and videographers work together to create ads and landing pages that feel cohesive and compelling from first impression to final conversion.'],
                ['title' => 'We optimize continuously.', 'body' => 'The strongest campaigns improve over time. We monitor performance, test ads and landing pages, refine targeting, and make data-driven adjustments to improve efficiency and results.'],
                ['title' => 'We make every click count.', 'body' => 'Driving traffic is only part of the equation. We help ensure the pages behind your ads deliver the information, experience, and calls to action needed to convert visitors into customers.'],
                ['title' => 'We provide clear reporting.', 'body' => 'You shouldn’t have to interpret confusing dashboards. We provide transparent reporting and practical recommendations that help you understand what’s working and where to improve.'],
            ],
    ],

    // -------- Capabilities (Offerings) --------
    'offerings_overline'   => 'Capabilities',
    'offerings_heading'    => 'Advertising Services We Offer',
    'offerings' =>     [
        ['title' => 'Search advertising', 'description' => 'Text-based search campaigns that connect your business with customers actively searching for your products or services.'],
        ['title' => 'Google shopping ads', 'description' => 'Product-focused campaigns that help ecommerce businesses increase visibility and drive qualified traffic.'],
        ['title' => 'Social media advertising', 'description' => 'Paid campaigns for Meta, LinkedIn, TikTok, Pinterest, and other social platforms designed to build awareness, generate leads, and drive conversions.'],
        ['title' => 'Display advertising', 'description' => 'Visual banner ads that expand brand awareness, support remarketing efforts, and reach audiences across the web.'],
        ['title' => 'Retargeting campaigns', 'description' => 'Targeted advertising that reconnects with previous website visitors and encourages them to return and take action.'],
        ['title' => 'Landing pages', 'description' => 'Dedicated campaign landing pages optimized to support your advertising goals and improve conversion rates.'],
        ['title' => 'Ad copy & design', 'description' => 'Compelling ad copy, graphics, photography, video, and other campaign assets developed specifically for paid advertising.'],
        ['title' => 'Performance reporting & insights', 'description' => 'Campaign monitoring, performance analysis, budget tracking, and ongoing optimization recommendations.'],
    ],

    // -------- Add-On Services --------
    'addons_heading' => 'Add-On Services',
    'addons' =>     [
        ['title' => 'SEO & Content Strategy', 'description' => 'SEO keyword research, content planning, landing page optimization, and supporting content designed to strengthen paid campaigns.'],
        ['title' => 'Budget Management', 'description' => 'Campaign oversight, media budget tracking, vendor coordination, and performance monitoring.'],
        ['title' => 'CMS Loading', 'description' => 'Landing page formatting, publishing, and quality assurance within your content management system.'],
    ],

    // -------- Cross-sell CTA --------
    'cross_cta' =>     [
        'heading' => 'Need more than paid advertising?',
        'body'    => 'We’re a full-scale agency offering everything you need to improve visibility, create better content, and grow your business.',
        'links'   => [
            ['label' => 'SEO/AEO Services', 'url' => '/seo_content_strategy_services/'],
            ['label' => 'Interactive Content Marketing', 'url' => '/services/bespoke-content-experience/'],
            ['label' => 'Visual Content & Design', 'url' => '/visual-content-and-design/'],
            ['label' => 'Content Writing', 'url' => '/content-writing-at-any-scale/'],
        ],
    ],

    // -------- Process (How It Works) --------
    'process' => [
        'overline' => 'Process',
        'heading'  => 'How We Work',
        'intro'    => 'Great advertising starts long before an ad goes live.',
        'steps' =>             [
                ['title' => 'Discovery', 'description' => 'We learn about your business, audience, competitors, goals, and budget to understand what success looks like.'],
                ['title' => 'Campaign Strategy', 'description' => 'Our team develops audience targeting, messaging, creative concepts, platform recommendations, and campaign structure tailored to your objectives.'],
                ['title' => 'Creative Development', 'description' => 'Writers, designers, photographers, and videographers collaborate to create advertising assets that capture attention and reinforce your brand.'],
                ['title' => 'Campaign Launch', 'description' => 'We build, test, and launch campaigns while ensuring tracking, reporting, and landing pages are ready to support performance.'],
                ['title' => 'Optimization', 'description' => 'Advertising isn’t static. We continuously monitor results, refine targeting, and optimize campaigns to improve performance over time.'],
            ],
    ],

    // -------- Why Stretch / Benefits --------
    'why_heading' => 'Why Stretch Creative?',
    'benefits' =>     [
        ['title' => 'All of the services you need under one roof', 'description' => 'SEO, content, design, photography, video, and paid advertising working together to support your growth strategy.'],
        ['title' => 'Human-created, expert-led', 'description' => 'Our strategists, writers, designers, and digital advertising specialists create campaigns built on thoughtful design, strong creative messaging, and measurable performance.'],
        ['title' => 'Built to scale', 'description' => 'Whether you’re launching your first campaign or managing advertising across multiple markets, our team can scale alongside your business.'],
        ['title' => 'A single point of contact', 'description' => 'Your dedicated project manager keeps campaigns moving, communication clear, and every deliverable aligned with your goals.'],
    ],

    // -------- FAQ (unchanged) --------
    'faqs' => [
        [
            'question' => 'What platforms do you run ads on?',
            'answer'   => 'Google (Search, Display, YouTube, Performance Max), Meta (Facebook, Instagram), LinkedIn, TikTok, and Reddit. We recommend platforms based on where your audience actually converts — not which ones the agency is comfortable with.',
        ],
        [
            'question' => 'Do you handle creative too, or just media buying?',
            'answer'   => 'Both. Our writers, designers, and video team produce ad creative in-house, which is why we can iterate weekly instead of every few months. You get creative and media as one integrated engagement.',
        ],
        [
            'question' => "What's the minimum ad spend you'll work with?",
            'answer'   => 'It depends on the platform and objective, but we generally recommend a minimum of $5K/month in working media to see meaningful results. We can scope smaller engagements for specific campaigns or testing windows.',
        ],
        [
            'question' => 'How do you report on performance?',
            'answer'   => 'Weekly Loom walkthroughs or monthly live reviews, depending on your preference. Every report ties spend to outcomes that matter to your business — conversions, pipeline, revenue, CAC, ROAS — with clear recommendations on what to scale, cut, or test next.',
        ],
        [
            'question' => 'Who owns the ad accounts?',
            'answer'   => 'You do. Always. We run in your ad accounts and tracking, so if we ever part ways, you keep the data, the creative, the pixels, and the learnings. No hostage accounts.',
        ],
    ],
];

// ============================================================
// 7. Visual Content & Design
// (combines the former Graphic Design + Video Content pages)
// ============================================================
$services['visual-content-and-design'] = [
    // -------- Hero --------
    'headline'       => 'Visual Content and Design',
    'headline_accent' => 'Design',
    'subheadline'    => 'Show your audience what words alone can’t.',
    'hero_text'      =>     [
        'People process visuals faster than text, and first impressions happen in seconds. Great visual content helps you explain complex concepts, showcase products, or tell your brand story in a way your audience will remember.',
        'Stretch Creative combines graphic design, photography, videography, and creative strategy under one roof to produce visual assets that support your website, social media, paid advertising, email marketing, and content initiatives.',
    ],
    'hero_cta_label' => 'Let’s Talk Visuals',
    'hero_cta_url'   => '/contact-stretch-creative/',

    // -------- Props (stat pills, not counters) --------
    'props' =>     [
        'In-House Creative Team',
        'Photography & Video Production',
        'Graphic Design & Branding',
        'From Concept Through Delivery',
    ],

    // -------- Problem --------
    'problem' => [
        'overline'   => 'The Reality',
        'heading'    => 'First impressions happen fast.',
        'subheading' => 'Your content deserves better visuals.',
        'text'       =>             [
                'Today’s audiences are swamped with information. Long paragraphs of text, generic stock photography, and inconsistent branding make it harder than ever to capture attention and communicate your message.',
                'At the same time, businesses are expected to produce high-quality visuals for websites, blogs, social media, advertising, email campaigns, sales materials, and more. For many marketing teams, keeping up with those demands is a real challenge.',
                'Great visual content helps people understand what you do, remember your message, and feel more confident engaging with your business.',
            ],
    ],

    // -------- Solution --------
    'solution' => [
        'overline'  => 'The Solution',
        'heading'   => 'Creative content changes the equation.',
        'text'      =>             [
                'Effective visual content communicates, educates, and inspires action and loyalty.',
                'Stretch Creative helps businesses create visuals that support real marketing goals.',
            ],
        'points' =>             [
                ['title' => 'We design with purpose.', 'body' => 'Every graphic, photo, and video should solve a problem. Whether it’s simplifying complex information, highlighting product features, or reinforcing your brand identity, every visual asset is created with a clear objective in mind.'],
                ['title' => 'We keep your brand consistent.', 'body' => 'Strong brands are recognizable across every touchpoint. We create visual content that meets your brand standards and feels cohesive across websites, social media, advertising, presentations, and print materials.'],
                ['title' => 'We handle everything in-house.', 'body' => 'From creative direction, copywriting, and design to photography, videography, editing, and post-production, our in-house team manages the entire process collaboratively. We streamline the process, and you pay less for more.'],
                ['title' => 'We create assets that work everywhere.', 'body' => 'One photoshoot or design project shouldn’t produce just one deliverable. We develop visual content that can be adapted across multiple channels so you get more value from every project.'],
                ['title' => 'We collaborate from concept to completion.', 'body' => 'The best creative work happens through strong partnerships. We collaborate with you throughout the process to ensure every asset reflects your goals, your audience, and your brand.'],
            ],
    ],

    // -------- Capabilities (Offerings, in two anchored groups) --------
    'offerings_overline'   => 'Capabilities',
    'offerings_heading'    => 'Creative Services',
    'offerings_intro'      => 'Our in-house creative teams collaborate across assets to keep your visuals consistent and on-brand.',
    'offerings_groups' =>     [
        [
            'anchor'  => 'graphic-design',
            'heading' => 'Graphic Design',
            'items'   =>                 [
                    ['title' => 'Graphic Design', 'description' => 'Branded graphics, marketing collateral, brochures, sales sheets, presentations, digital ads, and other custom design assets.'],
                    ['title' => 'Infographics', 'description' => 'Clear, engaging visual explanations that simplify complex ideas and make information easier to understand and share.'],
                    ['title' => 'Social Media Creative', 'description' => 'Platform-ready graphics, videos, stories, reels, and campaign assets designed to support your social media strategy.'],
                    ['title' => 'Email & Digital Marketing Assets', 'description' => 'Graphics, banners, headers, and supporting visuals that strengthen email campaigns and digital marketing initiatives.'],
                    ['title' => 'Presentation & Sales Materials', 'description' => 'Pitch decks, trade show materials, sales presentations, one-pagers, and visual assets that help communicate your message clearly.'],
                    ['title' => 'Brand Support', 'description' => 'Creative direction, visual storytelling, iconography, illustration, and other design services that strengthen your brand identity.'],
                ],
        ],
        [
            'anchor'  => 'photography-video',
            'heading' => 'Videography & Photography',
            'items'   =>                 [
                    ['title' => 'Brand Stories', 'description' => 'Cinematic videos that capture your brand’s personality, values, and purpose through thoughtful storytelling and polished production.'],
                    ['title' => 'Corporate Video Services', 'description' => 'Professional videos for training, recruiting, investor relations, internal communications, product demonstrations, and marketing initiatives.'],
                    ['title' => 'Commercial Production', 'description' => 'Broadcast-quality television commercials produced entirely in-house, from concept development and scriptwriting through filming and post-production.'],
                    ['title' => 'Social Media Content', 'description' => 'Short-form videos and paid social creative designed to capture attention, reinforce your brand, and engage audiences across social platforms.'],
                    ['title' => 'Documentaries', 'description' => 'Authentic, story-driven films that inform, inspire, and highlight the people, organizations, or missions behind your brand.'],
                    ['title' => 'Motion Graphics & Animation', 'description' => 'Custom animations and motion graphics that simplify complex ideas, enhance video productions, and create engaging visual content for digital channels.'],
                    ['title' => 'Interviews', 'description' => 'Professionally produced interviews featuring employees, executives, customers, or industry experts, suitable for websites, social media, presentations, and marketing campaigns.'],
                    ['title' => 'Pre-Production', 'description' => 'Creative planning and logistics, including concept development, scriptwriting, storyboarding, location scouting, talent coordination, and production planning.'],
                    ['title' => 'Production', 'description' => 'Professional video production services, including directing, cinematography, lighting, audio recording, and on-set production management.'],
                    ['title' => 'Post-Production', 'description' => 'Editing, color correction, audio enhancement, motion graphics, subtitles, visual effects, and final formatting for distribution across multiple channels.'],
                    ['title' => 'Video Interviewing', 'description' => 'Remote or on-location interview recording, professionally edited into long-form videos, short clips, social content, or written marketing assets.'],
                    ['title' => 'Product & Lifestyle Photography', 'description' => 'Product photography, lifestyle imagery, team photography, headshots, environmental photography, and branded visual storytelling.'],
                ],
        ],
    ],

    // -------- Add-On Services --------
    'addons_heading' => 'Add-On Services',
    'addons' =>     [
        ['title' => 'Creative Ideation', 'description' => 'Campaign concepts, creative direction, mood boards, shot lists, storyboards, and visual planning sessions.'],
        ['title' => 'Budget Management', 'description' => 'Coordinated production oversight, vendor management, scheduling, and budget tracking for larger creative initiatives.'],
        ['title' => 'Copywriting', 'description' => 'Scriptwriting, infographic writing, whitepaper and ebook copy, and any other words you need in your design assets'],
    ],

    // -------- Cross-sell CTA --------
    'cross_cta' =>     [
        'heading' => 'Need more than written content?',
        'body'    => 'We’re a full-scale agency offering all of the services you need to work smarter and rank higher.',
        'links'   => [
            ['label' => 'SEO/AEO Services', 'url' => '/seo_content_strategy_services/'],
            ['label' => 'Content Writing', 'url' => '/content-writing-at-any-scale/'],
            ['label' => 'Interactive Content Marketing', 'url' => '/services/bespoke-content-experience/'],
            ['label' => 'Paid Advertising', 'url' => '/paid-advertising/'],
        ],
    ],

    // -------- Why Stretch / Benefits --------
    'why_heading' => 'Why Stretch Creative?',
    'benefits' =>     [
        ['title' => 'All of the services you need under one roof', 'description' => 'Content writing, SEO, design, photography, video, and paid advertising working together to support your growth strategy.'],
        ['title' => 'Human-created, expert-led', 'description' => 'Our designers, photographers, videographers, editors, and creative strategists produce visual content that’s thoughtful, purposeful, and on brand.'],
        ['title' => 'Built to scale', 'description' => 'Whether you need a handful of graphics or an ongoing creative partner, our team can grow alongside your business.'],
        ['title' => 'A single point of contact', 'description' => 'Your dedicated project manager keeps production moving smoothly, coordinates creative resources, and ensures every deliverable stays on schedule.'],
    ],

    // -------- FAQ: merged from graphic_design_services (first) + video-content-services (second), deduped --------
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

    // -------- Closing CTA --------
    'cta' => [
        'heading'      => 'Ready to Tell Your Story Visually?',
        'button_label' => 'Get in Touch',
        'button_url'   => '/contact-stretch-creative/',
        'secondary'    => false,
    ],
];


// ============================================================
// Save options and update page templates
// ============================================================
// Inject shared testimonials into any service that doesn't already define its own
foreach ($services as $slug => &$data) {
    if (empty($data['testimonials'])) {
        $data['testimonials']             = $shared_testimonials;
        $data['testimonials_heading']     = $shared_testimonials_heading;
        $data['testimonials_subheading']  = $shared_testimonials_subheading;
    }
}
unset($data);

// Page titles for slugs this script creates from scratch (top-level pages).
// Existing service pages (imported from the original site) already have their
// own titles and are matched/updated by slug below without renaming them.
$new_page_titles = [
    'visual-content-and-design' => 'Visual Content & Design',
];

// Retired pages: content merged into visual-content-and-design and 301-redirected
// (see functions.php ~line 141). Their $services entries stay above only to feed
// the combined page's FAQ merge — never (re)create or template-touch these pages.
$retired_slugs = ['graphic_design_services', 'video-content-services'];

foreach ($services as $slug => $data) {
    // Save option
    update_option('stretch_service_' . $slug, $data, false);
    if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("Saved option: stretch_service_{$slug}"); } else { echo "Saved option: stretch_service_{$slug}" . "\n"; }

    if (in_array($slug, $retired_slugs, true)) {
        if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("Skipped page create/template for retired slug: {$slug} (301s in functions.php)"); } else { echo "Skipped page create/template for retired slug: {$slug} (301s in functions.php)" . "\n"; }
        continue;
    }

    // Find the page by slug and set its template
    $page = get_page_by_path($slug);
    if (!$page) {
        // Create as a top-level page (mirrors setup-industries.php's page-creation pattern)
        $title = isset($new_page_titles[$slug]) ? $new_page_titles[$slug] : ucwords(str_replace('-', ' ', $slug));
        $page_id = wp_insert_post([
            'post_title'  => $title,
            'post_name'   => $slug,
            'post_type'   => 'page',
            'post_status' => 'publish',
            'post_parent' => 0,
        ]);
        if ($page_id && !is_wp_error($page_id)) {
            update_post_meta($page_id, '_wp_page_template', 'page-service.php');
            if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("Created page: {$slug} (ID {$page_id}) and set template"); } else { echo "Created page: {$slug} (ID {$page_id}) and set template" . "\n"; }
        } else {
            if (defined('WP_CLI') && WP_CLI) { WP_CLI::warning("Failed to create page for slug: {$slug}"); } else { echo 'Warning: ' . "Failed to create page for slug: {$slug}" . "\n"; }
        }
    } else {
        update_post_meta($page->ID, '_wp_page_template', 'page-service.php');
        if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("Set template for page: {$page->post_title} (ID: {$page->ID})"); } else { echo "Set template for page: {$page->post_title} (ID: {$page->ID})" . "\n"; }
    }
}

if (defined('WP_CLI') && WP_CLI) { WP_CLI::success('All service page content saved and templates assigned.'); } else { echo 'Success: ' . 'All service page content saved and templates assigned.' . "\n"; }
