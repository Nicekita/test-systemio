<?php
declare(strict_types=1);
namespace App\Payment\Processors;

use App\Payment\PaymentProcessor;
use Symfony\Component\DependencyInjection\Attribute\AsTaggedItem;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Throwable;

#[AsTaggedItem(index: 'paypal')]
class Paypal implements PaymentProcessor
{
    public function __construct()
    {
    }
    public function pay(int $price): bool
    {
        try {
            (new PaypalPaymentProcessor())->pay($price);
        }
        catch (Throwable) {
            return false;
        }
        return true;
    }

}