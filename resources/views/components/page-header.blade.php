@props(['title', 'description' => null, 'eyebrow' => null, 'breadcrumbs' => []])

<header {{ $attributes->merge(['class' => 'border-b border-line bg-surface']) }}>
    <div class="app-container pb-8 pt-6 sm:pb-10">
        @if($breadcrumbs)
            <x-site-breadcrumbs :items="$breadcrumbs" />
        @endif
        <div class="mt-6 flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-3xl">
                @if($eyebrow)
                    <p class="app-eyebrow">{{ $eyebrow }}</p>
                @endif
                <h1 @class(['text-3xl font-bold tracking-[-0.03em] text-ink sm:text-4xl', 'mt-1' => $eyebrow])>{{ $title }}</h1>
                @if($description)
                    <p class="mt-3 max-w-[68ch] text-base leading-7 text-ink-muted">{{ $description }}</p>
                @endif
            </div>
            @isset($actions)
                <div class="flex shrink-0 flex-wrap gap-2">{{ $actions }}</div>
            @endisset
        </div>
    </div>
</header>
