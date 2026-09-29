<div class="flex flex-wrap items-end gap-6">
    @foreach(['xs', 'sm', 'md', 'lg', 'xl'] as $size)
        <span class="flex flex-col items-center gap-2 font-mono text-xs text-ink-muted">
            <x-ui.flag iso="de" :size="$size" alt="Germany" />
            {{ $size }}
        </span>
    @endforeach
</div>
