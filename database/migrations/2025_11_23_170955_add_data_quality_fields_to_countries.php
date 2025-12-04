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
        Schema::table('countries', function (Blueprint $table) {
            // Add zero_rate field for 0% VAT products
            $table->boolean('zero_rate')->default(false)->after('parking_rate');

            // Data source and credibility
            $table->string('data_source')->nullable()->after('iso_code_2');
            $table->string('data_source_url')->nullable()->after('data_source');
            $table->timestamp('last_verified_at')->nullable()->after('data_source_url');
            $table->timestamp('last_updated_from_source')->nullable()->after('last_verified_at');

            // Data quality indicators
            $table->boolean('is_verified')->default(false)->after('last_updated_from_source');
            $table->string('verification_status')->default('pending')->after('is_verified'); // pending, verified, needs_review

            // Credibility score (0-100)
            $table->integer('credibility_score')->default(0)->after('verification_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->dropColumn([
                'zero_rate',
                'data_source',
                'data_source_url',
                'last_verified_at',
                'last_updated_from_source',
                'is_verified',
                'verification_status',
                'credibility_score',
            ]);
        });
    }
};
