<?php

declare(strict_types=1);

namespace App\Application\Command\Competition;

use App\Domain\Competition\Event\CompetitionStarted;
use App\Infrastructure\Domain\Competition\Repository\CompetitionRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class DispatchCompetitionStartedEvents extends Command
{
    private CompetitionRepository $competitionRepository;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(
        CompetitionRepository $competitionRepository,
        EventDispatcherInterface $eventDispatcher
    ) {
        parent::__construct(null);
        $this->competitionRepository = $competitionRepository;
        $this->eventDispatcher       = $eventDispatcher;
    }

    public function configure(): void
    {
        $this->setName('duo:competition:dispatch_competition_started_events');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $competitions = $this->competitionRepository->findAllStartingWithin10Minutes();

        if (\count($competitions) === 0) {
            $io->writeln('There are no competitions starting within 10 minutes');

            return 0;
        }

        foreach ($this->competitionRepository->findAllStartingWithin10Minutes() as $competition) {
            $this->eventDispatcher->dispatch(new CompetitionStarted($competition));
            $io->writeln(\sprintf('Event dispatched for competition "%s"', $competition->id()->asString()));
        }

        $io->success('Done!');

        return 0;
    }
}
