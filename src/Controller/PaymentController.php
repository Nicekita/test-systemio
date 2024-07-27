<?php

namespace App\Controller;

use App\Action\CalculatePrice;
use App\Action\PurchaseProduct;
use App\Requests\CalculatePriceRequest;
use App\Requests\PurchaseRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class PaymentController extends AbstractController
{

    #[Route('/calculate-price', name: 'calculate-price')]
    public function calculatePrice(CalculatePriceRequest $request, CalculatePrice $action): JsonResponse
    {
        $price = $action->execute($request->product, $request->taxNumber, $request->couponCode);
        return $this->json(['price' => $price]);
    }
    #[Route('/purchase', name: 'purchase')]
    public function purchase(PurchaseRequest $request, PurchaseProduct $action): JsonResponse
    {
        $result = $action->execute($request->product, $request->taxNumber, $request->couponCode, $request->paymentProcessor);
        if (!$result) {
            return $this->json(['message' => 'Purchase failed'], 400);
        }
        return $this->json(['message' => 'Purchase successful']);
    }
}