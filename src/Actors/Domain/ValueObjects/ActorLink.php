<?php

namespace App\Actors\Domain\ValueObjects;

class ActorLink
{
    private function __construct(public readonly string $link)
    {
    }

    public static function fromString(string $link): self
    {
        return new self($link);
    }
}
