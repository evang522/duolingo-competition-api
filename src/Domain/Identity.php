<?php

declare(strict_types=1);

namespace App\Domain;

interface Identity
{
    /**
     * @return mixed
     */
    public static function generate();

    /**
     * @return mixed
     */
    public static function fromString(string $uuid);

    public function asString(): string;

    public function equals(self $other): bool;

    public function __toString(): string;
}
