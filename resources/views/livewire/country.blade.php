<div class="container">
    @section('title', 'VAT Rates in ' . $country->name . '- EU VAT Info')
    @section('meta_description',
        'The standard VAT rate in ' .
        $country->name .
        ' is ' .
        $country->standard_rate .
        '%. Learn about VAT rates, exceptions, and compliance in ' .
        $country->name .
        '. Use our VAT
        calculator to calculate VAT for transactions in ' .
        $country->name .
        '.')
        <div class="">
            <div class="relative w-full">
                <div class="grid sm:grid-cols-12 gap-9">
                    <div class="sm:col-span-12">
                        {{-- <x-country-rates :country="$country" /> --}}
                    </div>
                    <div class="sm:col-span-4 sm:sticky top-[-1px] sticky-element" style="align-self: flex-start">
                        <a href="/" class="mb-3 block flex items-center gap-3 hover:text-blue-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                            </svg>
                            Back to all countries
                        </a>
                        <x-country-stats :country="$country" />
                        <div class="mt-9 space-y-3 sm:mb-12 border-t pt-3">
                            <h4>VAT Tools</h4>

                            <div>
                                <a class="text-blue-600 hover:underline" wire:navigate="/vat-calculator/{{ $country->slug }}"
                                    href="/vat-calculator/{{ $country->slug }}">VAT Calculator for {{ $country->name }}

                                </a>
                            </div>

                            <div>
                                <a class="text-blue-600 hover:underline" wire:navigate="/vat-calculator/{{ $country->slug }}"
                                    href="/embed/{{ $country->slug }}">Embed {{ $country->name }} VAT Widget
                                    {{-- TODO: add a new badge  --}}
                                    <span class="badge badge-info ml-2">New</span>
                                </a>
                            </div>
                        </div>
                        
                        <!-- Sidebar Banners -->
                        <x-banner-display position="country_sidebar" />
                    </div>

                    <div class="sm:col-span-8 pb-12">
                        <x-breadcrumbs :items="[$country->name => '']" />
                        
                        <div class="space-y-3">
                            <h1 class="text-2xl lg:text-3xl font-bold">
                                VAT rates for goods and services in {{ $country->name }}
                            </h1>
                            <p class="text-gray-500 dark:text-gray-400">

                            </p>
                        </div>
                        <div class="mb-6">
                            <x-country-rates :country="$country" />
                        </div>

                        {{-- <!-- VAT Validator Widget -->
                        <div class="mb-12">
                            <livewire:vat-validator :country="$country" />
                        </div> --}}

                        <div class="country-content">

                            <article>
                                <h1> {{ $country->name }} VAT Information</h1>

                                <section>
                                    <h2>Introduction to VAT in {{ $country->name }} </h2>
                                    <p> {{ $country->name }} , as a member of the European Union, has its
                                        unique VAT
                                        system that businesses and consumers need to navigate. The standard VAT
                                        rate in {{ $country->name }} is {{ $country->standard_rate }}%, one of
                                        the lowest in Europe, affecting
                                        goods and services across the country. For detailed VAT rates and
                                        exceptions, use our <a wire:navigate="/vat-calculator/{{ $country->slug }}"
                                            href="/vat-calculator/{{ $country->slug }}">VAT Calculator for
                                            {{ $country->name }}</a> to see
                                        how much VAT you need to pay or reclaim for transactions in
                                        {{ $country->name }} .
                                    </p>
                                </section>

                                <section>
                                    <h2>Understanding {{ $country->name }} 's VAT Rates</h2>
                                    <p> {{ $country->name }} offers three main VAT rates:</p>
                                    <ul>
                                        <li><strong>Standard Rate:</strong> {{ $country->standard_rate }}%
                                            applies to most goods and
                                            services.</li>
                                        <li><strong>Reduced Rate:</strong> {{ $country->reduced_rate }}% for
                                            essential goods like food,
                                            drugs, and books.</li>
                                        <li><strong>Special Rate for Accommodation Services:</strong>
                                            {{ $country->special_rate }}%</li>
                                    </ul>

                                </section>

                                <section>
                                    <h2>Do I Need to Pay VAT in {{ $country->name }} ?</h2>
                                    <p>Whether you're a business owner importing goods into
                                        {{ $country->name }} or
                                        providing services within the country, understanding your VAT
                                        obligations is crucial.</p>
                                </section>

                                <section>
                                    <h2>Using the VAT Calculator for {{ $country->name }} </h2>
                                    <p>Calculating the VAT for transactions can be complex. Our <a
                                            href="/vat-calculator">VAT Calculator</a> simplifies this process,
                                        whether you're adding VAT to prices or extracting VAT amounts from gross
                                        sums. This tool is essential for businesses and individuals dealing with
                                        VAT in {{ $country->name }} .</p>
                                </section>

                                <section>
                                    <h2>Navigating VAT Registration and Compliance</h2>
                                    <p>VAT registration in {{ $country->name }} is mandatory for businesses
                                        exceeding a
                                        certain turnover threshold.</p>
                                </section>

                                <section>
                                    <h2>VAT Refunds in {{ $country->name }} </h2>
                                    <p>If you've incurred VAT on business-related expenses in
                                        {{ $country->name }} , you
                                        might be eligible for a refund.</p>
                                </section>

                                <section>
                                    <h2>Stay Updated with VAT Changes</h2>
                                    <p>VAT rates and regulations can change. Stay informed with the latest
                                        updates and insights on</p>
                                </section>

                            </article>
                        </div>

                        <!-- FAQ Section -->
                        <div class="mt-12 mb-8">
                            <h2 class="text-2xl font-bold mb-6">How to Calculate VAT in {{ $country->name }}</h2>
                            
                            <div class="space-y-6">
                                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                                    <h3 class="text-lg font-bold mb-3 text-gray-900">Adding VAT to a Net Price</h3>
                                    <p class="text-gray-600 mb-4">To calculate the gross amount from a net price (excluding VAT), use the following formula:</p>
                                    <div class="bg-gray-50 p-4 rounded-lg font-mono text-sm text-gray-800 mb-4 border border-gray-200">
                                        Gross Amount = Net Price × (1 + VAT Rate / 100)
                                    </div>
                                    <div class="text-sm text-gray-600">
                                        <strong>Example:</strong> Calculating {{ $country->standard_rate }}% VAT on €100 net:<br>
                                        €100 × (1 + {{ $country->standard_rate / 100 }}) = €100 × {{ 1 + $country->standard_rate / 100 }} = <strong>€{{ 100 * (1 + $country->standard_rate / 100) }}</strong>
                                    </div>
                                </div>

                                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                                    <h3 class="text-lg font-bold mb-3 text-gray-900">Removing VAT from a Gross Price</h3>
                                    <p class="text-gray-600 mb-4">To calculate the net price from a gross amount (including VAT), use this formula:</p>
                                    <div class="bg-gray-50 p-4 rounded-lg font-mono text-sm text-gray-800 mb-4 border border-gray-200">
                                        Net Price = Gross Amount ÷ (1 + VAT Rate / 100)
                                    </div>
                                    <div class="text-sm text-gray-600">
                                        <strong>Example:</strong> Extracting {{ $country->standard_rate }}% VAT from €100 gross:<br>
                                        €100 ÷ (1 + {{ $country->standard_rate / 100 }}) = €100 ÷ {{ 1 + $country->standard_rate / 100 }} = <strong>€{{ number_format(100 / (1 + $country->standard_rate / 100), 2) }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <h3 class="text-xl font-medium">
                                {{ $country->name }} VAT Exceptions
                            </h3>
                            <ul>
                                <li>
                                    Coming Soon
                                </li>
                            </ul>
                        </div>

                        <!-- Country Details -->
                        <div class="mt-8 p-6 bg-gray-50 rounded-xl border border-gray-200">
                            <h3 class="text-lg font-bold mb-4 text-gray-900">Quick Facts about {{ $country->name }}</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                                <div>
                                    <div class="text-xs text-gray-500 uppercase tracking-wider mb-1">ISO Code</div>
                                    <div class="font-mono font-medium text-gray-900">{{ $country->iso_code }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 uppercase tracking-wider mb-1">Currency</div>
                                    <div class="font-medium text-gray-900">{{ $country->currency_code ?? 'EUR' }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 uppercase tracking-wider mb-1">Standard Rate</div>
                                    <div class="font-bold text-blue-600">{{ $country->standard_rate }}%</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 uppercase tracking-wider mb-1">EU Member</div>
                                    <div class="font-medium text-green-600 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Yes
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="hidden mt-9">
            <h3 class="text-xl font-medium mb-3">Related countries</h3>
            <x-related-countries :country="$country" />

        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const el = document.querySelector(".sticky-element")
                const observer = new IntersectionObserver(
                    ([e]) => e.target.classList.toggle("is-pinned", e.intersectionRatio < 1), {
                        threshold: [1]
                    }
                );

                observer.observe(el);


                el.addEventListener('click', function() {
                    el.classList.toggle('is-pinned')
                });
            });
        </script>
    </div>
