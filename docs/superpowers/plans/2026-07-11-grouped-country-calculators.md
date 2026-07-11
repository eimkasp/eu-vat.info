# Grouped European Country Calculators Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Add explicitly supported non-EU European VAT calculators in a separate group and rebuild single-country calculator pages as compact, scope-aware reference workspaces.

**Architecture:** Centralize calculator eligibility in `Country` using a configuration-backed allowlist for additional European countries. Reuse that scope in Livewire, Blade components, related-country queries, and sitemap generation; keep EU-only services unchanged. Split the large calculator page into small country-header and country-reference components while preserving the existing `HeroCalculator` calculation engine.

**Tech Stack:** PHP 8.2+, Laravel 11, Eloquent, Livewire 3, Blade, Alpine.js, Tailwind CSS 3, Pest 2, Vite 5.

## Global Constraints

- Groups are named **European Union** and **Other European countries**.
- Additional slugs are `iceland`, `norway`, `switzerland`, `turkey`, and `united-kingdom`.
- Eligible countries require a valid slug, two-letter ISO code, and `standard_rate > 0`.
- EU datasets, VIES, maps, history, comparisons, and categories remain EU-scoped.
- Canonical URLs stay on `https://vat.businesspress.io`.
- Non-EU pages never claim “Official EU data” or render dead EU-only links.
- Target WCAG 2.2 AA, 44px controls, visible focus, and reduced-motion-safe transitions.
- No generic photo hero, decorative gradients, nested card grids, wide shadows, or horizontal country carousel.
- The Reference Workspace replaces the hero on country-specific pages; the generic `/vat-calculator` route keeps its existing general-purpose introduction.
- New English UI keys use Laravel's configured English fallback for untranslated locales.
- Validate at 320px, 375px, 768px, and 1440px.

## File Map

- Create `config/calculator.php` for the explicit allowlist and labels.
- Modify `app/Models/Country.php` for one calculator-availability boundary.
- Modify `app/Livewire/HeroCalculator.php` and `app/Livewire/VatCalculator.php` for grouped data and route eligibility.
- Modify `app/View/Components/CountryCalculatorList.php` and calculator Blade components for grouped presentation.
- Modify `app/Services/Seo/InternalLinkService.php`, `app/Services/SitemapGenerator.php`, and `app/Http/Controllers/AmpController.php` for calculator-only discovery.
- Create `resources/views/components/calculator/country-header.blade.php` and `country-reference.blade.php` to split the large page.
- Create `tests/Feature/CalculatorCountryScopeTest.php` and extend calculator/SEO tests.

---

### Task 1: Centralize Calculator Country Eligibility

**Files:**
- Create: `config/calculator.php`
- Modify: `app/Models/Country.php`
- Create: `tests/Feature/CalculatorCountryScopeTest.php`

**Interfaces:**
- Produces `Country::scopeCalculatorAvailable(Builder $query): Builder`.
- Produces `Country::isCalculatorAvailable(): bool`.
- Produces `Country::calculatorGroup(): string`, returning `eu` or `other_europe`.

- [ ] **Step 1: Write the failing scope tests**

```php
<?php

use App\Models\Country;

it('selects EU and configured other European calculator countries', function () {
    config()->set('calculator.additional_country_slugs', ['norway']);
    Country::factory()->create(['name' => 'Germany', 'slug' => 'germany', 'iso_code' => 'DE', 'standard_rate' => 19, 'is_eu_member' => true]);
    Country::factory()->create(['name' => 'Norway', 'slug' => 'norway', 'iso_code' => 'NO', 'standard_rate' => 25, 'is_eu_member' => false]);
    Country::factory()->create(['name' => 'Canada', 'slug' => 'canada', 'iso_code' => 'CA', 'standard_rate' => 5, 'is_eu_member' => false]);
    Country::factory()->create(['name' => 'No Rate', 'slug' => 'no-rate', 'iso_code' => 'NR', 'standard_rate' => 0, 'is_eu_member' => true]);

    expect(Country::calculatorAvailable()->orderBy('name')->pluck('slug')->all())
        ->toBe(['germany', 'norway']);
});

it('reports calculator group and instance availability', function () {
    config()->set('calculator.additional_country_slugs', ['switzerland']);
    $eu = Country::factory()->create(['slug' => 'malta', 'iso_code' => 'MT', 'standard_rate' => 18, 'is_eu_member' => true]);
    $other = Country::factory()->create(['slug' => 'switzerland', 'iso_code' => 'CH', 'standard_rate' => 8.1, 'is_eu_member' => false]);

    expect($eu->isCalculatorAvailable())->toBeTrue()
        ->and($eu->calculatorGroup())->toBe('eu')
        ->and($other->isCalculatorAvailable())->toBeTrue()
        ->and($other->calculatorGroup())->toBe('other_europe');
});
```

