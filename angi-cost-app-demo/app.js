/* =========================================================================
   "Build Your Bathroom Remodel" assembler — demo logic.
   Plain vanilla JS, no dependencies. Numbers are illustrative.
   ========================================================================= */

// Each component carries good/better/best ranges (national, install included).
const COMPONENTS = [
  { id: 'shower',  name: 'Shower / tub',        on: true,
    tiers: { Good: [3000, 4500],  Better: [5000, 7500],  Best: [9000, 14000] } },
  { id: 'vanity',  name: 'Vanity & sink',       on: true,
    tiers: { Good: [800, 1500],   Better: [1800, 3000],  Best: [3500, 6000] } },
  { id: 'tile',    name: 'Tile & walls',        on: true,
    tiers: { Good: [1000, 2000],  Better: [2500, 4500],  Best: [5000, 9000] } },
  { id: 'floor',   name: 'Flooring',            on: true,
    tiers: { Good: [600, 1200],   Better: [1500, 2800],  Best: [3000, 5500] } },
  { id: 'toilet',  name: 'Toilet',              on: true,
    tiers: { Good: [250, 450],    Better: [500, 900],    Best: [1000, 1800] } },
  { id: 'light',   name: 'Lighting & electrical', on: false,
    tiers: { Good: [400, 800],    Better: [1000, 1800],  Best: [2200, 4000] } },
  { id: 'plumb',   name: 'Move plumbing',       on: false,
    tiers: { Good: [1000, 1800],  Better: [2500, 4000],  Best: [5000, 8000] } },
];

const TIER_NAMES = ['Good', 'Better', 'Best'];

// --- state ---
const state = COMPONENTS.map(c => ({ ...c, tier: 'Better' }));
let multiplier = 1.0;

// --- helpers ---
const fmt = n => '$' + Math.round(n).toLocaleString('en-US');
const $ = sel => document.querySelector(sel);

// --- render component rows ---
function renderComponents() {
  const wrap = $('#components');
  wrap.innerHTML = '';
  state.forEach((c, i) => {
    const row = document.createElement('label');
    row.className = 'cmp' + (c.on ? ' cmp--on' : '');
    row.setAttribute('aria-disabled', String(!c.on));

    const [lo, hi] = c.tiers[c.tier];
    row.innerHTML = `
      <input type="checkbox" class="cmp__check" ${c.on ? 'checked' : ''} data-i="${i}">
      <span class="cmp__name">${c.name}</span>
      <select class="cmp__tier" data-i="${i}" ${c.on ? '' : 'disabled'}>
        ${TIER_NAMES.map(t => `<option ${t === c.tier ? 'selected' : ''}>${t}</option>`).join('')}
      </select>
      <span class="cmp__price">${c.on ? fmt(lo * multiplier) + '–' + fmt(hi * multiplier) : '—'}</span>`;
    wrap.appendChild(row);
  });
}

// --- recompute totals + breakdown ---
function recompute() {
  let lo = 0, hi = 0;
  const rows = [];
  state.forEach(c => {
    if (!c.on) return;
    const [l, h] = c.tiers[c.tier];
    lo += l * multiplier;
    hi += h * multiplier;
    rows.push({ name: c.name, tier: c.tier, lo: l * multiplier, hi: h * multiplier });
  });

  $('#total').textContent = rows.length ? fmt(lo) + ' – ' + fmt(hi) : '$0';

  $('#breakdown').innerHTML = rows.map(r =>
    `<tr><td>${r.name}</td><td>${r.tier}</td>
     <td style="text-align:right">${fmt(r.lo)} – ${fmt(r.hi)}</td></tr>`
  ).join('') || `<tr><td colspan="3" style="color:var(--angi-text-muted)">Select at least one item.</td></tr>`;

  return { lo, hi, rows };
}

// --- events ---
document.addEventListener('change', e => {
  const i = e.target.dataset.i;
  if (i === undefined) {
    if (e.target.id === 'loc') { multiplier = parseFloat(e.target.value); renderComponents(); recompute(); }
    return;
  }
  if (e.target.classList.contains('cmp__check')) state[i].on = e.target.checked;
  if (e.target.classList.contains('cmp__tier'))  state[i].tier = e.target.value;
  renderComponents();
  recompute();
});

// =========================================================================
//  Email gate + downloadable project brief
// =========================================================================
const modal = $('#modal');
$('#getBrief').addEventListener('click', () => { modal.hidden = false; });
$('#modalClose').addEventListener('click', () => { modal.hidden = true; });
modal.addEventListener('click', e => { if (e.target === modal) modal.hidden = true; });

$('#briefForm').addEventListener('submit', e => {
  e.preventDefault();
  const { lo, hi, rows } = recompute();
  const locName = $('#loc').selectedOptions[0].textContent;
  downloadBrief(rows, lo, hi, locName, $('#email').value);
  $('#modalTitle').textContent = 'Your brief is downloading ✓';
  $('#briefForm').innerHTML =
    '<p style="margin:0">Thanks! We\'ve matched you with <strong>3 local pros</strong> who can quote from your brief. ' +
    '(Demo — no real matching happens.)</p>';
});

function downloadBrief(rows, lo, hi, locName, email) {
  const line = '—'.repeat(48);
  let txt = '';
  txt += 'BATHROOM REMODEL — PROJECT BRIEF\n';
  txt += 'Prepared with Angi  •  ' + new Date().toLocaleDateString() + '\n';
  txt += line + '\n\n';
  txt += 'Location:        ' + locName + '\n';
  txt += 'Prepared for:    ' + (email || 'homeowner') + '\n';
  txt += 'Estimated range: ' + fmt(lo) + ' – ' + fmt(hi) + '\n\n';
  txt += 'SCOPE OF WORK\n' + line + '\n';
  rows.forEach(r => {
    txt += '• ' + r.name.padEnd(24) + '[' + r.tier + ']  '
        + fmt(r.lo) + ' – ' + fmt(r.hi) + '\n';
  });
  txt += '\nNOTES FOR CONTRACTOR\n' + line + '\n';
  txt += '- This is a homeowner-generated estimate; please provide a firm quote.\n';
  txt += '- Please itemize labor vs. materials.\n';
  txt += '- Confirm license, insurance, and projected timeline.\n';
  txt += '- Flag any costs not captured above (permits, disposal, surprises).\n';

  const blob = new Blob([txt], { type: 'text/plain' });
  const a = document.createElement('a');
  a.href = URL.createObjectURL(blob);
  a.download = 'bathroom-remodel-project-brief.txt';
  a.click();
  URL.revokeObjectURL(a.href);
}

// --- init ---
renderComponents();
recompute();
