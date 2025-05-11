<?php

namespace Database\Seeders;

use App\Models\Cart;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Psy\Util\Str;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rand = \Illuminate\Support\Str::random(10);
        for($i = 1; $i < 5; $i++){
            Cart::create([
                'user_id'=>1,
                'sku_id'=> $i,
                'cart_token' => $rand
            ]);
        }
    }
}
