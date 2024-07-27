<?php

namespace App\Action;

use App\Helpers\ParseTaxNumber;
use App\Repository\CountryRepository;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;
use App\Requests\CalculatePriceRequest;

class CalculatePrice
{

    public function __construct(
        private readonly ProductRepository     $productRepository,
        private readonly CountryRepository     $countryRepository,
        private readonly CouponRepository      $couponRepository
    )
    {
    }


    public function execute(int $productId, string $taxNumber, string $coupon): int
    {
        $productPrice = $this->productRepository->findById($productId)->getPrice();

        $countryCode = (new ParseTaxNumber($taxNumber))->countryCode;

        $countryTax = $this->countryRepository->findByCode($countryCode)->getTax();

        $coupon = $this->couponRepository->findByCode($coupon);
        $couponDiscount = $coupon ? $coupon->getDiscount() / 100 : 0;


        return $productPrice * (1 - $couponDiscount) * (1 + $countryTax);
    }
}