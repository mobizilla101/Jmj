<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachinerySubCategory extends Model
{
    /** @use HasFactory<\Database\Factories\MachinerySubCategoryFactory> */
    use HasFactory;

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(MachineryCategories::class, 'machinery_category_id');
    }

    public function machinery(){
        return $this->hasMany(Machinery::class, 'machinery_sub_category_id');
    }
}
