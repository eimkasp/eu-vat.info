@props(['countries' => [], 'search' => ''])

<div class="app-surface overflow-hidden">
    <div class="border-b border-line bg-white p-4 sm:p-5">
        <div class="mb-4 flex items-start justify-between gap-4">
            <h2 class="text-lg font-bold text-ink">{{ __('ui.home_page.rates_heading') }}</h2>
            <span class="shrink-0 rounded-full bg-surface-subtle px-2.5 py-1 text-sm font-semibold text-ink-muted sm:text-xs">{{ __('ui.home_page.rates_year', ['year' => date('Y')]) }}</span>
        </div>
        <div class="relative">
            <label for="country-rate-search" class="sr-only">{{ __('ui.home_page.search_placeholder') }}</label>
            <input wire:model.live="search"
                id="country-rate-search"
                class="app-field w-full pl-10 pr-10"
                placeholder="{{ __('ui.home_page.search_placeholder') }}" type="search">
            <div class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-ink-quiet">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </div>
            <div wire:loading wire:target="search" class="absolute right-3 top-1/2 -translate-y-1/2 text-action">
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

    <div wire:loading.class="opacity-50" wire:target="search">
        <table class="w-full table-fixed text-left text-sm text-ink-muted">
            <thead class="bg-surface-subtle text-sm font-semibold text-ink-muted sm:text-xs">
                <tr>
                    <th class="w-[48%] px-3 py-3 sm:w-auto sm:px-5">{{ __('ui.home_page.th_country') }}</th>
                    <th class="w-[27%] px-2 py-3 sm:w-auto sm:px-4">{{ __('ui.home_page.th_standard') }}</th>
                    <th class="hidden px-4 py-3 sm:table-cell">{{ __('ui.home_page.th_reduced') }}</th>
                    <th class="w-[25%] px-3 py-3 text-right sm:w-auto sm:px-5">{{ __('ui.home_page.th_actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-line bg-white">
                @forelse ($countries as $country)
                    <tr class="group transition-colors hover:bg-action-soft/60">
                        <td class="px-3 py-2 sm:px-5 sm:py-3">
                            <a href="{{ locale_path('/vat-calculator/' . $country->slug) }}"
                                class="flex min-h-11 items-center gap-2.5 text-ink transition-colors group-hover:text-action-deep sm:gap-3">
                                <img src="https://flagcdn.com/h40/{{ strtolower($country->iso_code) }}.jpg"
                                    alt="{{ $country->name }} flag"
                                    width="40" height="27"
                                    loading="lazy"
                                    class="h-5 w-7 shrink-0 rounded-sm object-cover">
                                <span class="truncate font-semibold text-ink group-hover:text-action-deep">{{ $country->name }}</span>
                            </a>
                        </td>
                        <td class="px-2 py-2 sm:px-4 sm:py-3">
                            <span class="inline-flex items-center rounded-md bg-action-soft px-2 py-1 text-sm font-bold tabular-nums text-action-deep">
                                {{ $country->standard_rate }}%
                            </span>
                        </td>
                        <td class="hidden px-4 py-3 tabular-nums sm:table-cell">
                            @if ($country->reduced_rate)
                                <span class="text-ink-muted">{{ $country->reduced_rate }}%</span>
                                @if ($country->super_reduced_rate)
                                    <span class="ml-1 text-sm text-ink-quiet sm:text-xs">({{ $country->super_reduced_rate }}%)</span>
                                @endif
                            @else
                                <span class="text-ink-quiet">—</span>
                            @endif
                        </td>
                        <td class="px-3 py-2 text-right sm:px-5 sm:py-3">
                            <a href="{{ locale_path('/vat-calculator/' . $country->slug) }}"
                                aria-label="{{ __('ui.details') }}: {{ $country->name }}"
                                class="inline-flex min-h-11 items-center justify-end gap-1 rounded-md text-sm font-semibold text-action transition-colors hover:text-action-deep sm:text-xs">
                                <span class="hidden sm:inline">{{ __('ui.details') }}</span>
                                <span aria-hidden="true">→</span>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-ink-muted">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-3 h-8 w-8 text-ink-quiet" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
