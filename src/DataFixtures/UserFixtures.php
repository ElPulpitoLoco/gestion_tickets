<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        //créer un admin
        $admin = new User();
        $admin->setEmail('admin@example.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'adminpass'));
        $manager->persist($admin);

        //créer un staff
        $staff = new User();
        $staff->setEmail('staff@example.com');
        $staff->setRoles(['ROLE_STAFF']);
        $staff->setPassword($this->passwordHasher->hashPassword($staff, 'staffpass'));
        $manager->persist($staff);

        $manager->flush();
    }
}
