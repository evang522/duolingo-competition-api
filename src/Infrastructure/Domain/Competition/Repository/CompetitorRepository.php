<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Competition\Repository;

use App\Domain\Competition\Entity\CompetitionId;
use App\Domain\Competition\Entity\Competitor;
use App\Infrastructure\Repository\EntityRepository;
use Doctrine\ORM\EntityManager;

class CompetitorRepository extends EntityRepository
{
    public function __construct(EntityManager $em)
    {
        parent::__construct($em, Competitor::class);
    }

    public function getAny(): Competitor
    {
        $competitor = $this->findOneBy([]);

        if ($competitor !== null) {
            return $competitor;
        }

        $competitor = new Competitor(
            'duolingo_username',
            null,
            'DE',
            '12345',
            0,
            0
        );

        $this->store($competitor);

        return $competitor;
    }

    public function store(Competitor $competitor): void
    {
        $this->_em->persist($competitor);
        $this->_em->flush();
    }

    public function get(CompetitionId $competitionId): Competitor
    {
        $competitor = $this->find($competitionId);

        if ($competitor === null) {
            throw new \RuntimeException('Competitor Not Found');
        }

        return $competitor;
    }

    /** @return Competitor[] */
    public function findByCompetition(CompetitionId $competitionId): array
    {
        return $this->createQueryBuilder('competitor')
            ->innerJoin('competitor.competitions', 'competition')
            ->where('competition.id = :competitionId')
            ->setParameter('competitionId', $competitionId->asString())
            ->getQuery()
            ->getResult();
    }
}
