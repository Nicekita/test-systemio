<?php

namespace App\Requests;
use App\Validator as CustomAssert;
use Symfony\Component\Validator\Constraints as Assert;
class PurchaseRequest extends BaseRequest
{

    #[CustomAssert\Product\ProductExists()]
    #[Assert\NotBlank()]
    public int $product;
    #[Assert\NotBlank()]
    #[CustomAssert\TaxNumber\TaxNumber()]
    public string $taxNumber;

    public string $couponCode;
    #[Assert\Choice(
        choices: ['paypal', 'stripe'],
        message: 'Choose a valid payment processor.',
    )]
    public string $paymentProcessor;
}