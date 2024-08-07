<?php

namespace App\Action;

use App\Helpers\ParseTaxNumber;
use App\Repository\CountryRepository;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;

class CalculatePrice
{

    public function __construct(
        private readonly ProductRepository     $productRepository,
        private readonly CountryRepository     $countryRepository,
        private readonly CouponRepository      $couponRepository
    )
    {
    }


    public function getPrice(int $productId, string $taxNumber, ?string $coupon): int
    {
        $productPrice = $this->productRepository->findById($productId)->getPrice();

        $countryCode = (new ParseTaxNumber($taxNumber))->countryCode;

        $countryTax = $this->countryRepository->findByCode($countryCode)->getTax();

        $coupon = $this->couponRepository->findByCode($coupon);

        if ($coupon) {
            $discount = $coupon->isFixed()
                ? $coupon->getDiscount()
                : $productPrice * ($coupon->getDiscount() / 100);
            $productPrice -= $discount;
        }

        return $productPrice * (1 + ($countryTax / 100));
    }
}