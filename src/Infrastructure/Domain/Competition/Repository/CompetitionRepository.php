<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Competition\Repository;

use App\Domain\Competition\Entity\Competition;
use App\Domain\Competition\Entity\CompetitionId;
use App\Domain\Competition\Entity\Host;
use App\Domain\Competition\Entity\HostId;
use App\Infrastructure\Repository\EntityRepository;
use Doctrine\ORM\EntityManager;

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
            throw new \RuntimeException('Competition not found');
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
        );

        $this->store($competition);

        return $competition;
    }

    public function store(Competition $competition): void
    {
        $this->_em->persist($competition);
        $this->_em->flush();
    }
}
