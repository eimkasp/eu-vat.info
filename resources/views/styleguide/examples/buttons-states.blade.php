<div class="flex flex-wrap items-center gap-3" x-data="{ busy: false }">
    <button
        type="button"
        class="app-button-primary"
        aria-busy="false"
        :aria-busy="busy.toString()"
        :disabled="busy"
        x-on:click="busy = true; setTimeout(() => busy = false, 1800)"
    >
        <span x-cloak x-show="busy" class="block size-4 animate-spin rounded-full border-2 border-white/30 border-t-white" aria-hidden="true"></span>
        <x-ui.icon name="shield-check" class="size-4" x-show="!busy" />
        <span x-text="busy ? 'Checking VIES…' : 'Validate'">Validate</span>
    </button>
    <button type="button" class="app-button-primary" disabled>Disabled</button>
</div>
