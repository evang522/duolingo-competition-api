<?php

declare(strict_types=1);

namespace App\Presentation\ApiDocs;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class SwaggerController extends AbstractController
{
    public function schemaAction() : JsonResponse
    {
        return $this->json($this->getSchema());
    }

    public function uiAction() : Response
    {
        $spec = $this->getSchema();
        $spec = \json_encode($spec, JSON_THROW_ON_ERROR | \JSON_UNESCAPED_SLASHES | \JSON_HEX_TAG, 512);

        return $this->render('api/swagger.html.twig', ['spec' => $spec]);
    }

    /**
     * @return mixed[]
     */
    private function getSchema() : array
    {
        $schemaFile = $this->getParameter('kernel.project_dir') . '/app/docs/swagger.json';

        $swagger = \file_get_contents($schemaFile);
        if ($swagger === false) {
            throw new \RuntimeException('Could not find swagger definition file.');
        }

        return \json_decode($swagger, true);
    }
}
