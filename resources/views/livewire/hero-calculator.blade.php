<div class="w-full" x-data="{
    loadingIndex: null,
    mode: @js($mode),
    selectedRate: @js($selectedRate),
    useCustomRate: @js($useCustomRate),
    customRate: @js($customRate ?? ''),
    amount: @js($amount),
    net: @js($net_amount),
    vat: @js($vat_amount),
    total: @js($total),
    hasResults: @js($showResults && $total > 0),
    currency: @js($selectedCountryObject?->currency_display ?? '€'),
    errorMsg: @js($error_message),
    compute() {
        this.errorMsg = null;
        let amt = parseFloat(String(this.amount).replace(/[^0-9.,\-]/g, '').replace(',', '.')) || 0;
        let rate = this.useCustomRate ? (parseFloat(this.customRate) || 0) : parseFloat(this.selectedRate);
        if (amt < 0 || rate < 0) { this.errorMsg = 'Please enter a valid positive number'; return; }
        if (amt === 0) { this.net = 0; this.vat = 0; this.total = 0; return; }
        if (this.mode === 'exclude') {
            this.net = Math.round(amt * 100) / 100;
            this.vat = Math.round(amt * (rate / 100) * 100) / 100;
            this.total = Math.round((this.net + this.vat) * 100) / 100;
        } else {
            this.total = Math.round(amt * 100) / 100;
            this.net = Math.round((amt / (1 + rate / 100)) * 100) / 100;
            this.vat = Math.round((amt - this.net) * 100) / 100;
        }
        this.hasResults = true;
    },
    fmt(v) { return (parseFloat(v) || 0).toFixed(2); }
}">
    {{-- Hero Header (hideable when embedded in other pages) --}}
    @if($showHeader)
    <div class="text-center mb-8 sm:mb-10">
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-gray-900 tracking-tight mb-3">
            <span class="text-blue-600">EU</span> {{ __('ui.calculator.title') }}
        </h1>
        <p class="text-base sm:text-lg text-gray-500 max-w-2xl mx-auto leading-relaxed">
            {{ __('ui.calculator.generic_subtitle') }}
        </p>
    </div>
    @endif

    {{-- Mode Tabs --}}
    <div class="mx-auto mb-0 max-w-4xl">
        <div class="flex items-center gap-3 rounded-t-xl border border-b-0 border-line bg-white p-2">
            <div class="flex gap-1 rounded-lg bg-surface-subtle p-1">
                <button
                    type="button"
                    @click="mode = 'exclude'; compute()"
                    class="flex min-h-11 items-center gap-2 whitespace-nowrap rounded-md px-4 text-sm font-semibold transition-colors duration-150 sm:px-5"
                    :class="mode === 'exclude' ? 'bg-ink text-white' : 'text-ink-muted hover:bg-white hover:text-ink'"
                    :aria-pressed="(mode === 'exclude').toString()"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    {{ __('ui.calculator.add_vat_mode') }}
                </button>
                <button
                    type="button"
                    @click="mode = 'include'; compute()"
                    class="flex min-h-11 items-center gap-2 whitespace-nowrap rounded-md px-4 text-sm font-semibold transition-colors duration-150 sm:px-5"
                    :class="mode === 'include' ? 'bg-ink text-white' : 'text-ink-muted hover:bg-white hover:text-ink'"
                    :aria-pressed="(mode === 'include').toString()"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                    </svg>
                    {{ __('ui.calculator.remove_vat_mode') }}
                </button>
            </div>
            <div class="ml-auto hidden items-center gap-3 pr-2 text-xs font-medium text-ink-muted sm:flex">
                <span class="flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    {{ __('ui.calculator.realtime_rates') }}
                </span>
                <span class="flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                    </svg>
                    {{ __('ui.calculator.official_eu_data') }}
                </span>
            </div>
        </div>
    </div>

    {{-- Calculator Bar --}}
    <div id="hero-calculator" class="mx-auto max-w-4xl">
        <div class="relative rounded-b-xl border border-t-0 border-line bg-white shadow-workflow">
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
                                $wire.set('selectedCountrySlug', slug).then(() => {
                                    let parentData = Alpine.$data(this.$root);
                                    parentData.selectedRate = $wire.selectedRate;
                                    parentData.useCustomRate = $wire.useCustomRate;
                                    parentData.customRate = $wire.customRate || '';
                                    parentData.currency = $wire.selectedCountryObject?.currency_display || '€';
                                    parentData.compute();
                                });
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
                        <label id="country-selector-label" class="mb-1.5 block pl-0.5 text-sm font-semibold text-ink-muted sm:text-xs">{{ __('ui.calculator.country_label') }}</label>
                        <div class="relative">
                            {{-- Trigger button --}}
                            <button
                                type="button"
                                @click="open = !open; $nextTick(() => open && $refs.searchInput.focus())"
                                class="app-field flex h-12 w-full cursor-pointer items-center gap-2.5 py-3 pl-3 pr-10 text-left text-sm font-medium"
                                aria-haspopup="listbox"
                                :aria-expanded="open.toString()"
                                aria-labelledby="country-selector-label"
                            >
                                <template x-if="current">
                                    <img :src="'https://flagcdn.com/h40/' + current.iso + '.jpg'" :alt="current.name" class="h-5 w-auto rounded-sm shadow-sm shrink-0">
                                </template>
                                <span class="truncate" x-text="current ? current.name + ' (' + current.standard_rate + '%)' : '{{ __('ui.calculator.select_country') }}'"></span>
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
                                 class="absolute z-50 mt-1.5 w-full overflow-hidden rounded-lg border border-line bg-white shadow-floating"
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
                                            placeholder="{{ __('ui.calculator.search_countries') }}"
                                            class="app-field w-full py-2 pl-8 pr-3 text-sm"
                                            @keydown.enter.prevent="if(filtered.length === 1) select(filtered[0].slug)"
                                        >
                                    </div>
                                </div>
                                {{-- Options --}}
                                <div class="max-h-[240px] overflow-y-auto overscroll-contain" role="listbox" aria-labelledby="country-selector-label">
                                    <template x-for="c in filtered" :key="c.slug">
                                        <button
                                            type="button"
                                            role="option"
                                            :aria-selected="(c.slug === $wire.selectedCountrySlug).toString()"
                                            @click="select(c.slug)"
                                            class="w-full flex items-center gap-2.5 px-3 py-2.5 text-sm text-left transition-colors"
                                            :class="c.slug === $wire.selectedCountrySlug ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50'"
                                        >
                                            <img :src="'https://flagcdn.com/h40/' + c.iso + '.jpg'" :alt="c.name" class="h-4 w-auto rounded-[2px] shadow-sm shrink-0" loading="lazy">
                                            <span x-text="c.name" class="truncate"></span>
                                            <span class="ml-auto shrink-0 text-sm tabular-nums text-ink-muted sm:text-xs" x-text="c.standard_rate + '%'"></span>
                                            <svg x-show="c.slug === $wire.selectedCountrySlug" class="w-4 h-4 text-blue-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </template>
                                    <div x-show="filtered.length === 0" class="px-3 py-4 text-center text-sm text-gray-400">
                                        {{ __('ui.calculator.no_countries_found') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Amount Input --}}
                    <div class="flex-1 min-w-0">
                        <label class="mb-1.5 block pl-0.5 text-sm font-semibold text-ink-muted sm:text-xs">
                            <span x-text="mode === 'include' ? '{{ __('ui.calculator.amount_incl_vat') }}' : '{{ __('ui.calculator.amount_excl_vat') }}'"></span>
                        </label>
                        <div class="relative">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-semibold text-base" x-text="currency">
                            </div>
                            <input
                                x-model="amount"
                                @input.debounce.300ms="compute()"
                                type="text"
                                inputmode="decimal"
                                placeholder="0.00"
                                class="app-field h-12 w-full py-3 pl-10 pr-4 text-base font-bold tabular-nums tracking-tight"
                            >
                        </div>
                    </div>

                    {{-- Calculate Button --}}
                    <div class="shrink-0 flex items-end">
                        <button
                            @click="compute(); hasResults = true; $wire.calculate(mode, selectedRate, useCustomRate, customRate, amount)"
                            class="app-button-primary h-12 w-full gap-2 whitespace-nowrap px-8 text-base sm:w-auto"
                        >
                            <svg wire:loading.remove wire:target="calculate" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V13.5Zm0 2.25h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V18Zm2.498-6.75h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V13.5Zm0 2.25h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V18Zm2.504-6.75h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V13.5Zm0 2.25h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V18Zm2.498-6.75h.008v.008H15.75v-.008Zm0 2.25h.008v.008H15.75V13.5ZM8.25 6h7.5v2.25h-7.5V6ZM12 2.25c-1.892 0-3.758.11-5.593.322C5.307 2.7 4.5 3.65 4.5 4.757V19.5a2.25 2.25 0 0 0 2.25 2.25h10.5a2.25 2.25 0 0 0 2.25-2.25V4.757c0-1.108-.806-2.057-1.907-2.185A48.507 48.507 0 0 0 12 2.25Z" />
                            </svg>
                            <svg wire:loading wire:target="calculate" class="animate-spin w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            {{ __('ui.calculator.calculate_btn') }}
                        </button>
                    </div>
                </div>
            </div>

            {{-- Row 2: Rate pills --}}
            <div class="border-t border-line bg-surface-subtle px-4 py-3 sm:px-5">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="mr-1 text-sm font-semibold text-ink-muted sm:text-xs">{{ __('ui.calculator.rate_label') }}</span>
                    @foreach($rates as $rate)
                        <button
                            type="button"
                            @click="useCustomRate = false; customRate = ''; selectedRate = {{ $rate['value'] }}; compute()"
                            class="relative min-h-11 rounded-lg border px-3.5 py-2 text-sm font-semibold transition-colors duration-150"
                            :class="!useCustomRate && selectedRate == {{ $rate['value'] }}
                                ? 'bg-action-soft border-blue-300 text-action-deep'
                                : 'bg-white border-line text-ink-muted hover:border-slate-400 hover:text-ink'"
                            :aria-pressed="(!useCustomRate && selectedRate == {{ $rate['value'] }}).toString()"
                        >
                            <span class="text-sm font-medium sm:text-xs" :class="!useCustomRate && selectedRate == {{ $rate['value'] }} ? 'text-action' : 'text-ink-quiet'">{{ $rate['name'] }}</span>
                            {{ $rate['value'] }}%
                        </button>
                    @endforeach

                    {{-- Custom Rate (active state) --}}
                    <div x-show="useCustomRate" x-cloak x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="flex min-h-11 items-center gap-1 rounded-lg border border-amber-400 bg-amber-50 px-3 py-1.5 text-amber-800">
                        <span class="text-sm font-medium text-amber-700 sm:text-xs">{{ __('ui.calculator.custom_label') }}</span>
                        <input
                            x-ref="customRateInput"
                            type="number"
                            x-model="customRate"
                            @input="if (customRate !== '' && parseFloat(customRate) >= 0) { selectedRate = parseFloat(customRate); compute() }"
                            step="0.1"
                            min="0"
                            max="100"
                            placeholder="0"
                            @click.stop
                            class="w-14 rounded-md border border-amber-300 bg-white px-1.5 py-1 text-center text-sm font-semibold focus:border-amber-600 focus:ring-2 focus:ring-amber-200"
                        >
                        <span class="text-sm font-semibold">%</span>
                    </div>

                    {{-- Custom Rate (toggle button) --}}
                    <button
                        x-show="!useCustomRate"
                        type="button"
                        @click="useCustomRate = true; $nextTick(() => $refs.customRateInput.focus())"
                        class="min-h-11 rounded-lg border border-dashed border-slate-400 bg-white px-3.5 py-2 text-sm font-semibold text-ink-muted transition-colors duration-150 hover:border-amber-500 hover:bg-amber-50 hover:text-amber-800"
                    >
                        {{ __('ui.calculator.custom_percent') }}
                    </button>
                </div>
            </div>

            {{-- Results Panel --}}
                <div x-show="hasResults && total > 0 && !errorMsg" x-cloak x-transition class="rounded-b-xl border-t border-line bg-white">
                    <div class="p-4 sm:p-5">
                        {{-- Context sentence with flag --}}
                        <div class="mb-4 flex items-center gap-2 text-sm text-ink-muted">
                            <img src="https://flagcdn.com/h40/{{ strtolower($selectedCountryObject?->iso_code ?? 'de') }}.jpg"
                                 alt="{{ $selectedCountryObject?->name ?? '' }}"
                                 class="h-4 w-6 rounded-sm object-cover">
                            <template x-if="mode === 'exclude'">
                                <span x-text="currency + fmt(amount) + ' + ' + selectedRate + '% VAT in '"></span>
                            </template>
                            <template x-if="mode === 'exclude'">
                                <strong class="text-ink">{{ $selectedCountryObject?->name ?? '' }}</strong>
                            </template>
                            <template x-if="mode === 'include'">
                                <span x-text="currency + fmt(amount) + ' including ' + selectedRate + '% VAT in '"></span>
                            </template>
                            <template x-if="mode === 'include'">
                                <strong class="text-ink">{{ $selectedCountryObject?->name ?? '' }}</strong>
                            </template>
                        </div>

                        <div class="grid grid-cols-3 items-center gap-3 sm:flex sm:items-center sm:gap-4">
                            {{-- Net Amount --}}
                            <div class="flex-1 text-center sm:text-left">
                                <div class="mb-1 text-sm font-semibold text-ink-muted sm:text-xs">{{ __('ui.calculator.net_amount') }}</div>
                                <div class="text-lg font-bold tabular-nums text-ink sm:text-2xl" x-text="currency + fmt(net)">
                                </div>
                            </div>

                            {{-- Arrow / Plus / Minus --}}
                            <div class="hidden sm:flex items-center justify-center w-10">
                                <div :class="mode === 'exclude' ? 'bg-blue-100 text-blue-600' : 'bg-red-100 text-red-600'" class="w-8 h-8 rounded-full flex items-center justify-center">
                                    <template x-if="mode === 'exclude'">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                    </template>
                                    <template x-if="mode === 'include'">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                                        </svg>
                                    </template>
                                </div>
                            </div>

                            {{-- VAT Amount --}}
                            <div class="flex-1 text-center">
                                <div class="mb-1 text-sm font-semibold text-ink-muted sm:text-xs" x-text="'VAT (' + selectedRate + '%)'"></div>
                                <div :class="mode === 'exclude' ? 'text-action-deep' : 'text-red-700'" class="text-lg font-bold tabular-nums sm:text-2xl">
                                    <template x-if="mode === 'exclude'">
                                        <span x-text="'+' + currency + fmt(vat)"></span>
                                    </template>
                                    <template x-if="mode === 'include'">
                                        <span x-text="'−' + currency + fmt(vat)"></span>
                                    </template>
                                </div>
                            </div>

                            {{-- Equals --}}
                            <div class="hidden sm:flex items-center justify-center w-10">
                                <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center font-bold text-sm">=</div>
                            </div>

                            {{-- Total --}}
                            <div class="flex-1 text-center sm:text-right">
                                <div class="mb-1 text-sm font-semibold text-ink-muted sm:text-xs">
                                    <template x-if="mode === 'exclude'">
                                        <span>{{ __('ui.calculator.total_incl_vat') }}</span>
                                    </template>
                                    <template x-if="mode === 'include'">
                                        <span>{{ __('ui.calculator.you_entered_incl_vat') }}</span>
                                    </template>
                                </div>
                                <div class="text-lg font-extrabold tabular-nums text-ink sm:text-2xl" x-text="currency + fmt(total)">
                                </div>
                            </div>

                            {{-- CTA --}}
                            <div class="col-span-3 grid grid-cols-2 gap-2 border-t border-line pt-3 sm:flex sm:flex-col sm:border-l sm:border-t-0 sm:pl-4 sm:pt-0">
                                <a :href="'{{ locale_path('/vat-calculation') }}/' + $wire.selectedCountrySlug + '/' + (amount || 0) + '/' + selectedRate + '/' + mode"
                                   class="inline-flex min-h-11 items-center justify-center gap-1.5 rounded-lg bg-ink px-3 text-sm font-semibold text-white transition-colors duration-150 hover:bg-slate-900 sm:text-xs">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" />
                                    </svg>
                                    {{ __('ui.calculator.share_details') }}
                                </a>
                                <a :href="'{{ locale_path('/vat-calculator') }}/' + $wire.selectedCountrySlug"
                                   class="inline-flex min-h-11 items-center justify-center gap-1.5 rounded-lg px-3 text-sm font-semibold text-ink-muted transition-colors duration-150 hover:bg-surface-subtle hover:text-action-deep sm:text-xs">
                                    {{ __('ui.calculator.full_calculator') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        {{-- Mobile-only divider with formula --}}
                        <div class="mt-3 border-t border-line pt-3 text-center text-sm text-ink-muted sm:hidden">
                            <template x-if="mode === 'exclude'">
                                <span x-text="currency + fmt(net) + ' + ' + selectedRate + '% VAT = ' + currency + fmt(total)"></span>
                            </template>
                            <template x-if="mode === 'include'">
                                <span x-text="currency + fmt(total) + ' − ' + selectedRate + '% VAT = ' + currency + fmt(net)"></span>
                            </template>
                        </div>
                    </div>
                </div>

            {{-- Error --}}
            <div x-show="errorMsg" x-cloak class="border-t border-red-100 bg-red-50 px-5 py-3">
                <p class="text-sm text-red-600 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    <span x-text="errorMsg"></span>
                </p>
            </div>
        </div>
    </div>

    {{-- Source and freshness --}}
    <div class="mx-auto mt-4 flex max-w-4xl flex-wrap items-center justify-center gap-x-5 gap-y-2 text-sm font-medium text-blue-50 sm:text-xs">
        <span class="flex items-center gap-1.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
            </svg>
            {{ __('ui.trust.official_ec_data') }}
        </span>
        <span class="flex items-center gap-1.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-200" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            {{ __('ui.data_updated_daily') }}
        </span>
    </div>

    {{-- Calculation History --}}
    @if(count($history) > 0)
        <div class="max-w-4xl mx-auto mt-8" x-data="{ expanded: false }">
            <div class="flex items-center justify-between mb-3">
                <h3 class="flex items-center gap-2 text-sm font-semibold text-white/90">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    {{ __('ui.calculator.recent_calculations') }}
                    <span class="bg-white/20 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ count($history) }}</span>
                </h3>
                <button
                    wire:click="clearHistory"
                    class="inline-flex min-h-11 items-center rounded-md px-2 text-xs text-blue-100 transition-colors hover:bg-white/10 hover:text-white"
                >
                    {{ __('ui.calculator.clear_all') }}
                </button>
            </div>

            {{-- Cards grid: first row always visible --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach($history as $index => $entry)
                    <button
                        @click="
                            loadingIndex = {{ $index }};
                            document.getElementById('hero-calculator').scrollIntoView({ behavior: 'smooth', block: 'center' });
                            $wire.loadFromHistory({{ $index }}).then(() => {
                                mode = $wire.mode;
                                selectedRate = $wire.selectedRate;
                                useCustomRate = $wire.useCustomRate;
                                customRate = $wire.customRate || '';
                                amount = $wire.amount;
                                currency = $wire.selectedCountryObject?.currency_display || '€';
                                compute();
                                hasResults = true;
                                setTimeout(() => loadingIndex = null, 600);
                            });
                        "
                        class="{{ $index >= 3 ? 'hidden' : '' }}"
                        :class="{ '!hidden': {{ $index }} >= 3 && !expanded, '!block': {{ $index }} >= 3 && expanded }"
                    >
                        <div class="group h-full cursor-pointer rounded-xl border border-line bg-white p-3.5 text-left transition-colors duration-150 hover:border-blue-300 hover:bg-action-soft"
                             :class="loadingIndex === {{ $index }} ? 'border-action bg-action-soft ring-2 ring-blue-200' : ''">
                            <div class="flex items-center gap-2.5 mb-2.5">
                                <img src="https://flagcdn.com/h40/{{ $entry['flag_iso'] }}.jpg"
                                    alt="{{ $entry['country'] }} flag" class="h-5 w-auto rounded-sm shadow-sm shrink-0" loading="lazy">
                                <span class="text-sm font-semibold text-gray-900 truncate">{{ $entry['country'] }}</span>
                                <span class="ml-auto text-[10px] font-medium px-1.5 py-0.5 rounded {{ $entry['mode'] === 'exclude' ? 'bg-blue-50 text-blue-600' : 'bg-red-50 text-red-600' }}">
                                    {{ $entry['mode'] === 'exclude' ? __('ui.calculator.plus_vat') : __('ui.calculator.minus_vat') }}
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
                                <div class="flex items-center gap-1.5 shrink-0">
                                    <a href="{{ locale_path('/vat-calculation/' . ($entry['slug'] ?? $entry['flag_iso']) . '/' . $entry['amount'] . '/' . number_format($entry['rate'], 2, '.', '') . '/' . $entry['mode']) }}"
                                       class="text-gray-300 hover:text-blue-500 transition-colors" title="{{ __('ui.calculator.share_details') }}" @click.stop>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                                        </svg>
                                    </a>
                                    <svg x-show="loadingIndex !== {{ $index }}" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-300 group-hover:text-blue-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182" />
                                    </svg>
                                    <svg x-show="loadingIndex === {{ $index }}" class="w-4 h-4 text-blue-500 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
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
                        class="inline-flex items-center gap-1.5 text-xs font-medium text-white/80 hover:text-white transition-colors"
                    >
                        <span x-text="expanded ? '{{ __('ui.calculator.show_less') }}' : '{{ __('ui.calculator.show_more', ['count' => count($history) - 3]) }}'"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 transition-transform duration-200" :class="expanded ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                </div>
            @endif
        </div>
    @endif
</div>
