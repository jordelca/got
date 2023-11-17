<?php

namespace App\Tests\Unit\Characters\Infrastructure\Controllers;

use App\Characters\Application\Commands\DeleteCharacter as DeleteCharacterCommand;
use App\Characters\Infrastructure\Controllers\CreateCharacter;
use App\Characters\Infrastructure\Controllers\DeleteCharacter;
use PHPUnit\Framework\TestCase;
use Mockery;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DeleteCharacterTest extends TestCase
{
    private DeleteCharacter $deleteCharacter;

    protected function setUp(): void
    {
        parent::setUp();
        $validator = Mockery::mock(ValidatorInterface::class);
        $validator->shouldReceive('autoValidateRequest')->andReturn(false);
        $command = Mockery::mock(DeleteCharacterCommand::class);
        $command->shouldReceive('handle');
        $this->deleteCharacter = new DeleteCharacter($command);
    }

    /**
     * @test
     */
    public function testDeleteCharacterController(): void
    {
        // when
        $response = $this->deleteCharacter->handle(Uuid::v4());

        // then
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }
}
