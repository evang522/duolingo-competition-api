<?php

declare(strict_types=1);

namespace App\Infrastructure\Bus\QueryBus;

use App\Infrastructure\Bus\QueryBus;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class SymfonyMessengerQueryBus implements QueryBus\QueryBus
{
    use HandleTrait;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * @return mixed
     */
    public function query(object $query)
    {
        return $this->handle($query);
    }
}
