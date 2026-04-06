@section('seo')
    <x-seo-meta
        title="VIES VAT Number Validator — Verify EU VAT Numbers Online"
        description="Free VIES VAT number validation tool. Verify any EU VAT number instantly using the official European Commission VIES database. Check company name, address, and validity."
        type="website"
    />
@endsection

<div class="mx-auto max-w-5xl px-4 py-8 sm:py-12">

    {{-- Breadcrumbs --}}
    <nav class="flex items-center gap-1.5 text-sm text-gray-400 mb-8 flex-wrap" aria-label="Breadcrumb">
        <a href="{{ locale_path('/') }}" class="hover:text-blue-600 transition-colors">Home</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
        <span class="text-gray-600 font-medium">VIES VAT Validator</span>
    </nav>

    {{-- Hero --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-900 via-indigo-800 to-indigo-900 text-white mb-8">
        <div class="absolute inset-0 opacity-5">
            <svg width="100%" height="100%"><defs><pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="0.5"/></pattern></defs><rect width="100%" height="100%" fill="url(#grid)"/></svg>
        </div>

        <div class="relative p-6 sm:p-10">
            <h1 class="text-2xl sm:text-3xl font-extrabold mb-2">VIES VAT Number Validator</h1>
            <p class="text-indigo-200 text-sm mb-6">Verify any EU VAT number using the official European Commission VIES database. Results are cached for faster lookups.</p>

            <form wire:submit.prevent="validateVat" class="space-y-4">
                <div class="grid sm:grid-cols-4 gap-4">
                    <div class="sm:col-span-1">
                        <label class="block text-xs font-semibold text-indigo-200 mb-1.5">Country</label>
                        <select wire:model="country_code" class="w-full rounded-xl bg-white/10 border border-white/20 text-white px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-400 focus:border-transparent">
                            <option value="">Select country</option>
                            @foreach($countries as $c)
                                <option value="{{ $c->iso_code }}">{{ $c->iso_code }} — {{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-indigo-200 mb-1.5">VAT Number</label>
                        <input type="text" wire:model="vat_number" placeholder="e.g. 123456789" class="w-full rounded-xl bg-white/10 border border-white/20 text-white placeholder-indigo-300/50 px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-400 focus:border-transparent">
                    </div>
                    <div class="sm:col-span-1 flex items-end">
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-white text-indigo-900 rounded-xl text-sm font-bold hover:bg-indigo-50 transition-all shadow-lg" wire:loading.class="opacity-50" wire:target="validateVat">
                            <svg wire:loading.remove wire:target="validateVat" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                            <svg wire:loading wire:target="validateVat" class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                            Validate
                        </button>
                    </div>
                </div>
                <p class="text-xs text-indigo-300/70">
                    Need an example?
                    <button type="button" wire:click="prefillExample" class="text-indigo-200 hover:text-white underline">Try LT100019070512</button>
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
        <div class="mb-8 bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden" wire:transition>
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
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="font-semibold text-sm text-gray-900 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5" /></svg>
                        VAT Validation API
                    </h2>
                </div>
                <div class="p-6 space-y-4">
                    <p class="text-sm text-gray-600">Integrate VAT validation into your application with our REST API. Results are cached from the official VIES database for reliable, fast responses.</p>

                    <div class="space-y-3">
                        <div>
                            <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Single Validation</h3>
                            <div class="bg-gray-900 rounded-xl p-4 font-mono text-xs text-gray-300 overflow-x-auto">
                                <p class="text-emerald-400">POST /api/vat/validate</p>
                                <p class="text-gray-500 mt-2">Content-Type: application/json</p>
                                <pre class="mt-2 text-amber-300">{
  "country_code": "LT",
  "vat_number": "100019070512"
}</pre>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Batch Validation (up to 10)</h3>
                            <div class="bg-gray-900 rounded-xl p-4 font-mono text-xs text-gray-300 overflow-x-auto">
                                <p class="text-emerald-400">POST /api/vat/batch</p>
                                <pre class="mt-2 text-amber-300">{
  "vat_numbers": [
    { "country_code": "LT", "vat_number": "100019070512" },
    { "country_code": "DE", "vat_number": "123456789" }
  ]
}</pre>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Response</h3>
                            <div class="bg-gray-900 rounded-xl p-4 font-mono text-xs text-gray-300 overflow-x-auto">
                                <pre class="text-amber-300">{
  "valid": true,
  "country_code": "LT",
  "vat_number": "100019070512",
  "name": "Company Name",
  "address": "Company Address",
  "request_identifier": "..."
}</pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- What is VIES --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="font-semibold text-sm text-gray-900 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" /></svg>
                        What is VIES?
                    </h2>
                </div>
                <div class="p-6 text-sm text-gray-700 space-y-3">
                    <p><strong>VIES (VAT Information Exchange System)</strong> is the official European Commission service for verifying VAT identification numbers of businesses registered in EU member states.</p>
                    <p>When you validate a VAT number through VIES, the system checks against the national VAT databases of each EU country in real-time. A valid result confirms the company is registered for intra-community trade.</p>
                    <p>Our validator adds a caching layer on top of VIES, so previously checked numbers return results instantly without querying the EU servers again.</p>
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
            {{-- Recently validated --}}
            @if(count($recentValidations) > 0)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5">
                    <h3 class="font-bold text-gray-900 text-sm mb-3">Recently Validated</h3>
                    <div class="space-y-2">
                        @foreach($recentValidations as $v)
                            <button wire:click="$set('country_code', '{{ $v['country_code'] }}'); $set('vat_number', '{{ $v['vat_number'] }}')"
                                    class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-xs hover:bg-gray-50 transition-colors text-left border border-gray-100">
                                <div>
                                    <span class="font-mono font-semibold text-gray-900">{{ $v['country_code'] }}{{ $v['vat_number'] }}</span>
                                    @if($v['name'] && $v['name'] !== 'N/A')
                                        <p class="text-gray-500 truncate max-w-[180px]">{{ $v['name'] }}</p>
                                    @endif
                                </div>
                                <span class="shrink-0 w-2 h-2 rounded-full {{ $v['is_valid'] ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- EU Countries --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5">
                <h3 class="font-bold text-gray-900 text-sm mb-3">EU Country VAT Guides</h3>
                <div class="space-y-1 max-h-64 overflow-y-auto">
                    @foreach($countries as $c)
                        <a href="{{ locale_path('/vat-calculator/' . $c->slug) }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs hover:bg-gray-50 transition-colors text-gray-700 hover:text-blue-600">
                            <img src="https://flagcdn.com/h40/{{ strtolower($c->iso_code) }}.jpg" alt="" class="h-3 w-auto rounded-sm" loading="lazy">
                            {{ $c->name }}
                            <span class="ml-auto text-gray-400">{{ $c->standard_rate }}%</span>
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
