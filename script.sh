#!/bin/bash

if [ -f '.env' ] 
then
    echo "Файл .env уже существует"
else
    echo "Файл .env не найден, будет создан новый"
    cp .env.example .env
fi

echo "Обновление пакетов"
composer update

echo "Создание нового ключа"
php artisan key:generate

echo "Выполнение миграций"
php artisan migrate:refresh --seed

echo "Создание клиентов для laravel passport"
php artisan passport:install

exit 0