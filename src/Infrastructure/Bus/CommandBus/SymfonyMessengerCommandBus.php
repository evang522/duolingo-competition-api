<?php

declare(strict_types=1);

namespace App\Infrastructure\Bus\CommandBus;

use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class SymfonyMessengerCommandBus implements CommandBus
{
    use HandleTrait {
        handle as private doHandle;
    }

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * @param object $command
     */
    public function handle(object $command): void
    {
        $this->doHandle($command);
    }
}
