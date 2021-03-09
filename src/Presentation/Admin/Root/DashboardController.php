<?php

declare(strict_types=1);

namespace App\Presentation\Admin\Root;

use App\Domain\Competition\Entity\Competition;
use App\Domain\Competition\Entity\Competitor;
use App\Domain\Competition\Entity\Host;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Duolingo Competitions Admin');
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
