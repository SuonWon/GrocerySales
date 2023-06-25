<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'CustomerCode'=>Customer::factory(),
            'CustomerName'=>fake()->name(),
            'NRCNo' => fake()->sentence(),
            'CompanyName' => fake()->company(),
            'Street' => fake()->streetName(),
            'City' => fake()->city(),
            'Region'=> fake()->sentence(),
            'ContactNo' => fake()->phoneNumber(),
            'OfficeNo' => fake()->buildingNumber(),
            'FaxNo' => fake()->phoneNumber(),
            'Email' => fake()->email(),
            'IsActive' => fake()->boolean(),
            'Remark' => fake()->sentence(),
            'CreatedBy' => fake()->name(),
            'ModifiedBy' => fake()->name(),
            
        ];
    }
}
