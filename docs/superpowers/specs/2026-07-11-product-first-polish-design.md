# Product-first polish design

## Intent

Polish EU VAT Info into an authoritative, calm, efficient working tool. The primary experience is rate lookup and VAT calculation; brand expression supports trust but never competes with the task.

## Chosen direction

Use the **Reference Desk** direction: a cool neutral workspace, flat white data surfaces, established institutional blue for identity, and brighter action blue only for interactive priority. This direction preserves the existing brand while removing generic SaaS cues such as background gradients, oversized rounded cards, diffuse shadows, decorative metrics, and unnecessary motion.

## Scope

The implementation focuses on the highest-leverage surfaces:

- Shared application shell: page canvas, global typography, focus, header, footer, and mobile navigation.
- Homepage: hero hierarchy, calculator integration, source/freshness cues, country rate table, and sidebar rhythm.
- Signature calculator: control density, button hierarchy, selected states, results readability, and mobile reflow.
- Trust correctness: the homepage's “EU VAT Rates” list must include EU members only.

Existing routes, translations, Livewire behavior, SEO metadata, structured data, and the established `#003399` identity remain intact.

## Experience design

The homepage opens with a compact task introduction and the calculator. The background image remains as a quiet contextual layer but no longer carries the entire page or creates a long parallax scene. Below the task, data moves onto a clean workspace canvas. The rate table becomes the dominant reference surface; supporting widgets remain visibly secondary.

On desktop, the calculator preserves a horizontal workflow. On mobile, mode, country, amount, action, rates, and result follow a strict vertical sequence. The fixed bottom navigation reserves matching page space so it cannot cover the result. Trust cues are presented as one compact source line rather than four decorative claims.

## Visual system

- One system sans family with a compact fixed type scale.
- `#003399` for identity; `#2563EB` for primary action, selection, links, and focus.
- `#F4F7FB` workspace, white task surfaces, `#D8E0EA` structural borders.
- Standard panel radius 12px; signature calculator radius 16px; controls 8px.
- Flat by default. Only the calculator and floating menus may use tight shadows.
- State transitions complete in 150–250ms and stop under reduced motion.

## Accessibility

Target WCAG 2.2 AA. All interactive elements maintain visible keyboard focus, meaningful accessible names, at least 44px touch height, and color-independent selected/error states. Body and placeholder copy use contrast-safe colors. Motion is state-only and disabled or shortened for `prefers-reduced-motion`.

## Functional behavior

`Home` queries only countries where `is_eu_member` is true, preserving ascending standard-rate order and search filtering. The calculator's existing add/remove modes, country lookup, custom rates, calculation history, share links, and localized copy remain functional.

## Verification

- Pest regression test confirms non-EU rows do not appear in homepage data.
- Existing feature and unit tests pass.
- Vite production build succeeds.
- Impeccable detector is run on touched UI files and actionable findings are resolved.
- Browser review covers 390px mobile, 768px tablet, and 1440px desktop; primary calculation is exercised with keyboard navigation and checked for overlap, horizontal scroll, and console errors.
