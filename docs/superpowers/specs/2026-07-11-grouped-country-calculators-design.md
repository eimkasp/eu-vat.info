# Grouped European country calculators and country-page polish

## Intent

Make VAT calculation available for maintained European countries outside the European Union while preserving a clear boundary around EU-only data, validation, history, and compliance surfaces. At the same time, refine single-country calculator pages into a compact, trustworthy reference workspace that puts the calculation first and removes repeated or inapplicable content.

The approved visual direction is the **Reference Workspace**: a restrained product surface using the existing institutional-blue identity, cool neutral workspace, flat white task surfaces, compact corners, and explicit data hierarchy. The page must feel authoritative, calm, and efficient rather than promotional.

## Approved scope

Calculator support is divided into two explicit groups:

1. **European Union** — countries where `is_eu_member` is true.
2. **Other European countries** — maintained non-EU countries explicitly enabled for calculation. The initial set is Iceland, Norway, Switzerland, Turkey, and the United Kingdom.

The additional-country list is configuration-backed rather than inferred from every non-EU database row. This prevents a future non-European record from becoming a public calculator page accidentally. A country is calculator-eligible only when it is an EU member or is explicitly configured, has a valid slug and ISO code, and has a positive standard VAT rate.

EU datasets, VIES validation, EU maps, EU VAT history archives, category rules, and EU comparisons remain EU-scoped. Non-EU support is for calculation and appropriately qualified reference information only.

## Non-goals

- Do not expand the EU dataset or label non-EU records as EU members.
- Do not expose VIES actions for countries where `vies_available` is false.
- Do not publish non-EU records into EU history, category, comparison, or dataset sitemaps.
- Do not invent country-specific registration or compliance claims without maintained source data.
- Do not rebuild the country model, introduce a new geographic taxonomy, or add a database migration for this release.
- Do not redesign unrelated homepage, admin, API, or validation experiences.

## Eligibility architecture

Add `config/calculator.php` with an explicit `additional_country_slugs` list. Centralize calculator eligibility in the `Country` model through a reusable query scope and small helpers:

- `scopeCalculatorAvailable($query)` selects EU members plus configured additional countries and requires a positive standard rate.
- `calculator_group` or an equivalent method returns `eu` or `other_europe` for eligible countries.
- `isCalculatorAvailable()` provides a consistent instance-level check for mounted routes.

The same scope must power:

- `HeroCalculator` country data.
- The country calculator directory component.
- Related calculator-country suggestions.
- Country-specific calculator route eligibility.
- Calculator sitemap discovery.

Cache keys must be versioned so the deployed application does not continue serving the previous EU-only selector data.

This boundary keeps calculator availability independent from EU membership while avoiding duplicated allowlists in Livewire components, Blade templates, and sitemap code.

## Country selector behavior

The custom calculator selector keeps its searchable interaction but presents two named groups:

- European Union
- Other European countries

EU countries appear first and both groups sort alphabetically. Search filters across both groups while preserving the group headings for matching results. A group heading is omitted when it has no matching countries. The selected country trigger continues to show flag, country name, and standard rate.

The selector retains keyboard support, Escape-to-close behavior, visible focus, and a minimum 44px touch target. Empty search results show a concise recovery message instead of a blank menu.

## Single-country page composition

### 1. Compact country header

Replace the large generic photo hero with a compact institutional-blue header containing:

- Breadcrumbs.
- Country flag and country name.
- “VAT Calculator” as the page task.
- Current standard rate and a scope label: “EU member” or “Other European country.”
- One short, qualified description.

The calculator follows immediately on the workspace canvas. Country pages must not imply that a generic mountain image is specific to Malta or another jurisdiction.

### 2. Signature calculator

Keep the existing Add VAT / Remove VAT modes, amount entry, rate presets, custom rate, live result, share link, and calculation history behavior. Refine the surface so:

- Controls follow country → amount → action → rate → result.
- Numeric values use tabular alignment.
- The country selector uses the approved grouped data.
- Source and freshness language is scope-aware.
- EU countries may show the existing European Commission trust statement.
- Other European countries use qualified maintained-rate language and never claim “Official EU data.”

On a country-specific page, “Full Calculator” must not link back to the same page as a redundant secondary action. Replace it with a useful next action such as “Change country” or omit it when the selector already provides the action clearly.

### 3. At-a-glance reference

Consolidate the current VAT-rate cards, key-information card, formula cards, and sidebar summary into one structured reference region:

- Standard and reduced rates.
- Currency and ISO code.
- EU membership status.
- VIES availability only when relevant.
- Add-VAT and remove-VAT formulas with one worked example each.

The region uses aligned definition rows and rate cells, not a collection of decorative cards. Values remain readable at a glance and avoid repeating the same standard rate in multiple adjacent panels.

### 4. Scope-aware guidance and actions

For EU members:

- Keep the VIES validation call to action only when `vies_available` is true.
- Keep EU map and source-backed EU history links only when their destination is publishable.
- Preserve category and comparison links only when their existing eligibility services return valid destinations.

For other European countries:

- Hide VIES, EU map, EU category, EU comparison, and EU history actions.
- Do not render generic EU registration copy or FAQs that imply EU rules apply.
- Show calculation guidance, current maintained rates, currency, formulas, and related calculator destinations.

Any content block whose destination would return 404 must be omitted rather than disabled.

### 5. Related calculators and grouped directory

Related calculator suggestions use calculator-eligible countries ranked by standard-rate proximity. Each suggestion identifies its scope without overwhelming the row.

