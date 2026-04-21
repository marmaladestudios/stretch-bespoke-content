<?php
/**
 * Template Name: Bespoke Content Experience
 *
 * Ported from bespoke-content-experience.html static prototype.
 * Scoped under .bce-page wrapper to avoid clashing with theme globals.
 */
get_header();
?>

<style>
/* =====================================================
   BESPOKE CONTENT EXPERIENCE — PAGE TEMPLATE
   ===================================================== */
html, body { overflow-x: hidden; }
.admin-bar .site-nav { top: 32px; }
@media (max-width: 782px) { .admin-bar .site-nav { top: 46px; } }
/* Scoped reset for BCE template */
.bce-page, .bce-page *, .bce-page *::before, .bce-page *::after { box-sizing: border-box; }
.bce-page { font-family: 'Assistant', sans-serif; font-weight: 300; font-size: 18px; line-height: 1.6; color: #323A51; background: #fff; }
.bce-page img { max-width: 100%; display: block; }
.bce-page a { text-decoration: none; color: inherit; }

    /* ===== RESET & BASE ===== */
/* ===== LAYOUT ===== */
    .bce-container { max-width: 1100px; margin: 0 auto; padding: 0 28px; }
    section { width: 100%; position: relative; }

    /* ===== TYPOGRAPHY ===== */
    .overline { font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 500; letter-spacing: 0.5px; margin-bottom: 16px; display: block; }
    .bce-page h1, .bce-page h2, .bce-page h3 { font-family: 'Poppins', sans-serif; }
    .bce-page h2 { font-size: 44px; font-weight: 600; color: #323A51; line-height: 1.1; margin-bottom: 32px; letter-spacing: -0.8px; }
    .bce-page h3 { font-size: 22px; font-weight: 600; color: #8560A8; line-height: 1.4; margin-bottom: 10px; }
    .bce-page p { margin-bottom: 24px; }
    .bce-page p:last-child { margin-bottom: 0; }

    /* ===== BUTTONS ===== */
    .btn-primary { display: inline-block; background: linear-gradient(135deg, #8560A8, #5674B9); color: #fff; font-family: 'Poppins', sans-serif; font-size: 15px; font-weight: 500; padding: 15px 34px; border: none; border-radius: 10px; cursor: pointer; transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1); position: relative; overflow: hidden; letter-spacing: 0.2px; }
    .btn-primary::after { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, rgba(255,255,255,0.15), transparent); transform: translateX(-100%); transition: transform 0.5s ease; }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 12px 36px rgba(133, 96, 168, 0.35); background: linear-gradient(135deg, #74509a, #4861a5); }
    .btn-primary:hover::after { transform: translateX(100%); }

    .btn-white {
      display: inline-block; background: #fff; color: #8560A8; font-family: 'Assistant', sans-serif;
      font-size: 17px; font-weight: 400; padding: 16px 36px; border: none; border-radius: 0;
      cursor: pointer; transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .btn-white:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(255,255,255,0.3); }

    /* ===== SCROLL REVEAL ===== */
    .reveal { opacity: 0; transform: translateY(32px); transition: opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1), transform 0.8s cubic-bezier(0.4, 0, 0.2, 1); }
    .reveal.visible { opacity: 1; transform: translateY(0); }
    .reveal-delay-1 { transition-delay: 0.1s; }
    .reveal-delay-2 { transition-delay: 0.2s; }
    .reveal-delay-3 { transition-delay: 0.3s; }
    .reveal-delay-4 { transition-delay: 0.4s; }
    .reveal-delay-5 { transition-delay: 0.5s; }
    .reveal-delay-6 { transition-delay: 0.6s; }

    /* ===== NAV ===== */
.site-nav.scrolled { background: rgba(37, 44, 58, 0.95); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); padding: 14px 0; box-shadow: 0 4px 30px rgba(0,0,0,0.15); }
.site-nav .logo { display: block; line-height: 0; }
.nav-toggle span { display: block; width: 24px; height: 2px; background: #fff; margin: 5px 0; transition: 0.3s; }
.nav-links a { font-family: 'Montserrat', sans-serif; font-size: 15px; font-weight: 400; color: #fff; transition: opacity 0.2s; }
/* ===== MODULE 1 — HERO ===== */
    .hero { position: relative; background: #252C3A; overflow: hidden; padding: 200px 0 140px; min-height: 85vh; display: flex; align-items: center; }
    .hero::before { content: ''; position: absolute; inset: 0; background: linear-gradient(160deg, rgba(86, 116, 185, 0.4), rgb(0, 191, 243) 80%); z-index: 1; }
    .hero .bce-container { position: relative; z-index: 2; }
    .hero-layout { display: grid; grid-template-columns: 1.3fr 1fr; gap: 48px; align-items: center; }
    .hero-text { }
    .hero .overline { color: rgba(255,255,255,0.7); letter-spacing: 2px; text-transform: uppercase; font-size: 13px; }
    .hero h1 { font-size: 80px; font-weight: 400; color: #fff; line-height: 1.05; margin-bottom: 28px; }
    .hero h1 .accent { background: linear-gradient(90deg, #fff 40%, #00BFF3 90%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
    .hero .subtitle { font-family: 'Poppins', sans-serif; font-size: 22px; font-weight: 400; color: rgba(255,255,255,0.92); line-height: 1.5; margin-bottom: 16px; }
    .hero .supporting { font-family: 'Assistant', sans-serif; font-size: 20px; font-weight: 300; color: rgba(255,255,255,0.7); margin-bottom: 44px; }

    /* Hero visual */
    .hero-visual { position: relative; display: flex; justify-content: center; align-items: center; min-height: 420px; }

    .hv-browser {
      position: relative; z-index: 3; background: #fff; width: 320px; min-height: 440px;
      box-shadow: 0 24px 64px rgba(0,0,0,0.3); overflow: hidden;
      animation: fadeUp 0.9s ease 0.6s both;
    }
    .hv-bar { display: flex; align-items: center; gap: 5px; padding: 8px 12px; background: #f0f0f2; border-bottom: 1px solid rgba(0,0,0,0.06); }
    .hv-dot { width: 8px; height: 8px; border-radius: 50%; }
    .hv-dot:nth-child(1) { background: #ff5f57; }
    .hv-dot:nth-child(2) { background: #ffbd2e; }
    .hv-dot:nth-child(3) { background: #28c840; }
    .hv-url { margin-left: 8px; background: #fff; border: 1px solid rgba(0,0,0,0.06); border-radius: 3px; padding: 3px 8px; font-size: 9px; color: #aaa; flex: 1; font-family: 'Assistant', sans-serif; }
    .hv-page { padding: 0; }
    .hv-page-hero { background: linear-gradient(160deg, rgba(86,116,185,0.55), rgba(0,191,243,0.65)); padding: 20px 18px 16px; }
    .hv-ph-line { height: 4px; background: rgba(255,255,255,0.5); margin-bottom: 6px; border-radius: 1px; }
    .hv-ph-line.title { height: 10px; background: #fff; width: 70%; margin-bottom: 5px; }
    .hv-ph-line.title2 { height: 10px; background: #fff; width: 50%; margin-bottom: 8px; }
    .hv-ph-line.sub { height: 5px; background: rgba(255,255,255,0.6); width: 60%; margin-bottom: 10px; }
    .hv-ph-btn { width: 60px; height: 16px; background: #8560A8; border-radius: 1px; }
    .hv-body { padding: 18px 18px 22px; }
    .hv-text { height: 4px; background: #e4e4e8; margin-bottom: 5px; border-radius: 1px; }
    .hv-text:nth-child(2) { width: 88%; }
    .hv-text:nth-child(3) { width: 72%; }
    .hv-media { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin: 12px 0; }
    .hv-img { height: 52px; background: linear-gradient(135deg, rgba(133,96,168,0.1), rgba(0,191,243,0.08)); border: 1px solid rgba(133,96,168,0.06); display: flex; align-items: center; justify-content: center; }
    .hv-img svg { width: 18px; height: 18px; opacity: 0.25; }
    .hv-interactive { margin: 10px 0; padding: 0; border: 1px solid rgba(133,96,168,0.12); background: #fff; overflow: hidden; }
    .hv-app-toolbar { display: flex; align-items: center; gap: 0; background: linear-gradient(90deg, #8560A8, #5674B9); padding: 5px 10px; }
    .hv-app-title { font-size: 6.5px; font-family: 'Poppins', sans-serif; font-weight: 600; color: #fff; text-transform: uppercase; letter-spacing: 0.6px; flex: 1; }
    .hv-app-tabs { display: flex; gap: 0; }
    .hv-app-tab { font-size: 5.5px; font-family: 'Poppins', sans-serif; font-weight: 500; color: rgba(255,255,255,0.6); padding: 2px 6px; text-transform: uppercase; letter-spacing: 0.3px; }
    .hv-app-tab.active { color: #fff; background: rgba(255,255,255,0.15); border-radius: 2px; }
    .hv-app-body { padding: 8px 10px; display: flex; gap: 8px; }
    .hv-app-panel { flex: 1; }
    .hv-app-chart { height: 36px; margin-bottom: 6px; }
    .hv-app-metrics { display: flex; gap: 4px; }
    .hv-app-metric { flex: 1; background: #f7f7fb; padding: 4px; text-align: center; border-radius: 2px; }
    .hv-app-metric-val { font-family: 'Poppins', sans-serif; font-size: 9px; font-weight: 700; color: #8560A8; line-height: 1; }
    .hv-app-metric-lbl { font-size: 5px; color: #999; text-transform: uppercase; letter-spacing: 0.2px; margin-top: 1px; }
    .hv-app-sidebar { width: 45%; display: flex; flex-direction: column; gap: 4px; }
    .hv-app-input { height: 10px; background: #f4f4f8; border: 1px solid #e8e8ec; border-radius: 2px; }
    .hv-app-btn { height: 12px; background: linear-gradient(90deg, #8560A8, #00BFF3); border-radius: 2px; }
    .hv-video { margin: 10px 0; height: 60px; background: linear-gradient(135deg, #252C3A, #323A51); display: flex; align-items: center; justify-content: center; }
    .hv-play { width: 24px; height: 24px; border-radius: 50%; background: rgba(255,255,255,0.12); border: 1.5px solid rgba(255,255,255,0.35); display: flex; align-items: center; justify-content: center; }
    .hv-play svg { width: 9px; height: 9px; }

    /* Floating mobile device — hidden */
    .hv-mobile { display: none; }
    .hv-mob-screen { background: #fff; border-radius: 12px; overflow: hidden; }
    .hv-mob-notch { height: 12px; display: flex; justify-content: center; align-items: center; }
    .hv-mob-notch-bar { width: 36px; height: 3px; background: #1a1a1b; border-radius: 2px; }
    .hv-mob-hero { height: 36px; background: linear-gradient(160deg, rgba(86,116,185,0.5), rgba(0,191,243,0.6)); }
    .hv-mob-body { padding: 7px 8px; }
    .hv-mob-line { height: 2.5px; background: #e4e4e8; margin-bottom: 4px; border-radius: 1px; }
    .hv-mob-line:nth-child(2) { width: 82%; }
    .hv-mob-line:nth-child(3) { width: 65%; }
    .hv-mob-chart { display: flex; gap: 2px; align-items: flex-end; height: 20px; margin: 6px 0; padding: 0 4px; }
    .hv-mob-b { flex: 1; border-radius: 1px 1px 0 0; }
    .hv-mob-b:nth-child(1) { height: 35%; background: #8560A8; opacity: 0.5; }
    .hv-mob-b:nth-child(2) { height: 60%; background: #5674B9; opacity: 0.5; }
    .hv-mob-b:nth-child(3) { height: 45%; background: #448CCB; opacity: 0.5; }
    .hv-mob-b:nth-child(4) { height: 80%; background: #00BFF3; opacity: 0.5; }
    .hv-mob-b:nth-child(5) { height: 55%; background: #8560A8; opacity: 0.5; }
    .hv-mob-cta { height: 12px; background: #8560A8; border-radius: 1px; margin: 4px 0 2px; }
    .hv-mob-bottom { height: 2.5px; width: 28px; background: #1a1a1b; border-radius: 2px; margin: 4px auto 2px; }

    /* Floating stats badge */
    .hv-stats {
      position: absolute; top: 10px; right: -24px; z-index: 5;
      background: #fff; padding: 14px 16px; width: 200px;
      box-shadow: 0 12px 36px rgba(0,0,0,0.2);
      animation: fadeUp 0.9s ease 1.1s both;
    }
    .hv-stats-header { display: flex; align-items: center; gap: 4px; margin-bottom: 10px; }
    .hv-stats-dot { width: 6px; height: 6px; border-radius: 50%; }
    .hv-stats-title { font-family: 'Poppins', sans-serif; font-size: 8px; font-weight: 500; color: #252C3A; text-transform: uppercase; letter-spacing: 0.4px; margin-left: 4px; }
    .hv-stat-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 6px; margin-bottom: 10px; }
    .hv-stat { text-align: center; padding: 6px 4px; background: #f9f9fb; }
    .hv-stat-num { font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 600; line-height: 1; }
    .hv-stat-label { font-size: 6.5px; text-transform: uppercase; letter-spacing: 0.3px; color: #444; margin-top: 2px; }
    .hv-hockey-chart { height: 32px; }

    @keyframes fadeUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    .hero .overline { animation: fadeUp 0.7s ease 0.2s both; }
    .hero h1 { animation: fadeUp 0.8s ease 0.35s both; }
    .hero .subtitle { animation: fadeUp 0.8s ease 0.5s both; }
    .hero .supporting { animation: fadeUp 0.7s ease 0.65s both; }
    .hero .btn-primary { animation: fadeUp 0.7s ease 0.8s both; }
    .hero-accent-bar { height: 4px; background: linear-gradient(90deg, #8560A8 0%, #5674B9 25%, #448CCB 50%, #00BFF3 75%, #8560A8 100%); background-size: 200% 100%; animation: gradientSlide 4s ease infinite; }
    @keyframes gradientSlide { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }

    /* ===== PULL QUOTE BANNER ===== */
    .pull-quote-banner {
      background: #252C3A;
      padding: 56px 0;
      position: relative;
      overflow: hidden;
    }
    .pull-quote-banner::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(133, 96, 168, 0.1), rgba(0, 191, 243, 0.08));
      pointer-events: none;
    }
    .pull-quote-banner .bce-container {
      position: relative;
      z-index: 1;
      text-align: center;
    }
    .pull-quote-banner blockquote {
      font-family: 'Poppins', sans-serif;
      font-size: 24px;
      font-weight: 400;
      color: #fff;
      line-height: 1.55;
      max-width: 820px;
      margin: 0 auto;
      position: relative;
      padding: 0 40px;
    }
    .pull-quote-banner blockquote::before {
      content: '';
      display: block;
      width: 48px;
      height: 3px;
      background: linear-gradient(90deg, #8560A8, #00BFF3);
      margin: 0 auto 28px;
    }
    .pull-quote-banner .quote-accent {
      color: #00BFF3;
    }

    /* ===== SECTION STYLES ===== */
    .section-white { background: #fff; padding: 100px 0; }
    .section-white .overline { color: #8560A8; }
    .section-white .body-content { max-width: 780px; }

    .pull-highlight { font-size: 22px; font-weight: 400; color: #252C3A; line-height: 1.55; padding: 32px 0 32px 28px; border-left: 3px solid #00BFF3; margin: 36px 0; font-family: 'Poppins', sans-serif; }

    .section-light { background: #f9f9fb; padding: 100px 0; }
    .section-light .overline { color: #8560A8; }
    .section-light .body-content { max-width: 780px; }

    /* ===== ILLUSTRATED MOCKUP — WHAT IS IT ===== */
    .mockup-showcase {
      margin: 60px 0 48px;
      display: grid;
      grid-template-columns: 1.3fr 0.7fr;
      gap: 24px;
      align-items: start;
    }

    /* Browser window */
    .browser-mockup {
      background: #fff;
      border: 1px solid rgba(0,0,0,0.08);
      box-shadow: 0 20px 60px rgba(37, 44, 58, 0.12), 0 4px 16px rgba(0,0,0,0.06);
      overflow: hidden;
      transform: perspective(1200px) rotateY(-2deg) rotateX(1deg);
      transition: transform 0.6s ease;
    }
    .browser-mockup:hover {
      transform: perspective(1200px) rotateY(0deg) rotateX(0deg);
    }
    .browser-bar {
      display: flex;
      align-items: center;
      gap: 6px;
      padding: 10px 14px;
      background: #f0f0f2;
      border-bottom: 1px solid rgba(0,0,0,0.06);
    }
    .browser-dot { width: 10px; height: 10px; border-radius: 50%; }
    .browser-dot:nth-child(1) { background: #ff5f57; }
    .browser-dot:nth-child(2) { background: #ffbd2e; }
    .browser-dot:nth-child(3) { background: #28c840; }
    .browser-url {
      margin-left: 12px;
      background: #fff;
      border: 1px solid rgba(0,0,0,0.06);
      border-radius: 4px;
      padding: 4px 12px;
      font-size: 11px;
      color: #999;
      flex: 1;
      font-family: 'Assistant', sans-serif;
    }

    .browser-content {
      padding: 0;
    }

    /* Inner page layout illustration */
    .mock-hero {
      background: linear-gradient(160deg, rgba(86, 116, 185, 0.6), rgba(0, 191, 243, 0.7));
      padding: 28px 24px 24px;
      position: relative;
    }
    .mock-hero-overline {
      width: 60px; height: 4px; background: rgba(255,255,255,0.5); margin-bottom: 10px; border-radius: 2px;
    }
    .mock-hero-title {
      width: 180px; height: 12px; background: #fff; margin-bottom: 8px; border-radius: 1px;
    }
    .mock-hero-title.short { width: 120px; }
    .mock-hero-sub {
      width: 140px; height: 6px; background: rgba(255,255,255,0.6); margin-bottom: 12px; border-radius: 1px;
    }
    .mock-hero-btn {
      width: 80px; height: 22px; background: #8560A8; border-radius: 1px;
    }

    .mock-body {
      padding: 20px 24px;
    }
    .mock-text-block {
      margin-bottom: 16px;
    }
    .mock-text-line {
      height: 5px; background: #e0e0e5; margin-bottom: 6px; border-radius: 1px;
    }
    .mock-text-line:nth-child(2) { width: 92%; }
    .mock-text-line:nth-child(3) { width: 78%; }
    .mock-text-line:nth-child(4) { width: 85%; }
    .mock-text-line.short { width: 55%; }

    .mock-media-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 10px;
      margin: 16px 0;
    }
    .mock-image-placeholder {
      height: 64px;
      background: linear-gradient(135deg, rgba(133, 96, 168, 0.12), rgba(0, 191, 243, 0.1));
      border: 1px solid rgba(133, 96, 168, 0.08);
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .mock-image-placeholder svg { width: 24px; height: 24px; opacity: 0.3; }

    .mock-video-placeholder {
      height: 80px;
      background: linear-gradient(135deg, #252C3A, #323A51);
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 16px 0;
      position: relative;
    }
    .mock-play-btn {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      background: rgba(255,255,255,0.15);
      display: flex;
      align-items: center;
      justify-content: center;
      border: 2px solid rgba(255,255,255,0.4);
    }
    .mock-play-btn svg { width: 12px; height: 12px; }

    /* Interactive tool mockup */
    .mock-interactive {
      margin: 16px 0;
      padding: 14px 16px;
      border: 1px solid rgba(133, 96, 168, 0.12);
      background: rgba(133, 96, 168, 0.02);
    }
    .mock-interactive-label {
      font-family: 'Poppins', sans-serif;
      font-size: 8px;
      font-weight: 600;
      color: #8560A8;
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-bottom: 10px;
    }
    .mock-slider-track {
      height: 4px; background: #e8e8ec; border-radius: 2px; position: relative; margin-bottom: 12px;
    }
    .mock-slider-fill {
      position: absolute; left: 0; top: 0; height: 100%; width: 65%; background: linear-gradient(90deg, #8560A8, #00BFF3); border-radius: 2px;
    }
    .mock-slider-thumb {
      position: absolute; right: -6px; top: -4px; width: 12px; height: 12px; background: #fff; border: 2px solid #8560A8; border-radius: 50%;
    }
    .mock-bar-chart {
      display: flex; gap: 4px; align-items: flex-end; height: 40px;
    }
    .mock-bar {
      flex: 1; border-radius: 1px 1px 0 0;
    }
    .mock-bar:nth-child(1) { height: 45%; background: rgba(133, 96, 168, 0.3); }
    .mock-bar:nth-child(2) { height: 70%; background: rgba(133, 96, 168, 0.45); }
    .mock-bar:nth-child(3) { height: 55%; background: rgba(86, 116, 185, 0.4); }
    .mock-bar:nth-child(4) { height: 90%; background: rgba(0, 191, 243, 0.5); }
    .mock-bar:nth-child(5) { height: 75%; background: rgba(86, 116, 185, 0.45); }
    .mock-bar:nth-child(6) { height: 60%; background: rgba(133, 96, 168, 0.35); }
    .mock-bar:nth-child(7) { height: 85%; background: rgba(0, 191, 243, 0.45); }
    .mock-bar:nth-child(8) { height: 50%; background: rgba(133, 96, 168, 0.3); }

    .mock-cta-row {
      margin: 16px 0 8px;
      padding: 12px 16px;
      background: linear-gradient(135deg, rgba(133, 96, 168, 0.06), rgba(0, 191, 243, 0.04));
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .mock-cta-text { flex: 1; }
    .mock-cta-text .mock-text-line { margin-bottom: 4px; }
    .mock-cta-btn {
      width: 56px; height: 18px; background: #8560A8; border-radius: 1px; flex-shrink: 0;
    }

    /* Right column: mobile + stats */
    .mockup-sidebar {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    /* Mobile mockup */
    .mobile-mockup {
      background: #1a1a1b;
      border-radius: 20px;
      padding: 8px;
      box-shadow: 0 16px 48px rgba(37, 44, 58, 0.18);
      max-width: 280px;
      min-width: 240px;
      margin: 0 auto;
      transform: perspective(800px) rotateY(4deg);
      transition: transform 0.6s ease;
    }
    .mobile-mockup:hover {
      transform: perspective(800px) rotateY(0deg);
    }
    .mobile-screen {
      background: #fff;
      border-radius: 14px;
      overflow: hidden;
    }
    .mobile-notch {
      height: 18px;
      background: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      padding-top: 4px;
    }
    .mobile-notch-bar {
      width: 50px; height: 4px; background: #1a1a1b; border-radius: 2px;
    }
    .mobile-hero-img {
      height: 60px;
      background: linear-gradient(160deg, rgba(86, 116, 185, 0.5), rgba(0, 191, 243, 0.6));
      display: flex;
      align-items: flex-end;
      padding: 0 12px 8px;
    }
    .mobile-hero-text { width: 70px; height: 8px; background: #fff; border-radius: 1px; }
    .mobile-content { padding: 10px 12px; }
    .mobile-text { height: 3px; background: #e4e4e8; margin-bottom: 5px; border-radius: 1px; }
    .mobile-text:nth-child(2) { width: 88%; }
    .mobile-text:nth-child(3) { width: 72%; }

    .mobile-chart-area {
      margin: 8px 0;
      padding: 8px;
      background: rgba(133, 96, 168, 0.04);
      border: 1px solid rgba(133, 96, 168, 0.06);
    }
    .mobile-donut {
      width: 40px; height: 40px; margin: 0 auto 6px;
      border-radius: 50%;
      background: conic-gradient(#8560A8 0% 35%, #5674B9 35% 60%, #00BFF3 60% 80%, #e4e4e8 80% 100%);
      position: relative;
    }
    .mobile-donut::after {
      content: ''; position: absolute; inset: 10px; background: #fff; border-radius: 50%;
    }
    .mobile-mini-bars {
      display: flex; gap: 3px; justify-content: center;
    }
    .mobile-mini-bar {
      width: 8px; border-radius: 1px 1px 0 0;
    }
    .mobile-mini-bar:nth-child(1) { height: 12px; background: #8560A8; }
    .mobile-mini-bar:nth-child(2) { height: 18px; background: #5674B9; }
    .mobile-mini-bar:nth-child(3) { height: 14px; background: #448CCB; }
    .mobile-mini-bar:nth-child(4) { height: 22px; background: #00BFF3; }
    .mobile-mini-bar:nth-child(5) { height: 16px; background: #8560A8; }

    .mobile-cta-bar {
      margin: 8px 0 4px;
      height: 16px;
      background: #8560A8;
      border-radius: 1px;
    }
    .mobile-bottom-bar {
      height: 3px;
      width: 36px;
      background: #1a1a1b;
      border-radius: 2px;
      margin: 6px auto 4px;
    }

    /* Stats card */
    .stats-card {
      background: #fff;
      border: 1px solid rgba(0,0,0,0.06);
      box-shadow: 0 8px 32px rgba(37, 44, 58, 0.08);
      padding: 20px;
      transform: perspective(800px) rotateY(3deg);
      transition: transform 0.6s ease;
    }
    .stats-card:hover {
      transform: perspective(800px) rotateY(0deg);
    }
    .stats-card-header {
      display: flex; align-items: center; gap: 8px; margin-bottom: 14px;
    }
    .stats-dot { width: 8px; height: 8px; border-radius: 50%; }
    .stats-dot.purple { background: #8560A8; }
    .stats-dot.blue { background: #5674B9; }
    .stats-dot.cyan { background: #00BFF3; }
    .stats-card-title {
      font-family: 'Poppins', sans-serif; font-size: 10px; font-weight: 500; color: #252C3A; text-transform: uppercase; letter-spacing: 0.5px;
    }

    .stats-metric-row {
      display: flex; gap: 12px; margin-bottom: 12px;
    }
    .stat-box {
      flex: 1;
      padding: 10px;
      background: #f9f9fb;
      text-align: center;
    }
    .stat-number {
      font-family: 'Poppins', sans-serif;
      font-size: 20px;
      font-weight: 600;
      line-height: 1;
      margin-bottom: 2px;
    }
    .stat-number.purple { color: #8560A8; }
    .stat-number.cyan { color: #00BFF3; }
    .stat-number.blue { color: #5674B9; }
    .stat-label {
      font-size: 9px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: #999;
      font-weight: 400;
    }

    .stats-sparkline {
      display: flex; align-items: flex-end; gap: 2px; height: 28px; margin-top: 8px;
    }
    .spark-bar {
      flex: 1; border-radius: 1px 1px 0 0; transition: height 0.3s ease;
    }
    .spark-bar:nth-child(1) { height: 30%; background: rgba(133, 96, 168, 0.25); }
    .spark-bar:nth-child(2) { height: 45%; background: rgba(133, 96, 168, 0.3); }
    .spark-bar:nth-child(3) { height: 40%; background: rgba(86, 116, 185, 0.3); }
    .spark-bar:nth-child(4) { height: 55%; background: rgba(86, 116, 185, 0.35); }
    .spark-bar:nth-child(5) { height: 50%; background: rgba(68, 140, 203, 0.35); }
    .spark-bar:nth-child(6) { height: 65%; background: rgba(68, 140, 203, 0.4); }
    .spark-bar:nth-child(7) { height: 60%; background: rgba(0, 191, 243, 0.4); }
    .spark-bar:nth-child(8) { height: 72%; background: rgba(0, 191, 243, 0.45); }
    .spark-bar:nth-child(9) { height: 68%; background: rgba(0, 191, 243, 0.5); }
    .spark-bar:nth-child(10) { height: 85%; background: rgba(0, 191, 243, 0.55); }
    .spark-bar:nth-child(11) { height: 78%; background: #00BFF3; opacity: 0.6; }
    .spark-bar:nth-child(12) { height: 95%; background: #00BFF3; opacity: 0.7; }

    /* ===== TRIO VISUAL ===== */
    .trio-visual { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2px; margin: 48px 0 40px; overflow: hidden; }
    .trio-item { padding: 36px 28px; text-align: center; position: relative; transition: transform 0.4s ease; }
    .trio-item:hover { transform: translateY(-4px); }
    .trio-item:nth-child(1) { background: linear-gradient(160deg, rgba(133, 96, 168, 0.08), rgba(133, 96, 168, 0.03)); }
    .trio-item:nth-child(2) { background: linear-gradient(160deg, rgba(86, 116, 185, 0.08), rgba(86, 116, 185, 0.03)); }
    .trio-item:nth-child(3) { background: linear-gradient(160deg, rgba(0, 191, 243, 0.08), rgba(0, 191, 243, 0.03)); }
    .trio-icon { width: 48px; height: 48px; margin: 0 auto 16px; }
    .trio-label { font-family: 'Poppins', sans-serif; font-size: 16px; font-weight: 500; color: #252C3A; }
    .trio-sub { font-size: 14px; color: #666; margin-top: 4px; }

    /* ===== FEATURES GRID ===== */
    .features-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-top: 48px; }
    .feature-card { padding: 36px 28px; border-left: 3px solid #8560A8; background: #fff; position: relative; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
    .section-light .feature-card { background: #fff; }
    .feature-card::before { content: ''; position: absolute; top: 0; left: -3px; bottom: 0; width: 3px; background: linear-gradient(180deg, #8560A8, #00BFF3); opacity: 0; transition: opacity 0.4s ease; }
    .feature-card:hover { transform: translateY(-6px); box-shadow: 0 16px 48px rgba(133, 96, 168, 0.12); }
    .feature-card:hover::before { opacity: 1; }

    /* Featured interactive card */
    .feature-card-featured {
      grid-column: 1 / -1;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 40px;
      padding: 48px 44px;
      background: linear-gradient(160deg, #252C3A, #323A51);
      border-left: 4px solid;
      border-image: linear-gradient(180deg, #8560A8, #00BFF3) 1;
      position: relative;
      overflow: hidden;
      transition: all 0.4s ease;
    }
    .feature-card-featured::after {
      content: '';
      position: absolute;
      top: -100px;
      right: -100px;
      width: 350px;
      height: 350px;
      background: radial-gradient(circle, rgba(0, 191, 243, 0.06), transparent 70%);
      pointer-events: none;
    }
    .feature-card-featured:hover {
      box-shadow: 0 20px 56px rgba(37, 44, 58, 0.3);
      transform: translateY(-4px);
    }
    .feature-card-featured h3 {
      color: #00BFF3;
      font-size: 24px;
      margin-bottom: 16px;
    }
    .feature-card-featured p {
      color: rgba(255,255,255,0.8);
      font-size: 17px;
      line-height: 1.65;
      margin-bottom: 0;
    }
    .feature-card-featured .feature-icon { margin-bottom: 24px; }
    .feature-card-featured .feature-icon svg { width: 48px; height: 48px; }
    .featured-tag {
      display: inline-block;
      font-family: 'Poppins', sans-serif;
      font-size: 10px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 2px;
      color: #00BFF3;
      border: 1px solid rgba(0, 191, 243, 0.3);
      padding: 4px 12px;
      margin-bottom: 20px;
    }

    /* Mini app illustration inside featured card */
    .mini-app {
      background: #fff;
      box-shadow: 0 12px 40px rgba(0,0,0,0.2);
      overflow: hidden;
      position: relative;
      z-index: 1;
    }
    .mini-app-bar {
      display: flex; align-items: center; gap: 5px; padding: 7px 10px;
      background: #f5f5f7; border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    .mini-app-dot { width: 7px; height: 7px; border-radius: 50%; }
    .mini-app-dot:nth-child(1) { background: #ff5f57; }
    .mini-app-dot:nth-child(2) { background: #ffbd2e; }
    .mini-app-dot:nth-child(3) { background: #28c840; }
    .mini-app-title {
      margin-left: 8px; font-family: 'Poppins', sans-serif; font-size: 9px;
      font-weight: 500; color: #8560A8; text-transform: uppercase; letter-spacing: 0.5px;
    }
    .mini-app-body { padding: 16px; }
    .mini-app-header {
      font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 600;
      color: #252C3A; margin-bottom: 12px;
    }
    .mini-app-controls { display: flex; gap: 8px; margin-bottom: 14px; }
    .mini-app-tab {
      padding: 5px 12px; font-size: 9px; font-family: 'Poppins', sans-serif;
      font-weight: 500; border: 1px solid #e0e0e5; color: #999; background: #fff;
    }
    .mini-app-tab.active { background: #8560A8; color: #fff; border-color: #8560A8; }
    .mini-app-sliders { margin-bottom: 14px; }
    .mini-app-slider-row {
      display: flex; align-items: center; gap: 10px; margin-bottom: 10px;
    }
    .mini-app-slider-label {
      font-size: 8px; font-family: 'Poppins', sans-serif; font-weight: 500;
      color: #666; text-transform: uppercase; letter-spacing: 0.5px; width: 50px; flex-shrink: 0;
    }
    .mini-app-track {
      flex: 1; height: 4px; background: #e8e8ec; border-radius: 2px; position: relative;
    }
    .mini-app-fill { position: absolute; left: 0; top: 0; height: 100%; border-radius: 2px; }
    .mini-app-thumb {
      position: absolute; top: -4px; width: 12px; height: 12px;
      background: #fff; border: 2px solid; border-radius: 50%;
    }
    .mini-app-slider-val {
      font-family: 'Poppins', sans-serif; font-size: 10px; font-weight: 600; width: 28px; text-align: right;
    }
    .mini-app-result {
      background: #f9f9fb; padding: 12px; display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 8px;
      margin-bottom: 12px;
    }
    .mini-app-metric { text-align: center; }
    .mini-app-metric-val {
      font-family: 'Poppins', sans-serif; font-size: 16px; font-weight: 600; line-height: 1;
    }
    .mini-app-metric-label {
      font-size: 7px; text-transform: uppercase; letter-spacing: 0.4px; color: #999; margin-top: 3px;
    }
    .mini-app-chart {
      display: flex; gap: 3px; align-items: flex-end; height: 44px;
    }
    .mini-app-bar-item { flex: 1; border-radius: 2px 2px 0 0; transition: height 0.3s ease; }
    .mini-app-cta {
      margin-top: 12px; padding: 8px; text-align: center; font-family: 'Poppins', sans-serif;
      font-size: 9px; font-weight: 500; color: #fff; background: #8560A8; letter-spacing: 0.5px;
    }
    .feature-icon { width: 44px; height: 44px; margin-bottom: 20px; display: flex; align-items: center; justify-content: center; }
    .feature-icon svg { width: 100%; height: 100%; }
    .feature-card h3 { font-size: 19px; margin-bottom: 12px; }
    .feature-card p { font-size: 16px; line-height: 1.6; margin-bottom: 0; color: #323A51; }

    /* ===== DARK SECTION — BENEFITS ===== */
    .section-dark { background: #282829; padding: 100px 0; position: relative; overflow: hidden; }
    .section-dark::before { content: ''; position: absolute; top: -200px; right: -200px; width: 600px; height: 600px; background: radial-gradient(circle, rgba(133, 96, 168, 0.08), transparent 70%); pointer-events: none; }
    .section-dark::after { content: ''; position: absolute; bottom: -150px; left: -150px; width: 500px; height: 500px; background: radial-gradient(circle, rgba(0, 191, 243, 0.06), transparent 70%); pointer-events: none; }
    .section-dark .bce-container { position: relative; z-index: 1; }
    .section-dark .overline { color: rgba(255,255,255,0.45); text-transform: uppercase; letter-spacing: 2px; font-size: 13px; }
    .section-dark h2 { color: #fff; }
    .benefits-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 2px; margin-top: 48px; background: rgba(255,255,255,0.04); }
    .benefit-item { padding: 36px 32px; background: #282829; position: relative; transition: all 0.4s ease; }
    .benefit-item:hover { background: rgba(255,255,255,0.03); }
    .benefit-icon { width: 40px; height: 40px; margin-bottom: 18px; display: flex; align-items: center; justify-content: center; }
    .benefit-icon svg { width: 100%; height: 100%; }
    .benefit-item strong { font-family: 'Poppins', sans-serif; font-size: 18px; font-weight: 500; color: #fff; display: block; margin-bottom: 8px; }
    .benefit-item span { font-size: 16px; color: rgba(255,255,255,0.65); font-weight: 300; line-height: 1.6; }

    /* ===== EXAMPLE USE CASE ===== */
    .use-case-layout { display: grid; grid-template-columns: 1fr 1fr; gap: 56px; margin-top: 40px; align-items: start; }
    .use-case-scenario p { font-size: 18px; }
    .scenario-label { display: inline-block; font-family: 'Poppins', sans-serif; font-size: 12px; font-weight: 500; text-transform: uppercase; letter-spacing: 1.5px; color: #8560A8; background: rgba(133, 96, 168, 0.08); padding: 6px 14px; margin-bottom: 20px; }
    .use-case-components { display: flex; flex-direction: column; gap: 8px; }
    .component-item { display: flex; gap: 16px; align-items: flex-start; padding: 18px 20px; background: #fff; border: 1px solid rgba(133, 96, 168, 0.08); transition: all 0.35s ease; }
    .section-light .component-item { background: #fff; }
    .component-item:hover { border-color: rgba(133, 96, 168, 0.2); transform: translateX(4px); }
    .check-icon { flex-shrink: 0; width: 22px; height: 22px; margin-top: 1px; }
    .component-item p { font-size: 15px; line-height: 1.55; margin-bottom: 0; }

    .result-callout { margin-top: 56px; padding: 40px 36px; background: linear-gradient(160deg, rgba(133, 96, 168, 0.06), rgba(0, 191, 243, 0.06)); border-left: 4px solid; border-image: linear-gradient(180deg, #8560A8, #00BFF3) 1; position: relative; }
    .result-callout::before { content: ''; position: absolute; top: -1px; right: -1px; bottom: -1px; left: -1px; border: 1px solid rgba(133, 96, 168, 0.08); border-left: none; pointer-events: none; }
    .result-callout p { font-size: 18px; font-weight: 300; color: #252C3A; margin-bottom: 0; line-height: 1.65; }
    .result-callout strong { font-weight: 600; color: #8560A8; }

    /* ===== PROCESS ===== */
    .process-steps { margin-top: 56px; position: relative; }
    .process-steps::before { content: ''; position: absolute; left: 31px; top: 40px; bottom: 40px; width: 2px; background: linear-gradient(180deg, #8560A8, #5674B9, #448CCB, #00BFF3); opacity: 0.25; }
    .process-step { display: grid; grid-template-columns: 64px 1fr; gap: 28px; padding: 28px 0; align-items: start; position: relative; }
    .step-marker { width: 64px; height: 64px; display: flex; align-items: center; justify-content: center; position: relative; z-index: 1; }
    .step-number { font-family: 'Poppins', sans-serif; font-size: 22px; font-weight: 600; width: 52px; height: 52px; display: flex; align-items: center; justify-content: center; color: #8560A8; background: #fff; border: 2px solid rgba(133, 96, 168, 0.2); transition: all 0.4s ease; }
    .process-step:hover .step-number { background: #8560A8; color: #fff; border-color: #8560A8; box-shadow: 0 8px 24px rgba(133, 96, 168, 0.25); }
    .section-light .step-number { background: #f9f9fb; }
    .step-content { padding-top: 12px; }
    .process-step h3 { font-size: 20px; margin-bottom: 6px; }
    .process-step .step-desc { color: #323A51; font-weight: 300; font-size: 17px; line-height: 1.6; }

    /* ===== AUDIENCE ===== */
    .audience-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-top: 44px; }
    .audience-card { display: flex; gap: 18px; align-items: flex-start; padding: 28px 24px; background: #fff; transition: all 0.4s ease; border: 1px solid transparent; }
    .audience-card:hover { border-color: rgba(133, 96, 168, 0.12); box-shadow: 0 8px 32px rgba(133, 96, 168, 0.06); transform: translateY(-3px); }
    .audience-icon { flex-shrink: 0; width: 36px; height: 36px; margin-top: 2px; }
    .audience-card p { font-size: 17px; line-height: 1.55; margin-bottom: 0; }

    /* ===== CTA CLOSE ===== */
    .cta-close { background: #8560A8; padding: 110px 0; text-align: center; position: relative; overflow: hidden; }
    .cta-close::before { content: ''; position: absolute; inset: 0; background: radial-gradient(ellipse 400px 400px at 20% 50%, rgba(86, 116, 185, 0.3), transparent), radial-gradient(ellipse 350px 350px at 80% 30%, rgba(0, 191, 243, 0.2), transparent); pointer-events: none; }
    .cta-close .bce-container { position: relative; z-index: 1; }
    .cta-close h2 { color: #fff; margin-bottom: 20px; max-width: 600px; margin-left: auto; margin-right: auto; font-size: 40px; }
    .cta-close p { color: rgba(255,255,255,0.85); font-size: 18px; max-width: 580px; margin: 0 auto 40px; }

    /* ===== FOOTER ===== */
    .site-footer { background: #282829; padding: 64px 0 32px; color: rgba(255,255,255,0.6); font-size: 15px; }
    .footer-grid { display: grid; grid-template-columns: 1.5fr 1fr 1fr 1fr; gap: 40px; margin-bottom: 40px; }
    .footer-brand .logo { display: block; line-height: 0; margin-bottom: 12px; }
    .footer-brand p { font-size: 14px; line-height: 1.6; color: rgba(255,255,255,0.5); margin-bottom: 0; max-width: 280px; }
    .footer-col h4 { font-family: 'Poppins', sans-serif; font-size: 15px; font-weight: 500; color: #fff; margin-bottom: 16px; }
    .footer-col ul { list-style: none; }
    .footer-col li { margin-bottom: 8px; }
    .footer-col a { color: rgba(255,255,255,0.55); font-size: 14px; transition: color 0.2s; }
    .footer-col a:hover { color: #00BFF3; }
    .footer-bottom { border-top: 1px solid rgba(255,255,255,0.08); padding-top: 24px; font-size: 13px; color: rgba(255,255,255,0.35); }

    .section-divider { height: 1px; background: linear-gradient(90deg, transparent, rgba(133, 96, 168, 0.15) 20%, rgba(0, 191, 243, 0.15) 80%, transparent); }

    /* ===== ILLUSTRATION IN USE CASE ===== */
    .use-case-illustration {
      margin-top: 48px;
    }
    .uc-browser {
      background: #fff;
      border: 1px solid rgba(0,0,0,0.06);
      box-shadow: 0 12px 40px rgba(37, 44, 58, 0.1);
      overflow: hidden;
    }
    .uc-browser-bar {
      display: flex; align-items: center; gap: 6px; padding: 8px 12px; background: #f5f5f7; border-bottom: 1px solid rgba(0,0,0,0.04);
    }
    .uc-dot { width: 8px; height: 8px; border-radius: 50%; }
    .uc-dot:nth-child(1) { background: #ff5f57; }
    .uc-dot:nth-child(2) { background: #ffbd2e; }
    .uc-dot:nth-child(3) { background: #28c840; }
    .uc-url-bar {
      margin-left: 10px; background: #fff; border: 1px solid rgba(0,0,0,0.05); border-radius: 3px; padding: 3px 10px; font-size: 10px; color: #999; flex: 1; font-family: 'Assistant', sans-serif;
    }
    .uc-page {
      display: grid;
      grid-template-columns: 200px 1fr;
      min-height: 200px;
    }
    .uc-sidebar {
      background: #f9f9fb;
      border-right: 1px solid rgba(0,0,0,0.04);
      padding: 14px;
    }
    .uc-sidebar-item {
      padding: 6px 8px;
      margin-bottom: 4px;
      border-radius: 2px;
      font-size: 9px;
      font-family: 'Poppins', sans-serif;
      color: #666;
      display: flex;
      align-items: center;
      gap: 6px;
    }
    .uc-sidebar-item.active {
      background: rgba(133, 96, 168, 0.08);
      color: #8560A8;
      font-weight: 500;
    }
    .uc-sidebar-dot {
      width: 6px; height: 6px; border-radius: 50%; background: #ddd;
    }
    .uc-sidebar-item.active .uc-sidebar-dot { background: #8560A8; }

    .uc-main {
      padding: 16px 20px;
    }
    .uc-content-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
      margin-bottom: 12px;
    }
    .uc-data-card {
      padding: 10px 12px;
      border: 1px solid rgba(0,0,0,0.05);
      background: #fff;
    }
    .uc-data-label { font-size: 8px; color: #999; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; font-family: 'Poppins', sans-serif; }
    .uc-data-value { font-family: 'Poppins', sans-serif; font-size: 18px; font-weight: 600; }
    .uc-mini-chart {
      display: flex; align-items: flex-end; gap: 2px; height: 20px; margin-top: 4px;
    }
    .uc-mini-bar { flex: 1; border-radius: 1px 1px 0 0; }

    .uc-text-area {
      margin-top: 4px;
    }
    .uc-text-row { height: 4px; background: #ebebee; margin-bottom: 4px; border-radius: 1px; }
    .uc-text-row:nth-child(2) { width: 90%; }
    .uc-text-row:nth-child(3) { width: 75%; }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 960px) {
      .hero-layout { grid-template-columns: 1fr; }
      .hero-visual { min-height: 320px; margin-top: 40px; }
      .feature-card-featured { grid-template-columns: 1fr; }
      .hv-browser { width: 280px; }
      .hv-mobile { left: -10px; }
      .hv-stats { right: -10px; }
      .features-grid { grid-template-columns: repeat(2, 1fr); }
      .benefits-grid { grid-template-columns: 1fr; }
      .use-case-layout { grid-template-columns: 1fr; gap: 36px; }
      .footer-grid { grid-template-columns: 1fr 1fr; gap: 32px; }
      .audience-grid { grid-template-columns: 1fr; }
      .mockup-showcase { grid-template-columns: 1fr; }
      .mockup-sidebar { flex-direction: row; gap: 20px; }
      .mobile-mockup { max-width: 240px; min-width: auto; }
      .browser-mockup, .mobile-mockup, .stats-card { transform: none; }
      .browser-mockup:hover, .mobile-mockup:hover, .stats-card:hover { transform: none; }
      .uc-page { grid-template-columns: 1fr; }
      .uc-sidebar { display: none; }
    }

    @media (max-width: 768px) {
      .hero { padding: 140px 0 70px; min-height: auto; }
      .hero-visual { display: none; }
      .hero h1 { font-size: 52px; }
      .hero .subtitle { font-size: 20px; }
      .hero .supporting { font-size: 17px; }
      .bce-page h2 { font-size: 30px; }
      .section-white, .section-light, .section-dark { padding: 72px 0; }
      .cta-close { padding: 80px 0; }
      .cta-close h2 { font-size: 30px; }
      .features-grid { grid-template-columns: 1fr; gap: 16px; }
      .process-steps::before { left: 27px; }
      .process-step { grid-template-columns: 56px 1fr; gap: 16px; padding: 20px 0; }
      .step-number { width: 44px; height: 44px; font-size: 18px; }
.footer-grid { grid-template-columns: 1fr; gap: 28px; }
      .trio-visual { grid-template-columns: 1fr; gap: 0; }
      .pull-quote-banner blockquote { font-size: 20px; padding: 0 20px; }
      .pull-quote-banner { padding: 44px 0; }
      .mockup-sidebar { flex-direction: column; align-items: center; }
      .mobile-mockup { max-width: 220px; min-width: auto; }
    }

    @media (max-width: 480px) {
      .hero h1 { font-size: 40px; }
      .hero .subtitle { font-size: 18px; }
      .bce-page h2 { font-size: 26px; }
      .btn-primary, .btn-white { width: 100%; text-align: center; }
      .feature-card { padding: 28px 20px; }
      .benefit-item { padding: 28px 20px; }
      .pull-quote-banner blockquote { font-size: 18px; padding: 0 8px; }
      .mock-media-row { grid-template-columns: 1fr; }
    }


/* =====================================================
   UPGRADE PASS — new systems
   ===================================================== */

/* HERO — grid texture + colored edge cells + mouse parallax */
.bce-page .hero { min-height: 88vh; padding: 200px 0 140px; }
.bce-page .hero::before {
  background: linear-gradient(160deg, rgba(37, 44, 58, 0.85) 0%, rgba(26, 31, 46, 0.92) 100%);
}
.bce-page .hero-grid {
  position: absolute; inset: 0; z-index: 1; pointer-events: none;
  background-image:
    linear-gradient(rgba(255,255,255,0.04) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255,255,255,0.04) 1px, transparent 1px);
  background-size: 60px 60px;
  background-position: center center;
  mask-image: radial-gradient(ellipse at center, rgba(0,0,0,0.35) 0%, rgba(0,0,0,0.9) 55%, rgba(0,0,0,1) 100%);
  -webkit-mask-image: radial-gradient(ellipse at center, rgba(0,0,0,0.35) 0%, rgba(0,0,0,0.9) 55%, rgba(0,0,0,1) 100%);
  transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}
.bce-page .hero-cells { position: absolute; inset: 0; z-index: 1; pointer-events: none; overflow: hidden; }
.bce-page .hero-cell { position: absolute; width: 60px; height: 60px; border-radius: 2px; opacity: 0.15; }
.bce-page .hero-cell.c1 { top: 12%;  left: 6%;  background: #8560A8; animation: bcePulse 7s ease-in-out infinite; }
.bce-page .hero-cell.c2 { top: 70%;  left: 12%; background: #00BFF3; animation: bcePulse 9s ease-in-out infinite 1s; }
.bce-page .hero-cell.c3 { top: 22%;  right: 9%; background: #448CCB; animation: bcePulse 8s ease-in-out infinite 0.5s; }
.bce-page .hero-cell.c4 { top: 58%;  right: 5%; background: #5674B9; animation: bcePulse 10s ease-in-out infinite 2s; }
.bce-page .hero-cell.c5 { top: 38%;  left: 38%; background: #00BFF3; width: 48px; height: 48px; opacity: 0.08; animation: bcePulse 12s ease-in-out infinite; }
@keyframes bcePulse {
  0%, 100% { opacity: 0.08; transform: scale(1); }
  50%      { opacity: 0.22; transform: scale(1.15); }
}

/* ANGLED SVG DIVIDERS between sections */
.bce-page .bce-angle {
  position: relative;
  height: 60px;
  margin-top: -1px;
  line-height: 0;
  z-index: 5;
}
.bce-page .bce-angle svg { display: block; width: 100%; height: 100%; }

/* SECTION POSITIONING for chapter marks */
.bce-page .section-white,
.bce-page .section-light,
.bce-page .section-dark,
.bce-page .cta-close { position: relative; overflow: hidden; }
.bce-page .section-white .bce-container,
.bce-page .section-light .bce-container,
.bce-page .section-dark .bce-container { position: relative; z-index: 2; }

/* CHAPTER MARKERS — giant faded numerals */
.bce-page .bce-chapter {
  position: absolute; top: 28px; right: 36px;
  font-family: 'Poppins', sans-serif;
  font-size: 200px; font-weight: 700; line-height: 0.85;
  letter-spacing: -8px;
  color: transparent;
  -webkit-text-stroke: 1.5px rgba(37, 44, 58, 0.06);
  pointer-events: none; user-select: none; z-index: 1;
}
.bce-page .section-dark .bce-chapter { -webkit-text-stroke-color: rgba(255, 255, 255, 0.06); }
.bce-page .cta-close .bce-chapter { -webkit-text-stroke-color: rgba(255, 255, 255, 0.1); }

/* PULL QUOTE — gradient accent bar upgrade */
.bce-page .pull-quote-banner { padding: 68px 0; }
.bce-page .pull-quote-banner::after {
  content: ''; position: absolute; left: 0; right: 0; bottom: 0;
  height: 4px;
  background: linear-gradient(90deg, #8560A8 0%, #5674B9 25%, #448CCB 50%, #00BFF3 75%, #8560A8 100%);
  background-size: 200% 100%;
  animation: bceGradSlide 6s ease infinite;
}
@keyframes bceGradSlide {
  0%, 100% { background-position: 0% 50%; }
  50%      { background-position: 100% 50%; }
}

/* FEATURED CARD — animated gradient accent bar along left edge (respects original dark design) */
.bce-page .feature-card-featured {
  position: relative;
  border-left: none !important;
  border-image: none !important;
  overflow: hidden;
}
.bce-page .feature-card-featured::before {
  content: ''; position: absolute; top: 0; left: 0; bottom: 0;
  width: 4px;
  background: linear-gradient(180deg, #8560A8 0%, #5674B9 33%, #448CCB 66%, #00BFF3 100%);
  background-size: 100% 300%;
  animation: bceAccentSlide 6s ease-in-out infinite;
  z-index: 2;
}
@keyframes bceAccentSlide {
  0%, 100% { background-position: 0% 0%; }
  50%      { background-position: 0% 100%; }
}

/* ICON REFRESH — unified colored-badge frame */
.bce-page .trio-icon,
.bce-page .feature-icon,
.bce-page .benefit-icon,
.bce-page .audience-icon {
  display: inline-flex;
  align-items: center; justify-content: center;
  border-radius: 11px;
  padding: 9px;
  border: 1px solid rgba(0, 0, 0, 0.06);
  background: rgba(255, 255, 255, 0.6);
  transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), background 0.3s ease;
}
.bce-page .section-dark .benefit-icon {
  background: rgba(255, 255, 255, 0.04);
  border-color: rgba(255, 255, 255, 0.08);
}
.bce-page .trio-icon    { width: 56px; height: 56px; color: #8560A8; }
.bce-page .feature-icon { width: 48px; height: 48px; color: #8560A8; }
.bce-page .feature-icon svg { width: 100%; height: 100%; }
.bce-page .benefit-icon { width: 44px; height: 44px; color: #00BFF3; }
.bce-page .benefit-icon svg { width: 100%; height: 100%; }
.bce-page .audience-icon { width: 44px; height: 44px; color: #8560A8; }
.bce-page .audience-icon svg { width: 100%; height: 100%; }

/* per-audience accent colors */
.bce-page .audience-card:nth-child(1) .audience-icon { color: #8560A8; }
.bce-page .audience-card:nth-child(2) .audience-icon { color: #5674B9; }
.bce-page .audience-card:nth-child(3) .audience-icon { color: #448CCB; }
.bce-page .audience-card:nth-child(4) .audience-icon { color: #00BFF3; }
.bce-page .trio-item:nth-child(1) .trio-icon { color: #8560A8; }
.bce-page .trio-item:nth-child(2) .trio-icon { color: #5674B9; }
.bce-page .trio-item:nth-child(3) .trio-icon { color: #00BFF3; }

.bce-page .feature-card:hover .feature-icon,
.bce-page .audience-card:hover .audience-icon,
.bce-page .benefit-item:hover .benefit-icon {
  transform: rotate(-5deg) scale(1.08);
  background: rgba(255, 255, 255, 0.92);
}
.bce-page .section-dark .benefit-item:hover .benefit-icon {
  background: rgba(255, 255, 255, 0.1);
}

/* 3D TILT + CURSOR GLOW on data-tilt elements */
.bce-page [data-tilt] {
  transition: box-shadow 0.4s ease;
  transform-style: preserve-3d;
  will-change: transform;
  position: relative;
}
.bce-page [data-tilt]::before {
  content: ''; position: absolute; inset: 0;
  background: radial-gradient(circle 200px at var(--glow-x, 50%) var(--glow-y, 50%), rgba(133, 96, 168, 0.18), transparent 60%);
  opacity: 0; transition: opacity 0.4s ease;
  pointer-events: none; z-index: 10;
  border-radius: inherit;
}
.bce-page [data-tilt]:hover::before { opacity: 1; }

/* CASE STUDIES SECTION */
.bce-page .case-studies { background: #fff; padding: 100px 0; position: relative; overflow: hidden; }
.bce-page .case-studies .bce-container { position: relative; z-index: 2; }
.bce-page .case-intro { text-align: center; max-width: 660px; margin: 0 auto 56px; }
.bce-page .case-intro h2 { text-align: center; }
.bce-page .case-intro .overline { display: block; margin-bottom: 14px; color: #00BFF3; }
.bce-page .case-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 28px;
}
.bce-page .case-card {
  background: #fff;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
  border: 1px solid rgba(0, 0, 0, 0.04);
  text-decoration: none;
  color: inherit;
  display: flex; flex-direction: column;
  transition: box-shadow 0.4s ease;
}
.bce-page .case-card:hover { box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12); }
.bce-page .case-thumb {
  aspect-ratio: 16 / 9;
  background: linear-gradient(135deg, var(--case-color, #8560A8) 0%, #1a1f2e 120%);
  position: relative;
  overflow: hidden;
  display: flex; align-items: center; justify-content: center;
}
.bce-page .case-thumb::before {
  content: ''; position: absolute; inset: 0;
  background-image:
    linear-gradient(rgba(255,255,255,0.05) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255,255,255,0.05) 1px, transparent 1px);
  background-size: 30px 30px;
}
.bce-page .case-thumb-browser {
  position: relative; z-index: 1;
  width: 78%; border-radius: 6px; overflow: hidden;
  background: #fff;
  box-shadow: 0 18px 40px rgba(0, 0, 0, 0.35);
  transform: perspective(900px) rotateX(6deg);
}
.bce-page .case-thumb-bar {
  display: flex; align-items: center; gap: 4px;
  padding: 6px 8px; background: #f0f0f2;
  border-bottom: 1px solid rgba(0, 0, 0, 0.06);
}
.bce-page .case-thumb-dot { width: 6px; height: 6px; border-radius: 50%; background: #d4d4d8; }
.bce-page .case-thumb-dot:nth-child(1) { background: #ff5f57; }
.bce-page .case-thumb-dot:nth-child(2) { background: #ffbd2e; }
.bce-page .case-thumb-dot:nth-child(3) { background: #28c840; }
.bce-page .case-thumb-body {
  padding: 12px;
  display: grid; grid-template-columns: 1fr 1fr; gap: 8px;
}
.bce-page .case-thumb-bar-thick {
  grid-column: 1 / -1;
  height: 8px; background: var(--case-color, #8560A8);
  border-radius: 2px;
  opacity: 0.9;
}
.bce-page .case-thumb-line {
  height: 4px; background: #e8e8ec; border-radius: 1px;
}
.bce-page .case-thumb-line.w-50 { width: 50%; }
.bce-page .case-thumb-line.w-80 { width: 80%; }
.bce-page .case-thumb-block {
  grid-column: 1 / -1;
  height: 30px;
  background: linear-gradient(135deg, rgba(133, 96, 168, 0.1), rgba(0, 191, 243, 0.08));
  border-radius: 3px;
  margin-top: 4px;
}
.bce-page .case-body { padding: 28px 28px 30px; }
.bce-page .case-body .case-eyebrow {
  font-family: 'Montserrat', sans-serif; font-size: 11px;
  text-transform: uppercase; letter-spacing: 2px;
  color: var(--case-color, #8560A8);
  margin-bottom: 10px;
  display: inline-flex; align-items: center; gap: 8px;
}
.bce-page .case-body .case-eyebrow::before {
  content: ''; width: 5px; height: 5px; border-radius: 50%; background: var(--case-color, #8560A8);
}
.bce-page .case-body h3 {
  font-family: 'Poppins', sans-serif;
  font-size: 22px; font-weight: 600; color: #252C3A;
  margin: 0 0 12px; line-height: 1.3; letter-spacing: -0.3px;
}
.bce-page .case-body p {
  font-size: 15px; color: #5a6276; line-height: 1.55; margin: 0 0 20px;
}
.bce-page .case-meta {
  display: flex; gap: 20px; margin-bottom: 22px;
  font-family: 'Poppins', sans-serif; font-size: 12px;
  color: #8590a6;
}
.bce-page .case-meta strong {
  display: block; color: #252C3A;
  font-size: 18px; font-weight: 600;
  letter-spacing: -0.3px;
}
.bce-page .case-link {
  font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 500;
  color: var(--case-color, #8560A8);
  display: inline-flex; align-items: center; gap: 8px;
  transition: gap 0.3s ease;
}
.bce-page .case-card:hover .case-link { gap: 14px; }

@media (max-width: 768px) {
  .bce-page .case-grid { grid-template-columns: 1fr; }
  .bce-page .bce-chapter { font-size: 110px; right: 16px; top: 16px; letter-spacing: -4px; }
}
@media (prefers-reduced-motion: reduce) {
  .bce-page .hero-cell,
  .bce-page .feature-card-featured::before,
  .bce-page .pull-quote-banner::after { animation: none; }
}

/* Button text color — higher specificity than .bce-page a { color: inherit } */
.bce-page .btn-primary,
.bce-page a.btn-primary,
.bce-page .btn-primary:hover,
.bce-page .btn-primary:visited { color: #fff; }

.bce-page .btn-white,
.bce-page a.btn-white,
.bce-page .btn-white:hover,
.bce-page .btn-white:visited { color: #8560A8; }

.bce-page .case-link { color: var(--case-color, #8560A8); }

/* Keep button label above the shimmer overlay */
.bce-page .btn-primary { isolation: isolate; }
.bce-page .btn-primary::after { z-index: -1; }

</style>

<div class="bce-page">
<!-- NAV -->
  <!-- MODULE 1 — HERO -->
  <section class="hero" aria-label="Hero">
    <div class="hero-grid" id="bceHeroGrid"></div>
    <div class="hero-cells">
      <span class="hero-cell c1"></span>
      <span class="hero-cell c2"></span>
      <span class="hero-cell c3"></span>
      <span class="hero-cell c4"></span>
      <span class="hero-cell c5"></span>
    </div>
    <div class="bce-container">
      <div class="hero-layout">
        <div class="hero-text">
          <h1>Bespoke<br>Content<br><span class="accent">Experience</span></h1>
          <p class="subtitle">The future of content is multi-modal, performance-driven, and impossible to ignore.</p>
          <p class="supporting">Not just content. A custom-built organic growth asset.</p>
          <a href="/contact-stretch-creative/" class="btn-primary">Let's Chat &rarr;</a>
        </div>
        <div class="hero-visual">
          <!-- Browser mockup -->
          <div class="hv-browser" data-tilt>
            <div class="hv-bar">
              <div class="hv-dot"></div><div class="hv-dot"></div><div class="hv-dot"></div>
              <div class="hv-url">yourbrand.com/content-experience</div>
            </div>
            <div class="hv-page">
              <div class="hv-page-hero">
                <div class="hv-ph-line" style="width:40%;"></div>
                <div class="hv-ph-line title"></div>
                <div class="hv-ph-line title2"></div>
                <div class="hv-ph-line sub"></div>
                <div class="hv-ph-btn"></div>
              </div>
              <div class="hv-body">
                <div class="hv-text"></div>
                <div class="hv-text"></div>
                <div class="hv-text"></div>
                <div class="hv-media">
                  <div class="hv-img">
                    <svg viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="1" stroke="#8560A8" stroke-width="1.5"/><circle cx="8.5" cy="8.5" r="2" stroke="#8560A8" stroke-width="1.2"/><path d="M3 16l5-4 4 3 3-2 6 4" stroke="#8560A8" stroke-width="1.2"/></svg>
                  </div>
                  <div class="hv-img">
                    <svg viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="1" stroke="#5674B9" stroke-width="1.5"/><circle cx="8.5" cy="8.5" r="2" stroke="#5674B9" stroke-width="1.2"/><path d="M3 16l5-4 4 3 3-2 6 4" stroke="#5674B9" stroke-width="1.2"/></svg>
                  </div>
                </div>
                <div class="hv-interactive">
                  <div class="hv-app-toolbar">
                    <div class="hv-app-title">Embedded Application</div>
                    <div class="hv-app-tabs">
                      <div class="hv-app-tab active">Dashboard</div>
                      <div class="hv-app-tab">Configure</div>
                      <div class="hv-app-tab">Export</div>
                    </div>
                  </div>
                  <div class="hv-app-body">
                    <div class="hv-app-panel">
                      <div class="hv-app-chart">
                        <svg viewBox="0 0 120 36" fill="none" width="100%" height="100%" preserveAspectRatio="none">
                          <rect x="0" y="32" width="120" height="0.5" fill="#e8e8ec"/>
                          <rect x="0" y="22" width="120" height="0.3" fill="#f0f0f2"/>
                          <rect x="0" y="12" width="120" height="0.3" fill="#f0f0f2"/>
                          <path d="M0 30 Q15 28 30 26 T60 22 Q75 18 90 10 L105 4 L120 1" stroke="#8560A8" stroke-width="1.5" fill="none" stroke-linecap="round"/>
                          <path d="M0 30 Q15 28 30 26 T60 22 Q75 18 90 10 L105 4 L120 1 L120 32 L0 32 Z" fill="url(#appChartFill)" opacity="0.1"/>
                          <circle cx="120" cy="1" r="2" fill="#8560A8"/>
                          <defs><linearGradient id="appChartFill" x1="0" y1="0" x2="0" y2="36" gradientUnits="userSpaceOnUse"><stop offset="0%" stop-color="#8560A8"/><stop offset="100%" stop-color="#8560A8" stop-opacity="0"/></linearGradient></defs>
                        </svg>
                      </div>
                      <div class="hv-app-metrics">
                        <div class="hv-app-metric"><div class="hv-app-metric-val">94</div><div class="hv-app-metric-lbl">Score</div></div>
                        <div class="hv-app-metric"><div class="hv-app-metric-val" style="color:#00BFF3;">A+</div><div class="hv-app-metric-lbl">Grade</div></div>
                        <div class="hv-app-metric"><div class="hv-app-metric-val" style="color:#5674B9;">12</div><div class="hv-app-metric-lbl">Tasks</div></div>
                      </div>
                    </div>
                    <div class="hv-app-sidebar">
                      <div class="hv-app-input"></div>
                      <div class="hv-app-input"></div>
                      <div class="hv-app-input"></div>
                      <div class="hv-app-btn"></div>
                    </div>
                  </div>
                </div>
                <div class="hv-video">
                  <div class="hv-play">
                    <svg viewBox="0 0 12 12" fill="none"><polygon points="3,1 3,11 10,6" fill="#fff"/></svg>
                  </div>
                </div>
                <div class="hv-text"></div>
                <div class="hv-text" style="width:65%;"></div>
              </div>
            </div>
          </div>
          <!-- Floating mobile -->
          <div class="hv-mobile">
            <div class="hv-mob-screen">
              <div class="hv-mob-notch"><div class="hv-mob-notch-bar"></div></div>
              <div class="hv-mob-hero"></div>
              <div class="hv-mob-body">
                <div class="hv-mob-line"></div>
                <div class="hv-mob-line"></div>
                <div class="hv-mob-line"></div>
                <div class="hv-mob-chart">
                  <div class="hv-mob-b"></div><div class="hv-mob-b"></div><div class="hv-mob-b"></div>
                  <div class="hv-mob-b"></div><div class="hv-mob-b"></div>
                </div>
                <div class="hv-mob-cta"></div>
              </div>
              <div class="hv-mob-bottom"></div>
            </div>
          </div>
          <!-- Floating stats -->
          <div class="hv-stats">
            <div class="hv-stats-header">
              <div class="hv-stats-dot" style="background:#8560A8;"></div>
              <div class="hv-stats-dot" style="background:#5674B9;"></div>
              <div class="hv-stats-dot" style="background:#00BFF3;"></div>
              <div class="hv-stats-title">Performance</div>
            </div>
            <div class="hv-stat-grid">
              <div class="hv-stat">
                <div class="hv-stat-num" style="color:#8560A8;">4.2x</div>
                <div class="hv-stat-label">Dwell</div>
              </div>
              <div class="hv-stat">
                <div class="hv-stat-num" style="color:#00BFF3;">312%</div>
                <div class="hv-stat-label">Organics</div>
              </div>
              <div class="hv-stat">
                <div class="hv-stat-num" style="color:#5674B9;">+89%</div>
                <div class="hv-stat-label">Social</div>
              </div>
              <div class="hv-stat">
                <div class="hv-stat-num" style="color:#28c840;">2.8x</div>
                <div class="hv-stat-label">Conversions</div>
              </div>
            </div>
            <div class="hv-hockey-chart">
              <svg viewBox="0 0 170 32" fill="none" width="100%" height="100%" preserveAspectRatio="none">
                <path d="M0 30 Q20 29 40 28 T80 26 Q95 24 110 20 Q125 14 140 6 L155 1 L170 0" stroke="url(#hockeyGrad)" stroke-width="2" fill="none" stroke-linecap="round"/>
                <path d="M0 30 Q20 29 40 28 T80 26 Q95 24 110 20 Q125 14 140 6 L155 1 L170 0 L170 32 L0 32 Z" fill="url(#hockeyFill)" opacity="0.15"/>
                <defs>
                  <linearGradient id="hockeyGrad" x1="0" y1="0" x2="170" y2="0" gradientUnits="userSpaceOnUse">
                    <stop offset="0%" stop-color="#8560A8"/>
                    <stop offset="100%" stop-color="#00BFF3"/>
                  </linearGradient>
                  <linearGradient id="hockeyFill" x1="0" y1="0" x2="170" y2="0" gradientUnits="userSpaceOnUse">
                    <stop offset="0%" stop-color="#8560A8"/>
                    <stop offset="100%" stop-color="#00BFF3"/>
                  </linearGradient>
                </defs>
              </svg>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="hero-accent-bar"></div>

  <!-- PULL QUOTE BANNER -->
  <div class="pull-quote-banner">
    <div class="bce-container">
      <blockquote>
        A single content asset that <span class="quote-accent">ranks</span>, earns backlinks, gets shared, generates leads, and positions the brand as the authority on the topic.
      </blockquote>
    </div>
  </div>

  <div class="bce-angle"><svg viewBox="0 0 1440 60" preserveAspectRatio="none"><polygon points="0,60 1440,0 1440,60" fill="#fff"/></svg></div>

  

  <!-- MODULE 2 — THE SHIFT -->
  <section class="section-white" aria-label="The landscape has changed">
    <span class="bce-chapter" aria-hidden="true">01</span>
    <div class="bce-container">
      <span class="overline reveal">The Landscape Has Changed</span>
      <h2 class="reveal">Going All In to Win Organic Traffic</h2>
      <div class="body-content">
        <p class="reveal">Imagine not just writing another SEO article — but going all in to win organic traffic for a topic that matters to your business.</p>
        <p class="reveal">That's the shift happening right now. The days of publishing basic articles and expecting strong organic growth are over. Content marketing and SEO now reward brands that create richer, more useful, and more engaging experiences — not just more words on a page.</p>
        <p class="reveal">Search engines and AI answer engines evaluate content on depth, structure, originality, and user experience. Audiences expect interactive tools, embedded video, original data, and design that earns their attention. The brands still treating content as a checkbox are the ones watching their rankings quietly disappear.</p>
        <div class="pull-highlight reveal">Blog content got you here. Owning the topic is what gets you to the next level.</div>
      </div>

      <h3 class="reveal" style="color: #8560A8; font-size: 20px; margin-top: 56px; margin-bottom: 28px;">Who this is built for</h3>
      <div class="audience-grid">
        <div class="audience-card reveal reveal-delay-1">
          <div class="audience-icon">
            <!-- Rocket: outgrown basic content -->
            <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M8 40h8v-8h8v-8h8v-8h8"/><path d="M40 4v12h-12"/><path d="M4 20h6"/><path d="M14 20h8" stroke-opacity="0.4"/><path d="M26 20h10" stroke-opacity="0.4"/></svg>
          </div>
          <p>Brands that have outgrown commodity blog content and need something that actually moves the needle</p>
        </div>
        <div class="audience-card reveal reveal-delay-2">
          <div class="audience-icon">
            <!-- Flag/plant: own a topic -->
            <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M6 42L22 12l8 14 4-6 10 22z"/><path d="M22 12v-8"/><path d="M22 4h10l-3 3.5 3 3.5H22"/><circle cx="22" cy="4" r="0.6" fill="currentColor" stroke="none"/></svg>
          </div>
          <p>Teams that want to own a topic in organic search — not just rank for a few keywords</p>
        </div>
        <div class="audience-card reveal reveal-delay-3">
          <div class="audience-icon">
            <!-- Upward trend: content as growth -->
            <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M6 40h36"/><path d="M6 40V10"/><path d="M10 36 18 32 26 26 32 18 40 8"/><path d="M40 8l-5 0M40 8l0 5"/><path d="M36 14l2-2m0 2l-2-2" stroke-width="1.2"/></svg>
          </div>
          <p>Organizations investing in content as a growth channel, not a checkbox</p>
        </div>
        <div class="audience-card reveal reveal-delay-4">
          <div class="audience-icon">
            <!-- Multi-channel: search + AI + social -->
            <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><circle cx="24" cy="24" r="6"/><circle cx="24" cy="8"  r="3"/><circle cx="40" cy="24" r="3"/><circle cx="24" cy="40" r="3"/><circle cx="8"  cy="24" r="3"/><path d="M24 14v-3M24 34v3M30 24h7M18 24h-7" stroke-opacity="0.55"/></svg>
          </div>
          <p>Companies that need content performing across traditional search, AI answer engines, and social</p>
        </div>
      </div>
    </div>
  </section>

  <div class="bce-angle"><svg viewBox="0 0 1440 60" preserveAspectRatio="none"><polygon points="0,60 1440,0 1440,60" fill="#f9f9fb"/></svg></div>

  

  <!-- MODULE 3 — WHAT IS IT -->
  <section class="section-light" aria-label="What is a Bespoke Content Experience">
    <span class="bce-chapter" aria-hidden="true">02</span>
    <div class="bce-container">
      <span class="overline reveal">The Service</span>
      <h2 class="reveal">What Is a Bespoke Content Experience?</h2>
      <div class="body-content">
        <p class="reveal">A Bespoke Content Experience is a custom-built digital content asset designed around a single high-value topic. It goes far beyond a traditional blog post by combining editorial depth with rich media, interactive elements, and strategic design — all engineered to perform.</p>
      </div>

      <!-- Illustrated Mockup Showcase -->
      <div class="mockup-showcase reveal">
        <!-- Browser Window -->
        <div class="browser-mockup" data-tilt>
          <div class="browser-bar">
            <div class="browser-dot"></div>
            <div class="browser-dot"></div>
            <div class="browser-dot"></div>
            <div class="browser-url">yourbrand.com/enterprise-data-migration-guide</div>
          </div>
          <div class="browser-content">
            <!-- Mock hero -->
            <div class="mock-hero">
              <div class="mock-hero-overline"></div>
              <div class="mock-hero-title"></div>
              <div class="mock-hero-title short"></div>
              <div class="mock-hero-sub"></div>
              <div class="mock-hero-btn"></div>
            </div>
            <!-- Mock body content -->
            <div class="mock-body">
              <div class="mock-text-block">
                <div class="mock-text-line"></div>
                <div class="mock-text-line"></div>
                <div class="mock-text-line"></div>
                <div class="mock-text-line short"></div>
              </div>

              <!-- Media row -->
              <div class="mock-media-row">
                <div class="mock-image-placeholder">
                  <svg viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="1" stroke="#8560A8" stroke-width="1.5"/><circle cx="8.5" cy="8.5" r="2" stroke="#8560A8" stroke-width="1.2"/><path d="M3 16l5-4 4 3 3-2 6 4" stroke="#8560A8" stroke-width="1.2"/></svg>
                </div>
                <div class="mock-image-placeholder">
                  <svg viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="1" stroke="#5674B9" stroke-width="1.5"/><circle cx="8.5" cy="8.5" r="2" stroke="#5674B9" stroke-width="1.2"/><path d="M3 16l5-4 4 3 3-2 6 4" stroke="#5674B9" stroke-width="1.2"/></svg>
                </div>
              </div>

              <!-- Interactive element mockup -->
              <div class="mock-interactive">
                <div class="mock-interactive-label">Interactive Assessment Tool</div>
                <div class="mock-slider-track">
                  <div class="mock-slider-fill">
                    <div class="mock-slider-thumb"></div>
                  </div>
                </div>
                <div class="mock-bar-chart">
                  <div class="mock-bar"></div>
                  <div class="mock-bar"></div>
                  <div class="mock-bar"></div>
                  <div class="mock-bar"></div>
                  <div class="mock-bar"></div>
                  <div class="mock-bar"></div>
                  <div class="mock-bar"></div>
                  <div class="mock-bar"></div>
                </div>
              </div>

              <!-- Video embed -->
              <div class="mock-video-placeholder">
                <div class="mock-play-btn">
                  <svg viewBox="0 0 12 12" fill="none"><polygon points="3,1 3,11 10,6" fill="#fff"/></svg>
                </div>
              </div>

              <div class="mock-text-block">
                <div class="mock-text-line"></div>
                <div class="mock-text-line"></div>
                <div class="mock-text-line short"></div>
              </div>

              <!-- CTA row -->
              <div class="mock-cta-row">
                <div class="mock-cta-text">
                  <div class="mock-text-line" style="width:70%; background: #bbb;"></div>
                  <div class="mock-text-line" style="width:50%; background: #ccc;"></div>
                </div>
                <div class="mock-cta-btn"></div>
              </div>
            </div>
          </div>
        </div>

        <!-- Sidebar: Mobile + Stats -->
        <div class="mockup-sidebar">
          <!-- Mobile device -->
          <div class="mobile-mockup" data-tilt>
            <div class="mobile-screen">
              <div class="mobile-notch"><div class="mobile-notch-bar"></div></div>
              <div class="mobile-hero-img">
                <div class="mobile-hero-text"></div>
              </div>
              <div class="mobile-content">
                <div class="mobile-text"></div>
                <div class="mobile-text"></div>
                <div class="mobile-text"></div>
                <div class="mobile-chart-area">
                  <div class="mobile-donut"></div>
                  <div class="mobile-mini-bars">
                    <div class="mobile-mini-bar"></div>
                    <div class="mobile-mini-bar"></div>
                    <div class="mobile-mini-bar"></div>
                    <div class="mobile-mini-bar"></div>
                    <div class="mobile-mini-bar"></div>
                  </div>
                </div>
                <div class="mobile-text"></div>
                <div class="mobile-text" style="width: 65%;"></div>
                <div class="mobile-cta-bar"></div>
              </div>
              <div class="mobile-bottom-bar"></div>
            </div>
          </div>

          <!-- Stats card -->
          <div class="stats-card">
            <div class="stats-card-header">
              <div class="stats-dot purple"></div>
              <div class="stats-dot blue"></div>
              <div class="stats-dot cyan"></div>
              <div class="stats-card-title">Performance Dashboard</div>
            </div>
            <div class="stats-metric-row">
              <div class="stat-box">
                <div class="stat-number purple">4.2x</div>
                <div class="stat-label">Dwell Time</div>
              </div>
              <div class="stat-box">
                <div class="stat-number cyan">312%</div>
                <div class="stat-label">Organic Lift</div>
              </div>
              <div class="stat-box">
                <div class="stat-number blue">89</div>
                <div class="stat-label">Backlinks</div>
              </div>
            </div>
            <div class="stats-sparkline">
              <div class="spark-bar"></div>
              <div class="spark-bar"></div>
              <div class="spark-bar"></div>
              <div class="spark-bar"></div>
              <div class="spark-bar"></div>
              <div class="spark-bar"></div>
              <div class="spark-bar"></div>
              <div class="spark-bar"></div>
              <div class="spark-bar"></div>
              <div class="spark-bar"></div>
              <div class="spark-bar"></div>
              <div class="spark-bar"></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Trio visual -->
      <div class="trio-visual reveal">
        <div class="trio-item">
          <div class="trio-icon"><svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M10 6h18l8 8v28H10z"/><path d="M28 6v8h8"/><path d="M16 22h16M16 28h16M16 34h10"/></svg></div>
          <div class="trio-label">Part Article</div>
          <div class="trio-sub">Editorial depth</div>
        </div>
        <div class="trio-item">
          <div class="trio-icon"><svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><rect x="6" y="10" width="36" height="30" rx="2"/><path d="M6 18h36"/><circle cx="11" cy="14" r="1" fill="currentColor" stroke="none"/><circle cx="15" cy="14" r="1" fill="currentColor" stroke="none"/><path d="M12 28h24" stroke-opacity="0.35"/><circle cx="26" cy="28" r="2.5" fill="#fff"/><path d="M14 34h20" stroke-opacity="0.3"/></svg></div>
          <div class="trio-label">Part Application</div>
          <div class="trio-sub">Interactive tools</div>
        </div>
        <div class="trio-item">
          <div class="trio-icon"><svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M24 4l18 20-18 20L6 24z"/><path d="M24 16l2.5 5 5.5 1-4 4 1 5-5-2.5-5 2.5 1-5-4-4 5.5-1z" stroke-width="1.3"/></svg></div>
          <div class="trio-label">Part Brand Experience</div>
          <div class="trio-sub">Strategic design</div>
        </div>
      </div>

      <div class="body-content">
        <p class="reveal">From editorial and design to video, visuals, and interactive functionality — every piece is built from the ground up for your specific audience, topic, and business goals.</p>
        <p class="reveal">We build bespoke multi-modal content experiences that combine best-in-class SEO strategy, AEO readiness, and custom-built content modules to help brands dominate traffic, earn media attention, and fuel social distribution.</p>
      </div>
    </div>
  </section>

  <div class="bce-angle"><svg viewBox="0 0 1440 60" preserveAspectRatio="none"><polygon points="0,0 1440,60 1440,60 0,60" fill="#fff"/></svg></div>

  

  <!-- MODULE 4 — WHAT'S INSIDE -->
  <section class="section-white" aria-label="What is included">
    <span class="bce-chapter" aria-hidden="true">03</span>
    <div class="bce-container">
      <span class="overline reveal">What's Included</span>
      <h2 class="reveal">Anatomy of a Bespoke Content Experience</h2>
      <!-- FEATURED: Custom Interactive Applications -->
      <div class="feature-card-featured reveal" data-tilt>
        <div>
          <div class="featured-tag">The Centerpiece</div>
          <h3>Custom Interactive Applications</h3>
          <p>Every Bespoke Content Experience includes a custom-built interactive application — designed and developed specifically for your topic, your audience, and your goals.</p>
          <p>ROI modelers, diagnostic tools, comparison engines, configurators — whatever the topic demands. Each one is engineered to increase dwell time, earn backlinks, and create the kind of value that search engines and AI answer engines reward.</p>
        </div>
        <div class="mini-app">
          <div class="mini-app-bar">
            <div class="mini-app-dot"></div><div class="mini-app-dot"></div><div class="mini-app-dot"></div>
            <div class="mini-app-title">Migration Readiness Assessment</div>
          </div>
          <div class="mini-app-body">
            <div class="mini-app-header">How ready is your organization?</div>
            <div class="mini-app-controls">
              <div class="mini-app-tab active">Assessment</div>
              <div class="mini-app-tab">Results</div>
              <div class="mini-app-tab">Benchmarks</div>
            </div>
            <div class="mini-app-sliders">
              <div class="mini-app-slider-row">
                <div class="mini-app-slider-label">Data Vol.</div>
                <div class="mini-app-track"><div class="mini-app-fill" style="width:72%; background: linear-gradient(90deg, #8560A8, #5674B9);"><div class="mini-app-thumb" style="border-color: #8560A8;"></div></div></div>
                <div class="mini-app-slider-val" style="color:#8560A8;">72</div>
              </div>
              <div class="mini-app-slider-row">
                <div class="mini-app-slider-label">Complexity</div>
                <div class="mini-app-track"><div class="mini-app-fill" style="width:58%; background: linear-gradient(90deg, #5674B9, #448CCB);"><div class="mini-app-thumb" style="border-color: #5674B9;"></div></div></div>
                <div class="mini-app-slider-val" style="color:#5674B9;">58</div>
              </div>
              <div class="mini-app-slider-row">
                <div class="mini-app-slider-label">Team Size</div>
                <div class="mini-app-track"><div class="mini-app-fill" style="width:85%; background: linear-gradient(90deg, #448CCB, #00BFF3);"><div class="mini-app-thumb" style="border-color: #00BFF3;"></div></div></div>
                <div class="mini-app-slider-val" style="color:#00BFF3;">85</div>
              </div>
            </div>
            <div class="mini-app-result">
              <div class="mini-app-metric">
                <div class="mini-app-metric-val" style="color:#8560A8;">7.2</div>
                <div class="mini-app-metric-label">Readiness</div>
              </div>
              <div class="mini-app-metric">
                <div class="mini-app-metric-val" style="color:#00BFF3;">4.8mo</div>
                <div class="mini-app-metric-label">Est. Timeline</div>
              </div>
              <div class="mini-app-metric">
                <div class="mini-app-metric-val" style="color:#5674B9;">Med</div>
                <div class="mini-app-metric-label">Risk Level</div>
              </div>
            </div>
            <div class="mini-app-chart">
              <div class="mini-app-bar-item" style="height:35%; background:rgba(133,96,168,0.3);"></div>
              <div class="mini-app-bar-item" style="height:55%; background:rgba(133,96,168,0.4);"></div>
              <div class="mini-app-bar-item" style="height:45%; background:rgba(86,116,185,0.35);"></div>
              <div class="mini-app-bar-item" style="height:70%; background:rgba(86,116,185,0.45);"></div>
              <div class="mini-app-bar-item" style="height:60%; background:rgba(68,140,203,0.4);"></div>
              <div class="mini-app-bar-item" style="height:85%; background:rgba(0,191,243,0.45);"></div>
              <div class="mini-app-bar-item" style="height:75%; background:rgba(0,191,243,0.5);"></div>
              <div class="mini-app-bar-item" style="height:92%; background:rgba(0,191,243,0.55);"></div>
            </div>
            <div class="mini-app-cta">Download Full Report</div>
          </div>
        </div>
      </div>

      <!-- Remaining features grid -->
      <div class="features-grid" style="margin-top: 24px;">
        <div class="feature-card reveal reveal-delay-1">
          <div class="feature-icon"><svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><circle cx="20" cy="20" r="12"/><path d="m29 29 11 11"/><path d="M20 15l1.2 3 3 0.8-3 0.8-1.2 3-1.2-3-3-0.8 3-0.8z" stroke-width="1.2"/></svg></div>
          <h3>Strategic SEO &amp; AEO Foundation</h3>
          <p>Keyword research, search intent mapping, and Answer Engine Optimization so the piece is built to rank in both traditional search and AI-powered results.</p>
        </div>
        <div class="feature-card reveal reveal-delay-2">
          <div class="feature-icon"><svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M32 6l10 10-20 20-10 2 2-10z"/><path d="M24 14l10 10"/><path d="M6 42h20"/></svg></div>
          <h3>Long-Form Editorial</h3>
          <p>Expert-level written content that establishes authority and covers the topic with genuine depth.</p>
        </div>
        <div class="feature-card reveal reveal-delay-3">
          <div class="feature-icon"><svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><rect x="6" y="8" width="28" height="20" rx="1"/><path d="M6 15h28"/><path d="M11 21h14M11 25h10" stroke-opacity="0.5"/><path d="M30 30l4 4 3-1-3 8-4-11z" fill="currentColor" stroke="currentColor" stroke-width="1"/></svg></div>
          <h3>Custom Design &amp; UX</h3>
          <p>Bespoke layout and visual design tailored to the topic — not a generic blog template.</p>
        </div>
        <div class="feature-card reveal reveal-delay-4">
          <div class="feature-icon"><svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><rect x="6" y="12" width="24" height="22" rx="2"/><path d="m16 18 8 5-8 5z" fill="currentColor" stroke="none"/><path d="M36 18c2 2 2 10 0 12M40 15c3 3 3 15 0 18" stroke-opacity="0.7"/></svg></div>
          <h3>Embedded Media</h3>
          <p>Original video production, data visualizations, or infographics woven into the experience.</p>
        </div>
        <div class="feature-card reveal reveal-delay-5">
          <div class="feature-icon"><svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8h36l-12 14v16l-12-6V22z"/><circle cx="36" cy="34" r="5"/><path d="M34 34h4M36 32v4" stroke-opacity="0.6"/></svg></div>
          <h3>Conversion Architecture</h3>
          <p>Strategic CTAs, lead capture, and user journeys designed to turn attention into action.</p>
        </div>
        <div class="feature-card reveal reveal-delay-6">
          <div class="feature-icon"><svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M6 42h36"/><path d="M6 42V6"/><path d="M12 34l8-6 6 4 10-14 6 4"/><circle cx="42" cy="22" r="2.5" fill="currentColor" stroke="none"/><path d="M12 22h2M12 12h2" stroke-opacity="0.3"/></svg></div>
          <h3>Performance Analytics</h3>
          <p>Purpose-built for measurable outcomes — every application is structured to track engagement, demonstrate ROI, and prove its impact on rankings and traffic.</p>
        </div>
      </div>
    </div>
  </section>

  <div class="bce-angle"><svg viewBox="0 0 1440 60" preserveAspectRatio="none"><polygon points="0,60 1440,0 1440,60" fill="#252C3A"/></svg></div>

  

  <!-- MODULE 5 — WHY IT WORKS -->
  <section class="section-dark" aria-label="Why it works">
    <span class="bce-chapter" aria-hidden="true">04</span>
    <div class="bce-container">
      <span class="overline reveal">The Results</span>
      <h2 class="reveal">Engineered to Strengthen the<br>Signals That Matter</h2>
      <div class="benefits-grid">
        <div class="benefit-item reveal reveal-delay-1">
          <div class="benefit-icon"><svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><circle cx="24" cy="24" r="16"/><path d="M24 14v10l7 4"/><path d="M24 8v2M24 38v2M8 24h2M38 24h2" stroke-opacity="0.4"/></svg></div>
          <strong>Dwell Time &amp; Engagement Depth</strong>
          <span>Interactive, media-rich content keeps users on the page longer, sending strong quality signals to search engines.</span>
        </div>
        <div class="benefit-item reveal reveal-delay-2">
          <div class="benefit-icon"><svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"/><circle cx="36" cy="12" r="4"/><circle cx="24" cy="36" r="4"/><path d="M15 14l6 18M33 14l-6 18" stroke-opacity="0.55"/></svg></div>
          <strong>Social Sharing &amp; Distribution</strong>
          <span>Unique, visually compelling content gives people a reason to share — fueling organic reach beyond search.</span>
        </div>
        <div class="benefit-item reveal reveal-delay-3">
          <div class="benefit-icon"><svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M20 18h-4a6 6 0 0 0 0 12h4"/><path d="M28 18h4a6 6 0 0 1 0 12h-4"/><path d="M18 24h12"/></svg></div>
          <strong>Backlinks &amp; Earned Media</strong>
          <span>High-value content assets attract links naturally and give your outreach team something genuinely worth pitching.</span>
        </div>
        <div class="benefit-item reveal reveal-delay-4">
          <div class="benefit-icon"><svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M8 10h32a2 2 0 0 1 2 2v18a2 2 0 0 1-2 2H24l-8 8v-8H8a2 2 0 0 1-2-2V12a2 2 0 0 1 2-2z"/><path d="M17 21l4 4 10-10" stroke-width="1.5"/></svg></div>
          <strong>AEO Visibility</strong>
          <span>Structured, authoritative content is more likely to be cited by AI answer engines like ChatGPT, Gemini, and Perplexity.</span>
        </div>
        <div class="benefit-item reveal reveal-delay-5">
          <div class="benefit-icon"><svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M24 4l16 6v12c0 10-8 18-16 22-8-4-16-12-16-22V10z"/><path d="M18 24l4 4 10-10" stroke-width="1.5"/></svg></div>
          <strong>Brand Authority &amp; Trust</strong>
          <span>A single flagship piece can reposition your brand as the definitive resource on a topic.</span>
        </div>
        <div class="benefit-item reveal reveal-delay-6">
          <div class="benefit-icon"><svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><circle cx="22" cy="24" r="14"/><circle cx="22" cy="24" r="8"/><circle cx="22" cy="24" r="2.5" fill="currentColor" stroke="none"/><path d="M36 10L22 24"/><path d="M36 10h-6M36 10v6" stroke-opacity="0.7"/></svg></div>
          <strong>Conversions</strong>
          <span>Content designed with user journeys in mind doesn't just attract traffic — it converts it.</span>
        </div>
      </div>
    </div>
  </section>

  <div class="bce-angle"><svg viewBox="0 0 1440 60" preserveAspectRatio="none"><polygon points="0,0 1440,60 1440,60 0,60" fill="#f9f9fb"/></svg></div>

  

  <!-- MODULE 6 — EXAMPLE USE CASE -->
  <section class="section-light" aria-label="Example use case">
    <span class="bce-chapter" aria-hidden="true">05</span>
    <div class="bce-container">
      <span class="overline reveal">See It In Action</span>
      <h2 class="reveal">What This Looks Like in Practice</h2>
      <div class="use-case-layout">
        <div class="use-case-scenario reveal">
          <div class="scenario-label">Example Scenario</div>
          <p>A B2B SaaS company wants to own the topic "enterprise data migration" in organic search.</p>
          <p>Instead of publishing a standard 2,000-word blog post, we build a Bespoke Content Experience:</p>
        </div>
        <div class="use-case-components">
          <div class="component-item reveal reveal-delay-1">
            <svg class="check-icon" viewBox="0 0 22 22" fill="none"><rect x="1" y="1" width="20" height="20" stroke="#8560A8" stroke-width="1.5" fill="none"/><path d="M6 11l3.5 3.5 6.5-7" stroke="#8560A8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <p>A long-form editorial guide covering strategy, risks, and best practices — written by subject matter experts</p>
          </div>
          <div class="component-item reveal reveal-delay-2">
            <svg class="check-icon" viewBox="0 0 22 22" fill="none"><rect x="1" y="1" width="20" height="20" stroke="#8560A8" stroke-width="1.5" fill="none"/><path d="M6 11l3.5 3.5 6.5-7" stroke="#8560A8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <p>An interactive migration readiness assessment embedded directly in the page</p>
          </div>
          <div class="component-item reveal reveal-delay-3">
            <svg class="check-icon" viewBox="0 0 22 22" fill="none"><rect x="1" y="1" width="20" height="20" stroke="#8560A8" stroke-width="1.5" fill="none"/><path d="M6 11l3.5 3.5 6.5-7" stroke="#8560A8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <p>Custom data visualizations showing migration timelines, cost benchmarks, and failure rates</p>
          </div>
          <div class="component-item reveal reveal-delay-4">
            <svg class="check-icon" viewBox="0 0 22 22" fill="none"><rect x="1" y="1" width="20" height="20" stroke="#8560A8" stroke-width="1.5" fill="none"/><path d="M6 11l3.5 3.5 6.5-7" stroke="#8560A8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <p>Short-form video walkthroughs of each migration phase</p>
          </div>
          <div class="component-item reveal reveal-delay-5">
            <svg class="check-icon" viewBox="0 0 22 22" fill="none"><rect x="1" y="1" width="20" height="20" stroke="#8560A8" stroke-width="1.5" fill="none"/><path d="M6 11l3.5 3.5 6.5-7" stroke="#8560A8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <p>A downloadable planning checklist gated behind a lead capture form</p>
          </div>
          <div class="component-item reveal reveal-delay-6">
            <svg class="check-icon" viewBox="0 0 22 22" fill="none"><rect x="1" y="1" width="20" height="20" stroke="#8560A8" stroke-width="1.5" fill="none"/><path d="M6 11l3.5 3.5 6.5-7" stroke="#8560A8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <p>Full SEO and AEO optimization — structured data, intent mapping, and answer-engine-ready formatting</p>
          </div>
        </div>
      </div>

      <!-- Illustrated use case browser -->
      <div class="use-case-illustration reveal">
        <div class="uc-browser">
          <div class="uc-browser-bar">
            <div class="uc-dot"></div>
            <div class="uc-dot"></div>
            <div class="uc-dot"></div>
            <div class="uc-url-bar">yourbrand.com/enterprise-data-migration</div>
          </div>
          <div class="uc-page">
            <div class="uc-sidebar">
              <div class="uc-sidebar-item active">
                <div class="uc-sidebar-dot"></div>
                Overview
              </div>
              <div class="uc-sidebar-item">
                <div class="uc-sidebar-dot"></div>
                Strategy & Risks
              </div>
              <div class="uc-sidebar-item">
                <div class="uc-sidebar-dot"></div>
                Readiness Assessment
              </div>
              <div class="uc-sidebar-item">
                <div class="uc-sidebar-dot"></div>
                Cost Benchmarks
              </div>
              <div class="uc-sidebar-item">
                <div class="uc-sidebar-dot"></div>
                Video Walkthroughs
              </div>
              <div class="uc-sidebar-item">
                <div class="uc-sidebar-dot"></div>
                Planning Checklist
              </div>
            </div>
            <div class="uc-main">
              <div class="uc-content-row">
                <div class="uc-data-card">
                  <div class="uc-data-label">Avg Migration Timeline</div>
                  <div class="uc-data-value" style="color: #8560A8;">6.4 mo</div>
                  <div class="uc-mini-chart">
                    <div class="uc-mini-bar" style="height: 40%; background: rgba(133,96,168,0.3);"></div>
                    <div class="uc-mini-bar" style="height: 65%; background: rgba(133,96,168,0.4);"></div>
                    <div class="uc-mini-bar" style="height: 55%; background: rgba(86,116,185,0.35);"></div>
                    <div class="uc-mini-bar" style="height: 80%; background: rgba(86,116,185,0.45);"></div>
                    <div class="uc-mini-bar" style="height: 70%; background: rgba(0,191,243,0.4);"></div>
                    <div class="uc-mini-bar" style="height: 90%; background: rgba(0,191,243,0.5);"></div>
                  </div>
                </div>
                <div class="uc-data-card">
                  <div class="uc-data-label">Failure Rate (Unprepared)</div>
                  <div class="uc-data-value" style="color: #00BFF3;">38%</div>
                  <div class="uc-mini-chart">
                    <div class="uc-mini-bar" style="height: 85%; background: rgba(0,191,243,0.45);"></div>
                    <div class="uc-mini-bar" style="height: 70%; background: rgba(0,191,243,0.4);"></div>
                    <div class="uc-mini-bar" style="height: 55%; background: rgba(86,116,185,0.35);"></div>
                    <div class="uc-mini-bar" style="height: 40%; background: rgba(86,116,185,0.3);"></div>
                    <div class="uc-mini-bar" style="height: 30%; background: rgba(133,96,168,0.25);"></div>
                    <div class="uc-mini-bar" style="height: 20%; background: rgba(133,96,168,0.2);"></div>
                  </div>
                </div>
              </div>
              <div class="uc-text-area">
                <div class="uc-text-row"></div>
                <div class="uc-text-row"></div>
                <div class="uc-text-row"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="result-callout reveal">
        <p><strong>The result:</strong> a single content asset that ranks, earns backlinks, gets shared, generates leads, and positions the brand as the authority on the topic.</p>
      </div>
    </div>
  </section>

  <!-- ANGLED DIVIDER -->
  <div class="bce-angle"><svg viewBox="0 0 1440 60" preserveAspectRatio="none"><polygon points="0,0 1440,60 1440,60 0,60" fill="#fff"/></svg></div>

  <!-- MODULE 6.5 — CASE STUDIES -->
  <section class="case-studies" aria-label="Case studies">
    <span class="bce-chapter" aria-hidden="true">05a</span>
    <div class="bce-container">
      <div class="case-intro reveal">
        <span class="overline">The Receipts</span>
        <h2>Built and shipping in the wild</h2>
        <p style="font-size: 17px; color: #5a6276;">A few recent Bespoke Content Experiences we've built for clients. Click any to walk through the strategy, design decisions, and results.</p>
      </div>
      <div class="case-grid">
        <a href="#" class="case-card reveal reveal-delay-1" data-tilt style="--case-color: #8560A8;">
          <div class="case-thumb">
            <div class="case-thumb-browser">
              <div class="case-thumb-bar">
                <span class="case-thumb-dot"></span><span class="case-thumb-dot"></span><span class="case-thumb-dot"></span>
              </div>
              <div class="case-thumb-body">
                <span class="case-thumb-bar-thick"></span>
                <span class="case-thumb-line w-80"></span>
                <span class="case-thumb-line w-50"></span>
                <span class="case-thumb-block"></span>
              </div>
            </div>
          </div>
          <div class="case-body">
            <span class="case-eyebrow">B2B SaaS · Enterprise</span>
            <h3>Migration Readiness: ranking #1 for a primary keyword in 90 days</h3>
            <p>A full content experience around "enterprise data migration" — interactive readiness assessment, expert editorial, original benchmarks — built to dominate both traditional search and AI answer engines.</p>
            <div class="case-meta">
              <div><strong>+412%</strong>Organic traffic</div>
              <div><strong>#1</strong>Target keyword</div>
              <div><strong>47</strong>Backlinks earned</div>
            </div>
            <span class="case-link">View case study &rarr;</span>
          </div>
        </a>
        <a href="#" class="case-card reveal reveal-delay-2" data-tilt style="--case-color: #00BFF3;">
          <div class="case-thumb">
            <div class="case-thumb-browser">
              <div class="case-thumb-bar">
                <span class="case-thumb-dot"></span><span class="case-thumb-dot"></span><span class="case-thumb-dot"></span>
              </div>
              <div class="case-thumb-body">
                <span class="case-thumb-bar-thick" style="background: #00BFF3;"></span>
                <span class="case-thumb-line w-80"></span>
                <span class="case-thumb-line w-50"></span>
                <span class="case-thumb-block"></span>
              </div>
            </div>
          </div>
          <div class="case-body">
            <span class="case-eyebrow">Ecommerce · DTC</span>
            <h3>Product education hub: turning a buying guide into an AEO citation magnet</h3>
            <p>An interactive product-matching experience paired with deep editorial on the category — engineered to rank, get cited by ChatGPT and Perplexity, and feed qualified leads into the sales funnel.</p>
            <div class="case-meta">
              <div><strong>18x</strong>AI citations</div>
              <div><strong>8m</strong>Dwell time</div>
              <div><strong>+38%</strong>Conversion rate</div>
            </div>
            <span class="case-link">View case study &rarr;</span>
          </div>
        </a>
      </div>
    </div>
  </section>



  <!-- MODULE 7 — PROCESS -->
  <section class="section-white" aria-label="Our process">
    <span class="bce-chapter" aria-hidden="true">06</span>
    <div class="bce-container">
      <span class="overline reveal">Our Process</span>
      <h2 class="reveal">How We Build It</h2>
      <div class="process-steps">
        <div class="process-step reveal">
          <div class="step-marker"><div class="step-number">01</div></div>
          <div class="step-content">
            <h3>Keyword &amp; Topic Selection</h3>
            <span class="step-desc">We pinpoint the target keyword your app will be built around — analyzing search intent, competitive gaps, and business value to choose the topic worth owning.</span>
          </div>
        </div>
        <div class="process-step reveal">
          <div class="step-marker"><div class="step-number">02</div></div>
          <div class="step-content">
            <h3>App Concept &amp; UX Design</h3>
            <span class="step-desc">We architect a custom web application around your keyword — defining the data models, user flows, and interactive features that will make your page an indispensable resource, not just another article.</span>
          </div>
        </div>
        <div class="process-step reveal">
          <div class="step-marker"><div class="step-number">03</div></div>
          <div class="step-content">
            <h3>Custom App Development</h3>
            <span class="step-desc">Our developers build your bespoke application from scratch — fully custom code, not a template or off-the-shelf widget — purpose-built to engage users around your target keyword.</span>
          </div>
        </div>
        <div class="process-step reveal">
          <div class="step-marker"><div class="step-number">04</div></div>
          <div class="step-content">
            <h3>Editorial &amp; Content Production</h3>
            <span class="step-desc">Our writers craft the supporting editorial content that wraps the application — expert-level copy that contextualizes the tool, builds authority, and drives organic visibility.</span>
          </div>
        </div>
        <div class="process-step reveal">
          <div class="step-marker"><div class="step-number">05</div></div>
          <div class="step-content">
            <h3>SEO, AEO &amp; Technical Integration</h3>
            <span class="step-desc">Schema markup, semantic structure, and AI-engine optimization are coded directly into the app — so search engines and AI platforms understand exactly what your page does.</span>
          </div>
        </div>
        <div class="process-step reveal">
          <div class="step-marker"><div class="step-number">06</div></div>
          <div class="step-content">
            <h3>Deploy &amp; Measure</h3>
            <span class="step-desc">We deliver the finished application ready to publish on your domain, with performance tracking to prove its impact on rankings, traffic, and engagement.</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- MODULE 9 — CTA CLOSE -->
  <section class="cta-close" aria-label="Get in touch">
    <div class="bce-container">
      <h2 class="reveal">Ready to build something<br>worth ranking for?</h2>
      <p class="reveal">Every Bespoke Content Experience starts with a conversation about your goals, your audience, and the topics that matter most to your business.</p>
      <a href="/contact-stretch-creative/" class="btn-white reveal">Get in touch &rarr;</a>
    </div>
  </section>
</div>

<script>
// Scroll reveal
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) entry.target.classList.add('visible');
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

    // Sticky nav
    const nav = document.getElementById('siteNav');
    let ticking = false;
    window.addEventListener('scroll', () => {
      if (!ticking) {
        window.requestAnimationFrame(() => {
          nav.classList.toggle('scrolled', window.scrollY > 60);
          const shapes = document.querySelector('.hero-shapes');
          if (shapes && window.scrollY < window.innerHeight) {
            shapes.style.transform = `translateY(${window.scrollY * 0.15}px)`;
          }
          ticking = false;
        });
        ticking = true;
      }
    });

  // Hero grid parallax (mouse-follow)
  (function () {
    var heroGrid = document.getElementById('bceHeroGrid');
    if (!heroGrid) return;
    var hero = heroGrid.parentElement;
    hero.addEventListener('mousemove', function (e) {
      var rect = hero.getBoundingClientRect();
      var x = ((e.clientX - rect.left) / rect.width - 0.5) * 20;
      var y = ((e.clientY - rect.top) / rect.height - 0.5) * 20;
      heroGrid.style.transform = 'translate(' + (-x).toFixed(1) + 'px, ' + (-y).toFixed(1) + 'px)';
    });
    hero.addEventListener('mouseleave', function () {
      heroGrid.style.transform = '';
    });
  })();

  // 3D tilt + cursor glow on [data-tilt]
  (function () {
    var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reduce || 'ontouchstart' in window) return;
    document.querySelectorAll('[data-tilt]').forEach(function (card) {
      var rafId = null;
      card.addEventListener('mousemove', function (e) {
        if (rafId) return;
        rafId = requestAnimationFrame(function () {
          rafId = null;
          var rect = card.getBoundingClientRect();
          var x = (e.clientX - rect.left) / rect.width;
          var y = (e.clientY - rect.top) / rect.height;
          var rx = (0.5 - y) * 4;
          var ry = (x - 0.5) * 4;
          card.style.transform = 'perspective(1400px) rotateX(' + rx.toFixed(2) + 'deg) rotateY(' + ry.toFixed(2) + 'deg) translate3d(0,-3px,0)';
          card.style.setProperty('--glow-x', (x * 100).toFixed(1) + '%');
          card.style.setProperty('--glow-y', (y * 100).toFixed(1) + '%');
        });
      });
      card.addEventListener('mouseleave', function () { card.style.transform = ''; });
    });
  })();

</script>

<?php get_footer(); ?>
