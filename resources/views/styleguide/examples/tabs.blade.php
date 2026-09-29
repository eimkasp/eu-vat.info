<div x-data="{
    tab: 'claude',
    tabs: ['claude', 'cursor', 'other'],
    move(step) {
        this.tab = this.tabs[(this.tabs.indexOf(this.tab) + step + this.tabs.length) % this.tabs.length];
        this.$nextTick(() => document.getElementById('sg-tab-' + this.tab).focus());
    },
}">
    <div role="tablist" aria-label="AI client" class="flex flex-wrap gap-2" x-on:keydown.arrow-right.prevent="move(1)" x-on:keydown.arrow-left.prevent="move(-1)">
        @foreach(['claude' => 'Claude', 'cursor' => 'Cursor', 'other' => 'Other clients'] as $key => $label)
            <button
                type="button"
                role="tab"
                id="sg-tab-{{ $key }}"
                aria-controls="sg-panel-{{ $key }}"
                aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                :aria-selected="(tab === @js($key)).toString()"
                tabindex="{{ $loop->first ? 0 : -1 }}"
                :tabindex="tab === @js($key) ? 0 : -1"
                @class(['app-chip', 'app-chip-active' => $loop->first])
                :class="{ 'app-chip-active': tab === @js($key) }"
                x-on:click="tab = @js($key)"
            >{{ $label }}</button>
        @endforeach
    </div>
    @foreach(['claude' => 'Open Settings → Connectors and add the server URL.', 'cursor' => 'Add the server to ~/.cursor/mcp.json.', 'other' => 'Connect with Streamable HTTP and no authentication.'] as $key => $step)
        <p role="tabpanel" id="sg-panel-{{ $key }}" aria-labelledby="sg-tab-{{ $key }}" tabindex="0" class="mt-4 text-sm text-ink-muted" x-show="tab === @js($key)" @unless($loop->first) x-cloak @endunless>{{ $step }}</p>
    @endforeach
</div>
