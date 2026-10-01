<?php

namespace App\Console\Commands;

use App\Services\VatChanges\ImportReport;
use App\Services\VatChanges\InvalidLedgerException;
use App\Services\VatChanges\VatChangeImporter;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ImportVatChanges extends Command
{
    protected $signature = 'vat-changes:import
        {--path= : Ledger CSV to import (default: config vat-changes.ledger)}
        {--notify : Leave new changes unsent so subscribers are alerted by vat-changes:notify-subscribers}
        {--dry-run : Report what would change without writing anything}';

    protected $description = 'Publish the enacted rows of the VAT change ledger (data/vat_changes.csv) to the VAT change history.';

    public function handle(VatChangeImporter $importer): int
    {
        try {
            $report = $importer->import($this->option('path') ?: null, (bool) $this->option('notify'), (bool) $this->option('dry-run'));
        } catch (InvalidLedgerException $exception) {
            Log::error($exception->getMessage());
            $this->error('The ledger was not imported:');

            foreach ($exception->errors as $error) {
                $this->line("  {$error}");
            }

            return self::FAILURE;
        }

        $prefix = $this->option('dry-run') ? 'Dry run: ' : '';
        $this->info("{$prefix}{$report->created} created, {$report->updated} updated, {$report->unchanged} unchanged, ".count($report->watchlist).' on the watchlist.');
        $this->reportAttention($report);

        if (! $this->option('dry-run') && $report->written() > 0) {
            Log::info("VAT change ledger imported: {$report->created} created, {$report->updated} updated.");
        }

        return self::SUCCESS;
    }

    private function reportAttention(ImportReport $report): void
    {
        foreach ($report->skipped as $skipped) {
            $this->warn($skipped);
        }

        $stale = array_filter($report->watchlist, fn ($row) => $row->effectiveDate->isPast());

        foreach ($stale as $row) {
            $this->warn("Line {$row->line}: {$row->country} {$row->rateType} is still announced although its effective date {$row->effectiveDate->toDateString()} has passed; mark it enacted or remove it.");
        }
    }
}
