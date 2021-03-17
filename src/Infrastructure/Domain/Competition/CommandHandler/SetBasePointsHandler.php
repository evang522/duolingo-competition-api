<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Competition\CommandHandler;

use App\Domain\Competition\Command\SetBasePoints;
use App\Domain\Competition\Entity\BasePoints;
use App\Infrastructure\Domain\Competition\Repository\BasePointsRepository;
use App\Infrastructure\Domain\Competition\Repository\CompetitionRepository;

class SetBasePointsHandler
{
    private CompetitionRepository $competitionRepository;
    private BasePointsRepository $basePointsRepository;

    public function __construct(
        CompetitionRepository $competitionRepository,
        BasePointsRepository $basePointsRepository
    ) {
        $this->competitionRepository = $competitionRepository;
        $this->basePointsRepository  = $basePointsRepository;
    }

    public function __invoke(SetBasePoints $command): void
    {
        $competition = $this->competitionRepository->get($command->competitionId());

        foreach ($competition->competitors() as $competitor) {
            $basePoints = $this->basePointsRepository->findForCompetitorAndCompetition($competitor, $competition);

            if ($basePoints === null) {
                $basePoints = new BasePoints($competitor, $competition, 0);
            }

            $basePoints->setBasePoints($competitor->totalPoints());
            $this->basePointsRepository->store($basePoints);
        }
    }
}
