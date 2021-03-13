<?php

declare(strict_types=1);

namespace App\Infrastructure\Duolingo\Model;

class UserInformation
{
    private string $duoUsername;
    private int $totalPoints;
    private string $profilePhotoUrl;
    private string $currentLanguage;

    public function __construct(
        string $duoUsername,
        int $totalPoints,
        string $profilePhotoUrl,
        string $currentLanguage
    ) {
        $this->duoUsername     = $duoUsername;
        $this->totalPoints     = $totalPoints;
        $this->profilePhotoUrl = $profilePhotoUrl;
        $this->currentLanguage = $currentLanguage;
    }

    public function duoUsername(): string
    {
        return $this->duoUsername;
    }

    public function totalPoints(): int
    {
        return $this->totalPoints;
    }

    public function profilePhotoUrl(): string
    {
        return $this->profilePhotoUrl;
    }

    public function currentLanguage(): string
    {
        return $this->currentLanguage;
    }
}
