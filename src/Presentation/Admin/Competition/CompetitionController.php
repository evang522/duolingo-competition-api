<?php

declare(strict_types=1);

namespace App\Presentation\Admin\Competition;

use App\Domain\Competition\Entity\Competition;
use App\Domain\Competition\Entity\Competitor;
use App\Infrastructure\Domain\Competition\Repository\HostRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\CrudAutocompleteType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class CompetitionController extends AbstractCrudController
{
    private HostRepository $hostRepository;
    private string $baseUrl;
    private string $frontendBaseUrl;

    public function __construct(
        HostRepository $hostRepository,
        string $baseUrl,
        string $frontendBaseUrl
    )
    {
        $this->hostRepository = $hostRepository;
        $this->baseUrl = $baseUrl;
        $this->frontendBaseUrl = $frontendBaseUrl;
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
            Field::new('updatedAt'),
            TextEditorField::new('description'),
            AssociationField::new('winner')
                ->autocomplete()
                ->renderAsNativeWidget()
                ->setFormType(CrudAutocompleteType::class)
                ->setFieldFqcn(Competitor::class),
        ];
    }

    public function redirectToApiResource(AdminContext $adminContext): Response
    {
        $dto = $adminContext->getEntity();

        $entity = $dto->getInstance();
        \assert($entity instanceof Competition);

        return new RedirectResponse($this->baseUrl . '/api/competition/' . $entity->id()->asString());
    }

    public function redirectToFrontend(AdminContext $adminContext): Response
    {
        $dto = $adminContext->getEntity();

        $entity = $dto->getInstance();
        \assert($entity instanceof Competition);

        return new RedirectResponse($this->frontendBaseUrl . '?competition=' . $entity->id()->asString());
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions->add(Crud::PAGE_INDEX, Action::DETAIL);
        $actions->add(
            Crud::PAGE_DETAIL,
            Action::new('redirectToApiResource', false, 'fa fa-server')
                ->linkToCrudAction('redirectToApiResource')->addCssClass('btn')
        );
        $actions->add(
            Crud::PAGE_DETAIL,
            Action::new('redirectToFrontend', false, 'fa fa-eye')
                ->linkToCrudAction('redirectToFrontend')
                ->addCssClass('btn btn-secondary')
        );

        return $actions;
    }

    public function createEntity(string $entityFqcn): Competition
    {
        $host = $this->hostRepository->getOneOrCreateDefault();

        return new Competition(
            new \DateTimeImmutable(),
            new \DateTimeImmutable(),
            'New Competition',
            $host,
            null,
        );
    }
}
