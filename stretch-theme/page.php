<?php
/**
 * Template: Standard Page
 * Uses ACF Flexible Content to render page sections.
 * Falls back to standard content if no ACF sections exist.
 */
get_header();

if (function_exists('have_rows') && have_rows('page_sections')) {
    stretch_render_sections();
} else {
    ?>
    <section class="section-white" style="padding-top:160px;">
      <div class="container">
        <div class="body-content">
          <?php
          while (have_posts()) {
              the_post();
              the_content();
          }
          ?>
        </div>
      </div>
    </section>
    <?php
}

get_footer();
