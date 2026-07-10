<?php
/**
 * setup-seo.php — AUD-003: seed site-wide SEO metadata (idempotent).
 *
 * Sets per-page SEO titles + meta descriptions (post meta) and blog-category
 * titles + descriptions (term meta) for whichever supported SEO plugin is
 * active (Rank Math preferred, Yoast fallback), plus Rank Math baseline
 * options: sitemap on, title separator, default OG image, Organization
 * knowledge graph, wizard/registration nags off, noisy modules off.
 *
 * Prerequisite (one-time, via wp-cli):
 *   wp plugin install seo-by-rank-math --activate --allow-root
 *
 * Run:
 *   docker compose cp setup-seo.php wordpress:/var/www/html/
 *   docker compose exec -T wordpress wp eval-file /var/www/html/setup-seo.php --allow-root
 */

if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
	exit;
}

// ---------------------------------------------------------------------------
// Detect active SEO plugin.
// ---------------------------------------------------------------------------

$is_rank_math = defined( 'RANK_MATH_VERSION' );
$is_yoast     = defined( 'WPSEO_VERSION' );

if ( $is_rank_math ) {
	$meta_title_key = 'rank_math_title';
	$meta_desc_key  = 'rank_math_description';
	WP_CLI::log( 'SEO plugin: Rank Math ' . RANK_MATH_VERSION );
} elseif ( $is_yoast ) {
	$meta_title_key = '_yoast_wpseo_title';
	$meta_desc_key  = '_yoast_wpseo_metadesc';
	WP_CLI::log( 'SEO plugin: Yoast SEO ' . WPSEO_VERSION );
} else {
	WP_CLI::error( 'Neither Rank Math nor Yoast SEO is active. Install one first (wp plugin install seo-by-rank-math --activate).' );
}

// ---------------------------------------------------------------------------
// Rank Math baseline configuration (options). All idempotent.
// ---------------------------------------------------------------------------

