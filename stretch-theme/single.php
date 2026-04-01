<?php
/**
 * Template: Single Blog Post — Premium Reading Experience
 */
get_header();

while (have_posts()) : the_post();

$cats = get_the_category();
$cat = $cats ? $cats[0] : null;
$read_time = ceil(str_word_count(strip_tags(get_the_content())) / 250);
if ($read_time < 1) $read_time = 1;
$author_id = get_the_author_meta('ID');
$author_name = get_the_author();
$author_bio = get_the_author_meta('description');
$author_initials = '';
$name_parts = explode(' ', $author_name);
foreach ($name_parts as $part) {
    if (!empty($part)) $author_initials .= strtoupper($part[0]);
}
$share_url = urlencode(get_the_permalink());
$share_title = urlencode(get_the_title());

// Category accent color
$hub_colors = ['#8560A8', '#5674B9', '#448CCB', '#00BFF3', '#6B8F3C', '#D4783F', '#C74B6F'];
$accent = $cat ? $hub_colors[$cat->term_id % count($hub_colors)] : '#8560A8';
?>

<style>
/* ========================================
   SINGLE POST — PREMIUM TEMPLATE
   ======================================== */
html, body { overflow-x: hidden; }
.admin-bar .site-nav { top: 32px; }
@media (max-width: 782px) { .admin-bar .site-nav { top: 46px; } }

.sp-section { box-sizing: border-box; position: relative; }
.sp-section *, .sp-section *::before, .sp-section *::after { box-sizing: inherit; }
.sp-section img { max-width: 100%; height: auto; display: block; }
.sp-container { max-width: 1200px; margin: 0 auto; padding: 0 40px; width: 100%; }

.sp-reveal {
  opacity: 0; transform: translateY(40px);
  transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}
.sp-reveal.visible { opacity: 1; transform: translateY(0); }

.sp-angle-divider {
  position: absolute; bottom: -1px; left: 0; right: 0; z-index: 2; pointer-events: none; line-height: 0;
}
.sp-angle-divider svg { display: block; width: 100%; height: 60px; }

/* ========================================
   1. ARTICLE HEADER
   ======================================== */
