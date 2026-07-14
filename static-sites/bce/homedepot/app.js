/* =========================================================================
   Bathroom Builder
   Vanilla JS implementation of the new studio-style UX prototype.
   ========================================================================= */

const HOME_DEPOT_BATHROOM_HUB = 'https://www.homedepot.com/c/alp/home-decor-ideas-bathroom-ideas-projects/vy9i-jg0j-Zb9bd/4';

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
      { key: 'movePlumbing', label: 'Move plumbing', desc: 'Relocate shower drain or supply lines', lo: 800, hi: 2600 },
    ],
    articles: [
      { title: 'Best Shower Kits for Your Bathroom', meta: 'The Home Depot - Buying Guide', tag: 'Buying guide', image: './assets/modern-small-bathroom-rain-shower.jpg', url: 'https://www.homedepot.com/c/ab/best-shower-kits-for-your-bathroom/9ba683603be9fa5395fab90cfc483fb' },
      { title: 'Types of Shower Bases and Walls', meta: 'The Home Depot - Buying Guide', tag: 'Buying guide', image: './assets/bathroom-double-vanity-bathtub-shower.jpg', url: 'https://www.homedepot.com/c/ab/types-of-shower-bases-and-walls/9ba683603be9fa5395fab90083cbd15' },
      { title: 'Bathtub Buying Guide: Sizes and Types', meta: 'The Home Depot - Buying Guide', tag: 'Buying guide', image: './assets/interior-small-bathroom.jpg', url: 'https://www.homedepot.com/c/ab/types-of-bathtubs/9ba683603be9fa5395fab90209ab53e' },
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
      { key: 'movePlumbing', label: 'Move plumbing', desc: 'Relocate sink supply or drain lines', lo: 700, hi: 2200 },
    ],
    articles: [
      { title: 'Best Bathroom Vanities for Your Home', meta: 'The Home Depot - Buying Guide', tag: 'Buying guide', image: './assets/bathroom-double-vanity-bathtub-shower.jpg', url: 'https://www.homedepot.com/c/ab/best-bathroom-vanities-for-your-home/9ba683603be9fa5395fab903c286cbf' },
      { title: 'How to Measure a Bathroom Faucet', meta: 'The Home Depot - Project Guide', tag: 'Project guide', image: './assets/white-bathroom.jpg', url: 'https://www.homedepot.com/c/ah/how-to-measure-a-bathroom-faucet/9ba683603be9fa5395fab901531349ba' },
      { title: 'Bathroom Remodel Ideas', meta: 'The Home Depot - Inspiration Guide', tag: 'Ideas', image: './assets/interior-small-bathroom.jpg', url: 'https://www.homedepot.com/c/ai/bathroom-remodel-ideas/9ba683603be9fa5395fab9010b281c7d' },
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
      { title: 'Bathroom Tile Ideas', meta: 'The Home Depot - Inspiration Guide', tag: 'Ideas', image: './assets/white-bathroom.jpg', url: 'https://www.homedepot.com/c/ai/bathroom-tile-ideas/9ba683603be9fa5395fab909785801a' },
      { title: '12 Easy Steps: How to Tile a Shower', meta: 'The Home Depot - Project Guide', tag: 'Project guide', image: './assets/interior-small-bathroom.jpg', url: 'https://www.homedepot.com/c/ah/how-to-tile-a-shower-wall/9ba683603be9fa5395fab909044bc64' },
      { title: 'Bathroom Flooring Ideas', meta: 'The Home Depot - Inspiration Guide', tag: 'Ideas', image: './assets/modern-small-bathroom-rain-shower.jpg', url: 'https://www.homedepot.com/c/ai/bathroom-flooring-ideas/9ba683603be9fa5395fab901bc3ef3f5' },
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
      { title: 'Bathroom Flooring Ideas', meta: 'The Home Depot - Inspiration Guide', tag: 'Ideas', image: './assets/budget-friendly-small-bathroom-ideas.jpg', url: 'https://www.homedepot.com/c/ai/bathroom-flooring-ideas/9ba683603be9fa5395fab901bc3ef3f5' },
      { title: 'Bathroom Tile Ideas', meta: 'The Home Depot - Inspiration Guide', tag: 'Ideas', image: './assets/interior-small-bathroom.jpg', url: 'https://www.homedepot.com/c/ai/bathroom-tile-ideas/9ba683603be9fa5395fab909785801a' },
      { title: 'Bathroom Remodel Ideas', meta: 'The Home Depot - Inspiration Guide', tag: 'Ideas', image: './assets/modern-small-bathroom-rain-shower.jpg', url: 'https://www.homedepot.com/c/ai/bathroom-remodel-ideas/9ba683603be9fa5395fab9010b281c7d' },
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
      { key: 'movePlumbing', label: 'Move plumbing', desc: 'Relocate toilet flange or supply line', lo: 900, hi: 3000 },
    ],
    articles: [
      { title: 'Toilet Buying Guide', meta: 'The Home Depot - Buying Guide', tag: 'Buying guide', image: './assets/interior-small-bathroom.jpg', url: 'https://www.homedepot.com/c/ab/toilet-buying-guide/9ba683603be9fa5395fab903b4a0dc1' },
      { title: 'How to Measure for a Toilet Replacement', meta: 'The Home Depot - Project Guide', tag: 'Project guide', image: './assets/family-bathroom.jpg', url: 'https://www.homedepot.com/c/ah/how-to-measure-for-a-toilet-replacement/9ba683603be9fa5395fab901505c7436' },
      { title: 'How to Install a Bidet', meta: 'The Home Depot - Project Guide', tag: 'Project guide', image: './assets/budget-friendly-small-bathroom-ideas.jpg', url: 'https://www.homedepot.com/c/ah/how-to-install-a-bidet/9ba683603be9fa5395fab90130213482' },
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
      { title: 'How to Install Vanity Lights', meta: 'The Home Depot - Project Guide', tag: 'Project guide', image: './assets/modern-small-bathroom-rain-shower.jpg', url: 'https://www.homedepot.com/c/ah/how-to-install-vanity-lights/9ba683603be9fa5395fab902201f5e0' },
      { title: 'Bathroom Exhaust Fan Buying Guide', meta: 'The Home Depot - Buying Guide', tag: 'Buying guide', image: './assets/bathroom-double-vanity-bathtub-shower.jpg', url: 'https://www.homedepot.com/c/ab/bathroom-exhaust-fan-buying-guide/9ba683603be9fa5395fab90ab995103' },
      { title: 'How to Install a Bathroom Fan', meta: 'The Home Depot - Project Guide', tag: 'Project guide', image: './assets/white-bathroom.jpg', url: 'https://www.homedepot.com/c/ah/how-to-install-a-bathroom-fan/9ba683603be9fa5395fab904366e6ec' },
    ],
  },
};

