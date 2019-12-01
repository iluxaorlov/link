# Настройка проекта Linky
1. Скопировать проект на локальный компьютер командой ```$ git clone https://github.com/iluxaorlov/project-linky.git```
2. Перейти в папку проекта
3. Выполнить команду ```$ composer install && npm install && npm run build```
7. Настроить подключение к базе данных в файле ***phinx.yml***
8. Создать базу данных с именем, указанным в конфигурационном файле
9. Выполнить команду ```$ vendor/bin/phinx migrate```