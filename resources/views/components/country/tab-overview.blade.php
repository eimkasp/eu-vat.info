@props(['country'])

<div class="mb-6">
    <x-country-rates :country="$country" />
</div>

<div class="country-content max-w-3xl mx-auto">
    <article class="prose prose-blue prose-lg max-w-none">
        <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ $country->name }} VAT Guide</h2>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 mb-10">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Introduction</h3>
            <p class="text-gray-600 leading-relaxed mb-0">
                {{ $country->name }}, as a member of the European Union, maintains its own unique VAT system. 
                The standard VAT rate is <span class="font-bold text-blue-600">{{ $country->standard_rate }}%</span>, 
                which applies to most goods and services. 
                Using our <a href="{{ route('vat-calculator.country', $country->slug) }}" class="text-blue-600 hover:underline font-medium">VAT Calculator</a>, 
                you can easily calculate the exact VAT amount for any transaction.
            </p>
        </div>

        <div class="space-y-10">
            <section>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">VAT Rate Structure</h3>
                <p class="text-gray-600 mb-4">{{ $country->name }} applies different rates depending on the product or service:</p>
                
                <div class="grid sm:grid-cols-2 gap-4 not-prose">
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                        <div class="text-sm text-blue-600 font-semibold uppercase tracking-wide mb-1">Standard Rate</div>
                        <div class="text-3xl font-bold text-gray-900">{{ $country->standard_rate }}%</div>
                        <div class="text-sm text-gray-500 mt-1">Most goods & services</div>
                    </div>
                    @if($country->reduced_rate)
                    <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                        <div class="text-sm text-green-600 font-semibold uppercase tracking-wide mb-1">Reduced Rate</div>
                        <div class="text-3xl font-bold text-gray-900">{{ $country->reduced_rate }}%</div>
                        <div class="text-sm text-gray-500 mt-1">Essentials (Food, Books, etc.)</div>
                    </div>
                    @endif
                </div>
            </section>

            <section>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">VAT Registration & Compliance</h3>
                <p class="text-gray-600 leading-relaxed">
                    Businesses operating in {{ $country->name }} must register for VAT if their annual turnover exceeds the national threshold. 
                    Foreign companies trading in {{ $country->name }} may need to register immediately without a threshold.
                </p>
            </section>

            <section>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Tools & Resources</h3>
                <div class="text-gray-600 leading-relaxed">
                    Use our specialized tools to manage your VAT obligations:
                    <ul class="list-disc pl-5 space-y-2 mt-2">
                        <li><a href="{{ route('vat-calculator.country', $country->slug) }}" class="text-blue-600 hover:underline">Calculate VAT for {{ $country->name }}</a></li>
                        <li><a href="{{ locale_path('/vat-changes') }}" class="text-blue-600 hover:underline">View historical rate changes</a></li>
                    </ul>
                </div>
            </section>
        </div>
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
