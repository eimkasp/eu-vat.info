@extends('components.layouts.app')
 @isset($selectedCountry->name)
@section('title', 'Embed VAT Calculator for '. $selectedCountry->name . ' to your website - EU VAT Info')

@else
@section('title', 'Embed VAT Calculator to your website - EU VAT Info')

@endisset
@section('meta_description', 'Embed this VAT Calculator widget on your website to show the current VAT rates for all EU
    countries. Customization options available.')
@push('head')
    @php
        $iframeBase = route('widget.iframe');
        $countrySlug = $selectedCountry->slug ?? '';
    @endphp
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('embedWidget', () => ({
                style: 'vertical',
                copied: false,
                showGuide: false,
                base: @js($iframeBase),
                country: @js($countrySlug),
                get iframeSrc() {
                    const countryPath = this.country ? '/' + this.country : '';
                    const styleParam = this.style === 'horizontal' ? '?style=horizontal' : '';
                    return this.base + countryPath + styleParam;
                },
                get embedCode() {
                    const height = this.style === 'horizontal' ? '320px' : '400px';
                    return '&lt;iframe src="' + this.iframeSrc + '" style="border:none;outline:none;background:transparent;box-shadow:none;" width="100%" height="' + height + '" frameborder="0"&gt;&lt;/iframe&gt;';
                },
                get embedCodeRaw() {
                    const height = this.style === 'horizontal' ? '320px' : '400px';
                    return '<iframe src="' + this.iframeSrc + '" style="border:none;outline:none;background:transparent;box-shadow:none;" width="100%" height="' + height + '" frameborder="0"></iframe>';
                },
                copyCode() {
                    navigator.clipboard.writeText(this.embedCodeRaw);
                    this.copied = true;
                    setTimeout(() => this.copied = false, 2000);
                }
            }));
        });
    </script>
