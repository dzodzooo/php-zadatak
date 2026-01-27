FROM php:8.3.30-fpm

COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

RUN docker-php-ext-install mysqli 

RUN apt-get update
