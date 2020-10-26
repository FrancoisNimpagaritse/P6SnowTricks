<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Category;
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
                //->setActivated();
            $manager->persist($user);
        }

        $manager->flush();
    }
}
