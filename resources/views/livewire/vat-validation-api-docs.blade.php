@section('seo')
    <x-seo-meta
        title="EU VAT Number Validation API — Free REST API Documentation"
        description="Free REST API to validate EU VAT numbers in real-time via the official VIES database. Single and batch validation, CORS headers, no API key required."
        type="website"
        :url="url()->current()">
        <x-json-ld :data="[
            '@type' => 'WebAPI',
            'name' => 'EU VAT Info API',
            'description' => 'Free REST API for EU VAT rates, VAT calculations and VIES VAT number validation. No API key required.',
            'url' => url()->current(),
            'documentation' => url()->current(),
            'isAccessibleForFree' => true,
            'provider' => ['@type' => 'Organization', 'name' => 'EU VAT Info', 'url' => url('/')],
            'subjectOf' => ['@type' => 'CreativeWork', 'name' => 'OpenAPI description', 'url' => url('/api/v1/openapi.json'), 'encodingFormat' => 'application/vnd.oai.openapi+json'],
        ]" />
        <x-json-ld :data="[
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => __('ui.site_name'), 'item' => url(locale_path('/'))],
                ['@type' => 'ListItem', 'position' => 2, 'name' => __('ui.nav.api'), 'item' => url()->current()],
            ],
        ]" />
    </x-seo-meta>
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
    <div class="hero-canvas">
        <x-hero-backdrop />
        <div class="relative mx-auto w-full max-w-5xl px-4 py-14 sm:px-6 sm:py-20">
            <x-site-breadcrumbs :items="[__('ui.vies_page.nav_title') => locale_path('/vat-number-validator'), 'API Documentation' => '']" variant="dark" />
            <div class="max-w-3xl mt-4">
                <p class="app-kicker mb-4">REST API · No Auth Required · Free</p>
                <h1 class="mb-3 text-3xl font-bold tracking-[-0.03em] sm:text-4xl">EU VAT Validation API</h1>
                <p class="text-white/85 text-base sm:text-lg max-w-2xl leading-relaxed mb-8">
                    Validate EU VAT numbers programmatically against the official VIES database. Free to use, no API key, CORS enabled.
                </p>

                <div class="grid sm:grid-cols-3 gap-4">
                    <div class="app-brand-panel p-4">
                        <div class="tabular mb-1 text-2xl font-bold">Free</div>
                        <div class="text-sm text-white/70">No API key or account needed</div>
                    </div>
                    <div class="app-brand-panel p-4">
                        <div class="tabular mb-1 text-2xl font-bold">10 / batch</div>
                        <div class="text-sm text-white/70">Validate up to 10 numbers at once</div>
                    </div>
                    <div class="app-brand-panel p-4">
                        <div class="tabular mb-1 text-2xl font-bold">27 Countries</div>
                        <div class="text-sm text-white/70">All EU member states supported</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mx-auto w-full max-w-5xl px-4 py-12 sm:px-6">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
            {{-- Left: Docs + Simulator --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- Base URL --}}
                <div>
                    <h2 class="text-xl font-bold text-ink mb-4">Base URL</h2>
                    <div class="bg-code rounded-card p-4 flex items-center gap-3">
                        <code class="text-syntax-ok font-mono text-sm flex-1">{{ $baseUrl }}</code>
                        <button onclick="navigator.clipboard.writeText('{{ $baseUrl }}')"
                                class="shrink-0 p-1.5 bg-code-muted hover:bg-white/15 text-white/75 rounded-control transition-colors" title="Copy">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                        </button>
                    </div>
                    <p class="text-xs text-ink-muted mt-2">All endpoints are relative to this base URL. Use HTTPS in production.</p>
                </div>

                {{-- Endpoints --}}
                <div>
                    <h2 class="text-xl font-bold text-ink mb-4">Endpoints</h2>

                    {{-- Single validate --}}
                    <div class="bg-surface rounded-card border border-line overflow-hidden mb-4">
                        <div class="flex items-center gap-3 px-5 py-4 border-b border-line bg-surface-subtle">
                            <span class="bg-action-soft text-action text-xs font-bold px-2.5 py-1 rounded-control">POST</span>
                            <code class="font-mono text-sm text-ink">/api/vat/validation/validate</code>
                        </div>
                        <div class="p-5 space-y-4">
                            <p class="text-sm text-ink-muted">Validate a single EU VAT number in real-time against the VIES database. Results are cached for 7 days for performance.</p>

                            <div>
                                <p class="text-xs font-bold text-ink-muted uppercase tracking-wider mb-2">Request Body</p>
                                <div class="relative overflow-x-auto rounded-card border border-line">
                                    <table class="w-full text-sm">
                                        <thead class="bg-surface-subtle text-xs text-ink-muted uppercase tracking-wide">
                                            <tr>
                                                <th class="text-left px-4 py-2.5 font-semibold">Parameter</th>
                                                <th class="text-left px-4 py-2.5 font-semibold">Type</th>
                                                <th class="text-left px-4 py-2.5 font-semibold">Required</th>
                                                <th class="text-left px-4 py-2.5 font-semibold">Description</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-line">
                                            <tr>
                                                <td class="px-4 py-3"><code class="text-action font-mono text-xs bg-action-soft px-1.5 py-0.5 rounded-sm">country_code</code></td>
                                                <td class="px-4 py-3 text-ink-muted text-xs">string</td>
                                                <td class="px-4 py-3"><span class="text-danger font-semibold text-xs">required</span></td>
                                                <td class="px-4 py-3 text-ink-muted text-xs">2-letter ISO code (e.g. <code class="font-mono bg-surface-muted px-1 rounded-sm">LT</code>, <code class="font-mono bg-surface-muted px-1 rounded-sm">DE</code>). Greece uses <code class="font-mono bg-surface-muted px-1 rounded-sm">EL</code>.</td>
                                            </tr>
                                            <tr>
                                                <td class="px-4 py-3"><code class="text-action font-mono text-xs bg-action-soft px-1.5 py-0.5 rounded-sm">vat_number</code></td>
                                                <td class="px-4 py-3 text-ink-muted text-xs">string</td>
                                                <td class="px-4 py-3"><span class="text-danger font-semibold text-xs">required</span></td>
                                                <td class="px-4 py-3 text-ink-muted text-xs">VAT number without the country prefix (e.g. <code class="font-mono bg-surface-muted px-1 rounded-sm">100019070512</code> not <code class="font-mono bg-surface-muted px-1 rounded-sm">LT100019070512</code>).</td>
                                            </tr>
                                            <tr>
                                                <td class="px-4 py-3"><code class="text-action font-mono text-xs bg-action-soft px-1.5 py-0.5 rounded-sm">company_name</code></td>
                                                <td class="px-4 py-3 text-ink-muted text-xs">string</td>
                                                <td class="px-4 py-3"><span class="text-ink-quiet text-xs">optional</span></td>
                                                <td class="px-4 py-3 text-ink-muted text-xs">Expected company name for fuzzy matching verification.</td>
                                            </tr>
                                            <tr>
                                                <td class="px-4 py-3"><code class="text-action font-mono text-xs bg-action-soft px-1.5 py-0.5 rounded-sm">address</code></td>
                                                <td class="px-4 py-3 text-ink-muted text-xs">string</td>
                                                <td class="px-4 py-3"><span class="text-ink-quiet text-xs">optional</span></td>
                                                <td class="px-4 py-3 text-ink-muted text-xs">Expected address for additional verification.</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="grid sm:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs font-bold text-ink-muted uppercase tracking-wider mb-2">Example Request</p>
                                    <div tabindex="0" class="bg-code rounded-card p-4 font-mono text-xs overflow-x-auto">
                                        <p class="text-white/55 mb-2">curl -X POST {{ $baseUrl }}/api/vat/validation/validate \</p>
                                        <p class="text-white/55 ml-2">-H "Content-Type: application/json" \</p>
                                        <p class="text-white/55 ml-2">-d '</p>
                                        <p class="text-syntax-literal ml-2">{</p>
                                        <p class="text-syntax-literal ml-4">"country_code": "LT",</p>
                                        <p class="text-syntax-literal ml-4">"vat_number": "100019070512"</p>
                                        <p class="text-syntax-literal ml-2">}'</p>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-ink-muted uppercase tracking-wider mb-2">Example Response</p>
                                    <div tabindex="0" class="bg-code rounded-card p-4 font-mono text-xs overflow-x-auto">
                                        <pre class="text-syntax-string">{
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
                    <div class="bg-surface rounded-card border border-line overflow-hidden mb-4">
                        <div class="flex items-center gap-3 px-5 py-4 border-b border-line bg-surface-subtle">
                            <span class="bg-action-soft text-action text-xs font-bold px-2.5 py-1 rounded-control">POST</span>
                            <code class="font-mono text-sm text-ink">/api/vat/validation/batch</code>
                            <span class="app-badge ml-auto bg-warning-soft text-warning">max 10</span>
                        </div>
                        <div class="p-5 space-y-4">
                            <p class="text-sm text-ink-muted">Validate up to 10 VAT numbers in a single request. Each number is validated independently against VIES.</p>

                            <div class="grid sm:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs font-bold text-ink-muted uppercase tracking-wider mb-2">Example Request</p>
                                    <div tabindex="0" class="bg-code rounded-card p-4 font-mono text-xs overflow-x-auto">
                                        <pre class="text-syntax-literal">{
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
                                    <p class="text-xs font-bold text-ink-muted uppercase tracking-wider mb-2">Example Response</p>
                                    <div tabindex="0" class="bg-code rounded-card p-4 font-mono text-xs overflow-x-auto">
                                        <pre class="text-syntax-string">{
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
                    <div class="bg-surface rounded-card border border-line overflow-hidden">
                        <div class="flex items-center gap-3 px-5 py-4 border-b border-line bg-surface-subtle">
                            <span class="bg-success-soft text-success text-xs font-bold px-2.5 py-1 rounded-control">GET</span>
                            <code class="font-mono text-sm text-ink">/api/vat/validation/health</code>
                        </div>
                        <div class="p-5">
                            <p class="text-sm text-ink-muted mb-3">Check the operational status of the VAT validation service.</p>
                            <div class="bg-code rounded-card p-4 font-mono text-xs">
                                <pre class="text-syntax-string">{
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
                    <h2 class="text-xl font-bold text-ink mb-4">Interactive Playground</h2>
                    <div class="bg-surface rounded-card border border-line overflow-visible">
                        {{-- Tab toggle --}}
                        <div class="flex border-b border-line">
                            <button @click="tab = 'single'; response = null; error = null"
                                    :class="tab === 'single' ? 'border-b-2 border-action text-action bg-action-soft' : 'text-ink-muted hover:text-ink'"
                                    class="flex-1 sm:flex-none px-5 py-3 text-sm font-semibold transition-colors">
                                Single Validation
                            </button>
                            <button @click="tab = 'batch'; response = null; error = null"
                                    :class="tab === 'batch' ? 'border-b-2 border-action text-action bg-action-soft' : 'text-ink-muted hover:text-ink'"
                                    class="flex-1 sm:flex-none px-5 py-3 text-sm font-semibold transition-colors">
                                Batch (demo)
                            </button>
                        </div>

                        <div class="p-5 space-y-4">
                            {{-- Inputs --}}
                            <div class="grid sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-medium text-ink-muted mb-1">country_code</label>
                                    <input x-model="simCountry" type="text" maxlength="2" placeholder="LT"
                                           class="w-full px-3 py-2.5 text-sm border border-line-strong rounded-card font-mono focus:ring-2 focus:ring-action/40 focus:border-action/60 uppercase bg-surface-subtle">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-ink-muted mb-1">vat_number</label>
                                    <input x-model="simVat" type="text" placeholder="100019070512"
                                           @keydown.enter="runRequest()"
                                           class="w-full px-3 py-2.5 text-sm border border-line-strong rounded-card font-mono focus:ring-2 focus:ring-action/40 focus:border-action/60 bg-surface-subtle">
                                </div>
                            </div>
                            <p x-show="tab === 'batch'" class="text-xs text-ink-muted bg-warning-soft border border-warning/30 rounded-control px-3 py-2">
                                Batch demo will validate the above number + a static DE example to show the multi-result response format.
                            </p>

                            {{-- Request preview + Send button --}}
                            <div class="bg-code rounded-t-card overflow-hidden">
                                <div class="flex items-center justify-between px-4 py-2.5 border-b border-white/10">
                                    <div class="flex items-center gap-2 text-xs text-white/55">
                                        <span class="text-syntax-ok font-mono font-semibold">POST</span>
                                        <span class="font-mono" x-text="currentEndpoint"></span>
                                    </div>
                                    <button @click="runRequest()" :disabled="loading"
                                            class="flex items-center gap-1.5 bg-button hover:bg-button-hover disabled:bg-white/15 disabled:cursor-not-allowed text-white text-xs font-semibold px-3 py-1.5 rounded-control transition-colors">
                                        <svg x-show="!loading" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 3l14 9-14 9V3z" /></svg>
                                        <svg x-show="loading" class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" /><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" /></svg>
                                        <span x-text="loading ? 'Sending…' : 'Send Request'"></span>
                                    </button>
                                </div>
                                <pre tabindex="0" class="p-4 text-xs font-mono text-syntax-literal overflow-x-auto" x-text="requestBody"></pre>
                            </div>

                            {{-- Response --}}
                            <div class="bg-code rounded-b-card border border-white/10 border-t-0 min-h-[100px]">
                                <div x-show="!response && !error && !loading" class="p-4 text-xs text-syntax-comment font-mono">
                                    // Response will appear here after you click Send Request
                                </div>
                                <div x-show="loading" class="p-4 text-xs text-white/45 font-mono flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 animate-spin text-syntax-keyword" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" /><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" /></svg>
                                    Sending request to VIES…
                                </div>
                                <div x-show="response">
                                    <div class="flex items-center justify-between px-4 py-2.5 border-b border-white/10">
                                        <span class="text-xs text-syntax-ok font-semibold">200 OK</span>
                                        <div class="flex items-center gap-3">
                                            <span class="text-xs text-white/45" x-text="elapsed ? elapsed + 'ms' : ''"></span>
                                            <button @click="navigator.clipboard.writeText(response)" class="text-white/45 hover:text-white/75 transition-colors" title="Copy">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                                            </button>
                                        </div>
                                    </div>
                                    <pre tabindex="0" class="p-4 text-xs font-mono text-syntax-string overflow-x-auto" x-text="response"></pre>
                                </div>
                                <div x-show="error" class="p-4">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="text-xs text-syntax-error font-semibold">Error</span>
                                    </div>
                                    <pre tabindex="0" class="text-xs font-mono text-syntax-error overflow-x-auto" x-text="error"></pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Response Fields --}}
                <div>
                    <h2 class="text-xl font-bold text-ink mb-4">Response Fields</h2>
                    <div class="bg-surface rounded-card border border-line overflow-hidden">
                        <table class="w-full text-sm">
                            <thead class="bg-surface-subtle text-xs text-ink-muted uppercase tracking-wide">
                                <tr>
                                    <th class="text-left px-5 py-3 font-semibold">Field</th>
                                    <th class="text-left px-5 py-3 font-semibold">Type</th>
                                    <th class="text-left px-5 py-3 font-semibold">Description</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-line">
                                <tr>
                                    <td class="px-5 py-3"><code class="font-mono text-xs bg-surface-muted text-ink-muted px-1.5 py-0.5 rounded-sm">success</code></td>
                                    <td class="px-5 py-3 text-ink-muted text-xs">boolean</td>
                                    <td class="px-5 py-3 text-ink-muted text-xs">Always <code class="font-mono bg-surface-muted px-1 rounded-sm">true</code> for 200 responses.</td>
                                </tr>
                                <tr>
                                    <td class="px-5 py-3"><code class="font-mono text-xs bg-surface-muted text-ink-muted px-1.5 py-0.5 rounded-sm">data.valid</code></td>
                                    <td class="px-5 py-3 text-ink-muted text-xs">boolean</td>
                                    <td class="px-5 py-3 text-ink-muted text-xs">Whether the VAT number is currently active in VIES.</td>
                                </tr>
                                <tr>
                                    <td class="px-5 py-3"><code class="font-mono text-xs bg-surface-muted text-ink-muted px-1.5 py-0.5 rounded-sm">data.country_code</code></td>
                                    <td class="px-5 py-3 text-ink-muted text-xs">string</td>
                                    <td class="px-5 py-3 text-ink-muted text-xs">ISO 2-letter country code echoed back.</td>
                                </tr>
                                <tr>
                                    <td class="px-5 py-3"><code class="font-mono text-xs bg-surface-muted text-ink-muted px-1.5 py-0.5 rounded-sm">data.vat_number</code></td>
                                    <td class="px-5 py-3 text-ink-muted text-xs">string</td>
                                    <td class="px-5 py-3 text-ink-muted text-xs">The VAT number as validated (without prefix).</td>
                                </tr>
                                <tr>
                                    <td class="px-5 py-3"><code class="font-mono text-xs bg-surface-muted text-ink-muted px-1.5 py-0.5 rounded-sm">data.name</code></td>
                                    <td class="px-5 py-3 text-ink-muted text-xs">string|null</td>
                                    <td class="px-5 py-3 text-ink-muted text-xs">Company name returned by VIES. May be <code class="font-mono bg-surface-muted px-1 rounded-sm">N/A</code> if withheld by country.</td>
                                </tr>
                                <tr>
                                    <td class="px-5 py-3"><code class="font-mono text-xs bg-surface-muted text-ink-muted px-1.5 py-0.5 rounded-sm">data.address</code></td>
                                    <td class="px-5 py-3 text-ink-muted text-xs">string|null</td>
                                    <td class="px-5 py-3 text-ink-muted text-xs">Registered address. May be withheld by some countries.</td>
                                </tr>
                                <tr>
                                    <td class="px-5 py-3"><code class="font-mono text-xs bg-surface-muted text-ink-muted px-1.5 py-0.5 rounded-sm">data.source</code></td>
                                    <td class="px-5 py-3 text-ink-muted text-xs">string</td>
                                    <td class="px-5 py-3 text-ink-muted text-xs"><code class="font-mono bg-surface-muted px-1 rounded-sm">vies</code> (live lookup), <code class="font-mono bg-surface-muted px-1 rounded-sm">cache</code>, or <code class="font-mono bg-surface-muted px-1 rounded-sm">database</code> (cached result).</td>
                                </tr>
                                <tr>
                                    <td class="px-5 py-3"><code class="font-mono text-xs bg-surface-muted text-ink-muted px-1.5 py-0.5 rounded-sm">data.request_identifier</code></td>
                                    <td class="px-5 py-3 text-ink-muted text-xs">string|null</td>
                                    <td class="px-5 py-3 text-ink-muted text-xs">VIES consultation reference number for audit purposes.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Error Codes --}}
                <div>
                    <h2 class="text-xl font-bold text-ink mb-4">Error Responses</h2>
                    <div class="bg-surface rounded-card border border-line overflow-hidden">
                        <table class="w-full text-sm">
                            <thead class="bg-surface-subtle text-xs text-ink-muted uppercase tracking-wide">
                                <tr>
                                    <th class="text-left px-5 py-3 font-semibold">HTTP Status</th>
                                    <th class="text-left px-5 py-3 font-semibold">When</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-line">
                                <tr>
                                    <td class="px-5 py-3"><span class="font-mono text-xs bg-danger-soft text-danger px-2 py-0.5 rounded-sm font-semibold">422</span></td>
                                    <td class="px-5 py-3 text-ink-muted text-xs">Validation failed — missing or invalid <code class="font-mono bg-surface-muted px-1 rounded-sm">country_code</code> or <code class="font-mono bg-surface-muted px-1 rounded-sm">vat_number</code>. Check the <code class="font-mono bg-surface-muted px-1 rounded-sm">errors</code> field in the response.</td>
                                </tr>
                                <tr>
                                    <td class="px-5 py-3"><span class="font-mono text-xs bg-danger-soft text-danger px-2 py-0.5 rounded-sm font-semibold">429</span></td>
                                    <td class="px-5 py-3 text-ink-muted text-xs">Too many requests — fair-use rate limit reached. Retry after a brief pause.</td>
                                </tr>
                                <tr>
                                    <td class="px-5 py-3"><span class="font-mono text-xs bg-danger-soft text-danger px-2 py-0.5 rounded-sm font-semibold">503</span></td>
                                    <td class="px-5 py-3 text-ink-muted text-xs">The upstream VIES system is temporarily unavailable. Check <a href="https://ec.europa.eu/taxation_customs/vies" target="_blank" rel="noopener" class="font-medium text-action underline underline-offset-2 hover:decoration-2">ec.europa.eu/taxation_customs/vies</a> for status.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Code Examples --}}
                <div>
                    <h2 class="text-xl font-bold text-ink mb-4">Code Examples</h2>
                    <div x-data="{ lang: 'curl' }">
                        <div class="flex gap-2 mb-3 flex-wrap">
                            @foreach(['curl', 'javascript', 'php', 'python'] as $lang)
                                <button @click="lang = '{{ $lang }}'"
                                        :class="lang === '{{ $lang }}' ? 'bg-code text-white' : 'bg-surface text-ink-muted hover:text-ink border border-line'"
                                        class="px-3 py-1.5 rounded-control text-xs font-semibold transition-colors">
                                    {{ strtoupper($lang) }}
                                </button>
                            @endforeach
                        </div>

                        <div x-show="lang === 'curl'">
                            <div class="relative bg-code rounded-card overflow-hidden">
                                <button onclick="navigator.clipboard.writeText(this.nextElementSibling.textContent.trim())" aria-label="{{ __('ui.calculator.copy') }}"
                                        class="absolute top-3 right-3 bg-code-muted hover:bg-white/15 text-white/75 p-1.5 rounded-control transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                                </button>
                                <pre tabindex="0" class="p-5 text-xs font-mono text-white/75 overflow-x-auto leading-relaxed"><code class="text-syntax-function">curl</code> -X POST {{ $baseUrl }}/api/vat/validation/validate \
  -H <code class="text-syntax-string">"Content-Type: application/json"</code> \
  -d <code class="text-syntax-literal">'{"country_code":"LT","vat_number":"100019070512"}'</code></pre>
                            </div>
                        </div>

                        <div x-show="lang === 'javascript'">
                            <div class="relative bg-code rounded-card overflow-hidden">
                                <button onclick="navigator.clipboard.writeText(this.nextElementSibling.textContent.trim())" aria-label="{{ __('ui.calculator.copy') }}"
                                        class="absolute top-3 right-3 bg-code-muted hover:bg-white/15 text-white/75 p-1.5 rounded-control transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                                </button>
                                <pre tabindex="0" class="p-5 text-xs font-mono overflow-x-auto leading-relaxed"><code class="text-syntax-keyword">const</code> <code class="text-white/75">response</code> = <code class="text-syntax-keyword">await</code> <code class="text-syntax-function">fetch</code>(<code class="text-syntax-string">'{{ $baseUrl }}/api/vat/validation/validate'</code>, {
  <code class="text-syntax-function">method</code>: <code class="text-syntax-string">'POST'</code>,
  <code class="text-syntax-function">headers</code>: { <code class="text-syntax-string">'Content-Type'</code>: <code class="text-syntax-string">'application/json'</code> },
  <code class="text-syntax-function">body</code>: <code class="text-syntax-keyword">JSON</code>.<code class="text-syntax-function">stringify</code>({
    <code class="text-syntax-function">country_code</code>: <code class="text-syntax-string">'LT'</code>,
    <code class="text-syntax-function">vat_number</code>: <code class="text-syntax-string">'100019070512'</code>
  })
});
<code class="text-syntax-keyword">const</code> <code class="text-white/75">data</code> = <code class="text-syntax-keyword">await</code> <code class="text-white/75">response</code>.<code class="text-syntax-function">json</code>();
<code class="text-syntax-keyword">console</code>.<code class="text-syntax-function">log</code>(<code class="text-white/75">data</code>.<code class="text-white/75">data</code>.<code class="text-white/75">valid</code>); <code class="text-white/45">// true</code></pre>
                            </div>
                        </div>

                        <div x-show="lang === 'php'">
                            <div class="relative bg-code rounded-card overflow-hidden">
                                <button onclick="navigator.clipboard.writeText(this.nextElementSibling.textContent.trim())" aria-label="{{ __('ui.calculator.copy') }}"
                                        class="absolute top-3 right-3 bg-code-muted hover:bg-white/15 text-white/75 p-1.5 rounded-control transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                                </button>
                                <pre tabindex="0" class="p-5 text-xs font-mono overflow-x-auto leading-relaxed"><code class="text-syntax-keyword">$response</code> = <code class="text-syntax-function">Http</code>::<code class="text-syntax-function">post</code>(<code class="text-syntax-string">'{{ $baseUrl }}/api/vat/validation/validate'</code>, [
    <code class="text-syntax-string">'country_code'</code> => <code class="text-syntax-string">'LT'</code>,
    <code class="text-syntax-string">'vat_number'</code>  => <code class="text-syntax-string">'100019070512'</code>,
]);

