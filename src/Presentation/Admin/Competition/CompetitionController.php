<?php

declare(strict_types=1);

namespace App\Presentation\Admin\Competition;

use App\Domain\Competition\Entity\Competition;
use App\Domain\Competition\Entity\Host;
use App\Infrastructure\Duolingo\Model\Credentials;
use Doctrine\Common\Collections\ArrayCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CompetitionController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Competition::class;
    }

    public function createEntity(string $entityFqcn): Competition
    {
        return new Competition(
            new \DateTimeImmutable(),
            new \DateTimeImmutable(),
            'New Competition',
            new ArrayCollection(),
            new ArrayCollection(),
            new Host(new Credentials('hello', 'hello'))
        );
    }
}
