<?php
/**
 * Content population script — run via WP-CLI:
 * wp eval-file setup-content.php
 *
 * Creates all pages and populates ACF flexible content sections
 * with content from the current stretchcreative.co site.
 */
// AUD-022: web-exposure guard — this script mutates content and must only run
// via WP-CLI (wp eval-file). A direct web request exits before doing anything.
if (!defined('WP_CLI') || !WP_CLI) {
    exit;
}

// ── Helper: Create or update a page ──
function stretch_create_page($title, $slug, $sections = [], $parent_id = 0) {
    $existing = get_page_by_path($slug);
    if ($existing) {
        $page_id = $existing->ID;
        if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("  Page '{$title}' already exists (ID: {$page_id}), updating..."); } else { echo "  Page '{$title}' already exists (ID: {$page_id}), updating..." . "\n"; }
    } else {
        $page_id = wp_insert_post([
            'post_title'  => $title,
            'post_name'   => $slug,
            'post_type'   => 'page',
            'post_status' => 'publish',
            'post_parent' => $parent_id,
        ]);
        if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("  Created page '{$title}' (ID: {$page_id})"); } else { echo "  Created page '{$title}' (ID: {$page_id})" . "\n"; }
    }

    if (!empty($sections) && function_exists('update_field')) {
        update_field('page_sections', $sections, $page_id);
        if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("    -> Added " . count($sections) . " sections"); } else { echo "    -> Added " . count($sections) . " sections" . "\n"; }
    }

    return $page_id;
}

// ── Helper: Section settings defaults ──
function sec($bg = 'white', $id = '') {
    return [
        'background_style'        => $bg,
        'custom_background_color'  => '',
        'section_id'               => $id,
        'padding_style'            => 'default',
    ];
}

if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("=== Setting up Stretch Creative content ===\n"); } else { echo "=== Setting up Stretch Creative content ===\n" . "\n"; }

// ────────────────────────────────────────
// NAVIGATION MENUS
// ────────────────────────────────────────
if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("Setting up navigation menus..."); } else { echo "Setting up navigation menus..." . "\n"; }

// Primary menu
$primary_menu = wp_get_nav_menu_object('Primary');
if (!$primary_menu) {
    $primary_menu_id = wp_create_nav_menu('Primary');
} else {
    $primary_menu_id = $primary_menu->term_id;
    // Clear existing items
    $items = wp_get_nav_menu_items($primary_menu_id);
    if ($items) foreach ($items as $item) wp_delete_post($item->ID, true);
}

$menu_locations = get_theme_mod('nav_menu_locations', []);
$menu_locations['primary'] = $primary_menu_id;

// Footer menus
foreach (['Solutions' => 'footer-1', 'Company' => 'footer-2', 'Stay Connected' => 'footer-3'] as $name => $location) {
    $menu = wp_get_nav_menu_object($name);
    if (!$menu) {
        $menu_id = wp_create_nav_menu($name);
    } else {
        $menu_id = $menu->term_id;
        $items = wp_get_nav_menu_items($menu_id);
        if ($items) foreach ($items as $item) wp_delete_post($item->ID, true);
    }
    $menu_locations[$location] = $menu_id;
}
set_theme_mod('nav_menu_locations', $menu_locations);

// ────────────────────────────────────────
// HOMEPAGE
// ────────────────────────────────────────
if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("\nCreating Homepage..."); } else { echo "\nCreating Homepage..." . "\n"; }

