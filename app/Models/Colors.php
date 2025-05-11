<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colors extends Model
{
    /** @use HasFactory<\Database\Factories\ColorsFactory> */
    use HasFactory;

    protected $fillable = ['color_name','color_code'];

    public function skus()
    {
        return $this->belongsToMany(SKU::class, 'color_sku','color_id','sku_id');
    }

    public function inventory(){
        return $this->hasMany(Inventory::class);
    }
}
