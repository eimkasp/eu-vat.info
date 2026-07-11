# Restore mountain atmosphere on country calculators

## Intent

Bring the existing European mountain image back to single-country VAT calculator pages without returning to the oversized, promotional hero layout. The image should make the page feel pleasant and recognizably branded while the calculator remains the dominant task.

## Approved direction

Use one continuous responsive mountain backdrop behind both the compact country header and the calculator. Apply a strong institutional-navy scrim so breadcrumbs, country identity, scope, rate, trust copy, and calculator edges remain legible. Keep the calculator itself white and unchanged in structure. The reference workspace below the calculator remains on the neutral product canvas.

## Composition

- Wrap the country header and calculator in one atmospheric section.
- Render the existing responsive assets from `public/images/eu-vat-calculator-background-*` with `<picture>` sources for mobile, tablet, and desktop.
- Use the image as presentation only with an empty alt value.
- Add a functional dark navy overlay for WCAG AA contrast; the overlay is a readability layer, not decorative glass or a flashy effect.
- Make the compact country-header component transparent inside this shared atmospheric section.
- Give the calculator measured vertical separation from the header, preserving its current maximum width and white task surface.
- Keep rate references, related countries, guidance, disclosures, and saved searches below on `bg-surface-subtle`.

## Calculator integration

Add a country-image surface variant to `HeroCalculator` presentation:

- It keeps maintained-rate versus official-EU wording scope-aware.
- It uses light trust/history text against the image.
- It continues to omit the redundant `Full Calculator` self-link on a country page.
- It preserves result scrolling, mobile bottom-navigation clearance, grouped selectors, and calculation behavior.

No data model, routing, sitemap, AMP, or country eligibility behavior changes are part of this update.

## Responsive behavior

- **Mobile:** use the small image source, keep the compact header single-column, and ensure the white calculator begins with comfortable inset spacing. The fixed bottom navigation and result scroll margin remain unchanged.
- **Tablet:** use the medium source and preserve the existing mixed calculator control row.
- **Desktop:** use the large source, maintain the current 1152px page container, and avoid increasing header height materially.
- No horizontal overflow at 320px, 375px, 768px, or desktop widths.

## Accessibility and performance

- Preload the WebP mountain image on country and generic calculator routes.
- Keep all page content visible when images fail to load by retaining the navy base color.
- Preserve a single `h1`, keyboard interaction, focus indicators, reduced-motion behavior, and 44px touch targets.
- Verify headline, supporting copy, breadcrumbs, scope labels, and trust indicators meet WCAG 2.2 AA against the final scrim.
- Do not animate the image.

## Testing and verification

- Update the country workspace regression to require the atmospheric wrapper and responsive mountain image instead of rejecting it.
- Confirm generic calculator imagery is unchanged.
- Run the full PHP suite, Pint, production build, and `git diff --check`.
- Visually verify Malta and Norway at 320px, 375px, 768px, and desktop, including a calculated mobile result.
- Confirm zero horizontal overflow and no browser console errors.

## Acceptance criteria

- Country calculator pages visibly use the mountain image behind the compact header and calculator.
- The UI remains calm, authoritative, calculator-first, and readable.
- The calculator and supporting workspace retain their existing information hierarchy and behavior.
- EU and non-EU trust wording remains truthful.
- Mobile results remain fully visible above the fixed navigation.
