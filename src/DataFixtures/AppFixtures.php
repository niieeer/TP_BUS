<?php

declare(strict_types = 1);

namespace App\DataFixtures;

use App\Entity\Daddy;
use App\Entity\Student;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $user = (new User())->setEmail("clement0201@icloud.com")->setAge(20)->setRoles(['admin']);
        $hashedPassword = $this->encoder->hashPassword($user, "glory");
        $user->setPassword($hashedPassword)->setName('Clément')->setSexe("Homme");

        $manager->persist($user);
        $manager->flush();
    }
}
