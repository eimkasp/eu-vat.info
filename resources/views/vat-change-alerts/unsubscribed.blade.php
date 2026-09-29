@extends('layouts.app')

@section('seo')
    <x-seo-meta :title="__('ui.alerts.unsubscribed_meta')" :description="__('ui.alerts.unsubscribed_meta')" :url="url()->current()" robots="noindex, nofollow" />
@endsection

@section('content')
    <div class="app-container py-16 sm:py-24">
        <div class="app-surface mx-auto max-w-xl p-8 text-center">
            <span class="mx-auto flex size-12 items-center justify-center rounded-full bg-success-soft text-success" aria-hidden="true">
                <x-ui.icon name="check" class="size-6" />
            </span>
            <h1 class="mt-5 text-2xl font-bold text-ink">{{ __('ui.alerts.unsubscribed_title') }}</h1>
            <p class="mt-3 text-ink-muted">{{ __('ui.alerts.unsubscribed_desc', ['email' => $subscription->email]) }}</p>
            <a href="{{ locale_path('/vat-changes') }}" class="app-button-primary mt-6">
                {{ __('ui.alerts.view_changes') }}
                <x-ui.icon name="arrow-right" class="size-4" />
            </a>
        </div>
    </div>
@endsection
