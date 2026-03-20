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
        <a href="{{ locale_path('/country/' . $related->slug) }}" 
          
           class="flex items-center gap-3 p-4 bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 hover:shadow-md hover:border-blue-200 dark:hover:border-blue-600 transition-all group">
            <img src="https://flagcdn.com/h40/{{ strtolower($related->iso_code) }}.jpg" 
                 alt="{{ $related->name }} flag" 
                 class="w-8 h-auto rounded shadow-sm"
                 loading="lazy">
            <div class="flex-1 min-w-0">
                <div class="font-bold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors truncate">{{ $related->name }}</div>
                <div class="text-sm text-gray-500 dark:text-gray-400">VAT: <strong class="text-blue-600 dark:text-blue-400">{{ $related->standard_rate }}%</strong></div>
            </div>
            <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 group-hover:text-blue-600 dark:group-hover:text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>
    @endforeach
</div>
