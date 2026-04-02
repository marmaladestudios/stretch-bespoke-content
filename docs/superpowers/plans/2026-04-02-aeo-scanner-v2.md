# AEO Scanner v2 Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Upgrade the AEO Scanner from generic page scoring to query-specific AI visibility predictions with simulated answer extraction and branded PDF export.

**Architecture:** All client-side, single file (`stretch-theme/aeo-scanner.php`). New query input step between URL fetch and analysis. New `predictVisibility()`, `extractCitablePassage()`, `suggestQuery()`, and `generatePDF()` functions added to the existing IIFE. jsPDF loaded via CDN for PDF generation.

**Tech Stack:** Vanilla JS, CSS, HTML, jsPDF (CDN), DOMParser (existing)

**Spec:** `docs/superpowers/specs/2026-04-02-aeo-scanner-v2-design.md`

---

### Task 1: Add Query Step HTML and CSS

**Files:**
- Modify: `stretch-theme/aeo-scanner.php:69` (insert new HTML before Loading State)
- Modify: `stretch-theme/aeo-scanner.php` (add CSS after existing styles, before `</style>`)

This task adds the new query input step UI that appears after the page is fetched but before analysis begins.

- [ ] **Step 1: Add query step HTML**

Insert this block immediately before the `<!-- Loading State -->` comment (line 69 of aeo-scanner.php):

```html
      <!-- Query Step -->
      <div id="scannerQuery" class="aeo-scanner-query" style="display:none;">
        <h2 class="aeo-scanner-heading">What question do you want to rank for?</h2>
        <p class="aeo-scanner-subtitle">We detected this from your page — edit it if you have a different target query.</p>
        <div class="aeo-scanner-query-form">
          <input type="text" id="targetQuery" class="aeo-scanner-query-input" placeholder="e.g. What is answer engine optimization?" aria-label="Target query" />
          <button id="analyzeBtn" class="aeo-scanner-btn">Analyze &rarr;</button>
        </div>
        <p class="aeo-scanner-note">This query shapes your AI visibility predictions</p>
      </div>
```

- [ ] **Step 2: Add query step CSS**

Insert these styles before the closing `</style>` tag, after the responsive media query block:

```css
/* ── Query Step ── */
.aeo-scanner-query {
  position: relative;
  z-index: 1;
}
.aeo-scanner-query-form {
  display: flex;
  gap: 12px;
  max-width: 600px;
  margin: 0 auto 16px;
}
.aeo-scanner-query-input {
  flex: 1;
  padding: 14px 18px;
  border: 2px solid rgba(255,255,255,0.12);
  border-radius: 10px;
  background: rgba(255,255,255,0.05);
  color: #fff;
  font-size: 16px;
  font-family: 'Assistant', sans-serif;
  outline: none;
  transition: border-color 0.3s, box-shadow 0.3s, background 0.3s;
}
.aeo-scanner-query-input::placeholder { color: #6b7385; }
.aeo-scanner-query-input:focus {
  border-color: #8560A8;
  box-shadow: 0 0 0 3px rgba(133,96,168,0.15), 0 0 20px rgba(133,96,168,0.08);
  background: rgba(255,255,255,0.07);
}
@media (max-width: 700px) {
  .aeo-scanner-query-form { flex-direction: column; }
}
```

- [ ] **Step 3: Verify in browser**

Open `http://localhost:8888/blog/aeo/` and confirm the scanner still renders correctly. The query step is hidden by default so nothing should change visually.

- [ ] **Step 4: Commit**

```bash
git add stretch-theme/aeo-scanner.php
git commit -m "feat(scanner): add query step HTML and CSS"
```

---

### Task 2: Add suggestQuery() Function

**Files:**
- Modify: `stretch-theme/aeo-scanner.php` (add function inside the IIFE, after the `clamp()` helper around line 784)

This task adds the query auto-suggestion engine that infers a target query from the fetched page HTML.

- [ ] **Step 1: Add suggestQuery function**

Insert this function after the `clamp()` helper (line 784), before the `typewriterText()` function:

```javascript
  /* ── Query Auto-Suggestion ── */
  function suggestQuery(doc, url) {
    // Helper: convert statement to question
    function toQuestion(text) {
      text = text.trim().replace(/\s+/g, ' ');
      // Already a question
      if (text.endsWith('?')) return text;
      // "How to X" patterns
      var howTo = text.match(/^how\s+to\s+(.+)/i);
      if (howTo) return 'How do you ' + howTo[1].replace(/\.$/, '') + '?';
      // "Guide to X" / "Introduction to X"
      var guideTo = text.match(/^(?:a\s+)?(?:guide|introduction|intro)\s+to\s+(.+)/i);
      if (guideTo) return 'What is ' + guideTo[1].replace(/\.$/, '') + '?';
      // "N Ways/Tips/Steps to X"
      var nWays = text.match(/^\d+\s+(?:ways|tips|steps|strategies|methods)\s+(?:to|for)\s+(.+)/i);
      if (nWays) return 'How do you ' + nWays[1].replace(/\.$/, '') + '?';
      // "What is X" already
      if (/^what\s+is/i.test(text)) return text.replace(/\.$/, '') + '?';
      // "Why X" / "When X" already question-like
      if (/^(why|when|where|who|which|can|should|does|do|is|are)\s+/i.test(text)) return text.replace(/\.$/, '') + '?';
      // Default: "What is [topic]?"
      // Strip common suffixes like " | Brand Name", " - Brand"
      var clean = text.replace(/\s*[\|\-–—]\s*[^|\-–—]+$/, '').trim();
      if (clean.length > 5 && clean.length < 80) return 'What is ' + clean.toLowerCase() + '?';
      return '';
    }

    // Priority 1: H1 tag
    var h1 = doc.querySelector('h1');
    if (h1) {
      var h1Text = (h1.textContent || '').trim();
      if (h1Text.length > 5) {
        var q = toQuestion(h1Text);
        if (q) return q;
      }
    }

    // Priority 2: Meta description
    var metaDesc = doc.querySelector('meta[name="description"]');
    if (metaDesc) {
      var desc = (metaDesc.getAttribute('content') || '').trim();
      if (desc.length > 20) {
        // Extract the first sentence or clause
        var firstSentence = desc.split(/[.!]/).filter(function(s) { return s.trim().length > 10; })[0];
        if (firstSentence) {
          var q = toQuestion(firstSentence.trim());
          if (q) return q;
        }
      }
    }

    // Priority 3: First H2
    var h2 = doc.querySelector('h2');
    if (h2) {
      var h2Text = (h2.textContent || '').trim();
      if (h2Text.length > 5) {
        var q = toQuestion(h2Text);
        if (q) return q;
      }
    }

    // Priority 4: Title tag
    var title = doc.querySelector('title');
    if (title) {
      var titleText = (title.textContent || '').trim();
      if (titleText.length > 5) {
        var q = toQuestion(titleText);
        if (q) return q;
      }
    }

    // Fallback: extract from URL slug
    try {
      var pathname = new URL(url).pathname;
      var slug = pathname.split('/').filter(function(s) { return s.length > 0; }).pop() || '';
      var words = slug.replace(/[-_]/g, ' ').trim();
      if (words.length > 3) return 'What is ' + words + '?';
    } catch(e) {}

    return 'What is this page about?';
  }
```

