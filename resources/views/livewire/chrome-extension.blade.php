@section('seo')
    <x-seo-meta
        title="EU VAT Calculator — Free Chrome Extension"
        description="Calculate EU VAT instantly from your browser toolbar. Free Chrome extension with all 27 EU country rates, calculation history, new-tab mode, and offline support."
        type="website"
    />
@endsection

<div>
    {{-- Hero --}}
    <div class="relative bg-gradient-to-br from-[#003399] via-[#0044bb] to-[#1a5cd8] text-white overflow-hidden">
        <div class="absolute inset-0 opacity-5">
            <svg width="100%" height="100%"><defs><pattern id="ext-grid" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="0.5"/></pattern></defs><rect width="100%" height="100%" fill="url(#ext-grid)"/></svg>
        </div>
        <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-white/5 pointer-events-none"></div>
        <div class="absolute -bottom-16 -left-16 w-64 h-64 rounded-full bg-white/5 pointer-events-none"></div>

        <div class="relative container py-14 sm:py-20 px-4">
            <x-breadcrumbs :items="[__('ui.breadcrumbs.tools') => locale_path('/tools'), 'Chrome Extension' => '']" variant="dark" />
            <div class="max-w-3xl py-6">
                <div class="inline-flex items-center gap-2 bg-white/10 rounded-full px-3 py-1 text-xs font-semibold text-blue-100 mb-4">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C8.21 0 4.831 1.757 2.632 4.501l3.953 6.848A5.454 5.454 0 0 1 12 6.545h10.691A12 12 0 0 0 12 0zM1.931 5.47A11.943 11.943 0 0 0 0 12c0 6.012 4.42 10.991 10.189 11.864l3.953-6.847a5.45 5.45 0 0 1-6.865-2.29zm13.342 2.166a5.446 5.446 0 0 1 1.45 7.09l.002.001-3.952 6.848c.2.014.4.025.6.025 6.627 0 12-5.373 12-12 0-.691-.073-1.365-.18-2.024zM12 16.364a4.364 4.364 0 1 1 0-8.728 4.364 4.364 0 0 1 0 8.728z"/></svg>
                    Free Chrome Extension
                </div>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold mb-4 leading-tight">EU VAT Calculator<br><span class="text-blue-200">Chrome Extension</span></h1>
                <p class="text-blue-100 text-base sm:text-lg max-w-2xl leading-relaxed mb-8">Calculate EU VAT instantly from your browser toolbar. All 27 EU country rates, calculation history, and new-tab mode — always one click away.</p>

                <a href="{{ $storeUrl }}" target="_blank" rel="noopener noreferrer" class="inline-block hover:opacity-90 transition-opacity">
                    <img src="/images/chrome-web-store-badge.png" alt="Available in the Chrome Web Store" class="h-14 sm:h-16" loading="eager">
                </a>
            </div>
        </div>
    </div>

    <div class="container !py-12">

        {{-- Key Features --}}
        <h2 class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-5">Features</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-12">

            {{-- Instant Calculation --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Instant Calculation</h3>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">Add or extract VAT with one click. Results appear instantly in the popup — no page loads, no waiting.</p>
            </div>

            {{-- All 27 EU Countries --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">All 27 EU Countries</h3>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">Standard, reduced, super-reduced, and parking rates for every EU member state. Rates auto-sync from eu-vat.info every 12 hours.</p>
            </div>

            {{-- New Tab Mode --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">New Tab Mode</h3>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">Replace your Chrome new tab with a full-featured VAT calculator, live clock, and quick rate overview for your default country.</p>
            </div>

            {{-- Calculation History --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Calculation History</h3>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">Your last 20 calculations are automatically saved. Click any past calculation to restore it instantly.</p>
            </div>

            {{-- Offline Support --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636a9 9 0 010 12.728m0 0l-2.829-2.829m2.829 2.829L21 21M15.536 8.464a5 5 0 010 7.072m0 0l-2.829-2.829m-4.243 2.829a5 5 0 01-7.072 0m7.072 0l-2.829-2.829M3 3l3.59 3.59m0 0A9.953 9.953 0 015 12c0 1.39.28 2.73.8 3.93M3 3l18 18"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Works Offline</h3>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">Built-in rate data means the calculator works without an internet connection. Rates sync automatically when you're back online.</p>
            </div>

            {{-- Keyboard Shortcuts --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Keyboard Shortcuts</h3>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed"><kbd class="px-1.5 py-0.5 bg-gray-100 dark:bg-gray-700 rounded text-xs font-mono">⌘↵</kbd> to calculate, <kbd class="px-1.5 py-0.5 bg-gray-100 dark:bg-gray-700 rounded text-xs font-mono">Esc</kbd> to clear. European number formats (1.234,56) fully supported.</p>
            </div>
        </div>

        {{-- Privacy & Permissions --}}
        <h2 class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-5">Privacy & Permissions</h2>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-12">
            <div class="grid sm:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-bold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        Your Data is Safe
                    </h3>
                    <ul class="space-y-2 text-sm text-gray-500 dark:text-gray-400">
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-green-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            No user data collected or transmitted
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-green-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            All calculations performed locally in your browser
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-green-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            History stored only in local Chrome storage
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 dark:text-white mb-3">Permissions Used</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex items-start gap-2">
                            <span class="font-mono text-xs bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded shrink-0">storage</span>
                            <span class="text-gray-500 dark:text-gray-400">Save settings, history & cached rates</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="font-mono text-xs bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded shrink-0">alarms</span>
                            <span class="text-gray-500 dark:text-gray-400">Auto-refresh rates every 12 hours</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="font-mono text-xs bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded shrink-0">contextMenus</span>
                            <span class="text-gray-500 dark:text-gray-400">Right-click "Open in Full Tab"</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CTA --}}
        <div class="relative bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-8 text-white overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <svg width="100%" height="100%"><defs><pattern id="cta-dots" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1.5" fill="white"/></pattern></defs><rect width="100%" height="100%" fill="url(#cta-dots)"/></svg>
            </div>
            <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                <div>
                    <h3 class="text-xl font-bold mb-1">Get the EU VAT Calculator for Chrome</h3>
                    <p class="text-blue-100 text-sm">Free, fast, and private. Calculate VAT in seconds from any tab.</p>
                </div>
                <a href="{{ $storeUrl }}" target="_blank" rel="noopener noreferrer" class="inline-block hover:opacity-90 transition-opacity shrink-0">
                    <img src="/images/chrome-web-store-badge.png" alt="Available in the Chrome Web Store" class="h-14" loading="lazy">
                </a>
            </div>
        </div>
    </div>
</div>
