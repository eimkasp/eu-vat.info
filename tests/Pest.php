<?php

use App\Services\VatChanges\LedgerReader;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

uses(
    TestCase::class,
    RefreshDatabase::class,
)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function something()
{
    // ..
}

/**
 * @param  array<string, string>  $overrides
 * @return array<string, string>
 */
function vatLedgerRow(array $overrides = []): array
{
    return array_merge([
        'country' => 'EE',
        'rate_type' => 'standard',
        'old_rate' => '22',
        'new_rate' => '24',
        'effective_date' => '2025-07-01',
        'announced_date' => '2025-03-01',
        'status' => 'enacted',
        'reason' => 'Budget consolidation',
        'description' => 'The standard rate rose from 22% to 24%.',
        'source' => 'Riigi Teataja',
        'source_url' => 'https://www.riigiteataja.ee/akt/example',
        'official_document' => 'Value Added Tax Act amendment, RT I, 2025',
    ], $overrides);
}

/**
 * @param  list<array<string, string>>  $rows
 */
function vatLedgerFile(array $rows, ?string $header = null): string
{
    $path = tempnam(sys_get_temp_dir(), 'vat-ledger');
    $handle = fopen($path, 'w');
    fwrite($handle, ($header ?? implode(',', LedgerReader::COLUMNS))."\n");

    foreach ($rows as $row) {
        fputcsv($handle, array_values($row), ',', '"', '');
    }

    fclose($handle);

    return $path;
}
