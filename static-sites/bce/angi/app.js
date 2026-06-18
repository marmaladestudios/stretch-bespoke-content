/* =========================================================================
   Bathroom Builder
   Vanilla JS implementation of the new studio-style UX prototype.
   ========================================================================= */

const ANGI_BATHROOM_HUB = 'https://www.angi.com/remodeling/bathroom-remodeling';

const COMPONENTS = {
  shower: {
    label: 'Shower / tub',
    iconKey: 'shower',
    blurb: 'Tub, walk-in, or combo',
    size: { w: 3, h: 3 },
    variants: ['Tub / shower combo', 'Walk-in shower', 'Freestanding tub'],
    tiers: { good: [2200, 3800], better: [4200, 7500], best: [8500, 14000] },
    addons: [
      { key: 'glass', label: 'Glass door', desc: 'Frameless enclosure', lo: 900, hi: 2400 },
      { key: 'surround', label: 'Tile surround', desc: 'Wall tile beyond base', lo: 1600, hi: 4500 },
      { key: 'spray', label: 'Body sprays', desc: 'Extra shower controls', lo: 350, hi: 1200 },
    ],
    articles: [
      { title: 'Shower vs. Bathtub: Which Is Right for Your Bathroom?', meta: 'Stephanie Mickelson - Apr 05, 2026', tag: 'Guide', image: './assets/modern-small-bathroom-rain-shower.jpg' },
      { title: 'Does a House Really Need a Bathtub?', meta: 'Lauren Bongard - May 03, 2026', tag: 'Guide', image: './assets/bathroom-double-vanity-bathtub-shower.jpg' },
      { title: 'How Much Does a Wet Room Cost? [2026 Data]', meta: 'Mariel Loveland - May 02, 2026', tag: 'Cost', image: './assets/interior-small-bathroom.jpg' },
    ],
  },
  vanity: {
    label: 'Vanity & sink',
    iconKey: 'vanity',
    blurb: 'Cabinet, top, and basin',
    size: { w: 4, h: 2 },
    variants: ['Single vanity', 'Double vanity', 'Floating vanity'],
    tiers: { good: [600, 1400], better: [1600, 3200], best: [3600, 7000] },
    addons: [
      { key: 'double', label: 'Double sink', desc: 'Two basins', lo: 800, hi: 2200 },
      { key: 'stone', label: 'Stone countertop', desc: 'Quartz or granite', lo: 500, hi: 1800 },
    ],
    articles: [
      { title: '7 Types of Bathroom Countertop Materials to Upgrade Your Space', meta: 'Mizuki Hisaka - May 02, 2026', tag: 'Materials', image: './assets/bathroom-double-vanity-bathtub-shower.jpg' },
      { title: 'How to Measure for a Bathroom Mirror', meta: 'Allie Ogletree - May 03, 2026', tag: 'Guide', image: './assets/white-bathroom.jpg' },
      { title: 'How Much Do Bathroom Cabinets Cost? [2026 Data]', meta: 'Deirdre Sullivan - May 03, 2026', tag: 'Cost', image: './assets/interior-small-bathroom.jpg' },
    ],
  },
  tile: {
    label: 'Tile & walls',
    iconKey: 'tile',
    blurb: 'Tile and waterproofing',
    size: { w: 3, h: 2 },
    variants: ['Shower surround', 'Floor tile', 'Backsplash', 'Accent wall'],
    tiers: { good: [1200, 2600], better: [2900, 5200], best: [5600, 11000] },
    addons: [
      { key: 'accent', label: 'Accent band', desc: 'Feature tile inlay', lo: 400, hi: 1500 },
      { key: 'niche', label: 'Tiled niche', desc: 'Recessed shelf', lo: 200, hi: 650 },
    ],
    articles: [
      { title: '8 Smart Ways to Update Bathroom Tile Without Replacing It', meta: 'Heather Ayer - May 03, 2026', tag: 'Guide', image: './assets/white-bathroom.jpg' },
      { title: 'Pros and Cons of Penny Tile for a Bathroom Remodel', meta: 'Paige Bennett - May 03, 2026', tag: 'Materials', image: './assets/interior-small-bathroom.jpg' },
      { title: '30 Small Bathroom Remodel Ideas to Make It Feel Spacious', meta: 'Mariel Loveland - May 5, 2026', tag: 'Guide', image: './assets/modern-small-bathroom-rain-shower.jpg' },
    ],
  },
  floor: {
    label: 'Flooring',
    iconKey: 'floor',
    blurb: 'Tile, vinyl, or stone floor',
    size: { w: 4, h: 4 },
    variants: ['Main floor', 'Shower pan'],
    tiers: { good: [600, 1500], better: [1700, 3200], best: [3500, 7000] },
    addons: [
      { key: 'heated', label: 'Heated floor', desc: 'In-floor warming', lo: 900, hi: 2600 },
    ],
    articles: [
      { title: 'Small Bathroom Dimensions: How to Fit Style and Function Into Every Square Foot', meta: 'Lauren Bongard - May 03, 2026', tag: 'Guide', image: './assets/budget-friendly-small-bathroom-ideas.jpg' },
      { title: 'How Much Does It Cost to Remodel a Small Bathroom? [2026 Data]', meta: 'Samantha Hawrylack - May 02, 2026', tag: 'Cost', image: './assets/interior-small-bathroom.jpg' },
      { title: 'What Is a Wet Room Bathroom?', meta: 'C.E. Larusso - May 02, 2026', tag: 'Guide', image: './assets/modern-small-bathroom-rain-shower.jpg' },
    ],
  },
  toilet: {
    label: 'Toilet',
    iconKey: 'toilet',
    blurb: 'Standard or comfort height',
    size: { w: 1.5, h: 2.5 },
    variants: ['Standard', 'Wall-hung', 'Smart toilet'],
    tiers: { good: [250, 600], better: [700, 1400], best: [1700, 3800] },
    addons: [
      { key: 'bidet', label: 'Bidet seat', desc: 'Smart washlet', lo: 400, hi: 1200 },
    ],
    articles: [
      { title: '12 Types of Toilets to Upgrade to in Your Bathroom Remodel', meta: 'Samantha Hawrylack - May 5, 2026', tag: 'Guide', image: './assets/interior-small-bathroom.jpg' },
      { title: '8 Smart Toilet Seats to Elevate Your Bathroom', meta: 'Allie Ogletree - May 02, 2026', tag: 'Guide', image: './assets/family-bathroom.jpg' },
      { title: '10 Tech Bathroom Features You Didn\'t Know You Needed', meta: 'Paige Bennett - Mar 06, 2026', tag: 'Guide', image: './assets/budget-friendly-small-bathroom-ideas.jpg' },
    ],
  },
  lighting: {
    label: 'Lighting & electrical',
    iconKey: 'light',
    blurb: 'Fixtures, outlets, and wiring',
    size: { w: 1.5, h: 1.5 },
    variants: ['Vanity lights', 'Recessed cans', 'Ceiling fixture'],
    tiers: { good: [450, 1100], better: [1200, 2600], best: [2900, 5500] },
    addons: [
      { key: 'recessed', label: 'Recessed lights', desc: 'Can lighting', lo: 400, hi: 1400 },
      { key: 'fan', label: 'Exhaust fan', desc: 'Quiet vent fan', lo: 250, hi: 700 },
    ],
    articles: [
      { title: '20 Spa Bathroom Ideas That Boost Enjoyment and Home Value', meta: 'Deirdre Sullivan - May 02, 2026', tag: 'Guide', image: './assets/modern-small-bathroom-rain-shower.jpg' },
      { title: '31 Chic Modern Bathroom Ideas to Inspire Your Remodel', meta: 'Mariel Loveland - May 02, 2026', tag: 'Guide', image: './assets/bathroom-double-vanity-bathtub-shower.jpg' },
      { title: 'Bathroom Remodeling Trends That Are Here to Stay', meta: 'Stacey Marcus - May 02, 2026', tag: 'Guide', image: './assets/white-bathroom.jpg' },
    ],
  },
  plumbing: {
    label: 'Move plumbing',
    iconKey: 'plumbing',
    blurb: 'Relocate supply and drains',
    size: { w: 2, h: 2 },
    variants: ['Relocate drain', 'Move supply lines', 'Add new line'],
    tiers: { good: [800, 1800], better: [1800, 4500], best: [4500, 9000] },
    addons: [],
    articles: [
      { title: '12 Important Questions to Ask Bathroom Remodeling Contractors', meta: 'Stephanie Mickelson - Apr 09, 2026', tag: 'Guide', image: './assets/family-bathroom.jpg' },
      { title: 'Who to Hire for a Bathroom Remodel Project', meta: 'Gemma Johnstone - May 5, 2026', tag: 'Guide', image: './assets/budget-friendly-small-bathroom-ideas.jpg' },
      { title: 'How Long Does a Bathroom Remodel Take?', meta: 'Becca Lewis - May 02, 2026', tag: 'Guide', image: './assets/bathroom-double-vanity-bathtub-shower.jpg' },
    ],
  },
};