if ( $is_rank_math ) {
	// 1. Modules: make sure the ones we rely on are on (sitemap, schema/OG,
	//    link counter, SEO analysis, ACF integration) and the noisy /
	//    irrelevant ones are off. Anything an admin enables later that is not
	//    on the banned list is preserved.
	$modules = (array) get_option( 'rank_math_modules', [] );
	$ensure  = [ 'sitemap', 'rich-snippet', 'link-counter', 'seo-analysis', 'acf' ];
	$banned  = [ 'analytics', 'content-ai', 'instant-indexing', 'ai-visibility', 'web-stories', 'woocommerce', 'buddypress', 'bbpress', 'podcast' ];

	$new_modules = array_values( array_unique( array_merge( array_diff( $modules, $banned ), $ensure ) ) );
	sort( $new_modules );
	$sorted_current = $modules;
	sort( $sorted_current );

	if ( $new_modules !== $sorted_current ) {
		update_option( 'rank_math_modules', $new_modules );
		WP_CLI::log( 'Modules set: ' . implode( ', ', $new_modules ) );
	} else {
		WP_CLI::log( 'Modules already correct: ' . implode( ', ', $new_modules ) );
	}

	// 2. Titles & meta options: separator, site identity, Organization schema,
	//    default OG image (brand-owned attachment, located at runtime).
	$titles = (array) get_option( 'rank-math-options-titles', [] );

	$og_id = 0;
	foreach ( [ 'stretch-creative-logo', 'logo', 'stretch_creative_product_copy' ] as $candidate ) {
		$found = get_posts(
			[
				'post_type'      => 'attachment',
				'name'           => $candidate,
				'posts_per_page' => 1,
				'post_status'    => 'any',
				'fields'         => 'ids',
			]
		);
		if ( $found ) {
			$og_id = (int) $found[0];
			break;
		}
	}

	$titles_changes = [
		'title_separator'     => '|',
		'website_name'        => 'Stretch Creative',
		'knowledgegraph_type' => 'company',
		'knowledgegraph_name' => 'Stretch Creative',
	];
	if ( $og_id ) {
		$titles_changes['open_graph_image']    = wp_get_attachment_url( $og_id );
		$titles_changes['open_graph_image_id'] = $og_id;
	} else {
		WP_CLI::warning( 'No suitable default OG image attachment found — skipping open_graph_image.' );
	}

	$dirty = false;
	foreach ( $titles_changes as $key => $value ) {
		if ( ! isset( $titles[ $key ] ) || $titles[ $key ] !== $value ) {
			$titles[ $key ] = $value;
			$dirty          = true;
		}
	}
	if ( $dirty ) {
		update_option( 'rank-math-options-titles', $titles );
		WP_CLI::log( 'Titles options updated (separator "|", Organization schema' . ( $og_id ? ', default OG image #' . $og_id : '' ) . ').' );
	} else {
		WP_CLI::log( 'Titles options already correct.' );
	}

	// 3. General options: keep breadcrumbs off (theme renders its own nav and
	//    has no rank-math-breadcrumbs support; avoids markup pollution).
	$general = (array) get_option( 'rank-math-options-general', [] );
	if ( ( $general['breadcrumbs'] ?? '' ) !== 'off' ) {
		$general['breadcrumbs'] = 'off';
		update_option( 'rank-math-options-general', $general );
		WP_CLI::log( 'Breadcrumbs module output disabled.' );
	} else {
		WP_CLI::log( 'Breadcrumbs already off.' );
	}

	// 4. Kill the setup-wizard redirect + registration nags.
	delete_transient( '_rank_math_activation_redirect' );
	if ( ! get_option( 'rank_math_is_configured' ) ) {
		update_option( 'rank_math_is_configured', true );
		WP_CLI::log( 'Marked Rank Math as configured (setup wizard nag off).' );
	}
	if ( ! get_option( 'rank_math_registration_skip' ) ) {
		update_option( 'rank_math_registration_skip', true );
		WP_CLI::log( 'Rank Math account-registration screen skipped.' );
	}

	// 5. Guard: the free plugin ships a Gutenberg TOC block
	//    (rank-math/toc-block) that has historically polluted imported posts.
	//    It only renders when present in post content — verify none remains
	//    (see strip-rank-math-toc.php for cleanup).
	global $wpdb;
	$toc_count = (int) $wpdb->get_var(
		"SELECT COUNT(*) FROM {$wpdb->posts}
		 WHERE post_status IN ('publish', 'draft')
		   AND post_content LIKE '%rank-math/toc-block%'"
	);
	if ( $toc_count > 0 ) {
		WP_CLI::warning( "$toc_count post(s) still contain rank-math/toc-block markup — run strip-rank-math-toc.php." );
	} else {
		WP_CLI::log( 'TOC check: no rank-math/toc-block markup in any post content.' );
	}
}

// ---------------------------------------------------------------------------
// Per-page SEO titles + meta descriptions. Pages resolved by path at runtime.
// Descriptions are 140-160 chars, benefit-led, sourced from the copy doc.
// ---------------------------------------------------------------------------

