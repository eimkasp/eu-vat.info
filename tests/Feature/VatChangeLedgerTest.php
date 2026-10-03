<?php

use App\Models\Country;
use App\Services\VatChanges\InvalidLedgerException;
use App\Services\VatChanges\LedgerReader;
use Database\Seeders\CountriesTableSeeder;

it('reads a valid ledger ordered by effective date', function () {
    $rows = (new LedgerReader)->read(vatLedgerFile([
        vatLedgerRow(['country' => 'RO', 'old_rate' => '19', 'new_rate' => '21', 'effective_date' => '2025-08-01']),
        vatLedgerRow(['status' => 'announced', 'announced_date' => '', 'official_document' => '']),
    ]));

    expect($rows)->toHaveCount(2)
        ->and($rows[0]->country)->toBe('EE')
        ->and($rows[0]->isEnacted())->toBeFalse()
        ->and($rows[0]->announcedDate)->toBeNull()
        ->and($rows[1]->country)->toBe('RO')
        ->and($rows[1]->oldRate)->toBe(19.0)
        ->and($rows[1]->effectiveDate->toDateString())->toBe('2025-08-01');
});

it('rejects invalid rows and names the line', function (array $overrides, string $message) {
    $call = fn () => (new LedgerReader)->read(vatLedgerFile([vatLedgerRow(), vatLedgerRow($overrides + ['effective_date' => '2026-01-01', 'old_rate' => '24', 'new_rate' => '25'])]));

    expect($call)->toThrow(InvalidLedgerException::class, 'Line 3: '.$message);
})->with([
    'lower-case country' => [['country' => 'ee'], 'country must be an upper-case ISO'],
    'unknown rate type' => [['rate_type' => 'zero'], 'rate_type must be one of'],
    'rate that is not a number' => [['new_rate' => 'high'], 'new_rate must be a percentage'],
    'identical rates' => [['old_rate' => '24', 'new_rate' => '24'], 'old_rate and new_rate are identical'],
    'regional standard rate' => [['old_rate' => '24', 'new_rate' => '17'], 'a standard-rate change of more than 6 percentage points'],
    'impossible date' => [['effective_date' => '2026-02-30'], 'effective_date must be a valid YYYY-MM-DD date'],
    'announced after effective' => [['announced_date' => '2026-02-01'], 'announced_date cannot be after effective_date'],
    'unknown status' => [['status' => 'proposed'], 'status must be enacted or announced'],
    'missing description' => [['description' => ''], 'description is required'],
    'description that repeats the rates' => [['description' => 'Rate changed from 24% to 25%.'], 'description must explain the change'],
    'missing publisher' => [['source' => ''], 'source (the publisher) is required'],
    'plain http link' => [['source_url' => 'http://www.riigiteataja.ee/akt/example'], 'source_url must be an https URL'],
    'enacted without a legal reference' => [['official_document' => ''], 'official_document'],
]);

it('rejects duplicate changes and broken rate chains', function () {
    $duplicate = fn () => (new LedgerReader)->read(vatLedgerFile([vatLedgerRow(), vatLedgerRow(['reason' => 'Other'])]));
    $broken = fn () => (new LedgerReader)->read(vatLedgerFile([vatLedgerRow(), vatLedgerRow(['old_rate' => '20', 'new_rate' => '25', 'effective_date' => '2026-01-01'])]));

    expect($duplicate)->toThrow(InvalidLedgerException::class, 'duplicates line 2')
        ->and($broken)->toThrow(InvalidLedgerException::class, 'does not follow the previous EE standard change');
});

it('lets reduced-rate changes of different categories follow one another freely', function () {
    $rows = (new LedgerReader)->read(vatLedgerFile([
        vatLedgerRow(['rate_type' => 'reduced', 'old_rate' => '9', 'new_rate' => '13', 'effective_date' => '2025-01-01', 'announced_date' => '']),
        vatLedgerRow(['rate_type' => 'reduced', 'old_rate' => '5', 'new_rate' => '9', 'effective_date' => '2026-01-01', 'announced_date' => '']),
    ]));

    expect($rows)->toHaveCount(2);
});

it('rejects a wrong header, ragged rows, an empty file and a missing file', function () {
    $header = fn () => (new LedgerReader)->read(vatLedgerFile([], 'country,rate'));
    $ragged = fn () => (new LedgerReader)->read(vatLedgerFile([array_slice(vatLedgerRow(), 0, 5)]));
    $empty = fn () => (new LedgerReader)->read(tempnam(sys_get_temp_dir(), 'vat-ledger'));
    $missing = fn () => (new LedgerReader)->read('/nonexistent/ledger.csv');

    expect($header)->toThrow(InvalidLedgerException::class, 'Header must be exactly')
        ->and($ragged)->toThrow(InvalidLedgerException::class, 'Line 2: expected 12 columns, found 5')
        ->and($empty)->toThrow(InvalidLedgerException::class, 'empty')
        ->and($missing)->toThrow(InvalidLedgerException::class, 'not found');
});

it('keeps the committed ledger valid, sourced from official publishers and tied to known countries', function () {
    $this->seed(CountriesTableSeeder::class);

    $rows = (new LedgerReader)->read(config('vat-changes.ledger'));
    $members = Country::query()->where('is_eu_member', true)->pluck('iso_code')->all();
    $hosts = config('vat-changes.official_hosts');

    expect($rows)->not->toBeEmpty();

    foreach ($rows as $row) {
        $host = strtolower(parse_url($row->sourceUrl, PHP_URL_HOST));

        expect($members)->toContain($row->country)
            ->and(collect($hosts)->contains(fn (string $suffix) => $host === $suffix || str_ends_with($host, '.'.$suffix)))
            ->toBeTrue("Line {$row->line}: {$host} is not an official publisher in config/vat-changes.php.");
    }
});
