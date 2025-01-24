#!/bin/bash

# Debug information
echo "Starting deployment process..."
echo "PHP Version: $(php -v)"
echo "Using PORT: ${PORT}"

# Database configuration debug
echo "Database configuration:"
echo "DB_CONNECTION: ${DB_CONNECTION}"
echo "DB_HOST: ${DB_HOST}"
echo "DB_PORT: ${DB_PORT}"
echo "DB_DATABASE: ${DB_DATABASE}"
echo "DB_USERNAME: ${DB_USERNAME}"

# Test database connection
echo "Testing database connection..."
if php artisan db:monitor --verbose; then
    echo "✅ Database connection successful!"
else
    echo "❌ Database connection failed with status $?"
    php artisan db:show --verbose
    exit 1
fi

# Run migrations
echo "Running migrations..."
php artisan migrate --force --graceful

# Clear and rebuild cache
echo "Caching config..."
php artisan config:cache
echo "Caching routes..."
php artisan route:cache

# Set permissions (if needed)
chown -R www-data:www-data /var/www/html/storage
chmod -R 775 /var/www/html/storage