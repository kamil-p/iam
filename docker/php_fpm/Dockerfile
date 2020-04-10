FROM php:7.4-fpm
ARG TIMEZONE

MAINTAINER Kamil Purzynski <kamil.purzynski@gmail.com>

RUN apt-get update && apt-get install -y \
    openssl \
    git \
    unzip \
    fish

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
&& composer --version

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone \
&& printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini \
&& "date"

# Type docker-php-ext-install to see available extensions
RUN docker-php-ext-install pdo pdo_mysql


# install xdebug
RUN pecl install apcu \
    xdebug \
&& docker-php-ext-enable xdebug \
&& docker-php-ext-enable apcu \
&& docker-php-ext-install opcache

COPY php-ini-overrides.ini /usr/local/etc/php/php.ini

RUN echo 'alias sf="php app/console"' >> ~/.bashrc

WORKDIR /var/www/app