$home_sections = [
    // Hero
    [
        'acf_fc_layout'   => 'hero',
        'overline'         => 'Stretch Creative',
        'headline'         => 'Creative Solutions Fit For You',
        'accent_text'      => 'Fit For You',
        'subtitle'         => 'The trusted partner for producing publish-ready content at scale — your story, your voice, on brand, on time.',
        'supporting_text'  => 'Content writing, SEO strategy, design, and videography.',
        'cta_button'       => ['title' => "Let's Chat", 'url' => '/contact-stretch-creative/', 'target' => ''],
        'secondary_cta'    => '',
        'bg_image'         => '',
        'bg_video'         => '',
        'show_shapes'      => 1,
    ],

    // Pull Quote
    [
        'acf_fc_layout'  => 'pull-quote-banner',
        'quote_text'     => 'More than a vendor — a creative partner that produces publish-ready content at scale, on brand and on time.',
        'accent_phrase'  => 'publish-ready content at scale',
    ],

    // Solutions Card Grid
    [
        'acf_fc_layout'  => 'card-grid',
        'overline'       => 'Solutions',
        'heading'        => 'Who We Work With',
        'columns'        => '4',
        'featured_first' => 0,
        'cards'          => [
            [
                'icon' => '', 'svg_code' => '<svg viewBox="0 0 44 44" fill="none" stroke="#8560A8" stroke-width="1.5"><rect x="8" y="8" width="28" height="28" rx="2" fill="none"/><path d="M8 18h28M18 18v18"/></svg>',
                'tag_label' => '', 'title' => 'Ecommerce',
                'description' => "Whether you're a retailer or DTC brand, the various types of content on your site can mean the difference between just doing okay and positively thriving.",
                'link' => ['title' => 'Learn More', 'url' => '/stretch-creative-solutions/ecommerce-content/', 'target' => ''],
            ],
            [
                'icon' => '', 'svg_code' => '<svg viewBox="0 0 44 44" fill="none" stroke="#8560A8" stroke-width="1.5"><circle cx="22" cy="16" r="6" fill="none"/><circle cx="12" cy="30" r="4" fill="none"/><circle cx="32" cy="30" r="4" fill="none"/><line x1="18" y1="20" x2="14" y2="27"/><line x1="26" y1="20" x2="30" y2="27"/></svg>',
                'tag_label' => '', 'title' => 'Agencies',
                'description' => "We'll handle your content needs with dedicated, industry-familiar writing teams to ensure consistency across clients.",
                'link' => ['title' => 'Learn More', 'url' => '/stretch-creative-solutions/agency-content/', 'target' => ''],
            ],
            [
                'icon' => '', 'svg_code' => '<svg viewBox="0 0 44 44" fill="none" stroke="#8560A8" stroke-width="1.5"><rect x="6" y="10" width="32" height="24" rx="1" fill="none"/><line x1="6" y1="18" x2="38" y2="18"/><line x1="22" y1="18" x2="22" y2="34"/></svg>',
                'tag_label' => '', 'title' => 'Publishers',
                'description' => 'You have a number of different web domains and need expert-level content for each property.',
                'link' => ['title' => 'Learn More', 'url' => '/stretch-creative-solutions/publisher-content/', 'target' => ''],
            ],
            [
                'icon' => '', 'svg_code' => '<svg viewBox="0 0 44 44" fill="none" stroke="#8560A8" stroke-width="1.5"><polyline points="8,32 16,24 22,28 30,14 36,10" fill="none"/><circle cx="36" cy="10" r="2.5" fill="none"/><line x1="8" y1="36" x2="36" y2="36"/></svg>',
                'tag_label' => '', 'title' => 'Content Marketing',
                'description' => 'Quality storytelling is everything when it comes to your brand identity — which we can help you define through copy.',
                'link' => ['title' => 'Learn More', 'url' => '/stretch-creative-solutions/demand-generation-content/', 'target' => ''],
            ],
        ],
        ...sec('light', 'solutions'),
    ],

    // Core Offerings — Featured + Grid
    [
        'acf_fc_layout'  => 'card-grid',
        'overline'       => 'Our Services',
        'heading'        => 'What We Deliver',
        'columns'        => '3',
        'featured_first' => 1,
        'cards'          => [
            [
                'icon' => '', 'svg_code' => '',
                'tag_label' => 'Core Offering',
                'title' => 'Content Writing at Any Scale',
                'description' => "From a single blog post to thousands of product descriptions — we build dedicated cohorts of writers calibrated to your brand voice, style guide, and quality standards.\n\nExpert-written, collaborative, and always on time.",
                'link' => ['title' => 'Learn More', 'url' => '/content-writing-at-any-scale/', 'target' => ''],
            ],
            [
                'icon' => '', 'svg_code' => '<svg viewBox="0 0 44 44" fill="none" stroke="#8560A8" stroke-width="1.5"><circle cx="22" cy="22" r="8" fill="none"/><line x1="22" y1="6" x2="22" y2="14"/><line x1="22" y1="30" x2="22" y2="38"/><line x1="6" y1="22" x2="14" y2="22"/><line x1="30" y1="22" x2="38" y2="22"/></svg>',
                'tag_label' => '', 'title' => 'SEO & Content Strategy',
                'description' => 'A perfect union of editorial and data. Keyword research, content planning, and optimization that drives organic visibility.',
                'link' => ['title' => 'Learn More', 'url' => '/seo_content_strategy_services/', 'target' => ''],
            ],
            [
                'icon' => '', 'svg_code' => '<svg viewBox="0 0 44 44" fill="none" stroke="#8560A8" stroke-width="1.5"><rect x="6" y="10" width="32" height="24" fill="none"/><line x1="22" y1="10" x2="22" y2="34"/><line x1="6" y1="22" x2="38" y2="22"/></svg>',
                'tag_label' => '', 'title' => 'Graphic Design',
                'description' => 'Always on brand. Custom visuals, infographics, and brand design that elevates your content.',
                'link' => ['title' => 'Learn More', 'url' => '/graphic_design_services/', 'target' => ''],
            ],
            [
                'icon' => '', 'svg_code' => '<svg viewBox="0 0 44 44" fill="none" stroke="#8560A8" stroke-width="1.5"><polygon points="22,6 36,22 22,38 8,22" fill="none"/><circle cx="22" cy="22" r="4" fill="none"/></svg>',
                'tag_label' => '', 'title' => 'Videography',
                'description' => 'Masterful visual storytelling. Video content production that brings your brand story to life.',
                'link' => ['title' => 'Learn More', 'url' => '/video-content-services/', 'target' => ''],
            ],
        ],
        ...sec('white', 'services'),
    ],

    // Testimonials
    [
        'acf_fc_layout' => 'testimonials',
        'testimonials'  => [
            [
                'quote'   => 'Working with Stretch Creative has been the biggest difference-maker in scaling Grove Collaborative\'s SEO content operations. The well-written, thoroughly researched articles bridge the gap between SEO needs and editorial best practices.',
                'name'    => 'Kristen Haney',
                'title'   => 'Sr. Growth Manager SEO Content',
                'company' => 'Grove Collaborative',
                'photo'   => '',
            ],
            [
                'quote'   => 'We have worked with Stretch on numerous projects across multiple channels and global markets. They were heavily involved in each project to get it across the line in a timely manner.',
                'name'    => 'Karen Hewitt',
                'title'   => 'Sr. Marketing Manager Demand Generation',
                'company' => 'WeWork',
                'photo'   => '',
            ],
            [
                'quote'   => 'Stretch is professional, punctual, and overall an amazing asset for us. No matter the task or turn around time they do a great job of bringing our brand identity to life.',
                'name'    => 'Keenan Wilson',
                'title'   => 'Marketing Manager',
                'company' => 'Stance',
                'photo'   => '',
            ],
            [
                'quote'   => 'Content for any brand is a monumental task. Not only in volume, but preciseness. Communicating at the right time, in the right dialect, and in a consistent voice across multiple platforms is imperative.',
                'name'    => 'Brian Reichel',
                'title'   => 'Sr. Vice President of Marketing',
                'company' => 'Brixton',
                'photo'   => '',
            ],
        ],
        ...sec('light'),
    ],

    // Blog Preview
    [
        'acf_fc_layout'  => 'blog-preview',
        'heading'        => 'Our Blog',
        'subheading'     => 'A few of our current posts',
        'post_count'     => 3,
        'category'       => '',
        'show_filters'   => 0,
        ...sec('white', 'blog'),
    ],

    // CTA
    [
        'acf_fc_layout'    => 'cta-section',
        'heading'          => "Ready to scale your content?",
        'body_text'        => 'Every partnership starts with a conversation about your goals, your audience, and the content that will get you there.',
        'cta_button'       => ['title' => 'Get in touch →', 'url' => '/contact-stretch-creative/', 'target' => ''],
        'secondary_button' => '',
        'bg_style'         => 'purple',
        'custom_bg_color'  => '',
    ],
];

