<?php

namespace Database\Factories;

use App\Models\Sku;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inventory>
 */
class InventoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sku_id'=>Sku::factory(),
            'imei'=>fake()->unique()->imei(),
            'serial_number'=>fake()->unique()->randomNumber(),
            'type'=> fake()->randomElement([
                'new',
                'used'
            ]),
            'price'=>fake()->numberBetween(50000, 100000),
            'discount'=>fake()->numberBetween(0,40),
        ];
    }
}
