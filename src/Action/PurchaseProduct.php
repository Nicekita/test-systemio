<?php

namespace App\Action;

use App\Payment\ProcessorPicker;

class PurchaseProduct
{


    public function __construct(private ProcessorPicker $processorPicker)
    {
    }

    public function purchase(int $price, string $payment): bool
    {
        $paymentProcessor = $this->processorPicker->pickProcessor($payment);
        return $paymentProcessor->pay($price);
    }
}