- [ ] **Step 2: Run tests and verify RED**

Run: `php artisan test tests/Feature/CalculatorCountryScopeTest.php`

Expected: FAIL because the scope and helpers do not exist.

- [ ] **Step 3: Add the configuration**

```php
<?php

return [
    'additional_country_slugs' => ['iceland', 'norway', 'switzerland', 'turkey', 'united-kingdom'],
    'groups' => ['eu' => 'European Union', 'other_europe' => 'Other European countries'],
];
```

- [ ] **Step 4: Implement the model boundary**

```php
public function scopeCalculatorAvailable(Builder $query): Builder
{
    return $query
        ->whereNotNull('slug')
        ->whereRaw('LENGTH(iso_code) = 2')
        ->where('standard_rate', '>', 0)
        ->where(fn (Builder $scope) => $scope
            ->where('is_eu_member', true)
            ->orWhereIn('slug', config('calculator.additional_country_slugs', [])));
}

public function isCalculatorAvailable(): bool
{
    return filled($this->slug)
        && strlen((string) $this->iso_code) === 2
        && (float) $this->standard_rate > 0
        && ($this->is_eu_member || in_array($this->slug, config('calculator.additional_country_slugs', []), true));
}

public function calculatorGroup(): string
{
    return $this->is_eu_member ? 'eu' : 'other_europe';
}
```

- [ ] **Step 5: Run tests and verify GREEN**

Run: `php artisan test tests/Feature/CalculatorCountryScopeTest.php`

Expected: 2 tests pass.

- [ ] **Step 6: Commit**

```bash
git add config/calculator.php app/Models/Country.php tests/Feature/CalculatorCountryScopeTest.php
git commit -m "Add calculator country eligibility"
```

---

### Task 2: Group Selector Data and Enforce Country Routes

**Files:**
- Modify: `app/Livewire/HeroCalculator.php`
- Modify: `app/Livewire/VatCalculator.php`
- Modify: `app/View/Components/CountryCalculatorList.php`
- Modify: `resources/views/livewire/hero-calculator.blade.php`
- Modify: `lang/en/ui.php`
- Modify: `tests/Feature/HeroCalculatorTest.php`
- Modify: `tests/Feature/VatCalculatorPageTest.php`

**Interfaces:**
- Consumes Task 1 eligibility.
- Produces each `$countries` row with `group`, `slug`, `name`, `flag`, `iso`, `standard_rate`, and `currency_display`.

- [ ] **Step 1: Write failing grouped-payload and route tests**

```php
it('groups EU and other European countries in the hero calculator', function () {
    config()->set('calculator.additional_country_slugs', ['norway']);
    Country::factory()->create(['name' => 'Malta', 'slug' => 'malta', 'iso_code' => 'MT', 'standard_rate' => 18, 'is_eu_member' => true]);
    Country::factory()->create(['name' => 'Norway', 'slug' => 'norway', 'iso_code' => 'NO', 'standard_rate' => 25, 'is_eu_member' => false]);
    Country::factory()->create(['name' => 'Canada', 'slug' => 'canada', 'iso_code' => 'CA', 'standard_rate' => 5, 'is_eu_member' => false]);

    Livewire::test(HeroCalculator::class)
        ->assertSet('countries', fn (array $rows) => collect($rows)->pluck('slug')->all() === ['malta', 'norway'])
        ->assertSet('countries.0.group', 'eu')
        ->assertSet('countries.1.group', 'other_europe');
});

it('loads configured non-EU calculator pages and rejects unsupported countries', function () {
    config()->set('calculator.additional_country_slugs', ['norway']);
    Country::factory()->create(['name' => 'Norway', 'slug' => 'norway', 'iso_code' => 'NO', 'standard_rate' => 25, 'is_eu_member' => false]);
    Country::factory()->create(['name' => 'Canada', 'slug' => 'canada', 'iso_code' => 'CA', 'standard_rate' => 5, 'is_eu_member' => false]);

    $this->get('/vat-calculator/norway')->assertOk();
    $this->get('/vat-calculator/canada')->assertNotFound();
});
```

