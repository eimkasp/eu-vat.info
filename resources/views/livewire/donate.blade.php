@section('seo')
    <x-seo-meta
        title="Donate — Support EU VAT Info"
        description="Support EU VAT Info, a free open-source platform providing VAT rates, calculators, and validators for all 27 EU member states. Donate via x402 crypto payments or traditional methods."
        :url="url()->current()"
    />
@endsection

<div>
    {{-- Hero --}}
    <div class="relative bg-gradient-to-br from-emerald-700 via-emerald-600 to-teal-600 text-white overflow-hidden">
        <div class="absolute inset-0 opacity-5">
            <svg width="100%" height="100%">
                <defs>
                    <pattern id="donate-grid" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="0.5"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#donate-grid)"/>
            </svg>
        </div>
        <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-white/5 pointer-events-none"></div>
        <div class="absolute -bottom-16 -left-16 w-64 h-64 rounded-full bg-white/5 pointer-events-none"></div>

        <div class="relative container py-14 sm:py-20 px-4">
            <x-breadcrumbs :items="['Donate' => '']" variant="dark" />
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 bg-white/10 rounded-full px-3 py-1 text-xs font-semibold text-emerald-100 mb-4">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    Support Open Source
                </div>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold mb-4 leading-tight">
                    Support EU VAT Info
                </h1>
                <p class="text-emerald-100 text-base sm:text-lg max-w-2xl leading-relaxed">
                    EU VAT Info is a free, open-source platform serving developers, businesses, and AI agents with comprehensive EU VAT data. Your donation helps keep it running and improving.
                </p>

                <div class="mt-8 flex flex-wrap gap-6">
                    <div class="flex items-center gap-2 text-sm text-emerald-100">
                        <svg class="w-4 h-4 text-emerald-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>27 EU Countries</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-emerald-100">
                        <svg class="w-4 h-4 text-emerald-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                        </svg>
                        <span>24 Languages</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-emerald-100">
                        <svg class="w-4 h-4 text-emerald-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                        </svg>
                        <span>Free & Open Source</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-12 px-4">

        {{-- WHAT YOUR DONATION SUPPORTS --}}
        <h2 class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-5">What Your Donation Supports</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-12">

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Daily Data Updates</h3>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                    Automated daily syncs from the European Commission and national tax authorities keep all 27 countries up-to-date.
                </p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Server & Infrastructure</h3>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                    Hosting, SSL certificates, CDN, and database costs to serve fast responses to users and agents worldwide.
                </p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">API & MCP Server</h3>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                    Free JSON API and MCP server enabling AI agents (Claude, Copilot, Cursor) to access live EU VAT data.
                </p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">24 Language Translations</h3>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                    Professional translations via DeepL for all 24 official EU languages, ensuring accessibility across the Union.
                </p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">VIES Validation</h3>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                    Free VAT number validation against the official EU VIES database with smart caching and fuzzy matching.
                </p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Open Source Development</h3>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                    Continued development of new features, bug fixes, and community contributions on GitHub.
                </p>
            </div>
        </div>

        {{-- DONATION METHODS --}}
        <h2 class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-5">How to Donate</h2>
        <div class="grid sm:grid-cols-2 gap-5 mb-12">

            {{-- x402 AGENT PAYMENT --}}
            <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 rounded-full bg-emerald-50 dark:bg-emerald-900/10 -translate-y-12 translate-x-12 pointer-events-none"></div>
                <div class="relative">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">
                                x402 Agent Payment
                            </h3>
                            <span class="text-xs font-semibold text-emerald-500 bg-emerald-50 dark:bg-emerald-900/20 px-2 py-0.5 rounded-full">For AI Agents</span>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed mb-4">
                        AI agents can donate instantly via the <a href="https://x402.org" target="_blank" rel="noopener noreferrer" class="text-emerald-600 dark:text-emerald-400 font-medium hover:underline">x402 protocol</a> — no accounts, no API keys, just a single HTTP request with USDC on Base.
                    </p>

                    <div class="bg-gray-50 dark:bg-gray-900 rounded-xl p-4 mb-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Agent Endpoint</span>
                        </div>
                        <code class="block text-sm text-emerald-600 dark:text-emerald-400 font-mono break-all">
                            GET {{ url('/api/x402/donate') }}
                        </code>
                        <div class="mt-3 flex items-center gap-3 text-xs text-gray-500 dark:text-gray-400">
                            <span class="inline-flex items-center gap-1">
                                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                $0.10 USDC
                            </span>
                            <span>Base Network</span>
                            <span>x402 v2</span>
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-900 rounded-xl p-4">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-2 font-semibold">How it works:</p>
                        <ol class="space-y-1.5 text-xs text-gray-500 dark:text-gray-400">
                            <li class="flex items-start gap-2">
                                <span class="w-4 h-4 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0 text-[10px] font-bold mt-0.5">1</span>
                                Agent sends GET request to the donate endpoint
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="w-4 h-4 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0 text-[10px] font-bold mt-0.5">2</span>
                                Server returns HTTP 402 with <code class="text-gray-600 dark:text-gray-300">PAYMENT-REQUIRED</code> header
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="w-4 h-4 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0 text-[10px] font-bold mt-0.5">3</span>
                                Agent signs payment with USDC on Base and retries with <code class="text-gray-600 dark:text-gray-300">PAYMENT-SIGNATURE</code> header
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="w-4 h-4 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0 text-[10px] font-bold mt-0.5">4</span>
                                Payment is verified, settled, and a thank-you message is returned
                            </li>
                        </ol>
                    </div>
                </div>
            </div>

            {{-- GITHUB SPONSORS --}}
            <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 rounded-full bg-pink-50 dark:bg-pink-900/10 -translate-y-12 translate-x-12 pointer-events-none"></div>
                <div class="relative">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-12 h-12 rounded-xl bg-pink-100 dark:bg-pink-900/30 text-pink-600 dark:text-pink-400 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">
                                GitHub Sponsors
                            </h3>
                            <span class="text-xs font-semibold text-pink-500 bg-pink-50 dark:bg-pink-900/20 px-2 py-0.5 rounded-full">For Humans</span>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed mb-4">
                        Support development through GitHub Sponsors with one-time or recurring donations. GitHub matches contributions during sponsorship events.
                    </p>

                    <a href="https://github.com/sponsors/eimkasp" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-2 bg-pink-600 hover:bg-pink-700 text-white font-semibold text-sm px-5 py-2.5 rounded-xl transition-colors shadow-sm mb-4">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                        Sponsor on GitHub
                    </a>

                    <div class="bg-gray-50 dark:bg-gray-900 rounded-xl p-4">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-2 font-semibold">Also available:</p>
                        <ul class="space-y-1.5 text-xs text-gray-500 dark:text-gray-400">
                            <li class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-pink-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                One-time donations
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-pink-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Monthly recurring sponsorship
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-pink-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                GitHub Sponsors matching (when available)
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- PREMIUM API ENDPOINTS --}}
        <h2 class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-5">Premium API Endpoints (x402)</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-5 max-w-2xl">
            These endpoints provide enriched data and are accessible via <a href="https://x402.org" target="_blank" rel="noopener noreferrer" class="text-emerald-600 dark:text-emerald-400 font-medium hover:underline">x402 micropayments</a>. All core data remains free via our <a href="/api/countries" class="text-blue-600 dark:text-blue-400 font-medium hover:underline">public API</a>.
        </p>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-12">
            @foreach ($x402Routes as $route => $config)
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-mono font-semibold text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-900 rounded px-2 py-0.5">{{ $config['price'] }}</span>
                        <span class="text-xs text-emerald-600 dark:text-emerald-400 font-semibold">USDC</span>
                    </div>
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-2">{{ $config['description'] }}</h3>
                    <code class="block text-xs text-gray-500 dark:text-gray-400 font-mono break-all bg-gray-50 dark:bg-gray-900 rounded-lg p-2">{{ $route }}</code>
                </div>
            @endforeach
        </div>

        {{-- x402 PROTOCOL INFO --}}
        <h2 class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-5">About x402 Protocol</h2>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-12">
            <div class="prose prose-sm prose-gray dark:prose-invert max-w-none">
                <p>
                    <a href="https://x402.org" target="_blank" rel="noopener noreferrer" class="text-emerald-600 dark:text-emerald-400 font-semibold hover:underline">x402</a> is an open, neutral standard for internet-native payments. It uses the HTTP <code>402 Payment Required</code> status code to enable frictionless, programmatic payments — perfect for AI agents and automated systems.
                </p>
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-4 not-prose">
                    <div class="bg-gray-50 dark:bg-gray-900 rounded-xl p-3 text-center">
                        <p class="text-lg font-bold text-gray-900 dark:text-white">$0</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Protocol Fees</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-900 rounded-xl p-3 text-center">
                        <p class="text-lg font-bold text-gray-900 dark:text-white">0</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Accounts Required</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-900 rounded-xl p-3 text-center">
                        <p class="text-lg font-bold text-gray-900 dark:text-white">USDC</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Stablecoin Payments</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-900 rounded-xl p-3 text-center">
                        <p class="text-lg font-bold text-gray-900 dark:text-white">Base</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Network (L2)</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- DISCOVERY ENDPOINT --}}
        <div class="bg-gray-50 dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 mb-12">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-3">Machine-Readable Discovery</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">AI agents can discover all paid endpoints and pricing programmatically:</p>
            <code class="block text-sm text-emerald-600 dark:text-emerald-400 font-mono bg-white dark:bg-gray-800 rounded-xl p-4 break-all border border-gray-200 dark:border-gray-700">
                GET {{ url('/api/x402/info') }}
            </code>
        </div>

        {{-- CTA --}}
        <div class="relative bg-gradient-to-r from-emerald-600 to-teal-600 rounded-2xl p-8 text-white overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <svg width="100%" height="100%">
                    <defs>
                        <pattern id="donate-dots" width="20" height="20" patternUnits="userSpaceOnUse">
                            <circle cx="10" cy="10" r="1.5" fill="white"/>
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#donate-dots)"/>
                </svg>
            </div>
            <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h3 class="text-xl font-bold mb-1">Every contribution makes a difference</h3>
                    <p class="text-emerald-100 text-sm">Whether you're a developer, business, or AI agent — thank you for supporting free EU VAT data.</p>
                </div>
                <div class="flex flex-wrap gap-3 shrink-0">
                    <a href="https://github.com/sponsors/eimkasp" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-2 bg-white text-emerald-700 font-semibold text-sm px-5 py-2.5 rounded-xl hover:bg-emerald-50 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                        Sponsor
                    </a>
                    <a href="https://github.com/eimkasp/eu-vat.info" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-2 bg-emerald-500/30 text-white font-semibold text-sm px-5 py-2.5 rounded-xl hover:bg-emerald-500/40 transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12c0 4.42 2.87 8.17 6.84 9.5.5.08.66-.23.66-.5v-1.69c-2.77.6-3.36-1.34-3.36-1.34-.46-1.16-1.11-1.47-1.11-1.47-.91-.62.07-.6.07-.6 1 .07 1.53 1.03 1.53 1.03.87 1.52 2.34 1.07 2.91.83.09-.65.35-1.09.63-1.34-2.22-.25-4.55-1.11-4.55-4.92 0-1.11.38-2 1.03-2.71-.1-.25-.45-1.29.1-2.64 0 0 .84-.27 2.75 1.02.79-.22 1.65-.33 2.5-.33.85 0 1.71.11 2.5.33 1.91-1.29 2.75-1.02 2.75-1.02.55 1.35.2 2.39.1 2.64.65.71 1.03 1.6 1.03 2.71 0 3.82-2.34 4.66-4.57 4.91.36.31.69.92.69 1.85V21c0 .27.16.59.67.5C19.14 20.16 22 16.42 22 12A10 10 0 0012 2z" clip-rule="evenodd"/>
                        </svg>
                        Star on GitHub
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
