<?php

namespace App\Actors\Infrastructure\Repository;

use App\Actors\Domain\ActorRepositoryInterface;
use App\Actors\Domain\Entity\Actor as DomainActor;
use App\Actors\Domain\ValueObjects\ActorName;
use App\Actors\Infrastructure\Entity\Actor;
use Doctrine\ORM\EntityManagerInterface;

class ActorRepository implements ActorRepositoryInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function existsByName(
        ActorName $actorName,
    ): bool {
        return (bool) $this->entityManager
            ->getRepository(Actor::class)
            ->findOneBy(['name' => $actorName->name]);
    }

    public function create(DomainActor $actor): void
    {
        if (! $this->existsByName($actor->actorName)) {
            $doctrineActor = new Actor();
            $doctrineActor->setId($actor->actorId->id);
            $doctrineActor->setName($actor->actorName->name);
            $doctrineActor->setLink($actor->actorLink->link);
            $doctrineActor->setSeasonsActive($actor->seasonsActive->seasonIds);

            $this->entityManager->persist($doctrineActor);
            $this->entityManager->flush();
        }
    }
}
