<?php

declare(strict_types=1);


namespace App\DataFixtures\Competition;


use App\Domain\Competition\Entity\Host;
use App\Infrastructure\Duolingo\Model\Credentials;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HostFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $host = new Host('host@duocomp.com', new Credentials('myAuthToken'));
        $this->setReference('host1', $host);

        $manager->persist($host);
        $manager->flush();
    }
}