- [ ] **Step 2: Run focused tests and verify RED**

Run: `php artisan test tests/Feature/HeroCalculatorTest.php tests/Feature/VatCalculatorPageTest.php --filter='groups|configured non-EU'`

Expected: FAIL because selector data is EU-only and route eligibility is unrestricted.

- [ ] **Step 3: Build the grouped eligible-country payload**

Use cache key `hero_calc_countries_v3`, `Country::calculatorAvailable()`, `orderByDesc('is_eu_member')`, and `orderBy('name')`. Include `'group' => $country->calculatorGroup()` in every array row.

- [ ] **Step 4: Enforce route and directory eligibility**

```php
$this->selectedCountryObject = Country::calculatorAvailable()
    ->where('slug', $slug)
    ->firstOrFail();
```

Use the same scope in `CountryCalculatorList`, ordered EU first and grouped by `calculatorGroup()` under a versioned cache key.

Also replace `VatCalculator`'s legacy `all_countries_with_flags` query with the same calculator-eligible scope so no fallback control can expose unsupported database rows.

- [ ] **Step 5: Render grouped searchable results**

```js
get filteredGroups() {
    const q = this.search.trim().toLowerCase();
    const matches = q ? $wire.countries.filter(c => c.name.toLowerCase().includes(q)) : $wire.countries;
    return {
        eu: matches.filter(c => c.group === 'eu'),
        other_europe: matches.filter(c => c.group === 'other_europe'),
    };
}
```

Render each non-empty group with the exact approved labels. Render a translated no-results message when both arrays are empty.

- [ ] **Step 6: Run focused tests and verify GREEN**

Run: `php artisan test tests/Feature/HeroCalculatorTest.php tests/Feature/VatCalculatorPageTest.php`

Expected: all tests pass.

- [ ] **Step 7: Commit**

```bash
git add app/Livewire/HeroCalculator.php app/Livewire/VatCalculator.php app/View/Components/CountryCalculatorList.php resources/views/livewire/hero-calculator.blade.php lang/en/ui.php tests/Feature/HeroCalculatorTest.php tests/Feature/VatCalculatorPageTest.php
git commit -m "Group European calculator countries"
```

---

### Task 3: Preserve EU Boundaries and Expand Calculator Discovery

**Files:**
- Modify: `app/Services/SitemapGenerator.php`
- Modify: `app/Http/Controllers/AmpController.php`
- Modify: `app/Services/Seo/InternalLinkService.php`
- Modify: `resources/views/livewire/vat-calculator.blade.php`
- Modify: `resources/views/components/related-countries.blade.php`
- Modify: `tests/Feature/CalculatorCountryScopeTest.php`
- Modify: `tests/Feature/SeoDiscoveryTest.php`
- Modify: `tests/Feature/VatCalculatorPageTest.php`

**Interfaces:**
- Produces `InternalLinkService::relatedCalculatorCountries(Country $country, int $limit = 6): Collection`.
- Preserves existing EU-only comparison/category/history methods.

- [ ] **Step 1: Write failing discovery and scope tests**

```php
it('discovers eligible non-EU calculators but keeps validators EU-only', function () {
    config()->set('calculator.additional_country_slugs', ['norway']);
    Country::factory()->create(['name' => 'Germany', 'slug' => 'germany', 'iso_code' => 'DE', 'standard_rate' => 19, 'is_eu_member' => true, 'vies_available' => true]);
    Country::factory()->create(['name' => 'Norway', 'slug' => 'norway', 'iso_code' => 'NO', 'standard_rate' => 25, 'is_eu_member' => false, 'vies_available' => false]);

    $this->get('/sitemaps/countries.xml')
        ->assertSee('/vat-calculator/germany', false)
        ->assertSee('/vat-calculator/norway', false);
    $this->get('/sitemaps/validators.xml')
        ->assertSee('/vat-number-validator/germany', false)
        ->assertDontSee('/vat-number-validator/norway', false);
});

it('uses scope-aware content and currency on a non-EU calculator page', function () {
    config()->set('calculator.additional_country_slugs', ['norway']);
    Country::factory()->create([
        'name' => 'Norway', 'slug' => 'norway', 'iso_code' => 'NO',
        'standard_rate' => 25, 'currency_code' => 'NOK',
        'is_eu_member' => false, 'vies_available' => false,
    ]);

    $this->get('/vat-calculator/norway')
        ->assertOk()
        ->assertSee('Other European country')
        ->assertSee('"priceCurrency":"NOK"', false)
        ->assertDontSee('Official European Commission data')
        ->assertDontSee('/vat-number-validator/norway', false)
        ->assertDontSee('/vat-map', false)
        ->assertDontSee('/vat-rates/norway/history', false);
});
```

