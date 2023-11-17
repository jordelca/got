<?php

namespace App\Characters\Domain\ValueObjects;

class CharacterLink
{
    private function __construct(public readonly string $link)
    {
    }

    public static function fromString(string $link): self
    {
        return new self($link);
    }
}
