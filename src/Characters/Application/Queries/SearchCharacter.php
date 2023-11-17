<?php

namespace App\Characters\Application\Queries;

use FOS\ElasticaBundle\Finder\FinderInterface;

class SearchCharacter
{
    public function __construct(
        private readonly FinderInterface $finder,
    ) {
    }

    public function handle(
        string $key,
    ): array {
        return $this->finder->find($key);
    }
}
