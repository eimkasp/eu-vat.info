<?php

use App\Jobs\GenerateVatRateChanges;
use App\Jobs\VerifyVatRatesIntegrity;
use App\Livewire\VatChangesHistory;
use App\Models\Country;
use App\Models\VatRate;
use App\Models\VatRateChange;
use App\Services\VatChanges\VatChangeImporter;
use Database\Seeders\CountriesTableSeeder;
use Database\Seeders\VatRateSeeder;
use Livewire\Livewire;

beforeEach(function () {
    $this->seed(CountriesTableSeeder::class);
    $this->estonia = Country::where('iso_code', 'EE')->firstOrFail();
    $this->romania = Country::where('iso_code', 'RO')->firstOrFail();
});

it('publishes enacted changes silently and keeps announcements on the watchlist', function () {
    $path = vatLedgerFile([
        vatLedgerRow(),
        vatLedgerRow(['country' => 'RO', 'rate_type' => 'reduced', 'old_rate' => '9', 'new_rate' => '11', 'effective_date' => '2025-08-01', 'description' => 'Food and medicines moved from 9% to the single 11% reduced rate.']),
        vatLedgerRow(['country' => 'AT', 'rate_type' => 'reduced', 'old_rate' => '10', 'new_rate' => '5', 'effective_date' => '2099-01-01', 'announced_date' => '', 'status' => 'announced', 'official_document' => '']),
        vatLedgerRow(['country' => 'ZZ', 'effective_date' => '2025-01-01', 'announced_date' => '']),
    ]);

    $report = app(VatChangeImporter::class)->import($path);

    expect($report->created)->toBe(2)
        ->and($report->watchlist)->toHaveCount(1)
        ->and($report->skipped)->toHaveCount(1)
        ->and(VatRateChange::count())->toBe(2);

    $change = VatRateChange::where('country_id', $this->estonia->id)->firstOrFail();

    expect($change->rate_type)->toBe('standard')
        ->and((float) $change->old_rate)->toBe(22.0)
        ->and((float) $change->new_rate)->toBe(24.0)
        ->and($change->change_date->toDateString())->toBe('2025-07-01')
        ->and($change->announced_date->toDateString())->toBe('2025-03-01')
        ->and($change->change_direction)->toBe('increase')
        ->and((float) $change->percentage_change)->toBe(9.09)
        ->and($change->source_url)->toBe('https://www.riigiteataja.ee/akt/example')
        ->and($change->official_document)->toContain('Value Added Tax Act')
        ->and($change->notification_sent)->toBeTrue()
        ->and($change->notification_sent_at)->not->toBeNull();
});

it('leaves new changes unsent when subscribers should be alerted', function () {
    app(VatChangeImporter::class)->import(vatLedgerFile([vatLedgerRow()]), notify: true);

    $change = VatRateChange::firstOrFail();

    expect($change->notification_sent)->toBeFalse()
        ->and($change->notification_sent_at)->toBeNull();
});

it('can be repeated without creating or altering anything', function () {
    $path = vatLedgerFile([vatLedgerRow(), vatLedgerRow(['rate_type' => 'reduced', 'old_rate' => '9', 'new_rate' => '13', 'effective_date' => '2025-01-01', 'announced_date' => ''])]);

    app(VatChangeImporter::class)->import($path);
    $before = VatRateChange::orderBy('id')->get()->toArray();
    $report = app(VatChangeImporter::class)->import($path, notify: true);

    expect($report->created)->toBe(0)
        ->and($report->updated)->toBe(0)
        ->and($report->unchanged)->toBe(2)
        ->and(VatRateChange::orderBy('id')->get()->toArray())->toBe($before);
});

it('writes nothing during a dry run', function () {
    $report = app(VatChangeImporter::class)->import(vatLedgerFile([vatLedgerRow()]), dryRun: true);

    expect($report->created)->toBe(1)
        ->and(VatRateChange::count())->toBe(0)
        ->and(VatRate::count())->toBe(0);
});

