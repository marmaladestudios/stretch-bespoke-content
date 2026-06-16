# Angi Cost-Guide BCE — Engineering Handoff

> Hand this to Codex (or any dev) to continue the build locally. It contains the full
> concept, the confirmed Angi design system, the current state of the demo, how to run it,
> and what to build next. No prior context needed.

---

## 1. What this project is

A **Bespoke Content Experience (BCE)** for Angi's cost-guide articles. Angi is a home-services
marketplace; they publish a large library of "how much does X cost" guides arranged in a
hub → spoke → sub-spoke → city tree. The goal is **one interactive web app** that drops into
those pages, helps a pre-quote homeowner build a cost estimate, and hands them off to "get
matched with local pros."

### The core model: one app, three forms, one shared ending
- **Hub** (e.g. *Bathroom Remodel Cost*) → **Assembler**: toggle project components, watch the total build.
- **Spoke** (e.g. *Shower Remodel Cost*) → same assembler scoped to one component.
- **Sub-spoke** (e.g. *Walk-in Shower Cost*) → **Comparison**: two close options side by side.
- **City** (e.g. *…/wa/seattle*) → a **location re-pricer** layer that re-prices the whole tree.
- **Shared ending (every form):** the estimate → "get matched with local pros for real quotes."
  This is the conversion step built into the app, NOT a separate widget.

### Important product decisions (don't undo these)
- **Do NOT build an "is my quote fair?" checker.** It targets people who already have a quote
  (already hired). Angi wants the homeowner *before* they have quotes. The app gives a ballpark,
  then funnels to "get real quotes through Angi."
- **Downloadable Project Brief is a key feature.** When the user finishes, they can download a
  spec sheet to hand contractors (→ more accurate quotes), gated behind an **email capture**
  (lead gen). This is the bridge from "ballpark" to "ready to get quotes."
- Estimates are framed as **ranges**, never fixed prices.

---

## 2. Confirmed Angi design system (source of truth)

These are pulled from Angi's **live** `theme-angi` design tokens — real values, not guesses.

### Colors
| Token | Hex | Role |
|---|---|---|
| Coral | `#fc5647` | Primary CTA / action ONLY |
| Coral pressed | `#d71100` | Button pressed/hover |
| Coral tint | `#ffefea` | Secondary-button hover bg |
| Deep teal | `#065c62` | Hero, footer, structure |
| Link teal | `#00819e` | Inline links |
| Mint | `#8cf4be` | Accent secondary |
| Text default | `#282827` | Body + headings |
| Text subtle | `#6d6d6d` | Captions, secondary |
| Text disabled | `#bcb9b4` | Disabled |
| BG neutral | `#f5f5f2` | Callouts, table stripes |
| BG cream | `#fff4e2` | Warm callout bg |
| BG mint | `#e8fdf2` | Pale CTA card bg |
| Border | `#dbd9d4` | Dividers, lines |
| White | `#ffffff` | Page bg, cards |
| Success / Warning / Error | `#06c778` / `#ffc020` / `#d71100` | Status |

**Rule:** teal = structure, coral = action (only on clickable things). Don't dilute coral.

