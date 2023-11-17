<?php

namespace App\Actors\Domain\Entity;

use App\Actors\Domain\ValueObjects\ActorId;
use App\Actors\Domain\ValueObjects\ActorLink;
use App\Actors\Domain\ValueObjects\ActorName;
use App\Actors\Domain\ValueObjects\SeasonsActive;

class Actor
{
    private function __construct(
        public readonly ActorId $actorId,
        public readonly ActorName $actorName,
        public readonly ActorLink $actorLink,
        public readonly SeasonsActive $seasonsActive,
    ) {
    }

    public static function new(
        ActorId $actorId,
        ActorName $actorName,
        ActorLink $actorLink,
        SeasonsActive $seasonsActive,
    ): self {
        return new self($actorId, $actorName, $actorLink, $seasonsActive);
    }
}
