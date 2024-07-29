<?php

namespace App\Tests;

use App\Action\CalculatePrice;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PriceTest extends KernelTestCase
{
    /**
     * @dataProvider provideCalculationData
     */
    public function testCalculation($product, $taxNumber, $discount, $expectedPrice): void
    {
        self::bootKernel(["environment" => 'test']);

        $calculatePrice = static::getContainer()->get(CalculatePrice::class);

        $this->assertSame($expectedPrice, $calculatePrice->getPrice($product, $taxNumber, $discount));
    }

    public function provideCalculationData(): array
    {
        return [
            [1, 'DE123456789', 'D10', 10710],
            [2, 'IT12345678901', 'D20', 1952],
            [3, 'FR12345678901', 'P50', 60],
            [1, 'GR123', 'D10', 11160],
        ];
    }
}
