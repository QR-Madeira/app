#!/bin/sh

if [ "$1" = "--init" ]; then
    composer i && npm i
    rm -rf public/storage
    rm -rf storage/app/public/*
    php artisan storage:link
    #echo "CREATE DATABASE `qr-madeira`" > mysql -u root -p 
    php artisan migrate:fresh --seed
fi

stop_commands() {
  kill %1 %2
}

folder=$(git rev-parse --show-toplevel)

exec php "$folder"/artisan serve --host=0.0.0.0 & exec npm run dev &
trap stop_commands INT
wait
