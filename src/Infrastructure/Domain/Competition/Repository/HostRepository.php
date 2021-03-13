<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Competition\Repository;

use App\Domain\Competition\Entity\Host;
use App\Infrastructure\Duolingo\Model\Credentials;
use App\Infrastructure\Repository\EntityRepository;
use Doctrine\ORM\EntityManager;

class HostRepository extends EntityRepository
{
    public function __construct(EntityManager $em)
    {
        parent::__construct($em, Host::class);
    }

    public function getOneOrCreateDefault(): Host
    {
        $host = $this->findOneBy([]);

        if ($host !== null) {
            return $host;
        }

        $host = new Host('host@host.com', new Credentials('null_auth_token'));

        $this->store($host);

        return $host;
    }

    public function store(Host $host): void
    {
        $this->_em->persist($host);
        $this->_em->flush();
    }
}
