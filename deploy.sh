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

# 3. Database connection check with debug
TIMEOUT=300
START_TIME=$(date +%s)
until php artisan tinker --execute="try { DB::connection()->getPdo(); echo 'Connection successful!'; } catch (\Exception \$e) { echo 'Connection failed: ' . \$e->getMessage(); }" 2>&1; do
    CURRENT_TIME=$(date +%s)
    ELAPSED_TIME=$((CURRENT_TIME - START_TIME))
    
    if [ $ELAPSED_TIME -gt $TIMEOUT ]; then
        echo "Database connection timeout after ${TIMEOUT} seconds"
        exit 1
    fi
    
    echo "Database connection not ready. Waiting... (${ELAPSED_TIME}s elapsed)"
    sleep 5
done

# 4. Added migration timeout with ignore duplicates
timeout 300 php artisan migrate --force --ignore-duplicate-migrations

# Clear and rebuild route cache
echo "Caching config..."
php artisan config:cache
echo "Caching routes..."
php artisan route:cache

# Start FrankenPHP using environment PORT
exec php artisan octane:frankenphp --host=0.0.0.0 --port=${PORT:-10000}