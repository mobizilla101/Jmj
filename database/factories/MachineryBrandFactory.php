<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MachineryBrand>
 */
class MachineryBrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): arrayc
    {
        return [
            'name' => $this->faker->word(),
            'logo' => '01JFQ182YZ79AF1NVZMN3FZ87Y.jpeg',
        ];
    }
}
