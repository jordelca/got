<?php

namespace App\Tests\Unit\Characters\Infrastructure\Controllers;

use App\Characters\Application\Queries\ListCharacters as ListCharactersCommand;
use App\Characters\Infrastructure\Controllers\ListCharacters;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ListCharactersTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $validator = \Mockery::mock(ValidatorInterface::class);
        $validator->shouldReceive('autoValidateRequest')->andReturn(false);
        $command = \Mockery::mock(ListCharactersCommand::class);
        $command->shouldReceive('handle');
        $this->listCharacters = new ListCharacters($command);
    }

    /**
     * @test
     */
    public function testListCharactersController(): void
    {
        // when
        $response = $this->listCharacters->handle();

        // then
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
}
