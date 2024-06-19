<header class="bg-[#003399] text-white sticky top-0 z-[99] shadow-xl">
    <div class="flex justify-between mx-auto max-w-6xl py-6 px-6 sm:px-0">
        <div class="logo">
            <a class="font-extrabold text-xl" href="/" >
                EU VAT Info
            </a>
        </div>
        <nav class="flex gap-6">
            <a href="/" title="EU VAT countries list">Countries</a>
            <a href="/vat-calculator">VAT Calculator</a>
            <a href="{{ route('widget.embed')}}">VAT Widget</a>
            {{-- <a href="/" wire:navigate>Countries</a> --}}

            <a href="https://github.com/eimkasp/eu-vat.info" target="_blank" class="w-6">
                @svg('feathericon-github')
            </a>
        </nav>
    </div>
</header>

{{-- Announcement bar --}}
<x-announcement-bar />

