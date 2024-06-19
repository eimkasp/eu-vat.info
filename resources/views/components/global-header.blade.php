<header class="bg-[#003399] text-white sticky top-0 z-[99] shadow-xl">
    <div class="sm:flex justify-between container !py-6 !px-6">
        <div class="logo mb-6 sm:mb-0">
            <a class="font-extrabold text-xl" href="/" >
                EU VAT Info
            </a>
        </div>
        <nav class="flex gap-6">
            <a href="/" title="EU VAT countries list">All Countries</a>
            <a href="/vat-calculator">VAT Calculator</a>
            <a href="{{ route('widget.embed')}}">VAT Widget</a>
            {{-- <a href="/" wire:navigate>Countries</a> --}}

            <a href="https://github.com/eimkasp/eu-vat.info" target="_blank" class="hidden sm:block w-6">
                @svg('feathericon-github')
            </a>
        </nav>
    </div>
</header>

{{-- Announcement bar --}}
<x-announcement-bar />

