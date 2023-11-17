<?php

namespace App\Characters\Domain;

use App\Characters\Domain\Entity\Character as DomainCharacter;
use App\Characters\Domain\ValueObjects\CharacterId;
use App\Characters\Domain\ValueObjects\CharacterName;

interface CharacterRepositoryInterface
{
    public function existsByName(
        CharacterName $characterName,
    ): bool;

    public function create(
        DomainCharacter $character,
    ): void;

    public function update(
        DomainCharacter $character,
    ): void;

    public function delete(
        CharacterId $characterId,
    ): void;

    public function list(): array;
}
