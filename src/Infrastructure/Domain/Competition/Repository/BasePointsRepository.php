<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Competition\Repository;

use App\Domain\Competition\Entity\BasePoints;
use App\Domain\Competition\Entity\Competition;
use App\Domain\Competition\Entity\Competitor;
use App\Infrastructure\Repository\EntityRepository;
use Doctrine\ORM\EntityManager;

class BasePointsRepository extends EntityRepository
{
    public function __construct(EntityManager $em)
    {
        parent::__construct($em, BasePoints::class);
    }

    public function findForCompetitorAndCompetition(
        Competitor $competitor,
        Competition $competition
    ): ?BasePoints
    {
        return $this->findOneBy([
            'competition' => $competition,
            'competitor' => $competitor
        ]);
    }
}
