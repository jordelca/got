<?php

namespace App\Tests\Unit\Characters\Infrastructure\Controllers;

use App\Characters\Application\Queries\SearchCharacters as SearchCharactersCommand;
use App\Characters\Infrastructure\Controllers\SearchCharacters;
use App\Characters\Infrastructure\Requests\SearchCharactersRequest;
use PHPUnit\Framework\TestCase;
use Mockery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SearchCharactersTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $validator = Mockery::mock(ValidatorInterface::class);
        $validator->shouldReceive('autoValidateRequest')->andReturn(false);
        $command = Mockery::mock(SearchCharactersCommand::class);
        $command->shouldReceive('handle');
        $this->searchCharacters = new SearchCharacters($command);
    }

    /**
     * @test
     */
    public function testSearchCharactersController(): void
    {
        // given
        $request = $this->getRequest();

        // when
        $response = $this->searchCharacters->handle($request);

        // then
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    /**
     * @return SearchCharactersRequest
     */
    public function getRequest(): SearchCharactersRequest
    {
        $request = Mockery::mock(SearchCharactersRequest::class);
        $request->shouldReceive('getRequest')
            ->andReturn(new Request(content: json_encode($this->getContent())));

        return $request;
    }

    private function getContent(): array
    {
        return [
            'key' => 'Name',
        ];
    }
}
