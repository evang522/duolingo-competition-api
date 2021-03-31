<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Competition\Repository;

use App\Domain\Competition\Entity\Competition;
use App\Domain\Competition\Entity\Competitor;
use App\Domain\Competition\Entity\FinalPoints;
use App\Infrastructure\Repository\EntityRepository;
use Doctrine\ORM\EntityManager;

class FinalPointsRepository extends EntityRepository
{
    public function __construct(EntityManager $em)
    {
        parent::__construct($em, FinalPoints::class);
    }

    public function findForCompetitorAndCompetition(
        Competitor $competitor,
        Competition $competition
    ): ?FinalPoints {
        return $this->findOneBy([
            'competition' => $competition,
            'competitor' => $competitor,
        ]);
    }

    public function store(FinalPoints $finalPoints): void
    {
        $this->_em->persist($finalPoints);
        $this->_em->flush();
    }
}