$home_id = stretch_create_page('Home', 'home', $home_sections);
update_option('show_on_front', 'page');
update_option('page_on_front', $home_id);

// ────────────────────────────────────────
// ABOUT / OUR STORY
// ────────────────────────────────────────
if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("\nCreating Our Story page..."); } else { echo "\nCreating Our Story page..." . "\n"; }

$about_sections = [
    // Hero
    [
        'acf_fc_layout'  => 'hero',
        'overline'       => 'Our Story',
        'headline'       => 'Because Stories Matter',
        'accent_text'    => 'Stories Matter',
        'subtitle'       => 'From humble beginnings to making global impact.',
        'supporting_text' => '',
        'cta_button'     => '',
        'secondary_cta'  => '',
        'bg_image'       => '',
        'bg_video'       => '',
        'show_shapes'    => 1,
    ],

    // Story content
    [
        'acf_fc_layout'  => 'content-block',
        'overline'       => 'How We Started',
        'heading'        => 'Our Story',
        'body_content'   => '<p>Stretch Creative was founded on a few core beliefs: that content creators deserve fair compensation for their work, that content should be publishable when delivered, that freelancers deserve support and community, and that client relationships should be long-term partnerships built on trust.</p><p>Founder and CEO Chris Reid incorporated Stretch Creative at the dawn of the pandemic. Since then, our community of creatives has grown from two to more than 200.</p>',
        'pull_highlight'  => 'Our community of creatives has grown from two to more than 200.',
        'max_width'       => 'normal',
        ...sec('white', 'story'),
    ],

    // Values
    [
        'acf_fc_layout'  => 'card-grid',
        'overline'       => 'What We Care About Most',
        'heading'        => 'Our Values',
        'columns'        => '3',
        'featured_first' => 0,
        'cards'          => [
            ['icon' => '', 'svg_code' => '', 'tag_label' => '', 'title' => 'Collaboration', 'description' => 'We neither silo nor hide our creatives. Open communication and teamwork are at the heart of everything we do.', 'link' => ''],
            ['icon' => '', 'svg_code' => '', 'tag_label' => '', 'title' => 'Flexibility', 'description' => 'Projects change and evolve, and we change and evolve with them. We adapt to your needs, not the other way around.', 'link' => ''],
            ['icon' => '', 'svg_code' => '', 'tag_label' => '', 'title' => 'Truth & Transparency', 'description' => "We're open and honest in our relationships with clients and creatives. No surprises, no hidden agendas.", 'link' => ''],
            ['icon' => '', 'svg_code' => '', 'tag_label' => '', 'title' => 'Accountability', 'description' => 'We take ownership of our words and actions. When we commit to a deadline or standard, we deliver.', 'link' => ''],
            ['icon' => '', 'svg_code' => '', 'tag_label' => '', 'title' => 'Social Responsibility', 'description' => 'We treat clients and creatives fairly. Fair pay, fair timelines, fair expectations.', 'link' => ''],
            ['icon' => '', 'svg_code' => '', 'tag_label' => '', 'title' => 'Empathy', 'description' => 'We get enormous satisfaction out of the relationships we have — with our clients, our creatives, and each other.', 'link' => ''],
        ],
        ...sec('light', 'values'),
    ],

    // Process
    [
        'acf_fc_layout' => 'process-steps',
        'overline'      => 'Tight and Transparent',
        'heading'       => 'Our Process',
        'steps'         => [
            ['title' => 'Consultation', 'description' => 'We meet to define your needs, budget, and timeline. This is where we learn about your brand and goals.', 'icon' => ''],
            ['title' => 'Create Brief & Style Guide', 'description' => 'We develop detailed project briefs and training materials so our writers know exactly what you need.', 'icon' => ''],
            ['title' => 'Curate Creative Team', 'description' => 'We select a dedicated team based on their interests, experience, and fit with your brand.', 'icon' => ''],
            ['title' => 'Calibrate', 'description' => 'We produce sample pieces for your feedback, refining voice and style until it matches your standards perfectly.', 'icon' => ''],
            ['title' => 'Creatives Create', 'description' => 'Your dedicated team produces content on schedule, at scale, with built-in quality checks at every stage.', 'icon' => ''],
            ['title' => 'Ongoing Calibration & Feedback', 'description' => 'We continuously monitor, maintain, and update content quality through regular feedback loops.', 'icon' => ''],
        ],
        ...sec('white', 'process'),
    ],

    // Careers CTA
    [
        'acf_fc_layout'    => 'cta-section',
        'heading'          => 'Join Our Team',
        'body_text'        => "We're always on the lookout for fresh talent as we grow. If you'd like to join our team, we'd love to hear from you.",
        'cta_button'       => ['title' => 'Meet the Team →', 'url' => '/the-team/', 'target' => ''],
        'secondary_button' => '',
        'bg_style'         => 'purple',
        'custom_bg_color'  => '',
    ],
];

