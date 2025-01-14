#!/bin/bash

# Wait for database
echo "Waiting for database connection..."
until php artisan db:monitor --check=connection; do
    echo "Database connection not ready. Waiting..."
    sleep 2
done

# Run migrations
echo "Running database migrations..."
php artisan migrate --force

# Start FrankenPHP
exec php artisan octane:frankenphp --host=0.0.0.0 --port=80 