const ORDER = ['shower', 'vanity', 'tile', 'floor', 'toilet', 'lighting', 'plumbing'];
const TIER_LABEL = { good: 'Good', better: 'Better', best: 'Best' };
const TIER_SHORT = { good: 'Budget', better: 'Mid-range', best: 'High-end' };
const DEFAULT_POS = {
  shower: { x: 0.26, y: 0.34 },
  vanity: { x: 0.72, y: 0.30 },
  tile: { x: 0.50, y: 0.18 },
  floor: { x: 0.50, y: 0.74 },
  toilet: { x: 0.82, y: 0.72 },
  lighting: { x: 0.26, y: 0.72 },
  plumbing: { x: 0.52, y: 0.50 },
};

const LOCATIONS = [
  { key: 'national', label: 'United States', st: '', mult: 1.00 },
  { key: 'seattle', label: 'Seattle', st: 'WA', mult: 1.18 },
  { key: 'la', label: 'Los Angeles', st: 'CA', mult: 1.22 },
  { key: 'phoenix', label: 'Phoenix', st: 'AZ', mult: 0.98 },
  { key: 'denver', label: 'Denver', st: 'CO', mult: 1.06 },
  { key: 'austin', label: 'Austin', st: 'TX', mult: 1.02 },
  { key: 'chicago', label: 'Chicago', st: 'IL', mult: 1.08 },
  { key: 'atlanta', label: 'Atlanta', st: 'GA', mult: 0.96 },
  { key: 'miami', label: 'Miami', st: 'FL', mult: 1.05 },
  { key: 'ny', label: 'New York', st: 'NY', mult: 1.35 },
];

const DEFAULT_RECOMMENDATIONS = [
  {
    title: 'How Much Does It Cost to Remodel a Small Bathroom? [2026 Data]',
    meta: 'Cost guide',
    tag: 'Cost',
    image: './assets/interior-small-bathroom.jpg',
    reason: 'Get a baseline before you compare local quotes.',
  },
  {
    title: 'Who to Hire for a Bathroom Remodel Project',
    meta: 'Hiring guide',
    tag: 'Guide',
    image: './assets/family-bathroom.jpg',
    reason: 'Understand which pros handle each part of the scope.',
  },
  {
    title: '12 Important Questions to Ask Bathroom Remodeling Contractors',
    meta: 'Pro checklist',
    tag: 'Checklist',
    image: './assets/budget-friendly-small-bathroom-ideas.jpg',
    reason: 'Use these questions when you request project quotes.',
  },
];

const state = {
  roomW: 10,
  roomH: 8,
  placed: [{
    id: 1,
    type: 'shower',
    name: 'Tub / shower combo',
    nx: DEFAULT_POS.shower.x,
    ny: DEFAULT_POS.shower.y,
    w: 3,
    h: 3,
    tier: 'better',
    addons: {},
  }],
  selectedId: 1,
  location: 'national',
  locOpen: false,
  view: 'plan',
};

let uid = 2;
let drag = null;

const $ = selector => document.querySelector(selector);
const fmtMoney = n => '$' + Math.round(n).toLocaleString('en-US');
const fmtNum = n => Number.isInteger(n) ? String(n) : String(Math.round(n * 100) / 100);
const clamp = (n, min, max) => Math.max(min, Math.min(max, n));
const snap = (n, step = 0.25) => Math.round(n / step) * step;

function iconSvg(iconKey) {
  return `<svg aria-hidden="true"><use href="#ic-${iconKey}"></use></svg>`;
}

function escapeHtml(value) {
  return String(value)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;');
}

function currentLocation() {
  return LOCATIONS.find(loc => loc.key === state.location) || LOCATIONS[0];
}

function locationLabel(loc = currentLocation()) {
  return loc.key === 'national' ? 'United States' : `${loc.label}, ${loc.st}`;
}

function locationNote(loc = currentLocation()) {
  if (loc.key === 'national') {
    return 'Showing national-average pricing. Pick a metro to see local labor rates and pro matching prompts.';
  }
  const pct = Math.round(Math.abs(loc.mult - 1) * 100);
  return `Costs in ${loc.label} run about ${pct}% ${loc.mult >= 1 ? 'above' : 'below'} the national average.`;
}

