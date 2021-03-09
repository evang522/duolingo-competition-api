<?php

declare(strict_types=1);

namespace App\Infrastructure\Duolingo\Service;

use Http\Client\HttpClient;

class Client
{
    private HttpClient $httpClient;

    public function __construct(
        HttpClient $httpClient
    ) {
        $this->httpClient = $httpClient;
    }
}
