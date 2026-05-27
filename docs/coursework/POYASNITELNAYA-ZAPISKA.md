# Пояснительная записка (сборный файл)

> Для переноса в Word объедините разделы в порядке нумерации или используйте этот файл целиком. Оформление: Times New Roman, 14 пт, поля по ГОСТ (см. методичку).

**Тема:** Проектирование информационной системы учёта автомобилей, клиентов и сделок автосалона (на примере DriveLine)

---

<!-- INCLUDE: 00-pereschen-sokrashcheniy.md -->
<!-- INCLUDE: 01-vvedenie.md -->
<!-- INCLUDE: 02-glava-1-analiticheskaya.md -->
<!-- INCLUDE: 03-glava-2-proektnaya.md -->
<!-- INCLUDE: 04-glava-3-realizaciya.md -->
<!-- INCLUDE: 05-zaklyuchenie-i-istochniki.md -->

---

**Примечание.** Разделы хранятся отдельными файлами в каталоге `docs/coursework/` для удобства редактирования. Приложения — в `appendices/` и `diagrams/`.

**Порядок сборки вручную:**

1. `00-pereschen-sokrashcheniy.md`
2. `01-vvedenie.md`
3. `02-glava-1-analiticheskaya.md`
4. `03-glava-2-proektnaya.md`
5. `04-glava-3-realizaciya.md`
6. `05-zaklyuchenie-i-istochniki.md`
7. Приложения А–И

Скрипт сборки (опционально):

```bash
cd docs/coursework
cat 00-pereschen-sokrashcheniy.md 01-vvedenie.md 02-glava-1-analiticheskaya.md \
  03-glava-2-proektnaya.md 04-glava-3-realizaciya.md 05-zaklyuchenie-i-istochniki.md \
  > POYASNITELNAYA-ZAPISKA-full.md
```
