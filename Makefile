.PHONY: setup git-hooks db-migrate db-fixtures messenger-consume es-populate composer-install composer-update \
composer-dump-autoload composer start up stop down destroy build terminal-php terminal-db phpstan php-cs-fixer \
test test-unit test-integration test-coverage-pcov
.DEFAULT_GOAL:=help

current-dir := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))

##@ Helpers

help:
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m<target>\033[0m\n"} /^[a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-15s\033[0m %s\n", $$1, $$2 } /^##@/ { printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)

##@  👩‍💻  Development environment

git-hooks: ## Sets up project git hooks
	@cp scripts/git-hooks/* .git/hooks

db-migrate: CMD='doctrine:migrations:migrate' ## Runs database migrations

db-fixtures: CMD='doctrine:fixtures:load' ## Loads fixtures

messenger-consume: CMD='messenger:consume' ## Consume fixtures

es-populate: CMD='fos:elastica:populate' ## ES populate

db-migrate db-fixtures messenger-consume es-populate:
	@docker compose run php bin/console $(CMD)


##@  🐘  Composer

composer-install: CMD=install ## Install composer dependencies
composer-update: CMD=update ## Update composer dependencies
composer-dump-autoload: CMD=dump-autoload ## Dumps autoload file

##@  ✅ Composer

test:
	@docker compose exec php vendor/bin/phpunit

test-unit:
	@docker compose exec php vendor/bin/phpunit --testsuite Unit

test-integration:
	@docker compose exec php vendor/bin/phpunit --testsuite Integration

test-coverage-pcov:
	@docker compose exec php vendor/bin/phpunit --coverage-html=var/coverage

phpstan:
	@docker compose exec php vendor/bin/phpstan analyse --memory-limit=1G

php-cs-fixer:
	scripts/cs-fixer.sh

# Usage example (add a new dependency): `make composer CMD="require --dev symfony/var-dumper ^4.2"`
composer composer-install composer-update composer-dump-autoload:
	@docker compose run php composer $(CMD)

##@  🐳  Docker Compose

start: ## Boot up containers
	@docker compose up -d

up: ##     -> Alias for start
	make start

stop: CMD=stop  ## Stop containers

destroy: CMD=down ## Stop and delete containers and volumes

down: ##     -> Alias for destroy
	make destroy

stop destroy:
	@docker compose $(CMD)

build: ## Builds project containers
	@docker compose build

##@