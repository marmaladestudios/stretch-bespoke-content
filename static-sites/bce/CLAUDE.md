# BCE Demos — Working Rules

Standalone client demo sites ("Bespoke Content Experiences"). Each folder here
is a self-contained static site: plain HTML/CSS/JS, no build step, no shared
dependencies with the WordPress site in the rest of the repo.

## Scope — read this first

- Work ONLY inside `static-sites/bce/<client>/` for BCE tasks. A BCE change
  never requires touching `stretch-theme/`, any `setup-*.php` seed, the
  `Dockerfile`, or `docker-entrypoint-custom.sh`.
- Each client folder is independent — an edit in `homedepot/` must not touch
  `angi/` (and vice versa).

## Layout per client

- `index.html` — entry page (may have additional demo pages alongside)
- `app.js` / `app.css` / `styles.css` — the demo's own code
- `assets/` — that demo's images/logos. Keep assets local to the folder;
  don't reference files from other demos or from the WordPress theme.

## Preview

Open the `index.html` in a browser — file:// works because everything is
relative. No server, no Docker needed for BCE work.

## Deploys

- Live URLs: `https://stretch-creative.onrender.com/bce/<client>/`
- Any push to `main` triggers a full production deploy of EVERYTHING in the
  repo (the WordPress site included). **Branch + PR by default** — only push
  to `main` when the change is approved to go live.
- Creating a new demo = new folder here; it is automatically published at
  `/bce/<folder>/` on the next deploy. No config needed.

## Conventions

- Keep demos self-contained and offline-capable: no CDN scripts/fonts unless
  the demo already uses them; prefer bundling.
- Optimize images before committing (target ≤400KB each; `sips -Z 1600` on macOS).
- Client branding assets belong to that client's folder — double-check you're
  using the right client's logo/colors (e.g. `homedepot/assets/` currently
  contains an `angi-logo-orange.svg` leftover; don't propagate mistakes like
  that into markup).
