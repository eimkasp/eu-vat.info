# Website Improvement Tasks

## Page Strategy
- Page Type: SaaS tool / VAT information resource
- Target Audience: Businesses, developers, accountants dealing with EU VAT
- Primary Conversion Goal: Calculator engagement (use the tool) → return visits → API adoption
- Secondary Goals: Country page deep dives, embed widget adoption, bookmark/share
- Desired Visitor Emotion: "This is the most reliable, fast, free EU VAT resource"
- Key Competitors: vatcalc.com, avalara.com, vatlive.com
- Weakest Link in Conversion Path: Value clarity for non-English speakers (hero calculator was fully hardcoded English)

## Iteration Status
- Current Iteration: 1 (completed)
- Last Review Date: 2026-04-01
- Overall Health Score: 70/120
- Primary Focus: Conversion
- Secondary Focus: Visual Design
- Perspective Lens: First-time visitor
- Mode: REFINE

## Score Breakdown
| Dimension | Score | Previous | Delta |
|---|---:|---:|---:|
| Conversion | 12/20 | 11/20 | +1 |
| Visual Design | 13/20 | 12/20 | +1 |
| Content | 12/20 | 10/20 | +2 |
| SEO | 14/20 | 14/20 | 0 |
| Usability | 12/20 | 11/20 | +1 |
| Performance | 12/20 | 12/20 | 0 |

## Current Batch
(Completed — see task_history.md)

## Backlog
### High Impact
- [ ] TASK-005 | Content | Add hero headline/value prop to homepage (currently goes straight to calculator with no context) | Biz: 5 | User: 4 | Effort: 2 | Priority: 36
- [ ] TASK-006 | Conversion | Add social proof / trust indicators near calculator (e.g. "Used by X businesses", data source badge) | Biz: 5 | User: 3 | Effort: 2 | Priority: 32
- [ ] TASK-007 | SEO | Country page uses @section('title') instead of x-seo-meta component — inconsistent meta handling | Biz: 3 | User: 2 | Effort: 2 | Priority: 20
- [ ] TASK-008 | Conversion | VAT calculator page subtitle hardcoded English: "Calculate VAT instantly..." | Biz: 4 | User: 4 | Effort: 2 | Priority: 32

### Quick Wins
- [ ] TASK-009 | Performance | Remove unused `showMap: true` Alpine variable from home.blade.php | Biz: 1 | User: 1 | Effort: 1 | Priority: 10
- [ ] TASK-010 | Visual | Remove CSS custom properties in layout that don't match actual usage (--primary etc.) | Biz: 1 | User: 1 | Effort: 1 | Priority: 10
- [ ] TASK-011 | Usability | Add aria-label to country selector dropdown in hero calculator (ARIA listbox role) | Biz: 2 | User: 3 | Effort: 2 | Priority: 20

### Strategic
- [ ] TASK-012 | Content | Translate remaining hardcoded strings on vat-calculator.blade.php page (outside hero calc) | Biz: 3 | User: 4 | Effort: 3 | Priority: 21
- [ ] TASK-013 | SEO | Add BreadcrumbList JSON-LD schema to all pages | Biz: 3 | User: 1 | Effort: 2 | Priority: 16
- [ ] TASK-014 | Performance | Optimize hero background image (check size, use WebP, add width/height) | Biz: 2 | User: 3 | Effort: 2 | Priority: 20

### Deferred
- [ ] TASK-015 | Testing | Fix 2 pre-existing test failures (VatCalculatorPageTest, UxImprovementsTest) | Biz: 1 | User: 0 | Effort: 2 | Priority: 4
