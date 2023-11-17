<?php

namespace App\Characters\Application\Queries;

use App\Characters\Domain\CharacterRepositoryInterface;

class ListCharacters
{
    public function __construct(public readonly CharacterRepositoryInterface $characterRepository)
    {
    }

    public function handle(): array
    {
        return $this->characterRepository->list();
    }
}
