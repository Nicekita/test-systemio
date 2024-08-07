<?php

namespace App\Controller;

use App\Action\CalculatePrice;
use App\Action\PurchaseProduct;
use App\Requests\CalculatePriceRequest;
use App\Requests\PurchaseRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class PaymentController extends AbstractController
{

    public function __construct(private CalculatePrice $calculator, private PurchaseProduct $action)
    {
    }

    #[Route('/calculate-price', name: 'calculate-price')]
    public function calculatePrice(#[MapRequestPayload] CalculatePriceRequest $request): JsonResponse
    {
        $price = $this->calculator->getPrice($request->product, $request->taxNumber, $request->couponCode);
        return $this->json(['price' => $price]);
    }
    #[Route('/purchase', name: 'purchase')]
    public function purchase(#[MapRequestPayload] PurchaseRequest $request): JsonResponse
    {
        $price = $this->calculator->getPrice($request->product, $request->taxNumber, $request->couponCode);
        $result = $this->action->purchase($price, $request->paymentProcessor);
        if (!$result) {
            return $this->json(['message' => 'Purchase failed'], 400);
        }
        return $this->json(['message' => 'Purchase successful']);
    }
}