function isAreaDriven(type) {
  return type === 'tile' || type === 'floor';
}

function sizeMultiplier(item) {
  if (!isAreaDriven(item.type)) return 1;
  const base = COMPONENTS[item.type].size;
  return Math.max(0.2, (item.w * item.h) / (base.w * base.h));
}

function baseRange(item) {
  const c = COMPONENTS[item.type];
  const tier = c.tiers[item.tier];
  const sizeMult = sizeMultiplier(item);
  return [tier[0] * sizeMult, tier[1] * sizeMult];
}

function itemRange(item, withLocation = true) {
  const c = COMPONENTS[item.type];
  const mult = withLocation ? currentLocation().mult : 1;
  const range = baseRange(item);
  c.addons.forEach(addon => {
    if (item.addons[addon.key]) {
      range[0] += addon.lo;
      range[1] += addon.hi;
    }
  });
  return [range[0] * mult, range[1] * mult];
}

function estimateRange() {
  return state.placed.reduce((sum, item) => {
    const [lo, hi] = itemRange(item);
    return [sum[0] + lo, sum[1] + hi];
  }, [0, 0]);
}

function rangeText(lo, hi) {
  return `${fmtMoney(lo)}–${fmtMoney(hi)}`;
}

function componentCount(type) {
  return state.placed.filter(item => item.type === type).length;
}

function placedTypes() {
  return [...new Set(state.placed.map(item => item.type))];
}

function selectedItem() {
  return state.placed.find(item => item.id === state.selectedId) || null;
}

function projectScopeLabel() {
  const count = state.placed.length;
  if (!count) return 'your bathroom plan';
  const labels = placedTypes().map(type => COMPONENTS[type].label.toLowerCase());
  if (labels.length === 1) return labels[0];
  if (labels.length === 2) return `${labels[0]} and ${labels[1]}`;
  return `${labels.slice(0, -1).join(', ')}, and ${labels[labels.length - 1]}`;
}

function recommendationItems(limit = 4) {
  const selected = selectedItem();
  const orderedTypes = [
    ...(selected ? [selected.type] : []),
    ...placedTypes(),
    ...ORDER,
  ];
  const seenTypes = [...new Set(orderedTypes)];
  const seenTitles = new Set();
  const items = [];

  seenTypes.forEach(type => {
    const component = COMPONENTS[type];
    if (!component) return;
    component.articles.forEach((article, index) => {
      if (seenTitles.has(article.title) || items.length >= limit) return;
      seenTitles.add(article.title);
      items.push({
        ...article,
        reason: index === 0
          ? `Recommended because your plan includes ${component.label.toLowerCase()}.`
          : `Helpful background for ${component.label.toLowerCase()} decisions.`,
      });
    });
  });

  DEFAULT_RECOMMENDATIONS.forEach(article => {
    if (seenTitles.has(article.title) || items.length >= limit) return;
    seenTitles.add(article.title);
    items.push(article);
  });

  return items;
}

function primaryRecommendation() {
  return recommendationItems(1)[0] || DEFAULT_RECOMMENDATIONS[0];
}

function scopeItemsText() {
  const count = state.placed.length;
  return `${count} scoped item${count === 1 ? '' : 's'}`;
}

function nextName(type) {
  const c = COMPONENTS[type];
  if (!c.variants.length) return c.label;
  const used = state.placed.filter(item => item.type === type).map(item => item.name);
  return c.variants.find(variant => !used.includes(variant)) || c.variants[0];
}

function clampItem(item) {
  item.w = clamp(item.w, 0.5, state.roomW);
  item.h = clamp(item.h, 0.5, state.roomH);
  item.nx = clamp(item.nx, (item.w / state.roomW) / 2, 1 - (item.w / state.roomW) / 2);
  item.ny = clamp(item.ny, (item.h / state.roomH) / 2, 1 - (item.h / state.roomH) / 2);
  return item;
}

function createItem(type, nx, ny) {
  const c = COMPONENTS[type];
  const item = {
    id: uid++,
    type,
    name: nextName(type),
    nx,
    ny,
    w: c.size.w,
    h: c.size.h,
    tier: 'better',
    addons: {},
  };
  return clampItem(item);
}

function addItem(type, nx, ny) {
  const fallback = DEFAULT_POS[type] || { x: 0.5, y: 0.5 };
  const offset = (componentCount(type) % 4) * 0.05;
  const item = createItem(
    type,
    nx ?? clamp(fallback.x + offset, 0.12, 0.88),
    ny ?? clamp(fallback.y + offset, 0.12, 0.88),
  );
  state.placed.push(item);
  state.selectedId = item.id;
  renderAll();
}

function removeItem(id) {
  state.placed = state.placed.filter(item => item.id !== id);
  if (state.selectedId === id) {
    state.selectedId = state.placed.length ? state.placed[state.placed.length - 1].id : null;
  }
  renderAll();
}

function canvasRect() {
  return $('#planCanvas').getBoundingClientRect();
}

function pointToNorm(clientX, clientY, item) {
  const rect = canvasRect();
  const nx = (clientX - rect.left) / rect.width;
  const ny = (clientY - rect.top) / rect.height;
  if (!item) return { nx, ny };
  return {
    nx: clamp(nx, (item.w / state.roomW) / 2, 1 - (item.w / state.roomW) / 2),
    ny: clamp(ny, (item.h / state.roomH) / 2, 1 - (item.h / state.roomH) / 2),
  };
}

function snapNormX(nx) {
  return snap(nx * state.roomW) / state.roomW;
}

function snapNormY(ny) {
  return snap(ny * state.roomH) / state.roomH;
}

function isInsideCanvas(clientX, clientY) {
  const rect = canvasRect();
  return clientX >= rect.left && clientX <= rect.right && clientY >= rect.top && clientY <= rect.bottom;
}

function applyCanvasMetrics(roomW, roomH) {
  const canvas = $('#planCanvas');
  const ratio = roomW / roomH;
  const canvasWidth = ratio >= 1 ? 100 : clamp(ratio * 116, 54, 88);
  canvas.style.setProperty('--grid-x', `${100 / roomW}%`);
  canvas.style.setProperty('--grid-y', `${100 / roomH}%`);
  canvas.style.setProperty('--grid-x-half', `${50 / roomW}%`);
  canvas.style.setProperty('--grid-y-half', `${50 / roomH}%`);
  canvas.style.setProperty('--room-w', roomW);
  canvas.style.setProperty('--room-h', roomH);
  canvas.style.setProperty('--canvas-aspect', `${roomW} / ${roomH}`);
  canvas.style.setProperty('--canvas-width', `${canvasWidth}%`);
  $('#canvasWidthLabel').textContent = `${fmtNum(roomW)} ft`;
  $('#canvasHeightLabel').textContent = `${fmtNum(roomH)} ft`;
}

