FROM php:8.1.4-fpm-alpine3.14

RUN apk update
RUN apk add --no-cache git libzip-dev zip unzip php8-exif

RUN docker-php-ext-install pdo pdo_mysql zip exif \
    && curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

COPY . .

RUN chown -R www-data:www-data /var/www/html

RUN composer install