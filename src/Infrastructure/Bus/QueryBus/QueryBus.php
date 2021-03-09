<?php

declare(strict_types=1);

namespace App\Infrastructure\Bus\QueryBus;

interface QueryBus
{
    /**
     * @return mixed
     */
    public function query(object $query);
}
