FROM php:8.2-fpm-alpine

RUN apk add --no-cache git curl libzip-dev zip unzip postgresql-dev oniguruma-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip xml

WORKDIR /var/www/html

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

CMD ["php-fpm"]

