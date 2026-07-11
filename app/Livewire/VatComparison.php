<?php

namespace App\Livewire;

use App\Models\Country;
use App\Services\Seo\InternalLinkService;
use Livewire\Component;

class VatComparison extends Component
{
    public Country $leftCountry;

    public Country $rightCountry;

    public function mount(string $pair, InternalLinkService $links)
    {
        if (! preg_match('/^(.+)-vs-(.+)$/', $pair, $matches)) {
            abort(404);
        }

        $requested = [$matches[1], $matches[2]];
        $canonical = $links->canonicalPair(...$requested);
        abort_unless($canonical, 404);

        if ($requested !== $canonical) {
            return redirect()->to(locale_path('/compare/'.implode('-vs-', $canonical).'-vat'), 301);
        }

        $countries = Country::query()
            ->where('is_eu_member', true)
            ->whereIn('slug', $canonical)
            ->get()
            ->sortBy(fn (Country $country) => array_search($country->slug, $canonical, true))
            ->values();

        abort_unless($countries->count() === 2, 404);

        [$left, $right] = $countries->all();

        $this->leftCountry = $left;
        $this->rightCountry = $right;
    }

    public function render()
    {
        return view('livewire.vat-comparison', [
            'leftChanges' => $this->leftCountry->vatRateChanges()->count(),
            'rightChanges' => $this->rightCountry->vatRateChanges()->count(),
        ]);
    }
}
