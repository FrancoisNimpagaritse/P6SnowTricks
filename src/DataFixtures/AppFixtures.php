<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Category;
use App\Entity\Figure;
use App\Entity\Message;
use App\Entity\Picture;
use App\Entity\Video;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-FR');

        //Nous gérons les utilisateurs
        $users = [];
        for($i = 1; $i <= 5; $i++)
        {
            $user = new User();

            $hash = $this->encoder->encodePassword($user, 'password');

            $user->setFirstname($faker->firstname)
                 ->setLastname($faker->lastname)
                 ->setEmail($faker->email)
                 ->setHash($hash)
                 ->setImageName($faker->imageUrl(640,480))
                 ->setUpdatedAt(new \DateTime('now'));
            $manager->persist($user);
            $users[] = $user;
        }
        
        //Nous gérons les catégories
        $categories = [];
        for($i = 1; $i <= 2; $i++)
        {
            $category = new Category();

            $category->setName($faker->name);

            $manager->persist($category);
            $categories[] = $category;
        }

        //Nous gérons les figures
        $figures =[];
        for($i = 1; $i <= 5 ; $i++)
        {
            $figure = new Figure();
    
            $cat = $categories[mt_rand(0,1)];
            $figure->setName($faker->name())
                   ->setDescription($faker->sentence())
                   ->setUpdatedAt(new \DateTime('now'))
                   ->setCategory($cat);

            $manager->persist($figure);
            $figures[] = $figure;
        }

        //Nous gérons les pictures
        for($i = 1; $i <= 3; $i++)
        {
            $picture = new Picture();

            $fig =  $figures[mt_rand(0,4)];

            $picture->setName($faker->name)
                    ->setCaption($faker->sentence())
                    ->setFigure($fig);

            $manager->persist($picture);
        }

        //Nous gérons les vidéos
        for($i = 1; $i <= 3; $i++)
        {
            $video = new Video();

            $fig =  $figures[mt_rand(0,4)];

            $video->setUrl($faker->url)
                    ->setFigure($fig);

            $manager->persist($video);
        }

        //Nous gérons les messages
        for($i = 1; $i <= 15; $i++)
        {
            $message = new Message();

            $usuario = $users[mt_rand(0,4)];
            $fig =  $figures[mt_rand(0,4)];

            $message->setContent($faker->sentence())
                    ->setCreatedAt(new \DateTime('now'))
                    ->setUser($usuario)
                    ->setFigure($fig);

            $manager->persist($message);
        }

        $manager->flush();
    }
}
