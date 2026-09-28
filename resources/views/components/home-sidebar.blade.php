<aside class="space-y-5" aria-label="{{ __('ui.home_page.sidebar_label') }}">
    <livewire:vat-rate-changes />

    <x-banner-display position="sidebar" />

    <livewire:recent-countries />

    <section class="app-surface overflow-hidden" aria-labelledby="map-card-heading">
        <div class="relative isolate overflow-hidden bg-brand-deep px-5 pb-5 pt-6 text-white">
            <x-hero-backdrop opacity="opacity-20" />
            <x-ui.icon name="map" class="size-6 text-sky-200" />
            <h2 id="map-card-heading" class="mt-3 text-base font-bold text-white">{{ __('ui.home_page.map_card_title') }}</h2>
            <p class="mt-1 text-sm leading-6 text-white/75">{{ __('ui.home_page.map_card_text') }}</p>
        </div>
        <div class="p-3">
            <a href="{{ locale_path('/vat-map') }}" class="app-button-secondary w-full">
                {{ __('ui.rate_changes.explore_map') }}
                <x-ui.icon name="arrow-right" class="size-4" />
            </a>
        </div>
    </section>

    <x-useful-vat-links />
</aside>
