<?php

namespace App\Characters\Infrastructure\Repository;

use App\Actors\Infrastructure\Entity\Actor;
use App\Characters\Domain\CharacterRepositoryInterface;
use App\Characters\Domain\ValueObjects\CharacterActors;
use App\Characters\Domain\ValueObjects\CharacterId;
use App\Characters\Domain\ValueObjects\CharacterName;
use App\Characters\Domain\ValueObjects\CharacterAllies;
use App\Characters\Infrastructure\Entity\Character;
use App\Characters\Domain\Entity\Character as DomainCharacter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

class CharacterRepository implements CharacterRepositoryInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function create(
        DomainCharacter $character,
    ): void {
        if (! $this->existsByName($character->characterName)) {
            $doctrineCharacter = new Character();
            $doctrineCharacter->setId($character->characterId->id);

            $this->entityManager->persist($this->setProperties($doctrineCharacter, $character));
            $this->entityManager->flush();
        }
    }

    public function list(): array
    {
        return $this->entityManager->createQueryBuilder()
            ->select('c')
            ->from(Character::class, 'c')
            ->getQuery()->getResult();
    }

    public function existsByName(
        CharacterName $characterName,
    ): bool {
        return (bool) $this->entityManager
            ->getRepository(Character::class)
            ->findOneBy(['name' => $characterName->name]);
    }

    public function update(DomainCharacter $character): void
    {
        $doctrineCharacter = $this->entityManager->find(Character::class, $character->characterId->id);
        $doctrineCharacter = $this->setProperties($doctrineCharacter, $character);
        $doctrineCharacter = $this->setAllies($doctrineCharacter, $character->allies);
        $doctrineCharacter = $this->setActors($doctrineCharacter, $character->actors);

        $this->entityManager->persist($doctrineCharacter);
        $this->entityManager->flush();
    }

    public function delete(CharacterId $characterId): void
    {
        $doctrineCharacter = $this->entityManager->find(Character::class, $characterId->id);

        $this->entityManager->remove($doctrineCharacter);
        $this->entityManager->flush();
    }

    public function setProperties(Character $doctrineCharacter, DomainCharacter $character): Character
    {
        $doctrineCharacter->setName($character->characterName->name);
        $doctrineCharacter->setNickname($character->characterNickname->name);
        $doctrineCharacter->setLink($character->characterLink->link);
        $doctrineCharacter->setRoyal($character->royal);
        $doctrineCharacter->setKingsguard($character->kingsguard);
        $doctrineCharacter->setHouses($character->houses);
        if ($character->imageThumb) {
            $doctrineCharacter->setImageThumb($character->imageThumb->link);
        }
        if ($character->imageFull) {
            $doctrineCharacter->setImageFull($character->imageFull->link);
        }

        return $doctrineCharacter;
    }

    public function setAllies(Character $doctrineCharacter, CharacterAllies $allies): Character
    {
        $doctrineCharacter->setAllies(
            new ArrayCollection($this->entityManager->getRepository(Character::class)
                ->findBy(['id' => $allies->alliesIds])),
        );

        return $doctrineCharacter;
    }

    public function setActors(Character $doctrineCharacter, CharacterActors $actors): Character
    {
        $doctrineCharacter->setActors(
            new ArrayCollection($this->entityManager->getRepository(Actor::class)
                ->findBy(['id' => $actors->actorsIds])),
        );

        return $doctrineCharacter;
    }
}
