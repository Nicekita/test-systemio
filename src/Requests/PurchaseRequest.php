<?php

namespace App\Requests;
use App\Validator as CustomAssert;
use Symfony\Component\Validator\Constraints as Assert;
class PurchaseRequest extends BaseRequest
{

    #[CustomAssert\Product\ProductExists]
    #[Assert\NotBlank(null, 'Product is required.')]
    public int $product;
    #[Assert\NotBlank(null, 'Tax number is required.')]
    #[CustomAssert\TaxNumber\TaxNumber]
    public string $taxNumber;

    public string $couponCode;
    #[Assert\Choice(
        choices: ['paypal', 'stripe'],
        message: 'Choose a valid payment processor.',
    )]
    public string $paymentProcessor;
}