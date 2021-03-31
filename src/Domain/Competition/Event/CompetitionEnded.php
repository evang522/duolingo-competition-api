<?php

declare(strict_types=1);

namespace App\Domain\Competition\Event;

use App\Domain\Competition\Entity\Competition;

class CompetitionEnded
{
    private Competition $competition;

    public function __construct(
        Competition $competition
    ) {
        $this->competition = $competition;
    }

    public function competition(): Competition
    {
        return $this->competition;
    }
}
