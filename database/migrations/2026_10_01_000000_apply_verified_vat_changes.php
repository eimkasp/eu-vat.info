<?php

use App\Models\Country;
use App\Services\VatChanges\InvalidLedgerException;
use App\Services\VatChanges\VatChangeImporter;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Brings production up to date with the rates the Member States report to the European Commission (TEDB, 2026-07-01
 * situation) and publishes the VAT change ledger.
 *
 * Each correction names the value it replaces and is applied only while the stored value still equals it, so a figure
 * that an administrator has already corrected is never overwritten and re-running the migration changes nothing.
 */
return new class extends Migration
{
    /**
     * [iso code, column, expected stored value, new value]
     */
    private const CORRECTIONS = [
        ['AT', 'super_reduced_rate', null, 4.9],
        ['CY', 'super_reduced_rate', null, 3],
        ['EE', 'reduced_rate', '9', '9 / 13'],
        ['FI', 'reduced_rate', '10 / 14', '10 / 13.5'],
        ['LT', 'reduced_rate', '5 / 9', '5 / 12'],
        ['LU', 'reduced_rate', '8', '8 / 14'],
        ['MT', 'parking_rate', null, 12],
        ['RO', 'reduced_rate', '5 / 9', '11'],
        ['SK', 'reduced_rate', '10', '5 / 19'],
        ['SK', 'super_reduced_rate', 5, null],
    ];

    public function up(): void
    {
        if (! DB::table('countries')->exists()) {
            return;
        }

        foreach (self::CORRECTIONS as [$iso, $column, $expected, $value]) {
            $this->correct($iso, $column, $expected, $value);
        }

        $this->publishLedger();

        VatChangeImporter::forgetCaches();
    }

    public function down(): void
    {
        // Verified data is not reverted: restoring the earlier values would reintroduce rates that are no longer in force.
    }

    private function correct(string $iso, string $column, string|int|float|null $expected, string|int|float|null $value): void
    {
        DB::table('countries')
            ->where('iso_code', $iso)
            ->get(['id', $column])
            ->filter(fn (object $country) => $this->same($country->{$column}, $expected, $column))
            ->each(fn (object $country) => DB::table('countries')
                ->where('id', $country->id)
                ->update([$column => $value, 'updated_at' => now()]));
    }

    private function same(mixed $stored, string|int|float|null $expected, string $column): bool
    {
        if ($stored === null || $expected === null) {
            return $stored === $expected;
        }

        return $column === 'reduced_rate'
            ? Country::parseRateList($stored) === Country::parseRateList($expected)
            : abs((float) $stored - (float) $expected) < 0.001;
    }

    private function publishLedger(): void
    {
        try {
            $report = app(VatChangeImporter::class)->import();

            Log::info("VAT change ledger imported by migration: {$report->created} created, {$report->updated} updated, {$report->unchanged} unchanged.");
        } catch (InvalidLedgerException $exception) {
            Log::error($exception->getMessage());
        }
    }
};
