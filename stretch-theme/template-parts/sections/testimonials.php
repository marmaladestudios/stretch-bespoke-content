<?php
/**
 * Section: Testimonials Carousel
 */
$sec          = stretch_section_classes();
$testimonials = get_sub_field('testimonials');
?>

<section class="<?php echo esc_attr($sec['class']); ?>"<?php echo $sec['id'] ? ' id="' . $sec['id'] . '"' : ''; ?><?php echo $sec['style'] ? ' style="' . $sec['style'] . '"' : ''; ?>>
  <div class="container">
    <?php if ($testimonials) : ?>
      <div class="testimonials-carousel reveal" aria-label="<?php esc_attr_e('Testimonials', 'stretch'); ?>">
        <div class="testimonials-track">
          <?php foreach ($testimonials as $t) : ?>
            <div class="testimonial-slide">
              <?php if ($t['photo']) : ?>
                <div class="testimonial-photo">
                  <img src="<?php echo esc_url($t['photo']['sizes']['thumbnail']); ?>" alt="<?php echo esc_attr($t['name']); ?>" loading="lazy">
                </div>
              <?php endif; ?>
              <blockquote class="testimonial-quote">&ldquo;<?php echo esc_html($t['quote']); ?>&rdquo;</blockquote>
              <div class="testimonial-author"><?php echo esc_html($t['name']); ?></div>
              <?php if ($t['title'] || $t['company']) : ?>
                <div class="testimonial-role">
                  <?php echo esc_html(implode(', ', array_filter([$t['title'], $t['company']]))); ?>
                </div>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
        <div class="testimonials-dots" role="tablist" aria-label="<?php esc_attr_e('Testimonial navigation', 'stretch'); ?>">
          <?php foreach ($testimonials as $i => $t) : ?>
            <button class="testimonials-dot<?php echo $i === 0 ? ' active' : ''; ?>" role="tab" aria-label="<?php printf(esc_attr__('Testimonial %d', 'stretch'), $i + 1); ?>"></button>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>