function updateCanvasGrid() {
  applyCanvasMetrics(state.roomW, state.roomH);
}

function previewRoomDimensions() {
  const roomW = parseFloat($('#roomWidth').value);
  const roomH = parseFloat($('#roomHeight').value);
  if (Number.isNaN(roomW) || Number.isNaN(roomH)) return;
  applyCanvasMetrics(clamp(snap(roomW, 0.5), 4, 40), clamp(snap(roomH, 0.5), 4, 40));
}

function renderPalette() {
  $('#componentPalette').innerHTML = ORDER.map(type => {
    const c = COMPONENTS[type];
    const count = componentCount(type);
    const status = count
      ? `<span class="palette-count">${count > 1 ? `${count} on plan` : 'On plan'}</span>`
      : '<span class="palette-action">+ Add</span>';
    return `
      <button class="palette-card${count ? ' is-active' : ''}" type="button" data-action="palette" data-type="${type}">
        <span class="palette-icon">${iconSvg(c.iconKey)}</span>
        <span class="palette-label">${escapeHtml(c.label)}</span>
        ${status}
      </button>
    `;
  }).join('');
}

function renderRoomControls() {
  $('#roomWidth').value = fmtNum(state.roomW);
  $('#roomHeight').value = fmtNum(state.roomH);
  $('#roomSqft').textContent = fmtNum(state.roomW * state.roomH);
  updateCanvasGrid();
}

function renderLocations() {
  const loc = currentLocation();
  $('#locationLabel').textContent = locationLabel(loc);
  $('#locationNote').textContent = locationNote(loc);
  $('#locationToggle').setAttribute('aria-expanded', String(state.locOpen));
  $('#locationMenu').hidden = !state.locOpen;
  $('#locationMenu').innerHTML = LOCATIONS.map(option => {
    const pct = Math.round(Math.abs(option.mult - 1) * 100);
    const sub = option.key === 'national'
      ? 'National average'
      : `${option.st} - ${option.mult >= 1 ? '+' : '-'}${pct}% vs national`;
    return `
      <button class="location-option${option.key === state.location ? ' is-active' : ''}" type="button" data-action="location" data-location="${option.key}" role="option" aria-selected="${option.key === state.location}">
        <span class="location-option__mark">${option.key === state.location ? '&#10003;' : ''}</span>
        <span>
          <span class="location-option__label">${escapeHtml(option.key === 'national' ? 'United States' : option.label)}</span>
          <span class="location-option__sub">${escapeHtml(sub)}</span>
        </span>
      </button>
    `;
  }).join('');
}

function renderCanvas() {
  $('#emptyCanvas').hidden = state.placed.length > 0;
  $('#placedItems').innerHTML = state.placed.map((item, index) => {
    const c = COMPONENTS[item.type];
    const selected = item.id === state.selectedId;
    const wPct = (item.w / state.roomW) * 100;
    const hPct = (item.h / state.roomH) * 100;
    const z = item.type === 'floor' ? (selected ? 9 : 2) : (selected ? 999 : 20 + index);
    return `
      <article
        class="plan-item ${item.type === 'floor' ? 'floor-item' : ''}${selected ? ' is-selected' : ''}"
        data-id="${item.id}"
        data-type="${item.type}"
        tabindex="0"
        style="--x:${item.nx * 100};--y:${item.ny * 100};--w:${wPct};--h:${hPct};z-index:${z}">
        <span class="item-icon">${iconSvg(c.iconKey)}</span>
        <span class="item-name">${escapeHtml(item.name)}</span>
        <span class="item-dims">${fmtNum(item.w)} x ${fmtNum(item.h)} ft</span>
        <button class="item-remove" type="button" data-action="remove" data-id="${item.id}" aria-label="Remove ${escapeHtml(item.name)}">&times;</button>
        <button class="resize-handle" type="button" data-action="resize" data-id="${item.id}" aria-label="Resize ${escapeHtml(item.name)}"></button>
      </article>
    `;
  }).join('');
}

function renderEstimate() {
  const [lo, hi] = estimateRange();
  const n = state.placed.length;
  const loc = currentLocation();
  $('#estimateTotal').textContent = n ? rangeText(lo, hi) : 'Add fixtures to start';
  $('#placedCount').textContent = `${n} item${n === 1 ? '' : 's'} on your plan`;
  $('#estimateLocation').textContent = locationLabel(loc);
  $('#estimateNote').textContent = locationNote(loc);
  $('#quoteButton').textContent = n > 2 ? 'Get quotes for this scoped plan' : 'Get local quotes for this plan';
}

function renderViewTabs() {
  document.querySelectorAll('[data-action="view"]').forEach(button => {
    const active = button.dataset.view === state.view;
    button.classList.toggle('is-active', active);
    button.setAttribute('aria-selected', String(active));
  });
  document.querySelectorAll('.module-view').forEach(view => {
    const active = view.id === `${state.view}View`;
    view.hidden = !active;
    view.classList.toggle('is-active', active);
  });
}

function costDriverItems() {
  const drivers = [];
  const types = placedTypes();
  if (types.includes('plumbing')) {
    drivers.push({
      title: 'Plumbing changes',
      text: 'Moving drains or supply lines usually requires a local pro to confirm access, permits, and final labor.',
    });
  }
  if (types.includes('tile') || types.includes('floor')) {
    drivers.push({
      title: 'Tile quantity and waterproofing',
      text: 'Tile area, prep, and waterproofing details can shift both materials and installation time.',
    });
  }
  if (types.includes('shower')) {
    drivers.push({
      title: 'Shower enclosure details',
      text: 'Glass, surrounds, and fixture upgrades are common drivers behind a wider shower estimate.',
    });
  }
  if (types.includes('vanity')) {
    drivers.push({
      title: 'Vanity size and countertop',
      text: 'Double sinks, stone counters, and custom storage can change finish allowances quickly.',
    });
  }
  if (!drivers.length) {
    drivers.push({
      title: 'Scope completeness',
      text: 'Add fixtures, finishes, and any layout changes to make the estimate more useful for local pros.',
    });
  }
  drivers.push({
    title: 'Local labor rates',
    text: locationNote(),
  });
  return drivers.slice(0, 4);
}

