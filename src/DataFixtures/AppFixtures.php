<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Faker\Factory::create('fr_FR');

        for ($i=0; $i < 30 ; $i++) { 

            $category = new Category();
            $category->setName($faker->word($faker->randomDigit()));
         
            $manager->persist($category);
        }

        $manager->flush();
    }
}
