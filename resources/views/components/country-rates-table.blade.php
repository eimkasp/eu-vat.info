@props(['countries' => [], 'search' => ''])

<div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
    <div class="p-4 border-b border-gray-100 bg-gray-50/50">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-lg font-bold text-gray-900">{{ __('ui.home_page.rates_heading') }}</h2>
            <span class="text-xs text-gray-400 font-medium">{{ __('ui.home_page.rates_year', ['year' => date('Y')]) }}</span>
        </div>
        <div class="relative">
            <input wire:model.live="search"
                class="w-full pl-10 pr-4 py-3 rounded-xl border-0 ring-1 ring-gray-200 focus:ring-2 focus:ring-blue-500 bg-white shadow-sm transition-all"
                placeholder="{{ __('ui.home_page.search_placeholder') }}" type="search">
            <div class="absolute left-3 top-3.5 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </div>
            <div wire:loading wire:target="search" class="absolute right-3 top-3.5 text-blue-500">
                <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10"
                        stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto" wire:loading.class="opacity-50" wire:target="search">
        <table class="w-full text-left text-sm text-gray-600">
            <thead class="bg-gray-50 text-xs uppercase font-semibold text-gray-500 tracking-wider">
                <tr>
                    <th class="px-6 py-4">{{ __('ui.home_page.th_country') }}</th>
                    <th class="px-6 py-4">{{ __('ui.home_page.th_standard') }}</th>
                    <th class="px-6 py-4 hidden sm:table-cell">{{ __('ui.home_page.th_reduced') }}</th>
                    <th class="px-6 py-4 text-right">{{ __('ui.home_page.th_actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($countries as $country)
                    <tr class="hover:bg-blue-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <a href="{{ locale_path('/vat-calculator/' . $country->slug) }}"
                                class="flex items-center gap-4 group-hover:text-blue-600 transition-colors">
                                <span class="font-mono text-xs text-gray-300 w-6">#{{ $country->countryRank() }}</span>
                                <img src="https://flagcdn.com/h40/{{ strtolower($country->iso_code) }}.jpg"
                                    alt="{{ $country->name }} flag"
                                    width="40" height="27"
                                    loading="lazy"
                                    class="h-6 w-auto rounded-sm shadow-sm">
                                <span class="font-bold text-gray-900 group-hover:text-blue-600">{{ $country->name }}</span>
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-bold bg-blue-100 text-blue-800">
                                {{ $country->standard_rate }}%
                            </span>
                        </td>
                        <td class="px-6 py-4 hidden sm:table-cell">
                            @if ($country->reduced_rate)
                                <span class="text-gray-500">{{ $country->reduced_rate }}%</span>
                                @if ($country->super_reduced_rate)
                                    <span class="text-gray-500 text-xs ml-1">({{ $country->super_reduced_rate }}%)</span>
                                @endif
                            @else
                                <span class="text-gray-300">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ locale_path('/vat-calculator/' . $country->slug) }}"
                                class="text-blue-600 font-medium hover:text-blue-800 text-xs uppercase tracking-wide transition-colors">
                                {{ __('ui.details') }} &rarr;
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto mb-2 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            {{ __('ui.home_page.no_results') ?? 'No countries found matching your search.' }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
