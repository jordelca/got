<?php

namespace App\Characters\Infrastructure\Resources;

use App\Actors\Infrastructure\Entity\Actor;
use App\Characters\Infrastructure\Entity\Character;

class CharacterResource
{
    public static function toArray(Character $character): array
    {
        return array_filter(
            [
                'id' => $character->getId(),
                'characterLink' => $character->getLink(),
                'characterName' => $character->getName(),
                'nickname' => $character->getNickname(),
                'royal' => $character->isRoyal(),
                'kingsguard' => $character->isRoyal(),
                'characterImageThumb' => $character->getImageThumb(),
                'characterImageFull' => $character->getImageFull(),
                'houses' => $character->getHouses(),
                'allies' => $character->getAllies()->map(fn (Character $ally) => $ally->getName())->toArray(),
                'actors' => $character->getActors()->map(fn (Actor $actor) => $actor->getName())->toArray(),
                'marriedEngaged' => $character->getMarriedEngaged()->toArray(),
                'siblings' => $character->getSiblings()->toArray(),
                'guardedBy' => $character->getGuardedBy()->toArray(),
                'parents' => $character->getParents()->toArray(),
                'parentOf' => $character->getParentOf()->toArray(),
                'serves' => $character->getServes()->toArray(),
                'servedBy' => $character->getServedBy()->toArray(),
                'killed' => $character->getKilled()->toArray(),
                'killedBy' => $character->getKilledBy()->toArray(),
            ],
        );
    }
}