@endpush
@section('content')
    <div class="container mx-auto !py-12" x-data="embedWidget">
            <div>
                <h1 class="text-4xl font-bold mb-4">Embed EU VAT Widget
                    @isset($selectedCountry->name)
                        for {{ $selectedCountry->name }}
                    @endisset
                </h1>
                <p class="mb-6 text-gray-600">Embed this widget on your website to show the current VAT rates for all EU countries.</p>
            </div>

            {{-- Config row: Style + Embed Code side by side --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                {{-- Style Selector --}}
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200">
                    <h2 class="text-lg font-bold mb-3">Widget Style</h2>
                    <div class="grid grid-cols-2 gap-3">
                        <button
                            @click="style = 'vertical'"
                            :class="style === 'vertical' ? 'border-blue-500 bg-blue-50 ring-2 ring-blue-200' : 'border-gray-200 hover:border-gray-300'"
                            class="relative flex flex-col items-center gap-2 p-4 rounded-xl border-2 transition-all cursor-pointer"
                        >
                            {{-- Vertical icon --}}
                            <div class="w-12 h-16 rounded-lg border-2 flex flex-col gap-1 p-1.5 transition-colors"
                                 :class="style === 'vertical' ? 'border-blue-400' : 'border-gray-300'">
                                <div class="w-full h-1.5 rounded-full" :class="style === 'vertical' ? 'bg-blue-400' : 'bg-gray-300'"></div>
                                <div class="w-full h-1.5 rounded-full" :class="style === 'vertical' ? 'bg-blue-300' : 'bg-gray-200'"></div>
                                <div class="w-3/4 h-1.5 rounded-full" :class="style === 'vertical' ? 'bg-blue-300' : 'bg-gray-200'"></div>
                                <div class="w-full h-2.5 rounded mt-auto" :class="style === 'vertical' ? 'bg-blue-400' : 'bg-gray-300'"></div>
                            </div>
                            <span class="text-sm font-semibold" :class="style === 'vertical' ? 'text-blue-700' : 'text-gray-600'">Vertical</span>
                            <span class="text-xs text-gray-400">Classic stacked layout</span>
                        </button>
                        <button
                            @click="style = 'horizontal'"
                            :class="style === 'horizontal' ? 'border-blue-500 bg-blue-50 ring-2 ring-blue-200' : 'border-gray-200 hover:border-gray-300'"
                            class="relative flex flex-col items-center gap-2 p-4 rounded-xl border-2 transition-all cursor-pointer"
                        >
                            {{-- Horizontal icon --}}
                            <div class="w-16 h-12 rounded-lg border-2 flex flex-col gap-1 p-1.5 transition-colors"
                                 :class="style === 'horizontal' ? 'border-blue-400' : 'border-gray-300'">
                                <div class="flex gap-1">
                                    <div class="w-1/3 h-1.5 rounded-full" :class="style === 'horizontal' ? 'bg-blue-400' : 'bg-gray-300'"></div>
                                    <div class="w-1/3 h-1.5 rounded-full" :class="style === 'horizontal' ? 'bg-blue-300' : 'bg-gray-200'"></div>
                                    <div class="w-1/3 h-1.5 rounded-full" :class="style === 'horizontal' ? 'bg-blue-400' : 'bg-gray-300'"></div>
                                </div>
                                <div class="flex gap-1 mt-1">
                                    <div class="w-1/2 h-1.5 rounded-full" :class="style === 'horizontal' ? 'bg-blue-300' : 'bg-gray-200'"></div>
                                    <div class="w-1/2 h-1.5 rounded-full" :class="style === 'horizontal' ? 'bg-blue-300' : 'bg-gray-200'"></div>
                                </div>
                            </div>
                            <span class="text-sm font-semibold" :class="style === 'horizontal' ? 'text-blue-700' : 'text-gray-600'">Horizontal</span>
                            <span class="text-xs text-gray-400">Wide inline layout</span>
                        </button>
                    </div>
                </div>

                {{-- Embed Code --}}
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200">
                    <h2 class="text-lg font-bold mb-3">Embed Code</h2>
                    <pre class="bg-gray-50 p-4 rounded-lg w-full break-all whitespace-pre-wrap text-sm text-gray-700 border border-gray-200" x-html="embedCode"></pre>
                    <div class="flex items-center justify-between mt-4">
                        <button
                            @click="copyCode()"
                            class="btn btn-primary plausible-event-name=CopyCode flex items-center gap-2"
                        >
                            <template x-if="!copied">
                                <span class="flex items-center gap-2">
                                    Copy code
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </span>
                            </template>
                            <template x-if="copied">
                                <span class="flex items-center gap-2 text-green-200">
                                    Copied!
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                </span>
                            </template>
                        </button>
                        <div class="flex items-center gap-3">
                            <button
                                @click="showGuide = true"
                                class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center gap-1 transition-colors"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                How to install
                            </button>
                            <span class="text-sm text-gray-400">Forever free!</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Full-width Preview --}}
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 mb-8">
                <h2 class="text-lg font-bold mb-4">Widget Preview</h2>

                {{-- Vertical preview: constrain width --}}
                <div x-show="style === 'vertical'" x-transition class="max-w-md mx-auto">
                    @isset($selectedCountry->slug)
                        <livewire:vat-calculator-form :slug="$selectedCountry->slug" />
                    @else
                        <livewire:vat-calculator-form slug="united-kingdom-gb" />
                    @endisset
                </div>

                {{-- Horizontal preview: full width --}}
                <div x-show="style === 'horizontal'" x-transition>
                    <livewire:hero-calculator :initial-country="$selectedCountry->slug ?? 'germany'" :show-header="false" />
                </div>

                <div class="mt-3 text-right text-sm">
                    Powered by <a href="https://eu-vat.info" target="_blank" class="text-blue-500 hover:underline">eu-vat.info</a>
                </div>
            </div>

            {{-- Country list --}}
            <div>
                <x-country-calculator-list />
            </div>

            {{-- Installation Guide Modal --}}
            <div x-show="showGuide" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" @keydown.escape.window="showGuide = false">
                {{-- Backdrop --}}
                <div x-show="showGuide" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute inset-0 bg-black/50" @click="showGuide = false"></div>

                {{-- Modal --}}
                <div x-show="showGuide" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="relative bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                    {{-- Header --}}
                    <div class="sticky top-0 bg-white border-b border-gray-200 rounded-t-2xl px-6 py-4 flex items-center justify-between">
                        <h2 class="text-xl font-bold text-gray-900">How to Add the Widget to Your Website</h2>
                        <button @click="showGuide = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    {{-- Body --}}
                    <div class="px-6 py-5 space-y-6">
                        {{-- Step 1 --}}
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center text-sm">1</div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Choose your widget style</h3>
                                <p class="text-sm text-gray-600">Select <strong>Vertical</strong> for sidebars and narrow spaces, or <strong>Horizontal</strong> for full-width sections and headers.</p>
                            </div>
                        </div>

                        {{-- Step 2 --}}
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center text-sm">2</div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Copy the embed code</h3>
                                <p class="text-sm text-gray-600">Click the <strong>Copy code</strong> button above. The code is a simple HTML <code class="bg-gray-100 px-1.5 py-0.5 rounded text-xs font-mono">&lt;iframe&gt;</code> snippet — no JavaScript or dependencies required.</p>
                            </div>
                        </div>

                        {{-- Step 3 --}}
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center text-sm">3</div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Paste into your website</h3>
                                <p class="text-sm text-gray-600 mb-2">Add the code where you want the widget to appear. Works with any platform:</p>
                                <div class="grid grid-cols-2 gap-2 text-xs">
                                    <div class="bg-gray-50 rounded-lg p-3 border border-gray-200">
                                        <p class="font-semibold text-gray-700 mb-1">WordPress</p>
                                        <p class="text-gray-500">Add a Custom HTML block and paste the code.</p>
                                    </div>
                                    <div class="bg-gray-50 rounded-lg p-3 border border-gray-200">
                                        <p class="font-semibold text-gray-700 mb-1">Shopify</p>
                                        <p class="text-gray-500">Edit theme &rarr; Add a Custom Liquid section.</p>
                                    </div>
                                    <div class="bg-gray-50 rounded-lg p-3 border border-gray-200">
                                        <p class="font-semibold text-gray-700 mb-1">Wix / Squarespace</p>
                                        <p class="text-gray-500">Use an Embed / HTML block widget.</p>
                                    </div>
                                    <div class="bg-gray-50 rounded-lg p-3 border border-gray-200">
                                        <p class="font-semibold text-gray-700 mb-1">Plain HTML</p>
                                        <p class="text-gray-500">Paste directly into your HTML file.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Step 4 --}}
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center text-sm">4</div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Adjust the height (optional)</h3>
                                <p class="text-sm text-gray-600">The default height works for most cases. To change it, edit the <code class="bg-gray-100 px-1.5 py-0.5 rounded text-xs font-mono">height</code> value in the iframe code. Recommended: <strong>400px</strong> for vertical, <strong>320px</strong> for horizontal.</p>
                            </div>
                        </div>

                        {{-- Info box --}}
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="text-sm text-blue-800">
                                <p class="font-semibold mb-1">Good to know</p>
                                <ul class="space-y-1 text-blue-700">
                                    <li>&bull; The widget is <strong>completely free</strong> — no account or API key needed.</li>
                                    <li>&bull; VAT rates are <strong>updated automatically</strong> from official EU sources.</li>
                                    <li>&bull; The widget is <strong>responsive</strong> and adapts to any container width.</li>
                                    <li>&bull; No cookies or tracking — fully <strong>GDPR compliant</strong>.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="sticky bottom-0 bg-gray-50 border-t border-gray-200 rounded-b-2xl px-6 py-4 flex justify-end">
                        <button @click="showGuide = false" class="btn btn-primary">Got it</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection
