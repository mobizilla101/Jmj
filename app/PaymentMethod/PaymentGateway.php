<?php

namespace App\PaymentMethod;

use App\Models\Order;
use App\Models\PaymentDetails;
use App\PaymentMethod\CashOnDelivery;

class PaymentGateway
{
    private int $total;
    private array $options = [];
    private string|null $paymentClass;

    private Order|null $order = null;

    /**
     * Constructor to initialize the payment gateway.
     *
     * @param int $total Total amount to be processed.
     * @param array $options  Optional configuration settings for payment.
     * @param string|null $paymentMethod The payment method key (e.g., 'cod').
     */
    public function __construct(Order $order,int $total, string|null $paymentMethod = null, array $options = [],)
    {
        $this->order = $order;
        $this->total = $total;
        $this->options = $options;
        $this->paymentClass = $paymentMethod ? PaymentDetails::getPaymentClass($paymentMethod) : null;
    }

    /**
     * Get the total amount.
     *
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * Set options for the payment gateway.
     *
     * @param array|null $options
     */
    public function setOptions(array $options =[]): void
    {
        $this->options = $options;
    }

    /**
     * Get the options.
     *
     * @return array|null
     */
    public function getOptions(): ?array
    {
        return $this->options;
    }

    /**
     * Set the payment method class dynamically.
     *
     * @param string $key
     */
    public function setPaymentMethod(string $key): void
    {
        $this->paymentClass = PaymentDetails::getPaymentClass($key);
    }

    /**
     * Get the payment class based on the key from PaymentDetails model.
     *
     * @param string $key
     * @return string|null
     */
    public static function getPaymentClass(string $key): ?string
    {
        return PaymentDetails::getPaymentClass($key);
    }


    public function process(): bool
    {
        if (!$this->paymentClass) {
            return false;
        }

        // Instantiate the payment class
        $paymentProcessor = new $this->paymentClass($this->total, $this->options);

        return $paymentProcessor->process($this->order); // Call the process method of the payment class
    }

    /**
     * Verify the payment status.
     *
     * @param string $transactionId
     * @return bool
     */
    public function verify(string $transactionId): bool
    {
        if (!$this->paymentClass) {
            return false; // No payment method class found
        }

        $paymentProcessor = new $this->paymentClass();

        return $paymentProcessor->verify($transactionId); // Call verify method of the payment class
    }
}
