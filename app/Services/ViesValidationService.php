<?php

namespace App\Services;

use App\Models\VatValidationCache;
use App\Models\VatValidationLog;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ViesValidationService
{
    private const VIES_API_URL = 'https://ec.europa.eu/taxation_customs/vies/rest-api/check-vat-number';

    private const CACHE_TTL = 86400; // 24 hours

    /**
     * Validate a VAT number against VIES using a Redis/array cache, then the database, then the live API.
     * Caller-specific name/address matching is computed per request and never cached.
     */
    public function validate(string $countryCode, string $vatNumber, ?string $companyName = null, ?string $address = null): array
    {
        $countryCode = $this->viesCountryCode($countryCode);
        $vatNumber = $this->cleanVatNumber($vatNumber, $countryCode);
        $cacheKey = "vat_validation_{$countryCode}_{$vatNumber}";

        if ($cached = Cache::get($cacheKey)) {
            return $this->withMatching(array_merge($cached, ['source' => 'cache']), $companyName, $address);
        }

        $dbResult = $this->getFromDatabase($countryCode, $vatNumber);

        if ($dbResult && $this->isRecentValidation($dbResult)) {
            Cache::put($cacheKey, $dbResult, self::CACHE_TTL);

            return $this->withMatching(array_merge($dbResult, ['source' => 'database']), $companyName, $address);
        }

        try {
            $response = Http::timeout(10)->acceptJson()->post(self::VIES_API_URL, [
                'countryCode' => $countryCode,
                'vatNumber' => $vatNumber,
            ]);

            $data = (array) $response->json();

            if ($response->successful() && ($data['actionSucceed'] ?? true) !== false && array_key_exists('valid', $data)) {
                $result = [
                    'valid' => (bool) $data['valid'],
                    'country_code' => $countryCode,
                    'vat_number' => $vatNumber,
                    'name' => $this->presentOrNull($data['name'] ?? null),
                    'address' => $this->presentOrNull($data['address'] ?? null),
                    'request_date' => $data['requestDate'] ?? now()->format('Y-m-d'),
                    'request_identifier' => $this->presentOrNull($data['requestIdentifier'] ?? null),
                ];

                $this->saveToDatabase($result);
                Cache::put($cacheKey, $result, self::CACHE_TTL);

                return $this->withMatching(array_merge($result, ['source' => 'vies_api']), $companyName, $address);
            }

            return $this->failure((string) (data_get($data, 'errorWrappers.0.error') ?? 'HTTP_'.$response->status()), $dbResult, $companyName, $address);
        } catch (\Throwable $exception) {
            report($exception);

            return $this->failure('SERVICE_UNAVAILABLE', $dbResult, $companyName, $address);
        }
    }

    /**
     * VIES answers most errors with HTTP 200 and "actionSucceed": false, so failures are never cached as an invalid number.
     * A stored result is only reused when the failure is on the VIES side rather than in the submitted number.
     */
    private function failure(string $code, ?array $dbResult, ?string $companyName, ?string $address): array
    {
        $invalidInput = $code === 'INVALID_INPUT' || str_starts_with($code, 'VOW-ERR');

        if ($dbResult && ! $invalidInput) {
            return $this->withMatching(array_merge($dbResult, ['source' => 'database_fallback', 'warning' => 'VIES API unavailable']), $companyName, $address);
        }

        return [
            'valid' => false,
            'error' => $invalidInput
                ? 'The VAT number format is not valid for this member state.'
                : 'The VIES service is temporarily unavailable. Please try again shortly.',
            'error_code' => $code,
            'source' => 'error',
        ];
    }

    private function presentOrNull(mixed $value): ?string
    {
        $value = is_string($value) ? trim($value) : null;

        return in_array($value, [null, '', '---', 'N/A'], true) ? null : $value;
    }

    /**
     * VIES identifies Greece as EL even though its ISO 3166 code is GR.
     */
    public function viesCountryCode(string $countryCode): string
    {
        $countryCode = strtoupper(trim($countryCode));

        return $countryCode === 'GR' ? 'EL' : $countryCode;
    }

    private function withMatching(array $result, ?string $companyName, ?string $address): array
    {
        if (! ($result['valid'] ?? false) || (! $companyName && ! $address)) {
            return $result;
        }

        $result['name_match'] = $this->fuzzyMatch($companyName, $result['name'] ?? null);
        $result['address_match'] = $this->fuzzyMatch($address, $result['address'] ?? null);
        $result['confidence'] = $this->calculateConfidence($result);

        return $result;
    }

    /**
     * Normalise a VAT number and drop the member-state prefix only when it matches the country.
     */
    private function cleanVatNumber(string $vatNumber, string $countryCode): string
    {
        $cleaned = strtoupper((string) preg_replace('/[\s\-.]/', '', $vatNumber));
        $prefixes = $countryCode === 'EL' ? ['EL', 'GR'] : [$countryCode];

        foreach ($prefixes as $prefix) {
            if (str_starts_with($cleaned, $prefix) && strlen($cleaned) > strlen($prefix) + 1) {
                return substr($cleaned, strlen($prefix));
            }
        }

        return $cleaned;
    }

    /**
     * Fuzzy string matching with flexibility for Latin characters and case
     */
    private function fuzzyMatch(?string $input, ?string $reference): ?array
    {
        if (! $input || ! $reference) {
            return null;
        }

        // Normalize strings
        $normalizedInput = $this->normalizeString($input);
        $normalizedReference = $this->normalizeString($reference);

        // Calculate similarity
        similar_text($normalizedInput, $normalizedReference, $percent);

        // Calculate Levenshtein distance for additional accuracy
        $distance = levenshtein(
            substr($normalizedInput, 0, 255),
            substr($normalizedReference, 0, 255)
        );

        return [
            'input' => $input,
            'reference' => $reference,
            'similarity_percent' => round($percent, 2),
            'levenshtein_distance' => $distance,
            'is_match' => $percent >= 80, // 80% similarity threshold
            'is_close_match' => $percent >= 60 && $percent < 80,
        ];
    }

    /**
     * Normalize string for comparison - handle Latin chars, case, punctuation
     */
    private function normalizeString(string $str): string
    {
        // Convert to lowercase
        $str = mb_strtolower($str);

        // Replace Latin characters with ASCII equivalents
        $str = $this->removeDiacritics($str);

        // Remove punctuation except spaces
        $str = preg_replace('/[^\w\s]/', '', $str);

        // Normalize whitespace
        $str = preg_replace('/\s+/', ' ', $str);

        return trim($str);
    }

    /**
     * Remove diacritics from Latin characters
     */
    private function removeDiacritics(string $str): string
    {
        $replacements = [
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e',
            'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
            'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o',
            'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u',
            'ý' => 'y', 'ÿ' => 'y',
            'ñ' => 'n', 'ç' => 'c', 'š' => 's', 'ž' => 'z',
            'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ś' => 's', 'ź' => 'z', 'ż' => 'z',
            'ė' => 'e', 'į' => 'i', 'ų' => 'u', 'ū' => 'u', 'č' => 'c',
        ];

        return strtr($str, $replacements);
    }

    /**
     * Calculate overall confidence score
     */
    private function calculateConfidence(array $result): int
    {
        $score = 0;

        if ($result['valid']) {
            $score += 40; // Base score for valid VAT
        }

        if (isset($result['name_match']['is_match']) && $result['name_match']['is_match']) {
            $score += 30;
        } elseif (isset($result['name_match']['is_close_match']) && $result['name_match']['is_close_match']) {
            $score += 15;
        }

        if (isset($result['address_match']['is_match']) && $result['address_match']['is_match']) {
            $score += 30;
        } elseif (isset($result['address_match']['is_close_match']) && $result['address_match']['is_close_match']) {
            $score += 15;
        }

        return min(100, $score);
    }

    /**
     * Save validation result to database
     */
    private function saveToDatabase(array $result): void
    {
        VatValidationLog::create([
            'country_code' => $result['country_code'],
            'vat_number' => $result['vat_number'],
            'is_valid' => $result['valid'],
            'name' => $result['name'],
            'address' => $result['address'],
            'request_identifier' => $result['request_identifier'] ?? null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        // Also save to cache table for faster lookups
        VatValidationCache::updateOrCreate(
            [
                'country_code' => $result['country_code'],
                'vat_number' => $result['vat_number'],
            ],
            [
                'is_valid' => $result['valid'],
                'name' => $result['name'],
                'address' => $result['address'],
                'last_checked_at' => now(),
            ]
        );
    }

    /**
     * Get validation from database
     */
    private function getFromDatabase(string $countryCode, string $vatNumber): ?array
    {
        $cached = VatValidationCache::where('country_code', $countryCode)
            ->where('vat_number', $vatNumber)
            ->first();

        if ($cached) {
            return [
                'valid' => $cached->is_valid,
                'country_code' => $cached->country_code,
                'vat_number' => $cached->vat_number,
                'name' => $cached->name,
                'address' => $cached->address,
                'last_checked_at' => $cached->last_checked_at,
            ];
        }

        return null;
    }

    /**
     * Check if validation is recent (within 7 days)
     */
    private function isRecentValidation(?array $result): bool
    {
        if (! $result || ! isset($result['last_checked_at'])) {
            return false;
        }

        return Carbon::parse($result['last_checked_at'])->greaterThan(now()->subDays(7));
    }
}
