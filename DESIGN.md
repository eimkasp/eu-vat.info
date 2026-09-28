---
name: EU VAT Info
description: A calm, authoritative reference desk for European VAT data and tools.
colors:
  institutional-blue: "#003399"
  institutional-blue-deep: "#002B7A"
  action-blue: "#2563EB"
  action-blue-deep: "#1D4ED8"
  reference-ink: "#172033"
  supporting-ink: "#536176"
  quiet-ink: "#65758B"
  workspace: "#F4F7FB"
  surface: "#FFFFFF"
  surface-subtle: "#EEF3F8"
  border: "#D8E0EA"
  success: "#067647"
  warning: "#B54708"
  error: "#B42318"
typography:
  display:
    fontFamily: "Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, sans-serif"
    fontSize: "3rem"
    fontWeight: 750
    lineHeight: 1.08
    letterSpacing: "-0.03em"
  headline:
    fontFamily: "Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, sans-serif"
    fontSize: "1.75rem"
    fontWeight: 700
    lineHeight: 1.2
    letterSpacing: "-0.02em"
  title:
    fontFamily: "Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, sans-serif"
    fontSize: "1.125rem"
    fontWeight: 700
    lineHeight: 1.35
  body:
    fontFamily: "Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, sans-serif"
    fontSize: "1rem"
    fontWeight: 400
    lineHeight: 1.6
  label:
    fontFamily: "Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, sans-serif"
    fontSize: "0.8125rem"
    fontWeight: 650
    lineHeight: 1.35
    letterSpacing: "0.01em"
rounded:
  sm: "6px"
  md: "8px"
  lg: "12px"
  xl: "16px"
  pill: "999px"
spacing:
  xs: "4px"
  sm: "8px"
  md: "12px"
  lg: "16px"
  xl: "24px"
  2xl: "32px"
  3xl: "48px"
  4xl: "64px"
components:
  button-primary:
    backgroundColor: "{colors.action-blue}"
    textColor: "{colors.surface}"
    rounded: "{rounded.md}"
    padding: "12px 20px"
  button-primary-hover:
    backgroundColor: "{colors.action-blue-deep}"
    textColor: "{colors.surface}"
    rounded: "{rounded.md}"
    padding: "12px 20px"
  button-secondary:
    backgroundColor: "{colors.surface}"
    textColor: "{colors.reference-ink}"
    rounded: "{rounded.md}"
    padding: "12px 20px"
  field:
    backgroundColor: "{colors.surface}"
    textColor: "{colors.reference-ink}"
    rounded: "{rounded.md}"
    padding: "12px 14px"
  data-surface:
    backgroundColor: "{colors.surface}"
    textColor: "{colors.reference-ink}"
    rounded: "{rounded.lg}"
    padding: "24px"
---

# Design System: EU VAT Info

## Overview

**Creative North Star: "The Reference Desk"**

EU VAT Info should feel like a well-organized professional desk: the current answer is immediately visible, supporting evidence is close at hand, and deeper material is available without crowding the primary task. A finance manager should be able to use it in bright office light on a laptop or phone without decoding the interface first.

The system is restrained, data-forward, and familiar. It preserves the established institutional blue identity while replacing decorative depth and generic SaaS treatments with crisp surfaces, measured spacing, and explicit hierarchy. Motion communicates state only and completes within 150–250ms.

**Key Characteristics:**

- Task-first composition with compact, predictable controls.
- Strong alignment for monetary values, percentages, dates, and rankings.
- Institutional blue for identity; action blue only for interactive priority and selection.
- Flat surfaces separated by tone and fine borders rather than diffuse decoration.
- Mobile layouts that preserve the calculation result and primary action without overlaying content.

## Colors

The palette combines established EU blue with cool neutral working surfaces and semantic colors reserved for real status.

### Primary

- **Institutional Blue:** Brand, global navigation, and trust-bearing identity surfaces.
- **Action Blue:** Primary actions, current selection, links, and keyboard focus.

### Secondary

- **Reference Ink:** Primary copy, headings, and high-value numeric data.
- **Supporting Ink:** Secondary copy and labels that must remain readable at WCAG AA.

### Neutral

- **Workspace:** Default page canvas behind task surfaces.
- **Surface:** Forms, tables, and panels containing interactive or structured content.
- **Surface Subtle:** Table headings, segmented controls, and quiet grouped regions.
- **Border:** Structural separation between fields, rows, and adjacent surfaces.

### Named Rules

**The Action Ration Rule.** Action blue is used for primary actions, current selection, links, and focus—not as ambient decoration.

**The Trust Color Rule.** Success, warning, and error colors communicate verified state only and always include text or an icon.

## Typography

**Display Font:** Inter with system sans fallbacks
**Body Font:** Inter with system sans fallbacks

**Character:** One disciplined sans family keeps dense data and multilingual UI consistent. Hierarchy comes from weight, spacing, and alignment rather than exaggerated size changes.

### Hierarchy

- **Display** (750, 3rem, 1.08): Homepage and major tool titles only; letter spacing never tighter than -0.03em.
- **Headline** (700, 1.75rem, 1.2): Major section headings and country page titles.
- **Title** (700, 1.125rem, 1.35): Panels, table sections, and grouped results.
- **Body** (400, 1rem, 1.6): Explanations and guidance, capped at 72ch.
- **Label** (650, 0.8125rem, 1.35): Controls and data descriptors; use sentence case by default.

### Named Rules

**The Working Scale Rule.** Product typography uses fixed rem sizes and a compact ratio; fluid display type and oversized dashboard headings are prohibited.

**The Numeric Alignment Rule.** Rates and currency values use tabular numerals and align by column or edge.

