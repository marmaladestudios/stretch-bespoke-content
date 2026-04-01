<?php
/**
 * Template: 404 Not Found
 */
get_header();
?>

<section class="section-white page-404">
  <div class="container">
    <h1>404</h1>
    <h2><?php esc_html_e('Page Not Found', 'stretch'); ?></h2>
    <p style="max-width:480px;margin:20px auto 40px;"><?php esc_html_e("The page you're looking for doesn't exist or has been moved.", 'stretch'); ?></p>
    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-primary"><?php esc_html_e('Back to Home', 'stretch'); ?> &rarr;</a>
  </div>
</section>

<?php get_footer(); ?>
