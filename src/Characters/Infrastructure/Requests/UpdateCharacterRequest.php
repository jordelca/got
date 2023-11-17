<?php

namespace App\Characters\Infrastructure\Requests;

use Symfony\Component\Validator\Constraints\NotBlank;

class UpdateCharacterRequest extends BaseRequest
{
    #[NotBlank]
    protected string $characterName;

    #[NotBlank]
    protected string $nickname;

    #[NotBlank]
    protected string $characterLink;

    protected array $allies;

    protected array $actors;

    protected array $houses;
}
