<?php
if (!defined('WP_CLI') || !WP_CLI) exit;
/**
 * AUD-014 — Sideload the hotlinked Unsplash images used by the live
 * Home (Who We Serve) and About (story) templates into the media library,
 * then record the attachment IDs in the `stretch_page_images` option.
 *
 * Run via WP-CLI only:
 *   wp eval-file setup-page-images.php
 *
 * Idempotent: attachments are deduped by a `_stretch_source_url` meta key,
 * so re-running never creates duplicates — it just refreshes the option.
 *
 * Templates (page-home.php / page-about.php) read the option and render via
 * wp_get_attachment_image(); they fall back to the original Unsplash URL when
 * a key is missing, so running this script is safe at any point.
 */

require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

/**
 * The 5 live hotlinked images (page-home.php Who We Serve ×4, page-about.php story ×1).
 * Keys are the option keys the templates read.
 */
$stretch_page_image_sources = [
    'home_ecommerce' => [
        'url'   => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=600&h=400&fit=crop',
        'title' => 'home-who-we-serve-ecommerce',
        'alt'   => 'Ecommerce',
    ],
    'home_agencies' => [
        'url'   => 'https://images.unsplash.com/photo-1600880292203-757bb62b4baf?w=600&h=400&fit=crop',
        'title' => 'home-who-we-serve-agencies',
        'alt'   => 'Agencies and strategic partners',
    ],
    'home_service_providers' => [
        'url'   => 'https://images.unsplash.com/photo-1521791136064-7986c2920216?w=600&h=400&fit=crop',
        'title' => 'home-who-we-serve-local-service-providers',
        'alt'   => 'Local service providers',
    ],
    'home_saas' => [
        'url'   => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=600&h=400&fit=crop',
        'title' => 'home-who-we-serve-saas',
        'alt'   => 'SaaS and digital platforms',
    ],
    'about_team' => [
        'url'   => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&h=600&fit=crop',
        'title' => 'about-story-team-collaboration',
        'alt'   => 'Team collaboration at Stretch Creative',
    ],
    // Contact page location card — brand-toned dark static map of Victoria, BC
    // (CARTO Dark Matter / OpenStreetMap tiles, z12, ~48.4284,-123.3656). The
    // URL is a stable dedupe token only; the bundled page-images/contact_map.jpg
    // is always used (no runtime tile/API requests). Attribution is baked into
    // the image ("© OpenStreetMap contributors  © CARTO").
    'contact_map' => [
        'url'   => 'https://assets.stretchcreative.co/page-images/contact-map-victoria-bc.jpg',
        'title' => 'contact-map-victoria-bc',
        'alt'   => 'Map of Victoria, BC — Stretch Creative location',
    ],
];

/**
 * Find an attachment previously sideloaded from $url (deduped via meta),
 * or sideload it now. Returns attachment ID or 0 on failure.
 */
function stretch_page_image_sideload($url, $title, $alt, $bundle_key = '') {
    // Dedupe: was this exact source URL already imported by this script?
    $existing = get_posts([
        'post_type'   => 'attachment',
        'post_status' => 'any',
        'numberposts' => 1,
        'fields'      => 'ids',
        'meta_key'    => '_stretch_source_url',
        'meta_value'  => $url,
    ]);
    if (!empty($existing)) {
        $id = (int) $existing[0];
        WP_CLI::log("  ✓ Already imported '{$title}' (attachment {$id}) — skipping download");
        return $id;
    }

    $tmp = null;

    // Prefer the repo-bundled file (Unsplash is unreachable from Render egress).
    if (!empty($bundle_key)) {
        $bundle_dirs = ['/opt/page-images', dirname(ABSPATH) . '/page-images'];
        foreach ($bundle_dirs as $dir) {
            foreach (['jpg', 'jpeg', 'png', 'webp'] as $try_ext) {
                $local = $dir . '/' . $bundle_key . '.' . $try_ext;
                if (file_exists($local)) {
                    $tmp_copy = wp_tempnam($bundle_key . '.' . $try_ext);
                    if ($tmp_copy && copy($local, $tmp_copy)) {
                        WP_CLI::log("  ✓ Using bundled file for '{$bundle_key}' ({$local})");
                        $tmp = $tmp_copy;
                        break 2;
                    }
                }
            }
        }
    }

    if (empty($tmp)) {
        $tmp = download_url($url, 60);
        if (is_wp_error($tmp)) {
            // One retry — the first production run failed on transient network
            // contention during a crash-loop window and never got another chance.
            WP_CLI::log("  … download failed ({$tmp->get_error_message()}), retrying once");
            sleep(2);
            $tmp = download_url($url, 60);
        }
        if (is_wp_error($tmp)) {
            WP_CLI::warning("Failed to download {$url}: " . $tmp->get_error_message());
            return 0;
        }
    }

    // Unsplash URLs carry no file extension — derive one from the real mime type.
    $mime_map = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
        'image/gif'  => 'gif',
        'image/avif' => 'avif',
    ];
    $mime = function_exists('wp_get_image_mime') ? wp_get_image_mime($tmp) : false;
    $ext  = ($mime && isset($mime_map[$mime])) ? $mime_map[$mime] : 'jpg';

    $file_array = [
        'name'     => sanitize_title($title) . '.' . $ext,
        'tmp_name' => $tmp,
    ];

    $attachment_id = media_handle_sideload($file_array, 0, $title);
    if (is_wp_error($attachment_id)) {
        @unlink($tmp);
        WP_CLI::warning("Failed to sideload '{$title}': " . $attachment_id->get_error_message());
        return 0;
    }

    update_post_meta($attachment_id, '_stretch_source_url', $url);
    update_post_meta($attachment_id, '_wp_attachment_image_alt', $alt);

    WP_CLI::log("  + Imported '{$title}' (attachment {$attachment_id})");
    return (int) $attachment_id;
}

