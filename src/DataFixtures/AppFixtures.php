<?php

namespace App\DataFixtures;

use App\Entity\Country;
use App\Entity\Coupon;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    private const array DATA = [
        Product::class => [
            ['id' => 1, 'name' => 'Iphone', 'price' => 10000],
            ['id' => 2, 'name' => 'AirPods (fake)', 'price' => 2000],
            ['id' => 3, 'name' => 'Ihole', 'price' => 100],
        ],
        Country::class => [
            ['code' => 'DE', 'tax' => 19, 'numbers' => 9, 'symbols' => 0],
            ['code' => 'IT', 'tax' => 22, 'numbers' => 11, 'symbols' => 0],
            ['code' => 'FR', 'tax' => 20, 'numbers' => 11, 'symbols' => 2],
            ['code' => 'GR', 'tax' => 24 ,'numbers' => 3, 'symbols' => 3],
        ],
        Coupon::class => [
            ['code' => 'D10', 'discount' => 10],
            ['code' => 'D20', 'discount' => 20],
            ['code' => 'P50', 'discount' => 50],
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
