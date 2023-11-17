<?php

namespace App\Characters\Infrastructure\Controllers;

use App\Characters\Application\Queries\ListCharacters as ListCharactersQuery;
use App\Characters\Infrastructure\Entity\Character;
use App\Characters\Infrastructure\Resources\CharacterResource;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

class ListCharacters extends AbstractController
{
    public function __construct(private readonly ListCharactersQuery $listCharacters)
    {
    }

    #[Route(path: '/character', methods: ['GET'])]
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
    public function handle(): JsonResponse
    {
        return new JsonResponse(
            array_map(
                fn (Character $character) => CharacterResource::toArray($character),
                $this->listCharacters->handle(),
            ),
            200,
        );
    }
}