WP_CLI::log('=== AUD-014: Sideloading page images (Home Who-We-Serve ×4, About story ×1) ===');

$option  = get_option('stretch_page_images', []);
$option  = is_array($option) ? $option : [];
$before  = $option;
$failed  = 0;

foreach ($stretch_page_image_sources as $key => $src) {
    // If the option already points at a real image attachment, keep it.
    $current = isset($option[$key]) ? (int) $option[$key] : 0;
    if ($current && wp_attachment_is_image($current)) {
        WP_CLI::log("  ✓ '{$key}' already set (attachment {$current}) — no-op");
        continue;
    }

    $id = stretch_page_image_sideload($src['url'], $src['title'], $src['alt'], $key);
    if ($id) {
        $option[$key] = $id;
    } else {
        $failed++;
    }
}

if ($option !== $before) {
    update_option('stretch_page_images', $option, true);
    WP_CLI::log('Updated option stretch_page_images: ' . wp_json_encode($option));
} else {
    WP_CLI::log('Option stretch_page_images unchanged: ' . wp_json_encode($option));
}

/* ============================================================
 * AUD-014b — Solution + Industry page image slots.
 *
 * Fills the intro/process editorial photos on the Solutions
 * (page-service.php) pages and the "Challenges" photo + Work-Gallery
 * tiles on the Industry (page-industry.php) pages. Uses the same
 * sideload/dedupe/bundle path as above; the resulting attachment IDs are
 * written into the per-page options seeded by setup-services.php and
 * setup-industries.php (both run earlier in the entrypoint SEED_SCRIPTS),
 * so writing IDs into them here is safe.
 *
 * Sources: the 6 challenge/intro/process images are client-approved
 * Unsplash stock; the 3 ecommerce gallery tiles are real Stretch portfolio
 * shots exported from the media library into page-images/ so prod and local
 * converge through the bundle (Render cannot fetch the library file at boot).
 *
 * Idempotent: attachments dedupe by _stretch_source_url; each option field
 * is only rewritten when its value actually changes.
 * ============================================================ */
WP_CLI::log('=== AUD-014b: Sideloading Solution + Industry slot images ===');

