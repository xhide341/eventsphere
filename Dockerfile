FROM dunglas/frankenphp:1.4.1-php8.2.27-bookworm

# Just expose the port, let environment set it
EXPOSE 10000

# Add health check with longer start period
RUN apt-get update && apt-get install -y curl
HEALTHCHECK --interval=30s --timeout=10s --start-period=60s --retries=5 \
    CMD curl -f http://localhost:${PORT}/health || exit 1

# Create sail user
ARG WWWGROUP=1000
ARG WWWUSER=1000
RUN groupadd --force -g ${WWWGROUP} sail && \
    useradd -ms /bin/bash --no-user-group -g ${WWWGROUP} -u ${WWWUSER} sail

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    nodejs \
    npm \
    supervisor \
    && update-ca-certificates

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install required PHP extensions
RUN MAKE="make -j$(nproc) -s" \
    install-php-extensions \
    pcntl \
    pgsql \
    pdo_pgsql \
    redis \
    intl \
    gd \
    bcmath \
    zip

WORKDIR /var/www/html

# Copy entire application and deploy script
COPY . .
COPY deploy.sh ./deploy.sh

# Install dependencies and build
RUN composer install --no-dev --optimize-autoloader --no-interaction \
    --no-plugins --no-scripts && \
    php artisan octane:install --server=frankenphp && \
    php artisan package:discover --ansi && \
    php artisan vendor:publish --tag=filament-config && \
    php artisan vendor:publish --tag=filament-translations && \
    php artisan vendor:publish --tag=filament-assets && \
    npm install && npm run build

# Set broad permissions for sail user
RUN mkdir -p /config && \
    chmod -R 777 /config && \
    chmod -R 777 /var/www/html && \
    chmod -R 777 /tmp && \
    chmod +x /usr/local/bin/frankenphp && \
    chmod +x ./deploy.sh && \
    chmod -R 777 /var/log/supervisor && \
    chmod -R 777 /var/run && \
    chown -R sail:sail /config && \
    chown -R sail:sail /var/www/html && \
    chown -R sail:sail /var/log/supervisor && \
    chown -R sail:sail .

# Add supervisor config
COPY supervisor.conf /etc/supervisor/conf.d/supervisor.conf

# Make sure supervisor and storage directories exist and are writable
RUN mkdir -p /var/log/supervisor && \
    mkdir -p storage/framework/{sessions,views,cache} && \
    chmod -R 777 storage && \
    chmod -R 777 bootstrap/cache

# Switch to sail user
USER sail

CMD ["./deploy.sh"]