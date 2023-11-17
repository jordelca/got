<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

if (file_exists(dirname(__DIR__).'/config/bootstrap.php')) {
    require dirname(__DIR__).'/config/bootstrap.php';
} elseif (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
}

passthru(
    'php bin/console --env=test doctrine:database:drop --no-interaction --quiet',
);

passthru(
    'php bin/console --env=test doctrine:database:create --no-interaction --quiet',
);

passthru(
    'php bin/console --env=test doctrine:migrations:migrate --no-interaction --quiet',
);

passthru(
    'php bin/console --env=test doctrine:fixtures:load --no-interaction --quiet',
);
