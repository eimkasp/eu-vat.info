@props(['country'])

<div class="space-y-6">
    <div class="bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 p-6 rounded-xl border border-blue-200 dark:border-blue-800">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
            Calculate VAT for {{ $country->name }}
        </h2>
        <p class="text-gray-600 dark:text-gray-400 text-sm">
            Add or remove {{ $country->standard_rate }}% VAT from any amount instantly.
        </p>
    </div>

    <!-- Embed VAT Calculator Component -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
        <livewire:vat-calculator-simple :country="$country" :key="'calc-'.$country->id" />
    </div>

    <!-- Calculator Instructions -->
    <div class="grid md:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-bold mb-3 text-gray-900 dark:text-white">Adding VAT</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">Calculate the gross amount including VAT:</p>
            <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg font-mono text-sm text-gray-800 dark:text-gray-200 mb-4 border border-gray-200 dark:border-gray-700">
                Gross = Net × (1 + {{ $country->standard_rate / 100 }})
            </div>
            <div class="text-sm text-gray-600 dark:text-gray-400">
                <strong>Example:</strong> €100 net → €{{ 100 * (1 + $country->standard_rate / 100) }} gross
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-bold mb-3 text-gray-900 dark:text-white">Removing VAT</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">Calculate the net amount excluding VAT:</p>
            <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg font-mono text-sm text-gray-800 dark:text-gray-200 mb-4 border border-gray-200 dark:border-gray-700">
                Net = Gross ÷ (1 + {{ $country->standard_rate / 100 }})
            </div>
            <div class="text-sm text-gray-600 dark:text-gray-400">
                <strong>Example:</strong> €100 gross → €{{ number_format(100 / (1 + $country->standard_rate / 100), 2) }} net
            </div>
        </div>
    </div>
</div>
