FROM shinsenter/frankenphp:latest

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    supervisor \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Copy composer files first to leverage layer caching
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copy application files
COPY . .

# Copy and setup deploy script
COPY deploy.sh ./deploy.sh
RUN chmod +x ./deploy.sh

# Copy supervisor configuration (before switching user)
COPY supervisor.conf /etc/supervisor/conf.d/supervisor.conf

# Set permissions
RUN chmod +x /usr/local/bin/frankenphp && \
    chown -R www-data:www-data .

# Install Octane
RUN composer require laravel/octane && \
    php artisan octane:install --server=frankenphp

# Add healthcheck
HEALTHCHECK --interval=30s --timeout=30s --start-period=5s --retries=3 \
    CMD curl -f http://localhost/up || exit 1

# Switch to non-root user for security
USER www-data

# Use supervisor to manage processes
CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/supervisord.conf"]