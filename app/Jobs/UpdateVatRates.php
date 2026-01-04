<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateVatRates implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UpdateVatRates implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Log::info('UpdateVatRates job started.');
        
        $this->updateFromGithub();
        
        Log::info('UpdateVatRates job finished.');
    }

    private function updateFromGithub()
    {
        $url = 'https://raw.githubusercontent.com/kdeldycke/vat-rates/main/vat_rates.csv';
        $path = base_path('data/vat_rates.csv');

        try {
            $response = Http::get($url);

            if ($response->successful()) {
                // Ensure directory exists
                if (!File::exists(dirname($path))) {
                    File::makeDirectory(dirname($path), 0755, true);
                }

                File::put($path, $response->body());
                Log::info("Downloaded latest VAT rates CSV to {$path}");

                // Run the seeder
                Artisan::call('db:seed', ['--class' => 'VatRateSeeder']);
                Log::info("VatRateSeeder executed successfully.");
            } else {
                Log::error("Failed to download VAT rates CSV. Status: " . $response->status());
            }
        } catch (\Exception $e) {
            Log::error("Error updating VAT rates: " . $e->getMessage());
        }
    }
}
