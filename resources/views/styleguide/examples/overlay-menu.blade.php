<div class="min-h-52">
    <div class="relative inline-block" x-data="{ open: true }" x-on:click.outside="open = false" x-on:keydown.escape="open = false">
        <button type="button" class="app-button-secondary" aria-haspopup="true" aria-controls="sg-language-menu" aria-expanded="true" :aria-expanded="open.toString()" x-on:click="open = !open">
            <x-ui.icon name="languages" class="size-4" />
            Language
            <x-ui.icon name="chevron-down" class="size-4 transition-transform duration-150" x-bind:class="open && 'rotate-180'" />
        </button>
        <div
            id="sg-language-menu"
            x-cloak
            x-show="open"
            x-transition:enter="transition duration-150 ease-out-quint"
            x-transition:enter-start="-translate-y-1 opacity-0"
            x-transition:leave="transition duration-100 ease-out"
            x-transition:leave-end="opacity-0"
            class="app-popover absolute left-0 top-full z-20 mt-1.5 w-56 p-1.5"
        >
            @foreach(['English', 'Deutsch', 'Français'] as $language)
                <button type="button" class="flex min-h-10 w-full items-center rounded-control px-2.5 text-left text-sm text-ink hover:bg-surface-muted" x-on:click="open = false">{{ $language }}</button>
            @endforeach
        </div>
    </div>
</div>
