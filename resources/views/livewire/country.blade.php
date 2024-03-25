<div class="mx-auto max-w-6xl py-6">
@section('title', 'EU VAT Info - ' . $country->name)
@section('description', 'Learn about VAT rates, exceptions, and compliance in ' . $country->name . '. Use our VAT calculator to calculate VAT for transactions in ' . $country->name . '.')
    <div class="">
        <div class="relative w-full">
            <div class="grid sm:grid-cols-12 gap-9">
                <div class="sm:col-span-12">
                    {{-- <x-country-rates :country="$country" /> --}}
                </div>
                <div class="sm:col-span-4 sm:sticky top-[-1px] sticky-element" style="align-self: flex-start">
                    <x-country-stats :country="$country" />
                </div>

                <div class="sm:col-span-8">
                    <div class="space-y-3">
                        <h1 class="text-3xl font-bold">
                              VAT rates for goods and services in {{ $country->name }}
                        </h1>
                        <p class="text-gray-500 dark:text-gray-400">

                        </p>
                    </div>
                    <div class="mb-6">
                        <x-country-rates :country="$country" />
                    </div>

                

                    <div class="country-content">

                        <article>
                            <h1> {{ $country->name }} VAT Information</h1>

                            <section>
                                <h2>Introduction to VAT in {{ $country->name }} </h2>
                                <p> {{ $country->name }} , as a member of the European Union, has its
                                    unique VAT
                                    system that businesses and consumers need to navigate. The standard VAT
                                    rate in {{ $country->name }} is {{ $country->standard_rate }}, one of
                                    the lowest in Europe, affecting
                                    goods and services across the country. For detailed VAT rates and
                                    exceptions, use our <a href="/vat-calculator">VAT Calculator</a> to see
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
                                <p>For a comprehensive overview of what goods and services are taxed at
                                    these rates, visit our detailed guide on <a
                                        href="/vat-rates/{{ $country->slug }}">VAT Rates in
                                        {{ $country->name }} </a>.</p>
                            </section>

                            <section>
                                <h2>Do I Need to Pay VAT in {{ $country->name }} ?</h2>
                                <p>Whether you're a business owner importing goods into
                                    {{ $country->name }} or
                                    providing services within the country, understanding your VAT
                                    obligations is crucial. Our guide, <a
                                        href="/guides/do-i-need-to-pay-vat-in-{{ $country->slug }}">Do I
                                        Need to Pay
                                        VAT in {{ $country->name }} ?</a>, offers insights into
                                    registration
                                    thresholds, compliance, and how to handle VAT payments and refunds.</p>
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
                                    certain turnover threshold. Our step-by-step guide on <a
                                        href="/vat-registration/{{ $country->slug }}">VAT Registration in
                                        {{ $country->name }} </a> walks you through the process,
                                    documentation, and
                                    how to stay compliant with European VAT laws in {{ $country->name }}.</p>
                            </section>

                            <section>
                                <h2>VAT Refunds in {{ $country->name }} </h2>
                                <p>If you've incurred VAT on business-related expenses in
                                    {{ $country->name }} , you
                                    might be eligible for a refund. Learn about the eligibility criteria,
                                    the process, and the necessary documentation in our guide to <a
                                        href="/vat-refunds/{{ $country->slug }}">VAT Refunds in
                                        {{ $country->name }} </a>.</p>
                            </section>

                            <section>
                                <h2>Stay Updated with VAT Changes</h2>
                                <p>VAT rates and regulations can change. Stay informed with the latest
                                    updates and insights on <a href="/vat-news/{{ $country->slug }}">VAT
                                        News in
                                        {{ $country->name }} </a> to ensure your business remains compliant
                                    and to
                                    take advantage of any new VAT opportunities or savings.</p>
                            </section>

                        </article>


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
