FROM shinsenter/php-archives:20250122-8.3-fpm-nginx

COPY . .

# Only essential overrides for Render
ENV NGINX_HTTP_PORT ${PORT}  # Required for Render
ENV WEBROOT /var/www/html/public  # Required for Laravel

# Laravel production mode
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# Fix permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

CMD ["/usr/local/bin/docker-entrypoint.sh"]