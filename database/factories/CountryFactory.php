<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CountryFactory extends Factory
{
    protected $model = Country::class;

    protected $countries = [
        ['name' => 'Germany', 'iso' => 'DE'],
        ['name' => 'France', 'iso' => 'FR'],
        ['name' => 'Spain', 'iso' => 'ES'],
        ['name' => 'Italy', 'iso' => 'IT'],
        ['name' => 'Netherlands', 'iso' => 'NL'],
        ['name' => 'Belgium', 'iso' => 'BE'],
        ['name' => 'Poland', 'iso' => 'PL'],
        ['name' => 'Sweden', 'iso' => 'SE'],
    ];

    public function definition(): array
    {
        $country = $this->faker->unique()->randomElement($this->countries);

        return [
            'name' => $country['name'],
            'iso_code' => $country['iso'],
            'slug' => Str::slug($country['name']),
            'standard_rate' => $this->faker->numberBetween(15, 27),
            'reduced_rate' => $this->faker->numberBetween(5, 12),
            'zero_rate' => 0,
            'super_reduced_rate' => 0,
            'parking_rate' => 0,
        ];
    }

    /**
     * Configure the factory to create a test country with specific rates.
     */
    public function withRates(float $standardRate, float $reducedRate = 0): self
    {
        return $this->state(function (array $attributes) use ($standardRate, $reducedRate) {
            return [
                'standard_rate' => $standardRate,
                'reduced_rate' => $reducedRate,
            ];
        });
    }

    /**
     * Configure the model factory with a specific country
     */
    public function country(string $name, string $isoCode): self
    {
        return $this->state([
            'name' => $name,
            'iso_code' => strtoupper($isoCode),
            'slug' => Str::slug($name),
        ]);
    }
}
