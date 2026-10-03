# VAT change updates

How EU VAT Info keeps its rates and its change history in step with the law. The weekly review takes about 30 minutes; everything else runs on the schedule.

## How the data flows

| Step | What | When |
|------|------|------|
| Community rates | `UpdateVatRates` downloads `data/vat_rates.csv` (kdeldycke/vat-rates) and seeds `vat_rates` | Mondays 03:00 |
| **Change ledger** | `vat-changes:import` publishes the enacted rows of `data/vat_changes.csv` to `vat_rate_changes` and, for standard, super-reduced and parking changes, to `vat_rates` | daily 03:30 |
| Integrity | `VerifyVatRatesIntegrity` copies the rate in force from `vat_rates` to `countries` (so a rate enacted for a future date applies on that date) | daily 04:00 |
| Generated history | `GenerateVatRateChanges` turns differences between consecutive `vat_rates` rows into generic change rows, skipping events the ledger already covers | daily 04:30 |
| Alerts | `vat-changes:notify-subscribers` emails changes imported with `--notify` in the last 24 hours | daily 05:00 |
| **Audit** | `vat-changes:audit` compares the stored rates with what Member States report to the European Commission (TEDB) and fails when they differ | Mondays 06:00 |

The ledger is the reviewed, sourced record. The community feed fills the gaps; whenever both describe the same change (same country, rate type and rates, dates within 200 days), the ledger row wins and no duplicate appears.

Set `VAT_CHANGES_ALERT_EMAIL` to receive the output of an import that fails or an audit that finds differences; both are always written to `storage/logs/vat-changes.log` and `storage/logs/vat-audit.log`.

## The ledger: `data/vat_changes.csv`

One row per change, keyed by country, rate type and effective date (these three form the page URL `/vat-changes/{country}/{rate_type}/{date}`, so they must be unique).

| Column | Rule |
|--------|------|
| `country` | ISO 3166-1 alpha-2 code as stored in `countries.iso_code`. Greece is `GR` |
| `rate_type` | `standard` for the general rate. `reduced` for anything else that moves to or from another rate (say what in `description`). `super_reduced` or `parking` only when the country's own super-reduced or parking rate changes value |
| `old_rate`, `new_rate` | Percentages the goods or services paid before and after, such as `21` or `13.5`. Only national rates are recorded: regional and territorial rates (Greek islands, Canary Islands, French overseas departments, Madeira and the Azores, Jungholz and Mittelberg) never appear in the ledger, and a `standard` change of more than 6 percentage points is rejected |
| `effective_date` | The day the new rate applies, `YYYY-MM-DD` |
| `announced_date` | The day the act was published or the decision announced, or empty |
| `status` | `enacted`: adopted and published in the official gazette, or confirmed by the government in a decision with a fixed effective date. `announced`: proposed, announced or approved by one chamber only |
| `reason` | Why the government changed the rate, in a few words, or empty |
| `description` | What changes, starting with what the rate applies to. Shown on the change page and in alerts. Not "Rate changed from X% to Y%" |
| `source` | The publisher, for example `Riigi Teataja` or `Bundesgesetzblatt I Nr. 43/2026` |
| `source_url` | `https` link to the official text or notice. The host must be listed in `config/vat-changes.php` (`official_hosts`) |
| `official_document` | The legal act or official notice, required for enacted rows |

Only `enacted` rows reach the site. `announced` rows are the watchlist: they stay in the file, the import counts them, and it warns when one is still announced after its effective date. Promote a row by changing its status once the act is published, or delete it if the plan is dropped.

A change that depends on a future condition (a price index threshold, a government review) stays `announced` until the condition is met. A temporary rate with a legal end date is recorded as two rows: the start and the scheduled end, which becomes void if the law is extended. A change whose date is not fixed yet is not recorded; keep it as a lead in the pull request.

A chain of `standard`, `super_reduced` or `parking` rows for one country must connect (each `old_rate` equals the previous `new_rate`); a gap means a change is missing.

