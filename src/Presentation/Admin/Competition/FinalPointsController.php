<?php

declare(strict_types=1);

namespace App\Presentation\Admin\Competition;

use App\Domain\Competition\Entity\Competition;
use App\Domain\Competition\Entity\Competitor;
use App\Domain\Competition\Entity\FinalPoints;
use App\Infrastructure\Domain\Competition\Repository\CompetitionRepository;
use App\Infrastructure\Domain\Competition\Repository\CompetitorRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\CrudAutocompleteType;

class FinalPointsController extends AbstractCrudController
{
    private CompetitorRepository $competitorRepository;
    private CompetitionRepository $competitionRepository;

    public function __construct(
        CompetitorRepository $competitorRepository,
        CompetitionRepository $competitionRepository
    )
    {
        $this->competitorRepository = $competitorRepository;
        $this->competitionRepository = $competitionRepository;
    }

    public static function getEntityFqcn(): string
    {
        return FinalPoints::class;
    }


    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('competition');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('competitor')
                ->autocomplete()
                ->setFormType(CrudAutocompleteType::class)
                ->setFieldFqcn(Competitor::class),
            AssociationField::new('competition')
                ->autocomplete()
                ->setFormType(CrudAutocompleteType::class)
                ->setFieldFqcn(Competition::class),
            NumberField::new('finalPoints'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function createEntity(string $entityFqcn): FinalPoints
    {
        return new FinalPoints(
            $this->competitorRepository->getAny(),
            $this->competitionRepository->getOneOrCreateDefault(),
            0
        );
    }
}
