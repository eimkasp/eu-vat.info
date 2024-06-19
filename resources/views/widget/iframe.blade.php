@extends('components.layouts.app-embed')
@section('content')
    <div class="p-6">
        <livewire:vat-calculator-form />
        <div class="mt-3 text-right">
            Powered by <a href="https://eu-vat.info" target="_blank" class="text-blue-500">EU-VAT.info</a>
        </div>
    </div>
@endsection