stretch_create_page('Our Story', 'about-stretch-creative', $about_sections);

// ────────────────────────────────────────
// OUR TEAM
// ────────────────────────────────────────
if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("\nCreating Our Team page..."); } else { echo "\nCreating Our Team page..." . "\n"; }

$team_sections = [
    // Hero
    [
        'acf_fc_layout'  => 'hero',
        'overline'       => 'Our Team',
        'headline'       => 'Clever. Skilled. Inspired.',
        'accent_text'    => 'Inspired.',
        'subtitle'       => 'We choose our creative teams carefully. Do they share our values? Are they driven to create because their spirit compels them to?',
        'supporting_text' => '',
        'cta_button'     => '',
        'secondary_cta'  => '',
        'bg_image'       => '',
        'bg_video'       => '',
        'show_shapes'    => 1,
    ],

    // Team intro + grid
    [
        'acf_fc_layout'  => 'team-grid',
        'heading'        => 'Meet the Team',
        'intro_text'     => 'We choose our creative teams carefully. Do they share our values? Are they driven to create because their spirit compels them to? Do they love what they do, are they good at it, and do they want to get even better at it? If the answer is yes, you\'ll find them right here, ready to crush it for you.',
        'team_members'   => [
            ['photo' => '', 'name' => 'Chris Reid', 'title' => 'CEO', 'bio' => ''],
            ['photo' => '', 'name' => 'Kelsi Carrell', 'title' => 'Head of Operations', 'bio' => ''],
            ['photo' => '', 'name' => 'Jesse Galvon Reid', 'title' => 'Chief People Officer', 'bio' => ''],
            ['photo' => '', 'name' => 'Kristen Bailey', 'title' => 'Editor-In-Chief', 'bio' => ''],
            ['photo' => '', 'name' => 'Josh Wong', 'title' => 'Director of Video Content', 'bio' => ''],
            ['photo' => '', 'name' => 'Jeanine Gordon', 'title' => 'Managing Editor', 'bio' => ''],
            ['photo' => '', 'name' => 'Fiona Ferguson', 'title' => 'Community & Recruitment Coordinator', 'bio' => ''],
            ['photo' => '', 'name' => 'Kristyn Pacione', 'title' => 'Client Services', 'bio' => ''],
            ['photo' => '', 'name' => 'MacKenzie Sanford', 'title' => 'Editor + Resource Coordinator', 'bio' => ''],
            ['photo' => '', 'name' => 'Jessica DeWolf', 'title' => 'Lead Editor', 'bio' => ''],
            ['photo' => '', 'name' => 'Leslie Jeffries', 'title' => 'Senior Copywriter', 'bio' => ''],
            ['photo' => '', 'name' => 'Jodi Noblett', 'title' => 'Copywriter', 'bio' => ''],
        ],
        ...sec('white', 'team'),
    ],

    // Hiring qualities
    [
        'acf_fc_layout'  => 'card-grid',
        'overline'       => 'What We Look For',
        'heading'        => 'Join Our Team',
        'columns'        => '2',
        'featured_first' => 0,
        'cards'          => [
            ['icon' => '', 'svg_code' => '', 'tag_label' => '', 'title' => 'Empathy', 'description' => "You love to tell a good story. You value relatable storytelling and truthful, helpful content with attention to rhythm and word choice.", 'link' => ''],
            ['icon' => '', 'svg_code' => '', 'tag_label' => '', 'title' => 'Intuition', 'description' => "You really know how to read a room. You understand audience needs and present information to solve problems effectively.", 'link' => ''],
            ['icon' => '', 'svg_code' => '', 'tag_label' => '', 'title' => 'Curious', 'description' => "You go down the rabbit hole. You seek deep understanding and bring relevant research insights to readers.", 'link' => ''],
            ['icon' => '', 'svg_code' => '', 'tag_label' => '', 'title' => 'Growth-Minded', 'description' => "You want to be a better writer. You value feedback and collaboration with creative peers.", 'link' => ''],
        ],
        ...sec('light', 'qualities'),
    ],

    // Apply CTA
    [
        'acf_fc_layout'    => 'cta-section',
        'heading'          => 'Start Your Career with Stretch',
        'body_text'        => "We're always looking for talented writers, editors, and creatives to join our growing team.",
        'cta_button'       => ['title' => 'Apply Now →', 'url' => '/contact-stretch-creative/', 'target' => ''],
        'secondary_button' => '',
        'bg_style'         => 'purple',
        'custom_bg_color'  => '',
    ],
];

