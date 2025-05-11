<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Accessory extends Model
{
    /** @use HasFactory<\Database\Factories\AccessoryFactory> */
    use HasFactory;

    protected $casts = [
        'attachments' => 'json',
    ];

    protected $guarded = [];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($accessories) {
            $accessories->slug = Str::slug(strtolower($accessories->title));
        });

        static::updating(function ($accessories) {
            $accessories->slug = Str::slug(strtolower($accessories->title));
        });
    }

    public function category(){
        return $this->belongsTo(AccessoryCategory::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(AccessoryBrand::class, 'brand_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(AccessorySubCategory::class,'sub_category_id');
    }

}
