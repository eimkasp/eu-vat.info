@props(['mobile' => false])

@php
    $locales = supported_locales();
    $current = app()->getLocale();
    $currentConfig = current_locale_config();
@endphp

@if($mobile)
    <div {{ $attributes->merge(['class' => 'flex items-center gap-2']) }}>
        <label for="mobile-language" class="sr-only">{{ __('ui.language_switcher.label') }}</label>
        <x-ui.icon name="languages" class="size-4 text-white/70" />
        <select id="mobile-language" onchange="window.location.href = '/lang/' + this.value" class="h-10 rounded-lg border border-white/20 bg-white/10 px-2.5 text-sm font-medium text-white [&>option]:text-ink">
            @foreach($locales as $code => $config)
                <option value="{{ $code }}" @selected($code === $current)>{{ $config['native'] }}</option>
            @endforeach
        </select>
    </div>
@else
    <div x-data="{ open: false }" @click.outside="open = false" @keydown.escape="open = false" {{ $attributes->merge(['class' => 'relative']) }}>
        <button
            type="button"
            @click="open = !open"
            :aria-expanded="open.toString()"
            aria-haspopup="true"
            aria-controls="language-menu"
            aria-label="{{ __('ui.language_switcher.current', ['name' => $currentConfig['native'] ?? 'English']) }}"
            class="inline-flex h-10 items-center gap-1.5 rounded-lg px-2.5 text-sm font-semibold uppercase text-white/85 transition-colors hover:bg-white/10 hover:text-white"
        >
            <x-ui.flag :iso="$currentConfig['flag'] ?? 'gb'" size="sm" :lazy="false" class="shadow-none ring-1 ring-white/25" />
            {{ $current }}
            <x-ui.icon name="chevron-down" class="size-3.5 transition-transform duration-150" x-bind:class="open && 'rotate-180'" />
        </button>

        <div id="language-menu" x-cloak x-show="open" x-transition.opacity.duration.150ms class="absolute right-0 top-full z-50 mt-2 grid max-h-[70vh] w-72 grid-cols-2 gap-0.5 overflow-y-auto rounded-2xl border border-line bg-surface p-1.5 text-ink shadow-floating">
            @foreach($locales as $code => $config)
                <a href="/lang/{{ $code }}" lang="{{ $code }}" @class(['flex items-center gap-2 rounded-lg px-2.5 py-2 text-sm transition-colors', 'bg-action-soft font-semibold text-action-deep' => $code === $current, 'text-ink-muted hover:bg-surface-subtle hover:text-ink' => $code !== $current]) @if($code === $current) aria-current="true" @endif>
                    <x-ui.flag :iso="$config['flag']" size="sm" />
                    <span class="truncate">{{ $config['native'] }}</span>
                </a>
            @endforeach
        </div>
    </div>
@endif
