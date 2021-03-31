<?php

declare(strict_types=1);

namespace App\Domain\Competition\Command;

use App\Domain\Competition\Entity\CompetitionId;

class FinishCompetition
{
    private CompetitionId $competitionId;

    public function __construct(
        CompetitionId $competitionId
    ) {
        $this->competitionId = $competitionId;
    }

    public function competitionId(): CompetitionId
    {
        return $this->competitionId;
    }
}
