<?php

namespace App\Livewire;

use App\Models\Country;
use App\Support\Vat\VatCalculation;
use App\Support\Vat\VatMode;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;

class SharedCalculation extends Component
{
    public const AMOUNTS = [100, 200, 500, 1000, 2500, 5000, 10000];

    #[Locked]
    public string $country = '';

    #[Locked]
    public float $amount = 0;

    #[Locked]
    public float $rate = 0;

    #[Locked]
    public string $mode = 'exclude';

    public function mount(string $country, string $amount, string $rate, string $mode = 'exclude'): void
    {
        abort_unless(is_numeric($amount) && (float) $amount <= VatCalculation::MAX_AMOUNT, 404);
        abort_unless(is_numeric($rate) && (float) $rate <= 100, 404);

        $this->country = $country;
        $this->amount = round((float) $amount, 2);
        $this->rate = round((float) $rate, 2);
        $this->mode = VatMode::fromInput($mode)->value;

        abort_unless($this->countryModel, 404);
    }

    public static function calculationUrl(string $country, float|int|string $amount, float|int|string $rate, string $mode): string
    {
        return locale_path('/vat-calculation/'.$country.'/'.self::segment($amount).'/'.self::segment($rate).'/'.VatMode::fromInput($mode)->value);
    }

    public static function segment(float|int|string $value): string
    {
        return rtrim(rtrim(number_format((float) $value, 2, '.', ''), '0'), '.');
    }

    #[Computed]
    public function countryModel(): ?Country
    {
        return Country::query()->where('slug', $this->country)->first();
    }

    #[Computed]
    public function calculation(): VatCalculation
    {
        return VatCalculation::make($this->amount, $this->rate, $this->mode);
    }

    /**
     * @return list<array{type: string, rate: float, label: string}>
     */
    #[Computed]
    public function rateOptions(): array
    {
        return array_map(fn (array $option) => $option + ['label' => __('ui.rate_type.'.$option['type'])], $this->countryModel->rateOptions());
    }

    /**
     * @return array{type: string, label: string}
     */
    #[Computed]
    public function rateType(): array
    {
        $match = collect($this->rateOptions)->first(fn (array $option) => abs($option['rate'] - $this->rate) < 0.001);

        return $match
            ? ['type' => $match['type'], 'label' => $match['label']]
            : ['type' => 'custom', 'label' => __('ui.rate_type.custom')];
    }

    /**
     * EU countries whose standard rate is closest to the shared rate.
     *
     * @return Collection<int, Country>
     */
    #[Computed]
    public function nearbyCountries(): Collection
    {
        return Country::calculatorAvailable()
            ->where('is_eu_member', true)
            ->where('slug', '!=', $this->country)
            ->get(['name', 'slug', 'iso_code', 'standard_rate', 'currency_code'])
            ->sortBy([fn (Country $a, Country $b) => abs((float) $a->standard_rate - $this->rate) <=> abs((float) $b->standard_rate - $this->rate), ['name', 'asc']])
            ->take(8)
            ->values();
    }

    public function render()
    {
        return view('livewire.shared-calculation', [
            'countryModel' => $this->countryModel,
            'calculation' => $this->calculation,
        ]);
    }
}
