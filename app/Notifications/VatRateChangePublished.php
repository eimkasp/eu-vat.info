<?php

namespace App\Notifications;

use App\Models\VatChangeSubscription;
use App\Models\VatRateChange;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class VatRateChangePublished extends Notification
{
    use Queueable;

    public function __construct(
        public VatRateChange $change,
        public VatChangeSubscription $subscription,
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $country = $this->change->country?->name ?? 'Europe';
        $rateType = Str::headline(str_replace('_', ' ', $this->change->rate_type));
        $direction = $this->change->change_direction === 'decrease' ? 'decreased' : 'changed';
        $unsubscribeUrl = URL::temporarySignedRoute(
            'vat-change-alerts.unsubscribe',
            now()->addYears(5),
            ['subscription' => $this->subscription->id],
        );

        $message = (new MailMessage)
            ->subject("VAT alert: {$country} {$rateType} rate {$direction}")
            ->greeting('VAT change alert')
            ->line("{$country} {$rateType} VAT rate {$direction} from {$this->change->old_rate}% to {$this->change->new_rate}%.")
            ->line('Effective date: '.$this->change->change_date->format('F j, Y'));

        if ($this->change->description) {
            $message->line($this->change->description);
        }

        return $message
            ->action('View VAT changes', url('/vat-changes'))
            ->line('You are receiving this because you subscribed to EU VAT Info VAT change alerts.')
            ->line('Unsubscribe: '.$unsubscribeUrl);
    }
}
