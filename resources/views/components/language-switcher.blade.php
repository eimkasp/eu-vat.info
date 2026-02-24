@props(['mobile' => false])

@php
    $locales = supported_locales();
    $current = app()->getLocale();
    $currentConfig = current_locale_config();
@endphp

@if($mobile)
    {{-- Mobile: simple select --}}
    <div class="px-4 py-2">
        <label class="block text-xs font-medium text-gray-500 mb-1">{{ __('ui.language_switcher.label') }}</label>
        <select onchange="window.location.href='/lang/' + this.value"
                class="w-full rounded-md border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
            @foreach($locales as $code => $config)
                <option value="{{ $code }}" {{ $code === $current ? 'selected' : '' }}>
                    {{ $config['native'] }}
                </option>
            @endforeach
        </select>
    </div>
@else
    {{-- Desktop: dropdown --}}
    <div x-data="{ open: false }" @click.outside="open = false" class="relative">
        <button @click="open = !open" type="button"
                class="flex items-center gap-1.5 text-sm text-gray-600 hover:text-blue-600 transition-colors px-2 py-1 rounded-md hover:bg-gray-100"
                aria-label="{{ __('ui.language_switcher.current', ['name' => $currentConfig['native'] ?? 'English']) }}">
            <img src="https://flagcdn.com/h20/{{ $currentConfig['flag'] ?? 'gb' }}.jpg"
                 alt="" class="h-3.5 rounded-sm border border-gray-200" loading="lazy">
            <span class="uppercase font-medium">{{ $current }}</span>
            <svg class="w-3 h-3 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>

        <div x-show="open" x-transition:enter="transition ease-out duration-100"
             x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-75"
             x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
             class="absolute right-0 mt-2 w-48 max-h-80 overflow-y-auto bg-white rounded-lg shadow-lg border border-gray-200 z-50 py-1"
             x-cloak>
            @foreach($locales as $code => $config)
                <a href="/lang/{{ $code }}"
                   class="flex items-center gap-2 px-3 py-1.5 text-sm hover:bg-blue-50 transition-colors {{ $code === $current ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-700' }}">
                    <img src="https://flagcdn.com/h20/{{ $config['flag'] }}.jpg"
                         alt="" class="h-3.5 rounded-sm border border-gray-200" loading="lazy">
                    <span>{{ $config['native'] }}</span>
                    @if($code === $current)
                        <svg class="w-3.5 h-3.5 ml-auto text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
@endif
