<div class="w-full" x-data="{ mode: $wire.entangle('mode') }">
    {{-- Hero Header (hideable when embedded in other pages) --}}
    @if($showHeader)
    <div class="text-center mb-8 sm:mb-10">
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-gray-900 tracking-tight mb-3">
            <span class="text-blue-600">EU VAT</span> Calculator
        </h1>
        <p class="text-base sm:text-lg text-gray-500 max-w-2xl mx-auto leading-relaxed">
            Calculate VAT instantly for all 27 EU member states. Add or extract VAT with real-time rates.
        </p>
    </div>
    @endif

    {{-- Mode Tabs --}}
    <div class="max-w-4xl mx-auto mb-0">
        <div class="flex items-center bg-white rounded-t-2xl border border-b-0 border-gray-200 px-1 pt-1 overflow-x-auto">
            <div class="relative flex p-1 gap-0 bg-gray-100 rounded-xl">
                {{-- Sliding background indicator --}}
                <div class="absolute top-1 bottom-1 rounded-lg bg-gray-800 shadow-md transition-all duration-300 ease-out"
                     :style="'width: calc(50% - 4px); ' + (mode === 'include' ? 'left: calc(50% + 2px)' : 'left: 2px')"></div>

                <button
                    type="button"
                    @click="mode = 'exclude'"
                    class="relative z-10 flex items-center gap-2 px-6 py-3 rounded-lg text-sm font-bold transition-colors duration-300 whitespace-nowrap"
                    :class="mode === 'exclude' ? 'text-white' : 'text-gray-500 hover:text-gray-700'"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Add VAT
                </button>
                <button
                    type="button"
                    @click="mode = 'include'"
                    class="relative z-10 flex items-center gap-2 px-6 py-3 rounded-lg text-sm font-bold transition-colors duration-300 whitespace-nowrap"
                    :class="mode === 'include' ? 'text-white' : 'text-gray-500 hover:text-gray-700'"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                    </svg>
                    Remove VAT
                </button>
            </div>
            <div class="ml-auto hidden sm:flex items-center gap-3 pr-3 text-xs text-gray-400">
                <span class="flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    Real-time rates
                </span>
                <span class="flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                    </svg>
                    Official EU data
                </span>
            </div>
        </div>
    </div>

    {{-- Calculator Bar --}}
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-b-2xl shadow-xl border border-t-0 border-gray-200 overflow-hidden">
            {{-- Row 1: Country + Amount + Calculate --}}
            <div class="p-4 sm:p-5 pb-0 sm:pb-0">
                <div class="flex flex-col sm:flex-row gap-3">
                    {{-- Country Selector --}}
                    <div class="sm:w-[280px] shrink-0"
                         x-data="{
                            open: false,
                            search: '',
                            get filtered() {
                                if (!this.search) return $wire.countries;
                                const q = this.search.toLowerCase();
                                return $wire.countries.filter(c => c.name.toLowerCase().includes(q));
                            },
                            select(slug) {
                                $wire.set('selectedCountrySlug', slug);
                                this.open = false;
                                this.search = '';
                            },
                            get current() {
                                return $wire.countries.find(c => c.slug === $wire.selectedCountrySlug);
                            }
                         }"
                         @click.outside="open = false"
                         @keydown.escape.window="open = false"
                    >
                        <label class="block text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1.5 pl-1">Country</label>
                        <div class="relative">
                            {{-- Trigger button --}}
                            <button
                                type="button"
                                @click="open = !open; $nextTick(() => open && $refs.searchInput.focus())"
                                class="w-full flex items-center gap-2.5 bg-gray-50 border border-gray-200 rounded-xl pl-3 pr-10 py-3.5 text-sm font-medium text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hover:border-gray-300 transition-all cursor-pointer text-left h-[50px]"
                            >
                                <template x-if="current">
                                    <img :src="'https://flagcdn.com/h40/' + current.iso + '.jpg'" :alt="current.name" class="h-5 w-auto rounded-sm shadow-sm shrink-0">
                                </template>
                                <span class="truncate" x-text="current ? current.name + ' (' + current.standard_rate + '%)' : 'Select country'"></span>
                            </button>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                                <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>

                            {{-- Dropdown --}}
                            <div x-show="open"
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 -translate-y-1"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 -translate-y-1"
                                 class="absolute z-50 mt-1.5 w-full bg-white rounded-xl border border-gray-200 shadow-2xl overflow-hidden"
                                 style="display: none;"
                            >
                                {{-- Search --}}
                                <div class="p-2 border-b border-gray-100">
                                    <div class="relative">
                                        <svg class="absolute left-2.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                        </svg>
                                        <input
                                            x-ref="searchInput"
                                            x-model="search"
                                            type="text"
                                            placeholder="Search countries..."
                                            class="w-full pl-8 pr-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50"
                                            @keydown.enter.prevent="if(filtered.length === 1) select(filtered[0].slug)"
                                        >
                                    </div>
                                </div>
                                {{-- Options --}}
                                <div class="max-h-[240px] overflow-y-auto overscroll-contain">
                                    <template x-for="c in filtered" :key="c.slug">
                                        <button
                                            type="button"
                                            @click="select(c.slug)"
                                            class="w-full flex items-center gap-2.5 px-3 py-2.5 text-sm text-left transition-colors"
                                            :class="c.slug === $wire.selectedCountrySlug ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50'"
                                        >
                                            <img :src="'https://flagcdn.com/h40/' + c.iso + '.jpg'" :alt="c.name" class="h-4 w-auto rounded-[2px] shadow-sm shrink-0" loading="lazy">
                                            <span x-text="c.name" class="truncate"></span>
                                            <span class="ml-auto text-xs text-gray-400 tabular-nums shrink-0" x-text="c.standard_rate + '%'"></span>
                                            <svg x-show="c.slug === $wire.selectedCountrySlug" class="w-4 h-4 text-blue-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </template>
                                    <div x-show="filtered.length === 0" class="px-3 py-4 text-center text-sm text-gray-400">
                                        No countries found
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Amount Input --}}
                    <div class="flex-1 min-w-0">
                        <label class="block text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1.5 pl-1">
                            <span x-text="mode === 'include' ? 'Amount (incl. VAT)' : 'Amount (excl. VAT)'"></span>
                        </label>
                        <div class="relative">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-semibold text-base">
                                {{ $selectedCountryObject?->currency_display ?? '€' }}
                            </div>
                            <input
                                wire:model.live.debounce.300ms="amount"
                                type="text"
                                inputmode="decimal"
                                placeholder="0.00"
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-10 pr-4 py-3.5 text-base font-bold text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hover:border-gray-300 transition-all tabular-nums tracking-tight h-[50px]"
                            >
                        </div>
                    </div>

                    {{-- Calculate Button --}}
                    <div class="shrink-0 flex items-end">
                        <button
                            wire:click="calculate"
                            class="w-full sm:w-auto px-10 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-bold rounded-xl shadow-lg shadow-blue-600/25 hover:shadow-xl hover:shadow-blue-600/30 active:scale-[0.98] transition-all duration-150 flex items-center justify-center gap-2 text-base whitespace-nowrap h-[50px]"
                        >
                            <svg wire:loading.remove wire:target="calculate" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V13.5Zm0 2.25h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V18Zm2.498-6.75h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V13.5Zm0 2.25h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V18Zm2.504-6.75h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V13.5Zm0 2.25h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V18Zm2.498-6.75h.008v.008H15.75v-.008Zm0 2.25h.008v.008H15.75V13.5ZM8.25 6h7.5v2.25h-7.5V6ZM12 2.25c-1.892 0-3.758.11-5.593.322C5.307 2.7 4.5 3.65 4.5 4.757V19.5a2.25 2.25 0 0 0 2.25 2.25h10.5a2.25 2.25 0 0 0 2.25-2.25V4.757c0-1.108-.806-2.057-1.907-2.185A48.507 48.507 0 0 0 12 2.25Z" />
                            </svg>
                            <svg wire:loading wire:target="calculate" class="animate-spin w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Calculate
                        </button>
                    </div>
                </div>
            </div>

            {{-- Row 2: Rate pills --}}
            <div class="px-4 sm:px-5 py-3 border-t border-gray-100 bg-gray-50/50">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mr-1">Rate</span>
                    @foreach($rates as $rate)
                        <button
                            wire:click="selectRate({{ $rate['value'] }})"
                            class="relative px-3.5 py-2 rounded-lg text-sm font-semibold border transition-all duration-200
                                {{ !$useCustomRate && $selectedRate == $rate['value']
                                    ? 'bg-blue-50 border-blue-300 text-blue-700 ring-1 ring-blue-200'
                                    : 'bg-white border-gray-200 text-gray-600 hover:border-gray-300 hover:text-gray-800' }}"
                        >
                            <span class="text-[10px] font-medium {{ !$useCustomRate && $selectedRate == $rate['value'] ? 'text-blue-400' : 'text-gray-400' }}">{{ $rate['name'] }}</span>
                            {{ $rate['value'] }}%
                        </button>
                    @endforeach

                    {{-- Custom Rate --}}
                    @if($useCustomRate)
                        <div class="flex items-center gap-1 px-3 py-1.5 rounded-lg border-2 border-amber-400 bg-amber-50 text-amber-700">
                            <span class="text-[10px] font-medium text-amber-500">Custom</span>
                            <input
                                type="number"
                                wire:model.live.debounce.300ms="customRate"
                                step="0.1"
                                min="0"
                                max="100"
                                placeholder="0"
                                autofocus
                                @click.stop
                                class="w-14 px-1.5 py-0.5 text-sm font-semibold border border-amber-300 rounded bg-white focus:ring-1 focus:ring-amber-500 text-center"
                            >
                            <span class="text-xs font-semibold">%</span>
                        </div>
                    @else
                        <button
                            wire:click="enableCustomRate"
                            class="px-3.5 py-2 rounded-lg text-sm font-semibold border border-dashed border-gray-300 text-gray-400 hover:border-amber-300 hover:text-amber-600 hover:bg-amber-50 transition-all duration-200"
                        >
                            Custom %
                        </button>
                    @endif
                </div>
            </div>

            {{-- Results Panel --}}
            @if($showResults && $total > 0 && !$error_message)
                <div class="border-t border-gray-100 bg-gradient-to-r from-gray-50 to-blue-50/30" wire:transition>
                    <div class="p-4 sm:p-5">
                        {{-- Context sentence with flag --}}
                        <div class="flex items-center gap-2 mb-4 text-sm text-gray-500">
                            <img src="https://flagcdn.com/h40/{{ strtolower($selectedCountryObject?->iso_code ?? 'de') }}.jpg"
                                 alt="{{ $selectedCountryObject?->name ?? '' }}"
                                 class="h-4 w-auto rounded-[2px] shadow-sm">
                            @if($mode === 'exclude')
                                <span>{{ $selectedCountryObject?->currency_display ?? '€' }}{{ number_format(floatval($amount ?: 0), 2) }} + {{ $selectedRate }}% VAT in <strong class="text-gray-700">{{ $selectedCountryObject?->name ?? '' }}</strong></span>
                            @else
                                <span>{{ $selectedCountryObject?->currency_display ?? '€' }}{{ number_format(floatval($amount ?: 0), 2) }} including {{ $selectedRate }}% VAT in <strong class="text-gray-700">{{ $selectedCountryObject?->name ?? '' }}</strong></span>
                            @endif
                        </div>

                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
                            {{-- Net Amount --}}
                            <div class="flex-1 text-center sm:text-left">
                                <div class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Net Amount</div>
                                <div class="text-2xl sm:text-3xl font-bold text-gray-900 tabular-nums">
                                    {{ $selectedCountryObject?->currency_display ?? '€' }}{{ number_format($net_amount, 2) }}
                                </div>
                            </div>

                            {{-- Arrow / Plus / Minus --}}
                            <div class="hidden sm:flex items-center justify-center w-10">
                                <div class="w-8 h-8 rounded-full {{ $mode === 'exclude' ? 'bg-blue-100 text-blue-600' : 'bg-red-100 text-red-600' }} flex items-center justify-center">
                                    @if($mode === 'exclude')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                                        </svg>
                                    @endif
                                </div>
                            </div>

                            {{-- VAT Amount --}}
                            <div class="flex-1 text-center">
                                <div class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">VAT ({{ $selectedRate }}%)</div>
                                <div class="text-2xl sm:text-3xl font-bold {{ $mode === 'exclude' ? 'text-blue-600' : 'text-red-600' }} tabular-nums">
                                    {{ $mode === 'exclude' ? '+' : '-' }}{{ $selectedCountryObject?->currency_display ?? '€' }}{{ number_format($vat_amount, 2) }}
                                </div>
                            </div>

                            {{-- Equals --}}
                            <div class="hidden sm:flex items-center justify-center w-10">
                                <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center font-bold text-sm">=</div>
                            </div>

                            {{-- Total --}}
                            <div class="flex-1 text-center sm:text-right">
                                <div class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">
                                    {{ $mode === 'exclude' ? 'Total (incl. VAT)' : 'You entered (incl. VAT)' }}
                                </div>
                                <div class="text-2xl sm:text-3xl font-extrabold text-gray-900 tabular-nums">
                                    {{ $selectedCountryObject?->currency_display ?? '€' }}{{ number_format($total, 2) }}
                                </div>
                            </div>

                            {{-- CTA --}}
                            <div class="flex flex-col gap-2 sm:pl-4 sm:border-l border-gray-200">
                                <a href="{{ locale_path('/calculation?country=' . $selectedCountrySlug . '&amount=' . $amount . '&rate=' . $selectedRate . '&mode=' . $mode) }}"
                                   class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 bg-gray-800 hover:bg-gray-900 text-white rounded-lg text-xs font-semibold shadow-sm transition-all duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" />
                                    </svg>
                                    Share &amp; Details
                                </a>
                                <a href="{{ locale_path('/vat-calculator/' . $selectedCountrySlug) }}" wire:navigate
                                   class="inline-flex items-center justify-center gap-1.5 px-4 py-2 text-xs font-medium text-gray-500 hover:text-blue-600 transition-colors duration-200">
                                    Full Calculator
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        {{-- Mobile-only divider with formula --}}
                        <div class="sm:hidden mt-3 pt-3 border-t border-gray-200 text-center text-xs text-gray-400">
                            @if($mode === 'exclude')
                                {{ $selectedCountryObject?->currency_display ?? '€' }}{{ number_format($net_amount, 2) }} + {{ $selectedRate }}% VAT = {{ $selectedCountryObject?->currency_display ?? '€' }}{{ number_format($total, 2) }}
                            @else
                                {{ $selectedCountryObject?->currency_display ?? '€' }}{{ number_format($total, 2) }} − {{ $selectedRate }}% VAT = {{ $selectedCountryObject?->currency_display ?? '€' }}{{ number_format($net_amount, 2) }}
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            {{-- Error --}}
            @if($error_message)
                <div class="border-t border-red-100 bg-red-50 px-5 py-3">
                    <p class="text-sm text-red-600 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        {{ $error_message }}
                    </p>
                </div>
            @endif
        </div>
    </div>

    {{-- Quick Stats --}}
    <div class="max-w-4xl mx-auto mt-4 flex flex-wrap items-center justify-center gap-x-6 gap-y-2 text-xs font-medium text-gray-700">
        <span class="flex items-center gap-1.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
            </svg>
            27 EU Countries
        </span>
        <span class="flex items-center gap-1.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            100% Free
        </span>
        <span class="flex items-center gap-1.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
            </svg>
            No Sign-up Required
        </span>
    </div>

    {{-- Calculation History --}}
    @if(count($history) > 0)
        <div class="max-w-4xl mx-auto mt-8" x-data="{ expanded: false }">
            <div class="flex items-center justify-between mb-3">
                <h3 class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    Recent Calculations
                    <span class="bg-gray-200 text-gray-600 text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ count($history) }}</span>
                </h3>
                <button
                    wire:click="clearHistory"
                    class="text-xs text-gray-400 hover:text-red-500 transition-colors"
                >
                    Clear all
                </button>
            </div>

            {{-- Cards grid: first row always visible --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach($history as $index => $entry)
                    <button
                        wire:click="loadFromHistory({{ $index }})"
                        class="{{ $index >= 3 ? 'hidden' : '' }}"
                        :class="{ '!hidden': {{ $index }} >= 3 && !expanded, '!block': {{ $index }} >= 3 && expanded }"
                    >
                        <div class="bg-white rounded-xl border border-gray-200 p-3.5 hover:border-blue-300 hover:shadow-md transition-all duration-200 cursor-pointer group text-left h-full">
                            <div class="flex items-center gap-2.5 mb-2.5">
                                <img src="https://flagcdn.com/h40/{{ $entry['flag_iso'] }}.jpg"
                                    alt="" class="h-5 w-auto rounded-sm shadow-sm shrink-0" loading="lazy">
                                <span class="text-sm font-semibold text-gray-900 truncate">{{ $entry['country'] }}</span>
                                <span class="ml-auto text-[10px] font-medium px-1.5 py-0.5 rounded {{ $entry['mode'] === 'exclude' ? 'bg-blue-50 text-blue-600' : 'bg-red-50 text-red-600' }}">
                                    {{ $entry['mode'] === 'exclude' ? '+ VAT' : '− VAT' }}
                                </span>
                            </div>
                            <div class="flex items-baseline justify-between">
                                <div>
                                    <div class="text-lg font-bold text-gray-900 tabular-nums leading-tight">
                                        {{ $entry['currency'] }}{{ number_format($entry['total'], 2) }}
                                    </div>
                                    <div class="text-[11px] {{ $entry['mode'] === 'exclude' ? 'text-blue-500' : 'text-red-500' }} font-medium tabular-nums mt-0.5">
                                        {{ $entry['mode'] === 'exclude' ? '+' : '−' }}{{ $entry['currency'] }}{{ number_format($entry['vat'], 2) }} at {{ $entry['rate'] }}%
                                    </div>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-300 group-hover:text-blue-500 transition-colors shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182" />
                                </svg>
                            </div>
                        </div>
                    </button>
                @endforeach
            </div>

            {{-- Show more / less toggle --}}
            @if(count($history) > 3)
                <div class="text-center mt-3">
                    <button
                        @click="expanded = !expanded"
                        class="inline-flex items-center gap-1.5 text-xs font-medium text-gray-500 hover:text-gray-800 transition-colors"
                    >
                        <span x-text="expanded ? 'Show less' : 'Show {{ count($history) - 3 }} more'"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 transition-transform duration-200" :class="expanded ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                </div>
            @endif
        </div>
    @endif
</div>
