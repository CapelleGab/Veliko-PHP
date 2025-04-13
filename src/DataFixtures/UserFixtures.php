<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $hasher) {}
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 10; $i++) {
            $user = new \App\Entity\User();
            $user->setRoles(['ROLE_USER']);
            $user->setFirstName($faker->firstName());
            $user->setLastName($faker->lastName());
            $user->setUsername($faker->userName());
            $user->setPhoneNumber($faker->phoneNumber());
            $user->setCreatedAt(new \DateTimeImmutable());
            $user->setUpdatedAt(new \DateTimeImmutable());
            $user->setPassword($this->hasher->hashPassword($user, 'password'));
            $user->setEmail($faker->email());
            $user->setIsVerified(true);

            $manager->persist($user);
        }
        $manager->flush();
    }
}
