#!/bin/sh
set -e

if [ -z "$APP_KEY" ]; then
    echo "APP_KEY is not set. Generate one locally with 'php artisan key:generate --show'"
    echo "and set it as an environment variable on the host before deploying."
    exit 1
fi

php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force

exec "$@"
