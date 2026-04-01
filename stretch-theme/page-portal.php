<?php
/**
 * Template Name: Client Portal
 * Template Post Type: page
 *
 * Minimal full-width template for future client portal features.
 * No sidebar, simplified header.
 */
get_header();
?>

<section class="section-white" style="padding-top:120px;min-height:60vh;">
  <div class="container">
    <?php
    if (is_user_logged_in()) {
        while (have_posts()) {
            the_post();
            the_content();
        }
    } else {
        ?>
        <div style="text-align:center;padding:60px 0;">
          <h2><?php esc_html_e('Client Portal', 'stretch'); ?></h2>
          <p><?php esc_html_e('Please log in to access your dashboard.', 'stretch'); ?></p>
          <?php wp_login_form(); ?>
        </div>
        <?php
    }
    ?>
  </div>
</section>

<?php get_footer(); ?>
