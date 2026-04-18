<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\VatRateChange;
use Illuminate\Database\Eloquent\Factories\Factory;

class VatRateChangeFactory extends Factory
{
    protected $model = VatRateChange::class;

    public function definition(): array
    {
        $oldRate = $this->faker->randomFloat(2, 5, 25);
        $newRate = $oldRate + $this->faker->randomFloat(2, -3, 3);

        return [
            'country_id' => Country::factory(),
            'rate_type' => $this->faker->randomElement(['standard', 'reduced', 'super_reduced', 'parking']),
            'old_rate' => $oldRate,
            'new_rate' => $newRate,
            'change_date' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'change_direction' => $newRate > $oldRate ? 'increase' : 'decrease',
            'change_reason' => $this->faker->optional()->sentence(),
        ];
    }
}