const PRODUCTS = [
  { id: 'shower-alliance', type: 'shower', tier: 'good', brand: 'DreamLine', title: 'Alliance Pro BG 60 in. Semi-Frameless Sliding Shower Door', price: '$350.00', model: 'SDAB60A700VXX09', url: 'https://www.homedepot.com/p/321168371', image: './assets/products/shower-alliance.jpg', styles: ['modern-black', 'clean-white'], why: 'Matte black framing gives the room a crisp modern anchor.' },
  { id: 'shower-essence', type: 'shower', tier: 'better', brand: 'DreamLine', title: 'Essence 56–60 in. Frameless Sliding Shower Door', price: '$637.49', model: 'SHDR-6360760-09', url: 'https://www.homedepot.com/p/316239133', image: './assets/products/shower-essence.jpg', styles: ['modern-black', 'soft-carrara'], why: 'The clear glass keeps Carrara and white wall tile visible.' },
  { id: 'shower-encore', type: 'shower', tier: 'best', brand: 'DreamLine', title: 'Encore 56–60 in. Semi-Frameless Sliding Shower Door', price: '$713.00', model: 'SHDR-1660760-09', url: 'https://www.homedepot.com/p/302273336', image: './assets/products/shower-encore.jpg', styles: ['modern-black', 'warm-oak'], why: 'The strong black outline balances warm wood and pale stone.' },
  { id: 'vanity-everdean', type: 'vanity', tier: 'good', brand: 'Glacier Bay', title: 'Everdean 37 in. White Vanity with Cultured Marble Top', price: '$389.00', model: 'EV36P2-WH', url: 'https://www.homedepot.com/p/311606052', image: './assets/products/vanity-everdean.jpg', styles: ['clean-white', 'brushed-nickel'], why: 'The included white top makes an easy base for subway tile.' },
  { id: 'vanity-sonoma', type: 'vanity', tier: 'better', brand: 'Home Decorators Collection', title: 'Sonoma 36 in. Pebble Gray Vanity with Carrara Marble Top', price: '$1,349.00', model: 'Sonoma 36PG', url: 'https://www.homedepot.com/p/300711784', image: './assets/products/vanity-sonoma.jpg', styles: ['soft-carrara', 'brushed-nickel', 'coastal-gray'], why: 'Its included Carrara top establishes the stone palette for the room.' },
  { id: 'vanity-aberdeen', type: 'vanity', tier: 'best', brand: 'Home Decorators Collection', title: 'Aberdeen 48 in. Antique Oak Vanity with Carrara Marble Top', price: '$1,899.00', model: 'Aberdeen 48AO', url: 'https://www.homedepot.com/p/312613755', image: './assets/products/vanity-aberdeen.jpg', styles: ['warm-oak', 'soft-carrara', 'brushed-nickel'], why: 'Warm oak adds depth while the Carrara top ties into pale tile.' },
  { id: 'tile-restore-3x6', type: 'tile', tier: 'good', brand: 'Daltile', title: 'Restore Bright White 3 x 6 Ceramic Subway Tile', price: '$1.20 / sq. ft.', model: 'RE1536MODHD1P4', url: 'https://www.homedepot.com/p/302575146', image: './assets/products/tile-restore-3x6.jpg', styles: ['clean-white', 'modern-black'], why: 'A simple white field lets black fixtures or wood cabinetry lead.' },
  { id: 'tile-restore-4x12', type: 'tile', tier: 'better', brand: 'Daltile', title: 'Restore Bright White 4 x 12 Ceramic Subway Tile', price: '$2.05 / sq. ft.', model: 'RE15412MODHD1P2', url: 'https://www.homedepot.com/p/311781598', image: './assets/products/tile-restore-4x12.jpg', styles: ['clean-white', 'brushed-nickel'], why: 'The longer format feels updated and stays neutral with nickel.' },
  { id: 'tile-carrara-penny', type: 'tile', tier: 'best', brand: 'MSI', title: 'Carrara Penny Round Matte Porcelain Mosaic Tile', price: '$11.52 / sq. ft.', model: 'PT-PENRD-CARMC', url: 'https://www.homedepot.com/p/315654369', image: './assets/products/tile-carrara-penny.jpg', styles: ['soft-carrara', 'brushed-nickel'], why: 'The marble look repeats a Carrara vanity top without competing with it.' },
  { id: 'floor-breaksea', type: 'floor', tier: 'good', brand: 'TrafficMaster', title: 'Breaksea Island Waterproof Click Lock Vinyl Plank', price: '$1.49 / sq. ft.', model: 'VTRHDBREAIS6X36', url: 'https://www.homedepot.com/p/324087709', image: './assets/products/floor-breaksea.jpg', styles: ['coastal-gray', 'clean-white'], why: 'A cool gray plank works with white cabinetry and pebble-gray finishes.' },
  { id: 'floor-dusk-cherry', type: 'floor', tier: 'better', brand: 'Lifeproof', title: 'Dusk Cherry Waterproof Luxury Vinyl Plank', price: '$3.28 / sq. ft.', model: 'I06204LP', url: 'https://www.homedepot.com/p/311573441', image: './assets/products/floor-dusk-cherry.jpg', styles: ['warm-oak', 'modern-black'], why: 'The warm grain supports oak cabinetry and softens black metal.' },
  { id: 'floor-carrara', type: 'floor', tier: 'best', brand: 'MSI', title: 'Carrara 24 x 24 Matte Porcelain Marble Look Tile', price: '$3.55 / sq. ft.', model: 'NCAR2424-N', url: 'https://www.homedepot.com/p/316119204', image: './assets/products/floor-carrara.jpg', styles: ['soft-carrara', 'clean-white'], why: 'Large pale tiles continue the Carrara palette with fewer grout lines.' },
  { id: 'toilet-powerflush', type: 'toilet', tier: 'good', brand: 'Glacier Bay', title: 'Power Flush 2-Piece Round Toilet with Seat', price: '$129.00', model: 'N2450R-17', url: 'https://www.homedepot.com/p/338019410', image: './assets/products/toilet-powerflush.jpg', styles: ['clean-white'], why: 'A neutral white fixture fits every coordinated palette.' },
  { id: 'toilet-powerflush-tall', type: 'toilet', tier: 'better', brand: 'Glacier Bay', title: 'Power Flush Extra Tall Round Front Toilet', price: '$179.00', model: 'N2450R-19', url: 'https://www.homedepot.com/p/333499067', image: './assets/products/toilet-powerflush-tall.jpg', styles: ['clean-white'], why: 'The taller profile adds comfort without changing the finish story.' },
  { id: 'toilet-cadet3', type: 'toilet', tier: 'best', brand: 'American Standard', title: 'Cadet 3 Ovation One-Piece Tall Height Toilet', price: '$259.00', model: '2768.128.020', url: 'https://www.homedepot.com/p/203068464', image: './assets/products/toilet-cadet3.jpg', styles: ['clean-white', 'soft-carrara'], why: 'The one-piece silhouette suits the cleaner premium palette.' },
  { id: 'light-ayelen', type: 'lighting', tier: 'good', brand: 'Home Decorators Collection', title: 'Ayelen 22 in. 3-Light Brushed Nickel Vanity Light', price: '$59.97', model: '39109-HBU', url: 'https://www.homedepot.com/p/316719925', image: './assets/products/light-ayelen.jpg', styles: ['brushed-nickel', 'clean-white'], why: 'Brushed nickel quietly complements white cabinetry and tops.' },
  { id: 'light-halyn', type: 'lighting', tier: 'better', brand: 'Home Decorators Collection', title: 'Halyn 31 in. 4-Light Brushed Nickel Vanity Light', price: '$109.97', model: '1020HDCBNDI', url: 'https://www.homedepot.com/p/316691021', image: './assets/products/light-halyn.jpg', styles: ['brushed-nickel', 'soft-carrara', 'coastal-gray'], why: 'The clear glass and nickel coordinate with gray and Carrara finishes.' },
  { id: 'light-regan', type: 'lighting', tier: 'best', brand: 'Hampton Bay', title: 'Regan 29 in. 4-Light Matte Black Vanity Light', price: '$119.97', model: 'DSHD19574V3', url: 'https://www.homedepot.com/p/316719722', image: './assets/products/light-regan.jpg', styles: ['modern-black', 'warm-oak'], why: 'Matte black repeats the shower frame and defines warm wood vanities.' },
];

