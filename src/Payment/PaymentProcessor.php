<?php

namespace App\Payment;

interface PaymentProcessor
{
    public function pay(int $price): bool;
}