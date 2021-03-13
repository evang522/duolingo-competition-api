<?php

declare(strict_types=1);

namespace App\Presentation;

use App\Domain\Competition\Entity\Competition;
use App\Infrastructure\Bus\CommandBus\CommandBus;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PlaygroundController
{
    private EntityManagerInterface $em;
    private CommandBus $commandBus;
    private ViewHandlerInterface $viewHandler;

    public function __construct(
        EntityManagerInterface $em,
        CommandBus $commandBus,
        ViewHandlerInterface $viewHandler
    ) {
        $this->em          = $em;
        $this->commandBus  = $commandBus;
        $this->viewHandler = $viewHandler;
    }

    public function __invoke(Request $request): Response
    {
        $repo        = $this->em->getRepository(Competition::class);
        $competition = $repo->findOneBy([]);

        return $this->viewHandler->handle(View::create($competition));
    }
}
