<?php

declare(strict_types=1);

namespace App\Tests\Presentation\Rest\Competition\Controller;

use App\FixtureBuilder\Loaders\UuidLoader;
use Speicher210\FunctionalTestBundle\Test\RestControllerWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class GetCompetitionControllerTest extends RestControllerWebTestCase
{
    public function testReturns404WhenNotFound(): void
    {
        $this->assertRestGetPath('/api/competition/' . UuidLoader::forIdentifier(1), [], Response::HTTP_NOT_FOUND);
    }

    public function testReturns200WithFullData(): void
    {
        $this->assertRestGetPath('/api/competition/' . UuidLoader::forIdentifier(1));
    }
}
