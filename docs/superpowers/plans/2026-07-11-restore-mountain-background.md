# Restore Mountain Background Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Restore the existing responsive mountain image behind the compact country header and calculator while preserving the Reference Workspace hierarchy, accessibility, and mobile behavior.

**Architecture:** The country-specific branch of `vat-calculator.blade.php` will own one atmospheric wrapper containing a responsive presentation-only `<picture>`, a navy readability scrim, the transparent country header, and the existing calculator. `HeroCalculator` will receive a `country-image` surface variant so its trust/history copy stays light on the image while its redundant self-link remains hidden. Supporting content stays unchanged on the neutral workspace below.

**Tech Stack:** Laravel 11, Blade, Livewire 3, Alpine.js, Tailwind CSS 3, Pest 2, Vite 5.

## Global Constraints

- Use the existing `eu-vat-calculator-background-sm`, `-md`, and `-lg` WebP/JPG assets; do not create or download new imagery.
- The image is presentation-only, never animated, and must retain a solid navy fallback.
- The country header and calculator share one continuous image section.
- The white calculator remains the primary task surface and supporting reference content remains on `bg-surface-subtle`.
- Preserve truthful EU/non-EU trust wording, grouped selectors, result scroll behavior, fixed-navigation clearance, and WCAG 2.2 AA contrast.
- No model, route, sitemap, AMP, eligibility, or calculation behavior changes.
- Verify at 320px, 375px, 768px, and desktop with no horizontal overflow.

---

### Task 1: Add the Atmospheric Country Calculator Surface

**Files:**
- Modify: `tests/Feature/VatCalculatorPageTest.php`
- Modify: `resources/views/livewire/vat-calculator.blade.php`
- Modify: `resources/views/components/calculator/country-header.blade.php`
- Modify: `resources/views/livewire/hero-calculator.blade.php`

**Interfaces:**
- Consumes: existing responsive mountain assets and `HeroCalculator::$surface`.
- Produces: `data-country-atmosphere` markup contract and the `country-image` presentation variant.

- [ ] **Step 1: Write the failing country-atmosphere regression**

Update the existing `renders country calculators as a compact reference workspace` test to require the restored image and responsive sources:

```php
$response = $this->get('/vat-calculator/germany')
    ->assertOk()
    ->assertSee('data-country-atmosphere', false)
    ->assertSee('eu-vat-calculator-background-sm.webp', false)
    ->assertSee('eu-vat-calculator-background-md.webp', false)
    ->assertSee('eu-vat-calculator-background-lg.webp', false)
    ->assertSee('data-calculator-surface="country-image"', false)
    ->assertSee('data-country-reference', false)
    ->assertDontSee('Full Calculator');
```

Keep the ordering assertion `data-country-header < id="hero-calculator" < data-country-reference`.

- [ ] **Step 2: Run the regression and verify RED**

Run:

```bash
php artisan test tests/Feature/VatCalculatorPageTest.php --filter='compact reference workspace'
```

Expected: FAIL because `data-country-atmosphere`, the responsive picture sources, and `country-image` variant do not exist.

- [ ] **Step 3: Build one responsive atmospheric wrapper**

In the country-specific branch of `resources/views/livewire/vat-calculator.blade.php`, wrap the header and calculator with:

```blade
<section data-country-atmosphere class="relative isolate overflow-hidden bg-[#0b2f4f]">
    <picture class="absolute inset-0 -z-20 block h-full w-full" aria-hidden="true">
        <source media="(min-width: 1024px)" type="image/webp" srcset="/images/eu-vat-calculator-background-lg.webp">
        <source media="(min-width: 640px)" type="image/webp" srcset="/images/eu-vat-calculator-background-md.webp">
        <source type="image/webp" srcset="/images/eu-vat-calculator-background-sm.webp">
        <img src="/images/eu-vat-calculator-background.jpg" alt="" class="h-full w-full object-cover object-center" loading="eager" fetchpriority="high">
    </picture>
    <div class="absolute inset-0 -z-10 bg-[#071f35]/80" aria-hidden="true"></div>

    <x-calculator.country-header :country="$selectedCountryObject" />

    <div class="container pb-8 sm:pb-10">
        <section id="calculator" aria-label="{{ $selectedCountryObject->name }} VAT calculation" class="scroll-mb-24">
            <livewire:hero-calculator
                :key="'hero-calc-' . $selectedCountryObject->id"
                :initial-country="$selectedCountryObject->slug"
                :show-header="false"
                surface="country-image"
            />
        </section>
    </div>
</section>
```

Move only the calculator into this wrapper; leave the reference grid in the following neutral `<main>`.