- [ ] **Step 2: Test manually in browser console**

Open `http://localhost:8888/blog/aeo/`, open dev tools console, and test:

```javascript
// Create a test document
var parser = new DOMParser();
var testDoc = parser.parseFromString('<html><head><title>How to Build a Content Strategy | Acme</title></head><body><h1>How to Build a Content Strategy</h1></body></html>', 'text/html');
// The function is inside an IIFE so we can't call it directly — we'll test it end-to-end in Task 4
```

Visual verification will happen in Task 4 when the flow is wired together.

- [ ] **Step 3: Commit**

```bash
git add stretch-theme/aeo-scanner.php
git commit -m "feat(scanner): add suggestQuery auto-suggestion engine"
```

---

### Task 3: Add extractCitablePassage() and predictVisibility() Functions

**Files:**
- Modify: `stretch-theme/aeo-scanner.php` (add functions inside the IIFE, after `suggestQuery()`)

- [ ] **Step 1: Add extractCitablePassage function**

Insert after `suggestQuery()`:

```javascript
  /* ── Citable Passage Extraction ── */
  function extractCitablePassage(doc, query) {
    var queryWords = query.toLowerCase().replace(/[?.,!]/g, '').split(/\s+/).filter(function(w) {
      return w.length > 2 && ['what','how','why','when','where','who','which','can','do','does','is','are','the','and','for','that','this','with','from','your','you','have','has'].indexOf(w) === -1;
    });
    var paragraphs = doc.querySelectorAll('p');
    var best = null;
    var bestScore = -1;

    for (var i = 0; i < paragraphs.length; i++) {
      var text = (paragraphs[i].textContent || '').trim();
      var words = text.split(/\s+/);
      // Skip too short or too long
      if (words.length < 15 || words.length > 200) continue;

      var score = 0;
      var lower = text.toLowerCase();

      // Keyword overlap (most important signal)
      var matchCount = 0;
      for (var k = 0; k < queryWords.length; k++) {
        if (lower.indexOf(queryWords[k]) !== -1) matchCount++;
      }
      if (queryWords.length > 0) {
        score += (matchCount / queryWords.length) * 50;
      }

      // Ideal length bonus (40-120 words)
      if (words.length >= 40 && words.length <= 120) score += 15;
      else if (words.length >= 20 && words.length <= 150) score += 8;

      // Starts with declarative statement (not a question)
      if (text.charAt(text.length - 1) !== '?' && !/^(but|however|although|yet)\b/i.test(text)) score += 10;

      // Position bonus — earlier paragraphs slightly preferred
      if (i < 5) score += 10;
      else if (i < 10) score += 5;

      // Proximity to heading containing query words
      var prev = paragraphs[i].previousElementSibling;
      if (prev && /^H[1-6]$/.test(prev.tagName)) {
        var hText = prev.textContent.toLowerCase();
        var headingMatch = 0;
        for (var k = 0; k < queryWords.length; k++) {
          if (hText.indexOf(queryWords[k]) !== -1) headingMatch++;
        }
        if (headingMatch > 0) score += 15;
      }

      if (score > bestScore) {
        bestScore = score;
        best = { text: text, score: score, wordCount: words.length, index: i };
      }
    }

    if (!best || bestScore < 10) {
      return { found: false, text: '', feedback: 'No clear extractable answer found for this query. Consider adding a concise paragraph (40-80 words) that directly answers the question.', wordCount: 0 };
    }

    // Generate feedback
    var feedback = [];
    if (best.wordCount > 120) feedback.push('This passage is ' + best.wordCount + ' words — AI engines prefer concise answers of 40-80 words. Consider tightening it.');
    if (best.wordCount < 30) feedback.push('This passage is very short. AI engines prefer answers with enough context — aim for 40-80 words.');
    if (best.score < 25) feedback.push('Weak query alignment — the passage doesn\'t strongly match your target query. Rewrite the opening to directly address the question.');
    if (best.index > 10) feedback.push('This passage appears deep in the page. Move your best answer closer to the top for stronger AI visibility.');
    if (feedback.length === 0) feedback.push('Strong candidate for AI citation. Clear, well-positioned, and relevant to your target query.');

    return { found: true, text: best.text, feedback: feedback.join(' '), wordCount: best.wordCount };
  }
```

- [ ] **Step 2: Add predictVisibility function**

Insert after `extractCitablePassage()`:

