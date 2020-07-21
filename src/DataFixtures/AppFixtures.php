<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $products = [
          'Vegetables and fruit',
          'Paying rent',
          'Dentist visit',
          'Bottle of water'
        ];
        $count = count($products);

        for ($i = 0; $i < $count; ++$i) {
            $product = new Product();
            $product->setTitle($products[$i])
                    ->setCost(mt_rand(1, 100))
                    ->setCreatedAt(\DateTime::createFromFormat('Y-m-d', date('Y-m-d')));
            $manager->persist($product);
        }
        $manager->flush();
    }
}
