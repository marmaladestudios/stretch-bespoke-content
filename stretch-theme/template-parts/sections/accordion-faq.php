<?php
/**
 * Section: Accordion / FAQ
 */
$sec     = stretch_section_classes();
$heading = get_sub_field('heading');
$items   = get_sub_field('items');
$uid     = 'faq-' . uniqid();
?>

<section class="<?php echo esc_attr($sec['class']); ?>"<?php echo $sec['id'] ? ' id="' . $sec['id'] . '"' : ''; ?><?php echo $sec['style'] ? ' style="' . $sec['style'] . '"' : ''; ?>>
  <div class="container">
    <?php if ($heading) : ?>
      <h2 class="reveal"><?php echo esc_html($heading); ?></h2>
    <?php endif; ?>

    <?php if ($items) : ?>
      <div class="body-content">
        <?php foreach ($items as $i => $item) :
          $panel_id = $uid . '-panel-' . $i;
          $trigger_id = $uid . '-trigger-' . $i;
        ?>
          <div class="accordion-item reveal">
            <button
              class="accordion-trigger"
              id="<?php echo esc_attr($trigger_id); ?>"
              aria-expanded="false"
              aria-controls="<?php echo esc_attr($panel_id); ?>"
            >
              <?php echo esc_html($item['question']); ?>
              <span class="accordion-icon" aria-hidden="true"></span>
            </button>
            <div
              class="accordion-panel"
              id="<?php echo esc_attr($panel_id); ?>"
              role="region"
              aria-labelledby="<?php echo esc_attr($trigger_id); ?>"
            >
              <div class="accordion-panel-inner">
                <?php echo wp_kses_post($item['answer']); ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