function renderEstimateScreen() {
  const breakdown = $('#estimateBreakdown');
  const drivers = $('#estimateDrivers');
  const intro = $('#estimateViewIntro');
  if (!breakdown || !drivers || !intro) return;

  const [lo, hi] = estimateRange();
  intro.textContent = state.placed.length
    ? `${scopeItemsText()} in a ${fmtNum(state.roomW * state.roomH)} sq ft bathroom near ${locationLabel()}. Current range: ${rangeText(lo, hi)}.`
    : 'Add components to generate an itemized project estimate.';

  breakdown.innerHTML = state.placed.length ? state.placed.map(item => {
    const component = COMPONENTS[item.type];
    const [itemLo, itemHi] = itemRange(item);
    const addons = component.addons
      .filter(addon => item.addons[addon.key])
      .map(addon => addon.label);
    return `
      <article class="estimate-line-item">
        <span class="estimate-line-item__icon">${iconSvg(component.iconKey)}</span>
        <div>
          <h4>${escapeHtml(item.name)}</h4>
          <p>${escapeHtml(TIER_LABEL[item.tier])} finish - ${fmtNum(item.w)} x ${fmtNum(item.h)} ft${addons.length ? ` - ${escapeHtml(addons.join(', '))}` : ''}</p>
        </div>
        <strong>${rangeText(itemLo, itemHi)}</strong>
      </article>
    `;
  }).join('') : `
    <section class="estimate-empty">
      <h4>No scope added yet</h4>
      <p>Add fixtures from the Plan tab to build an itemized estimate.</p>
    </section>
  `;

  drivers.innerHTML = costDriverItems().map(driver => `
    <article class="estimate-driver">
      <h4>${escapeHtml(driver.title)}</h4>
      <p>${escapeHtml(driver.text)}</p>
    </article>
  `).join('');
}

function renderRecommendations() {
  const target = $('#recommendedGuides');
  const intro = $('#recommendationIntro');
  if (!target || !intro) return;

  const selected = selectedItem();
  const loc = currentLocation();
  const guides = recommendationItems(4);
  intro.textContent = selected
    ? `Based on ${selected.name.toLowerCase()} and your current ${locationLabel(loc)} estimate.`
    : 'Add fixtures to see guides matched to your exact remodel scope.';
  target.innerHTML = guides.map(article => `
    <a class="recommended-card" href="${ANGI_BATHROOM_HUB}" target="_blank" rel="noreferrer">
      <img src="${article.image}" alt="">
      <span class="recommended-card__tag">${escapeHtml(article.tag)}</span>
      <strong>${escapeHtml(article.title)}</strong>
      <p>${escapeHtml(article.reason)}</p>
    </a>
  `).join('');
}

function renderGuidesScreen() {
  const target = $('#guideCollections');
  const intro = $('#guidesViewIntro');
  if (!target || !intro) return;

  const types = placedTypes();
  intro.textContent = types.length
    ? `Showing guides for ${projectScopeLabel()} in your current plan.`
    : 'Add components to see guides matched to your remodel scope.';

  const collectionTypes = types.length ? types : ['shower', 'vanity', 'tile'];
  target.innerHTML = collectionTypes.map(type => {
    const component = COMPONENTS[type];
    const articles = component.articles.slice(0, 3).map(article => `
      <a class="guide-row" href="${ANGI_BATHROOM_HUB}" target="_blank" rel="noreferrer">
        <img src="${article.image}" alt="">
        <span>
          <em>${escapeHtml(article.tag)}</em>
          <strong>${escapeHtml(article.title)}</strong>
          <small>${escapeHtml(article.meta)}</small>
        </span>
      </a>
    `).join('');
    return `
      <section class="guide-collection">
        <div class="guide-collection__head">
          <span class="guide-collection__icon">${iconSvg(component.iconKey)}</span>
          <div>
            <h3>${escapeHtml(component.label)}</h3>
            <p>${escapeHtml(component.blurb)}</p>
          </div>
        </div>
        <div class="guide-row-list">${articles}</div>
      </section>
    `;
  }).join('');
}

function renderProHandoff() {
  const title = $('#proHandoffTitle');
  const copy = $('#proHandoffCopy');
  const chips = $('#scopeChips');
  const button = $('#proQuoteButton');
  if (!title || !copy || !chips || !button) return;

  const loc = currentLocation();
  const [lo, hi] = estimateRange();
  const count = state.placed.length;
  const scope = projectScopeLabel();
  const range = count ? rangeText(lo, hi) : 'an estimate';
  const local = loc.key === 'national' ? 'local' : `${loc.label} area`;

  title.textContent = count ? `Get ${local} quotes for this plan` : 'Get matched with bathroom remodelers near you';
  copy.textContent = count
    ? `Your ${scope} scope is ready to share with pros. Send the same plan to local remodelers so estimates start from ${range}.`
    : 'Build a project scope, then share it with local remodelers for more accurate quotes.';
  button.textContent = count ? 'Send this plan to local pros' : 'Find bathroom remodelers';

  const chipData = [
    `${count} scoped item${count === 1 ? '' : 's'}`,
    `${fmtNum(state.roomW * state.roomH)} sq ft bathroom`,
    locationLabel(loc),
    count ? range : 'Estimate pending',
  ];
  chips.innerHTML = chipData.map(chip => `<span>${escapeHtml(chip)}</span>`).join('');
}

