{{-- Sidebar: VAT changes, banners, links, recent countries, map --}}
<aside class="space-y-5" aria-label="VAT updates and resources">
    <!-- VAT Rate Changes Widget -->
    <livewire:vat-rate-changes />

    <!-- Sidebar Banners -->
    <x-banner-display position="sidebar" />

    <!-- Useful Links Widget -->
    <x-useful-vat-links />

    <!-- Recent Countries & Map -->
    <div class="space-y-5">
        <livewire:recent-countries />
        <div class="app-surface p-4 sm:p-5">
            <livewire:europe-map />
        </div>
    </div>
</aside>
