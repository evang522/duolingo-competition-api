<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Competition\Repository;

use App\Domain\Competition\Entity\Competition;
use App\Domain\Competition\Entity\CompetitionId;
use App\Domain\Competition\Entity\HostId;
use App\Infrastructure\Repository\EntityRepository;
use Doctrine\ORM\EntityManager;

class CompetitionRepository extends EntityRepository
{
    public function __construct(EntityManager $em)
    {
        parent::__construct($em, Competition::class);
    }

    public function get(CompetitionId $competitionId): Competition
    {
        $competition = $this->find($competitionId->asString());
        if ($competition === null) {
            throw new \RuntimeException('Competition not found');
        }

        return $competition;
    }

    public function hostConnectedToCompetitions(HostId $hostId): bool
    {
        return $this->count([
                'host' => $hostId
            ]) >= 1;
    }
}
