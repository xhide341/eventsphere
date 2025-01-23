FROM shinsenter/frankenphp:php8.3

ENV SERVER_NAME=eventsphere-eqyq.onrender.com
ENV APP_PATH=/app
ENV DOCUMENT_ROOT=/public

# Install system dependencies
RUN apt-get update && apt-get install -y \
    supervisor \
    && rm -rf /var/lib/apt/lists/*

WORKDIR ${APP_PATH}

# Copy application files
COPY . ${APP_PATH}
# Copy Caddyfile
COPY Caddyfile /etc/caddy/Caddyfile

# Install composer dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction && \
    php artisan octane:install

# Copy supervisor configuration
COPY supervisor.conf /etc/supervisor/conf.d/supervisor.conf

# Set permissions
RUN chmod 755 /usr/local/bin/frankenphp && \
    chown root:root /usr/local/bin/frankenphp && \
    chmod -R 775 ${APP_PATH} && \
    chown -R root:root ${APP_PATH}

# Healthcheck using port 10000
HEALTHCHECK --interval=30s --timeout=30s --start-period=5s --retries=3 \
    CMD curl -f http://localhost:10000/up || exit 1

CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/conf.d/supervisor.conf"]