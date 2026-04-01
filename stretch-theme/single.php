<?php
/**
 * Template: Single Blog Post
 */
get_header();

while (have_posts()) : the_post();
?>

<header class="single-post-header">
  <div class="container">
    <?php
    $cats = get_the_category();
    if ($cats) : ?>
      <span class="blog-card-category" style="color:var(--color-cyan);">
        <?php echo esc_html($cats[0]->name); ?>
      </span>
    <?php endif; ?>
    <h1><?php the_title(); ?></h1>
    <div class="single-post-meta">
      <?php echo esc_html(get_the_date()); ?> &middot;
      <?php esc_html_e('By', 'stretch'); ?> <?php the_author(); ?>
    </div>
  </div>
</header>
<div class="hero-accent-bar"></div>

<article class="single-post-content">
  <?php if (has_post_thumbnail()) : ?>
    <figure style="margin:0 0 40px;">
      <?php the_post_thumbnail('large'); ?>
    </figure>
  <?php endif; ?>

  <?php the_content(); ?>
</article>

<?php
// Related posts
$related = new WP_Query([
    'post_type'      => 'post',
    'posts_per_page' => 3,
    'post__not_in'   => [get_the_ID()],
    'category__in'   => wp_get_post_categories(get_the_ID()),
    'post_status'    => 'publish',
]);

if ($related->have_posts()) : ?>
  <section class="section-light">
    <div class="container">
      <h2><?php esc_html_e('Related Posts', 'stretch'); ?></h2>
      <div class="blog-grid">
        <?php while ($related->have_posts()) : $related->the_post();
          $r_cats = get_the_category();
          $r_cat = $r_cats ? $r_cats[0] : null;
        ?>
          <article class="blog-card">
            <?php if (has_post_thumbnail()) : ?>
              <a href="<?php the_permalink(); ?>" class="blog-card-image">
                <?php the_post_thumbnail('blog-card'); ?>
              </a>
            <?php endif; ?>
            <div class="blog-card-body">
              <?php if ($r_cat) : ?>
                <span class="blog-card-category"><?php echo esc_html($r_cat->name); ?></span>
              <?php endif; ?>
              <h3 class="blog-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
              <p class="blog-card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
            </div>
          </article>
        <?php endwhile; ?>
      </div>
    </div>
  </section>
  <?php wp_reset_postdata(); ?>
<?php endif; ?>

<?php
endwhile;
get_footer();