- [ ] **Step 2: Run tests and verify RED**

Run: `php artisan test tests/Feature/CalculatorCountryScopeTest.php tests/Feature/SeoDiscoveryTest.php tests/Feature/VatCalculatorPageTest.php --filter='discovers eligible|scope-aware'`

Expected: FAIL because calculator discovery is EU-only and the page emits EU-only claims.

- [ ] **Step 3: Split calculator and validator sitemap scopes**

```php
$query = Country::query();
if ($prefix === '/vat-calculator') {
    $query->calculatorAvailable();
} else {
    $query->where('is_eu_member', true)->where('vies_available', true);
}
```

Do not alter dataset, changes, categories, comparisons, or editorial records.

- [ ] **Step 4: Add calculator-related rate ranking**

```php
public function relatedCalculatorCountries(Country $country, int $limit = 6): Collection
{
    return Country::calculatorAvailable()
        ->whereKeyNot($country->getKey())
        ->orderByRaw('ABS(standard_rate - ?)', [(float) $country->standard_rate])
        ->orderByDesc('is_eu_member')
        ->orderBy('name')
        ->limit($limit)
        ->get();
}
```

Use this only for calculator suggestions.

- [ ] **Step 5: Gate content and correct structured currency**

Set `'priceCurrency' => $selectedCountryObject->currency_code ?: 'EUR'`. Gate VIES by `vies_available`; gate EU map/history/category/comparison blocks by `is_eu_member` plus their existing destination checks. Use maintained-rate trust wording outside the EU.

- [ ] **Step 6: Apply eligibility to AMP country pages**

Use `Country::calculatorAvailable()->where('slug', $slug)->firstOrFail()` for the AMP calculator country route while leaving EU-only AMP listings unchanged.

- [ ] **Step 7: Run tests and verify GREEN**

Run: `php artisan test tests/Feature/CalculatorCountryScopeTest.php tests/Feature/SeoDiscoveryTest.php tests/Feature/VatCalculatorPageTest.php`

Expected: all tests pass.

- [ ] **Step 8: Commit**

```bash
git add app/Services/SitemapGenerator.php app/Http/Controllers/AmpController.php app/Services/Seo/InternalLinkService.php resources/views/livewire/vat-calculator.blade.php resources/views/components/related-countries.blade.php tests/Feature/CalculatorCountryScopeTest.php tests/Feature/SeoDiscoveryTest.php tests/Feature/VatCalculatorPageTest.php
git commit -m "Scope calculator discovery by country"
```

---

### Task 4: Build the Reference Workspace Layout

**Files:**
- Create: `resources/views/components/calculator/country-header.blade.php`
- Create: `resources/views/components/calculator/country-reference.blade.php`
- Modify: `resources/views/livewire/vat-calculator.blade.php`
- Modify: `resources/views/livewire/hero-calculator.blade.php`
- Modify: `lang/en/ui.php`
- Modify: `tests/Feature/VatCalculatorPageTest.php`

**Interfaces:**
- `country-header` consumes `Country $country` and breadcrumb data.
- `country-reference` consumes `Country $country` and renders only existing rates.
- `HeroCalculator` retains all calculation formulas and state ownership.

- [ ] **Step 1: Write the failing layout-contract test**

