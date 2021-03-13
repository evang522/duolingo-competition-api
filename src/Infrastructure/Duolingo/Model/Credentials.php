<?php

declare(strict_types=1);

namespace App\Infrastructure\Duolingo\Model;

class Credentials
{
    private ?string $authToken;

    public function __construct(
        string $authToken
    ) {
        $this->authToken = $authToken;
    }

    public function authToken(): ?string
    {
        return $this->authToken;
    }

    public function setAuthToken(?string $authToken): Credentials
    {
        $this->authToken = $authToken;

        return $this;
    }
}
