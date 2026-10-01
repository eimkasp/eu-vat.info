<?php

use App\Models\Country;
use App\Models\VatRateChange;
use Database\Seeders\CountriesTableSeeder;
use Illuminate\Support\Facades\Cache;

function vatCatchUpMigration(): object
{
    return require database_path('migrations/2026_10_01_000000_apply_verified_vat_changes.php');
}

function vatCatchUpRates(string $iso): array
{
    return Country::where('iso_code', $iso)->firstOrFail()->only(['reduced_rate', 'super_reduced_rate', 'parking_rate']);
}

it('does nothing on an empty database', function () {
    vatCatchUpMigration()->up();

    expect(Country::count())->toBe(0)->and(VatRateChange::count())->toBe(0);
});

it('corrects stale rate sets, keeps hand-edited values and can be repeated', function () {
    $this->seed(CountriesTableSeeder::class);

    Country::where('iso_code', 'EE')->update(['reduced_rate' => '9']);
    Country::where('iso_code', 'FI')->update(['reduced_rate' => '10 / 14']);
    Country::where('iso_code', 'LT')->update(['reduced_rate' => '5 / 9 / 21']);
    Country::where('iso_code', 'RO')->update(['reduced_rate' => '5 / 9']);
    Country::where('iso_code', 'SK')->update(['reduced_rate' => '10', 'super_reduced_rate' => 5]);
    Country::where('iso_code', 'AT')->update(['super_reduced_rate' => null]);
    Country::where('iso_code', 'MT')->update(['parking_rate' => 11]);

    vatCatchUpMigration()->up();
    $afterFirstRun = Country::orderBy('id')->get()->toArray();
    vatCatchUpMigration()->up();

    expect(vatCatchUpRates('EE')['reduced_rate'])->toBe('9 / 13')
        ->and(vatCatchUpRates('FI')['reduced_rate'])->toBe('10 / 13.5')
        ->and(vatCatchUpRates('RO')['reduced_rate'])->toBe('11')
        ->and(vatCatchUpRates('SK')['reduced_rate'])->toBe('5 / 19')
        ->and(vatCatchUpRates('SK')['super_reduced_rate'])->toBeNull()
        ->and((float) vatCatchUpRates('AT')['super_reduced_rate'])->toBe(4.9)
        ->and(vatCatchUpRates('LT')['reduced_rate'])->toBe('5 / 9 / 21')
        ->and((float) vatCatchUpRates('MT')['parking_rate'])->toBe(11.0)
        ->and(Country::orderBy('id')->get()->toArray())->toBe($afterFirstRun);
});

it('publishes the ledger silently and refreshes cached rates', function () {
    $this->seed(CountriesTableSeeder::class);
    Cache::put('api_countries', 'stale');

    vatCatchUpMigration()->up();

    expect(Cache::has('api_countries'))->toBeFalse()
        ->and(VatRateChange::where('notification_sent', false)->count())->toBe(0);
});
