<?php

declare(strict_types=1);

namespace App\Presentation;

use App\Domain\Competition\Entity\Competitor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PlaygroundController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(
        EntityManagerInterface $em
    ) {
        $this->em = $em;
    }

    public function __invoke(Request $request): Response
    {
        $repo = $this->em->getRepository(Competitor::class);

        $competitor = new Competitor('Bob bla', null, 'German', 'hahaha', 111, 111);

        $this->em->persist($competitor);
        $this->em->flush();
        \dd($repo->find($competitor->id()->asString()));

        return new Response('hi');
    }
}
