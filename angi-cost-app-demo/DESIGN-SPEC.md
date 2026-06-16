# Angi Cost Guide App — Design Spec

**Goal:** the cost-guide app must look like a native section of an Angi blog article, not a third-party widget bolted on. Same fonts, same teal/coral color logic, same rounded-card styling, same CTA pattern.

> **Verification status:**
> - ✅ **Coral `#FF6153` (+ secondary `#A03027`) — confirmed** as Angi's brand colors.
> - ⚠️ **Deep teal + font — estimated from screenshot, not yet confirmed.** Angi's live site and the public brand-asset aggregators block automated fetching, so these couldn't be pulled programmatically. To lock them, open any Angi article in Chrome, right-click the teal hero → Inspect, and read the computed `background-color` (teal) and `font-family` (body text). Drop the exact values into `styles.css` — they're single-line token changes.

---

## 1. Color palette

| Token | Approx. hex | Role |
|---|---|---|
| Primary deep teal | `#16524C` | Hero banner, footer, brand structure |
| Teal dark (hover/depth) | `#0F3D38` | Hover states on teal, footer base |
| CTA coral | `#FF6153` | Primary buttons, action only — **confirmed Angi brand coral** |
| CTA coral dark (hover) | `#A03027` | Button hover — **confirmed Angi secondary** |
| Link teal | `#1A7A6E` | Inline links, "read more" |
| Text near-black | `#222222` | Body copy, headings |
| Text muted gray | `#6B6B6B` | Captions, secondary text |
| Section gray | `#F5F5F5` | Callout boxes, table stripes |
| Border gray | `#E2E2E2` | Dividers, table lines, card edges |
| White | `#FFFFFF` | Page background, cards |

**The rule that matters:** teal = structure/brand, coral = *action*. Coral appears only on things you click. Don't dilute it.

## 2. Typography

- **One clean sans-serif throughout** — no serifs anywhere. Closest web-safe stack: `Inter, "Helvetica Neue", Arial, sans-serif`.
- **H1 (hero):** bold, white, ~32–40px.
- **H2 (section):** bold, near-black, ~24–28px, generous space above.
- **H3:** bold, ~20px.
- **Body:** ~16–18px, regular, `#222`, line-height ~1.6, single readable column.
- **Eyebrow / category label:** ~12px, uppercase, letter-spaced, coral.
- **Caption:** ~13px, muted gray.

## 3. Layout & spacing

- **Single centered content column**, ~720px max-width for readable text.
- **Full-bleed colored bands** for hero and footer (teal); white body.
- Generous vertical rhythm; clear H2 → paragraph spacing.
- **Rounded corners** ~8px on cards, tables, callout boxes.
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