```csv
country,rate_type,old_rate,new_rate,effective_date,announced_date,status,reason,description,source,source_url,official_document
EE,standard,22,24,2025-07-01,2025-02-12,enacted,Budget consolidation,The standard rate rose from 22% to 24%.,Riigi Teataja,https://www.riigiteataja.ee/akt/...,Value Added Tax Act amendment
```

## The weekly review

1. **Get the leads.** `php artisan vat-changes:audit` (production or a database copy). Each line is a country whose stored rates differ from the Commission's. The Commission publishes semi-annually, so it lags the law by up to six months and never shows announcements.
2. **Read the official sources** for the countries below, newest first: acts published since the last review, anything taking effect in the next 12 months, and government announcements. Use news and consultancy notes as pointers only; every row needs a primary source you have opened.
3. **Edit `data/vat_changes.csv`.** Add rows, correct rows, promote announcements. Keep a row's `source_url` pointing at the most authoritative text.
4. **Keep the country's rate list right.** If the change adds or removes a rate the country applies (a new reduced rate, a rate that disappears), correct `countries.reduced_rate`, `super_reduced_rate` or `parking_rate` too: edit the country in Filament, or ship a data migration modelled on `2026_10_01_000000_apply_verified_vat_changes.php`, whose corrections apply only while the stored value still equals the old one. Standard-rate changes follow on their effective date by themselves.
5. **Validate.** `php artisan vat-changes:import --dry-run` lists what would be created or updated and prints every ledger error with its line. `./vendor/bin/pest --filter=VatChange` runs the ledger checks, including that every `source_url` belongs to an official publisher.
6. **Update the editorial tracker** `content/blog/upcoming-vat-changes-2026-2027.md` for anything upcoming.
7. **Open a pull request.** After the merge and deploy, the 03:30 import publishes the rows and subscribers are alerted at 05:00 (changes effective within the last 30 days or in the future). To publish at once, run `php artisan vat-changes:import --notify` on the server.

Most announcements appear with the autumn budgets (September to December): check the budget speeches and tax bills of each government as they are presented, and re-check the acts after parliament votes.

If the audit stays red for a difference that is real and intended (the Commission files a single-category rate under another type, or the site lists a rate the Commission does not), add it to `audit.ignore` in `config/vat-changes.php` with the country and rate type.

## What counts as official

Primary sources only: the official gazette or legislation database, the tax authority, the finance ministry or government, parliament, and the European Commission (TEDB, EUR-Lex). A proposal is `announced` until the act is published; an act without a fixed effective date is not yet a change.

| Country | Legislation | Tax authority and ministry |
|---------|-------------|----------------------------|
| AT | ris.bka.gv.at (BGBl.) | bmf.gv.at, usp.gv.at |
| BE | ejustice.just.fgov.be (Moniteur belge) | finance.belgium.be |
| BG | dv.parliament.bg (State Gazette) | nra.bg, minfin.bg |
| HR | narodne-novine.nn.hr | porezna-uprava.gov.hr, mfin.gov.hr |
| CY | cylaw.org, gov.cy | mof.gov.cy, tax.gov.cy |
| CZ | e-sbirka.cz | financnisprava.cz, mfcr.cz |
| DK | retsinformation.dk | skat.dk, skm.dk |
| EE | riigiteataja.ee | emta.ee, fin.ee |
| FI | finlex.fi | vero.fi, vm.fi |
| FR | legifrance.gouv.fr (JORF) | impots.gouv.fr (BOFiP), economie.gouv.fr |
| DE | recht.bund.de (BGBl.), gesetze-im-internet.de | bundesfinanzministerium.de |
| GR | et.gr (ΦΕΚ) | aade.gr, minfin.gr |
| HU | magyarkozlony.hu, njt.hu | nav.gov.hu, kormany.hu |
| IE | irishstatutebook.ie | revenue.ie, gov.ie |
| IT | gazzettaufficiale.it, normattiva.it | agenziaentrate.gov.it, finanze.gov.it |
| LV | likumi.lv, vestnesis.lv | vid.gov.lv, fm.gov.lv |
| LT | e-tar.lt | vmi.lt, finmin.lrv.lt |
| LU | legilux.public.lu | aed.public.lu, gouvernement.lu |
| MT | legislation.mt | cfr.gov.mt, mfin.gov.mt |
| NL | officielebekendmakingen.nl (Staatsblad) | belastingdienst.nl, rijksoverheid.nl |
| PL | dziennikustaw.gov.pl, isap.sejm.gov.pl | podatki.gov.pl, gov.pl/web/finanse |
| PT | diariodarepublica.pt | portaldasfinancas.gov.pt |
| RO | monitoruloficial.ro | anaf.ro, mfinante.gov.ro |
| SK | slov-lex.sk | financnasprava.sk, mfsr.sk |
| SI | uradni-list.si, pisrs.si | fu.gov.si |
| ES | boe.es | agenciatributaria.es, hacienda.gob.es |
| SE | riksdagen.se, svenskforfattningssamling.se | skatteverket.se, regeringen.se |
| EU | eur-lex.europa.eu | ec.europa.eu/taxation_customs/tedb |

