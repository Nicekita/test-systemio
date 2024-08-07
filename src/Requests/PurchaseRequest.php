<?php

namespace App\Requests;
use App\Payment\ProcessorPicker;
use App\Validator as CustomAssert;
use Symfony\Component\Validator\Constraints as Assert;
class PurchaseRequest
{
    public function __construct(
        #[CustomAssert\Product\ProductExists]
        #[Assert\NotBlank(null, 'Product is required.')]
        public int $product,

        #[Assert\NotBlank(null, 'Tax number is required.')]
        #[CustomAssert\TaxNumber\TaxNumber]
        public string $taxNumber,

        public string $couponCode,

        #[CustomAssert\PaymentProcessor\PaymentProcessor]
        public string $paymentProcessor,
    )
    {

    }
}