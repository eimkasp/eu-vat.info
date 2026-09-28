<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * The previous VatRateSeeder keyed rows on a floating-point rate (e.g. 14.000000000000002), so every weekly
 * sync inserted duplicates. Keep the oldest row of each (country, type, start date, rate) group and re-point
 * rate-change references to it before deleting the copies.
 */
return new class extends Migration
{
    public function up(): void
    {
        $kept = [];

        DB::table('vat_rates')
            ->orderBy('id')
            ->get(['id', 'country_id', 'type', 'effective_from', 'rate'])
            ->each(function (object $row) use (&$kept) {
                $key = implode('|', [
                    $row->country_id,
                    strtolower((string) $row->type),
                    substr((string) $row->effective_from, 0, 10),
                    number_format((float) $row->rate, 2, '.', ''),
                ]);

                if (! isset($kept[$key])) {
                    $kept[$key] = $row->id;

                    return;
                }

                DB::transaction(function () use ($row, $kept, $key) {
                    DB::table('vat_rate_changes')->where('vat_rate_id', $row->id)->update(['vat_rate_id' => $kept[$key]]);
                    DB::table('vat_rates')->where('id', $row->id)->delete();
                });
            });
    }

    public function down(): void
    {
        // Duplicate rows carried no information of their own.
    }
};
