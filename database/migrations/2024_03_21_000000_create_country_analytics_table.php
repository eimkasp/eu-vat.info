<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('country_analytics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained()->cascadeOnDelete();
            $table->string('type'); // 'view' or 'calculator'
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('referer')->nullable();
            $table->string('location_country')->nullable();
            $table->string('location_city')->nullable();
            $table->decimal('amount', 10, 2)->nullable(); // For calculator tracking
            $table->decimal('rate_used', 5, 2)->nullable(); // VAT rate used
            $table->json('meta_data')->nullable(); // Additional data
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('country_analytics');
    }
};
