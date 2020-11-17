FROM php:fpm

RUN apt-get update && apt-get install -y libzip-dev

RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo_mysql