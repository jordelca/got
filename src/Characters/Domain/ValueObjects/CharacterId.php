<?php

namespace App\Characters\Domain\ValueObjects;

use Symfony\Component\Uid\Uuid;

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
        return new self(Uuid::v4());
    }
}
