# Приложение Д. Скриншоты интерфейса

При сдаче работы добавьте в каталог `docs/coursework/screenshots/` файлы и вставьте их в Word.

## Чеклист скриншотов

| № | Файл | Содержание |
|---|------|------------|
| 1 | `vitrina.png` | Главная страница каталога (`/`) |
| 2 | `admin-login.png` | Страница входа `/admin` |
| 3 | `admin-menu.png` | Боковое меню MoonShine |
| 4 | `car-form.png` | Форма создания/редактирования автомобиля |
| 5 | `client-form.png` | Форма клиента |
| 6 | `sail-sell-form.png` | Форма сделки продажи |
| 7 | `sail-list.png` | Список сделок |
| 8 | `report-form.png` | Создание отчёта |
| 9 | `report-xlsx.png` | Скачанный файл Excel (приложение З) |
| 10 | `ci-success.png` | Успешный прогон GitHub Actions (опционально) |

## Команды для подготовки демо-данных

```bash
make up
docker compose exec app php artisan migrate --force
docker compose exec app php artisan car:parser
docker compose exec app php artisan app:create-admin
```

Откройте http://localhost и http://localhost/admin.
