<?php

namespace App\Characters\Domain\Events;

use App\Characters\Domain\ValueObjects\CharacterId;

final class CharacterDeleted
{
    public function __construct(public readonly string $characterId)
    {
    }

    public static function new(CharacterId $characterId): self
    {
        return new self($characterId->id);
    }
}
