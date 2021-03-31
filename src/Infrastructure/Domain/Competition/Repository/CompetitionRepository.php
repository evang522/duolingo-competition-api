<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Competition\Repository;

use App\Domain\Competition\Entity\Competition;
use App\Domain\Competition\Entity\CompetitionId;
use App\Domain\Competition\Entity\Host;
use App\Domain\Competition\Entity\HostId;
use App\Infrastructure\Repository\EntityRepository;
use DateTime;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CompetitionRepository extends EntityRepository
{
    public function __construct(
        EntityManager $em
    ) {
        parent::__construct($em, Competition::class);
    }

    public function get(CompetitionId $competitionId): Competition
    {
        $competition = $this->find($competitionId->asString());
        if ($competition === null) {
            throw new NotFoundHttpException('Competition not found');
        }

        return $competition;
    }

    public function hostConnectedToCompetitions(HostId $hostId): bool
    {
        return $this->count(['host' => $hostId]) >= 1;
    }

    public function getAny(): Competition
    {
        $competition = $this->findOneBy([]);
        if ($competition !== null) {
            return $competition;
        }

        $hostRepository = $this->getEntityManager()->getRepository(Host::class);

        $competition = new Competition(
            new \DateTimeImmutable(),
            new \DateTimeImmutable(),
            'Default_Competition',
            $hostRepository->getOneOrCreateDefault(),
            null,
        );

        $this->store($competition);

        return $competition;
    }

    public function store(Competition $competition): void
    {
        $this->_em->persist($competition);
        $this->_em->flush();
    }

    /**
     * @return Competition[]
     */
    public function findAllStartingWithin10Minutes(): array
    {
        return $this->createQueryBuilder('c')
            ->where('c.startDate BETWEEN :now AND :tenMinutesFromNow')
            ->setParameter('now', new DateTime())
            ->setParameter('tenMinutesFromNow', (new DateTime())->add(new \DateInterval('PT10M')))
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Competition[]
     */
    public function findAllActiveCompetitions(): array
    {
        return $this->createQueryBuilder('c')
            ->where('c.startDate < :now')
            ->where('c.endDate > :now')
            ->setParameter('now', new DateTime())
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Competition[]
     */
    public function findAllEndingWithin10Minutes(): array
    {
        return $this->createQueryBuilder('c')
            ->where('c.endDate BETWEEN :now AND :tenMinutesFromNow')
            ->setParameter('now', new DateTime())
            ->setParameter('tenMinutesFromNow', (new DateTime())->add(new \DateInterval('PT10M')))
            ->getQuery()
            ->getResult();
    }
}
