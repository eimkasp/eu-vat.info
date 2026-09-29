<div class="app-surface max-w-2xl divide-y divide-line">
    @foreach([
        ['Do I need an account?', 'No. Every tool is free and needs no sign-up.'],
        ['Are the answers tax advice?', 'No. The rates are reference data. Check important cases with a tax adviser.'],
    ] as [$question, $answer])
        <details class="group" @if($loop->first) open @endif>
            <summary class="flex min-h-14 cursor-pointer list-none items-center justify-between gap-4 px-5 py-4 font-semibold text-ink [&::-webkit-details-marker]:hidden">
                {{ $question }}
                <x-ui.icon name="chevron-down" class="size-4 text-ink-quiet transition-transform duration-150 group-open:rotate-180" />
            </summary>
            <p class="px-5 pb-4 text-sm leading-6 text-ink-muted">{{ $answer }}</p>
        </details>
    @endforeach
</div>
