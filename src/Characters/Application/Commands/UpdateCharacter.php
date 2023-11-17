<?php

namespace App\Characters\Application\Commands;

use App\Characters\Domain\Entity\Character;
use App\Characters\Infrastructure\Services\CharacterService;

class UpdateCharacter
{
    public function __construct(public readonly CharacterService $characterService)
    {
    }

    public function handle(
        Character $character,
    ): void {
        $this->characterService->update(
            $character,
        );
    }
}
