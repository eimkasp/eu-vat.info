<ul class="grid grid-cols-1 gap-3 md:grid-cols-3">
    @foreach([
        ['map', 'VAT map', 'Compare standard rates visually'],
        ['history', 'VAT history', 'Every recorded rate change'],
        ['code', 'VAT widget', 'Embed a calculator on your site'],
    ] as [$icon, $title, $text])
        <li>
            <a href="#tiles" class="app-surface pressable group flex h-full items-start gap-3 p-4 hover:border-line-strong">
                <span class="flex size-9 shrink-0 items-center justify-center rounded-control bg-action-soft text-action" aria-hidden="true">
                    <x-ui.icon :name="$icon" class="size-4" />
                </span>
                <span>
                    <span class="block font-semibold text-ink group-hover:text-action">{{ $title }}</span>
                    <span class="mt-0.5 block text-sm text-ink-muted">{{ $text }}</span>
                </span>
            </a>
        </li>
    @endforeach
</ul>
