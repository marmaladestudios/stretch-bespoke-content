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
  overflow: hidden;
}
/* Hero grid overlay — populated by JS */
.sp-header-grid {
  position: absolute;
  inset: 0;
  pointer-events: none;
  z-index: 0;
  overflow: hidden;
}
.sp-header-grid-inner {
  position: absolute;
  inset: -60px;
  display: grid;
  grid-template-columns: repeat(auto-fill, 60px);
  grid-auto-rows: 60px;
  transition: transform 0.4s ease-out;
}
.sp-grid-cell {
  border: 1px solid rgba(255,255,255,0.025);
}
.sp-grid-cell.colored {
  background: var(--cell-color);
  animation: sp-cellPulse 4s ease-in-out infinite;
  animation-delay: var(--cell-delay, 0s);
}
@keyframes sp-cellPulse {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.3; }
}
.sp-header-grid::after {
  content: '';
  position: absolute;
  inset: 0;
  background: radial-gradient(ellipse 65% 60% at 50% 45%, rgba(37,44,58,0.98) 0%, rgba(37,44,58,0.85) 35%, rgba(37,44,58,0.4) 55%, transparent 75%);
  pointer-events: none;
  z-index: 1;
}
@media (prefers-reduced-motion: reduce) {
  .sp-grid-cell.colored { animation: none; }
  display: flex;
  align-items: center;
}
.sp-header-inner {
  width: 100%;
  position: relative;
  z-index: 1;
}
/* Breadcrumbs */
.sp-breadcrumbs {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  margin-top: 12px;
  margin-bottom: 0;
  font-family: 'Poppins', sans-serif;
  font-size: 12px;
  font-weight: 400;
  opacity: 0.55;
}
.sp-breadcrumbs a {
  color: rgba(255,255,255,0.7);
  text-decoration: none;
  transition: color 0.2s;
}
.sp-breadcrumbs a:hover { color: #fff; }
.sp-breadcrumbs .sp-bc-sep { color: rgba(255,255,255,0.35); }
.sp-breadcrumbs .sp-bc-current {
  color: rgba(255,255,255,0.7);
  max-width: 260px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
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
  border-radius: 18px;
  overflow: hidden;
  padding: 4px;
  background: #e8e8ec;
  position: relative;
  transition: background 0.6s ease;
}
.sp-featured-img.border-active {
  background: conic-gradient(
    from var(--sp-border-angle, 0deg),
    #8560A8 0%,
    #5674B9 calc(var(--sp-border-progress, 0%) * 0.25),
    #448CCB calc(var(--sp-border-progress, 0%) * 0.5),
    #00BFF3 var(--sp-border-progress, 0%),
    #e8e8ec var(--sp-border-progress, 0%),
    #e8e8ec 100%
  );
  animation: sp-borderSpin 40s linear infinite;
}
.sp-featured-img.border-complete {
  background: conic-gradient(
    from var(--sp-border-angle, 0deg),
    #8560A8, #5674B9, #448CCB, #00BFF3, #8560A8
  );
  animation: sp-borderSpin 40s linear infinite;
  box-shadow: 0 20px 60px rgba(0,0,0,0.2), 0 0 24px rgba(133,96,168,0.2), 0 0 48px rgba(0,191,243,0.1);
}
.sp-featured-img img {
  width: 100% !important;
  height: auto !important;
  max-height: none;
  display: block;
  border-radius: 14px;
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
  filter: saturate(0.9);
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
  margin: 48px -40px;
  padding: 40px 40px;
  border-top: 2px solid rgba(133,96,168,0.15);
  border-bottom: 2px solid rgba(133,96,168,0.15);
  border-left: none;
  background: transparent;
  border-radius: 0;
  font-style: normal;
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

/* Figure & figcaption — clean treatment */
.sp-article figure {
  margin: 48px -40px;
  padding: 0;
  position: relative;
  border-radius: 16px;
  overflow: hidden;
}
.sp-article figure img {
  border-radius: 16px;
  margin: 0;
  width: 100%;
  display: block;
  box-shadow: 0 8px 32px rgba(37,44,58,0.12);
  transition: transform 0.4s ease, box-shadow 0.4s ease;
}
.sp-article figure:hover img {
  transform: translateY(-4px);
  box-shadow: 0 16px 48px rgba(133,96,168,0.18);
}

/* Gradient border animation — for CTA cards only */
@property --sp-border-angle {
  syntax: '<angle>';
  initial-value: 0deg;
  inherits: false;
}
@property --sp-border-progress {
  syntax: '<percentage>';
  initial-value: 0%;
  inherits: false;
}
@keyframes sp-borderSpin {
  to { --sp-border-angle: 360deg; }
}
.sp-gradient-border {
  padding: 3px;
  background: #e8e8ec;
  border-radius: 20px;
  transition: background 0.6s ease;
}
.sp-gradient-border.border-active {
  background: conic-gradient(
    from var(--sp-border-angle),
    #8560A8 0%,
    #5674B9 calc(var(--sp-border-progress) * 0.25),
    #448CCB calc(var(--sp-border-progress) * 0.5),
    #00BFF3 var(--sp-border-progress),
    #e8e8ec var(--sp-border-progress),
    #e8e8ec 100%
  );
  animation: sp-borderSpin 19s linear infinite;
}
.sp-gradient-border.border-complete {
  background: conic-gradient(
    from var(--sp-border-angle),
    #8560A8, #5674B9, #448CCB, #00BFF3, #8560A8
  );
  animation: sp-borderSpin 19s linear infinite;
  box-shadow: 0 0 24px rgba(133,96,168,0.2), 0 0 48px rgba(0,191,243,0.1);
}
.sp-article figcaption {
  font-family: 'Poppins', sans-serif;
  font-size: 13px;
  font-weight: 400;
  color: #8560A8;
  text-align: center;
  margin: 0;
  padding: 16px 0 0;
  position: absolute;
  bottom: -36px;
  left: 0;
  right: 0;
  z-index: 2;
  line-height: 1.5;
  letter-spacing: 0.3px;
  font-style: italic;
}

/* Tables */
.sp-article table {
  width: 100%;
  border-collapse: collapse;
  margin: 32px 0;
  font-family: 'Assistant', sans-serif;
  font-size: 16px;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 2px 16px rgba(0,0,0,0.06);
}
.sp-article table thead {
  background: linear-gradient(135deg, #252C3A, #323A51);
  color: #fff;
}
.sp-article table thead th {
  padding: 14px 20px;
  font-family: 'Poppins', sans-serif;
  font-size: 14px;
  font-weight: 600;
  text-align: left;
  letter-spacing: 0.5px;
}
.sp-article table tbody tr {
  border-bottom: 1px solid #eee;
  transition: background 0.2s;
}
.sp-article table tbody tr:last-child { border-bottom: none; }
.sp-article table tbody tr:hover { background: #f9f9fb; }
.sp-article table tbody td {
  padding: 14px 20px;
  color: #323A51;
}
.sp-article table tbody td:first-child {
  font-weight: 600;
  color: #252C3A;
}

/* Styled HR */
.sp-article hr {
  border: none;
  height: 3px;
  background: linear-gradient(90deg, #8560A8, #5674B9, #448CCB, #00BFF3);
  margin: 48px 0;
  border-radius: 2px;
  opacity: 0.5;
}

/* Image gallery (consecutive images) */
.sp-article .wp-block-gallery,
.sp-article .gallery {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 16px;
  margin: 32px 0;
}
.sp-article .wp-block-gallery figure,
.sp-article .gallery figure {
  margin: 0;
}

/* ========================================
   READING PROGRESS BAR
   ======================================== */
.sp-progress-bar {
  position: fixed;
  top: 0;
  left: 0;
  width: 0%;
  height: 3px;
  background: linear-gradient(90deg, #8560A8, #5674B9, #448CCB, #00BFF3);
  z-index: 9999;
  transition: width 0.1s linear;
}
.admin-bar .sp-progress-bar { top: 32px; }
@media (max-width: 782px) { .admin-bar .sp-progress-bar { top: 46px; } }

/* Nav on post pages — use default container styling */

/* ========================================
   TABLE OF CONTENTS SIDEBAR
   ======================================== */
.sp-toc-sidebar {
  position: fixed;
  left: max(20px, calc((100vw - 780px) / 2 - 260px));
  top: 160px;
  width: 200px;
  max-height: calc(100vh - 140px);
  overflow-y: auto;
  overflow-x: hidden;
  scrollbar-width: none;
  z-index: 50;
  opacity: 0;
  transition: opacity 0.4s ease;
}
.sp-toc-sidebar::-webkit-scrollbar { display: none; }
.sp-toc-sidebar.visible { opacity: 1; }
.sp-toc-label {
  font-family: 'Poppins', sans-serif;
  font-size: 11px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 2px;
  color: #bbb;
  margin-bottom: 16px;
}
.sp-toc-list { list-style: none; padding: 0; margin: 0; border-left: 2px solid #e8e8ec; }
.sp-toc-item { padding: 8px 0 8px 16px; border-left: 2px solid transparent; margin-left: -2px; }
.sp-toc-item a { font-size: 13px; color: #999; text-decoration: none; transition: color 0.2s; font-family: 'Poppins', sans-serif; display: block; line-height: 1.4; }
.sp-toc-item.active { border-left-color: #8560A8; }
.sp-toc-item.active a { color: #8560A8; font-weight: 500; }
.sp-toc-item a:hover { color: #252C3A; }

@media (max-width: 1280px) {
  .sp-toc-sidebar { display: none; }
}

/* ========================================
   3. SHARE BAR
   ======================================== */
.sp-share-bar {
  display: none !important;
}
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

/* Mobile share bar — hidden, replaced by inline bar */
.sp-share-mobile {
  display: none !important;
}

/* Inline horizontal share bar */
.sp-share-inline {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 24px 0;
  margin-top: 24px;
  border-top: 1px solid rgba(133,96,168,0.12);
}
.sp-share-inline-label {
  font-family: 'Poppins', sans-serif;
  font-size: 13px;
  font-weight: 500;
  color: #999;
  text-transform: uppercase;
  letter-spacing: 1px;
  margin-right: 8px;
}
.sp-share-inline .sp-share-btn {
  width: 44px; height: 44px;
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
  color: #fff;
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
  color: #fff;
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
   FAQ SECTION
   ======================================== */
.sp-faq {
  padding: 80px 0;
  background: #f9f9fb;
  position: relative;
}
.sp-faq-container {
  max-width: 780px;
  margin: 0 auto;
  padding: 0 40px;
}
.sp-faq h2 {
  font-family: 'Poppins', sans-serif;
  font-size: 32px;
  font-weight: 600;
  color: #252C3A;
  text-align: center;
  margin-bottom: 48px;
}
.sp-faq-item {
  border-bottom: 1px solid rgba(133,96,168,0.1);
}
.sp-faq-trigger {
  width: 100%;
  background: none;
  border: none;
  padding: 24px 0;
  display: flex;
  justify-content: space-between;
  align-items: center;
  cursor: pointer;
  font-family: 'Poppins', sans-serif;
  font-size: 17px;
  font-weight: 500;
  color: #323A51;
  text-align: left;
  transition: color 0.3s;
  border-left: 3px solid transparent;
  padding-left: 20px;
}
.sp-faq-trigger:hover,
.sp-faq-trigger.open { color: #8560A8; border-left-color: #8560A8; }
.sp-faq-icon {
  font-size: 24px;
  color: #8560A8;
  transition: transform 0.3s;
  flex-shrink: 0;
}
.sp-faq-trigger.open .sp-faq-icon { transform: rotate(45deg); }
.sp-faq-answer {
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.4s ease;
}
.sp-faq-answer-inner {
  padding: 0 0 24px 20px;
  font-size: 16px;
  line-height: 1.7;
  color: #666;
}

/* ========================================
   RESPONSIVE
   ======================================== */
@media (max-width: 1100px) {
  /* share bars handled globally */
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
  .sp-article figure { margin-left: 0; margin-right: 0; }
  .sp-article h3 { font-size: 20px; }
  .sp-article blockquote { padding: 20px 24px; font-size: 16px; }
  .sp-article .pullquote, .sp-article .wp-block-pullquote { margin-left: 0; margin-right: 0; padding: 28px 16px; }
  .sp-article .pullquote p, .sp-article .wp-block-pullquote p { font-size: 20px; }
  .sp-article table { font-size: 14px; }
  .sp-article table thead th, .sp-article table tbody td { padding: 10px 12px; }
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

/* ========================================
   HUB ARTICLES SIDEBAR
   ======================================== */
.sp-hub-sidebar {
  margin-top: 32px;
  max-width: 200px;
  opacity: 0;
  transition: opacity 0.4s ease;
}
.sp-hub-sidebar .sp-toc-label {
  margin-bottom: 12px;
}
.sp-hub-acc {
  margin-bottom: 4px;
}
.sp-hub-acc-trigger {
  width: 100%;
  padding: 8px 0;
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-family: 'Poppins', sans-serif;
  font-size: 12px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 1px;
}
.sp-hub-acc-link {
  color: #8560A8;
  text-decoration: none;
  transition: color 0.2s;
  flex: 1;
}
.sp-hub-acc-link:hover { color: #00BFF3; }
.sp-hub-acc-trigger .sp-hub-arrow {
  font-size: 14px;
  font-weight: 300;
  color: #bbb;
  cursor: pointer;
  padding: 4px 8px;
  transition: transform 0.3s, color 0.2s;
}
.sp-hub-acc-trigger .sp-hub-arrow:hover { color: #8560A8; }
.sp-hub-acc-trigger.open .sp-hub-arrow { transform: rotate(45deg); color: #8560A8; }
.sp-hub-acc-panel {
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.3s ease;
}
.sp-hub-acc-list {
  list-style: none;
  padding: 0 0 8px 0;
  margin: 0;
  border-left: 2px solid #e8e8ec;
}
.sp-hub-acc-list li {
  padding: 6px 0 6px 12px;
}
.sp-hub-acc-list a {
  font-family: 'Poppins', sans-serif;
  font-size: 12px;
  color: #999;
  text-decoration: none;
  transition: color 0.2s;
  line-height: 1.4;
  display: block;
}
.sp-hub-acc-list a:hover { color: #8560A8; }
.sp-hub-acc-list .current-post a {
  color: #8560A8;
  font-weight: 500;
}

/* ========================================
   MORE FROM HUB GRID
   ======================================== */
.sp-more-hub {
  padding: 80px 0;
  background: #fff;
  position: relative;
}
.sp-hub-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 24px;
  margin-top: 40px;
}
.sp-hub-card {
  text-decoration: none;
  color: inherit;
  transition: transform 0.4s ease;
  display: block;
}
.sp-hub-card:hover { transform: translateY(-6px); }
.sp-hub-card-img {
  aspect-ratio: 16/10;
  overflow: hidden;
  border-radius: 8px;
  margin-bottom: 16px;
  background: #f9f9fb;
  position: relative;
}
.sp-hub-card-img::after {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, rgba(133,96,168,0.1) 0%, transparent 60%, rgba(0,191,243,0.06) 100%);
  pointer-events: none;
  transition: opacity 0.3s;
}
.sp-hub-card:hover .sp-hub-card-img::after { opacity: 0; }
.sp-hub-card-img img {
  width: 100%; height: 100%; object-fit: cover;
  transition: transform 0.4s ease;
}
.sp-hub-card:hover .sp-hub-card-img img { transform: scale(1.05); }
.sp-hub-card h3 {
  font-family: 'Poppins', sans-serif;
  font-size: 15px;
  font-weight: 500;
  color: #252C3A;
  line-height: 1.4;
  margin-bottom: 6px;
  transition: color 0.2s;
}
.sp-hub-card:hover h3 { color: #8560A8; }
.sp-hub-card-meta {
  font-size: 12px;
  color: #999;
}
.sp-hub-card-img .fallback-gradient {
  width: 100%; height: 100%;
  background: linear-gradient(135deg, #8560A8, #5674B9);
  display: flex; align-items: center; justify-content: center;
  font-family: 'Poppins', sans-serif; font-size: 16px; color: rgba(255,255,255,0.25);
}

@media (max-width: 960px) { .sp-hub-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 480px) { .sp-hub-grid { grid-template-columns: 1fr; } }

/* ========================================
   ENGAGEMENT: Reading Time Pill
   ======================================== */
.sp-read-time-pill {
  display: none !important;
  pointer-events: none;
}
.sp-read-time-pill.visible {
  opacity: 1;
  transform: translateY(0);
}
.sp-read-time-pill .pill-icon {
  display: inline-block;
  width: 6px; height: 6px;
  border-radius: 50%;
  background: #00BFF3;
  margin-right: 8px;
  animation: sp-pillPulse 2s ease infinite;
}
@keyframes sp-pillPulse { 0%,100% { opacity: 1; } 50% { opacity: 0.4; } }

/* ========================================
   ENGAGEMENT: Inline Content Upgrade CTA
   ======================================== */
.sp-content-upgrade {
  margin: 48px -20px;
}
.sp-content-upgrade-inner {
  padding: 36px 40px;
  background: linear-gradient(135deg, #252C3A 0%, #1a1f2e 100%);
  border-radius: 17px;
  position: relative;
  overflow: hidden;
}
.sp-content-upgrade-inner::after {
  content: '';
  position: absolute;
  top: -50px; right: -50px;
  width: 200px; height: 200px;
  background: radial-gradient(circle, rgba(0,191,243,0.08), transparent 70%);
  pointer-events: none;
}
.sp-content-upgrade-overline {
  font-family: 'Poppins', sans-serif;
  font-size: 11px; font-weight: 600;
  text-transform: uppercase; letter-spacing: 2px;
  color: #00BFF3; margin-bottom: 12px;
}
.sp-content-upgrade h3 {
  font-family: 'Poppins', sans-serif;
  font-size: 22px; font-weight: 600;
  color: #fff; margin-bottom: 12px; line-height: 1.3;
}
.sp-content-upgrade p {
  font-family: 'Assistant', sans-serif;
  font-size: 16px; color: rgba(255,255,255,0.7);
  line-height: 1.6; margin-bottom: 20px;
}
.sp-content-upgrade-btn {
  display: inline-block;
  background: linear-gradient(135deg, #8560A8, #00BFF3);
  color: #fff !important; font-family: 'Poppins', sans-serif;
  font-size: 14px; font-weight: 500;
  padding: 12px 28px; border-radius: 6px;
  text-decoration: none !important;
  transition: transform 0.3s, box-shadow 0.3s;
}
.sp-content-upgrade-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(133,96,168,0.3);
}

/* ========================================
   ENGAGEMENT: Text Highlight Share
   ======================================== */
.sp-text-share {
  position: absolute;
  background: #252C3A;
  border-radius: 8px;
  padding: 8px 12px;
  display: flex;
  gap: 8px;
  z-index: 100;
  opacity: 0;
  transform: translateY(8px);
  transition: opacity 0.2s, transform 0.2s;
  pointer-events: none;
  box-shadow: 0 8px 24px rgba(0,0,0,0.2);
}
.sp-text-share.visible {
  opacity: 1;
  transform: translateY(0);
  pointer-events: auto;
}
.sp-text-share::after {
  content: '';
  position: absolute;
  bottom: -6px;
  left: 50%;
  width: 12px; height: 12px;
  background: #252C3A;
  border-radius: 2px;
  transform: translateX(-50%) rotate(45deg);
}
.sp-text-share a {
  display: flex; align-items: center; justify-content: center;
  width: 32px; height: 32px;
  border-radius: 6px;
  background: rgba(255,255,255,0.1);
  color: #fff;
  text-decoration: none;
  transition: background 0.2s;
}
.sp-text-share a:hover { background: #8560A8; }
.sp-text-share a svg { width: 14px; height: 14px; fill: currentColor; }

/* ========================================
   ENGAGEMENT: Sticky CTA Bar
   ======================================== */
.sp-sticky-cta {
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  background: rgba(37,44,58,0.95);
  backdrop-filter: blur(12px);
  padding: 16px 40px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  z-index: 80;
  transform: translateY(100%);
  transition: transform 0.4s cubic-bezier(0.16,1,0.3,1);
}
.sp-sticky-cta.visible { transform: translateY(0); }
.sp-sticky-cta-text {
  font-family: 'Poppins', sans-serif;
  font-size: 15px; font-weight: 400; color: #fff;
}
.sp-sticky-cta-text strong { color: #00BFF3; font-weight: 500; }
.sp-sticky-cta-btn {
  display: inline-block;
  background: linear-gradient(135deg, #8560A8, #00BFF3);
  color: #fff; font-family: 'Poppins', sans-serif;
  font-size: 13px; font-weight: 500;
  padding: 10px 24px; border-radius: 6px;
  text-decoration: none; white-space: nowrap;
  transition: transform 0.3s, box-shadow 0.3s;
}
.sp-sticky-cta-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(133,96,168,0.3);
}
.sp-sticky-cta-close {
  background: none; border: none; color: rgba(255,255,255,0.5);
  font-size: 18px; cursor: pointer; padding: 4px 8px; margin-left: 16px;
  transition: color 0.2s;
}
.sp-sticky-cta-close:hover { color: #fff; }
@media (max-width: 768px) {
  .sp-sticky-cta { padding: 12px 20px; flex-wrap: wrap; gap: 8px; }
  .sp-sticky-cta-text { font-size: 13px; flex: 1; }
}

/* ========================================
   ENGAGEMENT: Key Takeaway Boxes
   ======================================== */
.sp-key-takeaway {
  margin: 32px 0;
  padding: 24px 28px;
  background: linear-gradient(135deg, rgba(133,96,168,0.06), rgba(0,191,243,0.04));
  border-left: 3px solid #8560A8;
  border-radius: 0 12px 12px 0;
}
.sp-key-takeaway-label {
  font-family: 'Poppins', sans-serif;
  font-size: 11px; font-weight: 600;
  text-transform: uppercase; letter-spacing: 1.5px;
  color: #8560A8; margin-bottom: 8px;
  display: flex; align-items: center; gap: 8px;
}
.sp-key-takeaway-label::before {
  content: '\1F4A1'; font-size: 14px;
}
.sp-key-takeaway p {
  font-family: 'Poppins', sans-serif;
  font-size: 15px; font-weight: 500;
  color: #252C3A; line-height: 1.55;
  margin: 0;
}

/* ========================================
   ENGAGEMENT: Next Article Teaser
   ======================================== */
.sp-next-article {
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  background: #fff;
  border-top: 1px solid rgba(0,0,0,0.06);
  box-shadow: 0 -8px 32px rgba(0,0,0,0.08);
  padding: 20px 40px;
  display: flex;
  align-items: center;
  gap: 20px;
  z-index: 85;
  transform: translateY(100%);
  transition: transform 0.5s cubic-bezier(0.16,1,0.3,1);
}
.sp-next-article.visible { transform: translateY(0); }
.sp-next-article-label {
  font-family: 'Poppins', sans-serif;
  font-size: 10px; font-weight: 600;
  text-transform: uppercase; letter-spacing: 2px;
  color: #8560A8;
}
.sp-next-article-img {
  width: 80px; height: 56px;
  border-radius: 8px;
  overflow: hidden; flex-shrink: 0;
}
.sp-next-article-img img { width: 100%; height: 100%; object-fit: cover; }
.sp-next-article-text { flex: 1; }
.sp-next-article-title {
  font-family: 'Poppins', sans-serif;
  font-size: 15px; font-weight: 500;
  color: #252C3A; line-height: 1.3;
  text-decoration: none;
  transition: color 0.2s;
}
.sp-next-article-title:hover { color: #8560A8; }
.sp-next-article-close {
  background: none; border: none;
  color: #bbb; font-size: 20px;
  cursor: pointer; padding: 4px 8px;
}
@media (max-width: 768px) {
  .sp-next-article { padding: 16px 20px; }
  .sp-next-article-img { width: 60px; height: 42px; }
  .sp-next-article-title { font-size: 13px; }
}

/* ========================================
   ENGAGEMENT: Reduced Motion
   ======================================== */
@media (prefers-reduced-motion: reduce) {
  .sp-read-time-pill,
  .sp-sticky-cta,
  .sp-next-article,
  .sp-text-share,
  .sp-content-upgrade-btn { transition: none; }
  .sp-read-time-pill .pill-icon { animation: none; }
}

/* ========================================
   ENGAGEMENT: Animated Section Dividers
   ======================================== */
.sp-section-divider {
  height: 2px;
  margin: 48px 0;
  background: linear-gradient(90deg, #8560A8, #5674B9, #448CCB, #00BFF3);
  transform: scaleX(0);
  transform-origin: left;
  transition: transform 1.2s cubic-bezier(0.16, 1, 0.3, 1);
}
.sp-section-divider.drawn { transform: scaleX(1); }
@media (prefers-reduced-motion: reduce) {
  .sp-section-divider { transform: scaleX(1); transition: none; }
}

/* ========================================
   ENGAGEMENT: Custom Illustrated Icons on H2
   ======================================== */
.sp-heading-icon {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 32px;
  height: 32px;
  border-radius: 8px;
  background: linear-gradient(135deg, rgba(133,96,168,0.1), rgba(0,191,243,0.08));
  margin-right: 12px;
  vertical-align: middle;
  flex-shrink: 0;
}
.sp-heading-icon svg {
  width: 18px;
  height: 18px;
}
.sp-article h2 {
  display: flex;
  align-items: center;
}

/* ========================================
   ENGAGEMENT: Reading Position Marker
   ======================================== */
.sp-reading-position {
  position: fixed;
  right: calc((100vw - 780px) / 2 - 30px);
  top: 160px;
  font-family: 'Poppins', sans-serif;
  font-size: 11px;
  font-weight: 500;
  color: #bbb;
  letter-spacing: 0.5px;
  opacity: 0;
  transition: opacity 0.3s;
  z-index: 49;
  writing-mode: vertical-rl;
  transform: rotate(180deg);
}
.admin-bar .sp-reading-position { top: 192px; }
.sp-reading-position.visible { opacity: 1; }
@media (max-width: 960px) { .sp-reading-position { display: none; } }

/* ========================================
   ENGAGEMENT: Interactive Comparison Table
   ======================================== */
.sp-article table tbody tr { cursor: pointer; position: relative; }
.sp-article table tbody tr.highlighted {
  background: rgba(133,96,168,0.08) !important;
}
.sp-article table tbody tr.highlighted td:first-child {
  font-weight: 600;
  color: #8560A8;
}

/* ========================================
   ENGAGEMENT: Copy Button on Quotes
   ======================================== */
.sp-copy-btn {
  position: absolute;
  top: 12px;
  right: 12px;
  background: rgba(133,96,168,0.08);
  border: 1px solid rgba(133,96,168,0.15);
  border-radius: 6px;
  padding: 4px 10px;
  font-family: 'Poppins', sans-serif;
  font-size: 10px;
  font-weight: 500;
  color: #8560A8;
  cursor: pointer;
  transition: all 0.2s;
  z-index: 5;
}
.sp-copy-btn:hover {
  background: #8560A8;
  color: #fff;
  border-color: #8560A8;
}
.sp-copy-btn.copied {
  background: #28c840;
  color: #fff;
  border-color: #28c840;
}

/* ========================================
   ENGAGEMENT: Reaction Buttons
   ======================================== */
.sp-reactions {
  text-align: center;
  padding: 32px 0;
  margin: 32px 0;
}
.sp-reactions-label {
  font-family: 'Poppins', sans-serif;
  font-size: 15px;
  font-weight: 500;
  color: #252C3A;
  margin-bottom: 16px;
}
.sp-reactions-btns {
  display: flex;
  justify-content: center;
  gap: 12px;
}
.sp-reaction-btn {
  width: 52px;
  height: 52px;
  border-radius: 50%;
  border: 2px solid #e8e8ec;
  background: #fff;
  font-size: 22px;
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.16,1,0.3,1);
  display: flex;
  align-items: center;
  justify-content: center;
}
.sp-reaction-btn:hover {
  transform: scale(1.2);
  border-color: #8560A8;
  box-shadow: 0 4px 16px rgba(133,96,168,0.15);
}
.sp-reaction-btn.selected {
  transform: scale(1.15);
  border-color: #8560A8;
  background: rgba(133,96,168,0.08);
  box-shadow: 0 4px 16px rgba(133,96,168,0.2);
}
.sp-reaction-btn.selected:hover {
  transform: scale(1.25);
}
.sp-reaction-thanks {
  font-family: 'Assistant', sans-serif;
  font-size: 14px;
  color: #8560A8;
  margin-top: 12px;
  opacity: 0;
  transition: opacity 0.3s;
}
.sp-reaction-thanks.visible { opacity: 1; }

/* ========================================
   ENGAGEMENT: Exit Intent Popup
   ======================================== */
.sp-exit-overlay {
  position: fixed;
  inset: 0;
  background: rgba(37,44,58,0.6);
  backdrop-filter: blur(4px);
  z-index: 10000;
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0;
  pointer-events: none;
  transition: opacity 0.3s;
}
.sp-exit-overlay.visible {
  opacity: 1;
  pointer-events: auto;
}
.sp-exit-modal {
  background: #fff;
  border-radius: 20px;
  padding: 48px;
  max-width: 480px;
  width: 90%;
  text-align: center;
  position: relative;
  box-shadow: 0 24px 64px rgba(0,0,0,0.2);
  transform: scale(0.9) translateY(20px);
  transition: transform 0.4s cubic-bezier(0.16,1,0.3,1);
}
.sp-exit-overlay.visible .sp-exit-modal {
  transform: scale(1) translateY(0);
}
.sp-exit-close {
  position: absolute;
  top: 16px; right: 16px;
  background: none; border: none;
  font-size: 24px; color: #bbb;
  cursor: pointer;
  transition: color 0.2s;
}
.sp-exit-close:hover { color: #252C3A; }
.sp-exit-icon {
  width: 64px; height: 64px;
  margin: 0 auto 20px;
  background: linear-gradient(135deg, rgba(133,96,168,0.1), rgba(0,191,243,0.08));
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 28px;
}
.sp-exit-modal h3 {
  font-family: 'Poppins', sans-serif;
  font-size: 24px; font-weight: 600;
  color: #252C3A; margin-bottom: 12px;
}
.sp-exit-modal p {
  font-family: 'Assistant', sans-serif;
  font-size: 16px; color: #666;
  line-height: 1.6; margin-bottom: 24px;
}
.sp-exit-form {
  display: flex; gap: 8px;
}
.sp-exit-form input {
  flex: 1;
  padding: 14px 18px;
  border: 2px solid #e8e8ec;
  border-radius: 10px;
  font-family: 'Assistant', sans-serif;
  font-size: 15px;
  outline: none;
  transition: border-color 0.2s;
}
.sp-exit-form input:focus { border-color: #8560A8; }
.sp-exit-form button {
  padding: 14px 24px;
  background: linear-gradient(135deg, #8560A8, #00BFF3);
  color: #fff;
  border: none;
  border-radius: 10px;
  font-family: 'Poppins', sans-serif;
  font-size: 14px; font-weight: 500;
  cursor: pointer;
  white-space: nowrap;
  transition: transform 0.2s, box-shadow 0.2s;
}
.sp-exit-form button:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(133,96,168,0.3);
}
.sp-exit-skip {
  display: block;
  margin-top: 16px;
  font-family: 'Assistant', sans-serif;
  font-size: 13px;
  color: #bbb;
  background: none; border: none;
  cursor: pointer;
  transition: color 0.2s;
}
.sp-exit-skip:hover { color: #8560A8; }

/* ========================================
   ENGAGEMENT: Scroll Depth Milestones
   ======================================== */
.sp-milestone-toast {
  position: fixed;
  bottom: 80px;
  left: 50%;
  transform: translateX(-50%) translateY(20px);
  background: rgba(37,44,58,0.9);
  backdrop-filter: blur(8px);
  color: #fff;
  font-family: 'Poppins', sans-serif;
  font-size: 13px;
  font-weight: 400;
  padding: 10px 20px;
  border-radius: 20px;
  z-index: 95;
  opacity: 0;
  transition: opacity 0.4s, transform 0.4s;
  pointer-events: none;
  display: flex;
  align-items: center;
  gap: 8px;
}
.sp-milestone-toast.visible {
  opacity: 1;
  transform: translateX(-50%) translateY(0);
}
.sp-milestone-toast .toast-emoji { font-size: 16px; }
@media (prefers-reduced-motion: reduce) {
  .sp-milestone-toast,
  .sp-exit-overlay,
  .sp-exit-modal,
  .sp-reaction-btn,
  .sp-copy-btn,
  .sp-reading-position { transition: none; }
}
</style>

<!-- Reading Progress Bar -->
<div class="sp-progress-bar" id="readingProgress"></div>

<!-- Reading Position Marker -->
<div class="sp-reading-position" id="readingPosition">0% through</div>

<!-- Milestone Toast -->
<div class="sp-milestone-toast" id="milestoneToast"><span class="toast-emoji"></span><span class="toast-text"></span></div>

<!-- Reading Time Pill -->
<div class="sp-read-time-pill" id="readTimePill"><span class="pill-icon"></span><span id="readTimePillText"><?php echo $read_time; ?> min left</span></div>

<!-- Text Highlight Share Tooltip -->
<div class="sp-text-share" id="textShare">
  <a id="textShareTwitter" href="#" target="_blank" rel="noopener noreferrer" title="Share on X">
    <svg viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
  </a>
  <a id="textShareLinkedIn" href="#" target="_blank" rel="noopener noreferrer" title="Share on LinkedIn">
    <svg viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
  </a>
</div>

<!-- Table of Contents Sidebar (populated via JS) -->
<nav class="sp-toc-sidebar" id="tocSidebar" aria-label="Table of contents">
  <div class="sp-toc-label">Contents</div>
  <ul class="sp-toc-list" id="tocList"></ul>

  <?php
  $current_post_id = get_the_ID();
  $saved_cat = $cat;
  if ($cat) :
    $hub_posts = new WP_Query([
        'post_type'      => 'post',
        'posts_per_page' => 10,
        'cat'            => $cat->term_id,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    ]);
    $other_cats = get_categories(['hide_empty' => true, 'exclude' => [$cat->term_id]]);
  ?>
  <div class="sp-hub-sidebar" id="hubSidebar">
    <div class="sp-toc-label">Learn</div>

    <!-- Current hub (expanded by default) -->
    <div class="sp-hub-acc">
      <div class="sp-hub-acc-trigger open">
        <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" class="sp-hub-acc-link"><?php echo esc_html($cat->name); ?></a>
        <span class="sp-hub-arrow" onclick="var t=this.parentElement;t.classList.toggle('open');var p=t.nextElementSibling;if(p.style.maxHeight){p.style.maxHeight=null}else{p.style.maxHeight=p.scrollHeight+'px'}">+</span>
      </div>
      <div class="sp-hub-acc-panel" style="max-height:500px;">
        <ul class="sp-hub-acc-list">
          <?php while ($hub_posts->have_posts()) : $hub_posts->the_post(); ?>
            <li<?php if (get_the_ID() == $current_post_id) echo ' class="current-post"'; ?>>
              <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </li>
          <?php endwhile; wp_reset_postdata(); ?>
        </ul>
      </div>
    </div>

    <!-- Other hubs (collapsed) -->
    <?php foreach ($other_cats as $ocat) :
      $ocat_posts = new WP_Query([
          'post_type'      => 'post',
          'posts_per_page' => 5,
          'cat'            => $ocat->term_id,
          'post_status'    => 'publish',
      ]);
      if ($ocat_posts->have_posts()) :
    ?>
    <div class="sp-hub-acc">
      <div class="sp-hub-acc-trigger">
        <a href="<?php echo esc_url(get_category_link($ocat->term_id)); ?>" class="sp-hub-acc-link"><?php echo esc_html($ocat->name); ?></a>
        <span class="sp-hub-arrow" onclick="var t=this.parentElement;t.classList.toggle('open');var p=t.nextElementSibling;if(p.style.maxHeight){p.style.maxHeight=null}else{p.style.maxHeight=p.scrollHeight+'px'}">+</span>
      </div>
      <div class="sp-hub-acc-panel">
        <ul class="sp-hub-acc-list">
          <?php while ($ocat_posts->have_posts()) : $ocat_posts->the_post(); ?>
            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
          <?php endwhile; wp_reset_postdata(); ?>
        </ul>
      </div>
    </div>
    <?php endif; endforeach; ?>
  </div>
  <?php endif; ?>
</nav>

<!-- ============================
     1. ARTICLE HEADER
     ============================ -->
<section class="sp-section sp-header" id="spHeader">
  <div class="sp-header-grid"><div class="sp-header-grid-inner" id="spGridInner"></div></div>
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
      <nav class="sp-breadcrumbs" aria-label="Breadcrumb">
        <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>">Blog</a>
        <span class="sp-bc-sep">/</span>
        <?php if ($cat) : ?>
          <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"><?php echo esc_html($cat->name); ?></a>
          <span class="sp-bc-sep">/</span>
        <?php endif; ?>
        <span class="sp-bc-current"><?php the_title(); ?></span>
      </nav>
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

    <!-- FAQ (inside article, before conclusion) -->
    <div class="sp-faq-inline" style="margin: 48px 0 0; padding: 40px 0 0; border-top: 1px solid rgba(133,96,168,0.1);">
      <h2 style="text-align:center; margin-bottom:32px;">Frequently Asked Questions</h2>
      <?php
      $faqs = [];
      if ($cat && stripos($cat->name, 'AEO') !== false) {
          $faqs = [
              ['What is Answer Engine Optimization?', 'AEO is the practice of optimizing content to be cited by AI-powered answer engines like ChatGPT, Gemini, and Perplexity. Unlike traditional SEO which focuses on ranking in search results, AEO focuses on getting your content referenced in AI-generated responses.'],
              ['How is AEO different from SEO?', 'While SEO targets rankings in traditional search engine results pages, AEO targets citations in AI-generated answers. SEO relies heavily on backlinks and keyword optimization, while AEO prioritizes content structure, definitiveness, and expertise signals.'],
              ['How long does it take to see results from AEO?', 'AEO results can vary, but most brands start seeing increased AI citations within 3-6 months of implementing structured content strategies. The key is consistency in producing authoritative, well-structured content.'],
              ['Do I need AEO if I already do SEO?', 'Yes. As AI answer engines capture more search queries, brands that only optimize for traditional search risk losing visibility. AEO and SEO work together — many SEO best practices support AEO, but AEO requires additional focus on content structure and definitiveness.'],
              ['Can Stretch Creative help with AEO?', 'Absolutely. Our content strategy team specializes in creating structured, authoritative content optimized for both traditional search engines and AI answer engines. We help brands build topical authority and get cited in AI responses.'],
          ];
      } else {
          $faqs = [
              ['How does content marketing drive business growth?', 'Quality content builds brand authority, drives organic traffic, and nurtures leads through the sales funnel. Consistently publishing valuable, relevant content positions your brand as a trusted resource in your industry.'],
              ['How long does it take to see results from content marketing?', 'Most content marketing strategies begin showing measurable results within 3-6 months. SEO-focused content may take longer to rank, but the compounding effect of consistent publishing accelerates results over time.'],
              ['What types of content does Stretch Creative produce?', 'We produce everything from blog articles and buying guides to product descriptions, ebooks, email campaigns, SEO content, video scripts, and more. Our team of 200+ creatives covers virtually every content need.'],
              ['How do you maintain quality at scale?', 'We build dedicated writer cohorts calibrated to your brand voice. Each team goes through a calibration process, and every piece passes through editorial quality checks before delivery. Quality never compromises, regardless of volume.'],
              ['What industries do you work with?', 'We work across ecommerce, SaaS, healthcare, finance, retail, publishing, and many more. Our writers have deep expertise across industries, and we match your project with writers who understand your space.'],
          ];
      }
      foreach ($faqs as $faq) : ?>
      <div class="sp-faq-item">
        <button class="sp-faq-trigger" onclick="this.classList.toggle('open');var a=this.nextElementSibling;if(a.style.maxHeight){a.style.maxHeight=null}else{a.style.maxHeight=a.scrollHeight+'px'}">
          <?php echo esc_html($faq[0]); ?>
          <span class="sp-faq-icon">+</span>
        </button>
        <div class="sp-faq-answer">
          <div class="sp-faq-answer-inner"><?php echo esc_html($faq[1]); ?></div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- Inline horizontal share bar -->
    <div class="sp-share-inline">
      <span class="sp-share-inline-label">Share</span>
      <a href="https://twitter.com/intent/tweet?url=<?php echo $share_url; ?>&text=<?php echo $share_title; ?>" target="_blank" rel="noopener noreferrer" class="sp-share-btn" title="Share on X">
        <svg viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
      </a>
      <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $share_url; ?>" target="_blank" rel="noopener noreferrer" class="sp-share-btn" title="Share on LinkedIn">
        <svg viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
      </a>
      <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $share_url; ?>" target="_blank" rel="noopener noreferrer" class="sp-share-btn" title="Share on Facebook">
        <svg viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
      </a>
      <button class="sp-share-btn" title="Copy link" onclick="navigator.clipboard.writeText(window.location.href);this.innerHTML='&#10003;';var btn=this;setTimeout(function(){btn.innerHTML='<svg viewBox=\'0 0 24 24\'><path d=\'M13.723 18.654l-3.61 3.609c-2.316 2.315-6.063 2.315-8.378 0-2.315-2.316-2.315-6.062 0-8.377l3.61-3.609c2.316-2.315 6.063-2.315 8.378 0 .542.541.961 1.174 1.257 1.858l-1.633 1.129c-.157-.474-.42-.911-.789-1.28-1.536-1.536-4.025-1.536-5.561 0l-3.61 3.61c-1.536 1.535-1.536 4.025 0 5.56 1.536 1.536 4.025 1.536 5.561 0l2.643-2.643c.65.187 1.322.27 1.988.255z\'/><path d=\'M19.265 1.736c-2.316-2.315-6.063-2.315-8.378 0l-3.61 3.609c-.542.541-.961 1.174-1.257 1.858l1.633 1.129c.157-.474.42-.911.789-1.28l3.61-3.61c1.536-1.535 4.025-1.535 5.561 0 1.536 1.536 1.536 4.025 0 5.561l-3.61 3.61c-1.536 1.535-4.025 1.535-5.561 0-.157-.157-.3-.324-.427-.499l-1.633 1.129c.341.498.752.955 1.234 1.354l.223.196.003.003c2.298 2.143 5.903 2.07 8.117-.282l3.61-3.609c2.316-2.316 2.316-6.063 0-8.378z\'/></svg>'},2000)">
        <svg viewBox="0 0 24 24"><path d="M13.723 18.654l-3.61 3.609c-2.316 2.315-6.063 2.315-8.378 0-2.315-2.316-2.315-6.062 0-8.377l3.61-3.609c2.316-2.315 6.063-2.315 8.378 0 .542.541.961 1.174 1.257 1.858l-1.633 1.129c-.157-.474-.42-.911-.789-1.28-1.536-1.536-4.025-1.536-5.561 0l-3.61 3.61c-1.536 1.535-1.536 4.025 0 5.56 1.536 1.536 4.025 1.536 5.561 0l2.643-2.643c.65.187 1.322.27 1.988.255z"/><path d="M19.265 1.736c-2.316-2.315-6.063-2.315-8.378 0l-3.61 3.609c-.542.541-.961 1.174-1.257 1.858l1.633 1.129c.157-.474.42-.911.789-1.28l3.61-3.61c1.536-1.535 4.025-1.535 5.561 0 1.536 1.536 1.536 4.025 0 5.561l-3.61 3.61c-1.536 1.535-4.025 1.535-5.561 0-.157-.157-.3-.324-.427-.499l-1.633 1.129c.341.498.752.955 1.234 1.354l.223.196.003.003c2.298 2.143 5.903 2.07 8.117-.282l3.61-3.609c2.316-2.316 2.316-6.063 0-8.378z"/></svg>
      </button>
    </div>
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
        <div style="display:flex;gap:16px;align-items:center;margin-top:8px;">
          <a href="<?php echo esc_url(get_author_posts_url($author_id)); ?>" class="sp-author-link">View all posts &rarr;</a>
          <?php $linkedin = get_the_author_meta('linkedin'); if ($linkedin) : ?>
            <a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener" class="sp-author-link" style="display:inline-flex;align-items:center;gap:6px;">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
              LinkedIn
            </a>
          <?php endif; ?>
        </div>
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

<!-- ============================
     6. MORE FROM THIS HUB
     ============================ -->
<?php
wp_reset_postdata();
$cat = $saved_cat; // Restore category after sub-queries
$more_hub = new WP_Query([
    'post_type'      => 'post',
    'posts_per_page' => 4,
    'post__not_in'   => [$current_post_id],
    'cat'            => $cat ? $cat->term_id : 0,
    'post_status'    => 'publish',
]);
if ($more_hub->have_posts() && $cat) :
?>
<section class="sp-section sp-more-hub">
  <div class="sp-angle-divider" style="top:-1px;bottom:auto;">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none"><polygon points="0,0 1440,0 0,60" fill="#f9f9fb"/></svg>
  </div>
  <div class="sp-container">
    <h2 class="sp-related-heading sp-reveal">More from <?php echo esc_html($cat->name); ?></h2>
    <div class="sp-hub-grid">
      <?php while ($more_hub->have_posts()) : $more_hub->the_post(); ?>
      <a href="<?php the_permalink(); ?>" class="sp-hub-card sp-reveal">
        <div class="sp-hub-card-img">
          <?php if (has_post_thumbnail()) : the_post_thumbnail('blog-card'); else : ?>
            <div class="fallback-gradient">Stretch</div>
          <?php endif; ?>
        </div>
        <div class="sp-hub-card-body">
          <h3><?php the_title(); ?></h3>
          <span class="sp-hub-card-meta"><?php echo get_the_date(); ?> &middot; <?php echo ceil(str_word_count(strip_tags(get_the_content())) / 250); ?> min</span>
        </div>
      </a>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php endwhile; ?>

<!-- ============================
     7. RELATED POSTS
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
  // Hero grid generation
  var gridInner = document.getElementById('spGridInner');
  if (gridInner) {
    var cellSize = 60;
    var cols = Math.ceil((window.innerWidth + 120) / cellSize);
    var rows = Math.ceil((window.innerHeight * 0.6 + 120) / cellSize);
    var total = cols * rows;
    var coloredCount = Math.floor(total * 0.18);
    var gradients = [
      'rgba(133,96,168,0.18)', 'rgba(133,96,168,0.14)',
      'rgba(86,116,185,0.16)', 'rgba(86,116,185,0.12)',
      'rgba(0,191,243,0.14)', 'rgba(0,191,243,0.10)',
      'rgba(68,140,203,0.14)', 'rgba(133,96,168,0.22)',
      'rgba(0,191,243,0.18)'
    ];
    var coloredSet = new Set();
    while (coloredSet.size < coloredCount) coloredSet.add(Math.floor(Math.random() * total));
    var frag = document.createDocumentFragment();
    for (var i = 0; i < total; i++) {
      var cell = document.createElement('div');
      cell.className = 'sp-grid-cell';
      if (coloredSet.has(i)) {
        cell.classList.add('colored');
        cell.style.setProperty('--cell-color', gradients[Math.floor(Math.random() * gradients.length)]);
        cell.style.setProperty('--cell-delay', (Math.random() * 4).toFixed(1) + 's');
      }
      frag.appendChild(cell);
    }
    gridInner.appendChild(frag);

    // Mouse parallax on hero grid
    var spHeader = document.getElementById('spHeader');
    if (spHeader && !('ontouchstart' in window) && window.innerWidth > 768) {
      spHeader.addEventListener('mousemove', function(e) {
        var rect = spHeader.getBoundingClientRect();
        var mx = ((e.clientX - rect.left) / rect.width - 0.5) * 2;
        var my = ((e.clientY - rect.top) / rect.height - 0.5) * 2;
        gridInner.style.transform = 'translate(' + (mx * 15) + 'px, ' + (my * 15) + 'px)';
      });
      spHeader.addEventListener('mouseleave', function() {
        gridInner.style.transform = 'translate(0, 0)';
      });
    }
  }

  // Gradient border fill on scroll — for CTA cards and featured image
  if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    function updateFigureBorders() {
      // Re-query each time to catch dynamically injected elements
      var borderEls = document.querySelectorAll('.sp-gradient-border, .sp-featured-img');
      borderEls.forEach(function(fig) {
        var rect = fig.getBoundingClientRect();
        var viewH = window.innerHeight;

        // Start filling when figure enters bottom 80% of viewport
        // Complete when figure center reaches viewport center
        var figCenter = rect.top + rect.height / 2;
        var startPoint = viewH * 0.85;
        var endPoint = viewH * 0.4;

        if (rect.top < startPoint && rect.bottom > 0) {
          var progress = Math.min(1, Math.max(0, (startPoint - figCenter) / (startPoint - endPoint)));
          var pct = Math.round(progress * 100);

          if (pct >= 100) {
            fig.classList.remove('border-active');
            fig.classList.add('border-complete');
          } else if (pct > 0) {
            fig.classList.add('border-active');
            fig.classList.remove('border-complete');
            fig.style.setProperty('--sp-border-progress', pct + '%');
          }
        } else {
          fig.classList.remove('border-active', 'border-complete');
        }
      });
    }

    window.addEventListener('scroll', function() {
      requestAnimationFrame(updateFigureBorders);
    }, { passive: true });
    updateFigureBorders();
  }

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
  var article = document.querySelector('.sp-article');
  if (shareBar && article) {
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

  // ========================================
  // READING PROGRESS BAR
  // ========================================
  var progressBar = document.getElementById('readingProgress');
  var contentSection = document.querySelector('.sp-content-section');
  if (progressBar && contentSection) {
    window.addEventListener('scroll', function() {
      var rect = contentSection.getBoundingClientRect();
      var sectionTop = rect.top + window.scrollY;
      var sectionHeight = contentSection.offsetHeight;
      var scrolled = window.scrollY - sectionTop;
      var progress = Math.max(0, Math.min(100, (scrolled / (sectionHeight - window.innerHeight)) * 100));
      progressBar.style.width = progress + '%';
    }, { passive: true });
  }

  // ========================================
  // TABLE OF CONTENTS — Auto-generated
  // ========================================
  var tocSidebar = document.getElementById('tocSidebar');
  var tocList = document.getElementById('tocList');
  if (article && tocSidebar && tocList) {
    var headings = article.querySelectorAll('h2');
    if (headings.length > 1) {
      // Build TOC items
      headings.forEach(function(h2, index) {
        if (!h2.id) {
          h2.id = 'section-' + (index + 1);
        }
        var li = document.createElement('li');
        li.className = 'sp-toc-item';
        li.setAttribute('data-target', h2.id);
        var a = document.createElement('a');
        a.href = '#' + h2.id;
        a.textContent = h2.textContent;
        a.addEventListener('click', function(e) {
          e.preventDefault();
          document.getElementById(h2.id).scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
        li.appendChild(a);
        tocList.appendChild(li);
      });

      // Show/hide TOC — only visible while scrolling through article content
      var hubSidebar = document.getElementById('hubSidebar');
      function updateTocVisibility() {
        var rect = article.getBoundingClientRect();
        var articleTop = rect.top;
        var articleBottom = rect.bottom - 300; // hide 300px before article ends
        if (articleTop < window.innerHeight * 0.5 && articleBottom > 100) {
          tocSidebar.classList.add('visible');
          if (hubSidebar) { hubSidebar.style.opacity = '1'; }
        } else {
          tocSidebar.classList.remove('visible');
          if (hubSidebar) { hubSidebar.style.opacity = '0'; }
        }
      }
      window.addEventListener('scroll', function() {
        requestAnimationFrame(updateTocVisibility);
      }, { passive: true });
      updateTocVisibility();

      // Highlight active section with IntersectionObserver
      var tocItems = tocList.querySelectorAll('.sp-toc-item');
      var sectionObserver = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
          if (entry.isIntersecting) {
            tocItems.forEach(function(item) { item.classList.remove('active'); });
            var activeItem = tocList.querySelector('[data-target="' + entry.target.id + '"]');
            if (activeItem) activeItem.classList.add('active');
          }
        });
      }, { rootMargin: '-80px 0px -70% 0px', threshold: 0 });

      headings.forEach(function(h2) {
        sectionObserver.observe(h2);
      });

      // Activate first item by default
      if (tocItems.length > 0) tocItems[0].classList.add('active');
    } else {
      // Not enough headings, hide TOC
      tocSidebar.style.display = 'none';
    }
  }

  // ========================================
  // ENGAGEMENT FEATURES
  // ========================================
  var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  // --- 1. Reading Time Pill ---
  var readTimePill = document.getElementById('readTimePill');
  var readTimePillText = document.getElementById('readTimePillText');
  var totalReadTime = <?php echo $read_time; ?>;
  var stickyCtaEl = document.getElementById('stickyCta');
  var nextArticleEl = document.getElementById('nextArticle');
  var stickyCtaClosed = false;
  var nextArticleClosed = false;

  // Listen for close button clicks
  if (stickyCtaEl) {
    stickyCtaEl.querySelector('.sp-sticky-cta-close').addEventListener('click', function() {
      stickyCtaClosed = true;
    });
  }
  if (nextArticleEl) {
    nextArticleEl.querySelector('.sp-next-article-close').addEventListener('click', function() {
      nextArticleClosed = true;
    });
  }

  if (readTimePill && article && contentSection && !reducedMotion) {
    window.addEventListener('scroll', function() {
      requestAnimationFrame(function() {
        var rect = contentSection.getBoundingClientRect();
        var sectionTop = rect.top + window.scrollY;
        var sectionHeight = contentSection.offsetHeight;
        var scrolled = window.scrollY - sectionTop;
        var progress = Math.max(0, Math.min(1, scrolled / (sectionHeight - window.innerHeight)));
        var minutesLeft = Math.max(0, Math.ceil(totalReadTime * (1 - progress)));

        // Check if article is in view
        var articleRect = article.getBoundingClientRect();
        var articleInView = articleRect.top < window.innerHeight && articleRect.bottom > 0;

        // Check if sticky CTA or next article is showing
        var bottomBarVisible = (stickyCtaEl && stickyCtaEl.classList.contains('visible')) ||
                               (nextArticleEl && nextArticleEl.classList.contains('visible'));

        if (articleInView && !bottomBarVisible && minutesLeft > 0) {
          readTimePillText.textContent = minutesLeft + ' min left';
          readTimePill.classList.add('visible');
        } else {
          readTimePill.classList.remove('visible');
        }
      });
    }, { passive: true });
  }

  // --- 2. Inline Content Upgrade CTA ---
  if (article) {
    var articleH2s = article.querySelectorAll('h2');
    if (articleH2s.length >= 3) {
      var upgradeBox = document.createElement('div');
      upgradeBox.className = 'sp-content-upgrade sp-gradient-border sp-reveal';
      upgradeBox.innerHTML = '<div class="sp-content-upgrade-inner">'
          + '<div class="sp-content-upgrade-overline">Free Consultation</div>'
          + '<h3>Want us to build a content strategy for your brand?</h3>'
          + '<p>Our team of 200+ creatives can help you dominate organic search and get cited by AI answer engines. Let\'s talk about your goals.</p>'
          + '<a href="/contact-stretch-creative/" class="sp-content-upgrade-btn">Book a Free Consult \u2192</a>'
          + '</div>';
      articleH2s[2].parentNode.insertBefore(upgradeBox, articleH2s[2]);
      // Observe for reveal animation
      observer.observe(upgradeBox);
    }
  }

  // --- 3. Text Highlight Share ---
  var textShareEl = document.getElementById('textShare');
  var textShareTwitter = document.getElementById('textShareTwitter');
  var textShareLinkedIn = document.getElementById('textShareLinkedIn');
  if (textShareEl && article && !reducedMotion) {
    article.addEventListener('mouseup', function(e) {
      var selection = window.getSelection();
      var selectedText = selection.toString().trim();
      if (selectedText.length > 5) {
        var range = selection.getRangeAt(0);
        var rect = range.getBoundingClientRect();
        var pageUrl = encodeURIComponent(window.location.href);
        var encodedText = encodeURIComponent(selectedText.substring(0, 280));

        textShareTwitter.href = 'https://twitter.com/intent/tweet?text=' + encodedText + '&url=' + pageUrl;
        textShareLinkedIn.href = 'https://www.linkedin.com/sharing/share-offsite/?url=' + pageUrl;

        textShareEl.style.top = (rect.top + window.scrollY - 56) + 'px';
        textShareEl.style.left = (rect.left + rect.width / 2 - 44) + 'px';
        textShareEl.classList.add('visible');
      } else {
        textShareEl.classList.remove('visible');
      }
    });

    document.addEventListener('mousedown', function(e) {
      if (!textShareEl.contains(e.target)) {
        textShareEl.classList.remove('visible');
      }
    });
  }

  // --- 4. Sticky CTA Bar & 6. Next Article Teaser ---
  if (contentSection && !reducedMotion) {
    window.addEventListener('scroll', function() {
      requestAnimationFrame(function() {
        var rect = contentSection.getBoundingClientRect();
        var sectionTop = rect.top + window.scrollY;
        var sectionHeight = contentSection.offsetHeight;
        var scrolled = window.scrollY - sectionTop;
        var progress = Math.max(0, Math.min(1, scrolled / (sectionHeight - window.innerHeight)));

        // Next article: show at 90%+, hide below 80%
        if (nextArticleEl && !nextArticleClosed) {
          if (progress >= 0.9) {
            nextArticleEl.classList.add('visible');
            // Hide sticky CTA when next article shows
            if (stickyCtaEl) stickyCtaEl.classList.remove('visible');
          } else if (progress < 0.8) {
            nextArticleEl.classList.remove('visible');
          }
        }

        // Sticky CTA: show 60%-90%, hide below 40% or above 90%
        if (stickyCtaEl && !stickyCtaClosed) {
          var nextArticleShowing = nextArticleEl && nextArticleEl.classList.contains('visible');
          if (progress >= 0.6 && progress < 0.9 && !nextArticleShowing) {
            stickyCtaEl.classList.add('visible');
          } else if (progress < 0.4 || progress >= 0.9) {
            stickyCtaEl.classList.remove('visible');
          }
        }
      });
    }, { passive: true });
  }

  // --- 5. Key Takeaway Boxes ---
  if (article) {
    var h2sForTakeaway = article.querySelectorAll('h2');
    var takeaways = [
      { index: 0, text: 'AEO is the practice of structuring content so AI-powered engines cite your brand \u2014 it\u2019s becoming as essential as traditional SEO.' },
      { index: 3, text: 'Structure your content with clear headings, lead with answers, and build topical authority through content clusters.' }
    ];
    takeaways.forEach(function(tk) {
      if (h2sForTakeaway.length > tk.index) {
        var h2El = h2sForTakeaway[tk.index];
        // Find the first paragraph sibling after this h2
        var nextEl = h2El.nextElementSibling;
        while (nextEl && nextEl.tagName !== 'P') {
          nextEl = nextEl.nextElementSibling;
        }
        if (nextEl) {
          var takeawayBox = document.createElement('div');
          takeawayBox.className = 'sp-key-takeaway sp-reveal';
          takeawayBox.innerHTML = '<div class="sp-key-takeaway-label">Key Takeaway</div>'
              + '<p>' + tk.text + '</p>';
          nextEl.parentNode.insertBefore(takeawayBox, nextEl.nextSibling);
          observer.observe(takeawayBox);
        }
      }
    });
  }

  // ========================================
  // ELITE ENGAGEMENT FEATURES
  // ========================================
  var isTouchDevice = ('ontouchstart' in window) || (navigator.maxTouchPoints > 0);

  // --- E1. Animated Section Dividers (disabled) ---
  if (false && article && !reducedMotion) {
    var articleH2sForDividers = article.querySelectorAll('h2');
    var dividerObserver = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('drawn');
          dividerObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.2 });

    articleH2sForDividers.forEach(function(h2, idx) {
      if (idx === 0) return; // skip first h2
      var divider = document.createElement('div');
      divider.className = 'sp-section-divider';
      h2.parentNode.insertBefore(divider, h2);
      dividerObserver.observe(divider);
    });
  }

  // --- E2. Custom Illustrated Icons on H2 Headings (disabled) ---
  if (false && article) {
    var iconMap = [
      { keywords: ['what', 'introduction', 'overview'], svg: '<svg viewBox="0 0 24 24" fill="none" stroke="#8560A8" stroke-width="1.5"><path d="M9 21h6M12 3a6 6 0 014 10.47V17a1 1 0 01-1 1h-6a1 1 0 01-1-1v-3.53A6 6 0 0112 3z"/></svg>' },
      { keywords: ['seo', 'search', 'ranking'], svg: '<svg viewBox="0 0 24 24" fill="none" stroke="#5674B9" stroke-width="1.5"><circle cx="11" cy="11" r="7"/><path d="M16 16l4.5 4.5"/></svg>' },
      { keywords: ['ai', 'answer engine', 'machine', 'how'], svg: '<svg viewBox="0 0 24 24" fill="none" stroke="#448CCB" stroke-width="1.5"><circle cx="6" cy="6" r="2"/><circle cx="18" cy="6" r="2"/><circle cx="6" cy="18" r="2"/><circle cx="18" cy="18" r="2"/><circle cx="12" cy="12" r="2"/><path d="M8 6h8M6 8v8M18 8v8M8 18h8M8 8l2.5 2.5M16 8l-2.5 2.5M8 16l2.5-2.5M16 16l-2.5-2.5"/></svg>' },
      { keywords: ['strategy', 'key', 'steps', 'tips'], svg: '<svg viewBox="0 0 24 24" fill="none" stroke="#00BFF3" stroke-width="1.5"><path d="M4 7h4M4 12h4M4 17h4M12 7h8M12 12h8M12 17h8"/><path d="M2 7l1 1 2-2M2 12l1 1 2-2M2 17l1 1 2-2" stroke-linecap="round" stroke-linejoin="round"/></svg>' },
      { keywords: ['measure', 'success', 'result', 'impact'], svg: '<svg viewBox="0 0 24 24" fill="none" stroke="#8560A8" stroke-width="1.5"><path d="M4 20h16M4 20V10l4-3 4 5 4-7 4 4v11"/></svg>' },
      { keywords: ['start', 'getting', 'begin', 'future'], svg: '<svg viewBox="0 0 24 24" fill="none" stroke="#00BFF3" stroke-width="1.5"><path d="M12 2C6 8 6 14 6 14h12s0-6-6-12zM6 14l-2 4 4-2M18 14l2 4-4-2M10 16v4M14 16v4"/></svg>' },
      { keywords: ['vs', 'comparison', 'difference'], svg: '<svg viewBox="0 0 24 24" fill="none" stroke="#5674B9" stroke-width="1.5"><path d="M12 3v18M4 7l8-4 8 4M4 7l2 6h-4M20 7l-2 6h4"/><circle cx="4" cy="13" r="0.5" fill="#5674B9"/><circle cx="20" cy="13" r="0.5" fill="#5674B9"/></svg>' },
      { keywords: ['faq', 'question'], svg: '<svg viewBox="0 0 24 24" fill="none" stroke="#448CCB" stroke-width="1.5"><circle cx="12" cy="12" r="9"/><path d="M9 9a3 3 0 114 2.83V14"/><circle cx="12" cy="17" r="0.5" fill="#448CCB"/></svg>' }
    ];
    var defaultIcon = '<svg viewBox="0 0 24 24" fill="none" stroke="#8560A8" stroke-width="1.5"><path d="M12 2l2.9 5.9 6.5.9-4.7 4.6 1.1 6.5L12 17l-5.8 3-1.1-6.5L.4 8.8l6.5-.9z"/></svg>';

    var allH2sForIcons = article.querySelectorAll('h2');
    allH2sForIcons.forEach(function(h2) {
      var text = h2.textContent.toLowerCase();
      var matchedSvg = defaultIcon;
      for (var i = 0; i < iconMap.length; i++) {
        var found = false;
        for (var j = 0; j < iconMap[i].keywords.length; j++) {
          if (text.indexOf(iconMap[i].keywords[j]) !== -1) {
            found = true;
            break;
          }
        }
        if (found) {
          matchedSvg = iconMap[i].svg;
          break;
        }
      }
      var iconSpan = document.createElement('span');
      iconSpan.className = 'sp-heading-icon';
      iconSpan.innerHTML = matchedSvg;
      h2.insertBefore(iconSpan, h2.firstChild);
    });
  }

  // --- E3. Reading Position Marker ---
  var readingPosEl = document.getElementById('readingPosition');
  if (readingPosEl && article && contentSection) {
    window.addEventListener('scroll', function() {
      requestAnimationFrame(function() {
        var rect = contentSection.getBoundingClientRect();
        var sTop = rect.top + window.scrollY;
        var sHeight = contentSection.offsetHeight;
        var scrolled = window.scrollY - sTop;
        var pct = Math.max(0, Math.min(100, Math.round((scrolled / (sHeight - window.innerHeight)) * 100)));

        var articleRect = article.getBoundingClientRect();
        var inView = articleRect.top < window.innerHeight && articleRect.bottom > 0;

        if (inView && pct > 0 && pct < 100) {
          readingPosEl.textContent = pct + '% through';
          readingPosEl.classList.add('visible');
        } else {
          readingPosEl.classList.remove('visible');
        }
      });
    }, { passive: true });
  }

  // --- E4. Interactive Comparison Table ---
  if (article) {
    var tableRows = article.querySelectorAll('table tbody tr');
    tableRows.forEach(function(row) {
      row.addEventListener('click', function() {
        var wasHighlighted = row.classList.contains('highlighted');
        // Remove from all rows in same table
        var tbody = row.parentElement;
        tbody.querySelectorAll('tr.highlighted').forEach(function(r) {
          r.classList.remove('highlighted');
        });
        if (!wasHighlighted) {
          row.classList.add('highlighted');
        }
      });
    });
  }

  // --- E5. Copy Button on Quotes and Takeaways ---
  if (article) {
    var copyTargets = article.querySelectorAll('blockquote, .wp-block-pullquote, .pullquote, .sp-key-takeaway');
    copyTargets.forEach(function(el) {
      el.style.position = 'relative';
      var btn = document.createElement('button');
      btn.className = 'sp-copy-btn';
      btn.textContent = 'Copy';
      btn.addEventListener('click', function(e) {
        e.stopPropagation();
        var textContent = el.textContent.replace(/^Copy/, '').replace(/^Copied!/, '').trim();
        navigator.clipboard.writeText(textContent);
        btn.textContent = 'Copied!';
        btn.classList.add('copied');
        setTimeout(function() {
          btn.textContent = 'Copy';
          btn.classList.remove('copied');
        }, 2000);
      });
      el.appendChild(btn);
    });
  }

  // --- E6. Reaction Buttons ---
  var reactionBtns = document.querySelectorAll('.sp-reaction-btn');
  var reactionThanks = document.getElementById('reactionThanks');
  if (reactionBtns.length && reactionThanks) {
    reactionBtns.forEach(function(btn) {
      btn.addEventListener('click', function() {
        var wasSelected = btn.classList.contains('selected');
        reactionBtns.forEach(function(b) { b.classList.remove('selected'); });
        if (!wasSelected) {
          btn.classList.add('selected');
          reactionThanks.classList.add('visible');
          // Bounce animation
          btn.style.transform = 'scale(1.3)';
          setTimeout(function() { btn.style.transform = ''; }, 200);
        } else {
          reactionThanks.classList.remove('visible');
        }
      });
    });
  }

  // --- E7. Exit Intent Popup ---
  var exitOverlay = document.getElementById('exitOverlay');
  if (exitOverlay && !isTouchDevice) {
    var exitShown = false;
    var exitScrollThreshold = 0.3;

    function closeExitPopup() {
      exitOverlay.classList.remove('visible');
    }

    document.getElementById('exitClose').addEventListener('click', closeExitPopup);
    document.getElementById('exitSkip').addEventListener('click', closeExitPopup);
    exitOverlay.addEventListener('click', function(e) {
      if (e.target === exitOverlay) closeExitPopup();
    });

    document.addEventListener('mouseleave', function(e) {
      if (exitShown) return;
      if (e.clientY >= 10) return;

      // Check scroll progress
      if (contentSection) {
        var rect = contentSection.getBoundingClientRect();
        var sTop = rect.top + window.scrollY;
        var sHeight = contentSection.offsetHeight;
        var scrolled = window.scrollY - sTop;
        var progress = Math.max(0, Math.min(1, scrolled / (sHeight - window.innerHeight)));
        if (progress < exitScrollThreshold) return;
      }

      exitShown = true;
      exitOverlay.classList.add('visible');
    });
  }

  // --- E8. Scroll Depth Milestones (disabled) ---
  var milestoneToast = document.getElementById('milestoneToast');
  if (false && milestoneToast && contentSection) {
    var milestone50 = false;
    var milestone80 = false;

    function showMilestone(emoji, text) {
      milestoneToast.querySelector('.toast-emoji').textContent = emoji;
      milestoneToast.querySelector('.toast-text').textContent = text;
      milestoneToast.classList.add('visible');
      setTimeout(function() {
        milestoneToast.classList.remove('visible');
      }, 3000);
    }

    window.addEventListener('scroll', function() {
      requestAnimationFrame(function() {
        var rect = contentSection.getBoundingClientRect();
        var sTop = rect.top + window.scrollY;
        var sHeight = contentSection.offsetHeight;
        var scrolled = window.scrollY - sTop;
        var progress = Math.max(0, Math.min(1, scrolled / (sHeight - window.innerHeight)));

        if (!milestone50 && progress >= 0.5) {
          milestone50 = true;
          showMilestone('\uD83D\uDD25', "You're halfway through!");
        }
        if (!milestone80 && progress >= 0.8) {
          milestone80 = true;
          showMilestone('\uD83C\uDFAF', 'Almost there \u2014 keep going!');
        }
      });
    }, { passive: true });
  }
})();
</script>

<!-- Sticky CTA Bar -->
<div class="sp-sticky-cta" id="stickyCta">
  <span class="sp-sticky-cta-text">Need help with <strong>content strategy</strong>?</span>
  <a href="/contact-stretch-creative/" class="sp-sticky-cta-btn">Talk to Our Team &rarr;</a>
  <button class="sp-sticky-cta-close" onclick="this.parentElement.style.display='none'" aria-label="Close">&times;</button>
</div>

<!-- Next Article Teaser -->
<?php
$next_post = get_adjacent_post(true, '', false, 'category');
if (!$next_post) {
    $next_post = get_adjacent_post(true, '', true, 'category');
}
if ($next_post) :
?>
<div class="sp-next-article" id="nextArticle">
  <div>
    <div class="sp-next-article-label">Next Article</div>
  </div>
  <?php if (has_post_thumbnail($next_post->ID)) : ?>
  <div class="sp-next-article-img">
    <?php echo get_the_post_thumbnail($next_post->ID, 'thumbnail'); ?>
  </div>
  <?php endif; ?>
  <div class="sp-next-article-text">
    <a href="<?php echo get_permalink($next_post->ID); ?>" class="sp-next-article-title"><?php echo esc_html($next_post->post_title); ?></a>
  </div>
  <button class="sp-next-article-close" onclick="this.parentElement.style.display='none'" aria-label="Close">&times;</button>
</div>
<?php endif; ?>

<!-- Exit Intent Overlay -->
<div class="sp-exit-overlay" id="exitOverlay">
  <div class="sp-exit-modal">
    <button class="sp-exit-close" id="exitClose">&times;</button>
    <div class="sp-exit-icon">&#128203;</div>
    <h3>Before you go...</h3>
    <p>Get our free AEO checklist &mdash; 15 actionable steps to get your content cited by AI answer engines.</p>
    <div class="sp-exit-form">
      <input type="email" placeholder="your@email.com" aria-label="Email">
      <button type="button" onclick="this.textContent='Sent! \u2713';this.style.background='#28c840';">Get It Free</button>
    </div>
    <button class="sp-exit-skip" id="exitSkip">No thanks, I'll figure it out myself</button>
  </div>
</div>

<?php get_footer(); ?>
