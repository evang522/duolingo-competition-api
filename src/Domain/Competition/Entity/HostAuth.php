<?php

declare(strict_types=1);

namespace App\Domain\Competition\Entity;

class HostAuth
{
    private string $id;

    private string $authToken;

    private Host $host;

    public function __construct(
        Host $host,
        string $authToken
    ) {
        $this->id        = HostAuthId::generate()->asString();
        $this->host      = $host;
        $this->authToken = $authToken;
    }

    public function host(): Host
    {
        return $this->host;
    }

    public function setHost(Host $host): HostAuth
    {
        $this->host = $host;

        return $this;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function setId(string $id): HostAuth
    {
        $this->id = $id;

        return $this;
    }

    public function authToken(): string
    {
        return $this->authToken;
    }

    public function setAuthToken(string $authToken): HostAuth
    {
        $this->authToken = $authToken;

        return $this;
    }
}
