<?php
/**
 * Template: Homepage
 * Respects page template selection; falls back to ACF Flexible Content.
 */
$page_template = get_page_template_slug();
if ($page_template && $page_template !== 'front-page.php' && locate_template($page_template)) {
    include locate_template($page_template);
    return;
}

get_header();
stretch_render_sections();
get_footer();
