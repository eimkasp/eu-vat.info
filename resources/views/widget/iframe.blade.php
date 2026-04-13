@extends('components.layouts.app-embed')
@section('content')
    <div class="p-6">
        @if(request()->query('style') === 'horizontal')
            <livewire:hero-calculator :key="'hero-calc-widget-' . $country" :initial-country="$country" :show-header="false" />
        @else
            <livewire:vat-calculator-form />
        @endif
        <div class="mt-3 text-right">
            Powered by <a href="https://businesspress.io" target="_blank" class="text-blue-500">BusinessPress</a>
        </div>
    </div>
@endsection
