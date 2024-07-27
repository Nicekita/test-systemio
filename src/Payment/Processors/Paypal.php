<?php

namespace App\Payment\Processors;

use App\Payment\PaymentProcessor;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Throwable;

class Paypal implements PaymentProcessor
{
    public function __construct()
    {
    }
    public function pay(int $price): bool
    {
        try {
            (new PaypalPaymentProcessor())->pay($price);
        }
        catch (Throwable) {
            return false;
        }
        return true;
    }
}