<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Sku extends Eloquent
{
    /** @use HasFactory<\Database\Factories\SkuFactory> */
    use HasFactory;

    protected $guarded = [];


    public function model()
    {
        return $this->belongsTo(Model::class,'model_id');
    }

    public function inventory()
    {
        return $this->hasMany(Inventory::class);
    }
    public function carts()
    {
        return $this->morphMany(Cart::class, 'item');
    }

    public function orderDetails()
    {
        return $this->morphMany(OrderDetails::class, 'item');
    }

    public function secondhandInventory(){
        return $this->hasMany(SecondhandInventory::class);
    }

    public function color(){
        return $this->belongsToMany(Colors::class,'color_sku', 'sku_id', 'color_id');
    }
}
