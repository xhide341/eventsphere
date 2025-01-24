FROM shinsenter/php-archives:20250122-8.3-fpm-nginx

COPY . .

ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# PHP configurations
ENV PHP_DISPLAY_ERRORS 0
ENV PHP_POST_MAX_SIZE 100M
ENV PHP_UPLOAD_MAX_FILESIZE 100M
ENV PHP_MEMORY_LIMIT 256M
ENV PHP_MAX_EXECUTION_TIME 60
ENV PHP_SESSION_COOKIE_SECURE 1
ENV PHP_SESSION_COOKIE_HTTPONLY 1

# Nginx configurations
ENV NGINX_HTTP_PORT 10000
ENV WEBROOT /var/www/html/public
ENV NGINX_ACCESS_LOG /dev/stdout
ENV NGINX_ERROR_LOG /dev/stderr

# Allow runtime PHP environment variables
ENV ALLOW_RUNTIME_PHP_ENVVARS 1

# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

CMD ["/docker-entrypoint.sh", "nginx", "php-fpm"]