<?php

namespace App\Payment\Processors;

use App\Payment\PaymentProcessor;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Throwable;

class Paypal implements PaymentProcessor
{
    public function __construct(private readonly PaypalPaymentProcessor $paymentProcessor)
    {
    }
    public function pay(int $price): bool
    {
        try {
            $this->paymentProcessor->pay($price);
        }
        catch (Throwable $e) {
            return false;
        }
        return true;
    }
}