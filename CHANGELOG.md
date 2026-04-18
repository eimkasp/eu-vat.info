# Changelog

All notable changes to EU VAT Info are documented here.  
Format loosely follows [Keep a Changelog](https://keepachangelog.com/en/1.1.0/).

---

## [Unreleased] — 2026-04-18

### Agent Readiness & AI Discovery

A full pass to make eu-vat.info natively discoverable and usable by AI agents,
LLM orchestration frameworks, and MCP-compatible clients — without any authentication.

#### Content Signals (`robots.txt`)
- Added `Content-Signal: ai-train=yes, search=yes, ai-input=yes` under `User-agent: *`  
  per the [Content Signals spec](https://contentsignals.org/) (Cloudflare / IETF draft).  
  Declares permissive content-usage preferences for AI training, search indexing, and AI input (RAG/grounding).

#### RFC 8414 — OAuth 2.0 Authorization Server Metadata
- Published `GET /.well-known/oauth-authorization-server`  
  Correctly describes the site as a **public API** with no OAuth flows:
  - `grant_types_supported: []` — no token acquisition needed
  - `token_endpoint_auth_methods_supported: ["none"]`
  - `jwks_uri` — points to companion JWKS endpoint

#### RFC 7517 — JSON Web Key Set
- Published `GET /.well-known/jwks.json`  
  Returns an empty key set (`{"keys": []}`) — no token signing since all APIs are open.

#### RFC 9728 — OAuth Protected Resource Metadata
- Published `GET /.well-known/oauth-protected-resource`  
  Agents can now programmatically discover:
  - `resource` — the canonical API identifier
  - `authorization_servers` — points to our own `oauth-authorization-server` doc
  - `scopes_supported: []` / `bearer_methods_supported: []` — confirming no auth required
  - `agent_skills` — array of Markdown skill URLs for VAT rates and VIES validation
  - `mcp` block — full MCP server metadata (endpoint, transport, protocol version, tool list)

#### Agent Skill Files
Published two Markdown skill files consumable directly by AI agents and MCP clients:

- `GET /.well-known/agent-skills/vat-rates/SKILL.md`  
  Covers all four MCP tools (`get_all_vat_rates`, `get_country_vat_rate`, `calculate_vat`,
  `compare_vat_rates`), REST API endpoints, request/response examples, and human-readable references.

- `GET /.well-known/agent-skills/vies-validation/SKILL.md`  
  Covers the `validate_vat_number` MCP tool, single and batch REST endpoints, full EU country
  code reference table (including the `EL` vs `GR` gotcha for Greece), and caching behaviour.

Both served with `Content-Type: text/markdown; charset=utf-8` via an allowlisted route.

#### Files Changed
| File | Change |
|------|--------|
| `public/robots.txt` | Added `Content-Signal` directive |
| `routes/web.php` | Added 5 new `.well-known` routes |
| `public/.well-known/agent-skills/vat-rates/SKILL.md` | New — VAT rates agent skill |
| `public/.well-known/agent-skills/vies-validation/SKILL.md` | New — VIES validation agent skill |

---

## [4.0.0] — 2025-07-17 — Iteration 4: Accessibility & Usability

**Score:** 87/120 (+4 from previous)  
**Focus:** Keyboard accessibility, motion preferences, contrast

### Fixed
- Skip-to-content link displayed raw `ui.skip_to_content` key instead of translated text  
  (`lang/en/ui.php` + `resources/views/components/layouts/app.blade.php`)
- Nav focus rings invisible on dark blue header — switched to white `outline` for keyboard users  
  (`resources/views/components/global-header.blade.php`)
- Parallax scroll animation now respects `prefers-reduced-motion: reduce` (WCAG 2.3.3)  
  (`resources/views/livewire/home.blade.php`)

### Improved
- Country page hero overlay contrast strengthened (`from-white/60` → `from-white/70`,
  `via-white/80` → `via-white/85`) for better legibility over dark flag images

---

## [3.0.0] — 2026-04-01 — Iteration 3: Trust & SEO Meta

**Score:** 83/120 (+4 from previous)  
**Focus:** Conversion trust signals, SEO meta i18n, accessibility

### Added
- Trust indicator badges below homepage and calculator page hero:  
  "Official European Commission data", "Always free", "All 27 EU countries", "No sign-up required"

### Fixed
- VAT calculator `@section('title')` and `@section('meta_description')` were hardcoded English
  for all 24 locales — replaced with `__('ui.calculator.meta_title_*')` translation calls
- Country selector dropdown lacked ARIA roles — added `aria-haspopup="listbox"`,
  `role="listbox"`, `role="option"`, `aria-selected`, `aria-expanded`, `aria-labelledby`

---

## [2.0.0] — 2026-04-01 — Iteration 2: Value Proposition & Visual Polish

**Score:** 79/120 (+4 from previous)  
**Focus:** Visual design, content clarity, mobile experience

### Added
- Homepage hero `<h1>` headline and subtitle — first-time visitors now have context above the calculator

### Fixed
- VAT calculator page heading/subtitle hardcoded English — replaced with `__('ui.calculator.*')` calls
- Removed unused `showMap: true` Alpine variable from homepage (`home.blade.php`)
- Removed unused CSS custom properties (`--primary`, `--secondary`, etc.) from app layout

---

## [1.0.0] — 2026-04-01 — Iteration 1: i18n Foundation & Accessibility

**Score:** 75/120 (baseline)  
**Focus:** i18n coverage, ARIA, DaisyUI theming

### Fixed
- Hero calculator had 20+ hardcoded English strings — replaced with `__('ui.calculator.*')` for all 24 locales
- DaisyUI theme had placeholder test colors (`#ff00ff`, `#00ff00`) — replaced with brand palette
  (`secondary: #0EA5E9`, `neutral: #374151`, `warning: #F59E0B`)
- Country rates table heading hardcoded English — replaced with translation calls
- FAQ accordion on country page had no ARIA attributes — added full accordion ARIA pattern
  (`aria-expanded`, `aria-controls`, `role="region"`, `aria-hidden` on decorative SVG)
