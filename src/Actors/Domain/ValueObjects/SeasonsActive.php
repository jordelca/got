<?php

namespace App\Actors\Domain\ValueObjects;

class SeasonsActive
{
    private function __construct(public readonly array $seasonIds)
    {
    }

    public static function fromArray(array $seasonIds): self
    {
        return new self($seasonIds);
    }
}
