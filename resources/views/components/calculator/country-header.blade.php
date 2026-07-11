@props(['country'])

<header data-country-header class="bg-[#0b2f4f] text-white">
    <div class="container !py-5 sm:!py-7">
        <x-breadcrumbs variant="dark" :items="[__('ui.calculator.breadcrumb_label') => locale_path('/vat-calculator'), $country->name => '']" />

        <div class="mt-4 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
            <div class="min-w-0">
                <div class="flex items-center gap-3">
                    <img
                        src="https://flagcdn.com/h80/{{ strtolower($country->iso_code) }}.jpg"
                        alt="{{ $country->name }} flag"
                        class="h-8 w-auto rounded-sm ring-1 ring-white/25"
                    >
                    <span class="text-xs font-semibold uppercase tracking-[0.16em] text-blue-100">
                        {{ $country->is_eu_member ? __('ui.calculator.scope.eu') : __('ui.calculator.scope.other_europe') }}
                    </span>
                </div>

                <h1 class="mt-3 text-3xl font-bold tracking-tight text-white sm:text-4xl">{{ $country->name }} VAT Calculator</h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-blue-100 sm:text-base">
                    {{ __('ui.calculator.country_subtitle', ['country' => $country->name, 'rate' => $country->standard_rate]) }}
                </p>
            </div>

            <dl class="flex shrink-0 items-baseline gap-3 border-l-2 border-blue-300/60 pl-4 sm:block sm:min-w-32">
                <dt class="text-xs font-semibold uppercase tracking-[0.14em] text-blue-200">{{ __('ui.country_page.standard_rate_label') }}</dt>
                <dd class="mt-1 text-3xl font-bold tabular-nums text-white">{{ $country->standard_rate }}%</dd>
            </dl>
        </div>
    </div>
</header>
