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
  { id: 'tub-mustee-durawall', type: 'shower', tier: 'good', brand: 'MUSTEE', title: 'Durawall 60 in. Rectangular Tub / Shower Combo Unit in White', price: '$789.00', model: 'K-3060R-53WHT', url: 'https://www.homedepot.com/p/323185149', image: './assets/bathroom-double-vanity-bathtub-shower.jpg', styles: ['clean-white'], why: 'The one-piece white tub and wall set keeps a compact bath clean and practical.' },
  { id: 'tub-delta-classic', type: 'shower', tier: 'better', brand: 'Delta', title: 'Classic 500 60 in. Alcove Bathtub and Shower Combo in High Gloss White', price: '$678.00', model: 'BVS2-C522-WH', url: 'https://www.homedepot.com/p/321602830', image: './assets/bathroom-double-vanity-bathtub-shower.jpg', styles: ['clean-white', 'soft-carrara'], why: 'The bright white alcove kit pairs easily with pale stone and tile finishes.' },
  { id: 'tub-cantora', type: 'shower', tier: 'good', brand: 'Home Decorators Collection', title: 'Cantora 60 in. Freestanding Flatbottom Soaking Bathtub in White', price: '$599.00', model: 'GBBA013', url: 'https://www.homedepot.com/p/304905712', image: './assets/interior-small-bathroom.jpg', styles: ['clean-white', 'soft-carrara'], why: 'Its clean freestanding silhouette gives a light, spa-like focal point.' },
  { id: 'tub-aldrich', type: 'shower', tier: 'better', brand: 'Home Decorators Collection', title: 'Aldrich 59 in. Freestanding Flatbottom Soaking Bathtub in White', price: '$576.40', model: 'GBBA016', url: 'https://www.homedepot.com/p/313951286', image: './assets/interior-small-bathroom.jpg', styles: ['clean-white', 'brushed-nickel'], why: 'The centered-drain soaking tub works well with simple nickel and white finishes.' },
  { id: 'tub-coniston', type: 'shower', tier: 'best', brand: 'Home Decorators Collection', title: 'Coniston 60 in. Acrylic Single Slipper Soaking Bathtub in White', price: '$799.00', model: 'GBBA019', url: 'https://www.homedepot.com/p/321198959', image: './assets/interior-small-bathroom.jpg', styles: ['clean-white', 'brushed-nickel'], why: 'The slipper shape and included brushed-nickel hardware make a more finished focal point.' },
  { id: 'vanity-everdean', type: 'vanity', tier: 'good', brand: 'Glacier Bay', title: 'Everdean 37 in. White Vanity with Cultured Marble Top', price: '$389.00', model: 'EV36P2-WH', url: 'https://www.homedepot.com/p/311606052', image: './assets/products/vanity-everdean.jpg', styles: ['clean-white', 'brushed-nickel'], why: 'The included white top makes an easy base for subway tile.' },
  { id: 'vanity-sonoma', type: 'vanity', tier: 'better', brand: 'Home Decorators Collection', title: 'Sonoma 36 in. Pebble Gray Vanity with Carrara Marble Top', price: '$1,349.00', model: 'Sonoma 36PG', url: 'https://www.homedepot.com/p/300711784', image: './assets/products/vanity-sonoma.jpg', styles: ['soft-carrara', 'brushed-nickel', 'coastal-gray'], why: 'Its included Carrara top establishes the stone palette for the room.' },
  { id: 'vanity-aberdeen', type: 'vanity', tier: 'best', brand: 'Home Decorators Collection', title: 'Aberdeen 48 in. Antique Oak Vanity with Carrara Marble Top', price: '$1,899.00', model: 'Aberdeen 48AO', url: 'https://www.homedepot.com/p/312613755', image: './assets/products/vanity-aberdeen.jpg', styles: ['warm-oak', 'soft-carrara', 'brushed-nickel'], why: 'Warm oak adds depth while the Carrara top ties into pale tile.' },
  { id: 'tile-restore-3x6', type: 'tile', tier: 'good', brand: 'Daltile', title: 'Restore Bright White 3 x 6 Ceramic Subway Tile', price: '$1.20 / sq. ft.', model: 'RE1536MODHD1P4', url: 'https://www.homedepot.com/p/302575146', image: './assets/products/tile-restore-3x6.jpg', styles: ['clean-white', 'modern-black'], why: 'A simple white field lets black fixtures or wood cabinetry lead.' },
  { id: 'tile-restore-4x12', type: 'tile', tier: 'better', brand: 'Daltile', title: 'Restore Bright White 4 x 12 Ceramic Subway Tile', price: '$2.05 / sq. ft.', model: 'RE15412MODHD1P2', url: 'https://www.homedepot.com/p/311781598', image: './assets/products/tile-restore-4x12.jpg', styles: ['clean-white', 'brushed-nickel'], why: 'The longer format feels updated and stays neutral with nickel.' },
  { id: 'tile-carrara-penny', type: 'tile', tier: 'best', brand: 'MSI', title: 'Carrara Penny Round Matte Porcelain Mosaic Tile', price: '$11.52 / sq. ft.', model: 'PT-PENRD-CARMC', url: 'https://www.homedepot.com/p/315654369', image: './assets/products/tile-carrara-penny.jpg', styles: ['soft-carrara', 'brushed-nickel'], why: 'The marble look repeats a Carrara vanity top without competing with it.' },
  { id: 'floor-breaksea', type: 'floor', tier: 'good', brand: 'TrafficMaster', title: 'Breaksea Island Waterproof Click Lock Vinyl Plank', price: '$1.49 / sq. ft.', model: 'VTRHDBREAIS6X36', url: 'https://www.homedepot.com/p/324087709', image: './assets/products/floor-breaksea.jpg', styles: ['coastal-gray', 'clean-white'], why: 'A cool gray plank works with white cabinetry and pebble-gray finishes.' },
  { id: 'floor-dusk-cherry', type: 'floor', tier: 'better', brand: 'Lifeproof', title: 'Dusk Cherry Waterproof Luxury Vinyl Plank', price: '$2.98 / sq. ft.', model: 'I06204LP', url: 'https://www.homedepot.com/p/311573441', image: './assets/products/floor-dusk-cherry.jpg', styles: ['warm-oak', 'modern-black'], why: 'The warm grain supports oak cabinetry and softens black metal.' },
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

