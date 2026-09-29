<?php

namespace App\Livewire;

use App\Models\VatChangeSubscription;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class VatChangeSignup extends Component
{
    public string $email = '';

    public string $website = '';

    public string $source = 'vat-changes';

    public bool $compact = false;

    public ?string $statusMessage = null;

    public string $messageType = 'success';

    protected function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email:rfc', 'max:254'],
            'website' => ['nullable', 'string', 'max:0'],
            'source' => ['required', 'string', 'max:100'],
        ];
    }

    public function subscribe(): void
    {
        if ($this->website !== '') {
            $this->email = '';
            $this->statusMessage = __('ui.alerts.check_inbox');

            return;
        }

        $this->email = VatChangeSubscription::normalizeEmail($this->email);
        $this->validate();

        $key = 'vat-change-signup:'.sha1((request()->ip() ?? 'unknown').'|'.$this->email);

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $this->addError('email', __('ui.alerts.too_many_attempts'));

            return;
        }

        RateLimiter::hit($key, 3600);

        $subscription = VatChangeSubscription::firstOrNew(['email' => $this->email]);
        $alreadyActive = $subscription->exists && $subscription->status === VatChangeSubscription::STATUS_ACTIVE;

        $subscription->reactivate(
            source: $this->source,
            locale: app()->getLocale(),
            ipHash: request()->ip() ? hash('sha256', request()->ip()) : null,
        );

        $this->messageType = 'success';
        $this->statusMessage = $alreadyActive
            ? __('ui.alerts.already_subscribed')
            : __('ui.alerts.subscribed');
        $this->email = '';
    }

    public function render()
    {
        return view('livewire.vat-change-signup');
    }
}
