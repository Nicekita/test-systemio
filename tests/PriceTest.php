<?php

namespace App\Tests;

use App\Action\CalculatePrice;
use App\Entity\Country;
use App\Entity\Coupon;
use App\Entity\Product;
use App\Repository\CountryRepository;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PriceTest extends KernelTestCase
{
    /**
     * @dataProvider provideCalculationData
     */
    public function testCalculation(
        int $product,
        string $taxNumber,
        string $discount,
        int $expectedPrice,
        int $productPrice,
        int $countryTax,
        int $couponDiscount,
        bool $isFixed
    ): void
    {
        self::bootKernel(["environment" => 'test']);
        $container = static::getContainer();

        $mockProduct = $this->createMock(Product::class);
        $mockProduct->method('getPrice')->willReturn($productPrice);

        $mockProductRepository = $this->createMock(ProductRepository::class);
        $mockProductRepository->method('findOneBy')->willReturn($mockProduct);

        $mockCountry = $this->createMock(Country::class);
        $mockCountry->method('getTax')->willReturn($countryTax);

        $mockCountryRepository = $this->createMock(CountryRepository::class);
        $mockCountryRepository->method('findOneBy')->willReturn($mockCountry);

        $mockCoupon = $this->createMock(Coupon::class);
        $mockCoupon->method('isFixed')->willReturn($isFixed);
        $mockCoupon->method('getDiscount')->willReturn($couponDiscount);

        $mockCouponRepository = $this->createMock(CouponRepository::class);
        $mockCouponRepository->method('findOneBy')->willReturn($mockCoupon);

        $container->set(ProductRepository::class, $mockProductRepository);
        $container->set(CountryRepository::class, $mockCountryRepository);
        $container->set(CouponRepository::class, $mockCouponRepository);

        $calculatePrice = $container->get(CalculatePrice::class);

        $this->assertSame($expectedPrice, $calculatePrice->getPrice($product, $taxNumber, $discount));
    }

    public function provideCalculationData(): array
    {
        return [
            [1, 'DE123456789', 'D10', 10710, 10000, 19, 10, false],
            [2, 'IT12345678901', 'D20', 1952, 2000, 22, 20, false],
            [3, 'FR12345678901', 'FIX100', 2580, 2500, 20, 350, true],
            [1, 'GR123', 'D10', 11160, 10000, 24, 10, false],
        ];
    }
}
