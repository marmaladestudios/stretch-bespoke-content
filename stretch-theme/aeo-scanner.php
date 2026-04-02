<!-- ============================
     AEO READINESS SCANNER
     ============================ -->
<section class="aeo-scanner" id="aeo-scanner">
  <div class="aeo-scanner-container">

    <!-- App Card (animated gradient border) -->
    <div class="aeo-scanner-card">
      <div class="aeo-scanner-card-inner">

        <!-- Floating particles -->
        <div class="aeo-scanner-dots">
          <div class="aeo-scanner-dot" style="top:12%;left:8%;animation-delay:0s;"></div>
          <div class="aeo-scanner-dot" style="top:28%;left:85%;animation-delay:1.2s;"></div>
          <div class="aeo-scanner-dot" style="top:65%;left:15%;animation-delay:2.4s;"></div>
          <div class="aeo-scanner-dot" style="top:80%;left:78%;animation-delay:0.8s;"></div>
          <div class="aeo-scanner-dot" style="top:45%;left:92%;animation-delay:3.6s;"></div>
          <div class="aeo-scanner-dot" style="top:90%;left:45%;animation-delay:1.8s;"></div>
          <div class="aeo-scanner-dot" style="top:18%;left:55%;animation-delay:4.2s;"></div>
        </div>

        <!-- App Header -->
        <div class="aeo-scanner-app-header">
          <div class="aeo-scanner-app-badge">Free Tool</div>
        </div>

        <!-- Input State -->
        <div id="scannerInput" class="aeo-scanner-input">
          <h2 class="aeo-scanner-heading">Are you AEO Ready?</h2>
          <p class="aeo-scanner-subtitle">Find out if your content is optimized for AI-powered search engines like ChatGPT, Gemini, and Perplexity.</p>

          <div class="aeo-scanner-features">
            <div class="aeo-scanner-feature-card">
              <div class="aeo-scanner-feature-icon aeo-scanner-feature-icon--purple">
                <svg viewBox="0 0 20 20" fill="none" width="18" height="18"><rect x="2" y="4" width="16" height="12" rx="1" stroke="currentColor" stroke-width="1.5"/><path d="M6 8h8M6 11h5" stroke="currentColor" stroke-width="1.2"/></svg>
              </div>
              <div>
                <strong>Content Analysis</strong>
                <span>Heading structure, content depth, answer-first formatting</span>
              </div>
            </div>
            <div class="aeo-scanner-feature-card">
              <div class="aeo-scanner-feature-icon aeo-scanner-feature-icon--blue">
                <svg viewBox="0 0 20 20" fill="none" width="18" height="18"><path d="M10 2v6l4 2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><circle cx="10" cy="10" r="8" stroke="currentColor" stroke-width="1.5"/></svg>
              </div>
              <div>
                <strong>Technical Signals</strong>
                <span>Schema markup, E-E-A-T signals, meta optimization</span>
              </div>
            </div>
            <div class="aeo-scanner-feature-card">
              <div class="aeo-scanner-feature-icon aeo-scanner-feature-icon--cyan">
                <svg viewBox="0 0 20 20" fill="none" width="18" height="18"><path d="M4 14l4-4 3 3 5-7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
              </div>
              <div>
                <strong>Actionable Report</strong>
                <span>8 scored dimensions with specific fixes and recommended reading</span>
              </div>
            </div>
          </div>

          <div class="aeo-scanner-form">
            <input type="url" id="scanUrl" class="aeo-scanner-url" placeholder="https://yourdomain.com/your-page" aria-label="Page URL to scan" />
            <button id="scanBtn" class="aeo-scanner-btn">Scan Page &rarr;</button>
          </div>
          <p class="aeo-scanner-note">Instant results &mdash; no signup required</p>
        </div>

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

      <!-- Loading State -->
      <div id="scannerLoading" class="aeo-scanner-loading" style="display:none;">
        <h2 class="aeo-scanner-heading">Analyzing Your Page</h2>
        <div class="aeo-scanner-radar">
          <div class="aeo-scanner-radar-ring aeo-scanner-radar-ring--1"></div>
          <div class="aeo-scanner-radar-ring aeo-scanner-radar-ring--2"></div>
          <div class="aeo-scanner-radar-ring aeo-scanner-radar-ring--3"></div>
          <div class="aeo-scanner-radar-sweep"></div>
          <div class="aeo-scanner-radar-center"></div>
        </div>
        <p id="loadingStatus" class="aeo-scanner-status"></p>
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
              <span id="scoreGrade" class="aeo-score-grade">&mdash;</span>
            </div>
          </div>
          <div class="aeo-scanner-score-info">
            <h3 id="scoreLabel" class="aeo-scanner-score-label">Calculating...</h3>
            <p id="scoreInterpretation" class="aeo-scanner-score-interp"></p>
            <p id="scannedUrl" class="aeo-scanner-scanned-url"></p>
          </div>
        </div>

        <div class="aeo-scanner-predictions" id="predictionsPanel"></div>
        <div class="aeo-scanner-passage" id="passagePanel"></div>

        <div class="aeo-scanner-dimensions" id="dimensionsGrid"></div>

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
      </div>

      </div><!-- /.aeo-scanner-card-inner -->
    </div><!-- /.aeo-scanner-card -->

    <!-- Confetti container (positioned over card) -->
    <div id="aeoConfetti" class="aeo-scanner-confetti"></div>
  </div>