it('updates a changed row in place', function () {
    app(VatChangeImporter::class)->import(vatLedgerFile([vatLedgerRow()]));
    $report = app(VatChangeImporter::class)->import(vatLedgerFile([vatLedgerRow(['description' => 'Corrected wording.', 'source' => 'Ministry of Finance'])]));

    expect($report->updated)->toBe(1)
        ->and(VatRateChange::count())->toBe(1)
        ->and(VatRateChange::first()->description)->toBe('Corrected wording.')
        ->and(VatRateChange::first()->source)->toBe('Ministry of Finance');
});

it('adopts the generic community row for the same change instead of adding a duplicate', function () {
    $community = VatRate::create(['country_id' => $this->estonia->id, 'type' => 'standard', 'rate' => 24, 'effective_from' => '2025-06-15', 'source' => VatRateSeeder::SOURCE]);
    $generic = VatRateChange::create([
        'country_id' => $this->estonia->id, 'vat_rate_id' => $community->id, 'rate_type' => 'standard', 'old_rate' => 22, 'new_rate' => 24,
        'change_date' => '2025-06-15', 'description' => 'Rate changed from 22% to 24%', 'source' => VatRateSeeder::SOURCE,
    ]);

    app(VatChangeImporter::class)->import(vatLedgerFile([vatLedgerRow()]));

    $generic->refresh();

    expect(VatRateChange::count())->toBe(1)
        ->and($generic->change_date->toDateString())->toBe('2025-07-01')
        ->and($generic->source_url)->toBe('https://www.riigiteataja.ee/akt/example')
        ->and($generic->vat_rate_id)->toBe($community->id)
        ->and(VatRate::count())->toBe(1);
});

it('records single-rate changes as rate periods and closes the previous one', function () {
    VatRate::create(['country_id' => $this->estonia->id, 'type' => 'standard', 'rate' => 22, 'effective_from' => '2024-01-01', 'source' => VatRateSeeder::SOURCE]);

    app(VatChangeImporter::class)->import(vatLedgerFile([
        vatLedgerRow(),
        vatLedgerRow(['rate_type' => 'reduced', 'old_rate' => '9', 'new_rate' => '13', 'effective_date' => '2025-01-01', 'announced_date' => '']),
    ]));

    $previous = VatRate::whereDate('effective_from', '2024-01-01')->firstOrFail();
    $current = VatRate::whereDate('effective_from', '2025-07-01')->firstOrFail();

    expect($previous->effective_to->toDateString())->toBe('2025-07-01')
        ->and((float) $current->rate)->toBe(24.0)
        ->and($current->source)->toBe('Riigi Teataja')
        ->and(VatRate::where('type', 'reduced')->count())->toBe(0)
        ->and(VatRateChange::where('rate_type', 'standard')->firstOrFail()->vat_rate_id)->toBe($current->id);
});

it('moves a country to its new standard rate on the effective date through the integrity job', function () {
    $this->estonia->update(['standard_rate' => 22]);
    VatRate::create(['country_id' => $this->estonia->id, 'type' => 'standard', 'rate' => 22, 'effective_from' => '2024-01-01', 'source' => VatRateSeeder::SOURCE]);

    app(VatChangeImporter::class)->import(vatLedgerFile([vatLedgerRow(['effective_date' => now()->addDays(10)->toDateString(), 'announced_date' => ''])]));
    (new VerifyVatRatesIntegrity)->handle();

    expect((float) $this->estonia->fresh()->standard_rate)->toBe(22.0);

    $this->travel(11)->days();
    (new VerifyVatRatesIntegrity)->handle();

    expect((float) $this->estonia->fresh()->standard_rate)->toBe(24.0);
});

