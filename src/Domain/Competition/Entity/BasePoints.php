<?php

declare(strict_types=1);

namespace App\Domain\Competition\Entity;

class BasePoints
{
    private string $id;
    private Competitor $competitor;
    private Competition $competition;
    private int $basePoints;

    public function __construct(
        Competitor $competitor,
        Competition $competition,
        int $basePoints
    )
    {
        $this->id = BasePointsId::generate()->asString();
        $this->competitor = $competitor;
        $this->competition = $competition;
        $this->basePoints = $basePoints;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function competitor(): Competitor
    {
        return $this->competitor;
    }

    public function setCompetitor(Competitor $competitor): void
    {
        $this->competitor = $competitor;
    }

    public function competition(): Competition
    {
        return $this->competition;
    }

    public function setCompetition(Competition $competition): void
    {
        $this->competition = $competition;
    }

    public function basePoints(): int
    {
        return $this->basePoints;
    }

    public function setBasePoints(int $basePoints): void
    {
        $this->basePoints = $basePoints;
    }
}
