<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Competition\Repository;

use App\Domain\Competition\Entity\Host;
use App\Infrastructure\Repository\EntityRepository;
use Doctrine\ORM\EntityManager;

class HostRepository extends EntityRepository
{
    public function __construct(EntityManager $em)
    {
        parent::__construct($em, Host::class);
    }
}
