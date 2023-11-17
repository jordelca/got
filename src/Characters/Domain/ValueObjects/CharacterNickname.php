<?php

namespace App\Characters\Domain\ValueObjects;

class CharacterNickname
{
    private function __construct(public readonly string $name)
    {
    }

    public static function fromString(string $name): self
    {
        return new self($name);
    }
}
