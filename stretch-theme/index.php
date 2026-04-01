<?php
/**
 * Template: Fallback / Blog index
 */
get_header();
?>

<section class="search-header">
  <div class="container">
    <h1><?php esc_html_e('Latest Posts', 'stretch'); ?></h1>
  </div>
</section>

<section class="section-white">
  <div class="container">
    <?php if (have_posts()) : ?>
      <div class="blog-grid">
        <?php while (have_posts()) : the_post();
          $cats = get_the_category();
          $first_cat = $cats ? $cats[0] : null;
        ?>
          <article class="blog-card">
            <?php if (has_post_thumbnail()) : ?>
              <a href="<?php the_permalink(); ?>" class="blog-card-image">
                <?php the_post_thumbnail('blog-card'); ?>
              </a>
            <?php endif; ?>
            <div class="blog-card-body">
              <?php if ($first_cat) : ?>
                <span class="blog-card-category"><?php echo esc_html($first_cat->name); ?></span>
              <?php endif; ?>
              <h3 class="blog-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
              <p class="blog-card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
              <a href="<?php the_permalink(); ?>" class="blog-card-readmore"><?php esc_html_e('Read More', 'stretch'); ?> &rarr;</a>
            </div>
          </article>
        <?php endwhile; ?>
      </div>

      <div class="pagination">
        <?php
        the_posts_pagination([
            'prev_text' => '&laquo;',
            'next_text' => '&raquo;',
        ]);
        ?>
      </div>
    <?php else : ?>
      <p><?php esc_html_e('No posts found.', 'stretch'); ?></p>
    <?php endif; ?>
  </div>
</section>

<?php get_footer(); ?>
