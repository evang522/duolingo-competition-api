<?php

declare(strict_types=1);


namespace App\Presentation\Example;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ExampleController extends AbstractController
{
    public function exampleAction(Request $request): Response
    {

        $responses = [
            'You\'re awesome!',
            'Example text',
            'Bla!',
            'Isn\'t it an amazing thing to be able to code?',
            'Truth is not as simple as you probably think.',
            'Keep refreshing the page man'
        ];

        return new JsonResponse([
            'message' => $responses[array_rand($responses)],
        ]);

    }
}
