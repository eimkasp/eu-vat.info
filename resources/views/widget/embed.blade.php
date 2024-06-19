@extends('components.layouts.app')
@section('content')
    <div class="container mx-auto !py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-9">
            <div>
                <h1 class="text-4xl font-bold mb-4">Embed EU VAT Widget</h1>
                <p class="mb-4">Embed this widget on your website to show the current VAT rates for all EU countries.</p>
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold mb-4">Embed code</h2>
                    <pre class="bg-gray-100 p-4 rounded-lg w-full break-all whitespace-pre-wrap">&lt;iframe src="{{ route('widget.embed') }}" width="100%" height="400px" frameborder="0"&gt;&lt;/iframe&gt;
        </pre>
                    <div class="flex items-center justify-between mt-6">
                        <div class="btn btn-primary">Copy code
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                        <div>Forever free!</div>
                    </div>
                </div>
            </div>

            <div>
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold mb-4">Widget Preview</h2>
                    <livewire:vat-calculator-form />
                    <div class="mt-3 text-right">
                    Powered by <a href="https://eu-vat.info" target="_blank" class="text-blue-500">EU-VAT.info</a>
                    </div>
                </div>
            </div>


        </div>
    @endsection
