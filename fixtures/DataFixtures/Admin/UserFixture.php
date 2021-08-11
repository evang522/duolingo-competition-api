<?php

declare(strict_types=1);


namespace App\DataFixtures\Admin;


use App\Domain\User\Entity\AdminUser;
use App\Infrastructure\Domain\User\Service\UserPasswordUpdater;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    private UserPasswordUpdater $passwordUpdater;

    public function __construct(UserPasswordUpdater $passwordUpdater)
    {
        $this->passwordUpdater = $passwordUpdater;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new AdminUser();
        $user->setEmail('admin@duo.de');
        $user->setPlainTextPassword('admin');

        $this->passwordUpdater->updatePassword($user);

        $manager->persist($user);
        $manager->flush();
    }
}
