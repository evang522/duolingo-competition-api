<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Competition\Service\Serializer;

use App\Domain\Competition\Entity\Competition;

class CompetitionSerializer
{
    public function winnerId(Competition $competition): ?string
    {
        if ($competition->winner() === null) {
            return null;
        }

        return $competition->winner()->duolingoId();
    }
}
