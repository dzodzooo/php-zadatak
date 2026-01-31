FROM php:8.4-fpm

COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

COPY config/php.ini /usr/local/etc/php/

RUN docker-php-ext-install mysqli 

RUN apt-get update && apt install -y \
    msmtp msmtp-mta mailutils

COPY config/.msmtprc /usr/local/etc/.msmtprc