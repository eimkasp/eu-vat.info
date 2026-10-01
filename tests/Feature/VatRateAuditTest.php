<?php

use App\Models\Country;
use App\Services\VatChanges\RateAudit;
use App\Services\VatChanges\TedbClient;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Http;

/**
 * @param  list<array{0: string, 1: string, 2: float, 3?: ?string}>  $rates  member state, TEDB rate type, value, category
 */
function vatAuditTedbXml(array $rates): string
{
    $results = '';

    foreach ($rates as [$member, $type, $value, $category]) {
        $category ??= null;
        $results .= '<vatRateResults><memberState>'.$member.'</memberState><type>'.($type === 'DEFAULT' ? 'STANDARD' : 'REDUCED').'</type>'
            .'<rate><type>'.$type.'</type><value>'.number_format($value, 1, '.', '').'</value></rate>'
            .'<situationOn>2026-07-01+02:00</situationOn>'
            .($category ? '<category><identifier>'.$category.'</identifier></category>' : '')
            .'<comment>Ignored</comment></vatRateResults>';
    }

    return '<env:Envelope xmlns:env="http://schemas.xmlsoap.org/soap/envelope/"><env:Header/><env:Body>'
        .'<ns2:retrieveVatRatesRespMsg xmlns="urn:ec.europa.eu:taxud:tedb:services:v1:IVatRetrievalService:types" xmlns:ns2="urn:ec.europa.eu:taxud:tedb:services:v1:IVatRetrievalService">'
        .$results.'</ns2:retrieveVatRatesRespMsg></env:Body></env:Envelope>';
}

function vatAuditCountry(string $name, string $iso, array $rates): Country
{
    return Country::factory()->country($name, $iso)->create(array_merge([
        'standard_rate' => null,
        'reduced_rate' => null,
        'super_reduced_rate' => null,
        'parking_rate' => null,
        'is_eu_member' => true,
    ], $rates));
}

it('reads rates from the Commission, maps Greece and flags regional rates', function () {
    Http::fake(['*' => Http::response(vatAuditTedbXml([
        ['EL', 'DEFAULT', 24.0, null],
        ['EL', 'REDUCED_RATE', 13.0, 'FOODSTUFFS'],
        ['EL', 'REDUCED_RATE', 17.0, 'REGION'],
        ['EL', 'SUPER_REDUCED_RATE', 4.0, 'NON_OWNED_RESIDENCY_RENOVATION'],
        ['EL', 'PARKING_RATE', 13.0, 'AGRICULTURAL_EQUIPMENT'],
        ['EL', 'SOMETHING_ELSE', 1.0, null],
    ]), 200, ['Content-Type' => 'text/xml'])]);

    $rates = (new TedbClient)->rates(['GR'], CarbonImmutable::parse('2026-10-01'));

    expect($rates)->toHaveCount(5)
        ->and($rates[0])->toBe(['country' => 'GR', 'type' => 'standard', 'rate' => 24.0, 'regional' => false])
        ->and($rates[2]['regional'])->toBeTrue()
        ->and(collect($rates)->pluck('type')->all())->toBe(['standard', 'reduced', 'reduced', 'super_reduced', 'parking']);

    Http::assertSent(fn ($request) => $request->url() === config('vat-changes.tedb.endpoint')
        && $request->hasHeader('SOAPAction', '"urn:ec.europa.eu:taxud:tedb:services:v1:VatRetrievalService/RetrieveVatRates"')
        && str_contains($request->body(), '<typ:isoCode>EL</typ:isoCode>')
        && str_contains($request->body(), '<typ:situationOn>2026-10-01</typ:situationOn>'));
});

it('fails clearly when the Commission service answers with a fault or nonsense', function () {
    Http::fakeSequence()
        ->push('<env:Envelope xmlns:env="http://schemas.xmlsoap.org/soap/envelope/"><env:Body><env:Fault><faultcode>env:Client</faultcode><faultstring>TEDB-ERR-2 - Request is not valid</faultstring></env:Fault></env:Body></env:Envelope>', 500)
        ->push('<html>Bad gateway', 502)
        ->push('', 200);

    expect(fn () => (new TedbClient)->rates(['DE'], today()))->toThrow(RuntimeException::class, 'TEDB-ERR-2')
        ->and(fn () => (new TedbClient)->rates(['DE'], today()))->toThrow(RuntimeException::class, 'HTTP 502')
        ->and(fn () => (new TedbClient)->rates(['DE'], today()))->toThrow(RuntimeException::class, 'HTTP 200');
});

