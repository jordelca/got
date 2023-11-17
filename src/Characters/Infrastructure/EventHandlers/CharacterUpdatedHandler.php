<?php

namespace App\Characters\Infrastructure\EventHandlers;

use App\Characters\Domain\Events\CharacterUpdated;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class CharacterUpdatedHandler implements MessageHandlerInterface
{
    public function __invoke(CharacterUpdated $message): void
    {
        print_r('CharacterDeleted');
    }
}
