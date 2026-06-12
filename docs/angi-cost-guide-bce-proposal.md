# Angi Cost Guide BCE — Concept Proposal

**Prepared for:** Angi Cost Guide team
**Re:** A bespoke interactive experience for the cost guide hub-and-spoke model

---

## The idea in one line

Instead of building a separate calculator for every cost guide, we build **one cost engine** and let each level of the hub-and-spoke tree show a different view of it. That's what makes this feel bespoke instead of a calculator slapped onto every page.

## Why this approach

The three structures the writer laid out — spokes, sub-spokes, and the city pages — are really all the same hierarchy. If we treat them that way, the hub estimate becomes the sum of its spokes, which means every tool naturally links to its parent and its children.

We'd get the internal-linking structure we want almost for free, and the whole library would feel like one connected product instead of a pile of one-off pages.

## How it maps to the tree

| Level | Page example | What the tool does |
|---|---|---|
| **Hub** | Bathroom Remodel Cost | "Build Your Bathroom" — toggle the pieces (shower, tub, vanity, flooring) and watch the total build |
| **Spoke** | Shower Remodel Cost | The same tool, zoomed into one component |
| **Sub-spoke** | Walk-in Shower Cost | Side-by-side comparison of the specific variants |
| **City** | Bathroom Remodel Cost, Seattle | The same engine, re-priced by location |

## What each level actually does

**Hub — the centerpiece.** Someone toggles their components and watches the total assemble, and each line item links down to its spoke ("customize your shower →"). It answers "what's my whole project going to cost" and feeds link equity to every spoke at the same time.

**Spoke — the component deep-dive.** The same engine, focused on one component, with a link back up to add it to the full bathroom and links down to the sub-spokes.

**Sub-spoke — the decision.** This is where we settle the actual choice the person is making: walk-in vs. tub-to-shower conversion, glass door, shower pan, accessibility, and so on. It's the moment where "convert tub to shower cost" and "walk-in shower cost" need to be pulled apart.

**City pages — the big unlock.** One location dataset re-prices the entire tree, so picking Seattle updates the hub, every spoke, and every sub-spoke at once. That's how we scale to hundreds of city pages from a single build instead of writing each one by hand — which lines up perfectly with the local cost guide push already underway.

## The interactive pieces, by priority

1. **"Is my quote fair?" check** — someone enters the quote they got and sees where it lands vs. the local range. Highest-intent moment there is, and almost nobody builds it. Works at every level.
2. **Component assembler** — at the hub.
3. **Variant comparison** — at the sub-spoke level.
4. **Local re-pricer** — for the city pages.

Lighter modules we can sprinkle in:

- A cost breakdown showing where the money actually goes
- A good / better / best slider
- A financing comparison
- A "hidden costs people forget" list

## Suggested rollout

1. Build the engine and data model once, around a single tree. **Bathroom Remodel Cost is a great pilot** — the writer already mapped out the full spoke / sub-spoke / city structure.
2. Ship the three views (hub assembler, spoke deep-dive, sub-spoke comparer).
3. Add the location layer for instant city-page scale.
4. Wrap the whole thing with the "is my quote fair?" hook up top and a "find a vetted local pro" CTA at the bottom.

Build it once, and it templates across every cost guide tree Angi owns.
