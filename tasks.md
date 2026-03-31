# Website Improvement Tasks

## Page Strategy
- Page Type: SaaS tool / VAT information resource
- Target Audience: Businesses, developers, accountants dealing with EU VAT
- Primary Conversion Goal: Calculator engagement (use the tool) → return visits → API adoption
- Secondary Goals: Country page deep dives, embed widget adoption, bookmark/share
- Desired Visitor Emotion: "This is the most reliable, fast, free EU VAT resource"
- Key Competitors: vatcalc.com, avalara.com, vatlive.com
- Weakest Link in Conversion Path: Keyboard/a11y users hitting invisible focus states and missing skip nav

## Iteration Status
- Current Iteration: 4 (completed)
- Last Review Date: 2025-07-17
- Overall Health Score: 87/120
- Primary Focus: Usability
- Secondary Focus: Conversion
- Perspective Lens: Returning visitor
- Mode: REFINE

## Score Breakdown
| Dimension | Score | Previous | Delta |
|---|---:|---:|---:|
| Conversion | 15/20 | 15/20 | 0 |
| Visual Design | 15/20 | 14/20 | +1 |
| Content | 14/20 | 14/20 | 0 |
| SEO | 14/20 | 14/20 | 0 |
| Usability | 16/20 | 13/20 | +3 |
| Performance | 13/20 | 13/20 | 0 |

## Current Batch (Iteration 4 — completed)
- [x] TASK-018 | Usability | Fix skip-to-content missing translation key (raw key visible)
- [x] TASK-019 | Usability | Add visible focus-ring styles to nav links on dark header
- [x] TASK-020 | Usability | Add prefers-reduced-motion to homepage parallax animation
- [x] TASK-021 | Visual | Strengthen country page hero overlay contrast

## Backlog
### High Impact
- [ ] TASK-007 | SEO | Country page uses @section('title') instead of x-seo-meta component — inconsistent meta handling | Biz: 3 | User: 2 | Effort: 2 | Priority: 20
- [ ] TASK-016 | Conversion | Add structured FAQ section to vat-calculator page for common questions | Biz: 4 | User: 3 | Effort: 3 | Priority: 21

### Quick Wins
(none remaining)

### Strategic
- [ ] TASK-013 | SEO | Add BreadcrumbList JSON-LD schema to all pages | Biz: 3 | User: 1 | Effort: 2 | Priority: 16
- [ ] TASK-014 | Performance | Optimize hero background image (check size, use WebP, add width/height) | Biz: 2 | User: 3 | Effort: 2 | Priority: 20
- [ ] TASK-017 | Visual | Improve mobile calculator UX (larger touch targets, better spacing) | Biz: 3 | User: 4 | Effort: 3 | Priority: 21

### Deferred
- [ ] TASK-015 | Testing | Fix 2 pre-existing test failures (VatCalculatorPageTest, UxImprovementsTest) | Biz: 1 | User: 0 | Effort: 2 | Priority: 4
