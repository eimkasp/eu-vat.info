# Advanced SEO Architecture Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Replace uncontrolled generated URL inventory with a canonical, locale-aware SEO system and add finite, data-backed VAT landing pages.

**Architecture:** Centralize indexability in `config/seo.php` and `App\Support\Seo\SeoPolicy`, then make metadata, hreflang, sitemaps, routes, and new programmatic templates consume that policy. New pages are backed by existing `Country`, `VatRate`, and `VatRateChange` records; curated comparisons and validator formats use explicit configuration, while category rules use a verified database model.

**Tech Stack:** Laravel 11, Livewire 3, Blade, Pest 2, Eloquent, Laravel HTTP client.

## Global Constraints

- Canonical host is exactly `https://eu-vat.info`.
- Shared calculation URLs are functional but `noindex, follow` and canonicalized to their country calculator.
- English is the only indexable locale by default.
- No page may claim freshness newer than its underlying records.
- No category-specific VAT claim is published without a source URL and verification timestamp.
- New URL matrices are finite and allowlisted.

---

### Task 1: Canonical host, locale readiness, and metadata policy

**Files:**
- Create: `config/seo.php`
- Create: `app/Support/Seo/SeoPolicy.php`
- Create: `app/Http/Middleware/RedirectLegacySeoHost.php`
- Modify: `bootstrap/app.php`
- Modify: `resources/views/components/seo-meta.blade.php`
- Modify: `resources/views/components/layouts/app.blade.php`
- Modify: `resources/views/livewire/shared-calculation.blade.php`
- Test: `tests/Feature/SeoIndexabilityTest.php`

**Interfaces:**
- Produces: `SeoPolicy::indexableLocales(): array`, `SeoPolicy::isLocaleIndexable(string): bool`, `SeoPolicy::canonicalHost(): string`.

- [ ] Write failing tests proving legacy-host redirects, incomplete locales are `noindex`, hreflang contains only ready locales, and shared calculations canonicalize to country pages.
- [ ] Run `php artisan test tests/Feature/SeoIndexabilityTest.php` and confirm the expected assertions fail.
- [ ] Implement the policy, middleware, metadata props, conditional hreflang, and shared-calculation directives.
- [ ] Run the focused test and confirm it passes.

### Task 2: Discovery files and sitemap index

**Files:**
- Delete: `public/sitemap.xml`
- Delete: `public/llms.txt`
- Modify: `public/robots.txt`
- Modify: `app/Http/Controllers/LlmsController.php`
- Modify: `routes/web.php`
- Modify: `app/Services/SitemapGenerator.php`
- Modify: `app/Http/Controllers/SitemapController.php`
- Test: `tests/Feature/SeoDiscoveryTest.php`

**Interfaces:**
- Produces: `SitemapGenerator::generateIndex(): string`, `SitemapGenerator::generateSection(string): string`, dynamic `/llms.txt` and `/sitemaps/{section}.xml` responses.

- [ ] Write failing tests for one canonical domain, a sitemap index, reciprocal localized `<loc>` entries, truthful `lastmod`, current llms routes, and the absence of legacy hosts.
- [ ] Run the focused test and confirm failure.
- [ ] Implement dynamic discovery documents and sectioned sitemap generation without `priority` or `changefreq`.
- [ ] Run the focused test and confirm it passes.

### Task 3: Dataset landing page and CSV distribution

**Files:**
- Create: `app/Livewire/VatDataset.php`
- Create: `resources/views/livewire/vat-dataset.blade.php`
- Create: `app/Http/Controllers/VatDatasetDownloadController.php`
- Modify: `routes/web.php`
- Modify: `routes/api.php`
- Test: `tests/Feature/VatDatasetSeoTest.php`

**Interfaces:**
- Produces: `/datasets/eu-vat-rates`, `/datasets/eu-vat-rates.csv`, and a canonical Dataset JSON-LD graph.

- [ ] Write failing tests for the landing page, EU-only CSV output, provenance, license, actual `dateModified`, and distribution URLs.
- [ ] Run the test and confirm failure.
- [ ] Implement the Livewire page, streamed CSV controller, routes, and structured data.
- [ ] Run the test and confirm it passes.

### Task 4: Country history and VAT change event pages

**Files:**
- Create: `app/Livewire/CountryVatHistory.php`
- Create: `resources/views/livewire/country-vat-history.blade.php`
- Create: `app/Livewire/VatChangeEvent.php`
- Create: `resources/views/livewire/vat-change-event.blade.php`
- Create: `app/Livewire/VatChangesArchive.php`
- Create: `resources/views/livewire/vat-changes-archive.blade.php`
- Modify: `routes/web.php`
- Test: `tests/Feature/ProgrammaticVatPagesTest.php`

