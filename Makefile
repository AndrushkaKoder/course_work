sail = ./vendor/bin/sail

up:
	$(sail) up -d
	$(sail) php artisan migrate
	$(sail) php artisan optimize:clear

down:
	$(sail) down

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
	$(sail) vendor/bin/phpstan analyse app

queue:
	$(sail) php artisan queue:work
