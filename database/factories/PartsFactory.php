<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Parts>
 */
class PartsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=>$this->faker->word(),
            'parts_category_id'=>$this->faker->numberBetween(1,10),
            'model_id'=>1,
            'description'=>$this->faker->paragraph(),
            'price'=>$this->faker->numberBetween(1,100),
            'stock'=>$this->faker->numberBetween(1,100),
            'discount'=>$this->faker->numberBetween(1,5),
            'thumbnail'=>'parts/thumbnail/01JM9GRHSNYV6SM30BCNQAM7V7.png',
            'attachments'=>'["parts/attachments/01JM9GRHSSKHV0MGJKY9XJVSAG.jpg", "parts/attachments/01JM9GRHSVF3EP7G3XCEN207YX.png"]',
            'published'=>false
        ];
    }
}
