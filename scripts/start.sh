#!/bin/bash

# Check if PHP-FPM is already running
if ! pgrep -x "php-fpm" > /dev/null
then
    echo "Starting PHP-FPM..."
    php-fpm &
else
    echo "PHP-FPM is already running."
fi

# Start Nginx
echo "Starting Nginx..."
nginx -g "daemon off;"