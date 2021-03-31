<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Competition\Service;

use App\Domain\Competition\Entity\Competition;
use App\Domain\Competition\Entity\Competitor;
use App\Infrastructure\Domain\Competition\Repository\BasePointsRepository;
use App\Infrastructure\Domain\Competition\Repository\FinalPointsRepository;

class CompetitionPoints
{
    private FinalPointsRepository $finalPointsRepository;
    private BasePointsRepository $basePointsRepository;

    public function __construct(
        FinalPointsRepository $finalPointsRepository,
        BasePointsRepository $basePointsRepository
    ) {
        $this->finalPointsRepository = $finalPointsRepository;
        $this->basePointsRepository  = $basePointsRepository;
    }

    public function getForCompetitorAndCompetition(Competition $competition, Competitor $competitor): int
    {
        $finalPoints = $this->finalPointsRepository->findForCompetitorAndCompetition($competitor, $competition);

        if ($finalPoints !== null) {
            return $finalPoints->finalPoints();
        }

        $competitorTotalPoints = $competitor->totalPoints();

        $basePoints = $this->basePointsRepository->findForCompetitorAndCompetition($competitor, $competition);
        if ($basePoints !== null) {
            return \max($competitorTotalPoints - $basePoints->basePoints(), 0);
        }

        return 0;
    }
}
