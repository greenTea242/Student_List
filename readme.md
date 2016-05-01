## Список студентов
### База данных: mySQL 5.7

1. Отредактируйте необходимые параметры для подключения к БД (логин, пароль) в файле config.php.
2. Установите в php.ini display_errors = 0 для использования на "продакшен".
3. Добавьте в конфигигурационный файл Apache следующий код:
<VirtualHost *:80>
ServerName localhost (*имя сервера которое обслуживает этот VirtualHost*)
DocumentRoot C:\Documents\studentlist\public (*укажите свою корневую папка сервера*)
</VirtualHost>