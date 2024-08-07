<?php

namespace App\Requests;
use App\Validator as CustomAssert;
use Symfony\Component\Validator\Constraints\NotBlank;

class CalculatePriceRequest
{

    public function __construct(
        #[CustomAssert\Entity\EntityExists('App\Entity\Product', 'Product')]
        #[NotBlank(null, 'Product is required.')]
        public int $product,

        #[NotBlank(null, 'Tax number is required.')]
        #[CustomAssert\TaxNumber\TaxNumber()]
        public string $taxNumber,

        #[CustomAssert\Entity\EntityExists('App\Entity\Coupon', 'Coupon', 'code')]
        public ?string $couponCode,
    ) {

    }
}