```javascript
  /* ── AI Visibility Predictions ── */
  function predictVisibility(dims, doc, query, passage) {
    var queryWords = query.toLowerCase().replace(/[?.,!]/g, '').split(/\s+/).filter(function(w) {
      return w.length > 2;
    });

    // Gather dimension scores by name for easy access
    var dimScores = {};
    for (var i = 0; i < dims.length; i++) {
      dimScores[dims[i].name] = dims[i].score;
    }

    // === Google AI Overview Prediction ===
    var gScore = 0;
    var gReasons = [];
    var gFixes = [];

    // Query-content alignment (check if any heading contains query keywords)
    var headings = doc.querySelectorAll('h1,h2,h3');
    var headingMatchCount = 0;
    for (var i = 0; i < headings.length; i++) {
      var hLower = (headings[i].textContent || '').toLowerCase();
      for (var k = 0; k < queryWords.length; k++) {
        if (hLower.indexOf(queryWords[k]) !== -1) { headingMatchCount++; break; }
      }
    }
    if (headingMatchCount >= 2) { gScore += 20; gReasons.push('Multiple headings match your target query'); }
    else if (headingMatchCount >= 1) { gScore += 10; gReasons.push('One heading matches your target query'); }
    else { gFixes.push('Add headings that directly include your target query keywords'); }

    // Answer conciseness (from passage extraction)
    if (passage.found && passage.wordCount >= 30 && passage.wordCount <= 80) {
      gScore += 25; gReasons.push('Found a concise ' + passage.wordCount + '-word answer passage');
    } else if (passage.found && passage.wordCount > 80) {
      gScore += 12; gFixes.push('Your best answer passage is ' + passage.wordCount + ' words — tighten to 40-60 words for AI Overview format');
    } else if (passage.found) {
      gScore += 8; gFixes.push('Your answer passage is very brief — expand to 40-60 words with supporting context');
    } else {
      gFixes.push('No extractable answer found — add a concise paragraph directly answering the query');
    }

    // Content structure
    if ((dimScores['Heading Structure'] || 0) >= 70) { gScore += 15; gReasons.push('Strong heading hierarchy for content parsing'); }
    else { gFixes.push('Improve heading hierarchy — AI Overviews rely on well-structured content'); }

    // Lists and tables (AI Overviews love these)
    var lists = doc.querySelectorAll('ul, ol, table');
    if (lists.length >= 3) { gScore += 10; gReasons.push('Structured formatting (lists/tables) detected'); }
    else if (lists.length >= 1) { gScore += 5; }
    else { gFixes.push('Add lists or tables — AI Overviews heavily favor structured formats'); }

    // Schema markup
    if ((dimScores['Schema Markup'] || 0) >= 60) { gScore += 10; gReasons.push('Schema markup helps AI understand content type'); }
    else { gFixes.push('Add Article/FAQ schema to clarify content type for Google'); }

    // E-E-A-T
    if ((dimScores['E-E-A-T Signals'] || 0) >= 60) { gScore += 10; }

    // Content depth
    if ((dimScores['Content Depth'] || 0) >= 70) { gScore += 10; }

    gScore = Math.min(gScore, 100);
    var gLevel = gScore >= 65 ? 'High' : gScore >= 35 ? 'Medium' : 'Low';

    // === AI Chat Citation Prediction ===
    var cScore = 0;
    var cReasons = [];
    var cFixes = [];

    // Comprehensive coverage
    if ((dimScores['Content Depth'] || 0) >= 70) { cScore += 20; cReasons.push('Comprehensive content depth signals thorough coverage'); }
    else if ((dimScores['Content Depth'] || 0) >= 50) { cScore += 10; cFixes.push('Expand content depth — chat models pull from the most comprehensive source'); }
    else { cFixes.push('Thin content. Chat models prefer exhaustive resources — aim for 2,000+ words'); }

    // Unique/original signals
    var bodyText = (doc.body ? doc.body.textContent : '') || '';
    var hasFirstPerson = /\b(I |we |our |my )\b/i.test(bodyText);
    var hasData = /\b(\d+%|\d+x|survey|study|research|data shows|according to)\b/i.test(bodyText);
    var hasExamples = /\b(for example|for instance|such as|e\.g\.|case study)\b/i.test(bodyText);
    if (hasFirstPerson || hasData || hasExamples) {
      var origScore = 0;
      if (hasFirstPerson) origScore += 5;
      if (hasData) origScore += 10;
      if (hasExamples) origScore += 5;
      cScore += origScore;
      if (hasData) cReasons.push('Original data/research references detected');
      if (hasExamples) cReasons.push('Specific examples strengthen citation likelihood');
    }
    if (!hasData && !hasExamples) { cFixes.push('Add original data, statistics, or specific examples — chat models favor unique content'); }

    // Topical authority
    if ((dimScores['Internal Linking'] || 0) >= 60) { cScore += 15; cReasons.push('Strong internal linking signals topical authority'); }
    else { cFixes.push('Increase internal linking to signal topical authority'); }

    // Factual density (crude: count sentences with numbers or specific claims)
    var sentences = bodyText.split(/[.!?]+/).filter(function(s) { return s.trim().length > 20; });
    var factualCount = 0;
    for (var i = 0; i < sentences.length; i++) {
      if (/\d/.test(sentences[i]) || /\b(because|therefore|specifically|exactly|precisely)\b/i.test(sentences[i])) factualCount++;
    }
    var factRatio = sentences.length > 0 ? factualCount / sentences.length : 0;
    if (factRatio >= 0.3) { cScore += 15; cReasons.push('High factual density — concrete claims over filler'); }
    else if (factRatio >= 0.15) { cScore += 8; }
    else { cFixes.push('Increase factual density — replace vague statements with specific data and claims'); }

    // Recency signals
    if (/\b(2025|2026|updated|last updated|revised)\b/i.test(bodyText)) { cScore += 10; cReasons.push('Recency signals detected (dates/update language)'); }
    else { cFixes.push('Add publication/update dates — chat models prefer fresh content'); }

    // Query alignment bonus
    if (passage.found) { cScore += 15; }

    cScore = Math.min(cScore, 100);
    var cLevel = cScore >= 65 ? 'High' : cScore >= 35 ? 'Medium' : 'Low';

    return {
      google: { score: gScore, level: gLevel, reasons: gReasons, fixes: gFixes },
      chat: { score: cScore, level: cLevel, reasons: cReasons, fixes: cFixes }
    };
  }
```

- [ ] **Step 3: Commit**

```bash
git add stretch-theme/aeo-scanner.php
git commit -m "feat(scanner): add passage extraction and AI visibility prediction engines"
```

---

### Task 4: Wire Up the Query Step Flow

**Files:**
- Modify: `stretch-theme/aeo-scanner.php` (modify the scan button event listener and add analyze button listener)

This task connects the new query step into the existing flow: URL input → page fetch → query step → loading → results.

- [ ] **Step 1: Modify the scan button click handler**

Find the existing scan button event listener (starts at line 1203 with `document.getElementById('scanBtn').addEventListener('click', async function() {`). Replace the entire handler (from that line through the closing `});` for that listener — approximately lines 1203-1259) with:

```javascript
  /* ── Shared state ── */
  var fetchedHtml = null;
  var fetchedUrl = null;
  var parsedDoc = null;

  document.getElementById('scanBtn').addEventListener('click', async function() {
    var url = document.getElementById('scanUrl').value.trim();
    if (!url) {
      document.getElementById('scanUrl').focus();
      return;
    }
    if (!url.match(/^https?:\/\//)) url = 'https://' + url;
    fetchedUrl = url;

    // Show loading while fetching
    document.getElementById('scannerInput').style.display = 'none';
    document.getElementById('scannerLoading').style.display = 'block';

    var messages = ['Fetching page...', 'Reading content structure...', 'Preparing analysis...'];
    var msgIdx = 0;
    var statusEl = document.getElementById('loadingStatus');
    var currentTypewriter = null;

    function showNextMessage() {
      if (currentTypewriter) clearInterval(currentTypewriter);
      currentTypewriter = typewriterText(statusEl, messages[msgIdx], 25, function() {
        setTimeout(function() {
          msgIdx = (msgIdx + 1) % messages.length;
          showNextMessage();
        }, 400);
      });
    }
    showNextMessage();

    // Try CORS proxies
    var proxies = [
      'https://api.allorigins.win/raw?url=',
      'https://corsproxy.io/?',
      'https://api.codetabs.com/v1/proxy?quest='
    ];
    var html = null;
    for (var pi = 0; pi < proxies.length; pi++) {
      try {
        var response = await fetch(proxies[pi] + encodeURIComponent(url), { signal: AbortSignal.timeout(8000) });
        if (response.ok) {
          var text = await response.text();
          if (text.length > 500 && (text.indexOf('<html') !== -1 || text.indexOf('<head') !== -1 || text.indexOf('<body') !== -1)) {
            html = text;
            break;
          }
        }
      } catch(e) {}
    }

    if (currentTypewriter) clearInterval(currentTypewriter);

    // Store fetched data
    fetchedHtml = html;
    if (html) {
      var parser = new DOMParser();
      parsedDoc = parser.parseFromString(html, 'text/html');
    } else {
      parsedDoc = null;
    }

    // Suggest a query
    var suggestedQuery = '';
    if (parsedDoc) {
      suggestedQuery = suggestQuery(parsedDoc, url);
    } else {
      // Fallback: extract from URL
      try {
        var pathname = new URL(url).pathname;
        var slug = pathname.split('/').filter(function(s) { return s.length > 0; }).pop() || '';
        var words = slug.replace(/[-_]/g, ' ').trim();
        suggestedQuery = words.length > 3 ? 'What is ' + words + '?' : 'What is this page about?';
      } catch(e) {
        suggestedQuery = 'What is this page about?';
      }
    }

    // Show query step
    document.getElementById('scannerLoading').style.display = 'none';
    document.getElementById('scannerQuery').style.display = 'block';
    document.getElementById('targetQuery').value = suggestedQuery;
    document.getElementById('targetQuery').focus();
  });
```

