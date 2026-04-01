@section('seo')
    <x-seo-meta
        title="Popular VAT Calculations — EU VAT Calculator"
        description="Browse the most common VAT calculations across all 27 EU member states. Quick links to add or remove VAT for popular amounts like €100, €500, €1,000 and more."
        type="website"
    />
@endsection

<div class="mx-auto max-w-6xl px-4 py-8 sm:py-12">

    {{-- Breadcrumbs --}}
    <x-breadcrumbs :items="[['label' => 'Popular Calculations']]" />

    {{-- Hero --}}
    <div class="text-center mb-10">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight mb-3">
            Popular VAT Calculations
        </h1>
        <p class="text-gray-500 max-w-2xl mx-auto">
            Quick access to the most common VAT calculations across all 27 EU member states.
            Click any link to see the full calculation breakdown.
        </p>
    </div>

    {{-- Quick amount navigation --}}
    <div class="flex flex-wrap justify-center gap-2 mb-10">
        @foreach($popularAmounts as $amt)
            <a href="#amount-{{ $amt }}" class="px-4 py-2 rounded-full border border-gray-200 bg-white text-sm font-semibold text-gray-700 hover:border-blue-300 hover:bg-blue-50 hover:text-blue-700 shadow-sm transition-all">
                €{{ number_format($amt) }}
            </a>
        @endforeach
    </div>

    {{-- Sections per amount --}}
    @foreach($popularAmounts as $amt)
        <section id="amount-{{ $amt }}" class="mb-12 scroll-mt-20">
            <div class="flex items-center gap-3 mb-5">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900">
                    VAT on €{{ number_format($amt) }}
                </h2>
                <div class="flex-1 border-t border-gray-200"></div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="px-5 py-3 text-left font-semibold text-gray-600">Country</th>
                                <th class="px-5 py-3 text-center font-semibold text-gray-600">Rate</th>
                                <th class="px-5 py-3 text-right font-semibold text-gray-600">VAT Amount</th>
                                <th class="px-5 py-3 text-right font-semibold text-gray-600">Total incl. VAT</th>
                                <th class="px-5 py-3 text-center font-semibold text-gray-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($countries as $country)
                                @php
                                    $rate = $country['standard_rate'];
                                    $vatAmount = round($amt * ($rate / 100), 2);
                                    $total = round($amt + $vatAmount, 2);
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
                                            <a href="{{ locale_path('/vat-calculation/' . $country['slug'] . '/' . $amt . '/' . $rate . '/exclude') }}"
                                               class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-emerald-50 text-emerald-700 hover:bg-emerald-100 transition-colors"
                                               title="Add {{ $rate }}% VAT to €{{ number_format($amt) }}">
                                                + Add VAT
                                            </a>
                                            <a href="{{ locale_path('/vat-calculation/' . $country['slug'] . '/' . $amt . '/' . $rate . '/include') }}"
                                               class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-amber-50 text-amber-700 hover:bg-amber-100 transition-colors"
                                               title="Remove {{ $rate }}% VAT from €{{ number_format($amt) }}">
                                                − Remove VAT
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    @endforeach

    {{-- SEO content --}}
    <div class="prose prose-sm max-w-3xl mx-auto text-gray-600 mt-12">
        <h2 class="text-lg font-bold text-gray-900">About These Calculations</h2>
        <p>
            This page provides pre-calculated VAT amounts for common transaction values across all 27 EU member states.
            Each calculation uses the current standard VAT rate for the respective country, sourced from the European Commission.
        </p>
        <p>
            VAT (Value Added Tax) is a consumption tax applied to goods and services in the European Union.
            Standard rates range from {{ collect($countries)->min('standard_rate') }}% to {{ collect($countries)->max('standard_rate') }}%
            depending on the country. Use our <a href="{{ locale_path('/vat-calculator') }}" class="text-blue-600 hover:text-blue-700">VAT Calculator</a>
            for custom amounts or to calculate with reduced rates.
        </p>
    </div>

    {{-- Disclaimer --}}
    <div class="text-center text-xs text-gray-400 max-w-2xl mx-auto mt-8">
        <p>Calculations are for informational purposes only. VAT rates are sourced from the European Commission and may change.
        Always verify with your local tax authority for official compliance.</p>
    </div>
</div>