it('stops the generator and the community seeder from duplicating or overwriting curated data', function () {
    app(VatChangeImporter::class)->import(vatLedgerFile([vatLedgerRow(['country' => 'RO', 'old_rate' => '19', 'new_rate' => '21', 'effective_date' => '2025-08-01', 'announced_date' => ''])]));

    VatRate::where('country_id', $this->romania->id)->whereDate('effective_from', '2025-08-01')->update(['rate' => 21, 'source' => 'Monitorul Oficial']);
    VatRate::create(['country_id' => $this->romania->id, 'type' => 'standard', 'rate' => 19, 'effective_from' => '2017-01-01', 'effective_to' => '2025-08-01', 'source' => VatRateSeeder::SOURCE]);

    $this->seed(VatRateSeeder::class);
    (new GenerateVatRateChanges)->handle();
    (new GenerateVatRateChanges)->handle();

    $romania = VatRateChange::where('country_id', $this->romania->id)->where('rate_type', 'standard')->where('change_date', '>=', '2025-01-01')->get();

    expect($romania)->toHaveCount(1)
        ->and($romania->first()->source_url)->toBe('https://www.riigiteataja.ee/akt/example')
        ->and(VatRate::where('country_id', $this->romania->id)->whereDate('effective_from', '2025-08-01')->value('source'))->toBe('Monitorul Oficial');
});

it('does not generate a second row when the community date differs slightly from the official date', function () {
    app(VatChangeImporter::class)->import(vatLedgerFile([vatLedgerRow()]));

    VatRate::create(['country_id' => $this->estonia->id, 'type' => 'standard', 'rate' => 22, 'effective_from' => '2024-01-01', 'effective_to' => '2025-06-20', 'source' => VatRateSeeder::SOURCE]);
    VatRate::create(['country_id' => $this->estonia->id, 'type' => 'standard', 'rate' => 24, 'effective_from' => '2025-06-20', 'source' => VatRateSeeder::SOURCE]);
    (new GenerateVatRateChanges)->handle();

    expect(VatRateChange::where('country_id', $this->estonia->id)->count())->toBe(1);
});

it('shows an imported change with its legal basis and official source on its page', function () {
    app(VatChangeImporter::class)->import(vatLedgerFile([vatLedgerRow()]));

    $this->get('/vat-changes/estonia/standard/2025-07-01')
        ->assertOk()
        ->assertSee('The standard rate rose from 22% to 24%.')
        ->assertSee('Legal basis')
        ->assertSee('Value Added Tax Act amendment, RT I, 2025')
        ->assertSee('href="https://www.riigiteataja.ee/akt/example"', false);
});

it('counts only standard-rate changes in the country stability ranking', function () {
    app(VatChangeImporter::class)->import(vatLedgerFile([
        vatLedgerRow(),
        vatLedgerRow(['rate_type' => 'reduced', 'old_rate' => '9', 'new_rate' => '13', 'effective_date' => '2025-01-01', 'announced_date' => '']),
    ]));

    $estonia = collect(Livewire::test(VatChangesHistory::class)->instance()->stability)->firstWhere('iso', 'EE');

    expect($estonia['changes'])->toBe(1);
});

it('imports from the command and reports invalid ledgers with a failing exit code', function () {
    $this->artisan('vat-changes:import', ['--path' => vatLedgerFile([vatLedgerRow()])])
        ->expectsOutputToContain('1 created, 0 updated, 0 unchanged, 0 on the watchlist.')
        ->assertExitCode(0);

    $this->artisan('vat-changes:import', ['--path' => vatLedgerFile([vatLedgerRow(['country' => 'ee'])])])
        ->expectsOutputToContain('The ledger was not imported')
        ->assertExitCode(1);

    expect(VatRateChange::count())->toBe(1);
});

it('warns about announcements whose effective date has passed', function () {
    $this->artisan('vat-changes:import', ['--path' => vatLedgerFile([vatLedgerRow(['status' => 'announced', 'effective_date' => '2025-07-01', 'official_document' => ''])]), '--dry-run' => true])
        ->expectsOutputToContain('still announced')
        ->assertExitCode(0);
});

it('publishes the committed ledger without errors', function () {
    $report = app(VatChangeImporter::class)->import(dryRun: true);

    expect($report->skipped)->toBe([]);
});
