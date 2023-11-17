<?php

namespace App\Tests\Integration\Characters;

use App\Characters\Application\Queries\ListCharacters;
use App\Characters\Infrastructure\Entity\Character;
use App\Tests\IntegrationTest;

class ListCharactersTest extends IntegrationTest
{
    private ListCharacters $listCharactersQuery;

    protected function setUp(): void
    {
        parent::setUp();
        $this->listCharactersQuery = static::getContainer()->get(ListCharacters::class);
        $this->entityManager = static::getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * @test
     */
    public function testListCharacterCommands(): void
    {
        // when
        $characterList = $this->listCharactersQuery->handle();

        // then
        $this->assertNotEmpty($characterList);
        $this->assertContainsOnlyInstancesOf(Character::class, $characterList);
    }
}
