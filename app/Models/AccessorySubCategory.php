<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessorySubCategory extends Model
{
    /** @use HasFactory<\Database\Factories\AccessorySubCategoryFactory> */
    use HasFactory;

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(AccessoryCategory::class,'category_id');
    }
}
