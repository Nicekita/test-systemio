<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Requests\CalculatePriceRequest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PaymentController extends AbstractController
{
    public function __construct(private ValidatorInterface $validator, private EntityManagerInterface $entityManager){}

    #[Route('/calculate-price', name: 'calculate-price')]
    public function calculatePrice(Request $request)
    {
        $data = $request->toArray();
        $calculatePriceRequest = new CalculatePriceRequest($data['product'], $data['taxNumber'], $data['couponCode']);
        $errors = $this->validator->validate($calculatePriceRequest);
        if (count($errors) > 0) {
            return $this->json(['errors' => $errors], 400);
        }

        return $this->json(['price' => $this->entityManager->getRepository(Product::class)->findById($data['product'])->getPrice()]);
    }
    #[Route('/purchase', name: 'purchase')]
    public function purchase(Request $request)
    {
    }
}