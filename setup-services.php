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
            'description' => 'Get blog content that performs the way you want it to — educate or inspire, pitch or plug, teach or tempt. From thought leadership and lifestyle pieces to listicles and how-to\'s, we\'ll create blog articles that are helpful, accurate, and a pleasure to read.',
        ],
        [
            'title'       => 'Buying Guides',
            'description' => 'A perfect balance of romance copy to inspire and useful information to educate, a buying guide establishes your authority, builds trust, showcases your brand, and helps your customers choose just what they need.',
        ],
        [
            'title'       => 'User-Generated Content',
            'description' => 'Build trust and credibility with user-generated content. Our UGC writers create super-engaging content — photos included — that sparks inspiration and a sense of community and helps influence purchases.',
        ],
        [
            'title'       => 'Expert-Written or Reviewed',
            'description' => 'Expertise, experience, authoritativeness, and trust (E-E-A-T) is everything when you\'re writing what Google calls "Your Money, Your Life" (YMYL) content — medical, financial, and other important topics that do best when they\'re written or reviewed by a credentialed expert. Byline included.',
        ],
        [
            'title'       => 'Product Descriptions',
            'description' => 'The almighty product description is often the very last thing a visitor sees before they ADD TO CART (or leave the page), so they gotta be good: engaging, informative, accurate, and on-brand. Leave it to Stretch to write spectacular product descriptions that help drive sales.',
        ],
        [
            'title'       => 'Product Listing Pages',
            'description' => 'Product listing pages — aka category landing pages or "bottom copy" — give your customers loads of helpful information to inform their purchasing decisions, whatever their funnel position. We\'ll convince them they\'re making the right choice, or help them find exactly what they\'re looking for.',
        ],
        [
            'title'       => 'Email & Social Content',
            'description' => 'Getting people to open, read, and act on your emails — or like and share your social posts — is like pulling teeth if your content is as painful to read as a root canal. Email and social media are very special birds, and we\'re fluent in their subtle, musical language.',
        ],
        [
            'title'       => 'Photo Sourcing',
            'description' => 'We\'ll find and acquire images for use in your content — from your internal database, free or paid stock photo libraries, or other sources — fully licensed and ready to ship.',
        ],
        [
            'title'       => 'Expert Review',
            'description' => 'Our roster of credentialed experts in fields like health, finance, and law will review the content we produce. An expert-reviewed byline gives the piece more authority in the eyes of search engines and your readers.',
        ],
        [
            'title'       => 'Incorporate Interview',
            'description' => 'Have an existing interview transcript? We\'ll turn it into a Q&A blog or pull the best quotes into a feature piece — making your subject-matter expertise work harder.',
        ],
        [
            'title'       => 'Conduct Expert Interviews',
            'description' => 'We\'ll interview your stakeholders for you. We write the questions, run the video conference, and turn the transcript into publish-ready content.',
        ],
        [
            'title'       => 'Create Editorial Briefs',
            'description' => 'Hand us your keyword and SEO research and we\'ll build editorial briefs that give writers a clear roadmap to high-performing content — angle, structure, sources, and voice all spelled out.',
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
    'stats' => [
        ['label' => 'Writers', 'value' => '200', 'suffix' => '+'],
        ['label' => 'Minimums', 'value' => 'No Minimums', 'suffix' => ''],
        ['label' => 'Industries', 'value' => '10', 'suffix' => '+'],
        ['label' => 'On-Time Delivery', 'value' => '98', 'suffix' => '%'],
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
    'headline'    => 'SEO Strategy & Services',
    'subheadline' => "From detailed enterprise audits and rank tracking to SEO-Lite for smaller brands, our services flex to what you actually need — so you only pay for the work that moves the needle.",
    'offerings'   => [
        [
            'title'       => 'Keyword Research',
            'description' => 'Success in SEO starts with the right keywords. Our SEO team does a deep dive into your niche to uncover the keywords most relevant to your audience. We pay attention to context, search intent, and the story the keywords tell.',
        ],
        [
            'title'       => 'SEO Content Briefs',
            'description' => 'Success in SEO starts with the right keywords and a solid strategy — but it doesn\'t end there. We\'ll take your keywords (or do the research for you) and create editorial briefs that help our writers produce comprehensive, reader-friendly articles that are genuinely helpful and authentically authoritative.',
        ],
        [
            'title'       => 'On-Page Optimization',
            'description' => 'Title tags, meta descriptions, header hierarchy, internal linking, schema markup, and content structure — optimized across every page that matters. We handle the detail work that separates pages that rank from pages that sit on page two.',
        ],
        [
            'title'       => 'Audits & Analyses',
            'description' => 'Our internal SEO team provides insight and expert advice on improving the performance of your website and your content. Whatever information you need, we can deliver it with audits like a standalone keyword gap analysis, a link audit, or keyword performance tracking.',
        ],
        [
            'title'       => 'Article Optimizations & Rewrites',
            'description' => 'If your existing content is a little rough around the edges — or it was last updated in 2015 — leave it to us to dust off the cobwebs and give it the head-to-toe SEO treatment, plus a good, old-fashioned spit-shine to clean it up and make it current, cohesive, relevant, and results-oriented.',
        ],
        [
            'title'       => 'A/B Testing',
            'description' => 'Not sure why your content isn\'t performing? We\'ll help you gain insight into user behavior with A/B testing, then work with you to refine your site\'s UX and improve content for a more satisfying experience and better search results.',
        ],
        [
            'title'       => 'SEO-Lite for Small Brands',
            'description' => "Enterprise-grade SEO is overkill for most small and mid-sized brands. Our SEO-Lite offering delivers the essentials — foundational audits, targeted keyword work, on-page fundamentals, and light-touch reporting — at a price point that actually fits a lean marketing budget.",
        ],
        [
            'title'       => 'Rank Tracking & Reporting',
            'description' => "Transparent, business-focused reporting on the keywords and pages that matter to your revenue. We track rankings, organic traffic, click-through rates, and conversions — then translate the data into clear recommendations on what to do next.",
        ],
    ],
    'why_heading' => 'Why Stretch?',
    'why_intro'   => "Our SEO experts know the ins and outs of keyword research and data analysis. Our editorial team is tuned into the human ethos and user experience. Together, they're a perfect balance of science and art — and they scale from SEO-Lite engagements to full enterprise programs.",
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
    'stats' => [
        ['label' => 'Keywords Analyzed', 'value' => '500', 'suffix' => 'K+'],
        ['label' => 'Results Timeline', 'value' => '3-6', 'suffix' => 'mo'],
        ['label' => 'Strategy', 'value' => '100', 'suffix' => '%'],
        ['label' => 'Approach', 'value' => 'Data-Driven', 'suffix' => ''],
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
    'headline'    => 'Paid Advertising That Actually Converts',
    'subheadline' => "Stop wasting money on ads that miss the mark. We build and run Google, Meta, and social campaigns that reach your audience, boost conversions, and grow your revenue.",
    'offerings'   => [
        [
            'title'       => 'Google Search Ads',
            'description' => 'Intent-driven campaigns built around the keywords your customers actually use. We structure accounts for efficiency, write ad copy that earns the click, and manage bids to maximize every dollar.',
        ],
        [
            'title'       => 'Google Display & YouTube',
            'description' => 'Awareness and retargeting across the Google Display Network and YouTube. We pair smart audience targeting with on-brand creative to drive qualified impressions at efficient CPMs.',
        ],
        [
            'title'       => 'Meta Ads (Facebook & Instagram)',
            'description' => 'Full-funnel Meta campaigns from prospecting to retargeting. We handle audience research, creative direction, copywriting, and optimization — all in one place.',
        ],
        [
            'title'       => 'LinkedIn Ads',
            'description' => 'B2B campaigns tuned for decision-makers. We target by role, industry, and account, then build message variants that speak to each buyer stage.',
        ],
        [
            'title'       => 'Retargeting Campaigns',
            'description' => 'Bring back the visitors who already know you. We build sophisticated retargeting audiences and sequenced messaging that moves warm traffic toward conversion.',
        ],
        [
            'title'       => 'Ad Creative & Copy',
            'description' => 'Static, video, carousel — our in-house design and writing teams produce platform-native creative variants built for testing. No subcontractors, no handoff gaps.',
        ],
        [
            'title'       => 'Landing Page Optimization',
            'description' => "Ads don't fail in isolation — the landing page is half the equation. We audit, redesign, and test landing pages to close the gap between click and conversion.",
        ],
        [
            'title'       => 'Reporting & Insights',
            'description' => 'Weekly or monthly reporting tied to the metrics that matter to your business — CAC, ROAS, pipeline, revenue — not vanity metrics dressed up as performance.',
        ],
    ],
    'why_heading' => 'Why Stretch?',
    'why_intro'   => "Most paid shops treat creative and media as separate disciplines — and your CAC pays the price. We run them together, which is exactly why our campaigns compound.",
    'benefits'    => [
        [
            'title'       => 'Creative + Media Under One Roof',
            'description' => 'Your writers, designers, videographers, and media buyers are on the same team — so creative iterates as fast as the data demands, with no agency ping-pong.',
        ],
        [
            'title'       => 'Transparent Reporting',
            'description' => "You see the account. You see the spend. You see what's working. No black-box dashboards, no mystery line items — just clear reporting tied to your goals.",
        ],
        [
            'title'       => 'Built for ROI',
            'description' => "We optimize for business outcomes, not platform metrics. If an ad looks great but isn't converting, we kill it. If a scrappy variant is winning, we scale it.",
        ],
        [
            'title'       => 'Always Testing',
            'description' => 'Paid only stays efficient if you keep testing. We run structured creative and audience tests every cycle — so performance moves up instead of decaying over time.',
        ],
    ],
    'stats' => [
        ['label' => 'Platforms', 'value' => '6', 'suffix' => '+'],
        ['label' => 'Reporting', 'value' => 'Transparent', 'suffix' => ''],
        ['label' => 'Creative', 'value' => 'In-House', 'suffix' => ''],
        ['label' => 'Focus', 'value' => 'ROI', 'suffix' => ''],
    ],
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
