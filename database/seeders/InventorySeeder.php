<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Inventory;
use App\Models\Model;
use App\Models\Sku;
use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Inventory::factory(20)
            ->has(
                Sku::factory(5)
                    ->has(
                        Model::factory(5)
                            ->has(Brand::factory())
                    )
            )
            ->create();
    }
}
