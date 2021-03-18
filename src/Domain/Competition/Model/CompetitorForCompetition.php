<?php

declare(strict_types=1);

namespace App\Domain\Competition\Model;

class CompetitorForCompetition
{
    private string $competitionId;
    private string $duolingoUserName;
    private int $competitionPoints;
    private string $duolingoUserId;
    private ?string $profilePhotoUrl;
    private string $currentLanguage;
    private int $streak;

    public function __construct(
        string $competitionId,
        string $duolingoUserName,
        string $duolingoUserId,
        int $competitionPoints,
        string $currentLanguage,
        ?string $profilePhotoUrl,
        int $streak
    ) {
        $this->competitionId     = $competitionId;
        $this->duolingoUserName  = $duolingoUserName;
        $this->duolingoUserId    = $duolingoUserId;
        $this->competitionPoints = $competitionPoints;
        $this->currentLanguage   = $currentLanguage;
        $this->profilePhotoUrl   = $profilePhotoUrl;
        $this->streak            = $streak;
    }

    public function streak(): int
    {
        return $this->streak;
    }

    public function competitionId(): string
    {
        return $this->competitionId;
    }

    public function duolingoUserName(): string
    {
        return $this->duolingoUserName;
    }

    public function competitionPoints(): int
    {
        return $this->competitionPoints;
    }

    public function profilePhotoUrl(): string
    {
        return $this->profilePhotoUrl;
    }

    public function duolingoUserId(): string
    {
        return $this->duolingoUserId;
    }

    public function currentLanguage(): string
    {
        return $this->currentLanguage;
    }
}
