<?php

namespace App\Characters\Application\Commands;

use App\Characters\Domain\Entity\Character;
use App\Characters\Infrastructure\Services\CharacterService;

class CreateCharacter
{
    public function __construct(public readonly CharacterService $characterService)
    {
    }

    public function handle(
        Character $character,
    ): void {
        $this->characterService->create(
            $character,
        );
    }
}
