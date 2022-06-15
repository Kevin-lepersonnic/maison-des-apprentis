<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Role;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder){
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Faker\Factory::create('fr_FR');        

        // ----------------   Fixture pour User ----------------
        
        $users = [];
        $genres = ['male', 'female'];

        for ($i=0; $i <= 20 ; $i++) { 
            $user = new User();
            
            $genre = $faker->randomElement($genres);

            $picture = 'https://randomuser.me/api/portraits/';
            $pictureId = $faker->numberBetween(1,99). '.jpg';

            $picture .= ($genre == 'male' ? 'men/' : 'women/').$pictureId;

            $user->setFirstname($faker->firstName($genre))
                 ->setLastname($faker->lastname)
                 ->setEmail($faker->email)
                 ->setAvatar($picture)
                 ->setHash($this->encoder->hashPassword($user, "password"));
            
            $manager->persist($user);
            $users[] = $user;
        }
        
        // User Kevin
        $user1 = new User();
        $user1->setFirstname('Kevin')
                ->setLastname('Lebreton')
                ->setEmail('kevin@mda.fr')
                ->setAvatar('https://i.pinimg.com/736x/d6/ae/52/d6ae527fae8b7164d583393297de497e.jpg')
                ->setHash($this->encoder->hashPassword($user1, "password"));        
        $manager->persist($user1);

        // User Hakim
        $user2 = new User();
        $user2->setFirstname('Hakim')
                ->setLastname('Lebogoss')
                ->setEmail('hakim@mda.fr')
                ->setAvatar('https://nicotoulouse.files.wordpress.com/2018/08/2018-05-27-nico-01-2-3.jpg')
                ->setHash($this->encoder->hashPassword($user2, "password"));        
        $manager->persist($user2);

        // User Tristan
        $user3 = new User();
        $user3->setFirstname('Tristan')
                ->setLastname('Lechevelu')
                ->setEmail('tristan@mda.fr')
                ->setAvatar('https://i0.wp.com/www.starmag.com/wp-content/uploads/2018/09/barbu-et-chevelu-il-subit-un-relooking-extreme-le-changement-est-incroyable.jpg?resize=1200%2C1200&ssl=1')
                ->setHash($this->encoder->hashPassword($user3, "password"));        
        $manager->persist($user3);

        // User Antho
        $user4 = new User();
        $user4->setFirstname('Anthony')
                ->setLastname('Leserieux')
                ->setEmail('anthony@mda.fr')
                ->setAvatar('https://thumbs.dreamstime.com/b/le-gamer-s%C3%A9rieux-passe-temps-dans-club-d-ordinateur-103713838.jpg')
                ->setHash($this->encoder->hashPassword($user4, "password"));        
        $manager->persist($user4);

        // User Florian
        $user5 = new User();
        $user5->setFirstname('Florian')
                ->setLastname('Alapero')
                ->setEmail('florian@mda.fr')
                ->setAvatar('https://www.happybeertime.com/wp-content/uploads/2013/11/ventre-biere.jpg')
                ->setHash($this->encoder->hashPassword($user5, "password"));        
        $manager->persist($user5);

        // création des Users Admin
        $adminRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);

        $adminUser1 = new User();
        $adminUser1->setFirstname('Florian')
                    ->setLastname('Admin')
                    ->setEmail('florian@admin.fr')
                    ->setAvatar('https://www.booska-p.com/wp-content/uploads/2021/10/da-couvre-la-ma-re-de-sangoku-photo.jpg')
                    ->setHash($this->encoder->hashPassword($adminUser1, "password"))
                    ->addUserRole($adminRole);
        $manager->persist($adminUser1);

        $adminUser2 = new User();
        $adminUser2->setFirstname('Kevin')
                    ->setLastname('Admin')
                    ->setEmail('kevin@admin.fr')
                    ->setAvatar('https://www.booska-p.com/wp-content/uploads/2021/10/da-couvre-la-ma-re-de-sangoku-photo.jpg')
                    ->setHash($this->encoder->hashPassword($adminUser2, "password"))
                    ->addUserRole($adminRole);
        $manager->persist($adminUser2);

        $adminUser3 = new User();
        $adminUser3->setFirstname('Hakim')
                    ->setLastname('Admin')
                    ->setEmail('hakim@admin.fr')
                    ->setAvatar('https://www.booska-p.com/wp-content/uploads/2021/10/da-couvre-la-ma-re-de-sangoku-photo.jpg')
                    ->setHash($this->encoder->hashPassword($adminUser3, "password"))
                    ->addUserRole($adminRole);
        $manager->persist($adminUser3);

        $adminUser4 = new User();
        $adminUser4->setFirstname('Tristan')
                    ->setLastname('Admin')
                    ->setEmail('tristan@admin.fr')
                    ->setAvatar('https://www.booska-p.com/wp-content/uploads/2021/10/da-couvre-la-ma-re-de-sangoku-photo.jpg')
                    ->setHash($this->encoder->hashPassword($adminUser4, "password"))
                    ->addUserRole($adminRole);
        $manager->persist($adminUser4);

        $adminUser5 = new User();
        $adminUser5->setFirstname('Anthony')
                    ->setLastname('Admin')
                    ->setEmail('anthony@admin.fr')
                    ->setAvatar('https://www.booska-p.com/wp-content/uploads/2021/10/da-couvre-la-ma-re-de-sangoku-photo.jpg')
                    ->setHash($this->encoder->hashPassword($adminUser5, "password"))
                    ->addUserRole($adminRole);
        $manager->persist($adminUser5);

        // --------------- Fixture Category ----------------------

        $angularCat = new Category();
        $angularCat->setname('Angular')
                        ->setimage('../img/angular-logo.png')
                        ->setdescription('framework Front-end');
        $manager->persist($angularCat);
        

        $htmlCat = new Category();
        $htmlCat->setname('HTML')
                    ->setimage('../img/html-1.png')
                    ->setdescription('Langage de balisage');
        $manager->persist($htmlCat);

        $cssCat = new Category();
        $cssCat->setname('CSS')
                    ->setimage('../img/css-3.png')
                    ->setdescription('Langage de style');
        $manager->persist($cssCat);

        $symfonyCat = new Category();
        $symfonyCat->setname('Symfony')
                    ->setimage('../img/symfony-5.png')
                    ->setdescription('Framework back-end');
        $manager->persist($symfonyCat);

        $phpCat = new Category();
        $phpCat->setname('PHP')
                    ->setimage('../img/3.png')
                    ->setdescription('Langage back-end');
        $manager->persist($phpCat);

        $jsCat = new Category();
        $jsCat->setname('JavaScript')
                    ->setimage('../img/javascript-1.png')
                    ->setdescription('Langage Front-end');
        $manager->persist($jsCat);

        $bootstrapCat = new Category();
        $bootstrapCat->setname('Bootstrap')
                    ->setimage('../img/4.png')
                    ->setdescription('Bibliothèque de style');
        $manager->persist($bootstrapCat);

        $wpCat = new Category();
        $wpCat->setname('Wordpress')
                    ->setimage('../img/wp.png')
                    ->setdescription('Un CMS au top');
        $manager->persist($wpCat);
        
        $categories=[$angularCat, $htmlCat, $cssCat, $symfonyCat, $phpCat, $jsCat, $bootstrapCat, $wpCat];
        
        // ----------------  Fixture pour Articles ---------------
        
        for ($i=0; $i < 30 ; $i++) { 

            $article = new Article();
            
            $author = $users[mt_rand(0, count($users) -1)];
            $category = $categories[mt_rand(0, count($categories) -1)];
            $article->setTitle($faker->word($faker->randomDigit()))
                    ->setImage("https://www.événementiel.net/wp-content/uploads/2014/02/default-placeholder.png")
                    ->setContent('<p>'. implode('</p><p>', $faker->words(25)) .'</p>')
                    ->setAuthor($author)
                    ->setCategory($category);
        
            $manager->persist($article);
        }

        
         $manager->flush();
    }
}
