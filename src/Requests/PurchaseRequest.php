<?php

namespace App\Requests;
use App\Validator as CustomAssert;
use Symfony\Component\Validator\Constraints as Assert;
class PurchaseRequest
{
    public function __construct(
        #[CustomAssert\Entity\EntityExists('App\Entity\Product', 'Product')]
        #[Assert\NotBlank(null, 'Product is required.')]
        public int $product,

        #[Assert\NotBlank(null, 'Tax number is required.')]
        #[CustomAssert\TaxNumber\TaxNumber]
        public string $taxNumber,

        #[CustomAssert\Entity\EntityExists('App\Entity\Coupon', 'Coupon', 'code')]
        public ?string $couponCode,

        #[CustomAssert\PaymentProcessor\PaymentProcessorConstraint]
        public string $paymentProcessor,
    )
    {

    }
}