## Running the review with Claude Code

The `vat-change-update` skill (`.claude/skills/vat-change-update`) carries this procedure. A scheduled agent can run it weekly and open the pull request for review:

```
Run the vat-change-update skill: audit the stored rates, research the official sources for every EU member state, update data/vat_changes.csv and the editorial tracker, validate, and open a pull request that lists each change with its source.
```

## Open leads from the first review (1 October 2026)

The first review recorded what could be confirmed from a primary source. These leads were not confirmed and are the first items of the next review; delete each one once it is checked.

- **Belgium:** the Moniteur belge act behind the accommodation move to 12% on 1 March 2026 (the row rests on the Commission's TEDB); pesticides and fossil fuels dropped from the 12% list in 2025.
- **Croatia:** the rate after the temporary 5% on gas, district heating and firewood ends on 31 March 2027 (13% expected, not stated in an official page); whether it is extended again.
- **Cyprus:** the decree for the zero rate renewed from 12 October 2026; the announced cut on residential photovoltaic systems from 19% to 9%.
- **Czechia:** publication and date of effect of the EET 2.0 act (12% on non-alcoholic drinks in catering); a reported 0% on prescription medicines.
- **Denmark:** the government's plan to halve VAT on food and remove it on fruit and vegetables, and the bill on books (expected from 2027); no dates yet.
- **France:** the 2027 finance bill presented on 1 October 2026; the Budget Law 2026 articles beyond arts. 81, 93 and 96.
- **Ireland:** Budget 2027 on 6 October 2026.
- **Italy:** the Budget Laws 2025 and 2026 and the new VAT code (Legislative Decree 10/2026, in force from 2027) were not read; no Italian change is recorded, which does not mean there was none.
- **Portugal:** changes with an inferred previous rate (household electricity up to 200 kWh from 2025, game species and olive-oil services from 2026, the 6% rate for housing works under Decree-Law 97/2026) and the 2027 State Budget.
- **Romania:** whether a 2026 act extended the 9% rate on first-home purchases beyond 31 July 2026.
- **Slovenia:** a reported emergency law with 5% on staple foods and 9.5% on energy, not confirmed by an official source.
- **Spain:** the November and December 2026 results of the conditional 10% rate (Real Decreto-ley 25/2026) and the validation of Real Decreto-ley 26/2026.
- **Greece, Croatia, Malta:** nothing found for Budget 2027 announcements. Greek island rates are regional and are not recorded.

## Troubleshooting

- **`vat-changes:import` prints the ledger errors and exits 1.** Nothing was imported. Fix the lines it names; the previous data stays in place.
- **A country is skipped.** Its code is not in `countries`; check the ISO code (Greece is `GR`).
- **The change page shows 404.** The change page needs an EU member country and an enacted row with that rate type and date.
- **Subscribers were not alerted.** Alerts go out only for rows imported with `--notify` (the scheduled run does) within the last 24 hours, and only when the effective date is within the last 30 days or in the future. Backfilled history is imported silently.
