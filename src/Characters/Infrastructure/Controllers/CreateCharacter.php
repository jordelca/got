<?php

namespace App\Characters\Infrastructure\Controllers;

use App\Characters\Application\Commands\CreateCharacter as CreateCharacterCommand;
use App\Characters\Domain\Entity\Character;
use App\Characters\Domain\ValueObjects\CharacterActors;
use App\Characters\Domain\ValueObjects\CharacterAllies;
use App\Characters\Domain\ValueObjects\CharacterId;
use App\Characters\Domain\ValueObjects\CharacterLink;
use App\Characters\Domain\ValueObjects\CharacterName;
use App\Characters\Domain\ValueObjects\CharacterNickname;
use App\Characters\Domain\ValueObjects\ImageLink;
use App\Characters\Infrastructure\Requests\CreateCharacterRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

class CreateCharacter extends AbstractController
{
    public function __construct(
        private readonly CreateCharacterCommand $createCharacter,
    ) {
    }

    #[Route(path: '/character', methods: ['POST'])]
    #[OA\Response(
        response: 204,
        description: 'Returns Empty Response',
    )]
    public function handle(CreateCharacterRequest $request): Response
    {
        $requestBody = json_decode($request->getRequest()->getContent());

        $this->createCharacter->handle(
            Character::new(
                CharacterId::fromString($requestBody->id),
                CharacterName::fromString($requestBody->characterName),
                CharacterNickname::fromString($requestBody->nickname),
                CharacterLink::fromString($requestBody->characterLink),
                isset($gotCharacter->characterImageThumb)
                    ? ImageLink::fromString($gotCharacter->characterImageThumb) : null,
                isset($gotCharacter->characterImageFull)
                    ? ImageLink::fromString($gotCharacter->characterImageFull) : null,
                CharacterAllies::empty(),
                CharacterActors::empty(),
                $requestBody->houses,
                $gotCharacter->royal ?? false,
                $gotCharacter->kingsguard ?? false,
            ),
        );

        return new Response(status: Response::HTTP_NO_CONTENT);
    }
}
