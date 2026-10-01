<?php

namespace Database\Seeders;

use App\Services\VatChanges\VatChangeImporter;
use Illuminate\Database\Seeder;

class VatChangeSeeder extends Seeder
{
    /**
     * Publishes data/vat_changes.csv without alerting subscribers. Safe to re-run.
     */
    public function run(VatChangeImporter $importer): void
    {
        $report = $importer->import();

        $this->command?->info("VAT change ledger: {$report->created} created, {$report->updated} updated, {$report->unchanged} unchanged.");
    }
}
