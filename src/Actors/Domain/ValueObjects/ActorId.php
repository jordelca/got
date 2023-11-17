<?php

namespace App\Actors\Domain\ValueObjects;

class ActorId
{
    private function __construct(public readonly string $id)
    {
    }

    public static function fromString(string $id): self
    {
        return new self($id);
    }
}
