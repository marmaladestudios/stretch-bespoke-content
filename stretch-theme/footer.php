<?php
/**
 * Footer template — multi-column with menus.
 */
?>
</main>

<footer class="site-footer" role="contentinfo">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <?php if (has_custom_logo()) : ?>
          <div class="logo">
            <?php
            $logo_id = get_theme_mod('custom_logo');
            echo wp_get_attachment_image($logo_id, 'full');
            ?>
          </div>
        <?php else : ?>
          <div class="logo">
            <span style="font-family:'Montserrat',sans-serif;font-size:26px;font-weight:700;color:#fff;"><?php bloginfo('name'); ?></span>
          </div>
        <?php endif; ?>
        <p><?php echo esc_html(get_theme_mod('stretch_footer_tagline', 'The trusted partner for producing publish-ready content at scale — your story, your voice, on time.')); ?></p>
      </div>

      <?php if (has_nav_menu('footer-1')) : ?>
        <div class="footer-col">
          <h4><?php echo esc_html(wp_get_nav_menu_name('footer-1')); ?></h4>
          <?php wp_nav_menu(['theme_location' => 'footer-1', 'container' => false, 'menu_class' => '', 'depth' => 1]); ?>
        </div>
      <?php endif; ?>

      <?php if (has_nav_menu('footer-2')) : ?>
        <div class="footer-col">
          <h4><?php echo esc_html(wp_get_nav_menu_name('footer-2')); ?></h4>
          <?php wp_nav_menu(['theme_location' => 'footer-2', 'container' => false, 'menu_class' => '', 'depth' => 1]); ?>
        </div>
      <?php endif; ?>

      <?php if (has_nav_menu('footer-3')) : ?>
        <div class="footer-col">
          <h4><?php echo esc_html(wp_get_nav_menu_name('footer-3')); ?></h4>
          <?php wp_nav_menu(['theme_location' => 'footer-3', 'container' => false, 'menu_class' => '', 'depth' => 1]); ?>
        </div>
      <?php endif; ?>
    </div>

    <div class="footer-bottom">
      <?php echo wp_kses_post(get_theme_mod('stretch_footer_copyright', '&copy; Copyright ' . date('Y') . ' Stretch Creative')); ?>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
