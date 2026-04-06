@section('seo')
    <x-seo-meta
        title="EU VAT Number Validation API — Free REST API Documentation"
        description="Free REST API to validate EU VAT numbers in real-time via the official VIES database. Single and batch validation, CORS headers, no API key required."
        type="website"
        :url="url()->current()"
    />
@endsection

<div x-data="{
    tab: 'single',
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
        const body = this.tab === 'single'
            ? { country_code: this.simCountry, vat_number: this.simVat }
            : {
                validations: [
                    { country_code: this.simCountry, vat_number: this.simVat },
                    { country_code: 'DE', vat_number: '123456789' }
                ]
              };
        const endpoint = this.tab === 'single'
            ? '/api/vat/validation/validate'
            : '/api/vat/validation/batch';
        try {
            const res = await fetch(endpoint, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                body: JSON.stringify(body)
            });
            const json = await res.json();
            this.elapsed = Math.round(performance.now() - t0);
            this.response = JSON.stringify(json, null, 2);
            if (!res.ok) this.error = this.response, this.response = null;
        } catch(e) {
            this.error = e.message;
        }
        this.loading = false;
    },
    get requestBody() {
        if (this.tab === 'single') {
            return JSON.stringify({ country_code: this.simCountry, vat_number: this.simVat }, null, 2);
        }
        return JSON.stringify({
            validations: [
                { country_code: this.simCountry, vat_number: this.simVat },
                { country_code: 'DE', vat_number: '123456789' }
            ]
        }, null, 2);
    },
    get currentEndpoint() {
        return this.tab === 'single' ? '/api/vat/validation/validate' : '/api/vat/validation/batch';
    }
}">
    {{-- Hero --}}
    <div class="relative bg-gradient-to-br from-[#003399] via-[#0044bb] to-[#1a5cd8] text-white overflow-hidden">
        <div class="absolute inset-0 opacity-5">
            <svg width="100%" height="100%"><defs><pattern id="api-grid" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="0.5"/></pattern></defs><rect width="100%" height="100%" fill="url(#api-grid)"/></svg>
        </div>
        <div class="relative container py-14 sm:py-20 px-4 max-w-5xl mx-auto">
            <x-breadcrumbs :items="[__('ui.vies_page.nav_title') => locale_path('/vat-number-validator'), 'API Documentation' => '']" variant="dark" />
            <div class="max-w-3xl mt-4">
                <div class="inline-flex items-center gap-2 bg-white/10 rounded-full px-3 py-1 text-xs font-semibold text-blue-100 mb-4">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                    REST API · No Auth Required · Free
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold mb-3 leading-tight">EU VAT Validation API</h1>
                <p class="text-blue-100 text-base sm:text-lg max-w-2xl leading-relaxed mb-8">
                    Validate EU VAT numbers programmatically against the official VIES database. Free to use, no API key, CORS enabled.
                </p>

                <div class="grid sm:grid-cols-3 gap-4">
                    <div class="bg-white/10 rounded-xl p-4">
                        <div class="text-2xl font-bold mb-1">Free</div>
                        <div class="text-blue-200 text-sm">No API key or account needed</div>
                    </div>
                    <div class="bg-white/10 rounded-xl p-4">
                        <div class="text-2xl font-bold mb-1">10 / batch</div>
                        <div class="text-blue-200 text-sm">Validate up to 10 numbers at once</div>
                    </div>
                    <div class="bg-white/10 rounded-xl p-4">
                        <div class="text-2xl font-bold mb-1">27 Countries</div>
                        <div class="text-blue-200 text-sm">All EU member states supported</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container max-w-5xl mx-auto px-4 py-12">
        <div class="grid lg:grid-cols-3 gap-8">
            {{-- Left: Docs + Simulator --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- Base URL --}}
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Base URL</h2>
                    <div class="bg-gray-900 rounded-xl p-4 flex items-center gap-3">
                        <code class="text-emerald-400 font-mono text-sm flex-1">{{ $baseUrl }}</code>
                        <button onclick="navigator.clipboard.writeText('{{ $baseUrl }}')"
                                class="shrink-0 p-1.5 bg-gray-700 hover:bg-gray-600 text-gray-300 rounded-lg transition-colors" title="Copy">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">All endpoints are relative to this base URL. Use HTTPS in production.</p>
                </div>

                {{-- Endpoints --}}
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Endpoints</h2>

                    {{-- Single validate --}}
                    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden mb-4">
                        <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-100 bg-gray-50">
                            <span class="bg-indigo-100 text-indigo-700 text-xs font-bold px-2.5 py-1 rounded-lg">POST</span>
                            <code class="font-mono text-sm text-gray-800">/api/vat/validation/validate</code>
                        </div>
                        <div class="p-5 space-y-4">
                            <p class="text-sm text-gray-600">Validate a single EU VAT number in real-time against the VIES database. Results are cached for 7 days for performance.</p>

                            <div>
                                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Request Body</p>
                                <div class="overflow-x-auto rounded-xl border border-gray-200">
                                    <table class="w-full text-sm">
                                        <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wide">
                                            <tr>
                                                <th class="text-left px-4 py-2.5 font-semibold">Parameter</th>
                                                <th class="text-left px-4 py-2.5 font-semibold">Type</th>
                                                <th class="text-left px-4 py-2.5 font-semibold">Required</th>
                                                <th class="text-left px-4 py-2.5 font-semibold">Description</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100">
                                            <tr>
                                                <td class="px-4 py-3"><code class="text-indigo-600 font-mono text-xs bg-indigo-50 px-1.5 py-0.5 rounded">country_code</code></td>
                                                <td class="px-4 py-3 text-gray-500 text-xs">string</td>
                                                <td class="px-4 py-3"><span class="text-red-500 font-semibold text-xs">required</span></td>
                                                <td class="px-4 py-3 text-gray-600 text-xs">2-letter ISO code (e.g. <code class="font-mono bg-gray-100 px-1 rounded">LT</code>, <code class="font-mono bg-gray-100 px-1 rounded">DE</code>). Greece uses <code class="font-mono bg-gray-100 px-1 rounded">EL</code>.</td>
                                            </tr>
                                            <tr>
                                                <td class="px-4 py-3"><code class="text-indigo-600 font-mono text-xs bg-indigo-50 px-1.5 py-0.5 rounded">vat_number</code></td>
                                                <td class="px-4 py-3 text-gray-500 text-xs">string</td>
                                                <td class="px-4 py-3"><span class="text-red-500 font-semibold text-xs">required</span></td>
                                                <td class="px-4 py-3 text-gray-600 text-xs">VAT number without the country prefix (e.g. <code class="font-mono bg-gray-100 px-1 rounded">100019070512</code> not <code class="font-mono bg-gray-100 px-1 rounded">LT100019070512</code>).</td>
                                            </tr>
                                            <tr>
                                                <td class="px-4 py-3"><code class="text-indigo-600 font-mono text-xs bg-indigo-50 px-1.5 py-0.5 rounded">company_name</code></td>
                                                <td class="px-4 py-3 text-gray-500 text-xs">string</td>
                                                <td class="px-4 py-3"><span class="text-gray-400 text-xs">optional</span></td>
                                                <td class="px-4 py-3 text-gray-600 text-xs">Expected company name for fuzzy matching verification.</td>
                                            </tr>
                                            <tr>
                                                <td class="px-4 py-3"><code class="text-indigo-600 font-mono text-xs bg-indigo-50 px-1.5 py-0.5 rounded">address</code></td>
                                                <td class="px-4 py-3 text-gray-500 text-xs">string</td>
                                                <td class="px-4 py-3"><span class="text-gray-400 text-xs">optional</span></td>
                                                <td class="px-4 py-3 text-gray-600 text-xs">Expected address for additional verification.</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="grid sm:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Example Request</p>
                                    <div class="bg-gray-900 rounded-xl p-4 font-mono text-xs overflow-x-auto">
                                        <p class="text-gray-400 mb-2">curl -X POST {{ $baseUrl }}/api/vat/validation/validate \</p>
                                        <p class="text-gray-400 ml-2">-H "Content-Type: application/json" \</p>
                                        <p class="text-gray-400 ml-2">-d '</p>
                                        <p class="text-amber-300 ml-2">{</p>
                                        <p class="text-amber-300 ml-4">"country_code": "LT",</p>
                                        <p class="text-amber-300 ml-4">"vat_number": "100019070512"</p>
                                        <p class="text-amber-300 ml-2">}'</p>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Example Response</p>
                                    <div class="bg-gray-900 rounded-xl p-4 font-mono text-xs overflow-x-auto">
                                        <pre class="text-green-400">{
  "success": true,
  "data": {
    "valid": true,
    "country_code": "LT",
    "vat_number": "100019070512",
    "name": "UAB Company Name",
    "address": "Vilnius, Lithuania",
    "source": "vies",
    "request_identifier": "..."
  }
}</pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Batch validate --}}
                    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden mb-4">
                        <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-100 bg-gray-50">
                            <span class="bg-indigo-100 text-indigo-700 text-xs font-bold px-2.5 py-1 rounded-lg">POST</span>
                            <code class="font-mono text-sm text-gray-800">/api/vat/validation/batch</code>
                            <span class="ml-auto text-xs font-semibold bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full">max 10</span>
                        </div>
                        <div class="p-5 space-y-4">
                            <p class="text-sm text-gray-600">Validate up to 10 VAT numbers in a single request. Each number is validated independently against VIES.</p>

                            <div class="grid sm:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Example Request</p>
                                    <div class="bg-gray-900 rounded-xl p-4 font-mono text-xs overflow-x-auto">
                                        <pre class="text-amber-300">{
  "validations": [
    {
      "country_code": "LT",
      "vat_number": "100019070512"
    },
    {
      "country_code": "DE",
      "vat_number": "129274202"
    }
  ]
}</pre>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Example Response</p>
                                    <div class="bg-gray-900 rounded-xl p-4 font-mono text-xs overflow-x-auto">
                                        <pre class="text-green-400">{
  "success": true,
  "total": 2,
  "data": [
    {
      "valid": true,
      "country_code": "LT",
      "vat_number": "100019070512",
      "name": "UAB ...",
      ...
    },
    { ... }
  ]
}</pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Health check --}}
                    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                        <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-100 bg-gray-50">
                            <span class="bg-green-100 text-green-700 text-xs font-bold px-2.5 py-1 rounded-lg">GET</span>
                            <code class="font-mono text-sm text-gray-800">/api/vat/validation/health</code>
                        </div>
                        <div class="p-5">
                            <p class="text-sm text-gray-600 mb-3">Check the operational status of the VAT validation service.</p>
                            <div class="bg-gray-900 rounded-xl p-4 font-mono text-xs">
                                <pre class="text-green-400">{
  "status": "operational",
  "service": "VAT VIES Validation API",
  "timestamp": "2026-04-07T10:00:00+00:00"
}</pre>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Interactive Playground --}}
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Interactive Playground</h2>
                    <div class="bg-white rounded-2xl border border-gray-200 overflow-visible">
                        {{-- Tab toggle --}}
                        <div class="flex border-b border-gray-200">
                            <button @click="tab = 'single'; response = null; error = null"
                                    :class="tab === 'single' ? 'border-b-2 border-indigo-500 text-indigo-700 bg-indigo-50/50' : 'text-gray-500 hover:text-gray-700'"
                                    class="flex-1 sm:flex-none px-5 py-3 text-sm font-semibold transition-colors">
                                Single Validation
                            </button>
                            <button @click="tab = 'batch'; response = null; error = null"
                                    :class="tab === 'batch' ? 'border-b-2 border-indigo-500 text-indigo-700 bg-indigo-50/50' : 'text-gray-500 hover:text-gray-700'"
                                    class="flex-1 sm:flex-none px-5 py-3 text-sm font-semibold transition-colors">
                                Batch (demo)
                            </button>
                        </div>

                        <div class="p-5 space-y-4">
                            {{-- Inputs --}}
                            <div class="grid sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">country_code</label>
                                    <input x-model="simCountry" type="text" maxlength="2" placeholder="LT"
                                           class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-xl font-mono focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 uppercase bg-gray-50">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">vat_number</label>
                                    <input x-model="simVat" type="text" placeholder="100019070512"
                                           @keydown.enter="runRequest()"
                                           class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-xl font-mono focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 bg-gray-50">
                                </div>
                            </div>
                            <p x-show="tab === 'batch'" class="text-xs text-gray-500 bg-amber-50 border border-amber-200 rounded-lg px-3 py-2">
                                Batch demo will validate the above number + a static DE example to show the multi-result response format.
                            </p>

                            {{-- Request preview + Send button --}}
                            <div class="bg-gray-900 rounded-t-xl overflow-hidden">
                                <div class="flex items-center justify-between px-4 py-2.5 border-b border-gray-700">
                                    <div class="flex items-center gap-2 text-xs text-gray-400">
                                        <span class="text-emerald-400 font-mono font-semibold">POST</span>
                                        <span class="font-mono" x-text="currentEndpoint"></span>
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
                            <div class="bg-gray-950 rounded-b-xl border border-gray-800 border-t-0 min-h-[100px]">
                                <div x-show="!response && !error && !loading" class="p-4 text-xs text-gray-600 font-mono">
                                    // Response will appear here after you click Send Request
                                </div>
                                <div x-show="loading" class="p-4 text-xs text-gray-500 font-mono flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 animate-spin text-indigo-400" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                                    Sending request to VIES…
                                </div>
                                <div x-show="response">
                                    <div class="flex items-center justify-between px-4 py-2.5 border-b border-gray-800">
                                        <span class="text-xs text-emerald-400 font-semibold">200 OK</span>
                                        <div class="flex items-center gap-3">
                                            <span class="text-xs text-gray-500" x-text="elapsed ? elapsed + 'ms' : ''"></span>
                                            <button @click="navigator.clipboard.writeText(response)" class="text-gray-500 hover:text-gray-300 transition-colors" title="Copy">
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
                    </div>
                </div>

                {{-- Response Fields --}}
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Response Fields</h2>
                    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wide">
                                <tr>
                                    <th class="text-left px-5 py-3 font-semibold">Field</th>
                                    <th class="text-left px-5 py-3 font-semibold">Type</th>
                                    <th class="text-left px-5 py-3 font-semibold">Description</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr>
                                    <td class="px-5 py-3"><code class="font-mono text-xs bg-gray-100 text-gray-700 px-1.5 py-0.5 rounded">success</code></td>
                                    <td class="px-5 py-3 text-gray-500 text-xs">boolean</td>
                                    <td class="px-5 py-3 text-gray-600 text-xs">Always <code class="font-mono bg-gray-100 px-1 rounded">true</code> for 200 responses.</td>
                                </tr>
                                <tr>
                                    <td class="px-5 py-3"><code class="font-mono text-xs bg-gray-100 text-gray-700 px-1.5 py-0.5 rounded">data.valid</code></td>
                                    <td class="px-5 py-3 text-gray-500 text-xs">boolean</td>
                                    <td class="px-5 py-3 text-gray-600 text-xs">Whether the VAT number is currently active in VIES.</td>
                                </tr>
                                <tr>
                                    <td class="px-5 py-3"><code class="font-mono text-xs bg-gray-100 text-gray-700 px-1.5 py-0.5 rounded">data.country_code</code></td>
                                    <td class="px-5 py-3 text-gray-500 text-xs">string</td>
                                    <td class="px-5 py-3 text-gray-600 text-xs">ISO 2-letter country code echoed back.</td>
                                </tr>
                                <tr>
                                    <td class="px-5 py-3"><code class="font-mono text-xs bg-gray-100 text-gray-700 px-1.5 py-0.5 rounded">data.vat_number</code></td>
                                    <td class="px-5 py-3 text-gray-500 text-xs">string</td>
                                    <td class="px-5 py-3 text-gray-600 text-xs">The VAT number as validated (without prefix).</td>
                                </tr>
                                <tr>
                                    <td class="px-5 py-3"><code class="font-mono text-xs bg-gray-100 text-gray-700 px-1.5 py-0.5 rounded">data.name</code></td>
                                    <td class="px-5 py-3 text-gray-500 text-xs">string|null</td>
                                    <td class="px-5 py-3 text-gray-600 text-xs">Company name returned by VIES. May be <code class="font-mono bg-gray-100 px-1 rounded">N/A</code> if withheld by country.</td>
                                </tr>
                                <tr>
                                    <td class="px-5 py-3"><code class="font-mono text-xs bg-gray-100 text-gray-700 px-1.5 py-0.5 rounded">data.address</code></td>
                                    <td class="px-5 py-3 text-gray-500 text-xs">string|null</td>
                                    <td class="px-5 py-3 text-gray-600 text-xs">Registered address. May be withheld by some countries.</td>
                                </tr>
                                <tr>
                                    <td class="px-5 py-3"><code class="font-mono text-xs bg-gray-100 text-gray-700 px-1.5 py-0.5 rounded">data.source</code></td>
                                    <td class="px-5 py-3 text-gray-500 text-xs">string</td>
                                    <td class="px-5 py-3 text-gray-600 text-xs"><code class="font-mono bg-gray-100 px-1 rounded">vies</code> (live lookup), <code class="font-mono bg-gray-100 px-1 rounded">cache</code>, or <code class="font-mono bg-gray-100 px-1 rounded">database</code> (cached result).</td>
                                </tr>
                                <tr>
                                    <td class="px-5 py-3"><code class="font-mono text-xs bg-gray-100 text-gray-700 px-1.5 py-0.5 rounded">data.request_identifier</code></td>
                                    <td class="px-5 py-3 text-gray-500 text-xs">string|null</td>
                                    <td class="px-5 py-3 text-gray-600 text-xs">VIES consultation reference number for audit purposes.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Error Codes --}}
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Error Responses</h2>
                    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wide">
                                <tr>
                                    <th class="text-left px-5 py-3 font-semibold">HTTP Status</th>
                                    <th class="text-left px-5 py-3 font-semibold">When</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr>
                                    <td class="px-5 py-3"><span class="font-mono text-xs bg-red-50 text-red-700 px-2 py-0.5 rounded font-semibold">422</span></td>
                                    <td class="px-5 py-3 text-gray-600 text-xs">Validation failed — missing or invalid <code class="font-mono bg-gray-100 px-1 rounded">country_code</code> or <code class="font-mono bg-gray-100 px-1 rounded">vat_number</code>. Check the <code class="font-mono bg-gray-100 px-1 rounded">errors</code> field in the response.</td>
                                </tr>
                                <tr>
                                    <td class="px-5 py-3"><span class="font-mono text-xs bg-red-50 text-red-700 px-2 py-0.5 rounded font-semibold">429</span></td>
                                    <td class="px-5 py-3 text-gray-600 text-xs">Too many requests — fair-use rate limit reached. Retry after a brief pause.</td>
                                </tr>
                                <tr>
                                    <td class="px-5 py-3"><span class="font-mono text-xs bg-red-50 text-red-700 px-2 py-0.5 rounded font-semibold">503</span></td>
                                    <td class="px-5 py-3 text-gray-600 text-xs">The upstream VIES system is temporarily unavailable. Check <a href="https://ec.europa.eu/taxation_customs/vies" target="_blank" rel="noopener" class="text-indigo-600 hover:underline">ec.europa.eu/taxation_customs/vies</a> for status.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Code Examples --}}
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Code Examples</h2>
                    <div x-data="{ lang: 'curl' }">
                        <div class="flex gap-2 mb-3 flex-wrap">
                            @foreach(['curl', 'javascript', 'php', 'python'] as $lang)
                                <button @click="lang = '{{ $lang }}'"
                                        :class="lang === '{{ $lang }}' ? 'bg-gray-900 text-white' : 'bg-white text-gray-600 hover:text-gray-900 border border-gray-200'"
                                        class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors">
                                    {{ strtoupper($lang) }}
                                </button>
                            @endforeach
                        </div>

                        <div x-show="lang === 'curl'">
                            <div class="relative bg-gray-900 rounded-xl overflow-hidden">
                                <button onclick="navigator.clipboard.writeText(this.nextElementSibling.textContent.trim())"
                                        class="absolute top-3 right-3 bg-gray-700 hover:bg-gray-600 text-gray-300 p-1.5 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                </button>
                                <pre class="p-5 text-xs font-mono text-gray-300 overflow-x-auto leading-relaxed"><code class="text-yellow-300">curl</code> -X POST {{ $baseUrl }}/api/vat/validation/validate \
  -H <code class="text-green-300">"Content-Type: application/json"</code> \
  -d <code class="text-amber-300">'{"country_code":"LT","vat_number":"100019070512"}'</code></pre>
                            </div>
                        </div>

                        <div x-show="lang === 'javascript'">
                            <div class="relative bg-gray-900 rounded-xl overflow-hidden">
                                <button onclick="navigator.clipboard.writeText(this.nextElementSibling.textContent.trim())"
                                        class="absolute top-3 right-3 bg-gray-700 hover:bg-gray-600 text-gray-300 p-1.5 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                </button>
                                <pre class="p-5 text-xs font-mono overflow-x-auto leading-relaxed"><code class="text-blue-300">const</code> <code class="text-gray-300">response</code> = <code class="text-blue-300">await</code> <code class="text-yellow-300">fetch</code>(<code class="text-green-300">'{{ $baseUrl }}/api/vat/validation/validate'</code>, {
  <code class="text-yellow-300">method</code>: <code class="text-green-300">'POST'</code>,
  <code class="text-yellow-300">headers</code>: { <code class="text-green-300">'Content-Type'</code>: <code class="text-green-300">'application/json'</code> },
  <code class="text-yellow-300">body</code>: <code class="text-blue-300">JSON</code>.<code class="text-yellow-300">stringify</code>({
    <code class="text-yellow-300">country_code</code>: <code class="text-green-300">'LT'</code>,
    <code class="text-yellow-300">vat_number</code>: <code class="text-green-300">'100019070512'</code>
  })
});
<code class="text-blue-300">const</code> <code class="text-gray-300">data</code> = <code class="text-blue-300">await</code> <code class="text-gray-300">response</code>.<code class="text-yellow-300">json</code>();
<code class="text-blue-300">console</code>.<code class="text-yellow-300">log</code>(<code class="text-gray-300">data</code>.<code class="text-gray-300">data</code>.<code class="text-gray-300">valid</code>); <code class="text-gray-500">// true</code></pre>
                            </div>
                        </div>

                        <div x-show="lang === 'php'">
                            <div class="relative bg-gray-900 rounded-xl overflow-hidden">
                                <button onclick="navigator.clipboard.writeText(this.nextElementSibling.textContent.trim())"
                                        class="absolute top-3 right-3 bg-gray-700 hover:bg-gray-600 text-gray-300 p-1.5 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                </button>
                                <pre class="p-5 text-xs font-mono overflow-x-auto leading-relaxed"><code class="text-blue-300">$response</code> = <code class="text-yellow-300">Http</code>::<code class="text-yellow-300">post</code>(<code class="text-green-300">'{{ $baseUrl }}/api/vat/validation/validate'</code>, [
    <code class="text-green-300">'country_code'</code> => <code class="text-green-300">'LT'</code>,
    <code class="text-green-300">'vat_number'</code>  => <code class="text-green-300">'100019070512'</code>,
]);

