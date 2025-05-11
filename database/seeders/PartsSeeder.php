<?php

namespace Database\Seeders;

use App\Models\Parts;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PartsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 15; $i++) {
            Parts::factory(2)->create([
                'parts_category_id' =>$i
            ]);
        }
    }
}
