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


    public function __construct(
        Credentials $credentials
    )
    {
        $this->id = HostId::generate()->asString();
        $this->credentials = $credentials;
        $this->competitions = new ArrayCollection();
    }

    public function id(): string
    {
        return $this->id;
    }

    public function credentials(): Credentials
    {
        return $this->credentials;
    }

    public function competitions()
    {
        return $this->competitions;
    }
}