$stretch_slot_sources = [
    // --- Per-page solution INTRO photos (one per solution page) ---
    'solution-intro-editorial-workspace' => [
        'url'   => 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?w=1600&q=80&fit=crop',
        'title' => 'solution-intro-editorial-workspace',
        'alt'   => 'Editorial content workspace with a laptop, notebook and coffee',
    ],
    'solution-intro-seo-analytics' => [
        'url'   => 'https://images.unsplash.com/photo-1504868584819-f8e8b4b6d7e3?w=1600&q=80&fit=crop',
        'title' => 'solution-intro-seo-analytics',
        'alt'   => 'Laptop displaying a search and audience analytics dashboard',
    ],
    'solution-intro-paid-media-planning' => [
        'url'   => 'https://images.unsplash.com/photo-1533750516457-a7f992034fec?w=1600&q=80&fit=crop',
        'title' => 'solution-intro-paid-media-planning',
        'alt'   => 'Marketer planning an advertising campaign at a desk with notes and a laptop',
    ],
    'solution-intro-visual-design-studio' => [
        'url'   => 'https://images.unsplash.com/photo-1626785774573-4b799315345d?w=1600&q=80&fit=crop',
        'title' => 'solution-intro-visual-design-studio',
        'alt'   => 'Creative design studio desk with design software, tablet and a graphic design book',
    ],
    // --- Per-page solution PROCESS photos ---
    'solution-process-team-collaboration' => [
        'url'   => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=1600&q=80&fit=crop',
        'title' => 'solution-process-team-collaboration',
        'alt'   => 'Content team collaborating around a table of laptops',
    ],
    // Round 2 #19: replaced the ubiquitous "hands sketching a wireframe by a laptop"
    // stock shot (photo-1454165804606) Cole flagged as a duplicate. New image is a
    // site-architecture / journey-mapping board — distinct from the SEO intro's
    // analytics-dashboard photo and from every meeting/planning shot on the site.
    'solution-process-seo-strategy' => [
        'url'   => 'https://images.unsplash.com/photo-1531403009284-440f080d1e12?w=1600&q=80&fit=crop',
        'title' => 'solution-process-seo-strategy',
        'alt'   => 'Mapping out a site architecture and user journey on a planning board',
    ],
    'solution-process-paid-campaign' => [
        'url'   => 'https://images.unsplash.com/photo-1553484771-371a605b060b?w=1600&q=80&fit=crop',
        'title' => 'solution-process-paid-campaign',
        'alt'   => 'Reviewing a marketing strategy framework while planning a campaign',
    ],
    'industry-ecommerce-storefront' => [
        'url'   => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=1600&q=80&fit=crop',
        'title' => 'industry-ecommerce-storefront',
        'alt'   => 'Curated retail storefront display of apparel and accessories',
    ],
    'industry-agencies-team-meeting' => [
        'url'   => 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=1600&q=80&fit=crop',
        'title' => 'industry-agencies-team-meeting',
        'alt'   => 'Marketing agency team planning a campaign with sticky notes',
    ],
    'industry-service-providers-tradesperson' => [
        'url'   => 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=1600&q=80&fit=crop',
        'title' => 'industry-service-providers-tradesperson',
        'alt'   => 'Local service tradesperson working on-site in a hard hat',
    ],
    'industry-saas-analytics-dashboard' => [
        'url'   => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=1600&q=80&fit=crop',
        'title' => 'industry-saas-analytics-dashboard',
        'alt'   => 'SaaS product analytics dashboard on a laptop screen',
    ],
    // Real Stretch portfolio work — bundled from the media library (see page-images/).
    // The URLs are stable dedupe tokens only; the bundled file is always used.
    'ecommerce-gallery-product-photography' => [
        'url'   => 'https://assets.stretchcreative.co/portfolio/ecommerce-gallery-product-photography.jpg',
        'title' => 'ecommerce-gallery-product-photography',
        'alt'   => 'Styled product photography flat lay for an ecommerce brand',
    ],
    // Round 2 #22: the "Lifestyle & Social" tile now holds the Reef surf-barrel
    // social-content shot (moved up from the campaign tile); the Meyer's lilac
    // flat-lay it previously held was product photography (already covered by tile 1)
    // and has been retired. The bundle file page-images/ecommerce-gallery-lifestyle-social.jpg
    // now contains the surf image; the URL token is bumped so the sideloader
    // re-imports the new file instead of returning the retired attachment.
    'ecommerce-gallery-lifestyle-social' => [
        'url'   => 'https://assets.stretchcreative.co/portfolio/reef-surf-barrel-social-content.jpg',
        'title' => 'ecommerce-gallery-lifestyle-social',
        'alt'   => 'Surfer riding inside a wave barrel — Reef lifestyle social content',
    ],
    // Round 2 #22: the "Campaign Creative" tile now holds a real Stretch campaign
    // piece — the Monster Energy X Games Aspen social ad (branded step-and-repeat
    // shoot) — replacing the surf image, which read as lifestyle, not campaign.
    // Bundle file page-images/ecommerce-gallery-campaign-creative.jpg now contains
    // the Monster Energy shot; URL token bumped to force a fresh re-import.
    'ecommerce-gallery-campaign-creative' => [
        'url'   => 'https://assets.stretchcreative.co/portfolio/monster-energy-x-games-aspen-social-ad.jpg',
        'title' => 'ecommerce-gallery-campaign-creative',
        'alt'   => 'Monster Energy athlete at the X Games Aspen branded backdrop — campaign creative',
    ],
];

