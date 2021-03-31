<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Competition\CommandHandler;

use App\Domain\Competition\Command\FinishCompetition;
use App\Domain\Competition\Command\UpdateCompetitionParticipants;
use App\Domain\Competition\Entity\Competition;
use App\Domain\Competition\Entity\FinalPoints;
use App\Infrastructure\Bus\CommandBus\CommandBus;
use App\Infrastructure\Domain\Competition\Repository\CompetitionRepository;
use App\Infrastructure\Domain\Competition\Repository\FinalPointsRepository;
use App\Infrastructure\Domain\Competition\Service\CompetitionPoints;

class FinishCompetitionHandler
{
    private CompetitionRepository $competitionRepository;
    private CompetitionPoints $competitionPoints;
    private FinalPointsRepository $finalPointsRepository;
    private CommandBus $commandBus;

    public function __construct(
        CompetitionRepository $competitionRepository,
        CompetitionPoints $competitionPoints,
        FinalPointsRepository $finalPointsRepository,
        CommandBus $commandBus
    ) {
        $this->competitionRepository = $competitionRepository;
        $this->competitionPoints     = $competitionPoints;
        $this->finalPointsRepository = $finalPointsRepository;
        $this->commandBus            = $commandBus;
    }

    public function __invoke(FinishCompetition $command): void
    {
        $this->commandBus->handle(new UpdateCompetitionParticipants($command->competitionId()));

        $competition = $this->competitionRepository->get($command->competitionId());

        /** @var FinalPoints[] $finalPointsList */
        $finalPointsList = [];
        foreach ($competition->competitors() as $competitor) {
            $finalPoints = $this->competitionPoints->getForCompetitorAndCompetition($competition, $competitor);
            $finalPoints = new FinalPoints($competitor, $competition, $finalPoints);
            $this->finalPointsRepository->store($finalPoints);

            $finalPointsList[] = $finalPoints;
        }

        $this->calculateAndStoreWinner($finalPointsList, $competition);
    }

    /** @param FinalPoints[]|array $finalPointsList */
    private function calculateAndStoreWinner(array $finalPointsList, Competition $competition): void
    {
        if (\count($finalPointsList) === 0) {
            return;
        }

        $highestFinalPoints = $finalPointsList[0];

        foreach ($finalPointsList as $finalPoints) {
            if ($finalPoints->finalPoints() <= $highestFinalPoints->finalPoints()) {
                continue;
            }

            $highestFinalPoints = $finalPoints;
        }

        $competition->setWinner($highestFinalPoints->competitor());
        $this->competitionRepository->store($competition);
    }
}
