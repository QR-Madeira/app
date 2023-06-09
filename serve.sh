#!/bin/sh

if [ "$1" = "--init" ]; then
  git pull
  composer i && npm i
  rm -rf public/storage
  rm -rf storage/app/public/*
  php artisan storage:link
  php artisan migrate:fresh --seed
fi

if [ "$1" = "--db" ]; then
  git pull
  php artisan migrate:fresh --seed
fi

stop_commands() {
  kill %1 %2
}

folder=$(git rev-parse --show-toplevel)

cd "$folder" || exit
#npm run dev
exec php "$folder"/artisan serve --host=0.0.0.0 & exec npm run dev &
trap stop_commands INT
wait
