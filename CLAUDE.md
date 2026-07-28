# Stretch Creative — Monorepo Guide

This repo contains **two independent workstreams** that deploy together to
https://stretch-creative.onrender.com. Identify which one you're working on
before touching anything, and stay inside its directories.

## ⚠️ Deploys: pushing to `main` IS a production deploy

Render watches `main` and auto-builds on every push (~2–5 min, full container
rebuild). **Work on a branch and open a PR unless you have been explicitly told
to push to main.** There is no staging environment.

## Workstream 1 — BCE demos (static sites)

Client-facing "Bespoke Content Experience" demos. Pure static HTML/CSS/JS —
no build step, no framework, no WordPress.

- **Code:** `static-sites/bce/<client>/` (currently `angi/`, `homedepot/`)
- **Live URLs:** `/bce/<client>/` on the production domain
- **Local preview:** open the `index.html` directly in a browser — that's it
- **Deploy mechanics:** the Dockerfile copies `static-sites/` into the
  container and the entrypoint publishes it into the webroot on boot. A new
  folder under `static-sites/bce/` automatically becomes `/bce/<folder>/`.
- **Scope rule:** BCE work touches ONLY `static-sites/`. Never edit the theme,
  seeds, Dockerfile, or entrypoint for a BCE task.
- See `static-sites/bce/CLAUDE.md` for details.

## Workstream 2 — The Stretch Creative website (WordPress)

Custom WordPress theme + seed-script content pipeline.

- **Theme:** `stretch-theme/` (templates like `page-home.php`,
  `page-service.php`, `page-industry.php`; shared effects kit at
  `template-parts/premium-fx.php`; CSS in `assets/css/theme.css`)
- **Content seeds:** root `setup-*.php` / `content-fixes.php` — idempotent
  WP-CLI scripts that are the source of truth for page copy, images, menus.
  They run automatically on deploy (hash-gated list in
  `docker-entrypoint-custom.sh`). Every seed must stay idempotent and
  `WP_CLI`-guarded.
- **Local dev:** `docker compose up -d` → http://localhost:8888. The theme dir
  is bind-mounted (edits apply on refresh). Root seed scripts are NOT mounted —
  apply with `docker compose cp <file> wordpress:/var/www/html/<file>` then
  `docker compose exec -T wordpress wp eval-file /var/www/html/<file> --allow-root`.
  After data/CSS changes: `wp cache flush` + clear `/var/www/html/wp-content/cache/`.
- **Images:** bundled in `page-images/`, sideloaded by `setup-page-images.php`
  / `setup-team-photos.php` (content-hash deduped). Never hotlink external
  images; production cannot fetch external URLs at boot. Site rule: no image
  appears on more than one page.
- **Copy fidelity:** page copy uses curly apostrophes (’), curly quotes, and
  em-dashes — preserve them byte-for-byte. On macOS grep with
  `export LC_ALL=C; grep -a`, count multibyte chars with `perl -CSD`.
- **Hard-won conventions** (do not regress):
  - Wedge dividers: container bg = previous section's color; clipped triangle =
    next section's color extended 1px past BOTH edges; container
    `margin-bottom:-1px`. Any deviation shows hairline seams.
  - Hero grid: the lattice lines live ON the parallax layer
    (`.pfx-grid-container`) — a second static line source causes doubled lines.
  - Kit button text is white via a terminal rule in `premium-fx.php` — don't
    add page-level `a { color }` rules that fight it.
  - Asset cache-busting is by `filemtime` in `functions.php` — never rely on
    the theme `Version:` header.
  - Icons: every card/chip sets an explicit icon slug; the fallback is a
    deliberate neutral asterisk. Don't reintroduce silent fallbacks.
- **Design source of truth:** `design_handoff_stretch_pages/` (README + .dc.html
  references) for Home/Solutions/Industry; `design-reference/copy-doc.md` for copy.
- **Retired content:** the AEO blog cluster and the standalone Team/Work pages
  are retired (301s + drafted posts + guarded seeds). Don't resurrect them.

## Verification habits

`php -l` every edited PHP file. After changes, curl the affected local pages
(HTTP 200, expected markers, zero PHP warnings). For visual checks use headless
Chrome screenshots. Production checks: curl https://stretch-creative.onrender.com
after a deploy lands (expect one brief 502 during the container swap).
