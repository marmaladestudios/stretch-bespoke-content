# Angi Cost Guide App — Design Spec

**Goal:** the cost-guide app must look like a native section of an Angi blog article, not a third-party widget bolted on. Same fonts, same teal/coral color logic, same rounded-card styling, same CTA pattern.

> **Verification status: ✅ CONFIRMED.** All values below are pulled directly from Angi's live design system (`theme-angi` / `:root` tokens), not estimated. `styles.css` mirrors them exactly.

---

## 1. Color palette (Angi design-system tokens)

| Token | Hex | Angi variable | Role |
|---|---|---|---|
| Coral | `#fc5647` | `accent-primary` / `bg-strong` | Primary CTAs, action only |
| Coral pressed | `#d71100` | `momentary-pressed` / `error` | Button pressed/hover-depth |
| Coral tint | `#ffefea` | `momentary-hover` / `error-bg` | Secondary-button hover bg |
| Deep teal | `#065c62` | `bg-dark` | Hero banner, footer, structure |
| Link teal | `#00819e` | `text-link` | Inline links, "read more" |
| Mint | `#8cf4be` | `accent-secondary` | Accent highlights |
| Text default | `#282827` | `text-default` | Body copy, headings |
| Text subtle | `#6d6d6d` | `text-subtle` | Captions, secondary text |
| Text disabled | `#bcb9b4` | `text-disabled` | Disabled states |
| BG neutral | `#f5f5f2` | `bg-neutral` | Callouts, table stripes, reviews |
| BG cream | `#fff4e2` | `bg-light` / `warning-bg` | Warm callout backgrounds |
| BG mint | `#e8fdf2` | `bg-medium` / `success-bg` | Pale CTA card background |
| Border | `#dbd9d4` | `bg-outline` | Dividers, table lines, card edges |
| White | `#ffffff` | `bg-default` | Page background, cards |
| Success | `#06c778` | `success` | Positive states |
| Warning | `#ffc020` | `warning` | Caution states |

**The rule that matters:** teal = structure/brand, coral = *action*. Coral appears only on things you click. Don't dilute it.

## 2. Typography

- **Font: `National`** (Angi's brand typeface), full stack `National, "Helvetica Neue", Helvetica, Arial, sans-serif`. Loaded in `styles.css` via `@font-face` from Angi's public CDN (regular/400 weight).
- **Weights (important):** light/regular `400`, medium `500`, **heavy `600`** — Angi tops out at 600, *not* 700. Don't use 700.
- **H1 (hero):** 600, white, ~36px.
- **H2 (section):** 600, `#282827`, ~26px, generous space above.
- **H3:** 600, ~20px.
- **Body:** ~17px, regular, `#282827`, line-height ~1.6, single readable column.
- **Eyebrow / category label:** ~12px, uppercase, letter-spaced, coral.
- **Caption:** ~13px, `#6d6d6d`.

## 2a. Logo

- Brand mark: `https://media.angi.com/s3fs-public/angi-circle-logo.svg` (Angi `--background-image-brand-logo`).

## 3. Layout & spacing

- **Single centered content column**, ~720px max-width for readable text.
- **Full-bleed colored bands** for hero and footer (teal `#065c62`); white body.
- Generous vertical rhythm; clear H2 → paragraph spacing.
- **Rounded corners:** `4px` on buttons/inputs (`corner-button`/`corner-tight`), `16px` on cards/tables/callouts (`corner-loose`).
- **Soft, minimal shadows** — content-first, no heavy elevation.
- Spacing scale: 4 / 8 / 16 / 24 / 32 / 48 / 64 px.

## 4. Components the app must echo

1. **Inline "Get a pro" CTA card** — pale-teal/cream background, short line of text, single coral button. The app's get-matched handoff copies this exactly.
2. **Cost table** — header row, zebra striping (`#F5F5F5` alt rows), light borders, rounded container. The estimate output reuses this.
3. **Checklist / callout block** — bordered, branded.
4. **Image + caption** — full-width image, small muted caption beneath.
5. **Related-articles grid** — 3-col cards: thumbnail, coral uppercase eyebrow, bold title.
6. **Footer** — deep teal, multi-column links, app-store badges, social icons.

## 5. Tone

Trustworthy, clean, utilitarian. Lots of whitespace, no gradients or flashy effects, content-first. Color used sparingly and purposefully. The app should read as "another well-designed part of the article."
