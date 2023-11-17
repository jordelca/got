<?php

namespace App\Characters\Infrastructure\Services;

use App\Characters\Domain\Entity\Character;
use App\Characters\Domain\Events\CharacterCreated;
use App\Characters\Domain\Events\CharacterDeleted;
use App\Characters\Domain\Events\CharacterUpdated;
use App\Characters\Domain\ValueObjects\CharacterId;
use App\Characters\Infrastructure\Repository\CharacterRepository;
use FOS\ElasticaBundle\Finder\FinderInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class CharacterService
{
    public function __construct(
        private readonly MessageBusInterface $bus,
        private readonly CharacterRepository $characterRepository,
        private readonly FinderInterface $finder,
    ) {
    }

    public function list(
    ): array {
        return $this->characterRepository->list();
    }

    public function search(
        string $key,
    ): array {
        return $this->finder->find($key);
    }

    public function create(
        Character $character,
    ): void {
        $this->characterRepository->create($character);

        $this->bus->dispatch(CharacterCreated::new($character->characterId));
    }

    public function update(
        Character $character,
    ): void {
        $this->characterRepository->update($character);

        $this->bus->dispatch(CharacterUpdated::new($character->characterId));
    }

    public function delete(
        CharacterId $characterId,
    ): void {
        $this->characterRepository->delete($characterId);

        $this->bus->dispatch(CharacterDeleted::new($characterId));
    }
}
