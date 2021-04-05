<?php

declare(strict_types=1);

namespace App\Presentation\Admin\Competition;

use App\Domain\Competition\Entity\BasePoints;
use App\Domain\Competition\Entity\Competition;
use App\Domain\Competition\Entity\Competitor;
use App\Infrastructure\Domain\Competition\Repository\CompetitionRepository;
use App\Infrastructure\Domain\Competition\Repository\CompetitorRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\CrudAutocompleteType;

class BasePointsController extends AbstractCrudController
{
    private CompetitorRepository $competitorRepository;
    private CompetitionRepository $competitionRepository;

    public function __construct(
        CompetitorRepository $competitorRepository,
        CompetitionRepository $competitionRepository
    ) {
        $this->competitorRepository  = $competitorRepository;
        $this->competitionRepository = $competitionRepository;
    }

    public static function getEntityFqcn(): string
    {
        return BasePoints::class;
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
            NumberField::new('basePoints'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function createEntity(string $entityFqcn): BasePoints
    {
        return new BasePoints(
            $this->competitorRepository->getAny(),
            $this->competitionRepository->getOneOrCreateDefault(),
            0
        );
    }
}