Replace the horizontally clipped “VAT Calculators by Country” carousel with a compact grouped directory. On single-country pages the directory sits in a native disclosure region labelled “Browse all country calculators” so the primary task remains short. Inside it:

- EU calculators use a responsive compact grid.
- Other European calculators have their own heading and remain visibly separate.
- Links show flag, name, and standard rate.
- There is no horizontal scrolling at 320–390px widths.

## Responsive behavior

### Mobile: 320–639px

- Header and calculator use a single-column sequence.
- Mode controls remain two equal, readable actions.
- Result values reflow without being covered by fixed navigation.
- The application reserves bottom-navigation space and the result region uses an appropriate scroll margin so the settled result stays above the navigation.
- At-a-glance information uses two-column definition rows only where labels and values remain readable; otherwise it stacks.
- Calculator-directory links do not create horizontal overflow.
- All controls and links maintain at least 44px touch targets.

### Tablet: 640–1023px

- Calculator controls use a compact mixed row without crowding labels.
- Reference data uses a two-column structure.
- Guidance remains below the reference region rather than competing beside the calculator.

### Desktop: 1024px and above

- The calculator remains the dominant full-width task surface.
- Supporting content uses an 8/4 main-and-reference layout only when it improves scanning.
- The previous repeated sidebar summary and card carousel are removed.

## SEO and structured data

Calculator pages for EU members and configured additional European countries are canonical, indexable, and discoverable in the calculator/country sitemap section. This does not change EU-only dataset, validator, history, comparison, or category discovery.

Country calculator metadata must use truthful scope-neutral wording. Structured data must:

- Keep the canonical BusinessPress host.
- Use the selected country’s actual `currency_code` instead of hard-coded EUR.
- Describe a finance calculator without claiming EU membership for non-EU countries.
- Include only links and capabilities available for the selected country.

Generic `/vat-calculator` metadata may describe European VAT calculation rather than claiming the selector contains EU members only.

## Accessibility and interaction quality

- Target WCAG 2.2 AA.
- Maintain visible keyboard focus on the selector, mode buttons, rates, disclosure, and related links.
- Express selection with `aria-pressed` or the equivalent state, not color alone.
- Keep headings in a logical hierarchy with a single `h1`.
- Use native disclosure behavior for the grouped directory.
- Respect reduced motion; transitions communicate state and finish within 150–250ms.
- Keep muted text contrast-safe against white and workspace surfaces.
- Avoid image hover transforms, decorative gradients, wide diffuse shadows, oversized radii, and nested cards.

## Empty and error states

- If no eligible countries exist, the calculator shows a clear unavailable state rather than failing on an undefined default.
- If a configured slug is missing or lacks a valid rate, it is excluded from selector and sitemap output.
- Direct requests for non-eligible country calculator slugs return 404.
- Selector search with no matches explains that no supported country was found and lets the user clear the search.
- Invalid amount and custom-rate behavior retains the existing adjacent error treatment.
- A country without reduced rates renders only the rates that exist.

## Testing strategy

Behavior is implemented test-first. Required regression coverage:

1. `HeroCalculator` returns EU countries followed by configured other-European countries and excludes unconfigured non-EU records.
2. Search/group view data contains the correct group labels and membership.
3. Country-specific pages load for the United Kingdom, Norway, Switzerland, Turkey, and Iceland when valid records exist.
4. Unsupported non-EU country slugs return 404.
5. Non-EU pages do not render VIES, EU map, EU history, EU comparison, EU category, or “Official EU data” claims.
6. EU pages preserve their applicable VIES, history, map, comparison, and category actions.
7. Calculator sitemap output includes eligible additional-country calculators but EU-only sitemap sections remain free of them.
8. Structured data uses each country’s real currency code.
9. Grouped directory renders both headings and has no carousel/overflow treatment.
10. Existing calculation, saved-history, canonical-host, and EU dataset tests remain green.

Visual verification covers 320px, 375px, 768px, and 1440px. It checks initial state, calculated result, selector open/search state, EU and non-EU country pages, disclosure state, fixed-navigation clearance, horizontal overflow, keyboard focus, and browser console errors.

## Implementation boundaries

Expected files include:

- `config/calculator.php`
- `app/Models/Country.php`
- `app/Livewire/HeroCalculator.php`
- `app/Livewire/VatCalculator.php`
- `app/View/Components/CountryCalculatorList.php`
- Calculator-related services only if a shared query cannot remain cleanly model-scoped
- `resources/views/livewire/hero-calculator.blade.php`
- `resources/views/livewire/vat-calculator.blade.php`
- `resources/views/components/country-calculator-list.blade.php`
- Shared mobile navigation/layout spacing only where required to prevent overlap
- English translation keys plus the project’s established fallback path for other locales
- Calculator, sitemap, SEO, and responsive regression tests

Unrelated country APIs, EU datasets, homepage country table, VAT-change archives, and admin resources remain unchanged.

## Acceptance criteria

- Users can select and calculate VAT for Iceland, Norway, Switzerland, Turkey, and the United Kingdom.
- EU and other-European countries are visibly and semantically grouped.
- Malta and other single-country calculator pages present the calculator first, remove generic photo decoration, and eliminate repeated rate summaries.
- Non-EU calculator pages contain no false EU or VIES claims and no dead EU-only links.
- Mobile results remain fully readable above the fixed navigation at supported widths.
- The page has no unintended horizontal scrolling.
- Canonical metadata and discovery remain on `https://vat.businesspress.io`.
- Automated tests, changed-file lint, production build, SEO audit, and browser verification pass before publication.
