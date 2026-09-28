<?php

use App\Models\Country;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

/**
 * Two factual corrections for rows written by earlier tooling:
 *
 * 1. The original seeder averaged multi-rate reduced columns ("10 / 13" became "11.5"). The source
 *    list is restored only where the stored value still equals that exact average, so any value an
 *    administrator corrected by hand is left untouched.
 * 2. Bulgaria adopted the euro on 1 January 2026; rows still describing the lev are switched to EUR.
 */
return new class extends Migration
{
    public function up(): void
    {
        $this->restoreReducedRateLists();

        DB::table('countries')
            ->where('iso_code', 'BG')
            ->where(fn ($query) => $query->whereNull('currency_code')->orWhere('currency_code', 'BGN'))
            ->update([
                'currency' => 'Euro',
                'currency_code' => 'EUR',
                'currency_symbol' => '€',
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        // Data corrections are not reverted: restoring averaged rates or a retired currency would reintroduce wrong data.
    }

    private function restoreReducedRateLists(): void
    {
        $path = base_path('data/eu-vat-2024-jan.csv');

        if (! is_file($path)) {
            return;
        }

        $reader = Reader::createFromPath($path);
        $reader->setHeaderOffset(0);

        foreach ($reader->getRecords() as $record) {
            if (! preg_match('/\((\w{2})\)\s*$/', (string) ($record['Country'] ?? ''), $matches)) {
                continue;
            }

            $rates = Country::parseRateList($record['Reduced Rate (%)'] ?? null);

            if (count($rates) < 2) {
                continue;
            }

            $average = array_sum($rates) / count($rates);
            $list = implode(' / ', array_map(fn (float $rate) => Country::formatRate($rate), $rates));

            DB::table('countries')
                ->where('iso_code', $matches[1])
                ->get(['id', 'reduced_rate'])
                ->filter(fn (object $country) => is_numeric($country->reduced_rate) && abs((float) $country->reduced_rate - $average) < 0.001)
                ->each(fn (object $country) => DB::table('countries')
                    ->where('id', $country->id)
                    ->update(['reduced_rate' => $list, 'updated_at' => now()]));
        }
    }
};
