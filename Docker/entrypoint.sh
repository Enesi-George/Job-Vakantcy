#!/bin/bash

# Exit on fail
set -e

# Ensure composer dependencies are installed
if [ ! -f 'vendor/autoload.php' ]; then
    composer install --no-progress --no-interaction
fi

# If .env is not specified, copy the .env.example
if [ ! -f ".env" ]; then
    echo "Creating env file for env $APP_ENV"
    cp .env.example .env
else
    echo "env file exists."
fi

# Laravel setup commands
php artisan migrate --force
php artisan key:generate --force
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan optimize:clear

# Start the queue worker in the background
php artisan queue:work &

# Run Laravel scheduler in background
while true; do
    php artisan schedule:run --no-interaction --quiet
    sleep 60
done &

# Start Laravel server
php artisan serve --port=$PORT --host=0.0.0.0 --env=.env

# Run the default entrypoint command
exec docker-php-entrypoint "$@"