**Interfaces:**
- Produces finite country history, event, year archive, and upcoming archive routes backed by real records.

- [ ] Write failing tests for existing records, 404 behavior for missing records/years, canonical metadata, sources, and internal links.
- [ ] Run the focused test and confirm failure.
- [ ] Implement the three Livewire page types and constrained routes.
- [ ] Run the focused test and confirm it passes.

### Task 5: Curated comparison pages and relevant internal links

**Files:**
- Create: `app/Livewire/VatComparison.php`
- Create: `resources/views/livewire/vat-comparison.blade.php`
- Create: `app/Services/Seo/InternalLinkService.php`
- Modify: `config/seo.php`
- Modify: `routes/web.php`
- Modify: `resources/views/livewire/vat-calculator.blade.php`
- Test: `tests/Feature/VatComparisonSeoTest.php`

**Interfaces:**
- Produces: `InternalLinkService::relatedCountries(Country, int): Collection` and allowlisted `/compare/{left}-vs-{right}-vat` pages.

- [ ] Write failing tests proving approved pairs render, reversed pairs redirect canonically, unapproved pairs 404, and related links are rate-relevant rather than alphabetical.
- [ ] Run the focused test and confirm failure.
- [ ] Implement the allowlist, comparison page, and internal-link service.
- [ ] Run the focused test and confirm it passes.

### Task 6: Validator format data and verified category-rule boundary

**Files:**
- Create: `config/vat-number-formats.php`
- Create: `database/migrations/2026_07_11_000000_create_vat_rate_rules_table.php`
- Create: `app/Models/VatRateRule.php`
- Modify: `app/Models/Country.php`
- Modify: `app/Livewire/ViesValidatorPage.php`
- Modify: `resources/views/livewire/vies-validator-page.blade.php`
- Test: `tests/Feature/VatSeoDataQualityTest.php`

**Interfaces:**
- Produces: country VAT-format guidance and `VatRateRule::scopeIndexable()` requiring publication, source, and verification.

- [ ] Write failing tests for format lookup, visible limitations, and the verified-category-rule scope.
- [ ] Run the focused test and confirm failure.
- [ ] Implement maintained VAT format configuration and the guarded category-rule model.
- [ ] Run the focused test and confirm it passes.

### Task 7: Metadata accuracy, schema cleanup, and URL inventory controls

**Files:**
- Modify: `lang/en/ui.php`
- Modify: `resources/views/livewire/vat-calculator.blade.php`
- Modify: `resources/views/livewire/top-calculations-amount.blade.php`
- Modify: `resources/views/livewire/vat-changes-history.blade.php`
- Modify: `app/Livewire/TopCalculations.php`
- Modify: `app/Livewire/TopCalculationsAmount.php`
- Test: `tests/Feature/SeoMetadataQualityTest.php`

**Interfaces:**
- Consumes: `SeoPolicy` and real model timestamps.

- [ ] Write failing tests for no duplicated canonical, no hard-coded freshness claim, EU-only calculations, useful amount descriptions, and record-based dataset modification dates.
- [ ] Run the focused test and confirm failure.
- [ ] Implement the metadata and query corrections.
- [ ] Run the focused test and confirm it passes.

### Task 8: IndexNow and automated SEO audit

**Files:**
- Create: `app/Services/Seo/IndexNowService.php`
- Create: `app/Console/Commands/AuditSeo.php`
- Modify: `config/seo.php`
- Test: `tests/Feature/SeoAutomationTest.php`

**Interfaces:**
- Produces: `IndexNowService::submit(array $urls): bool` and `php artisan seo:audit`.

- [ ] Write failing tests for canonical-host filtering, disabled-by-default behavior, valid IndexNow payloads, and audit failures on legacy-host leakage.
- [ ] Run the focused test and confirm failure.
- [ ] Implement the service and audit command.
- [ ] Run the focused test and confirm it passes.

### Task 9: Final verification

**Files:**
- Modify only files identified by verification failures.

- [ ] Run all new SEO tests together and require zero failures.
- [ ] Run `./vendor/bin/pint --test` on touched PHP files.
- [ ] Run `npm run build`.
- [ ] Run the full Pest suite and separate pre-existing failures from regressions.
- [ ] Run `php artisan seo:audit` against the final repository.
- [ ] Render representative English and non-indexable localized pages, inspect canonicals/hreflang/schema, and capture final evidence.
