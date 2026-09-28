@props(['country'])

@use('App\Models\Country')

<header data-country-header class="text-white">
    <x-site-breadcrumbs variant="dark" :items="[__('ui.calculator.breadcrumb_label') => locale_path('/vat-calculator'), $country->name => '']" />

    <div class="mt-6 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
        <div class="flex min-w-0 items-start gap-4">
            <x-ui.flag :iso="$country->iso_code" size="xl" :lazy="false" :alt="$country->name" class="mt-1 rounded-md shadow-none ring-1 ring-white/25" />
            <div class="min-w-0">
                <p class="text-sm font-semibold text-sky-200">{{ $country->is_eu_member ? __('ui.calculator.scope.eu') : __('ui.calculator.scope.other_europe') }}</p>
                <h1 class="mt-1 text-3xl font-bold tracking-[-0.03em] text-white sm:text-4xl">{{ __('ui.calculator.country_heading', ['country' => $country->name]) }}</h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-white/80 sm:text-base">
                    {{ __('ui.calculator.country_subtitle', ['country' => $country->name, 'rate' => Country::formatRate($country->standard_rate)]) }}
                </p>
            </div>
        </div>

        <dl class="grid shrink-0 grid-cols-3 divide-x divide-white/15 overflow-hidden rounded-2xl border border-white/15 bg-white/10 text-center backdrop-blur-sm">
            <div class="px-4 py-3 sm:px-5">
                <dt class="text-xs font-medium text-white/70">{{ __('ui.rate_type.standard') }}</dt>
                <dd class="mt-0.5 text-2xl font-bold text-white">{{ Country::formatRate($country->standard_rate) }}%</dd>
            </div>
            <div class="px-4 py-3 sm:px-5">
                <dt class="text-xs font-medium text-white/70">{{ __('ui.rate_type.reduced') }}</dt>
                <dd class="mt-0.5 text-2xl font-bold text-white">{{ $country->formattedReducedRates(' · ') ?? '—' }}</dd>
            </div>
            <div class="px-4 py-3 sm:px-5">
                <dt class="text-xs font-medium text-white/70">{{ __('ui.country_page.currency') }}</dt>
                <dd class="mt-0.5 text-2xl font-bold text-white">{{ $country->currencyCode() }}</dd>
            </div>
        </dl>
    </div>
</header>
