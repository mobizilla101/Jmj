<?php

namespace App\PaymentMethod;

use App\Interface\Payment;
use App\Models\Order;
use App\Models\PaymentDetails;

class CashOnDelivery implements Payment
{
    private float $amount;
    private array $options;

    /**
     * CashOnDelivery constructor.
     *
     * @param float $amount The amount to be paid.
     * @param array $options Additional options for the payment method.
     */
    public function __construct(float $amount, array $options = [])
    {
        $this->amount = $amount;
        $this->options = $options;
    }

    /**
     * Process the payment (Cash on Delivery doesn't require online processing).
     *
     * @return bool True if payment is successful.
     */
    public function process(Order $order,mixed $data = null):bool
    {
        $provider = array_filter(config('payments'),function($dat){
            return $dat['key'] === 'cod';
        })[0];

        $order->payment_details()->create([
                'provider' => self::class,
                'provider_name' =>$provider['name'],
                'provider_key' =>$provider['key'],
                'order_id' => $order->id,
                'amount' => $this->amount
        ]);

        return true;
    }

    /**
     * Verify the payment status.
     *
     * @param string $transactionId The transaction ID to verify.
     * @return bool True if verified, false otherwise.
     */
    public function verify(string $transactionId): bool
    {

        return true;
    }
}
