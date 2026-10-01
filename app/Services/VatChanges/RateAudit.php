<?php

namespace App\Services\VatChanges;

use App\Models\Country;
use Carbon\CarbonInterface;

/**
 * Compares the rates stored for each EU member state with what the member state reports to the European Commission.
 * The result is a list of leads for the weekly review; it never changes data.
 */
class RateAudit
{
    private const TYPES = ['standard', 'reduced', 'super_reduced', 'parking'];

    public function __construct(private readonly TedbClient $client) {}

    /**
     * @return list<array{country: string, type: string, official: list<float>, stored: list<float>, add: list<float>, remove: list<float>, note: ?string}>
     */
    public function findings(?CarbonInterface $on = null): array
    {
        $countries = Country::query()->where('is_eu_member', true)->orderBy('name')->get();
        $official = $this->officialRates($countries->pluck('iso_code')->map(fn ($iso) => strtoupper((string) $iso))->all(), $on ?? today());
        $findings = [];

        foreach ($countries as $country) {
            $iso = strtoupper((string) $country->iso_code);

            if (! isset($official[$iso])) {
                $findings[] = ['country' => $iso, 'type' => 'all', 'official' => [], 'stored' => [], 'add' => [], 'remove' => [], 'note' => 'The Commission returned no rates for this country.'];

                continue;
            }

            foreach (self::TYPES as $type) {
                $ignored = array_map(fn ($rate) => $this->key($rate), config("vat-changes.audit.ignore.{$iso}.{$type}", []));
                $expected = $this->without($official[$iso][$type] ?? [], $ignored);
                $stored = $this->without($this->storedRates($country, $type), $ignored);
                $add = array_values(array_diff($expected, $stored));
                $remove = array_values(array_diff($stored, $expected));

                if ($add !== [] || $remove !== []) {
                    $findings[] = ['country' => $iso, 'type' => $type, 'official' => $expected, 'stored' => $stored, 'add' => $add, 'remove' => $remove, 'note' => null];
                }
            }
        }

        return $findings;
    }

    /**
     * @param  list<string>  $isoCodes
     * @return array<string, array<string, list<float>>>
     */
    private function officialRates(array $isoCodes, CarbonInterface $on): array
    {
        $official = [];

        foreach ($this->client->rates($isoCodes, $on) as $rate) {
            if ($rate['regional'] || $rate['rate'] <= 0) {
                continue;
            }

            $official[$rate['country']][$rate['type']][] = $this->key($rate['rate']);
        }

        return array_map(fn (array $types) => array_map(fn (array $rates) => $this->sorted($rates), $types), $official);
    }

    /**
     * @return list<float>
     */
    private function storedRates(Country $country, string $type): array
    {
        $rates = match ($type) {
            'standard' => [$country->standard_rate],
            'reduced' => Country::parseRateList($country->reduced_rate),
            'super_reduced' => [$country->super_reduced_rate],
            'parking' => [$country->parking_rate],
        };

        return $this->sorted(array_map(fn ($rate) => $this->key($rate), array_filter($rates, fn ($rate) => is_numeric($rate) && (float) $rate > 0)));
    }

    /**
     * @param  list<float>  $rates
     * @param  list<float>  $ignored
     * @return list<float>
     */
    private function without(array $rates, array $ignored): array
    {
        return array_values(array_diff($rates, $ignored));
    }

    /**
     * @param  array<int, float>  $rates
     * @return list<float>
     */
    private function sorted(array $rates): array
    {
        $rates = array_values(array_unique($rates));
        sort($rates);

        return $rates;
    }

    private function key(float|int|string $rate): float
    {
        return round((float) $rate, 2);
    }
}
