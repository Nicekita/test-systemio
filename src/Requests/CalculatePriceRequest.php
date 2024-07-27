<?php

namespace App\Requests;
use App\Validator as AppAssert;
use Symfony\Component\Validator\Constraints\NotBlank;

class CalculatePriceRequest extends BaseRequest
{

    #[AppAssert\Product\ProductExists()]
    #[NotBlank()]
    public int $product;
    #[NotBlank()]
    public string $taxNumber;

    public string $couponCode;
}