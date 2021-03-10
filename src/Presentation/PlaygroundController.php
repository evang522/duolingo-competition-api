<?php

declare(strict_types=1);

namespace App\Presentation;

use App\Domain\Competition\Command\UpdateCompetitionParticipants;
use App\Domain\Competition\Command\UpdateCompetitorStats;
use App\Domain\Competition\Entity\Competition;
use App\Domain\Competition\Entity\CompetitionId;
use App\Domain\Competition\Entity\Competitor;
use App\Infrastructure\Bus\CommandBus\CommandBus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PlaygroundController extends AbstractController
{
    private EntityManagerInterface $em;
    private CommandBus $commandBus;

    public function __construct(
        EntityManagerInterface $em,
        CommandBus $commandBus
    ) {
        $this->em         = $em;
        $this->commandBus = $commandBus;
    }

    public function __invoke(Request $request): Response
    {
        $repo = $this->em->getRepository(Competition::class);

        $competition = $repo->get(CompetitionId::fromString('d383b2f6-7d73-413e-a6e3-3c0e85b53f4e'));

        $this->commandBus->handle(new UpdateCompetitionParticipants($competition->id()));
        dd('hi');
        return new Response('hi');
    }
}
