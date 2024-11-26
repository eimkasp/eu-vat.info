<header class="bg-[#003399] text-white sticky top-0 z-[99] shadow-xl">
    <div class="sm:flex justify-between container !py-6 !px-6">
        <div class="logo mb-6 sm:mb-0">
            <a wire:navigate class="font-extrabold text-xl" href="/" >
                EU VAT Info
            </a>
        </div>
        <nav class="flex gap-6">
            <a wire:navigate="/" href="/" title="EU VAT countries list">All Countries 🇪🇺</a>
            <a wire:navigate="/vat-calculator" href="/vat-calculator">VAT Calculator 💶</a>
            <a wire:navigate="{{ route('widget.embed')}}" href="{{ route('widget.embed')}}">VAT Widget</a>
            <a wire:navigate={{ route('vat-map') }} href="{{ route('vat-map')}}">VAT Map 🌍</a>
            {{-- <a href="/" wire:navigate>Countries</a> --}}

            <a href="https://github.com/eimkasp/eu-vat.info" target="_blank" class="hidden sm:block w-6">
                @svg('feathericon-github')
            </a>
        </nav>
    </div>
</header>

{{-- Announcement bar --}}
<x-announcement-bar />

