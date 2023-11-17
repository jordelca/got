Game of Thrones
==================================

### Installation
```
make build
make start
make composer-install
make db-migrate
make db-fixtures
make git-hooks
```

### Messenger
```
make messenger-consume
```

### Testing

```
make test
make test-unit
make test-integration
make test-coverage-pcov
```

### Code analysis
```
make phpstan
make php-cs-fixer
```

### API
http://localhost/character

### Postman Collection
```
resources/GameOfThrones.postman_collection.json
```

### OpenAPI
http://localhost/api/doc.json

### Elasticsearch
http://localhost:9200

### Elasticsearch Head
http://localhost:8080/

### RabbitMQ
http://localhost:15672

### Note
I tried to complete at least some part of every requirement (from both required, and optionals). I consider that completing linting, search or messaging can be more relevant than covering 100% of the code.
However, I listed a few ToDo that would need to be implemented in a real case.

### Done
- Converted input into 2 table (characters, actors) via fixtures
- Fixture makes use of CreateCharacter and CreateActor.
- Created RESTful CRUD for character and some relations (n)
  - List
  - Create
  - Update
  - Delete
  - Search
- Added unit tests for controllers and the service
- Added integration tests for commands and queries
- Coverage report can be generated via following command:
  - `make test-coverage-pcov`
  - Report is generated under `var/coverage`
- OpenApi documentation is automatically generated using `NelmioApiDocBundle` and can be found under 
  - `http://localhost/api/doc.json`
- Added git hooks:
  - pre-commit: php-cs-fixer
  - pre-push: all tests and phpstan
- Added ElasticSearch docker container
  - Added FOSElastica which takes care of data sync and search 
- Added RabbitMQ docker container 
  - Connected SymfonyMessenger with RabbitMQ
  - Sending messages on Character creation, update and deletion
    - Check consumer output when running `make messenger-consume` 
- Added Github Actions config (not working) which:
  - On open PR against `main` branch: runs unit test 
  - On merge against `main` branch: Notify slack channel and run deploy (deploy process not defined)

### ToDo
- Increase test coverage
- Error managing
- Only allies (self), and actor (Actor entity) relations CRUDS have been implemented. 
  - Implement missing character relations CRUD
- Indexing is done automatically by FOSElastica, however, every modifying action sends a message to RabbitMQ, handlers simply print a message, check consumer output.
  - If we need it, handlers can implement sync instead.
- Database is reset for every integration test. That ensures every test is independent of others but makes the tests run slower. Caching test database can help run faster while keeping test independence.
  - [LiipTestFixturesBundle](https://github.com/liip/LiipTestFixturesBundle) can help with that.