# Stretch Creative WordPress Theme — Design Spec

## Overview

Build a custom WordPress theme for Stretch Creative (stretchcreative.co) based on the approved landing page prototype (`bespoke-content-experience.html`). The theme replaces an existing Elementor-based WordPress site with a clean, ACF-powered architecture that gives the client a simple editing experience while maintaining full design control.

## Goals

- Replicate the prototype's design system across the full site
- Provide a form-based editing UI (ACF) for all page content — no code required
- Support the current sitemap: Homepage, About, Team, Solutions (+ sub-pages), Services (+ sub-pages), Blog, Contact
- Use a flexible content architecture so any page can mix and match section types
- Keep the theme lightweight, fast, and free of page-builder dependencies
- Lay groundwork for a future client portal (auth, dashboard, Notion sync, chat, files, reports)

## Architecture

### Approach: Classic ACF Theme on Underscores (_s)

- **Starter:** Underscores (_s) — stripped to essentials
- **Content management:** ACF Pro with Flexible Content fields
- **Blog editing:** Standard Gutenberg editor, styled to match the theme
- **Global settings:** WordPress Customizer for brand colors, fonts, logos
- **No page builders.** Elementor is removed entirely.

### Theme Directory Structure

```
stretch-theme/
├── style.css                    # Theme declaration + minimal base
├── functions.php                # Setup, enqueues, ACF registration, menus, customizer
├── header.php                   # Fixed nav with scroll behavior
├── footer.php                   # Multi-column footer
├── index.php                    # Fallback
├── front-page.php               # Homepage (ACF flexible content)
├── page.php                     # Standard page (ACF flexible content)
├── page-portal.php              # Future portal template (full-width, minimal chrome)
├── single.php                   # Single blog post
├── archive.php                  # Blog archive with category filters
├── search.php                   # Search results
├── 404.php                      # Not found
├── assets/
│   ├── css/
│   │   └── theme.css            # Full design system stylesheet
│   ├── js/
│   │   └── theme.js             # Scroll reveal, nav scroll, animations
│   └── images/                  # Theme images (placeholder fallbacks, icons)
├── template-parts/
│   └── sections/                # One PHP file per ACF flexible content layout
│       ├── hero.php
│       ├── content-block.php
│       ├── card-grid.php
│       ├── pull-quote-banner.php
│       ├── logo-carousel.php
│       ├── testimonials.php
│       ├── process-steps.php
│       ├── cta-section.php
│       ├── image-text.php
│       ├── accordion-faq.php
│       ├── team-grid.php
│       ├── contact-block.php
│       └── blog-preview.php
├── acf-json/                    # ACF field group JSON exports (version controlled)
└── inc/
    ├── customizer.php           # Theme Customizer settings
    ├── acf-fields.php           # ACF field group registration (PHP fallback)
    └── theme-setup.php          # Menus, image sizes, theme supports
```

## Design System

Extracted from the approved prototype. These become CSS custom properties and Customizer defaults.

### Colors

| Token              | Default   | Usage                           |
|--------------------|-----------|---------------------------------|
| `--color-purple`   | `#8560A8` | Primary brand, buttons, accents |
| `--color-blue`     | `#5674B9` | Secondary accent                |
| `--color-mid-blue` | `#448CCB` | Gradient midpoints              |
| `--color-cyan`     | `#00BFF3` | Highlight accent, links         |
| `--color-dark`     | `#252C3A` | Dark section backgrounds        |
| `--color-dark-alt` | `#282829` | Footer, benefits bg             |
| `--color-body`     | `#323A51` | Body text                       |
| `--color-light-bg` | `#f9f9fb` | Light section backgrounds       |
| `--color-white`    | `#ffffff` | White section backgrounds       |

### Typography

| Role     | Font Family | Weights    | Usage                  |
|----------|-------------|------------|------------------------|
| Headings | Poppins     | 400, 500, 600 | h1-h3, overlines, labels |
| Body     | Assistant   | 300, 400, 600 | Body text, buttons     |
| Nav      | Montserrat  | 400        | Navigation links       |

Base font size: 18px. Line height: 1.6.

### Responsive Breakpoints

| Breakpoint | Max-width | Key changes                              |
|------------|-----------|------------------------------------------|
| Tablet     | 960px     | Grids collapse to fewer columns          |
| Mobile     | 768px     | Single column, hero visual hidden, hamburger nav |
| Small      | 480px     | Full-width buttons, tighter spacing      |

### Component Styles