$slot_ids = [];
foreach ($stretch_slot_sources as $key => $src) {
    $id = stretch_page_image_sideload($src['url'], $src['title'], $src['alt'], $key);
    if ($id) {
        $slot_ids[$key] = $id;
    } else {
        $failed++;
    }
}

/** Set $arr[$field] = $id only when it differs. Returns true if it changed. */
if (!function_exists('stretch_slot_set')) {
    function stretch_slot_set(&$arr, $field, $id) {
        if (!$id) { return false; }
        $current = isset($arr[$field]) ? (int) $arr[$field] : 0;
        if ($current === (int) $id) { return false; }
        $arr[$field] = (int) $id;
        return true;
    }
}

// --- Solution pages: intro_image + process_image (only where the slot renders) ---
$service_slot_map = [
    // Each solution page gets a contextually distinct intro; process photos are
    // differentiated where a strong, brand-/face-clean stock image exists.
    'content-writing-at-any-scale'  => ['intro_image' => 'solution-intro-editorial-workspace',  'process_image' => 'solution-process-team-collaboration'],
    'seo_content_strategy_services' => ['intro_image' => 'solution-intro-seo-analytics',        'process_image' => 'solution-process-seo-strategy'],
    'paid-advertising'              => ['intro_image' => 'solution-intro-paid-media-planning',  'process_image' => 'solution-process-paid-campaign'],
    'visual-content-and-design'     => ['intro_image' => 'solution-intro-visual-design-studio'], // no process section (no process steps)
];
foreach ($service_slot_map as $slug => $fields) {
    $opt = get_option('stretch_service_' . $slug, null);
    if (!is_array($opt)) {
        WP_CLI::log("  … stretch_service_{$slug} option missing — skipping");
        continue;
    }
    $changed = false;
    foreach ($fields as $field => $bkey) {
        if (isset($slot_ids[$bkey]) && stretch_slot_set($opt, $field, $slot_ids[$bkey])) { $changed = true; }
    }
    if ($changed) {
        update_option('stretch_service_' . $slug, $opt, false);
        WP_CLI::log("  ↳ Wired image slots into stretch_service_{$slug}");
    } else {
        WP_CLI::log("  ✓ stretch_service_{$slug} image slots already set — no-op");
    }
}

// --- Industry pages: challenges_photo (+ ecommerce Work-Gallery tiles) ---
$industry_challenge_map = [
    'ecommerce'         => 'industry-ecommerce-storefront',
    'agencies'          => 'industry-agencies-team-meeting',
    'service-providers' => 'industry-service-providers-tradesperson',
    'saas'              => 'industry-saas-analytics-dashboard',
];
$ecommerce_gallery_map = [
    0 => 'ecommerce-gallery-product-photography', // "Product Photography" tile
    1 => 'ecommerce-gallery-lifestyle-social',    // "Lifestyle & Social" tile
    2 => 'ecommerce-gallery-campaign-creative',   // "Campaign Creative" tile
];
foreach ($industry_challenge_map as $slug => $bkey) {
    $opt = get_option('stretch_industry_' . $slug, null);
    if (!is_array($opt)) {
        WP_CLI::log("  … stretch_industry_{$slug} option missing — skipping");
        continue;
    }
    $changed = false;
    if (isset($slot_ids[$bkey]) && stretch_slot_set($opt, 'challenges_photo', $slot_ids[$bkey])) { $changed = true; }
    if ($slug === 'ecommerce' && !empty($opt['gallery']) && is_array($opt['gallery'])) {
        foreach ($ecommerce_gallery_map as $i => $gkey) {
            if (isset($opt['gallery'][$i]) && is_array($opt['gallery'][$i]) && isset($slot_ids[$gkey])) {
                if (stretch_slot_set($opt['gallery'][$i], 'image', $slot_ids[$gkey])) { $changed = true; }
            }
        }
    }
    if ($changed) {
        update_option('stretch_industry_' . $slug, $opt, false);
        WP_CLI::log("  ↳ Wired image slots into stretch_industry_{$slug}");
    } else {
        WP_CLI::log("  ✓ stretch_industry_{$slug} image slots already set — no-op");
    }
}

if ($failed) {
    // Exit non-zero so the deploy seed gate does NOT record this run as complete
    // and retries on the next boot (all seeds are idempotent no-ops once done).
    // A plain warning here previously let a transient failure seal the gate with
    // Unsplash fallbacks still live on the homepage.
    WP_CLI::error("{$failed} image(s) could not be imported — templates keep their Unsplash fallback; seed will retry next boot.");
} else {
    WP_CLI::success('All page images are local attachments.');
}
