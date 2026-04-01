<?php
/**
 * Section: Card Grid
 */
$sec      = stretch_section_classes();
$overline = get_sub_field('overline');
$heading  = get_sub_field('heading');
$columns  = get_sub_field('columns') ?: '3';
$featured = get_sub_field('featured_first');
$cards    = get_sub_field('cards');
?>

<section class="<?php echo esc_attr($sec['class']); ?>"<?php echo $sec['id'] ? ' id="' . $sec['id'] . '"' : ''; ?><?php echo $sec['style'] ? ' style="' . $sec['style'] . '"' : ''; ?>>
  <div class="container">
    <?php if ($overline) : ?>
      <span class="overline reveal"><?php echo esc_html($overline); ?></span>
    <?php endif; ?>

    <?php if ($heading) : ?>
      <h2 class="reveal"><?php echo esc_html($heading); ?></h2>
    <?php endif; ?>

    <?php if ($cards) : ?>
      <div class="features-grid cols-<?php echo esc_attr($columns); ?>">
        <?php foreach ($cards as $i => $card) :
          $is_featured = ($featured && $i === 0);
          $delay = min($i + 1, 6);
        ?>
          <?php if ($is_featured) : ?>
            <div class="feature-card-featured reveal">
              <div>
                <?php if ($card['tag_label']) : ?>
                  <div class="featured-tag"><?php echo esc_html($card['tag_label']); ?></div>
                <?php endif; ?>
                <h3><?php echo esc_html($card['title']); ?></h3>
                <?php if ($card['description']) : ?>
                  <p><?php echo wp_kses_post(nl2br(esc_html($card['description']))); ?></p>
                <?php endif; ?>
              </div>
              <div>
                <?php if ($card['icon']) : ?>
                  <div class="feature-icon"><?php echo wp_get_attachment_image($card['icon']['ID'], 'medium'); ?></div>
                <?php elseif ($card['svg_code']) : ?>
                  <div class="feature-icon"><?php echo $card['svg_code']; ?></div>
                <?php endif; ?>
              </div>
            </div>
          <?php else : ?>
            <div class="feature-card reveal reveal-delay-<?php echo esc_attr($delay); ?>">
              <?php if ($card['icon']) : ?>
                <div class="feature-icon"><?php echo wp_get_attachment_image($card['icon']['ID'], 'thumbnail'); ?></div>
              <?php elseif ($card['svg_code']) : ?>
                <div class="feature-icon"><?php echo $card['svg_code']; ?></div>
              <?php endif; ?>
              <h3><?php echo esc_html($card['title']); ?></h3>
              <?php if ($card['description']) : ?>
                <p><?php echo esc_html($card['description']); ?></p>
              <?php endif; ?>
              <?php if ($card['link']) : ?>
                <a href="<?php echo esc_url($card['link']['url']); ?>" class="blog-card-readmore"<?php echo $card['link']['target'] ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo esc_html($card['link']['title']); ?> &rarr;</a>
              <?php endif; ?>
            </div>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
