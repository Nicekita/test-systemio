<?php

namespace App\Tests;

use App\Action\CalculatePrice;
use App\Action\PurchaseProduct;
use App\Requests\PurchaseRequest;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PurchaseTest extends KernelTestCase
{

    /**
     * @dataProvider providePaymentData
     */
    public function testCalculation($price, $processor, $expectedResult): void
    {
        self::bootKernel(["environment" => 'test']);

        $purchaser = static::getContainer()->get(PurchaseProduct::class);

        if (!$expectedResult) {
            $this->expectException(Exception::class);
        }

        $this->assertSame($expectedResult, $purchaser->purchase($price, $processor));

    }

    public function providePaymentData(): array
    {
        return [
            [10000, 'stripe', true],
            [20000, 'paypal', true],
            [30000, 'YandexMoney', false],
        ];
    }
}
