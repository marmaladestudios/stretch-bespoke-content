<?php
/**
 * Section: Team Grid
 */
$sec     = stretch_section_classes();
$heading = get_sub_field('heading');
$intro   = get_sub_field('intro_text');
$members = get_sub_field('team_members');
?>

<section class="<?php echo esc_attr($sec['class']); ?>"<?php echo $sec['id'] ? ' id="' . $sec['id'] . '"' : ''; ?><?php echo $sec['style'] ? ' style="' . $sec['style'] . '"' : ''; ?>>
  <div class="container">
    <?php if ($heading) : ?>
      <h2 class="reveal"><?php echo esc_html($heading); ?></h2>
    <?php endif; ?>

    <?php if ($intro) : ?>
      <p class="reveal" style="max-width:700px;"><?php echo esc_html($intro); ?></p>
    <?php endif; ?>

    <?php if ($members) : ?>
      <div class="team-grid">
        <?php foreach ($members as $i => $m) :
          $delay = min($i + 1, 6);
        ?>
          <div class="team-card reveal reveal-delay-<?php echo esc_attr($delay); ?>">
            <div class="team-card-photo">
              <?php if ($m['photo']) : ?>
                <img src="<?php echo esc_url($m['photo']['sizes']['team-photo']); ?>" alt="<?php echo esc_attr($m['name']); ?>" loading="lazy">
              <?php endif; ?>
            </div>
            <div class="team-card-info">
              <div class="team-card-name"><?php echo esc_html($m['name']); ?></div>
              <?php if ($m['title']) : ?>
                <div class="team-card-title"><?php echo esc_html($m['title']); ?></div>
              <?php endif; ?>
            </div>
            <?php if ($m['bio']) : ?>
              <div class="team-card-bio-overlay">
                <p><?php echo esc_html($m['bio']); ?></p>
              </div>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
