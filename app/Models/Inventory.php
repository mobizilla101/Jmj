<?php

namespace App\Models;

use App\Enum\InventoryType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    /** @use HasFactory<\Database\Factories\InventoryFactory> */
    use HasFactory;

    protected $guarded = [];

    public function sku()
    {
        return $this->belongsTo(Sku::class);
    }

    public function color(){
        return $this->belongsTo(Colors::class);
    }
}
