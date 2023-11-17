<?php

namespace App\Characters\Infrastructure\EventHandlers;

use App\Characters\Domain\Events\CharacterDeleted;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class CharacterUpdatedHandler implements MessageHandlerInterface
{
    public function __invoke(CharacterDeleted $message): void
    {
        print_r('CharacterDeleted');
    }
}
