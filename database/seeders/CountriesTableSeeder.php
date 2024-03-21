<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csv = Reader::createFromPath(base_path('data/eu-vat-2024-jan.csv'), 'r');
        $csv->setHeaderOffset(0);

        foreach ($csv as $record) {
            $superReducedRate = empty (trim($record['Super-reduced Rate (%)'])) ? null : $this->convertToDecimal($record['Super-reduced Rate (%)']);
            $reducedRate = empty (trim($record['Reduced Rate (%)'])) ? null : $this->convertToDecimal($record['Reduced Rate (%)']);
            $parkingRate = empty (trim($record['Parking Rate (%)'])) ? null : $this->convertToDecimal($record['Parking Rate (%)']);
            $standardRate = empty (trim($record['Standard Rate (%)'])) ? null : $this->convertToDecimal($record['Standard Rate (%)']);
            if($superReducedRate === '-') {
                $superReducedRate = null;
            }

            if($reducedRate === '-') {
                $reducedRate = null;
            }

            if($parkingRate === '-') {
                $parkingRate = null;
            }

            if($standardRate === '-') {
                $standardRate = null;
            }

            Country::create([
                'name' => $record['Country'],
                'iso_code' => $record['Country'],
                'super_reduced_rate' => $superReducedRate,
                'reduced_rate' => $reducedRate,
                'parking_rate' => $parkingRate,
                'standard_rate' => $standardRate,
            ]);
        }
    }

    private function convertToDecimal($value)
    {
        if (strpos($value, '/') !== false) {
            $numbers = explode('/', $value);
            return array_sum($numbers) / count($numbers);
        }

        return $value;
    }
}