function renderInspector() {
  const item = selectedItem();
  const wrap = $('#inspectorContent');
  if (!item) {
    wrap.innerHTML = `
      <section class="config-empty">
        <h2>Select a component</h2>
        <p>Click any item on the plan to configure finish level, dimensions, add-ons, and related guides.</p>
      </section>
    `;
    return;
  }

  const c = COMPONENTS[item.type];
  const [lo, hi] = itemRange(item);
  const spotlight = primaryRecommendation();
  const variants = c.variants.map(variant => `
    <button class="pill-button${item.name === variant ? ' is-active' : ''}" type="button" data-action="variant" data-id="${item.id}" data-value="${escapeHtml(variant)}">${escapeHtml(variant)}</button>
  `).join('');
  const tiers = ['good', 'better', 'best'].map(tier => `
    <button class="tier-button${item.tier === tier ? ' is-active' : ''}" type="button" data-action="tier" data-id="${item.id}" data-tier="${tier}">
      <span class="tier-label">${TIER_LABEL[tier]}</span>
      <span class="tier-short">${TIER_SHORT[tier]}</span>
    </button>
  `).join('');
  const addons = c.addons.length ? c.addons.map(addon => {
    const active = !!item.addons[addon.key];
    const price = rangeText(addon.lo * currentLocation().mult, addon.hi * currentLocation().mult);
    return `
      <button class="addon-row${active ? ' is-active' : ''}" type="button" data-action="addon" data-id="${item.id}" data-addon="${addon.key}">
        <span class="addon-check">${active ? '&#10003;' : ''}</span>
        <span>
          <span class="addon-title">${escapeHtml(addon.label)}</span>
          <span class="addon-desc">${escapeHtml(addon.desc)}</span>
        </span>
        <span class="addon-price">+${price}</span>
      </button>
    `;
  }).join('') : '<p class="coverage-note">No add-ons for this component yet.</p>';
  const articles = c.articles.map(article => `
    <a class="article-card" href="${ANGI_BATHROOM_HUB}" target="_blank" rel="noreferrer">
      <span class="article-thumb article-thumb--${article.tag}">${article.image ? `<img src="${article.image}" alt="">` : iconSvg(c.iconKey)}</span>
      <span>
        <span class="article-title">${escapeHtml(article.title)}</span>
        <span class="article-meta">${escapeHtml(article.meta)}</span>
      </span>
    </a>
  `).join('');

  wrap.innerHTML = `
    <section class="selected-config">
      <div class="selected-head">
        <span class="item-icon">${iconSvg(c.iconKey)}</span>
        <div>
          <h2>${escapeHtml(item.name)}</h2>
          <p>${escapeHtml(c.label)}</p>
        </div>
      </div>

      <section class="inspector-section inspector-section--variants" aria-label="Configuration">
        <div class="variant-row">${variants}</div>
      </section>

      <p class="selected-range"><span>This item</span><strong>${rangeText(lo, hi)}</strong></p>

      <a class="guide-spotlight" href="${ANGI_BATHROOM_HUB}" target="_blank" rel="noreferrer">
        <span class="guide-spotlight__thumb"><img src="${spotlight.image}" alt=""></span>
        <span class="guide-spotlight__body">
          <span class="guide-spotlight__kicker">Recommended guide</span>
          <strong>${escapeHtml(spotlight.title)}</strong>
          <span>${escapeHtml(spotlight.reason)}</span>
        </span>
      </a>

      <section class="inspector-section inspector-section--compact inspector-section--finish">
        <h3>Finish level</h3>
        <div class="tier-row">${tiers}</div>
      </section>

      <section class="inspector-section inspector-section--compact inspector-section--size">
        <div class="section-title-row">
          <h3>Size &amp; footprint</h3>
          <span class="sqft-badge">${fmtNum(item.w * item.h)} sq ft</span>
        </div>
        <div class="dimension-grid">
          <div class="dimension-control">
            <label for="itemWidth">Width</label>
            <div class="stepper">
              <button type="button" data-action="dim-step" data-id="${item.id}" data-axis="w" data-delta="-0.25">-</button>
              <input id="itemWidth" value="${fmtNum(item.w)}" inputmode="decimal" data-action="dim-input" data-id="${item.id}" data-axis="w" aria-label="Item width in feet">
              <button type="button" data-action="dim-step" data-id="${item.id}" data-axis="w" data-delta="0.25">+</button>
            </div>
          </div>
          <div class="dimension-control">
            <label for="itemHeight">Depth</label>
            <div class="stepper">
              <button type="button" data-action="dim-step" data-id="${item.id}" data-axis="h" data-delta="-0.25">-</button>
              <input id="itemHeight" value="${fmtNum(item.h)}" inputmode="decimal" data-action="dim-input" data-id="${item.id}" data-axis="h" aria-label="Item depth in feet">
              <button type="button" data-action="dim-step" data-id="${item.id}" data-axis="h" data-delta="0.25">+</button>
            </div>
          </div>
        </div>
        <p class="coverage-note">${fmtNum(item.w * item.h)} sq ft footprint${isAreaDriven(item.type) ? ' updates this cost range.' : '.'}</p>
      </section>

      <section class="inspector-section">
        <h3>Add-ons</h3>
        <div class="addon-list">${addons}</div>
      </section>

      <section class="inspector-section">
        <h3>Related guides</h3>
        <div class="article-list">${articles}</div>
      </section>

      <button class="danger-button" type="button" data-action="remove" data-id="${item.id}">Remove from plan</button>
    </section>
  `;
}

function renderAll() {
  renderViewTabs();
  renderPalette();
  renderRoomControls();
  renderLocations();
  renderCanvas();
  renderEstimate();
  renderEstimateScreen();
  renderRecommendations();
  renderGuidesScreen();
  renderProHandoff();
  renderInspector();
}

function findItem(id) {
  return state.placed.find(item => item.id === Number(id)) || null;
}

function setItemDimension(id, axis, value) {
  const item = findItem(id);
  if (!item || Number.isNaN(value)) return;
  const max = axis === 'w' ? state.roomW : state.roomH;
  item[axis] = clamp(snap(value), 0.5, max);
  clampItem(item);
  renderAll();
}

function commitRoomDimensions() {
  const roomW = parseFloat($('#roomWidth').value);
  const roomH = parseFloat($('#roomHeight').value);
  if (Number.isNaN(roomW) || Number.isNaN(roomH)) return;
  state.roomW = clamp(snap(roomW, 0.5), 4, 40);
  state.roomH = clamp(snap(roomH, 0.5), 4, 40);
  state.placed.forEach(clampItem);
  renderAll();
}

function beginPaletteDrag(type, e) {
  const ghost = document.createElement('div');
  ghost.className = 'drag-ghost';
  ghost.innerHTML = `
    <span class="ghost-icon">${iconSvg(COMPONENTS[type].iconKey)}</span>
    <span>${escapeHtml(COMPONENTS[type].label)}</span>
  `;
  document.body.appendChild(ghost);
  drag = {
    mode: 'palette',
    type,
    startX: e.clientX,
    startY: e.clientY,
    moved: false,
    ghost,
  };
  moveGhost(e.clientX, e.clientY);
}

function beginMoveDrag(item, e) {
  const rect = canvasRect();
  const cx = rect.left + item.nx * rect.width;
  const cy = rect.top + item.ny * rect.height;
  drag = {
    mode: 'move',
    id: item.id,
    startX: e.clientX,
    startY: e.clientY,
    offsetX: e.clientX - cx,
    offsetY: e.clientY - cy,
    moved: false,
  };
}

function beginResizeDrag(item, e) {
  drag = {
    mode: 'resize',
    id: item.id,
    startX: e.clientX,
    startY: e.clientY,
    tlx: item.nx - (item.w / state.roomW) / 2,
    tly: item.ny - (item.h / state.roomH) / 2,
    moved: false,
  };
}

function moveGhost(clientX, clientY) {
  if (!drag?.ghost) return;
  drag.ghost.style.left = `${clientX}px`;
  drag.ghost.style.top = `${clientY}px`;
}

function cleanupDrag() {
  drag?.ghost?.remove();
  drag = null;
  $('#planCanvas').classList.remove('is-over');
}

