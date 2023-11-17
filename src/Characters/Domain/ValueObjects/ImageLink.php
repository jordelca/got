<?php

namespace App\Characters\Domain\ValueObjects;

class ImageLink
{
    private function __construct(public readonly string $link)
    {
    }

    public static function fromString(string $link): self
    {
        return new self($link);
    }
}
