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
          <div class="aeo-scanner-app-icon">
            <svg viewBox="0 0 32 32" fill="none"><circle cx="16" cy="16" r="12" stroke="#00BFF3" stroke-width="1.5"/><path d="M12 16l3 3 5-6" stroke="#00BFF3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
          <div class="aeo-scanner-app-badge">Free Tool</div>
        </div>

        <!-- Input State -->
        <div id="scannerInput" class="aeo-scanner-input">
          <h2 class="aeo-scanner-heading">AEO Readiness Scanner</h2>
          <p class="aeo-scanner-subtitle">Find out if your content is optimized for AI-powered search engines like ChatGPT, Gemini, and Perplexity.</p>

          <div class="aeo-scanner-features">
            <div class="aeo-scanner-feature">
              <div class="aeo-scanner-feature-icon aeo-scanner-feature-icon--purple">
                <svg viewBox="0 0 20 20" fill="none" width="16" height="16"><rect x="2" y="4" width="16" height="12" rx="1" stroke="currentColor" stroke-width="1.5"/><path d="M6 8h8M6 11h5" stroke="currentColor" stroke-width="1.2"/></svg>
              </div>
              <span>Analyzes heading structure, content depth &amp; formatting</span>
            </div>
            <div class="aeo-scanner-feature">
              <div class="aeo-scanner-feature-icon aeo-scanner-feature-icon--blue">
                <svg viewBox="0 0 20 20" fill="none" width="16" height="16"><path d="M10 2v6l4 2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><circle cx="10" cy="10" r="8" stroke="currentColor" stroke-width="1.5"/></svg>
              </div>
              <span>Checks schema markup, E-E-A-T signals &amp; meta tags</span>
            </div>
            <div class="aeo-scanner-feature">
              <div class="aeo-scanner-feature-icon aeo-scanner-feature-icon--cyan">
                <svg viewBox="0 0 20 20" fill="none" width="16" height="16"><path d="M4 14l4-4 3 3 5-7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
              </div>
              <span>Scores your page across 8 AEO dimensions with actionable fixes</span>
            </div>
          </div>

          <div class="aeo-scanner-form">
            <input type="url" id="scanUrl" class="aeo-scanner-url" placeholder="https://yourdomain.com/your-page" aria-label="Page URL to scan" />
            <button id="scanBtn" class="aeo-scanner-btn">Scan Page &rarr;</button>
          </div>
          <p class="aeo-scanner-note">Instant results &mdash; no signup required</p>
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

        <div class="aeo-scanner-dimensions" id="dimensionsGrid"></div>

        <div class="aeo-scanner-cta">
          <a href="/contact-stretch-creative/" class="aeo-scanner-cta-btn">Want to improve your score? Talk to our AEO experts &rarr;</a>
          <button id="scanAgainBtn" class="aeo-scanner-again">Scan Another Page</button>
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
  max-width: 900px;
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
  justify-content: space-between;
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

/* ── Feature Bullets with Colored Icon Backgrounds ── */
.aeo-scanner-features {
  display: flex;
  flex-direction: column;
  gap: 14px;
  margin: 24px 0 32px;
  position: relative;
  z-index: 1;
}
.aeo-scanner-feature {
  display: flex;
  align-items: center;
  gap: 14px;
  font-family: 'Assistant', sans-serif;
  font-size: 15px;
  color: rgba(255,255,255,0.7);
  transition: color 0.2s, transform 0.15s;
}
.aeo-scanner-feature:hover {
  color: rgba(255,255,255,0.9);
  transform: translateX(4px);
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
  function showResults(dims, url) {
    var total = 0;
    for (var i = 0; i < dims.length; i++) total += dims[i].score;
    var overall = Math.round(total / dims.length);
    var color = scoreColor(overall);
    var grade = scoreGrade(overall);

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

      card.innerHTML =
        '<div class="aeo-dim-card-header">' +
          '<span class="aeo-dim-name">' + statusIconHtml + d.name + '</span>' +
          '<span class="aeo-dim-score-badge" style="background:' + c + '22;color:' + c + ';">' + d.score + '/100</span>' +
        '</div>' +
        '<div class="aeo-dim-bar-track"><div class="aeo-dim-bar-fill" style="background:linear-gradient(90deg,' + c + ',' + c + 'aa);"></div></div>' +
        '<p class="aeo-dim-rec">' + d.rec + '</p>';
      grid.appendChild(card);
      // Animate bar with staggered delay
      (function(fill, score, delay) {
        setTimeout(function() { fill.style.width = score + '%'; }, 200 + delay);
      })(card.querySelector('.aeo-dim-bar-fill'), d.score, i * 80);
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

    // Typewriter loading messages
    var messages = ['Fetching page...', 'Analyzing heading structure...', 'Checking schema markup...', 'Evaluating E-E-A-T signals...', 'Scoring content depth...', 'Calculating AEO score...'];
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

    // Try multiple CORS proxies
    var proxies = [
      'https://api.allorigins.win/raw?url=',
      'https://corsproxy.io/?' ,
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
      } catch(e) { /* try next proxy */ }
    }

    if (currentTypewriter) clearInterval(currentTypewriter);
    if (html) {
      var results = analyzeAEO(html, url);
      showResults(results, url);
    } else {
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
    // Reset glow
    var scoreCircleEl = document.querySelector('.aeo-scanner-score-circle');
    if (scoreCircleEl) scoreCircleEl.style.filter = '';
    // Clear confetti
    var confettiEl = document.getElementById('aeoConfetti');
    if (confettiEl) confettiEl.innerHTML = '';
  });
})();
</script>
