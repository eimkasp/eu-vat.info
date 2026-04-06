@section('seo')
    <x-seo-meta
        :title="__('ui.tools.seo_title')"
        :description="__('ui.tools.seo_description')"
        :url="url()->current()"
    />
@endsection

<div>
    {{-- Hero --}}
    <div class="relative bg-gradient-to-br from-[#003399] via-[#0044bb] to-[#1a5cd8] text-white overflow-hidden">
        <div class="absolute inset-0 opacity-5">
            <svg width="100%" height="100%"><defs><pattern id="tools-grid" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="0.5"/></pattern></defs><rect width="100%" height="100%" fill="url(#tools-grid)"/></svg>
        </div>
        <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-white/5 pointer-events-none"></div>
        <div class="absolute -bottom-16 -left-16 w-64 h-64 rounded-full bg-white/5 pointer-events-none"></div>

        <div class="relative container py-14 sm:py-20 px-4">
            <x-breadcrumbs :items="[__('ui.breadcrumbs.tools') => '']" variant="dark" />
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 bg-white/10 rounded-full px-3 py-1 text-xs font-semibold text-blue-100 mb-4">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Free EU VAT Tools
                </div>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold mb-4 leading-tight">{{ __('ui.tools.heading') }}</h1>
                <p class="text-blue-100 text-base sm:text-lg max-w-2xl leading-relaxed">{{ __('ui.tools.intro_text') }}</p>

                <div class="mt-8 flex flex-wrap gap-6">
                    <div class="flex items-center gap-2 text-sm text-blue-100">
                        <svg class="w-4 h-4 text-blue-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/></svg>
                        <span>27 EU Member States</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-blue-100">
                        <svg class="w-4 h-4 text-blue-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Always Up-to-Date Rates</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-blue-100">
                        <svg class="w-4 h-4 text-blue-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        <span>100% Free to Use</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-12 px-4">

        {{-- Primary Tools --}}
        <h2 class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-5">Core Tools</h2>
        <div class="grid sm:grid-cols-2 gap-5 mb-12">

            {{-- VAT Calculator --}}
            <a href="{{ locale_path('/vat-calculator') }}"
               class="group relative bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg hover:border-blue-300 dark:hover:border-blue-600 transition-all overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 rounded-full bg-blue-50 dark:bg-blue-900/10 -translate-y-12 translate-x-12 group-hover:scale-150 transition-transform duration-500 pointer-events-none"></div>
                <div class="relative">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors mb-1">{{ __('ui.tools.calculator_heading') }}</h2>
                            <span class="text-xs font-semibold text-blue-500 bg-blue-50 dark:bg-blue-900/20 px-2 py-0.5 rounded-full">Most Popular</span>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed mb-4">{{ __('ui.tools.calculator_description') }}</p>
                    <ul class="space-y-1.5">
                        <li class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400"><svg class="w-3.5 h-3.5 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Add &amp; remove VAT instantly</li>
                        <li class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400"><svg class="w-3.5 h-3.5 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> All EU rates (standard, reduced, super-reduced)</li>
                        <li class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400"><svg class="w-3.5 h-3.5 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Shareable result links</li>
                    </ul>
                </div>
                <div class="mt-5 flex items-center gap-1 text-xs font-semibold text-blue-600 dark:text-blue-400 group-hover:translate-x-1 transition-transform">Open Calculator <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg></div>
            </a>

            {{-- VAT Number Validator --}}
            <a href="{{ locale_path('/vat-number-validator') }}"
               class="group relative bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg hover:border-emerald-300 dark:hover:border-emerald-600 transition-all overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 rounded-full bg-emerald-50 dark:bg-emerald-900/10 -translate-y-12 translate-x-12 group-hover:scale-150 transition-transform duration-500 pointer-events-none"></div>
                <div class="relative">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors mb-1">{{ __('ui.nav.vat_number_validator') }}</h2>
                            <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 dark:bg-emerald-900/20 px-2 py-0.5 rounded-full">VIES Powered</span>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed mb-4">Instantly verify any EU VAT number against the official VIES database. Check registration status, retrieve company details, and validate before issuing invoices.</p>
                    <ul class="space-y-1.5">
                        <li class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400"><svg class="w-3.5 h-3.5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Real-time VIES API lookup</li>
                        <li class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400"><svg class="w-3.5 h-3.5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Auto-detects country from VAT prefix</li>
                        <li class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400"><svg class="w-3.5 h-3.5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Company name &amp; address lookup</li>
                    </ul>
                </div>
                <div class="mt-5 flex items-center gap-1 text-xs font-semibold text-emerald-600 dark:text-emerald-400 group-hover:translate-x-1 transition-transform">Validate a Number <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg></div>
            </a>
        </div>

        {{-- Secondary Tools --}}
        <h2 class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-5">More Tools</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-12">

            {{-- VAT Map --}}
            <a href="{{ locale_path('/vat-map') }}"
               class="group bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 hover:shadow-md hover:border-green-300 dark:hover:border-green-600 transition-all">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">{{ __('ui.nav.vat_map') }}</h3>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">Interactive map of EU VAT rates. Click any country to explore standard and reduced rates at a glance across all 27 member states.</p>
                <div class="mt-4 flex items-center gap-1 text-xs font-semibold text-green-600 dark:text-green-400 group-hover:translate-x-1 transition-transform">Explore map <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg></div>
            </a>

            {{-- VAT History --}}
            <a href="{{ locale_path('/vat-changes') }}"
               class="group bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 hover:shadow-md hover:border-amber-300 dark:hover:border-amber-600 transition-all">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">{{ __('ui.nav.vat_history') }}</h3>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">Track every EU VAT rate change with a historical timeline. See when rates increased, decreased, or were introduced — filterable by country and year.</p>
                <div class="mt-4 flex items-center gap-1 text-xs font-semibold text-amber-600 dark:text-amber-400 group-hover:translate-x-1 transition-transform">View history <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg></div>
            </a>

            {{-- Embed Widget --}}
            <a href="{{ route('widget.embed') }}"
               class="group bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 hover:shadow-md hover:border-indigo-300 dark:hover:border-indigo-600 transition-all">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">{{ __('ui.nav.vat_widget') }}</h3>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">Embed a live VAT rate widget on your own website. One line of code — always shows current EU VAT rates with zero maintenance.</p>
                <div class="mt-4 flex items-center gap-1 text-xs font-semibold text-indigo-600 dark:text-indigo-400 group-hover:translate-x-1 transition-transform">Get embed code <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg></div>
            </a>

            {{-- JSON API --}}
            <a href="/api/countries"
               class="group bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 hover:shadow-md hover:border-rose-300 dark:hover:border-rose-600 transition-all">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900 dark:text-white group-hover:text-rose-600 dark:group-hover:text-rose-400 transition-colors">{{ __('ui.footer.vat_rates_api') }}</h3>
                        <span class="text-xs font-semibold text-rose-500 bg-rose-50 dark:bg-rose-900/20 px-2 py-0.5 rounded-full">REST JSON</span>
                    </div>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">Free JSON API returning all EU VAT rates. Integrate current VAT data directly into your app — no API key required.</p>
                <div class="mt-4 flex items-center gap-1 text-xs font-semibold text-rose-600 dark:text-rose-400 group-hover:translate-x-1 transition-transform">View API <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg></div>
            </a>

            {{-- All Countries --}}
            <a href="{{ locale_path('/') }}"
               class="group bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 hover:shadow-md hover:border-blue-300 dark:hover:border-blue-600 transition-all">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">{{ __('ui.nav.all_countries') }}</h3>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">Browse VAT rates, calculators, and compliance guides for all 27 EU member states — each with a dedicated country page.</p>
                <div class="mt-4 flex items-center gap-1 text-xs font-semibold text-blue-600 dark:text-blue-400 group-hover:translate-x-1 transition-transform">Browse countries <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg></div>
            </a>

            {{-- Top VAT Calculations --}}
            <a href="{{ locale_path('/top-vat-calculations') }}"
               class="group bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 hover:shadow-md hover:border-purple-300 dark:hover:border-purple-600 transition-all">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">Top VAT Calculations</h3>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">See the most common VAT calculations across popular amounts (€100, €500, €1,000+) for all 27 EU member states side by side.</p>
                <div class="mt-4 flex items-center gap-1 text-xs font-semibold text-purple-600 dark:text-purple-400 group-hover:translate-x-1 transition-transform">View calculations <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg></div>
            </a>
        </div>

        {{-- CTA Banner --}}
        <div class="relative bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-8 text-white overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <svg width="100%" height="100%"><defs><pattern id="cta-dots" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1.5" fill="white"/></pattern></defs><rect width="100%" height="100%" fill="url(#cta-dots)"/></svg>
            </div>
            <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h3 class="text-xl font-bold mb-1">Need VAT rate data in your app?</h3>
                    <p class="text-blue-100 text-sm">Access all EU VAT rates programmatically via our free JSON API — no authentication required.</p>
                </div>
                <div class="flex flex-wrap gap-3 shrink-0">
                    <a href="/api/countries" target="_blank"
                       class="inline-flex items-center gap-2 bg-white text-blue-700 font-semibold text-sm px-5 py-2.5 rounded-xl hover:bg-blue-50 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                        View API
                    </a>
                    <a href="{{ locale_path('/vat-number-validator') }}"
                       class="inline-flex items-center gap-2 bg-white/15 text-white font-semibold text-sm px-5 py-2.5 rounded-xl hover:bg-white/25 transition-colors border border-white/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Validate VAT Number
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
