<?php

namespace App\Characters\Infrastructure\Controllers;

use App\Characters\Application\Commands\DeleteCharacter as DeleteCharacterCommand;
use App\Characters\Domain\ValueObjects\CharacterId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use OpenApi\Attributes as OA;

class DeleteCharacter extends AbstractController
{
    public function __construct(
        private readonly DeleteCharacterCommand $deleteCharacter,
    ) {
    }

    #[Route(path: '/character/{id}', requirements: ['page' => Requirement::UUID], methods: ['DELETE'])]
    #[OA\Response(
        response: 204,
        description: 'Returns Empty Response',
    )]
    public function handle(string $id): Response
    {
        $this->deleteCharacter->handle(CharacterId::fromString($id));

        return new Response(status: Response::HTTP_NO_CONTENT);
    }
}
