@section('seo')
    <x-seo-meta
        :title="'VAT Calculation: ' . ($mode === 'exclude' ? 'Add' : 'Remove') . ' ' . $rate . '% VAT on ' . ($countryObject?->currency_display ?? '€') . number_format((float)$amount, 2) . ' — ' . $countryObject->name"
        :description="'Detailed VAT calculation for ' . $countryObject->name . '. ' . ($mode === 'exclude' ? 'Adding' : 'Removing') . ' ' . $rate . '% VAT on ' . ($countryObject?->currency_display ?? '€') . number_format((float)$amount, 2) . '. Net: ' . ($countryObject?->currency_display ?? '€') . number_format($net_amount, 2) . ', VAT: ' . ($countryObject?->currency_display ?? '€') . number_format($vat_amount, 2) . ', Total: ' . ($countryObject?->currency_display ?? '€') . number_format($total, 2)"
        type="website"
    />
@endsection

<div class="mx-auto max-w-4xl px-4 py-8 sm:py-12">

    {{-- Breadcrumbs --}}
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-8">
        <a href="{{ locale_path('/') }}" wire:navigate class="hover:text-blue-600 transition-colors">Home</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
        <a href="{{ locale_path('/vat-calculator/' . $countryObject->slug) }}" wire:navigate class="hover:text-blue-600 transition-colors">VAT Calculator</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
        <span class="text-gray-600 font-medium">Shared Calculation</span>
    </nav>

    {{-- Header --}}
    <div class="text-center mb-8">
        <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-50 text-blue-700 rounded-full text-xs font-semibold mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" />
            </svg>
            Shared Calculation
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight mb-2">
            {{ $mode === 'exclude' ? 'Adding' : 'Removing' }} {{ $rate }}% VAT
            <span class="text-blue-600">in {{ $countryObject->name }}</span>
        </h1>
        <p class="text-gray-500 text-sm">
            Calculated on {{ now()->format('F j, Y') }} using official EU VAT rates
        </p>
    </div>

    {{-- Main Result Card --}}
    <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden mb-6">
        {{-- Country header bar --}}
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="https://flagcdn.com/h80/{{ strtolower($countryObject->iso_code) }}.jpg"
                     alt="{{ $countryObject->name }} flag"
                     class="h-8 w-auto rounded shadow-sm" loading="lazy">
                <div>
                    <h2 class="text-white font-bold text-lg">{{ $countryObject->name }}</h2>
                    <p class="text-blue-200 text-xs">{{ $rateName }} rate: {{ $rate }}% &middot; Currency: {{ $countryObject->currency_display ?? 'EUR (€)' }}</p>
                </div>
            </div>
            <div class="text-right">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-white/20 text-white backdrop-blur-sm">
                    {{ $mode === 'exclude' ? 'VAT Added' : 'VAT Extracted' }}
                </span>
            </div>
        </div>

        {{-- Results breakdown --}}
        <div class="p-6 sm:p-8">
            {{-- Visual Flow --}}
            <div class="flex flex-col sm:flex-row items-center gap-4 sm:gap-6 mb-8">
                {{-- Input Amount --}}
                <div class="flex-1 w-full text-center p-5 bg-gray-50 rounded-xl border border-gray-200">
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                        {{ $mode === 'exclude' ? 'Net Amount' : 'Gross Amount' }}
                    </div>
                    <div class="text-3xl sm:text-4xl font-extrabold text-gray-900 tabular-nums">
                        {{ $countryObject->currency_display ?? '€' }}{{ number_format((float)$amount, 2) }}
                    </div>
                    <div class="text-xs text-gray-400 mt-1">Amount you entered</div>
                </div>

                {{-- Operator --}}
                <div class="w-12 h-12 rounded-full {{ $mode === 'exclude' ? 'bg-blue-100 text-blue-600' : 'bg-red-100 text-red-600' }} flex items-center justify-center shrink-0 shadow-sm">
                    @if($mode === 'exclude')
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                        </svg>
                    @endif
                </div>

                {{-- VAT --}}
                <div class="flex-1 w-full text-center p-5 {{ $mode === 'exclude' ? 'bg-blue-50 border-blue-200' : 'bg-red-50 border-red-200' }} rounded-xl border">
                    <div class="text-xs font-semibold {{ $mode === 'exclude' ? 'text-blue-400' : 'text-red-400' }} uppercase tracking-wider mb-2">
                        VAT ({{ $rate }}%)
                    </div>
                    <div class="text-3xl sm:text-4xl font-extrabold {{ $mode === 'exclude' ? 'text-blue-600' : 'text-red-600' }} tabular-nums">
                        {{ $mode === 'exclude' ? '+' : '−' }}{{ $countryObject->currency_display ?? '€' }}{{ number_format($vat_amount, 2) }}
                    </div>
                    <div class="text-xs {{ $mode === 'exclude' ? 'text-blue-400' : 'text-red-400' }} mt-1">{{ $rateName }} rate</div>
                </div>

                {{-- Equals --}}
                <div class="w-12 h-12 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center shrink-0 shadow-sm font-bold text-xl">=</div>

                {{-- Result --}}
                <div class="flex-1 w-full text-center p-5 bg-gradient-to-br from-gray-900 to-gray-800 rounded-xl text-white">
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                        {{ $mode === 'exclude' ? 'Total (incl. VAT)' : 'Net Amount' }}
                    </div>
                    <div class="text-3xl sm:text-4xl font-extrabold tabular-nums">
                        {{ $countryObject->currency_display ?? '€' }}{{ number_format($mode === 'exclude' ? $total : $net_amount, 2) }}
                    </div>
                    <div class="text-xs text-gray-400 mt-1">Final result</div>
                </div>
            </div>

            {{-- Detailed Breakdown Table --}}
            <div class="bg-gray-50 rounded-xl border border-gray-200 overflow-hidden mb-6">
                <div class="px-5 py-3 border-b border-gray-200 bg-white">
                    <h3 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
                        </svg>
                        Calculation Breakdown
                    </h3>
                </div>
                <table class="w-full text-sm">
                    <tbody class="divide-y divide-gray-200">
                        <tr>
                            <td class="px-5 py-3 text-gray-500">Country</td>
                            <td class="px-5 py-3 text-right font-semibold text-gray-900">
                                <span class="inline-flex items-center gap-2">
                                    <img src="https://flagcdn.com/h40/{{ strtolower($countryObject->iso_code) }}.jpg" alt="" class="h-4 w-auto rounded-sm" loading="lazy">
                                    {{ $countryObject->name }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-5 py-3 text-gray-500">VAT Rate</td>
                            <td class="px-5 py-3 text-right font-semibold text-gray-900">{{ $rate }}% ({{ $rateName }})</td>
                        </tr>
                        <tr>
                            <td class="px-5 py-3 text-gray-500">Calculation Mode</td>
                            <td class="px-5 py-3 text-right font-semibold text-gray-900">{{ $mode === 'exclude' ? 'Add VAT to net amount' : 'Extract VAT from gross amount' }}</td>
                        </tr>
                        <tr class="bg-white">
                            <td class="px-5 py-3 text-gray-500">Net Amount (excl. VAT)</td>
                            <td class="px-5 py-3 text-right font-bold text-gray-900 text-base">{{ $countryObject->currency_display ?? '€' }}{{ number_format($net_amount, 2) }}</td>
                        </tr>
                        <tr class="bg-white">
                            <td class="px-5 py-3 text-gray-500">VAT Amount</td>
                            <td class="px-5 py-3 text-right font-bold {{ $mode === 'exclude' ? 'text-blue-600' : 'text-red-600' }} text-base">{{ $mode === 'exclude' ? '+' : '−' }}{{ $countryObject->currency_display ?? '€' }}{{ number_format($vat_amount, 2) }}</td>
                        </tr>
                        <tr class="bg-gray-900 text-white">
                            <td class="px-5 py-3.5 font-semibold">Total (incl. VAT)</td>
                            <td class="px-5 py-3.5 text-right font-extrabold text-lg">{{ $countryObject->currency_display ?? '€' }}{{ number_format($total, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Formula Explanation --}}
            <div class="bg-amber-50 rounded-xl border border-amber-200 p-5 mb-6">
                <h3 class="font-bold text-amber-800 text-sm flex items-center gap-2 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                    </svg>
                    How this was calculated
                </h3>

                @if($mode === 'exclude')
                    <div class="space-y-3 text-sm text-amber-900">
                        <p><strong>Mode:</strong> Adding VAT to a net (tax-exclusive) amount</p>
                        <div class="bg-white/60 rounded-lg p-4 font-mono text-xs sm:text-sm space-y-1.5 border border-amber-200">
                            <p class="text-gray-500">// Formula: VAT = Net Amount × (Rate ÷ 100)</p>
                            <p>VAT = {{ $countryObject->currency_display ?? '€' }}{{ number_format((float)$amount, 2) }} × ({{ $rate }} ÷ 100)</p>
                            <p>VAT = {{ $countryObject->currency_display ?? '€' }}{{ number_format((float)$amount, 2) }} × {{ number_format($rate / 100, 4) }}</p>
                            <p class="font-bold">VAT = {{ $countryObject->currency_display ?? '€' }}{{ number_format($vat_amount, 2) }}</p>
                            <div class="border-t border-amber-200 my-2"></div>
                            <p class="text-gray-500">// Formula: Total = Net Amount + VAT</p>
                            <p>Total = {{ $countryObject->currency_display ?? '€' }}{{ number_format((float)$amount, 2) }} + {{ $countryObject->currency_display ?? '€' }}{{ number_format($vat_amount, 2) }}</p>
                            <p class="font-bold text-base">Total = {{ $countryObject->currency_display ?? '€' }}{{ number_format($total, 2) }}</p>
                        </div>
                    </div>
                @else
                    <div class="space-y-3 text-sm text-amber-900">
                        <p><strong>Mode:</strong> Extracting VAT from a gross (tax-inclusive) amount</p>
                        <div class="bg-white/60 rounded-lg p-4 font-mono text-xs sm:text-sm space-y-1.5 border border-amber-200">
                            <p class="text-gray-500">// Formula: Net = Gross ÷ (1 + Rate ÷ 100)</p>
                            <p>Net = {{ $countryObject->currency_display ?? '€' }}{{ number_format((float)$amount, 2) }} ÷ (1 + {{ $rate }} ÷ 100)</p>
                            <p>Net = {{ $countryObject->currency_display ?? '€' }}{{ number_format((float)$amount, 2) }} ÷ {{ number_format(1 + $rate / 100, 4) }}</p>
                            <p class="font-bold">Net = {{ $countryObject->currency_display ?? '€' }}{{ number_format($net_amount, 2) }}</p>
                            <div class="border-t border-amber-200 my-2"></div>
                            <p class="text-gray-500">// Formula: VAT = Gross − Net</p>
                            <p>VAT = {{ $countryObject->currency_display ?? '€' }}{{ number_format((float)$amount, 2) }} − {{ $countryObject->currency_display ?? '€' }}{{ number_format($net_amount, 2) }}</p>
                            <p class="font-bold text-base">VAT = {{ $countryObject->currency_display ?? '€' }}{{ number_format($vat_amount, 2) }}</p>
                        </div>
                    </div>
                @endif
            </div>

            {{-- All Available Rates for this country --}}
            @if(count($countryRates) > 0)
                <div class="bg-white rounded-xl border border-gray-200 p-5 mb-6">
                    <h3 class="font-bold text-gray-900 text-sm flex items-center gap-2 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                        </svg>
                        All VAT Rates for {{ $countryObject->name }}
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($countryRates as $r)
                            <a href="{{ locale_path('/calculation?country=' . $country . '&amount=' . $amount . '&rate=' . $r['value'] . '&mode=' . $mode) }}"
                               class="px-4 py-2 rounded-xl border text-sm font-semibold transition-all
                                   {{ abs($r['value'] - $rate) < 0.01
                                       ? 'bg-blue-600 border-blue-600 text-white shadow-md'
                                       : 'bg-gray-50 border-gray-200 text-gray-700 hover:border-blue-300 hover:bg-blue-50' }}">
                                {{ $r['name'] }}: {{ $r['value'] }}%
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="flex flex-col sm:flex-row items-center justify-center gap-3 mb-8"
         x-data="{ copied: false, shareUrl: '{{ $this->shareUrl }}' }">

        {{-- Copy Link --}}
        <button
            @click="navigator.clipboard.writeText(shareUrl).then(() => { copied = true; setTimeout(() => copied = false, 2000) })"
            class="inline-flex items-center gap-2 px-6 py-3 bg-white border border-gray-200 rounded-xl text-sm font-semibold text-gray-700 hover:bg-gray-50 hover:border-gray-300 shadow-sm transition-all w-full sm:w-auto justify-center"
        >
            <svg x-show="!copied" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
            </svg>
            <svg x-show="copied" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            <span x-text="copied ? 'Link Copied!' : 'Copy Link'"></span>
        </button>

        {{-- Recalculate --}}
        <a href="{{ locale_path('/vat-calculator/' . $countryObject->slug . '?amount=' . $amount . '&selectedRate=' . $rate . '&vat_included=' . $mode) }}" wire:navigate
           class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold shadow-lg shadow-blue-200 transition-all w-full sm:w-auto justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V13.5Zm0 2.25h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V18Zm2.498-6.75h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V13.5Zm0 2.25h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V18Zm2.504-6.75h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V13.5Zm0 2.25h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V18Zm2.498-6.75h.008v.008H15.75v-.008Zm0 2.25h.008v.008H15.75V13.5ZM8.25 6h7.5v2.25h-7.5V6ZM12 2.25c-1.892 0-3.758.11-5.593.322C5.307 2.7 4.5 3.65 4.5 4.757V19.5a2.25 2.25 0 0 0 2.25 2.25h10.5a2.25 2.25 0 0 0 2.25-2.25V4.757c0-1.108-.806-2.057-1.907-2.185A48.507 48.507 0 0 0 12 2.25Z" />
            </svg>
            Open in Full Calculator
        </a>

        {{-- Country Details --}}
        <a href="{{ locale_path('/vat-calculator/' . $countryObject->slug) }}" wire:navigate
           class="inline-flex items-center gap-2 px-6 py-3 bg-white border border-gray-200 rounded-xl text-sm font-semibold text-gray-700 hover:bg-gray-50 hover:border-gray-300 shadow-sm transition-all w-full sm:w-auto justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
            </svg>
            {{ $countryObject->name }} VAT Guide
        </a>
    </div>

    {{-- Disclaimer --}}
    <div class="text-center text-xs text-gray-400 max-w-2xl mx-auto">
        <p>This calculation is for informational purposes only. VAT rates are sourced from the European Commission and may change.
        Always verify with your local tax authority for official compliance. Calculated on {{ now()->format('F j, Y \a\t H:i') }} UTC.</p>
    </div>
</div>