// Our Team merged into the single About page (/about-stretch-creative/#our-team,
// punch-list #12). No longer created as a standalone /the-team/ page; existing
// installs are drafted by content-fixes.php FIX 5 and 301-redirected in
// functions.php (stretch_redirect_merged_about_pages). $team_sections retained
// above for reference/history.
// stretch_create_page('Our Team', 'the-team', $team_sections);

// ────────────────────────────────────────
// SOLUTIONS (parent page)
// ────────────────────────────────────────
if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("\nCreating Solutions pages..."); } else { echo "\nCreating Solutions pages..." . "\n"; }

$solutions_sections = [
    [
        'acf_fc_layout'  => 'hero',
        'overline'       => 'Solutions',
        'headline'       => 'Creative Solutions Fit For You',
        'accent_text'    => 'Fit For You',
        'subtitle'       => 'No matter your industry or content needs, we have a solution built for you.',
        'supporting_text' => '',
        'cta_button'     => ['title' => "Let's Talk →", 'url' => '/contact-stretch-creative/', 'target' => ''],
        'secondary_cta'  => '',
        'bg_image'       => '',
        'bg_video'       => '',
        'show_shapes'    => 1,
    ],
    [
        'acf_fc_layout'  => 'card-grid',
        'overline'       => '',
        'heading'        => 'Find Your Solution',
        'columns'        => '2',
        'featured_first' => 0,
        'cards'          => [
            ['icon' => '', 'svg_code' => '', 'tag_label' => '', 'title' => "I'm an Ecommerce Business", 'description' => "You need branded content that puts your best face forward — but some of what you get doesn't look remotely like you.", 'link' => ['title' => 'Learn More →', 'url' => '/stretch-creative-solutions/ecommerce-content/', 'target' => '']],
            ['icon' => '', 'svg_code' => '', 'tag_label' => '', 'title' => "I'm an Agency", 'description' => "Your clients expect you to create SEO content that does neat tricks, but what comes back from your provider doesn't look like what it's supposed to be doing.", 'link' => ['title' => 'Learn More →', 'url' => '/stretch-creative-solutions/agency-content/', 'target' => '']],
            ['icon' => '', 'svg_code' => '', 'tag_label' => '', 'title' => "I'm a Publisher", 'description' => "You're building an empire on a foundation of convincing content at scale. It's got to be authoritative, helpful, a joy to read, and optimized.", 'link' => ['title' => 'Learn More →', 'url' => '/stretch-creative-solutions/publisher-content/', 'target' => '']],
            ['icon' => '', 'svg_code' => '', 'tag_label' => '', 'title' => "I'm a Content Marketer", 'description' => "Your content needs are growing faster than your creative pool, and you feel like you're about to lose sight of the forest and the trees.", 'link' => ['title' => 'Learn More →', 'url' => '/stretch-creative-solutions/demand-generation-content/', 'target' => '']],
        ],
        ...sec('white'),
    ],
    [
        'acf_fc_layout'    => 'cta-section',
        'heading'          => "Let's Talk",
        'body_text'        => "Tell us about your content needs and we'll build a solution that fits.",
        'cta_button'       => ['title' => 'Contact Us →', 'url' => '/contact-stretch-creative/', 'target' => ''],
        'secondary_button' => '',
        'bg_style'         => 'purple',
        'custom_bg_color'  => '',
    ],
];

