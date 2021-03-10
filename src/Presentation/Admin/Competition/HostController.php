<?php

declare(strict_types=1);

namespace App\Presentation\Admin\Competition;

use App\Domain\Competition\Entity\Host;
use App\Infrastructure\Duolingo\Model\Credentials;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;

class HostController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Host::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            Field::new('id')->hideOnForm(),
            Field::new('credentials.username', 'Duolingo username'),
            Field::new('credentials.password', 'Duolingo Password'),
        ];
    }

    public function createEntity(string $entityFqcn): Host
    {
        return new Host(
            new Credentials('test@email.com', 'My Duolingo Password', null),
        );
    }
}
