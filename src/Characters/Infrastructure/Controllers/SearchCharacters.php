<?php

namespace App\Characters\Infrastructure\Controllers;

use App\Characters\Infrastructure\Entity\Character;
use App\Characters\Infrastructure\Requests\SearchCharactersRequest;
use App\Characters\Infrastructure\Resources\CharacterResource;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Characters\Application\Queries\SearchCharacters as SearchCharacterQuery;
use OpenApi\Attributes as OA;

class SearchCharacters extends AbstractController
{
    public function __construct(
        private readonly SearchCharacterQuery $searchCharacter,
    ) {
    }

    #[Route(path: '/character/search', methods: ['POST'])]
    #[OA\Response(
        response: 200,
        description: 'Returns Characters',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(
                properties: [
                    new OA\Property(property: 'id', type: 'string'),
                    new OA\Property(property: 'characterName', type: 'string'),
                    new OA\Property(property: 'characterLink', type: 'string'),
                    new OA\Property(property: 'nickname', type: 'string'),
                    new OA\Property(property: 'characterImageThumb', type: 'string'),
                    new OA\Property(property: 'characterImageFull', type: 'string'),
                    new OA\Property(property: 'houses', type: 'array', items: new OA\Items(type: 'string')),
                    new OA\Property(property: 'allies', type: 'array', items: new OA\Items(type: 'string')),
                    new OA\Property(property: 'actors', type: 'array', items: new OA\Items(type: 'string')),
                ],
                type: 'object',
            ),
        ),
    )]
    public function handle(SearchCharactersRequest $request): Response
    {
        $requestBody = json_decode($request->getRequest()->getContent());

        return new JsonResponse(
            array_map(
                fn (Character $character) => CharacterResource::toArray($character),
                $this->searchCharacter->handle($requestBody->key),
            ),
            Response::HTTP_OK,
        );
    }
}
