<?php

declare(strict_types=1);

namespace App\Presentation\Rest\Competition\Controller;

use App\Infrastructure\Domain\Competition\Repository\CompetitionRepository;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ListCompetitionsController extends AbstractController
{
    private CompetitionRepository $competitionRepository;
    private ViewHandlerInterface $viewHandler;

    public function __construct(
        CompetitionRepository $competitionRepository,
        ViewHandlerInterface $viewHandler
    ) {
        $this->competitionRepository = $competitionRepository;
        $this->viewHandler           = $viewHandler;
    }

    public function __invoke(Request $request): Response
    {
        $competitions = $this->competitionRepository->findAll();

        $view = View::create($competitions);

        $view->getContext()->setGroups(['competition-listing']);

        return $this->viewHandler->handle($view);
    }
}
