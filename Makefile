export PACKAGER=$(shell id -u):$(shell id -g)
export UID=$(shell id -u)
export GID=$(shell id -g)

up:
	docker compose up -d

down:
	docker compose down --rmi local
