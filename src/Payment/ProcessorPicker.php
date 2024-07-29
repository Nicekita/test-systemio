<?php

namespace App\Payment;

use App\Payment\Processors\Paypal;
use App\Payment\Processors\Stripe;
use Exception;

class ProcessorPicker
{

    public function __construct(private Paypal $paypal, private Stripe $stripe)
    {
    }

    /**
     * Эту ошибку не надо ловить, т.к. валидация не должна пустить сюда некорректный процессор
     * @throws Exception
     */
    public function pickProcessor(string $processor): PaymentProcessor
    {
        return match($processor) {
            'paypal' => $this->paypal,
            'stripe' => $this->stripe,
            default => throw new Exception('This payment method is not implemented yet.')
        };
    }

}