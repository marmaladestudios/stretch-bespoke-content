<?php
/**
 * Template: Search Results
 */
get_header();
?>

<header class="search-header">
  <div class="container">
    <h1><?php esc_html_e('Search results for:', 'stretch'); ?> <span class="search-query"><?php echo esc_html(get_search_query()); ?></span></h1>
  </div>
</header>
<div class="hero-accent-bar"></div>

<section class="section-white">
  <div class="container">
    <?php if (have_posts()) : ?>
      <div class="blog-grid">
        <?php while (have_posts()) : the_post(); ?>
          <article class="blog-card">
            <?php if (has_post_thumbnail()) : ?>
              <a href="<?php the_permalink(); ?>" class="blog-card-image">
                <?php the_post_thumbnail('blog-card'); ?>
              </a>
            <?php endif; ?>
            <div class="blog-card-body">
              <h3 class="blog-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
              <p class="blog-card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
            </div>
          </article>
        <?php endwhile; ?>
      </div>

      <div class="pagination">
        <?php the_posts_pagination(['prev_text' => '&laquo;', 'next_text' => '&raquo;']); ?>
      </div>
    <?php else : ?>
      <div class="body-content" style="text-align:center;padding:60px 0;">
        <p><?php esc_html_e('No results found. Try a different search.', 'stretch'); ?></p>
        <?php get_search_form(); ?>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php get_footer(); ?>
