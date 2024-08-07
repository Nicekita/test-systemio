<?php
declare(strict_types=1);

namespace App\Payment\Processors;

use App\Payment\PaymentProcessor;
use Symfony\Component\DependencyInjection\Attribute\AsTaggedItem;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

#[AsTaggedItem(index: 'stripe')]
class Stripe implements PaymentProcessor
{
    public function __construct()
    {
    }
    public function pay(int $price): bool
    {
        return (new StripePaymentProcessor())->processPayment($price / 100);
    }

}