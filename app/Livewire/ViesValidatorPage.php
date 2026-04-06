<?php

namespace App\Livewire;

use App\Models\Country;
use App\Models\VatValidationLog;
use App\Services\ViesValidationService;
use Livewire\Attributes\Url;
use Livewire\Component;

class ViesValidatorPage extends Component
{
    #[Url]
    public $country_code = '';

    #[Url]
    public $vat_number = '';

    public $result = null;

    public $error = null;

    public $countries;

    public $countryObject = null;

    public $validationCount = 0;

    /**
     * EU country ISO code prefixes used in VAT numbers.
     * Greece uses 'EL' in VAT numbers instead of 'GR'.
     */
    private const VAT_PREFIXES = [
        'AT', 'BE', 'BG', 'HR', 'CY', 'CZ', 'DK', 'EE', 'FI', 'FR',
        'DE', 'EL', 'HU', 'IE', 'IT', 'LV', 'LT', 'LU', 'MT', 'NL',
        'PL', 'PT', 'RO', 'SK', 'SI', 'ES', 'SE',
    ];

    public function mount(?string $slug = null)
    {
        $this->countries = Country::orderBy('name')->get();

        if ($slug) {
            $this->countryObject = Country::where('slug', $slug)->first();
            if ($this->countryObject) {
                $this->country_code = $this->countryObject->iso_code;
            }
        }

        // Auto-detect country from vat_number prefix
        if (!$this->country_code && $this->vat_number) {
            $this->detectCountryFromVatNumber();
        }

        // Strip country prefix from vat_number if present
        $this->stripCountryPrefix();

        // Auto-validate if both params provided via URL
        if ($this->country_code && $this->vat_number) {
            $this->validateVat();
        }
    }

    public function updatedVatNumber()
    {
        $this->detectCountryFromVatNumber();
        $this->stripCountryPrefix();
    }

    private function detectCountryFromVatNumber(): void
    {
        $cleaned = strtoupper(preg_replace('/[\s\-.]/', '', $this->vat_number));

        if (strlen($cleaned) < 3) {
            return;
        }

        $prefix = substr($cleaned, 0, 2);

        if (in_array($prefix, self::VAT_PREFIXES)) {
            // Greece uses EL in VAT but GR as ISO code
            $isoCode = $prefix === 'EL' ? 'GR' : $prefix;
            $this->country_code = $isoCode;
        }
    }

    private function stripCountryPrefix(): void
    {
        $cleaned = strtoupper(preg_replace('/[\s\-.]/', '', $this->vat_number));

        if (strlen($cleaned) >= 3) {
            $prefix = substr($cleaned, 0, 2);
            if (in_array($prefix, self::VAT_PREFIXES)) {
                $this->vat_number = substr($cleaned, 2);
            }
        }
    }

    public function validateVat()
    {
        $this->validate([
            'country_code' => 'required|string|size:2',
            'vat_number' => 'required|string|min:5|max:20',
        ]);

        $this->result = null;
        $this->error = null;

        try {
            $service = app(ViesValidationService::class);
            $data = $service->validate($this->country_code, $this->vat_number);

            if (isset($data['error'])) {
                $this->error = $data['error'];
                return;
            }

            $this->result = [
                'valid' => $data['valid'] ?? false,
                'name' => $data['name'] ?? 'N/A',
                'address' => $data['address'] ?? 'N/A',
                'request_identifier' => $data['request_identifier'] ?? null,
                'source' => $data['source'] ?? 'unknown',
                'country_code' => $this->country_code,
                'vat_number' => $this->vat_number,
            ];

            // Log the validation
            VatValidationLog::create([
                'country_code' => $this->country_code,
                'vat_number' => $this->vat_number,
                'is_valid' => $this->result['valid'],
                'name' => $this->result['name'],
                'address' => $this->result['address'],
                'request_identifier' => $this->result['request_identifier'],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            $this->validationCount = VatValidationLog::where('vat_number', $this->vat_number)
                ->where('country_code', $this->country_code)
                ->count();

        } catch (\Exception $e) {
            $this->error = 'Error connecting to VIES service: ' . $e->getMessage();
        }
    }

    public function prefillExample()
    {
        $this->country_code = 'LT';
        $this->vat_number = '100019070512';
        $this->validateVat();
    }

    public function render()
    {
        return view('livewire.vies-validator-page');
    }
}
