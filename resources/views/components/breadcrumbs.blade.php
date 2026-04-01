@props(['items', 'variant' => 'light'])

@php
    $isDark = $variant === 'dark';
    $navClasses = $isDark
        ? 'flex text-sm text-white/70 pt-2 mb-2'
        : 'flex text-sm text-gray-500 dark:text-gray-400 pt-6 mb-4';
    $separatorClasses = $isDark
        ? 'w-4 h-4 text-white/40 mx-1'
        : 'w-4 h-4 text-gray-300 dark:text-gray-600 mx-1';
    $linkHoverClasses = $isDark
        ? 'inline-flex items-center hover:text-white transition-colors'
        : 'inline-flex items-center hover:text-blue-600 dark:hover:text-blue-400 transition-colors';
    $midLinkClasses = $isDark
        ? 'text-sm font-medium hover:text-white transition-colors'
        : 'text-sm font-medium hover:text-blue-600 dark:hover:text-blue-400 transition-colors';
    $currentClasses = $isDark
        ? 'text-sm font-medium text-white/90'
        : 'text-sm font-medium text-gray-700 dark:text-gray-300';
@endphp

<nav {{ $attributes->merge(['class' => $navClasses]) }} aria-label="Breadcrumb">
    <ol class="inline-flex items-center flex-wrap gap-y-1" itemscope itemtype="https://schema.org/BreadcrumbList">
        <li class="inline-flex items-center" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <a href="{{ locale_path('/') }}" class="{{ $linkHoverClasses }}" itemprop="item">
                <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                </svg>
                <span itemprop="name">{{ __('ui.breadcrumbs.home') }}</span>
            </a>
            <meta itemprop="position" content="1" />
        </li>
        @foreach($items as $label => $url)
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <div class="flex items-center">
                    <svg class="{{ $separatorClasses }}" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    @if(!$loop->last)
                        <a href="{{ $url }}" class="{{ $midLinkClasses }}" itemprop="item">
                            <span itemprop="name">{{ $label }}</span>
                        </a>
                    @else
                        <span class="{{ $currentClasses }}" aria-current="page" itemprop="item" itemid="{{ request()->url() }}">
                            <span itemprop="name">{{ $label }}</span>
                        </span>
                    @endif
                    <meta itemprop="position" content="{{ $loop->iteration + 1 }}" />
                </div>
            </li>
        @endforeach
    </ol>
</nav>
