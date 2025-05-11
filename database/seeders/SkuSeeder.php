<?php

namespace Database\Seeders;

use App\Models\Model;
use App\Models\Sku;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $model = Model::all();

        foreach ($model as $item) {
            Sku::factory(5)->create([
                'model_id' => $item->id
            ]);
        }
    }
}
