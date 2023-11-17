<?php

namespace App\Characters\Infrastructure\Controllers;

use App\Characters\Domain\ValueObjects\CharacterId;
use App\Characters\Infrastructure\Services\CharacterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use OpenApi\Attributes as OA;

class DeleteCharacter extends AbstractController
{
    public function __construct(
        private readonly CharacterService $characterService,
    ) {
    }

    #[Route(path: '/character/{id}', requirements: ['page' => Requirement::UUID], methods: ['DELETE'])]
    #[OA\Response(
        response: 204,
        description: 'Returns Empty Response',
    )]
    public function handle(string $id): Response
    {
        $this->characterService->delete(CharacterId::fromString($id));

        return new Response(status: Response::HTTP_NO_CONTENT);
    }
}
