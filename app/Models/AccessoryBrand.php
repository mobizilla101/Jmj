<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessoryBrand extends Model
{
    /** @use HasFactory<\Database\Factories\AccessoryBrandFactory> */
    use HasFactory;

    protected $guarded = [];

    public function categories()
    {
        return $this->belongsToMany(AccessoryCategory::class, 'ab_ac','brand_id','category_id');
    }

    public function accessories()
    {
        return $this->hasMany(Accessory::class, 'brand_id');
    }
}