function handlePointerMove(e) {
  if (!drag) return;
  const dx = e.clientX - drag.startX;
  const dy = e.clientY - drag.startY;
  drag.moved = drag.moved || Math.hypot(dx, dy) > 5;

  if (drag.mode === 'palette') {
    moveGhost(e.clientX, e.clientY);
    $('#planCanvas').classList.toggle('is-over', isInsideCanvas(e.clientX, e.clientY));
    return;
  }

  const item = findItem(drag.id);
  if (!item) return;

  if (drag.mode === 'move') {
    const rect = canvasRect();
    const cx = e.clientX - drag.offsetX;
    const cy = e.clientY - drag.offsetY;
    const nx = snapNormX((cx - rect.left) / rect.width);
    const ny = snapNormY((cy - rect.top) / rect.height);
    item.nx = clamp(nx, (item.w / state.roomW) / 2, 1 - (item.w / state.roomW) / 2);
    item.ny = clamp(ny, (item.h / state.roomH) / 2, 1 - (item.h / state.roomH) / 2);
    renderAll();
    return;
  }

  if (drag.mode === 'resize') {
    const rect = canvasRect();
    const fx = (e.clientX - rect.left) / rect.width;
    const fy = (e.clientY - rect.top) / rect.height;
    const maxW = state.roomW - drag.tlx * state.roomW;
    const maxH = state.roomH - drag.tly * state.roomH;
    item.w = clamp(snap((fx - drag.tlx) * state.roomW), 0.5, maxW);
    item.h = clamp(snap((fy - drag.tly) * state.roomH), 0.5, maxH);
    item.nx = drag.tlx + (item.w / state.roomW) / 2;
    item.ny = drag.tly + (item.h / state.roomH) / 2;
    renderAll();
  }
}

function handlePointerUp(e) {
  if (!drag) return;
  if (drag.mode === 'palette') {
    if (drag.moved && isInsideCanvas(e.clientX, e.clientY)) {
      const item = createItem(drag.type, 0.5, 0.5);
      const pos = pointToNorm(e.clientX, e.clientY, item);
      item.nx = clamp(snapNormX(pos.nx), (item.w / state.roomW) / 2, 1 - (item.w / state.roomW) / 2);
      item.ny = clamp(snapNormY(pos.ny), (item.h / state.roomH) / 2, 1 - (item.h / state.roomH) / 2);
      state.placed.push(item);
      state.selectedId = item.id;
      renderAll();
    } else if (!drag.moved) {
      addItem(drag.type);
    }
  }
  cleanupDrag();
}

document.addEventListener('pointerdown', e => {
  if (e.pointerType === 'touch') return;
  const resize = e.target.closest('[data-action="resize"]');
  if (resize) {
    const item = findItem(resize.dataset.id);
    if (!item) return;
    state.selectedId = item.id;
    beginResizeDrag(item, e);
    e.preventDefault();
    e.stopPropagation();
    renderAll();
    return;
  }

  const planItem = e.target.closest('.plan-item');
  if (planItem && !e.target.closest('button, a, input')) {
    const item = findItem(planItem.dataset.id);
    if (!item) return;
    state.selectedId = item.id;
    beginMoveDrag(item, e);
    e.preventDefault();
    renderAll();
    return;
  }

  const palette = e.target.closest('[data-action="palette"]');
  if (palette) {
    beginPaletteDrag(palette.dataset.type, e);
    e.preventDefault();
  }
});

document.addEventListener('pointermove', handlePointerMove);
document.addEventListener('pointerup', handlePointerUp);
document.addEventListener('pointercancel', cleanupDrag);

document.addEventListener('click', e => {
  const actionTarget = e.target.closest('[data-action]');
  if (actionTarget) {
    const action = actionTarget.dataset.action;
    if (action === 'location') {
      state.location = actionTarget.dataset.location;
      state.locOpen = false;
      renderAll();
      return;
    }
    if (action === 'view') {
      state.view = actionTarget.dataset.view;
      renderAll();
      return;
    }
    if (action === 'remove') {
      removeItem(Number(actionTarget.dataset.id));
      return;
    }
    if (action === 'variant') {
      const item = findItem(actionTarget.dataset.id);
      if (item) item.name = actionTarget.dataset.value;
      renderAll();
      return;
    }
    if (action === 'tier') {
      const item = findItem(actionTarget.dataset.id);
      if (item) item.tier = actionTarget.dataset.tier;
      renderAll();
      return;
    }
    if (action === 'addon') {
      const item = findItem(actionTarget.dataset.id);
      if (item) item.addons[actionTarget.dataset.addon] = !item.addons[actionTarget.dataset.addon];
      renderAll();
      return;
    }
    if (action === 'dim-step') {
      const item = findItem(actionTarget.dataset.id);
      if (!item) return;
      const axis = actionTarget.dataset.axis;
      setItemDimension(item.id, axis, item[axis] + parseFloat(actionTarget.dataset.delta));
      return;
    }
  }

  const planItem = e.target.closest('.plan-item');
  if (planItem && !e.target.closest('button, a, input')) {
    state.selectedId = Number(planItem.dataset.id);
    renderAll();
  }
});

document.addEventListener('change', e => {
  if (e.target.id === 'roomWidth' || e.target.id === 'roomHeight') {
    commitRoomDimensions();
    return;
  }
  if (e.target.dataset.action === 'dim-input') {
    setItemDimension(e.target.dataset.id, e.target.dataset.axis, parseFloat(e.target.value));
  }
});

document.addEventListener('input', e => {
  if (e.target.id === 'roomWidth' || e.target.id === 'roomHeight') {
    previewRoomDimensions();
  }
});

document.addEventListener('keydown', e => {
  if (e.key === 'Enter' && e.target.matches('input')) {
    if (e.target.id === 'roomWidth' || e.target.id === 'roomHeight') {
      commitRoomDimensions();
    }
    e.target.blur();
  }
});

document.addEventListener('click', e => {
  if (e.target.id === 'locationToggle' || e.target.closest('#locationToggle')) {
    state.locOpen = !state.locOpen;
    renderAll();
    return;
  }
  if (state.locOpen && !e.target.closest('.location-picker')) {
    state.locOpen = false;
    renderAll();
  }
});

$('#locateButton').addEventListener('click', () => {
  state.location = state.location === 'national' ? 'seattle' : 'national';
  state.locOpen = false;
  renderAll();
});