it('lists only genuine differences between stored and official rates', function () {
    vatAuditCountry('Estonia', 'EE', ['standard_rate' => 24, 'reduced_rate' => '9']);
    vatAuditCountry('Greece', 'GR', ['standard_rate' => 24, 'reduced_rate' => '6 / 13']);
    vatAuditCountry('Austria', 'AT', ['standard_rate' => 20, 'reduced_rate' => '10 / 13', 'parking_rate' => 13]);
    Country::factory()->country('Norway', 'NO')->create(['is_eu_member' => false]);

    Http::fake(['*' => Http::response(vatAuditTedbXml([
        ['EE', 'DEFAULT', 24.0, null],
        ['EE', 'REDUCED_RATE', 9.0, 'FOODSTUFFS'],
        ['EE', 'REDUCED_RATE', 13.0, 'ACCOMMODATION'],
        ['EE', 'REDUCED_RATE', 0.0, 'PHARMACEUTICAL_PRODUCTS'],
        ['EL', 'DEFAULT', 24.0, null],
        ['EL', 'REDUCED_RATE', 6.0, 'BOOKS'],
        ['EL', 'REDUCED_RATE', 13.0, 'FOODSTUFFS'],
        ['EL', 'REDUCED_RATE', 17.0, 'REGION'],
        ['EL', 'SUPER_REDUCED_RATE', 4.0, 'NON_OWNED_RESIDENCY_RENOVATION'],
        ['EL', 'PARKING_RATE', 13.0, 'AGRICULTURAL_EQUIPMENT'],
        ['AT', 'DEFAULT', 20.0, null],
        ['AT', 'REDUCED_RATE', 10.0, 'FOODSTUFFS'],
        ['AT', 'REDUCED_RATE', 13.0, 'CULTURE'],
        ['AT', 'REDUCED_RATE', 19.0, 'REGION'],
        ['AT', 'SUPER_REDUCED_RATE', 4.9, 'FOODSTUFFS'],
    ]), 200)]);

    expect((new RateAudit(new TedbClient))->findings(CarbonImmutable::parse('2026-10-01')))->toBe([
        ['country' => 'AT', 'type' => 'super_reduced', 'official' => [4.9], 'stored' => [], 'add' => [4.9], 'remove' => [], 'note' => null],
        ['country' => 'EE', 'type' => 'reduced', 'official' => [9.0, 13.0], 'stored' => [9.0], 'add' => [13.0], 'remove' => [], 'note' => null],
    ]);
});

it('reports a country the Commission returned nothing for', function () {
    vatAuditCountry('Estonia', 'EE', ['standard_rate' => 24]);

    Http::fake(['*' => Http::response(vatAuditTedbXml([]), 200)]);

    $findings = (new RateAudit(new TedbClient))->findings();

    expect($findings)->toHaveCount(1)
        ->and($findings[0]['country'])->toBe('EE')
        ->and($findings[0]['note'])->toContain('no rates');
});

it('exits cleanly when the stored rates match and fails with a table when they do not', function () {
    vatAuditCountry('Estonia', 'EE', ['standard_rate' => 24, 'reduced_rate' => '9 / 13']);

    Http::fake(['*' => Http::response(vatAuditTedbXml([
        ['EE', 'DEFAULT', 24.0, null],
        ['EE', 'REDUCED_RATE', 9.0, 'FOODSTUFFS'],
        ['EE', 'REDUCED_RATE', 13.0, 'ACCOMMODATION'],
    ]), 200)]);

    $this->artisan('vat-changes:audit')->expectsOutputToContain('match')->assertExitCode(0);

    Country::where('iso_code', 'EE')->update(['reduced_rate' => '9', 'standard_rate' => 22]);

    $this->artisan('vat-changes:audit')
        ->expectsOutputToContain('2 difference(s)')
        ->assertExitCode(1);
});

it('prints findings as JSON and fails when the service is unreachable', function () {
    vatAuditCountry('Estonia', 'EE', ['standard_rate' => 22]);

    Http::fakeSequence()
        ->push(vatAuditTedbXml([['EE', 'DEFAULT', 24.0, null]]), 200)
        ->push('Service unavailable', 503);

    $this->artisan('vat-changes:audit', ['--json' => true])->expectsOutputToContain('"add": [')->assertExitCode(1);
    $this->artisan('vat-changes:audit')->expectsOutputToContain('The audit could not run')->assertExitCode(1);
});
