<div class="flex flex-wrap items-center gap-3">
    <button type="button" class="app-button-secondary" x-data x-on:click="$store.toasts.push('Calculation copied', 'success')">
        <x-ui.icon name="check" class="size-4" />
        Show a success toast
    </button>
    <button type="button" class="app-button-secondary" x-data x-on:click="$store.toasts.push('VIES is slow to respond right now', 'info')">
        <x-ui.icon name="info" class="size-4" />
        Show an info toast
    </button>
</div>
