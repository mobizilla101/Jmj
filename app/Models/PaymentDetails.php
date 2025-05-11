<?php

namespace App\Models;

use App\Enum\PaymentStatus;
use App\PaymentMethod\CashOnDelivery;
use App\PaymentMethod\PaymentGateway;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetails extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentDetailsFactory> */
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status' => PaymentStatus::class
    ];

    public function order()
    {
        $this->belongsTo(Order::class);
    }

    public static function getPaymentClass(string $key){
        return match ($key){
            'cod' => CashOnDelivery::class,
            default => null,
        };
    }
}
