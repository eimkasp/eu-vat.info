<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vat_rate_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained()->cascadeOnDelete();
            $table->string('category_slug');
            $table->string('category_name');
            $table->string('rate_type');
            $table->decimal('rate', 5, 2);
            $table->date('effective_from')->nullable();
            $table->date('effective_to')->nullable();
            $table->text('legal_basis')->nullable();
            $table->string('source_url')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['country_id', 'category_slug', 'published_at'], 'vat_rules_country_category_publish');
            $table->index(['category_slug', 'published_at', 'effective_from', 'effective_to'], 'vat_rules_category_eligibility');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vat_rate_rules');
    }
};
