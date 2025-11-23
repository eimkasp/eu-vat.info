<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vat_validation_logs', function (Blueprint $table) {
            $table->id();
            $table->string('country_code', 2);
            $table->string('vat_number');
            $table->boolean('is_valid');
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('request_identifier')->nullable(); // VIES request ID
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vat_validation_logs');
    }
};
