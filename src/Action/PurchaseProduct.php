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
        private CalculatePrice $priceCalculator,
        private ProcessorPicker $processorPicker
    )
    {
    }


    public function execute(int $productId, string $taxNumber, string $coupon, string $payment): bool
    {
        $price = $this->priceCalculator->execute($productId, $taxNumber, $coupon);
        $paymentProcessor = $this->processorPicker->pickProcessor($payment);
        return $paymentProcessor->pay($price);
    }
}