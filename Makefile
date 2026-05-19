compose = docker compose

up:
	$(compose) up -d --build --remove-orphans
	$(compose) exec app php artisan migrate --force
	$(compose) exec app php artisan optimize:clear


down:
	$(compose) down

restart:
	$(MAKE) down
	$(MAKE) up

cache:
	$(compose) exec app php artisan optimize:clear

migrate:
	$(compose) exec app php artisan migrate

docs:
	$(compose) exec app php artisan l5-swagger:generate

test:
	$(compose) exec app php artisan test

dockblock:
	$(compose) exec app php artisan ide-helper:models -RW

phpstan:
	$(compose) exec app php vendor/bin/phpstan analyse --memory-limit=512M

pint:
	$(compose) exec app pint

queue:
	$(compose)  exec app php artisan queue:work

complex:
	$(MAKE) test
	$(MAKE) pint
	$(MAKE) phpstan

