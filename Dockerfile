FROM dunglas/frankenphp:1.4.0

ENV PORT=10000
EXPOSE ${PORT}

# Add health check
RUN apt-get update && apt-get install -y curl
HEALTHCHECK --interval=30s --timeout=5s --start-period=30s --retries=3 \
    CMD curl -f http://localhost:${PORT}/health || exit 1

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

# Copy and setup deploy script
COPY deploy.sh ./deploy.sh
RUN chmod +x ./deploy.sh

# Set permissions
RUN chmod +x /usr/local/bin/frankenphp && \
    chown -R www-data:www-data .

USER www-data

# Install Octane
RUN echo "Installing Laravel Octane..." \
    && composer require laravel/octane \
    && php artisan octane:install --server=frankenphp

# Copy supervisor configuration
COPY supervisor.conf /etc/supervisor/conf.d/supervisor.conf

CMD ["./deploy.sh"]