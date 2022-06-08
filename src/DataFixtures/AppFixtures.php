<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i=0; $i < 30 ; $i++) { 

            $article = new Article();
            $article->setTitle($faker->word($faker->randomDigit()));
            $article->setContent('<p>'. implode('</p><p>', $faker->words(40)) .'</p>');
            $article->setAuthor($faker->name());
         
            $manager->persist($article);
        }

        $manager->flush();
    }
}
