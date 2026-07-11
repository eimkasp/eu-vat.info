@props(['country'])

@php
    $rates = collect([
        ['label' => __('ui.country_page.standard_rate'), 'value' => $country->standard_rate],
        ['label' => __('ui.country_page.reduced_rate'), 'value' => $country->reduced_rate],
        ['label' => __('ui.country_page.super_reduced'), 'value' => $country->super_reduced_rate],
        ['label' => __('ui.country_page.parking_rate'), 'value' => $country->parking_rate],
    ])->filter(fn (array $rate) => filled($rate['value']));
    $multiplier = 1 + $country->standard_rate / 100;
@endphp

<section data-country-reference aria-labelledby="country-reference-title" class="overflow-hidden border border-line bg-white">
    <div class="border-b border-line px-5 py-4 sm:px-6">
        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-action">{{ __('ui.country_page.key_information') }}</p>
        <h2 id="country-reference-title" class="mt-1 text-xl font-bold text-ink">{{ __('ui.calculator.current_vat_rates') }} and formulas</h2>
    </div>

    <div class="grid lg:grid-cols-2">
        <div class="border-b border-line p-5 sm:p-6 lg:border-b-0 lg:border-r">
            <h3 class="text-sm font-bold text-ink">Rate reference</h3>
            <dl class="mt-3 divide-y divide-line border-y border-line">
                @foreach($rates as $rate)
                    <div class="flex min-h-12 items-center justify-between gap-4 py-2.5">
                        <dt class="text-sm text-ink-muted">{{ $rate['label'] }}</dt>
                        <dd class="font-bold tabular-nums text-ink">{{ $rate['value'] }}%</dd>
                    </div>
                @endforeach
            </dl>

            <dl class="mt-5 grid grid-cols-2 gap-x-5 gap-y-4 text-sm">
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-ink-muted">{{ __('ui.country_page.currency') }}</dt>
                    <dd class="mt-1 font-semibold text-ink">{{ $country->currency_code }} · {{ $country->currency_display }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-ink-muted">{{ __('ui.country_page.country_code') }}</dt>
                    <dd class="mt-1 font-semibold text-ink">{{ $country->iso_code }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-ink-muted">{{ __('ui.country_page.eu_member') }}</dt>
                    <dd class="mt-1 font-semibold text-ink">{{ $country->is_eu_member ? __('ui.country_page.yes') : __('ui.country_page.no') }}</dd>
                </div>
                @if($country->is_eu_member)
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-ink-muted">{{ __('ui.country_page.vies_validation') }}</dt>
                        <dd class="mt-1 font-semibold text-ink">{{ $country->vies_available ? __('ui.country_page.available') : __('ui.country_page.not_available') }}</dd>
                    </div>
                @endif
            </dl>
        </div>

        <div class="p-5 sm:p-6">
            <h3 class="text-sm font-bold text-ink">Calculation reference</h3>
            <div class="mt-3 divide-y divide-line border-y border-line">
                <div class="py-4">
                    <p class="text-sm font-semibold text-ink">{{ __('ui.country_page.adding_vat', ['rate' => $country->standard_rate]) }}</p>
                    <code class="mt-2 block text-sm font-semibold tabular-nums text-action-deep">Net × {{ $multiplier }} = gross</code>
                    <p class="mt-2 text-sm text-ink-muted">{{ $country->currency_display }}100 net → <strong class="text-ink">{{ $country->currency_display }}{{ number_format(100 * $multiplier, 2) }} gross</strong></p>
                </div>
                <div class="py-4">
                    <p class="text-sm font-semibold text-ink">{{ __('ui.country_page.removing_vat', ['rate' => $country->standard_rate]) }}</p>
                    <code class="mt-2 block text-sm font-semibold tabular-nums text-action-deep">Gross ÷ {{ $multiplier }} = net</code>
                    <p class="mt-2 text-sm text-ink-muted">{{ $country->currency_display }}100 gross → <strong class="text-ink">{{ $country->currency_display }}{{ number_format(100 / $multiplier, 2) }} net</strong></p>
                </div>
            </div>
        </div>
    </div>
</section>
