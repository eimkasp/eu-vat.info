@props(['country'])

@php
    $relatedCountries = \App\Models\Country::where('id', '!=', $country->id)
        ->inRandomOrder()
        ->limit(6)
        ->get();
@endphp

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach ($relatedCountries as $related)
        @php
            $iso = strtoupper($related->iso_code);
            $flag = '';
            if (strlen($iso) === 2) {
                $flag = mb_chr(ord($iso[0]) + 127397) . mb_chr(ord($iso[1]) + 127397);
            }
        @endphp
        <a href="{{ route('country.show', $related->slug) }}" 
           wire:navigate
           class="flex items-center gap-3 p-4 bg-white rounded-xl border border-gray-100 hover:shadow-md hover:border-blue-200 transition-all group">
            <img src="https://flagcdn.com/h40/{{ strtolower($related->iso_code) }}.jpg" 
                 alt="{{ $related->name }} flag" 
                 class="w-8 h-auto rounded shadow-sm"
                 loading="lazy">
            <div class="flex-1 min-w-0">
                <div class="font-bold text-gray-900 group-hover:text-blue-600 transition-colors truncate">{{ $related->name }}</div>
                <div class="text-sm text-gray-500">VAT: <strong class="text-blue-600">{{ $related->standard_rate }}%</strong></div>
            </div>
            <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>
    @endforeach
</div>
