<?php
/**
 * Idempotent setup for Industry pages. Creates the /industries/ parent and child
 * pages, assigns the page-industry.php template, and seeds slug-keyed content.
 *
 * Run: docker compose exec wordpress wp eval-file /var/www/html/setup-industries.php --allow-root
 */
// AUD-022: web-exposure guard — this script mutates content and must only run
// via WP-CLI (wp eval-file). A direct web request exits before doing anything.
if (!defined('WP_CLI') || !WP_CLI) {
    exit;
}
if (!defined('ABSPATH')) {
    if (defined('WP_CLI') && WP_CLI) { WP_CLI::error('This script must be run via wp eval-file.'); } else { echo 'Error: ' . 'This script must be run via wp eval-file.' . "\n"; exit; }
}

// ── Parent: /industries/ ──────────────────────────────────────────────
$parent = get_page_by_path('industries');
if (!$parent) {
    $parent_id = wp_insert_post([
        'post_title'  => 'Industries',
        'post_name'   => 'industries',
        'post_type'   => 'page',
        'post_status' => 'publish',
    ]);
    if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("Created /industries/ parent (ID {$parent_id})"); } else { echo "Created /industries/ parent (ID {$parent_id})" . "\n"; }
} else {
    $parent_id = $parent->ID;
    if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("/industries/ parent exists (ID {$parent_id})"); } else { echo "/industries/ parent exists (ID {$parent_id})" . "\n"; }
}

// ── Content ───────────────────────────────────────────────────────────
$industries = [];

