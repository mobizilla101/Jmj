<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UsedInventories extends Model
{
    /** @use HasFactory<\Database\Factories\UsedInventoriesFactory> */
    use HasFactory;

    protected $guarded = [];

    public function sku():BelongsTo
    {
        return $this->belongsTo(Sku::class);
    }
}
