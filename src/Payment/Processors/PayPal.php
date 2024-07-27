<?php

namespace App\Payment\Processors;

use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

class Stripe
{
    public function __construct(private StripePaymentProcessor $paymentProcessor)
    {

    }
    public function pay(int $price): bool
    {
        return $this->paymentProcessor->processPayment($price);
    }
}