# Programmatic VAT Category Pages Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Publish source-gated VAT category hubs and country-category detail pages from verified `VatRateRule` data.

**Architecture:** Extend the existing rule model with a current-effective scope and a small query service that owns eligibility and coverage thresholds. Livewire pages, sitemaps, `llms.txt`, and country internal links all consume the same service so search discovery cannot diverge from route behavior.

**Tech Stack:** Laravel 11, Livewire 3, Blade, Eloquent, Pest 2, JSON-LD.

## Global Constraints

- Canonical host is exactly `https://eu-vat.info`.
- No category page is published without a source URL, verification timestamp, publication timestamp, and current effective date.
- Category hubs require at least three eligible EU countries unless `SEO_CATEGORY_MIN_COUNTRIES` overrides the threshold.
- Missing or ineligible records return 404 and are excluded from sitemaps, links, and `llms.txt`.
- All production behavior is implemented test-first.

---

### Task 1: Central category eligibility service

**Files:**
- Modify: `app/Models/VatRateRule.php`
- Create: `app/Services/Seo/VatCategorySeoService.php`
- Modify: `config/seo.php`
- Test: `tests/Feature/VatCategoryProgrammaticSeoTest.php`

**Interfaces:**
- Produces: `VatRateRule::scopeCurrent(Builder $query): Builder`.
- Produces: `VatCategorySeoService::eligibleCategories(): Collection`, `rulesForCategory(string): Collection`, and `ruleForCountry(string, string): ?VatRateRule`.

- [ ] Write tests proving unpublished, unsourced, unverified, future, expired, and non-EU rules are excluded.
- [ ] Run the focused test and confirm it fails because the current scope and service do not exist.
- [ ] Implement the current scope, configurable coverage threshold, and shared service.
- [ ] Run the focused test and confirm the eligibility assertions pass.

### Task 2: Category directory and comparison hubs

**Files:**
- Create: `app/Livewire/VatCategoryIndex.php`
- Create: `app/Livewire/VatCategoryHub.php`
- Create: `resources/views/livewire/vat-category-index.blade.php`
- Create: `resources/views/livewire/vat-category-hub.blade.php`
- Modify: `routes/web.php`
- Test: `tests/Feature/VatCategoryProgrammaticSeoTest.php`

**Interfaces:**
- Produces: `/vat-rates/categories` and `/vat-rates/categories/{category}`.

- [ ] Add failing route tests for threshold-qualified hubs, 404s below threshold, canonical metadata, source links, and `CollectionPage`/`ItemList` schema.
- [ ] Run the focused test and confirm the routes fail.
- [ ] Implement the two Livewire pages and constrained routes using `VatCategorySeoService`.
- [ ] Run the focused test and confirm the hub tests pass.

### Task 3: Country-category detail pages

**Files:**
- Create: `app/Livewire/CountryVatCategory.php`
- Create: `resources/views/livewire/country-vat-category.blade.php`
- Modify: `routes/web.php`
- Test: `tests/Feature/VatCategoryProgrammaticSeoTest.php`

**Interfaces:**
- Produces: `/vat-rates/{country}/categories/{category}`.

- [ ] Add failing tests for verified records, visible effective dates, legal basis, verification date, source URL, disclaimer, structured data, and ineligible 404s.
- [ ] Run the focused test and confirm failure.
- [ ] Implement the detail component, view, and route.
- [ ] Run the focused test and confirm the detail tests pass.

### Task 4: Discovery and contextual links

**Files:**
- Modify: `app/Services/SitemapGenerator.php`
- Modify: `app/Http/Controllers/LlmsController.php`
- Modify: `resources/views/livewire/vat-calculator.blade.php`
- Modify: `routes/web.php`
- Test: `tests/Feature/VatCategoryProgrammaticSeoTest.php`

**Interfaces:**
- Adds the `categories` sitemap section and context links using the same service eligibility rules.

- [ ] Add failing tests proving only eligible hubs/details appear in sitemaps, `llms.txt`, and country calculator links.
- [ ] Run the focused test and confirm discovery assertions fail.
- [ ] Implement category sitemap records, dynamic LLM discovery, and country links.
- [ ] Run the focused test and confirm all category tests pass.

### Task 5: Verification

**Files:**
- Modify only files identified by verification failures.

- [ ] Run the category test suite and all existing SEO tests.
- [ ] Run Pint on touched PHP files and `git diff --check`.
- [ ] Run `npm run build`.
- [ ] Run the full Pest suite and separate unrelated baseline failures.
- [ ] Verify representative category pages at desktop and mobile widths with correct canonical, schema, and no overflow.
