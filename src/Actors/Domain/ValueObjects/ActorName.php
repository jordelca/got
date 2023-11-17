<?php

namespace App\Actors\Domain\ValueObjects;

class ActorName
{
    private function __construct(public readonly string $name)
    {
    }

    public static function fromString(string $name): self
    {
        return new self($name);
    }
}
