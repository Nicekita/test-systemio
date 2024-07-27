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


    public function execute(CalculatePriceRequest $request): int
    {
        $productPrice = $this->productRepository->findById($request->product)->getPrice();

        $countryCode = (new ParseTaxNumber($request->taxNumber))->countryCode;

        $countryTax = $this->countryRepository->findByCode($countryCode)->getTax();

        $coupon = $this->couponRepository->findByCode($request->couponCode);
        $couponDiscount = $coupon ? $coupon->getDiscount() / 100 : 0;


        return $productPrice * (1 - $couponDiscount) * (1 + $countryTax);
    }
}