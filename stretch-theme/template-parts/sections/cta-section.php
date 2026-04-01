<?php
/**
 * Section: CTA Section
 */
$heading   = get_sub_field('heading');
$body      = get_sub_field('body_text');
$cta       = get_sub_field('cta_button');
$cta2      = get_sub_field('secondary_button');
$bg_style  = get_sub_field('bg_style') ?: 'purple';
$custom_bg = get_sub_field('custom_bg_color');

$class = 'cta-close';
$style = '';
if ($bg_style === 'dark') {
    $style = 'background:var(--color-dark);';
} elseif ($bg_style === 'custom' && $custom_bg) {
    $style = 'background:' . esc_attr($custom_bg) . ';';
}
?>

<section class="<?php echo esc_attr($class); ?>"<?php echo $style ? ' style="' . $style . '"' : ''; ?>>
  <div class="container">
    <h2 class="reveal"><?php echo wp_kses_post($heading); ?></h2>

    <?php if ($body) : ?>
      <p class="reveal"><?php echo esc_html($body); ?></p>
    <?php endif; ?>

    <?php if ($cta) : ?>
      <a href="<?php echo esc_url($cta['url']); ?>" class="btn-white reveal"<?php echo $cta['target'] ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo esc_html($cta['title']); ?></a>
    <?php endif; ?>

    <?php if ($cta2) : ?>
      <a href="<?php echo esc_url($cta2['url']); ?>" class="btn-primary reveal" style="margin-left:16px;"<?php echo $cta2['target'] ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo esc_html($cta2['title']); ?></a>
    <?php endif; ?>
  </div>
</section>
