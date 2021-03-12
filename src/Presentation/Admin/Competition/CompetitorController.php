<?php

declare(strict_types=1);

namespace App\Presentation\Admin\Competition;

use App\Domain\Competition\Entity\Competitor;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

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
                ->hideOnForm()
                ->setTemplatePath('/field/uuid.html.twig'),
            Field::new('duolingoId'),
            Field::new('username', 'Duolingo Username'),
            ImageField::new('profilePhotoUrl'),
            Field::new('currentLanguage'),
        ];
    }

    public function createEntity(string $entityFqcn): Competitor
    {
        return new Competitor('Username', null, 'German', 'Duolingo ID', 0);
    }

}
