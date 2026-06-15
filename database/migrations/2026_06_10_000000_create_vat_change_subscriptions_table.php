<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vat_change_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('status')->default('active');
            $table->timestamp('subscribed_at')->nullable();
            $table->timestamp('unsubscribed_at')->nullable();
            $table->timestamp('last_notified_at')->nullable();
            $table->string('source')->nullable();
            $table->string('locale', 10)->default('en');
            $table->string('ip_hash', 64)->nullable();
            $table->json('country_filters')->nullable();
            $table->timestamps();

            $table->index(['status', 'subscribed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vat_change_subscriptions');
    }
};
