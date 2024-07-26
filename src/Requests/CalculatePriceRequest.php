<?php

namespace App\Requests;
use App\Validator as AppAssert;

class CalculatePriceRequest
{

    #[AppAssert\Product\TaxNumber]
    protected int $product;

    protected string $taxNumber;
    protected string $couponCode;

    public function __construct(int $product, string $taxNumber, string $couponCode)
    {
        $this->product = $product;
        $this->taxNumber = $taxNumber;
        $this->couponCode = $couponCode;
    }
}