<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
             'ItemCode' => fake()->unique()->regexify('I-\d{5}'),
             'ItemName' => fake()->name(),
             'ItemCategoryCode' => fake()->slug(),
             'BaseUnit' => fake()->sentence(),
             'UnitPrice' => fake()->numberBetween(0,1000),
             'DefSalesUnit' => fake()->sentence(),
             'DefPurUnit' => fake()->sentence(),
             'LastPurPrice' => fake()->sentence(),
             'Discontinued' => fake()->boolean(),
             'Remark' => fake()->sentence(),
             'CreatedBy' => fake()->name(),
          
           
        ];

        
    }
}