$industries['ecommerce'] = [
    'title'    => 'Ecommerce',  // WP page title
    'overline' => 'Ecommerce',
    'h1'       => 'Ecommerce SEO, Content, and Creative Services',
    'h1_accent' => 'SEO, Content, and Creative Services',
    'hero_text' => 'Help shoppers discover the right products, and give them the inspiration and confidence they need to buy.',
    'cta_label' => 'Schedule a Discovery Call',
    'audiences' => [
        ['label' => 'Fashion & Apparel Brands', 'icon' => 'shirt'],
        ['label' => 'Food & Beverage Companies', 'icon' => 'cup'],
        ['label' => 'Beauty & Personal Care Brands', 'icon' => 'sparkle'],
        ['label' => 'DTC Brands', 'icon' => 'box'],
        ['label' => 'DTC Retailers', 'icon' => 'cart'],
        ['label' => 'Online Marketplaces', 'icon' => 'globe'],
    ],
    'challenges_intro' => [
        'Today’s ecommerce brands face more competition than ever before. Website traffic alone is no longer enough to drive success when customers research products across search engines, AI-powered search tools, marketplaces, social platforms, and retailer websites before making a purchase.',
        'At the same time, rising costs make it increasingly important to maximize the value of—and for—every visitor who lands on your website.',
    ],
    'challenges_photo' => 0, // attachment ID; 0 => neutral gradient placeholder (isset => slot renders)
    'challenges_list_title' => 'Many ecommerce businesses struggle with:',
    'challenges' => [
        'Product pages that don’t answer customer questions',
        'Category pages that fail to rank in search results',
        'Poor product discovery experiences',
        'Thin or duplicate content across large catalogs',
        'Inconsistent branding across channels',
        'Limited internal resources for content production',
        'Outdated content that’s poorly optimized for today’s search landscape',
        'Difficulty scaling ecommerce marketing efforts',
    ],
    'solutions_heading' => 'Solutions Built for Ecommerce Brands',
    'solutions_heading_accent' => 'Ecommerce Brands',
    'solutions' => [
        ['icon' => 'search',    'title' => 'Ecommerce SEO', 'body' => 'Effective ecommerce SEO starts with understanding how customers search for products. Our ecommerce SEO services include keyword research, technical SEO for ecommerce websites, on-page optimization, product page SEO, category page optimization, and content strategy development.'],
        ['icon' => 'box',       'title' => 'Product & Category Page Content', 'body' => 'Product detail pages and category pages often play a central role in both product discovery and purchasing decisions. We create product descriptions, category page content, and supporting copy that help customers make informed purchasing decisions while supporting ecommerce search engine optimization goals.'],
        ['icon' => 'file-text', 'title' => 'Ecommerce Content Marketing', 'body' => 'Most customers want solid product information before they buy. Buying guides, gift guides, comparison articles, educational resources, and ecommerce blog content help shoppers research products, understand their options, and discover your brand through search.'],
        ['icon' => 'camera',    'title' => 'Visual Content & Product Photography', 'body' => 'Strong visuals help customers understand products, compare options, and buy with confidence. Our creative team produces ecommerce product photography, video content, infographics, comparison graphics, and branded visual assets that support product pages, social media campaigns, email marketing, and paid advertising.'],
        ['icon' => 'target',    'title' => 'Ecommerce Paid Advertising', 'body' => 'Organic search takes time. Paid advertising helps ecommerce brands put products in front of the right shoppers at the right moment. We develop search, shopping, display, remarketing, and social media advertising campaigns that support product launches and help customers discover products they may not have found otherwise.'],
    ],
    'mid_cta_text' => 'Looking for solutions? Schedule a discovery call today.',
    'gallery' => [
        ['label' => 'Product Photography', 'image' => 0],
        ['label' => 'Lifestyle & Social', 'image' => 0],
        ['label' => 'Campaign Creative', 'image' => 0],
    ],
    'popular_heading' => 'Services Most Popular with Ecommerce Brands',
    'popular' => [
        ['title' => 'Ecommerce SEO Services', 'body' => 'Technical SEO, ecommerce SEO audits, on-page optimization, category and product page SEO, ecommerce content strategy, and AEO optimization.'],
        ['title' => 'Product Detail Page Content', 'body' => 'Helpful, engaging product descriptions, feature copy, specifications, FAQs, and other PDP resources that help shoppers make informed purchasing decisions.'],
        ['title' => 'Category Page Content', 'body' => 'Search-friendly, inspirational category page copy designed to improve navigation, product discovery, and search visibility.'],
        ['title' => 'Ecommerce Content Marketing', 'body' => 'Buying guides, gift guides, user-generated content, comparison guides, educational articles, and aspirational ecommerce blog content.'],
        ['title' => 'Expert-Written or Expert-Reviewed Content', 'body' => 'SME-bylined content for healthcare, finance, technology, and other YMYL products, backed by subject matter expertise and rigorous editorial review.'],
        ['title' => 'Visual Content & Design', 'body' => 'Infographics, comparison charts, social media assets, digital advertising creative, and branded design support.'],
        ['title' => 'Product Photography & Video', 'body' => 'Product photography, lifestyle imagery, demonstrations, and branded video production.'],
        ['title' => 'Interactive Content Experiences', 'body' => 'Product finders, quizzes, calculators, and other tools that support product discovery and customer engagement.'],
        ['title' => 'Paid Advertising', 'body' => 'Search, shopping, display, and email and social media campaigns.'],
    ],
    'why' => [
        ['title' => 'All of the Services You Need Under One Roof', 'body' => 'SEO, content, design, photography, video, and paid advertising working together to support your ecommerce marketing strategy.'],
        ['title' => 'Human-Created, Expert-Led', 'body' => 'Every project is developed by experienced professionals who understand how to create content that serves both customers and search engines.'],
        ['title' => 'Built for Growth', 'body' => 'Our team can support ecommerce brands at virtually any stage of growth, from new product launches to enterprise-scale catalogs.'],
        ['title' => 'A True Extension of Your Team', 'body' => 'Work directly with strategists, writers, editors, creatives, and SEO specialists who understand your products, your audience, and your goals.'],
    ],
    'faqs' => [
        ['q' => 'What is ecommerce SEO?', 'a' => 'Ecommerce SEO is the process of improving an online store’s visibility in search engines through technical SEO, keyword research, product page optimization, category page optimization, and content development.'],
        ['q' => 'Do product pages help SEO?', 'a' => 'Yes. Product page SEO helps search engines understand your products while providing customers with the information they need to make the right purchasing decisions.'],
        ['q' => 'What is category page SEO?', 'a' => 'Category page SEO focuses on optimizing product category pages to improve search visibility, product discovery, and site navigation.'],
        ['q' => 'What is ecommerce content marketing?', 'a' => 'Ecommerce content marketing uses buying guides, comparison content, educational articles, videos, and other resources to help customers research products, make informed decisions, and discover brands through search.'],
        ['q' => 'Can Stretch Creative help large ecommerce websites?', 'a' => 'Absolutely. We regularly support ecommerce businesses with large product catalogs and complex content requirements.'],
        ['q' => 'Do you provide ecommerce product photography?', 'a' => 'Yes. Our in-house creative team provides ecommerce product photography, lifestyle photography, video production, and supporting visual content services.'],
    ],
    'final_heading' => 'Ready to Grow Your Ecommerce Business?',
    'final_text' => 'Whether you need ecommerce SEO services, content marketing support, product photography, or a complete ecommerce marketing strategy, Stretch Creative can help. Let’s talk about your products, customers, and goals.',
];

