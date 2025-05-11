<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MachinerySubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach(\App\Models\MachineryCategories::all() as $dat){
            \App\Models\MachinerySubCategory::factory(6)->create([
                'machinery_category_id' => $dat->id
            ]);
        }
    }
}
