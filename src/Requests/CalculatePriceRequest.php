<?php

namespace App\Requests;
use App\Validator as CustomAssert;
use Symfony\Component\Validator\Constraints\NotBlank;

class CalculatePriceRequest extends BaseRequest
{

    #[CustomAssert\Product\ProductExists()]
    #[NotBlank(null, 'Product is required.')]
    public int $product;
    #[NotBlank(null, 'Tax number is required.')]
    #[CustomAssert\TaxNumber\TaxNumber()]
    public string $taxNumber;

    public string $couponCode;
}