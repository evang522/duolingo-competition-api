<?php

declare(strict_types=1);

namespace App\Domain\User\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

class AdminUser implements UserInterface
{
    private string $id;
    private ?string $plainTextPassword;
    private string $encryptedPassword;
    private string $email;

    public function __construct()
    {
        $this->id = AdminUserId::generate()->asString();
    }

    public function getEncryptedPassword(): string
    {
        return $this->encryptedPassword;
    }

    public function setEncryptedPassword(string $encryptedPassword): void
    {
        $this->encryptedPassword = $encryptedPassword;
    }

    public function plainTextPassword(): ?string
    {
        return $this->plainTextPassword;
    }

    public function setPlainTextPassword(?string $password): void
    {
        $this->plainTextPassword = $password;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getId(): AdminUserId
    {
        return AdminUserId::fromString($this->id);
    }

    public function eraseCredentials(): void
    {
        $this->plainTextPassword = null;
    }

    public function getPassword(): string
    {
        return $this->encryptedPassword;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER', 'ROLE_ADMIN'];
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getUsername(): string
    {
        return $this->email;
    }
}
