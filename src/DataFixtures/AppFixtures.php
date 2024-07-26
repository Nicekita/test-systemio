<?php

namespace App\DataFixtures;

use App\Entity\Country;
use App\Entity\Coupon;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    private const DATA = [
        Product::class => [
            ['name' => 'Iphone', 'price' => 10000],
            ['name' => 'AirPods (fake)', 'price' => 2000],
            ['name' => 'Ihole', 'price' => 100],
        ],
        Country::class => [
            ['code' => 'DE', 'tax' => 19],
            ['code' => 'IT', 'tax' => 22],
            ['code' => 'FR', 'tax' => 20],
            ['code' => 'GR', 'tax' => 24],
        ],
        Coupon::class => [
            ['code' => '123', 'discount' => 10],
            ['code' => '456', 'discount' => 20],
            ['code' => '789', 'discount' => 30],
        ],
    ];
    public function load(ObjectManager $manager): void
    {
       // Не очень красиво, но т.к. данных мало выделять в json смысла нет
       foreach (self::DATA as $entity => $data) {
            foreach ($data as $row) {
                $object = new $entity();
                foreach ($row as $property => $value) {
                    $object->{'set' . ucfirst($property)}($value);
                }
                $manager->persist($object);
            }
        }
        $manager->flush();
    }
}
