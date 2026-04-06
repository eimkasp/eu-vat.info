@section('seo')
    <x-seo-meta
        :title="$countryObject
            ? __('ui.vies_page.country_title', ['country' => $countryObject->name])
            : __('ui.vies_page.title')"
        :description="$countryObject
            ? __('ui.vies_page.country_description', ['country' => $countryObject->name, 'code' => $countryObject->iso_code])
            : __('ui.vies_page.description')"
        type="website"
    />
@endsection

<div class="mx-auto max-w-5xl px-4 py-8 sm:py-12">

    {{-- Breadcrumbs --}}
    <nav class="flex items-center gap-1.5 text-sm text-gray-400 mb-8 flex-wrap" aria-label="Breadcrumb">
        <a href="{{ locale_path('/') }}" class="hover:text-blue-600 transition-colors">{{ __('ui.home') }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
        <a href="{{ locale_path('/vat-number-validator') }}" class="hover:text-blue-600 transition-colors">{{ __('ui.vies_page.nav_title') }}</a>
        @if($countryObject)
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
            <span class="text-gray-600 font-medium">{{ $countryObject->name }}</span>
        @endif
    </nav>

    {{-- Hero --}}
    <div class="relative overflow-visible rounded-2xl bg-gradient-to-br from-indigo-900 via-indigo-800 to-indigo-900 text-white mb-8">
        <div class="absolute inset-0 opacity-5">
            <svg width="100%" height="100%"><defs><pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="0.5"/></pattern></defs><rect width="100%" height="100%" fill="url(#grid)"/></svg>
        </div>

        <div class="relative p-6 sm:p-10">
            <h1 class="text-2xl sm:text-3xl font-extrabold mb-2">
                @if($countryObject)
                    {{ __('ui.vies_page.country_h1', ['country' => $countryObject->name]) }}
                @else
                    {{ __('ui.vies_page.h1') }}
                @endif
            </h1>
            <p class="text-indigo-200 text-sm mb-6">
                @if($countryObject)
                    {{ __('ui.vies_page.country_subtitle', ['country' => $countryObject->name, 'code' => $countryObject->iso_code]) }}
                @else
                    {{ __('ui.vies_page.subtitle') }}
                @endif
            </p>

            <form wire:submit.prevent="validateVat" class="space-y-4">
                <div class="grid sm:grid-cols-12 gap-4">
                    {{-- VAT Number (first, wider) --}}
                    <div class="sm:col-span-5">
                        <label class="block text-xs font-semibold text-indigo-200 mb-1.5">{{ __('ui.vies_page.vat_number_label') }}</label>
                        <input type="text" wire:model.blur="vat_number" placeholder="{{ __('ui.vies_page.vat_placeholder') }}" class="w-full rounded-xl bg-white/10 border border-white/20 text-white placeholder-indigo-300/50 px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-400 focus:border-transparent">
                    </div>

                    {{-- Country Selector (searchable with flags) --}}
                    <div class="sm:col-span-5"
                         x-data="{
                            open: false,
                            search: '',
                            countries: @js($countries->map(fn($c) => ['iso' => $c->iso_code, 'name' => $c->name, 'slug' => $c->slug, 'flag' => strtolower($c->iso_code)])->values()),
                            get filtered() {
                                if (!this.search) return this.countries;
                                const q = this.search.toLowerCase();
                                return this.countries.filter(c => c.name.toLowerCase().includes(q) || c.iso.toLowerCase().includes(q));
                            },
                            get current() {
                                return this.countries.find(c => c.iso === $wire.country_code);
                            },
                            select(iso) {
                                $wire.set('country_code', iso);
                                this.open = false;
                                this.search = '';
                            }
                         }"
                         @click.outside="open = false"
                         @keydown.escape.window="open = false"
                    >
                        <label class="block text-xs font-semibold text-indigo-200 mb-1.5">{{ __('ui.vies_page.country_label') }}</label>
                        <div class="relative">
                            <button type="button"
                                    @click="open = !open; $nextTick(() => open && $refs.searchInput.focus())"
                                    class="w-full flex items-center gap-2.5 bg-white/10 border border-white/20 rounded-xl pl-3 pr-10 py-3 text-sm font-medium text-white focus:ring-2 focus:ring-indigo-400 focus:border-transparent hover:bg-white/15 transition-all cursor-pointer text-left h-[46px]"
                                    aria-haspopup="listbox" :aria-expanded="open.toString()">
                                <template x-if="current">
                                    <img :src="'https://flagcdn.com/h40/' + current.flag + '.jpg'" :alt="current.name" class="h-4 w-auto rounded-sm shadow-sm shrink-0">
                                </template>
                                <span class="truncate" x-text="current ? current.name : '{{ __('ui.vies_page.select_country') }}'"></span>
                            </button>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-indigo-300">
                                <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </div>

                            <div x-show="open" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 -translate-y-1"
                                 class="absolute z-50 mt-1.5 w-full bg-white rounded-xl border border-gray-200 shadow-2xl overflow-hidden" style="display: none;">
                                <div class="p-2 border-b border-gray-100">
                                    <div class="relative">
                                        <svg class="absolute left-2.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                                        <input x-ref="searchInput" x-model="search" type="text" placeholder="{{ __('ui.vies_page.search_countries') }}" class="w-full pl-8 pr-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-gray-50 text-gray-900"
                                               @keydown.enter.prevent="if(filtered.length === 1) select(filtered[0].iso)">
                                    </div>
                                </div>
                                <div class="max-h-[240px] overflow-y-auto overscroll-contain" role="listbox">
                                    <template x-for="c in filtered" :key="c.iso">
                                        <button type="button" role="option" :aria-selected="(c.iso === $wire.country_code).toString()" @click="select(c.iso)"
                                                class="w-full flex items-center gap-2.5 px-3 py-2.5 text-sm text-left transition-colors"
                                                :class="c.iso === $wire.country_code ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-700 hover:bg-gray-50'">
                                            <img :src="'https://flagcdn.com/h40/' + c.flag + '.jpg'" :alt="c.name" class="h-4 w-auto rounded-[2px] shadow-sm shrink-0" loading="lazy">
                                            <span x-text="c.name" class="truncate"></span>
                                            <span class="ml-auto text-xs text-gray-400 shrink-0" x-text="c.iso"></span>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Validate button --}}
                    <div class="sm:col-span-2 flex items-end">
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-white text-indigo-900 rounded-xl text-sm font-bold hover:bg-indigo-50 transition-all shadow-lg" wire:loading.class="opacity-50" wire:target="validateVat">
                            <svg wire:loading.remove wire:target="validateVat" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                            <svg wire:loading wire:target="validateVat" class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                            {{ __('ui.vies_page.validate_btn') }}
                        </button>
                    </div>
                </div>
                <p class="text-xs text-indigo-300/70">
                    {{ __('ui.vies_page.auto_detect_hint') }}
                    <button type="button" wire:click="prefillExample" class="text-indigo-200 hover:text-white underline">{{ __('ui.vies_page.try_example') }}</button>
                </p>
            </form>
        </div>
    </div>

    {{-- Error --}}
    @if($error)
        <div role="alert" class="mb-6 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl text-sm flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" /></svg>
            {{ $error }}
        </div>
    @endif

    {{-- Result --}}
    @if($result)
        <div class="mb-8 bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden" wire:transition
             x-init="$dispatch('validation-complete', { cc: '{{ $result['country_code'] }}', vn: '{{ $result['vat_number'] }}', valid: {{ $result['valid'] ? 'true' : 'false' }}, name: {{ json_encode($result['name']) }} })">
            <div class="px-6 py-4 border-b {{ $result['valid'] ? 'bg-emerald-50 border-emerald-200' : 'bg-red-50 border-red-200' }}">
                <div class="flex items-center gap-2">
                    @if($result['valid'])
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                        <h2 class="text-lg font-bold text-emerald-800">Valid VAT Number</h2>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                        <h2 class="text-lg font-bold text-red-800">Invalid VAT Number</h2>
                    @endif
                </div>
            </div>

            <table class="w-full text-sm">
                <tbody class="divide-y divide-gray-100">
                    <tr>
                        <td class="px-6 py-3.5 text-gray-500 w-1/3">VAT Number</td>
                        <td class="px-6 py-3.5 font-semibold text-gray-900 font-mono">{{ $result['country_code'] }}{{ $result['vat_number'] }}</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-3.5 text-gray-500">Country</td>
                        <td class="px-6 py-3.5 font-semibold text-gray-900">
                            @php $countryObj = $countries->firstWhere('iso_code', $result['country_code']); @endphp
                            @if($countryObj)
                                <a href="{{ locale_path('/vat-calculator/' . $countryObj->slug) }}" class="inline-flex items-center gap-2 hover:text-blue-600 transition-colors">
                                    <img src="https://flagcdn.com/h40/{{ strtolower($result['country_code']) }}.jpg" alt="" class="h-4 w-auto rounded-sm" loading="lazy">
                                    {{ $countryObj->name }}
                                </a>
                            @else
                                {{ $result['country_code'] }}
                            @endif
                        </td>
                    </tr>
                    @if($result['valid'])
                        <tr>
                            <td class="px-6 py-3.5 text-gray-500">Company Name</td>
                            <td class="px-6 py-3.5 font-semibold text-gray-900">{{ $result['name'] }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3.5 text-gray-500">Address</td>
                            <td class="px-6 py-3.5 text-gray-900">{{ $result['address'] }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td class="px-6 py-3.5 text-gray-500">Status</td>
                        <td class="px-6 py-3.5">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold {{ $result['valid'] ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                {{ $result['valid'] ? 'Active' : 'Invalid / Inactive' }}
                            </span>
                        </td>
                    </tr>
                    @if($result['request_identifier'])
                        <tr>
                            <td class="px-6 py-3.5 text-gray-500">Request ID</td>
                            <td class="px-6 py-3.5 text-gray-400 font-mono text-xs">{{ $result['request_identifier'] }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td class="px-6 py-3.5 text-gray-500">Data Source</td>
                        <td class="px-6 py-3.5 text-gray-400 text-xs">
                            @if($result['source'] === 'cache' || $result['source'] === 'database')
                                <span class="inline-flex items-center gap-1 text-amber-600"><svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" /></svg> Cached result (fast)</span>
                            @else
                                <span class="inline-flex items-center gap-1 text-indigo-600"><svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" /></svg> Live VIES API</span>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>

            @if($validationCount > 1)
                <div class="px-6 py-3 bg-gray-50 border-t border-gray-100 text-xs text-gray-500">
                    This VAT number has been checked {{ $validationCount }} times on our platform.
                </div>
            @endif
        </div>
    @endif

    {{-- Two-column layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="lg:col-span-2 space-y-6">
            {{-- API section --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-visible"
                 x-data="{
                    simCountry: 'LT',
                    simVat: '100019070512',
                    loading: false,
                    response: null,
                    error: null,
                    elapsed: null,
                    async runRequest() {
                        this.loading = true;
                        this.response = null;
                        this.error = null;
                        this.elapsed = null;
                        const t0 = performance.now();
                        try {
                            const res = await fetch('/api/vat/validation/validate', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                                body: JSON.stringify({ country_code: this.simCountry, vat_number: this.simVat })
                            });
                            const json = await res.json();
                            this.elapsed = Math.round(performance.now() - t0);
                            if (!res.ok) {
                                this.error = JSON.stringify(json, null, 2);
                            } else {
                                this.response = JSON.stringify(json, null, 2);
                            }
                        } catch(e) {
                            this.error = e.message;
                        }
                        this.loading = false;
                    },
                    get requestBody() {
                        return JSON.stringify({ country_code: this.simCountry, vat_number: this.simVat }, null, 2);
                    }
                 }">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="font-semibold text-sm text-gray-900 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5" /></svg>
                        VAT Validation API
                    </h2>
                    <a href="{{ locale_path('/vat-validation-api') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition-colors">
                        Full API Docs
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
                <div class="p-6 space-y-5">
                    {{-- Production endpoint --}}
                    <div class="bg-gray-50 rounded-xl border border-gray-200 p-4">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Production Endpoint</p>
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="inline-block bg-indigo-100 text-indigo-700 text-xs font-bold px-2 py-0.5 rounded">POST</span>
                            <code class="text-sm font-mono text-gray-800 break-all">https://vat.businesspress.io/api/vat/validation/validate</code>
                            <button onclick="navigator.clipboard.writeText('https://vat.businesspress.io/api/vat/validation/validate')"
                                    class="shrink-0 p-1.5 rounded-lg bg-white border border-gray-200 hover:bg-gray-100 text-gray-500 transition-colors" title="Copy URL">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            </button>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">No API key required · JSON body · Free to use</p>
                    </div>

                    {{-- Interactive Simulator --}}
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Try It Live</p>
                        <div class="grid sm:grid-cols-2 gap-3 mb-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">country_code</label>
                                <input x-model="simCountry" type="text" maxlength="2" placeholder="LT"
                                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg font-mono focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 uppercase bg-gray-50">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">vat_number</label>
                                <input x-model="simVat" type="text" placeholder="100019070512"
                                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg font-mono focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 bg-gray-50"
                                       @keydown.enter="runRequest()">
                            </div>
                        </div>

                        {{-- Request preview --}}
                        <div class="bg-gray-900 rounded-t-xl overflow-hidden">
                            <div class="flex items-center justify-between px-4 py-2 border-b border-gray-700">
                                <div class="flex items-center gap-2 text-xs text-gray-400">
                                    <span class="text-emerald-400 font-mono font-semibold">POST</span>
                                    <span class="font-mono">/api/vat/validation/validate</span>
                                </div>
                                <button @click="runRequest()" :disabled="loading"
                                        class="flex items-center gap-1.5 bg-indigo-600 hover:bg-indigo-500 disabled:bg-gray-600 disabled:cursor-not-allowed text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">
                                    <svg x-show="!loading" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 3l14 9-14 9V3z"/></svg>
                                    <svg x-show="loading" class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                                    <span x-text="loading ? 'Sending…' : 'Send Request'"></span>
                                </button>
                            </div>
                            <pre class="p-4 text-xs font-mono text-amber-300 overflow-x-auto" x-text="requestBody"></pre>
                        </div>

                        {{-- Response --}}
                        <div class="bg-gray-950 rounded-b-xl border-t border-gray-800 min-h-[80px] overflow-hidden">
                            <div x-show="!response && !error && !loading" class="p-4 text-xs text-gray-600 font-mono">
                                // Response will appear here...
                            </div>
                            <div x-show="loading" class="p-4 text-xs text-gray-500 font-mono flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 animate-spin text-indigo-400" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                                Validating against VIES…
                            </div>
                            <div x-show="response" class="relative">
                                <div class="flex items-center justify-between px-4 py-2 border-b border-gray-800">
                                    <span class="text-xs text-emerald-400 font-semibold">200 OK</span>
                                    <div class="flex items-center gap-3">
                                        <span class="text-xs text-gray-500" x-text="elapsed ? elapsed + 'ms' : ''"></span>
                                        <button @click="navigator.clipboard.writeText(response)" class="text-gray-500 hover:text-gray-300 transition-colors" title="Copy response">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                        </button>
                                    </div>
                                </div>
                                <pre class="p-4 text-xs font-mono text-green-300 overflow-x-auto" x-text="response"></pre>
                            </div>
                            <div x-show="error" class="p-4">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-xs text-red-400 font-semibold">Error</span>
                                </div>
                                <pre class="text-xs font-mono text-red-300 overflow-x-auto" x-text="error"></pre>
                            </div>
                        </div>
                    </div>

                    <a href="{{ locale_path('/vat-validation-api') }}"
                       class="flex items-center justify-between p-3 rounded-xl bg-indigo-50 border border-indigo-200 hover:bg-indigo-100 transition-colors group">
                        <div>
                            <p class="text-sm font-semibold text-indigo-900">Full API Documentation</p>
                            <p class="text-xs text-indigo-600">Batch validation, error codes, SDK examples</p>
                        </div>
                        <svg class="w-4 h-4 text-indigo-600 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

            {{-- What is VIES --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="font-semibold text-sm text-gray-900 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" /></svg>
                        @if($countryObject)
                            {{ __('ui.vies_page.about_vat_country', ['country' => $countryObject->name]) }}
                        @else
                            {{ __('ui.vies_page.what_is_vies') }}
                        @endif
                    </h2>
                </div>
                <div class="p-6 text-sm text-gray-700 space-y-3">
                    @if($countryObject)
                        <p>{!! __('ui.vies_page.country_vies_p1', ['country' => $countryObject->name, 'code' => $countryObject->iso_code]) !!}</p>
                        <p>{!! __('ui.vies_page.country_vies_p2', ['country' => $countryObject->name, 'rate' => $countryObject->standard_rate, 'calculator_link' => '<a href="' . locale_path('/vat-calculator/' . $countryObject->slug) . '" class="text-indigo-600 hover:underline font-medium">' . __('ui.vies_page.country_calculator_link', ['country' => $countryObject->name]) . '</a>']) !!}</p>
                    @else
                        <p>{{ __('ui.vies_page.vies_p1') }}</p>
                        <p>{{ __('ui.vies_page.vies_p2') }}</p>
                        <p>{{ __('ui.vies_page.vies_p3') }}</p>
                    @endif
                </div>
            </div>

            {{-- FAQ Schema --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="font-semibold text-sm text-gray-900">Frequently Asked Questions</h2>
                </div>
                <div class="divide-y divide-gray-100" itemscope itemtype="https://schema.org/FAQPage">
                    @php
                        $faqs = [
                            ['q' => 'What is a VAT number?', 'a' => 'A VAT number (Value Added Tax identification number) is a unique identifier assigned to businesses registered for VAT in EU member states. It\'s required for intra-community trade and B2B transactions.'],
                            ['q' => 'How does VIES validation work?', 'a' => 'VIES connects to the national VAT databases of each EU country. When you submit a VAT number, the system verifies it against the relevant country\'s database and returns the registration status along with company details.'],
                            ['q' => 'Why should I validate VAT numbers?', 'a' => 'Validating VAT numbers is essential for B2B transactions within the EU. It ensures your business partner is legitimately registered for VAT, which is required to apply the reverse charge mechanism and zero-rate intra-community supplies.'],
                            ['q' => 'How often is VIES data updated?', 'a' => 'VIES data comes directly from national tax authorities and is updated in real-time. Our cached results are refreshed every 7 days to balance speed with accuracy.'],
                            ['q' => 'Can I validate VAT numbers via API?', 'a' => 'Yes! We offer a free REST API for single and batch VAT number validation. See the API documentation section above for endpoints and request formats.'],
                        ];
                    @endphp
                    @foreach($faqs as $faq)
                        <div class="px-6 py-4" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                            <h3 class="font-semibold text-gray-900 text-sm" itemprop="name">{{ $faq['q'] }}</h3>
                            <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                                <p class="mt-1.5 text-sm text-gray-600" itemprop="text">{{ $faq['a'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Recently validated (localStorage) --}}
            <div x-data="{
                history: [],
                init() {
                    try { this.history = JSON.parse(localStorage.getItem('vat_validation_history') || '[]'); } catch(e) { this.history = []; }
                },
                fill(cc, vn) {
                    $wire.set('country_code', cc);
                    $wire.set('vat_number', vn);
                },
                clear() {
                    this.history = [];
                    localStorage.removeItem('vat_validation_history');
                }
            }"
                 x-on:validation-complete.window="
                    let entry = $event.detail;
                    history = history.filter(h => !(h.cc === entry.cc && h.vn === entry.vn));
                    history.unshift(entry);
                    history = history.slice(0, 10);
                    localStorage.setItem('vat_validation_history', JSON.stringify(history));
                 "
                 x-show="history.length > 0" x-cloak
                 class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-bold text-gray-900 text-sm">Your Recent Lookups</h3>
                    <button @click="clear()" class="text-xs text-gray-400 hover:text-red-500 transition-colors">Clear</button>
                </div>
                <div class="space-y-2">
                    <template x-for="v in history" :key="v.cc + v.vn">
                        <button @click="fill(v.cc, v.vn)"
                                class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-xs hover:bg-gray-50 transition-colors text-left border border-gray-100">
                            <div>
                                <span class="font-mono font-semibold text-gray-900" x-text="v.cc + v.vn"></span>
                                <p class="text-gray-500 truncate max-w-[180px]" x-show="v.name && v.name !== 'N/A'" x-text="v.name"></p>
                            </div>
                            <span class="shrink-0 w-2 h-2 rounded-full" :class="v.valid ? 'bg-emerald-500' : 'bg-red-500'"></span>
                        </button>
                    </template>
                </div>
                <p class="mt-3 text-[10px] text-gray-400 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" /></svg>
                    Saved locally on your device only. Not shared with our servers.
                </p>
            </div>

            {{-- Country Validators --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5">
                <h3 class="font-bold text-gray-900 text-sm mb-3">{{ __('ui.vies_page.country_validators') }}</h3>
                <div class="space-y-1 max-h-64 overflow-y-auto">
                    @foreach($countries as $c)
                        <a href="{{ locale_path('/vat-number-validator/' . $c->slug) }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs transition-colors {{ $countryObject && $countryObject->id === $c->id ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-700 hover:bg-gray-50 hover:text-blue-600' }}">
                            <img src="https://flagcdn.com/h40/{{ strtolower($c->iso_code) }}.jpg" alt="" class="h-3 w-auto rounded-sm" loading="lazy">
                            {{ $c->name }}
                            <span class="ml-auto text-gray-400">{{ $c->iso_code }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Related tools --}}
            <div class="bg-gradient-to-br from-indigo-50 to-blue-50 rounded-2xl border border-indigo-200 p-5 space-y-3">
                <h3 class="font-bold text-indigo-900 text-sm">Related Tools</h3>
                <a href="{{ locale_path('/vat-calculator') }}" class="flex items-center gap-2 text-sm text-indigo-700 hover:text-indigo-900 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V13.5Zm0 2.25h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V18Zm2.498-6.75h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V13.5Zm0 2.25h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V18Zm2.504-6.75h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V13.5Zm0 2.25h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V18Zm2.498-6.75h.008v.008H15.75v-.008Zm0 2.25h.008v.008H15.75V13.5ZM8.25 6h7.5v2.25h-7.5V6ZM12 2.25c-1.892 0-3.758.11-5.593.322C5.307 2.7 4.5 3.65 4.5 4.757V19.5a2.25 2.25 0 0 0 2.25 2.25h10.5a2.25 2.25 0 0 0 2.25-2.25V4.757c0-1.108-.806-2.057-1.907-2.185A48.507 48.507 0 0 0 12 2.25Z" /></svg>
                    VAT Calculator
                </a>
                <a href="{{ locale_path('/vat-map') }}" class="flex items-center gap-2 text-sm text-indigo-700 hover:text-indigo-900 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 0 0-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0Z" /></svg>
                    EU VAT Rate Map
                </a>
                <a href="{{ locale_path('/vat-changes') }}" class="flex items-center gap-2 text-sm text-indigo-700 hover:text-indigo-900 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                    VAT Rate Changes
                </a>
            </div>
        </div>
    </div>

    {{-- Disclaimer --}}
    <div class="text-center text-xs text-gray-400 max-w-2xl mx-auto">
        <p>VAT validation results are sourced from the European Commission VIES database. While we cache results for performance, always verify critical business decisions with your local tax authority.</p>
    </div>
</div>
