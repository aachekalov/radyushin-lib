# Инструкция
1. php init --env=Production --overwrite=All
2. В файле common/config/main-local.php указать корректные данные для подключения к БД
3. Применить миграции БД php yii migrate
4. Установить в качестве корневой папки web-сервера папку web
5. Открыть приложение в браузере