- [ ] **Step 2: Add analyze button click handler**

Insert this right after the scan button listener (before the Enter key listener):

```javascript
  document.getElementById('analyzeBtn').addEventListener('click', function() {
    var query = document.getElementById('targetQuery').value.trim();
    if (!query) {
      document.getElementById('targetQuery').focus();
      return;
    }

    // Show loading with query-specific messages
    document.getElementById('scannerQuery').style.display = 'none';
    document.getElementById('scannerLoading').style.display = 'block';

    var messages = [
      'Testing AI visibility for: ' + query,
      'Analyzing heading structure...',
      'Checking schema markup...',
      'Evaluating E-E-A-T signals...',
      'Extracting citable passages...',
      'Predicting AI Overview likelihood...',
      'Calculating AEO score...'
    ];
    var msgIdx = 0;
    var statusEl = document.getElementById('loadingStatus');
    var currentTypewriter = null;

    function showNextMessage() {
      if (currentTypewriter) clearInterval(currentTypewriter);
      currentTypewriter = typewriterText(statusEl, messages[msgIdx], 25, function() {
        setTimeout(function() {
          msgIdx = (msgIdx + 1) % messages.length;
          showNextMessage();
        }, 400);
      });
    }
    showNextMessage();

    // Run analysis after brief delay for dramatic effect
    setTimeout(function() {
      if (currentTypewriter) clearInterval(currentTypewriter);
      var dims, passage, predictions;

      if (fetchedHtml && parsedDoc) {
        dims = analyzeAEO(fetchedHtml, fetchedUrl);
        passage = extractCitablePassage(parsedDoc, query);
        predictions = predictVisibility(dims, parsedDoc, query, passage);
      } else {
        dims = fallbackAnalysis(fetchedUrl);
        passage = { found: false, text: '', feedback: 'Could not fetch page content. Predictions are based on URL heuristics.', wordCount: 0 };
        predictions = {
          google: { score: 35, level: 'Medium', reasons: ['Unable to analyze page content directly'], fixes: ['Ensure your page is publicly accessible for best results'] },
          chat: { score: 35, level: 'Medium', reasons: ['Unable to analyze page content directly'], fixes: ['Ensure your page is publicly accessible for best results'] }
        };
      }

      showResults(dims, fetchedUrl, query, predictions, passage);
    }, 1800);
  });

  // Enter key on query input
  document.getElementById('targetQuery').addEventListener('keydown', function(e) {
    if (e.key === 'Enter') document.getElementById('analyzeBtn').click();
  });
```

- [ ] **Step 3: Update the "Scan Again" handler**

Find the existing `scanAgainBtn` click handler (starts around line 1268). Replace it with:

```javascript
  document.getElementById('scanAgainBtn').addEventListener('click', function() {
    document.getElementById('scannerResults').style.display = 'none';
    document.getElementById('scannerQuery').style.display = 'none';
    document.getElementById('scannerInput').style.display = 'block';
    document.getElementById('scanUrl').value = '';
    document.getElementById('scanUrl').focus();
    // Reset circle
    document.getElementById('scoreCircle').style.strokeDashoffset = '414.69';
    document.getElementById('scoreNumber').textContent = '0';
    document.getElementById('scoreGrade').textContent = '\u2014';
    document.getElementById('dimensionsGrid').innerHTML = '';
    // Reset glow
    var scoreCircleEl = document.querySelector('.aeo-scanner-score-circle');
    if (scoreCircleEl) scoreCircleEl.style.filter = '';
    // Clear confetti
    var confettiEl = document.getElementById('aeoConfetti');
    if (confettiEl) confettiEl.innerHTML = '';
    // Clear new sections
    var predEl = document.getElementById('predictionsPanel');
    if (predEl) predEl.innerHTML = '';
    var passEl = document.getElementById('passagePanel');
    if (passEl) passEl.innerHTML = '';
    // Reset shared state
    fetchedHtml = null;
    fetchedUrl = null;
    parsedDoc = null;
  });
```

- [ ] **Step 4: Test end-to-end in browser**

Open `http://localhost:8888/blog/aeo/`. Enter a URL (e.g., `https://en.wikipedia.org/wiki/Search_engine_optimization`). Verify:
1. Loading appears while fetching
2. Query step appears with an auto-suggested query
3. Editing the query and clicking "Analyze" shows loading again
4. Results appear (they'll be missing the new panels — that's Task 5)
5. "Scan Another Page" resets everything cleanly

- [ ] **Step 5: Commit**

```bash
git add stretch-theme/aeo-scanner.php
git commit -m "feat(scanner): wire up query step flow between URL input and analysis"
```

---

### Task 5: Add AI Visibility Predictions and Passage Panel to Results

**Files:**
- Modify: `stretch-theme/aeo-scanner.php` (update `showResults()` function and add HTML/CSS for new panels)

- [ ] **Step 1: Add predictions and passage panel HTML**

Find the results section HTML. Insert these two new containers inside `#scannerResults`, right after the `.aeo-scanner-results-header` div (after approximately line 103) and before the `.aeo-scanner-dimensions` div:

```html
        <div class="aeo-scanner-predictions" id="predictionsPanel"></div>
        <div class="aeo-scanner-passage" id="passagePanel"></div>
```

- [ ] **Step 2: Add CSS for prediction cards and passage panel**

Insert before the closing `</style>` tag:

