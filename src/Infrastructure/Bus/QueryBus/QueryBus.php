<?php

declare(strict_types=1);

namespace App\Infrastructure\Bus\QueryBus;

interface QueryBus
{
    /**
     * @param object $query
     * @return mixed
     */
    public function query(object $query);
}
