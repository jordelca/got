<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class IntegrationTest extends KernelTestCase
{
    protected function setUp(): void
    {
        $commands = [
            'doctrine:database:drop',
            'doctrine:database:create',
            'doctrine:migrations:migrate',
            'doctrine:fixtures:load',
        ];

        foreach ($commands as $command) {
            passthru(
                sprintf(
                    'php bin/console --env=test %s --no-interaction --quiet ',
                    $command,
                ),
            );
        }

        parent::setUp();
    }
}