const VANITY_ACCESSORIES = [
  { label: 'Matching mirror', title: 'Sonoma 22 x 30 in. Pebble Gray Vanity Mirror', price: '$199.00', url: 'https://www.homedepot.com/p/300711825', styles: ['soft-carrara', 'coastal-gray'], forProduct: 'vanity-sonoma' },
  { label: 'Coordinating mirror', title: 'Glacier Bay 24 x 35 in. Brushed Nickel Vanity Mirror', price: '$99.97', url: 'https://www.homedepot.com/p/315953489', styles: ['brushed-nickel', 'clean-white'], forProduct: ['vanity-everdean', 'vanity-aberdeen'] },
  { label: 'Compatible 4 in. faucet', title: 'Glacier Bay Constructor Centerset Faucet in Brushed Nickel', price: '$29.98', url: 'https://www.homedepot.com/p/300687495', styles: ['brushed-nickel', 'clean-white'], forProduct: 'vanity-everdean' },
  { label: 'Compatible 8 in. faucet', title: 'Pfister Ladera Widespread Faucet in Brushed Nickel', price: '$127.71', url: 'https://www.homedepot.com/p/300721647', styles: ['brushed-nickel', 'soft-carrara'], forProduct: ['vanity-sonoma', 'vanity-aberdeen'] },
];

const ORDER = ['shower', 'vanity', 'tile', 'floor', 'toilet', 'lighting'];
const TIER_LABEL = { good: 'Essential', better: 'Upgraded', best: 'Premium' };
const TIER_SHORT = { good: 'Value', better: 'Most popular', best: 'Top tier' };
const DEFAULT_POS = {
  shower: { x: 0.26, y: 0.34 },
  vanity: { x: 0.72, y: 0.30 },
  tile: { x: 0.50, y: 0.18 },
  floor: { x: 0.50, y: 0.74 },
  toilet: { x: 0.82, y: 0.72 },
  lighting: { x: 0.26, y: 0.72 },
};

const OPENINGS = {
  door: {
    label: 'Door',
    blurb: 'Entry or closet clearance',
    length: 2.5,
    min: 2,
    max: 4,
  },
  window: {
    label: 'Window',
    blurb: 'Wall space and daylight',
    length: 3,
    min: 1.5,
    max: 6,
  },
};

