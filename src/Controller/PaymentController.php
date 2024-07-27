<?php

namespace App\Controller;

use App\Action\CalculatePrice;
use App\Entity\Product;
use App\Requests\CalculatePriceRequest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class PaymentController extends AbstractController
{

    #[Route('/calculate-price', name: 'calculate-price')]
    public function calculatePrice(CalculatePriceRequest $request, CalculatePrice $action): JsonResponse
    {
        $price = $action->execute($request);
        return $this->json(['price' => $price]);
    }
    #[Route('/purchase', name: 'purchase')]
    public function purchase(Request $request)
    {

    }
}