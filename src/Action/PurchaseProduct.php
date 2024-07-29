<?php

namespace App\Action;

use App\Helpers\ParseTaxNumber;
use App\Payment\ProcessorPicker;
use App\Payment\Processors\Paypal;
use App\Payment\Processors\Stripe;
use App\Repository\CountryRepository;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;
use App\Requests\CalculatePriceRequest;
use App\Requests\PurchaseRequest;
use Composer\XdebugHandler\Process;

class PurchaseProduct
{


    public function __construct(
        private ProcessorPicker $processorPicker
    )
    {
    }


    public function purchase(int $price, string $payment): bool
    {
        $paymentProcessor = $this->processorPicker->pickProcessor($payment);
        return $paymentProcessor->pay($price);
    }
}