<?php

declare(strict_types=1);

namespace App\Tests\Presentation\Rest\Competition\Controller\Fixtures\Loaders;

use App\Domain\Competition\Entity\BasePoints;
use App\FixtureBuilder\Competition\CompetitionBuilder;
use App\FixtureBuilder\Competition\CompetitorBuilder;
use Speicher210\FunctionalTestBundle\Test\Loader\AbstractLoader;

final class TestReturns200WithFullData extends AbstractLoader
{
    public function doLoad(): void
    {
        $competitor1 = CompetitorBuilder::forIdentifier(1)
            ->withTotalPoints(5000)
            ->build();
        $competitor2 = CompetitorBuilder::forIdentifier(2)->build();
        $competitor3 = CompetitorBuilder::forIdentifier(3)->build();

        $competition = CompetitionBuilder::forIdentifier(1)
            ->withCompetitor($competitor1)
            ->withCompetitor($competitor2)
            ->withCompetitor($competitor3)
            ->build();

        $basePoints = new BasePoints($competitor1, $competition, 1000);

        $this->persist($competition);
        $this->persist($competitor1);
        $this->persist($competitor2);
        $this->persist($competitor3);
        $this->persist($basePoints);
    }
}
