<?php

declare(strict_types=1);

namespace App\Domain\Competition\Entity;

use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;

class Competition
{
    private string $id;
    private DateTimeImmutable $startDate;
    private DateTimeImmutable $endDate;
    private string $name;
    private Collection $basePoints;
    private Collection $competitors;
    private Host $host;

    private function __construct(
        DateTimeImmutable $startDate,
        DateTimeImmutable $endDate,
        string $name,
        Collection $basePoints,
        Collection $competitors,
        Host $host
    ) {
        $this->id          = CompetitionId::generate()->asString();
        $this->startDate   = $startDate;
        $this->endDate     = $endDate;
        $this->name        = $name;
        $this->basePoints  = $basePoints;
        $this->competitors = $competitors;
        $this->host        = $host;
    }
}
