<?php

namespace Database\Seeders;

use App\Models\PartsCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PartsCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PartsCategory::factory(9)->create();
    }
}