<code class="text-syntax-keyword">$data</code> = <code class="text-syntax-keyword">$response</code>-><code class="text-syntax-function">json</code>(<code class="text-syntax-string">'data'</code>);
<code class="text-syntax-keyword">$isValid</code> = <code class="text-syntax-keyword">$data</code>[<code class="text-syntax-string">'valid'</code>]; <code class="text-white/45">// true</code></pre>
                            </div>
                        </div>

                        <div x-show="lang === 'python'">
                            <div class="relative bg-code rounded-card overflow-hidden">
                                <button onclick="navigator.clipboard.writeText(this.nextElementSibling.textContent.trim())" aria-label="{{ __('ui.calculator.copy') }}"
                                        class="absolute top-3 right-3 bg-code-muted hover:bg-white/15 text-white/75 p-1.5 rounded-control transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                                </button>
                                <pre tabindex="0" class="p-5 text-xs font-mono overflow-x-auto leading-relaxed"><code class="text-syntax-keyword">import</code> <code class="text-white/75">requests</code>

<code class="text-syntax-keyword">res</code> = <code class="text-white/75">requests</code>.<code class="text-syntax-function">post</code>(
    <code class="text-syntax-string">"{{ $baseUrl }}/api/vat/validation/validate"</code>,
    <code class="text-syntax-function">json</code>={<code class="text-syntax-string">"country_code"</code>: <code class="text-syntax-string">"LT"</code>, <code class="text-syntax-string">"vat_number"</code>: <code class="text-syntax-string">"100019070512"</code>}
)
<code class="text-syntax-keyword">data</code> = <code class="text-white/75">res</code>.<code class="text-syntax-function">json</code>()[<code class="text-syntax-string">"data"</code>]
<code class="text-syntax-keyword">print</code>(<code class="text-white/75">data</code>[<code class="text-syntax-string">"valid"</code>])  <code class="text-white/45"># True</code></pre>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Sidebar --}}
            <div class="space-y-5">
                {{-- Quick links --}}
                <div class="bg-surface rounded-card border border-line p-5">
                    <h3 class="font-bold text-ink text-sm mb-4">On This Page</h3>
                    <nav class="space-y-2 text-sm">
                        <a href="#" class="flex items-center gap-2 text-ink-muted hover:text-action transition-colors">
                            <svg class="w-3.5 h-3.5 text-ink-quiet" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                            Base URL
                        </a>
                        <a href="#" class="flex items-center gap-2 text-ink-muted hover:text-action transition-colors">
                            <svg class="w-3.5 h-3.5 text-ink-quiet" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                            Endpoints
                        </a>
                        <a href="#" class="flex items-center gap-2 text-ink-muted hover:text-action transition-colors">
                            <svg class="w-3.5 h-3.5 text-ink-quiet" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                            Interactive Playground
                        </a>
                        <a href="#" class="flex items-center gap-2 text-ink-muted hover:text-action transition-colors">
                            <svg class="w-3.5 h-3.5 text-ink-quiet" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                            Response Fields
                        </a>
                        <a href="#" class="flex items-center gap-2 text-ink-muted hover:text-action transition-colors">
                            <svg class="w-3.5 h-3.5 text-ink-quiet" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                            Code Examples
                        </a>
                    </nav>
                </div>

                {{-- Endpoints quick ref --}}
                <div class="bg-surface-subtle rounded-card border border-line p-5">
                    <h3 class="font-bold text-ink text-sm mb-3">Quick Reference</h3>
                    <div class="space-y-2">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold bg-action-soft text-action px-1.5 py-0.5 rounded-sm shrink-0">POST</span>
                            <code class="text-xs font-mono text-ink-muted break-all">/api/vat/validation/validate</code>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold bg-action-soft text-action px-1.5 py-0.5 rounded-sm shrink-0">POST</span>
                            <code class="text-xs font-mono text-ink-muted break-all">/api/vat/validation/batch</code>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold bg-success-soft text-success px-1.5 py-0.5 rounded-sm shrink-0">GET</span>
                            <code class="text-xs font-mono text-ink-muted break-all">/api/vat/validation/health</code>
                        </div>
                    </div>
                </div>

                {{-- Also available via JSON API --}}
                <div class="bg-surface rounded-card border border-line p-5">
                    <h3 class="font-bold text-ink text-sm mb-3">VAT Rates JSON API</h3>
                    <p class="text-xs text-ink-muted mb-3">Need VAT rates (not validation)? Use our rates API.</p>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-xs font-bold bg-success-soft text-success px-1.5 py-0.5 rounded-sm shrink-0">GET</span>
                        <code class="text-xs font-mono text-ink-muted">/api/countries</code>
                    </div>
                    <a href="/api/countries" target="_blank"
                       class="inline-flex items-center gap-1 text-xs text-action hover:text-action-deep font-medium transition-colors">
                        Open API <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>
                    </a>
                </div>

                {{-- Related --}}
                <div class="bg-action-soft rounded-card border border-action/25 p-5 space-y-3">
                    <h3 class="font-bold text-action-deep text-sm">Related</h3>
                    <a href="{{ locale_path('/vat-number-validator') }}" class="flex items-center gap-2 text-sm text-action hover:text-action-deep transition-colors">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        VAT Number Validator (UI)
                    </a>
                    <a href="{{ locale_path('/mcp-server') }}" class="flex items-center gap-2 text-sm text-action hover:text-action-deep transition-colors">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m9.86-2.814a4.5 4.5 0 00-1.242-7.244l4.5-4.5a4.5 4.5 0 016.364 6.364l-1.757 1.757" /></svg>
                        MCP Server (AI Integration)
                    </a>
                    <a href="{{ locale_path('/tools') }}" class="flex items-center gap-2 text-sm text-action hover:text-action-deep transition-colors">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                        All VAT Tools
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
