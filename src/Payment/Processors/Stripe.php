<?php

namespace App\Payment\Processors;

use App\Payment\PaymentProcessor;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

class Stripe implements PaymentProcessor
{
    public function __construct()
    {

    }
    public function pay(int $price): bool
    {
        return (new StripePaymentProcessor())->processPayment($price);
    }
}