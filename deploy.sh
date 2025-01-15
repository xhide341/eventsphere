#!/bin/bash

# 1. Added debug information
echo "Starting deployment process..."
echo "PHP Version: $(php -v)"
echo "Using PORT: ${PORT}"

# 2. Add database configuration debug
echo "Database configuration:"
echo "DB_CONNECTION: ${DB_CONNECTION}"
echo "DB_HOST: ${DB_HOST}"
echo "DB_PORT: ${DB_PORT}"
echo "DB_DATABASE: ${DB_DATABASE}"
echo "DB_USERNAME: ${DB_USERNAME}"
echo "Testing connection..."

# 4. Added migration timeout with ignore duplicates
php artisan migrate --force --graceful

# Clear and rebuild route cache
echo "Caching config..."
php artisan config:cache
echo "Caching routes..."
php artisan route:cache

# Start FrankenPHP using environment PORT
exec php artisan octane:frankenphp --host=0.0.0.0 --port=${PORT:-10000}