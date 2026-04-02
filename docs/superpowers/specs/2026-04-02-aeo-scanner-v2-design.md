# AEO Scanner v2 — Design Spec

## Overview

Upgrade the AEO Readiness Scanner from a generic page scoring tool into a query-specific AI visibility predictor with branded PDF export. The core shift: from "here's how your page looks" to "here's how likely AI engines are to cite your page for this specific question."

**Target user:** Marketing managers who know SEO basics and want to understand their AI search visibility.

**Primary goal:** Drive contact with Stretch Creative. Secondary goal: shareable reports that spread awareness.

**Architecture:** All client-side. No backend. Single self-contained file (`aeo-scanner.php`).

---

## 1. New User Flow

Current: URL input → loading → results

New (4 states):

1. **URL Input** — unchanged. User enters URL, clicks "Scan Page."
2. **Query Step** — new. After page fetch, shows auto-suggested query with editable input. User confirms or types their own target query, clicks "Analyze."
3. **Loading** — same radar animation. Loading messages now reference the target query (e.g., "Testing AI visibility for: *What is content marketing?*...").
4. **Results** — expanded. New AI visibility predictions and simulated answer panel above existing 8 dimension cards. PDF download button added to CTA area.

---

## 2. Query Auto-Suggestion Engine

After fetching the page HTML, infer the target query using this priority chain:

1. **H1 tag** — if question-formatted, use directly
2. **Meta description** — extract core topic, frame as question
3. **First H2** — reframe as question
4. **Title tag** — strip brand suffix, convert to question

Statement-to-question conversion patterns:
- "How to X" → "How do you X?"
- "Guide to X" / "What is X" → "What is X?"
- "N Ways to X" / "Tips for X" → "How do you X?"
- Generic fallback: "What is [extracted topic]?"

Presented as a pre-filled editable input with helper text: "We detected this from your page — edit it if you have a different target query."

**Fallback (no HTML fetched):** Extract keywords from URL slug, construct basic query.

---

## 3. AI Visibility Predictions

Two new prediction cards positioned prominently above the existing 8 dimension cards. Visually larger and distinct from dimension cards.

### Google AI Overview Likelihood

Score: High / Medium / Low with percentage estimate. Factors:

- **Query-content alignment** — does the page directly answer the target query in the first 1-2 sentences after a relevant heading?
- **Answer conciseness** — is there a clear, extractable passage (40-60 words) that directly answers the query?
- **Content structure** — proper heading hierarchy, list/table formatting (AI Overviews favor structured formats)
- **Schema markup** — present or absent
- **E-E-A-T signals** — author, dates, citations
- **Content depth** — relative to query complexity

### AI Chat Citation Likelihood

Score: High / Medium / Low. Different weighting — chat models value different signals:

- **Comprehensive coverage** — does the page cover the topic exhaustively?
- **Unique/original content signals** — first-person language, original data references, specific examples
- **Topical authority** — internal linking density, content cluster signals
- **Factual density** — ratio of concrete claims/data to filler
- **Recency signals** — dates, "updated" language

### Card contents:
- Likelihood badge (color-coded: green/yellow/red)
- 2-3 bullet points explaining *why* (e.g., "Your page has a clear 45-word answer to this query in paragraph 2" or "No concise extractable passage found")
- "What to fix" section for Medium/Low scores

---

## 4. Simulated AI Answer Panel

Below the prediction cards. Shows what an AI would likely extract from the page.

### Heading
"How AI would use your content"

### Passage extraction logic:
1. Search all `<p>` elements for text containing keywords from the target query
2. Score each paragraph:
   - Keyword overlap with query
   - Position relative to relevant heading (closer = better)
   - Length (40-120 words ideal)
   - Starts with declarative statement (not a question)
3. Select highest-scoring paragraph
4. Highlight matching keywords within the displayed passage

### Display:
- Clean panel with subtle AI-chat aesthetic (not copying any specific product)
- Extracted passage shown as a blockquote with label: "Most likely cited passage"
- Keywords from the target query highlighted within the passage
- **Empty state:** If no strong passage found, ghost placeholder: "No clear extractable answer found for this query" with guidance on what to write

### Below the passage:
- **"What's missing"** — if passage is too long, too vague, or buries the answer, say so
- **"Ideal answer format"** — hint like "AI engines prefer a direct 1-2 sentence answer followed by supporting detail"

---

## 5. Branded PDF Report

"Download Report" button in the results CTA area alongside existing "Talk to our AEO experts" button.

### Generated client-side using jsPDF. No email gate.

### Contents:
1. **Cover page:** Stretch Creative logo, "AEO Readiness Report," scanned URL, target query, date, overall score with letter grade
2. **AI Visibility Summary:** Two prediction scores with reasoning bullets
3. **Simulated Answer:** Extracted passage with "what's missing" notes
4. **Dimension Breakdown:** 8 dimensions as clean table — name, score, recommendation
5. **Priority Action List:** Top 3 fixes ranked by impact (lowest-scoring dimensions most relevant to target query)
6. **Footer on every page:** "Prepared by Stretch Creative — stretchcreative.co" + "Want help improving your score? Contact us at [link]"

### Styling:
Clean, professional, dark header with brand purple. Consultant-deliverable feel, not UI replication.

### CDN dependency:
- jsPDF (~90kb gzipped) — only new external dependency

---

## 6. Integration & Architecture

### File structure:
Everything stays in `aeo-scanner.php`. Single self-contained file.

### Changes to existing code:

- **`analyzeAEO(html, url)`** → **`analyzeAEO(html, url, query)`** — new parameter. Calculates two visibility predictions and finds citable passage in addition to existing 8 dimensions.
- **`fallbackAnalysis(url)`** → **`fallbackAnalysis(url, query)`** — accepts query, adjusts heuristic predictions.
- **`showResults(dims, url)`** → **`showResults(dims, url, query, predictions, passage)`** — renders new panels above existing dimension grid.
- **New query step UI** — HTML/CSS inserted between input and loading states.
- **New `generatePDF()`** function — handles report creation using jsPDF.
- **New `extractCitablePassage(doc, query)`** function — passage extraction logic.
- **New `predictVisibility(dims, doc, query)`** function — calculates the two AI visibility scores.
- **New `suggestQuery(doc, url)`** function — query auto-suggestion.

### What doesn't change:
- 8 existing analysis dimensions (stay as-is)
- Glassmorphism card, animated border, radar loading, confetti
- "Talk to our AEO experts" CTA
- "Scan Another Page" reset flow
- Mobile responsive behavior (new elements stack naturally)

### Estimated additions:
- ~200-300 lines JS (new analysis + passage extraction + PDF generation)
- ~100 lines CSS (query step + prediction cards + simulated answer panel)
- ~50 lines HTML (query step + new result sections)
