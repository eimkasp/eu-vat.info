<?php

namespace App\Console\Commands;

use App\Models\Country;
use App\Models\VatRate;
use Illuminate\Console\Command;

class VerifyVatRates extends Command
{
    protected $signature = 'vat:verify {--fix : Update countries whose standard rate differs from the current rate history}';

    protected $description = 'Compare each country\'s standard rate with the current entry in the synced VAT rate history';

    public function handle(): int
    {
        $today = now()->toDateString();
        $mismatches = 0;

        Country::query()->orderBy('name')->each(function (Country $country) use ($today, &$mismatches) {
            $current = VatRate::query()
                ->where('country_id', $country->id)
                ->where('type', 'standard')
                ->whereDate('effective_from', '<=', $today)
                ->where(fn ($query) => $query->whereNull('effective_to')->orWhereDate('effective_to', '>', $today))
                ->orderByDesc('effective_from')
                ->value('rate');

            if ($current === null) {
                $this->warn("{$country->name}: no current standard rate in the rate history, skipped.");

                return;
            }

            if (abs((float) $country->standard_rate - (float) $current) < 0.01) {
                $this->line("{$country->name}: OK (".Country::formatRate($current).'%)');

                return;
            }

            $mismatches++;
            $this->error("{$country->name}: countries table has {$country->standard_rate}%, rate history has {$current}%.");

            if ($this->option('fix')) {
                $country->update(['standard_rate' => $current]);
                $this->info("{$country->name}: updated to ".Country::formatRate($current).'%.');
            }
        });

        $this->info($mismatches === 0 ? 'All standard rates match the rate history.' : "{$mismatches} mismatch(es) found.");

        return self::SUCCESS;
    }
}
