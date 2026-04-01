<?php
/**
 * Section: Blog Preview
 */
$sec        = stretch_section_classes();
$heading    = get_sub_field('heading');
$subheading = get_sub_field('subheading');
$count      = get_sub_field('post_count') ?: 3;
$category   = get_sub_field('category');
$show_filters = get_sub_field('show_filters');

$args = [
    'post_type'      => 'post',
    'posts_per_page' => $count,
    'post_status'    => 'publish',
];
if ($category) {
    $args['cat'] = $category;
}
$posts = new WP_Query($args);

// Get categories for filter buttons
$cats = get_categories(['hide_empty' => true]);
?>

<section class="<?php echo esc_attr($sec['class']); ?>"<?php echo $sec['id'] ? ' id="' . $sec['id'] . '"' : ''; ?><?php echo $sec['style'] ? ' style="' . $sec['style'] . '"' : ''; ?>>
  <div class="container">
    <?php if ($heading) : ?>
      <h2 class="reveal"><?php echo esc_html($heading); ?></h2>
    <?php endif; ?>

    <?php if ($subheading) : ?>
      <p class="reveal"><?php echo esc_html($subheading); ?></p>
    <?php endif; ?>

    <?php if ($show_filters && $cats) : ?>
      <div class="blog-filters reveal">
        <button class="blog-filter-btn active" data-filter="all"><?php esc_html_e('All', 'stretch'); ?></button>
        <?php foreach ($cats as $cat) : ?>
          <button class="blog-filter-btn" data-filter="<?php echo esc_attr($cat->slug); ?>"><?php echo esc_html($cat->name); ?></button>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php if ($posts->have_posts()) : ?>
      <div class="blog-grid">
        <?php while ($posts->have_posts()) : $posts->the_post();
          $post_cats = get_the_category();
          $first_cat = $post_cats ? $post_cats[0] : null;
        ?>
          <article class="blog-card reveal" data-category="<?php echo $first_cat ? esc_attr($first_cat->slug) : ''; ?>">
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
      <?php wp_reset_postdata(); ?>
    <?php endif; ?>
  </div>
</section>
