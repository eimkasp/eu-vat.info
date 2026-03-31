{{-- Sidebar: VAT changes, banners, links, recent countries, map --}}
<div class="space-y-6">
    <!-- VAT Rate Changes Widget -->
    <livewire:vat-rate-changes />

    <!-- Sidebar Banners -->
    <x-banner-display position="sidebar" />

    <!-- Useful Links Widget -->
    <x-useful-vat-links />

    <!-- Recent Countries & Map -->
    <div>
        <livewire:recent-countries />
        <div class="bg-white p-6 shadow-xl rounded-xl">
            <livewire:europe-map />
        </div>
    </div>
</div>