const OPENING_ORDER = ['door', 'window'];
const WALLS = [
  { key: 'top', label: 'Top wall' },
  { key: 'right', label: 'Right wall' },
  { key: 'bottom', label: 'Bottom wall' },
  { key: 'left', label: 'Left wall' },
];
const DEFAULT_OPENINGS = {
  door: [
    { wall: 'bottom', offset: 0.22 },
    { wall: 'left', offset: 0.45 },
    { wall: 'right', offset: 0.72 },
  ],
  window: [
    { wall: 'top', offset: 0.70 },
    { wall: 'right', offset: 0.35 },
    { wall: 'left', offset: 0.30 },
  ],
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
    title: 'Bathroom Remodel Ideas',
    meta: 'Inspiration guide',
    tag: 'Ideas',
    image: './assets/interior-small-bathroom.jpg',
    url: 'https://www.homedepot.com/c/ai/bathroom-remodel-ideas/9ba683603be9fa5395fab9010b281c7d',
    reason: 'Get a baseline before you choose products or installation services.',
  },
  {
    title: 'How to DIY a Bathroom Remodel',
    meta: 'Advanced project guide',
    tag: 'Project guide',
    image: './assets/family-bathroom.jpg',
    url: 'https://www.homedepot.com/c/ah/how-to-remodel-a-bathroom/9ba683603be9fa5395fab901422e17f9',
    reason: 'Understand the sequence, tools, and materials the work requires.',
  },
  {
    title: 'Bathroom Remodel Checklist',
    meta: 'Planning checklist',
    tag: 'Checklist',
    image: './assets/budget-friendly-small-bathroom-ideas.jpg',
    url: 'https://www.homedepot.com/c/ai/bathroom-remodel-checklist/9ba683603be9fa5395fab901971c37f8',
    reason: 'Keep product, prep, and installation decisions organized.',
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
  openings: [
    { id: 1, type: 'door', wall: 'bottom', offset: 0.22, length: 2.5 },
    { id: 2, type: 'window', wall: 'top', offset: 0.70, length: 3 },
  ],
  selectedOpeningId: null,
  selectedProducts: {},
  location: 'national',
  locOpen: false,
  view: new URLSearchParams(window.location.search).get('view') === 'guides' ? 'guides' : 'plan',
};

let uid = 2;
let openingUid = 3;
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

function productsForType(type, tier = null) {
  const items = PRODUCTS.filter(product => product.type === type);
  if (!tier) return items;
  return [...items].sort((a, b) => Number(b.tier === tier) - Number(a.tier === tier));
}

function productById(id) {
  return PRODUCTS.find(product => product.id === id) || null;
}

function selectedProductFor(type) {
  const chosen = productById(state.selectedProducts[type]);
  if (chosen) return chosen;
  const plannedItem = state.placed.find(item => item.type === type);
  return productsForType(type, plannedItem?.tier || 'better')[0];
}

function matchingProducts(base, limit = 4) {
  if (!base) return [];
  const preferredOrder = {
    shower: ['tile', 'floor', 'lighting', 'vanity'],
    vanity: ['tile', 'lighting', 'floor', 'shower'],
    tile: ['vanity', 'lighting', 'floor', 'shower'],
    floor: ['vanity', 'tile', 'lighting', 'toilet'],
    toilet: ['floor', 'vanity', 'lighting', 'tile'],
    lighting: ['vanity', 'tile', 'shower', 'floor'],
  }[base.type] || ORDER.filter(type => type !== base.type);

  return preferredOrder.map(type => {
    const candidates = productsForType(type);
    return candidates.sort((a, b) => {
      const score = product => product.styles.filter(style => base.styles.includes(style)).length * 10 + Number(product.tier === base.tier) * 2;
      return score(b) - score(a);
    })[0];
  }).filter(Boolean).slice(0, limit);
}

function sharedStyleLabel(a, b) {
  const labels = {
    'modern-black': 'matte black accents',
    'clean-white': 'clean white finishes',
    'soft-carrara': 'Carrara stone tones',
    'warm-oak': 'warm natural wood',
    'brushed-nickel': 'brushed nickel details',
    'coastal-gray': 'soft gray tones',
  };
  const shared = b.styles.find(style => a.styles.includes(style));
  return shared ? labels[shared] : 'a balanced neutral palette';
}

function productOptionMarkup(product, active = false) {
  return `
    <article class="product-option${active ? ' is-selected' : ''}">
      <a class="product-option__image" href="${product.url}" target="_blank" rel="noreferrer" aria-label="Shop ${escapeHtml(product.title)}">
        <img src="${product.image}" alt="${escapeHtml(product.title)}">
      </a>
      <div class="product-option__body">
        <span class="product-option__tier">${escapeHtml(TIER_LABEL[product.tier])} product</span>
        <a href="${product.url}" target="_blank" rel="noreferrer"><strong>${escapeHtml(product.title)}</strong></a>
        <span class="product-option__price">${escapeHtml(product.price)}</span>
        <small>${escapeHtml(product.brand)} · Model ${escapeHtml(product.model)}</small>
        <button type="button" data-action="choose-product" data-product-id="${product.id}"${active ? ' aria-pressed="true"' : ''}>${active ? 'Selected for this look' : 'Use this look'}</button>
      </div>
    </article>
  `;
}

function fullProductCardMarkup(product, base = null) {
  const selected = state.selectedProducts[product.type] === product.id;
  const matchReason = base && base.id !== product.id
    ? `Matches through ${sharedStyleLabel(base, product)}.`
    : product.why;
  return `
    <article class="shop-product-card${selected ? ' is-selected' : ''}">
      <a class="shop-product-card__image" href="${product.url}" target="_blank" rel="noreferrer">
        <img src="${product.image}" alt="${escapeHtml(product.title)}">
      </a>
      <div class="shop-product-card__body">
        <span class="shop-product-card__category">${escapeHtml(COMPONENTS[product.type].label)}</span>
        <a href="${product.url}" target="_blank" rel="noreferrer"><h4>${escapeHtml(product.title)}</h4></a>
        <p class="shop-product-card__match">${escapeHtml(matchReason)}</p>
        <div class="shop-product-card__buy">
          <div><strong>${escapeHtml(product.price)}</strong><small>${escapeHtml(product.brand)} · ${escapeHtml(product.model)}</small></div>
          <button type="button" data-action="choose-product" data-product-id="${product.id}">${selected ? 'Selected' : 'Use this look'}</button>
        </div>
      </div>
    </article>
  `;
}