<code class="text-blue-300">$data</code> = <code class="text-blue-300">$response</code>-><code class="text-yellow-300">json</code>(<code class="text-green-300">'data'</code>);
<code class="text-blue-300">$isValid</code> = <code class="text-blue-300">$data</code>[<code class="text-green-300">'valid'</code>]; <code class="text-gray-500">// true</code></pre>
                            </div>
                        </div>

                        <div x-show="lang === 'python'">
                            <div class="relative bg-gray-900 rounded-xl overflow-hidden">
                                <button onclick="navigator.clipboard.writeText(this.nextElementSibling.textContent.trim())"
                                        class="absolute top-3 right-3 bg-gray-700 hover:bg-gray-600 text-gray-300 p-1.5 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                </button>
                                <pre class="p-5 text-xs font-mono overflow-x-auto leading-relaxed"><code class="text-blue-300">import</code> <code class="text-gray-300">requests</code>

<code class="text-blue-300">res</code> = <code class="text-gray-300">requests</code>.<code class="text-yellow-300">post</code>(
    <code class="text-green-300">"{{ $baseUrl }}/api/vat/validation/validate"</code>,
    <code class="text-yellow-300">json</code>={<code class="text-green-300">"country_code"</code>: <code class="text-green-300">"LT"</code>, <code class="text-green-300">"vat_number"</code>: <code class="text-green-300">"100019070512"</code>}
)
<code class="text-blue-300">data</code> = <code class="text-gray-300">res</code>.<code class="text-yellow-300">json</code>()[<code class="text-green-300">"data"</code>]
<code class="text-blue-300">print</code>(<code class="text-gray-300">data</code>[<code class="text-green-300">"valid"</code>])  <code class="text-gray-500"># True</code></pre>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Sidebar --}}
            <div class="space-y-5">
                {{-- Quick links --}}
                <div class="bg-white rounded-2xl border border-gray-200 p-5">
                    <h3 class="font-bold text-gray-900 text-sm mb-4">On This Page</h3>
                    <nav class="space-y-2 text-sm">
                        <a href="#" class="flex items-center gap-2 text-gray-600 hover:text-indigo-600 transition-colors">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            Base URL
                        </a>
                        <a href="#" class="flex items-center gap-2 text-gray-600 hover:text-indigo-600 transition-colors">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            Endpoints
                        </a>
                        <a href="#" class="flex items-center gap-2 text-gray-600 hover:text-indigo-600 transition-colors">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            Interactive Playground
                        </a>
                        <a href="#" class="flex items-center gap-2 text-gray-600 hover:text-indigo-600 transition-colors">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            Response Fields
                        </a>
                        <a href="#" class="flex items-center gap-2 text-gray-600 hover:text-indigo-600 transition-colors">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            Code Examples
                        </a>
                    </nav>
                </div>

                {{-- Endpoints quick ref --}}
                <div class="bg-gray-50 rounded-2xl border border-gray-200 p-5">
                    <h3 class="font-bold text-gray-900 text-sm mb-3">Quick Reference</h3>
                    <div class="space-y-2">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold bg-indigo-100 text-indigo-700 px-1.5 py-0.5 rounded shrink-0">POST</span>
                            <code class="text-xs font-mono text-gray-700 break-all">/api/vat/validation/validate</code>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold bg-indigo-100 text-indigo-700 px-1.5 py-0.5 rounded shrink-0">POST</span>
                            <code class="text-xs font-mono text-gray-700 break-all">/api/vat/validation/batch</code>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold bg-green-100 text-green-700 px-1.5 py-0.5 rounded shrink-0">GET</span>
                            <code class="text-xs font-mono text-gray-700 break-all">/api/vat/validation/health</code>
                        </div>
                    </div>
                </div>

                {{-- Also available via JSON API --}}
                <div class="bg-white rounded-2xl border border-gray-200 p-5">
                    <h3 class="font-bold text-gray-900 text-sm mb-3">VAT Rates JSON API</h3>
                    <p class="text-xs text-gray-500 mb-3">Need VAT rates (not validation)? Use our rates API.</p>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-xs font-bold bg-green-100 text-green-700 px-1.5 py-0.5 rounded shrink-0">GET</span>
                        <code class="text-xs font-mono text-gray-700">/api/countries</code>
                    </div>
                    <a href="/api/countries" target="_blank"
                       class="inline-flex items-center gap-1 text-xs text-indigo-600 hover:text-indigo-800 font-medium transition-colors">
                        Open API <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                {{-- Related --}}
                <div class="bg-gradient-to-br from-indigo-50 to-blue-50 rounded-2xl border border-indigo-200 p-5 space-y-3">
                    <h3 class="font-bold text-indigo-900 text-sm">Related</h3>
                    <a href="{{ locale_path('/vat-number-validator') }}" class="flex items-center gap-2 text-sm text-indigo-700 hover:text-indigo-900 transition-colors">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        VAT Number Validator (UI)
                    </a>
                    <a href="{{ locale_path('/mcp-server') }}" class="flex items-center gap-2 text-sm text-indigo-700 hover:text-indigo-900 transition-colors">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m9.86-2.814a4.5 4.5 0 00-1.242-7.244l4.5-4.5a4.5 4.5 0 016.364 6.364l-1.757 1.757"/></svg>
                        MCP Server (AI Integration)
                    </a>
                    <a href="{{ locale_path('/tools') }}" class="flex items-center gap-2 text-sm text-indigo-700 hover:text-indigo-900 transition-colors">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        All VAT Tools
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