- **Buttons:** Sharp corners (border-radius: 0), hover lift with box-shadow, gradient sweep animation
- **Cards:** Left border accent (3px solid purple, gradient on hover), hover lift
- **Sections:** Full-width with `.container` max-width 1100px, 100px vertical padding (72px mobile)
- **Scroll reveal:** Elements fade up on viewport entry (IntersectionObserver)
- **Nav:** Fixed, transparent on top, frosted glass on scroll (`backdrop-filter: blur`)
- **Gradient accent bar:** Animated gradient below hero (purple → blue → cyan cycle)

## Section Library (ACF Flexible Content Layouts)

Each section is a layout option in an ACF Flexible Content field called `page_sections`. Every section has a shared "Section Settings" group with:

- **Background style:** White / Light / Dark / Purple (dropdown)
- **Custom background color:** Color picker (optional override)
- **Section ID:** Text field for anchor links
- **Top/Bottom padding:** Select (default / compact / none)

### 1. Hero

**Fields:**
- Overline text (optional)
- Headline (text)
- Subtitle (textarea)
- Supporting text (textarea, optional)
- CTA button (link field)
- Secondary CTA (link field, optional)
- Background: color/gradient (default) or image/video upload
- Show animated shapes (toggle, default on)

**Renders:** Full-viewport hero with mesh gradient background, floating geometric shapes, staggered fade-up animations.

### 2. Content Block

**Fields:**
- Overline (text, optional)
- Heading (text)
- Body content (WYSIWYG editor)
- Pull highlight quote (textarea, optional — renders as left-bordered pullquote)
- Max width: Normal (780px) or Wide (1100px)

**Renders:** Standard text section with typographic hierarchy.

### 3. Card Grid

**Fields:**
- Overline (text, optional)
- Heading (text, optional)
- Columns: 2 / 3 / 4 (select)
- Cards (repeater):
  - Icon (image upload or SVG textarea)
  - Title (text)
  - Description (textarea)
  - Link (link field, optional)
