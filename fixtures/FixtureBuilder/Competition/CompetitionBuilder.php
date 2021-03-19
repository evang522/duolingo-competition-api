<?php

declare(strict_types=1);


namespace App\FixtureBuilder\Competition;


use App\Domain\Competition\Entity\Competition;
use App\Domain\Competition\Entity\Competitor;
use App\Domain\Competition\Entity\Host;
use App\FixtureBuilder\Loaders\UuidLoader;
use App\Infrastructure\Duolingo\Model\Credentials;

class CompetitionBuilder
{
    private Competition $competition;

    public function __construct()
    {
        $this->competition = new Competition(
            new \DateTimeImmutable('2050-08-16'),
            new \DateTimeImmutable('2050-08-26'),
            'Default Competition',
            new Host('Default Host', new Credentials('authToken')),
            null,
        );
    }


    public static function forIdentifier(int $identifier): self
    {
        $self = new self();
        $self->withName($self->competition . (string)$identifier);
        $self->withId(UuidLoader::forIdentifier($identifier));

        return $self;
    }

    public function withName(string $name): self
    {
        $this->competition->setName($name);

        return $this;
    }

    public function withId(string $id): self
    {
        $this->competition->setIdFromString($id);

        return $this;
    }

    public function withDescription(string $description): self
    {
        $this->competition->setDescription($description);

        return $this;
    }

    public function withCompetitor(Competitor $competitor): self
    {
        $this->competition->addCompetitor($competitor);
        return $this;
    }

    public function withStartDate(\DateTimeImmutable $startDate): self
    {
        $this->competition->setStartDate($startDate);

        return $this;
    }

    public function withEndDate(\DateTimeImmutable $endDate): self
    {
        $this->competition->setEndDate($endDate);

        return $this;
    }

    public function withHost(Host $host): self
    {
        $this->competition->setHost($host);

        return $this;
    }

    public function build(): Competition
    {
        return $this->competition;
    }

}
