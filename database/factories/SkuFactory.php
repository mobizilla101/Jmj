<?php

namespace Database\Factories;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sku>
 */
class SkuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "model_id"=>Model::factory(),
            "color"=>fake()->hexColor(),
            "color_name"=>fake()->colorName(),
            "storage"=>fake()->randomElement([
                128,
                258
            ]),
            "memory"=>fake()->randomElement([
                8,
                16,
                32
            ]),
            "discount"=>fake()->randomElement([
                0,
                10,
                15,
                20,
            ]),
            "price"=>fake()->numberBetween(10000, 100000),
        ];
    }
}
