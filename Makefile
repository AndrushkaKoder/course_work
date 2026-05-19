sail = ./vendor/bin/sail

up:
	$(sail) up -d
	$(sail) php artisan migrate
	$(sail) php artisan optimize:clear

down:
	$(sail) down

restart:
	$(MAKE) down
	$(MAKE) up

cache:
	$(sail) php artisan optimize:clear

migrate:
	$(sail) php artisan migrate

docs:
	$(sail) php artisan l5-swagger:generate

test:
	$(sail) php artisan test

dockblock:
	$(sail) php artisan ide-helper:models -RW

phpstan:
	$(sail) php vendor/bin/phpstan analyse --memory-limit=512M

pint:
	$(sail) pint

queue:
	$(sail) php artisan queue:work

complex:
	$(MAKE) test
	$(MAKE) pint
	$(MAKE) phpstan

