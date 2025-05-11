<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machinery extends Model
{
    /** @use HasFactory<\Database\Factories\MachineryFactory> */
    use HasFactory;
    protected $guarded =[];

    protected $casts =[
        'attachments' => 'array'
    ];

    public function category()
    {
        return $this->belongsTo(MachineryCategories::class, 'machinery_category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(MachinerySubCategory::class, 'machinery_sub_category_id');
    }

    public function workingNature()
    {
        return $this->belongsTo(MachineryWorkingNature::class, 'machinery_working_nature_id');
    }

    public function brand()
    {
        return $this->belongsTo(MachineryBrand::class, 'machinery_brand_id');
    }
}
