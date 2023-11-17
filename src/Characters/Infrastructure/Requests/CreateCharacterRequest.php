<?php

namespace App\Characters\Infrastructure\Requests;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Uuid;

class CreateCharacterRequest extends BaseRequest
{
    #[Uuid]
    protected string $id;

    #[NotBlank]
    protected string $characterName;

    #[NotBlank]
    protected string $nickname;

    #[NotBlank]
    protected string $characterLink;

    #[NotBlank]
    protected array $houses;
}
