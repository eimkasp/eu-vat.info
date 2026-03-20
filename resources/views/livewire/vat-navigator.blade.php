@section('seo')
    <x-seo-meta
        :title="__('ui.navigator.seo_title')"
        :description="__('ui.navigator.seo_description')"
        :url="url()->current()"
    />
@endsection

<div class="container !py-6">
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
    <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4 text-white">
        <h2 class="text-xl font-semibold flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
            </svg>
            {{ __('ui.navigator.heading') }}
        </h2>
        <p class="text-purple-100 text-sm !mb-0 opacity-90">{{ __('ui.navigator.subtitle') }}</p>
    </div>

    <div class="p-6 grid md:grid-cols-2 gap-8">
        <!-- Form -->
        <div class="space-y-6">
            <x-select 
                :label="__('ui.navigator.seller_country')" 
                :options="$countries" 
                option-value="id"
                option-label="name" 
                :placeholder="__('ui.navigator.select_country')" 
                wire:model.live="sellerCountry"
                class="w-full"
            />

            <x-select 
                :label="__('ui.navigator.buyer_country')" 
                :options="collect($countries)->push(['id' => 'non-eu', 'name' => __('ui.navigator.non_eu_country')])" 
                option-value="id"
                option-label="name" 
                :placeholder="__('ui.navigator.select_country')" 
                wire:model.live="buyerCountry"
                class="w-full"
            />

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('ui.navigator.buyer_type') }}</label>
                <div class="flex gap-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" wire:model.live="buyerType" value="b2c" class="text-purple-600 focus:ring-purple-500">
                        <span class="text-gray-700 dark:text-gray-300">{{ __('ui.navigator.individual_b2c') }}</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" wire:model.live="buyerType" value="b2b" class="text-purple-600 focus:ring-purple-500">
                        <span class="text-gray-700 dark:text-gray-300">{{ __('ui.navigator.business_b2b') }}</span>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('ui.navigator.item_type') }}</label>
                <div class="flex gap-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" wire:model.live="itemType" value="goods" class="text-purple-600 focus:ring-purple-500">
                        <span class="text-gray-700 dark:text-gray-300">{{ __('ui.navigator.physical_goods') }}</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" wire:model.live="itemType" value="services" class="text-purple-600 focus:ring-purple-500">
                        <span class="text-gray-700 dark:text-gray-300">{{ __('ui.navigator.services') }}</span>
                    </label>
                </div>
            </div>

            @if($itemType === 'services')
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('ui.navigator.service_category') }}</label>
                    <select wire:model.live="productCategory" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        <option value="general">{{ __('ui.navigator.general_services') }}</option>
                        <option value="digital">{{ __('ui.navigator.digital_services') }}</option>
                        <option value="construction">{{ __('ui.navigator.construction_work') }}</option>
                        <option value="events">{{ __('ui.navigator.admission_events') }}</option>
                    </select>
                </div>
            @endif
        </div>

        <!-- Results -->
        <div class="bg-gray-50 dark:bg-gray-900 rounded-xl p-6 border border-gray-200 dark:border-gray-700 flex flex-col justify-center items-center text-center min-h-[300px]">
            @if($result)
                <div class="w-full animate-fade-in">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
                        </svg>
                    </div>
                    
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $result['action'] }}</h3>
                    
                    @if($result['rate'] !== 0 && $result['rate'] !== 'Varies')
                        <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-4">{{ $result['rate'] }}% VAT</div>
                    @endif

                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        {!! nl2br(e($result['explanation'])) !!}
                    </p>
                </div>
            @else
                <div class="text-gray-400 dark:text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mx-auto mb-3 opacity-50">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                    </svg>
                    <p>{{ __('ui.navigator.empty_state') }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
</div>
