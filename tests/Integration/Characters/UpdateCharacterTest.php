<?php

namespace App\Tests\Integration\Characters;

use App\Characters\Application\Commands\UpdateCharacter;
use App\Characters\Domain\Exceptions\CharacterNotFound;
use App\Characters\Domain\ValueObjects\CharacterActors;
use App\Characters\Domain\ValueObjects\CharacterAllies;
use App\Characters\Domain\ValueObjects\CharacterId;
use App\Characters\Domain\ValueObjects\CharacterLink;
use App\Characters\Domain\ValueObjects\CharacterName;
use App\Characters\Domain\ValueObjects\CharacterNickname;
use App\Characters\Domain\ValueObjects\ImageLink;
use App\Characters\Infrastructure\Entity\Character;
use App\Tests\IntegrationTest;
use Doctrine\ORM\EntityManagerInterface;
use App\Characters\Domain\Entity\Character as DomainCharacter;

class UpdateCharacterTest extends IntegrationTest
{
    private UpdateCharacter $updateCharacterCommand;

    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        parent::setUp();
        $this->updateCharacterCommand = static::getContainer()->get(UpdateCharacter::class);
        $this->entityManager = static::getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * @test
     */
    public function testUpdateCharacterCommand(): void
    {
        // given
        /** @var Character $character */
        $character = $this->entityManager->getRepository(Character::class)->findAll()[0];
        $oldName = $character->getName();
        $newName = 'John Doe';

        // when
        $this->updateCharacterCommand->handle(
            DomainCharacter::new(
                CharacterId::fromString($character->getId()),
                CharacterName::fromString($newName),
                CharacterNickname::fromString($character->getNickname()),
                CharacterLink::fromString($character->getLink()),
                ImageLink::fromString($character->getImageThumb() ?? ''),
                ImageLink::fromString($character->getImageFull() ?? ''),
                CharacterAllies::empty(),
                CharacterActors::empty(),
                $character->getHouses(),
                $character->isRoyal(),
                $character->isKingsguard(),
            ),
        );

        $updatedCharacter = $this->entityManager
            ->getRepository(Character::class)
            ->findOneBy(['id' => $character->getId()]);

        // then
        $this->assertNotEquals($oldName, $newName);
        $this->assertEquals($updatedCharacter->getName(), $newName);
    }

    /**
     * @test
     */
    public function testUpdateCharacterCommandThrowsNotFound(): void
    {
        // given
        $id = 'not_existing_character_id';

        // then
        $this->expectException(CharacterNotFound::class);

        // when
        $this->updateCharacterCommand->handle(
            DomainCharacter::new(
                CharacterId::fromString($id),
                CharacterName::fromString('Character Name'),
                CharacterNickname::fromString('Character Nickname'),
                CharacterLink::fromString('/character/ch123422'),
                ImageLink::fromString('http://imageservice/thumb.jpg'),
                ImageLink::fromString('http://imageservice/full.jpg'),
                CharacterAllies::empty(),
                CharacterActors::empty(),
                ['House 1'],
                true,
                false,
            ),
        );
    }
}
