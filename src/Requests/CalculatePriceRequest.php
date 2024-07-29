<?php

namespace App\Requests;
use App\Validator as CustomAssert;
use Symfony\Component\Validator\Constraints\NotBlank;

class CalculatePriceRequest extends BaseRequest
{

    #[CustomAssert\Product\ProductExists()]
    #[NotBlank()]
    public int $product;
    #[NotBlank()]
    #[CustomAssert\TaxNumber\TaxNumber()]
    public string $taxNumber;

    public string $couponCode;
}