$solutions_id = stretch_create_page('Solutions', 'stretch-creative-solutions', $solutions_sections);

// Solution sub-pages
$solution_subpages = [
    ['Ecommerce Content', 'ecommerce-content', 'High Performance Ecommerce Content Services', "Whether you're a retailer or DTC brand, great content is the difference between just doing okay and positively thriving. We create product descriptions, buying guides, blog content, and SEO copy that drives conversions."],
    ['Agency Content', 'agency-content', 'Content Solutions for Agencies', "We become an extension of your agency with dedicated, industry-familiar writing teams that ensure consistency across all your clients."],
    ['Publisher Content', 'publisher-content', 'Expert Content for Publishers', "You have multiple web domains and need expert-level content for each property. We deliver authoritative, helpful content optimized for performance at scale."],
    ['Content Marketing & Demand Generation', 'demand-generation-content', 'Content Marketing & Demand Generation', "Quality storytelling is everything when it comes to your brand identity. We help you define your voice and create content that drives awareness, engagement, and conversions."],
];

foreach ($solution_subpages as $sp) {
    $sp_sections = [
        [
            'acf_fc_layout'  => 'hero',
            'overline'       => 'Solutions',
            'headline'       => $sp[2],
            'accent_text'    => '',
            'subtitle'       => $sp[3],
            'supporting_text' => '',
            'cta_button'     => ['title' => "Let's Talk →", 'url' => '/contact-stretch-creative/', 'target' => ''],
            'secondary_cta'  => '',
            'bg_image'       => '',
            'bg_video'       => '',
            'show_shapes'    => 1,
        ],
        [
            'acf_fc_layout'  => 'content-block',
            'overline'       => '',
            'heading'        => '',
            'body_content'   => '<p>' . $sp[3] . '</p>',
            'pull_highlight'  => '',
            'max_width'       => 'normal',
            ...sec('white'),
        ],
        [
            'acf_fc_layout'    => 'cta-section',
            'heading'          => "Let's Talk",
            'body_text'        => 'Tell us about your content needs and we\'ll build a solution that fits.',
            'cta_button'       => ['title' => 'Contact Us →', 'url' => '/contact-stretch-creative/', 'target' => ''],
            'secondary_button' => '',
            'bg_style'         => 'purple',
            'custom_bg_color'  => '',
        ],
    ];
    stretch_create_page($sp[0], $sp[1], $sp_sections, $solutions_id);
}

// ────────────────────────────────────────
// SERVICES PAGES
// ────────────────────────────────────────
if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("\nCreating Service pages..."); } else { echo "\nCreating Service pages..." . "\n"; }

$service_pages = [
    ['Content Writing at Any Scale', 'content-writing-at-any-scale', 'Content Writing at Any Scale', "From a single blog post to thousands of product descriptions — we build dedicated cohorts of writers calibrated to your brand voice, style guide, and quality standards."],
    ['SEO & Content Strategy', 'seo_content_strategy_services', 'SEO & Content Strategy Services', "A perfect union of editorial expertise and data-driven strategy. We help you rank for the keywords that matter most to your business."],
    ['Graphic Design Services', 'graphic_design_services', 'Graphic Design Services', "Always on brand. Custom visuals, infographics, and brand design that elevates your content and strengthens your identity."],
    ['Video Content Services', 'video-content-services', 'Video Content Services', "Masterful visual storytelling. From concept to final cut, we produce video content that brings your brand story to life."],
];

