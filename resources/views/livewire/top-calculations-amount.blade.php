@section('seo')
    <x-seo-meta
        :title="__('ui.top_calc.vat_on_amount', ['amount' => number_format($amount)]) . ' — ' . __('ui.top_calc.page_title')"
        :description="__('ui.top_calc.amount_page_desc', ['rate' => '', 'amount' => number_format($amount)])"
        type="website"
    />
@endsection

<div class="mx-auto max-w-6xl px-4 py-8 sm:py-12">

    {{-- Breadcrumbs --}}
    <x-breadcrumbs :items="[
        __('ui.top_calc.breadcrumb') => locale_path('/top-vat-calculations'),
        __('ui.top_calc.vat_on_amount', ['amount' => number_format($amount)]) => '',
    ]" />

    {{-- Back link --}}
    <div class="mb-6">
        <a href="{{ locale_path('/top-vat-calculations') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors">
            {{ __('ui.top_calc.back_to_all') }}
        </a>
    </div>

    {{-- Hero --}}
    <div class="text-center mb-10">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight mb-3">
            {{ __('ui.top_calc.vat_on_amount', ['amount' => number_format($amount)]) }}
        </h1>
        <p class="text-gray-500 max-w-2xl mx-auto">
            {{ __('ui.top_calc.calculations_count', ['count' => count($countries) * 2]) }}
        </p>
    </div>

    {{-- Quick amount navigation --}}
    <div class="flex flex-wrap justify-center gap-2 mb-10">
        @foreach($allAmounts as $amt)
            <a href="{{ locale_path('/top-vat-calculations/' . $amt) }}"
               class="px-4 py-2 rounded-full border text-sm font-semibold shadow-sm transition-all
                   {{ $amt === $amount
                       ? 'border-blue-400 bg-blue-600 text-white'
                       : 'border-gray-200 bg-white text-gray-700 hover:border-blue-300 hover:bg-blue-50 hover:text-blue-700' }}">
                €{{ number_format($amt) }}
            </a>
        @endforeach
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-12">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-5 py-3 text-left font-semibold text-gray-600">{{ __('ui.top_calc.country') }}</th>
                        <th class="px-5 py-3 text-center font-semibold text-gray-600">{{ __('ui.top_calc.rate') }}</th>
                        <th class="px-5 py-3 text-right font-semibold text-gray-600">{{ __('ui.top_calc.vat_amount') }}</th>
                        <th class="px-5 py-3 text-right font-semibold text-gray-600">{{ __('ui.top_calc.total_incl_vat') }}</th>
                        <th class="px-5 py-3 text-center font-semibold text-gray-600">{{ __('ui.top_calc.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($countries as $country)
                        @php
                            $rate = $country['standard_rate'];
                            $vatAmount = round($amount * ($rate / 100), 2);
                            $total = round($amount + $vatAmount, 2);
                        @endphp
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-5 py-3">
                                <a href="{{ locale_path('/vat-calculator/' . $country['slug']) }}" class="inline-flex items-center gap-2.5 font-semibold text-gray-900 hover:text-blue-600 transition-colors">
                                    <img src="https://flagcdn.com/h40/{{ strtolower($country['iso_code']) }}.jpg"
                                         alt="" class="h-4 w-auto rounded-sm" loading="lazy">
                                    {{ $country['name'] }}
                                </a>
                            </td>
                            <td class="px-5 py-3 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700">
                                    {{ $rate }}%
                                </span>
                            </td>
                            <td class="px-5 py-3 text-right font-semibold text-emerald-600 tabular-nums">
                                +€{{ number_format($vatAmount, 2) }}
                            </td>
                            <td class="px-5 py-3 text-right font-bold text-gray-900 tabular-nums">
                                €{{ number_format($total, 2) }}
                            </td>
                            <td class="px-5 py-3 text-center">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ locale_path('/vat-calculation/' . $country['slug'] . '/' . $amount . '/' . $rate . '/exclude') }}"
                                       class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-emerald-50 text-emerald-700 hover:bg-emerald-100 transition-colors"
                                       title="{{ __('ui.top_calc.add_vat') }}">
                                        {{ __('ui.top_calc.add_vat') }}
                                    </a>
                                    <a href="{{ locale_path('/vat-calculation/' . $country['slug'] . '/' . $amount . '/' . $rate . '/include') }}"
                                       class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-amber-50 text-amber-700 hover:bg-amber-100 transition-colors"
                                       title="{{ __('ui.top_calc.remove_vat') }}">
                                        {{ __('ui.top_calc.remove_vat') }}
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Disclaimer --}}
    <div class="text-center text-xs text-gray-400 max-w-2xl mx-auto">
        <p>{{ __('ui.top_calc.disclaimer') }}</p>
    </div>
</div>
