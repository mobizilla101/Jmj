<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Machinery>
 */
class MachineryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->unique()->word(),
            'description' => $this->faker->text(),
            'amount' => $this->faker->randomFloat(2, 10),
            'discount' => $this->faker->randomFloat(2, 10),
            'thumbnail'=>'parts/thumbnail/01JM9GRHSNYV6SM30BCNQAM7V7.png',
            'attachments'=>'["parts/attachments/01JM9GRHSSKHV0MGJKY9XJVSAG.jpg", "parts/attachments/01JM9GRHSVF3EP7G3XCEN207YX.png"]',
        ];
    }
}
