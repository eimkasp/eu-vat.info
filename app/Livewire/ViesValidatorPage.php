<?php

namespace App\Livewire;

use App\Models\Country;
use App\Models\VatValidationCache;
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

    public $validationCount = 0;

    public $recentValidations = [];

    public function mount(?string $slug = null)
    {
        $this->countries = Country::orderBy('name')->get();

        if ($slug) {
            $country = Country::where('slug', $slug)->first();
            if ($country) {
                $this->country_code = $country->iso_code;
            }
        }

        $this->loadRecentValidations();

        // Auto-validate if both params provided via URL
        if ($this->country_code && $this->vat_number) {
            $this->validateVat();
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

            $this->loadRecentValidations();

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

    private function loadRecentValidations()
    {
        $this->recentValidations = VatValidationCache::orderByDesc('last_checked_at')
            ->limit(10)
            ->get()
            ->map(fn ($v) => [
                'country_code' => $v->country_code,
                'vat_number' => $v->vat_number,
                'name' => $v->name,
                'is_valid' => $v->is_valid,
                'last_checked_at' => $v->last_checked_at?->diffForHumans(),
            ])
            ->toArray();
    }

    public function render()
    {
        return view('livewire.vies-validator-page');
    }
}
