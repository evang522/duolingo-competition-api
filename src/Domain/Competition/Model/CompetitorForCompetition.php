<?php

declare(strict_types=1);


namespace App\Domain\Competition\Model;


class CompetitorForCompetition
{
    private string $competitionId;
    private string $duolingoUserName;
    private int $competitionPoints;
    private string $profilePhotoUrl;
    private string $duolingoUserId;

    public function __construct(
        string $competitionId,
        string $duolingoUserName,
        string $duolingoUserId,
        int $competitionPoints,
        string $profilePhotoUrl
    )
    {
        $this->competitionId = $competitionId;
        $this->duolingoUserName = $duolingoUserName;
        $this->duolingoUserId = $duolingoUserId;
        $this->competitionPoints = $competitionPoints;
        $this->profilePhotoUrl = $profilePhotoUrl;
    }

    public function competitionId(): string
    {
        return $this->competitionId;
    }

    public function duolingoUserName(): string
    {
        return $this->duolingoUserName;
    }

    public function CompetitionPoints(): int
    {
        return $this->competitionPoints;
    }

    public function ProfilePhotoUrl(): string
    {
        return $this->profilePhotoUrl;
    }

    public function DuolingoUserId(): string
    {
        return $this->duolingoUserId;
    }
}