- [ ] **Step 4: Make the country header transparent**

Change the root header class in `country-header.blade.php` from a solid background to:

```blade
<header data-country-header class="text-white">
```

Preserve the compact spacing, breadcrumbs, flag, scope, title, subtitle, and standard-rate block.

- [ ] **Step 5: Add the country-image calculator presentation variant**

In `hero-calculator.blade.php`, expose the presentation contract on the root element:

```blade
<div class="w-full" data-calculator-surface="{{ $surface }}" x-data="{
```

This adds the data attribute to the existing root without changing its Alpine state object.

Use `$surface !== 'workspace'` for light trust/history text, and hide the secondary self-link for both country page variants:

```blade
@if(! in_array($surface, ['workspace', 'country-image'], true))
    {{-- Full Calculator link --}}
@endif
```

Do not change calculation, selector, rate, result, or history behavior.

- [ ] **Step 6: Preload the image on country pages**

In the existing `@push('head')`, keep the AMP link for country pages and add the WebP preload for both country and generic routes:

```blade
<link rel="preload" as="image" type="image/webp" href="/images/eu-vat-calculator-background.webp" fetchpriority="high">
```

- [ ] **Step 7: Run focused tests and verify GREEN**

Run:

```bash
php artisan test tests/Feature/VatCalculatorPageTest.php tests/Feature/HeroCalculatorTest.php tests/Feature/CalculatorCountryScopeTest.php
```

Expected: all calculator, grouped-scope, and atmosphere regressions pass.

- [ ] **Step 8: Commit the implementation**

```bash
git add tests/Feature/VatCalculatorPageTest.php resources/views/livewire/vat-calculator.blade.php resources/views/components/calculator/country-header.blade.php resources/views/livewire/hero-calculator.blade.php
git commit -m "Restore mountain calculator atmosphere"
```

---

### Task 2: Verify, Review, Publish, and Merge

**Files:**
- Verify: all modified files and generated production assets.
- Publish: branch `codex/restore-mountain-background` to PR against `main`.

**Interfaces:**
- Consumes: Task 1 implementation and its test contract.
- Produces: reviewed PR, merged `main`, and verified production screenshots.

- [ ] **Step 1: Run repository verification**

Run:

```bash
php artisan test
./vendor/bin/pint app/Livewire/HeroCalculator.php app/Livewire/VatCalculator.php tests/Feature/VatCalculatorPageTest.php
npm run build
git diff --check
```

Expected: PHP suite passes, Pint reports PASS, Vite builds successfully, and `git diff --check` is silent.

- [ ] **Step 2: Run Impeccable detection**

Run:

```bash
npx impeccable detect resources/views/livewire/vat-calculator.blade.php resources/views/components/calculator/country-header.blade.php resources/views/livewire/hero-calculator.blade.php --format text
```

Review only findings introduced by this change; vendor and pre-existing project-wide findings are out of scope.

- [ ] **Step 3: Verify responsive behavior in the browser**

Use an isolated SQLite preview database and check Malta and Norway at 320px, 375px, 768px, and desktop. Confirm:

- The mountain image spans the header and calculator.
- Text and trust copy remain readable.
- Norway keeps maintained-rate wording and no EU-only contextual actions.
- The calculated mobile result settles above the fixed navigation.
- `document.documentElement.scrollWidth === document.documentElement.clientWidth`.
- Browser console has no errors.

- [ ] **Step 4: Push and open a ready PR**

```bash
git push -u origin codex/restore-mountain-background
gh pr create --base main --head codex/restore-mountain-background --title "Restore mountain background on country calculators" --fill
```

- [ ] **Step 5: Request independent code review**

Review the range `origin/main..HEAD` against `docs/superpowers/specs/2026-07-11-restore-mountain-background-design.md`. Fix every Critical or Important finding, rerun Step 1, and push the reviewed commit.

- [ ] **Step 6: Inspect PR checks and merge**

Run:

```bash
gh pr checks --watch --interval 10
gh pr merge --squash
```

If GitHub Actions cannot start for the known account billing lock, verify the check-run annotation and do not misreport it as a code failure. Merge only after local verification and independent review remain green and GitHub reports the PR mergeable.

- [ ] **Step 7: Verify production**

Confirm both routes return HTTP 200 and contain `data-country-atmosphere`:

```bash
curl -sSIL https://vat.businesspress.io/vat-calculator/malta
curl -sSIL https://vat.businesspress.io/vat-calculator/norway
```

Capture final desktop and mobile screenshots from production and confirm the canonical host remains `https://vat.businesspress.io`.
