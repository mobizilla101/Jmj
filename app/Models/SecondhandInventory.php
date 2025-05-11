<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class SecondhandInventory extends Model
{
    /** @use HasFactory<\Database\Factories\SecondhandInventoryFactory> */
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'attachments' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saved(fn () => Cache::forget('used_inventory'));
        static::deleted(fn () => Cache::forget('used_inventory'));
    }

    public function sku()
    {
        return $this->belongsTo(Sku::class);
    }

    public function color()
    {
        return $this->belongsTo(\App\Models\Colors::class,'color_id');
    }
}
