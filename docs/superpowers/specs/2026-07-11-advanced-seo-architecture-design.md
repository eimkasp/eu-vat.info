# Advanced SEO Architecture Design

## Objective

Turn EU VAT Info's existing VAT entities, historical rates, change events, validation tools, translations, and machine-readable data into a controlled search architecture that earns indexation through unique utility. The implementation must reduce duplicate and low-value URL inventory before adding new programmatic landing pages.

## Principles

1. Application state is not automatically search content. Arbitrary calculations and filter combinations remain usable but are not indexable.
2. A generated page is indexable only when it has unique data, a canonical URL, reliable freshness, and an approved language version.
3. English is the initial indexable locale. Additional locales are enabled explicitly after translation completeness and editorial review.
4. Search metadata must describe visible page content and derive dates from real records, never request time.
5. VAT facts need source provenance, effective dates, and a visible verification status.
6. New templates launch in finite cohorts. No Cartesian page matrix is published by default.

## Canonical Host and Crawl Control

`https://eu-vat.info` is the only canonical host. Requests to `vat.businesspress.io` receive a permanent redirect preserving path and query. Static discovery files must not publish the legacy host.

Shared calculations at `/vat-calculation/{country}/{amount}/{rate}/{mode}` remain shareable but use `noindex, follow`, canonicalize to `/vat-calculator/{country}`, and never emit hreflang alternates or sitemap entries. VAT history filters also canonicalize to their unfiltered archive; individual event pages carry the indexable detail.

## Locale Readiness

`config/seo.php` defines the locales eligible for indexation. The default is English only. All accessible locales continue to work, but non-ready locales receive `noindex, follow` and are omitted from hreflang and XML sitemaps. Enabling a locale requires complete critical SEO and page-copy keys.

## Sitemap Architecture

`/sitemap.xml` becomes a sitemap index. It links to focused XML URL sets for core pages, countries, validators, VAT history, and editorial content. Every localized page is emitted as its own `<loc>` entry and includes reciprocal hreflang links for all indexable locales. `lastmod` comes from database or content timestamps. `priority` and `changefreq` are omitted.

## Indexable Page Types

### Country VAT hubs

The existing country calculator remains the canonical country entity and links to validation, history, data downloads, recent changes, and approved comparisons.

### Country VAT history

`/vat-rates/{country}/history` exists only for EU-member countries and presents current rates plus chronological `VatRate` and `VatRateChange` records with provenance.

### VAT change events

`/vat-changes/{country}/{rateType}/{date}` exists only for a matching stored event. It exposes before/after rates, effective and announcement dates, explanation, official sources, and related country/history pages.

### Archive hubs

`/vat-changes/year/{year}` exists only when records exist. `/vat-changes/upcoming` contains future-dated events. Both are finite archive pages, not arbitrary facets.

### Dataset landing page

`/datasets/eu-vat-rates` documents provenance, freshness, license, variables, and JSON, CSV, and Markdown distributions. It is the canonical `Dataset` entity.

### Curated comparisons

`/compare/{left}-vs-{right}-vat` is limited to pairs listed in configuration. Each page compares current rates, currencies, validation availability, and history counts. Unapproved permutations return 404.

### Validator guides

Country validator routes surface country-specific VAT prefix, format guidance, VIES availability, and limitations from a maintained configuration. Missing format data does not produce invented copy.

### Category rate architecture

A `vat_rate_rules` table stores country, category, rate, effective dates, legal basis, source URL, verification time, and publication status. Category pages are indexable only for verified published records; this implementation establishes the data boundary without fabricating category rules.

## Structured Data

Pages use connected JSON-LD graphs with stable fragment identifiers. The dataset landing page includes `Dataset`, provenance, license, temporal and spatial coverage, and distributions. Change pages use `Article` plus `BreadcrumbList`. Country tools use `WebPage`, `WebApplication`, `Country`, and breadcrumbs. FAQ schema remains optional and is not treated as a traffic feature.

## Internal Linking

Country hubs link to country history, validator, recent change events, dataset, and a small set of approved or rate-similar countries. Change events link to their country hub, history, adjacent changes, and dataset. Archive pages link to event details. Random alphabetical related-country lists are replaced with deterministic relevance.

## Automation and Quality Gates

An SEO audit command verifies canonical-host leakage, sitemap structure, translation readiness, invalid indexable shared calculations, and stale generated discovery files. IndexNow submission is optional and event-driven through configuration; it submits only canonical changed URLs. Google discovery continues through accurate sitemaps and Search Console.

## Testing

Feature tests cover host redirects, robots directives, shared-calculation indexability, locale gating, reciprocal hreflang, sitemap sections, truthful dates, new page routes, comparison allowlists, dataset downloads, and IndexNow payloads. Existing unrelated baseline failures are documented separately and are not accepted as regressions in the new SEO test suite.
