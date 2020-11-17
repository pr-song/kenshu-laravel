FROM php:fpm

RUN apt-get update && apt-get install -y libzip-dev

# Laravel用の拡張
RUN docker-php-ext-install zip
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo_mysql

#Composerをインストールする
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer global require laravel/installer