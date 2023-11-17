<?php

namespace App\Characters\Application\Queries;

use App\Characters\Infrastructure\Services\CharacterService;

class SearchCharacters
{
    public function __construct(public readonly CharacterService $characterService)
    {
    }

    public function handle(
        string $key,
    ): array {
        return $this->characterService->search($key);
    }
}