- Featured card (toggle — if on, first card spans full width with dark bg, matching prototype's featured card style)

**Renders:** Responsive grid of cards with left-border accent. Used for features, services, solutions, values, hiring qualities.

### 4. Pull Quote Banner

**Fields:**
- Quote text (textarea)
- Accent word/phrase (text — rendered in cyan)

**Renders:** Dark background, centered quote with gradient divider above.

### 5. Logo Carousel

**Fields:**
- Heading (text, optional)
- Subheading (text, optional)
- Logos (repeater):
  - Logo image (image upload)
  - Company name (text — for alt text)

**Renders:** Horizontally scrolling logo strip with grayscale-to-color hover effect.

### 6. Testimonials

**Fields:**
- Testimonials (repeater):
  - Quote (textarea)
  - Name (text)
  - Title (text)
  - Company (text)
  - Photo (image, optional)

**Renders:** Carousel/slider with navigation dots and arrows.

### 7. Process Steps

**Fields:**
- Overline (text, optional)
- Heading (text, optional)
- Steps (repeater):
  - Step title (text)
  - Step description (textarea)
  - Icon (image, optional)

**Renders:** Numbered vertical timeline with gradient connector line. Step numbers in bordered squares, hover fills purple.

### 8. CTA Section

**Fields:**
- Heading (text)
- Body text (textarea, optional)
- CTA button (link field)
- Secondary button (link field, optional)
- Background style: Purple (default) / Dark / Custom color

**Renders:** Centered text and button on colored background with radial gradient overlays.

### 9. Image + Text

**Fields:**
- Image (image upload)
- Content side: Overline, heading, body (WYSIWYG), CTA button (optional)
- Image position: Left / Right (select)
- Image style: Full bleed / Contained (select)

**Renders:** 50/50 split layout, reverses on mobile to image-on-top.

### 10. Accordion / FAQ

**Fields:**
- Heading (text, optional)
- Items (repeater):
  - Question/title (text)
  - Answer/content (WYSIWYG)

**Renders:** Expandable sections with smooth open/close animation. Purple accent on active item.

### 11. Team Grid

**Fields:**
- Heading (text, optional)
- Intro text (textarea, optional)
- Team members (repeater):
  - Photo (image)
  - Name (text)
  - Title (text)
  - Bio (textarea, optional)

**Renders:** Responsive grid of team member cards. Photo on hover reveals bio overlay.

### 12. Contact Block

**Fields:**
- Heading (text, optional)
- Address (textarea)
- Phone (text)
- Email (text)
- Social links (repeater: platform + URL)
- Form shortcode (text — for embedding Gravity Forms, WPForms, or CF7)
- Layout: Form right (default) / Form left

**Renders:** Two-column layout with contact info and embedded form.

### 13. Blog Preview

**Fields:**
- Heading (text)
- Subheading (text, optional)
- Post count (number, default 3)
- Category filter (taxonomy select, optional — limit to specific categories)
- Show category filter buttons (toggle)

**Renders:** Grid of recent post cards with title, excerpt, category tag, read-more link. Optional category filter buttons above.

## Template Hierarchy

### front-page.php (Homepage)
- Loads ACF flexible content sections
- Default sections pre-populated on theme activation: Hero, Pull Quote, Content Block, Card Grid (features), CTA

### page.php (Standard Pages)
- Same ACF flexible content system
- Used for: About, Solutions, Solutions sub-pages, Service pages, Contact
- Each page builds its own layout from the section library

### single.php (Blog Post)
- Standard Gutenberg content area styled to match theme typography
- Featured image hero (optional — uses simplified hero styling)
- Post meta: date, author, categories
- Related posts grid below content
- Social share links

### archive.php (Blog Archive)
- Category filter buttons (isotope-style or AJAX)
- Post grid with cards (title, excerpt, category, featured image)
- Pagination

### page-portal.php (Future Portal)
- Full-width, no sidebar
- Minimal header (logo + user menu only)
- Placeholder for future portal features
- Registered but not actively used in phase 1

### 404.php
- Styled to match theme
- Search form + link to homepage

## WordPress Customizer (Global Settings)

### Brand Colors Panel
- Primary color (default: #8560A8)
- Secondary color (default: #5674B9)
- Accent color (default: #00BFF3)
- Dark background (default: #252C3A)
- Body text color (default: #323A51)

Changes cascade to all sections via CSS custom properties.

### Typography Panel
- Heading font family (default: Poppins)
- Body font family (default: Assistant)
- Nav font family (default: Montserrat)
- Base font size (default: 18px)

### Header Panel
- Logo upload (image)
- Sticky nav toggle
- Nav background color on scroll

### Footer Panel
- Footer logo (image, optional)
- Tagline text
- Column configuration (which columns to show)
- Copyright text

## Navigation

- **Primary Menu:** Registered as `primary` — displays in header nav
- **Footer Menus:** Registered as `footer-1`, `footer-2`, `footer-3` — one per footer column
- Mobile: Hamburger toggle with slide-in menu at 768px breakpoint

## Plugin Dependencies

### Required
- **ACF Pro** — Flexible Content, Repeater, Options pages

### Recommended
- **WPForms Lite** or **Contact Form 7** — Contact form (embedded via shortcode in Contact Block section)
- **Yoast SEO** or **Rank Math** — SEO meta (theme outputs clean semantic HTML)
- **WP Fastest Cache** or **LiteSpeed Cache** — Caching

### Future (Client Portal Phase)
- Custom plugin or theme module for:
  - Client user role + auth
  - Kanban ticket board (React-based, REST API)
  - Notion API two-way sync
  - File management dashboard
  - Client chat (WebSocket or third-party integration)
  - SEO/project reports

## Future Portal Considerations

The theme is built with the portal in mind but does not implement it:

1. **User role:** `stretch_client` role registered in `functions.php` (no capabilities beyond `read` initially)
2. **Template:** `page-portal.php` exists as a minimal full-width template
3. **Conditional nav:** Header checks `is_user_logged_in()` and shows a "Dashboard" link for client users
4. **REST API:** Theme does not register any conflicting REST routes; clean namespace available for portal endpoints
5. **Asset isolation:** Portal pages can enqueue their own JS/CSS bundles without conflicting with front-end theme assets

## Performance

- No jQuery dependency (vanilla JS only)
- Google Fonts loaded with `font-display: swap` and preconnect hints
- CSS custom properties for theming (no runtime style recalculation)
- Minimal DOM — sections render only the HTML they need
- Images: theme supports WebP, lazy loading via native `loading="lazy"`
- SVG icons inline (no icon font library)

## Accessibility

- Semantic HTML5 (nav, main, article, section, aside, footer)
- ARIA labels on nav, toggle buttons, carousel controls
- Focus-visible styles on all interactive elements
- Skip-to-content link
- Color contrast meets WCAG AA on all text/background combinations
- Reduced motion: `prefers-reduced-motion` disables all animations

## Deliverables (Phase 1)

1. Complete WordPress theme installable as a `.zip`
2. ACF field groups exported as JSON (in `acf-json/`)
3. Theme Customizer with all global brand settings
4. All 13 section types functional and styled
5. All page templates (front-page, page, single, archive, search, 404, portal placeholder)
6. Responsive across all breakpoints
7. Blog archive with category filtering
8. Documentation for the client on how to edit pages