```php
it('renders the calculator-first reference workspace without a generic photo hero', function () {
    Country::factory()->create([
        'name' => 'Malta', 'slug' => 'malta', 'iso_code' => 'MT',
        'standard_rate' => 18, 'reduced_rate' => 6, 'is_eu_member' => true,
    ]);

    $this->get('/vat-calculator/malta')
        ->assertOk()
        ->assertSee('data-testid="country-calculator-header"', false)
        ->assertSee('data-testid="country-reference"', false)
        ->assertSee('At a glance')
        ->assertSee('Adding 18')
        ->assertSee('Removing 18')
        ->assertDontSee('eu-vat-calculator-background')
        ->assertDontSee('Full Calculator');
});
```

- [ ] **Step 2: Run the test and verify RED**

Run: `php artisan test tests/Feature/VatCalculatorPageTest.php --filter='reference workspace'`

Expected: FAIL because the new components and layout contract do not exist.

- [ ] **Step 3: Build the compact country header**

Create a flat institutional-blue header with breadcrumbs, flag, one `h1`, short qualified description, current standard rate, and “EU member” or “Other European country” label. Use fixed product typography and no photo or gradient.

```blade
<header data-testid="country-calculator-header" class="bg-brand text-white">
    <div class="container py-6 sm:py-8">
        <x-breadcrumbs variant="dark" :items="$breadcrumbs" />
        <div class="mt-4 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div class="flex items-center gap-3">
                <img class="h-8 w-auto rounded" ...>
                <h1 class="text-2xl font-bold tracking-[-0.02em] sm:text-3xl">{{ $country->name }} VAT Calculator</h1>
            </div>
            <div class="flex items-center gap-3 text-sm">
                <strong class="text-2xl tabular-nums">{{ $country->standard_rate }}%</strong>
                <span class="rounded-full bg-white/10 px-3 py-1.5">...</span>
            </div>
        </div>
    </div>
</header>
```

- [ ] **Step 4: Build the consolidated reference component**

Render existing rates, currency, ISO, membership, VIES availability, and Add/Remove VAT formulas inside one semantic section using definition lists and tabular values. Do not repeat a sidebar summary or nest cards.

- [ ] **Step 5: Recompose the page in task order**

For country-specific pages use: country header → calculator → at-a-glance reference → applicable actions/guidance → applicable FAQs/map/history → related calculators → grouped directory. Remove the country-page photo hero, duplicate summary, repeated rate cards, and redundant self-link. Preserve the generic `/vat-calculator` route's general-purpose introduction and calculator behavior.

- [ ] **Step 6: Refine result hierarchy**

Keep values tabular, put mobile actions below results, remove “Full Calculator” when already on a country page, and add `scroll-mb-24` to the result region.

- [ ] **Step 7: Run page and calculation tests**

Run: `php artisan test tests/Feature/VatCalculatorPageTest.php tests/Feature/HeroCalculatorTest.php tests/Feature/VatCalculatorLivewireTest.php`

Expected: all tests pass.

- [ ] **Step 8: Commit**

```bash
git add resources/views/components/calculator/country-header.blade.php resources/views/components/calculator/country-reference.blade.php resources/views/livewire/vat-calculator.blade.php resources/views/livewire/hero-calculator.blade.php lang/en/ui.php tests/Feature/VatCalculatorPageTest.php
git commit -m "Polish country calculator workspace"
```

---

### Task 5: Group the Directory, Fix Mobile Clearance, and Verify

**Files:**
- Modify: `resources/views/components/country-calculator-list.blade.php`
- Modify: `resources/views/components/related-countries.blade.php`
- Modify: `resources/views/components/layouts/app.blade.php`
- Modify: `resources/views/components/bottom-navigation.blade.php` only if shared layout spacing is insufficient.
- Modify: `tests/Feature/VatCalculatorPageTest.php`
- Modify: `tests/Feature/UxImprovementsTest.php`

**Interfaces:**
- Consumes grouped `CountryCalculatorList::$countries` from Task 2.
- Produces native disclosure labelled “Browse all country calculators”.

- [ ] **Step 1: Write failing directory and clearance tests**

