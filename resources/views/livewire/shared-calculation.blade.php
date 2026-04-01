@section('seo')
    <x-seo-meta
        :title="($mode === 'exclude' ? 'Add' : 'Remove') . ' ' . $rate . '% VAT on ' . ($countryObject?->currency_display ?? '€') . number_format((float)$amount, 2) . ' — ' . $countryObject->name . ' VAT Calculation'"
        :description="'Detailed VAT calculation for ' . $countryObject->name . '. ' . ($mode === 'exclude' ? 'Adding' : 'Removing') . ' ' . $rate . '% VAT on ' . ($countryObject?->currency_display ?? '€') . number_format((float)$amount, 2) . '. Net: ' . ($countryObject?->currency_display ?? '€') . number_format($net_amount, 2) . ', VAT: ' . ($countryObject?->currency_display ?? '€') . number_format($vat_amount, 2) . ', Total: ' . ($countryObject?->currency_display ?? '€') . number_format($total, 2)"
        type="website"
    />
@endsection

<div class="mx-auto max-w-5xl px-4 py-8 sm:py-12">

    {{-- Breadcrumbs --}}
    <nav class="flex items-center gap-1.5 text-sm text-gray-400 mb-8 flex-wrap" aria-label="Breadcrumb">
        <a href="{{ locale_path('/') }}" class="hover:text-blue-600 transition-colors">Home</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
        <a href="{{ locale_path('/vat-calculator/' . $countryObject->slug) }}" class="hover:text-blue-600 transition-colors">{{ $countryObject->name }} VAT</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
        <span class="text-gray-600 font-medium">{{ $rate }}% VAT on {{ ($countryObject?->currency_display ?? '€') }}{{ number_format((float)$amount, 2) }}</span>
    </nav>

    {{-- Hero Result --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white mb-8">
        <div class="absolute inset-0 opacity-5">
            <svg width="100%" height="100%"><defs><pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="0.5"/></pattern></defs><rect width="100%" height="100%" fill="url(#grid)"/></svg>
        </div>

        <div class="relative p-6 sm:p-10">
            <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
                <div class="flex items-center gap-3">
                    <img src="https://flagcdn.com/h80/{{ strtolower($countryObject->iso_code) }}.jpg"
                         alt="{{ $countryObject->name }} flag"
                         class="h-8 w-auto rounded shadow-lg" loading="lazy">
                    <div>
                        <h1 class="text-lg sm:text-xl font-bold">{{ $countryObject->name }}</h1>
                        <p class="text-slate-400 text-xs">{{ $rateName }} rate &middot; {{ $rate }}% VAT &middot; {{ $countryObject->currency_display ?? 'EUR (€)' }}</p>
                    </div>
                </div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold {{ $mode === 'exclude' ? 'bg-emerald-500/20 text-emerald-300 ring-1 ring-emerald-500/30' : 'bg-amber-500/20 text-amber-300 ring-1 ring-amber-500/30' }}">
                    @if($mode === 'exclude')
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                        VAT Added
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" /></svg>
                        VAT Extracted
                    @endif
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 items-center">
                <div class="text-center p-5 rounded-xl bg-white/5 backdrop-blur-sm border border-white/10">
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">
                        {{ $mode === 'exclude' ? 'Net Amount' : 'Gross Amount' }}
                    </div>
                    <div class="text-2xl sm:text-3xl font-extrabold tabular-nums tracking-tight">
                        {{ $countryObject->currency_display ?? '€' }}{{ number_format((float)$amount, 2) }}
                    </div>
                </div>

                <div class="text-center">
                    <div class="inline-flex items-center gap-3 px-5 py-3 rounded-xl {{ $mode === 'exclude' ? 'bg-emerald-500/10 border border-emerald-500/20' : 'bg-amber-500/10 border border-amber-500/20' }}">
                        <span class="text-lg {{ $mode === 'exclude' ? 'text-emerald-400' : 'text-amber-400' }}">{{ $mode === 'exclude' ? '+' : '−' }}</span>
                        <div>
                            <div class="text-[10px] font-bold {{ $mode === 'exclude' ? 'text-emerald-400/70' : 'text-amber-400/70' }} uppercase tracking-widest">VAT {{ $rate }}%</div>
                            <div class="text-xl sm:text-2xl font-extrabold {{ $mode === 'exclude' ? 'text-emerald-300' : 'text-amber-300' }} tabular-nums">
                                {{ $countryObject->currency_display ?? '€' }}{{ number_format($vat_amount, 2) }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center p-5 rounded-xl bg-blue-500/10 border-2 border-blue-400/30 relative">
                    <div class="absolute -top-2.5 left-1/2 -translate-x-1/2 px-2 py-0.5 bg-blue-500 rounded-full text-[10px] font-bold uppercase tracking-wider">Result</div>
                    <div class="text-[10px] font-bold text-blue-300/70 uppercase tracking-widest mb-2 mt-1">
                        {{ $mode === 'exclude' ? 'Total incl. VAT' : 'Net excl. VAT' }}
                    </div>
                    <div class="text-3xl sm:text-4xl font-black tabular-nums tracking-tight text-blue-100">
                        {{ $countryObject->currency_display ?? '€' }}{{ number_format($mode === 'exclude' ? $total : $net_amount, 2) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Two-column layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="lg:col-span-2 space-y-6">
            {{-- Breakdown Table --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="font-bold text-gray-900 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
                        </svg>
                        Calculation Breakdown
                    </h2>
                </div>
                <table class="w-full text-sm">
                    <tbody class="divide-y divide-gray-100">
                        <tr>
                            <td class="px-6 py-3.5 text-gray-500">Country</td>
                            <td class="px-6 py-3.5 text-right font-semibold text-gray-900">
                                <span class="inline-flex items-center gap-2">
                                    <img src="https://flagcdn.com/h40/{{ strtolower($countryObject->iso_code) }}.jpg" alt="" class="h-4 w-auto rounded-sm" loading="lazy">
                                    {{ $countryObject->name }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3.5 text-gray-500">VAT Rate</td>
                            <td class="px-6 py-3.5 text-right font-semibold text-gray-900">{{ $rate }}% <span class="text-gray-400 font-normal">({{ $rateName }})</span></td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3.5 text-gray-500">Mode</td>
                            <td class="px-6 py-3.5 text-right font-semibold text-gray-900">{{ $mode === 'exclude' ? 'Add VAT to net amount' : 'Extract VAT from gross amount' }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3.5 text-gray-500">Net Amount <span class="text-gray-400">(excl. VAT)</span></td>
                            <td class="px-6 py-3.5 text-right font-bold text-gray-900 text-base tabular-nums">{{ $countryObject->currency_display ?? '€' }}{{ number_format($net_amount, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3.5 text-gray-500">VAT Amount</td>
                            <td class="px-6 py-3.5 text-right font-bold {{ $mode === 'exclude' ? 'text-emerald-600' : 'text-amber-600' }} text-base tabular-nums">{{ $mode === 'exclude' ? '+' : '−' }}{{ $countryObject->currency_display ?? '€' }}{{ number_format($vat_amount, 2) }}</td>
                        </tr>
                        <tr class="bg-slate-900">
                            <td class="px-6 py-4 font-semibold text-white">Total <span class="text-slate-400 font-normal">(incl. VAT)</span></td>
                            <td class="px-6 py-4 text-right font-black text-white text-lg tabular-nums">{{ $countryObject->currency_display ?? '€' }}{{ number_format($total, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Formula --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="font-bold text-gray-900 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                        </svg>
                        How This Was Calculated
                    </h2>
                </div>
                <div class="p-6">
                    @if($mode === 'exclude')
                        <div class="space-y-3 text-sm text-gray-700">
                            <p><strong>Mode:</strong> Adding VAT to a net (tax-exclusive) amount</p>
                            <div class="bg-gray-50 rounded-xl p-5 font-mono text-xs sm:text-sm space-y-1.5 border border-gray-200">
                                <p class="text-gray-400">// Formula: VAT = Net × (Rate ÷ 100)</p>
                                <p>VAT = {{ $countryObject->currency_display ?? '€' }}{{ number_format((float)$amount, 2) }} × {{ number_format($rate / 100, 4) }}</p>
                                <p class="font-bold text-emerald-700">VAT = {{ $countryObject->currency_display ?? '€' }}{{ number_format($vat_amount, 2) }}</p>
                                <div class="border-t border-gray-200 my-2"></div>
                                <p class="text-gray-400">// Formula: Total = Net + VAT</p>
                                <p>Total = {{ $countryObject->currency_display ?? '€' }}{{ number_format((float)$amount, 2) }} + {{ $countryObject->currency_display ?? '€' }}{{ number_format($vat_amount, 2) }}</p>
                                <p class="font-bold text-blue-700 text-base">Total = {{ $countryObject->currency_display ?? '€' }}{{ number_format($total, 2) }}</p>
                            </div>
                        </div>
                    @else
                        <div class="space-y-3 text-sm text-gray-700">
                            <p><strong>Mode:</strong> Extracting VAT from a gross (tax-inclusive) amount</p>
                            <div class="bg-gray-50 rounded-xl p-5 font-mono text-xs sm:text-sm space-y-1.5 border border-gray-200">
                                <p class="text-gray-400">// Formula: Net = Gross ÷ (1 + Rate ÷ 100)</p>
                                <p>Net = {{ $countryObject->currency_display ?? '€' }}{{ number_format((float)$amount, 2) }} ÷ {{ number_format(1 + $rate / 100, 4) }}</p>
                                <p class="font-bold text-emerald-700">Net = {{ $countryObject->currency_display ?? '€' }}{{ number_format($net_amount, 2) }}</p>
                                <div class="border-t border-gray-200 my-2"></div>
                                <p class="text-gray-400">// Formula: VAT = Gross − Net</p>
                                <p>VAT = {{ $countryObject->currency_display ?? '€' }}{{ number_format((float)$amount, 2) }} − {{ $countryObject->currency_display ?? '€' }}{{ number_format($net_amount, 2) }}</p>
                                <p class="font-bold text-amber-700 text-base">VAT = {{ $countryObject->currency_display ?? '€' }}{{ number_format($vat_amount, 2) }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right sidebar --}}
        <div class="space-y-6">
            {{-- Actions --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 space-y-3"
                 x-data="{ copied: false, shareUrl: '{{ $this->shareUrl }}' }">
                <h3 class="font-bold text-gray-900 text-sm mb-3">Actions</h3>

                <button
                    @click="navigator.clipboard.writeText(shareUrl).then(() => { copied = true; setTimeout(() => copied = false, 2000) })"
                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm font-semibold text-gray-700 hover:bg-gray-50 hover:border-gray-300 shadow-sm transition-all"
                >
                    <svg x-show="!copied" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                    </svg>
                    <svg x-show="copied" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <span x-text="copied ? 'Link Copied!' : 'Copy Share Link'"></span>
                </button>

                <a href="{{ locale_path('/vat-calculator/' . $countryObject->slug . '?amount=' . $amount . '&selectedRate=' . $rate . '&vat_included=' . $mode) }}"
                   class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold shadow-sm transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V13.5Zm0 2.25h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V18Zm2.498-6.75h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V13.5Zm0 2.25h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V18Zm2.504-6.75h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V13.5Zm0 2.25h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V18Zm2.498-6.75h.008v.008H15.75v-.008Zm0 2.25h.008v.008H15.75V13.5ZM8.25 6h7.5v2.25h-7.5V6ZM12 2.25c-1.892 0-3.758.11-5.593.322C5.307 2.7 4.5 3.65 4.5 4.757V19.5a2.25 2.25 0 0 0 2.25 2.25h10.5a2.25 2.25 0 0 0 2.25-2.25V4.757c0-1.108-.806-2.057-1.907-2.185A48.507 48.507 0 0 0 12 2.25Z" />
                    </svg>
                    Open Full Calculator
                </a>

                <a href="{{ locale_path('/vat-calculator/' . $countryObject->slug) }}"
                   class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm font-semibold text-gray-700 hover:bg-gray-50 hover:border-gray-300 shadow-sm transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
                    </svg>
                    {{ $countryObject->name }} VAT Guide
                </a>
            </div>

            {{-- Rate switcher --}}
            @if(count($countryRates) > 0)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5">
                    <h3 class="font-bold text-gray-900 text-sm mb-3">All {{ $countryObject->name }} VAT Rates</h3>
                    <div class="space-y-2">
                        @foreach($countryRates as $r)
                            <a href="{{ locale_path('/vat-calculation/' . $country . '/' . $amount . '/' . $r['value'] . '/' . $mode) }}"
                               class="flex items-center justify-between px-4 py-2.5 rounded-xl border text-sm font-semibold transition-all
                                   {{ abs($r['value'] - $rate) < 0.01
                                       ? 'bg-blue-600 border-blue-600 text-white shadow-md'
                                       : 'bg-gray-50 border-gray-200 text-gray-700 hover:border-blue-300 hover:bg-blue-50' }}">
                                <span>{{ $r['name'] }}</span>
                                <span>{{ $r['value'] }}%</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Mode switcher --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5">
                <h3 class="font-bold text-gray-900 text-sm mb-3">Switch Mode</h3>
                <div class="space-y-2">
                    <a href="{{ locale_path('/vat-calculation/' . $country . '/' . $amount . '/' . $rate . '/exclude') }}"
                       class="flex items-center gap-3 px-4 py-2.5 rounded-xl border text-sm font-semibold transition-all
                           {{ $mode === 'exclude'
                               ? 'bg-emerald-50 border-emerald-300 text-emerald-700'
                               : 'bg-gray-50 border-gray-200 text-gray-700 hover:border-emerald-300 hover:bg-emerald-50' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                        Add VAT to amount
                    </a>
                    <a href="{{ locale_path('/vat-calculation/' . $country . '/' . $amount . '/' . $rate . '/include') }}"
                       class="flex items-center gap-3 px-4 py-2.5 rounded-xl border text-sm font-semibold transition-all
                           {{ $mode === 'include'
                               ? 'bg-amber-50 border-amber-300 text-amber-700'
                               : 'bg-gray-50 border-gray-200 text-gray-700 hover:border-amber-300 hover:bg-amber-50' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" /></svg>
                        Remove VAT from amount
                    </a>
                </div>
            </div>

            {{-- Top calculations link --}}
            <a href="{{ locale_path('/top-vat-calculations') }}" class="block bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl border border-blue-200 p-5 hover:border-blue-300 hover:shadow-sm transition-all group">
                <h3 class="font-bold text-blue-900 text-sm flex items-center gap-2 mb-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                    </svg>
                    Popular VAT Calculations
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 ml-auto text-blue-400 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                </h3>
                <p class="text-xs text-blue-700/70">Browse the most common VAT calculations across all EU countries</p>
            </a>
        </div>
    </div>

    {{-- Disclaimer --}}
    <div class="text-center text-xs text-gray-400 max-w-2xl mx-auto">
        <p>This calculation is for informational purposes only. VAT rates are sourced from the European Commission and may change.
        Always verify with your local tax authority for official compliance. Calculated on {{ now()->format('F j, Y \a\t H:i') }} UTC.</p>
    </div>
</div>
