---
name: design-system
description: EU VAT Info design system rules. Use whenever you create or change a Blade view, a Livewire component's markup, resources/css/app.css or an Alpine UI component, or when you review UI changes.
---

# EU VAT Info design system

`DESIGN.md` at the repository root is the source of truth. Read its **Quick start for agents** and the component recipe you need before editing markup.

The look is solid and institutional: flat EU navy for the header, heroes and footer, EU gold only as a thin accent on navy, opaque white surfaces with hairline borders, square corners and tabular figures.

## Non-negotiables (enforced by `tests/Feature/DesignSystemTest.php`)

- Style with semantic tokens and the `app-*` classes from `resources/css/app.css`. No raw palette colours (`bg-blue-600`), no `dark:` variants, no literal colours, no default `shadow-*`, no `backdrop-*` blur and no gradient utilities.
- Radii come from the scale: `rounded-control` (4px), `rounded-card` (6px), `rounded-panel` (8px), plus `rounded-xs`/`rounded-sm` for flags and badges. No pills: `rounded-full` is only for dots, spinners and avatars.
- Navy areas use `hero-canvas`, `bg-brand` or `bg-brand-deep` with `on-brand`; tiles on navy use `app-brand-panel`; menus and toasts use `app-popover`.
- Icons via `<x-ui.icon>`, flags via `<x-ui.flag>`, structured data via `<x-json-ld>`, every `<img>` with `alt`.
- White text only on `bg-button`, never on `bg-action`. Gold only on navy, never as body text.
- New strings go to `lang/en/ui.php` and all 24 locales.
- A new token or component class must be documented in `DESIGN.md` in the same change.

## Verify before you finish

```bash
yarn build
php artisan test --filter=DesignSystemTest
php artisan test
vendor/bin/pint --test
```

Check the changed pages in light and dark mode at 390px and 1440px wide.
