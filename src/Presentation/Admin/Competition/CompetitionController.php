<?php

declare(strict_types=1);

namespace App\Presentation\Admin\Competition;

use App\Domain\Competition\Entity\Competition;
use App\Domain\Competition\Entity\Competitor;
use App\Infrastructure\Domain\Competition\Repository\HostRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\CrudAutocompleteType;

class CompetitionController extends AbstractCrudController
{
    private HostRepository $hostRepository;

    public function __construct(
        HostRepository $hostRepository
    ) {
        $this->hostRepository = $hostRepository;
    }

    public static function getEntityFqcn(): string
    {
        return Competition::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            Field::new('id')
                ->hideOnForm()
                ->setTemplatePath('/field/uuid.html.twig'),
            Field::new('name'),
            AssociationField::new('host'),
            AssociationField::new('competitors')
                ->autocomplete()
                ->setFormType(CrudAutocompleteType::class)
                ->setFieldFqcn(Competitor::class),
            Field::new('startDate'),
            Field::new('endDate'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function createEntity(string $entityFqcn): Competition
    {
        $host = $this->hostRepository->getOneOrCreateDefault();

        return new Competition(
            new \DateTimeImmutable(),
            new \DateTimeImmutable(),
            'New Competition',
            $host
        );
    }
}
