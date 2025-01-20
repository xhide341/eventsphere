FROM dunglas/frankenphp:1.4.1-php8.2.27-bookworm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    supervisor \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Copy composer files first to leverage Docker cache
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copy application files
COPY . .

# Set permissions
RUN mkdir -p /var/log/supervisor \
    && mkdir -p storage/framework/{sessions,views,cache} \
    && chmod -R 777 storage \
    && chmod -R 777 bootstrap/cache \
    && chmod +x /usr/local/bin/frankenphp \
    && chmod +x deploy.sh

# Install Octane
RUN echo "Installing Laravel Octane..." \
    && composer require laravel/octane \
    && php artisan octane:install --server=frankenphp

# Copy supervisor configuration
COPY supervisor.conf /etc/supervisor/conf.d/supervisor.conf

# Expose port
EXPOSE ${PORT}

# Start deployment script
CMD ["./deploy.sh"]