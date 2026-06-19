<?php
/**
 * Idempotent setup for Industry pages. Creates the /industries/ parent and child
 * pages, assigns the page-industry.php template, and seeds slug-keyed content.
 *
 * Run: docker compose exec wordpress wp eval-file /var/www/html/setup-industries.php --allow-root
 */
if (!defined('ABSPATH')) {
    WP_CLI::error('This script must be run via wp eval-file.');
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
    WP_CLI::log("Created /industries/ parent (ID {$parent_id})");
} else {
    $parent_id = $parent->ID;
    WP_CLI::log("/industries/ parent exists (ID {$parent_id})");
}

// ── Content ───────────────────────────────────────────────────────────
$industries = [];

$industries['ecommerce'] = [
    'title'    => 'Ecommerce',  // WP page title
    'overline' => 'Ecommerce',
    'h1'       => 'Ecommerce SEO, Content, and Creative Services',
    'hero_text' => 'Help shoppers discover the right products, and give them the inspiration and confidence they need to buy.',
    'cta_label' => 'Schedule a Discovery Call',
    'audiences' => [
        'Fashion & Apparel Brands',
        'Food & Beverage Companies',
        'Beauty & Personal Care Brands',
        'DTC Brands',
        'DTC Retailers',
        'Online Marketplaces',
    ],
    'challenges_intro' => [
        'Today\'s ecommerce brands face more competition than ever before. Website traffic alone is no longer enough to drive success when customers research products across search engines, AI-powered search tools, marketplaces, social platforms, and retailer websites before making a purchase.',
        'At the same time, rising costs make it increasingly important to maximize the value of—and for—every visitor who lands on your website. Many ecommerce businesses struggle with:',
    ],
    'challenges' => [
        'Product pages that don\'t answer customer questions',
        'Category pages that fail to rank in search results',
        'Poor product discovery experiences',
        'Thin or duplicate content across large catalogs',
        'Inconsistent branding across channels',
        'Limited internal resources for content production',
        'Outdated content that\'s poorly optimized for today\'s search landscape',
        'Difficulty scaling ecommerce marketing efforts',
    ],
    'solutions_heading' => 'Solutions Built for Ecommerce Brands',
    'solutions' => [
        ['title' => 'Ecommerce SEO', 'body' => 'Effective ecommerce SEO starts with understanding how customers search for products. Our ecommerce SEO services include keyword research, technical SEO for ecommerce websites, on-page optimization, product page SEO, category page optimization, and content strategy development.'],
        ['title' => 'Product & Category Page Content', 'body' => 'Product detail pages and category pages often play a central role in both product discovery and purchasing decisions. We create product descriptions, category page content, and supporting copy that help customers make informed purchasing decisions while supporting ecommerce search engine optimization goals.'],
        ['title' => 'Ecommerce Content Marketing', 'body' => 'Most customers want solid product information before they buy. Buying guides, gift guides, comparison articles, educational resources, and ecommerce blog content help shoppers research products, understand their options, and discover your brand through search.'],
        ['title' => 'Visual Content & Product Photography', 'body' => 'Strong visuals help customers understand products, compare options, and buy with confidence. Our creative team produces ecommerce product photography, video content, infographics, comparison graphics, and branded visual assets that support product pages, social media campaigns, email marketing, and paid advertising.'],
        ['title' => 'Ecommerce Paid Advertising', 'body' => 'Organic search takes time. Paid advertising helps ecommerce brands put products in front of the right shoppers at the right moment. We develop search, shopping, display, remarketing, and social media advertising campaigns that support product launches and help customers discover products they may not have found otherwise.'],
    ],
    'mid_cta_text' => 'Looking for solutions? Schedule a discovery call today.',
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
        ['q' => 'What is ecommerce SEO?', 'a' => 'Ecommerce SEO is the process of improving an online store\'s visibility in search engines through technical SEO, keyword research, product page optimization, category page optimization, and content development.'],
        ['q' => 'Do product pages help SEO?', 'a' => 'Yes. Product page SEO helps search engines understand your products while providing customers with the information they need to make the right purchasing decisions.'],
        ['q' => 'What is category page SEO?', 'a' => 'Category page SEO focuses on optimizing product category pages to improve search visibility, product discovery, and site navigation.'],
        ['q' => 'What is ecommerce content marketing?', 'a' => 'Ecommerce content marketing uses buying guides, comparison content, educational articles, videos, and other resources to help customers research products, make informed decisions, and discover brands through search.'],
        ['q' => 'Can Stretch Creative help large ecommerce websites?', 'a' => 'Absolutely. We regularly support ecommerce businesses with large product catalogs and complex content requirements.'],
        ['q' => 'Do you provide ecommerce product photography?', 'a' => 'Yes. Our in-house creative team provides ecommerce product photography, lifestyle photography, video production, and supporting visual content services.'],
    ],
    'final_heading' => 'Ready to Grow Your Ecommerce Business?',
    'final_text' => 'Whether you need ecommerce SEO services, content marketing support, product photography, or a complete ecommerce marketing strategy, Stretch Creative can help. Let\'s talk about your products, customers, and goals.',
];

$industries['agencies'] = [
    'title'    => 'Agencies & Strategic Partners',
    'overline' => 'Agencies & Strategic Partners',
    'h1'       => 'White-Labeled Content & Creative Services for Agencies and Strategic Partners',
    'hero_text' => 'Scale production, expand your capabilities, and deliver exceptional work without expanding your payroll.',
    'cta_label' => 'Schedule a Discovery Call',
    'audiences' => [
        'SEO Agencies',
        'Content Marketing Agencies',
        'Digital Marketing Agencies',
        'Creative Agencies',
        'Publishers & Media Companies',
        'In-House Marketing Teams',
    ],
    'challenges_intro' => [
        'Agency growth is exciting—until production becomes the bottleneck.',
        'As client demands increase, many agencies find themselves balancing tight deadlines, fluctuating workloads, limited internal resources, and increasing pressure to maintain quality at scale. Hiring talent is expensive and time-consuming. Freelancers can help, but managing multiple contractors often creates administrative headaches and inconsistent results. Many agencies and strategic partners struggle with:',
    ],
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
    'solutions' => [
        ['title' => 'White-Labeled Content Production', 'body' => 'Need additional production capacity without additional payroll? Stretch Creative works behind the scenes as an extension of your team, producing high-quality content that aligns with your clients\' goals, brand standards, and editorial requirements.'],
        ['title' => 'Flexible Production Support', 'body' => 'Your clients\' needs can change quickly. Our team is built to scale production up or down as workloads fluctuate, helping agencies respond to new opportunities without disrupting their existing operations.'],
        ['title' => 'SEO Content at Scale', 'body' => 'Whether you need ten articles or a thousand, our team supports both low- and high-volume content initiatives across a wide range of industries. We create SEO-focused content designed to help agencies meet publishing goals without sacrificing quality.'],
        ['title' => 'Creative & Visual Content', 'body' => 'Content often performs best when it\'s supported by strong visuals. We provide graphic design, infographics, photography, video production, and other creative assets that help agencies expand their service offerings and deliver more value to clients.'],
        ['title' => 'Subject Matter Expertise', 'body' => 'Our roster of credentialed subject matter experts supports agencies that work across complex industries and specialized subjects, from ecommerce and healthcare to SaaS and local service providers.'],
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
        WP_CLI::log("Created page: industries/{$slug} (ID {$page_id})");
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
    WP_CLI::log("Saved option: stretch_industry_{$slug}");
}

WP_CLI::success('Industry pages created and content seeded.');
