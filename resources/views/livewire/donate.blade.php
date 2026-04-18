@section('seo')
    <x-seo-meta
        title="Donate — Support EU VAT Info"
        description="Support EU VAT Info, a free open-source platform providing VAT rates, calculators, and validators for all 27 EU member states. Donate via x402 crypto payments or GitHub Sponsors."
        :url="url()->current()"
    />
@endsection

<div>
    {{-- Hero with key actions --}}
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
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold mb-4 leading-tight">
                    Support EU VAT Info
                </h1>
                <p class="text-emerald-100 text-base sm:text-lg max-w-2xl leading-relaxed mb-8">
                    Free, open-source EU VAT data for developers, businesses, and AI agents. Keep it running with a donation.
                </p>

                {{-- Hero action cards --}}
                <div class="grid sm:grid-cols-2 gap-4 max-w-2xl">
                    {{-- Human donation --}}
                    <a href="https://github.com/sponsors/eimkasp" target="_blank" rel="noopener noreferrer"
                       class="group flex items-center gap-4 bg-white/10 hover:bg-white/20 backdrop-blur-sm rounded-2xl p-5 transition-all border border-white/10">
                        <div class="w-12 h-12 rounded-xl bg-pink-500/20 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-pink-300" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-bold text-white group-hover:text-pink-100 transition-colors">GitHub Sponsors</div>
                            <div class="text-sm text-emerald-200">One-time or recurring &middot; For humans</div>
                        </div>
                        <svg class="w-5 h-5 text-white/50 group-hover:text-white/80 shrink-0 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    </a>

                    {{-- Agent donation --}}
                    <div class="flex items-center gap-4 bg-white/10 backdrop-blur-sm rounded-2xl p-5 border border-white/10">
                        <div class="w-12 h-12 rounded-xl bg-emerald-400/20 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-bold text-white">x402 Micropayment</div>
                            <div class="text-sm text-emerald-200">$0.10 USDC on Base &middot; For AI agents</div>
                        </div>
                        <a href="#x402-test" class="text-xs font-semibold text-emerald-200 hover:text-white bg-white/10 hover:bg-white/20 px-3 py-1.5 rounded-lg transition-colors shrink-0">
                            Test it
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container !py-12 px-4">

        {{-- QUICK REFERENCE: HOW TO DONATE --}}
        <div class="grid sm:grid-cols-2 gap-5 mb-12">

            {{-- x402 AGENT PAYMENT --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-xs font-semibold text-emerald-500 bg-emerald-50 dark:bg-emerald-900/20 px-2.5 py-1 rounded-full">For AI Agents</span>
                    <span class="text-xs font-semibold text-gray-400 dark:text-gray-500">x402 Protocol</span>
                </div>

                <div class="bg-gray-50 dark:bg-gray-900 rounded-xl p-4 mb-4">
                    <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider block mb-2">Donate Endpoint</span>
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
                            Agent sends <code class="text-gray-600 dark:text-gray-300">GET</code> request to the donate endpoint
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="w-4 h-4 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0 text-[10px] font-bold mt-0.5">2</span>
                            Server returns <code class="text-gray-600 dark:text-gray-300">HTTP 402</code> with payment requirements
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="w-4 h-4 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0 text-[10px] font-bold mt-0.5">3</span>
                            Agent signs USDC payment &amp; retries with <code class="text-gray-600 dark:text-gray-300">PAYMENT-SIGNATURE</code>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="w-4 h-4 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0 text-[10px] font-bold mt-0.5">4</span>
                            Payment verified, settled, and thank-you returned
                        </li>
                    </ol>
                </div>
            </div>

            {{-- GITHUB SPONSORS --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-xs font-semibold text-pink-500 bg-pink-50 dark:bg-pink-900/20 px-2.5 py-1 rounded-full">For Humans</span>
                    <span class="text-xs font-semibold text-gray-400 dark:text-gray-500">GitHub Sponsors</span>
                </div>

                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed mb-5">
                    Support development through GitHub Sponsors with one-time or recurring donations. GitHub matches contributions during sponsorship events.
                </p>

                <a href="https://github.com/sponsors/eimkasp" target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center gap-2 bg-pink-600 hover:bg-pink-700 text-white font-semibold text-sm px-5 py-2.5 rounded-xl transition-colors shadow-sm mb-5">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                    Sponsor on GitHub
                </a>

                <div class="bg-gray-50 dark:bg-gray-900 rounded-xl p-4">
                    <ul class="space-y-1.5 text-xs text-gray-500 dark:text-gray-400">
                        <li class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-pink-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            One-time donations from $1
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

        {{-- TEST x402 CONNECTION --}}
        <div id="x402-test" class="scroll-mt-24 mb-12" x-data="x402Test()">
            <h2 class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-5">Test x402 Connection</h2>
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-5">
                    <p class="text-sm text-gray-500 dark:text-gray-400 flex-1">
                        Verify the x402 payment endpoint is responding correctly. This sends a request <strong>without</strong> a payment signature — you should see an HTTP <code class="text-gray-600 dark:text-gray-300">402</code> response with payment requirements.
                    </p>
                    <button @click="testEndpoint()" :disabled="loading"
                            class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 disabled:opacity-50 disabled:cursor-wait text-white font-semibold text-sm px-5 py-2.5 rounded-xl transition-colors shadow-sm shrink-0">
                        <svg x-show="!loading" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        <svg x-show="loading" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span x-text="loading ? 'Testing...' : 'Test Connection'"></span>
                    </button>
                </div>

                {{-- curl example --}}
                <div class="bg-gray-50 dark:bg-gray-900 rounded-xl p-4 mb-5">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Or try with curl</span>
                    </div>
                    <code class="block text-sm text-emerald-600 dark:text-emerald-400 font-mono break-all">
                        curl -i {{ url('/api/x402/donate') }}
                    </code>
                </div>

                {{-- Test result --}}
                <template x-if="result !== null">
                    <div class="rounded-xl border overflow-hidden" :class="result.success ? 'border-emerald-200 dark:border-emerald-800' : 'border-red-200 dark:border-red-800'">
                        {{-- Status header --}}
                        <div class="px-4 py-3 flex items-center gap-3" :class="result.success ? 'bg-emerald-50 dark:bg-emerald-900/20' : 'bg-red-50 dark:bg-red-900/20'">
                            <template x-if="result.success">
                                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </template>
                            <template x-if="!result.success">
                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </template>
                            <div>
                                <span class="text-sm font-bold" :class="result.success ? 'text-emerald-700 dark:text-emerald-300' : 'text-red-700 dark:text-red-300'" x-text="result.title"></span>
                                <span class="ml-2 text-xs font-mono px-2 py-0.5 rounded" :class="result.success ? 'bg-emerald-100 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400' : 'bg-red-100 dark:bg-red-900/40 text-red-600 dark:text-red-400'" x-text="'HTTP ' + result.status"></span>
                            </div>
                        </div>
                        {{-- Response body --}}
                        <div class="bg-gray-50 dark:bg-gray-900 p-4">
                            <pre class="text-xs text-gray-600 dark:text-gray-400 font-mono whitespace-pre-wrap break-all max-h-64 overflow-y-auto" x-text="result.body"></pre>
                        </div>
                        {{-- Explanation --}}
                        <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
                            <p class="text-xs text-gray-500 dark:text-gray-400" x-text="result.explanation"></p>
                        </div>
                    </div>
                </template>

                {{-- Error --}}
                <template x-if="error !== null">
                    <div class="rounded-xl border border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-900/20 p-4">
                        <div class="flex items-center gap-2 text-sm font-bold text-red-700 dark:text-red-300 mb-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Connection Failed
                        </div>
                        <p class="text-xs text-red-600 dark:text-red-400" x-text="error"></p>
                    </div>
                </template>
            </div>
        </div>

        {{-- PREMIUM API ENDPOINTS --}}
        <h2 class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-5">Premium API Endpoints (x402)</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-5 max-w-2xl">
            These endpoints provide enriched data via <a href="https://x402.org" target="_blank" rel="noopener noreferrer" class="text-emerald-600 dark:text-emerald-400 font-medium hover:underline">x402 micropayments</a>. All core data remains free via our <a href="/api/countries" class="text-blue-600 dark:text-blue-400 font-medium hover:underline">public API</a>.
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

        {{-- DISCOVERY ENDPOINT --}}
        <div class="bg-gray-50 dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 mb-12">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-3">Machine-Readable Discovery</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">AI agents can discover all paid endpoints and pricing programmatically:</p>
            <code class="block text-sm text-emerald-600 dark:text-emerald-400 font-mono bg-white dark:bg-gray-800 rounded-xl p-4 break-all border border-gray-200 dark:border-gray-700">
                GET {{ url('/api/x402/info') }}
            </code>
        </div>

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

<script>
function x402Test() {
    return {
        loading: false,
        result: null,
        error: null,

        async testEndpoint() {
            this.loading = true;
            this.result = null;
            this.error = null;

            try {
                const response = await fetch('{{ url("/api/x402/donate") }}', {
                    method: 'GET',
                    headers: { 'Accept': 'application/json' },
                });

                const status = response.status;
                let body = '';
                try {
                    const json = await response.json();
                    body = JSON.stringify(json, null, 2);
                } catch {
                    body = await response.text();
                }

                if (status === 402) {
                    const paymentHeader = response.headers.get('X-PAYMENT') || response.headers.get('PAYMENT-REQUIRED');
                    this.result = {
                        success: true,
                        status: status,
                        title: 'x402 is working correctly',
                        body: body,
                        explanation: 'The server returned HTTP 402 (Payment Required) as expected. An x402-compatible agent would now sign a USDC payment and retry the request with a PAYMENT-SIGNATURE header to complete the donation.'
                    };
                } else if (status === 200) {
                    this.result = {
                        success: true,
                        status: status,
                        title: 'Endpoint reachable (x402 may be disabled)',
                        body: body,
                        explanation: 'The server returned HTTP 200 instead of 402. The x402 middleware may be disabled in configuration. The donate endpoint is reachable but not requiring payment.'
                    };
                } else {
                    this.result = {
                        success: false,
                        status: status,
                        title: 'Unexpected response',
                        body: body,
                        explanation: 'Expected HTTP 402 (Payment Required) but received ' + status + '. Check that the x402 middleware is configured and the route is registered correctly.'
                    };
                }
            } catch (e) {
                this.error = 'Could not connect to the API endpoint. Error: ' + e.message;
            } finally {
                this.loading = false;
            }
        }
    };
}
</script>
