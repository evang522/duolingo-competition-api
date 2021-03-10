<?php

declare(strict_types=1);

namespace App\Infrastructure\Duolingo\Model;

class Credentials
{
    private string $username;
    private string $password;
    private ?string $authToken;

    public function __construct(
        string $username,
        string $password,
        ?string $authToken
    )
    {
        $this->username = $username;
        $this->password = $password;
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

    public function username(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): Credentials
    {
        $this->username = $username;
        return $this;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): Credentials
    {
        $this->password = $password;
        return $this;
    }
}
