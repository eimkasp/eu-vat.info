# Programmatic VAT Category Pages Design

## Objective

Complete the strongest remaining programmatic SEO opportunity by turning verified `VatRateRule` records into useful country-category detail pages and multi-country category hubs. The system must never create a country-by-category URL matrix from assumptions or generic copy.

## Approaches considered

1. **Source-gated category publishing — selected.** Publish only records with an EU country, source URL, verification timestamp, publication timestamp, and a currently effective date range. This scales with trusted data while keeping the index clean.
2. **Generate every country/category permutation.** This creates immediate URL volume but would produce thin, unsupported tax claims and is rejected.
3. **Editorial category articles only.** This is safe but does not use the structured country-level data already modeled and leaves the best programmatic opportunity unused.

## Public architecture

- `/vat-rates/categories` is the category directory. It exists only when at least one category meets the configured country-coverage threshold.
- `/vat-rates/categories/{category}` is a comparison hub. It exists only when the category has at least three current, indexable country rules by default.
- `/vat-rates/{country}/categories/{category}` is a country-category detail page. It exists only for a matching current, indexable rule.
- Missing, expired, future, unpublished, unverified, unsourced, or non-EU records return 404 and never enter sitemaps or internal links.

## Page value

The category hub shows country coverage, comparable rates, rate types, effective dates, and source links. The detail page shows the applicable rate, classification, effective period, legal basis when present, verification date, source, calculator link, category hub link, and a clear transaction-specific disclaimer.

## Discovery and internal linking

A dedicated `categories` sitemap section contains only eligible directory, hub, and detail URLs. Country calculators surface their current verified category rules. Category pages link back to country calculators and sibling country rules. Dynamic `llms.txt` lists only categories that meet the same publication threshold.

## Structured data and metadata

Category hubs use `CollectionPage` with an `ItemList`; details use `WebPage` with a `DefinedTerm` about entity and connected breadcrumbs. Canonicals use `https://eu-vat.info`. `dateModified` derives from rule verification/update timestamps.

## Quality gates

- `VatRateRule::current()` enforces effective-date boundaries.
- Category hub minimum coverage is configured in `config/seo.php` and defaults to three countries.
- Category slugs must match `[a-z0-9-]+`.
- Every rendered tax rate includes a visible source and verification date.
- Tests cover publication gates, 404 behavior, sitemap exclusion, structured data, links, and coverage thresholds.
