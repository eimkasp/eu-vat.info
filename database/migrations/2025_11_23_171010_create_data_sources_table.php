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
        Schema::create('data_sources', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('url')->nullable();
            $table->string('api_endpoint')->nullable();
            $table->enum('type', ['official', 'community', 'commercial', 'scraper'])->default('community');
            
            // Credibility metrics
            $table->integer('credibility_score')->default(50); // 0-100
            $table->integer('reliability_score')->default(50); // 0-100
            $table->timestamp('last_checked_at')->nullable();
            $table->timestamp('last_successful_update')->nullable();
            $table->integer('consecutive_failures')->default(0);
            
            // Status
            $table->boolean('is_active')->default(true);
            $table->boolean('is_primary')->default(false);
            $table->integer('priority')->default(0); // Higher = checked first
            
            // Rate limiting
            $table->integer('requests_per_day')->nullable();
            $table->integer('requests_today')->default(0);
            $table->date('requests_reset_date')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_sources');
    }
};
