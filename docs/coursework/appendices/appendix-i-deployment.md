# Приложение И. Инструкция по установке и настройке

## И.1 Требования

- Docker и Docker Compose
- Make (опционально)

## И.2 Установка

```bash
git clone <url> course_work
cd course_work
cp .env.example .env
```

Параметры БД в `.env`:

```env
DB_CONNECTION=pgsql
DB_HOST=database
DB_PORT=5432
DB_DATABASE=driveline
DB_USERNAME=driveline
DB_PASSWORD=secret
```

## И.3 Запуск

```bash
make up
docker compose exec app npm install
docker compose exec app npm run build
```

- Витрина: http://localhost  
- Админ-панель: http://localhost/admin  

## И.4 Служебные команды

| Команда | Назначение |
|---------|------------|
| `make migrate` | Миграции |
| `make test` | PHPUnit |
| `make pint` | Стиль кода |
| `make phpstan` | Статический анализ |
| `make queue` | Обработчик очереди |
| `php artisan car:parser` | Наполнение каталога |
| `php artisan app:create-admin` | Создание администратора |

## И.5 CI/CD

При push в репозиторий выполняется workflow: Pint → PHPStan → PHPUnit на PostgreSQL. После успеха на ветке `main` возможен деплой по SSH (см. `.github/workflows/deployment.yml`).
