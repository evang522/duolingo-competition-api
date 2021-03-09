<?php

declare(strict_types=1);

namespace App\Presentation\Admin\Competition;

use App\Domain\Competition\Entity\Host;
use App\Infrastructure\Duolingo\Model\Credentials;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class HostController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Host::class;
    }

    public function createEntity(string $entityFqcn): Host
    {
        return new Host(
            new Credentials('test@email.com', 'My Duolingo Password'),
        );
    }
}
