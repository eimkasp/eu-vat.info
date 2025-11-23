@props(['position'])

@php
    $banners = \App\Models\Banner::active()
        ->where('position', $position)
        ->get();
@endphp

@foreach($banners as $banner)
    <div class="banner-container my-4">
        <a href="{{ $banner->link_url }}" target="_blank" rel="noopener noreferrer" class="block hover:opacity-90 transition-opacity">
            @if($banner->image)
                <img src="{{ Storage::url($banner->image) }}" alt="{{ $banner->title }}" class="w-full rounded-lg shadow-md">
            @elseif($banner->content)
                <div class="bg-white rounded-lg shadow-md p-4">
                    {!! $banner->content !!}
                </div>
            @endif
        </a>
    </div>
@endforeach
