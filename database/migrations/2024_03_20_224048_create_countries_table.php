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
        /* My Data
        "Country","Super-reduced Rate (%)","Reduced Rate (%)","Parking Rate (%)","Standard Rate (%)"
        "Austria (AT)","-","10 / 13","13","20"
        */
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug'); // Field name same as your `saveSlugsTo`
            $table->decimal('super_reduced_rate', 5, 2)->nullable();
            /* Reduced rate is string because it can be such value 5-10% */
            $table->string('reduced_rate')->nullable();
            $table->decimal('parking_rate', 5, 2)->nullable();
            $table->decimal('standard_rate', 5, 2)->nullable();
            $table->string('currency')->nullable();
            $table->string('currency_code')->nullable();
            $table->string('currency_symbol')->nullable();
            $table->string('flag')->nullable();
            $table->string('iso_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
