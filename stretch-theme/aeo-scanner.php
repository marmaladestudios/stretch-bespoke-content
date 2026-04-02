<!-- ============================
     AEO READINESS SCANNER
     ============================ -->
<section class="aeo-scanner" id="aeo-scanner">
  <div class="aeo-scanner-container">

    <!-- Input State -->
    <div id="scannerInput" class="aeo-scanner-input">
      <h2 class="aeo-scanner-heading">AEO Readiness Scanner</h2>
      <p class="aeo-scanner-subtitle">See how well your content is optimized for AI-powered search engines and answer engines.</p>
      <div class="aeo-scanner-form">
        <input type="url" id="scanUrl" class="aeo-scanner-url" placeholder="https://example.com/your-page" aria-label="Page URL to scan" />
        <button id="scanBtn" class="aeo-scanner-btn">Scan Page &rarr;</button>
      </div>
      <p class="aeo-scanner-note">Free &mdash; no signup required</p>
    </div>

    <!-- Loading State -->
    <div id="scannerLoading" class="aeo-scanner-loading" style="display:none;">
      <h2 class="aeo-scanner-heading">Analyzing Your Page</h2>
      <div class="aeo-scanner-progress">
        <div class="aeo-scanner-progress-bar"></div>
      </div>
      <p id="loadingStatus" class="aeo-scanner-status">Fetching page...</p>
    </div>

    <!-- Results State -->
    <div id="scannerResults" class="aeo-scanner-results" style="display:none;">
      <div class="aeo-scanner-results-header">
        <div class="aeo-scanner-score-circle">
          <svg viewBox="0 0 160 160" class="aeo-score-svg">
            <circle cx="80" cy="80" r="66" class="aeo-score-track" />
            <circle cx="80" cy="80" r="66" class="aeo-score-fill" id="scoreCircle"
                    stroke-dasharray="414.69"
                    stroke-dashoffset="414.69" />
          </svg>
          <div class="aeo-score-value">
            <span id="scoreNumber">0</span>
            <span id="scoreGrade" class="aeo-score-grade">—</span>
          </div>
        </div>
        <div class="aeo-scanner-score-info">
          <h3 id="scoreLabel" class="aeo-scanner-score-label">Calculating...</h3>
          <p id="scoreInterpretation" class="aeo-scanner-score-interp"></p>
          <p id="scannedUrl" class="aeo-scanner-scanned-url"></p>
        </div>
      </div>

      <div class="aeo-scanner-dimensions" id="dimensionsGrid"></div>

      <div class="aeo-scanner-cta">
        <a href="/contact/" class="aeo-scanner-cta-btn">Want to improve your score? Talk to our AEO experts &rarr;</a>
        <button id="scanAgainBtn" class="aeo-scanner-again">Scan Another Page</button>
      </div>
    </div>

  </div>
</section>

