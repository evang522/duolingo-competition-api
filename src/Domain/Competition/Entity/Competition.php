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

    public function __construct(
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

    public function id(): CompetitionId
    {
        return CompetitionId::fromString($this->id);
    }

    public function startDate(): DateTimeImmutable
    {
        return $this->startDate;
    }

    public function setStartDate(DateTimeImmutable $startDate): Competition
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function endDate(): DateTimeImmutable
    {
        return $this->endDate;
    }

    public function setEndDate(DateTimeImmutable $endDate): Competition
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function setName(string $name): Competition
    {
        $this->name = $name;

        return $this;
    }

    public function basePoints(): Collection
    {
        return $this->basePoints;
    }

    public function setBasePoints(Collection $basePoints): Competition
    {
        $this->basePoints = $basePoints;

        return $this;
    }

    /** @return Collection|Competitor[] */
    public function competitors(): Collection
    {
        return $this->competitors;
    }

    public function setCompetitors(Collection $competitors): Competition
    {
        $this->competitors = $competitors;

        return $this;
    }

    public function host(): Host
    {
        return $this->host;
    }

    public function setHost(Host $host): Competition
    {
        $this->host = $host;

        return $this;
    }
}
