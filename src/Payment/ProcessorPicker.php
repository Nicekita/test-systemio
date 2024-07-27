<?php

namespace App\Payment;

use App\Payment\Processors\Paypal;
use App\Payment\Processors\Stripe;

class ProcessorPicker
{

    public function __construct(private Paypal $paypal, private Stripe $stripe)
    {
    }

    public function pickProcessor(string $processor): PaymentProcessor
    {
        return match($processor) {
            'paypal' => $this->paypal,
            'stripe' => $this->stripe,
            default => throw new \Exception('This payment method is not implemented yet.')
        };
    }

}