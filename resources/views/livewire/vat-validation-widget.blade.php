<div class="w-full max-w-2xl mx-auto" 
     x-data="{ 
         showSuccess: false,
         showError: false 
     }"
     @validation-complete.window="
         if ($event.detail.valid) {
             showSuccess = true;
             setTimeout(() => showSuccess = false, 3000);
         } else {
             showError = true;
             setTimeout(() => showError = false, 3000);
         }
     ">
    
    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
            EU VAT Number Validator
        </h2>
        <p class="text-sm text-gray-600 dark:text-gray-400">
            Validate EU VAT numbers using the official VIES service with intelligent company name and address matching.
        </p>
    </div>

    <!-- Validation Form -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 space-y-4">
        
        <!-- Country Selection -->
        <div>
            <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Country <span class="text-red-500">*</span>
            </label>
            <select 
                wire:model.live="countryCode"
                id="country"
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                @disabled($isLoading)>
                <option value="">Select a country</option>
                @foreach($euCountries as $code => $name)
                    <option value="{{ $code }}">{{ $name }} ({{ $code }})</option>
                @endforeach
            </select>
            @error('countryCode')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- VAT Number Input -->
        <div>
            <label for="vatNumber" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                VAT Number <span class="text-red-500">*</span>
            </label>
            <div class="flex gap-2">
                <div class="flex-1">
                    <input 
                        type="text"
                        wire:model.live="vatNumber"
                        id="vatNumber"
                        placeholder="e.g., 123456789"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400"
                        @disabled($isLoading)
                        @keydown.enter="$wire.validate()">
                    @error('vatNumber')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Enter the VAT number without the country code prefix
                    </p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3 pt-2">
            <button 
                wire:click="validate"
                @disabled($isLoading || !$countryCode || !$vatNumber)
                class="flex-1 px-6 py-3 bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                @if($isLoading)
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Validating...</span>
                @else
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Validate VAT Number</span>
                @endif
            </button>

            @if($validationResult || $vatNumber)
                <button 
                    wire:click="clear"
                    @disabled($isLoading)
                    class="px-6 py-3 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                    Clear
                </button>
            @endif
        </div>

        <!-- Error Message -->
        @if($errorMessage)
            <div class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg" 
                 x-data="{ show: true }"
                 x-show="show"
                 x-transition>
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-red-800 dark:text-red-200">{{ $errorMessage }}</p>
                    </div>
                    <button @click="show = false" class="text-red-500 hover:text-red-700">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        <!-- Validation Result -->
        @if($validationResult)
            <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mt-4">
                
                <!-- Status Badge -->
                <div class="mb-4 flex items-center justify-between">
                    @if($validationResult['valid'])
                        <div class="flex items-center gap-2 px-4 py-2 bg-green-100 dark:bg-green-900/30 rounded-lg">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-semibold text-green-800 dark:text-green-200">Valid VAT Number</span>
                        </div>
                    @else
                        <div class="flex items-center gap-2 px-4 py-2 bg-red-100 dark:bg-red-900/30 rounded-lg">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-semibold text-red-800 dark:text-red-200">Invalid VAT Number</span>
                        </div>
                    @endif

                    <!-- Source Badge -->
                    <span class="text-xs px-3 py-1 rounded-full {{ $validationResult['source'] === 'vies' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                        {{ ucfirst($validationResult['source']) }}
                    </span>
                </div>

                <!-- Company Details -->
                @if($validationResult['name'] || $validationResult['address'])
                    <div class="space-y-3 bg-gray-50 dark:bg-gray-900/50 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-900 dark:text-white">Company Details</h3>
                        
                        @if($validationResult['name'])
                            <div>
                                <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Company Name</label>
                                <p class="text-sm text-gray-900 dark:text-white mt-1">{{ $validationResult['name'] }}</p>
                                
                                @if(isset($validationResult['name_match']) && $validationResult['name_match']['confidence'] > 0)
                                    <div class="mt-2 flex items-center gap-2">
                                        <div class="flex-1 h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                            <div class="h-full rounded-full transition-all duration-500 {{ $validationResult['name_match']['confidence'] >= 80 ? 'bg-green-500' : ($validationResult['name_match']['confidence'] >= 60 ? 'bg-yellow-500' : 'bg-red-500') }}" 
                                                 style="width: {{ $validationResult['name_match']['confidence'] }}%"></div>
                                        </div>
                                        <span class="text-xs text-gray-600 dark:text-gray-400 font-medium">
                                            {{ $validationResult['name_match']['confidence'] }}% match
                                        </span>
                                    </div>
                                @endif
                            </div>
                        @endif

                        @if($validationResult['address'])
                            <div>
                                <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Address</label>
                                <p class="text-sm text-gray-900 dark:text-white mt-1 whitespace-pre-line">{{ $validationResult['address'] }}</p>
                                
                                @if(isset($validationResult['address_match']) && $validationResult['address_match']['confidence'] > 0)
                                    <div class="mt-2 flex items-center gap-2">
                                        <div class="flex-1 h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                            <div class="h-full rounded-full transition-all duration-500 {{ $validationResult['address_match']['confidence'] >= 80 ? 'bg-green-500' : ($validationResult['address_match']['confidence'] >= 60 ? 'bg-yellow-500' : 'bg-red-500') }}" 
                                                 style="width: {{ $validationResult['address_match']['confidence'] }}%"></div>
                                        </div>
                                        <span class="text-xs text-gray-600 dark:text-gray-400 font-medium">
                                            {{ $validationResult['address_match']['confidence'] }}% match
                                        </span>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Request Date -->
                @if(isset($validationResult['request_date']))
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-3 text-center">
                        Validated on {{ \Carbon\Carbon::parse($validationResult['request_date'])->format('F j, Y \a\t g:i A') }}
                    </p>
                @endif
            </div>
        @endif
    </div>

    <!-- Info Notice -->
    <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
        <div class="flex gap-3">
            <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
            </svg>
            <div class="text-sm text-blue-800 dark:text-blue-200">
                <p class="font-medium mb-1">About VAT Validation</p>
                <p class="text-xs">This tool uses the European Commission's VIES service to verify VAT numbers. Results are cached for 7 days. Our fuzzy matching algorithm helps identify companies even with slight variations in name or address formatting.</p>
            </div>
        </div>
    </div>
</div>
