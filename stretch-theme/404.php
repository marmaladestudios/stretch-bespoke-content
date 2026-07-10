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

    <nav class="helpful-links" aria-label="<?php esc_attr_e('Helpful links', 'stretch'); ?>">
      <p><?php esc_html_e('Or try one of these:', 'stretch'); ?></p>
      <ul>
        <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'stretch'); ?></a></li>
        <li><a href="<?php echo esc_url(home_url('/blog/')); ?>"><?php esc_html_e('Blog', 'stretch'); ?></a></li>
        <li><a href="<?php echo esc_url(home_url('/services/')); ?>"><?php esc_html_e('Services', 'stretch'); ?></a></li>
        <li><a href="<?php echo esc_url(home_url('/contact-stretch-creative/')); ?>"><?php esc_html_e('Contact', 'stretch'); ?></a></li>
      </ul>
    </nav>
  </div>
</section>

<?php get_footer(); ?>
