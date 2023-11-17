<?php

namespace App\Characters\Application\Commands;

use App\Characters\Domain\CharacterRepositoryInterface;
use App\Characters\Domain\Entity\Character;

class CreateCharacter
{
    public function __construct(public readonly CharacterRepositoryInterface $characterRepository)
    {
    }

    public function handle(
        Character $character,
    ): void {
        $this->characterRepository->create(
            $character,
        );
    }
}