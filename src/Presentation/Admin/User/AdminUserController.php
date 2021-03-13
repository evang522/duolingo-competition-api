<?php

declare(strict_types=1);

namespace App\Presentation\Admin\User;

use App\Domain\User\Entity\AdminUser;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;

class AdminUserController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AdminUser::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            Field::new('id')->hideOnForm()->setTemplatePath('/field/uuid.html.twig'),
            Field::new('email'),
            Field::new('plainTextPassword'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
}
