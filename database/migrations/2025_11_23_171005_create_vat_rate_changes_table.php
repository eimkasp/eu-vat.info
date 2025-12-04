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
        Schema::create('vat_rate_changes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vat_rate_id')->nullable()->constrained()->nullOnDelete();

            // Change details
            $table->string('rate_type'); // standard, reduced, super_reduced, parking, zero
            $table->decimal('old_rate', 5, 2);
            $table->decimal('new_rate', 5, 2);
            $table->date('change_date');
            $table->date('announced_date')->nullable();

            // Change metadata
            $table->text('change_reason')->nullable();
            $table->text('description')->nullable();
            $table->string('source')->nullable();
            $table->string('source_url')->nullable();
            $table->string('official_document')->nullable();

            // Impact analysis
            $table->decimal('percentage_change', 5, 2)->nullable();
            $table->enum('change_direction', ['increase', 'decrease', 'no_change'])->nullable();

            // Notification tracking
            $table->boolean('notification_sent')->default(false);
            $table->timestamp('notification_sent_at')->nullable();

            $table->timestamps();

            // Indexes for efficient querying
            $table->index(['country_id', 'change_date'], 'idx_country_change_date');
            $table->index('change_date', 'idx_change_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vat_rate_changes');
    }
};
