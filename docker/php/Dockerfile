FROM php:8.0-apache

RUN apt-get update && \ 
    apt-get install libzip-dev -y && \
    docker-php-ext-install zip \
    && a2enmod rewrite

WORKDIR /var/www

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug