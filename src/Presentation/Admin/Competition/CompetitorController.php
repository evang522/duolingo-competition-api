<?php

declare(strict_types=1);

namespace App\Presentation\Admin\Competition;

use App\Domain\Competition\Entity\Competitor;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CompetitorController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Competitor::class;
    }

    public function createEntity(string $entityFqcn): Competitor
    {
        return new Competitor('Username', null, 'German', 'Duolingo ID', 0);
    }
}
