<?php
/**
 * Section: Logo Carousel
 */
$sec        = stretch_section_classes();
$heading    = get_sub_field('heading');
$subheading = get_sub_field('subheading');
$logos      = get_sub_field('logos');
?>

<section class="<?php echo esc_attr($sec['class']); ?>"<?php echo $sec['id'] ? ' id="' . $sec['id'] . '"' : ''; ?><?php echo $sec['style'] ? ' style="' . $sec['style'] . '"' : ''; ?>>
  <div class="container" style="text-align:center;">
    <?php if ($heading) : ?>
      <h2 class="reveal"><?php echo esc_html($heading); ?></h2>
    <?php endif; ?>
    <?php if ($subheading) : ?>
      <p class="reveal"><?php echo esc_html($subheading); ?></p>
    <?php endif; ?>

    <?php if ($logos) : ?>
      <div class="logo-carousel reveal">
        <?php foreach ($logos as $logo) : ?>
          <?php if ($logo['logo_image']) : ?>
            <img
              src="<?php echo esc_url($logo['logo_image']['url']); ?>"
              alt="<?php echo esc_attr($logo['company_name'] ?: $logo['logo_image']['alt']); ?>"
              loading="lazy"
            >
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
