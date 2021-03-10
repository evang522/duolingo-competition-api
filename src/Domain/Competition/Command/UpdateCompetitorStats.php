<?php

declare(strict_types=1);

namespace App\Domain\Competition\Command;

use App\Domain\Competition\Entity\CompetitorId;
use App\Domain\Competition\Entity\HostId;

class UpdateCompetitorStats
{
    private CompetitorId $competitorId;
    private HostId $hostId;

    public function __construct(
        CompetitorId $competitorId,
        HostId $hostId
    ) {
        $this->competitorId = $competitorId;
        $this->hostId       = $hostId;
    }

    public function hostId(): HostId
    {
        return $this->hostId;
    }

    public function competitorId(): CompetitorId
    {
        return $this->competitorId;
    }
}
