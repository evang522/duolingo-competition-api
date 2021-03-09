<?php

declare(strict_types=1);


namespace App\Domain\Competition\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Competitor
{
    private string $id;
    private string $username;
    private ?string $profilePhotoUrl;
    private string $currentLanguage;
    private string $duolingoId;
    private int $totalPoints;
    private Collection $competitions;

    public function __construct(
        string $username,
        ?string $profilePhotoUrl,
        string $currentLanguage,
        string $duolingoId,
        int $totalPoints
    )
    {
        $this->username = $username;
        $this->profilePhotoUrl = $profilePhotoUrl;
        $this->currentLanguage = $currentLanguage;
        $this->duolingoId = $duolingoId;
        $this->totalPoints = $totalPoints;
        $this->competitions = new ArrayCollection();
    }

    public function id(): CompetitorId
    {
        return CompetitorId::fromString($this->id);
    }

    public function username(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): Competitor
    {
        $this->username = $username;
        return $this;
    }

    public function profilePhotoUrl(): ?string
    {
        return $this->profilePhotoUrl;
    }

    public function setProfilePhotoUrl(?string $profilePhotoUrl): Competitor
    {
        $this->profilePhotoUrl = $profilePhotoUrl;
        return $this;
    }

    public function currentLanguage(): string
    {
        return $this->currentLanguage;
    }

    public function setCurrentLanguage(string $currentLanguage): Competitor
    {
        $this->currentLanguage = $currentLanguage;
        return $this;
    }

    public function duolingoId(): string
    {
        return $this->duolingoId;
    }

    public function setDuolingoId(string $duolingoId): Competitor
    {
        $this->duolingoId = $duolingoId;
        return $this;
    }

    public function totalPoints(): int
    {
        return $this->totalPoints;
    }

    public function setTotalPoints(int $totalPoints): Competitor
    {
        $this->totalPoints = $totalPoints;
        return $this;
    }
}
