<?php

namespace Database\Seeders;

use App\Models\Machinery;
use App\Models\MachineryCategories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MachineryCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MachineryCategories::factory(5)->create();
    }
}
