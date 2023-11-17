<?php

namespace App\Tests\Unit\Characters\Infrastructure\Controllers;

use App\Characters\Application\Commands\CreateCharacter as CreateCharacterCommand;
use App\Characters\Infrastructure\Controllers\CreateCharacter;
use App\Characters\Infrastructure\Requests\CreateCharacterRequest;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateCharacterTest extends TestCase
{
    private CreateCharacter $createCharacter;

    protected function setUp(): void
    {
        parent::setUp();
        $validator = \Mockery::mock(ValidatorInterface::class);
        $validator->shouldReceive('autoValidateRequest')->andReturn(false);
        $command = \Mockery::mock(CreateCharacterCommand::class);
        $command->shouldReceive('handle');
        $this->createCharacter = new CreateCharacter($command);
    }

    /**
     * @test
     */
    public function testCreateCharacterController(): void
    {
        // given
        $request = $this->getRequest();

        // when
        $response = $this->createCharacter->handle($request);

        // then
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    public function getRequest(): CreateCharacterRequest
    {
        $request = \Mockery::mock(CreateCharacterRequest::class);
        $request->shouldReceive('getRequest')
            ->andReturn(new Request(content: json_encode($this->getContent())));

        return $request;
    }

    private function getContent(): array
    {
        return [
            'id' => '5370cea7-48b3-42fd-8ca2-2ca80ff0c4fe',
            'characterName' => 'Rodrik Cassel',
            'nickname' => 'Rodrik Cassel',
            'characterLink' => 'Rodrik Cassel',
            'houses' => ['House 1', 'House 2'],
        ];
    }
}
