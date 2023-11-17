<?php

namespace App\Tests\Integration\Characters;

use App\Characters\Application\Commands\DeleteCharacter;
use App\Characters\Domain\ValueObjects\CharacterId;
use App\Characters\Infrastructure\Entity\Character;
use App\Tests\IntegrationTest;
use Doctrine\ORM\EntityManagerInterface;

class DeleteCharacterTest extends IntegrationTest
{
    private DeleteCharacter $deleteCharacterCommand;

    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        parent::setUp();
        $this->deleteCharacterCommand = static::getContainer()->get(DeleteCharacter::class);
        $this->entityManager = static::getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * @test
     */
    public function testDeleteCharacterCommand(): void
    {
        // given
        $character = $this->entityManager->getRepository(Character::class)->findAll()->first();

        // when
        $this->deleteCharacterCommand->handle(
            CharacterId::fromString($character->getId()),
        );

        // then
        $character = $this->entityManager->getRepository(Character::class)->findOneBy(['id' => $character->getId()]);
        $this->assertNull($character);
    }
}
