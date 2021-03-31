<?php

declare(strict_types=1);

namespace App\Tests\Infrastructure\Domain\Competition\Service;

use App\Domain\Competition\Entity\BasePoints;
use App\Domain\Competition\Entity\Competition;
use App\Domain\Competition\Entity\Competitor;
use App\Domain\Competition\Entity\FinalPoints;
use App\Domain\Competition\Entity\Host;
use App\Infrastructure\Domain\Competition\Repository\BasePointsRepository;
use App\Infrastructure\Domain\Competition\Repository\FinalPointsRepository;
use App\Infrastructure\Domain\Competition\Service\CompetitionPoints;
use App\Infrastructure\Duolingo\Model\Credentials;
use PHPUnit\Framework\TestCase;

class CompetitionPointsTest extends TestCase
{
    public function testReturnsFinalPointsIfTheyArePresent(): void
    {
        $finalPointsRepo = $this->createMock(FinalPointsRepository::class);
        $basePointsRepo  = $this->createMock(BasePointsRepository::class);

        $competitionPoints = new CompetitionPoints($finalPointsRepo, $basePointsRepo);
        $competition       = new Competition(
            new \DateTimeImmutable(),
            new \DateTimeImmutable(),
            'Test',
            new Host('test@test.com', new Credentials('asd')),
            null
        );

        $competitor = new Competitor(
            'username',
            null,
            'DE',
            '21345',
            10000,
            0
        );

        $finalPointsRepo->expects(self::once())
            ->method('findForCompetitorAndCompetition')
            ->willReturn(new FinalPoints($competitor, $competition, 1000));

        $pointsForCompetition = $competitionPoints->getForCompetitorAndCompetition(
            $competition,
            $competitor
        );

        self::assertEquals(1000, $pointsForCompetition);
    }

    public function testReturns0IfNoBasePointsOrFinalPointsArePresent(): void
    {
        $finalPointsRepo = $this->createMock(FinalPointsRepository::class);
        $basePointsRepo  = $this->createMock(BasePointsRepository::class);

        $competitionPoints = new CompetitionPoints($finalPointsRepo, $basePointsRepo);
        $competition       = new Competition(
            new \DateTimeImmutable(),
            new \DateTimeImmutable(),
            'Test',
            new Host('test@test.com', new Credentials('asd')),
            null
        );

        $competitor = new Competitor(
            'username',
            null,
            'DE',
            '21345',
            10000,
            0
        );

        $finalPointsRepo->expects(self::once())
            ->method('findForCompetitorAndCompetition')
            ->willReturn(null);

        $basePointsRepo->expects(self::once())
            ->method('findForCompetitorAndCompetition')
            ->willReturn(null);

        $pointsForCompetition = $competitionPoints->getForCompetitorAndCompetition(
            $competition,
            $competitor
        );

        self::assertEquals(0, $pointsForCompetition);
    }

    public function testReturnsBasePointsSubtractedFromTotalPointsWhenPresent(): void
    {
        $finalPointsRepo = $this->createMock(FinalPointsRepository::class);
        $basePointsRepo  = $this->createMock(BasePointsRepository::class);

        $competitionPoints = new CompetitionPoints($finalPointsRepo, $basePointsRepo);
        $competition       = new Competition(
            new \DateTimeImmutable(),
            new \DateTimeImmutable(),
            'Test',
            new Host('test@test.com', new Credentials('asd')),
            null
        );

        $competitor = new Competitor(
            'username',
            null,
            'DE',
            '21345',
            1500,
            0
        );

        $finalPointsRepo->expects(self::once())
            ->method('findForCompetitorAndCompetition')
            ->willReturn(null);

        $basePointsRepo->expects(self::once())
            ->method('findForCompetitorAndCompetition')
            ->willReturn(new BasePoints($competitor, $competition, 1000));

        $pointsForCompetition = $competitionPoints->getForCompetitorAndCompetition(
            $competition,
            $competitor
        );

        self::assertEquals(500, $pointsForCompetition);
    }

    public function testWhenBasePointsAndFinalPointsAreAvailablePrefersFinalPoints(): void
    {
        $finalPointsRepo = $this->createMock(FinalPointsRepository::class);
        $basePointsRepo  = $this->createMock(BasePointsRepository::class);

        $competitionPoints = new CompetitionPoints($finalPointsRepo, $basePointsRepo);
        $competition       = new Competition(
            new \DateTimeImmutable(),
            new \DateTimeImmutable(),
            'Test',
            new Host('test@test.com', new Credentials('asd')),
            null
        );

        $competitor = new Competitor(
            'username',
            null,
            'DE',
            '21345',
            6500,
            0
        );

        $finalPointsRepo->expects(self::once())
            ->method('findForCompetitorAndCompetition')
            ->willReturn(new FinalPoints($competitor, $competition, 5000));

        $basePointsRepo
            ->method('findForCompetitorAndCompetition')
            ->willReturn(new BasePoints($competitor, $competition, 1000));

        $pointsForCompetition = $competitionPoints->getForCompetitorAndCompetition(
            $competition,
            $competitor
        );

        self::assertEquals(5000, $pointsForCompetition);
    }
}
