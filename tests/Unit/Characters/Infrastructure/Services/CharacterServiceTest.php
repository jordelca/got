<?php

namespace App\Tests\Unit\Characters\Infrastructure\Services;

use App\Characters\Domain\Entity\Character;
use App\Characters\Domain\Events\CharacterCreated;
use App\Characters\Domain\Events\CharacterDeleted;
use App\Characters\Domain\Events\CharacterUpdated;
use App\Characters\Domain\ValueObjects\CharacterActors;
use App\Characters\Domain\ValueObjects\CharacterAllies;
use App\Characters\Domain\ValueObjects\CharacterId;
use App\Characters\Domain\ValueObjects\CharacterLink;
use App\Characters\Domain\ValueObjects\CharacterName;
use App\Characters\Domain\ValueObjects\CharacterNickname;
use App\Characters\Domain\ValueObjects\ImageLink;
use App\Characters\Infrastructure\Repository\CharacterRepository;
use App\Characters\Infrastructure\Services\CharacterService;
use FOS\ElasticaBundle\Finder\FinderInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\MessageBus;
use Mockery\MockInterface;
use Symfony\Component\Messenger\TraceableMessageBus;

class CharacterServiceTest extends TestCase
{
    private CharacterService $characterService;
    private TraceableMessageBus $messageBusInterface;
    private MockInterface&CharacterRepository $characterRepository;
    private MockInterface&FinderInterface $finderInterface;

    protected function setUp(): void
    {
        parent::setUp();
        $this->messageBusInterface = new TraceableMessageBus(new MessageBus());
        $this->characterRepository = \Mockery::mock(CharacterRepository::class);
        $this->finderInterface = \Mockery::mock(FinderInterface::class);
        $this->characterService = new CharacterService(
            $this->messageBusInterface,
            $this->characterRepository,
            $this->finderInterface,
        );
    }

    /**
     * @test
     */
    public function testListCharactersCommand(): void
    {
        // given
        $this->characterRepository->allows(['list' => []]);

        // when
        $result = $this->characterService->list();

        // then
        $this->assertIsArray($result);
    }

    /**
     * @test
     */
    public function search(): void
    {
        // given
        $this->finderInterface->allows(['find' => []]);

        // when
        $result = $this->characterService->search('search');

        // then
        $this->assertIsArray($result);
    }

    /**
     * @test
     */
    public function create(): void
    {
        // given
        $character = $this->getCharacter();
        $this->characterRepository->allows(['create' => null]);

        // when
        $this->characterService->create($character);

        // then
        $messages = $this->messageBusInterface->getDispatchedMessages();

        $this->assertNotEmpty($messages);
        $this->assertInstanceOf(CharacterCreated::class, $messages[0]['message']);
    }

    /**
     * @test
     */
    public function update(): void
    {
        // given
        $character = $this->getCharacter();
        $this->characterRepository->allows(['update' => null]);

        // when
        $this->characterService->update($character);

        // then
        $messages = $this->messageBusInterface->getDispatchedMessages();
        $this->assertNotEmpty($messages);
        $this->assertInstanceOf(CharacterUpdated::class, $messages[0]['message']);
    }

    /**
     * @test
     */
    public function delete(): void
    {
        // given
        $characterId = CharacterId::generate();
        $this->characterRepository->allows(['delete' => null]);

        // when
        $this->characterService->delete($characterId);

        // then
        $messages = $this->messageBusInterface->getDispatchedMessages();
        $this->assertNotEmpty($messages);
        $this->assertInstanceOf(CharacterDeleted::class, $messages[0]['message']);
    }

    public function getCharacter(): Character
    {
        return Character::new(
            CharacterId::generate(),
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
        );
    }
}