$industries['agencies'] = [
    'title'    => 'Agencies & Strategic Partners',
    'overline' => 'Agencies & Strategic Partners',
    'h1'       => 'White-Labeled Content & Creative Services for Agencies and Strategic Partners',
    'h1_accent' => 'Agencies and Strategic Partners',
    'hero_text' => 'Scale production, expand your capabilities, and deliver exceptional work without expanding your payroll.',
    'cta_label' => 'Schedule a Discovery Call',
    'audiences' => [
        ['label' => 'SEO Agencies', 'icon' => 'search'],
        ['label' => 'Content Marketing Agencies', 'icon' => 'file-text'],
        ['label' => 'Digital Marketing Agencies', 'icon' => 'target'],
        ['label' => 'Creative Agencies', 'icon' => 'pen'],
        ['label' => 'Publishers & Media Companies', 'icon' => 'book-open'],
        ['label' => 'In-House Marketing Teams', 'icon' => 'users'],
    ],
    'challenges_intro' => [
        'Agency growth is exciting—until production becomes the bottleneck.',
        'As client demands increase, many agencies find themselves balancing tight deadlines, fluctuating workloads, limited internal resources, and increasing pressure to maintain quality at scale. Hiring talent is expensive and time-consuming. Freelancers can help, but managing multiple contractors often creates administrative headaches and inconsistent results.',
    ],
    'challenges_photo' => 0, // attachment ID; 0 => neutral gradient placeholder (isset => slot renders)
    'challenges_list_title' => 'Many agencies and strategic partners struggle with:',
    'challenges' => [
        'Limited bandwidth during periods of rapid growth',
        'Difficulty scaling content production without adding headcount',
        'Maintaining consistent quality across writers and projects',
        'Meeting aggressive publishing schedules',
        'Managing multiple client industries and subject matters',
        'Finding reliable partners for specialized content needs',
        'Balancing strategy work with content execution',
        'Expanding service offerings without expanding internal teams',
    ],
    'solutions_heading' => 'Solutions Built for Agencies & Partners',
    'solutions_heading_accent' => 'Agencies & Partners',
    'solutions' => [
        ['icon' => 'file-text', 'title' => 'White-Labeled Content Production', 'body' => 'Need additional production capacity without additional payroll? Stretch Creative works behind the scenes as an extension of your team, producing high-quality content that aligns with your clients\' goals, brand standards, and editorial requirements.'],
        ['icon' => 'sliders',   'title' => 'Flexible Production Support', 'body' => 'Your clients\' needs can change quickly. Our team is built to scale production up or down as workloads fluctuate, helping agencies respond to new opportunities without disrupting their existing operations.'],
        ['icon' => 'search',    'title' => 'SEO Content at Scale', 'body' => 'Whether you need ten articles or a thousand, our team supports both low- and high-volume content initiatives across a wide range of industries. We create SEO-focused content designed to help agencies meet publishing goals without sacrificing quality.'],
        ['icon' => 'camera',    'title' => 'Creative & Visual Content', 'body' => 'Content often performs best when it\'s supported by strong visuals. We provide graphic design, infographics, photography, video production, and other creative assets that help agencies expand their service offerings and deliver more value to clients.'],
        ['icon' => 'award',     'title' => 'Subject Matter Expertise', 'body' => 'Our roster of credentialed subject matter experts supports agencies that work across complex industries and specialized subjects, from ecommerce and healthcare to SaaS and local service providers.'],
    ],
    'mid_cta_text' => 'Need additional production capacity? Schedule a discovery call today.',
    'popular_heading' => 'Services Most Popular with Agencies & Partners',
    'popular' => [
        ['title' => 'White-Labeled SEO Content', 'body' => 'SEO articles, pillar pages, landing pages, service pages, and other search-focused content delivered under your brand.'],
        ['title' => 'Content Strategy Support', 'body' => 'Keyword research, content planning, editorial calendars, content audits, and content optimization recommendations.'],
        ['title' => 'Graphic Design & Visual Content', 'body' => 'Infographics, social media assets, digital advertising creative, branded graphics, and supporting visual content.'],
        ['title' => 'Expert-Written or Expert-Reviewed Content', 'body' => 'SME-bylined content for healthcare, finance, technology, and other YMYL industries, backed by subject matter expertise and rigorous editorial review.'],
        ['title' => 'Interactive Content Experiences', 'body' => 'Calculators, assessments, quizzes, and interactive tools that help agencies differentiate their offerings.'],
        ['title' => 'Photography & Video Production', 'body' => 'Photography, videography, editing, and post-production services for agency and client projects.'],
        ['title' => 'Content Optimization', 'body' => 'Content refreshes, SEO updates, content audits, and optimization initiatives designed to improve performance.'],
        ['title' => 'White Papers & Long-Form Content', 'body' => 'Thought leadership content, ebooks, guides, research reports, and other premium content assets.'],
        ['title' => 'Overflow & Production Support', 'body' => 'Dedicated production resources available when your internal teams need additional capacity.'],
    ],
    'why' => [
        ['title' => 'All of the Services You Need Under One Roof', 'body' => 'Content, SEO, design, photography, video, and paid advertising working together to support your clients\' goals and campaigns.'],
        ['title' => 'Human-Created. Expert-Led.', 'body' => 'Every project is developed by experienced professionals who understand the importance of quality, consistency, and brand alignment.'],
        ['title' => 'Built for Growth', 'body' => 'Our team can scale alongside your agency, whether you need occasional overflow support or a long-term production partner.'],
        ['title' => 'A True Extension of Your Team', 'body' => 'We work collaboratively, communicate clearly, and integrate seamlessly into existing agency workflows.'],
    ],
    'faqs' => [
        ['q' => 'Do you offer white-labeled services?', 'a' => 'Yes. Stretch Creative regularly partners with agencies and strategic partners on fully white-labeled content, SEO, design, and creative projects.'],
        ['q' => 'Can you match our client\'s brand voice?', 'a' => 'Absolutely. Our onboarding and editorial processes, including dedicated writing and editing cohorts, are designed to ensure consistency across brands, industries, and content types.'],
        ['q' => 'How quickly can you scale production?', 'a' => 'Our team is built to support both ongoing content programs and high-volume initiatives. Production timelines depend on project scope, but scaling quickly is one of our core strengths.'],
        ['q' => 'Do you work under NDAs?', 'a' => 'Yes. We regularly work under non-disclosure agreements and maintain strict confidentiality for agency partnerships.'],
        ['q' => 'Can you support multiple industries?', 'a' => 'Yes. We work across ecommerce, healthcare, SaaS, local service providers, professional services, and many other industries.'],
        ['q' => 'Do you provide strategy in addition to content production?', 'a' => 'Yes. We can support keyword research, content planning, SEO strategy, content audits, performance tracking, and other strategic initiatives in addition to content creation.'],
    ],
    'final_heading' => 'Ready to Scale Your Agency?',
    'final_text' => 'Whether you need additional production capacity, specialized expertise, or a long-term white-labeled content partner, Stretch Creative can help.',
];

