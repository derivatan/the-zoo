.PHONY: all
all: build run

.PHONY: build
build:
	docker-compose build

.PHONY: run
run:
	docker-compose up -d

.PHONY: run-migrate
run-migrate:
	docker exec the-zoo_php_1 php artisan migrate
