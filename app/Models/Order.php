<?php

namespace App\Models;

use App\Enum\OrderStatus;
use App\Enum\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    protected $guarded=[];

    protected $casts =[
        'orderStatus'=>OrderStatus::class,
    ];

    public function order_details(): HasMany{
        return $this->hasMany(OrderDetails::class, 'order_id');
    }

    public function payment_details()
    {
        return $this->hasOne(PaymentDetails::class);
    }

    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class, 'order_id');
    }

}
