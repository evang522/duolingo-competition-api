<?php

declare(strict_types=1);

namespace App\Application\Command\Competition;

use App\Domain\Competition\Command\UpdateCompetitionParticipants;
use App\Infrastructure\Bus\CommandBus\CommandBus;
use App\Infrastructure\Domain\Competition\Repository\CompetitionRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UpdateAllCompetitionsCommand extends Command
{
    private CommandBus $commandBus;
    private CompetitionRepository $competitionRepository;

    public function __construct(
        CommandBus $commandBus,
        CompetitionRepository $competitionRepository
    ) {
        parent::__construct();
        $this->commandBus            = $commandBus;
        $this->competitionRepository = $competitionRepository;
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $competitions = $this->competitionRepository->findAllActiveCompetitions();
        foreach ($competitions as $competition) {
            $this->commandBus->handle(
                new UpdateCompetitionParticipants($competition->id())
            );
        }

        $io->success('Done!');

        return 0;
    }

    protected function configure(): void
    {
        $this->setName('duo:competition:update_all');
    }
}
