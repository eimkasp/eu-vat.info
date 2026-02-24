@props(['items'])

<nav {{ $attributes->merge(['class' => 'flex text-sm text-gray-500 pt-6']) }} aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a href="{{ locale_path('/') }}" wire:navigate class="inline-flex items-center hover:text-blue-600 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                </svg>
                {{ __('ui.breadcrumbs.home') }}
            </a>
        </li>
        @foreach($items as $label => $url)
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    @if(!$loop->last)
                        <a href="{{ $url }}" wire:navigate class="ml-1 text-sm font-medium hover:text-blue-600 md:ml-2 transition-colors">{{ $label }}</a>
                    @else
                        <span class="ml-1 text-sm font-medium text-gray-700 md:ml-2" aria-current="page">{{ $label }}</span>
                    @endif
                </div>
            </li>
        @endforeach
    </ol>
</nav>
