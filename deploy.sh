#!/bin/bash

# 1. Added debug information
echo "Starting deployment process..."
echo "PHP Version: $(php -v)"
echo "Using PORT: ${PORT}"

# 2. Added database timeout
TIMEOUT=300
START_TIME=$(date +%s)
until php artisan tinker --execute="DB::connection()->getPdo();" > /dev/null 2>&1; do
    CURRENT_TIME=$(date +%s)
    ELAPSED_TIME=$((CURRENT_TIME - START_TIME))
    
    # Check timeout
    if [ $ELAPSED_TIME -gt $TIMEOUT ]; then
        echo "Database connection timeout after ${TIMEOUT} seconds"
        exit 1
    fi
    
    echo "Database connection not ready. Waiting... (${ELAPSED_TIME}s elapsed)"
    sleep 5
done

# 3. Added migration timeout
timeout 300 php artisan migrate --force

# Clear and rebuild route cache
echo "Caching config..."
php artisan config:cache
echo "Caching routes..."
php artisan route:cache

# Start FrankenPHP using environment PORT
exec php artisan octane:frankenphp --host=0.0.0.0 --port=${PORT:-10000}