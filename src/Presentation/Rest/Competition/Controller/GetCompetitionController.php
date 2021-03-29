<?php

declare(strict_types=1);

namespace App\Presentation\Rest\Competition\Controller;

use App\Domain\Competition\Command\UpdateCompetitionParticipants;
use App\Domain\Competition\Entity\CompetitionId;
use App\Infrastructure\Bus\CommandBus\CommandBus;
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
    private CommandBus $commandBus;

    public function __construct(
        CompetitionRepository $competitionRepository,
        ViewHandlerInterface $viewHandler,
        CommandBus $commandBus
    ) {
        $this->competitionRepository = $competitionRepository;
        $this->viewHandler           = $viewHandler;
        $this->commandBus            = $commandBus;
    }

    public function __invoke(Request $request): Response
    {
        $id = CompetitionId::fromString($request->get('id'));

        $competition = $this->competitionRepository->get($id);

        $updatedAt = $competition->updatedAt();

        if ($updatedAt === null || (new \DateTimeImmutable())->getTimestamp() - $updatedAt->getTimestamp() >= 600) {
            $this->commandBus->handle(new UpdateCompetitionParticipants($competition->id()));
            $competition = $this->competitionRepository->get($competition->id());

            return $this->viewHandler->handle(View::create($competition, Response::HTTP_OK));
        }

        return $this->viewHandler->handle(View::create($competition, Response::HTTP_OK));
    }
}
