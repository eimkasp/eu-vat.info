<?php

namespace App\Console\Commands;

use App\Services\VatChanges\RateAudit;
use Carbon\CarbonImmutable;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;

class AuditVatChanges extends Command
{
    protected $signature = 'vat-changes:audit
        {--date= : Situation date to audit (default: today)}
        {--json : Print the findings as JSON}';

    protected $description = 'Compare the stored VAT rates with the rates the Member States report to the European Commission (TEDB).';

    public function handle(RateAudit $audit): int
    {
        try {
            $date = $this->option('date') ? CarbonImmutable::parse($this->option('date')) : CarbonImmutable::today();
            $findings = $audit->findings($date);
        } catch (RuntimeException|Throwable $exception) {
            Log::error('VAT rate audit failed: '.$exception->getMessage());
            $this->error('The audit could not run: '.$exception->getMessage());

            return self::FAILURE;
        }

        if ($this->option('json')) {
            $this->line(json_encode($findings, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

            return $findings === [] ? self::SUCCESS : self::FAILURE;
        }

        if ($findings === []) {
            $this->info("Stored rates match the European Commission's TEDB for every member state on {$date->toDateString()}.");

            return self::SUCCESS;
        }

        $this->table(['Country', 'Type', 'Official', 'Stored', 'Difference'], array_map(fn (array $finding) => [
            $finding['country'],
            $finding['type'],
            $this->list($finding['official']),
            $this->list($finding['stored']),
            $finding['note'] ?? trim(($finding['add'] ? 'add '.$this->list($finding['add']).'  ' : '').($finding['remove'] ? 'remove '.$this->list($finding['remove']) : '')),
        ], $findings));

        Log::warning('VAT rate audit found '.count($findings).' difference(s) from the European Commission TEDB.', ['findings' => $findings]);
        $this->warn(count($findings).' difference(s). Check each against the national source, then record it in the ledger or correct the stored rate (docs/vat-change-updates.md).');

        return self::FAILURE;
    }

    /**
     * @param  list<float>  $rates
     */
    private function list(array $rates): string
    {
        return $rates === [] ? '–' : implode(' / ', array_map(fn (float $rate) => rtrim(rtrim(number_format($rate, 2, '.', ''), '0'), '.'), $rates));
    }
}
