<?php
/**
 * Section: Pull Quote Banner
 */
$quote  = get_sub_field('quote_text');
$accent = get_sub_field('accent_phrase');
?>

<div class="pull-quote-banner">
  <div class="container">
    <blockquote class="reveal">
      <?php
      if ($accent && str_contains($quote, $accent)) {
          echo wp_kses_post(str_replace(
              $accent,
              '<span class="quote-accent">' . esc_html($accent) . '</span>',
              esc_html($quote)
          ));
      } else {
          echo esc_html($quote);
      }
      ?>
    </blockquote>
  </div>
</div>
