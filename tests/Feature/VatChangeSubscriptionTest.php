<?php

use App\Livewire\VatChangeSignup;
use App\Models\VatChangeSubscription;
use Illuminate\Support\Facades\URL;
use Livewire\Livewire;

it('subscribes an email address to VAT change alerts', function () {
    Livewire::test(VatChangeSignup::class, ['source' => 'test'])
        ->set('email', 'USER@example.com')
        ->call('subscribe')
        ->assertHasNoErrors()
        ->assertSet('email', '');

    $this->assertDatabaseHas('vat_change_subscriptions', [
        'email' => 'user@example.com',
        'status' => VatChangeSubscription::STATUS_ACTIVE,
        'source' => 'test',
    ]);
});

it('reactivates an unsubscribed email address', function () {
    $subscription = VatChangeSubscription::create([
        'email' => 'alerts@example.com',
        'status' => VatChangeSubscription::STATUS_UNSUBSCRIBED,
        'subscribed_at' => now()->subMonth(),
        'unsubscribed_at' => now()->subDay(),
    ]);

    Livewire::test(VatChangeSignup::class, ['source' => 'test-reactivation'])
        ->set('email', 'alerts@example.com')
        ->call('subscribe')
        ->assertHasNoErrors();

    $subscription->refresh();

    expect($subscription->status)->toBe(VatChangeSubscription::STATUS_ACTIVE);
    expect($subscription->unsubscribed_at)->toBeNull();
    expect($subscription->source)->toBe('test-reactivation');
});

it('validates subscription email addresses', function () {
    Livewire::test(VatChangeSignup::class)
        ->set('email', 'not-an-email')
        ->call('subscribe')
        ->assertHasErrors(['email']);
});

it('unsubscribes using a signed URL', function () {
    $subscription = VatChangeSubscription::create([
        'email' => 'alerts@example.com',
        'status' => VatChangeSubscription::STATUS_ACTIVE,
        'subscribed_at' => now(),
    ]);

    $url = URL::signedRoute('vat-change-alerts.unsubscribe', ['subscription' => $subscription]);

    $this->get($url)
        ->assertOk()
        ->assertSee('You are unsubscribed');

    expect($subscription->fresh()->status)->toBe(VatChangeSubscription::STATUS_UNSUBSCRIBED);
});
