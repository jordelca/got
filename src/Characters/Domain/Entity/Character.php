<?php

namespace App\Characters\Domain\Entity;

use App\Characters\Domain\ValueObjects\CharacterActors;
use App\Characters\Domain\ValueObjects\CharacterId;
use App\Characters\Domain\ValueObjects\CharacterLink;
use App\Characters\Domain\ValueObjects\CharacterName;
use App\Characters\Domain\ValueObjects\CharacterNickname;
use App\Characters\Domain\ValueObjects\CharacterAllies;
use App\Characters\Domain\ValueObjects\ImageLink;

class Character
{
    private function __construct(
        public readonly CharacterId $characterId,
        public readonly CharacterName $characterName,
        public readonly CharacterNickname $characterNickname,
        public readonly CharacterLink $characterLink,
        public readonly ImageLink|null $imageThumb,
        public readonly ImageLink|null $imageFull,
        public readonly CharacterAllies $allies,
        public readonly CharacterActors $actors,
        public readonly array $houses,
        public readonly bool $royal,
        public readonly bool $kingsguard,
    ) {
    }

    public static function new(
        CharacterId $characterId,
        CharacterName $characterName,
        CharacterNickname $characterNickname,
        CharacterLink $characterLink,
        ImageLink|null $imageThumb,
        ImageLink|null $imageFull,
        CharacterAllies $allies,
        CharacterActors $actors,
        array $houses,
        bool $royal,
        bool $kingsguard,
    ): self {
        return new self(
            $characterId,
            $characterName,
            $characterNickname,
            $characterLink,
            $imageThumb,
            $imageFull,
            $allies,
            $actors,
            $houses,
            $royal,
            $kingsguard,
        );
    }
}
