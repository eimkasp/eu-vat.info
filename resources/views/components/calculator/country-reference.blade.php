@props(['country'])

@use('App\Models\Country')
@use('App\Support\Vat\Money')
@use('App\Support\Vat\VatCalculation')

@php
    $rates = collect($country->rateOptions());
    $standard = (float) $country->standard_rate;
    $multiplier = Country::formatRate(1 + $standard / 100);
    $currency = $country->currencyCode();
    $add = VatCalculation::addVat(100, $standard);
    $remove = VatCalculation::removeVat(100, $standard);
@endphp

<section data-country-reference aria-labelledby="country-reference-title" class="app-surface overflow-hidden">
    <div class="border-b border-line px-5 py-4 sm:px-6">
        <p class="app-eyebrow">{{ __('ui.country_page.key_information') }}</p>
        <h2 id="country-reference-title" class="mt-1 text-xl font-bold text-ink">{{ __('ui.calculator.rates_and_formulas', ['country' => $country->name]) }}</h2>
    </div>

    <div class="grid md:grid-cols-2">
        <div class="border-b border-line p-5 sm:p-6 md:border-b-0 md:border-r">
            <h3 class="text-sm font-semibold text-ink">{{ __('ui.calculator.rate_reference') }}</h3>
            <dl class="mt-3 divide-y divide-line">
                @foreach($rates as $rate)
                    <div class="flex min-h-12 items-center justify-between gap-4 py-2.5">
                        <dt class="text-sm text-ink-muted">{{ __('ui.rate_type.'.$rate['type']) }}</dt>
                        <dd class="tabular font-bold text-ink">{{ Country::formatRate($rate['rate']) }}%</dd>
                    </div>
                @endforeach
            </dl>

            <dl class="mt-5 grid grid-cols-2 gap-x-5 gap-y-4 rounded-xl bg-surface-subtle p-4 text-sm">
                <div>
                    <dt class="text-xs font-medium text-ink-muted">{{ __('ui.country_page.currency') }}</dt>
                    <dd class="mt-1 font-semibold text-ink">{{ $currency }} · {{ $country->currency_display }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-ink-muted">{{ __('ui.country_page.country_code') }}</dt>
                    <dd class="mt-1 font-semibold text-ink">{{ $country->iso_code }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-ink-muted">{{ __('ui.country_page.eu_member') }}</dt>
                    <dd class="mt-1 font-semibold text-ink">{{ $country->is_eu_member ? __('ui.country_page.yes') : __('ui.country_page.no') }}</dd>
                </div>
                @if($country->is_eu_member)
                    <div>
                        <dt class="text-xs font-medium text-ink-muted">{{ __('ui.country_page.vies_validation') }}</dt>
                        <dd class="mt-1 font-semibold text-ink">{{ $country->vies_available ? __('ui.country_page.available') : __('ui.country_page.not_available') }}</dd>
                    </div>
                @endif
            </dl>
        </div>

        <div class="p-5 sm:p-6">
            <h3 class="text-sm font-semibold text-ink">{{ __('ui.calculator.calculation_reference') }}</h3>
            <div class="mt-3 space-y-3">
                <div class="rounded-xl border border-line p-4">
                    <p class="text-sm font-semibold text-ink">{{ __('ui.country_page.adding_vat', ['rate' => Country::formatRate($standard)]) }}</p>
                    <code class="mt-2 block font-mono text-sm font-semibold text-action-deep">{{ __('ui.calculator.formula_add', ['multiplier' => $multiplier]) }}</code>
                    <p class="mt-2 text-sm text-ink-muted">{{ Money::format($add->net, $currency) }} → <strong class="text-ink">{{ Money::format($add->gross, $currency) }}</strong></p>
                </div>
                <div class="rounded-xl border border-line p-4">
                    <p class="text-sm font-semibold text-ink">{{ __('ui.country_page.removing_vat', ['rate' => Country::formatRate($standard)]) }}</p>
                    <code class="mt-2 block font-mono text-sm font-semibold text-action-deep">{{ __('ui.calculator.formula_remove', ['multiplier' => $multiplier]) }}</code>
                    <p class="mt-2 text-sm text-ink-muted">{{ Money::format($remove->gross, $currency) }} → <strong class="text-ink">{{ Money::format($remove->net, $currency) }}</strong></p>
                </div>
            </div>
        </div>
    </div>
</section>
