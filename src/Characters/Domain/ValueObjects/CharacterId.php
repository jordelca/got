<?php

namespace App\Characters\Domain\ValueObjects;

class CharacterId
{
    private function __construct(public readonly string $id)
    {
    }

    public static function fromString(string $id): self
    {
        return new self($id);
    }

    public static function generate(): self
    {
        return new self(sprintf('ch%07d', rand(0, 999999)));
    }
}
