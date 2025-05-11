<?php

namespace Database\Factories;

use App\Models\Sku;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cart>
 */
class CartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Creates a related user
            'sku_id' => Sku::factory(), // Creates a product and its related SKU
            'cart_token' => $this->faker->unique()->uuid(), // Generate a unique cart token
            'cart_status' => $this->faker->boolean(80), // 80% likely to be true
            'cart_delete' => false, // Default to not deleted
            'quantity' => $this->faker->numberBetween(1, 5), // Random quantity between 1 and 5
        ];
    }
}
