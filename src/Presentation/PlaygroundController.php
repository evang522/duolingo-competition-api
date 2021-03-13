<?php

declare(strict_types=1);

namespace App\Presentation;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PlaygroundController
{
    public function __construct()
    {
    }

    public function __invoke(Request $request): Response
    {
        return new Response('Playground');
    }
}