### Typography
- **Font: `National`** (Angi's brand face). Stack: `National, "Helvetica Neue", Helvetica, Arial, sans-serif`.
- Regular weight loads via `@font-face` from Angi's CDN:
  `https://lpfe-static-assets.angi.com/static/landing-pages-frontend/_next/static/media/national-2-web-regular.d0da2e34.woff2`
  (also `.woff`). Medium (500) / Heavy (600) URLs not yet captured — grab from DevTools if needed.
- **Weights:** light/regular 400, medium 500, **heavy 600 (NOT 700)**.
- Type scale: H1 ~36px, H2 ~26px, H3 ~20px, body ~17px, caption ~13px, eyebrow ~12px uppercase.

### Shape & spacing
- Radius: **4px** buttons/inputs (`corner-button`/`corner-tight`), **16px** cards/tables/callouts (`corner-loose`).
- Spacing scale: 4 / 8 / 16 / 24 / 32 / 48 / 64 px.
- Content column max-width ~720px; wide (nav/footer) ~1040px.

### Logo
- Brand mark: `https://media.angi.com/s3fs-public/angi-circle-logo.svg`
- (Current demo uses an inline SVG placeholder — a coral circle with "a" — so it works offline.)

---

## 3. Current state of the demo

A working **hub Assembler** demo for a **bathroom remodel**, styled to the Angi system, dropped
into a realistic article shell (nav, teal hero, body copy, cost tables, related-guide cards, footer).

### Files (in `angi-cost-app-demo/`)
| File | Purpose |
|---|---|
| `index.html` | Article shell + app markup (modular; links the CSS/JS) |
| `styles.css` | Angi design tokens + base/component styles (the reusable system) |
| `app.css` | Demo-page-specific styles (nav, hero, app, modal, footer) |
| `app.js` | Assembler logic (state, render, totals, brief download) |
| `bathroom-remodel-demo.html` | **Standalone single-file build** (CSS+JS inlined) — open directly |
| `DESIGN-SPEC.md` | The design system written up for humans |

> The standalone file is generated from the modular files. To regenerate after edits, inline
> `styles.css` + `app.css` into a `<style>` and `app.js` into a `<script>` (see git history / commit
> `fb0857f`+ for the python one-liner used).

### What works in the demo
- Toggle 7 components (shower, vanity, tile, flooring, toilet, lighting, move-plumbing).
- Per-component **Good/Better/Best** tier dropdown.
- **Live total range** + cost-breakdown table update on every change.
- **Location re-pricer** dropdown (National / Seattle / NYC / Austin / Cleveland) with multipliers.
- **"Get my project brief"** → email-gate modal → downloads a formatted `.txt` project brief and
  shows a "matched with 3 local pros" confirmation.

### Known limitations / caveats
- **All dollar figures are illustrative placeholders**, not real Angi cost data.
- Only the **hub Assembler** form is built (no spoke/sub-spoke/city views yet).
- Brief is a plain `.txt`; a PDF would be nicer (see roadmap).
- `National` font + real logo load from Angi's CDN — fine locally, but were stripped to inline
  SVG in the demo so it works with no network.

---

## 4. How to run it locally

It's plain static HTML/CSS/JS — no build step, no dependencies.

**Easiest:** double-click `bathroom-remodel-demo.html` → opens in the browser.

**As a localhost server (e.g. for `http://localhost:8080/`):**
```bash
cd angi-cost-app-demo
python3 -m http.server 8080
# then open http://localhost:8080/   (serves index.html)
```
Any static server works (`npx serve`, VS Code Live Server, etc.).

The code is on git branch `claude/nice-ritchie-gkff84` in the repo, under `angi-cost-app-demo/`.

---

## 5. Suggested next steps (roadmap)

1. **Replace placeholder pricing** with a real cost dataset + a defensible location-multiplier table.
2. **Data model**: extract components/tiers/prices into a JSON config so one engine powers every
   page (the hub→spoke→sub-spoke→city tree) instead of hardcoding per page.
3. **Build the other forms:**
   - Spoke = assembler scoped to one component.
   - Sub-spoke = side-by-side **Comparison** (e.g. walk-in shower vs. tub-to-shower conversion).
   - City = same engine, location pre-selected, re-prices the tree.
4. **Upgrade the Project Brief to PDF** (e.g. jsPDF / pdf-lib) with Angi branding, scope, tiers,
   range, and contractor-question checklist.
5. **Wire real lead capture** on the email gate (currently a no-op) and the "get matched" handoff
   into Angi's actual match flow; ideally pipe the brief to matched pros.
6. **Add the lighter modules** where useful: cost breakdown (where money goes), financing
   comparison, hidden-costs list.
7. **Productionize**: swap inline SVG logo for the real Angi logo + add the National 500/600 font
   weights; integrate into Angi's CMS/page template.
8. **Polish**: accessibility (labels, focus states, keyboard), mobile QA, analytics events.

---

## 6. Prompt to start Codex

> "I'm continuing a static web-app demo in `angi-cost-app-demo/` (plain HTML/CSS/JS, no build
> step). Read `DESIGN-SPEC.md` and this handoff doc first. The design tokens in `styles.css` are
> Angi's real brand system — keep teal = structure, coral = action, font National, heavy weight
> 600 not 700. The current build is a hub 'Assembler' for a bathroom remodel. Next I want you
> to [pick a roadmap item]. Keep everything framed as cost *ranges*, and keep the 'get matched /
> download project brief' as the shared ending. Don't add an 'is my quote fair' checker."
