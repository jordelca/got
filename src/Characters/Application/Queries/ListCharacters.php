<?php

namespace App\Characters\Application\Queries;

use App\Characters\Infrastructure\Services\CharacterService;

class ListCharacters
{
    public function __construct(public readonly CharacterService $characterService)
    {
    }

    public function handle(): array
    {
        return $this->characterService->list();
    }
}
