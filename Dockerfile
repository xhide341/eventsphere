FROM dunglas/frankenphp:1.4.0-php8.2

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
    php artisan package:discover --ansi && \
    php artisan vendor:publish --all && \
    npm install && npm run build

# Set all permissions before switching user
RUN chmod +x /usr/local/bin/frankenphp && \
    chmod +x ./deploy.sh && \
    chown -R sail:sail .

# Switch to sail user
USER sail

CMD ["./deploy.sh"]