foreach ($service_pages as $svc) {
    $svc_sections = [
        [
            'acf_fc_layout'  => 'hero',
            'overline'       => 'Services',
            'headline'       => $svc[2],
            'accent_text'    => '',
            'subtitle'       => $svc[3],
            'supporting_text' => '',
            'cta_button'     => ['title' => "Get Started →", 'url' => '/contact-stretch-creative/', 'target' => ''],
            'secondary_cta'  => '',
            'bg_image'       => '',
            'bg_video'       => '',
            'show_shapes'    => 1,
        ],
        [
            'acf_fc_layout'  => 'content-block',
            'overline'       => '',
            'heading'        => 'What We Offer',
            'body_content'   => '<p>' . $svc[3] . '</p>',
            'pull_highlight'  => '',
            'max_width'       => 'normal',
            ...sec('white'),
        ],
        [
            'acf_fc_layout'    => 'cta-section',
            'heading'          => "Ready to get started?",
            'body_text'        => "Let's talk about how we can help with your content needs.",
            'cta_button'       => ['title' => 'Contact Us →', 'url' => '/contact-stretch-creative/', 'target' => ''],
            'secondary_button' => '',
            'bg_style'         => 'purple',
            'custom_bg_color'  => '',
        ],
    ];
    stretch_create_page($svc[0], $svc[1], $svc_sections);
}

// ────────────────────────────────────────
// CONTACT
// ────────────────────────────────────────
if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("\nCreating Contact page..."); } else { echo "\nCreating Contact page..." . "\n"; }

$contact_sections = [
    [
        'acf_fc_layout'  => 'hero',
        'overline'       => 'Contact',
        'headline'       => "We're Here to Help",
        'accent_text'    => 'Here to Help',
        'subtitle'       => "Let's talk about your content needs.",
        'supporting_text' => '',
        'cta_button'     => '',
        'secondary_cta'  => '',
        'bg_image'       => '',
        'bg_video'       => '',
        'show_shapes'    => 1,
    ],
    [
        'acf_fc_layout'    => 'contact-block',
        'heading'          => "Let's Talk",
        'address'          => "132 - 328 Wale Rd\nVictoria, BC\nCanada V9B 0J8",
        'phone'            => '+1 250 858 9644',
        'email'            => 'hello@stretchcreative.co',
        'social_links'     => [
            ['platform' => 'linkedin', 'url' => 'https://www.linkedin.com/company/stretchcreative/'],
        ],
        'form_shortcode'   => '',
        'layout'           => 'form-right',
        ...sec('white', 'contact'),
    ],
];

stretch_create_page('Contact Stretch Creative', 'contact-stretch-creative', $contact_sections);

// ────────────────────────────────────────
// BLOG PAGE
// ────────────────────────────────────────
if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("\nCreating Blog page..."); } else { echo "\nCreating Blog page..." . "\n"; }

$blog_id = stretch_create_page('Blog', 'blog', []);
update_option('page_for_posts', $blog_id);

// ────────────────────────────────────────
// NAVIGATION MENU ITEMS
// ────────────────────────────────────────
if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("\nPopulating navigation menus..."); } else { echo "\nPopulating navigation menus..." . "\n"; }

// Primary menu
$primary_menu_id = $menu_locations['primary'];
wp_update_nav_menu_item($primary_menu_id, 0, [
    'menu-item-title'  => 'Solutions',
    'menu-item-url'    => home_url('/stretch-creative-solutions/'),
    'menu-item-status' => 'publish',
    'menu-item-type'   => 'custom',
    'menu-item-position' => 1,
]);
wp_update_nav_menu_item($primary_menu_id, 0, [
    'menu-item-title'  => 'Our Story',
    'menu-item-url'    => home_url('/about-stretch-creative/'),
    'menu-item-status' => 'publish',
    'menu-item-type'   => 'custom',
    'menu-item-position' => 2,
]);
wp_update_nav_menu_item($primary_menu_id, 0, [
    'menu-item-title'  => 'Our Team',
    'menu-item-url'    => home_url('/the-team/'),
    'menu-item-status' => 'publish',
    'menu-item-type'   => 'custom',
    'menu-item-position' => 3,
]);
wp_update_nav_menu_item($primary_menu_id, 0, [
    'menu-item-title'  => 'Blog',
    'menu-item-url'    => home_url('/blog/'),
    'menu-item-status' => 'publish',
    'menu-item-type'   => 'custom',
    'menu-item-position' => 4,
]);
wp_update_nav_menu_item($primary_menu_id, 0, [
    'menu-item-title'   => 'Contact Us',
    'menu-item-url'     => home_url('/contact-stretch-creative/'),
    'menu-item-status'  => 'publish',
    'menu-item-type'    => 'custom',
    'menu-item-classes' => 'btn-primary nav-cta',
    'menu-item-position' => 5,
]);

