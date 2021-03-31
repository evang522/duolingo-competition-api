<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Competition\Service;

use App\Domain\Competition\Entity\Competition;
use App\Domain\Competition\Entity\Competitor;
use App\Domain\Competition\Model\CompetitorForCompetition;
use App\Infrastructure\Domain\Competition\Repository\CompetitorRepository;

class GetCompetitorsForCompetition
{
    private CompetitorRepository $competitorRepository;
    private CompetitionPoints $competitionPoints;

    public function __construct(
        CompetitorRepository $competitorRepository,
        CompetitionPoints $competitionPoints
    ) {
        $this->competitorRepository = $competitorRepository;
        $this->competitionPoints    = $competitionPoints;
    }

    /** @return CompetitorForCompetition[] */
    public function getListForCompetition(Competition $competition): array
    {
        $competitors = $this->competitorRepository->findByCompetition($competition->id());

        return \array_map(
            function (Competitor $competitor) use ($competition): CompetitorForCompetition {
                $pointsForCompetition = $this->competitionPoints->getForCompetitorAndCompetition(
                    $competition,
                    $competitor
                );

                return new CompetitorForCompetition(
                    $competition->id()->asString(),
                    $competitor->username(),
                    $competitor->duolingoId(),
                    $pointsForCompetition,
                    $competitor->currentLanguage(),
                    $competitor->profilePhotoUrl(),
                    $competitor->streak()
                );
            },
            $competitors
        );
    }
}
