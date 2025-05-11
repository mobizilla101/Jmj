<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoweredBy extends Model
{
    /** @use HasFactory<\Database\Factories\PoweredByFactory> */
    use HasFactory;

    protected $fillable = ['name','logo'];

    protected static function boot()
    {
        parent::boot();

        static::saved(function () {
            cache()->forget('poweredbies');
        });

        static::deleted(function () {
            cache()->forget('poweredbies');
        });
    }

}
