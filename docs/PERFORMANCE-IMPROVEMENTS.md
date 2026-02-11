# Website Performance Improvements

Based on the Lighthouse report for `http://rosacare.test/products` (rosacare.test-20260205T153618.html).

## Current scores (summary)

| Metric | Value | Score | Target |
|--------|--------|-------|--------|
| **Performance** | — | **0.7** | ≥ 0.9 |
| First Contentful Paint (FCP) | 2.9 s | 0.53 | < 1.8 s |
| **Largest Contentful Paint (LCP)** | **23.8 s** | **0** | < 2.5 s |
| Speed Index | 2.9 s | 0.95 | Good |
| Total Blocking Time (TBT) | 0 ms | 1 | Good |
| Cumulative Layout Shift (CLS) | 0 | 1 | Good |
| **Time to Interactive (TTI)** | **24.2 s** | **0** | < 3.8 s |

The main issues are **LCP** and **TTI** (very high), plus **FCP** and **unused JavaScript**.

---

## 1. Fix Largest Contentful Paint (LCP) – critical

**Problem:** LCP is 23.8 s, so the main content (likely hero image or product images) is loading very late.

**Actions:**

- **Prioritize the LCP element**
  - Identify the LCP element on `/products` (hero, first product image, or big banner).
  - Use `<link rel="preload">` for the LCP image (and optionally the LCP font) in the layout head.
- **Optimize images**
  - Serve images in modern formats (WebP/AVIF) with a fallback.
  - Use responsive images: `srcset` + `sizes` so the browser doesn’t load oversized images.
  - Lazy-load images below the fold; do **not** lazy-load the LCP image.
- **Reduce server response time**
  - Root document took ~540 ms. Use response caching (e.g. full-page or fragment cache for the products index) and ensure DB queries are optimized (e.g. eager load, indexes).

---

## 2. Reduce JavaScript cost and improve TTI

**Problem:** TTI 24.2 s and ~101 KiB unused JavaScript (main app bundle + dropdown chunk).

**Actions:**

- **Code splitting**
  - Use route-based (lazy) code splitting so the products page doesn’t load the whole app bundle up front.
  - In Vite/React, use `React.lazy()` + `Suspense` for route components (e.g. Products Index, Home, About).
- **Trim unused JS**
  - The report flags `app-R2VdD8Yl.js` and `dropdown-menu-C_JbKYE9.js`. Tree-shake unused exports and avoid pulling in large libraries for a single feature.
  - Consider dynamic import for heavy UI (e.g. dropdown menu, Swiper) only when needed.
- **Defer non-critical script**
  - Keep critical path minimal; load analytics and non-essential scripts with `defer` or after interaction.

---

## 3. Improve First Contentful Paint (FCP)

**Problem:** FCP 2.9 s (target < 1.8 s).

**Actions:**

- **Fonts**
  - Preload the main font used for above-the-fold text (e.g. Alexandria):
    ```html
    <link rel="preload" href="/fonts/alexandria/Alexandria-Light.ttf" as="font" type="font/ttf" crossorigin>
    ```
  - Use `font-display: swap` (or optional) in `@font-face` so text appears immediately with a fallback font.
- **Critical CSS**
  - Inline or preload critical above-the-fold CSS; load the rest asynchronously so it doesn’t block first paint.
- **Reduce render-blocking**
  - If any stylesheets or scripts are render-blocking, move or defer them (e.g. non-critical CSS with `media="print"` and switch to `all` on load).

---

## 4. Images: sizing and layout stability

**Problem:** “Set an explicit width and height on image elements” (unsized images, score 0.5).

**Actions:**

- Add explicit `width` and `height` (or `aspect-ratio`) to `<img>` and image wrappers so the browser can reserve space and avoid layout shift.
- Use CSS `object-fit` to keep aspect ratio without causing CLS (you already have CLS 0; this keeps it stable as you add more images).

---

## 5. Preloader and perceived performance

**Current:** Preloader hides when the page is “fully loaded.”

**Suggestion:**

- Hide the preloader as soon as the main content is visible (e.g. on FCP or when the LCP element has loaded), not on full load.
- Optionally remove the preloader on fast connections (e.g. when load completes in < 1.5 s) to avoid unnecessary delay.

---

## 6. HTTPS (for production)

**Problem:** “Does not use HTTPS” and “22 insecure requests” (expected on local `.test`).

**Action:** In production, serve the site over HTTPS and redirect HTTP to HTTPS so the report and real users get a secure experience.

---

## 7. Vite / build configuration

**Suggestions:**

- Ensure **minification** is enabled for production (Vite does this by default).
- Enable **code splitting** by route (see section 2).
- Consider **manual chunks** in `vite.config.ts` for large vendor libs (e.g. Swiper, MUI) so they are cached separately and not re-downloaded on every app change.
- Run a production build and re-run Lighthouse: `npm run build` then test `http://rosacare.test/products` with the built assets.

---

## 8. Quick wins checklist

- [ ] Preload LCP image (and main font) in the layout.
- [ ] Add `width`/`height` (or `aspect-ratio`) to product and hero images.
- [ ] Use `font-display: swap` (or equivalent) for Alexandria (and any other custom fonts).
- [ ] Lazy-load images below the fold; exclude the LCP image.
- [ ] Introduce route-based code splitting (e.g. `React.lazy` for page components).
- [ ] Cache the products index response (or key fragments) where possible.
- [ ] Hide preloader on FCP or LCP instead of full load.
- [ ] Re-run Lighthouse after each change to validate improvements.

---

## 9. Re-testing

After applying changes:

1. Run a production build: `npm run build`
2. Open the site (e.g. `http://rosacare.test/products`)
3. Run Lighthouse again (Performance, mobile) and compare LCP, FCP, TTI, and Performance score.

Focus first on **LCP** and **TTI** (preload LCP resource, reduce JS, code splitting); then **FCP** (fonts, critical CSS); then image sizing and preloader behavior.
