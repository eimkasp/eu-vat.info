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
            $table->string('iso_code_2', 2)->nullable()->after('iso_code');
        });

        // Update existing records to extract 2-letter code
        DB::statement("UPDATE countries SET iso_code_2 = SUBSTRING_INDEX(SUBSTRING_INDEX(iso_code, '(', -1), ')', 1) WHERE iso_code LIKE '%(%)%'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->dropColumn('iso_code_2');
        });
    }
};