.sp-header {
  background: linear-gradient(170deg, #252C3A 0%, #1a1f2e 100%);
  padding: 160px 0 200px;
  color: #fff;
  text-align: center;
  position: relative;
  min-height: 60vh;
  display: flex;
  align-items: center;
}
.sp-header-inner {
  width: 100%;
}
.sp-cat-badge {
  display: inline-block;
  font-family: 'Montserrat', sans-serif;
  font-size: 11px;
  text-transform: uppercase;
  letter-spacing: 2px;
  color: <?php echo $accent; ?>;
  background: rgba(255,255,255,0.06);
  padding: 6px 16px;
  border-radius: 4px;
  margin-bottom: 24px;
  text-decoration: none;
  transition: background 0.3s ease;
}
.sp-cat-badge:hover { background: rgba(255,255,255,0.12); color: <?php echo $accent; ?>; }
.sp-header h1 {
  font-family: 'Poppins', sans-serif;
  font-size: 48px;
  font-weight: 600;
  line-height: 1.2;
  margin: 0 auto 24px;
  max-width: 800px;
  letter-spacing: -1px;
}
.sp-meta {
  font-family: 'Assistant', sans-serif;
  font-size: 16px;
  color: rgba(255,255,255,0.5);
  margin-bottom: 0;
}
.sp-meta a { color: rgba(255,255,255,0.7); text-decoration: none; }
.sp-meta a:hover { color: #fff; }

/* Featured image overlapping */
.sp-featured-wrap {
  max-width: 900px;
  margin: -160px auto 0;
  position: relative;
  z-index: 3;
  padding: 0 40px;
}
.sp-featured-img {
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 20px 60px rgba(0,0,0,0.2);
}
.sp-featured-img img {
  width: 100%;
  display: block;
}

/* Accent bar */
.sp-accent-bar {
  height: 4px;
  background: linear-gradient(90deg, #8560A8, #5674B9, #448CCB, #00BFF3);
}

/* ========================================
   2. ARTICLE CONTENT
   ======================================== */
.sp-content-section {
  background: #fff;
  padding: 60px 0 80px;
  position: relative;
}
.sp-content-section.has-featured {
  padding-top: 0;
}
.sp-article {
  max-width: 780px;
  margin: 0 auto;
  padding: 0 40px;
  font-family: 'Assistant', sans-serif;
  font-size: 18px;
  line-height: 1.8;
  color: #323A51;
}
.sp-article.has-featured {
  padding-top: 60px;
}
.sp-article p {
  margin: 0 0 24px;
}
.sp-article h2 {
  font-family: 'Poppins', sans-serif;
  font-size: 28px;
  font-weight: 600;
  color: #252C3A;
  margin: 48px 0 20px;
  padding-left: 20px;
  border-left: 4px solid #8560A8;
  line-height: 1.3;
}
.sp-article h3 {
  font-family: 'Poppins', sans-serif;
  font-size: 22px;
  font-weight: 600;
  color: #252C3A;
  margin: 36px 0 16px;
  line-height: 1.35;
}
.sp-article h4 {
  font-family: 'Poppins', sans-serif;
  font-size: 18px;
  font-weight: 600;
  color: #252C3A;
  margin: 28px 0 12px;
}
.sp-article blockquote {
  margin: 36px 0;
  padding: 24px 32px;
  border-left: 4px solid #00BFF3;
  background: #f9f9fb;
  border-radius: 0 12px 12px 0;
  font-family: 'Poppins', sans-serif;
  font-size: 18px;
  font-style: italic;
  color: #323A51;
  line-height: 1.7;
}
.sp-article blockquote p { margin-bottom: 0; }
.sp-article img {
  border-radius: 12px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.08);
  margin: 32px 0;
}
.sp-article ul, .sp-article ol {
  margin: 0 0 24px;
  padding-left: 24px;
}
.sp-article ul li {
  list-style: none;
  position: relative;
  padding-left: 20px;
  margin-bottom: 10px;
}
.sp-article ul li::before {
  content: '';
  position: absolute;
  left: 0;
  top: 10px;
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: linear-gradient(135deg, #8560A8, #00BFF3);
}
.sp-article ol li {
  margin-bottom: 10px;
  padding-left: 4px;
}
.sp-article ol li::marker {
  color: #8560A8;
  font-weight: 600;
}
.sp-article pre, .sp-article code {
  font-family: 'SFMono-Regular', Consolas, monospace;
  font-size: 14px;
}
.sp-article code {
  background: #f0f0f5;
  padding: 2px 6px;
  border-radius: 4px;
  color: #8560A8;
}
.sp-article pre {
  background: #1e2435;
  color: #e0e6f0;
  padding: 24px;
  border-radius: 12px;
  overflow-x: auto;
  margin: 32px 0;
}
.sp-article pre code {
  background: none;
  padding: 0;
  color: inherit;
}
.sp-article a {
  color: #8560A8;
  text-decoration: underline;
  text-decoration-color: rgba(133,96,168,0.3);
  text-underline-offset: 3px;
  transition: text-decoration-color 0.3s ease;
}
.sp-article a:hover {
  text-decoration-color: #8560A8;
}

/* Pull quote */
.sp-article .wp-block-pullquote,
.sp-article .pullquote {
  text-align: center;
  margin: 48px 0;
  padding: 32px 0;
  border-top: 2px solid rgba(133,96,168,0.15);
  border-bottom: 2px solid rgba(133,96,168,0.15);
}
.sp-article .wp-block-pullquote p,
.sp-article .pullquote p {
  font-family: 'Poppins', sans-serif;
  font-size: 24px;
  font-weight: 500;
  color: #252C3A;
  line-height: 1.5;
  font-style: italic;
}
.sp-article .wp-block-pullquote p::before,
.sp-article .pullquote p::before { content: '\201C'; color: #8560A8; }
.sp-article .wp-block-pullquote p::after,
.sp-article .pullquote p::after { content: '\201D'; color: #8560A8; }

/* ========================================
   3. SHARE BAR
   ======================================== */
.sp-share-bar {
  position: fixed;
  left: calc(50% - 480px);
  top: 50%;
  transform: translateY(-50%);
  z-index: 90;
  display: flex;
  flex-direction: column;
  gap: 10px;
  opacity: 0;
  transition: opacity 0.4s ease;
}
.sp-share-bar.visible { opacity: 1; }
.sp-share-btn {
  width: 40px; height: 40px;
  border-radius: 50%;
  background: #f9f9fb;
  border: 1px solid rgba(0,0,0,0.06);
  display: flex; align-items: center; justify-content: center;
  text-decoration: none;
  transition: all 0.3s ease;
  cursor: pointer;
  color: #323A51;
  font-size: 14px;
}
.sp-share-btn:hover {
  background: #8560A8;
  color: #fff;
  border-color: #8560A8;
  transform: scale(1.1);
}
.sp-share-btn svg { width: 16px; height: 16px; fill: currentColor; }

/* Mobile share bar */
.sp-share-mobile {
  display: none;
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  z-index: 90;
  background: #fff;
  border-top: 1px solid rgba(0,0,0,0.08);
  padding: 10px 0;
  justify-content: center;
  gap: 16px;
}
.sp-share-mobile .sp-share-btn {
  width: 36px; height: 36px;
}

/* ========================================
   4. AUTHOR BIO
   ======================================== */
.sp-author-bio {
  max-width: 780px;
  margin: 0 auto;
  padding: 48px 40px 0;
}
.sp-author-card {
  display: flex;
  gap: 24px;
  align-items: flex-start;
  padding: 32px;
  background: #f9f9fb;
  border-radius: 16px;
  border: 1px solid rgba(0,0,0,0.04);
}
.sp-author-avatar {
  width: 64px; height: 64px;
  border-radius: 50%;
  background: linear-gradient(135deg, #8560A8, #5674B9);
  display: flex; align-items: center; justify-content: center;
  font-family: 'Poppins', sans-serif;
  font-size: 22px;
  font-weight: 600;
  color: #fff;
  flex-shrink: 0;
}
.sp-author-info h3 {
  font-family: 'Poppins', sans-serif;
  font-size: 18px;
  font-weight: 600;
  color: #252C3A;
  margin: 0 0 4px;
}
.sp-author-info .author-role {
  font-family: 'Montserrat', sans-serif;
  font-size: 12px;
  text-transform: uppercase;
  letter-spacing: 1.5px;
  color: #8560A8;
  margin-bottom: 8px;
}
.sp-author-info p {
  font-family: 'Assistant', sans-serif;
  font-size: 15px;
  color: #555;
  line-height: 1.6;
  margin: 0 0 12px;
}
.sp-author-link {
  font-family: 'Poppins', sans-serif;
  font-size: 14px;
  color: #8560A8;
  text-decoration: none;
  font-weight: 500;
}
.sp-author-link:hover { text-decoration: underline; }

/* ========================================
   5. RELATED POSTS
   ======================================== */
.sp-related {
  background: #f9f9fb;
  padding: 100px 0;
  position: relative;
}
.sp-related-heading {
  font-family: 'Poppins', sans-serif;
  font-size: 36px;
  font-weight: 600;
  color: #252C3A;
  text-align: center;
  margin: 0 0 48px;
}
.sp-related-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 32px;
}
.sp-rcard {
  background: #fff;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 2px 16px rgba(0,0,0,0.06);
  transition: transform 0.4s ease, box-shadow 0.4s ease;
  border: 1px solid rgba(0,0,0,0.04);
}
.sp-rcard:hover {
  transform: translateY(-6px);
  box-shadow: 0 12px 40px rgba(0,0,0,0.12);
}
.sp-rcard-image {
  aspect-ratio: 16/10;
  overflow: hidden;
  display: block;
}
.sp-rcard-image img {
  width: 100%; height: 100%; object-fit: cover;
  transition: transform 0.6s ease;
}
.sp-rcard:hover .sp-rcard-image img { transform: scale(1.06); }
.sp-rcard-image .fallback-gradient {
  width: 100%; height: 100%;
  background: linear-gradient(135deg, #8560A8, #5674B9);
  display: flex; align-items: center; justify-content: center;
  font-family: 'Poppins', sans-serif; font-size: 18px; color: rgba(255,255,255,0.25);
}
.sp-rcard-body { padding: 24px; }
.sp-rcard-body .cat-badge {
  display: inline-block;
  font-family: 'Montserrat', sans-serif;
  font-size: 10px;
  text-transform: uppercase;
  letter-spacing: 2px;
  color: #8560A8;
  background: rgba(133,96,168,0.08);
  padding: 3px 10px;
  border-radius: 4px;
  margin-bottom: 10px;
}
.sp-rcard-body h3 {
  font-family: 'Poppins', sans-serif;
  font-size: 18px;
  font-weight: 600;
  line-height: 1.35;
  margin: 0 0 8px;
  color: #252C3A;
}
.sp-rcard-body h3 a { color: inherit; text-decoration: none; }
.sp-rcard-body h3 a:hover { color: #8560A8; }
.sp-rcard-body .card-excerpt {
  font-family: 'Assistant', sans-serif;
  font-size: 15px;
  color: #555;
  line-height: 1.5;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* ========================================
   6. NEWSLETTER + CTA
   ======================================== */
.sp-newsletter {
  background: linear-gradient(170deg, #252C3A, #1a1f2e);
  padding: 100px 0;
  color: #fff;
  position: relative;
}
.sp-newsletter-inner {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 60px;
  align-items: center;
}
.sp-newsletter h2 {
  font-family: 'Poppins', sans-serif;
  font-size: 36px;
  font-weight: 600;
  margin: 0 0 12px;
}
.sp-newsletter .nl-sub {
  font-family: 'Assistant', sans-serif;
  font-size: 17px;
  color: rgba(255,255,255,0.6);
  line-height: 1.6;
}
.sp-nl-form {
  display: flex;
  gap: 12px;
}
.sp-nl-form input[type="email"] {
  flex: 1;
  padding: 16px 20px;
  border-radius: 8px;
  border: 1px solid rgba(255,255,255,0.15);
  background: rgba(255,255,255,0.06);
  color: #fff;
  font-family: 'Assistant', sans-serif;
  font-size: 16px;
  outline: none;
  transition: border-color 0.3s ease;
}
.sp-nl-form input[type="email"]::placeholder { color: rgba(255,255,255,0.35); }
.sp-nl-form input[type="email"]:focus { border-color: #00BFF3; }
.sp-nl-form button {
  padding: 16px 32px;
  border: none;
  border-radius: 8px;
  background: linear-gradient(135deg, #8560A8, #5674B9);
  color: #fff;
  font-family: 'Poppins', sans-serif;
  font-size: 15px;
  font-weight: 500;
  cursor: pointer;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  white-space: nowrap;
}
.sp-nl-form button:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 30px rgba(133,96,168,0.4);
}

.sp-cta-final {
  background: linear-gradient(135deg, #8560A8, #5674B9);
  padding: 80px 0;
  text-align: center;
  color: #fff;
}
.sp-cta-final h2 {
  font-family: 'Poppins', sans-serif;
  font-size: 36px;
  font-weight: 600;
  margin: 0 0 24px;
}
.sp-cta-final .cta-btn {
  display: inline-block;
  padding: 16px 40px;
  background: #fff;
  color: #8560A8;
  font-family: 'Poppins', sans-serif;
  font-size: 15px;
  font-weight: 600;
  border-radius: 8px;
  text-decoration: none;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.sp-cta-final .cta-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 30px rgba(0,0,0,0.2);
}

/* ========================================
   RESPONSIVE
   ======================================== */
@media (max-width: 1100px) {
  .sp-share-bar { display: none; }
  .sp-share-mobile { display: flex; }
  body { padding-bottom: 56px; }
}
@media (max-width: 960px) {
  .sp-related-grid { grid-template-columns: repeat(2, 1fr); }
  .sp-newsletter-inner { grid-template-columns: 1fr; gap: 32px; }
}
@media (max-width: 768px) {
  .sp-container { padding: 0 24px; }
  .sp-header { padding: 130px 0 140px; min-height: auto; }
  .sp-header h1 { font-size: 32px; }
  .sp-featured-wrap { padding: 0 24px; margin-top: -100px; }
  .sp-article { padding: 0 24px; font-size: 17px; }
  .sp-article.has-featured { padding-top: 40px; }
  .sp-article h2 { font-size: 24px; }
  .sp-article h3 { font-size: 20px; }
  .sp-article blockquote { padding: 20px 24px; font-size: 16px; }
  .sp-author-bio { padding: 36px 24px 0; }
  .sp-author-card { flex-direction: column; text-align: center; align-items: center; }
  .sp-related, .sp-newsletter { padding: 60px 0; }
  .sp-related-heading { font-size: 28px; }
  .sp-nl-form { flex-direction: column; }
  .sp-cta-final h2 { font-size: 28px; }
  .sp-newsletter h2 { font-size: 28px; }
}
@media (max-width: 480px) {
  .sp-related-grid { grid-template-columns: 1fr; }
  .sp-header h1 { font-size: 26px; }
}
</style>

<!-- ============================
     1. ARTICLE HEADER
     ============================ -->
<section class="sp-section sp-header">
  <div class="sp-container sp-header-inner">
    <div class="sp-reveal">
      <?php if ($cat) : ?>
        <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" class="sp-cat-badge"><?php echo esc_html($cat->name); ?></a>
      <?php endif; ?>
      <h1><?php the_title(); ?></h1>
      <p class="sp-meta">
        <a href="<?php echo esc_url(get_author_posts_url($author_id)); ?>"><?php echo esc_html($author_name); ?></a>
        &middot; <?php echo get_the_date(); ?>
        &middot; <?php echo $read_time; ?> min read
      </p>
    </div>
  </div>
</section>

<!-- Accent bar -->
<div class="sp-accent-bar"></div>

<!-- Featured image (overlapping) -->
<?php if (has_post_thumbnail()) : ?>
<div class="sp-featured-wrap sp-reveal">
  <div class="sp-featured-img">
    <?php the_post_thumbnail('large'); ?>
  </div>
</div>
<?php endif; ?>

<!-- ============================
     2. ARTICLE CONTENT
     ============================ -->
<section class="sp-section sp-content-section <?php echo has_post_thumbnail() ? 'has-featured' : ''; ?>">
  <article class="sp-article <?php echo has_post_thumbnail() ? 'has-featured' : ''; ?>">
    <?php the_content(); ?>
  </article>

  <!-- Author Bio -->
  <div class="sp-author-bio">
    <div class="sp-author-card sp-reveal">
      <div class="sp-author-avatar"><?php echo esc_html($author_initials); ?></div>
      <div class="sp-author-info">
        <h3><?php echo esc_html($author_name); ?></h3>
        <div class="author-role">Author</div>
        <?php if ($author_bio) : ?>
          <p><?php echo esc_html($author_bio); ?></p>
        <?php else : ?>
          <p>Content creator and strategist at Stretch Creative, focused on helping brands tell their story effectively.</p>
        <?php endif; ?>
        <a href="<?php echo esc_url(get_author_posts_url($author_id)); ?>" class="sp-author-link">View all posts &rarr;</a>
      </div>
    </div>
  </div>
</section>

<!-- Share bar (desktop — fixed left) -->
<div class="sp-share-bar" id="shareBar">
  <a href="https://twitter.com/intent/tweet?url=<?php echo $share_url; ?>&text=<?php echo $share_title; ?>" target="_blank" rel="noopener noreferrer" class="sp-share-btn" title="Share on X">
    <svg viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
  </a>
  <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $share_url; ?>" target="_blank" rel="noopener noreferrer" class="sp-share-btn" title="Share on LinkedIn">
    <svg viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
  </a>
  <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $share_url; ?>" target="_blank" rel="noopener noreferrer" class="sp-share-btn" title="Share on Facebook">
    <svg viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
  </a>
  <button class="sp-share-btn" title="Copy link" onclick="navigator.clipboard.writeText(window.location.href);this.innerHTML='&#10003;';setTimeout(function(){document.querySelector('#shareBar .sp-share-btn:last-child').innerHTML='<svg viewBox=\'0 0 24 24\'><path d=\'M13.723 18.654l-3.61 3.609c-2.316 2.315-6.063 2.315-8.378 0-2.315-2.316-2.315-6.062 0-8.377l3.61-3.609c2.316-2.315 6.063-2.315 8.378 0 .542.541.961 1.174 1.257 1.858l-1.633 1.129c-.157-.474-.42-.911-.789-1.28-1.536-1.536-4.025-1.536-5.561 0l-3.61 3.61c-1.536 1.535-1.536 4.025 0 5.56 1.536 1.536 4.025 1.536 5.561 0l2.643-2.643c.65.187 1.322.27 1.988.255z\'/><path d=\'M19.265 1.736c-2.316-2.315-6.063-2.315-8.378 0l-3.61 3.609c-.542.541-.961 1.174-1.257 1.858l1.633 1.129c.157-.474.42-.911.789-1.28l3.61-3.61c1.536-1.535 4.025-1.535 5.561 0 1.536 1.536 1.536 4.025 0 5.561l-3.61 3.61c-1.536 1.535-4.025 1.535-5.561 0-.157-.157-.3-.324-.427-.499l-1.633 1.129c.341.498.752.955 1.234 1.354l.223.196.003.003c2.298 2.143 5.903 2.07 8.117-.282l3.61-3.609c2.316-2.316 2.316-6.063 0-8.378z\'/></svg>'},2000)">
    <svg viewBox="0 0 24 24"><path d="M13.723 18.654l-3.61 3.609c-2.316 2.315-6.063 2.315-8.378 0-2.315-2.316-2.315-6.062 0-8.377l3.61-3.609c2.316-2.315 6.063-2.315 8.378 0 .542.541.961 1.174 1.257 1.858l-1.633 1.129c-.157-.474-.42-.911-.789-1.28-1.536-1.536-4.025-1.536-5.561 0l-3.61 3.61c-1.536 1.535-1.536 4.025 0 5.56 1.536 1.536 4.025 1.536 5.561 0l2.643-2.643c.65.187 1.322.27 1.988.255z"/><path d="M19.265 1.736c-2.316-2.315-6.063-2.315-8.378 0l-3.61 3.609c-.542.541-.961 1.174-1.257 1.858l1.633 1.129c.157-.474.42-.911.789-1.28l3.61-3.61c1.536-1.535 4.025-1.535 5.561 0 1.536 1.536 1.536 4.025 0 5.561l-3.61 3.61c-1.536 1.535-4.025 1.535-5.561 0-.157-.157-.3-.324-.427-.499l-1.633 1.129c.341.498.752.955 1.234 1.354l.223.196.003.003c2.298 2.143 5.903 2.07 8.117-.282l3.61-3.609c2.316-2.316 2.316-6.063 0-8.378z"/></svg>
  </button>
</div>

<!-- Share bar (mobile — bottom) -->
<div class="sp-share-mobile" id="shareMobile">
  <a href="https://twitter.com/intent/tweet?url=<?php echo $share_url; ?>&text=<?php echo $share_title; ?>" target="_blank" rel="noopener noreferrer" class="sp-share-btn" title="Share on X">
    <svg viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
  </a>
  <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $share_url; ?>" target="_blank" rel="noopener noreferrer" class="sp-share-btn" title="Share on LinkedIn">
    <svg viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
  </a>
  <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $share_url; ?>" target="_blank" rel="noopener noreferrer" class="sp-share-btn" title="Share on Facebook">
    <svg viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
  </a>
  <button class="sp-share-btn" title="Copy link" onclick="navigator.clipboard.writeText(window.location.href);this.textContent='Copied!';">
    <svg viewBox="0 0 24 24"><path d="M13.723 18.654l-3.61 3.609c-2.316 2.315-6.063 2.315-8.378 0-2.315-2.316-2.315-6.062 0-8.377l3.61-3.609c2.316-2.315 6.063-2.315 8.378 0 .542.541.961 1.174 1.257 1.858l-1.633 1.129c-.157-.474-.42-.911-.789-1.28-1.536-1.536-4.025-1.536-5.561 0l-3.61 3.61c-1.536 1.535-1.536 4.025 0 5.56 1.536 1.536 4.025 1.536 5.561 0l2.643-2.643c.65.187 1.322.27 1.988.255z"/><path d="M19.265 1.736c-2.316-2.315-6.063-2.315-8.378 0l-3.61 3.609c-.542.541-.961 1.174-1.257 1.858l1.633 1.129c.157-.474.42-.911.789-1.28l3.61-3.61c1.536-1.535 4.025-1.535 5.561 0 1.536 1.536 1.536 4.025 0 5.561l-3.61 3.61c-1.536 1.535-4.025 1.535-5.561 0-.157-.157-.3-.324-.427-.499l-1.633 1.129c.341.498.752.955 1.234 1.354l.223.196.003.003c2.298 2.143 5.903 2.07 8.117-.282l3.61-3.609c2.316-2.316 2.316-6.063 0-8.378z"/></svg>
  </button>
</div>

<?php endwhile; ?>

<!-- ============================
     6. RELATED POSTS
     ============================ -->
<?php
$related = new WP_Query([
    'post_type'      => 'post',
    'posts_per_page' => 3,
    'post__not_in'   => [get_the_ID()],
    'category__in'   => $cat ? [$cat->term_id] : [],
    'post_status'    => 'publish',
]);
if ($related->have_posts()) :
?>
<section class="sp-section sp-related">
  <div class="sp-angle-divider" style="top:-1px;bottom:auto;">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none"><polygon points="0,0 1440,0 1440,60" fill="#fff"/></svg>
  </div>
  <div class="sp-container">
    <h2 class="sp-related-heading sp-reveal">Keep Reading</h2>
    <div class="sp-related-grid">
      <?php while ($related->have_posts()) : $related->the_post();
        $rc = get_the_category();
        $rcat = $rc ? $rc[0] : null;
      ?>
        <article class="sp-rcard sp-reveal">
          <a href="<?php the_permalink(); ?>" class="sp-rcard-image">
            <?php if (has_post_thumbnail()) : ?>
              <?php the_post_thumbnail('blog-card'); ?>
            <?php else : ?>
              <div class="fallback-gradient">Stretch</div>
            <?php endif; ?>
          </a>
          <div class="sp-rcard-body">
            <?php if ($rcat) : ?>
              <span class="cat-badge"><?php echo esc_html($rcat->name); ?></span>
            <?php endif; ?>
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <p class="card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
          </div>
        </article>
      <?php endwhile; ?>
    </div>
  </div>
  <?php wp_reset_postdata(); ?>

  <div class="sp-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none"><polygon points="0,60 1440,0 1440,60" fill="#252C3A"/></svg>
  </div>
</section>
<?php endif; ?>

<!-- ============================
     7. NEWSLETTER CTA
     ============================ -->
<section class="sp-section sp-newsletter">
  <div class="sp-container">
    <div class="sp-newsletter-inner sp-reveal">
      <div>
        <h2>Stay in the loop</h2>
        <p class="nl-sub">Get the latest insights on content strategy, SEO, and digital storytelling delivered to your inbox.</p>
      </div>
      <div>
        <form class="sp-nl-form" onsubmit="return false;">
          <input type="email" placeholder="your@email.com" aria-label="Email address">
          <button type="submit">Subscribe</button>
        </form>
      </div>
    </div>
  </div>

  <div class="sp-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none"><polygon points="0,0 1440,60 1440,60 0,60" fill="#8560A8"/></svg>
  </div>
</section>

<!-- ============================
     8. FINAL CTA
     ============================ -->
<section class="sp-section sp-cta-final">
  <div class="sp-container sp-reveal">
    <h2>Ready to scale your content?</h2>
    <a href="<?php echo esc_url(home_url('/contact-stretch-creative/')); ?>" class="cta-btn">Get Started</a>
  </div>
</section>

<script>
(function() {
  // Scroll reveals
  var revealEls = document.querySelectorAll('.sp-reveal');
  var observer = new IntersectionObserver(function(entries) {
    entries.forEach(function(entry) {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
  revealEls.forEach(function(el) { observer.observe(el); });

  // Share bar visibility (desktop)
  var shareBar = document.getElementById('shareBar');
  if (shareBar) {
    var article = document.querySelector('.sp-article');
    if (article) {
      var shareObs = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
          if (entry.isIntersecting) {
            shareBar.classList.add('visible');
          } else {
            shareBar.classList.remove('visible');
          }
        });
      }, { threshold: 0 });
      shareObs.observe(article);
    }
  }
})();
</script>

<?php get_footer(); ?>
