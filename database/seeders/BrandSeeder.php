<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
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

        foreach ($brands as $brand) {
            Brand::factory()->create([
                'name' => $brand
            ]);
        }

    }
}
