#!/usr/bin/env bash

COMMAND="vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php"
docker compose exec -e PHP_CS_FIXER_IGNORE_ENV=1 -T php bash -c "$COMMAND"

echo 'php-cs-fixer fix done'
