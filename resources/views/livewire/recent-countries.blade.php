<div>
@if(count($recentCountries) > 0)
<div class="bg-white rounded-lg shadow-lg p-6 mb-6">
    <h2 class="text-xl font-bold mb-4">Recently Viewed Countries</h2>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4">
        @foreach($recentCountries as $country)
        <a href="{{ locale_path('/country/' . $country->slug) }}" 
           class="flex flex-col items-center p-3 rounded-lg hover:bg-gray-50 transition-colors">
            <img src="https://flagcdn.com/h40/{{ strtolower($country->iso_code) }}.jpg" 
                 alt="{{ $country->name }} flag" 
                 class="w-10 h-6 object-cover rounded shadow-sm mb-2">
            <span class="text-sm text-center font-medium">{{ $country->name }}</span>
            <span class="text-xs text-gray-500">{{ $country->standard_rate }}%</span>
        </a>
        @endforeach
    </div>
</div>
@endif
</div>