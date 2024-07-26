<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;

class PaymentController
{
    #[Route('/calculate-price', name: 'calculate-price')]
    public function calculatePrice()
    {

    }
    #[Route('/purchase', name: 'purchase')]
    public function purchase(Request $request)
    {
    }
}