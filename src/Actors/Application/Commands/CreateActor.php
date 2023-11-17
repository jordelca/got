<?php

namespace App\Actors\Application\Commands;

use App\Actors\Domain\ActorRepositoryInterface;
use App\Actors\Domain\Entity\Actor;

class CreateActor
{
    public function __construct(public readonly ActorRepositoryInterface $actorRepository)
    {
    }

    public function handle(
        Actor $actor,
    ): void {
        $this->actorRepository->create($actor);
    }
}