$pages = [
	// Core pages.
	'home'                                                 => [
		'title' => 'Content Solutions for Modern Search & Discoverability | Stretch Creative',
		'desc'  => 'Rank smarter, not harder. Stretch Creative maximizes your marketing budget with SEO, AEO, and content services that fit your needs—nothing more, nothing less.',
	],

	// Industry pages (titles = copy-doc H1s + brand).
	'industries/ecommerce'                                 => [
		'title' => 'Ecommerce SEO, Content, and Creative Services | Stretch Creative',
		'desc'  => 'Help shoppers discover the right products—and buy with confidence. Ecommerce SEO, product and category page content, and creative services that convert.',
	],
	'industries/agencies'                                  => [
		'title' => 'White-Labeled Content & Creative Services for Agencies and Strategic Partners | Stretch Creative',
		'desc'  => 'Scale production, expand your capabilities, and deliver exceptional work without expanding your payroll. White-labeled content built for agency growth.',
	],

	// Service pages.
	'content-writing-at-any-scale'                         => [
		'title' => 'Content Writing at Any Scale | Stretch Creative',
		'desc'  => 'Human-written, SEO- and AEO-optimized content from a dedicated writing team. No minimums, no long-term contracts—just publish-ready content at any scale.',
	],
	'seo_content_strategy_services'                        => [
		'title' => 'SEO + AEO Strategy & Services | Stretch Creative',
		'desc'  => 'Get found today, stay visible tomorrow. Proven SEO plus Answer Engine Optimization keeps your website visible across Google and AI-powered search tools.',
	],
	'graphic_design_services'                              => [
		'title' => 'Graphic Design & Visual Content Services | Stretch Creative',
		'desc'  => 'Branded graphics, infographics, social creative, and presentation design from an in-house team—visual content that makes your message easier to remember.',
	],
	'video-content-services'                               => [
		'title' => 'Video & Photography Production Services | Stretch Creative',
		'desc'  => 'Brand stories, commercials, product photography, and social video—full-service production from concept through delivery by our in-house creative team.',
	],
	'paid-advertising'                                     => [
		'title' => 'Paid Advertising Services | Stretch Creative',
		'desc'  => 'Reach the right audience with campaigns built to perform. Search, shopping, social, and display advertising with clear reporting and constant optimization.',
	],
	'services/bespoke-content-experience'                  => [
		'title' => 'Interactive Content Marketing | Stretch Creative',
		'desc'  => 'Calculators, quizzes, assessments, and interactive tools that turn visitors into engaged leads. Bespoke content experiences designed, built, and measured.',
	],

	// Company pages.
	'about-stretch-creative'                               => [
		'title' => 'About Stretch Creative | Our Story, Values & Process',
		'desc'  => 'From two creatives to a community of 200+, Stretch Creative is changing the way content gets made. Learn about our story, our values, and how we work.',
	],
	'the-team'                                             => [
		'title' => 'Meet the Team | Stretch Creative',
		'desc'  => 'Clever, skilled, and inspired—meet the writers, editors, designers, and strategists behind Stretch Creative and see what we look for in new talent.',
	],
	'contact-stretch-creative'                             => [
		'title' => 'Contact Us | Stretch Creative',
		'desc'  => "Tell us about your project and we'll show you how Stretch Creative can help. Get in touch to talk SEO, AEO, content, design, video, or paid advertising.",
	],
	'our-work'                                             => [
		'title' => 'Our Work | Stretch Creative',
		'desc'  => 'Explore selected work from Stretch Creative—content writing, graphic design, infographics, photography, and video produced for brands across industries.',
	],
	'pricing'                                              => [
		'title' => 'Pricing | Stretch Creative',
		'desc'  => 'Flexible engagement options with no minimums and no long-term contracts. See how Stretch Creative pricing helps you maximize your content and SEO budget.',
	],
	'blog'                                                 => [
		'title' => 'Blog: SEO, AEO & Content Insights | Stretch Creative',
		'desc'  => 'Insights on SEO, AEO, content marketing, ecommerce, and creative strategy from the Stretch Creative team—practical advice for modern search visibility.',
	],

	// Additional published pages (legacy Solutions cluster + structural).
	'services'                                             => [
		'title' => 'Services | Stretch Creative',
		'desc'  => 'Explore Stretch Creative services: SEO and AEO strategy, content writing, interactive content experiences, visual design, video, and paid advertising.',
	],
	'stretch-creative-solutions'                           => [
		'title' => 'Content & SEO Solutions | Stretch Creative',
		'desc'  => 'Explore Stretch Creative solutions for ecommerce, agencies, publishers, and demand generation—SEO, content, and creative services under one roof.',
	],
	'stretch-creative-solutions/ecommerce-content'         => [
		'title' => 'Ecommerce Content Services | Stretch Creative',
		'desc'  => 'Product descriptions, category pages, buying guides, and blogs that help shoppers find and choose your products—ecommerce content that drives sales.',
	],
	'stretch-creative-solutions/agency-content'            => [
		'title' => 'Agency Content Services | Stretch Creative',
		'desc'  => 'White-labeled content production for marketing agencies—scale your deliverables, meet deadlines, and keep quality high without growing your headcount.',
	],
	'stretch-creative-solutions/publisher-content'         => [
		'title' => 'Publisher Content Services | Stretch Creative',
		'desc'  => 'Editorial content at scale for publishers and media companies—search-optimized articles, evergreen features, and content updates readers will trust.',
	],
	'stretch-creative-solutions/demand-generation-content' => [
		'title' => 'Content Marketing & Demand Generation | Stretch Creative',
		'desc'  => 'Content marketing programs that generate real demand—strategy, SEO articles, lead magnets, and nurture content mapped to every stage of your funnel.',
	],
	'content-strategy'                                     => [
		'title' => 'Content Strategy Services | Stretch Creative',
		'desc'  => 'Keyword research, topic planning, editorial calendars, and content briefs—content strategy that connects your business goals to measurable search growth.',
	],
];

