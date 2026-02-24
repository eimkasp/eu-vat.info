<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UpdateVatRates implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 60;

    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('UpdateVatRates job started.');

        $this->downloadLatestCsv();
        $this->runSeeder();
        $this->syncCountryRates();

        Log::info('UpdateVatRates job finished.');
    }

    /**
     * Download the latest VAT rates CSV from kdeldycke/vat-rates GitHub repo.
     */
    private function downloadLatestCsv(): void
    {
        $url = 'https://raw.githubusercontent.com/kdeldycke/vat-rates/main/vat_rates.csv';
        $path = base_path('data/vat_rates.csv');

        $response = Http::timeout(30)->get($url);

        if (!$response->successful()) {
            Log::error("Failed to download VAT rates CSV. Status: {$response->status()}");
            throw new \RuntimeException("Failed to download VAT rates CSV: HTTP {$response->status()}");
        }

        if (!File::exists(dirname($path))) {
            File::makeDirectory(dirname($path), 0755, true);
        }

        File::put($path, $response->body());
        Log::info("Downloaded latest VAT rates CSV ({$this->countCsvLines($response->body())} records).");
    }

    /**
     * Run the VatRateSeeder to import CSV data into vat_rates table.
     */
    private function runSeeder(): void
    {
        Artisan::call('db:seed', [
            '--class' => 'VatRateSeeder',
            '--force' => true,
        ]);
        Log::info('VatRateSeeder executed successfully.');
    }

    /**
     * Sync latest active VatRate records back to the countries table.
     */
    private function syncCountryRates(): void
    {
        $job = new VerifyVatRatesIntegrity();
        $job->handle();
    }

    private function countCsvLines(string $content): int
    {
        return max(0, substr_count($content, "\n") - 1); // minus header
    }
}