const PRODUCT_METADATA = {
  'shower-alliance': { amount: 350, unit: 'each', variants: ['Walk-in shower'], includes: ['glassDoor'] },
  'shower-essence': { amount: 637.49, unit: 'each', variants: ['Walk-in shower'], includes: ['glassDoor'] },
  'shower-encore': { amount: 713, unit: 'each', variants: ['Walk-in shower'], includes: ['glassDoor'] },
  'tub-mustee-durawall': { amount: 789, unit: 'each', variants: ['Tub / shower combo'], includes: [] },
  'tub-delta-classic': { amount: 678, unit: 'each', variants: ['Tub / shower combo'], includes: [] },
  'tub-cantora': { amount: 599, unit: 'each', variants: ['Freestanding tub'], includes: [] },
  'tub-aldrich': { amount: 576.4, unit: 'each', variants: ['Freestanding tub'], includes: [] },
  'tub-coniston': { amount: 799, unit: 'each', variants: ['Freestanding tub'], includes: [] },
  'vanity-everdean': { amount: 389, unit: 'each', variants: ['Single vanity'], minWidth: 2.75, maxWidth: 3.25, includes: ['countertop', 'sink'] },
  'vanity-sonoma': { amount: 1349, unit: 'each', variants: ['Single vanity'], minWidth: 2.75, maxWidth: 3.25, includes: ['countertop', 'sink'] },
  'vanity-aberdeen': { amount: 1899, unit: 'each', variants: ['Single vanity'], minWidth: 3.75, maxWidth: 4.25, includes: ['countertop', 'sink'] },
  'tile-restore-3x6': { amount: 1.2, unit: 'sq. ft.', variants: ['Shower surround', 'Floor tile', 'Backsplash', 'Accent wall'], includes: [] },
  'tile-restore-4x12': { amount: 2.05, unit: 'sq. ft.', variants: ['Shower surround', 'Floor tile', 'Backsplash', 'Accent wall'], includes: [] },
  'tile-carrara-penny': { amount: 11.52, unit: 'sq. ft.', variants: ['Shower surround', 'Floor tile', 'Backsplash', 'Accent wall'], includes: [] },
  'floor-breaksea': { amount: 1.49, unit: 'sq. ft.', variants: ['Main floor'], includes: [] },
  'floor-dusk-cherry': { amount: 2.98, unit: 'sq. ft.', caseAmount: 59.97, coverageSqFt: 20.1, variants: ['Main floor'], includes: [] },
  'floor-carrara': { amount: 3.55, unit: 'sq. ft.', variants: ['Main floor'], includes: [] },
  'toilet-powerflush': { amount: 129, unit: 'each', variants: ['Standard'], includes: [] },
  'toilet-powerflush-tall': { amount: 179, unit: 'each', variants: ['Standard'], includes: [] },
  'toilet-cadet3': { amount: 259, unit: 'each', variants: ['Standard'], includes: [] },
  'light-ayelen': { amount: 59.97, unit: 'each', variants: ['Vanity lights'], includes: [] },
  'light-halyn': { amount: 109.97, unit: 'each', variants: ['Vanity lights'], includes: [] },
  'light-regan': { amount: 119.97, unit: 'each', variants: ['Vanity lights'], includes: [] },
};

const ADDON_INCLUDES = {
  glass: 'glassDoor',
  stone: 'countertop',
};

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
  { key: 'national', label: 'United States', st: '', mult: 1.00, currency: 'USD', storeLabel: 'United States' },
  { key: 'seattle', label: 'Seattle', st: 'WA', mult: 1.18, currency: 'USD', storeLabel: 'Seattle, WA sample market' },
  { key: 'la', label: 'Los Angeles', st: 'CA', mult: 1.22, currency: 'USD', storeLabel: 'Los Angeles, CA sample market' },
  { key: 'phoenix', label: 'Phoenix', st: 'AZ', mult: 0.98, currency: 'USD', storeLabel: 'Phoenix, AZ sample market' },
  { key: 'denver', label: 'Denver', st: 'CO', mult: 1.06, currency: 'USD', storeLabel: 'Denver, CO sample market' },
  { key: 'austin', label: 'Austin', st: 'TX', mult: 1.02, currency: 'USD', storeLabel: 'Austin, TX sample market' },
  { key: 'chicago', label: 'Chicago', st: 'IL', mult: 1.08, currency: 'USD', storeLabel: 'Chicago, IL sample market' },
  { key: 'atlanta', label: 'Atlanta', st: 'GA', mult: 0.96, currency: 'USD', storeLabel: 'Atlanta, GA sample market' },
  { key: 'miami', label: 'Miami', st: 'FL', mult: 1.05, currency: 'USD', storeLabel: 'Miami, FL sample market' },
  { key: 'ny', label: 'New York', st: 'NY', mult: 1.35, currency: 'USD', storeLabel: 'New York, NY sample market' },
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
  location: sessionStorage.getItem('bathroomPlannerMarket') || 'national',
  locOpen: false,
  mobileMode: 'items',
  recommendationAnchor: null,
  comparison: null,
  view: new URLSearchParams(window.location.search).get('view') === 'guides' ? 'guides' : 'plan',
};

let uid = 2;
let openingUid = 3;
let drag = null;
let suppressPaletteClick = false;

const $ = selector => document.querySelector(selector);
const fmtMoney = n => '$' + Math.round(n).toLocaleString('en-US');
const fmtNum = n => Number.isInteger(n) ? String(n) : String(Math.round(n * 100) / 100);
const clamp = (n, min, max) => Math.max(min, Math.min(max, n));
const snap = (n, step = 0.25) => Math.round(n / step) * step;

function announce(message) {
  const status = $('#plannerStatus');
  if (status) status.textContent = message;
}

function restorePlannerFocus(selector) {
  window.requestAnimationFrame(() => $(selector)?.focus());
}

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

function productMeta(product) {
  return {
    amount: 0,
    unit: 'each',
    caseAmount: null,
    coverageSqFt: null,
    checkedOn: '2026-07-14',
    source: 'static-snapshot',
    variants: [],
    minWidth: null,
    maxWidth: null,
    includes: [],
    ...(PRODUCT_METADATA[product.id] || {}),
  };
}

function productPriceText(product) {
  const meta = productMeta(product);
  const casePrice = meta.caseAmount ? ` (${fmtMoney(meta.caseAmount)} / case)` : '';
  return `${fmtMoney(meta.amount)} / ${meta.unit}${casePrice}`;
}

function validateProductData() {
  return PRODUCTS.flatMap(product => {
    const meta = productMeta(product);
    const missing = [];
    if (!product.model) missing.push('model');
    if (!product.url.startsWith('https://www.homedepot.com/')) missing.push('Home Depot URL');
    if (!product.image) missing.push('image');
    if (!Number.isFinite(meta.amount) || meta.amount <= 0) missing.push('numeric price');
    if (!meta.unit) missing.push('unit');
    if (!meta.checkedOn || !meta.source) missing.push('price provenance');
    if (!Array.isArray(meta.variants) || !Array.isArray(meta.includes)) missing.push('compatibility metadata');
    return missing.length ? [`${product.id}: missing ${missing.join(', ')}`] : [];
  });
}

function isProductCompatible(product, item) {
  if (!product || !item || product.type !== item.type) return false;
  const meta = productMeta(product);
  const variantMatches = !meta.variants.length || meta.variants.includes(item.name);
  const widthMatches = (meta.minWidth === null || item.w >= meta.minWidth)
    && (meta.maxWidth === null || item.w <= meta.maxWidth);
  return variantMatches && widthMatches;
}

function productsForItem(item) {
  return productsForType(item.type, item.tier).filter(product => isProductCompatible(product, item));
}

function selectedProductFor(subject) {
  const item = typeof subject === 'object'
    ? subject
    : state.placed.find(candidate => candidate.type === subject);
  if (!item) return null;
  const chosen = productById(item.productId);
  return chosen && isProductCompatible(chosen, item) ? chosen : null;
}

function recommendedProductFor(subject) {
  const item = typeof subject === 'object'
    ? subject
    : state.placed.find(candidate => candidate.type === subject);
  return item ? productsForItem(item)[0] || null : null;
}

