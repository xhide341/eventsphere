FROM shinsenter/php-archives:20250122-8.3-fpm-nginx

# Only essential overrides for Render
ENV NGINX_HTTP_PORT ${PORT}
ENV WEBROOT /var/www/html/public

# Laravel production mode
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# Fix permissions and directory structure
RUN mkdir -p /var/www/html/public \
    && mkdir -p /var/www/html/storage \
    && mkdir -p /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Set permissions for the public directory
RUN chown -R www-data:www-data /var/www/html/public \
    && chmod -R 755 /var/www/html/public

COPY . /var/www/html/public

# Configure Nginx
COPY conf/nginx/nginx-site.conf /etc/nginx/conf.d/default.conf

# Copy deploy script
COPY scripts/00-laravel-deploy.sh /usr/local/bin/00-laravel-deploy.sh
RUN chmod +x /usr/local/bin/00-laravel-deploy.sh

# Copy the start script into the container
COPY scripts/start.sh /scripts/start.sh

# Make sure the script is executable
RUN chmod +x /scripts/start.sh

# Start both services
CMD ["/bin/bash", "/scripts/start.sh"]