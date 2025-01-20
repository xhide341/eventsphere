FROM shinsenter/frankenphp:latest

# Install system dependencies
RUN apt-get update && apt-get install -y \
    supervisor \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /app

# Copy application files first (we need artisan)
COPY . .

# Install composer dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Install Octane
RUN composer require laravel/octane && \
    php artisan octane:install --server=frankenphp

# Copy supervisor configuration
COPY supervisor.conf /etc/supervisor/conf.d/supervisor.conf

# Set permissions
RUN chown -R www-data:www-data .

# Add healthcheck
HEALTHCHECK --interval=30s --timeout=30s --start-period=5s --retries=3 \
    CMD curl -f http://localhost/up || exit 1

# Switch to non-root user for security
USER www-data

# Use supervisor to manage processes
CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/supervisord.conf"]