## Elevation

The system is flat by default. Depth is conveyed through tonal layering and borders; small, tight shadows may appear only on floating menus or a focused primary workflow. Wide ambient shadows are prohibited.

### Shadow Vocabulary

- **Focused workflow** (`0 4px 8px rgba(23, 32, 51, 0.10)`): The primary calculator surface only.
- **Floating menu** (`0 8px 16px rgba(23, 32, 51, 0.14)`): Dropdowns and popovers that must visually leave the page plane.

### Named Rules

**The Flat-by-Default Rule.** If a border and tonal surface can explain the hierarchy, no shadow is added.

## Components

### Buttons

- **Shape:** Compact corners (8px) and minimum 44px touch height.
- **Primary:** Action blue with white text and 12px by 20px padding.
- **Hover / Focus:** Darker action blue on hover; a high-contrast 2px focus ring with 2px offset.
- **Secondary:** White or subtle surface, reference ink, and a structural border.

### Chips

- **Style:** Compact pills for rate types and status only; never decorative tags.
- **State:** Selected chips use pale blue plus action-blue text and border. Unselected chips use a neutral border and surface.

### Cards / Containers

- **Corner Style:** 12px for standard task panels and 16px only for the primary calculator.
- **Background:** White on the workspace canvas or subtle neutral for grouped rows.
- **Shadow Strategy:** Flat by default; primary workflow may use the focused-workflow shadow.
- **Border:** One-pixel structural border in Border.
- **Internal Padding:** 16px on mobile, 24px on desktop.

### Inputs / Fields

- **Style:** White surface, one-pixel border, 8px corners, and at least 44px height.
- **Focus:** Action-blue border and focus ring; placeholder copy meets WCAG AA.
- **Error / Disabled:** Error text is adjacent to the field; disabled controls remain legible and visibly inactive.

### Navigation

Global navigation uses institutional blue, compact spacing, and a visible active state. Mobile navigation remains fixed only when the page reserves equivalent bottom space; every destination has a minimum 44px target and `aria-current` when active.

### VAT Calculator

The calculator is the signature task surface. Mode, country, amount, rate, and result follow a single top-to-bottom reading order on mobile and a left-to-right working order on larger screens. Source and freshness cues sit near the calculation rather than as decorative metrics.

## Do's and Don'ts

### Do:

- **Do** preserve Institutional Blue for the global identity and Action Blue for user action.
- **Do** align currency values and percentages with tabular numerals.
- **Do** keep primary touch targets at least 44px tall.
- **Do** use borders and neutral surfaces before shadows.
- **Do** provide visible keyboard focus, reduced-motion alternatives, and WCAG 2.2 AA contrast.

### Don't:

- **Don't** use generic SaaS styling: excessive gradients, oversized decorative cards, vanity metrics, glass effects, or flashy motion.
- **Don't** pair a one-pixel border with a wide diffuse shadow on the same surface.
- **Don't** use gradients as text or as default section backgrounds.
- **Don't** use tiny uppercase tracked labels as the page's repeated visual scaffold.
- **Don't** place fixed mobile navigation over results without reserving content space.
- **Don't** use color alone to communicate validation, rate direction, or selection.

## Implementation

The system is implemented with Tailwind CSS 4 in `resources/css/app.css`. There is no component library: every surface is built from the tokens and component classes below, so light and dark themes stay consistent.

### Semantic tokens

Colors are OKLCH custom properties (`--ui-*`) exposed to Tailwind through `@theme inline`, which yields utilities such as `bg-surface`, `text-ink-muted`, `border-line` and `bg-action-soft`. The `.dark` class (set before first paint from the visitor's system preference or saved choice) swaps every token, so templates never need `dark:` variants.

| Token | Use |
|---|---|
| `workspace`, `surface`, `surface-subtle`, `surface-muted` | Page canvas, panels, grouped rows, quiet fills |
| `line`, `line-strong` | Structural borders and field outlines |
| `ink`, `ink-muted`, `ink-quiet` | Primary, supporting and tertiary text |
| `brand`, `brand-deep` | Institutional blue identity surfaces (header, heroes) |
| `action`, `action-deep`, `action-soft`, `button`, `button-hover` | Links, selection, focus and primary buttons |
| `success`, `warning`, `danger` (+ `-soft`) | Verified state only, always paired with an icon and text |
| `code`, `code-raised`, `code-muted` | Code samples, dark in both themes |

### Component classes

`app-surface`, `app-surface-raised`, `app-field`, `app-select`, `app-button-primary`, `app-button-secondary`, `app-button-ghost`, `app-chip` / `app-chip-active`, `app-table`, `app-code`, `app-prose`, `app-kbd`, `app-flag`, `hero-canvas` and the `app-container` utility. Shared Blade components live in `resources/views/components`: `x-page-header`, `x-hero-backdrop`, `x-ui.icon`, `x-ui.flag`, `x-json-ld`, `x-europe-map`.

### Data visualisation

The VAT map uses a five-step single-hue sequential ramp (`--map-0` … `--map-4`), stepped separately for light and dark mode and validated for colour-vision deficiencies. Every region is also exposed as text: an accessible name on the map and a ranked table beside it. Bars and meters use the action fill on a track of the same hue.

### Rules for new templates

- Use semantic tokens; the legacy gray/blue palette remap in `app.css` only keeps un-migrated templates legible in dark mode.
- Write schema.org data with `<x-json-ld :data="…">`. Blade treats `@context` as a directive, so the component adds it.
- Use local flags through `<x-ui.flag>`; no third-party image hosts.
- Put new UI copy in `lang/en/ui.php` and translate it for all 24 locales.
