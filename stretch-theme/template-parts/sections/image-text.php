<?php
/**
 * Section: Image + Text
 */
$sec      = stretch_section_classes();
$image    = get_sub_field('image');
$position = get_sub_field('image_position') ?: 'right';
$overline = get_sub_field('overline');
$heading  = get_sub_field('heading');
$body     = get_sub_field('body_content');
$cta      = get_sub_field('cta_button');
?>

<section class="<?php echo esc_attr($sec['class']); ?>"<?php echo $sec['id'] ? ' id="' . $sec['id'] . '"' : ''; ?><?php echo $sec['style'] ? ' style="' . $sec['style'] . '"' : ''; ?>>
  <div class="container">
    <div class="image-text-layout image-<?php echo esc_attr($position); ?> reveal">
      <div class="image-text-content">
        <?php if ($overline) : ?>
          <span class="overline"><?php echo esc_html($overline); ?></span>
        <?php endif; ?>

        <?php if ($heading) : ?>
          <h2><?php echo esc_html($heading); ?></h2>
        <?php endif; ?>

        <?php if ($body) : ?>
          <?php echo wp_kses_post($body); ?>
        <?php endif; ?>

        <?php if ($cta) : ?>
          <a href="<?php echo esc_url($cta['url']); ?>" class="btn-primary"<?php echo $cta['target'] ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo esc_html($cta['title']); ?></a>
        <?php endif; ?>
      </div>
      <div class="image-text-media">
        <?php if ($image) : ?>
          <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" loading="lazy">
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
