# Walgreens BCE — generated output

**Do not hand-edit the files in this folder.** Everything here except this
README is the build output of a Next.js static export. Edits will be lost on
the next rebuild.

## Source

The demo lives in a separate repo: `~/BCE Demo 1` (branch
`in-app-browser-live`). It's a Next.js 16 frontend plus a FastAPI backend that
does the real image analysis.

## Rebuilding

From `frontend/` in the source repo:

```bash
BCE_STATIC_EXPORT=1 NEXT_PUBLIC_DEMO_MODE=1 NEXT_PUBLIC_BASE_PATH=/bce/walgreens npm run build
```

Then copy `out/` over this folder, keeping this README.

The three env vars matter:

- `BCE_STATIC_EXPORT=1` — turns on `output: "export"`, `basePath:
  "/bce/walgreens"`, `trailingSlash`, and unoptimized images.
- `NEXT_PUBLIC_BASE_PATH` — feeds `lib/basePath.ts`. Next's `basePath` rewrites
  `next/link` and `_next/*` but NOT raw `<img>`/`<video>`/`<a>` or
  `next/image` under `unoptimized`, so those go through `asset()`.
- `NEXT_PUBLIC_DEMO_MODE=1` — **the scan is canned.** `postAnalyze()` returns
  the hardcoded `SAMPLE_SCAN` after a short delay instead of POSTing to the
  backend, and telemetry is disabled. There is no backend deployed for this
  build; the walkthrough is clickable end to end but the results shown are
  **not** derived from the visitor's photos.

To make the analysis real, deploy `backend/` somewhere public, drop
`NEXT_PUBLIC_DEMO_MODE`, set `NEXT_PUBLIC_BACKEND_URL` to that host, and add
this site's origin to the CORS allowlist in `backend/app/main.py`.

## Live URL

https://stretch-creative.onrender.com/bce/walgreens/
