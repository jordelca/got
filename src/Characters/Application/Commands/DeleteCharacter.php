<?php

namespace App\Characters\Application\Commands;

use App\Characters\Domain\ValueObjects\CharacterId;
use App\Characters\Infrastructure\Services\CharacterService;

class DeleteCharacter
{
    public function __construct(public readonly CharacterService $characterService)
    {
    }

    public function handle(
        CharacterId $characterId,
    ): void {
        $this->characterService->delete(
            $characterId,
        );
    }
}
