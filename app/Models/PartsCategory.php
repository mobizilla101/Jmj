<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartsCategory extends Model
{
    /** @use HasFactory<\Database\Factories\PartsCategoryFactory> */
    use HasFactory;

    protected $guarded = [];

    public function parts()
    {
        static::saved(fn () => Cache::forget('used_inventory'));
        static::deleted(fn () => Cache::forget('used_inventory'));

        return $this->hasMany(Parts::class);
    }
}
