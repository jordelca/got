<?php

namespace App\Characters\Domain\ValueObjects;

class CharacterAllies
{
    private function __construct(public readonly array $alliesIds)
    {
    }

    public static function fromArray(array $alliesIds): self
    {
        return new self($alliesIds);
    }

    public static function empty(): self
    {
        return new self([]);
    }
}
