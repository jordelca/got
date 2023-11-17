<?php

namespace App\Actors\Domain;

use App\Actors\Domain\Entity\Actor;
use App\Actors\Domain\ValueObjects\ActorName;

interface ActorRepositoryInterface
{
    public function existsByName(
        ActorName $actorName,
    ): bool;

    public function create(Actor $actor): void;
}
