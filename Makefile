export PACKAGER=$(shell id -u):$(shell id -g)
export UID=$(shell id -u)
export GID=$(shell id -g)

ENV_LOCAL=.env.local

up:
	make check-env && \
	docker compose up -d

down:
	docker compose down --remove-orphans --rmi local

rebuild: down up

init-prod:
	docker exec yii_fpm php init --env=Production --overwrite=All --delete=All

init-dev:
	docker exec yii_fpm php init --env=Development --overwrite=All --delete=All

migrate:
	docker exec yii_fpm php yii migrate --interactive=0

check-env:
	test -f ./.env.local || touch ./.env.local