```css
/* ── AI Visibility Predictions ── */
.aeo-scanner-predictions {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 16px;
  margin-bottom: 32px;
}
.aeo-pred-card {
  background: rgba(255,255,255,0.04);
  border-radius: 16px;
  padding: 24px;
  border: 1px solid rgba(255,255,255,0.08);
  transition: transform 0.2s, background 0.2s;
}
.aeo-pred-card:hover {
  transform: translateY(-3px);
  background: rgba(255,255,255,0.06);
}
.aeo-pred-card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 16px;
}
.aeo-pred-title {
  font-family: 'Poppins', sans-serif;
  font-size: 16px;
  font-weight: 600;
  color: #fff;
}
.aeo-pred-badge {
  font-family: 'Poppins', sans-serif;
  font-size: 13px;
  font-weight: 700;
  padding: 4px 14px;
  border-radius: 20px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}
.aeo-pred-reasons {
  list-style: none;
  padding: 0;
  margin: 0 0 12px;
}
.aeo-pred-reasons li {
  font-family: 'Assistant', sans-serif;
  font-size: 14px;
  color: #c0c8d8;
  padding: 4px 0;
  padding-left: 20px;
  position: relative;
  line-height: 1.5;
}
.aeo-pred-reasons li::before {
  content: '';
  position: absolute;
  left: 0;
  top: 10px;
  width: 8px;
  height: 8px;
  border-radius: 50%;
}
.aeo-pred-reasons li.aeo-pred-good::before { background: #28c840; }
.aeo-pred-reasons li.aeo-pred-fix::before { background: #F5A623; }
.aeo-pred-fixes-label {
  font-family: 'Poppins', sans-serif;
  font-size: 12px;
  font-weight: 600;
  color: #F5A623;
  text-transform: uppercase;
  letter-spacing: 1px;
  margin: 12px 0 6px;
}

/* ── Simulated Answer Panel ── */
.aeo-scanner-passage {
  margin-bottom: 32px;
}
.aeo-passage-card {
  background: rgba(255,255,255,0.03);
  border-radius: 16px;
  padding: 28px;
  border: 1px solid rgba(255,255,255,0.08);
}
.aeo-passage-heading {
  font-family: 'Poppins', sans-serif;
  font-size: 16px;
  font-weight: 600;
  color: #fff;
  margin: 0 0 8px;
  display: flex;
  align-items: center;
  gap: 10px;
}
.aeo-passage-heading-icon {
  width: 28px;
  height: 28px;
  background: rgba(0,191,243,0.1);
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  color: #00BFF3;
}
.aeo-passage-label {
  font-family: 'Poppins', sans-serif;
  font-size: 11px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 1.5px;
  color: #6b7385;
  margin: 16px 0 10px;
}
.aeo-passage-blockquote {
  background: rgba(133,96,168,0.06);
  border-left: 3px solid #8560A8;
  border-radius: 0 8px 8px 0;
  padding: 16px 20px;
  margin: 0 0 16px;
  font-family: 'Assistant', sans-serif;
  font-size: 15px;
  line-height: 1.65;
  color: #d0d6e0;
}
.aeo-passage-blockquote .aeo-kw-highlight {
  background: rgba(0,191,243,0.15);
  color: #00BFF3;
  padding: 1px 4px;
  border-radius: 3px;
}
.aeo-passage-empty {
  text-align: center;
  padding: 24px;
  color: #6b7385;
  font-family: 'Assistant', sans-serif;
  font-size: 15px;
  border: 1px dashed rgba(255,255,255,0.1);
  border-radius: 8px;
}
.aeo-passage-feedback {
  font-family: 'Assistant', sans-serif;
  font-size: 14px;
  color: #a0a8b8;
  margin: 0;
  line-height: 1.5;
}
.aeo-passage-tip {
  font-family: 'Assistant', sans-serif;
  font-size: 13px;
  color: #6b7385;
  margin: 12px 0 0;
  font-style: italic;
}

@media (max-width: 700px) {
  .aeo-scanner-predictions { grid-template-columns: 1fr; }
}
```

- [ ] **Step 3: Update showResults function signature and add prediction/passage rendering**

Find the existing `showResults` function (starts around line 1103 with `function showResults(dims, url) {`). Replace the function signature:

```javascript
  function showResults(dims, url, query, predictions, passage) {
```

Then, inside `showResults`, right after the dimension grid rendering loop (after the closing of `for (var i = 0; i < dims.length; i++) {` block and its bar animation IIFE), add this code to render the prediction cards and passage panel:

```javascript
    // ── Render AI Visibility Predictions ──
    var predPanel = document.getElementById('predictionsPanel');
    predPanel.innerHTML = '';

    function renderPredCard(pred, title, iconSvg) {
      var badgeColor = pred.level === 'High' ? '#28c840' : pred.level === 'Medium' ? '#F5A623' : '#E74C3C';
      var card = document.createElement('div');
      card.className = 'aeo-pred-card';

      var reasonsHtml = '';
      for (var r = 0; r < pred.reasons.length; r++) {
        reasonsHtml += '<li class="aeo-pred-good">' + pred.reasons[r] + '</li>';
      }
      var fixesHtml = '';
      if (pred.fixes.length > 0) {
        fixesHtml = '<div class="aeo-pred-fixes-label">What to fix</div><ul class="aeo-pred-reasons">';
        for (var f = 0; f < pred.fixes.length; f++) {
          fixesHtml += '<li class="aeo-pred-fix">' + pred.fixes[f] + '</li>';
        }
        fixesHtml += '</ul>';
      }

      card.innerHTML =
        '<div class="aeo-pred-card-header">' +
          '<span class="aeo-pred-title">' + iconSvg + ' ' + title + '</span>' +
          '<span class="aeo-pred-badge" style="background:' + badgeColor + '22;color:' + badgeColor + ';">' + pred.level + ' (' + pred.score + '%)</span>' +
        '</div>' +
        '<ul class="aeo-pred-reasons">' + reasonsHtml + '</ul>' +
        fixesHtml;

      return card;
    }

    predPanel.appendChild(renderPredCard(
      predictions.google,
      'Google AI Overview',
      '<svg viewBox="0 0 18 18" width="16" height="16" fill="none" style="vertical-align:-2px;"><circle cx="9" cy="9" r="7" stroke="#00BFF3" stroke-width="1.5"/><path d="M9 5v4l3 2" stroke="#00BFF3" stroke-width="1.3" stroke-linecap="round"/></svg>'
    ));
    predPanel.appendChild(renderPredCard(
      predictions.chat,
      'AI Chat Citation',
      '<svg viewBox="0 0 18 18" width="16" height="16" fill="none" style="vertical-align:-2px;"><rect x="2" y="3" width="14" height="10" rx="2" stroke="#8560A8" stroke-width="1.5"/><path d="M6 15l2-2h0" stroke="#8560A8" stroke-width="1.5" stroke-linecap="round"/><path d="M6 7h6M6 10h4" stroke="#8560A8" stroke-width="1.2"/></svg>'
    ));

    // ── Render Simulated Answer Panel ──
    var passPanel = document.getElementById('passagePanel');
    passPanel.innerHTML = '';

    var passCard = document.createElement('div');
    passCard.className = 'aeo-passage-card';

    var headingHtml = '<div class="aeo-passage-heading">' +
      '<span class="aeo-passage-heading-icon"><svg viewBox="0 0 16 16" width="14" height="14" fill="none"><path d="M2 4h12M2 8h8M2 12h10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg></span>' +
      'How AI would use your content' +
    '</div>';

    if (passage.found) {
      // Highlight query keywords in the passage text
      var highlightedText = passage.text;
      var kwWords = query.toLowerCase().replace(/[?.,!]/g, '').split(/\s+/).filter(function(w) {
        return w.length > 3 && ['what','how','why','when','where','this','that','with','from','your','have'].indexOf(w) === -1;
      });
      for (var k = 0; k < kwWords.length; k++) {
        var regex = new RegExp('(' + kwWords[k].replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'gi');
        highlightedText = highlightedText.replace(regex, '<span class="aeo-kw-highlight">$1</span>');
      }

      passCard.innerHTML = headingHtml +
        '<div class="aeo-passage-label">Most likely cited passage</div>' +
        '<blockquote class="aeo-passage-blockquote">' + highlightedText + '</blockquote>' +
        '<p class="aeo-passage-feedback">' + passage.feedback + '</p>' +
        '<p class="aeo-passage-tip">Tip: AI engines prefer a direct 1-2 sentence answer followed by supporting detail.</p>';
    } else {
      passCard.innerHTML = headingHtml +
        '<div class="aeo-passage-empty">' + passage.feedback + '</div>' +
        '<p class="aeo-passage-tip">Tip: Add a concise paragraph (40-80 words) that directly answers your target query near the top of the page.</p>';
    }

    passPanel.appendChild(passCard);
```

