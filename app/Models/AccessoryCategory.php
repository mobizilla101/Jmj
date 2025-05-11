<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessoryCategory extends Model
{
    /** @use HasFactory<\Database\Factories\AccessoryCategoryFactory> */
    use HasFactory;

    protected $guarded =[];

    public function brands()
    {
        return $this->belongsToMany(AccessoryBrand::class, 'ab_ac','category_id','brand_id');
    }

    public function subCategories()
    {
        return $this->hasMany(AccessorySubCategory::class,'category_id');
    }
}