</section>

<style>
/* ── AEO Scanner Premium ── */

/* Animated border angle property */
@property --scanner-angle {
  syntax: '<angle>';
  initial-value: 0deg;
  inherits: false;
}

.aeo-scanner {
  background: #fff;
  padding: 0 0 60px;
  font-family: 'Poppins', 'Assistant', sans-serif;
}
.aeo-scanner-container {
  max-width: 1120px;
  margin: 0 auto;
  padding: 0 40px;
  position: relative;
}

/* ── Animated Gradient Border Card ── */
.aeo-scanner-card {
  padding: 3px;
  background: conic-gradient(from var(--scanner-angle), #8560A8, #5674B9, #448CCB, #00BFF3, #8560A8);
  animation: scannerBorderSpin 8s linear infinite;
  border-radius: 24px;
  box-shadow:
    0 0 30px rgba(133,96,168,0.15),
    0 0 60px rgba(0,191,243,0.08),
    0 20px 60px rgba(37,44,58,0.3);
  position: relative;
}
@keyframes scannerBorderSpin {
  to { --scanner-angle: 360deg; }
}

/* ── Glassmorphism Inner Card ── */
.aeo-scanner-card-inner {
  background: rgba(37, 44, 58, 0.95);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border-radius: 21px;
  padding: 48px;
  position: relative;
  overflow: hidden;
  color: #fff;
}

/* Grid background pattern */
.aeo-scanner-card-inner::before {
  content: '';
  position: absolute;
  inset: 0;
  background-image:
    linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
  background-size: 40px 40px;
  pointer-events: none;
  mask-image: radial-gradient(ellipse 70% 60% at 50% 50%, transparent 30%, black 80%);
  -webkit-mask-image: radial-gradient(ellipse 70% 60% at 50% 50%, transparent 30%, black 80%);
}

/* ── Floating Particles ── */
.aeo-scanner-dots {
  position: absolute;
  inset: 0;
  pointer-events: none;
  overflow: hidden;
  z-index: 0;
}
.aeo-scanner-dot {
  position: absolute;
  width: 4px;
  height: 4px;
  border-radius: 50%;
  background: rgba(0,191,243,0.3);
  animation: floatDot 6s ease-in-out infinite;
}
.aeo-scanner-dot:nth-child(odd) {
  background: rgba(133,96,168,0.3);
  animation-duration: 8s;
}
.aeo-scanner-dot:nth-child(3n) {
  width: 3px;
  height: 3px;
  background: rgba(86,116,185,0.25);
  animation-duration: 7s;
}
@keyframes floatDot {
  0%, 100% { transform: translateY(0) scale(1); opacity: 0.3; }
  50% { transform: translateY(-20px) scale(1.5); opacity: 0.7; }
}

/* ── App Header ── */
.aeo-scanner-app-header {
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 32px;
  position: relative;
  z-index: 1;
}
.aeo-scanner-app-icon {
  width: 44px;
  height: 44px;
  background: rgba(0,191,243,0.1);
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  animation: iconPulse 3s ease-in-out infinite;
  transition: transform 0.2s, box-shadow 0.2s;
}
.aeo-scanner-app-icon:hover {
  transform: scale(1.08);
  box-shadow: 0 0 16px rgba(0,191,243,0.2);
}
@keyframes iconPulse {
  0%, 100% { box-shadow: 0 0 0 0 rgba(0,191,243,0.15); }
  50% { box-shadow: 0 0 0 8px rgba(0,191,243,0); }
}
.aeo-scanner-app-icon svg { width: 24px; height: 24px; }
.aeo-scanner-app-badge {
  font-family: 'Poppins', sans-serif;
  font-size: 11px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 1.5px;
  color: #00BFF3;
  border: 1px solid rgba(0,191,243,0.3);
  padding: 4px 12px;
  border-radius: 20px;
  transition: background 0.2s, border-color 0.2s;
}
.aeo-scanner-app-badge:hover {
  background: rgba(0,191,243,0.08);
  border-color: rgba(0,191,243,0.5);
}

/* ── Feature Cards ── */
.aeo-scanner-features {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 14px;
  margin: 28px 0 36px;
  position: relative;
  z-index: 1;
}
.aeo-scanner-feature-card {
  display: flex;
  align-items: flex-start;
  gap: 14px;
  padding: 16px;
  background: rgba(255,255,255,0.04);
  border: 1px solid rgba(255,255,255,0.06);
  border-radius: 12px;
  transition: background 0.2s, border-color 0.2s, transform 0.2s;
}
.aeo-scanner-feature-card:hover {
  background: rgba(255,255,255,0.07);
  border-color: rgba(255,255,255,0.12);
  transform: translateY(-2px);
}
.aeo-scanner-feature-card strong {
  display: block;
  font-family: 'Poppins', sans-serif;
  font-size: 13px;
  font-weight: 600;
  color: #fff;
  margin-bottom: 4px;
}
.aeo-scanner-feature-card span {
  font-family: 'Assistant', sans-serif;
  font-size: 13px;
  color: rgba(255,255,255,0.5);
  line-height: 1.4;
}
@media (max-width: 700px) {
  .aeo-scanner-features { grid-template-columns: 1fr; }
}
.aeo-scanner-feature-icon {
  width: 32px;
  height: 32px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  transition: transform 0.2s, box-shadow 0.2s;
}
.aeo-scanner-feature:hover .aeo-scanner-feature-icon {
  transform: scale(1.1);
}
.aeo-scanner-feature-icon--purple {
  background: rgba(133,96,168,0.15);
  color: #8560A8;
  box-shadow: 0 0 0 1px rgba(133,96,168,0.2);
}
.aeo-scanner-feature-icon--blue {
  background: rgba(86,116,185,0.15);
  color: #5674B9;
  box-shadow: 0 0 0 1px rgba(86,116,185,0.2);
}
.aeo-scanner-feature-icon--cyan {
  background: rgba(0,191,243,0.12);
  color: #00BFF3;
  box-shadow: 0 0 0 1px rgba(0,191,243,0.2);
}

/* ── State Containers ── */
.aeo-scanner-input,
.aeo-scanner-loading,
.aeo-scanner-results { position: relative; z-index: 1; }
.aeo-scanner-heading {
  font-family: 'Poppins', sans-serif;
  font-size: 32px;
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

/* ── Form ── */
.aeo-scanner-form {
  display: flex;
  gap: 12px;
  max-width: 600px;
  margin: 0 auto 16px;
}
.aeo-scanner-url {
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
.aeo-scanner-url::placeholder { color: #6b7385; }
.aeo-scanner-url:focus {
  border-color: #8560A8;
  box-shadow: 0 0 0 3px rgba(133,96,168,0.15), 0 0 20px rgba(133,96,168,0.08);
  background: rgba(255,255,255,0.07);
}

/* ── Shimmer Button ── */
.aeo-scanner-btn {
  padding: 14px 28px;
  background: linear-gradient(135deg, #8560A8, #5674B9, #00BFF3);
  background-size: 200% 100%;
  animation: shimmer 3s ease infinite;
  color: #fff;
  border: none;
  border-radius: 10px;
  font-size: 16px;
  font-weight: 600;
  font-family: 'Poppins', sans-serif;
  cursor: pointer;
  white-space: nowrap;
  transition: transform 0.2s, box-shadow 0.3s;
  position: relative;
  overflow: hidden;
}
.aeo-scanner-btn::after {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, transparent 30%, rgba(255,255,255,0.15) 50%, transparent 70%);
  background-size: 200% 100%;
  animation: btnSheen 3s ease infinite;
  pointer-events: none;
}
@keyframes shimmer {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}
@keyframes btnSheen {
  0% { background-position: 200% 0; }
  100% { background-position: -200% 0; }
}
.aeo-scanner-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(133,96,168,0.3), 0 0 40px rgba(0,191,243,0.12);
}
.aeo-scanner-btn:active { transform: translateY(0); }

.aeo-scanner-note {
  text-align: center;
  font-size: 13px;
  color: #6b7385;
  margin: 0;
}

/* ── Loading: Radar Sweep ── */
.aeo-scanner-loading { text-align: center; }
.aeo-scanner-radar {
  width: 140px;
  height: 140px;
  border-radius: 50%;
  position: relative;
  margin: 32px auto 28px;
  animation: radarGlow 2s ease-in-out infinite;
}
@keyframes radarGlow {
  0%, 100% { box-shadow: 0 0 20px rgba(0,191,243,0.08); }
  50% { box-shadow: 0 0 40px rgba(0,191,243,0.18), 0 0 60px rgba(133,96,168,0.1); }
}
.aeo-scanner-radar-ring {
  position: absolute;
  border-radius: 50%;
  border: 1px solid rgba(133,96,168,0.15);
}
.aeo-scanner-radar-ring--1 {
  inset: 0;
}
.aeo-scanner-radar-ring--2 {
  inset: 20%;
  border-color: rgba(86,116,185,0.12);
}
.aeo-scanner-radar-ring--3 {
  inset: 40%;
  border-color: rgba(0,191,243,0.1);
}
.aeo-scanner-radar-sweep {
  position: absolute;
  inset: 0;
  border-radius: 50%;
  background: conic-gradient(from 0deg, transparent 0%, rgba(0,191,243,0.25) 15%, rgba(133,96,168,0.12) 25%, transparent 40%);
  animation: radarSweep 2s linear infinite;
}
@keyframes radarSweep { to { transform: rotate(360deg); } }
.aeo-scanner-radar-center {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: #00BFF3;
  box-shadow: 0 0 12px rgba(0,191,243,0.5), 0 0 24px rgba(0,191,243,0.2);
}

.aeo-scanner-status {
  font-size: 16px;
  color: #a0a8b8;
  font-family: 'Assistant', sans-serif;
  min-height: 24px;
}
.aeo-scanner-status .aeo-typewriter-cursor {
  display: inline-block;
  width: 2px;
  height: 1em;
  background: #00BFF3;
  margin-left: 2px;
  vertical-align: text-bottom;
  animation: cursorBlink 0.7s step-end infinite;
}
@keyframes cursorBlink {
  0%, 100% { opacity: 1; }
  50% { opacity: 0; }
}

/* ── Results ── */
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
  transition: filter 0.4s;
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
  transition: color 0.3s;
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

/* ── Dimensions Grid ── */
.aeo-scanner-dimensions {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 16px;
  margin-bottom: 40px;
}
.aeo-dim-card {
  background: rgba(255,255,255,0.04);
  border-radius: 12px;
  padding: 20px;
  border-left: 4px solid #555;
  transition: transform 0.2s, background 0.2s, box-shadow 0.2s;
  opacity: 0;
  transform: translateY(12px);
  animation: dimCardIn 0.4s ease-out forwards;
}
.aeo-dim-card:hover {
  transform: translateY(-3px);
  background: rgba(255,255,255,0.06);
  box-shadow: 0 8px 24px rgba(0,0,0,0.15);
}
@keyframes dimCardIn {
  to { opacity: 1; transform: translateY(0); }
}
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
  display: flex;
  align-items: center;
  gap: 8px;
}
.aeo-dim-status-icon {
  display: inline-flex;
  width: 18px;
  height: 18px;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  flex-shrink: 0;
}
.aeo-dim-status-icon svg {
  width: 12px;
  height: 12px;
}
.aeo-dim-score-badge {
  font-size: 13px;
  font-weight: 700;
  padding: 2px 10px;
  border-radius: 20px;
  font-family: 'Poppins', sans-serif;
  transition: transform 0.15s;
}
.aeo-dim-card:hover .aeo-dim-score-badge {
  transform: scale(1.05);
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
  transition: width 1s ease-out;
}
.aeo-dim-rec {
  font-size: 13px;
  color: #a0a8b8;
  margin: 0;
  line-height: 1.45;
  font-family: 'Assistant', sans-serif;
}
.aeo-dim-article {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-top: 10px;
  padding: 8px 12px;
  background: rgba(133,96,168,0.08);
  border-radius: 8px;
  text-decoration: none;
  font-family: 'Poppins', sans-serif;
  font-size: 12px;
  font-weight: 500;
  color: #00BFF3;
  transition: background 0.2s, transform 0.15s;
}
.aeo-dim-article:hover {
  background: rgba(133,96,168,0.15);
  transform: translateX(4px);
  color: #00BFF3;
}
.aeo-dim-article-icon { font-size: 14px; }

/* ── CTA ── */
.aeo-scanner-cta {
  text-align: center;
}
.aeo-scanner-cta-btn {
  display: inline-block;
  padding: 16px 36px;
  background: linear-gradient(135deg, #8560A8, #5674B9);
  background-size: 200% 100%;
  color: #fff;
  text-decoration: none;
  border-radius: 10px;
  font-size: 16px;
  font-weight: 600;
  font-family: 'Poppins', sans-serif;
  transition: transform 0.2s, box-shadow 0.3s, background-position 0.4s;
  margin-bottom: 16px;
}
.aeo-scanner-cta-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(133,96,168,0.25);
  color: #fff;
}
.aeo-scanner-again {
  display: block;
  margin: 0 auto;
  padding: 10px 24px;
  background: transparent;
  color: #a0a8b8;
  border: 1px solid rgba(255,255,255,0.15);
  border-radius: 8px;
  font-size: 14px;
  font-family: 'Poppins', sans-serif;
  cursor: pointer;
  transition: color 0.2s, border-color 0.2s, transform 0.15s, background 0.2s;
}
.aeo-scanner-again:hover {
  color: #fff;
  border-color: rgba(255,255,255,0.35);
  transform: translateY(-1px);
  background: rgba(255,255,255,0.03);
}

/* ── Confetti ── */
.aeo-scanner-confetti {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  pointer-events: none;
  overflow: hidden;
  z-index: 10;
}
.aeo-confetti-piece {
  position: absolute;
  width: 6px;
  height: 6px;
  border-radius: 1px;
  opacity: 0;
  animation: confettiFall 1.5s ease-out forwards;
}
@keyframes confettiFall {
  0% { transform: translateY(0) rotate(0deg) scale(1); opacity: 1; }
  100% { transform: translateY(200px) rotate(720deg) scale(0); opacity: 0; }
}

/* ── Responsive ── */
@media (max-width: 700px) {
  .aeo-scanner { padding: 48px 0; }
  .aeo-scanner-container { padding: 0 20px; }
  .aeo-scanner-card { border-radius: 18px; }
  .aeo-scanner-card-inner { padding: 32px 24px; border-radius: 15px; }
  .aeo-scanner-heading { font-size: 26px; }
  .aeo-scanner-form { flex-direction: column; }
  .aeo-scanner-btn { width: 100%; }
  .aeo-scanner-results-header { flex-direction: column; text-align: center; }
  .aeo-scanner-score-interp { margin-left: auto; margin-right: auto; }
  .aeo-scanner-dimensions { grid-template-columns: 1fr; }
}

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

  /* ── Typewriter Effect ── */
  function typewriterText(el, text, speed, callback) {
    el.textContent = '';
    var cursor = document.createElement('span');
    cursor.className = 'aeo-typewriter-cursor';
    el.appendChild(cursor);
    var i = 0;
    var interval = setInterval(function() {
      if (i < text.length) {
        el.insertBefore(document.createTextNode(text.charAt(i)), cursor);
        i++;
      } else {
        clearInterval(interval);
        if (callback) callback();
      }
    }, speed || 30);
    return interval;
  }

  /* ── Confetti Burst ── */
  function confettiBurst() {
    var container = document.getElementById('aeoConfetti');
    if (!container) return;
    var colors = ['#8560A8', '#5674B9', '#00BFF3', '#28c840', '#F5A623', '#fff'];
    for (var i = 0; i < 30; i++) {
      var piece = document.createElement('div');
      piece.className = 'aeo-confetti-piece';
      piece.style.left = (30 + Math.random() * 40) + '%';
      piece.style.top = (20 + Math.random() * 20) + '%';
      piece.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
      piece.style.animationDelay = (Math.random() * 0.4) + 's';
      piece.style.animationDuration = (1 + Math.random() * 1) + 's';
      var angle = -60 + Math.random() * 120;
      var dist = 60 + Math.random() * 140;
      piece.style.setProperty('--x', Math.sin(angle * Math.PI / 180) * dist + 'px');
      piece.style.width = (4 + Math.random() * 5) + 'px';
      piece.style.height = (4 + Math.random() * 5) + 'px';
      piece.style.borderRadius = Math.random() > 0.5 ? '50%' : '1px';
      container.appendChild(piece);
    }
    setTimeout(function() { container.innerHTML = ''; }, 2000);
  }

  /* ── Score Scramble Effect ── */
  function scrambleThenCount(el, finalScore, color, callback) {
    var scrambleDuration = 500;
    var scrambleStart = Date.now();
    var scrambleInterval = setInterval(function() {
      el.textContent = Math.floor(Math.random() * 100);
      if (Date.now() - scrambleStart > scrambleDuration) {
        clearInterval(scrambleInterval);
        // Now count up
        var current = 0;
        var step = Math.max(1, Math.floor(finalScore / 40));
        var counter = setInterval(function() {
          current += step;
          if (current >= finalScore) { current = finalScore; clearInterval(counter); if (callback) callback(); }
          el.textContent = current;
        }, 30);
      }
    }, 40);
  }

  /* ── Dimension Status Icon SVG ── */
  function dimStatusIcon(score) {
    if (score >= 60) {
      return '<svg viewBox="0 0 12 12" fill="none"><path d="M2.5 6.5L5 9L9.5 3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
    }
    return '<svg viewBox="0 0 12 12" fill="none"><path d="M6 3.5v3M6 8.5h.01" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>';
  }

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
      score += Math.min(words / 300, 15);
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
      if (/author|byline|written\s*by|posted\s*by/i.test(html)) score += 25;
      if (doc.querySelector('[rel="author"], .author, .byline, [class*="author"]')) score += 10;
      if (doc.querySelector('time, [datetime], .date, .published, [class*="date"]')) score += 20;
      if (/\b(updated|modified|published|reviewed)\b/i.test(html)) score += 5;
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

  /* ── Fallback Analysis (smart URL-based heuristics) ── */
  function fallbackAnalysis(url) {
    var path = url.toLowerCase();
    var dims = [];
    var hasBlog = /\/blog|\/article|\/post|\/news|\/guide|\/how-to/i.test(path);
    var hasLongSlug = path.split('/').filter(function(s){return s.length > 0;}).length >= 3;
    var isHome = /^https?:\/\/[^\/]+\/?$/.test(path);
    var domain = '';
    try { domain = new URL(url).hostname; } catch(e) {}
    var isBigSite = /\.com$|\.org$|\.io$/.test(domain);
    var hasKeywords = path.length > 40;

    var headingBase = isHome ? 45 : (hasBlog ? 65 : 50);
    var depthBase = hasLongSlug ? 60 : (hasBlog ? 55 : 35);
    var schemaBase = isBigSite ? 45 : 30;
    var eatBase = hasBlog ? 50 : 35;
    var linkBase = isBigSite ? 55 : 40;
    var questionBase = hasKeywords && hasBlog ? 50 : 30;
    var metaBase = isBigSite ? 60 : 45;
    var answerBase = hasBlog ? 55 : 40;

    function vary(base) { return Math.max(10, Math.min(95, base + Math.floor(Math.random() * 16) - 8)); }

    dims.push({ name: 'Heading Structure', score: vary(headingBase),
      rec: hasBlog ? 'Blog-style pages typically use H2s for sections. Verify your H1\u2192H2\u2192H3 hierarchy is clean and descriptive \u2014 AI systems parse content hierarchically.' : 'Ensure you have exactly one H1, multiple descriptive H2 section headings, and H3 subheadings where appropriate.' });
    dims.push({ name: 'Answer-First Format', score: vary(answerBase),
      rec: 'Each section should open with a clear, definitive answer statement. Lead with the conclusion, then explain \u2014 this mirrors how AI systems extract information.' });
    dims.push({ name: 'Content Depth', score: vary(depthBase),
      rec: hasLongSlug ? 'Long-form content (2,000+ words) with 6+ sections signals comprehensive coverage. Ensure each section adds genuine depth, not filler.' : 'Aim for 2,000+ words with 6+ well-structured sections. AI systems favor comprehensive resources over thin content.' });
    dims.push({ name: 'Schema Markup', score: vary(schemaBase),
      rec: isBigSite ? 'Larger sites often have basic schema. Add FAQ schema and Article/BlogPosting schema with author details to maximize AEO signals.' : 'Add JSON-LD schema markup: Article schema for blog posts, FAQ schema for Q&A sections, Organization schema for your brand.' });
    dims.push({ name: 'E-E-A-T Signals', score: vary(eatBase),
      rec: 'Include a visible author byline with credentials, publication dates, external citations to authoritative sources, and clear expertise indicators.' });
    dims.push({ name: 'Internal Linking', score: vary(linkBase),
      rec: 'Aim for 10+ contextual internal links per article. Build content clusters \u2014 link to related articles and pillar pages to signal topical authority.' });
    dims.push({ name: 'Question Targeting', score: vary(questionBase),
      rec: 'Use question-format H2 headings (e.g., "What is AEO?") and include an FAQ section. These formats align with how users query AI systems.' });
    dims.push({ name: 'Meta Optimization', score: vary(metaBase),
      rec: 'Ensure a 120-160 character meta description with your target keyword, an optimized title tag under 60 characters, and a canonical URL.' });

    return dims;
  }

  /* ── Show Results ── */
  function showResults(dims, url, query, predictions, passage) {
    var total = 0;
    for (var i = 0; i < dims.length; i++) total += dims[i].score;
    var overall = Math.round(total / dims.length);
    var color = scoreColor(overall);
    var grade = scoreGrade(overall);
    lastDims = dims;
    lastQuery = query;
    lastPredictions = predictions;
    lastPassage = passage;
    lastOverallScore = overall;
    lastGrade = grade;

    // Hide loading, show results
    document.getElementById('scannerLoading').style.display = 'none';
    document.getElementById('scannerResults').style.display = 'block';

    // Score circle glow
    var scoreCircleEl = document.querySelector('.aeo-scanner-score-circle');
    scoreCircleEl.style.filter = 'drop-shadow(0 0 16px ' + color + '40)';

    // Score circle animation
    var circumference = 414.69;
    var offset = circumference - (overall / 100) * circumference;
    var circle = document.getElementById('scoreCircle');
    circle.style.stroke = color;
    setTimeout(function() { circle.style.strokeDashoffset = offset; }, 50);

    // Scramble then count up number
    var numEl = document.getElementById('scoreNumber');
    var gradeEl = document.getElementById('scoreGrade');
    gradeEl.style.color = color;
    scrambleThenCount(numEl, overall, color, function() {
      // Confetti burst if score > 70
      if (overall > 70) confettiBurst();
    });
    setTimeout(function() { gradeEl.textContent = grade; }, 1100);

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

    // Dimension cards with staggered animation
    var grid = document.getElementById('dimensionsGrid');
    grid.innerHTML = '';
    for (var i = 0; i < dims.length; i++) {
      var d = dims[i];
      var c = scoreColor(d.score);
      var card = document.createElement('div');
      card.className = 'aeo-dim-card';
      card.style.borderLeftColor = c;
      card.style.borderImage = 'linear-gradient(to bottom, ' + c + ', ' + c + '66) 1';
      card.style.borderLeftWidth = '4px';
      card.style.borderLeftStyle = 'solid';
      card.style.borderImage = 'none';
      card.style.borderLeftColor = c;
      card.style.animationDelay = (i * 0.08) + 's';

      var statusBg = d.score >= 60 ? c + '22' : c + '22';
      var statusIconHtml = '<span class="aeo-dim-status-icon" style="background:' + statusBg + ';color:' + c + ';">' + dimStatusIcon(d.score) + '</span>';

      // Map dimensions to recommended articles
      var articleMap = {
        'Heading Structure': { title: 'How to Structure Content for AI Answer Engines', slug: 'structure-content-for-ai' },
        'Answer-First Format': { title: 'How to Structure Content for AI Answer Engines', slug: 'structure-content-for-ai' },
        'Content Depth': { title: 'Building Topical Authority: The Content Cluster Strategy', slug: 'building-topical-authority-content-cluster-strategy-aeo' },
        'Schema Markup': { title: 'Schema Markup for AEO: The Technical Guide', slug: 'schema-markup-for-aeo-technical-guide' },
        'E-E-A-T Signals': { title: 'E-E-A-T Signals That AI Engines Actually Evaluate', slug: 'eeat-signals-ai-answer-engines-evaluate' },
        'Internal Linking': { title: 'Building Topical Authority: The Content Cluster Strategy', slug: 'building-topical-authority-content-cluster-strategy-aeo' },
        'Question Targeting': { title: 'Featured Snippets as the Bridge to AEO', slug: 'featured-snippets-bridge-to-aeo' },
        'Meta Optimization': { title: 'What Is Answer Engine Optimization? Beginner\'s Guide', slug: 'what-is-answer-engine-optimization-beginners-guide' }
      };

      var recArticle = articleMap[d.name];
      var articleHtml = '';
      if (d.score < 70 && recArticle) {
        articleHtml = '<a href="/blog/aeo/' + recArticle.slug + '/" class="aeo-dim-article">' +
          '<span class="aeo-dim-article-icon">📖</span>' +
          '<span>Read: ' + recArticle.title + '</span>' +
        '</a>';
      }

      card.innerHTML =
        '<div class="aeo-dim-card-header">' +
          '<span class="aeo-dim-name">' + statusIconHtml + d.name + '</span>' +
          '<span class="aeo-dim-score-badge" style="background:' + c + '22;color:' + c + ';">' + d.score + '/100</span>' +
        '</div>' +
        '<div class="aeo-dim-bar-track"><div class="aeo-dim-bar-fill" style="background:linear-gradient(90deg,' + c + ',' + c + 'aa);"></div></div>' +
        '<p class="aeo-dim-rec">' + d.rec + '</p>' +
        articleHtml;
      grid.appendChild(card);
      // Animate bar with staggered delay
      (function(fill, score, delay) {
        setTimeout(function() { fill.style.width = score + '%'; }, 200 + delay);
      })(card.querySelector('.aeo-dim-bar-fill'), d.score, i * 80);
    }

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
  }

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
    var scoreColor2 = overallScore >= 80 ? [40, 200, 64] : overallScore >= 60 ? [0, 191, 243] : overallScore >= 40 ? [245, 166, 35] : [231, 76, 60];
    doc.setFillColor(45, 52, 68);
    doc.circle(pageW / 2, 160, 30, 'F');
    doc.setDrawColor(scoreColor2[0], scoreColor2[1], scoreColor2[2]);
    doc.setLineWidth(2.5);
    doc.circle(pageW / 2, 160, 30, 'S');
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(32);
    doc.setTextColor(scoreColor2[0], scoreColor2[1], scoreColor2[2]);
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

  /* ── Shared state ── */
  var fetchedHtml = null;
  var fetchedUrl = null;
  var parsedDoc = null;
  var lastDims = null;
  var lastQuery = null;
  var lastPredictions = null;
  var lastPassage = null;
  var lastOverallScore = 0;
  var lastGrade = '';

  /* ── Event Listeners ── */
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

  // Enter key on URL input
  document.getElementById('scanUrl').addEventListener('keydown', function(e) {
    if (e.key === 'Enter') document.getElementById('scanBtn').click();
  });

  // Scan again
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

  // PDF download
  document.getElementById('downloadPdfBtn').addEventListener('click', function() {
    if (lastDims) {
      generatePDF(lastDims, fetchedUrl, lastQuery, lastPredictions, lastPassage, lastOverallScore, lastGrade);
    }
  });
})();
</script>
