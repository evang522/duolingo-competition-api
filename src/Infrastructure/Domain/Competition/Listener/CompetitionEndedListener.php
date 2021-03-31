<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Competition\Listener;

use App\Domain\Competition\Command\FinishCompetition;
use App\Domain\Competition\Event\CompetitionEnded;
use App\Infrastructure\Bus\CommandBus\CommandBus;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CompetitionEndedListener implements EventSubscriberInterface
{
    private CommandBus $commandBus;

    public function __construct(
        CommandBus $commandBus
    ) {
        $this->commandBus = $commandBus;
    }

    public static function getSubscribedEvents(): array
    {
        return [CompetitionEnded::class => 'onCompetitionEnded'];
    }

    public function onCompetitionEnded(CompetitionEnded $event): void
    {
        $competition = $event->competition();

        $this->commandBus->handle(new FinishCompetition($competition->id()));
    }
}
