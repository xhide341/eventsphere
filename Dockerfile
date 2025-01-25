FROM shinsenter/php-archives:20250122-8.3-fpm-nginx

COPY . .

# Only essential overrides for Render
ENV NGINX_HTTP_PORT ${PORT}
ENV WEBROOT /var/www/html/public

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

# Configure Nginx
COPY conf/nginx/nginx-site.conf /etc/nginx/conf.d/default.conf

# Copy deploy script
COPY scripts/00-laravel-deploy.sh /usr/local/bin/00-laravel-deploy.sh
RUN chmod +x /usr/local/bin/00-laravel-deploy.sh

# Start both services
CMD ["/start.sh"]