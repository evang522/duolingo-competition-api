<?php

declare(strict_types=1);

namespace App\Infrastructure\Bus\CommandBus;

interface CommandBus
{
    public function handle(object $command): void;
}
