<?php

namespace Database\Seeders;

use App\Models\Model;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $models = Model::all();
        foreach ($models as $model) {
            if(!$model->slug){
                $model->slug = Str::slug(strtolower($model->model_no));
            }
//            $model->hot_sale = true;
//            $model->published = true;
            $model->save();
        }
    }

    public function csvUpdate(){
        $model = fopen(storage_path('record.csv'),'r');
        $datas = [];
        while(! feof($model))
        {
            $datas[] = fgetcsv($model);
        }
        fclose($model);

        $headers = array_shift($datas);

        foreach ($datas as $data) {
            if (empty($data) || count($data) !== count($headers)) {
                continue;
            }

            $record = array_combine($headers, $data); // Combine headers with row data
            if (isset($record['released'])) {
                $record['released'] = \Carbon\Carbon::parse($record['released'])->format('Y-m-d');
            }
            Model::create($record);
        }
    }
}
