# Приложение Е. Описание таблиц базы данных (PostgreSQL)

## Таблица `cars`

| Поле | Тип | Ограничения | Примечание |
|------|-----|-------------|------------|
| id | bigserial | PK | |
| mark | varchar | NOT NULL, index | |
| model | varchar | NOT NULL, index | |
| class | varchar | NULL, index | |
| vin_code | varchar | NOT NULL | |
| year | integer | NOT NULL | |
| price | integer | NOT NULL | |
| color | enum | NOT NULL | CarColor |
| type | enum | NOT NULL | NEW / USED |
| status | smallint | DEFAULT 1 | CarStatus |
| mileage | integer | NULL | |
| state_number | varchar | NULL | |
| preview | varchar | NULL | |
| images | json | NULL | |
| created_at, updated_at | timestamp | | |
| deleted_at | timestamp | NULL | soft delete |

## Таблица `clients`

| Поле | Тип | Ограничения | Примечание |
|------|-----|-------------|------------|
| id | bigserial | PK | |
| name | varchar | NOT NULL | |
| phone | varchar | UNIQUE | |
| passport_series | varchar | NULL | |
| passport_number | varchar | NULL | |
| created_at, updated_at | timestamp | | |

## Таблица `sails`

| Поле | Тип | Ограничения | Примечание |
|------|-----|-------------|------------|
| id | bigserial | PK | |
| client_id | bigint | FK → clients, SET NULL | |
| user_id | bigint | FK → users, SET NULL | |
| car_id | bigint | FK → cars, SET NULL | |
| price | integer | NULL | |
| status | enum/int | DEFAULT 0 | SailStatus |
| type | enum/int | NOT NULL | BUY / SELL |
| files | json | NULL | Вложения |
| created_at, updated_at | timestamp | | |

## Таблица `options`

| Поле | Тип | Ограничения | Примечание |
|------|-----|-------------|------------|
| id | bigserial | PK | |
| name | varchar | NOT NULL | |
| price | integer | NOT NULL | |
| created_at, updated_at | timestamp | | |

## Таблица `option_sale`

| Поле | Тип | Ограничения | Примечание |
|------|-----|-------------|------------|
| option_id | bigint | PK, FK → options, CASCADE | |
| sail_id | bigint | PK, FK → sails, CASCADE | |

## Таблица `credit_applications`

| Поле | Тип | Ограничения | Примечание |
|------|-----|-------------|------------|
| id | bigserial | PK | |
| client_id | bigint | FK → clients, CASCADE | |
| user_id | bigint | FK → users, SET NULL | |
| sum | integer | NOT NULL | |
| status | integer | NULL, index | |
| files | json | NULL | |
| cancel_reason | varchar | NULL | |
| created_at, updated_at | timestamp | | |

## Таблица `reports`

| Поле | Тип | Ограничения | Примечание |
|------|-----|-------------|------------|
| id | bigserial | PK | |
| user_id | bigint | FK → users, SET NULL | |
| from | date | NOT NULL | Начало периода |
| to | date | NOT NULL | Конец периода |
| type | smallint | NOT NULL | SailType |
| status | smallint | DEFAULT 0 | ReportStatus |
| file | varchar | NULL | Путь к XLSX |
| created_at, updated_at | timestamp | | |

## Таблица `users`

| Поле | Тип | Ограничения | Примечание |
|------|-----|-------------|------------|
| id | bigserial | PK | |
| name | varchar | NOT NULL | |
| email | varchar | UNIQUE | |
| password | varchar | NOT NULL | |
| user_role_id | bigint | FK → user_roles | |
| created_at, updated_at | timestamp | | |

## Таблица `user_roles`

| Поле | Тип | Ограничения | Примечание |
|------|-----|-------------|------------|
| id | bigserial | PK | 1 — admin, 2 — manager |
| name | varchar | | |

## Таблица `user_permissions`

| Поле | Тип | Ограничения | Примечание |
|------|-----|-------------|------------|
| id | bigserial | PK | |
| user_id | bigint | FK → users, CASCADE | |
| permissions | json | NOT NULL | Матрица прав |
| created_at, updated_at | timestamp | | |

## Примеры SQL-запросов

```sql
-- Автомобили в наличии для витрины
SELECT id, mark, model, price, type, status
FROM cars
WHERE status = 1 AND deleted_at IS NULL;

-- Завершённые продажи за период (для отчёта)
SELECT s.*, c.mark, c.model, cl.name AS client_name
FROM sails s
LEFT JOIN cars c ON c.id = s.car_id
LEFT JOIN clients cl ON cl.id = s.client_id
WHERE s.status = 1
  AND s.type = 2
  AND s.created_at BETWEEN '2026-01-01' AND '2026-01-31 23:59:59';
```

*Примечание: числовые значения `type` и `status` соответствуют backed enum в PHP (`SailType`, `SailStatus`).*
