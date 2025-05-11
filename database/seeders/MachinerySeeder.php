<?php

namespace Database\Seeders;

use App\Models\Machinery;
use App\Models\MachineryBrand;
use App\Models\MachineryCategories;
use App\Models\MachinerySubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MachinerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $machiney_brand = MachineryBrand::all();
        $machiney_category = MachineryCategories::all();
        $machinery_subcategory = MachinerySubCategory::all();

        foreach ($machiney_brand as $brand) {
            foreach ($machiney_category as $category) {
                foreach ($machiney_category as $subcategory) {
                    Machinery::factory(10)->create([
                       'machinery_brand_id' => $brand->id,
                       'machinery_category_id' => $category->id,
                       'machinery_sub_category_id' => $subcategory->id,
                    ]);
                }
            }
        }
    }
}
