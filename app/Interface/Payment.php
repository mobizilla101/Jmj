<?php

namespace App\Interface;

use App\Models\Order;

interface Payment
{
    /**
     * Process the payment.
     *
     * @param mixed $data Optional data required for processing the payment.
     * @return bool True if payment is successful, false otherwise.
     */
    public function process(Order $order,mixed $data = null):bool|array|string|int;

    /**
     * Verify the payment status.
     *
     * @param string $transactionId The transaction ID to verify.
     * @return bool True if the payment is verified, false otherwise.
     */
    public function verify(string $transactionId): bool|array|string|int;
}
