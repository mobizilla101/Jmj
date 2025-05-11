<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Testimonial>
 */
class TestimonialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => $this->faker->paragraph(),
            'username' => $this->faker->name,
            'avatar' => '01JK8J0T0GJ6VD7E9NSF9TJBYY.jpg',
            'stars' => $this->faker->numberBetween(1, 5),
            'reviewed_date' => $this->faker->date('Y-m-d', 'now')
        ];
    }

}
