<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Competition\Repository;

use App\Domain\Competition\Entity\Competition;
use App\Infrastructure\Repository\EntityRepository;
use Doctrine\ORM\EntityManager;

class CompetitionRepository extends EntityRepository
{
    public function __construct(EntityManager $em)
    {
        parent::__construct($em, Competition::class);
    }
}
