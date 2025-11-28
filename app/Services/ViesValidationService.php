<?php

namespace App\Services;

use App\Models\VatValidationLog;
use App\Models\VatValidationCache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ViesValidationService
{
    private const VIES_API_URL = 'https://ec.europa.eu/taxation_customs/vies/rest-api/check-vat-number';
    private const CACHE_TTL = 86400; // 24 hours

    /**
     * Validate VAT number with VIES API and cache results
     */
    public function validate(string $countryCode, string $vatNumber, ?string $companyName = null, ?string $address = null): array
    {
        $countryCode = strtoupper($countryCode);
        $vatNumber = $this->cleanVatNumber($vatNumber);
        $cacheKey = "vat_validation_{$countryCode}_{$vatNumber}";

        // Check cache first
        if ($cached = Cache::get($cacheKey)) {
            return array_merge($cached, ['source' => 'cache']);
        }

        // Check database backup
        if ($dbResult = $this->getFromDatabase($countryCode, $vatNumber)) {
            if ($this->isRecentValidation($dbResult)) {
                Cache::put($cacheKey, $dbResult, self::CACHE_TTL);
                return array_merge($dbResult, ['source' => 'database']);
            }
        }

        // Call VIES API
        try {
            $response = Http::timeout(10)->post(self::VIES_API_URL, [
                'countryCode' => $countryCode,
                'vatNumber' => $vatNumber,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                $result = [
                    'valid' => $data['valid'] ?? false,
                    'country_code' => $countryCode,
                    'vat_number' => $vatNumber,
                    'name' => $data['name'] ?? null,
                    'address' => $data['address'] ?? null,
                    'request_date' => $data['requestDate'] ?? now()->format('Y-m-d'),
                    'request_identifier' => $data['requestIdentifier'] ?? null,
                ];

                // Perform fuzzy matching if user provided data
                if ($result['valid']) {
                    $result['name_match'] = $this->fuzzyMatch($companyName, $result['name']);
                    $result['address_match'] = $this->fuzzyMatch($address, $result['address']);
                    $result['confidence'] = $this->calculateConfidence($result);
                }

                // Save to database and cache
                $this->saveToDatabase($result);
                Cache::put($cacheKey, $result, self::CACHE_TTL);

                return array_merge($result, ['source' => 'vies_api']);
            }

            // If VIES fails, try to get from database as fallback
            if ($dbResult) {
                return array_merge($dbResult, ['source' => 'database_fallback', 'warning' => 'VIES API unavailable']);
            }

            return [
                'valid' => false,
                'error' => $response->json()['errorWrapperError'] ?? 'Validation failed',
                'source' => 'error'
            ];

        } catch (\Exception $e) {
            // Exception fallback to database
            if ($dbResult) {
                return array_merge($dbResult, ['source' => 'database_fallback', 'warning' => $e->getMessage()]);
            }

            return [
                'valid' => false,
                'error' => 'Service unavailable: ' . $e->getMessage(),
                'source' => 'error'
            ];
        }
    }

    /**
     * Clean VAT number - remove spaces, dashes, country prefix
     */
    private function cleanVatNumber(string $vatNumber): string
    {
        // Remove spaces, dashes, dots
        $cleaned = str_replace([' ', '-', '.'], '', $vatNumber);
        
        // Remove country code prefix if present (e.g., LT123456789 -> 123456789)
        $cleaned = preg_replace('/^[A-Z]{2}/', '', $cleaned);
        
        return strtoupper(trim($cleaned));
    }

    /**
     * Fuzzy string matching with flexibility for Latin characters and case
     */
    private function fuzzyMatch(?string $input, ?string $reference): ?array
    {
        if (!$input || !$reference) {
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
        if (!$result || !isset($result['last_checked_at'])) {
            return false;
        }

        return now()->diffInDays($result['last_checked_at']) < 7;
    }
}
