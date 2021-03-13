<?php

declare(strict_types=1);

namespace App\Presentation\Admin\Competition;

use App\Domain\Competition\Entity\Host;
use App\Infrastructure\Domain\Competition\Repository\CompetitionRepository;
use App\Infrastructure\Duolingo\Model\Credentials;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class HostController extends AbstractCrudController
{
    private CompetitionRepository $competitionRepository;
    private AdminUrlGenerator $urlGenerator;

    public function __construct(
        CompetitionRepository $competitionRepository,
        AdminUrlGenerator $urlGenerator
    ) {
        $this->competitionRepository = $competitionRepository;
        $this->urlGenerator          = $urlGenerator;
    }

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
            Field::new('emailAddress'),
            Field::new('id')
                ->hideOnForm()
                ->setTemplatePath('/field/uuid.html.twig'),
            Field::new('credentials.authToken', 'Duolingo Token'),
        ];
    }

    public function createEntity(string $entityFqcn): Host
    {
        return new Host(
            'host@host.com',
            new Credentials('null'),
        );
    }

    public function delete(AdminContext $context)
    {
        $entity = $context->getEntity();

        if ($this->competitionRepository->hostConnectedToCompetitions($entity->getInstance()->id())) {
            $this->addFlash('danger', 'Cannot delete Host as it is connected to existing competitions.');

            return $this->redirect(
                $this->urlGenerator
                    ->setAction('index')
                    ->setController(self::class)
                    ->generateUrl()
            );
        }

        return parent::delete($context);
    }
}
