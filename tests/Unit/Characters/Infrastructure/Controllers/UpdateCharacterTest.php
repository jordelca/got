<?php

namespace App\Tests\Unit\Characters\Infrastructure\Controllers;

use App\Characters\Application\Commands\UpdateCharacter as UpdateCharacterCommand;
use App\Characters\Infrastructure\Controllers\UpdateCharacter;
use App\Characters\Infrastructure\Requests\UpdateCharacterRequest;
use PHPUnit\Framework\TestCase;
use Mockery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UpdateCharacterTest extends TestCase
{
    private UpdateCharacter $updateCharacter;

    protected function setUp(): void
    {
        parent::setUp();
        $validator = Mockery::mock(ValidatorInterface::class);
        $validator->shouldReceive('autoValidateRequest')->andReturn(false);
        $command = Mockery::mock(UpdateCharacterCommand::class);
        $command->shouldReceive('handle');
        $this->updateCharacter = new UpdateCharacter($command);
    }

    /**
     * @test
     */
    public function testUpdateCharacterController(): void
    {
        // given
        $request = $this->getRequest();

        // when
        $response = $this->updateCharacter->handle($request, Uuid::v4());

        // then
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    /**
     * @return UpdateCharacterRequest
     */
    public function getRequest(): UpdateCharacterRequest
    {
        $request = Mockery::mock(UpdateCharacterRequest::class);
        $request->shouldReceive('getRequest')
            ->andReturn(new Request(content: json_encode($this->getContent())));

        return $request;
    }

    private function getContent(): array
    {
        return [
            'characterName' => 'Rodrik Cassel',
            'nickname' => 'Rodrik Cassel',
            'characterLink' => 'Rodrik Cassel',
            'houses' => ['House 1', 'House 2']
        ];
    }
}