- [ ] **Step 4: Test in browser**

Open `http://localhost:8888/blog/aeo/`. Scan a URL. Verify:
1. AI Visibility prediction cards appear above the dimension grid with color-coded badges
2. Passage panel shows extracted text with highlighted keywords (or empty state)
3. Existing dimension cards still render correctly below
4. Mobile responsive (resize browser narrow) — prediction cards stack to single column

- [ ] **Step 5: Commit**

```bash
git add stretch-theme/aeo-scanner.php
git commit -m "feat(scanner): render AI visibility predictions and simulated answer panel in results"
```

---

### Task 6: Add PDF Report Generation

**Files:**
- Modify: `stretch-theme/aeo-scanner.php` (add jsPDF CDN script tag, add generatePDF function, add download button)

- [ ] **Step 1: Add jsPDF CDN script**

In `stretch-theme/category.php`, find where `aeo-scanner.php` is included (around line 924-927). The scanner is loaded via `get_template_part` or `include`. We need to add the jsPDF script before the scanner include. Find the scanner include line and add this before it:

```php
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.2/jspdf.umd.min.js" crossorigin="anonymous"></script>
```

If the scanner is included via `<?php include(get_template_directory() . '/aeo-scanner.php'); ?>`, place the script tag on the line immediately before it.

- [ ] **Step 2: Add download button HTML**

In `aeo-scanner.php`, find the `.aeo-scanner-cta` div (around line 106-109). Replace it with:

```html
        <div class="aeo-scanner-cta">
          <a href="/contact-stretch-creative/" class="aeo-scanner-cta-btn">Want to improve your score? Talk to our AEO experts &rarr;</a>
          <div class="aeo-scanner-cta-row">
            <button id="downloadPdfBtn" class="aeo-scanner-pdf-btn">
              <svg viewBox="0 0 18 18" width="16" height="16" fill="none" style="vertical-align:-2px;"><path d="M9 2v10M5 8l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M3 14h12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
              Download PDF Report
            </button>
            <button id="scanAgainBtn" class="aeo-scanner-again">Scan Another Page</button>
          </div>
        </div>
```

- [ ] **Step 3: Add PDF button CSS**

Insert before the closing `</style>`:

```css
/* ── CTA Row ── */
.aeo-scanner-cta-row {
  display: flex;
  gap: 12px;
  justify-content: center;
  margin-top: 12px;
}
.aeo-scanner-pdf-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 10px 24px;
  background: rgba(133,96,168,0.12);
  color: #c0a8e0;
  border: 1px solid rgba(133,96,168,0.3);
  border-radius: 8px;
  font-size: 14px;
  font-family: 'Poppins', sans-serif;
  font-weight: 500;
  cursor: pointer;
  transition: background 0.2s, border-color 0.2s, color 0.2s, transform 0.15s;
}
.aeo-scanner-pdf-btn:hover {
  background: rgba(133,96,168,0.2);
  border-color: rgba(133,96,168,0.5);
  color: #fff;
  transform: translateY(-1px);
}
@media (max-width: 700px) {
  .aeo-scanner-cta-row { flex-direction: column; align-items: center; }
}
```

- [ ] **Step 4: Add generatePDF function and click handler**

Insert inside the IIFE, after the `predictVisibility()` function and before the event listeners section:

