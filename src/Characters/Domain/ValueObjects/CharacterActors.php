<?php

namespace App\Characters\Domain\ValueObjects;

class CharacterActors
{
    private function __construct(public readonly array $actorsIds)
    {
    }

    public static function fromArray(array $actorsIds): self
    {
        return new self($actorsIds);
    }

    public static function empty(): self
    {
        return new self([]);
    }
}
