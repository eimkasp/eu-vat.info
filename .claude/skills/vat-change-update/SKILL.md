---
name: vat-change-update
description: Weekly review of EU VAT rate changes against official sources. Use when asked to update VAT changes, research VAT announcements, refresh data/vat_changes.csv or run the VAT audit.
---

# Weekly VAT change update

`docs/vat-change-updates.md` is the source of truth: ledger columns, the schedule, the official source for every country and the troubleshooting notes. Read it first.

## Rules

- Accuracy over coverage. A row needs a primary source you have opened: the official gazette, the tax authority, the finance ministry or government, parliament, or the European Commission. News, consultancies and the community dataset are leads only.
- `enacted` means adopted and published (or confirmed by a government decision) with a fixed effective date. Everything else is `announced`. Say "not found" rather than guess a date.
- Never edit `data/vat_rates.csv` (it is downloaded every Monday) or `public/v1`.
- Record national rates only: never a regional or territorial rate (islands, overseas departments, special zones). A temporary rate with a legal end date is two rows (start and scheduled end); a measure that depends on a future condition or has no fixed date stays `announced` or out of the file.
- One row per country, rate type and effective date. Describe what the rate applies to at the start of `description`. Use `reduced` for any category that moves to another rate; `super_reduced` and `parking` only when that band's own value changes.

## Procedure

1. `php artisan vat-changes:audit` for leads, then open the official sources in the docs table for every EU member state: acts published since the last review, anything taking effect in the next 12 months, and announcements.
2. Edit `data/vat_changes.csv`: add or correct rows, promote announcements whose act is now published, remove abandoned ones.
3. If a country's set of rates changed, correct its `reduced_rate`, `super_reduced_rate` or `parking_rate` through Filament or a guarded data migration (see the docs).
4. Update `content/blog/upcoming-vat-changes-2026-2027.md` for upcoming changes.
5. Validate: `php artisan vat-changes:import --dry-run`, `./vendor/bin/pest --filter=VatChange`, `./vendor/bin/pint --test`. A new official publisher host goes into `config/vat-changes.php`.
6. Open a pull request listing every added or changed row with its source link, what was checked and found unchanged, and anything that could not be verified.
