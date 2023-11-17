<?php

namespace App\Tests\Integration\Characters;

use App\Characters\Application\Commands\DeleteCharacter;
use App\Characters\Domain\Exceptions\CharacterNotFound;
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
        $character = $this->entityManager->getRepository(Character::class)->findAll()[0];

        // when
        $this->deleteCharacterCommand->handle(
            CharacterId::fromString($character->getId()),
        );

        // then
        $character = $this->entityManager->getRepository(Character::class)->findOneBy(['id' => $character->getId()]);
        $this->assertNull($character);
    }

    /**
     * @test
     */
    public function testDeleteCharacterCommandThrowsNotFound(): void
    {
        // given
        $id = 'not_existing_character_id';

        // then
        $this->expectException(CharacterNotFound::class);

        // when
        $this->deleteCharacterCommand->handle(
            CharacterId::fromString($id),
        );
    }
}
