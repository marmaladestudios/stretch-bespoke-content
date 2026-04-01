<?php
/**
 * Template Name: Our Team
 */
get_header();
?>

<style>
/* ========================================
   OUR TEAM — PREMIUM TEMPLATE
   ======================================== */

html, body { overflow-x: hidden; }
.admin-bar .site-nav { top: 32px; }
@media (max-width: 782px) { .admin-bar .site-nav { top: 46px; } }

.v2-section { box-sizing: border-box; }
.v2-section *, .v2-section *::before, .v2-section *::after { box-sizing: inherit; }
.v2-section img { max-width: 100%; height: auto; display: block; }

.v2-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 40px;
  width: 100%;
}
.gradient-text {
  background: linear-gradient(135deg, #8560A8 0%, #5674B9 30%, #448CCB 60%, #00BFF3 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

/* ---------- REVEAL ANIMATIONS ---------- */
.v2-reveal {
  opacity: 0; transform: translateY(40px);
  transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}
.v2-reveal.visible { opacity: 1; transform: translateY(0); }
.v2-reveal-left {
  opacity: 0; transform: translateX(-60px);
  transition: opacity 0.9s cubic-bezier(0.16, 1, 0.3, 1), transform 0.9s cubic-bezier(0.16, 1, 0.3, 1);
}
.v2-reveal-left.visible { opacity: 1; transform: translateX(0); }
.v2-reveal-right {
  opacity: 0; transform: translateX(60px);
  transition: opacity 0.9s cubic-bezier(0.16, 1, 0.3, 1), transform 0.9s cubic-bezier(0.16, 1, 0.3, 1);
}
.v2-reveal-right.visible { opacity: 1; transform: translateX(0); }
.v2-delay-1 { transition-delay: 0.1s; }
.v2-delay-2 { transition-delay: 0.2s; }
.v2-delay-3 { transition-delay: 0.3s; }
.v2-delay-4 { transition-delay: 0.4s; }
.v2-delay-5 { transition-delay: 0.5s; }
.v2-delay-6 { transition-delay: 0.6s; }

.v2-angle-divider {
  position: absolute; bottom: -1px; left: 0; right: 0;
  z-index: 2; pointer-events: none; line-height: 0;
}
.v2-angle-divider svg { display: block; width: 100%; height: 60px; }

/* ========================================
   1. HERO
   ======================================== */
.team-hero {
  position: relative;
  min-height: 60vh;
  display: flex;
  align-items: center;
  background: linear-gradient(170deg, #1a1f2e 0%, #252C3A 40%, #1e2333 100%);
  overflow: hidden;
  padding: 140px 0 100px;
}
.team-hero::before {
  content: '';
  position: absolute;
  top: -50%; right: -20%;
  width: 80%; height: 150%;
  background: radial-gradient(ellipse at center, rgba(86,116,185,0.08) 0%, transparent 70%);
  pointer-events: none;
}
.team-hero::after {
  content: '';
  position: absolute;
  bottom: -30%; left: -10%;
  width: 60%; height: 80%;
  background: radial-gradient(ellipse at center, rgba(133,96,168,0.06) 0%, transparent 70%);
  pointer-events: none;
}
.team-hero-shapes {
  position: absolute; inset: 0;
  pointer-events: none; z-index: 1;
}
.team-shape {
  position: absolute; border-radius: 50%; opacity: 0.12;
}
.team-shape-1 { width: 300px; height: 300px; top: 10%; left: 5%; background: radial-gradient(circle, #8560A8, transparent); }
.team-shape-2 { width: 200px; height: 200px; top: 60%; left: 60%; background: radial-gradient(circle, #5674B9, transparent); }
.team-shape-3 { width: 150px; height: 150px; top: 20%; right: 10%; background: radial-gradient(circle, #00BFF3, transparent); }

.team-hero-content {
  position: relative; z-index: 2;
  text-align: center;
  max-width: 700px;
  margin: 0 auto;
}
.team-hero-content .v2-overline {
  font-family: 'Montserrat', sans-serif;
  font-size: 13px; font-weight: 400;
  letter-spacing: 3px; text-transform: uppercase;
  color: #00BFF3; margin-bottom: 20px; display: block;
}
.team-hero-content h1 {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(36px, 4.5vw, 58px);
  font-weight: 600; line-height: 1.1;
  color: #fff; margin: 0 0 24px; letter-spacing: -1px;
}
.team-hero-content .v2-subtitle {
  font-family: 'Assistant', sans-serif;
  font-size: 19px; font-weight: 300; line-height: 1.7;
  color: rgba(255,255,255,0.7);
  max-width: 520px; margin: 0 auto;
}

/* ========================================
   2. TEAM GRID
   ======================================== */
.team-grid-section {
  padding: 120px 0;
  background: #fff;
  position: relative;
}
.team-grid-heading {
  text-align: center;
  margin-bottom: 64px;
}
.team-grid-heading .v2-overline {
  font-family: 'Montserrat', sans-serif;
  font-size: 12px; letter-spacing: 3px;
  text-transform: uppercase; color: #00BFF3;
  display: block; margin-bottom: 16px;
}
.team-grid-heading h2 {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(32px, 4vw, 44px);
  font-weight: 600; color: #252C3A; margin: 0;
}
.team-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 32px;
}
.team-card {
  position: relative;
  background: #f9f9fb;
  border-radius: 12px;
  padding: 40px 24px 32px;
  text-align: center;
  transition: transform 0.4s cubic-bezier(0.16,1,0.3,1), box-shadow 0.4s ease;
  overflow: hidden;
  transform-style: preserve-3d;
}
.team-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 20px 60px rgba(37,44,58,0.12);
}
.team-avatar {
  width: 80px; height: 80px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: 'Poppins', sans-serif;
  font-size: 22px; font-weight: 600;
  color: #fff;
  margin: 0 auto 20px;
  position: relative;
  z-index: 1;
}
.team-card h3 {
  font-family: 'Poppins', sans-serif;
  font-size: 16px; font-weight: 600;
  color: #252C3A; margin: 0 0 6px;
  position: relative; z-index: 1;
}
.team-card .team-role {
  font-family: 'Assistant', sans-serif;
  font-size: 14px; color: #888;
  position: relative; z-index: 1;
}

/* Hover bio overlay */
.team-card-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, rgba(133,96,168,0.95), rgba(86,116,185,0.95));
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 24px;
  opacity: 0;
  transition: opacity 0.4s ease;
  border-radius: 12px;
  z-index: 2;
}
.team-card:hover .team-card-overlay { opacity: 1; }
.team-card-overlay p {
  font-family: 'Assistant', sans-serif;
  font-size: 15px; font-weight: 300;
  color: #fff; line-height: 1.7;
  text-align: center;
}

/* ========================================
   3. HIRING QUALITIES
   ======================================== */
.team-qualities {
  padding: 120px 0;
  background: #f9f9fb;
  position: relative;
}
.team-qualities-heading {
  text-align: center;
  margin-bottom: 64px;
}
.team-qualities-heading .v2-overline {
  font-family: 'Montserrat', sans-serif;
  font-size: 12px; letter-spacing: 3px;
  text-transform: uppercase; color: #00BFF3;
  display: block; margin-bottom: 16px;
}
.team-qualities-heading h2 {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(32px, 4vw, 44px);
  font-weight: 600; color: #252C3A; margin: 0;
}
.team-qualities-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 32px;
  max-width: 900px;
  margin: 0 auto;
}
.team-quality-card {
  background: #fff;
  border-radius: 12px;
  padding: 40px 36px;
  display: flex;
  gap: 24px;
  align-items: flex-start;
  transition: transform 0.4s cubic-bezier(0.16,1,0.3,1), box-shadow 0.4s ease;
  border: 1px solid rgba(0,0,0,0.04);
}
.team-quality-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 16px 48px rgba(37,44,58,0.1);
}
.team-quality-icon {
  width: 56px; height: 56px; min-width: 56px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, rgba(133,96,168,0.08), rgba(0,191,243,0.08));
}
.team-quality-icon svg { width: 28px; height: 28px; }
.team-quality-card h3 {
  font-family: 'Poppins', sans-serif;
  font-size: 20px; font-weight: 600;
  color: #252C3A; margin: 0 0 8px;
}
.team-quality-card p {
  font-family: 'Assistant', sans-serif;
  font-size: 16px; font-weight: 300;
  line-height: 1.7; color: #666; margin: 0;
}

/* ========================================
   4. CTA
   ======================================== */
.team-cta {
  padding: 100px 0;
  background: linear-gradient(135deg, #8560A8, #5674B9);
  text-align: center;
  position: relative;
  overflow: hidden;
}
.team-cta::before {
  content: '';
  position: absolute;
  top: 30%; left: 50%;
  transform: translate(-50%, -50%);
  width: 600px; height: 600px;
  background: radial-gradient(circle, rgba(0,191,243,0.12), transparent 70%);
  pointer-events: none;
}
.team-cta h2 {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(32px, 4vw, 48px);
  font-weight: 600; color: #fff;
  margin: 0 0 16px; position: relative;
}
.team-cta p {
  font-family: 'Assistant', sans-serif;
  font-size: 19px; font-weight: 300;
  color: rgba(255,255,255,0.7);
  margin-bottom: 36px; position: relative;
}
.team-cta .v2-btn-primary {
  display: inline-block;
  font-family: 'Poppins', sans-serif;
  font-size: 15px; font-weight: 500;
  color: #8560A8; background: #fff;
  padding: 16px 40px; border-radius: 6px;
  text-decoration: none;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  box-shadow: 0 4px 20px rgba(0,0,0,0.15);
  position: relative;
}
.team-cta .v2-btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 30px rgba(0,0,0,0.25);
}

/* ========================================
   RESPONSIVE
   ======================================== */
@media (max-width: 960px) {
  .team-grid { grid-template-columns: repeat(3, 1fr); }
  .team-qualities-grid { grid-template-columns: 1fr; }
}
@media (max-width: 768px) {
  .v2-container { padding: 0 24px; }
  .team-hero { padding: 100px 0 70px; }
  .team-hero-content h1 { font-size: 34px; }
  .team-grid-section { padding: 80px 0; }
  .team-grid { grid-template-columns: repeat(2, 1fr); }
  .team-qualities { padding: 80px 0; }
  .team-cta { padding: 70px 0; }
}
@media (max-width: 480px) {
  .v2-container { padding: 0 16px; }
  .team-grid { grid-template-columns: 1fr; }
}
</style>


<!-- ========================================
     1. HERO
     ======================================== -->
<section class="v2-section team-hero" aria-label="Hero">
  <div class="team-hero-shapes">
    <div class="team-shape team-shape-1"></div>
    <div class="team-shape team-shape-2"></div>
    <div class="team-shape team-shape-3"></div>
  </div>

  <div class="v2-container">
    <div class="team-hero-content">
      <span class="v2-overline v2-reveal v2-delay-1">Our Team</span>
      <h1 class="v2-reveal v2-delay-2">Clever. Skilled. <span class="gradient-text">Inspired.</span></h1>
      <p class="v2-subtitle v2-reveal v2-delay-3">We choose our creative teams carefully &mdash; hand-selecting talent that brings expertise, empathy, and enthusiasm to every project.</p>
    </div>
  </div>

  <div class="v2-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none">
      <polygon points="0,60 1440,0 1440,60" fill="#ffffff"/>
    </svg>
  </div>
</section>


<!-- ========================================
     2. TEAM GRID
     ======================================== -->
<section class="v2-section team-grid-section" aria-label="Team Members">
  <div class="v2-container">
    <div class="team-grid-heading">
      <span class="v2-overline v2-reveal">The People Behind the Work</span>
      <h2 class="v2-reveal v2-delay-1">Meet the <span class="gradient-text">Team</span></h2>
    </div>

    <div class="team-grid">
      <?php
      $team_members = array(
        array('name' => 'Chris Reid', 'role' => 'CEO', 'initials' => 'CR', 'color' => '#8560A8', 'bio' => 'Founder and visionary behind Stretch Creative. Chris built the company on a belief that content creation should be fair, collaborative, and exceptional.'),
        array('name' => 'Kelsi Carrell', 'role' => 'Head of Operations', 'initials' => 'KC', 'color' => '#5674B9', 'bio' => 'Kelsi keeps the engine running smoothly, coordinating teams, timelines, and deliverables with precision and care.'),
        array('name' => 'Jesse Galvon Reid', 'role' => 'CPO', 'initials' => 'JR', 'color' => '#448CCB', 'bio' => 'Jesse leads product development and innovation, ensuring Stretch stays ahead of the curve in content solutions.'),
        array('name' => 'Kristen Bailey', 'role' => 'Editor-In-Chief', 'initials' => 'KB', 'color' => '#00BFF3', 'bio' => 'Kristen sets the editorial standard across all content, ensuring quality, consistency, and brand voice alignment.'),
        array('name' => 'Josh Wong', 'role' => 'Director of Video Content', 'initials' => 'JW', 'color' => '#8560A8', 'bio' => 'Josh brings stories to life through video, leading our growing visual content capabilities with creativity and technical skill.'),
        array('name' => 'Jeanine Gordon', 'role' => 'Managing Editor', 'initials' => 'JG', 'color' => '#5674B9', 'bio' => 'Jeanine manages editorial workflows and writer relationships, keeping content on track and on brand.'),
        array('name' => 'Fiona Ferguson', 'role' => 'Community & Recruitment', 'initials' => 'FF', 'color' => '#448CCB', 'bio' => 'Fiona nurtures our creative community and finds the best new talent to join the Stretch family.'),
        array('name' => 'Kristyn Pacione', 'role' => 'Client Services', 'initials' => 'KP', 'color' => '#00BFF3', 'bio' => 'Kristyn is the bridge between our clients and our creative teams, ensuring every partnership thrives.'),
        array('name' => 'MacKenzie Sanford', 'role' => 'Editor + Resource Coordinator', 'initials' => 'MS', 'color' => '#8560A8', 'bio' => 'MacKenzie wears two hats with ease, editing content while coordinating the resources that make delivery seamless.'),
        array('name' => 'Jessica DeWolf', 'role' => 'Lead Editor', 'initials' => 'JD', 'color' => '#5674B9', 'bio' => 'Jessica brings sharp editorial instincts and attention to detail to every piece that passes through her hands.'),
        array('name' => 'Leslie Jeffries', 'role' => 'Senior Copywriter', 'initials' => 'LJ', 'color' => '#448CCB', 'bio' => 'Leslie crafts compelling copy that connects with audiences and drives results across industries.'),
        array('name' => 'Jodi Noblett', 'role' => 'Copywriter', 'initials' => 'JN', 'color' => '#00BFF3', 'bio' => 'Jodi brings creativity and curiosity to every brief, delivering content that engages and inspires.'),
      );

      $delay = 1;
      foreach ($team_members as $i => $member) :
        $d = ($delay % 6) + 1;
      ?>
      <div class="team-card v2-reveal v2-delay-<?php echo $d; ?>">
        <div class="team-avatar" style="background: <?php echo $member['color']; ?>;">
          <?php echo $member['initials']; ?>
        </div>
        <h3><?php echo $member['name']; ?></h3>
        <span class="team-role"><?php echo $member['role']; ?></span>
        <div class="team-card-overlay">
          <p><?php echo $member['bio']; ?></p>
        </div>
      </div>
      <?php
        $delay++;
      endforeach;
      ?>
    </div>
  </div>

  <div class="v2-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none">
      <polygon points="0,0 1440,60 1440,60 0,60" fill="#f9f9fb"/>
    </svg>
  </div>
</section>


<!-- ========================================
     3. HIRING QUALITIES
     ======================================== -->
<section class="v2-section team-qualities" aria-label="What We Look For">
  <div class="v2-container">
    <div class="team-qualities-heading">
      <span class="v2-overline v2-reveal">Join Us</span>
      <h2 class="v2-reveal v2-delay-1">What We <span class="gradient-text">Look For</span></h2>
    </div>

    <div class="team-qualities-grid">
      <div class="team-quality-card v2-reveal v2-delay-1">
        <div class="team-quality-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="#8560A8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
        </div>
        <div>
          <h3>Empathy</h3>
          <p>You love to tell a good story. You understand that behind every brief is a human audience that deserves authentic, meaningful content.</p>
        </div>
      </div>

      <div class="team-quality-card v2-reveal v2-delay-2">
        <div class="team-quality-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="#5674B9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
        </div>
        <div>
          <h3>Intuition</h3>
          <p>You really know how to read a room. You pick up on tone, context, and audience signals instinctively and adapt your voice accordingly.</p>
        </div>
      </div>

      <div class="team-quality-card v2-reveal v2-delay-3">
        <div class="team-quality-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="#448CCB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </div>
        <div>
          <h3>Curious</h3>
          <p>You go down the rabbit hole. You research thoroughly, ask great questions, and bring genuine interest to every topic you tackle.</p>
        </div>
      </div>

      <div class="team-quality-card v2-reveal v2-delay-4">
        <div class="team-quality-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="#00BFF3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
        </div>
        <div>
          <h3>Growth-Minded</h3>
          <p>You want to be a better writer. You welcome feedback, seek out learning opportunities, and constantly push to refine your craft.</p>
        </div>
      </div>
    </div>
  </div>

  <div class="v2-angle-divider">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none">
      <polygon points="0,60 1440,0 1440,60" fill="#8560A8"/>
    </svg>
  </div>
</section>


<!-- ========================================
     4. CTA
     ======================================== -->
<section class="v2-section team-cta" aria-label="Call to Action">
  <div class="v2-container">
    <h2 class="v2-reveal">Start Your Career with Stretch</h2>
    <p class="v2-reveal v2-delay-1">We&rsquo;re always looking for talented writers, editors, and creatives who want to do meaningful work. Let&rsquo;s connect.</p>
    <a href="/contact-stretch-creative/" class="v2-btn-primary v2-reveal v2-delay-2">Apply Now &rarr;</a>
  </div>
</section>


<script>
(function() {
  /* ---------- SCROLL REVEAL ---------- */
  var revealObserver = new IntersectionObserver(function(entries) {
    entries.forEach(function(entry) {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        revealObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });

  document.querySelectorAll('.v2-reveal, .v2-reveal-left, .v2-reveal-right').forEach(function(el) {
    revealObserver.observe(el);
  });

  /* ---------- 3D TILT ON TEAM CARDS ---------- */
  var isTouchDevice = 'ontouchstart' in window || navigator.maxTouchPoints > 0;
  var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  if (!isTouchDevice && !reducedMotion) {
    var tiltCards = document.querySelectorAll('.team-card');
    tiltCards.forEach(function(card) {
      card.addEventListener('mousemove', function(e) {
        var rect = card.getBoundingClientRect();
        var cx = rect.left + rect.width / 2;
        var cy = rect.top + rect.height / 2;
        var dx = (e.clientX - cx) / (rect.width / 2);
        var dy = (e.clientY - cy) / (rect.height / 2);
        card.style.transform = 'perspective(800px) rotateY(' + (dx * 6) + 'deg) rotateX(' + (-dy * 6) + 'deg) translateY(-8px)';
        card.style.transition = 'box-shadow 0.4s ease';
      });
      card.addEventListener('mouseleave', function() {
        card.style.transform = '';
        card.style.transition = 'transform 0.5s cubic-bezier(0.16,1,0.3,1), box-shadow 0.4s ease';
      });
    });
  }
})();
</script>

<?php get_footer(); ?>
