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
        Schema::table('vat_rates', function (Blueprint $table) {
            // Add notes field for additional context
            $table->text('notes')->nullable()->after('source');
            
            // Data validation fields
            $table->boolean('is_validated')->default(false)->after('notes');
            $table->string('validation_status')->default('pending')->after('is_validated'); // pending, validated, disputed
            $table->timestamp('validated_at')->nullable()->after('validation_status');
            $table->foreignId('validated_by')->nullable()->constrained('users')->nullOnDelete()->after('validated_at');
            
            // Change tracking
            $table->string('change_reason')->nullable()->after('validated_by');
            $table->decimal('previous_rate', 5, 2)->nullable()->after('change_reason');
            
            // Official document reference
            $table->string('official_document_url')->nullable()->after('previous_rate');
            $table->string('legal_reference')->nullable()->after('official_document_url');
            
            // Add index for better query performance
            $table->index(['country_id', 'type', 'effective_from'], 'idx_country_type_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vat_rates', function (Blueprint $table) {
            $table->dropIndex('idx_country_type_date');
            $table->dropForeign(['validated_by']);
            $table->dropColumn([
                'notes',
                'is_validated',
                'validation_status',
                'validated_at',
                'validated_by',
                'change_reason',
                'previous_rate',
                'official_document_url',
                'legal_reference'
            ]);
        });
    }
};