```javascript
  /* ── PDF Report Generation ── */
  function generatePDF(dims, url, query, predictions, passage, overallScore, grade) {
    var jsPDF = window.jspdf.jsPDF;
    var doc = new jsPDF('p', 'mm', 'a4');
    var pageW = 210;
    var margin = 20;
    var contentW = pageW - margin * 2;
    var y = 0;

    function addFooter() {
      doc.setFontSize(9);
      doc.setTextColor(120, 120, 140);
      doc.text('Prepared by Stretch Creative — stretchcreative.co', margin, 285);
      doc.text('Want help improving your score? Visit stretchcreative.co/contact-stretch-creative/', margin, 290);
    }

    // ── Cover Page ──
    doc.setFillColor(37, 44, 58);
    doc.rect(0, 0, pageW, 297, 'F');

    // Brand header bar
    doc.setFillColor(133, 96, 168);
    doc.rect(0, 0, pageW, 6, 'F');

    // Title
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(28);
    doc.setTextColor(255, 255, 255);
    doc.text('AEO Readiness Report', margin, 50);

    // Subtitle
    doc.setFont('helvetica', 'normal');
    doc.setFontSize(13);
    doc.setTextColor(160, 168, 184);
    doc.text('AI Visibility Analysis', margin, 62);

    // URL and query
    doc.setFontSize(11);
    doc.setTextColor(200, 200, 220);
    doc.text('URL: ' + url, margin, 85, { maxWidth: contentW });
    doc.text('Target Query: ' + query, margin, 95, { maxWidth: contentW });
    doc.text('Date: ' + new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }), margin, 105);

    // Score circle (simplified)
    var scoreColor = overallScore >= 80 ? [40, 200, 64] : overallScore >= 60 ? [0, 191, 243] : overallScore >= 40 ? [245, 166, 35] : [231, 76, 60];
    doc.setFillColor(45, 52, 68);
    doc.circle(pageW / 2, 160, 30, 'F');
    doc.setDrawColor(scoreColor[0], scoreColor[1], scoreColor[2]);
    doc.setLineWidth(2.5);
    doc.circle(pageW / 2, 160, 30, 'S');
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(32);
    doc.setTextColor(scoreColor[0], scoreColor[1], scoreColor[2]);
    doc.text(String(overallScore), pageW / 2, 157, { align: 'center' });
    doc.setFontSize(16);
    doc.text(grade, pageW / 2, 170, { align: 'center' });

    // Branding
    doc.setFont('helvetica', 'normal');
    doc.setFontSize(10);
    doc.setTextColor(107, 115, 133);
    doc.text('Stretch Creative', pageW / 2, 210, { align: 'center' });
    doc.text('stretchcreative.co', pageW / 2, 218, { align: 'center' });

    addFooter();

    // ── Page 2: AI Visibility ──
    doc.addPage();
    doc.setFillColor(255, 255, 255);
    doc.rect(0, 0, pageW, 297, 'F');

    doc.setFillColor(133, 96, 168);
    doc.rect(0, 0, pageW, 6, 'F');

    y = 24;
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(18);
    doc.setTextColor(37, 44, 58);
    doc.text('AI Visibility Predictions', margin, y);
    y += 14;

    function writePredSection(pred, title) {
      var badgeColor = pred.level === 'High' ? [40, 200, 64] : pred.level === 'Medium' ? [245, 166, 35] : [231, 76, 60];
      doc.setFont('helvetica', 'bold');
      doc.setFontSize(14);
      doc.setTextColor(37, 44, 58);
      doc.text(title + ': ', margin, y);
      doc.setTextColor(badgeColor[0], badgeColor[1], badgeColor[2]);
      doc.text(pred.level + ' (' + pred.score + '%)', margin + doc.getTextWidth(title + ': '), y);
      y += 8;

      doc.setFont('helvetica', 'normal');
      doc.setFontSize(10);
      doc.setTextColor(80, 80, 100);
      for (var r = 0; r < pred.reasons.length; r++) {
        var lines = doc.splitTextToSize('+ ' + pred.reasons[r], contentW - 10);
        doc.text(lines, margin + 5, y);
        y += lines.length * 5;
      }
      if (pred.fixes.length > 0) {
        y += 3;
        doc.setFont('helvetica', 'bold');
        doc.setFontSize(9);
        doc.setTextColor(245, 166, 35);
        doc.text('WHAT TO FIX:', margin + 5, y);
        y += 5;
        doc.setFont('helvetica', 'normal');
        doc.setFontSize(10);
        doc.setTextColor(80, 80, 100);
        for (var f = 0; f < pred.fixes.length; f++) {
          var lines = doc.splitTextToSize('- ' + pred.fixes[f], contentW - 10);
          doc.text(lines, margin + 5, y);
          y += lines.length * 5;
        }
      }
      y += 10;
    }

    writePredSection(predictions.google, 'Google AI Overview');
    writePredSection(predictions.chat, 'AI Chat Citation');

    // Simulated Answer
    y += 5;
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(14);
    doc.setTextColor(37, 44, 58);
    doc.text('Simulated AI Answer', margin, y);
    y += 8;

    if (passage.found) {
      doc.setFillColor(245, 243, 250);
      var passLines = doc.splitTextToSize(passage.text, contentW - 16);
      var passHeight = passLines.length * 5 + 12;
      doc.rect(margin, y - 4, contentW, passHeight, 'F');
      doc.setDrawColor(133, 96, 168);
      doc.setLineWidth(0.8);
      doc.line(margin, y - 4, margin, y - 4 + passHeight);
      doc.setFont('helvetica', 'normal');
      doc.setFontSize(10);
      doc.setTextColor(60, 60, 80);
      doc.text(passLines, margin + 8, y + 2);
      y += passHeight + 6;
      doc.setFontSize(9);
      doc.setTextColor(100, 100, 120);
      var fbLines = doc.splitTextToSize(passage.feedback, contentW);
      doc.text(fbLines, margin, y);
      y += fbLines.length * 4 + 4;
    } else {
      doc.setFont('helvetica', 'italic');
      doc.setFontSize(10);
      doc.setTextColor(120, 120, 140);
      doc.text(passage.feedback, margin, y);
      y += 8;
    }

    addFooter();

    // ── Page 3: Dimension Breakdown ──
    doc.addPage();
    doc.setFillColor(255, 255, 255);
    doc.rect(0, 0, pageW, 297, 'F');

    doc.setFillColor(133, 96, 168);
    doc.rect(0, 0, pageW, 6, 'F');

    y = 24;
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(18);
    doc.setTextColor(37, 44, 58);
    doc.text('Dimension Breakdown', margin, y);
    y += 12;

    for (var i = 0; i < dims.length; i++) {
      var d = dims[i];
      var dColor = d.score >= 80 ? [40, 200, 64] : d.score >= 60 ? [0, 191, 243] : d.score >= 40 ? [245, 166, 35] : [231, 76, 60];

      if (y > 260) {
        addFooter();
        doc.addPage();
        doc.setFillColor(255, 255, 255);
        doc.rect(0, 0, pageW, 297, 'F');
        doc.setFillColor(133, 96, 168);
        doc.rect(0, 0, pageW, 6, 'F');
        y = 24;
      }

      // Dimension name and score
      doc.setFont('helvetica', 'bold');
      doc.setFontSize(11);
      doc.setTextColor(37, 44, 58);
      doc.text(d.name, margin, y);
      doc.setTextColor(dColor[0], dColor[1], dColor[2]);
      doc.text(d.score + '/100', margin + contentW - 20, y, { align: 'right' });

      // Score bar
      y += 4;
      doc.setFillColor(230, 230, 235);
      doc.roundedRect(margin, y, contentW, 3, 1.5, 1.5, 'F');
      doc.setFillColor(dColor[0], dColor[1], dColor[2]);
      doc.roundedRect(margin, y, contentW * (d.score / 100), 3, 1.5, 1.5, 'F');
      y += 6;

      // Recommendation
      doc.setFont('helvetica', 'normal');
      doc.setFontSize(9);
      doc.setTextColor(80, 80, 100);
      var recLines = doc.splitTextToSize(d.rec, contentW);
      doc.text(recLines, margin, y);
      y += recLines.length * 4 + 8;
    }

    // ── Priority Action List ──
    y += 5;
    if (y > 240) {
      addFooter();
      doc.addPage();
      doc.setFillColor(255, 255, 255);
      doc.rect(0, 0, pageW, 297, 'F');
      doc.setFillColor(133, 96, 168);
      doc.rect(0, 0, pageW, 6, 'F');
      y = 24;
    }

    doc.setFont('helvetica', 'bold');
    doc.setFontSize(14);
    doc.setTextColor(37, 44, 58);
    doc.text('Priority Actions', margin, y);
    y += 10;

    // Sort dims by score ascending, take top 3
    var sorted = dims.slice().sort(function(a, b) { return a.score - b.score; });
    var top3 = sorted.slice(0, 3);
    doc.setFont('helvetica', 'normal');
    doc.setFontSize(10);
    doc.setTextColor(60, 60, 80);
    for (var i = 0; i < top3.length; i++) {
      var actionLines = doc.splitTextToSize((i + 1) + '. ' + top3[i].name + ' (' + top3[i].score + '/100): ' + top3[i].rec, contentW);
      doc.text(actionLines, margin, y);
      y += actionLines.length * 5 + 4;
    }

    addFooter();

    // Save
    var filename = 'AEO-Report-' + new Date().toISOString().slice(0, 10) + '.pdf';
    doc.save(filename);
  }
```

