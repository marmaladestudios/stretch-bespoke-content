/**
 * Stretch Creative Theme — Interactions
 * No jQuery. Vanilla JS only.
 */

(function () {
  'use strict';

  // ── Scroll Reveal ──
  if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    const revealObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add('visible');
          }
        });
      },
      { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
    );
    document.querySelectorAll('.reveal').forEach((el) => revealObserver.observe(el));
  }

  // ── Sticky Nav ──
  const nav = document.getElementById('siteNav');
  if (nav) {
    let ticking = false;
    window.addEventListener('scroll', () => {
      if (!ticking) {
        window.requestAnimationFrame(() => {
          nav.classList.toggle('scrolled', window.scrollY > 60);
          ticking = false;
        });
        ticking = true;
      }
    }, { passive: true });
  }

  // ── Mobile Menu Toggle (AUD-005: touch-closable, backdrop, focus trap) ──
  const toggle = document.querySelector('.nav-toggle');
  const menu = document.getElementById('primaryMenu');
  if (toggle && menu) {
    const setMenuState = (open) => {
      menu.classList.toggle('open', open);
      toggle.classList.toggle('active', open);
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
      document.body.classList.toggle('nav-open', open);
      document.body.style.overflow = open ? 'hidden' : '';
      // Sub-menus are statically visible inside the open panel (AUD-006 interim)
      menu.querySelectorAll('a[aria-haspopup]').forEach((a) => {
        a.setAttribute('aria-expanded', open ? 'true' : 'false');
      });
    };

    toggle.addEventListener('click', () => {
      setMenuState(!menu.classList.contains('open'));
    });

    // Close on tap/click outside the panel — e.g. the dimmed backdrop (AUD-005)
    document.addEventListener('click', (e) => {
      if (!menu.classList.contains('open')) return;
      if (!(e.target instanceof Element)) return;
      if (e.target.closest('#primaryMenu') || e.target.closest('.nav-toggle')) return;
      setMenuState(false);
    });

    // Escape closes; Tab is trapped within toggle + panel links while open (AUD-005)
    document.addEventListener('keydown', (e) => {
      if (!menu.classList.contains('open')) return;

      if (e.key === 'Escape') {
        setMenuState(false);
        toggle.focus();
        return;
      }

      if (e.key !== 'Tab') return;
      const focusables = [toggle].concat(
        Array.prototype.slice.call(menu.querySelectorAll('a[href], button:not([disabled])'))
      );
      const first = focusables[0];
      const last = focusables[focusables.length - 1];
      if (focusables.indexOf(document.activeElement) === -1) {
        e.preventDefault();
        first.focus();
      } else if (e.shiftKey && document.activeElement === first) {
        e.preventDefault();
        last.focus();
      } else if (!e.shiftKey && document.activeElement === last) {
        e.preventDefault();
        first.focus();
      }
    });
  }

  // ── Nav Dropdown Accessibility (AUD-006 interim) ──
  // wp_nav_menu renders plain links; enhance parent items with aria-haspopup and
  // a JS-managed aria-expanded that mirrors the CSS :hover/:focus-within reveal.
  document.querySelectorAll('.nav-links > li').forEach((item) => {
    const link = item.querySelector(':scope > a');
    const sub = item.querySelector(':scope > .sub-menu');
    if (!link || !sub) return;

    const rootMenu = item.closest('.nav-links');
    link.setAttribute('aria-haspopup', 'true');
    link.setAttribute('aria-expanded', 'false');

    const setExpanded = (open) => {
      // Inside the open mobile panel sub-menus are always visible; state is
      // managed by setMenuState, so hover/focus must not toggle it off.
      if (rootMenu && rootMenu.classList.contains('open')) return;
      link.setAttribute('aria-expanded', open ? 'true' : 'false');
    };

    item.addEventListener('mouseenter', () => setExpanded(true));
    item.addEventListener('mouseleave', () => setExpanded(false));
    item.addEventListener('focusin', () => setExpanded(true));
    item.addEventListener('focusout', (e) => {
      if (!item.contains(e.relatedTarget)) setExpanded(false);
    });
  });

  // ── Accordion ──
  document.querySelectorAll('.accordion-trigger').forEach((trigger) => {
    trigger.addEventListener('click', () => {
      const panelId = trigger.getAttribute('aria-controls');
      const panel = panelId ? document.getElementById(panelId) : null;
      if (!panel) return; // AUD-034: missing/mistyped aria-controls target

      const isExpanded = trigger.getAttribute('aria-expanded') === 'true';
      trigger.setAttribute('aria-expanded', !isExpanded);

      if (!isExpanded) {
        panel.style.maxHeight = panel.scrollHeight + 'px';
      } else {
        panel.style.maxHeight = '0';
      }
    });
  });

  // ── Testimonials Carousel ──
  document.querySelectorAll('.testimonials-carousel').forEach((carousel) => {
    const track = carousel.querySelector('.testimonials-track');
    const dots = carousel.querySelectorAll('.testimonials-dot');
    let current = 0;
    const total = dots.length;
    if (!track || total === 0) return; // AUD-034: no track → throw; total 0 → NaN transform

    function goTo(index) {
      current = ((index % total) + total) % total;
      track.style.transform = 'translateX(-' + current * 100 + '%)';
      dots.forEach((d, i) => d.classList.toggle('active', i === current));
    }

    dots.forEach((dot, i) => {
      dot.addEventListener('click', () => goTo(i));
    });

    // Auto-advance every 6 seconds
    let interval = setInterval(() => goTo(current + 1), 6000);
    carousel.addEventListener('mouseenter', () => clearInterval(interval));
    carousel.addEventListener('mouseleave', () => {
      interval = setInterval(() => goTo(current + 1), 6000);
    });

    goTo(0);
  });

  // ── Blog Category Filters ──
  document.querySelectorAll('.blog-filter-btn').forEach((btn) => {
    btn.addEventListener('click', () => {
      const filter = btn.dataset.filter;
      const section = btn.closest('section');
      const grid = section ? section.querySelector('.blog-grid') : null;
      if (!grid) return; // AUD-034: button outside a <section> or no grid → throw

      // Update active button
      const filters = btn.closest('.blog-filters');
      if (filters) {
        filters.querySelectorAll('.blog-filter-btn').forEach((b) => b.classList.remove('active'));
      }
      btn.classList.add('active');

      // Filter cards
      grid.querySelectorAll('.blog-card').forEach((card) => {
        if (filter === 'all' || card.dataset.category === filter) {
          card.style.display = '';
        } else {
          card.style.display = 'none';
        }
      });
    });
  });
})();
