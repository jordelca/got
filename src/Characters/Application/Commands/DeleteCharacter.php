<?php

namespace App\Characters\Application\Commands;

use App\Characters\Domain\CharacterRepositoryInterface;
use App\Characters\Domain\ValueObjects\CharacterId;

class DeleteCharacter
{
    public function __construct(public readonly CharacterRepositoryInterface $characterRepository)
    {
    }

    public function handle(
        CharacterId $characterId,
    ): void {
        $this->characterRepository->delete($characterId);
    }
}
