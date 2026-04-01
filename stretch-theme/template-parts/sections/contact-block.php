<?php
/**
 * Section: Contact Block
 */
$sec     = stretch_section_classes();
$heading = get_sub_field('heading');
$address = get_sub_field('address');
$phone   = get_sub_field('phone');
$email   = get_sub_field('email');
$social  = get_sub_field('social_links');
$form    = get_sub_field('form_shortcode');
$layout  = get_sub_field('layout') ?: 'form-right';
?>

<section class="<?php echo esc_attr($sec['class']); ?>"<?php echo $sec['id'] ? ' id="' . $sec['id'] . '"' : ''; ?><?php echo $sec['style'] ? ' style="' . $sec['style'] . '"' : ''; ?>>
  <div class="container">
    <?php if ($heading) : ?>
      <h2 class="reveal"><?php echo esc_html($heading); ?></h2>
    <?php endif; ?>

    <div class="contact-layout <?php echo esc_attr($layout); ?> reveal">
      <div class="contact-info">
        <?php if ($address) : ?>
          <address><?php echo wp_kses_post(nl2br(esc_html($address))); ?></address>
        <?php endif; ?>

        <?php if ($phone) : ?>
          <p><a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a></p>
        <?php endif; ?>

        <?php if ($email) : ?>
          <p><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></p>
        <?php endif; ?>

        <?php if ($social) : ?>
          <div class="contact-social">
            <?php foreach ($social as $s) : ?>
              <a href="<?php echo esc_url($s['url']); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr($s['platform']); ?>">
                <?php echo esc_html($s['platform']); ?>
              </a>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

      <div class="contact-form">
        <?php if ($form) : ?>
          <?php echo do_shortcode($form); ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
