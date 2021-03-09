<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use Doctrine\ORM\EntityManager;

abstract class EntityRepository extends \Doctrine\ORM\EntityRepository implements ServiceEntityRepositoryInterface
{
    public function __construct(EntityManager $manager, string $entityClass)
    {
        parent::__construct($manager, $manager->getClassMetadata($entityClass));
    }
}
