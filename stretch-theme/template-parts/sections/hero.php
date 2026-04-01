<?php
/**
 * Section: Hero
 */
$overline   = get_sub_field('overline');
$headline   = get_sub_field('headline');
$accent     = get_sub_field('accent_text');
$subtitle   = get_sub_field('subtitle');
$supporting = get_sub_field('supporting_text');
$cta        = get_sub_field('cta_button');
$cta2       = get_sub_field('secondary_cta');
$bg_image   = get_sub_field('bg_image');
$bg_video   = get_sub_field('bg_video');
$shapes     = get_sub_field('show_shapes');

$style = $bg_image ? "background-image:url(" . esc_url($bg_image) . ");background-size:cover;background-position:center;" : '';
?>

<section class="hero" aria-label="<?php echo esc_attr($headline); ?>"<?php echo $style ? ' style="' . $style . '"' : ''; ?>>
  <?php if ($bg_video) : ?>
    <video class="hero-mesh" autoplay muted loop playsinline style="opacity:0.3;object-fit:cover;width:100%;height:100%;">
      <source src="<?php echo esc_url($bg_video); ?>" type="video/mp4">
    </video>
  <?php elseif (!$bg_image) : ?>
    <div class="hero-mesh"></div>
  <?php endif; ?>

  <?php if ($shapes) : ?>
    <div class="hero-shapes">
      <div class="shape shape-1"></div>
      <div class="shape shape-2"></div>
      <div class="shape shape-3"></div>
      <div class="shape shape-4"></div>
      <div class="shape shape-5"></div>
      <div class="shape shape-6"></div>
    </div>
  <?php endif; ?>

  <div class="container">
    <?php if ($overline) : ?>
      <span class="overline"><?php echo esc_html($overline); ?></span>
    <?php endif; ?>

    <h1>
      <?php
      if ($accent && str_contains($headline, $accent)) {
          echo wp_kses_post(str_replace($accent, '<span class="accent">' . esc_html($accent) . '</span>', esc_html($headline)));
      } else {
          echo esc_html($headline);
      }
      ?>
    </h1>

    <?php if ($subtitle) : ?>
      <p class="subtitle"><?php echo esc_html($subtitle); ?></p>
    <?php endif; ?>

    <?php if ($supporting) : ?>
      <p class="supporting"><?php echo esc_html($supporting); ?></p>
    <?php endif; ?>

    <?php if ($cta) : ?>
      <a href="<?php echo esc_url($cta['url']); ?>" class="btn-primary"<?php echo $cta['target'] ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo esc_html($cta['title']); ?></a>
    <?php endif; ?>

    <?php if ($cta2) : ?>
      <a href="<?php echo esc_url($cta2['url']); ?>" class="btn-white" style="margin-left:16px;"<?php echo $cta2['target'] ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo esc_html($cta2['title']); ?></a>
    <?php endif; ?>
  </div>
</section>
<div class="hero-accent-bar"></div>