- [ ] **Step 5: Store results data for PDF access and add click handler**

We need to store the analysis results so the PDF button can access them. Add these variables alongside the shared state variables (where `fetchedHtml`, `fetchedUrl`, `parsedDoc` are declared):

```javascript
  var lastDims = null;
  var lastQuery = null;
  var lastPredictions = null;
  var lastPassage = null;
  var lastOverallScore = 0;
  var lastGrade = '';
```

At the top of `showResults()`, after calculating `overall`, `color`, and `grade`, add:

```javascript
    lastDims = dims;
    lastQuery = query;
    lastPredictions = predictions;
    lastPassage = passage;
    lastOverallScore = overall;
    lastGrade = grade;
```

Then add the PDF button click handler after the `scanAgainBtn` handler:

```javascript
  document.getElementById('downloadPdfBtn').addEventListener('click', function() {
    if (lastDims) {
      generatePDF(lastDims, fetchedUrl, lastQuery, lastPredictions, lastPassage, lastOverallScore, lastGrade);
    }
  });
```

- [ ] **Step 6: Test PDF generation in browser**

Open `http://localhost:8888/blog/aeo/`. Run a full scan. Click "Download PDF Report." Verify:
1. PDF downloads with a filename like `AEO-Report-2026-04-02.pdf`
2. Cover page shows score, URL, query, date, and Stretch Creative branding
3. Page 2 shows AI visibility predictions and simulated answer
4. Page 3 shows dimension breakdown and priority actions
5. Footer appears on every page with Stretch Creative CTA

- [ ] **Step 7: Commit**

```bash
git add stretch-theme/aeo-scanner.php stretch-theme/category.php
git commit -m "feat(scanner): add branded PDF report generation with jsPDF"
```

---

### Task 7: Final Integration Testing and Polish

**Files:**
- Modify: `stretch-theme/aeo-scanner.php` (if any fixes needed)

- [ ] **Step 1: Full end-to-end test — successful fetch**

Open `http://localhost:8888/blog/aeo/`. Enter a content-rich URL (e.g., `https://en.wikipedia.org/wiki/Search_engine_optimization`). Walk through the complete flow:
1. URL input → click "Scan Page"
2. Loading appears → transitions to query step with suggested query
3. Edit or accept query → click "Analyze"
4. Loading with query-specific messages → results appear
5. Verify: score circle animates, prediction cards show with reasons/fixes, passage panel shows extracted text with highlighted keywords, dimension cards render below
6. Click "Download PDF Report" → verify PDF content
7. Click "Scan Another Page" → verify clean reset of all states

- [ ] **Step 2: Full end-to-end test — failed fetch (fallback)**

Enter a URL that will fail CORS (e.g., `https://example.internal/page`). Verify:
1. Query step still appears with URL-slug-based suggestion
2. Analysis runs with fallback heuristics
3. Predictions show "Unable to analyze page content directly" message
4. Passage panel shows empty state
5. PDF still generates correctly with fallback data

- [ ] **Step 3: Mobile responsive test**

Resize browser to ~375px width. Verify:
1. Query input and button stack vertically
2. Prediction cards stack to single column
3. Passage panel is readable
4. CTA buttons (PDF + Scan Again) stack vertically
5. No horizontal overflow anywhere

- [ ] **Step 4: Commit any fixes**

If any issues were found and fixed:

```bash
git add stretch-theme/aeo-scanner.php
git commit -m "fix(scanner): polish and responsive fixes for scanner v2"
```

- [ ] **Step 5: Final commit — update feature card descriptions**

Update the three feature cards in the scanner input state (lines 33-59) to reflect the new capabilities. Replace the existing feature cards HTML:

```html
          <div class="aeo-scanner-features">
            <div class="aeo-scanner-feature-card">
              <div class="aeo-scanner-feature-icon aeo-scanner-feature-icon--purple">
                <svg viewBox="0 0 20 20" fill="none" width="18" height="18"><rect x="2" y="4" width="16" height="12" rx="1" stroke="currentColor" stroke-width="1.5"/><path d="M6 8h8M6 11h5" stroke="currentColor" stroke-width="1.2"/></svg>
              </div>
              <div>
                <strong>AI Visibility Predictions</strong>
                <span>Google AI Overview & chat citation likelihood for your target query</span>
              </div>
            </div>
            <div class="aeo-scanner-feature-card">
              <div class="aeo-scanner-feature-icon aeo-scanner-feature-icon--blue">
                <svg viewBox="0 0 20 20" fill="none" width="18" height="18"><path d="M10 2v6l4 2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><circle cx="10" cy="10" r="8" stroke="currentColor" stroke-width="1.5"/></svg>
              </div>
              <div>
                <strong>Simulated AI Answer</strong>
                <span>See which passage AI engines would extract from your page</span>
              </div>
            </div>
            <div class="aeo-scanner-feature-card">
              <div class="aeo-scanner-feature-icon aeo-scanner-feature-icon--cyan">
                <svg viewBox="0 0 20 20" fill="none" width="18" height="18"><path d="M4 14l4-4 3 3 5-7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
              </div>
              <div>
                <strong>PDF Report</strong>
                <span>Download a branded report with scores, fixes, and priority actions</span>
              </div>
            </div>
          </div>
```

```bash
git add stretch-theme/aeo-scanner.php
git commit -m "feat(scanner): update feature card descriptions for v2 capabilities"
```
