<?php

namespace App\Characters\Infrastructure\Controllers;

use App\Characters\Application\Commands\UpdateCharacter as UpdateCharacterCommand;
use App\Characters\Domain\Entity\Character;
use App\Characters\Domain\ValueObjects\CharacterActors;
use App\Characters\Domain\ValueObjects\CharacterAllies;
use App\Characters\Domain\ValueObjects\CharacterId;
use App\Characters\Domain\ValueObjects\CharacterLink;
use App\Characters\Domain\ValueObjects\CharacterName;
use App\Characters\Domain\ValueObjects\CharacterNickname;
use App\Characters\Domain\ValueObjects\ImageLink;
use App\Characters\Infrastructure\Requests\UpdateCharacterRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

class UpdateCharacter extends AbstractController
{
    public function __construct(
        private readonly UpdateCharacterCommand $updateCharacter,
    ) {
    }

    #[Route(path: '/character/{id}', name: 'character_update', methods: ['PUT'])]
    #[OA\Response(
        response: 204,
        description: 'Returns Empty Response',
    )]
    public function handle(UpdateCharacterRequest $request, string $id): Response
    {
        $requestBody = json_decode($request->getRequest()->getContent());

        $this->updateCharacter->handle(
            Character::new(
                CharacterId::fromString($id),
                CharacterName::fromString($requestBody->characterName),
                CharacterNickname::fromString($requestBody->nickname),
                CharacterLink::fromString($requestBody->characterLink),
                isset($requestBody->characterImageThumb)
                    ? ImageLink::fromString($requestBody->characterImageThumb) : null,
                isset($requestBody->characterImageFull)
                    ? ImageLink::fromString($requestBody->characterImageFull) : null,
                CharacterAllies::fromArray($requestBody->allies ?? []),
                CharacterActors::fromArray($requestBody->actors ?? []),
                $requestBody->houses,
                $requestBody->royal ?? false,
                $requestBody->kingsguard ?? false,
            ),
        );

        return new Response(status: Response::HTTP_NO_CONTENT);
    }
}