```php
it('renders a grouped calculator directory without a horizontal carousel', function () {
    config()->set('calculator.additional_country_slugs', ['norway']);
    Country::factory()->create(['name' => 'Malta', 'slug' => 'malta', 'iso_code' => 'MT', 'standard_rate' => 18, 'is_eu_member' => true]);
    Country::factory()->create(['name' => 'Norway', 'slug' => 'norway', 'iso_code' => 'NO', 'standard_rate' => 25, 'is_eu_member' => false]);

    $this->get('/vat-calculator/malta')
        ->assertSee('Browse all country calculators')
        ->assertSee('European Union')
        ->assertSee('Other European countries')
        ->assertDontSee('overflow-x-auto', false)
        ->assertDontSee('snap-x', false);
});

it('reserves mobile navigation space around calculator results', function () {
    $this->get('/vat-calculator/malta')
        ->assertSee('mobile-nav-safe', false)
        ->assertSee('scroll-mb-24', false);
});
```

- [ ] **Step 2: Run tests and verify RED**

Run: `php artisan test tests/Feature/VatCalculatorPageTest.php tests/Feature/UxImprovementsTest.php --filter='grouped calculator directory|mobile navigation space'`

Expected: FAIL because the directory is still a carousel and result clearance is absent.

- [ ] **Step 3: Replace the carousel with grouped disclosure**

```blade
<details class="border-t border-line pt-6">
    <summary class="flex min-h-11 cursor-pointer items-center justify-between font-semibold text-ink focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-action">
        {{ __('ui.calculator.browse_all') }}
        <span aria-hidden="true">+</span>
    </summary>

    @foreach (['eu', 'other_europe'] as $group)
        @if(($countries[$group] ?? collect())->isNotEmpty())
            <section class="mt-6" aria-labelledby="calculator-group-{{ $group }}">
                <h3 id="calculator-group-{{ $group }}" class="text-base font-bold text-ink">{{ __('ui.calculator.groups.'.$group) }}</h3>
                <div class="mt-3 grid grid-cols-1 gap-2 sm:grid-cols-2 lg:grid-cols-3">
                    {{-- Compact 44px links with flag, country, and standard rate. --}}
                </div>
            </section>
        @endif
    @endforeach
</details>
```

- [ ] **Step 4: Reserve fixed mobile-navigation space**

Ensure the app shell reserves at least the fixed navigation height without desktop padding:

```blade
<main id="main-content" class="mobile-nav-safe min-h-screen bg-workspace pb-24 lg:pb-0">
```

Keep the result region’s `scroll-mb-24`. Do not add higher z-index or overlay workarounds.

- [ ] **Step 5: Run focused tests and verify GREEN**

Run: `php artisan test tests/Feature/VatCalculatorPageTest.php tests/Feature/UxImprovementsTest.php`

Expected: all tests pass.

- [ ] **Step 6: Run deterministic design scan**

```bash
npx impeccable detect --json resources/views/livewire/vat-calculator.blade.php resources/views/livewire/hero-calculator.blade.php resources/views/components/calculator resources/views/components/country-calculator-list.blade.php
```

Expected: exit 0, or exit 2 with reviewed findings corrected before continuing. If the detector package cannot load, record the concrete limitation and continue with browser/manual evidence.

- [ ] **Step 7: Run full automated verification**

Run each command separately and inspect its exit status:

```bash
php artisan test
```

```bash
git diff --name-only -- app config tests | rg '\.php$' | xargs ./vendor/bin/pint --test
```

```bash
npm run build
```

```bash
git diff --check
```

Expected: zero test failures, changed PHP files pass Pint, Vite exits 0, and diff check exits 0.

- [ ] **Step 8: Verify responsive UI in the browser**

Run the local app and inspect `/vat-calculator/malta` and `/vat-calculator/norway` at 320×800, 375×812, 768×1024, and 1440×1000. Confirm grouped selector/search, Add/Remove results, bottom-nav clearance, no horizontal overflow, scope-correct non-EU content, keyboard disclosure, visible focus, and no console errors.

- [ ] **Step 9: Commit final responsive polish**

```bash
git add resources/views/components/country-calculator-list.blade.php resources/views/components/related-countries.blade.php resources/views/components/layouts/app.blade.php resources/views/components/bottom-navigation.blade.php tests/Feature/VatCalculatorPageTest.php tests/Feature/UxImprovementsTest.php
git commit -m "Finalize responsive calculator polish"
```

- [ ] **Step 10: Publish for review**

Push `codex/grouped-country-calculators`, open a ready pull request to `main`, and include test, build, detector, and responsive-browser evidence. Do not claim GitHub Actions pass if the account billing lock still prevents jobs from starting.
