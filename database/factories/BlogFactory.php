<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(); // Generate a random blog title

        return [
            'title' => $title,
            'slug' => Str::slug($title), // Generate a slug from the title
            'content' => $this->faker->paragraphs(3, true), // Generate 3 paragraphs of content
            'thumbnail' => '01JK8J0T0GJ6VD7E9NSF9TJBYY.jpg',
            'description' => $this->faker->sentence(10), // Short blog description
        ];
    }
}
