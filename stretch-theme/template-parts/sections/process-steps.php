<?php
/**
 * Section: Process Steps
 */
$sec      = stretch_section_classes();
$overline = get_sub_field('overline');
$heading  = get_sub_field('heading');
$steps    = get_sub_field('steps');
?>

<section class="<?php echo esc_attr($sec['class']); ?>"<?php echo $sec['id'] ? ' id="' . $sec['id'] . '"' : ''; ?><?php echo $sec['style'] ? ' style="' . $sec['style'] . '"' : ''; ?>>
  <div class="container">
    <?php if ($overline) : ?>
      <span class="overline reveal"><?php echo esc_html($overline); ?></span>
    <?php endif; ?>

    <?php if ($heading) : ?>
      <h2 class="reveal"><?php echo esc_html($heading); ?></h2>
    <?php endif; ?>

    <?php if ($steps) : ?>
      <div class="process-steps">
        <?php foreach ($steps as $i => $step) : ?>
          <div class="process-step reveal">
            <div class="step-marker">
              <div class="step-number"><?php echo str_pad($i + 1, 2, '0', STR_PAD_LEFT); ?></div>
            </div>
            <div class="step-content">
              <h3><?php echo esc_html($step['title']); ?></h3>
              <?php if ($step['description']) : ?>
                <span class="step-desc"><?php echo esc_html($step['description']); ?></span>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
