<?php
/**
 * Template: Blog Posts Index (/blog/)
 *
 * WordPress uses home.php for the posts index when page_for_posts is set,
 * which supersedes any page template assigned to the Blog page. Delegate to
 * the Blog Home template so there's a single source of truth.
 */
require __DIR__ . '/page-blog-home.php';
