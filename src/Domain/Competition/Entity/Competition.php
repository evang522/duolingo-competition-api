<?php

declare(strict_types=1);

namespace App\Domain\Competition\Entity;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Competition
{
    private string $id;

    private DateTimeImmutable $startDate;

    private DateTimeImmutable $endDate;

    private ?DateTimeImmutable $updatedAt;

    private string $name;

    /** @var Collection|BasePoints[] */
    private Collection $basePoints;

    /** @var Collection|Competitor[] */
    private Collection $competitors;

    private Host $host;

    private ?Competitor $winner;

    private ?string $description;

    private bool $public;

    public function __construct(
        DateTimeImmutable $startDate,
        DateTimeImmutable $endDate,
        string $name,
        Host $host,
        ?string $description,
        ?Competitor $winner = null
    ) {
        $this->id          = CompetitionId::generate()->asString();
        $this->startDate   = $startDate;
        $this->endDate     = $endDate;
        $this->name        = $name;
        $this->basePoints  = new ArrayCollection();
        $this->competitors = new ArrayCollection();
        $this->host        = $host;
        $this->winner      = $winner;
        $this->description = $description;
        $this->updatedAt   = null;
        $this->public      = true;
    }

    public function updatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function description(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function isPublic(): bool
    {
        return $this->public;
    }

    public function setPublic(bool $public): void
    {
        $this->public = $public;
    }

    public function winner(): ?Competitor
    {
        return $this->winner;
    }

    public function setWinner(?Competitor $winner): void
    {
        $this->winner = $winner;
    }

    public function setIdFromString(string $id): void
    {
        $this->id = $id;
    }

    public function id(): CompetitionId
    {
        return CompetitionId::fromString($this->id);
    }

    public function startDate(): DateTimeImmutable
    {
        return $this->startDate;
    }

    public function setStartDate(DateTimeImmutable $startDate): Competition
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function endDate(): DateTimeImmutable
    {
        return $this->endDate;
    }

    public function setEndDate(DateTimeImmutable $endDate): Competition
    {
        $this->endDate = $endDate;

        return $this;
    }

    /** @return Collection|BasePoints[] */
    public function basePoints(): Collection
    {
        return $this->basePoints;
    }

    /** @param Collection|BasePoints[] $basePoints */
    public function setBasePoints(Collection $basePoints): Competition
    {
        $this->basePoints = $basePoints;

        return $this;
    }

    public function addCompetitor(Competitor $competitor): void
    {
        $this->competitors->add($competitor);
    }

    /** @return Collection|Competitor[] */
    public function competitors(): Collection
    {
        return $this->competitors;
    }

    /** @param Collection|Competitor[] $competitors */
    public function setCompetitors(Collection $competitors): Competition
    {
        $this->competitors = $competitors;

        return $this;
    }

    public function host(): Host
    {
        return $this->host;
    }

    public function setHost(Host $host): Competition
    {
        $this->host = $host;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name();
    }

    public function name(): string
    {
        return $this->name;
    }

    public function setName(string $name): Competition
    {
        $this->name = $name;

        return $this;
    }

    public function competitorCount(): int
    {
        return $this->competitors->count();
    }
}
