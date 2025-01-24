FROM shinsenter/php-archives:20250122-8.3-fpm-nginx

COPY . .

# Only essential overrides for Render
ENV NGINX_HTTP_PORT ${PORT}  # Required for Render
ENV WEBROOT /var/www/html/public  # Required for Laravel

# Laravel production mode
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# Fix permissions and directory structure
RUN mkdir -p /var/www/html/public \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Configure PHP-FPM to use TCP instead of socket
RUN sed -i 's|listen = /run/php-fpm.sock|listen = 127.0.0.1:9000|' /usr/local/etc/php-fpm.d/www.conf

# Configure Nginx
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Start both services
CMD ["sh", "-c", "rm -f /run/php-fpm.sock && php-fpm -D && nginx -g 'daemon off;'"]