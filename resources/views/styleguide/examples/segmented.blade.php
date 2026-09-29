<div x-data="{ mode: 'exclude' }">
    <div role="radiogroup" aria-label="Calculation mode" class="app-segmented" data-value="exclude" :data-value="mode">
        <span class="app-segmented-thumb" aria-hidden="true"></span>
        <button type="button" role="radio" aria-checked="true" :aria-checked="(mode === 'exclude').toString()" class="app-segment" x-on:click="mode = 'exclude'">
            <x-ui.icon name="plus" class="size-3.5" />
            Add VAT
        </button>
        <button type="button" role="radio" aria-checked="false" :aria-checked="(mode === 'include').toString()" class="app-segment" x-on:click="mode = 'include'">
            <x-ui.icon name="minus" class="size-3.5" />
            Remove VAT
        </button>
    </div>
</div>
