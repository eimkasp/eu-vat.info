<?php

namespace App\Console\Commands;

use App\Jobs\GenerateVatRateChanges;
use App\Jobs\UpdateVatRates;
use App\Jobs\VerifyVatRatesIntegrity;
use Illuminate\Console\Command;

class RefreshVatRates extends Command
{
    protected $signature = 'vat:refresh 
        {--skip-download : Skip downloading new CSV from GitHub}
        {--no-changes : Skip generating change records}
        {--queue : Dispatch jobs to queue instead of running synchronously}';

    protected $description = 'Refresh VAT rates from source (kdeldycke/vat-rates), verify integrity, and generate change records';

    public function handle(): int
    {
        $this->info('🔄 Starting VAT rates refresh...');
        $startTime = microtime(true);

        try {
            if ($this->option('queue')) {
                return $this->dispatchToQueue();
            }

            return $this->runSynchronously();
        } catch (\Exception $e) {
            $this->error("❌ Refresh failed: {$e->getMessage()}");
            return self::FAILURE;
        } finally {
            $elapsed = round(microtime(true) - $startTime, 2);
            $this->newLine();
            $this->info("⏱ Total time: {$elapsed}s");
        }
    }

    private function runSynchronously(): int
    {
        // Step 1: Download & seed
        if (!$this->option('skip-download')) {
            $this->info('Step 1/3: Downloading latest VAT rates from GitHub...');
            $job = new UpdateVatRates();
            $job->handle();
            $this->info('  ✓ Downloaded and seeded VAT rates.');
        } else {
            $this->info('Step 1/3: Skipped download (--skip-download).');
        }

        // Step 2: Verify integrity
        $this->info('Step 2/3: Verifying data integrity...');
        $verifyJob = new VerifyVatRatesIntegrity();
        $verifyJob->handle();
        $this->info('  ✓ Integrity check complete.');

        // Step 3: Generate change records
        if (!$this->option('no-changes')) {
            $this->info('Step 3/3: Generating VAT rate change records...');
            $changesJob = new GenerateVatRateChanges();
            $changesJob->handle();
            $this->info('  ✓ Change records generated.');
        } else {
            $this->info('Step 3/3: Skipped change generation (--no-changes).');
        }

        $this->newLine();
        $this->info('✅ VAT rates refresh complete!');

        return self::SUCCESS;
    }

    private function dispatchToQueue(): int
    {
        UpdateVatRates::dispatch();
        VerifyVatRatesIntegrity::dispatch()->delay(now()->addMinutes(2));
        GenerateVatRateChanges::dispatch()->delay(now()->addMinutes(4));

        $this->info('✅ Jobs dispatched to queue (UpdateVatRates → VerifyIntegrity → GenerateChanges).');

        return self::SUCCESS;
    }
}