function openDownloadModal() {
  const [lo, hi] = estimateRange();
  const modal = $('#briefModal');
  $('#briefSummary').textContent = state.placed.length
    ? `${state.placed.length} scoped item${state.placed.length === 1 ? '' : 's'} in a ${fmtNum(state.roomW)} x ${fmtNum(state.roomH)} ft bathroom near ${locationLabel()}. Estimated range: ${rangeText(lo, hi)}. Enter your info to download the PDF.`
    : 'Add fixtures to generate a contractor-ready PDF.';
  modal.hidden = false;
  $('#leadName').focus();
}

$('#quoteButton').addEventListener('click', openDownloadModal);
$('#downloadPlanButton').addEventListener('click', openDownloadModal);
$('#estimateDownloadButton').addEventListener('click', openDownloadModal);

$('#modalClose').addEventListener('click', () => {
  $('#briefModal').hidden = true;
});

$('#briefModal').addEventListener('click', e => {
  if (e.target.id === 'briefModal') $('#briefModal').hidden = true;
});

function planPdfLines(lead) {
  const [lo, hi] = estimateRange();
  return [
    'BATHROOM REMODEL PROJECT BRIEF',
    'Prepared with Angi',
    `Prepared for: ${lead.name} (${lead.email})`,
    '',
    `Room: ${fmtNum(state.roomW)} x ${fmtNum(state.roomH)} ft (${fmtNum(state.roomW * state.roomH)} sq ft)`,
    `Location: ${locationLabel()}`,
    `Estimated range: ${state.placed.length ? rangeText(lo, hi) : '$0'}`,
    '',
    'SCOPE',
    ...state.placed.map(item => {
      const [itemLo, itemHi] = itemRange(item);
      const c = COMPONENTS[item.type];
      const addonLabels = c.addons.filter(addon => item.addons[addon.key]).map(addon => addon.label);
      return `- ${item.name}: ${fmtNum(item.w)} x ${fmtNum(item.h)} ft, ${TIER_LABEL[item.tier]} tier, ${rangeText(itemLo, itemHi)}${addonLabels.length ? `, add-ons: ${addonLabels.join(', ')}` : ''}`;
    }),
    '',
    'RECOMMENDED GUIDES',
    ...recommendationItems(3).map(article => `- ${article.title}`),
    '',
    'NEXT STEP',
    'Share this scope with local pros so each estimate starts from the same project details.',
  ];
}

function wrapPdfText(text, maxChars = 78) {
  const words = String(text).replace(/\s+/g, ' ').trim().split(' ');
  const lines = [];
  let line = '';
  words.forEach(word => {
    const next = line ? `${line} ${word}` : word;
    if (next.length > maxChars && line) {
      lines.push(line);
      line = word;
    } else {
      line = next;
    }
  });
  if (line) lines.push(line);
  return lines.length ? lines : [''];
}

function escapePdfText(text) {
  return String(text)
    .replace(/[^\x20-\x7E]/g, '-')
    .replace(/\\/g, '\\\\')
    .replace(/\(/g, '\\(')
    .replace(/\)/g, '\\)');
}

function createPlanPdfBlob(lead) {
  const pageWidth = 612;
  const pageHeight = 792;
  const margin = 48;
  const pages = [];
  let y = pageHeight - margin;
  let stream = '';

  function newPage() {
    if (stream) pages.push(stream);
    stream = '';
    y = pageHeight - margin;
  }

  function addLine(text = '', options = {}) {
    const size = options.size || 11;
    const font = options.bold ? 'F2' : 'F1';
    const leading = options.leading || Math.round(size * 1.45);
    const maxChars = options.maxChars || (size >= 16 ? 44 : 78);
    const wrapped = text ? wrapPdfText(text, maxChars) : [''];
    wrapped.forEach(line => {
      if (y < margin + leading) newPage();
      stream += `BT /${font} ${size} Tf ${margin} ${y} Td (${escapePdfText(line)}) Tj ET\n`;
      y -= leading;
    });
  }

  planPdfLines(lead).forEach((line, index) => {
    if (index === 0) {
      addLine(line, { size: 20, bold: true, leading: 28, maxChars: 42 });
      return;
    }
    if (line === 'SCOPE' || line === 'RECOMMENDED GUIDES' || line === 'NEXT STEP') {
      addLine('');
      addLine(line, { size: 13, bold: true, leading: 18, maxChars: 60 });
      return;
    }
    addLine(line);
  });
  if (stream) pages.push(stream);

  const objects = [];
  const addObject = content => {
    objects.push(content);
    return objects.length;
  };
  addObject('<< /Type /Catalog /Pages 2 0 R >>');
  const pagesObjectIndex = addObject('');
  addObject('<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>');
  addObject('<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica-Bold >>');
  const pageRefs = [];
  pages.forEach(content => {
    const contentObject = addObject(`<< /Length ${content.length} >>\nstream\n${content}endstream`);
    const pageObject = addObject(`<< /Type /Page /Parent 2 0 R /MediaBox [0 0 ${pageWidth} ${pageHeight}] /Resources << /Font << /F1 3 0 R /F2 4 0 R >> >> /Contents ${contentObject} 0 R >>`);
    pageRefs.push(`${pageObject} 0 R`);
  });
  objects[pagesObjectIndex - 1] = `<< /Type /Pages /Kids [${pageRefs.join(' ')}] /Count ${pageRefs.length} >>`;

  let pdf = '%PDF-1.4\n';
  const offsets = [0];
  objects.forEach((object, index) => {
    offsets.push(pdf.length);
    pdf += `${index + 1} 0 obj\n${object}\nendobj\n`;
  });
  const xrefOffset = pdf.length;
  pdf += `xref\n0 ${objects.length + 1}\n0000000000 65535 f \n`;
  offsets.slice(1).forEach(offset => {
    pdf += `${String(offset).padStart(10, '0')} 00000 n \n`;
  });
  pdf += `trailer\n<< /Size ${objects.length + 1} /Root 1 0 R >>\nstartxref\n${xrefOffset}\n%%EOF`;
  return new Blob([pdf], { type: 'application/pdf' });
}

function downloadPlanPdf(lead) {
  const blob = createPlanPdfBlob(lead);
  const a = document.createElement('a');
  a.href = URL.createObjectURL(blob);
  a.download = 'bathroom-remodel-project-brief.pdf';
  document.body.appendChild(a);
  a.click();
  window.setTimeout(() => {
    URL.revokeObjectURL(a.href);
    a.remove();
  }, 1000);
}

$('#downloadLeadForm').addEventListener('submit', e => {
  e.preventDefault();
  if (!e.currentTarget.reportValidity()) return;
  downloadPlanPdf({
    name: $('#leadName').value.trim(),
    email: $('#leadEmail').value.trim(),
  });
  $('#briefModal').hidden = true;
});

renderAll();
