# Changelog

All notable changes to EU VAT Info are documented here.

---

## [Unreleased] — 2026-04-29

### Added
- **Shareable calculation links** — every VAT calculation gets its own unique URL. Copy and send it to your accountant, client, or colleague and they'll see the exact same breakdown — country, amount, rate, and direction all preserved.
- **Popular VAT calculations** — browse ready-made VAT breakdowns for the most common amounts (€100, €500, €1,000, €5,000…) across all 27 EU countries. No typing required, just click and see.
- **This changelog** — you can now track what's new without digging through anything.

### Improved
- Every country's VAT calculator page now shows a clearer title and description including the exact standard rate, making it much easier to find the right page in search results.
- The VAT rate change history page now surfaces in search results with richer information, so you can see at a glance that it covers all 27 EU countries.

---

## [4.0.0] — 2025-07-17 — Accessibility & Usability

### Improved
- Text on country hero images now has stronger contrast so it stays readable regardless of how dark or light the flag colours are.
- Animations and transitions now respect your operating system's "reduce motion" preference — no more spinning or sliding if you've asked your device to keep things still.

### Fixed
- "Skip to content" link now works correctly for keyboard and screen-reader users.
- Navigation focus rings are clearly visible again when using the keyboard to move through the site.

---

## [3.0.0] — 2026-04-01 — Trust & Transparency

### Added
- Trust badges on the homepage and calculator pages: **Official European Commission data**, **Always free**, **All 27 EU countries**, **No sign-up required** — so you know exactly what you're getting.

### Fixed
- VAT calculator pages in all 24 EU languages now correctly show translated titles and descriptions in search results, not English text.
- Country selector dropdowns now work correctly with screen readers and other assistive technology.

---

## [2.0.0] — 2026-04-01 — Homepage Refresh

### Added
- New headline and introduction on the homepage — first-time visitors can now immediately understand what EU VAT Info is and what it does.

### Improved
- Mobile layout across calculator pages — better spacing, larger tap targets, and improved readability on small screens.

---

## [1.0.0] — 2026-04-01 — Launch

### Added
- Full support for all 24 official EU languages — the entire site adapts to your preferred language automatically.
- VAT calculator for all 27 EU countries with standard, reduced, super-reduced, and parking rates.
- VIES VAT number validator to verify EU business VAT registrations instantly.
- Interactive Europe map showing current VAT rates at a glance.
- VAT rate change history going back to 2000.
- DaisyUI theme had placeholder test colors (`#ff00ff`, `#00ff00`) — replaced with brand palette
  (`secondary: #0EA5E9`, `neutral: #374151`, `warning: #F59E0B`)
- Country rates table heading hardcoded English — replaced with translation calls
- FAQ accordion on country page had no ARIA attributes — added full accordion ARIA pattern
  (`aria-expanded`, `aria-controls`, `role="region"`, `aria-hidden` on decorative SVG)
