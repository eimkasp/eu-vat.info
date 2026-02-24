@props(['country'])

<div class="space-y-6">
    <div class="bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 p-6 rounded-xl border border-green-200 dark:border-green-800">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
            Validate {{ $country->name }} VAT Numbers
        </h2>
        <p class="text-gray-600 dark:text-gray-400 text-sm">
            Verify VAT numbers using the official EU VIES system with intelligent company matching.
        </p>
    </div>

    <!-- Embed VAT Validator Component -->
    <livewire:vat-validation-widget :countryCode="$country->iso_code" :key="'validator-'.$country->id" />

    <!-- Validator Info -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-bold mb-3 text-gray-900 dark:text-white">About VAT Number Validation</h3>
        <div class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
            <p>
                {{ $country->name }} VAT numbers follow the format: <strong class="text-gray-900 dark:text-white">{{ $country->iso_code }}XXXXXXXXX</strong>
            </p>
            <p>
                Our validator uses the European Commission's VIES (VAT Information Exchange System) to verify that VAT numbers are registered and valid. Results include company name and registered address when available.
            </p>
            <ul class="list-disc pl-5 space-y-1">
                <li>Real-time validation against EU databases</li>
                <li>Fuzzy matching for company names and addresses</li>
                <li>Results cached for 7 days for faster lookup</li>
                <li>Handles variations in formatting and capitalization</li>
            </ul>
        </div>
    </div>
</div>
