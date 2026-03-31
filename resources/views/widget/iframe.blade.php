@extends('components.layouts.app-embed')
@section('content')
    <div class="p-6">
        @if(request()->query('style') === 'horizontal')
            <livewire:hero-calculator :key="'hero-calc-widget-' . $country" :initial-country="$country" :show-header="false" />
        @else
            <livewire:vat-calculator-form />
        @endif
        <div class="mt-3 text-right">
            Powered by <a href="https://eu-vat.info" target="_blank" class="text-blue-500">eu-vat.info</a>
        </div>
    </div>
@endsection
