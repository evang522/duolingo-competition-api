<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Competition\Service;

use App\Domain\Competition\Entity\Competition;
use App\Domain\Competition\Entity\Competitor;
use App\Domain\Competition\Model\CompetitorForCompetition;
use App\Infrastructure\Domain\Competition\Repository\BasePointsRepository;
use App\Infrastructure\Domain\Competition\Repository\CompetitorRepository;

class GetCompetitorsForCompetition
{
    private CompetitorRepository $competitorRepository;
    private BasePointsRepository $basePointsRepository;

    public function __construct(
        CompetitorRepository $competitorRepository,
        BasePointsRepository $basePointsRepository
    ) {
        $this->competitorRepository = $competitorRepository;
        $this->basePointsRepository = $basePointsRepository;
    }

    /** @return CompetitorForCompetition[] */
    public function getListForCompetition(Competition $competition): array
    {
        $competitors = $this->competitorRepository->findByCompetition($competition->id());

        return \array_map(
            function (Competitor $competitor) use ($competition): CompetitorForCompetition {
                $basePoints = $this->basePointsRepository
                    ->findForCompetitorAndCompetition($competitor, $competition);

                $totalPoints = $competitor->totalPoints();

                if ($basePoints !== null) {
                    $totalPoints = \max([0, $totalPoints - $basePoints->basePoints()]);
                }

                return new CompetitorForCompetition(
                    $competition->id()->asString(),
                    $competitor->username(),
                    $competitor->duolingoId(),
                    $totalPoints,
                    $competitor->profilePhotoUrl()
                );
            },
            $competitors
        );
    }
}
