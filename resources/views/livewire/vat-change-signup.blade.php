<section class="bg-white dark:bg-gray-800 border border-blue-100 dark:border-gray-700 rounded-xl shadow-sm p-5">
    <div class="{{ $compact ? '' : 'sm:flex sm:items-start sm:justify-between sm:gap-5' }}">
        <div class="{{ $compact ? 'mb-4' : 'mb-4 sm:mb-0' }}">
            <p class="text-xs font-semibold uppercase tracking-wide text-blue-700 dark:text-blue-300 mb-1">VAT change alerts</p>
            <h2 class="{{ $compact ? 'text-lg' : 'text-xl' }} font-bold text-gray-900 dark:text-white mb-2">Get notified when European VAT rates change</h2>
            <p class="text-sm text-gray-600 dark:text-gray-300 mb-0">
                We send practical alerts for material VAT rate changes and major EU VAT rule updates. Unsubscribe anytime.
            </p>
        </div>

        <form wire:submit="subscribe" class="{{ $compact ? 'space-y-3' : 'sm:min-w-[320px] space-y-3' }}">
            <label for="vat-change-email-{{ $this->getId() }}" class="sr-only">Email address</label>
            <input
                id="vat-change-email-{{ $this->getId() }}"
                type="email"
                wire:model="email"
                autocomplete="email"
                placeholder="you@example.com"
                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 text-sm focus:border-blue-500 focus:ring-blue-500"
            >

            <input type="text" wire:model="website" tabindex="-1" autocomplete="off" class="hidden" aria-hidden="true">

            @error('email')
                <p class="text-sm text-red-600 dark:text-red-400 mb-0">{{ $message }}</p>
            @enderror

            <button type="submit" class="inline-flex w-full items-center justify-center rounded-lg bg-blue-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-800 disabled:opacity-60" wire:loading.attr="disabled">
                <span wire:loading.remove>Subscribe</span>
                <span wire:loading>Subscribing...</span>
            </button>

            @if($statusMessage)
                <p class="text-sm {{ $messageType === 'success' ? 'text-green-700 dark:text-green-300' : 'text-red-600 dark:text-red-400' }} mb-0">{{ $statusMessage }}</p>
            @endif
        </form>
    </div>
</section>
