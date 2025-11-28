<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vat_validation_cache', function (Blueprint $table) {
            $table->id();
            $table->string('country_code', 2)->index();
            $table->string('vat_number', 50)->index();
            $table->boolean('is_valid')->default(false);
            $table->string('name')->nullable();
            $table->text('address')->nullable();
            $table->timestamp('last_checked_at');
            $table->timestamps();

            // Composite unique index for country + VAT number
            $table->unique(['country_code', 'vat_number'], 'vat_cache_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vat_validation_cache');
    }
};
