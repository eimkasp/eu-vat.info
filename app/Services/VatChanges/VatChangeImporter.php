<?php

namespace App\Services\VatChanges;

use App\Jobs\GenerateVatRateChanges;
use App\Models\Country;
use App\Models\VatRate;
use App\Models\VatRateChange;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

final class VatChangeImporter
{
    private const SINGLE_RATE_TYPES = ['standard', 'super_reduced', 'parking'];

    private const CACHE_KEYS = [
        'vat_map_countries_v2',
        'home_eu_countries_v3',
        'html_sitemap_countries_v2',
        'top_calculations_countries_v2',
        'hero_calculator_countries_v4',
        'sidebar_vat_rate_changes_v2',
        'vat_changes_countries_v2',
        'vat_changes_summary_v1',
        'vat_change_stability_v2',
        'vies_validator_countries_v1',
        'api_countries',
        'api_v1_countries',
        'mcp_all_vat_rates_v2',
        'x402_premium_vat_rates',
        'all_eu_countries_amp',
        'calculator_country_directory_v2',
    ];

    public function __construct(private readonly LedgerReader $reader) {}

    /**
     * Publishes the enacted rows of the ledger. Safe to repeat: rows are keyed by country, rate type and effective date.
     * Announced rows are only counted; they stay out of the public history until they are enacted.
     *
     * @throws InvalidLedgerException
     */
    public function import(?string $path = null, bool $notify = false, bool $dryRun = false): ImportReport
    {
        $rows = $this->reader->read($path ?? (string) config('vat-changes.ledger'));
        $countries = Country::query()->pluck('id', 'iso_code')->mapWithKeys(fn ($id, $iso) => [strtoupper((string) $iso) => $id]);
        $report = new ImportReport;

        DB::beginTransaction();

        try {
            foreach ($rows as $row) {
                if (! $row->isEnacted()) {
                    $report->watchlist[] = $row;

                    continue;
                }

                $countryId = $countries[$row->country] ?? null;

                if ($countryId === null) {
                    $report->skipped[] = "Line {$row->line}: {$row->country} is not in the countries table.";

                    continue;
                }

                match ($this->publish($row, $countryId, $notify)) {
                    'created' => $report->created++,
                    'updated' => $report->updated++,
                    default => $report->unchanged++,
                };
            }

            $dryRun ? DB::rollBack() : DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();

            throw $exception;
        }

        if (! $dryRun && $report->written() > 0) {
            self::forgetCaches();
        }

        return $report;
    }

    public static function forgetCaches(): void
    {
        foreach (self::CACHE_KEYS as $key) {
            Cache::forget($key);
        }

        Country::query()->pluck('slug')->each(function ($slug) {
            foreach (['api_country_', 'api_v1_country_', 'x402_premium_country_'] as $prefix) {
                Cache::forget($prefix.$slug);
            }
        });
    }

    private function publish(LedgerRow $row, int $countryId, bool $notify): string
    {
        $change = $this->existingChange($row, $countryId);
        $vatRateId = $this->syncVatRate($row, $countryId) ?? $change?->vat_rate_id;

        $attributes = [
            'vat_rate_id' => $vatRateId,
            'old_rate' => $row->oldRate,
            'new_rate' => $row->newRate,
            'change_date' => $row->effectiveDate->toDateString(),
            'announced_date' => $row->announcedDate?->toDateString(),
            'change_reason' => $row->reason,
            'description' => $row->description,
            'source' => $row->source,
            'source_url' => $row->sourceUrl,
            'official_document' => $row->officialDocument,
            'percentage_change' => $this->percentageChange($row),
            'change_direction' => $row->newRate > $row->oldRate ? 'increase' : 'decrease',
        ];

        if ($change === null) {
            VatRateChange::create($attributes + [
                'country_id' => $countryId,
                'rate_type' => $row->rateType,
                'notification_sent' => ! $notify,
                'notification_sent_at' => $notify ? null : now(),
            ]);

            return 'created';
        }

        $change->fill($attributes);

        if (! $change->isDirty()) {
            return 'unchanged';
        }

        $change->save();

        return 'updated';
    }

    /**
     * The row for this change: the one on the same date, or the generic "Rate changed from X% to Y%" row that the
     * community dataset produced with a slightly different date.
     */
    private function existingChange(LedgerRow $row, int $countryId): ?VatRateChange
    {
        $changes = VatRateChange::query()->where('country_id', $countryId)->where('rate_type', $row->rateType);

        return (clone $changes)->whereDate('change_date', $row->effectiveDate->toDateString())->first()
            ?? $changes->whereNull('source_url')
                ->where('old_rate', $row->oldRate)
                ->where('new_rate', $row->newRate)
                ->whereBetween('change_date', $this->window($row))
                ->orderBy('change_date')
                ->first();
    }

    /**
     * Keeps vat_rates in step so the daily integrity job moves countries.* on the effective date.
     */
    private function syncVatRate(LedgerRow $row, int $countryId): ?int
    {
        if (! in_array($row->rateType, self::SINGLE_RATE_TYPES, true)) {
            return null;
        }

        $periods = VatRate::query()->where('country_id', $countryId)->where('type', $row->rateType);
        $date = $row->effectiveDate->toDateString();

        if ($exact = (clone $periods)->whereDate('effective_from', $date)->first()) {
            if (abs((float) $exact->rate - $row->newRate) > 0.001) {
                $exact->update(['rate' => $row->newRate, 'source' => $row->source]);
            }

            return $exact->id;
        }

        if ($near = (clone $periods)->where('rate', $row->newRate)->whereBetween('effective_from', $this->window($row))->first()) {
            return $near->id;
        }

        $previous = (clone $periods)->whereDate('effective_from', '<', $date)->whereNull('effective_to')->orderByDesc('effective_from')->first();

        if ($previous && abs((float) $previous->rate - $row->oldRate) < 0.01) {
            $previous->update(['effective_to' => $date]);
        }

        return VatRate::create([
            'country_id' => $countryId,
            'type' => $row->rateType,
            'rate' => $row->newRate,
            'effective_from' => $date,
            'source' => $row->source,
        ])->id;
    }

    /**
     * @return array{0: string, 1: string}
     */
    private function window(LedgerRow $row): array
    {
        return [
            $row->effectiveDate->subDays(GenerateVatRateChanges::SAME_EVENT_WINDOW_DAYS)->toDateString(),
            $row->effectiveDate->addDays(GenerateVatRateChanges::SAME_EVENT_WINDOW_DAYS)->toDateString(),
        ];
    }

    private function percentageChange(LedgerRow $row): ?float
    {
        if ($row->oldRate == 0.0) {
            return null;
        }

        $percentage = round((($row->newRate - $row->oldRate) / $row->oldRate) * 100, 2);

        return abs($percentage) > 999.99 ? null : $percentage;
    }
}
