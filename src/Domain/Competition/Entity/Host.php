<?php

declare(strict_types=1);

namespace App\Domain\Competition\Entity;

use App\Infrastructure\Duolingo\Model\Credentials;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Host
{
    private string $id;
    private Credentials $credentials;
    private Collection $competitions;
    private string $emailAddress;

    public function __construct(
        string $emailAddress,
        Credentials $credentials
    ) {
        $this->id           = HostId::generate()->asString();
        $this->credentials  = $credentials;
        $this->competitions = new ArrayCollection();
        $this->emailAddress = $emailAddress;
    }

    public function setCredentials(Credentials $credentials): void
    {
        $this->credentials = $credentials;
    }

    public function setCompetitions($competitions): void
    {
        $this->competitions = $competitions;
    }

    public function setEmailAddress(string $emailAddress): void
    {
        $this->emailAddress = $emailAddress;
    }

    public function id(): HostId
    {
        return HostId::fromString($this->id);
    }

    public function competitions()
    {
        return $this->competitions;
    }

    public function __toString(): string
    {
        return $this->emailAddress;
    }

    public function emailAddress(): string
    {
        return $this->emailAddress;
    }

    public function credentials(): Credentials
    {
        return $this->credentials;
    }
}
