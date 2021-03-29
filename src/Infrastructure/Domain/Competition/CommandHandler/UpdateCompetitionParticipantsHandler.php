<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Competition\CommandHandler;

use App\Domain\Competition\Command\UpdateCompetitionParticipants;
use App\Domain\Competition\Command\UpdateCompetitorStats;
use App\Infrastructure\Bus\CommandBus\CommandBus;
use App\Infrastructure\Domain\Competition\Repository\CompetitionRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class UpdateCompetitionParticipantsHandler implements MessageHandlerInterface
{
    private CompetitionRepository $competitionRepository;
    private CommandBus $commandBus;

    public function __construct(
        CompetitionRepository $competitionRepository,
        CommandBus $commandBus
    ) {
        $this->competitionRepository = $competitionRepository;
        $this->commandBus            = $commandBus;
    }

    public function __invoke(UpdateCompetitionParticipants $command): void
    {
        $competition = $this->competitionRepository->get($command->competitionId());

        foreach ($competition->competitors() as $competitor) {
            $this->commandBus->handle(
                new UpdateCompetitorStats($competitor->id(), $competition->host()->id())
            );
        }

        $competition->setUpdatedAt(new \DateTimeImmutable());
        $this->competitionRepository->store($competition);
    }
}
