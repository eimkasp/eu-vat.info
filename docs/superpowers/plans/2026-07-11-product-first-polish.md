# Product-first Polish Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Deliver a restrained, product-first polish of the EU VAT Info shared shell and homepage while fixing the EU-only data trust issue.

**Architecture:** Preserve the Laravel 11 and Livewire 3 component boundaries. Centralize reusable visual decisions in Tailwind theme values and `resources/css/app.css`, then align the shared Blade shell and homepage components to those decisions. Change data behavior only in `App\Livewire\Home`, protected by a focused Livewire regression test.

**Tech Stack:** PHP 8.2+, Laravel 11, Livewire 3, Blade, Tailwind CSS 3, DaisyUI 4, Pest 2, Vite 5.

## Global Constraints

- Product personality is authoritative, calm, and efficient.
- Avoid generic SaaS styling: excessive gradients, oversized decorative cards, vanity metrics, glass effects, and flashy motion.
- Target WCAG 2.2 AA with visible focus, reduced motion, keyboard access, and 44px touch targets.
- Preserve routes, translations, SEO metadata, structured data, and existing calculator behavior.
- Keep institutional blue `#003399`; reserve action blue for actions, selection, links, and focus.

---

### Task 1: Protect EU-only homepage data

**Files:**
- Create: `tests/Feature/HomepageCountryScopeTest.php`
- Modify: `app/Livewire/Home.php`

**Interfaces:**
- Consumes: `Country.is_eu_member` boolean cast and the existing `Home::$euCountries` collection.
- Produces: Homepage country data containing EU members only, sorted by `standard_rate` ascending and still filterable by `Home::$search`.

- [ ] **Step 1: Write the failing Livewire test**

Create two countries with distinct `is_eu_member` values, render `Home`, and assert the EU country is visible while the non-EU country is absent from `euCountries`.

- [ ] **Step 2: Run the focused test and verify RED**

Run: `php artisan test tests/Feature/HomepageCountryScopeTest.php`
Expected: FAIL because `Home::render()` currently calls `Country::orderBy(...)` without the EU membership scope.

- [ ] **Step 3: Add the EU membership scope**

Change the cached query to `Country::where('is_eu_member', true)->orderBy('standard_rate', 'ASC')->get()` and version the cache key so stale all-country data is not reused.

- [ ] **Step 4: Run the focused test and verify GREEN**

Run: `php artisan test tests/Feature/HomepageCountryScopeTest.php`
Expected: PASS.

### Task 2: Establish the shared visual foundation

**Files:**
- Modify: `tailwind.config.js`
- Modify: `resources/css/app.css`
- Modify: `resources/views/components/layouts/app.blade.php`

**Interfaces:**
- Consumes: Tokens documented in `DESIGN.md`.
- Produces: Reusable canvas, surface, ink, border, focus, typography, motion, and bottom-safe-area rules used by all Blade views.

- [ ] **Step 1: Add semantic Tailwind theme values**

Extend Tailwind with `brand`, `action`, `ink`, `workspace`, `surface-subtle`, and `line` colors while retaining DaisyUI's existing theme keys.

- [ ] **Step 2: Replace global decorative defaults**

Set the body to a flat workspace background, normalize heading wrapping and margins, cap prose line length where appropriate, add semantic utility component classes, and include a reduced-motion media query.

- [ ] **Step 3: Reserve mobile navigation space**

Apply a shared bottom-safe-area class to the main content and remove the body gradient so the fixed mobile navigation never overlays the calculator result or footer content.

- [ ] **Step 4: Build assets**

Run: `npm run build`
Expected: Vite exits 0 and emits the production CSS bundle.

### Task 3: Polish shared navigation and footer

**Files:**
- Modify: `resources/views/components/global-header.blade.php`
- Modify: `resources/views/components/bottom-navigation.blade.php`
- Modify: `resources/views/components/footer.blade.php`

