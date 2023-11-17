<?php

namespace App\Characters\Infrastructure\EventHandlers;

use App\Characters\Domain\Events\CharacterCreated;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class CharacterCreatedHandler implements MessageHandlerInterface
{
    public function __invoke(CharacterCreated $message): void
    {
        print_r('CharacterCreated');
    }
}
