<?php

declare(strict_types=1);


namespace App\Presentation\Rest\Competition\Controller;


use App\Domain\Competition\Entity\CompetitionId;
use App\Infrastructure\Domain\Competition\Repository\CompetitionRepository;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetCompetitionController extends AbstractController
{
    private CompetitionRepository $competitionRepository;
    private ViewHandlerInterface $viewHandler;

    public function __construct(
        CompetitionRepository $competitionRepository,
        ViewHandlerInterface $viewHandler
    )
    {
        $this->competitionRepository = $competitionRepository;
        $this->viewHandler = $viewHandler;
    }

    public function __invoke(Request $request): Response
    {
        $id = CompetitionId::fromString($request->get('id'));

        $competition = $this->competitionRepository->get($id);

        return $this->viewHandler->handle(View::create($competition, Response::HTTP_OK));
    }
}
