FROM dunglas/frankenphp:1.4.0

ENV PORT=10000
EXPOSE ${PORT}

# Add health check
RUN apt-get update && apt-get install -y curl
HEALTHCHECK --interval=30s --timeout=5s --start-period=30s --retries=3 \
    CMD curl -f http://localhost:${PORT}/health || exit 1

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

# Install required PHP extensions quietly
RUN MAKE="make -j$(nproc) -s" \
    install-php-extensions \
    pcntl \
    pdo_mysql \
    pdo_pgsql \
    redis \
    intl \
    gd \
    bcmath \
    zip

WORKDIR /var/www/html

# Copy entire application first
COPY . .

# Install dependencies with specific settings
RUN composer install --no-dev --optimize-autoloader --no-interaction \
    --no-plugins --no-scripts

# Run post-install scripts manually
RUN php artisan package:discover --ansi \
    && php artisan vendor:publish --all

# Install Node.js dependencies and build assets
RUN npm install && npm run build

# Set permissions for FrankenPHP and application
RUN chmod +x /usr/local/bin/frankenphp && \
    chown -R www-data:www-data .

# Use www-data user
USER www-data

# Copy and set up deploy script
COPY deploy.sh ./deploy.sh
RUN chmod +x ./deploy.sh

CMD ["./deploy.sh"]