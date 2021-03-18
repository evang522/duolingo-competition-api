<?php

declare(strict_types=1);


namespace App\FixtureBuilder\Competition;

use App\Domain\Competition\Entity\Competitor;

class CompetitorBuilder
{
    private Competitor $competitor;

    public function __construct()
    {
        $this->competitor = new Competitor(
            'Competitor username',
            'https://profilepic.com',
            'de',
            'Duolingo ID',
            1000,
            1
        );
    }

    public static function forIdentifier(int $identifier): self
    {
        $self = new self();
        $self->withDuolingoId($self->competitor->duolingoId() . ' ' . $identifier);
        $self->withDuolingoUserName($self->competitor->username() . ' ' . $identifier);
        $self->withTotalPoints($identifier);
        $self->withStreak($identifier);

        return $self;
    }

    public function withDuolingoId(string $duolingoId): self
    {
        $this->competitor->setDuolingoId($duolingoId);
        return $this;
    }

    public function withDuolingoUserName(string $username): self
    {
        $this->competitor->setUsername($username);

        return $this;
    }

    public function withTotalPoints(int $points): self
    {
        $this->competitor->setTotalPoints($points);

        return $this;
    }

    public function withStreak(int $streak): self
    {
        $this->competitor->setStreak($streak);

        return $this;
    }

    public function withProfilePictureUrl(string $url): self
    {
        $this->competitor->setProfilePhotoUrl($url);

        return $this;
    }

    public function build(): Competitor
    {
        return $this->competitor;
    }
}
