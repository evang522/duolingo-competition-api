<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Competition\Listener;

use App\Domain\Competition\Command\SetBasePoints;
use App\Domain\Competition\Event\CompetitionStarted;
use App\Infrastructure\Bus\CommandBus\CommandBus;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CompetitionStartedListener implements EventSubscriberInterface
{
    private CommandBus $commandBus;

    public function __construct(
        CommandBus $commandBus
    ) {
        $this->commandBus = $commandBus;
    }

    public static function getSubscribedEvents(): array
    {
        return [CompetitionStarted::class => 'onCompetitionStarted'];
    }

    public function onCompetitionStarted(CompetitionStarted $event): void
    {
        $competition = $event->competition();

        $this->commandBus->handle(new SetBasePoints($competition->id()));
    }
}
