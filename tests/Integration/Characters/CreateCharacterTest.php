<?php

namespace App\Tests\Integration\Characters;

use App\Characters\Application\Commands\CreateCharacter;
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
use Symfony\Component\Uid\Uuid;
use App\Characters\Domain\Entity\Character as DomainCharacter;

class CreateCharacterTest extends IntegrationTest
{
    private CreateCharacter $createCharacterCommand;

    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createCharacterCommand = static::getContainer()->get(CreateCharacter::class);
        $this->entityManager = static::getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * @test
     */
    public function testCreateCharacterCommand(): void
    {
        // given
        $uuid = Uuid::v4();

        // when
        $this->createCharacterCommand->handle(
            DomainCharacter::new(
                CharacterId::fromString($uuid),
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

        $character = $this->entityManager->getRepository(Character::class)->findOneBy(['id' => (string) $uuid]);

        // then
        $this->assertNotNull($character);
        $this->assertEquals($uuid, $character->getId());
    }
}
