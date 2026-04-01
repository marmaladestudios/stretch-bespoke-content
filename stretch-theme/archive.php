<?php
/**
 * Template: Blog Archive (category, tag, date archives)
 */
get_header();
?>

<header class="search-header">
  <div class="container">
    <h1>
      <?php
      if (is_category()) {
          single_cat_title();
      } elseif (is_tag()) {
          single_tag_title();
      } elseif (is_author()) {
          the_author();
      } elseif (is_date()) {
          echo get_the_date('F Y');
      } else {
          esc_html_e('Blog', 'stretch');
      }
      ?>
    </h1>
  </div>
</header>
<div class="hero-accent-bar"></div>

<section class="section-white">
  <div class="container">
    <?php
    // Category filter buttons (on main blog page)
    $cats = get_categories(['hide_empty' => true]);
    if ($cats) : ?>
      <div class="blog-filters">
        <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="blog-filter-btn<?php echo !is_category() ? ' active' : ''; ?>"><?php esc_html_e('All', 'stretch'); ?></a>
        <?php foreach ($cats as $cat) : ?>
          <a href="<?php echo esc_url(get_category_link($cat)); ?>" class="blog-filter-btn<?php echo is_category($cat->term_id) ? ' active' : ''; ?>"><?php echo esc_html($cat->name); ?></a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php if (have_posts()) : ?>
      <div class="blog-grid">
        <?php while (have_posts()) : the_post();
          $post_cats = get_the_category();
          $first_cat = $post_cats ? $post_cats[0] : null;
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
              <span class="blog-card-meta"><?php echo esc_html(get_the_date()); ?></span>
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
