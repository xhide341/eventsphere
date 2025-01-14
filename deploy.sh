#!/bin/bash

# Wait for database
echo "Waiting for database connection..."
until php artisan tinker --execute="DB::connection()->getPdo();" > /dev/null 2>&1; do
    echo "Database connection not ready. Waiting..."
    sleep 2
done

# Clear and rebuild route cache
echo "Caching config..."
php artisan config:cache
echo "Caching routes..."
php artisan route:cache

# Run migrations
echo "Running database migrations..."
php artisan migrate --force

# Start FrankenPHP with explicit port
exec php artisan octane:frankenphp --host=0.0.0.0 --port=10000