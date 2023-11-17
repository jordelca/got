<?php

namespace App\Tests\Integration\Actors;

use App\Actors\Application\Commands\CreateActor;
use App\Actors\Domain\ValueObjects\ActorId;
use App\Actors\Domain\ValueObjects\ActorLink;
use App\Actors\Domain\ValueObjects\ActorName;
use App\Actors\Domain\ValueObjects\SeasonsActive;
use App\Actors\Infrastructure\Entity\Actor;
use App\Tests\IntegrationTest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;
use App\Actors\Domain\Entity\Actor as DomainActor;

class CreateActorTest extends IntegrationTest
{
    private CreateActor $createActorCommand;

    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createActorCommand = static::getContainer()->get(CreateActor::class);
        $this->entityManager = static::getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * @test
     */
    public function testCreateActorCommand(): void
    {
        // given
        $uuid = Uuid::v4();

        // when
        $this->createActorCommand->handle(
            DomainActor::new(
                ActorId::fromString($uuid),
                ActorName::fromString('Actor Name'),
                ActorLink::fromString('/name/nm21344'),
                SeasonsActive::fromArray([1, 2]),
            ),
        );

        $actor = $this->entityManager->getRepository(Actor::class)->findOneBy(['id' => (string) $uuid]);

        // then
        $this->assertNotNull($actor);
        $this->assertEquals($uuid, $actor->getId());
    }
}