function selectedProducts() {
  return state.placed
    .map(item => ({ item, product: selectedProductFor(item) }))
    .filter(entry => entry.product);
}

function productIncludes(product, addon) {
  if (!product) return false;
  const capability = ADDON_INCLUDES[addon.key];
  return !!capability && productMeta(product).includes.includes(capability);
}

function selectProduct(item, product) {
  if (!item || !product || !isProductCompatible(product, item)) return false;
  item.productId = product.id;
  state.recommendationAnchor = { itemId: item.id, productId: product.id };
  Object.keys(item.addons).forEach(key => {
    const addon = COMPONENTS[item.type].addons.find(candidate => candidate.key === key);
    if (addon && productIncludes(product, addon)) delete item.addons[key];
  });
  return true;
}

function clearIncompatibleProduct(item) {
  if (item?.productId && !isProductCompatible(productById(item.productId), item)) {
    const cleared = productById(item.productId);
    item.productId = null;
    if (state.recommendationAnchor?.itemId === item.id) state.recommendationAnchor = null;
    return cleared;
  }
  return null;
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
    const plannedItem = state.placed.find(item => item.type === type);
    const candidates = plannedItem ? productsForItem(plannedItem) : productsForType(type);
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

function productOptionMarkup(product, item, active = false) {
  return `
    <article class="product-option${active ? ' is-selected' : ''}">
      <a class="product-option__image" href="${product.url}" target="_blank" rel="noreferrer" aria-label="Shop ${escapeHtml(product.title)}">
        <img src="${product.image}" alt="${escapeHtml(product.title)}">
      </a>
      <div class="product-option__body">
        <span class="product-option__tier">${escapeHtml(TIER_LABEL[product.tier])} product</span>
        <a href="${product.url}" target="_blank" rel="noreferrer"><strong>${escapeHtml(product.title)}</strong></a>
        <span class="product-option__price">${escapeHtml(productPriceText(product))}</span>
        <small>${escapeHtml(product.brand)} · Model ${escapeHtml(product.model)}</small>
        <button type="button" data-action="choose-product" data-product-id="${product.id}" data-item-id="${item.id}"${active ? ' aria-pressed="true"' : ''}>${active ? 'Selected for this item' : 'Use this product'}</button>
      </div>
    </article>
  `;
}

function fullProductCardMarkup(product, base = null, item = null) {
  const selected = !!item && selectedProductFor(item)?.id === product.id;
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
          <div><strong>${escapeHtml(productPriceText(product))}</strong><small>${escapeHtml(product.brand)} · ${escapeHtml(product.model)}</small></div>
          <div class="shop-product-card__actions">
            <button type="button" data-action="choose-product" data-product-id="${product.id}"${item ? ` data-item-id="${item.id}"` : ' disabled'}>${selected ? 'Selected' : item ? 'Use this product' : 'Add this item to choose'}</button>
            ${item ? `<button type="button" class="button-secondary" data-action="compare-product" data-product-id="${product.id}" data-item-id="${item.id}">Compare</button>` : ''}
          </div>
        </div>
      </div>
    </article>
  `;
}

function currentLocation() {
  return LOCATIONS.find(loc => loc.key === state.location) || LOCATIONS[0];
}

function locationLabel(loc = currentLocation()) {
  return loc.key === 'national' ? 'United States planning market' : `${loc.label}, ${loc.st} planning market`;
}

function locationNote(loc = currentLocation()) {
  if (loc.key === 'national') {
    return 'Sample United States planning range. Prices are static snapshots; local price, availability, taxes, and delivery may vary.';
  }
  const pct = Math.round(Math.abs(loc.mult - 1) * 100);
  return `Sample ${loc.label} market: installation planning allowances run about ${pct}% ${loc.mult >= 1 ? 'above' : 'below'} the national baseline. Product prices remain static snapshots.`;
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

function addonRange(item, withLocation = true) {
  const c = COMPONENTS[item.type];
  const mult = withLocation ? currentLocation().mult : 1;
  const range = [0, 0];
  const product = selectedProductFor(item);
  c.addons.forEach(addon => {
    if (item.addons[addon.key] && !productIncludes(product, addon)) {
      range[0] += addon.lo;
      range[1] += addon.hi;
    }
  });
  return [range[0] * mult, range[1] * mult];
}

function materialQuantity(item, product) {
  const meta = productMeta(product);
  if (!['tile', 'floor'].includes(item.type)) return { count: 1, label: '1 each', subtotal: meta.amount };
  const coverage = item.type === 'floor' ? state.roomW * state.roomH : item.w * item.h;
  const requiredSqFt = Math.ceil(coverage * 1.1);
  if (meta.coverageSqFt && meta.caseAmount) {
    const cases = Math.ceil(requiredSqFt / meta.coverageSqFt);
    return { count: cases, label: `${cases} case${cases === 1 ? '' : 's'} · ${requiredSqFt} sq. ft. with 10% waste`, subtotal: cases * meta.caseAmount };
  }
  return { count: requiredSqFt, label: `${requiredSqFt} sq. ft. with 10% waste`, subtotal: requiredSqFt * meta.amount };
}

function materialLine(item) {
  const product = selectedProductFor(item);
  if (!product) return null;
  const quantity = materialQuantity(item, product);
  return { item, product, ...quantity };
}

function itemRange(item, withLocation = true) {
  const mult = withLocation ? currentLocation().mult : 1;
  const material = materialLine(item)?.subtotal || 0;
  const [addonLo, addonHi] = addonRange(item, withLocation);
  const [baseLo, baseHi] = baseRange(item);
  return [material + baseLo * mult + addonLo, material + baseHi * mult + addonHi];
}

function projectCostModel() {
  const lines = state.placed.map(item => ({
    item,
    material: materialLine(item),
    installation: baseRange(item).map(value => value * currentLocation().mult),
    addons: addonRange(item),
  }));
  const materials = lines.reduce((total, line) => total + (line.material?.subtotal || 0), 0);
  const installLo = lines.reduce((total, line) => total + line.installation[0] + line.addons[0], 0);
  const installHi = lines.reduce((total, line) => total + line.installation[1] + line.addons[1], 0);
  return { lines, materials, installLo, installHi, lo: materials + installLo, hi: materials + installHi };
}

function estimateRange() {
  const model = projectCostModel();
  return [model.lo, model.hi];
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

function itemDisplayName(item) {
  const siblings = state.placed.filter(candidate => candidate.type === item.type);
  if (siblings.length < 2) return item.name;
  return `${COMPONENTS[item.type].label} ${siblings.findIndex(candidate => candidate.id === item.id) + 1}`;
}

function itemBounds(item) {
  return {
    left: item.nx * state.roomW - item.w / 2,
    right: item.nx * state.roomW + item.w / 2,
    top: item.ny * state.roomH - item.h / 2,
    bottom: item.ny * state.roomH + item.h / 2,
  };
}

function itemsOverlap(a, b) {
  const aa = itemBounds(a);
  const bb = itemBounds(b);
  return aa.left < bb.right && aa.right > bb.left && aa.top < bb.bottom && aa.bottom > bb.top;
}

function layoutWarnings() {
  const warnings = [];
  state.placed.forEach((item, index) => {
    state.placed.slice(index + 1).forEach(other => {
      if (itemsOverlap(item, other)) warnings.push(`${itemDisplayName(item)} overlaps ${itemDisplayName(other)}.`);
    });
    const bounds = itemBounds(item);
    if (bounds.left < 0 || bounds.top < 0 || bounds.right > state.roomW || bounds.bottom > state.roomH) {
      warnings.push(`${itemDisplayName(item)} does not fit within the room.`);
    }
  });
  state.openings.filter(opening => opening.type === 'door').forEach(opening => {
    const wall = opening.wall;
    const offset = openingOffsetFt(opening);
    state.placed.forEach(item => {
      const bounds = itemBounds(item);
      const nearWall = wall === 'top' ? bounds.top < 1.5 : wall === 'bottom' ? state.roomH - bounds.bottom < 1.5 : wall === 'left' ? bounds.left < 1.5 : state.roomW - bounds.right < 1.5;
      const center = (wall === 'top' || wall === 'bottom') ? item.nx * state.roomW : item.ny * state.roomH;
      if (nearWall && Math.abs(center - offset) < opening.length / 2 + 0.75) warnings.push(`${itemDisplayName(item)} may block ${openingName(opening)} clearance.`);
    });
  });
  return [...new Set(warnings)];
}

function findOpenPosition(item, occupied = state.placed.filter(candidate => candidate.id !== item.id)) {
  for (let y = 0.5; y <= state.roomH - 0.5; y += 0.5) {
    for (let x = 0.5; x <= state.roomW - 0.5; x += 0.5) {
      const candidate = { ...item, nx: x / state.roomW, ny: y / state.roomH };
      clampItem(candidate);
      if (!occupied.some(other => itemsOverlap(candidate, other))) return { nx: candidate.nx, ny: candidate.ny };
    }
  }
  return null;
}

function resolveOverlaps() {
  const placed = [];
  state.placed.forEach(item => {
    if (placed.some(other => itemsOverlap(item, other))) {
      const target = findOpenPosition(item, placed);
      if (target) Object.assign(item, target);
    }
    placed.push(item);
  });
  renderAll();
  announce(layoutWarnings().length ? 'Some layout warnings still need your review.' : 'Overlapping fixtures were moved to open space.');
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
    productId: null,
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
  const openPosition = findOpenPosition(item);
  if (openPosition && state.placed.some(existing => itemsOverlap(item, existing))) Object.assign(item, openPosition);
  state.placed.push(item);
  state.selectedId = item.id;
  state.selectedOpeningId = null;
  renderAll();
  announce(`${item.name} added to your plan.`);
  return item;
}

function addOpening(type) {
  const opening = createOpening(type);
  state.openings.push(opening);
  state.selectedOpeningId = opening.id;
  state.selectedId = null;
  renderAll();
  announce(`${OPENINGS[type].label} marked on your plan.`);
  return opening;
}

function removeItem(id) {
  state.placed = state.placed.filter(item => item.id !== id);
  if (state.selectedId === id) {
    state.selectedId = state.placed.length ? state.placed[state.placed.length - 1].id : null;
  }
  renderAll();
  announce('Project item removed from your plan.');
}

function removeOpening(id) {
  state.openings = state.openings.filter(opening => opening.id !== id);
  if (state.selectedOpeningId === id) {
    state.selectedOpeningId = state.openings.length ? state.openings[state.openings.length - 1].id : null;
  }
  renderAll();
  announce('Opening removed from your plan.');
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
    const status = count ? `<span class="palette-count">${count} on plan</span>` : '<span class="palette-action">+ Add</span>';
    const card = `<button class="palette-card${count ? ' is-active' : ''}" type="button" data-action="${count ? 'palette-select' : 'palette'}" data-type="${type}">
      <span class="palette-icon">${iconSvg(c.iconKey)}</span>
      <span class="palette-label">${escapeHtml(c.label)}</span>
      ${status}
    </button>`;
    return count ? `<div class="palette-entry">${card}<button class="palette-add" type="button" data-action="palette" data-type="${type}" aria-label="Add another ${escapeHtml(c.label)}">+</button></div>` : card;
  }).join('');

  $('#openingPalette').innerHTML = OPENING_ORDER.map(type => {
    const opening = OPENINGS[type];
    const count = openingCount(type);
    const status = count ? `<span class="palette-count">${count} marked</span>` : '<span class="palette-action">+ Mark</span>';
    const card = `<button class="palette-card opening-card${count ? ' is-active' : ''}" type="button" data-action="${count ? 'opening-palette-select' : 'opening-add'}" data-opening-type="${type}">
        <span class="opening-icon opening-icon--${type}" aria-hidden="true"></span>
        <span>
          <span class="palette-label">${escapeHtml(opening.label)}</span>
          <span class="opening-blurb">${escapeHtml(opening.blurb)}</span>
        </span>
        ${status}
      </button>`;
    return count ? `<div class="palette-entry">${card}<button class="palette-add" type="button" data-action="opening-add" data-opening-type="${type}" aria-label="Add another ${escapeHtml(opening.label)}">+</button></div>` : card;
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
  $('#storeChipLabel').textContent = loc.storeLabel;
  $('#locationToggle').setAttribute('aria-expanded', String(state.locOpen));
  $('#locationMenu').hidden = !state.locOpen;
  $('#locationMenu').setAttribute('role', 'listbox');
  $('#locationMenu').setAttribute('aria-label', 'Planning market');
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
    const label = itemDisplayName(item);
    const product = selectedProductFor(item);
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
        aria-label="${escapeHtml(`${label}, ${fmtNum(item.w)} by ${fmtNum(item.h)} feet${product ? `, selected product ${product.title}` : ''}`)}"
        style="--x:${item.nx * 100};--y:${item.ny * 100};--w:${wPct};--h:${hPct};z-index:${z}">
        ${product ? `<img class="plan-item__product-thumb" src="${product.image}" alt="" aria-hidden="true">` : `<span class="item-icon">${iconSvg(c.iconKey)}</span>`}
        <span class="item-name">${escapeHtml(label)}</span>
        <span class="item-dims">${fmtNum(item.w)} x ${fmtNum(item.h)} ft</span>
        <button class="item-remove" type="button" data-action="remove" data-id="${item.id}" aria-label="Remove ${escapeHtml(label)}">&times;</button>
        <button class="resize-handle" type="button" data-action="resize" data-id="${item.id}" aria-label="Resize ${escapeHtml(label)}"></button>
      </article>
    `;
  }).join('');
  const warnings = layoutWarnings();
  const warningTarget = $('#layoutWarnings');
  warningTarget.hidden = !warnings.length;
  warningTarget.innerHTML = warnings.length ? `<strong>Layout review needed</strong><span>${escapeHtml(warnings.join(' '))}</span><button type="button" data-action="resolve-overlaps">Resolve overlaps</button>` : '';
}

