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

# 3. Test database connection
echo "Testing database connection..."
if php artisan db:monitor; then
    echo "Database connection successful!"
else
    echo "Database connection failed!"
    exit 1
fi

# 4. Run migrations
echo "Running migrations..."
php artisan migrate --force --graceful

# Clear and rebuild route cache
echo "Caching config..."
php artisan config:cache
echo "Caching routes..."
php artisan route:cache

# Start FrankenPHP using environment PORT
exec php artisan octane:frankenphp --host=0.0.0.0 --port=${PORT:-10000}