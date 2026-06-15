<?php

namespace App\Console\Commands;

use App\Models\VatChangeSubscription;
use App\Models\VatRateChange;
use App\Notifications\VatRateChangePublished;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class SendVatChangeNotifications extends Command
{
    protected $signature = 'vat-changes:notify-subscribers
        {--since-hours=24 : Only notify changes created within this many hours}
        {--limit=25 : Maximum number of change records to process}
        {--include-backlog : Include older unsent change records}
        {--dry-run : Count notifications without sending email or marking records sent}';

    protected $description = 'Send email alerts to active VAT change subscribers for new VAT rate changes.';

    public function handle(): int
    {
        $query = VatRateChange::with('country')
            ->where('notification_sent', false)
            ->whereDate('change_date', '>=', now()->subDays(30))
            ->orderBy('change_date')
            ->limit((int) $this->option('limit'));

        if (! $this->option('include-backlog')) {
            $query->where('created_at', '>=', now()->subHours((int) $this->option('since-hours')));
        }

        $changes = $query->get();
        $subscriberCount = VatChangeSubscription::active()->count();

        if ($changes->isEmpty() || $subscriberCount === 0) {
            $this->info("No notifications sent. Changes: {$changes->count()}, subscribers: {$subscriberCount}.");

            return self::SUCCESS;
        }

        $dryRun = (bool) $this->option('dry-run');
        $notifications = 0;

        foreach ($changes as $change) {
            VatChangeSubscription::active()
                ->orderBy('id')
                ->chunkById(200, function ($subscriptions) use ($change, $dryRun, &$notifications) {
                    foreach ($subscriptions as $subscription) {
                        $notifications++;

                        if (! $dryRun) {
                            Notification::route('mail', $subscription->email)
                                ->notify(new VatRateChangePublished($change, $subscription));

                            $subscription->forceFill(['last_notified_at' => now()])->save();
                        }
                    }
                });

            if (! $dryRun) {
                $change->forceFill([
                    'notification_sent' => true,
                    'notification_sent_at' => now(),
                ])->save();
            }
        }

        $mode = $dryRun ? 'Would send' : 'Sent';
        $this->info("{$mode} {$notifications} VAT change notification(s) for {$changes->count()} change record(s).");

        return self::SUCCESS;
    }
}