$industries['service-providers'] = [
    'title'             => 'Service Providers',
    'overline'          => 'Local Service Providers',
    'h1'                => 'Local SEO, Content & Creative Services for Service Providers',
    'h1_accent'         => 'Service Providers',
    'hero_text'         => 'Help customers find your business, understand your services, and feel confident reaching out.',
    'cta_label'         => 'Schedule a Discovery Call',
    'audiences'         => [
        ['label' => 'Home Service Businesses', 'icon' => 'wrench'],
        ['label' => 'Healthcare Systems', 'icon' => 'heart'],
        ['label' => 'Beauty & Wellness Practices', 'icon' => 'sparkle'],
        ['label' => 'Dental Groups', 'icon' => 'tooth'],
        ['label' => 'Multi-Office Law Firms', 'icon' => 'scale'],
        ['label' => 'Restoration Companies', 'icon' => 'hard-hat'],
        ['label' => 'Franchises', 'icon' => 'storefront'],
        ['label' => 'Multi-Location Businesses', 'icon' => 'map-pin'],
    ],
    'challenges_intro'  => [
        'When people need a service, they usually start with an online search.',
        'Whether they’re looking for a plumber, contractor, CPA, attorney, or wellness provider, customers expect to find accurate information quickly and easily. If your business isn’t visible where they’re searching, or if your website doesn’t build trust once they click in, you may never get the opportunity to earn their business.',
    ],
    'challenges_photo'  => 0, // attachment ID; 0 => neutral gradient placeholder (isset => slot renders)
    'challenges_list_title' => 'Many service providers struggle with:',
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
    'solutions_heading_accent' => 'Service Providers',
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
];