**Interfaces:**
- Consumes: Shared colors, focus treatment, spacing, and touch-target rules from Task 2.
- Produces: A compact institutional header, accessible mobile menu, non-overlapping bottom navigation, and a quieter reference footer.

- [ ] **Step 1: Refine the global header**

Reduce decorative elevation, add explicit `aria-expanded`/`aria-controls` for the mobile menu, strengthen current-page styling, standardize minimum target sizes, and keep dropdown motion state-only.

- [ ] **Step 2: Refine mobile bottom navigation**

Use safe-area padding, a structural top border, 44px targets, clearer active treatment, and a semantic navigation label.

- [ ] **Step 3: Refine the footer**

Improve text contrast, reduce heading scale conflicts from global CSS, and simplify spacing without changing destinations.

### Task 4: Reshape the homepage into a working reference surface

**Files:**
- Modify: `resources/views/livewire/home.blade.php`
- Modify: `resources/views/components/country-rates-table.blade.php`
- Modify: `resources/views/components/home-sidebar.blade.php`

**Interfaces:**
- Consumes: Existing `Home::$euCountries`, `Home::$search`, hero calculator component, and sidebar widgets.
- Produces: Compact task-first hero, flat workspace data region, scannable EU rate table, and aligned sidebar panels.

- [ ] **Step 1: Compact the hero**

Remove parallax behavior and the full-page background treatment. Keep the optimized image as a bounded hero backdrop, use fixed product heading sizes, and place one source/freshness line near the calculator.

- [ ] **Step 2: Recompose the data region**

Move the rate table and sidebar onto a flat workspace canvas with consistent top alignment, 24–32px gaps, and restrained section spacing.

- [ ] **Step 3: Improve table scanning**

Use sentence-case headers, compact row padding, tabular percentages, clearer row links, and a mobile layout that keeps country, standard rate, and action legible without horizontal scrolling.

- [ ] **Step 4: Align sidebar surfaces**

Remove the one-off large shadow around the map and standardize widget spacing and surface treatment.

### Task 5: Polish the signature calculator

**Files:**
- Modify: `resources/views/livewire/hero-calculator.blade.php`

**Interfaces:**
- Consumes: Existing Alpine state and Livewire calculator methods without changing their public contract.
- Produces: A denser calculator with consistent controls, readable results, complete focus states, and a clean vertical mobile flow.

- [ ] **Step 1: Align mode and input controls**

Replace the sliding decorative mode indicator with explicit selected button states, use 8px control radii, sentence-case labels, and 44–48px heights.

- [ ] **Step 2: Restrain selected rates and primary action**

Use Action Blue only for the active rate and Calculate action; remove diffuse blue shadows and layout transforms.

- [ ] **Step 3: Clarify results**

Use a neutral result surface, tabular values, consistent labels, and a single strong total. Preserve share and full-calculator actions.

- [ ] **Step 4: Harden mobile behavior**

Ensure results remain fully visible above bottom navigation, dropdowns fit the viewport, and all controls have 44px touch targets.

### Task 6: Verify and polish the completed experience

**Files:**
- Modify as needed: files touched in Tasks 1–5.

**Interfaces:**
- Consumes: Completed local application and production CSS bundle.
- Produces: Verified desktop, tablet, and mobile implementation plus final screenshots.

- [ ] **Step 1: Run automated verification**

Run `php artisan test`, `./vendor/bin/pint --test`, `npm run build`, and the Impeccable detector against all touched Blade/CSS files. Resolve relevant failures.

- [ ] **Step 2: Exercise the calculator**

In the browser, change mode, country, amount, and rate; verify calculation result, focus order, dropdown behavior, and absence of console errors.

- [ ] **Step 3: Test responsive layouts**

Review at 390×844, 768×1024, and 1440×1000. Confirm no horizontal overflow, no fixed-navigation overlap, and readable data hierarchy.

- [ ] **Step 4: Capture final evidence**

Save and present final desktop and mobile homepage screenshots after all checks pass.
