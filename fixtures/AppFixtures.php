<?php

namespace DataFixtures;

use App\Actors\Application\Commands\CreateActor;
use App\Actors\Domain\Entity\Actor;
use App\Actors\Domain\ValueObjects\ActorId;
use App\Actors\Domain\ValueObjects\ActorLink;
use App\Actors\Domain\ValueObjects\ActorName;
use App\Actors\Domain\ValueObjects\SeasonsActive;
use App\Characters\Application\Commands\CreateCharacter;
use App\Characters\Domain\Entity\Character;
use App\Characters\Domain\ValueObjects\CharacterActors;
use App\Characters\Domain\ValueObjects\CharacterId;
use App\Characters\Domain\ValueObjects\CharacterLink;
use App\Characters\Domain\ValueObjects\CharacterName;
use App\Characters\Domain\ValueObjects\CharacterNickname;
use App\Characters\Domain\ValueObjects\CharacterAllies;
use App\Characters\Domain\ValueObjects\ImageLink;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly CreateActor $createActor,
        private readonly CreateCharacter $createCharacter,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $gotCharacters = json_decode(file_get_contents('./resources/got-characters.json'));
        $actors = [];
        foreach ($gotCharacters->characters as $gotCharacter) {
            if (isset($gotCharacter->actorName, $gotCharacter->actorLink)) {
                $actors = array_merge($gotCharacter->actors ?? [], [(object) [
                    'actorLink' => $gotCharacter->actorLink,
                    'actorName' => $gotCharacter->actorName,
                    'seasonsActive' => $gotCharacter->seasonsActive ?? [],
                ]]);
            }
            foreach ($actors as $actor) {
                $this->createActor->handle(
                    Actor::new(
                        ActorId::fromString(Uuid::v4()),
                        ActorName::fromString($actor->actorName),
                        ActorLink::fromString($actor->actorLink),
                        SeasonsActive::fromArray($actor->seasonsActive ?? []),
                    ),
                );
            }

            $this->createCharacter->handle(
                Character::new(
                    CharacterId::fromString(Uuid::v4()),
                    CharacterName::fromString($gotCharacter->characterName ?? ''),
                    CharacterNickname::fromString($gotCharacter->nickname ?? ''),
                    CharacterLink::fromString($gotCharacter->characterLink ?? ''),
                    isset($gotCharacter->characterImageThumb)
                        ? ImageLink::fromString($gotCharacter->characterImageThumb) : null,
                    isset($gotCharacter->characterImageFull)
                        ? ImageLink::fromString($gotCharacter->characterImageFull) : null,
                    CharacterAllies::empty(),
                    CharacterActors::empty(),
                    $this->getHouseName($gotCharacter),
                    $gotCharacter->royal ?? false,
                    $gotCharacter->kingsguard ?? false,
                ),
            );
        }
    }

    private function getHouseName($gotCharacter): array
    {
        if (! isset($gotCharacter->houseName)) {
            return [];
        }

        if (! is_array($gotCharacter->houseName)) {
            return [$gotCharacter->houseName];
        }

        return $gotCharacter->houseName;
    }
}
