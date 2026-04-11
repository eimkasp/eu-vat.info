<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->string('native_name')->nullable()->after('name');
        });

        // Populate native names for all EU countries
        $nativeNames = [
            'AT' => 'Österreich',
            'BE' => 'België / Belgique',
            'BG' => 'България',
            'HR' => 'Hrvatska',
            'CY' => 'Κύπρος',
            'CZ' => 'Česko',
            'DK' => 'Danmark',
            'EE' => 'Eesti',
            'FI' => 'Suomi',
            'FR' => 'France',
            'DE' => 'Deutschland',
            'GR' => 'Ελλάδα',
            'HU' => 'Magyarország',
            'IE' => 'Éire / Ireland',
            'IT' => 'Italia',
            'LV' => 'Latvija',
            'LT' => 'Lietuva',
            'LU' => 'Lëtzebuerg',
            'MT' => 'Malta',
            'NL' => 'Nederland',
            'PL' => 'Polska',
            'PT' => 'Portugal',
            'RO' => 'România',
            'SK' => 'Slovensko',
            'SI' => 'Slovenija',
            'ES' => 'España',
            'SE' => 'Sverige',
        ];

        foreach ($nativeNames as $iso => $nativeName) {
            DB::table('countries')->where('iso_code', $iso)->update(['native_name' => $nativeName]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->dropColumn('native_name');
        });
    }
};
