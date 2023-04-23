#!/bin/sh

composer i && npm i
rm -rf public/storage
php artisan storage:link
php artisan migrate

stop_commands() {
  kill %1 %2
}

exec php artisan serve & exec npm run dev &
trap stop_commands INT
wait
