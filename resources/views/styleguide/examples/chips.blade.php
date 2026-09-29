<div class="flex flex-wrap gap-2" role="group" aria-label="VAT rate" x-data="{ rate: 19 }">
    <button type="button" class="app-chip app-chip-active min-h-10 px-3.5" :class="{ 'app-chip-active': rate === 19 }" aria-pressed="true" :aria-pressed="(rate === 19).toString()" x-on:click="rate = 19">
        <span class="font-medium opacity-80">Standard</span>
        <span class="tabular">19%</span>
    </button>
    <button type="button" class="app-chip min-h-10 px-3.5" :class="{ 'app-chip-active': rate === 7 }" aria-pressed="false" :aria-pressed="(rate === 7).toString()" x-on:click="rate = 7">
        <span class="font-medium opacity-80">Reduced</span>
        <span class="tabular">7%</span>
    </button>
    <button type="button" class="app-chip min-h-10 border-dashed px-3.5">
        <x-ui.icon name="plus" class="size-3.5" />
        Custom %
    </button>
</div>