$set       = 0;
$unchanged = 0;
$missing   = 0;

foreach ( $pages as $path => $meta ) {
	$page = get_page_by_path( $path, OBJECT, 'page' );
	if ( ! $page ) {
		WP_CLI::warning( "Page not found: $path — skipped." );
		$missing++;
		continue;
	}

	$len = mb_strlen( $meta['desc'] );
	if ( $len < 140 || $len > 160 ) {
		WP_CLI::warning( "Description length $len (target 140-160) for $path." );
	}

	$changed  = false;
	$changed |= (bool) ( get_post_meta( $page->ID, $meta_title_key, true ) !== $meta['title'] && update_post_meta( $page->ID, $meta_title_key, $meta['title'] ) );
	$changed |= (bool) ( get_post_meta( $page->ID, $meta_desc_key, true ) !== $meta['desc'] && update_post_meta( $page->ID, $meta_desc_key, $meta['desc'] ) );

	if ( $changed ) {
		WP_CLI::log( sprintf( 'SET   page #%d %-52s (%d-char desc)', $page->ID, $path, $len ) );
		$set++;
	} else {
		WP_CLI::log( sprintf( 'OK    page #%d %-52s (already set)', $page->ID, $path ) );
		$unchanged++;
	}
}

// Keep the WP-default sample page out of search results until it is removed.
$sample = get_page_by_path( 'sample-page', OBJECT, 'page' );
if ( $sample && $is_rank_math ) {
	$robots = (array) get_post_meta( $sample->ID, 'rank_math_robots', true );
	if ( ! in_array( 'noindex', $robots, true ) ) {
		update_post_meta( $sample->ID, 'rank_math_robots', [ 'noindex' ] );
		WP_CLI::log( 'SET   page #' . $sample->ID . ' sample-page => noindex (WP default page, pending deletion).' );
	} else {
		WP_CLI::log( 'OK    page #' . $sample->ID . ' sample-page already noindex.' );
	}
}

// ---------------------------------------------------------------------------
// Blog category titles + descriptions (term meta). /blog/aeo/ is the AEO hub.
// ---------------------------------------------------------------------------

