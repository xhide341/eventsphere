FROM shinsenter/frankenphp:latest

ENV SERVER_NAME=https://eventsphere-eqyq.onrender.com
ENV APP_PATH=/app
ENV DOCUMENT_ROOT=/public

# Install system dependencies
RUN apt-get update && apt-get install -y \
    supervisor \
    && rm -rf /var/lib/apt/lists/*

# Enable PHP production settings
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"


WORKDIR ${APP_PATH}

# Copy application files
COPY . ${APP_PATH}

# Install composer dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction && \
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