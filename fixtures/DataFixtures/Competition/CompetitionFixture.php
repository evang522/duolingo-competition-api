<?php

declare(strict_types=1);


namespace App\DataFixtures\Competition;


use App\Domain\Competition\Entity\Competition;
use App\Domain\Competition\Entity\Host;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CompetitionFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i < 10; $i++) {
            $competition = $this->createCompetition($i);
            $manager->persist($competition);
        }

        $manager->flush();
    }

    private function createCompetition(int $counter): Competition
    {
        /** @var Host $host1 */
        $host1 = $this->getReference('host1');

        return new Competition(
            new \DateTimeImmutable('5/20/2030'),
            new \DateTimeImmutable('5/25/2030'),
            'Competition ' . $counter,
            $host1,
            'Description for Competition ' . $counter
        );
    }

    public function getDependencies(): array
    {
        return [HostFixture::class];
    }
}