<style>
/* ── AEO Scanner ── */
.aeo-scanner {
  background: #252C3A;
  padding: 80px 0;
  font-family: 'Poppins', 'Assistant', sans-serif;
  color: #fff;
}
.aeo-scanner-container {
  max-width: 960px;
  margin: 0 auto;
  padding: 0 24px;
}
.aeo-scanner-heading {
  font-family: 'Poppins', sans-serif;
  font-size: 36px;
  font-weight: 700;
  margin: 0 0 12px;
  text-align: center;
  color: #fff;
}
.aeo-scanner-subtitle {
  font-family: 'Assistant', sans-serif;
  font-size: 18px;
  color: #a0a8b8;
  text-align: center;
  margin: 0 0 32px;
  max-width: 560px;
  margin-left: auto;
  margin-right: auto;
}
.aeo-scanner-form {
  display: flex;
  gap: 12px;
  max-width: 600px;
  margin: 0 auto 16px;
}
.aeo-scanner-url {
  flex: 1;
  padding: 14px 18px;
  border: 2px solid rgba(255,255,255,0.15);
  border-radius: 8px;
  background: rgba(255,255,255,0.06);
  color: #fff;
  font-size: 16px;
  font-family: 'Assistant', sans-serif;
  outline: none;
  transition: border-color 0.2s;
}
.aeo-scanner-url::placeholder { color: #6b7385; }
.aeo-scanner-url:focus { border-color: #8560A8; }
.aeo-scanner-btn {
  padding: 14px 28px;
  background: linear-gradient(135deg, #8560A8, #5674B9);
  color: #fff;
  border: none;
  border-radius: 8px;
  font-size: 16px;
  font-weight: 600;
  font-family: 'Poppins', sans-serif;
  cursor: pointer;
  white-space: nowrap;
  transition: opacity 0.2s, transform 0.15s;
}
.aeo-scanner-btn:hover { opacity: 0.9; transform: translateY(-1px); }
.aeo-scanner-note {
  text-align: center;
  font-size: 13px;
  color: #6b7385;
  margin: 0;
}

/* Loading */
.aeo-scanner-loading { text-align: center; }
.aeo-scanner-progress {
  max-width: 480px;
  margin: 24px auto 20px;
  height: 6px;
  background: rgba(255,255,255,0.1);
  border-radius: 3px;
  overflow: hidden;
}
.aeo-scanner-progress-bar {
  height: 100%;
  width: 0%;
  background: linear-gradient(90deg, #8560A8, #5674B9, #00BFF3);
  border-radius: 3px;
  animation: aeoProgressPulse 2.4s ease-in-out infinite;
}
@keyframes aeoProgressPulse {
  0% { width: 5%; }
  50% { width: 85%; }
  100% { width: 95%; }
}
.aeo-scanner-status {
  font-size: 16px;
  color: #a0a8b8;
  font-family: 'Assistant', sans-serif;
  min-height: 24px;
}

/* Results */
.aeo-scanner-results-header {
  display: flex;
  align-items: center;
  gap: 36px;
  margin-bottom: 48px;
  justify-content: center;
}
.aeo-scanner-score-circle {
  position: relative;
  width: 140px;
  height: 140px;
  flex-shrink: 0;
}
.aeo-score-svg {
  width: 140px;
  height: 140px;
  transform: rotate(-90deg);
}
.aeo-score-track {
  fill: none;
  stroke: rgba(255,255,255,0.08);
  stroke-width: 10;
}
.aeo-score-fill {
  fill: none;
  stroke: #8560A8;
  stroke-width: 10;
  stroke-linecap: round;
  transition: stroke-dashoffset 1.2s ease-out, stroke 0.4s;
}
.aeo-score-value {
  position: absolute;
  top: 50%; left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
  line-height: 1;
}
.aeo-score-value span:first-child {
  display: block;
  font-size: 42px;
  font-weight: 700;
  font-family: 'Poppins', sans-serif;
}
.aeo-score-grade {
  display: block;
  font-size: 18px;
  font-weight: 600;
  margin-top: 2px;
  font-family: 'Poppins', sans-serif;
}
.aeo-scanner-score-label {
  font-size: 22px;
  font-weight: 700;
  margin: 0 0 8px;
  font-family: 'Poppins', sans-serif;
}
.aeo-scanner-score-interp {
  font-size: 15px;
  color: #a0a8b8;
  margin: 0 0 8px;
  max-width: 380px;
  line-height: 1.5;
  font-family: 'Assistant', sans-serif;
}
.aeo-scanner-scanned-url {
  font-size: 13px;
  color: #6b7385;
  margin: 0;
  word-break: break-all;
  font-family: 'Assistant', sans-serif;
}

/* Dimensions Grid */
.aeo-scanner-dimensions {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 16px;
  margin-bottom: 40px;
}
.aeo-dim-card {
  background: rgba(255,255,255,0.05);
  border-radius: 10px;
  padding: 20px;
  border-left: 4px solid #555;
  transition: transform 0.15s;
}
.aeo-dim-card:hover { transform: translateY(-2px); }
.aeo-dim-card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 8px;
}
.aeo-dim-name {
  font-size: 15px;
  font-weight: 600;
  font-family: 'Poppins', sans-serif;
  color: #fff;
}
.aeo-dim-score-badge {
  font-size: 13px;
  font-weight: 700;
  padding: 2px 10px;
  border-radius: 20px;
  font-family: 'Poppins', sans-serif;
}
.aeo-dim-bar-track {
  height: 5px;
  background: rgba(255,255,255,0.08);
  border-radius: 3px;
  margin-bottom: 10px;
  overflow: hidden;
}
.aeo-dim-bar-fill {
  height: 100%;
  border-radius: 3px;
  width: 0%;
  transition: width 1s ease-out 0.3s;
}
.aeo-dim-rec {
  font-size: 13px;
  color: #a0a8b8;
  margin: 0;
  line-height: 1.45;
  font-family: 'Assistant', sans-serif;
}

/* CTA */
.aeo-scanner-cta {
  text-align: center;
}
.aeo-scanner-cta-btn {
  display: inline-block;
  padding: 16px 36px;
  background: linear-gradient(135deg, #8560A8, #5674B9);
  color: #fff;
  text-decoration: none;
  border-radius: 8px;
  font-size: 16px;
  font-weight: 600;
  font-family: 'Poppins', sans-serif;
  transition: opacity 0.2s, transform 0.15s;
  margin-bottom: 16px;
}
.aeo-scanner-cta-btn:hover { opacity: 0.9; transform: translateY(-1px); color: #fff; }
.aeo-scanner-again {
  display: block;
  margin: 0 auto;
  padding: 10px 24px;
  background: transparent;
  color: #a0a8b8;
  border: 1px solid rgba(255,255,255,0.15);
  border-radius: 6px;
  font-size: 14px;
  font-family: 'Poppins', sans-serif;
  cursor: pointer;
  transition: color 0.2s, border-color 0.2s;
}
.aeo-scanner-again:hover { color: #fff; border-color: rgba(255,255,255,0.35); }

/* Responsive */
@media (max-width: 700px) {
  .aeo-scanner { padding: 48px 0; }
  .aeo-scanner-heading { font-size: 26px; }
  .aeo-scanner-form { flex-direction: column; }
  .aeo-scanner-btn { width: 100%; }
  .aeo-scanner-results-header { flex-direction: column; text-align: center; }
  .aeo-scanner-score-interp { margin-left: auto; margin-right: auto; }
  .aeo-scanner-dimensions { grid-template-columns: 1fr; }
}
</style>

<script>
(function() {
  'use strict';

  /* ── Helpers ── */
  function scoreColor(s) {
    if (s >= 80) return '#28c840';
    if (s >= 60) return '#00BFF3';
    if (s >= 40) return '#F5A623';
    return '#E74C3C';
  }
  function scoreGrade(s) {
    if (s >= 90) return 'A+';
    if (s >= 80) return 'A';
    if (s >= 70) return 'B+';
    if (s >= 60) return 'B';
    if (s >= 50) return 'C+';
    if (s >= 40) return 'C';
    if (s >= 25) return 'D';
    return 'F';
  }
  function clamp(v, lo, hi) { return Math.max(lo, Math.min(hi, v)); }

  /* ── Analysis Engine ── */
  function analyzeAEO(html, url) {
    var parser = new DOMParser();
    var doc = parser.parseFromString(html, 'text/html');
    var dims = [];

    /* 1. Heading Structure */
    (function() {
      var h1s = doc.querySelectorAll('h1');
      var h2s = doc.querySelectorAll('h2');
      var h3s = doc.querySelectorAll('h3');
      var score = 0;
      if (h1s.length === 1) score += 35; else if (h1s.length > 0) score += 15;
      if (h2s.length >= 3) score += 35; else if (h2s.length >= 1) score += 15;
      if (h3s.length >= 1) score += 15;
      // Check nesting: H2 before any H3
      var allH = doc.querySelectorAll('h1,h2,h3');
      var seenH2 = false, goodNest = true;
      for (var i = 0; i < allH.length; i++) {
        if (allH[i].tagName === 'H2') seenH2 = true;
        if (allH[i].tagName === 'H3' && !seenH2) goodNest = false;
      }
      if (goodNest && h2s.length > 0) score += 15;
      score = clamp(score, 0, 100);
      var rec = score >= 80 ? 'Strong heading hierarchy. Your content is well-structured for AI parsing.'
        : score >= 50 ? 'Decent structure. Add more H2 subheadings for better topic segmentation.'
        : 'Add more H2 subheadings and ensure proper H1\u2192H2\u2192H3 nesting.';
      dims.push({ name: 'Heading Structure', score: score, rec: rec });
    })();

    /* 2. Answer-First Format */
    (function() {
      var h2s = doc.querySelectorAll('h2');
      var answerFirst = 0, checked = 0;
      for (var i = 0; i < Math.min(h2s.length, 6); i++) {
        var next = h2s[i].nextElementSibling;
        if (next && next.tagName === 'P') {
          checked++;
          var txt = (next.textContent || '').trim();
          if (txt.length > 30 && txt.charAt(txt.length - 1) !== '?') answerFirst++;
        }
      }
      var score = checked > 0 ? Math.round((answerFirst / checked) * 100) : 20;
      var rec = score >= 80 ? 'Great answer-first format. Your content leads with definitive statements AI engines prefer.'
        : score >= 50 ? 'Some sections start with clear answers. Ensure every section opens with a direct statement.'
        : 'Lead each section with a concise, definitive answer before elaborating. Avoid opening with questions.';
      dims.push({ name: 'Answer-First Format', score: score, rec: rec });
    })();

    /* 3. Content Depth */
    (function() {
      var body = doc.body ? doc.body.textContent || '' : '';
      var words = body.split(/\s+/).filter(function(w) { return w.length > 0; }).length;
      var sections = doc.querySelectorAll('h2').length;
      var score = 0;
      if (words >= 3000) score += 55; else if (words >= 2000) score += 40; else if (words >= 1000) score += 25; else score += 10;
      if (sections >= 6) score += 30; else if (sections >= 3) score += 20; else if (sections >= 1) score += 10;
      score += Math.min(words / 300, 15); // bonus for extra depth
      score = clamp(Math.round(score), 0, 100);
      var rec = score >= 80 ? 'Excellent content depth. Comprehensive content is favored by AI answer engines.'
        : score >= 50 ? 'Good depth, but could be expanded. Aim for 2,000+ words with 6+ distinct sections.'
        : 'Thin content. AI engines prefer comprehensive, in-depth pages. Expand to 2,000+ words.';
      dims.push({ name: 'Content Depth', score: score, rec: rec });
    })();

    /* 4. Schema Markup */
    (function() {
      var scripts = doc.querySelectorAll('script[type="application/ld+json"]');
      var score = 0;
      var types = [];
      if (scripts.length > 0) score += 30;
      for (var i = 0; i < scripts.length; i++) {
        try {
          var data = JSON.parse(scripts[i].textContent);
          var items = Array.isArray(data) ? data : [data];
          items.forEach(function(item) {
            var t = item['@type'] || '';
            if (Array.isArray(t)) t = t.join(',');
            if (/FAQ/i.test(t)) { score += 25; types.push('FAQ'); }
            if (/Article|NewsArticle|BlogPosting/i.test(t)) { score += 20; types.push('Article'); }
            if (/Organization|Person|LocalBusiness/i.test(t)) { score += 15; types.push('Organization'); }
            if (/BreadcrumbList/i.test(t)) { score += 5; types.push('Breadcrumb'); }
            if (/HowTo/i.test(t)) { score += 15; types.push('HowTo'); }
            // Check @graph
            if (item['@graph'] && Array.isArray(item['@graph'])) {
              item['@graph'].forEach(function(g) {
                var gt = g['@type'] || '';
                if (/FAQ/i.test(gt)) { score += 25; types.push('FAQ'); }
                if (/Article|NewsArticle|BlogPosting/i.test(gt)) { score += 20; types.push('Article'); }
                if (/Organization|Person/i.test(gt)) { score += 10; types.push('Organization'); }
              });
            }
          });
        } catch(e) {}
      }
      score = clamp(score, 0, 100);
      var rec = score >= 80 ? 'Excellent schema markup (' + types.join(', ') + '). AI engines can clearly understand your content type.'
        : score >= 40 ? 'Some schema detected. Consider adding FAQ and Article schema for better AI comprehension.'
        : 'No schema markup detected. Add Article and FAQ schema to help AI understand your content.';
      dims.push({ name: 'Schema Markup', score: score, rec: rec });
    })();

    /* 5. E-E-A-T Signals */
    (function() {
      var html_lower = html.toLowerCase();
      var score = 0;
      // Author / byline
      if (/author|byline|written\s*by|posted\s*by/i.test(html)) score += 25;
      if (doc.querySelector('[rel="author"], .author, .byline, [class*="author"]')) score += 10;
      // Dates
      if (doc.querySelector('time, [datetime], .date, .published, [class*="date"]')) score += 20;
      if (/\b(updated|modified|published|reviewed)\b/i.test(html)) score += 5;
      // External citations
      var links = doc.querySelectorAll('a[href]');
      var extCount = 0;
      var domain = '';
      try { domain = new URL(url).hostname; } catch(e) {}
      for (var i = 0; i < links.length; i++) {
        try {
          var h = links[i].getAttribute('href') || '';
          if (/^https?:\/\//.test(h) && h.indexOf(domain) === -1) extCount++;
        } catch(e) {}
      }
      if (extCount >= 3) score += 20; else if (extCount >= 1) score += 10;
      // Credentials mentions
      if (/\b(PhD|MD|expert|certified|years of experience|credential|qualification)\b/i.test(html)) score += 15;
      score = clamp(score, 0, 100);
      var rec = score >= 80 ? 'Strong E-E-A-T signals. Author info, dates, and citations build trust with AI engines.'
        : score >= 50 ? 'Some trust signals present. Add author bios, publication dates, and cite authoritative sources.'
        : 'Weak E-E-A-T signals. Add author bylines, dates, credentials, and external citations.';
      dims.push({ name: 'E-E-A-T Signals', score: score, rec: rec });
    })();

    /* 6. Internal Linking */
    (function() {
      var links = doc.querySelectorAll('a[href]');
      var domain = '';
      try { domain = new URL(url).hostname; } catch(e) {}
      var internal = 0;
      for (var i = 0; i < links.length; i++) {
        var h = links[i].getAttribute('href') || '';
        if (h.startsWith('/') && !h.startsWith('//')) { internal++; }
        else if (domain && h.indexOf(domain) !== -1) { internal++; }
      }
      var score = 0;
      if (internal >= 15) score = 90;
      else if (internal >= 10) score = 75;
      else if (internal >= 5) score = 55;
      else if (internal >= 2) score = 35;
      else score = 10;
      var rec = score >= 80 ? 'Strong internal linking (' + internal + ' links). Helps AI understand your content relationships.'
        : score >= 50 ? 'Moderate internal linking (' + internal + ' links). Aim for 10+ contextual internal links.'
        : 'Weak internal linking (' + internal + ' links). Add more internal links to strengthen topical authority.';
      dims.push({ name: 'Internal Linking', score: score, rec: rec });
    })();

    /* 7. Question Targeting */
    (function() {
      var headings = doc.querySelectorAll('h1,h2,h3,h4');
      var questionH = 0;
      for (var i = 0; i < headings.length; i++) {
        var t = (headings[i].textContent || '').trim();
        if (/^(what|how|why|when|where|who|which|can|do|does|is|are|should|will)\b/i.test(t) || t.indexOf('?') !== -1) {
          questionH++;
        }
      }
      var hasFAQ = doc.querySelector('[class*="faq"], [id*="faq"], [class*="FAQ"], [id*="FAQ"]') !== null;
      var score = 0;
      if (questionH >= 4) score += 60; else if (questionH >= 2) score += 40; else if (questionH >= 1) score += 20;
      if (hasFAQ) score += 35;
      score = clamp(score, 0, 100);
      var rec = score >= 80 ? 'Excellent question targeting. Question-format headings align perfectly with AI query patterns.'
        : score >= 50 ? 'Some question targeting. Add more question-based headings that match how users ask AI.'
        : 'Add question-format headings (e.g., "What is...?", "How do you...?") and an FAQ section.';
      dims.push({ name: 'Question Targeting', score: score, rec: rec });
    })();

    /* 8. Meta Optimization */
    (function() {
      var score = 0;
      var metaDesc = doc.querySelector('meta[name="description"]');
      if (metaDesc) {
        var content = metaDesc.getAttribute('content') || '';
        score += 25;
        if (content.length >= 120 && content.length <= 160) score += 20;
        else if (content.length >= 50) score += 10;
      }
      var title = doc.querySelector('title');
      if (title) {
        var tLen = (title.textContent || '').trim().length;
        score += 15;
        if (tLen >= 30 && tLen <= 65) score += 15;
        else if (tLen > 0) score += 5;
      }
      var canonical = doc.querySelector('link[rel="canonical"]');
      if (canonical) score += 15;
      var ogTitle = doc.querySelector('meta[property="og:title"]');
      if (ogTitle) score += 10;
      score = clamp(score, 0, 100);
      var rec = score >= 80 ? 'Well-optimized meta tags. AI engines use these signals to understand page relevance.'
        : score >= 50 ? 'Partial meta optimization. Ensure your meta description is 120-160 characters and title is under 65.'
        : 'Missing key meta tags. Add a descriptive meta description, optimize your title tag, and add a canonical URL.';
      dims.push({ name: 'Meta Optimization', score: score, rec: rec });
    })();

    return dims;
  }

  /* ── Fallback Analysis ── */
  function fallbackAnalysis(url) {
    var path = url.toLowerCase();
    var dims = [];
    var hasBlog = /\/blog\/|\/article|\/post|\/news/i.test(path);
    var isHome = path.replace(/^https?:\/\/[^\/]+\/?$/, '') === '';

    dims.push({ name: 'Heading Structure', score: hasBlog ? 55 : 35,
      rec: 'Unable to fully analyze (page blocked proxy). Blog pages typically have reasonable heading structure.' });
    dims.push({ name: 'Answer-First Format', score: 40,
      rec: 'Could not parse content. Ensure each section opens with a direct, concise answer.' });
    dims.push({ name: 'Content Depth', score: hasBlog ? 50 : 30,
      rec: 'Could not measure word count. Aim for 2,000+ words with 6+ sections.' });
    dims.push({ name: 'Schema Markup', score: 25,
      rec: 'Could not detect schema. Add Article and FAQ JSON-LD schema markup.' });
    dims.push({ name: 'E-E-A-T Signals', score: 30,
      rec: 'Could not verify trust signals. Add author info, dates, and external citations.' });
    dims.push({ name: 'Internal Linking', score: 40,
      rec: 'Could not count internal links. Aim for 10+ contextual internal links per page.' });
    dims.push({ name: 'Question Targeting', score: 25,
      rec: 'Could not verify question headings. Add question-format H2s and an FAQ section.' });
    dims.push({ name: 'Meta Optimization', score: 45,
      rec: 'Most sites have basic meta tags. Ensure 120-160 char description and optimized title.' });

    return dims;
  }

  /* ── Show Results ── */
  function showResults(dims, url) {
    var total = 0;
    for (var i = 0; i < dims.length; i++) total += dims[i].score;
    var overall = Math.round(total / dims.length);
    var color = scoreColor(overall);
    var grade = scoreGrade(overall);

    // Hide loading, show results
    document.getElementById('scannerLoading').style.display = 'none';
    document.getElementById('scannerResults').style.display = 'block';

    // Score circle animation
    var circumference = 414.69;
    var offset = circumference - (overall / 100) * circumference;
    var circle = document.getElementById('scoreCircle');
    circle.style.stroke = color;
    setTimeout(function() { circle.style.strokeDashoffset = offset; }, 50);

    // Count up number
    var numEl = document.getElementById('scoreNumber');
    var gradeEl = document.getElementById('scoreGrade');
    gradeEl.style.color = color;
    var current = 0;
    var step = Math.max(1, Math.floor(overall / 40));
    var counter = setInterval(function() {
      current += step;
      if (current >= overall) { current = overall; clearInterval(counter); }
      numEl.textContent = current;
    }, 30);
    setTimeout(function() { gradeEl.textContent = grade; }, 600);

    // Score label & interpretation
    var label, interp;
    if (overall >= 80) { label = 'Excellent AEO Readiness'; interp = 'Your page is well-optimized for AI answer engines. Fine-tune the areas below for an even stronger edge.'; }
    else if (overall >= 60) { label = 'Good AEO Readiness'; interp = 'Solid foundation, but there are clear opportunities to improve your visibility in AI-powered search.'; }
    else if (overall >= 40) { label = 'Moderate AEO Readiness'; interp = 'Your page has some AEO fundamentals but needs significant improvement to compete in AI search results.'; }
    else { label = 'Low AEO Readiness'; interp = 'This page is not well-optimized for AI answer engines. Addressing the issues below could substantially improve your visibility.'; }
    document.getElementById('scoreLabel').textContent = label;
    document.getElementById('scoreLabel').style.color = color;
    document.getElementById('scoreInterpretation').textContent = interp;
    document.getElementById('scannedUrl').textContent = url;

    // Dimension cards
    var grid = document.getElementById('dimensionsGrid');
    grid.innerHTML = '';
    for (var i = 0; i < dims.length; i++) {
      var d = dims[i];
      var c = scoreColor(d.score);
      var card = document.createElement('div');
      card.className = 'aeo-dim-card';
      card.style.borderLeftColor = c;
      card.innerHTML =
        '<div class="aeo-dim-card-header">' +
          '<span class="aeo-dim-name">' + d.name + '</span>' +
          '<span class="aeo-dim-score-badge" style="background:' + c + '22;color:' + c + ';">' + d.score + '/100</span>' +
        '</div>' +
        '<div class="aeo-dim-bar-track"><div class="aeo-dim-bar-fill" style="background:linear-gradient(90deg,' + c + ',' + c + 'aa);"></div></div>' +
        '<p class="aeo-dim-rec">' + d.rec + '</p>';
      grid.appendChild(card);
      // Animate bar
      (function(fill, score) {
        setTimeout(function() { fill.style.width = score + '%'; }, 100);
      })(card.querySelector('.aeo-dim-bar-fill'), d.score);
    }
  }

  /* ── Event Listeners ── */
  document.getElementById('scanBtn').addEventListener('click', async function() {
    var url = document.getElementById('scanUrl').value.trim();
    if (!url) {
      document.getElementById('scanUrl').focus();
      return;
    }
    if (!url.match(/^https?:\/\//)) url = 'https://' + url;

    // Show loading
    document.getElementById('scannerInput').style.display = 'none';
    document.getElementById('scannerLoading').style.display = 'block';

    // Cycle messages
    var messages = ['Fetching page...', 'Analyzing heading structure...', 'Checking schema markup...', 'Evaluating E-E-A-T signals...', 'Scoring content depth...', 'Calculating AEO score...'];
    var msgIdx = 0;
    var msgInterval = setInterval(function() {
      msgIdx = (msgIdx + 1) % messages.length;
      document.getElementById('loadingStatus').textContent = messages[msgIdx];
    }, 800);

    try {
      var response = await fetch('https://api.allorigins.win/raw?url=' + encodeURIComponent(url));
      if (!response.ok) throw new Error('Fetch failed');
      var html = await response.text();
      var results = analyzeAEO(html, url);
      clearInterval(msgInterval);
      showResults(results, url);
    } catch(e) {
      clearInterval(msgInterval);
      var fallback = fallbackAnalysis(url);
      showResults(fallback, url);
    }
  });

  // Enter key
  document.getElementById('scanUrl').addEventListener('keydown', function(e) {
    if (e.key === 'Enter') document.getElementById('scanBtn').click();
  });

  // Scan again
  document.getElementById('scanAgainBtn').addEventListener('click', function() {
    document.getElementById('scannerResults').style.display = 'none';
    document.getElementById('scannerInput').style.display = 'block';
    document.getElementById('scanUrl').value = '';
    document.getElementById('scanUrl').focus();
    // Reset circle
    document.getElementById('scoreCircle').style.strokeDashoffset = '414.69';
    document.getElementById('scoreNumber').textContent = '0';
    document.getElementById('scoreGrade').textContent = '\u2014';
    document.getElementById('dimensionsGrid').innerHTML = '';
  });
})();
</script>
