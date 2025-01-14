FROM dunglas/frankenphp

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
RUN install-php-extensions \
    pcntl \
    pdo_mysql \
    pdo_pgsql \
    redis \
    intl \
    gd \
    bcmath \
    zip

# Set working directory
WORKDIR /var/www/html

# Generate self-signed certificate for FrankenPHP
RUN mkdir -p /etc/frankenphp/ssl && \
    openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
    -keyout /etc/frankenphp/ssl/private.key \
    -out /etc/frankenphp/ssl/cert.pem \
    -subj "/C=US/ST=State/L=City/O=Organization/CN=localhost"

# Copy composer files first
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copy application files
COPY . .

# Install Node.js dependencies and build assets
RUN npm install && npm run build

# Set proper permissions
RUN chown -R www-data:www-data . && \
    chown -R www-data:www-data /data && \
    chown -R www-data:www-data /config && \
    chmod -R 777 /data && \
    chmod -R 777 /config && \
    chown -R www-data:www-data /etc/frankenphp/ssl && \
    chmod 644 /etc/frankenphp/ssl/cert.pem && \
    chmod 600 /etc/frankenphp/ssl/private.key

# Run as root for Render (they handle user permissions)
USER root

# Start FrankenPHP
ENTRYPOINT ["php", "artisan", "octane:frankenphp", "--host=0.0.0.0", "--port=80", "--admin-port=2019", "--https", "--http-redirect", "--watch"]