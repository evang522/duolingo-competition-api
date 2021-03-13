<?php

declare(strict_types=1);

namespace App\Presentation\Admin\Competition;

use App\Domain\Competition\Entity\Competitor;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;

class CompetitorController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Competitor::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            Field::new('id')
                ->hideOnForm(),
            Field::new('duolingoId')->hideOnIndex(),
            Field::new('username', 'Duolingo Username'),
            Field::new('profilePhotoUrl'),
            Field::new('currentLanguage'),
            Field::new('totalPoints'),
        ];
    }

    public function createEntity(string $entityFqcn): Competitor
    {
        return new Competitor('Username', null, 'German', 'Duolingo ID', 0);
    }
}
