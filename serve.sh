#!/bin/sh

if [ "$1" != "--only-serve" ]; then
    composer i && npm i
    rm -rf public/storage
    php artisan storage:link
    php artisan migrate
fi

stop_commands() {
  kill %1 %2
}

folder=$(git rev-parse --show-toplevel)

exec php "$folder"/artisan serve --host=0.0.0.0 & exec npm run dev &
trap stop_commands INT
wait
