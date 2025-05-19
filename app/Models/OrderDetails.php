<?php

namespace App\Models;

use App\Enum\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    /** @use HasFactory<\Database\Factories\OrderDetailsFactory> */
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
      'extra' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }

    public function item()
    {
        return $this->morphTo();
    }

    public function getTotalAttribute(): int
    {
        $amount = $this->amount ?? 0;
        $discount = $this->discount ?? 0;
        $quantity = $this->quantity ?? 1;

        $discountedPrice = max(0, $amount * (1 - ($discount / 100)));

        return $discountedPrice * $quantity;
    }

}