function currentLocation() {
  return LOCATIONS.find(loc => loc.key === state.location) || LOCATIONS[0];
}

function locationLabel(loc = currentLocation()) {
  return loc.key === 'national' ? 'National pricing' : `${loc.label}, ${loc.st}`;
}

function locationNote(loc = currentLocation()) {
  if (loc.key === 'national') {
    return 'Showing planning ranges. Select a market to reflect local product and installation costs.';
  }
  const pct = Math.round(Math.abs(loc.mult - 1) * 100);
  return `Planning costs in ${loc.label} run about ${pct}% ${loc.mult >= 1 ? 'above' : 'below'} the national range.`;
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

function openingCount(type) {
  return state.openings.filter(opening => opening.type === type).length;
}

function placedTypes() {
  return [...new Set(state.placed.map(item => item.type))];
}

function selectedItem() {
  return state.placed.find(item => item.id === state.selectedId) || null;
}

function selectedOpening() {
  return state.openings.find(opening => opening.id === state.selectedOpeningId) || null;
}

function wallLabel(wall) {
  return WALLS.find(option => option.key === wall)?.label || 'Wall';
}

function wallLength(wall) {
  return wall === 'top' || wall === 'bottom' ? state.roomW : state.roomH;
}

function openingWallAxis(wall) {
  return wall === 'top' || wall === 'bottom' ? 'horizontal' : 'vertical';
}

function openingName(opening) {
  const typeCount = state.openings
    .filter(candidate => candidate.type === opening.type && candidate.id <= opening.id)
    .length;
  return `${OPENINGS[opening.type].label}${typeCount > 1 ? ` ${typeCount}` : ''}`;
}

function openingOffsetFt(opening) {
  return opening.offset * wallLength(opening.wall);
}

function openingDescription(opening) {
  return `${openingName(opening)} on ${wallLabel(opening.wall).toLowerCase()}, ${fmtNum(opening.length)} ft wide, centered ${fmtNum(openingOffsetFt(opening))} ft along the wall`;
}

function clampOpening(opening) {
  const spec = OPENINGS[opening.type];
  const maxLength = Math.min(spec.max, wallLength(opening.wall));
  opening.length = clamp(snap(opening.length), spec.min, maxLength);
  const half = (opening.length / wallLength(opening.wall)) / 2;
  opening.offset = clamp(opening.offset, half, 1 - half);
  return opening;
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

function createOpening(type) {
  const presets = DEFAULT_OPENINGS[type] || [{ wall: 'bottom', offset: 0.5 }];
  const preset = presets[openingCount(type) % presets.length];
  return clampOpening({
    id: openingUid++,
    type,
    wall: preset.wall,
    offset: preset.offset,
    length: OPENINGS[type].length,
  });
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
  state.selectedOpeningId = null;
  renderAll();
}

function addOpening(type) {
  const opening = createOpening(type);
  state.openings.push(opening);
  state.selectedOpeningId = opening.id;
  state.selectedId = null;
  renderAll();
}

function removeItem(id) {
  state.placed = state.placed.filter(item => item.id !== id);
  if (state.selectedId === id) {
    state.selectedId = state.placed.length ? state.placed[state.placed.length - 1].id : null;
  }
  renderAll();
}

function removeOpening(id) {
  state.openings = state.openings.filter(opening => opening.id !== id);
  if (state.selectedOpeningId === id) {
    state.selectedOpeningId = state.openings.length ? state.openings[state.openings.length - 1].id : null;
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

  $('#openingPalette').innerHTML = OPENING_ORDER.map(type => {
    const opening = OPENINGS[type];
    const count = openingCount(type);
    const status = count
      ? `<span class="palette-count">${count > 1 ? `${count} marked` : 'Marked'}</span>`
      : '<span class="palette-action">+ Mark</span>';
    return `
      <button class="palette-card opening-card${count ? ' is-active' : ''}" type="button" data-action="opening-add" data-opening-type="${type}">
        <span class="opening-icon opening-icon--${type}" aria-hidden="true"></span>
        <span>
          <span class="palette-label">${escapeHtml(opening.label)}</span>
          <span class="opening-blurb">${escapeHtml(opening.blurb)}</span>
        </span>
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
          <span class="location-option__label">${escapeHtml(option.key === 'national' ? 'National pricing' : option.label)}</span>
          <span class="location-option__sub">${escapeHtml(sub)}</span>
        </span>
      </button>
    `;
  }).join('');
}

function renderOpenings() {
  $('#roomOpenings').innerHTML = state.openings.map(opening => {
    clampOpening(opening);
    const type = OPENINGS[opening.type];
    const axis = openingWallAxis(opening.wall);
    const lenPct = (opening.length / wallLength(opening.wall)) * 100;
    const selected = opening.id === state.selectedOpeningId;
    return `
      <button
        class="room-feature room-feature--${opening.type} room-feature--${opening.wall} room-feature--${axis}${selected ? ' is-selected' : ''}"
        type="button"
        data-action="opening-select"
        data-opening-id="${opening.id}"
        style="--pos:${opening.offset * 100};--len:${lenPct}"
        aria-label="${escapeHtml(openingDescription(opening))}">
        <span class="feature-line"></span>
        ${opening.type === 'door' ? '<span class="feature-swing"></span>' : ''}
        <span class="feature-label">${escapeHtml(type.label)}</span>
      </button>
    `;
  }).join('');
}

function renderCanvas() {
  $('#emptyCanvas').hidden = state.placed.length > 0 || state.openings.length > 0;
  renderOpenings();
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
  $('#placedCount').textContent = `${n} item${n === 1 ? '' : 's'} on your plan${state.openings.length ? ` + ${state.openings.length} opening marker${state.openings.length === 1 ? '' : 's'}` : ''}`;
  $('#estimateLocation').textContent = locationLabel(loc);
  $('#estimateNote').textContent = locationNote(loc);
  $('#quoteButton').textContent = n > 2 ? 'Build list from this plan' : 'Build project list';
  const listButton = $('#estimateQuoteButton');
  if (listButton) {
    listButton.disabled = n === 0;
    listButton.setAttribute('aria-disabled', String(n === 0));
    listButton.textContent = n > 2 ? 'Build list from this plan' : 'Build project list';
  }
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
  const hasPlumbingMove = state.placed.some(item => (
    ['shower', 'vanity', 'toilet'].includes(item.type) && item.addons.movePlumbing
  ));
  if (hasPlumbingMove) {
    drivers.push({
      title: 'Plumbing changes',
      text: 'Moving drains or supply lines usually requires a qualified installer to confirm access, permits, and final labor.',
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
  if (state.openings.length) {
    drivers.push({
      title: 'Door and window clearances',
      text: 'Marked openings help a consultant understand usable wall space, fixture placement, and swing clearance before a walkthrough.',
    });
  }
  if (!drivers.length) {
    drivers.push({
      title: 'Scope completeness',
      text: 'Add fixtures, finishes, and layout changes to create a more useful product and installation plan.',
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
    : 'Add fixtures to see products and guides matched to your remodel scope.';
  target.innerHTML = guides.map(article => `
    <a class="recommended-card" href="${article.url || HOME_DEPOT_BATHROOM_HUB}" target="_blank" rel="noreferrer">
      <img src="${article.image}" alt="">
      <span class="recommended-card__tag">${escapeHtml(article.tag)}</span>
      <strong>${escapeHtml(article.title)}</strong>
      <p>${escapeHtml(article.reason)}</p>
    </a>
  `).join('');
}

function renderGuidesScreen() {
  const target = $('#guideCollections');
  const productsTarget = $('#productCollections');
  const coordinatedTarget = $('#coordinatedRoom');
  const coordinatedIntro = $('#completeRoomIntro');
  const intro = $('#guidesViewIntro');
  if (!target || !productsTarget || !coordinatedTarget || !intro) return;

  const types = placedTypes();
  intro.textContent = types.length
    ? `Showing real product choices and guides for ${projectScopeLabel()} in your current plan.`
    : 'Start with curated product choices, then add project items to personalize the set.';

  const collectionTypes = types.length ? types : ['shower', 'vanity', 'tile'];
  const selected = selectedItem();
  const base = selectedProductFor(selected?.type || collectionTypes[0]);
  const matches = matchingProducts(base, 4);
  if (coordinatedIntro) coordinatedIntro.textContent = `${base.title} sets the direction. These picks repeat ${base.styles.map(style => sharedStyleLabel(base, { styles: [style] })).slice(0, 2).join(' and ')}.`;
  coordinatedTarget.innerHTML = `
    <article class="room-anchor-card">
      <span>Your starting point</span>
      <img src="${base.image}" alt="${escapeHtml(base.title)}">
      <div><strong>${escapeHtml(base.title)}</strong><em>${escapeHtml(base.price)}</em></div>
    </article>
    ${matches.map(product => fullProductCardMarkup(product, base)).join('')}
  `;

  productsTarget.innerHTML = collectionTypes.map(type => {
    const plannedItem = state.placed.find(item => item.type === type);
    const options = productsForType(type, plannedItem?.tier || 'better');
    return `
      <section class="product-collection">
        <div class="product-collection__head">
          <span class="guide-collection__icon">${iconSvg(COMPONENTS[type].iconKey)}</span>
          <div><h4>${escapeHtml(COMPONENTS[type].label)}</h4><p>Value, upgraded, and premium choices</p></div>
        </div>
        <div class="product-card-row">${options.map(product => fullProductCardMarkup(product, base)).join('')}</div>
      </section>
    `;
  }).join('');

  target.innerHTML = collectionTypes.map(type => {
    const component = COMPONENTS[type];
    const articles = component.articles.slice(0, 3).map(article => `
      <a class="guide-row" href="${article.url || HOME_DEPOT_BATHROOM_HUB}" target="_blank" rel="noreferrer">
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
  const local = loc.key === 'national' ? 'your area' : `${loc.label}`;

  title.textContent = count ? `Explore installation help in ${local}` : 'Get help with bathroom installation';
  copy.textContent = count
    ? `Your ${scope} scope is ready to share with a bathroom consultant. Start with the same project details and a planning range of ${range}.`
    : 'Build a project scope, then share it with a bathroom consultant to discuss products and installation.';
  button.textContent = count ? 'Request a consultation' : 'Check installation services';

  const chipData = [
    `${count} scoped item${count === 1 ? '' : 's'}`,
    `${state.openings.length} opening marker${state.openings.length === 1 ? '' : 's'}`,
    `${fmtNum(state.roomW * state.roomH)} sq ft bathroom`,
    locationLabel(loc),
    count ? range : 'Estimate pending',
  ];
  chips.innerHTML = chipData.map(chip => `<span>${escapeHtml(chip)}</span>`).join('');
}

function renderOpeningInspector(opening, wrap) {
  const spec = OPENINGS[opening.type];
  const walls = WALLS.map(wall => `
    <button class="pill-button${opening.wall === wall.key ? ' is-active' : ''}" type="button" data-action="opening-wall" data-opening-id="${opening.id}" data-wall="${wall.key}">${escapeHtml(wall.label.replace(' wall', ''))}</button>
  `).join('');
  const maxLength = Math.min(spec.max, wallLength(opening.wall));
  const offsetFt = openingOffsetFt(opening);

  wrap.innerHTML = `
    <section class="selected-config selected-config--opening">
      <div class="selected-head">
        <span class="opening-inspector-icon opening-icon--${opening.type}" aria-hidden="true"></span>
        <div>
          <h2>${escapeHtml(openingName(opening))}</h2>
          <p>${escapeHtml(wallLabel(opening.wall))} - does not change the cost estimate</p>
        </div>
      </div>

      <p class="selected-range selected-range--opening">
        <span>Layout marker</span>
        <strong>${escapeHtml(openingDescription(opening))}</strong>
      </p>

      <section class="inspector-section inspector-section--compact">
        <h3>Wall</h3>
        <div class="variant-row">${walls}</div>
      </section>

      <section class="inspector-section inspector-section--compact inspector-section--size">
        <div class="section-title-row">
          <h3>Opening size</h3>
          <span class="sqft-badge">${fmtNum(opening.length)} ft</span>
        </div>
        <div class="dimension-grid dimension-grid--single">
          <div class="dimension-control">
            <label for="openingLength">Length</label>
            <div class="stepper">
              <button type="button" data-action="opening-length-step" data-opening-id="${opening.id}" data-delta="-0.25" ${opening.length <= spec.min ? 'disabled' : ''}>-</button>
              <input id="openingLength" value="${fmtNum(opening.length)}" inputmode="decimal" data-action="opening-length-input" data-opening-id="${opening.id}" aria-label="${escapeHtml(spec.label)} length in feet">
              <button type="button" data-action="opening-length-step" data-opening-id="${opening.id}" data-delta="0.25" ${opening.length >= maxLength ? 'disabled' : ''}>+</button>
            </div>
          </div>
          <div class="dimension-control">
            <label for="openingOffset">Position</label>
            <div class="stepper">
              <button type="button" data-action="opening-offset-step" data-opening-id="${opening.id}" data-delta="-0.25">-</button>
              <input id="openingOffset" value="${fmtNum(offsetFt)}" inputmode="decimal" data-action="opening-offset-input" data-opening-id="${opening.id}" aria-label="${escapeHtml(spec.label)} position along wall in feet">
              <button type="button" data-action="opening-offset-step" data-opening-id="${opening.id}" data-delta="0.25">+</button>
            </div>
          </div>
        </div>
        <p class="coverage-note">Drag the marker along the wall or adjust the position in feet.</p>
      </section>

      <button class="danger-button" type="button" data-action="opening-remove" data-opening-id="${opening.id}">Remove marker</button>
    </section>
  `;
}

function renderInspector() {
  const opening = selectedOpening();
  const item = selectedItem();
  const wrap = $('#inspectorContent');
  if (opening) {
    renderOpeningInspector(opening, wrap);
    return;
  }

  if (!item) {
    wrap.innerHTML = `
      <section class="config-empty">
        <h2>Select a component</h2>
        <p>Click any fixture, door, or window on the plan to configure dimensions and layout details.</p>
      </section>
    `;
    return;
  }

  const c = COMPONENTS[item.type];
  const [lo, hi] = itemRange(item);
  const spotlight = primaryRecommendation();
  const activeProduct = selectedProductFor(item.type);
  const productOptions = productsForType(item.type, item.tier);
  const accessoryMatches = item.type === 'vanity' ? VANITY_ACCESSORIES.filter(accessory => !accessory.forProduct || (Array.isArray(accessory.forProduct) ? accessory.forProduct.includes(activeProduct.id) : accessory.forProduct === activeProduct.id)) : [];
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

      <section class="product-match-panel" aria-labelledby="productMatchTitle">
        <div class="product-match-panel__head">
          <div>
            <span>Real products at The Home Depot</span>
            <h3 id="productMatchTitle">Options in this finish range</h3>
          </div>
          <span class="match-badge">3 choices</span>
        </div>
        <div class="product-option-list">
          ${productOptions.map(product => productOptionMarkup(product, activeProduct.id === product.id)).join('')}
        </div>
        ${accessoryMatches.length ? `
          <div class="vanity-pairings">
            <strong>Complete this vanity</strong>
            <p>The ${escapeHtml(activeProduct.title)} includes its countertop. Add these coordinated pieces:</p>
            ${accessoryMatches.map(accessory => `<a href="${accessory.url}" target="_blank" rel="noreferrer"><span>${escapeHtml(accessory.label)}</span><strong>${escapeHtml(accessory.title)}</strong><em>${escapeHtml(accessory.price)}</em></a>`).join('')}
          </div>
        ` : ''}
        <p class="product-price-note">Online product prices checked July 14, 2026. Local price and availability may vary; installation is included separately in the planning range above.</p>
      </section>

      <a class="guide-spotlight" href="${spotlight.url || HOME_DEPOT_BATHROOM_HUB}" target="_blank" rel="noreferrer">
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

function findOpening(id) {
  return state.openings.find(opening => opening.id === Number(id)) || null;
}

function setItemDimension(id, axis, value) {
  const item = findItem(id);
  if (!item || Number.isNaN(value)) return;
  const max = axis === 'w' ? state.roomW : state.roomH;
  item[axis] = clamp(snap(value), 0.5, max);
  clampItem(item);
  renderAll();
}

function setOpeningLength(id, value) {
  const opening = findOpening(id);
  if (!opening || Number.isNaN(value)) return;
  const spec = OPENINGS[opening.type];
  opening.length = clamp(snap(value), spec.min, Math.min(spec.max, wallLength(opening.wall)));
  clampOpening(opening);
  renderAll();
}

function setOpeningOffsetFt(id, value) {
  const opening = findOpening(id);
  if (!opening || Number.isNaN(value)) return;
  const length = wallLength(opening.wall);
  opening.offset = snap(value) / length;
  clampOpening(opening);
  renderAll();
}

function setOpeningWall(id, wall) {
  const opening = findOpening(id);
  if (!opening) return;
  opening.wall = wall;
  clampOpening(opening);
  renderAll();
}

function commitRoomDimensions() {
  const roomW = parseFloat($('#roomWidth').value);
  const roomH = parseFloat($('#roomHeight').value);
  if (Number.isNaN(roomW) || Number.isNaN(roomH)) return;
  state.roomW = clamp(snap(roomW, 0.5), 4, 40);
  state.roomH = clamp(snap(roomH, 0.5), 4, 40);
  state.placed.forEach(clampItem);
  state.openings.forEach(clampOpening);
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

function beginOpeningDrag(opening, e) {
  drag = {
    mode: 'opening',
    id: opening.id,
    startX: e.clientX,
    startY: e.clientY,
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

  if (drag.mode === 'opening') {
    const opening = findOpening(drag.id);
    if (!opening) return;
    const rect = canvasRect();
    const raw = openingWallAxis(opening.wall) === 'horizontal'
      ? (e.clientX - rect.left) / rect.width
      : (e.clientY - rect.top) / rect.height;
    opening.offset = snap(raw * wallLength(opening.wall)) / wallLength(opening.wall);
    clampOpening(opening);
    renderAll();
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
  const openingMarker = e.target.closest('.room-feature');
  if (openingMarker) {
    const opening = findOpening(openingMarker.dataset.openingId);
    if (!opening) return;
    state.selectedOpeningId = opening.id;
    state.selectedId = null;
    beginOpeningDrag(opening, e);
    e.preventDefault();
    renderAll();
    return;
  }

  const resize = e.target.closest('[data-action="resize"]');
  if (resize) {
    const item = findItem(resize.dataset.id);
    if (!item) return;
    state.selectedId = item.id;
    state.selectedOpeningId = null;
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
    state.selectedOpeningId = null;
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
    if (action === 'choose-product') {
      const product = productById(actionTarget.dataset.productId);
      if (!product) return;
      state.selectedProducts[product.type] = product.id;
      const plannedItem = state.placed.find(item => item.type === product.type);
      if (plannedItem) plannedItem.tier = product.tier;
      renderAll();
      return;
    }
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
    if (action === 'opening-add') {
      addOpening(actionTarget.dataset.openingType);
      return;
    }
    if (action === 'opening-select') {
      state.selectedOpeningId = Number(actionTarget.dataset.openingId);
      state.selectedId = null;
      renderAll();
      return;
    }
    if (action === 'opening-wall') {
      setOpeningWall(actionTarget.dataset.openingId, actionTarget.dataset.wall);
      return;
    }
    if (action === 'opening-length-step') {
      const opening = findOpening(actionTarget.dataset.openingId);
      if (!opening) return;
      setOpeningLength(opening.id, opening.length + parseFloat(actionTarget.dataset.delta));
      return;
    }
    if (action === 'opening-offset-step') {
      const opening = findOpening(actionTarget.dataset.openingId);
      if (!opening) return;
      setOpeningOffsetFt(opening.id, openingOffsetFt(opening) + parseFloat(actionTarget.dataset.delta));
      return;
    }
    if (action === 'opening-remove') {
      removeOpening(Number(actionTarget.dataset.openingId));
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
      if (item) {
        item.tier = actionTarget.dataset.tier;
        delete state.selectedProducts[item.type];
      }
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
    state.selectedOpeningId = null;
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
    return;
  }
  if (e.target.dataset.action === 'opening-length-input') {
    setOpeningLength(e.target.dataset.openingId, parseFloat(e.target.value));
    return;
  }
  if (e.target.dataset.action === 'opening-offset-input') {
    setOpeningOffsetFt(e.target.dataset.openingId, parseFloat(e.target.value));
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
    ? `${state.placed.length} project item${state.placed.length === 1 ? '' : 's'} in a ${fmtNum(state.roomW)} x ${fmtNum(state.roomH)} ft bathroom for ${locationLabel()}. Planning range: ${rangeText(lo, hi)}. Enter your info to save the project plan.`
    : 'Add fixtures to generate a store-ready project plan.';
  modal.hidden = false;
  $('#leadName').focus();
}

$('#quoteButton').addEventListener('click', openDownloadModal);
$('#estimateQuoteButton').addEventListener('click', openDownloadModal);
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
    'BATHROOM REMODEL PROJECT PLAN',
    'Prepared with The Home Depot Project Planner',
    `Prepared for: ${lead.name} (${lead.email})`,
    '',
    `Room: ${fmtNum(state.roomW)} x ${fmtNum(state.roomH)} ft (${fmtNum(state.roomW * state.roomH)} sq ft)`,
    `Location: ${locationLabel()}`,
    `Estimated range: ${state.placed.length ? rangeText(lo, hi) : '$0'}`,
    '',
    'ROOM OPENINGS',
    ...(state.openings.length
      ? state.openings.map(opening => `- ${openingDescription(opening)}`)
      : ['- No doors or windows marked']),
    '',
    'SCOPE',
    ...state.placed.map(item => {
      const [itemLo, itemHi] = itemRange(item);
      const c = COMPONENTS[item.type];
      const addonLabels = c.addons.filter(addon => item.addons[addon.key]).map(addon => addon.label);
      return `- ${item.name}: ${fmtNum(item.w)} x ${fmtNum(item.h)} ft, ${TIER_LABEL[item.tier]} tier, ${rangeText(itemLo, itemHi)}${addonLabels.length ? `, add-ons: ${addonLabels.join(', ')}` : ''}`;
    }),
    '',
    'PRODUCT SELECTIONS',
    ...state.placed.map(item => {
      const product = selectedProductFor(item.type);
      return `- ${COMPONENTS[item.type].label}: ${product.brand} ${product.title}, ${product.price}, model ${product.model} - ${product.url}`;
    }),
    '',
    'RECOMMENDED GUIDES',
    ...recommendationItems(3).map(article => `- ${article.title}`),
    '',
    'NEXT STEP',
    'Use this scope to build a product list or request a Home Depot bathroom consultation.',
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
    if (line === 'ROOM OPENINGS' || line === 'SCOPE' || line === 'PRODUCT SELECTIONS' || line === 'RECOMMENDED GUIDES' || line === 'NEXT STEP') {
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
  a.download = 'home-depot-bathroom-project-plan.pdf';
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
