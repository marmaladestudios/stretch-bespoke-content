# Angi Cost Guide BCE — Concept Proposal

**Prepared for:** Angi Cost Guide team
**Re:** A bespoke interactive experience for the cost guide hub-and-spoke model

---

## The idea in one line

Instead of building a separate calculator for every cost guide, we build **one app**. A version of that same app sits on each page, and which "form" it takes depends on where the page lives in the hub-and-spoke tree.

## Why this approach

The three structures the writer laid out — spokes, sub-spokes, and the city pages — are really all the same hierarchy. If we treat them that way, the hub estimate becomes the sum of its spokes, which means every version of the app naturally links to its parent and its children.

We'd get the internal-linking structure we want almost for free, and the whole library would feel like one connected product instead of a pile of one-off pages.

## One app, three forms, one shared ending

There aren't four separate tools. There's **one app** that does two things on every page:

1. Helps the visitor land on a cost number
2. Hands them off to get real quotes from local pros

The *first* part changes shape depending on the page (that's the three forms below). The *second* part is identical everywhere (that's the shared ending).

### The three forms of the app

| Form | Where it lives | What it does |
|---|---|---|
| **Assembler** | **Hub** (e.g. Bathroom Remodel Cost) | Check off the parts of your project and watch the total build |
| **Component view** | **Spoke** (e.g. Shower Remodel Cost) | The same assembler, scoped to one component |
| **Comparison** | **Sub-spoke** (e.g. Walk-in Shower Cost) | Two close-but-different options side by side |

And one layer that sits on top of all of them:

| Layer | Where it applies | What it does |
|---|---|---|
| **Local re-pricer** | **City pages** | A "change location" control that re-prices everything on the page for that city |

### The shared ending (every form, every page)

Every version of the app finishes the same way: **the estimate → "get matched with local pros for real quotes."**

This is *not* a second app or an extra widget. It's the final step built into the one app — the same handoff button no matter which page you're on.

**Important on funnel stage:** we deliberately do *not* build an "is my quote fair?" checker. That targets people who already have a quote in hand — which usually means they've already found their pro. Angi wants the visitor *before* they have any quotes. So the app gives them the ballpark number they came for, and the very next step is getting real quotes through Angi — which is the stage Angi actually monetizes.

## How each form behaves, with examples

**Assembler (hub).** On "Bathroom Remodel Cost," you toggle on new shower + vanity + tile floor + toilet → running total lands around $31k. Each line links down to its spoke ("Customize your shower →"). Ends with: *"Your remodel looks like ~$28k–$34k. Get exact quotes from bathroom pros near you →"*

**Component view (spoke).** On "Shower Remodel Cost," the same assembler is zoomed into one component — shower type, size, tile, glass, fixtures. Links back up ("add this to your full bathroom") and down to the sub-spokes. Ends with the same get-matched handoff.

**Comparison (sub-spoke).** On "Walk-in Shower Cost," it shows walk-in shower (~$8k) vs. tub-to-shower conversion (~$5k) side by side — cost, timeline, resale impact, accessibility. Ends with the same get-matched handoff.

**Local re-pricer (city).** On "Bathroom Remodel Cost — Seattle," picking Seattle bumps the national ~$31k to the local ~$38k, and every spoke/sub-spoke number updates with it. One location dataset powers every city page.

## Lighter modules to sprinkle in

Smaller supporting elements that drop into the hub and spoke forms where useful:

- **Cost breakdown** — where the money actually goes (labor vs. materials vs. permits vs. design)
- **Good / better / best slider** — drag from budget to premium and watch the price move
- **Financing comparison** — cash vs. loan vs. HELOC, with monthly payment for each
- **"Hidden costs people forget" list** — permits, dumpster rental, surprises behind the wall

## Suggested rollout

1. Build the app and its data model once, around a single tree. **Bathroom Remodel Cost is a great pilot** — the writer already mapped out the full spoke / sub-spoke / city structure.
2. Ship the three forms (assembler, component view, comparison).
3. Add the local re-pricer layer for instant city-page scale.
4. The get-matched handoff is baked into every form from day one.

Build the app once, and it templates across every cost guide tree Angi owns.
