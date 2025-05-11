<?php

namespace Database\Factories;

use App\Models\Brand; // Ensure the Brand model is imported
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'model_no' => $this->faker->unique()->bothify('##??'), // Generate a random model number (e.g., "12AB")
            'brand_id' => Brand::factory(), // Automatically create and associate a brand
            'description' => $this->faker->paragraph(), // Generate a paragraph of text
            'specification' => $this->faker->paragraph(),
            'released' => $this->faker->date('Y-m-d', 'now'), // Random date before today
            'thumbnail' => $this->faker->imageUrl(640, 480, 'electronics', true), // Generate a random image URL
            'attachments' => json_encode([
                $this->faker->imageUrl(640, 480, 'electronics', true),
                $this->faker->imageUrl(640, 480, 'electronics', true),
            ]), // Example attachments as JSON array
        ];
    }
}
