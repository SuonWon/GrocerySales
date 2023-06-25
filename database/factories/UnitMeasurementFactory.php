<?php

namespace Database\Factories;

use App\Models\UnitMeasurement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UnitMeasurement>
 */
class UnitMeasurementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'UnitCode' => UnitMeasurement::factory(),
            'UnitDesc' => fake()->sentence(),
            'CreatedBy' => fake()->name()
        ];
    }
}
