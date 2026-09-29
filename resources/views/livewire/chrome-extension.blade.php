@section('seo')
    <x-seo-meta
        title="EU VAT Calculator — Free Chrome Extension"
        description="Calculate EU VAT instantly from your browser toolbar. Free Chrome extension with all 27 EU country rates, calculation history, new-tab mode, and offline support."
        type="website" />
@endsection

<div>
    {{-- Hero --}}
    <div class="hero-canvas">
        <x-hero-backdrop />
        <div class="app-container relative py-14 sm:py-20">
            <x-site-breadcrumbs :items="[__('ui.breadcrumbs.tools') => locale_path('/tools'), 'Chrome Extension' => '']" variant="dark" />
            <div class="max-w-3xl py-6">
                <p class="app-kicker mb-4">Free Chrome Extension</p>
                <h1 class="mb-4 text-3xl font-bold tracking-[-0.03em] sm:text-4xl lg:text-5xl lg:leading-[1.08]">EU VAT Calculator<br>Chrome Extension</h1>
                <p class="text-white/85 text-base sm:text-lg max-w-2xl leading-relaxed mb-8">Calculate EU VAT instantly from your browser toolbar. All 27 EU country rates, calculation history, and new-tab mode — always one click away.</p>

                <a href="{{ $storeUrl }}" target="_blank" rel="noopener noreferrer" class="inline-block hover:opacity-90 transition-opacity">
                    <img src="/images/chrome-web-store-badge.png" alt="Available in the Chrome Web Store" class="h-14 sm:h-16" loading="eager">
                </a>
            </div>
        </div>
    </div>

    <div class="app-container py-12">

        {{-- Key Features --}}
        <h2 class="text-xs font-bold text-ink-quiet uppercase tracking-widest mb-5">Features</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-12">

            {{-- Instant Calculation --}}
            <div class="app-surface p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-card bg-action-soft text-action flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    </div>
                    <h3 class="text-base font-bold text-ink">Instant Calculation</h3>
                </div>
                <p class="text-sm text-ink-muted leading-relaxed">Add or extract VAT with one click. Results appear instantly in the popup — no page loads, no waiting.</p>
            </div>

            {{-- All 27 EU Countries --}}
            <div class="app-surface p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-card bg-success-soft text-success flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" /></svg>
                    </div>
                    <h3 class="text-base font-bold text-ink">All 27 EU Countries</h3>
                </div>
                <p class="text-sm text-ink-muted leading-relaxed">Standard, reduced, super-reduced, and parking rates for every EU member state. Rates auto-sync from vat.businesspress.io every 12 hours.</p>
            </div>

            {{-- New Tab Mode --}}
            <div class="app-surface p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-card bg-action-soft text-action flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    </div>
                    <h3 class="text-base font-bold text-ink">New Tab Mode</h3>
                </div>
                <p class="text-sm text-ink-muted leading-relaxed">Replace your Chrome new tab with a full-featured VAT calculator, live clock, and quick rate overview for your default country.</p>
            </div>

            {{-- Calculation History --}}
            <div class="app-surface p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-card bg-warning-soft text-warning flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-base font-bold text-ink">Calculation History</h3>
                </div>
                <p class="text-sm text-ink-muted leading-relaxed">Your last 20 calculations are automatically saved. Click any past calculation to restore it instantly.</p>
            </div>

            {{-- Offline Support --}}
            <div class="app-surface p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-card bg-success-soft text-success flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636a9 9 0 010 12.728m0 0l-2.829-2.829m2.829 2.829L21 21M15.536 8.464a5 5 0 010 7.072m0 0l-2.829-2.829m-4.243 2.829a5 5 0 01-7.072 0m7.072 0l-2.829-2.829M3 3l3.59 3.59m0 0A9.953 9.953 0 015 12c0 1.39.28 2.73.8 3.93M3 3l18 18" /></svg>
                    </div>
                    <h3 class="text-base font-bold text-ink">Works Offline</h3>
                </div>
                <p class="text-sm text-ink-muted leading-relaxed">Built-in rate data means the calculator works without an internet connection. Rates sync automatically when you're back online.</p>
            </div>

            {{-- Keyboard Shortcuts --}}
            <div class="app-surface p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-card bg-danger-soft text-danger flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707" /></svg>
                    </div>
                    <h3 class="text-base font-bold text-ink">Keyboard Shortcuts</h3>
                </div>
                <p class="text-sm text-ink-muted leading-relaxed"><kbd class="px-1.5 py-0.5 bg-surface-muted rounded-sm text-xs font-mono">⌘↵</kbd> to calculate, <kbd class="px-1.5 py-0.5 bg-surface-muted rounded-sm text-xs font-mono">Esc</kbd> to clear. European number formats (1.234,56) fully supported.</p>
            </div>
        </div>

        {{-- Privacy & Permissions --}}
        <h2 class="text-xs font-bold text-ink-quiet uppercase tracking-widest mb-5">Privacy & Permissions</h2>
        <div class="app-surface p-6 mb-12">
            <div class="grid sm:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-bold text-ink mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                        Your Data is Safe
                    </h3>
                    <ul class="space-y-2 text-sm text-ink-muted">
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-success shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                            No user data collected or transmitted
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-success shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                            All calculations performed locally in your browser
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-success shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                            History stored only in local Chrome storage
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold text-ink mb-3">Permissions Used</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex items-start gap-2">
                            <span class="font-mono text-xs bg-surface-muted px-2 py-0.5 rounded-sm shrink-0">storage</span>
                            <span class="text-ink-muted">Save settings, history & cached rates</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="font-mono text-xs bg-surface-muted px-2 py-0.5 rounded-sm shrink-0">alarms</span>
                            <span class="text-ink-muted">Auto-refresh rates every 12 hours</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="font-mono text-xs bg-surface-muted px-2 py-0.5 rounded-sm shrink-0">contextMenus</span>
                            <span class="text-ink-muted">Right-click "Open in Full Tab"</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CTA --}}
        <div class="hero-canvas rounded-panel p-8">
            <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                <div>
                    <h3 class="text-xl font-bold mb-1">Get the EU VAT Calculator for Chrome</h3>
                    <p class="text-white/85 text-sm">Free, fast, and private. Calculate VAT in seconds from any tab.</p>
                </div>
                <a href="{{ $storeUrl }}" target="_blank" rel="noopener noreferrer" class="inline-block hover:opacity-90 transition-opacity shrink-0">
                    <img src="/images/chrome-web-store-badge.png" alt="Available in the Chrome Web Store" class="h-14" loading="lazy">
                </a>
            </div>
        </div>
    </div>
</div>
