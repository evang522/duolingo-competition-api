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
    /** @var Competition[]|Collection */
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

    public function id(): HostId
    {
        return HostId::fromString($this->id);
    }

    /** @return Collection|Competition[] */
    public function competitions(): Collection
    {
        return $this->competitions;
    }

    /** @param Competition[]|Collection $competitions */
    public function setCompetitions(Collection $competitions): void
    {
        $this->competitions = $competitions;
    }

    public function __toString(): string
    {
        return $this->emailAddress;
    }

    public function emailAddress(): string
    {
        return $this->emailAddress;
    }

    public function setEmailAddress(string $emailAddress): void
    {
        $this->emailAddress = $emailAddress;
    }

    public function credentials(): Credentials
    {
        return $this->credentials;
    }

    public function setCredentials(Credentials $credentials): void
    {
        $this->credentials = $credentials;
    }
}
