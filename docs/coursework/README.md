# Курсовая работа: DriveLine

Пояснительная записка по дисциплине «Проектирование информационных систем» (направление 09.03.03, профиль «Прикладная информатика в экономике»).

## Тема

**Проектирование информационной системы учёта автомобилей, клиентов и сделок автосалона (на примере DriveLine)**

## Состав материалов

| Файл | Содержание |
|------|------------|
| [00-pereschen-sokrashcheniy.md](00-pereschen-sokrashcheniy.md) | Перечень сокращений |
| [01-vvedenie.md](01-vvedenie.md) | Введение |
| [02-glava-1-analiticheskaya.md](02-glava-1-analiticheskaya.md) | Глава 1. Аналитическая часть |
| [03-glava-2-proektnaya.md](03-glava-2-proektnaya.md) | Глава 2. Проектная часть |
| [04-glava-3-realizaciya.md](04-glava-3-realizaciya.md) | Глава 3. Реализация |
| [05-zaklyuchenie-i-istochniki.md](05-zaklyuchenie-i-istochniki.md) | Заключение и список источников |
| [appendices/](appendices/) | Приложения А–И |
| [diagrams/](diagrams/) | Исходники диаграмм (Mermaid, PlantUML) |
| [defense-presentation.md](defense-presentation.md) | Презентация к защите (структура слайдов) |
| [defense-demo-scenario.md](defense-demo-scenario.md) | Сценарий демонстрации на защите |

## Готовый Word-документ

**[POYASNITELNAYA-ZAPISKA-full.docx](POYASNITELNAYA-ZAPISKA-full.docx)** — титульный лист из `Титульный лист.pages` + оглавление + полный текст + плейсхолдеры для рисунков.

Пересборка:

```bash
.venv-docx/bin/python3 docs/coursework/build_docx.py
```

После открытия в Word: **обновите оглавление** (правый клик → «Обновить поле» → «Обновить целиком»). Вставьте схемы и скриншоты вместо пометок *Место для скриншота / схемы таблицы*.

## Сборный текст (Markdown)

[POYASNITELNAYA-ZAPISKA-full.md](POYASNITELNAYA-ZAPISKA-full.md) — исходник для скрипта сборки.

## Связь с кодом

Реализованная ИС — репозиторий [course_work](/). Админ-панель: `/admin`, витрина: `/`.
