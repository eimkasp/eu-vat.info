<?php

namespace App\Http\Controllers;

use App\Models\VatChangeSubscription;

class VatChangeSubscriptionController extends Controller
{
    public function unsubscribe(VatChangeSubscription $subscription)
    {
        $subscription->unsubscribe();

        return view('vat-change-alerts.unsubscribed', [
            'subscription' => $subscription,
        ]);
    }
}