$industries['saas'] = [
    'title'             => 'SaaS & Digital Platforms',
    'overline'          => 'SaaS & Digital Platforms',
    'h1'                => 'SaaS and Digital Platform SEO, Content & Creative Services',
    'h1_accent'         => 'Creative Services',
    'hero_text'         => 'Help your audience understand what you offer, why it matters, and whether it’s the right fit.',
    'cta_label'         => 'Schedule a Discovery Call',
    'audiences'         => [
        ['label' => 'SaaS Companies', 'icon' => 'monitor'],
        ['label' => 'Telehealth Platforms', 'icon' => 'heart'],
        ['label' => 'Fintech Companies', 'icon' => 'coins'],
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
    'challenges_photo'  => 0, // attachment ID; 0 => neutral gradient placeholder (isset => slot renders)
    'challenges_list_title' => 'Many SaaS companies and digital platforms struggle with:',
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
    'solutions_heading_accent' => 'SaaS Companies and Digital Platforms',
    'solutions'         => [
        ['icon' => 'search',    'title' => 'SaaS SEO & Content Strategy', 'body' => 'Strong SaaS content starts with understanding how potential customers search for solutions. We develop AEO and SEO strategies, content plans, and search-optimized resources that help software companies and platforms attract qualified audiences throughout the buying process.'],
        ['icon' => 'app-window','title' => 'Product & Solution Pages', 'body' => 'Your website should help visitors understand what your product does, who it’s for, and why it matters. We create product pages, solution pages, feature descriptions, landing pages, and supporting content that simplify complex offerings without oversimplifying them.'],
        ['icon' => 'book-open', 'title' => 'Thought Leadership & Educational Content', 'body' => 'Many buyers need education before they’re ready to commit. Blogs, guides, white papers, case studies, research reports, and other long-form content help establish authority, answer questions, and support informed decision-making.'],
        ['icon' => 'award',     'title' => 'Expert-Written & Expert-Reviewed Content', 'body' => 'Healthcare, finance, legal, and other YMYL industries require a higher standard of accuracy and credibility. We have a roster of subject matter experts across many industries who can write or review content that informs, educates, and builds trust—byline included.'],
        ['icon' => 'camera',    'title' => 'Visual Content & Design', 'body' => 'Complex ideas are easier to understand when they’re presented visually. We create infographics, diagrams, presentations, branded graphics, and other visual assets that help explain products, workflows, and value propositions.'],
        ['icon' => 'cursor',    'title' => 'Interactive Content Experiences', 'body' => 'Calculators, assessments, quizzes, benchmarks, and other interactive tools help users evaluate solutions, understand potential outcomes, and engage more deeply with your brand.'],
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
];

// ── Create/ensure child pages + assign template + seed options ─────────
foreach ($industries as $slug => $data) {
    $title = !empty($data['title']) ? $data['title'] : ucfirst($slug);

    $page = get_page_by_path('industries/' . $slug);
    if (!$page) {
        $page_id = wp_insert_post([
            'post_title'  => $title,
            'post_name'   => $slug,
            'post_type'   => 'page',
            'post_status' => 'publish',
            'post_parent' => $parent_id,
        ]);
        if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("Created page: industries/{$slug} (ID {$page_id})"); } else { echo "Created page: industries/{$slug} (ID {$page_id})" . "\n"; }
    } else {
        $page_id = $page->ID;
        // Ensure correct parent
        if ((int) $page->post_parent !== (int) $parent_id) {
            wp_update_post(['ID' => $page_id, 'post_parent' => $parent_id]);
        }
    }
    update_post_meta($page_id, '_wp_page_template', 'page-industry.php');

    // Strip the WP-title-only field before saving as the render option
    $option_data = $data;
    unset($option_data['title']);
    update_option('stretch_industry_' . $slug, $option_data, false);
    if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("Saved option: stretch_industry_{$slug}"); } else { echo "Saved option: stretch_industry_{$slug}" . "\n"; }
}

if (defined('WP_CLI') && WP_CLI) { WP_CLI::success('Industry pages created and content seeded.'); } else { echo 'Success: ' . 'Industry pages created and content seeded.' . "\n"; }