// Footer 1 — Solutions
$f1_id = $menu_locations['footer-1'];
wp_update_nav_menu_item($f1_id, 0, ['menu-item-title' => 'For Ecommerce', 'menu-item-url' => home_url('/stretch-creative-solutions/ecommerce-content/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom']);
wp_update_nav_menu_item($f1_id, 0, ['menu-item-title' => 'For Agencies', 'menu-item-url' => home_url('/stretch-creative-solutions/agency-content/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom']);
wp_update_nav_menu_item($f1_id, 0, ['menu-item-title' => 'For Publishers', 'menu-item-url' => home_url('/stretch-creative-solutions/publisher-content/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom']);
wp_update_nav_menu_item($f1_id, 0, ['menu-item-title' => 'Marketing & Demand Gen', 'menu-item-url' => home_url('/stretch-creative-solutions/demand-generation-content/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom']);

// Footer 2 — Company
$f2_id = $menu_locations['footer-2'];
wp_update_nav_menu_item($f2_id, 0, ['menu-item-title' => 'Our Story', 'menu-item-url' => home_url('/about-stretch-creative/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom']);
wp_update_nav_menu_item($f2_id, 0, ['menu-item-title' => 'Our Team', 'menu-item-url' => home_url('/the-team/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom']);

// Footer 3 — Stay Connected
$f3_id = $menu_locations['footer-3'];
wp_update_nav_menu_item($f3_id, 0, ['menu-item-title' => 'Contact Us', 'menu-item-url' => home_url('/contact-stretch-creative/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom']);
wp_update_nav_menu_item($f3_id, 0, ['menu-item-title' => 'Blog', 'menu-item-url' => home_url('/blog/'), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom']);

// ────────────────────────────────────────
// SAMPLE BLOG POSTS
// ────────────────────────────────────────
if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("\nCreating sample blog posts..."); } else { echo "\nCreating sample blog posts..." . "\n"; }

$posts = [
    ['7 Things You Need to Know Now for Successful Content Marketing in 2024', 'content-marketing-2024', 'Content marketing continues to evolve at a rapid pace. From AI-assisted writing to interactive content experiences, the landscape is shifting beneath our feet. Here are the seven most important trends and strategies you need to know to stay ahead.', 'content-marketing'],
    ['How Ecommerce Brands Can Win with SEO Content', 'ecommerce-seo-content', 'For ecommerce brands, SEO content is more than just blog posts — it\'s product descriptions that convert, buying guides that rank, and category pages that drive organic traffic. Here\'s how to build a content strategy that actually moves the needle.', 'ecommerce'],
    ['The Complete Guide to Building a Content Team at Scale', 'building-content-team-scale', 'Scaling a content operation is one of the hardest challenges in marketing. How do you maintain quality as you increase volume? How do you keep brand voice consistent across dozens of writers? We break down the proven approach.', 'content-marketing'],
];

// Create categories
$cat_cm = wp_create_category('Content Marketing');
$cat_ec = wp_create_category('Ecommerce');
$cat_seo = wp_create_category('SEO');

foreach ($posts as $p) {
    $existing = get_page_by_path($p[1], OBJECT, 'post');
    if (!$existing) {
        $cat = ($p[3] === 'ecommerce') ? $cat_ec : $cat_cm;
        wp_insert_post([
            'post_title'    => $p[0],
            'post_name'     => $p[1],
            'post_content'  => '<p>' . $p[2] . '</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p><h2>Key Takeaways</h2><p>Understanding the landscape is the first step. Implementation is where the real work begins — and where the results come from.</p><blockquote>The brands that win at content marketing aren\'t the ones producing the most content. They\'re the ones producing the most useful content.</blockquote><p>Whether you\'re just starting to invest in content or looking to scale an existing operation, the principles remain the same: quality, consistency, and strategic alignment with business goals.</p>',
            'post_status'   => 'publish',
            'post_type'     => 'post',
            'post_category' => [$cat],
        ]);
        if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("  Created post: {$p[0]}"); } else { echo "  Created post: {$p[0]}" . "\n"; }
    }
}

// ────────────────────────────────────────
// PERMALINK STRUCTURE
// ────────────────────────────────────────
if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("\nSetting permalink structure..."); } else { echo "\nSetting permalink structure..." . "\n"; }
// AUD-023: match the real production structure so a manual re-run of this legacy
// rebuild script can never break existing /blog/... URLs.
update_option('permalink_structure', '/blog/%category%/%postname%/');
flush_rewrite_rules();

if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("\n=== Content setup complete! ==="); } else { echo "\n=== Content setup complete! ===" . "\n"; }
if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("Pages created: Home, Our Story, Our Team, Solutions (+ 4 sub-pages), 4 Service pages, Contact, Blog"); } else { echo "Pages created: Home, Our Story, Our Team, Solutions (+ 4 sub-pages), 4 Service pages, Contact, Blog" . "\n"; }
if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("Menus: Primary nav + 3 footer columns"); } else { echo "Menus: Primary nav + 3 footer columns" . "\n"; }
if (defined('WP_CLI') && WP_CLI) { WP_CLI::log("Blog: 3 sample posts with categories"); } else { echo "Blog: 3 sample posts with categories" . "\n"; }
