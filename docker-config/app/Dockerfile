FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    libzip-dev\
    zip \
    jpegoptim optipng pngquant gifsicle \
    libpq-dev \
    unzip \
    vim\
    curl \
    net-tools \
    libonig-dev \
    libc-client-dev \
    libkrb5-dev \
    libedit-dev \
    libxml2-dev \
    supervisor

RUN docker-php-ext-install mbstring tokenizer  pdo pdo_pgsql soap


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

COPY --chown=www:www . /var/www/html/

RUN chmod -R 755 /var/www/

USER www

WORKDIR  /var/www/html/
 

RUN php artisan storage:link

VOLUME ["/var/www/html"]