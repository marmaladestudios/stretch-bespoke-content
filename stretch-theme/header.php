<?php
/**
 * Header template — fixed nav with scroll behavior, mobile toggle.
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-to-content" href="#main-content"><?php esc_html_e('Skip to content', 'stretch'); ?></a>

<nav class="site-nav" id="siteNav" role="navigation" aria-label="<?php esc_attr_e('Main navigation', 'stretch'); ?>">
  <div class="container">
    <?php if (has_custom_logo()) : ?>
      <a href="<?php echo esc_url(home_url('/')); ?>" class="logo" aria-label="<?php esc_attr_e('Home', 'stretch'); ?>">
        <?php
        $logo_id = get_theme_mod('custom_logo');
        echo wp_get_attachment_image($logo_id, 'full');
        ?>
      </a>
    <?php else : ?>
      <a href="<?php echo esc_url(home_url('/')); ?>" class="logo" aria-label="<?php esc_attr_e('Home', 'stretch'); ?>">
        <span style="font-family:'Montserrat',sans-serif;font-size:28px;font-weight:700;color:#fff;letter-spacing:-1px;"><?php bloginfo('name'); ?></span>
      </a>
    <?php endif; ?>

    <button class="nav-toggle" aria-label="<?php esc_attr_e('Toggle navigation', 'stretch'); ?>" aria-expanded="false" aria-controls="primaryMenu">
      <span></span><span></span><span></span>
    </button>

    <?php if (has_nav_menu('primary')) : ?>
      <?php
      wp_nav_menu([
          'theme_location' => 'primary',
          'container'       => false,
          'menu_class'      => 'nav-links',
          'menu_id'         => 'primaryMenu',
          'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
          'depth'           => 2,
      ]);
      ?>
    <?php endif; ?>

    <?php if (is_user_logged_in() && current_user_can('stretch_client')) : ?>
      <a href="<?php echo esc_url(home_url('/portal/')); ?>" class="btn-primary nav-cta"><?php esc_html_e('Dashboard', 'stretch'); ?></a>
    <?php endif; ?>
  </div>
</nav>

<main id="main-content">
