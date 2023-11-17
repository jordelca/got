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
I have tried to complete at least some part of every requirement (from both required, and options). I consider that completing search and messaging can be more relevant than covering 100% of the code.
However, I listed a few ToDo that would need to be implemented in a real case.

### ToDo
- Increase test coverage
- Only allies (self), and actor (Actor entity) relations CRUDS have been implemented. 
  - Implement missing character relations CRUD
- Indexing is done automatically by FOSElastica, however, every modifying action sends a message to RabbitMQ, handlers simply print a message, check consumer output.
  - If we need it, handlers can implement sync instead.
- Database is reset for every integration test. That ensures every test is independent of others but makes the tests run slower. Caching test database can help run faster while keeping test independence.
  - [LiipTestFixturesBundle](https://github.com/liip/LiipTestFixturesBundle) can help with that