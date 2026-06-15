<x-layouts.app>
    @section('seo')
        <x-seo-meta
            title="Unsubscribed from VAT Change Alerts"
            description="You have been unsubscribed from EU VAT Info VAT change alerts."
            :url="url()->current()">
            <meta name="robots" content="noindex, nofollow">
        </x-seo-meta>
    @endsection

    <div class="container py-16">
        <div class="mx-auto max-w-xl rounded-xl border border-gray-200 bg-white p-8 text-center shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">You are unsubscribed</h1>
            <p class="text-gray-600 dark:text-gray-300 mb-6">
                {{ $subscription->email }} will no longer receive VAT change alerts from EU VAT Info.
            </p>
            <a href="{{ locale_path('/vat-changes') }}" class="inline-flex items-center justify-center rounded-lg bg-blue-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-800">
                View VAT changes
            </a>
        </div>
    </div>
</x-layouts.app>