$categories = [
	'aeo'               => [
		'title' => 'Answer Engine Optimization (AEO): The Complete Guide | Stretch Creative',
		'desc'  => 'Your hub for Answer Engine Optimization—how AI answer engines pick sources, AEO vs. SEO, schema, E-E-A-T, measurement, and how to earn brand citations.',
	],
	'seo'               => [
		'title' => 'SEO Strategy, Tips & Best Practices | Stretch Creative Blog',
		'desc'  => 'SEO articles from the Stretch Creative team—technical SEO, keyword research, on-page optimization, and strategies that hold up as search keeps evolving.',
	],
	'content-marketing' => [
		'title' => 'Content Marketing Insights & Strategy | Stretch Creative Blog',
		'desc'  => 'Content marketing advice you can actually use—strategy, production, editorial quality, and distribution tactics that turn content into real growth.',
	],
	'ecommerce'         => [
		'title' => 'Ecommerce SEO & Content Tips | Stretch Creative Blog',
		'desc'  => 'Ecommerce marketing articles—product page SEO, category content, buying guides, and discovery tactics that help shoppers find and choose your brand.',
	],
	'creative-dojo'     => [
		'title' => 'The Creative Dojo: Design & Creative Inspiration | Stretch Creative',
		'desc'  => "Welcome to the Creative Dojo—design thinking, visual storytelling, and creative craft from the Stretch Creative studio to sharpen your brand's edge.",
	],
	'generative-ai'     => [
		'title' => 'Generative AI in Search & Content | Stretch Creative Blog',
		'desc'  => 'How generative AI is reshaping search and content—practical takes on AI answer engines, AI-assisted workflows, and staying visible as discovery changes.',
	],
	'video-content'     => [
		'title' => 'Video Content & Production Insights | Stretch Creative Blog',
		'desc'  => 'Video marketing articles—brand stories, production tips, and practical strategies for using video to explain, engage, and convert across every channel.',
	],
];

$term_set       = 0;
$term_unchanged = 0;

foreach ( $categories as $slug => $meta ) {
	$term = get_term_by( 'slug', $slug, 'category' );
	if ( ! $term ) {
		WP_CLI::warning( "Category not found: $slug — skipped." );
		$missing++;
		continue;
	}

	$len = mb_strlen( $meta['desc'] );
	if ( $len < 140 || $len > 160 ) {
		WP_CLI::warning( "Description length $len (target 140-160) for category $slug." );
	}

	if ( $is_rank_math ) {
		$changed  = false;
		$changed |= (bool) ( get_term_meta( $term->term_id, 'rank_math_title', true ) !== $meta['title'] && update_term_meta( $term->term_id, 'rank_math_title', $meta['title'] ) );
		$changed |= (bool) ( get_term_meta( $term->term_id, 'rank_math_description', true ) !== $meta['desc'] && update_term_meta( $term->term_id, 'rank_math_description', $meta['desc'] ) );
	} else {
		// Yoast stores taxonomy meta in a single option, not term meta.
		$tax_meta = (array) get_option( 'wpseo_taxonomy_meta', [] );
		$current  = $tax_meta['category'][ $term->term_id ] ?? [];
		$changed  = ( $current['wpseo_title'] ?? '' ) !== $meta['title'] || ( $current['wpseo_desc'] ?? '' ) !== $meta['desc'];
		if ( $changed ) {
			$tax_meta['category'][ $term->term_id ]['wpseo_title'] = $meta['title'];
			$tax_meta['category'][ $term->term_id ]['wpseo_desc']  = $meta['desc'];
			update_option( 'wpseo_taxonomy_meta', $tax_meta );
		}
	}

	if ( $changed ) {
		WP_CLI::log( sprintf( 'SET   term #%d %-20s (%d-char desc)', $term->term_id, $slug, $len ) );
		$term_set++;
	} else {
		WP_CLI::log( sprintf( 'OK    term #%d %-20s (already set)', $term->term_id, $slug ) );
		$term_unchanged++;
	}
}

// ---------------------------------------------------------------------------
// Flush rewrites so /sitemap_index.xml resolves immediately.
// ---------------------------------------------------------------------------

flush_rewrite_rules( false );
WP_CLI::log( 'Rewrite rules flushed (sitemap URLs active).' );

WP_CLI::success(
	sprintf(
		'SEO metadata seeded. Pages: %d set, %d unchanged. Categories: %d set, %d unchanged. Missing: %d.',
		$set,
		$unchanged,
		$term_set,
		$term_unchanged,
		$missing
	)
);
