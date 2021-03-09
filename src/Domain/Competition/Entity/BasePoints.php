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
    ) {
        $this->id          = BasePointsId::generate()->asString();
        $this->competitor  = $competitor;
        $this->competition = $competition;
        $this->basePoints  = $basePoints;
    }
}
