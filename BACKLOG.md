# EU VAT Info — Backlog

Items identified during the audit/fix/growth/polish cycle. Grouped by priority.

---

## Medium Priority

### SEO
- [ ] Create a proper OG image (`public/images/og-image.png`) — currently falls back to favicon
- [ ] Add internal cross-links between country pages (e.g., "See also: neighboring countries")
- [ ] Add `BreadcrumbList` schema.org markup on country pages
- [ ] Add `lastReviewed` / `dateModified` meta tags on country pages

### i18n
- [ ] Translate new `ui.php` keys to all 23 non-English locales (tools, navigator, country_page, calculator, validator sections)
- [ ] Rate labels in `vat-calculator-simple.blade.php` still hardcoded (Standard, Reduced, Super Reduced, Parking) — extract to translation keys
- [ ] VAT Navigator result text (`$result['action']`, `$result['explanation']`) is generated server-side in English — needs i18n support in the Livewire component
- [ ] Country names are stored in English in the database — consider per-locale country name translations

### Accessibility
- [ ] Dark mode coverage ~70% — several components have incomplete dark mode styling
- [ ] Add `aria-current="page"` to the active navigation link
- [ ] Add visible focus ring to all interactive elements (currently only `*:focus-visible` global rule)
- [ ] Improve color contrast on some light-gray text elements (e.g., `text-gray-400`)

### Performance
- [ ] Consider switching to `wire:navigate` on country links in the home page table for faster transitions
- [ ] Add `loading="lazy"` to flag images in vat-changes-history and vat-map pages
- [ ] Consider `@once` directive for repeated inline SVG icons

---

## Low Priority

### Testing
- [ ] **Critical:** Enable `RefreshDatabase` + `DatabaseSeeder` in test setup so Feature tests can run with seeded data
- [ ] Fix `RootTagMissingFromViewException` in Livewire tests — components using `@section` before root `<div>` need restructuring
- [ ] Add unit tests for `ViesValidationService`, `CountryAnalyticsService`, and `SitemapGenerator`
- [ ] Add Feature tests for API endpoints (`/api/countries`, `/api/vat/validate`)
- [ ] Add Livewire component tests for `Home`, `VatCalculator`, `VatValidator`
- [ ] Convert PHPUnit-style `ExampleTest` to Pest syntax

### Code Quality
- [ ] Remove dead routes: `/counter`, commented-out `/vat-check` and `/vat-navigator` in `routes/web.php`
- [ ] `tools.blade.php` calculator link is hardcoded as `/vat-calculator` instead of using `locale_path()`
- [ ] Consider extracting FAQ generation logic from `country.blade.php` into a dedicated service or view model

### UX / Design
- [ ] Add `wire:transition` to more Livewire dynamic sections (currently only 2 uses)
- [ ] Consider adding a global search/autocomplete for country navigation
- [ ] Mobile bottom navigation could highlight the current active page
- [ ] Add skeleton loading states for the VAT map SVG and country page sidebar

---

## Completed This Cycle

- [x] Add hreflang `<link>` tags to HTML head (was only in XML sitemap)
- [x] Add missing `@section('seo')` to vat-map, tools, vat-navigator pages
- [x] Fix OG image 404 (temporary: changed to favicon)
- [x] Add `Sitemap:` directive to `robots.txt`
- [x] Add skip-to-content link and `<main>` landmark
- [x] Add `aria-live` regions to dynamic content (validator, calculator)
- [x] Add `focus-visible` outline globally
- [x] Cache country queries in Home and VatChangesHistory components
- [x] Fix N+1 query in VatRateChanges component
- [x] Add `loading="lazy"` to flag images on home page
- [x] Remove unused imports in `routes/web.php` and `VatRateChanges.php`
- [x] Cache `llms-full.txt` route response
- [x] Auto-fix 100 Pint code style violations
- [x] Add Dataset + Organization JSON-LD schemas to home page
- [x] Add `@stack('head')` to layout (enables FAQPage schema on country pages)
- [x] Add `wire:navigate` to all navigation links (desktop + mobile)
- [x] Add loading state to VAT validator form
- [x] Add empty state to home page country search
- [x] Extract ~80 hardcoded English strings to translation keys
- [x] Enable SQLite in-memory for test environment (`phpunit.xml`)
- [x] Enable `RefreshDatabase` trait in Pest config
- [x] Fix SQLite-incompatible migration (SUBSTRING_INDEX → database-agnostic)
