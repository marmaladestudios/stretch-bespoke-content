<?php
/**
 * Section: Content Block
 */
$sec       = stretch_section_classes();
$overline  = get_sub_field('overline');
$heading   = get_sub_field('heading');
$body      = get_sub_field('body_content');
$highlight = get_sub_field('pull_highlight');
$width     = get_sub_field('max_width') ?: 'normal';
?>

<section class="<?php echo esc_attr($sec['class']); ?>"<?php echo $sec['id'] ? ' id="' . $sec['id'] . '"' : ''; ?><?php echo $sec['style'] ? ' style="' . $sec['style'] . '"' : ''; ?>>
  <div class="container">
    <?php if ($overline) : ?>
      <span class="overline reveal"><?php echo esc_html($overline); ?></span>
    <?php endif; ?>

    <?php if ($heading) : ?>
      <h2 class="reveal"><?php echo esc_html($heading); ?></h2>
    <?php endif; ?>

    <div class="body-content<?php echo $width === 'wide' ? ' wide' : ''; ?>">
      <?php if ($body) : ?>
        <div class="reveal"><?php echo wp_kses_post($body); ?></div>
      <?php endif; ?>

      <?php if ($highlight) : ?>
        <div class="pull-highlight reveal"><?php echo esc_html($highlight); ?></div>
      <?php endif; ?>
    </div>
  </div>
</section>