function renderEstimate() {
  const model = projectCostModel();
  const [lo, hi] = [model.lo, model.hi];
  const n = state.placed.length;
  const loc = currentLocation();
  $('#estimateTotal').textContent = n ? rangeText(lo, hi) : 'Add fixtures to start';
  $('#placedCount').textContent = `${n} item${n === 1 ? '' : 's'} on your plan${state.openings.length ? ` + ${state.openings.length} opening marker${state.openings.length === 1 ? '' : 's'}` : ''}`;
  $('#estimateLocation').textContent = locationLabel(loc);
  $('#estimateNote').textContent = locationNote(loc);
  $('#quoteButton').textContent = 'Download project plan';
  const cartButton = $('#cartHandoffButton');
  const cartStatus = $('#cartHandoffStatus');
  if (cartStatus) {
    cartStatus.hidden = true;
    cartStatus.textContent = '';
  }
  if (cartButton) {
    const selectedCount = selectedProducts().length;
    cartButton.disabled = selectedCount === 0;
    cartButton.setAttribute('aria-disabled', String(selectedCount === 0));
    cartButton.textContent = selectedCount ? `Prepare ${selectedCount} selected product${selectedCount === 1 ? '' : 's'} for cart` : 'Select products to prepare cart handoff';
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
  const planView = $('#planView');
  if (planView) planView.dataset.mobileMode = state.mobileMode;
  document.querySelectorAll('[data-action="mobile-mode"]').forEach(button => {
    const active = state.view === 'plan' && button.dataset.mobileMode === state.mobileMode;
    button.setAttribute('aria-selected', String(active));
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
  if (layoutWarnings().length) {
    drivers.unshift({
      title: 'Layout review needed',
      text: `${layoutWarnings().length} layout warning${layoutWarnings().length === 1 ? '' : 's'} should be resolved before product ordering or installation pricing.`,
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

  const model = projectCostModel();
  const [lo, hi] = [model.lo, model.hi];
  intro.textContent = state.placed.length
    ? `${scopeItemsText()} in a ${fmtNum(state.roomW * state.roomH)} sq ft bathroom near ${locationLabel()}. Current range: ${rangeText(lo, hi)}.`
    : 'Add components to generate an itemized project estimate.';

  breakdown.innerHTML = state.placed.length ? `
    <p class="estimate-section-label">Selected materials · ${fmtMoney(model.materials)}</p>
    ${model.lines.map(line => {
      const { item, material } = line;
      const component = COMPONENTS[item.type];
      return material ? `<article class="estimate-line-item estimate-material-item">
        <a class="estimate-material-item__image" href="${material.product.url}" target="_blank" rel="noreferrer" aria-label="Shop ${escapeHtml(material.product.title)}"><img src="${material.product.image}" alt=""></a>
        <div>
          <p class="estimate-material-item__fixture">${escapeHtml(itemDisplayName(item))}</p>
          <a class="estimate-material-item__name" href="${material.product.url}" target="_blank" rel="noreferrer">${escapeHtml(material.product.title)}</a>
          <p>${escapeHtml(material.product.brand)} · Model ${escapeHtml(material.product.model)}<br>${escapeHtml(material.label)} · ${escapeHtml(productPriceText(material.product))}</p>
          <div class="estimate-material-item__actions"><button type="button" class="button-secondary" data-action="select-item" data-item-id="${item.id}">Replace</button><button type="button" class="text-button" data-action="remove-product" data-item-id="${item.id}">Remove</button></div>
        </div>
        <strong>${fmtMoney(material.subtotal)}</strong>
      </article>` : `<article class="estimate-line-item estimate-material-item estimate-material-item--empty"><span class="estimate-line-item__icon">${iconSvg(component.iconKey)}</span><div><h4>${escapeHtml(itemDisplayName(item))}</h4><p>No product is selected for this configuration.</p><button type="button" class="button-secondary" data-action="select-item" data-item-id="${item.id}">Choose a product</button></div><strong>—</strong></article>`;
    }).join('')}
    <p class="estimate-section-label">Installation, preparation & scope allowance · ${rangeText(model.installLo, model.installHi)}</p>
    ${state.placed.map(item => {
    const component = COMPONENTS[item.type];
    const installation = baseRange(item).map(value => value * currentLocation().mult);
    const addonCosts = addonRange(item);
    const [itemLo, itemHi] = [installation[0] + addonCosts[0], installation[1] + addonCosts[1]];
    const addons = component.addons
      .filter(addon => item.addons[addon.key])
      .map(addon => addon.label);
    return `
      <article class="estimate-line-item">
        <span class="estimate-line-item__icon">${iconSvg(component.iconKey)}</span>
        <div>
          <h4>${escapeHtml(itemDisplayName(item))}</h4>
          <p>${escapeHtml(TIER_LABEL[item.tier])} planning range · ${fmtNum(item.w)} x ${fmtNum(item.h)} ft${addons.length ? ` · ${escapeHtml(addons.join(', '))}` : ''}</p>
        </div>
        <strong>${rangeText(itemLo, itemHi)}</strong>
      </article>
    `;
  }).join('')}
    <p class="estimate-assumptions">Planning total includes selected-product snapshots plus installation, preparation, and scope allowances. Taxes, delivery, permits, demolition discoveries, and local availability are not included until a qualified quote is confirmed.</p>
  ` : `
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
    ? `Home Depot guides and project ideas selected for ${projectScopeLabel()} in your current plan.`
    : 'Add project items to receive more relevant Home Depot guides and ideas.';

  const collectionTypes = types.length ? types : ['shower', 'vanity', 'tile'];
  const selected = selectedItem();
  const anchorItem = findItem(state.recommendationAnchor?.itemId);
  const anchorProduct = productById(state.recommendationAnchor?.productId);
  const base = anchorProduct || selectedProductFor(anchorItem || selected || state.placed[0]) || recommendedProductFor(selected || state.placed[0]) || PRODUCTS[0];
  const matches = matchingProducts(base, 4);
  if (coordinatedIntro) coordinatedIntro.textContent = `${base.title} is your current anchor. These picks repeat ${base.styles.map(style => sharedStyleLabel(base, { styles: [style] })).slice(0, 2).join(' and ')}.`;
  const roomLook = selectedProducts();
  const comparisonProduct = productById(state.comparison?.productId);
  const comparisonItem = findItem(state.comparison?.itemId);
  const currentProduct = comparisonItem ? selectedProductFor(comparisonItem) : null;
  const comparison = comparisonProduct && comparisonItem ? `
    <section class="product-comparison" aria-live="polite">
      <div><span>Comparing</span><strong>${escapeHtml(currentProduct?.title || 'No product selected')}</strong><em>${escapeHtml(currentProduct ? productPriceText(currentProduct) : 'Choose a product first')}</em></div>
      <div><span>With</span><strong>${escapeHtml(comparisonProduct.title)}</strong><em>${escapeHtml(productPriceText(comparisonProduct))}</em></div>
      <button type="button" class="button-secondary" data-action="clear-comparison">Close comparison</button>
    </section>` : '';
  coordinatedTarget.innerHTML = `
    <section class="room-look-summary" aria-label="My room look">
      <h4>My room look</h4>
      <p>${roomLook.length ? 'Your selected products stay together as you compare coordinated alternatives.' : 'Choose a compatible product to start your room look.'}</p>
      ${roomLook.map(({ item, product }) => `<div class="room-look-summary__item"><span><strong>${escapeHtml(itemDisplayName(item))}</strong><br>${escapeHtml(product.title)}</span><button type="button" data-action="remove-product" data-item-id="${item.id}">Remove</button></div>`).join('')}
    </section>
    ${comparison}
    <article class="room-anchor-card">
      <span>Your starting point</span>
      <img src="${base.image}" alt="${escapeHtml(base.title)}">
      <div><strong>${escapeHtml(base.title)}</strong><em>${escapeHtml(productPriceText(base))}</em></div>
    </article>
    ${matches.map(product => fullProductCardMarkup(product, base, state.placed.find(item => item.type === product.type) || null)).join('')}
  `;

  productsTarget.innerHTML = collectionTypes.map(type => {
    const plannedItem = state.placed.find(item => item.type === type);
    const options = plannedItem ? productsForItem(plannedItem) : productsForType(type);
    return `
      <section class="product-collection">
        <div class="product-collection__head">
          <span class="guide-collection__icon">${iconSvg(COMPONENTS[type].iconKey)}</span>
          <div><h4>${escapeHtml(COMPONENTS[type].label)}</h4><p>Value, upgraded, and premium choices</p></div>
        </div>
        <div class="product-card-row">${options.length ? options.map(product => fullProductCardMarkup(product, base, plannedItem)).join('') : '<p class="product-empty">No compatible sample product is available for this configuration yet. Adjust the configuration or add a real assortment record.</p>'}</div>
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
    <button class="pill-button${opening.wall === wall.key ? ' is-active' : ''}" type="button" data-action="opening-wall" data-opening-id="${opening.id}" data-wall="${wall.key}" aria-pressed="${opening.wall === wall.key}">${escapeHtml(wall.label.replace(' wall', ''))}</button>
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
  const activeProduct = selectedProductFor(item);
  const productOptions = productsForItem(item);
  const accessoryMatches = item.type === 'vanity' && activeProduct ? VANITY_ACCESSORIES.filter(accessory => !accessory.forProduct || (Array.isArray(accessory.forProduct) ? accessory.forProduct.includes(activeProduct.id) : accessory.forProduct === activeProduct.id)) : [];
  const variants = c.variants.map(variant => `
    <button class="pill-button${item.name === variant ? ' is-active' : ''}" type="button" data-action="variant" data-id="${item.id}" data-value="${escapeHtml(variant)}" aria-pressed="${item.name === variant}">${escapeHtml(variant)}</button>
  `).join('');
  const tiers = ['good', 'better', 'best'].map(tier => `
    <button class="tier-button${item.tier === tier ? ' is-active' : ''}" type="button" data-action="tier" data-id="${item.id}" data-tier="${tier}" aria-pressed="${item.tier === tier}">
      <span class="tier-label">${TIER_LABEL[tier]}</span>
      <span class="tier-short">${TIER_SHORT[tier]}</span>
    </button>
  `).join('');
  const addons = c.addons.length ? c.addons.map(addon => {
    const included = productIncludes(activeProduct, addon);
    const active = !!item.addons[addon.key] && !included;
    const price = rangeText(addon.lo * currentLocation().mult, addon.hi * currentLocation().mult);
    return `
      <button class="addon-row${active ? ' is-active' : ''}" type="button" data-action="addon" data-id="${item.id}" data-addon="${addon.key}"${included ? ' disabled aria-describedby="includedAddonNote"' : ''}>
        <span class="addon-check">${active ? '&#10003;' : ''}</span>
        <span>
          <span class="addon-title">${escapeHtml(addon.label)}</span>
          <span class="addon-desc">${included ? 'Included with your selected product' : escapeHtml(addon.desc)}</span>
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
          <h2>${escapeHtml(itemDisplayName(item))}</h2>
          <p>${escapeHtml(c.label)}</p>
        </div>
      </div>

      <section class="inspector-section inspector-section--variants" aria-label="Configuration">
        <div class="variant-row">${variants}</div>
      </section>

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

      <p class="selected-range"><span>This item</span><strong>${rangeText(lo, hi)}</strong></p>

      <section class="product-match-panel" aria-labelledby="productMatchTitle">
        <div class="product-match-panel__head">
          <div>
            <span>Real products at The Home Depot</span>
            <h3 id="productMatchTitle">Compatible products for this configuration</h3>
          </div>
          <span class="match-badge">${productOptions.length} compatible choice${productOptions.length === 1 ? '' : 's'}</span>
        </div>
        <div class="product-option-list">
          ${productOptions.length ? productOptions.map(product => productOptionMarkup(product, item, activeProduct?.id === product.id)).join('') : `<p class="product-empty">No compatible sample product is available for this ${escapeHtml(item.name.toLowerCase())} configuration. Choose another configuration or browse the related Home Depot category.</p>`}
        </div>
        ${accessoryMatches.length ? `
          <div class="vanity-pairings">
            <strong>Complete this vanity</strong>
          <p>The ${escapeHtml(activeProduct.title)} includes its countertop. Add these coordinated pieces:</p>
            ${accessoryMatches.map(accessory => `<a href="${accessory.url}" target="_blank" rel="noreferrer"><span>${escapeHtml(accessory.label)}</span><strong>${escapeHtml(accessory.title)}</strong><em>${escapeHtml(accessory.price)}</em></a>`).join('')}
          </div>
        ` : ''}
        <p id="includedAddonNote" class="product-price-note">Sample prices checked July 14, 2026. Local price and availability may vary; included product parts are not added twice to the planning range.</p>
      </section>

      <section class="inspector-section">
        <h3>Add-ons</h3>
        <div class="addon-list">${addons}</div>
      </section>

      <a class="guide-spotlight" href="${spotlight.url || HOME_DEPOT_BATHROOM_HUB}" target="_blank" rel="noreferrer">
        <span class="guide-spotlight__thumb"><img src="${spotlight.image}" alt=""></span>
        <span class="guide-spotlight__body">
          <span class="guide-spotlight__kicker">Recommended guide</span>
          <strong>${escapeHtml(spotlight.title)}</strong>
          <span>${escapeHtml(spotlight.reason)}</span>
        </span>
      </a>

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
  const cleared = clearIncompatibleProduct(item);
  renderAll();
  if (cleared) announce(`${cleared.title} was removed because the updated dimensions are not compatible.`);
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
  state.placed.forEach(clearIncompatibleProduct);
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

function capturePointer(target, pointerId) {
  if (target instanceof Element && target.setPointerCapture) {
    try { target.setPointerCapture(pointerId); } catch (_) { /* A detached target cannot retain capture. */ }
  }
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
    clearIncompatibleProduct(item);
    renderAll();
  }
}

function handlePointerUp(e) {
  if (!drag) return;
  if (drag.mode === 'palette') {
    suppressPaletteClick = true;
    window.setTimeout(() => {
      suppressPaletteClick = false;
    }, 400);
    if (drag.moved && isInsideCanvas(e.clientX, e.clientY)) {
      const item = createItem(drag.type, 0.5, 0.5);
      const pos = pointToNorm(e.clientX, e.clientY, item);
      addItem(drag.type, pos.nx, pos.ny);
    } else if (!drag.moved) {
      addItem(drag.type);
    }
  }
  cleanupDrag();
}

document.addEventListener('pointerdown', e => {
  const openingMarker = e.target.closest('.room-feature');
  if (openingMarker) {
    const opening = findOpening(openingMarker.dataset.openingId);
    if (!opening) return;
    state.selectedOpeningId = opening.id;
    state.selectedId = null;
    beginOpeningDrag(opening, e);
    capturePointer(openingMarker, e.pointerId);
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
    capturePointer(resize, e.pointerId);
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
    capturePointer(planItem, e.pointerId);
    e.preventDefault();
    renderAll();
    return;
  }

  const palette = e.target.closest('[data-action="palette"]');
  if (palette) {
    beginPaletteDrag(palette.dataset.type, e);
    capturePointer(palette, e.pointerId);
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
    if (action === 'palette') {
      if (!suppressPaletteClick) addItem(actionTarget.dataset.type);
      return;
    }
    if (action === 'choose-product') {
      const product = productById(actionTarget.dataset.productId);
      const item = findItem(actionTarget.dataset.itemId) || state.placed.find(candidate => candidate.type === product?.type);
      if (!product || !item || !selectProduct(item, product)) return;
      renderAll();
      announce(`${product.title} selected for ${itemDisplayName(item)}.`);
      return;
    }
    if (action === 'cart-handoff') {
      const status = $('#cartHandoffStatus');
      if (!status) return;
      const count = selectedProducts().length;
      status.hidden = false;
      status.textContent = count
        ? `This prototype has ${count} selected product${count === 1 ? '' : 's'} ready, but it is not connected to an approved Home Depot cart API. Use the exact product links below to shop them.`
        : 'Choose products before preparing a cart handoff.';
      return;
    }
    if (action === 'compare-product') {
      const product = productById(actionTarget.dataset.productId);
      const item = findItem(actionTarget.dataset.itemId);
      if (!product || !item) return;
      state.comparison = { itemId: item.id, productId: product.id };
      renderAll();
      announce(`Comparing ${product.title} for ${itemDisplayName(item)}.`);
      return;
    }
    if (action === 'clear-comparison') {
      state.comparison = null;
      renderAll();
      return;
    }
    if (action === 'location') {
      state.location = actionTarget.dataset.location;
      sessionStorage.setItem('bathroomPlannerMarket', state.location);
      state.locOpen = false;
      renderAll();
      announce(`${locationLabel()} selected.`);
      return;
    }
    if (action === 'view') {
      state.view = actionTarget.dataset.view;
      renderAll();
      return;
    }
    if (action === 'mobile-mode') {
      const mode = actionTarget.dataset.mobileMode;
      if (mode === 'summary') {
        state.view = 'estimate';
      } else {
        state.view = 'plan';
        state.mobileMode = mode;
      }
      renderAll();
      return;
    }
    if (action === 'palette-select') {
      const item = state.placed.find(candidate => candidate.type === actionTarget.dataset.type);
      if (!item) return;
      state.selectedId = item.id;
      state.selectedOpeningId = null;
      renderAll();
      announce(`${itemDisplayName(item)} selected on your plan.`);
      return;
    }
    if (action === 'opening-palette-select') {
      const opening = state.openings.find(candidate => candidate.type === actionTarget.dataset.openingType);
      if (!opening) return;
      state.selectedOpeningId = opening.id;
      state.selectedId = null;
      renderAll();
      announce(`${openingName(opening)} selected on your plan.`);
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
    if (action === 'resolve-overlaps') {
      resolveOverlaps();
      return;
    }
    if (action === 'remove-product') {
      const item = findItem(actionTarget.dataset.itemId);
      if (!item) return;
      item.productId = null;
      if (state.recommendationAnchor?.itemId === item.id) state.recommendationAnchor = null;
      renderAll();
      announce(`Product removed from ${itemDisplayName(item)}.`);
      return;
    }
    if (action === 'select-item') {
      const item = findItem(actionTarget.dataset.itemId);
      if (!item) return;
      state.selectedId = item.id;
      state.selectedOpeningId = null;
      state.view = 'plan';
      state.mobileMode = 'details';
      renderAll();
      restorePlannerFocus(`#inspectorContent`);
      return;
    }
    if (action === 'remove') {
      removeItem(Number(actionTarget.dataset.id));
      return;
    }
    if (action === 'variant') {
      const item = findItem(actionTarget.dataset.id);
      if (item) {
        item.name = actionTarget.dataset.value;
        const cleared = clearIncompatibleProduct(item);
        if (cleared) announce(`${cleared.title} was removed because it does not fit the ${item.name.toLowerCase()} configuration.`);
      }
      renderAll();
      return;
    }
    if (action === 'tier') {
      const item = findItem(actionTarget.dataset.id);
      if (item) {
        item.tier = actionTarget.dataset.tier;
      }
      renderAll();
      return;
    }
    if (action === 'addon') {
      const item = findItem(actionTarget.dataset.id);
      const addon = item && COMPONENTS[item.type].addons.find(candidate => candidate.key === actionTarget.dataset.addon);
      if (item && addon && !productIncludes(selectedProductFor(item), addon)) item.addons[actionTarget.dataset.addon] = !item.addons[actionTarget.dataset.addon];
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
  const tab = e.target.closest('[role="tab"][data-action="view"], [role="tab"][data-action="mobile-mode"]');
  if (tab && ['ArrowLeft', 'ArrowRight', 'Home', 'End'].includes(e.key)) {
    const tabs = [...tab.parentElement.querySelectorAll('[role="tab"]')];
    const index = tabs.indexOf(tab);
    const nextIndex = e.key === 'Home' ? 0 : e.key === 'End' ? tabs.length - 1 : (index + (e.key === 'ArrowRight' ? 1 : -1) + tabs.length) % tabs.length;
    e.preventDefault();
    tabs[nextIndex].focus();
    tabs[nextIndex].click();
    return;
  }

  if (e.target.id === 'locationToggle' && ['ArrowDown', 'ArrowUp', 'Enter', ' '].includes(e.key)) {
    e.preventDefault();
    state.locOpen = true;
    renderAll();
    window.requestAnimationFrame(() => $('#locationMenu [role="option"]')?.focus());
    return;
  }

  if (state.locOpen) {
    const options = [...document.querySelectorAll('#locationMenu [role="option"]')];
    const currentIndex = options.indexOf(document.activeElement);
    if (e.key === 'Escape') {
      e.preventDefault();
      state.locOpen = false;
      renderAll();
      $('#locationToggle').focus();
      return;
    }
    if (['ArrowDown', 'ArrowUp'].includes(e.key) && currentIndex >= 0) {
      e.preventDefault();
      const next = (currentIndex + (e.key === 'ArrowDown' ? 1 : -1) + options.length) % options.length;
      options[next].focus();
      return;
    }
    if ((e.key === 'Enter' || e.key === ' ') && currentIndex >= 0) {
      e.preventDefault();
      options[currentIndex].click();
      return;
    }
  }

  const palette = e.target.closest('[data-action="palette"]');
  if (palette && (e.key === 'Enter' || e.key === ' ')) {
    e.preventDefault();
    addItem(palette.dataset.type);
    restorePlannerFocus(`[data-action="palette"][data-type="${palette.dataset.type}"]`);
    return;
  }

  const resize = e.target.closest('[data-action="resize"]');
  if (resize && ['ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown'].includes(e.key)) {
    const item = findItem(resize.dataset.id);
    if (!item) return;
    const step = e.shiftKey ? 1 : 0.5;
    const axis = ['ArrowLeft', 'ArrowRight'].includes(e.key) ? 'w' : 'h';
    const delta = ['ArrowLeft', 'ArrowUp'].includes(e.key) ? -step : step;
    e.preventDefault();
    item[axis] = clamp(snap(item[axis] + delta), 0.5, axis === 'w' ? state.roomW : state.roomH);
    clampItem(item);
    renderAll();
    restorePlannerFocus(`[data-action="resize"][data-id="${item.id}"]`);
    announce(`${item.name} ${axis === 'w' ? 'width' : 'depth'} is now ${fmtNum(item[axis])} feet.`);
    return;
  }

  const planItem = e.target.closest('.plan-item');
  const onCanvas = e.target.id === 'planCanvas';
  if ((planItem || onCanvas) && ['ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown'].includes(e.key)) {
    const item = planItem ? findItem(planItem.dataset.id) : selectedItem();
    if (!item) return;
    const step = e.shiftKey ? 1 : 0.5;
    const dx = e.key === 'ArrowLeft' ? -step : e.key === 'ArrowRight' ? step : 0;
    const dy = e.key === 'ArrowUp' ? -step : e.key === 'ArrowDown' ? step : 0;
    e.preventDefault();
    item.nx += dx / state.roomW;
    item.ny += dy / state.roomH;
    clampItem(item);
    state.selectedId = item.id;
    state.selectedOpeningId = null;
    renderAll();
    restorePlannerFocus(planItem ? `.plan-item[data-id="${item.id}"]` : '#planCanvas');
    announce(`${item.name} moved ${Math.abs(dx || dy)} feet.`);
    return;
  }

  if (planItem && (e.key === 'Enter' || e.key === ' ')) {
    e.preventDefault();
    const item = findItem(planItem.dataset.id);
    if (!item) return;
    state.selectedId = item.id;
    state.selectedOpeningId = null;
    renderAll();
    restorePlannerFocus(`.plan-item[data-id="${item.id}"]`);
    announce(`${item.name} selected. Use arrow keys to move it.`);
    return;
  }

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
  state.locOpen = !state.locOpen;
  renderAll();
});

let lastModalTrigger = null;

function setDownloadError(message = '') {
  const target = $('#downloadError');
  if (!target) return;
  target.hidden = !message;
  target.textContent = message;
}

function setModalBackground(isInert) {
  [...document.body.children]
    .filter(child => child.id !== 'briefModal')
    .forEach(child => child.toggleAttribute('inert', isInert));
}

function closeDownloadModal() {
  $('#briefModal').hidden = true;
  setDownloadError();
  setModalBackground(false);
  lastModalTrigger?.focus();
  lastModalTrigger = null;
}

function openDownloadModal(trigger = document.activeElement) {
  const [lo, hi] = estimateRange();
  const modal = $('#briefModal');
  lastModalTrigger = trigger instanceof HTMLElement ? trigger : document.activeElement;
  setDownloadError();
  $('#briefSummary').textContent = state.placed.length
    ? `${state.placed.length} project item${state.placed.length === 1 ? '' : 's'} in a ${fmtNum(state.roomW)} x ${fmtNum(state.roomH)} ft bathroom for ${locationLabel()}. Planning range: ${rangeText(lo, hi)}. Add optional details to label your local PDF.`
    : 'Add fixtures to generate a store-ready project plan.';
  modal.hidden = false;
  setModalBackground(true);
  $('#leadName').focus();
}

['quoteButton', 'downloadPlanButton', 'estimateDownloadButton'].forEach(id => {
  $(`#${id}`)?.addEventListener('click', event => openDownloadModal(event.currentTarget));
});

$('#modalClose').addEventListener('click', closeDownloadModal);

$('#briefModal').addEventListener('click', e => {
  if (e.target.id === 'briefModal') closeDownloadModal();
});

document.addEventListener('keydown', e => {
  const modal = $('#briefModal');
  if (modal.hidden) return;
  if (e.key === 'Escape') {
    e.preventDefault();
    closeDownloadModal();
    return;
  }
  if (e.key !== 'Tab') return;
  const focusable = [...modal.querySelectorAll('button:not([disabled]), input:not([disabled]), [href]')]
    .filter(element => !element.hidden);
  const current = focusable.indexOf(document.activeElement);
  if (e.shiftKey && (current <= 0 || document.activeElement === modal)) {
    e.preventDefault();
    focusable.at(-1)?.focus();
  } else if (!e.shiftKey && current === focusable.length - 1) {
    e.preventDefault();
    focusable[0]?.focus();
  }
});

function planPdfLines(lead) {
  const model = projectCostModel();
  const [lo, hi] = [model.lo, model.hi];
  const preparedFor = [lead.name, lead.email].filter(Boolean).join(' · ');
  return [
    'BATHROOM REMODEL PROJECT PLAN',
    'Prepared with The Home Depot Project Planner',
    `Prepared for: ${preparedFor || 'Not provided'}`,
    '',
    `Room: ${fmtNum(state.roomW)} x ${fmtNum(state.roomH)} ft (${fmtNum(state.roomW * state.roomH)} sq ft)`,
    `Location: ${locationLabel()}`,
    `Estimated range: ${state.placed.length ? rangeText(lo, hi) : '$0'}`,
    `Selected products: ${fmtMoney(model.materials)}`,
    `Installation, preparation & scope allowance: ${rangeText(model.installLo, model.installHi)}`,
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
      return `- ${itemDisplayName(item)}: ${fmtNum(item.w)} x ${fmtNum(item.h)} ft, ${TIER_LABEL[item.tier]} tier, ${rangeText(itemLo, itemHi)}${addonLabels.length ? `, add-ons: ${addonLabels.join(', ')}` : ''}`;
    }),
    '',
    'PRODUCT SELECTIONS',
    ...state.placed.map(item => {
      const product = selectedProductFor(item);
      const quantity = product ? materialQuantity(item, product) : null;
      return product
        ? `- ${itemDisplayName(item)}: ${product.brand} ${product.title}, ${productPriceText(product)}, ${quantity.label}, model ${product.model} - ${product.url}`
        : `- ${itemDisplayName(item)}: no compatible sample product selected`;
    }),
    '',
    'LAYOUT REVIEW',
    ...(layoutWarnings().length ? layoutWarnings().map(warning => `- ${warning}`) : ['- No overlap or fit warnings detected']),
    '',
    'ESTIMATE ASSUMPTIONS',
    '- Sample prices checked July 14, 2026. Local price and availability may vary.',
    '- Taxes, delivery, permits, demolition discoveries, and final installation scope are not included.',
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
    if (line === 'ROOM OPENINGS' || line === 'SCOPE' || line === 'PRODUCT SELECTIONS' || line === 'LAYOUT REVIEW' || line === 'ESTIMATE ASSUMPTIONS' || line === 'RECOMMENDED GUIDES' || line === 'NEXT STEP') {
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
  if (!(blob instanceof Blob) || blob.size === 0) throw new Error('The project plan could not be created.');
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
  try {
    downloadPlanPdf({
      name: $('#leadName').value.trim(),
      email: $('#leadEmail').value.trim(),
    });
    closeDownloadModal();
  } catch (error) {
    console.error('Project plan download failed.', error);
    setDownloadError('The project plan could not be downloaded. Please try again.');
  }
});

const productDataErrors = validateProductData();
if (productDataErrors.length) console.error(`Product data validation failed: ${productDataErrors.join('; ')}`);

renderAll();
