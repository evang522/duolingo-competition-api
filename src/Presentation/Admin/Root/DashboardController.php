<?php

declare(strict_types=1);

namespace App\Presentation\Admin\Root;

use App\Domain\Competition\Entity\Competition;
use App\Domain\Competition\Entity\Competitor;
use App\Domain\Competition\Entity\Host;
use App\Presentation\Admin\Competition\CompetitionController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends AbstractDashboardController
{
    private AdminUrlGenerator $adminUrlGenerator;

    public function __construct(
        AdminUrlGenerator $adminUrlGenerator
    )
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Duolingo Competitions Admin');
    }

    public function index(): Response
    {
        return $this->redirect(
            $this->adminUrlGenerator
                ->setController(CompetitionController::class)
                ->setAction('index')
                ->generateUrl()
        );
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Home'),
            MenuItem::section('Competition'),
            MenuItem::linkToCrud('Competitions', 'fa fa-flag', Competition::class),
            MenuItem::linkToCrud('Participants', 'fa fa-running', Competitor::class),
            MenuItem::linkToCrud('Hosts', 'fa fa-user', Host::class),
        ];
    }
}
