<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $productsData = [
            ['name' => 'Iphone', 'price' => 10000],
            ['name' => 'AirPods (fake)', 'price' => 2000],
            ['name' => 'Ihole', 'price' => 100],
        ];
        foreach ($productsData as $productData) {
            $product = new Product();
            $product->setName($productData['name']);
            $product->setPrice($productData['price']);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
