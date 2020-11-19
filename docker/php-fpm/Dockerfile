FROM php:7.4-fpm

RUN apt-get update \
    && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure \
        gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        gd \
        pdo_mysql \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
