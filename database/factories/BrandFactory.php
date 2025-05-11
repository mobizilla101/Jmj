<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $brandName = [
            "OPPO",
            "HTC",
            "IQOO",
            "Google Pixel",
            "LG",
            "realme",
            "ASUS",
            "GIONEE",
            "Nokia",
            "Apple",
            "SAMSUNG",
            "Lenovo",
            "Motorola",
            "POCO",
            "vivo",
            "Xiaomi"
        ];

        return [
            'name'=>fake()->unique()->name(),
            'slug'=>fake()->slug(),
            'description'=>fake()->text(),
            'logo'=>fake()->imageUrl(),
        ];
    }
}
